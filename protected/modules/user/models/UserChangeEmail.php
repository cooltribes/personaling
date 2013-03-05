<?php
class UserChangeEmail extends CFormModel {
	public $oldEmail;
	public $newEmail;
	public $verifyEmail;
	public $password;
	
	public function rules() {
		return array(
			array('newEmail, password, verifyEmail', 'required'),
			array('newEmail', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Maximo 128 Caracteres para el Correo.")),
			array('verifyEmail', 'compare', 'compareAttribute'=>'newEmail', 'message' => UserModule::t("Los correos no coinciden.")),
			array('password', 'verifyOldPassword'),
			array('newEmail', 'email','message'=>'El formato de correo es incorrecto'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'oldEmail'=>UserModule::t("Dirección de correo electrónico actual"),
			'newEmail'=>UserModule::t("Ej.: correoelectronico@cuenta.com"),
			'password'=>UserModule::t("Contraseña"),
			'verifyEmail'=>UserModule::t("Ej.: correoelectronico@cuenta.com"),
		);
	}
	/**
	 * Verify Old Password
	 */
	 public function verifyOldPassword($attribute, $params)
	 {
		 if (User::model()->notsafe()->findByPk(Yii::app()->user->id)->password != Yii::app()->getModule('user')->encrypting($this->$attribute))
			 $this->addError($attribute, UserModule::t("Password is incorrect."));
	 }	
}

?>