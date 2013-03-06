<?php
class PublicarForm extends CFormModel {
	public $tipo;
	//public $newEmail;
	//public $verifyEmail;
	//public $password;
	
	public function rules() {
		return array(
			array('tipo', 'required'),
			//array('oldPassword, password, verifyPassword', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			//array('verifyEmail', 'compare', 'compareAttribute'=>'newEmail', 'message' => UserModule::t("Los correos no coinciden.")),
			//array('password', 'verifyOldPassword'),
			//array('newEmail', 'email','message'=>'El formato de correo es incorrecto'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'tipo'=>UserModule::t("Tipo"),
			//'newEmail'=>UserModule::t("Ej.: correoelectronico@cuenta.com"),
			//'password'=>UserModule::t("Contraseña"),
			//'verifyEmail'=>UserModule::t("Ej.: correoelectronico@cuenta.com"),
		);
	}

}

?>