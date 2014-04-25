<?php

/**
 * This is the model class for table "{{bolsaGC}}".
 *
 * The followings are the available columns in table '{{bolsaGC}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $monto
 * @property string $plantilla_url
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class BolsaGC extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BolsaGC the static model class
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
		return '{{bolsaGC}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, monto', 'required'),
			array('user_id, monto', 'numerical', 'integerOnly'=>true),
			array('plantilla_url', 'length', 'max'=>255),
                        array('monto', 'numerical', 'max' => Giftcard::getMontoMaximo()),
                    
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, monto, plantilla_url', 'safe', 'on'=>'search'),
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
			'monto' => 'Monto',
			'plantilla_url' => 'Plantilla Url',
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

		
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('monto',$this->monto);
		$criteria->compare('plantilla_url',$this->plantilla_url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}