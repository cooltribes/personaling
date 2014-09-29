<?php

/**
 * This is the model class for table "{{affiliatePayment}}".
 *
 * The followings are the available columns in table '{{affiliatePayment}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $created_at
 * @property double $amount
 * @property integer $total_views
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property PayPersonalShopper[] $payPersonalShoppers
 */
class AffiliatePayment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AffiliatePayment the static model class
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
		return '{{affiliatePayment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, created_at, amount, total_views', 'required'),
			array('user_id, total_views', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, created_at, amount, total_views', 'safe', 'on'=>'search'),
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
			'payPersonalShoppers' => array(self::HAS_MANY, 'PayPersonalShopper', 'affiliatePay_id'),
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
			'created_at' => 'Created At',
			'amount' => 'Amount',
			'total_views' => 'Total Views',
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
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('total_views',$this->total_views);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * Method for retrieve the last payment to Personal Shoppers so we can
         * know from what date we need to compute the views and commissions.
         */
        
        public static function findLastPayment(){
            
            $payment = self::model()->find(array('order' => 'created_at DESC'));           
            
            return $payment ? $payment : null;
        }
        
        public function getAmount($format=true){
           
            return $format ? Yii::app()->numberFormatter->format("#,##0.00",$this->amount):
            $this->amount;            

        }
        
}