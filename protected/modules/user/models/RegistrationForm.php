<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegistrationForm extends User {
	public $verifyPassword;
	public $verifyCode;
	
	public function rules() {
		$rules = array(
			//array('username, password, email', 'required'),
			array('username', 'required', 'message'=>Yii::t('contentForm', 'What is your email?')),
			array('password', 'required', 'message'=>Yii::t('contentForm', 'Enter a password.')),
			array('email', 'required', 'message'=>Yii::t('contentForm', 'What is your email?')),
			//array('first_name', 'required', 'message'=>'¿Cómo te llamas?'),
			array('username', 'length', 'max'=>128, 'min' => 3,'tooShort' => Yii::t('contentForm', 'Name must be at least 3 characters')),
			array('password', 'length', 'max'=>128, 'min' => 4,'tooShort' => Yii::t('contentForm', 'Password must be at least 4 characters')),
			//array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email', 'message'=>'Introduzca un correo electronico valido.'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			
			//array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")),
			//array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
		);
		/*
		if (!(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')) {
			array_push($rules,array('verifyCode', 'captcha', 'allowEmpty'=>!UserModule::doCaptcha('registration')));
		}
		
		array_push($rules,array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")));
		*/
		return $rules;
	}
		
}