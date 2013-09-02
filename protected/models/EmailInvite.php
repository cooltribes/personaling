<?php

/**
 * This is the model class for table "{{email_invite}}".
 *
 * The followings are the available columns in table '{{email_invite}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $email_invitado
 * @property string $request_id
 * @property string $nombre_invitado
 * @property string $fecha
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class EmailInvite extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmailInvite the static model class
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
		return '{{email_invite}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, email_invitado, request_id, fecha', 'required'),
			array('user_id, estado', 'numerical', 'integerOnly'=>true),
			array('email_invitado, request_id', 'length', 'max'=>128),
			array('nombre_invitado', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, email_invitado, request_id, nombre_invitado, fecha, estado', 'safe', 'on'=>'search'),
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
			'email_invitado' => 'Email Invitado',
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
		$criteria->compare('email_invitado',$this->email_invitado,true);
		$criteria->compare('request_id',$this->request_id,true);
		$criteria->compare('nombre_invitado',$this->nombre_invitado,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}