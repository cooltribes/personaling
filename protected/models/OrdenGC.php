<?php

/*
 * Definicion de los estados de la orden por transferencia
 * 1 - En espera de pago
 * 2 - En espera de confirmación
 * 3 - Pago Confirmado
 * 4 - Enviado
 * 5 - Cancelado
 * 6 - Pago Rechazado
 * 7 - Pago insuficiente
 * 8 - Recibido
 * 9 - Devuelto
 * 10 - Parcialmente devuelto
 * 
 */

/**
 * This is the model class for table "{{ordenGC}}".
 *
 * The followings are the available columns in table '{{ordenGC}}':
 * @property integer $id
 * @property integer $estado
 * @property string $fecha
 * @property double $total
 * @property integer $user_id
 * @property integer $admin_id
 *
 * The followings are the available model relations:
 * @property DetallePago[] $detallePagos
 * @property Users $user
 * @property Users $admin
 */
class OrdenGC extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrdenGC the static model class
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
		return '{{ordenGC}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('estado, user_id, admin_id', 'numerical', 'integerOnly'=>true),
			array('total', 'numerical'),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, estado, fecha, total, user_id, admin_id', 'safe', 'on'=>'search'),
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
			'detallePagos' => array(self::HAS_MANY, 'DetallePago', 'orden_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'admin' => array(self::BELONGS_TO, 'Users', 'admin_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'estado' => 'Estado',
			'fecha' => 'Fecha',
			'total' => 'Total',
			'user_id' => 'User',
			'admin_id' => 'Admin',
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
		$criteria->compare('estado',$this->estado);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('total',$this->total);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('admin_id',$this->admin_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}