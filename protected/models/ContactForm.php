<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel
{
	public $name;
	public $email;
	public $subject;
	public $body;
	public $verifyCode;
	public $motivo;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			#array('name, email, subject, body, motivo', 'required'),
			#array('nombre, email, subject, body, motivo, verifyCode', 'required', 'message'=>'{attribute} No puede ser vacio.'),
			array('name', 'required', 'message'=>'{attribute} No puede ser vacio.'),
			array('name', 'required', 'message'=>'Ingrese un {attribute}.'),
			// email has to be a valid email address
			array('email', 'email'),
			array('name', 'required', 'message'=>'Ingrese un nombre.'),
			array('email', 'required', 'message'=>'Ingrese un correo electronico.'),
			array('subject', 'required', 'message'=>'Ingrese un asunto.'),
			array('body', 'required', 'message'=>'Ingrese un mensaje.'),
			array('motivo', 'required', 'message'=>'Seleccione un motivo.'),
			array('verifyCode', 'required', 'message'=>'Ingrese codigo de verificacion.'),
			// verifyCode needs to be entered correctly
			#array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(),'message' => Yii::t("", "El Codigo de Verificacion es Incorrecto.")),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'verifyCode'=>'Código de verificación ',
			'name' => 'Nombre',
			'email' => 'Correo electrónico',
			'subject' => 'Asunto',
			'body' => 'Mensaje',
			'motivo' => 'Motivo',
						
		);
	}


}