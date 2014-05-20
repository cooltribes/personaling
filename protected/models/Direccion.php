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
 * @property string $ciudad_id
 * @property string $provincia_id
 * @property string $pais
 * @property string $telefono
 * @property integer $user_id
 * @property integer $codigo_postal_id
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
			array('user_id, ciudad_id, provincia_id', 'numerical', 'integerOnly'=>true,'message' => 'Debes seleccionar una {attribute}'),
			array('nombre, apellido', 'length', 'max'=>70),
			array('cedula', 'length', 'max'=>20),
			array('dirUno, dirDos', 'length', 'max'=>120),
			array('telefono', 'length', 'max'=>45),
			array('pais', 'length', 'max'=>80),
			array('nombre, apellido, cedula, dirUno, ciudad_id, provincia_id, pais, telefono', 'required', 'message' => '{attribute} no puede estar vacío'),
			array('pais','compare','compareValue'=>'0','operator'=>'>','allowEmpty'=>false, 'message'=>'Escoja un país.'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, apellido, cedula, dirUno, dirDos, ciudad_id, provincia_id, pais, user_id', 'safe', 'on'=>'search'),
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
			'ciudad' => array(self::BELONGS_TO, 'Ciudad', 'ciudad_id'),
			'codigopostal' => array(self::BELONGS_TO, 'CodigoPostal', 'codigo_postal_id')
			
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
			'cedula' => Yii::t('contentForm','Identity card'),
			'dirUno' => 'Dirección Línea 1',
			'dirDos' => 'Dirección Línea 2',
			'telefono' => 'Teléfono',
			'ciudad_id' => Yii::t('contentForm','City'),
			'provincia_id' => Yii::t('contentForm','Province'),
			'pais' => 'País',
			'user_id' => 'User',
			'codigo_postal_id'=>Yii::t('contentForm','Zip code')
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
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}