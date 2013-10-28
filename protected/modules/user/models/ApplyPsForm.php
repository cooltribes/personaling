<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class ApplyPsForm extends RegistrationForm {
	
        public $avatarPs;   
	
        /**
        * @return array validation rules to be applied when {@link validate()} is called.
        */
        public function rules() {
            return array_merge(parent::rules(), array(
                
                array('avatarPs', 'file', 'allowEmpty'=>false, 'types'=>'jpg,jpeg,gif,png,bmp',
                    'message' => 'Debes escoger una imagen', 'wrongType' => 'El archivo que escogiste no es una imagen válida'),
                //array('avatarPs', 'required', 'message' => 'Debes escoger una imagen: RE'),
//                array('fieldNames', 'validatorNameOrFunction', 'param' => 'value'),
//                array('fieldNames', 'validatorNameOrFunction', 'on' => 'insert, update, search'), // valid for these scenario's
            
	));
        }
        /**
                                                       * @return array attribute labels (name=>label)
 */
        public function attributeLabels() {
            return array_merge(parent::attributeLabels(), array(
                'avatarPs' => 'Elige una imagen para tu avatar',
            
	));
        }
		
}