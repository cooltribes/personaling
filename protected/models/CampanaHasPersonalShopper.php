<?php

/**
 * This is the model class for table "{{campana_has_personal_shopper}}".
 *
 * The followings are the available columns in table '{{campana_has_personal_shopper}}':
 * @property integer $campana_id
 * @property integer $user_id
 * @property string $fecha_invitacion
 */
class CampanaHasPersonalShopper extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CampanaHasPersonalShopper the static model class
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
		return '{{campana_has_personal_shopper}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('campana_id, user_id', 'required'),
			array('campana_id, user_id', 'numerical', 'integerOnly'=>true),
			array('fecha_invitacion', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('campana_id, user_id, fecha_invitacion', 'safe', 'on'=>'search'),
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
			'campana_id' => 'Campana',
			'user_id' => 'User',
			'fecha_invitacion' => 'Fecha Invitacion',
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

		$criteria->compare('campana_id',$this->campana_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('fecha_invitacion',$this->fecha_invitacion,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}