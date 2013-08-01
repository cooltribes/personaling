<?php

/**
 * This is the model class for table "{{look_has_adorno}}".
 *
 * The followings are the available columns in table '{{look_has_adorno}}':
 * @property integer $id
 * @property integer $look_id
 * @property integer $adorno_id
 * @property integer $top
 * @property integer $left
 * @property integer $width
 * @property integer $height
 *
 * The followings are the available model relations:
 * @property Look $look
 * @property Adorno $adorno
 */ 
class LookHasAdorno extends CActiveRecord
{ 
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LookHasAdorno the static model class
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
		return '{{look_has_adorno}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('look_id, adorno_id, top, left, width, height', 'required'),
			array('look_id, adorno_id, top, left, width, height,angle,zindex', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, look_id, adorno_id, top, left, width, height,angle,zindex', 'safe', 'on'=>'search'),
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
			'look' => array(self::BELONGS_TO, 'Look', 'look_id'),
			'adorno' => array(self::BELONGS_TO, 'Adorno', 'adorno_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'look_id' => 'Look',
			'adorno_id' => 'Adorno',
			'top' => 'Top',
			'left' => 'Left',
			'width' => 'Width',
			'height' => 'Height',
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
		$criteria->compare('look_id',$this->look_id);
		$criteria->compare('adorno_id',$this->adorno_id);
		$criteria->compare('top',$this->top);
		$criteria->compare('left',$this->left);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}