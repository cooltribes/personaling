<?php

/**
 * This is the model class for table "{{orden}}".
 *
 * The followings are the available columns in table '{{orden}}':
 * @property integer $id
 * @property double $subtotal
 * @property double $descuento
 * @property double $envio
 * @property double $iva
 * @property double $descuentoRegalo
 * @property double $total
 * @property integer $estado
 * @property integer $bolsa_id
 * @property integer $user_id
 * @property integer $pago_id
 * @property integer $detalle_id
 * @property integer $direccionEnvio_id
 *
 * The followings are the available model relations:
 * @property DireccionEnvio $direccionEnvio
 * @property Pago $pago
 * @property Pago $detalle
 * @property Producto[] $tblProductos
 */
class Orden extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Orden the static model class
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
		return '{{orden}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bolsa_id, user_id, pago_id, detalle_id, direccionEnvio_id', 'required'),
			array('estado, bolsa_id, user_id, pago_id, detalle_id, direccionEnvio_id', 'numerical', 'integerOnly'=>true),
			array('subtotal, descuento, envio, iva, descuentoRegalo, total', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subtotal, descuento, envio, iva, descuentoRegalo, total, estado, bolsa_id, user_id, pago_id, detalle_id, direccionEnvio_id', 'safe', 'on'=>'search'),
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
			'direccionEnvio' => array(self::BELONGS_TO, 'DireccionEnvio', 'direccionEnvio_id'),
			'pago' => array(self::BELONGS_TO, 'Pago', 'pago_id'),
			'detalle' => array(self::BELONGS_TO, 'Pago', 'detalle_id'),
			'tblProductos' => array(self::MANY_MANY, 'Producto', '{{orden_has_tbl_producto}}(tbl_orden_id, tbl_producto_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'subtotal' => 'Subtotal',
			'descuento' => 'Descuento',
			'envio' => 'Envio',
			'iva' => 'Iva',
			'descuentoRegalo' => 'Descuento Regalo',
			'total' => 'Total',
			'estado' => 'Estado',
			'bolsa_id' => 'Bolsa',
			'user_id' => 'User',
			'pago_id' => 'Pago',
			'detalle_id' => 'Detalle',
			'direccionEnvio_id' => 'Direccion Envio',
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
		$criteria->compare('subtotal',$this->subtotal);
		$criteria->compare('descuento',$this->descuento);
		$criteria->compare('envio',$this->envio);
		$criteria->compare('iva',$this->iva);
		$criteria->compare('descuentoRegalo',$this->descuentoRegalo);
		$criteria->compare('total',$this->total);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('bolsa_id',$this->bolsa_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('pago_id',$this->pago_id);
		$criteria->compare('detalle_id',$this->detalle_id);
		$criteria->compare('direccionEnvio_id',$this->direccionEnvio_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}