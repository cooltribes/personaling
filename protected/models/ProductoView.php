<?php

/**
 * This is the model class for table "{{producto_view}}".
 *
 * The followings are the available columns in table '{{producto_view}}':
 * @property integer $id
 * @property integer $producto_id
 * @property string $created_on
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Producto $producto
 * @property Users $user
 */
class ProductoView extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductoView the static model class
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
		return '{{producto_view}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_on','default',
              'value'=>new CDbExpression('NOW()'),
              'setOnEmpty'=>false,'on'=>'insert'),
			array('producto_id, created_on, user_id', 'required'),
			array('producto_id, user_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, producto_id, created_on, user_id', 'safe', 'on'=>'search'),

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
			'producto_id' => 'Producto',
			'created_on' => 'Created On',
			'user_id' => 'User',
		);
	}
	public function lastView($limit = 2)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		 //$criteria->limit = $limit; 
		 $criteria->compare('user_id',$this->user_id);
		 $criteria->distinct = true;
		 $criteria->select = 'user_id,producto_id';
		 $criteria->order = 'created_on DESC';
		 //$criteria->offset = 0;
		 //$criteria->limit = 2; 
		 //$criteria->pagination = false;

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
                        'pageSize'=>$limit,
                ),
			'criteria'=>$criteria,
			
		));
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
		$criteria->compare('producto_id',$this->producto_id);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}