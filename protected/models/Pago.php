<?php

/*
 * Tipo 
 * 1- Deposito o Transferencia
 * 2- Tarjeta de Credito
 * 4- MercadoPago
 */ 
 
/**
 * This is the model class for table "{{pago}}".
 *
 * The followings are the available columns in table '{{pago}}':
 * @property integer $id
 * @property integer $tipo
 * @property integer $tbl_detalle_id
 *
 * The followings are the available model relations:
 * @property Orden[] $ordens
 * @property Orden[] $ordens1
 * @property Detalle $tblDetalle
 */
class Pago extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pago the static model class
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
		return '{{pago}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tbl_detalle_id', 'required'),
			array('tipo, tbl_detalle_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tipo, tbl_detalle_id', 'safe', 'on'=>'search'),
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
			'ordens' => array(self::HAS_MANY, 'Orden', 'pago_id'),
			'ordens1' => array(self::HAS_MANY, 'Orden', 'detalle_id'),
			'tblDetalle' => array(self::BELONGS_TO, 'Detalle', 'tbl_detalle_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tipo' => 'Tipo',
			'tbl_detalle_id' => 'Tbl Detalle',
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
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('tbl_detalle_id',$this->tbl_detalle_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}