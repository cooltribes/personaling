<?php

/**
 * This is the model class for table "{{facebook_invite}}".
 *
 * The followings are the available columns in table '{{facebook_invite}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $fb_id_invitado
 * @property integer $request_id
 * @property string $fecha
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Users $user
 * 
 * 
 * Estados:
 * 0: Invitación enviada
 * 1: Usuario invitado registrado
 */
class FacebookInvite extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FacebookInvite the static model class
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
		return '{{facebook_invite}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, fb_id_invitado, fecha', 'required'),
			array('user_id, fb_id_invitado, request_id, estado', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, fb_id_invitado, request_id, nombre_invitado, fecha, estado', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'fb_id_invitado' => 'Fb Id Invitado',
			'request_id' => 'Request',
			'nombre_invitado' => 'Nombre Invitado',
			'fecha' => 'Fecha',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('fb_id_invitado',$this->fb_id_invitado);
		$criteria->compare('request_id',$this->request_id);
		$criteria->compare('nombre_invitado',$this->nombre_invitado);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}