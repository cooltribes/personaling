<?php

/**
 * This is the model class for table "{{direccionEnvio}}".
 *
 * The followings are the available columns in table '{{direccionEnvio}}':
 * @property integer $id
 * @property string $nombre
 * @property string $cedula
 * @property string $dirUno
 * @property string $dirDos
 * @property string $ciudad
 * @property string $estado
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
			array('nombre', 'length', 'max'=>100),
			array('cedula', 'length', 'max'=>20),
			array('dirUno, dirDos', 'length', 'max'=>120),
			array('ciudad, estado, pais', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, cedula, dirUno, dirDos, ciudad, estado, pais', 'safe', 'on'=>'search'),
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
			'cedula' => 'Cedula',
			'dirUno' => 'Dir Uno',
			'dirDos' => 'Dir Dos',
			'ciudad' => 'Ciudad',
			'estado' => 'Estado',
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
		$criteria->compare('cedula',$this->cedula,true);
		$criteria->compare('dirUno',$this->dirUno,true);
		$criteria->compare('dirDos',$this->dirDos,true);
		$criteria->compare('ciudad',$this->ciudad,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('pais',$this->pais,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}