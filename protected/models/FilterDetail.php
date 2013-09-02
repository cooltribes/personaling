<?php

/**
 * This is the model class for table "{{filter_detail}}".
 *
 * The followings are the available columns in table '{{filter_detail}}':
 * @property integer $id_filter_detail
 * @property integer $id_filter
 * @property string $column
 * @property string $operator
 * @property string $value
 * @property string $relation
 *
 * The followings are the available model relations:
 * @property Filter $idFilter
 */
class FilterDetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FilterDetail the static model class
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
		return '{{filter_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_filter, column, operator, value', 'required'),
			array('id_filter', 'numerical', 'integerOnly'=>true),
			array('column', 'length', 'max'=>50),
			array('operator', 'length', 'max'=>32),
			array('value', 'length', 'max'=>64),
			array('relation', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_filter_detail, id_filter, column, operator, value, relation', 'safe', 'on'=>'search'),
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
			'idFilter' => array(self::BELONGS_TO, 'Filter', 'id_filter'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_filter_detail' => 'Id Filter Detail',
			'id_filter' => 'Id Filter',
			'column' => 'Column',
			'operator' => 'Operator',
			'value' => 'Value',
			'relation' => 'Relation',
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

		$criteria->compare('id_filter_detail',$this->id_filter_detail);
		$criteria->compare('id_filter',$this->id_filter);
		$criteria->compare('column',$this->column,true);
		$criteria->compare('operator',$this->operator,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('relation',$this->relation,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}