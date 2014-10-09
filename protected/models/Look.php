<?php
/*
 * tipoDescuento:
 * 
 * 0 = porcentaje
 * 1 = Valor en euros 
 * 
 */
  
/**
 * This is the model class for table "{{look}}".
 *
 * The followings are the available columns in table '{{look}}':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $altura
 * @property integer $contextura
 * @property integer $pelo
 * @property integer $ojos
 * @property integer $tipo_cuerpo
 * @property integer $piel
 * @property string $created_on
 * @property integer $tipo
 * @property integer $user_id
 * @property integer $campana_id
 * @property integer $status
 * @property integer $view_counter 
 * @property integer $url_amigable
 * @property string $sent_on
 * @property string $approved_on
 * @property string $tipoDescuento -> 0: porcentaje | 1: monto
 * @property string $valorDescuento
 * @property integer $available
 *
 * The followings are the available model relations:
 * @property LookHasTblBolsa[] $lookHasTblBolsas
 * @property Producto[] $tblProductos
 * @property Campana $campana
 */
class Look extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Look the static model class
	 */
	 const TIPO_CONSERVADOR = 2;
	 const TIPO_ATREVIDO = 1;
	 
	 /** STATUS DEL LOOK **/
	 const STATUS_CREADO = 0;
	 const STATUS_ENVIADO = 1; 
	 const STATUS_APROBADO = 2; 
	 
	 private $_precio = null; 
	 private $_precionf = null;
	 private $_precioDescuento = null;
	 private $_precioProductosFull = null;
	 private $_precioProductosDescuento = null;
	 private $_porcentajeDescuento = null;
	 
	 private $_items;
	 private $_ocasiones = array(36=>'fiesta',37=>'trabajo',38=>'playa',39=>'sport',40=>'coctel');
	 public $has_ocasiones;
         private $_totalVentas = null;
         
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{look}}';
	}
	 public function defaultScope() {
	        return array(
	            'condition' => 'deleted = 0', 
	        ); 
	    }
    public function scopes()
    {
        return array(
            'aprobados'=>array(
                'condition'=>'status=2',
            ),
            'poraprobar'=>array(
                'condition'=>'status=1',
                
            ),
            'availables'=>array(
                'condition'=>'available=1',
                
            ),
            'unavailables'=>array(
                'condition'=>'available=0',
                
            ),
           
        );
    }	 
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array(' altura, contextura, pelo, ojos, tipo_cuerpo, piel, tipo', 'numerical','min'=>1),
			array('created_on','default',
              'value'=>new CDbExpression('NOW()'),
              'setOnEmpty'=>false,'on'=>'insert'), 
			array('title, altura, contextura, pelo, ojos, tipo_cuerpo, piel, tipo, campana_id,created_on', 'required'),
			array('altura, contextura, pelo, ojos, tipo_cuerpo, piel, tipo,destacado,status, campana_id,view_counter,deleted', 'numerical', 'integerOnly'=>true),
			array('altura, contextura, pelo, ojos, tipo_cuerpo, piel', 'numerical','min'=>1,'tooSmall' => 'Debe seleccionar por lo menos un(a) {attribute}','on'=>'update'),
			array('has_ocasiones','required','on'=>'update','message'=> 'Al menos debes elegir una ocasión'),
			array('view_counter','numerical', 'integerOnly'=>true,'on'=>'increaseview'),
			array('available','numerical', 'integerOnly'=>true),
			array('view_counter','required','on'=>'increaseview'),
			array('tipoDescuento','numerical', 'integerOnly'=>true,'on'=>'descuento'),
			array('valorDescuento','numerical', 'integerOnly'=>false,'on'=>'descuento'),
			array('tipoDescuento, valorDescuento','required','on'=>'descuento'),
			array('title', 'length', 'max'=>45),
			array('deleted,deleted_on', 'required', 'on'=>'softdelete'),
			array('description, created_on, sent_on, approved_on, modified_on, activo', 'safe'),
			array('url_amigable', 'unique', 'message'=>'Url Amigable ya registrada para otro look.'),
			//array('url_amigable', 'match', 'pattern'=>'/^\w{1}([a-zA-Z_|\-]*[a-zA-Z]+[a-zA-Z_|\-]*)$/', 'message'=>'Url Amigable presenta caracteres no válidos'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched. 
			array('id, title, description, altura, contextura, pelo, ojos, 
                            tipo_cuerpo, piel, created_on, tipo,destacado, status, user_id, 
                            campana_id, view_counter, url_amigable, sent_on, approved_on, modified_on, tipoDescuento, valorDescuento, activo', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() 
	{
		// NOTE: you may need to adjust the relation name and the related 
		// class name for the relations automatically generated below.
		return array(
			'lookHasTblBolsas' => array(self::HAS_MANY, 'LookHasTblBolsa', 'tbl_look_id'),
			'productos' => array(self::MANY_MANY, 'Producto', '{{look_has_producto}}(look_id, producto_id)'),
			
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'campana' => array(self::BELONGS_TO, 'Campana', 'campana_id'),
			'categoriahaslook' => array(self::HAS_MANY, 'CategoriaHasLook', 'look_id'),
			'categorias' => array(self::MANY_MANY, 'Categoria', '{{categoria_has_look}}(look_id, categoria_id)'),
			//'categorias' => array(self::MANY_MANY, 'Categoria', array('categoria_id'=>'id'),'through'=>'categoriahaslook'),
			'lookhasproducto' => array(self::HAS_MANY, 'LookHasProducto','look_id'),
			'lookHasAdorno' => array(self::HAS_MANY, 'LookHasAdorno','look_id'), 
			'productos_todos' => array(self::HAS_MANY,'Producto',array('producto_id'=>'id'),'through'=>'lookhasproducto'),
			'precioNf'=>array(self::STAT,'LookHasProducto','look_id','select'=>'SUM(LookHasProducto.precioNf)'),
			
		);
	}  
	
 
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Titulo',
			'description' => 'Description',
			'altura' => 'Altura',
			'contextura' => 'Condición Física',
			'pelo' => 'Color de Cabello',
			'ojos' => 'Color de Ojos',
			'tipo_cuerpo' => 'Tipo Cuerpo',
			'piel' => 'Color de Piel',
			'destacado' => 'Destacado',
			'created_on' => 'Created On',
			'tipo' => 'Tipo',
			'campana_id' => 'Campaña',
			'has_ocasiones' => 'Ocasiones',
			'user_id'=>'Usuario',
			'available'=>'Disponible',
			'url_amigable' => 'Url Amigable',
                        'sent_on' => 'Fecha de envío',
                        'approved_on' => 'Fecha de aprobación',
                        'tipoDescuento' => 'Tipo de Descuento',
                        'valorDescuento' => 'Valor',
		);
	}
	public function matchOcaciones($user) 
	{ 
		//echo "rafa"; 
		//echo $this->title;	
		 
		//print_r($this->categoriahaslook);
		//print_r($this->categorias);
		
		if ($user!==null){
		foreach ($this->categorias as $categoria){
			$algo = $this->_ocasiones[$categoria->padreId];
			//echo '/'.$user->profile->$algo; 
			if ($user->profile->$algo == $this->tipo)
				return true;
		}
		return false;
		}
		return true;
	}
	public function match($user) 
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
/*
		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('altura',$this->altura);
		$criteria->compare('contextura',$this->contextura);
		$criteria->compare('pelo',$this->pelo);
		$criteria->compare('ojos',$this->ojos);
		$criteria->compare('tipo_cuerpo',$this->tipo_cuerpo);
		$criteria->compare('piel',$this->piel);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('tipo',$this->tipo);
*/
		/*
		$criteria->addCondition('altura & ' . $user->profile->altura . ' != 0');
		$criteria->addCondition('contextura & ' . $user->profile->contextura . ' != 0');
		$criteria->addCondition('pelo & ' . $user->profile->pelo . ' != 0');
		$criteria->addCondition('ojos & ' . $user->profile->ojos . ' != 0');
		$criteria->addCondition('tipo_cuerpo & ' . $user->profile->tipo_cuerpo . ' != 0');
		$criteria->addCondition('piel & ' . $user->profile->piel . ' != 0');
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));*/
		
		if ($user!==null){                      
                    
		$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM tbl_look WHERE deleted=0 and (if('.$user->profile->pelo.' & pelo !=0,1,0)+if('.$user->profile->altura.' & altura !=0,1,0))>=2')->queryScalar();
		
		$sql='SELECT id FROM tbl_look WHERE deleted = 0 AND  (
			if('.$user->profile->altura.' & altura !=0,1,0)+
			if('.$user->profile->contextura.' & contextura !=0,1,0)+
			if('.$user->profile->pelo.' & pelo !=0,1,0)+
			if('.$user->profile->ojos.' & ojos !=0,1,0)+
			if('.$user->profile->piel.' & piel !=0,1,0)+
			if('.$user->profile->tipo_cuerpo.' & tipo_cuerpo !=0,1,0)
		) = 6 
                AND ('.$user->getEdad().' BETWEEN edadMin AND edadMax)
                    
		UNION ALL '.
		'SELECT id FROM tbl_look WHERE deleted = 0 AND (
			if('.$user->profile->altura.' & altura !=0,1,0)+
			if('.$user->profile->contextura.' & contextura !=0,1,0)+
			if('.$user->profile->pelo.' & pelo !=0,1,0)+
			if('.$user->profile->ojos.' & ojos !=0,1,0)+
			if('.$user->profile->piel.' & piel !=0,1,0)+
			if('.$user->profile->tipo_cuerpo.' & tipo_cuerpo !=0,1,0)
		) = 5 
                AND ('.$user->getEdad().' BETWEEN edadMin AND edadMax)
		';
                
		} else {
			$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM tbl_look where deleted=0')->queryScalar();
			$sql = 'SELECT id FROM tbl_look WHERE deleted=0';
		}
		
		//$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM tbl_look WHERE (if(pelo & 2 !=0,1,0)+if(altura & 2 !=0,1,0))>=2')->queryScalar();
		//$sql='SELECT id FROM tbl_look WHERE (if(pelo & 2 !=0,1,0)+if(altura & 2 !=0,1,0)) >= 2';
		//$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM tbl_look WHERE (if(tipo ='.$user->profile->coctel.',1,0) or if(tipo = '.$user->profile->fiesta.',1,0))')->queryScalar();
		//$sql='SELECT id FROM tbl_look WHERE (if(tipo ='.$user->profile->coctel.',1,0)+if(tipo = '.$user->profile->fiesta.',1,0)) = 2';
		//$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM tbl_look WHERE (if(tipo ='.$user->profile->coctel.',1,0) or if(tipo = '.$user->profile->fiesta.',1,0))')->queryScalar();
		//$sql='SELECT id FROM tbl_look WHERE (tipo ='.$user->profile->coctel.') or (tipo = '.$user->profile->fiesta.') ';
		//$count = 10;
		return new CSqlDataProvider($sql, array(
		    'totalItemCount'=>$count,
		//'sort'=>array(
		//    'attributes'=>array(
		//         'id', 'username', 'email',
		//    ),
		//),
		//'pagination'=>array(
		//    'pageSize'=>10, 
		//    ),
		));
	}
	/**
	 * Mas vendidos
	 */
	 public function masvendidos($limit = 3)
	 {		
		$sql ="SELECT count(distinct tbl_orden_id) as looks,look_id FROM tbl_orden_has_productotallacolor a, tbl_look b where b.status = 2 and a.look_id != 0 and b.deleted = 0 and b.id = a.look_id group by a.look_id order by count(distinct tbl_orden_id) DESC";
                $count = count(Yii::app()->db->createCommand($sql)->query());
                
                $limit = $count && $count > $limit?$limit:$count;  
                
                //$count = 0;
		return new CSqlDataProvider($sql, array(
		    'totalItemCount'=>$count,
		   	'pagination'=>array(
				'pageSize'=>$limit,
			),	
		    

		));  
	 }
	 /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
 
		$criteria=new CDbCriteria;  

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('altura',$this->altura);
		$criteria->compare('contextura',$this->contextura);
		$criteria->compare('pelo',$this->pelo);
		$criteria->compare('ojos',$this->ojos);
		$criteria->compare('tipo_cuerpo',$this->tipo_cuerpo);
		$criteria->compare('piel',$this->piel);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('campana_id',$this->campana_id,true);
		$criteria->compare('url_amigable',$this->url_amigable,true);
                $criteria->compare('sent_on',$this->sent_on);
                $criteria->compare('approved_on',$this->approved_on);
                $criteria->compare('modified_on',$this->modified_on);
                $criteria->compare('tipoDescuento',$this->tipoDescuento);
                $criteria->compare('valorDescuento',$this->valorDescuento);
                $criteria->compare('available',$this->available);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function busqueda()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
 
		$criteria=new CDbCriteria;  

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('status',$this->status,true);
		
		$criteria->order = "created_on DESC";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function ProductosLook($personal)
	{
		// llega un ID de color

		$criteria=new CDbCriteria;

        $criteria->select = '*';
    //    $criteria->join ='JOIN tbl_look_has_producto b ON tbl_look_has_producto.look_id = t.id';
	//	$criteria->join ='JOIN tbl_producto ON tbl_producto.id = tbl_look_has_producto.producto_id';
	
//	$criteria->with = array('lookhasproducto');
	$criteria->with = array('productos_todos');
		
        //$criteria->addCondition('t.estado = 0');
	//	$criteria->addCondition('c.id = b.producto_id AND a.id = b.look_id');
     //   $criteria->condition = 't.estado = :uno';
	//	$criteria->condition = 't.status = :dos';
		$criteria->addCondition('t.user_id = :tres');
	//	$criteria->condition = 'tbl_precioTallaColor.color_id = :tres';
	//	$criteria->addCondition('tbl_precioTallaColor.cantidad > 0'); // que haya algo en inventario		
    //    $criteria->params = array(":uno" => "2"); // estado
	//	$criteria->params = array(":dos" => "1"); // status
		$criteria->params = array(":tres" => $personal); // color que llega
		$criteria->group = 'producto_id';
		$criteria->order = "t.created_on DESC";
		
		$criteria->together = true;
		
		return new CActiveDataProvider($this, array(
       'pagination'=>array('pageSize'=>12,),
       'criteria'=>$criteria,
	));
		
	}
        
        /**
	 * Retorna una lista de looks haciendo join con looksEncantan en base a un usuario $userId.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function busquedaEncantan($userId)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;  

		$criteria->join = "JOIN tbl_lookEncantan le on le.user_id = :userID and le.look_id = id";
                $criteria->params = array(":userID" => $userId);
		
		$criteria->order = "created_on DESC";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
				'pageSize'=>4,
			),
		));
	}
	/* devuelve verdadedo o falso si el look me encanta o no */
	public function meEncanta($userId = 0){
		if ($userId == 0)
			$userId = Yii::app()->user->id;
		return (null !== LookEncantan::model()->findByAttributes(array("user_id"=>$userId,"look_id"=>$this->id)));
	}
	
	/* looks destacados */
	public function lookDestacados($limit = 6) 
	{
		
		$criteria=new CDbCriteria;  		
		
		$criteria->compare('destacado',1);
		$criteria->compare('status',2);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>$limit,
			),	
		));		
	}
	/* look para el admin por aprobar o aprobados */
	public function lookAdminAprobar()
	{
		
		$criteria=new CDbCriteria;  

		
		$criteria->compare('status',1,false,'OR');
		$criteria->compare('status',2,false,'OR');
		$criteria->compare('title',$this->title,true);
		$criteria->order = 'id DESC';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));		
	}
	public function getCategorias()  
	{
		$array = array();	
		foreach($this->categoriahaslook as $categoria)
			$array[] = $categoria->categoria_id;
		return $array;
			
	}
	/*
	public function getPrecioNf()
	{
		if (is_null($this->_precionf)) {
				$this->_precionf = 0;
			foreach($this->lookhasproducto as $lookhasproducto){
				//if ($lookhasproducto->producto->getCantidad(null,$lookhasproducto->color_id) > 0)
				$this->_precionf += $lookhasproducto->producto->getPrecio(false);
			}
		}
		return $this->_precionf;
	}*/
	// calcula el precio del look sin iva
	public function getPrecio($format=true)
	{
		if (is_null($this->_precio)) {
				$this->_precio = 0;
		foreach($this->lookhasproducto as $lookhasproducto){
			//if ($lookhasproducto->producto->getCantidad(null,$lookhasproducto->color_id) > 0)
			$this->_precio += $lookhasproducto->producto->getPrecioDescuento(false);
		}
		}
		if ($format)
			return Yii::app()->numberFormatter->format("#,##0.00",$this->_precio);
		else
			return $this->_precio;
	}

	// calcula el precio del look con el descuento adicional si se compra completp
	public function getPrecioDescuento($format=true){
		if (is_null($this->_precioDescuento)) {
			$this->_precioDescuento = 0;
			if($this->tipoDescuento == 0){ // porcentaje
				$this->_precioDescuento = $this->getPrecioProductosDescuento(false) - ($this->getPrecioProductosDescuento(false) * $this->valorDescuento / 100);
			}else if($this->tipoDescuento == 1){ // monto
				$this->_precioDescuento = $this->valorDescuento;
			}

		}
		if ($format)
			return Yii::app()->numberFormatter->format("#,##0.00",$this->_precioDescuento);
		else
			return $this->_precioDescuento;
	}

	// calcula el precio total del look, restando el descuento y sumando el iva
    public function getPrecioTotal($format=true)
	{
		if ($format)
			return Yii::app()->numberFormatter->format("#,##0.00",($this->getPrecio(false)*0.21)+$this->getPrecio(false));
		else
			return ($this->getPrecio(false)*0.21)+$this->getPrecio(false);
	}

	// sumatoria del precio full de cada producto (con iva)
	public function getPrecioProductosFull($format=true){
		if (is_null($this->_precioProductosFull)) {
			$this->_precioProductosFull = 0;
			foreach($this->lookhasproducto as $lookhasproducto){
				//if ($lookhasproducto->producto->getCantidad(null,$lookhasproducto->color_id) > 0)
				$this->_precioProductosFull += $lookhasproducto->producto->getPrecioImpuesto(false);
			}

		}
		if ($format)
			return Yii::app()->numberFormatter->format("#,##0.00",$this->_precioProductosFull);
		else
			return $this->_precioProductosFull;
	}

	// sumatoria del precio con descuento de cada producto, precio total del look si se compran los productos separados
	public function getPrecioProductosDescuento($format=true){
		if (is_null($this->_precioProductosDescuento)) {
			$this->_precioProductosDescuento = 0;
			foreach($this->lookhasproducto as $lookhasproducto){
				//if ($lookhasproducto->producto->getCantidad(null,$lookhasproducto->color_id) > 0)
				$this->_precioProductosDescuento += $lookhasproducto->producto->getPrecioDescuento(false);
			}

		}
		if ($format)
			return Yii::app()->numberFormatter->format("#,##0.00",$this->_precioProductosDescuento);
		else
			return $this->_precioProductosDescuento;
	}

	// porcentaje de descuento del look
	public function getPorcentajeDescuento($format=true){
		if (is_null($this->_porcentajeDescuento)) {
			$this->_porcentajeDescuento = 0;
			
			if($this->tipoDescuento == 0){ // porcentaje
				$this->_porcentajeDescuento = $this->valorDescuento;
			}else if($this->tipoDescuento == 1){ // monto
				//$this->_porcentajeDescuento = ($this->valorDescuento * 100) / $this->getPrecio(false);
				$this->_porcentajeDescuento = 100 - (($this->getPrecioDescuento(false) * 100) / $this->getPrecioProductosDescuento(false));
			}

		}
		if ($format)
			return Yii::app()->numberFormatter->format("#",$this->_porcentajeDescuento);
		else
			return $this->_porcentajeDescuento;
	}

	public function getMarcas(){
		$marcas = array();
		foreach ($this->productos_todos(array('group'=>'marca_id')) as $producto){
			$marca=Marca::model()->findByPk($producto->marca_id);
			if($marca->padreId>0)
				$marca = Marca::model()->findByPk($marca->padreId);
			if(!in_array($marca,$marcas))
					$marcas[] = $marca;
		}
		return $marcas;
	}
	public function countItems()
	{
		if (isset($this->_items)){
			return $this->$_items;
		}else {
			$_items = count($this->productos);
			return $_items;
		}
	}

	public function getMontoVentas($format = true){
            /*El precio en la tabla tbl_orden_has_productotallacolor esta con IVA ? */
            
         
           	$sql ="SELECT SUM(op.precio*op.cantidad) FROM tbl_orden_has_productotallacolor op
                    where  op.look_id = :id AND tbl_orden_id IN (select id from tbl_orden where estado IN (3, 4, 8, 11))";
					if ($format)
			return Yii::app()->numberFormatter->formatDecimal( Yii::app()->db->createCommand($sql)->queryScalar(array("id" => $this->id)));
					else
			return  Yii::app()->db->createCommand($sql)->queryScalar(array("id" => $this->id));
              
            
	}
	
	
	
	
	
	
	
	
	
	
	public function getTipo()
	{
		return $this->tipo == self::TIPO_CONSERVADOR?'Consevador':'Atrevido';
	}
	/* regresar el texto del status del look */
	public function getStatus()
	{
		$textos = array('Creado','Enviado','Aprobado');
		return $textos[$this->status]; 
	}
	public function getTotalbyUser()
	{
		
		return count($this->findAll(array('condition'=>'user_id = '.Yii::app()->user->id)));
	}
	
	public function getxStatusbyUser($status) 
	{
		
		return $this->countByAttributes(array(),'status = :status and user_id = :user_id ',
    		array(':status'=>$status,':user_id'=>Yii::app()->user->id)
			);
	}	
	/* total de look */
	public function getTotal()
	{
		
		return count($this->findAll());
	}
	/* total de look activos */
	public function getAprovados()
	{
		 
		return $this->countByAttributes(array('status'=>2));
	}	
	/* total de look por enviar */
	public function getPorEnviar()
	{
		
		return $this->countByAttributes(array(),'status = :status ',
    		array(':status'=>0)
			);
	}
	/* total de look inactivos */
	public function getPorAprovar()
	{
		
		return $this->countByAttributes(array(),'status = :status ',
    		array(':status'=>1)
			);
	}	
	/* totoal por estado de orden */
	public function getTotalxStatus($status)
	{
		return count($this->findAllBySql('select tbl_orden_id,look_id from tbl_orden left join tbl_orden_has_productotallacolor on tbl_orden.id = tbl_orden_has_productotallacolor.tbl_orden_id where  estado = :status AND look_id != 0 group by tbl_orden_id, look_id;',
			array(':status'=>$status)));
		
		
	}	
	/* totoal por estado de orden */
	public function getLookxStatus($status)
	{
		return count($this->findAllBySql('select tbl_orden_id,look_id from tbl_orden left join tbl_orden_has_productotallacolor on tbl_orden.id = tbl_orden_has_productotallacolor.tbl_orden_id where  estado = :status AND look_id = :look_id group by tbl_orden_id, look_id;',
			array(':status'=>$status,':look_id'=>$this->id)));
		
		
	}	
	public function softDelete () {

                //$model = $this->getOwner();

                $this->deleted = 1;
                $this->deleted_on = date('Y-m-d h:i:s');
				$this->scenario = 'softdelete';
                if (!$this->save())
					Yii::trace('delete a look, Error:'.print_r($this->getErrors(), true), 'registro');
                return false;

        }
	public function increaseView(){
		
				$this->view_counter=$this->view_counter+1;
				$this->scenario = 'increaseview';
                if ($this->save())
					return true;
				return false;
				

        
	}
	
	public function createImage(){

		 $look = $this;
		 
		 /*
		 $w = 670;
		 if (isset($_GET['w']))
		 	$w = $_GET['w'];
		 $diff_w = 670/$w;
		 
		 $h = 670;
		 if (isset($_GET['h']))
		 	$h = $_GET['h'];
		 $diff_h = 670/$h;
		 */
		 $w = 710;
		 $diff_w = 1;
		  $h = 710;
		 $diff_h = 1;
		 $imagenes = array();
		 $i = 0;
		 
		 foreach($look->lookhasproducto as $lookhasproducto){
		 	$image_url = $lookhasproducto->producto->getImageUrl($lookhasproducto->color_id,array('ext'=>'png'));
		 	if (isset($image_url)){
		 			$imagenes[$i] = new stdClass();
				 	//$imagenes[$i]->path = Yii::getPathOfAlias('webroot').'/..'.$image_url;
					$imagenes[$i]->path = $_SERVER['DOCUMENT_ROOT'].$image_url;
					$imagenes[$i]->top = $lookhasproducto->top;
					$imagenes[$i]->left = $lookhasproducto->left;
					$imagenes[$i]->width = $lookhasproducto->width;
					$imagenes[$i]->height = $lookhasproducto->height;
					$imagenes[$i]->angle = $lookhasproducto->angle;
					$imagenes[$i]->zindex = $lookhasproducto->zindex;
			} 
			$i++;
		 }	
		 
		 foreach($look->lookHasAdorno as $lookhasadorno){
		 	$image_url = $lookhasadorno->adorno->getImageUrl(array('ext'=>'png'));
			$ador = Adorno::model()->findByPk($lookhasadorno->adorno_id);
		 	if (isset($image_url)){
		 			$imagenes[$i] = new stdClass();
				 	$imagenes[$i]->path = Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->language.'/adorno/'.$ador->path_image;
					$imagenes[$i]->top = $lookhasadorno->top;
					$imagenes[$i]->left = $lookhasadorno->left;
					$imagenes[$i]->width = $lookhasadorno->width;
					$imagenes[$i]->height = $lookhasadorno->height;
					$imagenes[$i]->angle = $lookhasadorno->angle;
					$imagenes[$i]->zindex = $lookhasadorno->zindex;
			} 

			$i++;
		 }	
		 
		  $imagenes[$i] = new stdClass();
				 	$imagenes[$i]->path = Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->language.'/p70.png';
					$imagenes[$i]->top = 0;
					$imagenes[$i]->left = 5;
					$imagenes[$i]->width = 70;
					$imagenes[$i]->height = 70;
					$imagenes[$i]->angle = 0;
					$imagenes[$i]->zindex = 1000;
		 
		 
		//Yii::trace('create a image look, Trace:'.print_r($imagenes, true), 'registro');
		function sortByIndex($a, $b) {
		    return $a->zindex - $b->zindex;
		} 
		
		usort($imagenes, 'sortByIndex');
		
		$canvas = imagecreatetruecolor($w, $h);
		$white = imagecolorallocate($canvas, 255, 255, 255);
		imagefill($canvas, 0, 0, $white);
		$inicio_x = 0;
		foreach($imagenes as $image){
			$ext = pathinfo($image->path, PATHINFO_EXTENSION);
            $b_top = 0;
            $b_btm = 0;
            $b_lft = 0;
            $b_rt = 0;
            //Yii::trace('product image path, Trace: ', 'registro');
			 switch(strtolower($ext)) {
			          case 'gif':
			          $src = imagecreatefromgif($image->path);
			          break;
			          case 'jpg':
			          $src = imagecreatefromjpeg($image->path);
			          break;
			          case 'png':
			          $src = imagecreatefrompng($image->path);
					        //top
					        for(; $b_top < imagesy($src); ++$b_top) {
					            for($x = 0; $x < imagesx($src); ++$x) {
					                $color        = imagecolorat($src, $x, $b_top);
					                $transparency = ($color >> 24) & 0x7F;
					                if(!$transparency) {
					                    break 2; //out of the 'top' loop
					                }
					            }
					        }
					
					        //bottom
					        for(; $b_btm < imagesy($src); ++$b_btm) {
					            for($x = 0; $x < imagesx($src); ++$x) {
					                $color        = imagecolorat($src, $x, imagesy($src) - $b_btm-1);
					                $transparency = ($color >> 24) & 0x7F;
					                if(!$transparency) {
					                    break 2; //out of the 'bottom' loop
					                }
					            }
					        }
					
					        //left
					        for(; $b_lft < imagesx($src); ++$b_lft) {
					            for($y = 0; $y < imagesy($src); ++$y) {
					                $color        = imagecolorat($src, $b_lft, $y);
					                $transparency = ($color >> 24) & 0x7F;
					                if(!$transparency) {
					                    break 2; //out of the 'left' loop
					                }
					            }
					        }
					
					        //right
					        for(; $b_rt < imagesx($src); ++$b_rt) {
					            for($y = 0; $y < imagesy($src); ++$y) {
					                $color        = imagecolorat($src, imagesx($src) - $b_rt-1, $y);
					                $transparency = ($color >> 24) & 0x7F;
					                if(!$transparency) {
					                    break 2; //out of the 'right' loop
					                }
					            }
					        }
					
					        //copy the contents, excluding the border
					      //  $newimg = $this->imagecreatetransparent(
					       //     imagesx($src)-($b_lft+$b_rt), imagesy($src)-($b_top+$b_btm));
					
					      //  imagecopy($newimg, $src, 0, 0, $b_lft, $b_top, imagesx(imagesx($src)-($b_lft+$b_rt)), imagesy(imagesy($src)-($b_top+$b_btm)));
					
					       
					            // Swap the new image for the old one
					        //   $src = $newimg;
					       
						//Yii::trace('create a image look, Trace:'.$image->path, 'registro');  
			          break;
			      }
			      //Yii::trace('product image src, Trace: '.print_r($src, true), 'registro');	

                $img = imagecreatetruecolor($image->width/$diff_w,$image->height/$diff_h);

			//    $img = imagecreatetruecolor(imagesx($src)-($b_lft+$b_rt), imagesy($src)-($b_top+$b_btm));
			
			
			imagealphablending( $img, false );
			imagesavealpha( $img, true ); 
    		$pngTransparency = imagecolorallocatealpha($img , 0, 0, 0, 127); 
    		//imagecopyresized($img,$src,0,0,0,0,$image->width/$diff_w,$image->height/$diff_h,imagesx($src), imagesy($src));
			//imagecopyresampled($img,$src,0,0,0,0,$b_lft, $b_top, imagesx($src)-($b_lft+$b_rt), imagesy($src)-($b_top+$b_btm));
            if ($look->id >= 638){
                imagecopyresampled($img,$src,0,0,$b_lft, $b_top,imagesx($img), imagesy($img),imagesx($src)-($b_lft+$b_rt), imagesy($src)-($b_top+$b_btm));
            }else{
			    imagecopyresampled($img,$src,0,0,0,0,$image->width/$diff_w,$image->height/$diff_h,imagesx($src), imagesy($src)); // <----- Se cambio a sampled para mejorar la calidad de las imagenes
			}
    		
    		//imagecopyresized($img,$src,0,0,0,0,imagesx($src),imagesy($src),imagesx($src), imagesy($src));
			if ($image->angle){
				//Yii::trace('create a image look,'.$image->angle.' Trace:'.$image->path, 'registro');
				$img = imagerotate($img,$image->angle*(-1),$pngTransparency);
			}
			imagecopy($canvas, $img, $image->left/$diff_w, $image->top/$diff_h, 0, 0, imagesx($img), imagesy($img));
		}
		header('Content-Type: image/png'); 
		header('Cache-Control: max-age=86400, public');
		//imagepng($canvas,Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->language.'/look/'.$look->id.'.png',9); // <------ se puso compresion 9 para mejorar la rapides al cargar la imagen
		imagepng($canvas,Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->language.'/look/'.$look->id.'.png',9); // <------ se puso compresion 9 para mejorar la rapides al cargar la imagen
		Yii::trace('create images, Trace:'.Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->language.'/look/'.$look->id.'.png', 'registro');
		imagedestroy($canvas);		
	}

	public function getUrl() 
	{
		if(isset($this->url_amigable) && $this->url_amigable != "")
				return Yii::app()->baseUrl."/looks/".$this->url_amigable;
		else
			return Yii::app()->baseUrl."/look/".$this->id;
		
	}


        
         /**
         * Buscar por todos los filtros dados en el array $filters
         */
        public function buscarPorFiltros($filters, $personalShopper = 0) {
//            echo "<pre>";
//            print_r($filters);
//            echo "</pre>";
//            Yii::app()->end();

            $criteria = new CDbCriteria;
            
            $criteria->with = array();
            //$criteria->select = array();
            //$criteria->select[] = "t.*";
            
            $havingPrecio = '';
            
            for ($i = 0; $i < count($filters['fields']); $i++) {
                
                $column = $filters['fields'][$i];
                $value = $filters['vals'][$i];
                $comparator = $filters['ops'][$i];
                
                if($i == 0){
                   $logicOp = 'AND'; 
                }else{                
                    $logicOp = $filters['rels'][$i-1];                
                }    
                
                if($column == 'campana')
                {
                    
                    $value = ($comparator == '=') ? "=".$value."" : $value;
                    
                    $criteria->compare('campana.nombre', $value,
                        true, $logicOp);
                    
                    
                    $criteria->with[] = 'campana';
                    
                    
                    continue;
                }
                
                if($column == 'precio')
                {
                    $criteria->addCondition('(select sum(precios.precioDescuento) from `tbl_look_has_producto` `productos_productos`, `tbl_producto` `productos`, `tbl_precio` `precios` 
                          where `t`.`id`=`productos_productos`.`look_id` and `productos`.`id`=`productos_productos`.`producto_id` and 
                          `precios`.`tbl_producto_id`=`productos`.`id`) '
                    .$comparator.' '.$value.'', $logicOp);                    
                    
                    
                   continue;
                }   
                
                if($column == 'marca')
                {                                    
                    
                    $criteria->with['productos'] = array(
                        'select'=> false,
                        //'joinType'=>'INNER JOIN',
                        //'condition'=>'productos.nombres = 8',
                    );    
                    
                    //having
                    if(!strpos($criteria->group, "t.id")){
                        $criteria->group = 't.id';
                    }
                    
                    //agregar condicion marca_id
                    $criteria->addCondition('productos.marca_id'
                    .$comparator.' '.$value.'', $logicOp);                    
                    
                   continue;
                } 
                
                if($column == 'prendas')
                {
                  $criteria->addCondition('(select count(look_id) 
                    from `tbl_look_has_producto` `productos_productos`
                    where `t`.`id`=`productos_productos`.`look_id`)'
                    .$comparator.' '.$value.'', $logicOp);
                   
                   continue;                   
                }  
                
                if($column == 'cantidad')
                {
                    /*
                     * Por cada orden se esta contando el look como vendido una 
                     * sola vez asi aparezca dos veces en la misma orden
                     * 
                     * Luego se debe corregir para que cuente correctamente si 
                     * el look ha sido pedido mas de una vez en una orden
                     */
                    
                  $criteria->addCondition('
                    (select count(distinct(orden.id)) from tbl_orden_has_productotallacolor o_ptc, tbl_orden orden
                    where o_ptc.tbl_orden_id = orden.id
                    and
                    o_ptc.look_id > 0
                    and
                    o_ptc.look_id = t.id
                    and
                    orden.estado IN (3, 4, 8))'
                    .$comparator.' '.$value.'', $logicOp);
                   
                   continue;                   
                }  
                
                if($column == 'monto')
                {
                    
                  $criteria->addCondition('
                    (select count(distinct(orden.id)) from tbl_orden_has_productotallacolor o_ptc, tbl_orden orden
                    where o_ptc.tbl_orden_id = orden.id
                    and
                    o_ptc.look_id > 0
                    and
                    o_ptc.look_id = t.id
                    and
                    orden.estado IN (3, 4, 8))                    
                    *
                    (select sum(precios.precioDescuento) from `tbl_look_has_producto` `productos_productos`, `tbl_producto` `productos`, `tbl_precio` `precios` 
                    where `t`.`id`=`productos_productos`.`look_id` and `productos`.`id`=`productos_productos`.`producto_id` and 
                    `precios`.`tbl_producto_id`=`productos`.`id`)
                    '
                    .$comparator.' '.$value.'', $logicOp);
                   
                   continue;                   
                } 

				if($column == 'ocasion')
                {
                	
					$criteria->compare('categoriahaslook.categoria_id', $comparator." ".$value,
	                        false, $logicOp);
					$criteria->with[] = 'categoriahaslook';
					
					 continue;     
				   
                } 
                
                if($column == 'created_on')
                {
                    $value = strtotime($value);
                    $value = date('Y-m-d H:i:s', $value);
                }



                $criteria->compare("t.".$column, $comparator." ".$value,
                        false, $logicOp);
                
            }
                                   
