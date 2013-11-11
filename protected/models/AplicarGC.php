<?php

/**
 * Formulario para cargar gift card
 */
class AplicarGC extends CFormModel
{
	
        public $campo1, $campo2, $campo3, $campo4;	

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			
			//array('campo1, campo2, campo3, campo4', 'required', 'message'=>'Debes escribir el código de tu Gift Card completo'),			
			array('campo1, campo2, campo3, campo4', 'required', 'message'=>'req'),			
                        //array('campo1, campo2, campo3, campo4', 'required', 'message'=>''),                        
                        
                        array('campo1, campo2, campo3, campo4', 'length', 'is'=> 4, 'message' => 'len'),
                        //array('campo1, campo2, campo3, campo4', 'length', 'is'=> 4, 'message' => 'Los campos deben ser de 4 caracteres cada uno.'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
//			'rememberMe'=>UserModule::t("Remember me next time"),
//			'username'=>UserModule::t("username or email"),
//			'password'=>UserModule::t("password"),
                    'campo1' => 'Ingresa el código de tu Gift Card',
                    
                    'campo2' => '',
                    'campo3' => '',
                    'campo4' => '',
		);
	}
}
