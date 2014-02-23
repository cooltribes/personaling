<?php

/**
 * This is the model class for table "{{shopping_metric}}".
 *
 * The followings are the available columns in table '{{shopping_metric}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $step
 * @property string $created_on
 * @property integer $tipo_compra
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class ShoppingMetric extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ShoppingMetric the static model class
	 */
	const STEP_BOLSA = 0;
	const STEP_LOGIN = 1; 
	const STEP_DIRECCIONES = 2; 
	const STEP_PAGO = 3;
	const STEP_CONFIRMAR = 4; 
	const STEP_PEDIDO = 5; 
        
        /*TIPOS DE COMPRA*/
	const TIPO_TIENDA = 0; 
	const TIPO_GIFTCARD = 1; 
        
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{shopping_metric}}';
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
			array('user_id, step, created_on, tipo_compra', 'required'),
			array('user_id, step, tipo_compra', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, step, created_on, tipo_compra', 'safe', 'on'=>'search'),
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
			'step' => 'Step',
			'created_on' => 'Created On',
			'tipo_compra' => 'Tipo de compra',
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
		$criteria->compare('step',$this->step);
		$criteria->compare('tipo_compra',$this->step);
		$criteria->compare('created_on',$this->created_on,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}