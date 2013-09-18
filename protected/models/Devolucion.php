<?php

/**
 * This is the model class for table "{{devolucion}}".
 *
 * The followings are the available columns in table '{{devolucion}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $orden_id
 * @property integer $preciotallacolor_id
 * @property string $motivo
 * @property double $montodevuelto
 * @property double $montoenvio
 *
 * The followings are the available model relations:
 * @property Orden $orden
 * @property PrecioTallaColor $preciotallacolor
 * @property Users $user
 */
class Devolucion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Devolucion the static model class
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
		return '{{devolucion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, orden_id, preciotallacolor_id, motivo, montodevuelto, montoenvio', 'required'),
			array('user_id, orden_id, preciotallacolor_id', 'numerical', 'integerOnly'=>true),
			array('montodevuelto, montoenvio', 'numerical'),
			array('motivo', 'length', 'max'=>300),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, orden_id, preciotallacolor_id, motivo, montodevuelto, montoenvio', 'safe', 'on'=>'search'),
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
			'orden' => array(self::BELONGS_TO, 'Orden', 'orden_id'),
			'preciotallacolor' => array(self::BELONGS_TO, 'PrecioTallaColor', 'preciotallacolor_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'orden_id' => 'Orden',
			'preciotallacolor_id' => 'Preciotallacolor',
			'motivo' => 'Motivo',
			'montodevuelto' => 'Montodevuelto',
			'montoenvio' => 'Montoenvio',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('orden_id',$this->orden_id);
		$criteria->compare('preciotallacolor_id',$this->preciotallacolor_id);
		$criteria->compare('motivo',$this->motivo,true);
		$criteria->compare('montodevuelto',$this->montodevuelto);
		$criteria->compare('montoenvio',$this->montoenvio);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}