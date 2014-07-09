<?php

/**
 * This is the model class for table "{{devolucion_has_preciotallacolor}}".
 *
 * The followings are the available columns in table '{{devolucion_has_preciotallacolor}}':
 * @property integer $id
 * @property integer $preciotallacolor_id
 * @property integer $cantidad
 * @property string $motivo
 * @property double $monto
 * @property integer $devolucion_id
 * @property integer $look_id
 * @property integer $rechazado
 * @property string $motivoAdmin
 */
class Devolucionhaspreciotallacolor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Devolucionhaspreciotallacolor the static model class
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
		return '{{devolucion_has_preciotallacolor}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('preciotallacolor_id, cantidad, devolucion_id, look_id, rechazado', 'numerical', 'integerOnly'=>true),
			array('monto', 'numerical'),
			array('motivo, motivoAdmin', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, preciotallacolor_id, cantidad, motivo, monto, devolucion_id, look_id, rechazado, motivoAdmin', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'preciotallacolor_id' => 'Preciotallacolor',
			'cantidad' => 'Cantidad',
			'motivo' => 'Motivo',
			'monto' => 'Monto',
			'devolucion_id' => 'Devolucion',
			'look_id' => 'Look',
			'rechazado' => 'Rechazado',
			'motivoAdmin' => 'Motivo Admin',
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
		$criteria->compare('preciotallacolor_id',$this->preciotallacolor_id);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('motivo',$this->motivo,true);
		$criteria->compare('monto',$this->monto);
		$criteria->compare('devolucion_id',$this->devolucion_id);
		$criteria->compare('look_id',$this->look_id);
		$criteria->compare('rechazado',$this->rechazado);
		$criteria->compare('motivoAdmin',$this->motivoAdmin,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function isValid($cantidad, $ptc, $orden){
		$sql="select sum(cantidad) from tbl_devolucion_has_preciotallacolor where devolucion_id IN (select id from tbl_devolucion where orden_id = ".$orden.") and preciotallacolor_id = ".$ptc;
		$devolucion=Yii::app()->db->createCommand($sql)->queryScalar();
		$compra=OrdenHasProductotallacolor::model()->findByAttributes(array('preciotallacolor_id'=>$ptc,'tbl_orden_id'=>$orden));
		if($compra>=$devolucion)
			return true;
		else
			return false;
		
	}
	public function getxDevolucion($id){
			
		$sql="select * from tbl_devolucion_has_preciotallacolor where devolucion_id=".$id;	
		$looks=Yii::app()->db->createCommand($sql)->queryAll();
		return $looks;
	}
}