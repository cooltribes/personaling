<?php

/**
 * This is the model class for table "{{orden_has_productotallacolor}}".
 *
 * The followings are the available columns in table '{{orden_has_productotallacolor}}':
 * @property integer $tbl_orden_id
 * @property integer $preciotallacolor_id
 * @property integer $cantidad
 * @property integer $look_id
 * @property double $precio
 * 
 * The followings are the available model relations:
 * @property PrecioTallaColor $preciotallacolor
 */
class OrdenHasProductotallacolor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrdenHasProductotallacolor the static model class
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
		return '{{orden_has_productotallacolor}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tbl_orden_id, preciotallacolor_id, cantidad', 'required'),
			array('tbl_orden_id, preciotallacolor_id, cantidad, look_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('tbl_orden_id, preciotallacolor_id, cantidad, look_id, precio', 'safe', 'on'=>'search'),
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
			'preciotallacolor' => array(self::BELONGS_TO, 'Preciotallacolor', 'preciotallacolor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tbl_orden_id' => 'Tbl Orden',
			'preciotallacolor_id' => 'Preciotallacolor',
			'cantidad' => 'Cantidad',
			'look_id' => 'Look',
			'precio' => 'Precio',
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

		$criteria->compare('tbl_orden_id',$this->tbl_orden_id);
		$criteria->compare('preciotallacolor_id',$this->preciotallacolor_id);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('look_id',$this->look_id);
		$criteria->compare('precio',$this->precio);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function countLooks($id){
			
		$sql="select count(distinct(look_id)) as counter  from tbl_orden_has_productotallacolor where tbl_orden_id=".$id." and look_id<>0";	
		$looks=Yii::app()->db->createCommand($sql)->queryAll();
		return $looks[0]['counter'];
	} 
	
	public function countIndividuales($id){
			
		$sql="select count(preciotallacolor_id) as counter from tbl_orden_has_productotallacolor where tbl_orden_id=".$id." and look_id=0";	
		$pr=Yii::app()->db->createCommand($sql)->queryAll();
		return $pr[0]['counter'];
	}
	
	public function getByLook($id, $look){
			
		$sql="select * from tbl_orden_has_productotallacolor where tbl_orden_id=".$id." and look_id=".$look;	
		$looks=Yii::app()->db->createCommand($sql)->queryAll();
		return $looks;
	}
	 
	public function getLooks($id){
			
		$sql="select distinct(look_id) from tbl_orden_has_productotallacolor where tbl_orden_id=".$id." and look_id<>0";	
		$looks=Yii::app()->db->createCommand($sql)->queryAll();
		return $looks;
	}
	public function getIndividuales($id){
			
		$sql="select * from tbl_orden_has_productotallacolor where tbl_orden_id=".$id." and look_id = 0";	
		$looks=Yii::app()->db->createCommand($sql)->queryAll();
		return $looks;
	}
	
		public function precioLook($id, $look){
			
		$sql="select precio from tbl_orden_has_productotallacolor where tbl_orden_id=".$id." and look_id=".$look." limit 0,1";	
		$looks=Yii::app()->db->createCommand($sql)->queryAll();
		return $looks[0]['precio'];
		
	}
	 	
	
}