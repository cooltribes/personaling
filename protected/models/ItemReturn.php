<?php

/**
 * This is the model class for table "{{itemReturn}}".
 *
 * The followings are the available columns in table '{{itemReturn}}':
 * @property integer $id
 * @property integer $return_id
 * @property integer $devolucionhaspreciotallacolor_id
 * @property integer $cantidad
 * @property integer $cantidadConfirmation
 * @property string $sku
 */
class ItemReturn extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ItemReturn the static model class
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
		return '{{itemReturn}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('return_id', 'required'),
			array('return_id, devolucionhaspreciotallacolor_id, cantidad, cantidadConfirmation', 'numerical', 'integerOnly'=>true),
			array('sku', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, return_id, devolucionhaspreciotallacolor_id, cantidad, cantidadConfirmation, sku', 'safe', 'on'=>'search'),
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
			'dhptc' => array(self::BELONGS_TO, 'Devolucionhaspreciotallacolor', 'devolucionhaspreciotallacolor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'return_id' => 'Return',
			'devolucionhaspreciotallacolor_id' => 'Devolucionhaspreciotallacolor',
			'cantidad' => 'Cantidad',
			'cantidadConfirmation' => 'Cantidad Confirmation',
			'sku' => 'Sku',
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
		$criteria->compare('return_id',$this->return_id);
		$criteria->compare('devolucionhaspreciotallacolor_id',$this->devolucionhaspreciotallacolor_id);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('cantidadConfirmation',$this->cantidadConfirmation);
		$criteria->compare('sku',$this->sku,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}