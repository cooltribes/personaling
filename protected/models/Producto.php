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
	const zara='Zara';
	const bershka='Bershka';
	const mango='Mango';
	// const a='Zara';
	
	public $horaInicio="";
	public $horaFin="";
	public $minInicio="";
	public $minFin="";
	public $uno="";
	public $dos="";
	
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
			array('descripcion, fInicio, fFin,horaInicio, horaFin, minInicio, minFin, fecha, status', 'safe'),
			//array('fInicio','compare','compareValue'=>date("Y-m-d"),'operator'=>'=>'),
			array('fInicio','compare','compareValue'=>date("Y-m-d"),'operator'=>'>=','allowEmpty'=>true, 'message'=>'La fecha de inicio debe ser mayor al dia de hoy.'),
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


	public function beforeSave()
	{

			
		if(!$this->fInicio && !$this->fFin)
		{
			$this->fInicio = "";
			$this->fFin = "";
			
			$this->fecha = date("Y-m-d");
			
			if(!$this->estado)
				$this->estado = 1;
			
			return parent::beforeSave();
		}
		else {

			if(!$this->estado)
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