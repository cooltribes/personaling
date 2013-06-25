<?php

/**
 * This is the model class for table "{{direccion}}".
 *
 * The followings are the available columns in table '{{direccion}}':
 * @property integer $id
 * @property string $nombre
 * @property string $apellido
 * @property string $cedula
 * @property string $dirUno
 * @property string $dirDos
 * @property string $ciudad
 * @property string $estado
 * @property string $pais
 * @property string $telefono
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class Direccion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Direccion the static model class
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
		return '{{direccion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('nombre, apellido', 'length', 'max'=>70),
			array('cedula', 'length', 'max'=>20),
			array('dirUno, dirDos', 'length', 'max'=>120),
			array('ciudad, estado, telefono', 'length', 'max'=>45),
			array('pais', 'length', 'max'=>80),
			array('nombre, apellido, cedula, dirUno, ciudad, estado, pais, telefono', 'required'),
			array('pais','compare','compareValue'=>'0','operator'=>'>','allowEmpty'=>false, 'message'=>'Escoja un país.'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, apellido, cedula, dirUno, dirDos, ciudad, estado, pais, user_id', 'safe', 'on'=>'search'),
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
			'nombre' => 'Nombre',
			'apellido' => 'Apellido',
			'cedula' => 'Cedula de Identidad',
			'dirUno' => 'Dirección Línea 1',
			'dirDos' => 'Dirección Línea 2',
			'telefono' => 'Teléfono',
			'ciudad' => 'Ciudad',
			'estado' => 'Estado',
			'pais' => 'País',
			'user_id' => 'User',
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
		$criteria->compare('ciudad',$this->ciudad,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('pais',$this->pais,true);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}