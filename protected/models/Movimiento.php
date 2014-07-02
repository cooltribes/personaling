<?php

/**
 * This is the model class for table "{{movimiento}}".
 *
 * The followings are the available columns in table '{{movimiento}}':
 * @property integer $id
 * @property double $total
 * @property string $fecha
 * @property integer $user_id
 * @property string $comentario
 * @property integer $egreso
 */
class Movimiento extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Movimiento the static model class
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
		return '{{movimiento}}';
	}
  
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id, egreso', 'numerical', 'integerOnly'=>true),
			array('total', 'numerical'),
			array('comentario', 'length', 'max'=>250),
			array('fecha', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, total, fecha, user_id, comentario, egreso', 'safe', 'on'=>'search'),
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

			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'mptcs' => array(self::HAS_MANY, 'Movimientohaspreciotallacolor','movimiento_id'),
		
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'total' => 'Total',
			'fecha' => 'Fecha',
			'user_id' => 'User',
			'comentario' => 'Comentario',
			'egreso' => 'Egreso',
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
		$criteria->compare('total',$this->total);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('egreso',$this->egreso);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getEgresados($movid){
		$sql="select sum(cantidad) from tbl_movimiento_has_preciotallacolor where movimiento_id = ".$movid;
			$cant=Yii::app()->db->createCommand($sql)->queryScalar();
		if(is_null($cant))
			return 0;
		else
			return $cant;
		
	}
	public function getTypes($id=null)
	{
		$types=array("por Mercadeo","por Devolucion");
		if(is_null($id)||$id>=count($types))
			return $types;
		else
			return $types[$id];
	}
}  