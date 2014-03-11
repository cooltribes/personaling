<?php

/**
 * This is the model class for table "{{direccionFacturacion}}".
 *
 * The followings are the available columns in table '{{direccionFacturacion}}':
 * @property integer $id
 * @property string $nombre
 * @property string $apellido
 * @property string $cedula
 * @property string $dirUno
 * @property string $dirDos
 * @property string $telefono
 * @property integer $ciudad_id
 * @property integer $provincia_id
 * @property string $pais
 * @property integer $facturacion
 *
 * The followings are the available model relations:
 * @property Ciudad $ciudad
 * @property Provincia $provincia
 */
class DireccionFacturacion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DireccionFacturacion the static model class
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
		return '{{direccionFacturacion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ciudad_id, provincia_id, facturacion', 'numerical', 'integerOnly'=>true),
			array('nombre, apellido', 'length', 'max'=>100),
			array('cedula', 'length', 'max'=>20),
			array('dirUno, dirDos', 'length', 'max'=>120),
			array('telefono, pais', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, apellido, cedula, dirUno, dirDos, telefono, ciudad_id, provincia_id, pais, facturacion', 'safe', 'on'=>'search'),
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
			'ciudad' => array(self::BELONGS_TO, 'Ciudad', 'ciudad_id'),
			'provincia' => array(self::BELONGS_TO, 'Provincia', 'provincia_id'),
			'ordens' => array(self::HAS_MANY, 'Orden', 'direccionEnvio_id'),
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
			'apellido' => 'Apellido',
			'cedula' => 'Cedula',
			'dirUno' => 'Dir Uno',
			'dirDos' => 'Dir Dos',
			'telefono' => 'Telefono',
			'ciudad_id' => 'Ciudad',
			'provincia_id' => 'Provincia',
			'pais' => 'Pais',
			'facturacion' => 'Facturacion',
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
		$criteria->compare('apellido',$this->apellido,true);
		$criteria->compare('cedula',$this->cedula,true);
		$criteria->compare('dirUno',$this->dirUno,true);
		$criteria->compare('dirDos',$this->dirDos,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('ciudad_id',$this->ciudad_id);
		$criteria->compare('provincia_id',$this->provincia_id);
		$criteria->compare('pais',$this->pais,true);
		$criteria->compare('facturacion',$this->facturacion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}