<?php

/**
 * This is the model class for table "{{movimiento_has_preciotallacolor}}".
 *
 * The followings are the available columns in table '{{movimiento_has_preciotallacolor}}':
 * @property integer $id
 * @property integer $movimiento_id
 * @property integer $preciotallacolor_id
 * @property integer $cantidad
 * @property double $costo
 */
class Movimientohaspreciotallacolor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Movimientohaspreciotallacolor the static model class
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
		return '{{movimiento_has_preciotallacolor}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('movimiento_id, preciotallacolor_id, cantidad', 'required'),
			array('movimiento_id, preciotallacolor_id, cantidad', 'numerical', 'integerOnly'=>true),
			array('costo', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, movimiento_id, preciotallacolor_id, cantidad, costo', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'movimiento_id' => 'Movimiento',
			'preciotallacolor_id' => 'Preciotallacolor',
			'cantidad' => 'Cantidad',
			'costo' => 'Costo',
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
		$criteria->compare('movimiento_id',$this->movimiento_id);
		$criteria->compare('preciotallacolor_id',$this->preciotallacolor_id);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('costo',$this->costo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getxMovimiento($id){
			
		$sql="select * from tbl_movimiento_has_preciotallacolor where movimiento_id=".$id;	
		$looks=Yii::app()->db->createCommand($sql)->queryAll();
		return $looks;
	}
}