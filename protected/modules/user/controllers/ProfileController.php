<?php

class ProfileController extends Controller
{
	public $defaultAction = 'profile';
	public $layout='//layouts/column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
	/**
	 * Shows a particular model.
	 */
	public function actionProfile()
	{
		$model = $this->loadUser();
	    $this->render('profile',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}
/**
 * Configuracion de Privacidad  
 */
	public function actionPrivacidad()
	{
		$model = $this->loadUser();
		if (isset($_POST['privacidad'])){
			
			$privacidad = array_sum($_POST['privacidad']);
			$model->privacy = $privacidad;
			if ($model->save()){
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('success',UserModule::t("Changes is saved."));				
			} else {
				Yii::trace('username:'.$model->username.' Error:'.implode('|',$model->getErrors()), 'registro');
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('error',UserModule::t("Changes not saved."));				
			}
			
			
		}
	    $this->render('privacidad',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}
/**
 * Configuracion de Eliminar  
 */
	public function actionDelete()
	{
		$model = $this->loadUser();
	    $this->render('delete',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}	
/**
 * Configuracion de Notificaciones  
 */
	public function actionNotificaciones()
	{
		$model = $this->loadUser();
	    $this->render('notificaciones',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}	
/**
 * Mi cuenta  
 */
	public function actionMicuenta()
	{
		$model = $this->loadUser();
		if  (UserModule::isPersonalShopper()) 
	    $this->render('micuenta_ps',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
		else 
	    $this->render('micuenta',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));			
	}
/**
 * Editar tu estilo  
 */
	public function actionEdittuestilo()
	{
		$model = $this->loadUser();
		$profile=$model->profile;
		$profile->profile_type = 2;
		//$profile=new Profile;
		if(isset($_POST['ajax']) && $_POST['ajax']==='tuestilo-form')
		{
			echo CActiveForm::validate($profile);
			Yii::app()->end();
		}	
		if(isset($_POST['Profile'])) {
			$profile->attributes=$_POST['Profile'];
			if($profile->validate())
			{
				if ($profile->save())
				{
					//$model->status_register = User::STATUS_REGISTER_ESTILO;
					//if ($model->save()){
               			Yii::app()->user->updateSession();
						Yii::app()->user->setFlash('profileMessage',UserModule::t("Changes is saved."));						
						$this->render('tuestilo',array(
					    	'model'=>$model,
							'profile'=>$model->profile,
							'editar'=>true,
					    ));
						//$this->redirect(array('/user/profile/tuestilo'));
					//}else {
					//	Yii::trace('username:'.$model->username.' Error:'.implode('|',$model->getErrors()), 'registro');
					//}
				} else {
					Yii::trace('username:'.$model->username.' Error:'.implode('|',$profile->getErrors()), 'registro');
				}
			} else {
				Yii::trace('username:'.$model->username.' Error:'.implode("|",$profile->getErrors()), 'registro');
			}
		}	
	    $this->render('tuestilo',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}
/**
 * Regsitro tu estilo  
 */
	public function actionTuestilo()
	{
		$model = $this->loadUser();
		$profile=$model->profile;
		$profile->profile_type = 2;
		//$profile=new Profile;
		if(isset($_POST['ajax']) && $_POST['ajax']==='tuestilo-form')
		{
			echo CActiveForm::validate($profile);
			Yii::app()->end();
		}	
		if(isset($_POST['Profile'])) {
			$profile->attributes=$_POST['Profile'];
			if($profile->validate())
			{
				if ($profile->save())
				{
					$model->status_register = User::STATUS_REGISTER_ESTILO;
					if ($model->save())	
						$this->redirect(array('/site/index'));
					else 
						Yii::trace('username:'.$model->username.' Error:'.implode('|',$model->getErrors()), 'registro');
					
				} else {
					Yii::trace('username:'.$model->username.' Error:'.implode('|',$profile->getErrors()), 'registro');
				}
			}
		}	
	    $this->render('tuestilo',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}	
 /**
 * Regsitro tu tipo  
 */
	public function actionTutipo()
	{
		$model = $this->loadUser();
		$profile=$model->profile;
		$profile->profile_type = 3;
		//$profile=new Profile;
		if(isset($_POST['ajax']) && $_POST['ajax']==='tutipo-form')
		{
			echo CActiveForm::validate($profile);
			Yii::app()->end();
		}	
		if(isset($_POST['Profile'])) {
			$profile->attributes=$_POST['Profile'];
			if($profile->validate())
			{
				if ($profile->save())
				{
					$model->status_register = User::STATUS_REGISTER_TIPO;
					if ($model->save())	
						$this->redirect(array('/user/profile/tuestilo'));
					else 
						Yii::trace('username:'.$model->username.' Error:'.implode('|',$model->getErrors()), 'registro');
					
				} else {
					Yii::trace('username:'.$model->username.' Error:'.implode('|',$profile->getErrors()), 'registro');
				}
			}
		}	
	    $this->render('tutipo',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}
/**
 * Editar tu tipo  
 */
	public function actionEdittutipo()
	{
		$model = $this->loadUser();
		$profile=$model->profile;
		$profile->profile_type = 3;
		//$profile=new Profile;
		if(isset($_POST['ajax']) && $_POST['ajax']==='tutipo-form')
		{
			echo CActiveForm::validate($profile);
			Yii::app()->end();
		}	
		if(isset($_POST['Profile'])) {
			$profile->attributes=$_POST['Profile'];
			if($profile->validate())
			{
				if ($profile->save())
				{
					//$model->status_register = User::STATUS_REGISTER_TIPO;
					//if ($model->save()){	
						Yii::app()->user->updateSession();
						Yii::app()->user->setFlash('success',UserModule::t("Changes is saved."));						
						$this->render('tutipo',array(
					    	'model'=>$model,
							'profile'=>$model->profile,
							'editar'=>true,
					    ));
					//}else{ 
					//	Yii::trace('username:'.$model->username.' Error:'.implode('|',$model->getErrors()), 'registro');
					//}
				} else {
					Yii::trace('username:'.$model->username.' Error:'.implode('|',$profile->getErrors()), 'registro');
				}
			} else {
				Yii::trace('username:'.$model->username.' Error:'.implode("|",$profile->getErrors()), 'registro');
				//Yii::trace('username:'.$model->username.' Error:'.$profile->getErrors(), 'registro');
			}
		}	
	    $this->render('tutipo',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
			'editar'=>true,
	    ));
		
	}		
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEdit()
	{
		
		$model = $this->loadUser();
		//Yii::trace('username:'.$model->username.' Error: Inicio Guardado', 'registro');	
		$profile=$model->profile;
		$profile->profile_type = 1;
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}
		
		if(isset($_POST['Profile']))
		{
			//$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($profile->validate()) {
				//$model->save();
				if ($profile->save()){
                Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('profileMessage',UserModule::t("Changes is saved."));
				$this->redirect(array('/user/profile'));
				} else {
					Yii::trace('username:'.$model->username.' Error:'.implode('|',$profile->getErrors()), 'registro');
				}
			} else $profile->validate();
		}

		$this->render('edit',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}
	/**
	 * Change email
	 */
	public function actionChangeemail() {
		$user = $this->loadUser();
		$model = new UserChangeEmail;
		$model->oldEmail = $user->email;
		if (Yii::app()->user->id) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changeemail-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangeEmail'])) {
					$model->attributes=$_POST['UserChangeEmail'];
					if($model->validate()) {
						$user->email = $model->newEmail;
						$user->username = $model->newEmail;
						//$new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
						//$new_password->password = UserModule::encrypting($model->password);
						//$new_password->activkey=UserModule::encrypting(microtime().$model->password);
						if ($user->save()){
							Yii::app()->user->setFlash('success',UserModule::t("Se guardo el nuevo Correo."));
						} else {
							Yii::trace('username:'.$user->username.' Error:'.implode('|',$user->getErrors()), 'registro');
							Yii::app()->user->setFlash('error',UserModule::t("Lo sentimos hubo un error, intente de nuevo mas tarde."));
						}
						//$this->redirect(array("profile"));
					}
			}
			$this->render('changeemail',array('model'=>$model));
	    }
	}
	
	/**
	 * Change password
	 */
	public function actionChangepassword() {
		$model = new UserChangePassword;
		if (Yii::app()->user->id) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePassword'])) {
					$model->attributes=$_POST['UserChangePassword'];
					if($model->validate()) {
						$new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
						$new_password->password = UserModule::encrypting($model->password);
						$new_password->activkey=UserModule::encrypting(microtime().$model->password);
						$new_password->save();
						Yii::app()->user->setFlash('profileMessage',UserModule::t("New password is saved."));
						$this->redirect(array("profile"));
					}
			}
			$this->render('changepassword',array('model'=>$model));
	    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser()
	{
		if($this->_model===null)
		{
			if(Yii::app()->user->id)
				$this->_model=Yii::app()->controller->module->user();
			if($this->_model===null)
				$this->redirect(Yii::app()->controller->module->loginUrl);
		}
		return $this->_model;
	}
}