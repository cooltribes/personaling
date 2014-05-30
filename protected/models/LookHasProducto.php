<?php

/**
 * This is the model class for table "{{look_has_producto}}".
 *
 * The followings are the available columns in table '{{look_has_producto}}':
 * @property integer $look_id
 * @property integer $producto_id
 *  * * @property integer $left
 * * @property integer $top
 * * @property integer $width
 * * @property integer $height
 * * @property integer $angle
 * * @property integer $zindex
 *  * */
class LookHasProducto extends CActiveRecord
{
	/** 
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LookHasProducto the static model class
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
		return '{{look_has_producto}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('look_id, producto_id', 'required'),
			array('look_id, producto_id, top, left, width, height,angle,zindex', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('look_id, producto_id, top, left, width, height,angle,zindex', 'safe', 'on'=>'search'),
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
			'producto' => array(self::BELONGS_TO, 'Producto', 'producto_id'),
			//'precioNf' => array(self::STAT,'Producto','prooducto_id','select'=>'SUM(precioNf)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'look_id' => 'Look',
			'producto_id' => 'Producto',
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

		$criteria->compare('look_id',$this->look_id);
		$criteria->compare('producto_id',$this->producto_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}