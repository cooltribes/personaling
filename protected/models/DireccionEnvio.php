<?php

/**
 * This is the model class for table "{{direccionEnvio}}".
 *
 * The followings are the available columns in table '{{direccionEnvio}}':
 * @property integer $id
 * @property string $nombre
 * @property string $apellido
 * @property string $cedula
 * @property string $dirUno
 * @property string $dirDos
 * @property string $telefono
 * @property string $ciudad_id
 * @property string $provincia_id
 * @property string $pais
 *
 * The followings are the available model relations:
 * @property Orden[] $ordens
 */
class DireccionEnvio extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DireccionEnvio the static model class
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
		return '{{direccionEnvio}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ciudad_id, provincia_id', 'required'),
			array('ciudad_id, provincia_id', 'numerical', 'integerOnly'=>true),
			array('nombre, apellido', 'length', 'max'=>100),
			array('cedula', 'length', 'max'=>20),
			array('dirUno, dirDos', 'length', 'max'=>120),
			array('pais, telefono', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, apellido, cedula, dirUno, dirDos, ciudad_id, provincia_id, pais', 'safe', 'on'=>'search'),
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
			'ordens' => array(self::HAS_MANY, 'Orden', 'direccionEnvio_id'),
			'myciudad' => array(self::BELONGS_TO, 'Ciudad', 'ciudad_id'),
			'codigoPostal' => array(self::BELONGS_TO, 'CodigoPostal', 'codigo_postal_id'),
			'provincia' => array(self::BELONGS_TO, 'Provincia', 'provincia_id'), 
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
			'provincia_id' => 'Estado',
			'pais' => 'Pais',
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
		$criteria->compare('ciudad_id',$this->ciudad_id,true);
		$criteria->compare('provincia_id',$this->provincia_id,true);
		$criteria->compare('pais',$this->pais,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}