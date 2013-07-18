<?php

class RegistrationController extends Controller
{
	public $defaultAction = 'registration';
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
	/**
	 * Registration user
	 */
	public function actionRegistration() {
            $model = new RegistrationForm;
            $profile=new Profile;
            $profile->regMode = true;
            
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='registration-form')
			{
				//echo "rafa";	
				//echo $_POST['Profile']['birthday'];	
				//$_POST['Profile']['birthday'] = $_POST['Profile']['year'] .'-'. $_POST['Profile']['month'] .'-'. $_POST['Profile']['day'];
				//echo 'rafa'.$_POST['Profile']['birthday'];
				echo UActiveForm::validate(array($model,$profile));
				//$_POST['Profile']['birthday'] = $_POST['Profile']['birthday']['year'] .'-'. $_POST['Profile']['birthday']['month'] .'-'. $_POST['Profile']['birthday']['day'];
				
				//echo CActiveForm::validate($profile);
				
				Yii::app()->end();
			}
			
		    if (Yii::app()->user->id) { 
		    	$this->redirect(Yii::app()->controller->module->profileUrl);
		    } else {
		    	
				//Yii::app()->end();
				
		    	if(isset($_POST['RegistrationForm'])) {
					//$_POST['Profile']['birthday'] = $_POST['Profile']['year'] .'-'. $_POST['Profile']['month'] .'-'. $_POST['Profile']['day'];
					//echo 'rafa'.$_POST['Profile']['birthday'];	
					$model->attributes=$_POST['RegistrationForm'];
					$profile->attributes=((isset($_POST['Profile'])?$_POST['Profile']:array()));
					//$profile->birthday = $profile->year .'-'. $profile->month .'-'. $profile->day;
					//echo 'lore'.$profile->birthday;
					
					if($model->validate()&&$profile->validate())
					{
						//echo 'entro';	
						$soucePassword = $model->password;
						$model->activkey=UserModule::encrypting(microtime().$model->password);
						$model->password=UserModule::encrypting($model->password);
						$model->verifyPassword=UserModule::encrypting($model->verifyPassword);
						$model->superuser=0;
						$model->status=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);
						if(isset($_POST['twitter_id'])){
							$model->twitter_id = $_POST['twitter_id'];
						}
						if(isset($_POST['facebook_id'])){
							$model->facebook_id = $_POST['facebook_id'];
						}
						
						if ($model->save()) {
							$profile->user_id=$model->id;
							$profile->save();
							//if (Yii::app()->controller->module->sendActivationMail) {
								$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email));
								
								$message            = new YiiMailMessage;
							    $message->view = "mail_template";
								$subject = 'Registro Personaling';
								$body = '<h2>Te damos la bienvenida a Personaling.</h2><br/><br/>Recibes este correo porque se ha registrado tu dirección en Personaling. Por favor valida tu cuenta haciendo click en el enlace que aparece a continuación:<br/> '.$activation_url;
							    $params              = array('subject'=>$subject, 'body'=>$body);
							    $message->subject    = $subject;
							    $message->setBody($params, 'text/html');                
							    $message->addTo($model->email);
								$message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
							    Yii::app()->mail->send($message);
								//UserModule::sendRegistrationMail($model->id, $activation_url);
								//UserModule::sendMail($model->email,UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)));
							//}
							
							if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
									$identity=new UserIdentity($model->username,$soucePassword);
									$identity->authenticate();
									Yii::app()->user->login($identity,0);
									//$this->redirect(Yii::app()->controller->module->returnUrl);
									$this->redirect(array('/user/profile/tutipo'));
							} else {
								if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
								} elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),Yii::app()->controller->module->loginUrl))));
								} elseif(Yii::app()->controller->module->loginNotActiv) {
									//Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
									$identity=new UserIdentity($model->email,$soucePassword);
									$identity->authenticate();
									Yii::app()->user->login($identity,0);
									$this->redirect(array('/user/profile/tutipo'));									
									
								} else {
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email."));
								}
								$this->refresh();
							}
						}
					} else $profile->validate();
				}

			    $this->render('/user/registration',array('model'=>$model,'profile'=>$profile));
		    }//else
	}// registration
	
	public function actionTwitterStart(){
		 $twitter = Yii::app()->twitter->getTwitter();  
	     $request_token = $twitter->getRequestToken();
	 
	         //set some session info
	         Yii::app()->session['oauth_token'] = $token = $request_token['oauth_token'];
	         Yii::app()->session['oauth_token_secret'] = $request_token['oauth_token_secret'];
	 
	        if($twitter->http_code == 200){
	            //get twitter connect url
	            $url = $twitter->getAuthorizeURL($token);
	            //send them
	            $this->redirect($url);
	            //echo $url;
	        }else{
	            //error here
	            echo 'error';
	            //$this->redirect(Yii::app()->homeUrl);
	        }
	}
	
	public function actionTwitter()
	{
		/* If the oauth_token is old redirect to the connect page. */
        if (isset($_REQUEST['oauth_token']) && Yii::app()->session['oauth_token'] !== $_REQUEST['oauth_token']) {
            Yii::app()->session['oauth_status'] = 'oldtoken';
        }
 
        /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
        $twitter = Yii::app()->twitter->getTwitterTokened(Yii::app()->session['oauth_token'], Yii::app()->session['oauth_token_secret']);   
 
        /* Request access tokens from twitter */
        if(isset($_REQUEST['oauth_verifier'])){
        	$access_token = $twitter->getAccessToken($_REQUEST['oauth_verifier']);
		}else{
			$this->redirect(array("/user/registration"));
		}
 
        /* Save the access tokens. Normally these would be saved in a database for future use. */
        Yii::app()->session['access_token'] = $access_token;
 
        /* Remove no longer needed request tokens */
        unset(Yii::app()->session['oauth_token']);
        unset(Yii::app()->session['oauth_token_secret']);
 
        if (200 == $twitter->http_code) {
            /* The user has been verified and the access tokens can be saved for future use */
            Yii::app()->session['status'] = 'verified';
 
            //get an access twitter object
            $twitter = Yii::app()->twitter->getTwitterTokened($access_token['oauth_token'],$access_token['oauth_token_secret']);
 
            //get user details
            $twuser= $twitter->get("account/verify_credentials");
			//var_dump($twuser);
			$user = User::model()->notsafe()->findByAttributes(array('twitter_id'=>$twuser->id));
			if(!$user){
				//no existe, crear usuario y redirigir a formulario para que complete el registro
				$user = new User();
				$registration_form = new RegistrationForm();
				//$user->username = $twuser->username;
				$user->twitter_id = $twuser->id;
				$profile = new Profile();
				$profile->regMode = true;
				
				$this->render('/user/twitter_registration',array('model'=>$registration_form, 'profile'=>$profile, 'twitter_user'=>$twuser));
			}else{
				//ya existe, login directo
				//echo 'Username: '.$user->username;
				$identity=new UserIdentity($user->username,$user->password);
				$identity->twitter();
				Yii::app()->user->login($identity,0);
				//$this->redirect(Yii::app()->controller->module->returnUrl);
				if ($user->status_register == User::STATUS_REGISTER_NEW){
					$this->redirect(array('/user/profile/tutipo'));
				}else if($user->status_register == User::STATUS_REGISTER_TIPO){
					$this->redirect(array("/user/profile/tuestilo"));
				}else{
					$this->redirect(array("/site/personal"));
				}
				
			}
			
			
            //get friends ids
            //$friends= $twitter->get("friends/ids");
                        //get followers ids
                //$followers= $twitter->get("followers/ids");
            //tweet
                        //$result=$twitter->post('statuses/update', array('status' => "Tweet message"));
                        //echo 'Name: '.$twuser->name;
 
        } else {
            /* Save HTTP status for error dialog on connnect page.*/
            //header('Location: /clearsessions.php');
            //$this->redirect(Yii::app()->homeUrl);
            echo 'Else';
        }
	}
	
}