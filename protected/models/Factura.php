<?php

/**
 * This is the model class for table "{{factura}}".
 *
 * The followings are the available columns in table '{{factura}}':
 * @property integer $id
 * @property string $fecha
 * @property integer $direccion_fiscal_id
 * @property integer $direccion_envio_id
 * @property integer $estado
 * @property integer $orden_id
 *
 * The followings are the available model relations:
 * @property Direccion $direccionFiscal
 * @property Direccion $direccionEnvio
 * @property Orden $orden
 * 
 * Estado:
 * 1: Pendiente
 * 2: Pagada
 * 
 */
 
 
 
 
 
class Factura extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Factura the static model class
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
		return '{{factura}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, direccion_fiscal_id, direccion_envio_id, orden_id', 'required'),
			array('direccion_fiscal_id, direccion_envio_id, estado, orden_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fecha, direccion_fiscal_id, direccion_envio_id, estado, orden_id', 'safe', 'on'=>'search'),
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
			'direccionFiscal' => array(self::BELONGS_TO, 'Direccion', 'direccion_fiscal_id'),
			'direccionEnvio' => array(self::BELONGS_TO, 'Direccion', 'direccion_envio_id'),
			'orden' => array(self::BELONGS_TO, 'Orden', 'orden_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fecha' => 'Fecha',
			'direccion_fiscal_id' => 'Direccion Fiscal',
			'direccion_envio_id' => 'Direccion Envio',
			'estado' => 'Estado',
			'orden_id' => 'Orden',
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
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('direccion_fiscal_id',$this->direccion_fiscal_id);
		$criteria->compare('direccion_envio_id',$this->direccion_envio_id);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('orden_id',$this->orden_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}