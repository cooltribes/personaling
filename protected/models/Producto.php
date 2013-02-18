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
 */
class Producto extends CActiveRecord
{
	const zara='Zara';
	const bershka='Bershka';
	const mango='Mango';
	// const a='Zara';
	
	public $horaInicio="";
	public $horaFin="";
	
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
			array('nombre', 'length', 'max'=>50),
			array('proveedor', 'length', 'max'=>45),
			array('descripcion, fInicio, fFin,horaInicio,horaFin', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, codigo, nombre, estado, descripcion, proveedor, fInicio, fFin,horaInicio,horaFin', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'codigo' => 'SKU / Codigo',
			'nombre' => 'Nombre / Titulo',
			'estado' => 'Estado',
			'descripcion' => 'Descripcion',
			'proveedor' => 'Marca / Proveedor',
			'fInicio' => 'Inicio',
			'fFin' => 'Fin',
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	public function beforeSave()
	{
		/*if(parent::beforeSave())
		{
		*/	
		$producto->attributes=$_POST['Producto'];
			
		$this->fInicio=Yii::app()->dateformatter->format("yyyy-MM-dd",$this->fInicio);	
		$this->fFin=Yii::app()->dateformatter->format("yyyy-MM-dd",$this->fFin);
		
		//$this->horaInicio = $producto->horaInicio."".$producto->minInicio;
		
		$this->horaInicio = substr($this->horaInicio, 0, 5); 
		$this->horaFin = substr($this->horaFin, 0, 5);
		
		$this->fInicio= $this->fInicio.' '.$this->horaInicio.':00';
		$this->fFin = $this->fFin.' '.$this->horaFin.':00';
		
		echo ("inicio ".$this->horaInicio);
		echo ("<br>fin".$this->horaFin);
		
		echo ($this->fInicio);
		echo ($this->fFin);
		return parent::beforeSave();
		//exit;
		
		/*
		parent::beforeSave();
			
		return true;
		}
		else {
			return false;
		}
		*/
	}

}