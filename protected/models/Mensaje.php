<?php

/*
 * Estado: 0=Sin Leer / 1=Leido
 * Visible: 1=visible / 0=No
 * Admin: 1=Enviado para Admin / NULL=Enviado desde admin
 */


/**
 * This is the model class for table "{{mensaje}}".
 *
 * The followings are the available columns in table '{{mensaje}}':
 * @property integer $id
 * @property string $asunto
 * @property string $cuerpo 
 * @property string $fecha
 * @property integer $visible
 * @property integer $estado
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class Mensaje extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Mensaje the static model class
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
		return '{{mensaje}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('asunto, cuerpo, fecha, visible, estado, user_id', 'required'),
			array('visible, estado, user_id', 'numerical', 'integerOnly'=>true),
			array('asunto', 'length', 'max'=>100),
			array('cuerpo', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, asunto, cuerpo, fecha, visible, estado, user_id', 'safe', 'on'=>'search'),
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
			'asunto' => 'Asunto',
			'cuerpo' => 'Cuerpo',
			'fecha' => 'Fecha',
			'visible' => 'Visible',
			'estado' => 'Estado',
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
		$criteria->compare('asunto',$this->asunto,true);
		$criteria->compare('cuerpo',$this->cuerpo,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('visible',$this->visible);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}