//            $criteria->select = 't.*';
            $criteria->having .= $havingPrecio;
            //$criteria->with = array('categorias', 'preciotallacolor', 'precios');
            $criteria->together = true;
            
            //si se estan usando los filtros en Mis Looks
            if($personalShopper){
                $criteria->compare('t.user_id', $personalShopper); //siempre los no eliminados
            }
            
            
//            echo "Criteria:";
//            
//            echo "<pre>";
//            print_r($criteria->toArray());
//            echo "</pre>"; 
            //exit();


            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
       }
       
       public function getCantVendidos()
	{
		return count($this->findAllBySql('select tbl_orden_id,look_id from tbl_orden 
                    left join tbl_orden_has_productotallacolor on tbl_orden.id = tbl_orden_has_productotallacolor.tbl_orden_id 
                    where  estado IN (3, 4, 8) AND look_id = :look_id group by tbl_orden_id, look_id;',
			array(':look_id'=>$this->id)));
		
		
	}
        
	public static function masVistos($limit = 20){
            $criteria=new CDbCriteria;  		
		
            //$criteria-> compare('destacado',1);
            //$criteria->addInCondition('status', array(2, 1));
            $criteria->order = "view_counter DESC";
            return new CActiveDataProvider(__CLASS__, array(
                    'criteria'=>$criteria,
                    'pagination'=>array(
                            'pageSize'=>$limit,
                    ),	
            ));
            
            
        }
        
        public function getTotalVentas($format = true){
            /*El precio en la tabla tbl_orden_has_productotallacolor esta con IVA ? */
            
            if (is_null($this->_totalVentas)){
                $sql ="SELECT SUM(op.precio) FROM tbl_orden_has_productotallacolor op, tbl_orden o
                    where o.estado IN (3, 4, 8)
                    AND
                    o.id = op.tbl_orden_id
                    AND
                    op.look_id = :id";
                $this->_totalVentas = Yii::app()->db->createCommand($sql)->queryScalar(array("id" => $this->id));
            }
            
		
            
            if ($format)
			return Yii::app()->numberFormatter->formatDecimal($this->_totalVentas);
		else
			return $this->_totalVentas;
            
            
        }
	
	protected function beforeSave()
	{
	   	
	   if(($this->url_amigable!='')||(!is_null($this->url_amigable))){
	   	$matches = null;
			if(!preg_match('/^\\w{1}([a-zA-Z_|\\-]*[a-zA-Z]+[a-zA-Z_|\\-]*)$/', $this->url_amigable, $matches)){
				$this->url_amigable=NULL;	
				Yii::app()->user->setFlash('error', 'Url no guardada por presentar caracteres inválidos.');
				
			}
			
	   }
	   //echo $this->birthday;
	   return parent::beforeSave();
	}
	 
	public function getHas_100chic(){
		if(is_array($this->productos))
		{		
			foreach($this->productos as  $producto){
				if($producto->mymarca->is_100chic)
					return true;
			}
		}
		return false;
	}
        
        /**
         * Se revisa si el look tiene al menos una prenda en existencia,
         * disponible y activa.
         */
	public function getIsVisible(){
		if(is_array($this->productos))
		{		
			foreach($this->lookhasproducto as $lookhasproducto){
				if($lookhasproducto->producto->getCantidad(null, $lookhasproducto->color_id) > 0 && 
                                    $lookhasproducto->producto->estado == 0)
					return true;
			}
		}
		return false;
	}
	public function getRangosPrecios(){
		$start = microtime(true);
				/*      Rangos de precios       */
		        $allLooks = Look::model()->findAll("status = 2");
		        $count = array(0, 0, 0, 0);
		        $rangosArray = array();              
		        
		        if($allLooks){
		//$time_taken = microtime(true) - $start;
		//echo $time_taken."x<br>";            
		            foreach ($allLooks as $look) {
		               // $allPrices[] = $look->getPrecio(false); //Precio sin descuento
		               $allPrices[] = $look->getPrecioDescuento(false); // Precio con descuento
		               
		                //$allPrices[] = $look->precioNf;
		//$time_taken = microtime(true) - $start;
		//echo $time_taken."x<br>";				
		            }

		            $rangos = 4;
		            $mayorP = max($allPrices);
		            $menorP = min($allPrices);
		            $len = ($mayorP - $menorP) / $rangos;
		//$time_taken = microtime(true) - $start;
		//echo $time_taken."x<br>";
		            foreach ($allPrices as $price) {
		                for($i = 0; $i < $rangos; $i++)
		                    $count[$i] += $price >= $menorP + $i * $len && $price <= $menorP + (($i+1) * $len) ? 1 : 0;
		            }                
		//$time_taken = microtime(true) - $start;
		//echo $time_taken."x<br>";
		            for ($i = 0; $i < $rangos; $i++) {
		                $mayorP = $menorP + $len;
		                $rangosArray[] = array('start' => $menorP, 'end' => $mayorP, 'count' => $count[$i]);
		                $menorP += $len;
		            }                                
		//$time_taken = microtime(true) - $start;
		//echo $time_taken."x<br>";        
		        }
				return $rangosArray;
	}

	public function hasProductosExternos(){
		foreach ($this->productos as $producto) {
			if($producto->tipo == 1){
				return true;
			}
		}
		return false;
	}

    public function encode_url($alphabet,$look_id=null,$ps_id=null){

        if ($look_id==null)
            $look_id = $this->id;
        if ($ps_id==null)
            $ps_id = $this->user_id;
        $num = $look_id.sprintf('%05d', $ps_id);
        $base_count = strlen($alphabet);
        $encoded = '';
        while ($num >= $base_count) {
            $div = $num/$base_count;
            $mod = ($num-($base_count*intval($div)));
            $encoded = $alphabet[$mod] . $encoded;
            $num = intval($div);
        }

        if ($num) $encoded = $alphabet[$num] . $encoded;

        return $encoded;
    }
    
    public function countAvailableProducts(){
        $count=0;    
        foreach($this->lookhasproducto as $lhp){
            $ptcs=Preciotallacolor::model()->findAllByAttributes(array('producto_id'=>$lhp->producto_id,'color_id'=>$lhp->color_id));
            if(isset($ptcs))
            {
                foreach($ptcs as $ptc){
                    if($ptc->cantidad>0){
                        $count++;
                        break;
                    }
                }
            }
                
        }
        return $count;
    }
    
    public function updateAvailability()
    {
        $this->setScenario('availability');
        $save=false;
        if($this->countAvailableProducts()<3)
        {
            if($this->available!=0){
                 $this->available=0;
                 $this->save();
                 $save=true;                
            }
        }           
        else{
            if($this->available!=1){
                 $this->available=1;
                 $this->save();
                 $save=true;                
            }
        } 
        return $save;
        
    }
	
}
