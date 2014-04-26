<?php

/**
 * This is the model class for table "{{pais}}".
 *
 * The followings are the available columns in table '{{pais}}':
 * @property integer $id
 * @property string $nombre
 * @property string $dominio
 * @property string $idioma
 * @property integer $grupo
 * @property integer $exento
 */
 // GRUPO: '0'=>No pertenece a ningun grupo, '1,2,3...∞' => Agrupamientos segun se necesite
 
 
class Pais extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pais the static model class
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
		return '{{pais}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, dominio, idioma', 'required'),
			array('grupo', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>150),
			array('dominio', 'length', 'max'=>3),
			array('idioma', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, dominio, idioma, grupo', 'safe', 'on'=>'search'),
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
		'provincias' => array(self::HAS_MANY, 'Provincia', 'pais_id'),
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
			'dominio' => 'Dominio',
			'idioma' => 'Idioma',
			'grupo' => 'Grupo',
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
		$criteria->compare('dominio',$this->dominio,true);
		$criteria->compare('idioma',$this->idioma,true);
		$criteria->compare('grupo',$this->grupo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}