<?php

/**
 * This is the model class for table "{{producto}}".
 *
 * The followings are the available columns in table '{{producto}}':
 * @property integer $id
 * @property string $codigo
 * @property string $nombre
 * @property integer $estado
 * @property string $descripcion
 * @property string $proveedor
 * @property string $fInicio
 * @property string $fFin
 * @property string $fecha
 * @property integer $status
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
			array('estado', 'numerical', 'integerOnly'=>true),
			array('codigo', 'length', 'max'=>25),
			array('nombre', 'length', 'max'=>70),
			array('nombre, codigo', 'required'),
			array('proveedor', 'length', 'max'=>45),
			array('imagenes', 'required', 'on'=>'multi'),
			array('codigo', 'unique', 'message'=>'Código de producto ya registrado.'),
			array('descripcion, fInicio, fFin,horaInicio, horaFin, minInicio, minFin, fecha, status', 'safe'),
			//array('fInicio','compare','compareValue'=>date("Y-m-d"),'operator'=>'=>'),
			array('fInicio','compare','compareValue'=>date("m/d/Y"),'operator'=>'>=','allowEmpty'=>true, 'message'=>'La fecha de inicio debe ser mayor al dia de hoy.'),
			array('fFin','compare','compareAttribute'=>'fInicio','operator'=>'>', 'allowEmpty'=>true , 'message'=>'La fecha de fin debe ser mayor a la fecha de inicio.'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, codigo, nombre, estado, descripcion, proveedor, fInicio, fFin,horaInicio,horaFin,minInicio,minFin,fecha, status', 'safe', 'on'=>'search'),
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
		);
	}
 
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'codigo' => 'SKU / Código',
			'nombre' => 'Nombre / Titulo',
			'estado' => 'Estado',
			'descripcion' => 'Descripción',
			'proveedor' => 'Marca / Proveedor',
			'fInicio' => 'Inicio',
			'fFin' => 'Fin',
			'fecha' => 'Fecha',
			'status' => 'Status',
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
		$criteria->compare('proveedor',$this->proveedor,true);
		$criteria->compare('fInicio',$this->fInicio,true);
		$criteria->compare('fFin',$this->fFin,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function busqueda($todos)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('t.nombre',$this->nombre,true);
		$criteria->compare('t.estado',$this->estado,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('proveedor',$this->proveedor,true);
		$criteria->compare('fInicio',$this->fInicio,true);
		$criteria->compare('fFin',$this->fFin,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('status',$this->status,true);
		$criteria->with = array('categorias');
		
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
       'pagination'=>array('pageSize'=>12,),
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
	public function getImageUrl($color=null)
	{
			if (is_null($color)){
				if ($this->mainimage) return $this->mainimage->getUrl();
			}else{
				$imagecolor = $this->colorimage( array('condition'=>'color_id=:color_id','params' => array(':color_id'=>$color) ) ); 
				if ( isset( $imagecolor) ) return  $imagecolor->getUrl();
				elseif ($this->mainimage) return $this->mainimage->getUrl();
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
			$ptc = PrecioTallaColor::model()->findAllByAttributes(array('producto_id'=>$this->id));
		else
			$ptc = PrecioTallaColor::model()->findAllByAttributes(array('talla_id'=>$talla,'producto_id'=>$this->id));
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
$ptc = PrecioTallaColor::model()->findAllByAttributes(array('color_id'=>$color,'producto_id'=>$this->id));
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
		
 /*
		$criteria->compare('id',$this->id);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('proveedor',$this->proveedor,true);
		$criteria->compare('fInicio',$this->fInicio,true);
		$criteria->compare('fFin',$this->fFin,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('status',$this->status,true);
		$criteria->with = array('preciotallacolor');

		$criteria->compare('color_id',$idColor,true);

		$criteria->together = true;
 */

	
		
		return new CActiveDataProvider($this, array(
       'pagination'=>array('pageSize'=>12,),
       'criteria'=>$criteria,
	));
		
	}


}