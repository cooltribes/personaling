<?php

/**
 * This is the model class for table "{{devolucion}}".
 *
 * The followings are the available columns in table '{{devolucion}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $orden_id
 * @property string $fecha
 * @property integer $estado
 * @property double $montodevuelto
 * @property double $montoenvio
 *
 * The followings are the available model relations:
 * @property Orden $orden
 * @property Users $user
 */
class Devolucion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Devolucion the static model class
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
		return '{{devolucion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, orden_id, fecha, estado, montodevuelto, montoenvio', 'required'),
			array('user_id, orden_id, estado', 'numerical', 'integerOnly'=>true),
			array('montodevuelto, montoenvio', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, orden_id, fecha, estado, montodevuelto, montoenvio', 'safe', 'on'=>'search'),
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
			'orden' => array(self::BELONGS_TO, 'Orden', 'orden_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'dptcs' => array(self::HAS_MANY, 'Devolucionhaspreciotallacolor','devolucion_id'),

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
			'orden_id' => 'Orden',
			'fecha' => 'Fecha',
			'estado' => 'Estado',
			'montodevuelto' => 'Montodevuelto',
			'montoenvio' => 'Montoenvio',
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
		$criteria->compare('orden_id',$this->orden_id);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('montodevuelto',$this->montodevuelto);
		$criteria->compare('montoenvio',$this->montoenvio);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	 
	public function getReasons($id = null){
		$reasons=array("No se parece a la imagen de la web",
							"Se ve de baja calidad  producto defectuoso",
							"No es mi talla","No me gusta como me queda la prenda",
							"El producto que he recibido esta equivocado",
							"He comprado mas de una talla");
		if(is_null($id))
			return $reasons; 
		else 
			return $reasons[$id];
	}
	public function getStatus($id = null){
		$statuses=array("Devolucion solicitada",
							"Notificado a Almacén",
							"Confirmado por Almacén",
							"Devolución Completada",
							"Devolución Rechazada por Administrador",
							"Devolución Aceptada por Administrador");
		if(is_null($id))
			return $statuses; 
		else 
			return $statuses[$id];
	}
	public function devueltosxOrden($orden,$ptcid,$lookid){
		$sql="select sum(cantidad) from tbl_devolucion_has_preciotallacolor dh 
		JOIN tbl_devolucion d  where dh.preciotallacolor_id=".$ptcid." 
		AND dh.look_id=".$lookid." AND d.orden_id=".$orden;
		$cant=Yii::app()->db->createCommand($sql)->queryScalar();
		if(is_null($cant))
			return 0;
		else
			return $cant;
		
	}
}