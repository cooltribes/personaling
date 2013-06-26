<?php

/**
 * This is the model class for table "{{campana}}".
 *
 * The followings are the available columns in table '{{campana}}':
 * @property integer $id
 * @property string $nombre
 * @property string $recepcion_inicio
 * @property string $recepcion_fin
 * @property string $ventas_inicio
 * @property string $ventas_fin
 * @property string $fecha_creacion
 * @property integer $estado
 */
class Campana extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Campana the static model class
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
		return '{{campana}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, recepcion_inicio, recepcion_fin, ventas_inicio, ventas_fin, fecha_creacion', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>50),
			array( 'recepcion_inicio','compare','compareValue' => date("Y-m-d H:i:s"),'operator'=>'>', 'allowEmpty'=>'false', 'message' => '{attribute} debe ser mayor que la fecha actual.'),
			array( 'recepcion_fin','compare','compareAttribute' => 'recepcion_inicio','operator'=>'>', 'allowEmpty'=>'false', 'message' => '{attribute} debe ser mayor que {compareAttribute}.'),
			array( 'ventas_inicio','compare','compareAttribute' => 'recepcion_fin','operator'=>'>', 'allowEmpty'=>'false', 'message' => '{attribute} debe ser mayor que {compareAttribute}.'),
			array( 'ventas_fin','compare','compareAttribute' => 'ventas_inicio','operator'=>'>', 'allowEmpty'=>'false', 'message' => '{attribute} debe ser mayor que {compareAttribute}.'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, recepcion_inicio, recepcion_fin, ventas_inicio, ventas_fin, fecha_creacion, estado', 'safe', 'on'=>'search'),
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
			'nombre' => 'Nombre',
			'recepcion_inicio' => 'Recepcion Inicio',
			'recepcion_fin' => 'Recepcion Fin',
			'ventas_inicio' => 'Ventas Inicio',
			'ventas_fin' => 'Ventas Fin',
			'fecha_creacion' => 'Fecha Creacion',
			'estado' => 'Estado',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('recepcion_inicio',$this->recepcion_inicio,true);
		$criteria->compare('recepcion_fin',$this->recepcion_fin,true);
		$criteria->compare('ventas_inicio',$this->ventas_inicio,true);
		$criteria->compare('ventas_fin',$this->ventas_fin,true);
		$criteria->compare('fecha_creacion',$this->fecha_creacion,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}