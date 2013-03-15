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
	
	
	public $horaInicio="";
	public $horaFin="";
	public $minInicio="";
	public $minFin="";
	public $uno="";
	public $dos="";
	public $categoria_id="";
	
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
			'imagenes' => array(self::HAS_MANY, 'Imagen', 'tbl_producto_id','order' => 'k.orden ASC', 'alias' => 'k'),
			'precios' => array(self::HAS_MANY, 'Precio', 'tbl_producto_id'),
			'inventario' => array(self::HAS_ONE, 'Inventario', 'tbl_producto_id'),
			'preciotallacolor' => array(self::HAS_MANY,'Preciotallacolor','producto_id'),
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

	public function busqueda()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('t.nombre',$this->nombre,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('proveedor',$this->proveedor,true);
		$criteria->compare('fInicio',$this->fInicio,true);
		$criteria->compare('fFin',$this->fFin,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('status',$this->status,true);
		$criteria->with = array('categorias');
		
		/*
		$op=0;
		$hijos = array();
		$cat = Categoria::model()->findAllByAttributes(array('id'=>$this->categoria_id,));

		if(isset($cat)){
			$hijos = $this->hijos($cat,$op); 
		
			if($op==1){
				foreach($hijos as $hijo){
					$criteria->compare('tbl_categoria_id',$hijo->id);
				}
			}else if($op>=2){
				$criteria->compare('tbl_categoria_id',$this->categoria_id);
			}
		}*/
		
		$criteria->compare('tbl_categoria_id',$this->categoria_id);
		
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
		else {

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

}