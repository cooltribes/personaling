<?php

/*
 * Estado = 0 activo / 1 Inactivo
 * status = 0 eliminado / 1 no eliminado
 */ 

/**
 * This is the model class for table "{{producto}}".
 *
 * The followings are the available columns in table '{{producto}}':
 * @property integer $id
 * @property string $codigo
 * @property string $nombre
 * @property integer $estado
 * @property string $descripcion
 * @property string $fInicio
 * @property string $fFin
 * @property string $fecha
 * @property integer $status
 * @property integer $destacado
 * @property integer $marca_id
 * @property integer $view_counter 
 */
class Producto extends CActiveRecord
{
	const aldo='Aldo';
	const desigual='Desigual';
	const mango='Mango';
	const accessorize='Accessorize';
	const suite='SuiteBlanco';
	const helly='Helly Hansel';
	const secret='Woman Secret';
	const bimba='Bimba & Lola';
	
	
	public $horaInicio="";
	public $horaFin="";
	public $minInicio="";
	public $minFin="";
	public $uno="";
	public $dos="";
	public $categoria_id="";
	public $_precio = null;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Producto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{producto}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('estado, marca_id, view_counter', 'numerical', 'integerOnly'=>true),
			array('peso', 'numerical', 'min'=>0.1, 'tooSmall'=>'El peso debe ser mayor a 0'),
			array('codigo', 'length', 'max'=>25),
			array('nombre', 'length', 'max'=>70),
			array('nombre, codigo, marca_id, descripcion, peso', 'required'),
			//array('proveedor', 'length', 'max'=>45), 
			array('imagenes', 'required', 'on'=>'multi'),
			array('codigo', 'unique', 'message'=>'Código de producto ya registrado.'),
			array('descripcion, fInicio, fFin,horaInicio, horaFin, minInicio, minFin, fecha, status, peso', 'safe'),
			//array('fInicio','compare','compareValue'=>date("Y-m-d"),'operator'=>'=>'),
			array('fInicio','compare','compareValue'=>date("m/d/Y"),'operator'=>'>=','allowEmpty'=>true, 'message'=>'La fecha de inicio debe ser mayor al dia de hoy.'),
			array('fFin','compare','compareAttribute'=>'fInicio','operator'=>'>', 'allowEmpty'=>true , 'message'=>'La fecha de fin debe ser mayor a la fecha de inicio.'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, codigo, nombre, estado, descripcion, marca_id, destacado, fInicio, fFin,horaInicio,horaFin,minInicio,minFin,fecha, status, peso', 'safe', 'on'=>'search'),
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
			'categorias' => array(self::MANY_MANY, 'Categoria', 'tbl_categoria_has_tbl_producto(tbl_categoria_id, tbl_producto_id)'),
			'encantan' => array(self::MANY_MANY, 'UserEncantan', 'tbl_userEncantan(producto_id, user_id)'),
			'imagenes' => array(self::HAS_MANY, 'Imagen', 'tbl_producto_id','order' => 'k.orden ASC', 'alias' => 'k'),
			'mainimage' => array(self::HAS_ONE, 'Imagen', 'tbl_producto_id','on' => 'orden=1'),
			'colorimage' => array(self::HAS_ONE, 'Imagen', 'tbl_producto_id','order'=>'k.orden ASC', 'alias' => 'k'),
			'precios' => array(self::HAS_MANY, 'Precio', 'tbl_producto_id'),
			'inventario' => array(self::HAS_ONE, 'Inventario', 'tbl_producto_id'),
			'preciotallacolor' => array(self::HAS_MANY,'Preciotallacolor','producto_id'),
			'preciotallacolorSum' => array(self::STAT, 'Preciotallacolor', 'producto_id',
                'select'=> 'SUM(cantidad)',
                ),
            'lookhasproducto' => array(self::BELONGS_TO, 'LookHasProducto','id'),                    
            
		);
	}
 
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'codigo' => 'Referencia',
			'nombre' => 'Nombre / Titulo',
			'estado' => 'Estado',
			'descripcion' => 'Descripción',
			'fInicio' => 'Inicio',
			'fFin' => 'Fin',
			'fecha' => 'Fecha',
			'status' => 'Status',
			'destacado' => '¿Destacar?',
			'marca_id' => 'Marca',
			'view_counter' => 'Contador',
			'peso' => 'Peso',
		);
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
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('marca_id',$this->marca_id,true);
		$criteria->compare('fInicio',$this->fInicio,true);
		$criteria->compare('fFin',$this->fFin,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('destacado',$this->destacado,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('peso',$this->peso,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	} 
	public function busqueda($todos)
	{

		$criteria=new CDbCriteria;
		$criteria->compare('t.nombre',$this->nombre,true);
		$criteria->compare('categorias.nombre',$this->nombre,true,'OR');
		/*
		$criteria->compare('id',$this->id);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('t.nombre',$this->nombre,true);
		$criteria->compare('t.estado',$this->estado,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('marca_id',$this->marca_id,true);
		$criteria->compare('fInicio',$this->fInicio,true);
		$criteria->compare('fFin',$this->fFin,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('destacado',$this->destacado,true);
		$criteria->compare('peso',$this->peso,true);
		*/
		
		//$criteria->with = array('categorias');
		//$criteria->with = array('precios');
		$criteria->with = array('precios','categorias');
		
		$criteria->join ='JOIN tbl_imagen ON tbl_imagen.tbl_producto_id = t.id';
		
		if(is_array($todos)) // si la variable es un array, viene de una accion de filtrado
		{
			if(empty($todos)) // si no tiene hijos devuelve un array vacio por lo que debe buscar por el id de la categoria
			{
				$criteria->compare('tbl_categoria_id',$this->categoria_id);
			}
			else // si tienes hijos
				{
					$criteria->addInCondition("tbl_categoria_id",$todos);
				}		
		}else if($todos=="a")
		{
				$criteria->compare('tbl_categoria_id',$this->categoria_id);
		}

		$criteria->addCondition('precioDescuento != ""');
		$criteria->addCondition('orden = 1');
		
		$criteria->order = "t.id ASC";
		
		$criteria->together = true;
		
		return new CActiveDataProvider($this, array(
       'pagination'=>array('pageSize'=>12,),
       'criteria'=>$criteria,
	));
		
	}
	public function busquedaOLD($todos)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		//$criteria->compare('id',$this->id);
		//$criteria->compare('codigo',$this->codigo,true);
		//$criteria->compare('nombre',$this->nombre,true,'OR',true);
		
		$criteria->compare('t.nombre',$this->nombre,true,'OR');
		//$criteria->compare('t.descripcion',$this->nombre,true);
		$criteria->compare('categorias.nombre',$this->nombre,true,'OR');
		//$criteria->compare('preciotallacolor.color_id',4,false,'OR');
		
		//$criteria->compare('t.estado',$this->estado,true);
		//$criteria->compare('marca_id',$this->marca_id,true);
		//$criteria->compare('fInicio',$this->fInicio,true);
		//$criteria->compare('fFin',$this->fFin,true);
		//$criteria->compare('fecha',$this->fecha,true);
		//$criteria->compare('status',$this->status,true);
		//$criteria->compare('destacado',$this->destacado,true);
		//$criteria->compare('peso',$this->peso,true);
		$criteria->with = array('categorias','preciotallacolor');
		//$criteria->with = array('preciotallacolor');
		
		
		
		if(is_array($todos)) // si la variable es un array, viene de una accion de filtrado
		{
			if(empty($todos)) // si no tiene hijos devuelve un array vacio por lo que debe buscar por el id de la categoria
			{
				$criteria->compare('tbl_categoria_id',$this->categoria_id);
			}
			else // si tienes hijos
				{
					$criteria->addInCondition("tbl_categoria_id",$todos);
					
				}		
		}else if($todos=="a")
		{
				$criteria->compare('tbl_categoria_id',$this->categoria_id);
		}
			
		
		
		$criteria->together = true;
		
		return new CActiveDataProvider($this, array(
       'pagination'=>array('pageSize'=>24),
       'criteria'=>$criteria,
	));
		
	}

	public function hijos($items,$op){
		
		$ids = array();
		
		foreach ($items as $item) {				
			if($item->hasChildren()){
				$categ = Categoria::model()->findAllByAttributes(array('padreId'=>$item->id,));
				foreach ($categ as $ca){
					array_push($ids, $ca->id);
					$op++;
				}
			}	
		}
		return $ids;
	}
	public function getPrecio($format=true)
	{

    if (is_null($this->_precio)) {
      $c = new CDbCriteria();
      $c->order = '`id` desc';
      $c->compare('tbl_producto_id', $this->id);
      $this->_precio = Precio::model()->find($c);
    }
	if (isset($this->_precio->precioDescuento))
		if ($format){
	 		return Yii::app()->numberFormatter->formatDecimal($this->_precio->precioDescuento);
		} else {
			return $this->_precio->precioDescuento;
		}
	else 
		return 0;
	
    
  		
	}
	public function getCantidad($talla=null,$color=null)
	{
	if (is_null($talla) and is_null($color))
		return $this->preciotallacolorSum;
	if (is_null($talla))
 		return $this->preciotallacolorSum(array('condition'=>'color_id=:color_id',
                      'params' => array(':color_id'=>$color)
				));	
	if (is_null($color))
 		return $this->preciotallacolorSum(array('condition'=>'talla_id = :talla_id',
                  'params' => array(':talla_id' => $talla)
			));
			 
	return $this->preciotallacolorSum(array('condition'=>'talla_id = :talla_id AND color_id=:color_id',
                  'params' => array(':talla_id' => $talla,':color_id'=>$color)
			));
	}
	public function getImageUrl($color=null,$opciones=array())
	{
		//$opciones['ext'] = isset($opciones['ext'])?$opciones['ext']:'jpg'; // valor por defecto
	 	//$opciones['type'] = isset($opciones['type'])?'_'.$opciones['type'].'.':'.'; // valor por defecto
			if (is_null($color)){
				if ($this->mainimage) return $this->mainimage->getUrl($opciones);
			}else{
				$imagecolor = $this->colorimage( array('condition'=>'color_id=:color_id','params' => array(':color_id'=>$color) ) ); 
				if ( isset( $imagecolor) ) return  $imagecolor->getUrl($opciones);
				elseif ($this->mainimage) return $this->mainimage->getUrl($opciones);
			}
			return "http://placehold.it/180";
			 
	}
	public function getColores($talla=null)
	{
		//$kwdata = Producto::model()->with(array('preciotallacolor'=>array('condition'=>'Preciotallacolor.color_id == '.$color)))->findByPk($this->id);
		//foreach ($this->with(array('preciotallacolor'=>array('condition'=>'Preciotallacolor.color_id == '.$color))) as $producto){
		//	$co = Color::model()->findByPk($p->color_id);
		//}
		if ($talla == null)
			$ptc = Preciotallacolor::model()->findAllByAttributes(array('producto_id'=>$this->id));
		else
			$ptc = Preciotallacolor::model()->findAllByAttributes(array('talla_id'=>$talla,'producto_id'=>$this->id));
		$datos = array();
		foreach($ptc as $p)
		{
			
			
			$ta = Color::model()->findByPk($p->color_id);
			$datos[$ta->id]=$ta->valor;
			//array_push($datos,$ta->id);
			//array_push($datos,$ta->valor); // para cada talla guardo su id y su valor
			
			
		}		
		return $datos;
	}
	public function getTallas($color)
	{
		//$kwdata = Producto::model()->with(array('preciotallacolor'=>array('condition'=>'Preciotallacolor.color_id == '.$color)))->findByPk($this->id);
		//foreach ($this->with(array('preciotallacolor'=>array('condition'=>'Preciotallacolor.color_id == '.$color))) as $producto){
		//	$co = Color::model()->findByPk($p->color_id);
		//}
$ptc = Preciotallacolor::model()->findAllByAttributes(array('color_id'=>$color,'producto_id'=>$this->id),'cantidad > 0');
		$datos = array();
		foreach($ptc as $p)
		{
			
			
			$ta = Talla::model()->findByPk($p->talla_id);
			$datos[$ta->id]=$ta->valor;
			//array_push($datos,$ta->id);
			//array_push($datos,$ta->valor); // para cada talla guardo su id y su valor
			
			
		}		
		return $datos;
	}
	public function beforeSave()
	{
		

		if(!$this->fInicio && !$this->fFin)
		{
			$this->fInicio = "";
			$this->fFin = "";
			
			$this->fecha = date("Y-m-d");
			
			if($this->estado=="")
				$this->estado = 1;
			
			return parent::beforeSave();
		}
		else if(($this->fInicio=="" && $this->fFin=="") || ($this->fInicio=="0000-00-00 00:00:00" && $this->fFin=="0000-00-00 00:00:00"))
		{ 
		
			$this->fInicio = "";
			$this->fFin = "";
			
			$this->fecha = date("Y-m-d");
			
			if($this->estado=="")
				$this->estado = 1;
			
			return parent::beforeSave();	
		
		}else{

			if($this->estado=="")
				$this->estado = 1;
			
		$this->fInicio=Yii::app()->dateformatter->format("yyyy-MM-dd",$this->fInicio);	
		$this->fFin=Yii::app()->dateformatter->format("yyyy-MM-dd",$this->fFin);
		
		//$this->horaInicio = $producto->horaInicio."".$producto->minInicio;
		
		$this->fecha = date("Y-m-d");
		
		$this->uno = $this->horaInicio;
		$this->dos = $this->horaFin;
		
		$this->horaInicio = substr($this->horaInicio, 0, 2); 
		$this->horaFin = substr($this->horaFin, 0, 2);
		
		$this->minInicio = substr($this->uno, 3, 2);
		$this->minFin = substr($this->dos, 3, 2);
		
		$horarioInicio = substr($this->uno, 6, 2);
		$horarioFin = substr($this->dos, 6, 2);
		
		if($horarioInicio=='AM')
			$this->fInicio= $this->fInicio.' '.$this->horaInicio.':'.$this->minInicio.':00';
		else
			{
				$this->horaInicio=$this->horaInicio+12;
				$this->fInicio= $this->fInicio.' '.$this->horaInicio.':'.$this->minInicio.':00';
			}
			
		if($horarioFin=='AM')
			$this->fFin = $this->fFin.' '.$this->horaFin.':'.$this->minFin.':00';
		else
			{
				$this->horaFin=$this->horaFin+12;
				$this->fFin = $this->fFin.' '.$this->horaFin.':'.$this->minFin.':00';
			}
				
		return parent::beforeSave();
	}
	
}


	public function busColor($idColor)
	{
		// llega un ID de color

		$criteria=new CDbCriteria;

        $criteria->select = 't.*';
        $criteria->join ='JOIN tbl_precioTallaColor ON tbl_precioTallaColor.producto_id = t.id';
        $criteria->addCondition('t.estado = 0');
		$criteria->addCondition('t.status = 1');
     //   $criteria->condition = 't.estado = :uno';
	//	$criteria->condition = 't.status = :dos';
		$criteria->addCondition('tbl_precioTallaColor.color_id = :tres');
	//	$criteria->condition = 'tbl_precioTallaColor.color_id = :tres';
		$criteria->addCondition('tbl_precioTallaColor.cantidad > 0'); // que haya algo en inventario		
    //    $criteria->params = array(":uno" => "2"); // estado
	//	$criteria->params = array(":dos" => "1"); // status
		$criteria->params = array(":tres" => $idColor); // color que llega
		$criteria->group = 't.id';

		
		return new CActiveDataProvider($this, array(
       'pagination'=>array('pageSize'=>12,),
       'criteria'=>$criteria,
	));
		
	}
	
		public function multipleColor($idColor, $idact)
	{
		// llega un array de ID de color
		 
		$colores="";
		$i=0;
		$criteria=new CDbCriteria;

        $criteria->select = 't.*';
        $criteria->join ='JOIN tbl_precioTallaColor ON tbl_precioTallaColor.producto_id = t.id JOIN tbl_categoria_has_tbl_producto on tbl_categoria_has_tbl_producto.tbl_producto_id  = t.id';
        $criteria->addCondition('t.estado = 0');
		$criteria->addCondition('t.status = 1');
     //   $criteria->condition = 't.estado = :uno';
	//	$criteria->condition = 't.status = :dos';
	

	
	if(is_array($idColor)){
		if(count($idColor)>0){	
			
			foreach($idColor as $col){
				if(count($idColor)==1){
					$colores='tbl_precioTallaColor.color_id = '.$col;	
					break;			
				}	
				
				if($i==0)
					$colores.='(tbl_precioTallaColor.color_id = '.$col.' ';
				
				if($i>0 && $i<count($idColor)-1)
					$colores.='OR tbl_precioTallaColor.color_id = '.$col.' ';
				
				if($i==count($idColor)-1)
					$colores.='OR tbl_precioTallaColor.color_id = '.$col.' )';
				
				$i++;
						
			}
			$criteria->addCondition($colores);
			
		}
	}
	
	if(isset(Yii::app()->session['idact'])){
		
		$categoria= 'tbl_categoria_has_tbl_producto.tbl_categoria_id ='.$idact;
		$criteria->addCondition($categoria);
		
		
	}
	
	

		
	
		
			
	//	$criteria->condition = 'tbl_precioTallaColor.color_id = :tres';
		$criteria->addCondition('tbl_precioTallaColor.cantidad > 0'); // que haya algo en inventario		
    //    $criteria->params = array(":uno" => "2"); // estado
	//	$criteria->params = array(":dos" => "1"); // status
		
		$criteria->group = 't.id';

		
		return new CActiveDataProvider($this, array(
       'pagination'=>array('pageSize'=>12,),
       'criteria'=>$criteria,
	));
		
	}
	
	
	
	
		
	public function ProductosLook($personal)
	{
		$sql = "SELECT c.* FROM tbl_look a, tbl_look_has_producto b, tbl_producto c where a.user_id =".$personal." and c.id = b.producto_id and a.id = b.look_id group by b.producto_id order by a.created_on DESC";
		
		$sql2 = "SELECT count( distinct b.producto_id ) as total FROM tbl_look a, tbl_look_has_producto b, tbl_producto c where a.user_id =".$personal." and c.id = b.producto_id and a.id = b.look_id order by a.created_on DESC";
		$num = Yii::app()->db->createCommand($sql2)->queryScalar();
		$count = $num;	
		
		return new CSqlDataProvider($sql, array(
		    'totalItemCount'=>$count,
			 'pagination'=>array(
				'pageSize'=>9,
			),		    

		));  
	
	}
	

	public function nueva($todos)
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('t.nombre',$this->nombre,true);
		$criteria->compare('t.estado',$this->estado,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('marca_id',$this->marca_id,true);
		$criteria->compare('fInicio',$this->fInicio,true);
		$criteria->compare('fFin',$this->fFin,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('destacado',$this->destacado,true);
		$criteria->compare('peso',$this->peso,true);
		$criteria->with = array('categorias');
		$criteria->with = array('precios');
		$criteria->join ='JOIN tbl_imagen ON tbl_imagen.tbl_producto_id = t.id JOIN tbl_precioTallaColor ON tbl_precioTallaColor.producto_id = t.id';
		
		if(is_array($todos)) // si la variable es un array, viene de una accion de filtrado
		{
			if(empty($todos)) // si no tiene hijos devuelve un array vacio por lo que debe buscar por el id de la categoria
			{
				$criteria->compare('tbl_categoria_id',$this->categoria_id);
			}
			else // si tienes hijos
				{
					$criteria->addInCondition("tbl_categoria_id",$todos);
				}		
		}else if($todos=="a")
		{
				$criteria->compare('tbl_categoria_id',$this->categoria_id);
		}

		$criteria->addCondition('precioDescuento != ""');
		$criteria->addCondition('orden = 1');
		$criteria->addCondition('cantidad > 0');
		
		// $criteria->order = "t.id ASC";
		$criteria->order = "fecha DESC";
		
		$criteria->together = true;
		
		return new CActiveDataProvider($this, array(
       'pagination'=>array('pageSize'=>12,),
       'criteria'=>$criteria,
	));
		
	}
	/**
	 * Mas vendidos
	 */
	 public function masvendidos($limit=10)
	 {
			
		//$sql ="SELECT SUM(tbl_orden_has_productotallacolor.cantidad) as productos,producto_id FROM db_personaling.tbl_orden_has_productotallacolor left join tbl_precioTallaColor on tbl_orden_has_productotallacolor.preciotallacolor_id = tbl_precioTallaColor.id GROUP BY producto_id ORDER by productos DESC";
		$sql = "SELECT SUM(tbl_orden_has_productotallacolor.cantidad) as productos,producto_id FROM tbl_orden_has_productotallacolor left join tbl_precioTallaColor on tbl_orden_has_productotallacolor.preciotallacolor_id = tbl_precioTallaColor.id left join tbl_imagen on tbl_precioTallaColor.producto_id = tbl_imagen.tbl_producto_id left join tbl_producto on tbl_producto.id = tbl_precioTallaColor.producto_id where tbl_imagen.orden = 1 and tbl_producto.status = 1 and tbl_producto.estado = 0 GROUP BY producto_id ORDER by productos DESC";
		//if (isset($limit))
		//	$sql.=" LIMIT 0,$limit";
		//$sql ="SELECT count(distinct tbl_orden_id) as looks,look_id FROM tbl_orden_has_productotallacolor where look_id != 0 group by look_id order by  count(distinct tbl_orden_id) DESC;";
		$count = 10; 	
		return new CSqlDataProvider($sql, array(
		    'totalItemCount'=>$count,
			 'pagination'=>array(
				'pageSize'=>$limit,
			),		    

		));  
	 }

         /**
	 * Productos que encantan a un usuario $userId
	 */
	 public function produtosEncantan($userId)
	 {
		$criteria=new CDbCriteria;  

		$criteria->join = "JOIN tbl_userEncantan pe on pe.user_id = :userID and pe.producto_id = id";
                $criteria->params = array(":userID" => $userId);		
		
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
				'pageSize'=>9,
			),
		));             
             
		
	 }
         
         /**
         * Buscar por todos los filtros dados en el array $filters
         */
        public function buscarPorFiltros($filters) {
//            echo "<pre>";
//            print_r($filters);
//            echo "</pre>";
//            Yii::app()->end();

            $criteria = new CDbCriteria;
            $joinPagos = '';
            $joinUsers = '';
            $joinLooks = '';
            $havingLooks = '';
            $joinLooks = '';
            $havingLooks = '';
            $criteria->with = array();
            $criteria->select = array();
            $criteria->select[] = "t.*";
            for ($i = 0; $i < count($filters['fields']); $i++) {
                
                $column = $filters['fields'][$i];
                $value = $filters['vals'][$i];
                $comparator = $filters['ops'][$i];
                
                if($i == 0){
                   $logicOp = 'AND'; 
                }else{                
                    $logicOp = $filters['rels'][$i-1];                
                }                
                
                if($column == 'fecha'){
                    $value = strtotime($value);
                    $value = date('Y-m-d H:i:s', $value);
                }
                
                if($column == 'looks'){
                    
                   if (!strpos($joinLooks, 'tbl_orden_has_productotallacolor')) {
                        $joinLooks .= ' JOIN tbl_orden_has_productotallacolor as oprod ON oprod.tbl_orden_id = t.id AND oprod.look_id > 0';
                        $criteria->group = 't.id';
                        $havingLooks .= 'count(oprod.tbl_orden_id) '.$comparator.' '.$value.'';
                   }else{
                        $havingLooks .= ' '.$logicOp.' count(oprod.tbl_orden_id) '.$comparator.' '.$value.'';
                   }  
                                      
                   continue;
                }
                
                if($column == 'prendas'){
                   
                   if (!strpos($joinLooks, 'tbl_orden_has_productotallacolor')) {
                        $joinLooks .= ' JOIN tbl_orden_has_productotallacolor as oprod ON oprod.tbl_orden_id = t.id AND oprod.look_id = 0';
                        $criteria->group = 't.id';
                        $havingLooks .= 'count(oprod.tbl_orden_id) '.$comparator.' '.$value.'';
                   }else{
                        $havingLooks .= ' '.$logicOp.' count(oprod.tbl_orden_id) '.$comparator.' '.$value.'';
                   }   
                   
                    continue;
                }
                
                if($column == 'pago_id'){                
                   
                    if (!strpos($joinPagos, 'tbl_pago')) {
                        $joinPagos .= ' JOIN tbl_pago on tbl_pago.id = pago_id AND ( tbl_pago.tipo '.$comparator.' '.$value.' )';
                    }else{
                        $joinPagos = str_replace(")", $logicOp.' tbl_pago.tipo '.$comparator.' '.$value.' )', $joinPagos) ; 
                    }           
                    
                    continue;
                }
                
                if($column == 'user_id'){
                    
                    $rest = ($comparator == '=') ? "= '".$value."'" : "LIKE '%".$value."%'";
                    
                    if (!strpos($joinUsers, 'tbl_users')) {
                        $joinUsers .= ' JOIN tbl_users on tbl_users.id = user_id AND ( tbl_users.username '.$rest.' )';
                    }else{
                        $joinUsers = str_replace(")", $logicOp.' tbl_users.username '.$rest.' )', $joinUsers) ; 
                    }  
                    
                    continue;
                }
                
                if($column == 'codigo'){
                    $value = ($comparator == '=') ? "=".$value."" : $value;
                    
                    $criteria->compare($column, $value,
                        true, $logicOp);
                    
                    continue;
                }
                
                if($column == 'categoria')
                {
                    
                    $value = ($comparator == '=') ? "=".$value."" : $value;
                    
                    $criteria->compare('categorias.nombre', $value,
                        true, $logicOp);
                    
                    if(!in_array('categorias', $criteria->with))
                    {
                        $criteria->with[] = 'categorias';
                    }
                    
                    continue;
                }
                
                if($column == 'sku')
                {
                    
                    $value = ($comparator == '=') ? "=".$value."" : $value;
                    
                    $criteria->compare('preciotallacolor.sku', $value,
                        true, $logicOp);
                    
                    if(!in_array('preciotallacolor', $criteria->with))
                    {
                        $criteria->with[] = 'preciotallacolor';
                    }
                   
                    
                    continue;
                }
                
                if($column == 'precios'){
                    
                    $criteria->compare('precios.precioVenta', $comparator." ".$value,
                        false, $logicOp);
                    
                    if(!in_array('precios', $criteria->with))
                    {
                        $criteria->with[] = 'precios';
                    }
                    
                    continue;
                }
                
                if($column == 'total'){
                    
//                    $criteria->compare('preciotallacolorSum.total', $comparator." ".$value,
//                        false, $logicOp);
                    
                    if(!in_array('preciotallacolor', $criteria->with))
                    {
                        $criteria->with[] = 'preciotallacolor';
                    }
                    
                    if(!in_array('SUM(preciotallacolor.cantidad) as total', $criteria->select))
                    {
                        $criteria->select[] = 'SUM(preciotallacolor.cantidad) as total';
                        $criteria->having .= "total ".$comparator." ".$value;
                        //$criteria->compare('total', $comparator.$value);
                               
                        $criteria->group .= "t.id";
                    }
                    
                    
                    
                    continue;
                }
                
                
                
                $criteria->compare("t.".$column, $comparator." ".$value,
                        false, $logicOp);
                
            }
                                   
            
            //$criteria->select = array('t.*', 'SUM(preciotallacolor.cantidad) as total');
            $criteria->join .= $joinPagos;
            $criteria->join .= $joinUsers;
            $criteria->join .= $joinLooks;
            $criteria->having .= $havingLooks;  
            //$criteria->with = array('categorias', 'preciotallacolor', 'precios');
            $criteria->together = true;
            $criteria->compare('t.status', '1'); //siempre los no eliminados
            
//            echo "Criteria:";
//            
//            echo "<pre>";
//            print_r($criteria->toArray());
//            echo "</pre>"; 
//            exit();


            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
       }

         
}