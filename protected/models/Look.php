<?php

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
 * @property integer $status
 * @property integer $view_counter 
 *
 * The followings are the available model relations:
 * @property LookHasTblBolsa[] $lookHasTblBolsas
 * @property Producto[] $tblProductos
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
	 private $_items;
	 private $_ocasiones = array(36=>'fiesta',37=>'trabajo',38=>'playa',39=>'sport',40=>'coctel');
	 public $has_ocasiones;
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

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array(' altura, contextura, pelo, ojos, tipo_cuerpo, piel, tipo', 'numerical','min'=>1),
			array('title, altura, contextura, pelo, ojos, tipo_cuerpo, piel, tipo, campana_id', 'required'),
			array('altura, contextura, pelo, ojos, tipo_cuerpo, piel, tipo,destacado,status, campana_id,view_counter', 'numerical', 'integerOnly'=>true),
			array('altura, contextura, pelo, ojos, tipo_cuerpo, piel', 'numerical','min'=>1,'tooSmall' => 'Debe seleccionar por lo menos un(a) {attribute}','on'=>'update'),
			array('has_ocasiones','required','on'=>'update'),
			array('title', 'length', 'max'=>45),
			array('description, created_on', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, description, altura, contextura, pelo, ojos, tipo_cuerpo, piel, created_on, tipo,destacado, status, user_id, campana_id, view_counter', 'safe', 'on'=>'search'),
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
			'categoriahaslook' => array(self::HAS_MANY, 'CategoriaHasLook', 'look_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'campana' => array(self::BELONGS_TO, 'Campana', 'campana_id'),
			'categorias' => array(self::MANY_MANY, 'Categoria', 'tbl_categoria_has_look(categoria_id, look_id)'),
			'lookhasproducto' => array(self::HAS_MANY, 'LookHasProducto','look_id','order'=>'zindex ASC'),
			'lookHasAdorno' => array(self::HAS_MANY, 'LookHasAdorno','look_id'),
			
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
		);
	}
	public function matchOcaciones($user)
	{
		foreach ($this->categorias as $categoria){
			$algo = $this->_ocasiones[$categoria->padreId];
			//echo '/'.$user->profile->$algo;
			if ($user->profile->$algo == $this->tipo)
				return true;
		}
		return false;
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
		
		$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM tbl_look WHERE (if('.$user->profile->pelo.' & pelo !=0,1,0)+if('.$user->profile->altura.' & altura !=0,1,0))>=2')->queryScalar();
		
		$sql='SELECT id FROM tbl_look WHERE (
			if('.$user->profile->altura.' & altura !=0,1,0)+
			if('.$user->profile->contextura.' & contextura !=0,1,0)+
			if('.$user->profile->pelo.' & pelo !=0,1,0)+
			if('.$user->profile->ojos.' & ojos !=0,1,0)+
			if('.$user->profile->piel.' & piel !=0,1,0)+
			if('.$user->profile->tipo_cuerpo.' & tipo_cuerpo !=0,1,0)
		) = 6 
		UNION ALL '.
		'SELECT id FROM tbl_look WHERE (
			if('.$user->profile->altura.' & altura !=0,1,0)+
			if('.$user->profile->contextura.' & contextura !=0,1,0)+
			if('.$user->profile->pelo.' & pelo !=0,1,0)+
			if('.$user->profile->ojos.' & ojos !=0,1,0)+
			if('.$user->profile->piel.' & piel !=0,1,0)+
			if('.$user->profile->tipo_cuerpo.' & tipo_cuerpo !=0,1,0)
		) = 5 
		';
		
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
/*			
		$criteria=new CDbCriteria;  
		$criteria->compare('tipo',1); 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
*/		
		$sql ="SELECT count(distinct tbl_orden_id) as looks,look_id FROM tbl_orden_has_productotallacolor where look_id != 0 group by look_id order by  count(distinct tbl_orden_id) DESC";
		$count = 10; 	
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
		
		$criteria->order = "created_on DESC";
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	/* looks destacados */
	public function lookDestacados($limit = 6) 
	{
		
		$criteria=new CDbCriteria;  

		
		
		$criteria->compare('destacado',1);
		
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
	public function getPrecio($format=true)
	{
		if (is_null($this->_precio)) {
				$this->_precio = 0;
		foreach($this->lookhasproducto as $lookhasproducto){
			if ($lookhasproducto->producto->getCantidad(null,$lookhasproducto->color_id) > 0)
			$this->_precio += $lookhasproducto->producto->getPrecio(false);
		}
		}
		if ($format)
			return Yii::app()->numberFormatter->formatDecimal($this->_precio);
		else
			return $this->_precio;
	}
	public function countItems()
	{
		if (isset($this->_items)){
			return $_items;
		}else {
			$_items = count($this->productos);
			return $_items;
		}
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
		return count($this->findAllBySql('select tbl_orden_id,look_id from tbl_orden left join tbl_orden_has_productotallacolor on tbl_orden.id = tbl_orden_has_productotallacolor.tbl_orden_id where estado = :status AND look_id != 0 group by tbl_orden_id, look_id;',
			array(':status'=>$status)));
		
		
	}	
	/* totoal por estado de orden */
	public function getLookxStatus($status)
	{
		return count($this->findAllBySql('select tbl_orden_id,look_id from tbl_orden left join tbl_orden_has_productotallacolor on tbl_orden.id = tbl_orden_has_productotallacolor.tbl_orden_id where estado = :status AND look_id = :look_id group by tbl_orden_id, look_id;',
			array(':status'=>$status,':look_id'=>$this->id)));
		
		
	}	
}