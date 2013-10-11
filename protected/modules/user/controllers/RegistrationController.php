    <?php

// Lib para conectar con el API de MailChimp
include("MailChimp.php");

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
            $profile = new Profile;
            $profile->regMode = true;

            // ajax validator
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') {
                //echo "rafa";	
                //echo $_POST['Profile']['birthday'];	
                //$_POST['Profile']['birthday'] = $_POST['Profile']['year'] .'-'. $_POST['Profile']['month'] .'-'. $_POST['Profile']['day'];
                //echo 'rafa'.$_POST['Profile']['birthday'];
                echo UActiveForm::validate(array($model, $profile));
                //$_POST['Profile']['birthday'] = $_POST['Profile']['birthday']['year'] .'-'. $_POST['Profile']['birthday']['month'] .'-'. $_POST['Profile']['birthday']['day'];
                //echo CActiveForm::validate($profile);

                Yii::app()->end();
            }

            if (Yii::app()->user->id) {
                $this->redirect(Yii::app()->controller->module->profileUrl);
            } else {

                //Yii::app()->end();
                if (isset($_GET['email'])) { //correo al que fue invitado
                    $model->email = $_GET['email'];
                }


                if (isset($_POST['RegistrationForm'])) {
                    //$_POST['Profile']['birthday'] = $_POST['Profile']['year'] .'-'. $_POST['Profile']['month'] .'-'. $_POST['Profile']['day'];
                    //echo 'rafa'.$_POST['Profile']['birthday'];	
                    $model->attributes = $_POST['RegistrationForm'];
                    $profile->attributes = ((isset($_POST['Profile']) ? $_POST['Profile'] : array()));
    //                                        echo "<pre>";
    //                                        print_r($_POST['Profile']);
    //                                        echo "</pre><br>";
    //                                        exit();
                    //$profile->birthday = $profile->year .'-'. $profile->month .'-'. $profile->day;
                    //echo 'lore'.$profile->birthday;


                    if ($model->validate() && $profile->validate()) {
                        $soucePassword = $model->password;
                        $model->activkey = UserModule::encrypting(microtime() . $model->password);
                        $model->password = UserModule::encrypting($model->password);
                        $model->verifyPassword = UserModule::encrypting($model->verifyPassword);
                        $model->superuser = 0;
                        $model->status = ((Yii::app()->controller->module->activeAfterRegister) ? User::STATUS_ACTIVE : User::STATUS_NOACTIVE);

                        if (isset($_POST['twitter_id'])) {
                            $model->twitter_id = $_POST['twitter_id'];
                        }
                        
                        if ( isset($_POST['facebook_id']) && $_POST['facebook_id']!="" ) {
                            $model->facebook_id = $_POST['facebook_id'];

                            $model->password = $this->passGenerator();
                            $soucePassword = $model->password;
                            $clave = $model->password;
                            $model->activkey = UserModule::encrypting(microtime() . $model->password);
                            $model->password = UserModule::encrypting($model->password);
                        }


                        if ($model->save()) {
                            if (isset($_POST['facebook_request'])) {
                                $invite = FacebookInvite::model()->findByAttributes(array('request_id' => $_POST['facebook_request']));
                                if ($invite) {
                                    $invite->estado = 1;
                                    $invite->save();
                                }
                            }
                            $profile->user_id = $model->id;
                            $profile->save();
                            //if (Yii::app()->controller->module->sendActivationMail) {

                            if ( isset($_POST['facebook_id']) && $_POST['facebook_id']!="" ) { // de facebook hay que enviar la clave
                                $activation_url = $this->createAbsoluteUrl('/user/activation/activation', array("activkey" => $model->activkey, "email" => $model->email));

                                $message = new YiiMailMessage;
                                $message->view = "mail_template";
                                $subject = 'Registro Personaling';
                                $body = '<h2>Te damos la bienvenida a Personaling.</h2>
                                        <br/>Tu contraseña provisional es: <strong>' . $clave . '</strong><br/>' .
                                        'Puedes cambiarla accediendo a tu cuenta y luego haciendo click ' .
                                        'en la opción Cambiar Contraseña.<br/>
                                        Recibes este correo porque se ha registrado tu dirección en Personaling.
                                        Por favor valida tu cuenta haciendo click en el enlace que aparece a continuación:<br/><br/> <a href="' . $activation_url.'"> Haz click aquí </a>';
                                $params = array('subject' => $subject, 'body' => $body);
                                $message->subject = $subject;
                                $message->setBody($params, 'text/html');
                                $message->addTo($model->email);
                                $message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
                                Yii::app()->mail->send($message);
                            } else {
                                $activation_url = $this->createAbsoluteUrl('/user/activation/activation', array("activkey" => $model->activkey, "email" => $model->email));

                                $message = new YiiMailMessage;
                                $message->view = "mail_template";
                                $subject = 'Registro Personaling';
                                $body = '<h2>¡Bienvenido a Personaling.com!</h2><br/><br/>Tu dirección se ha registrado en Personaling.com, solo estas a un paso de comenzar a disfrutar de nuestra plataforma, valida tu cuenta haciendo click en este enlace. <br/><br/>
                                			<a href="' . $activation_url.'"> Click aquí </a>';
                                $params = array('subject' => $subject, 'body' => $body);
                                $message->subject = $subject;
                                $message->setBody($params, 'text/html');
                                $message->addTo($model->email);
                                $message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
                                Yii::app()->mail->send($message);

                                //UserModule::sendRegistrationMail($model->id, $activation_url);
                                //UserModule::sendMail($model->email,UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)));
                            }


                            // Para registrar en la lista de correo
                            if (isset($_POST['Profile']['suscribir'])) {
                                //API key provisional para lista de prueba										
                                $MailChimp = new MailChimp('78347e50bf7c6299b77dd84fbc24e5be-us7');
                                $result = $MailChimp->call('lists/subscribe', array(
                                    'id' => '11801985e7',
                                    'email' => array('email' => $_POST['RegistrationForm']['email']),
                                    'merge_vars' => array('FNAME' => $_POST['Profile']['first_name'], 'LNAME' => $_POST['Profile']['last_name']),
                                    'birthday' => $_POST['Profile']['month'] . '/' . $_POST['Profile']['year'],
                                    'mc_language' => 'es',
                                    'update_existing' => true,
                                    'replace_interests' => false,
                                ));
                            }


                            //Si se registra por invitación
                            if (isset($_GET['requestId']) && isset($_GET['email'])) { 
                                
                                $invitation = EmailInvite::model()->findByAttributes(array('request_id' => $_GET['requestId']));
                                if($invitation && $invitation->email_invitado == $model->email){
                                    $invitation->estado = 1;
                                    $invitation->save();
                                }
                            }



                            if ((Yii::app()->controller->module->loginNotActiv || (Yii::app()->controller->module->activeAfterRegister && Yii::app()->controller->module->sendActivationMail == false)) && Yii::app()->controller->module->autoLogin) {
                                $identity = new UserIdentity($model->username, $soucePassword);
                                $identity->authenticate();
                                Yii::app()->user->login($identity, 0);
                                //$this->redirect(Yii::app()->controller->module->returnUrl);

                                if ($profile->sex == 1) // mujer
                                    $this->redirect(array('/user/profile/tutipo'));
                                else if ($profile->sex == 2) // hombre
                                    $this->redirect(array('/tienda/look'));
                            } else {
                                if (!Yii::app()->controller->module->activeAfterRegister && !Yii::app()->controller->module->sendActivationMail) {
                                    Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
                                } elseif (Yii::app()->controller->module->activeAfterRegister && Yii::app()->controller->module->sendActivationMail == false) {
                                    Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please {{login}}.", array('{{login}}' => CHtml::link(UserModule::t('Login'), Yii::app()->controller->module->loginUrl))));
                                } elseif (Yii::app()->controller->module->loginNotActiv) {
                                    //Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
                                    $identity = new UserIdentity($model->email, $soucePassword);
                                    $identity->authenticate();
                                    Yii::app()->user->login($identity, 0);

                                    if ($profile->sex == 1) // mujer
                                        $this->redirect(array('/user/profile/tutipo'));
                                    else if ($profile->sex == 2) // hombre
                                        $this->redirect(array('/tienda/look'));

                                    // $this->redirect(array('/user/profile/tutipo'));									
                                } else {
                                    Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please check your email."));
                                }
                                $this->refresh();
                            }
                        }
                    }
                    else
                        $profile->validate();
                }

                $this->render('/user/registration', array('model' => $model, 'profile' => $profile));
            }//else
    }

// registration
        
    public function actionAplicarPS() {
            $model = new RegistrationForm;
            $profile = new Profile;
            $profile->regMode = true;
            $profile->profile_type = 4;
            
            // ajax validator
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') {
               
                echo UActiveForm::validate(array($model, $profile));
                Yii::app()->end();
            }
            
            if (isset($_POST['RegistrationForm'])) {
                    	
                    $model->attributes = $_POST['RegistrationForm'];
                    $profile->attributes = ((isset($_POST['Profile']) ? $_POST['Profile'] : array()));   


                    if ($model->validate() && $profile->validate()) {
                        $soucePassword = $model->password;
                        $model->activkey = UserModule::encrypting(microtime() . $model->password);
                        $model->password = UserModule::encrypting($model->password);
                        $model->verifyPassword = UserModule::encrypting($model->verifyPassword);
                        $model->superuser = 0;
                        $model->personal_shopper = 2;
                        $model->status = ((Yii::app()->controller->module->activeAfterRegister) ? User::STATUS_ACTIVE : User::STATUS_NOACTIVE);

                        if (isset($_POST['twitter_id'])) {
                            $model->twitter_id = $_POST['twitter_id'];
                        }
                        
                        if ( isset($_POST['facebook_id']) && $_POST['facebook_id']!="" ) {
                            $model->facebook_id = $_POST['facebook_id'];

                            $model->password = $this->passGenerator();
                            $soucePassword = $model->password;
                            $clave = $model->password;
                            $model->activkey = UserModule::encrypting(microtime() . $model->password);
                            $model->password = UserModule::encrypting($model->password);
                        }


                        if ($model->save()) {
                            if (isset($_POST['facebook_request'])) {
                                $invite = FacebookInvite::model()->findByAttributes(array('request_id' => $_POST['facebook_request']));
                                if ($invite) {
                                    $invite->estado = 1;
                                    $invite->save();
                                }
                            }
                            $profile->user_id = $model->id;
                            $profile->save();
                            
                            //Enviar email de aplicacion a la usuaria
                            $message = new YiiMailMessage;
                            $message->view = "mail_apply";
                            $subject = 'Aplicación para Personal Shopper';
                            $body = '<h2>¡Tu aplicación ha sido enviada con éxito!</h2>
                                <br/>En breves momentos te notificaremos el resultado, mientras tanto ¿No deberías estar investigando tendencias?<br/> 
                                <br/>Personaling Team<br/><br/>';
                            $footer = '<span>Recibes este correo porque has solicitado unirte a los Personal Shopper de <a href="http://personaling.com/" title="personaling" style="color:#FFFFFF">Personaling.com</a> </span>';
                            $params = array('subject'=>$subject, 'body'=>$body, 'footer' => $footer);
                            $message->subject    = $subject;
                            $message->setBody($params, 'text/html');                
                            $message->addTo($model->email);
                            $message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
                            Yii::app()->mail->send($message);
                            
                            //Enviar email al admin para informar de una usuaria que aplico
                            $message = new YiiMailMessage;
                            $message->view = "mail_apply";
                            $subject = 'Aplicación de un Personal Shopper';
                            $body = '<h2>¡Hola Admin!</h2>
                                <br/>Vamos creciendo como la espuma 
                                ¡Otro Personal Shopper esta en el horno! 
                                ¿Quieres revisar su aplicación y dar un veredicto? 
                                Capaz estás impulsando la carrera del próximo Marc Jacobs o Carolina Herrera.
                                <br/><br/>';
                            $footer = '<span>Recibes este correo porque un nuevo Personal Shopper desea unirse a <a href="http://personaling.com/" title="personaling" style="color:#FFFFFF">Personaling.com</a> </span>';
                            $params = array('subject'=>$subject, 'body'=>$body, 'footer' => $footer);
                            $message->subject    = $subject;
                            $message->setBody($params, 'text/html');                
                            $message->addTo("info@personaling.com");
                            $message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
                            Yii::app()->mail->send($message);
                            
                            //if (Yii::app()->controller->module->sendActivationMail) {

                            if ( isset($_POST['facebook_id']) && $_POST['facebook_id']!="" ) { // de facebook hay que enviar la clave
                                $activation_url = $this->createAbsoluteUrl('/user/activation/activation', array("activkey" => $model->activkey, "email" => $model->email));

                                $message = new YiiMailMessage;
                                $message->view = "mail_template";
                                $subject = 'Registro Personaling';
                                $body = '<h2>Te damos la bienvenida a Personaling.</h2>
                                        <br/>Tu contraseña provisional es: <strong>' . $clave . '</strong><br/>' .
                                        'Puedes cambiarla accediendo a tu cuenta y luego haciendo click ' .
                                        'en la opción Cambiar Contraseña.<br/>
                                        Recibes este correo porque se ha registrado tu dirección en Personaling.
                                        Por favor valida tu cuenta haciendo click en el enlace que aparece a continuación:<br/><br/> <a href="' . $activation_url.'"> Haz click aquí </a>';
                                $params = array('subject' => $subject, 'body' => $body);
                                $message->subject = $subject;
                                $message->setBody($params, 'text/html');
                                $message->addTo($model->email);
                                $message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
                                Yii::app()->mail->send($message);
                            }
                            
                            //Si se registra por invitación
                            if (isset($_GET['requestId']) && isset($_GET['email'])) { 
                                
                                $invitation = EmailInvite::model()->findByAttributes(array('request_id' => $_GET['requestId']));
                                if($invitation && $invitation->email_invitado == $model->email){
                                    $invitation->estado = 1;
                                    $invitation->save();
                                }
                            }



                            if ((Yii::app()->controller->module->loginNotActiv || (Yii::app()->controller->module->activeAfterRegister && Yii::app()->controller->module->sendActivationMail == false)) && Yii::app()->controller->module->autoLogin) {
//                                $identity = new UserIdentity($model->username, $soucePassword);
//                                $identity->authenticate();
//                                Yii::app()->user->login($identity, 0);
//                                //$this->redirect(Yii::app()->controller->module->returnUrl);
//
//                                if ($profile->sex == 1) // mujer
//                                    $this->redirect(array('/user/profile/tutipo'));
//                                else if ($profile->sex == 2) // hombre
//                                    $this->redirect(array('/tienda/look'));
                                
                                /** Redireccionar a la p{agina de información **/
                                      $this->redirect(Yii::app()->baseUrl);
                                
                            } else {
                                if (!Yii::app()->controller->module->activeAfterRegister && !Yii::app()->controller->module->sendActivationMail) {
                                    Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
                                } elseif (Yii::app()->controller->module->activeAfterRegister && Yii::app()->controller->module->sendActivationMail == false) {
                                    Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please {{login}}.", array('{{login}}' => CHtml::link(UserModule::t('Login'), Yii::app()->controller->module->loginUrl))));
                                } elseif (Yii::app()->controller->module->loginNotActiv) {
                                    
                                    //Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
//                                    $identity = new UserIdentity($model->email, $soucePassword);
//                                    $identity->authenticate();
//                                    Yii::app()->user->login($identity, 0);
//
//                                    if ($profile->sex == 1) // mujer
//                                        $this->redirect(array('/user/profile/tutipo'));
//                                    else if ($profile->sex == 2) // hombre
//                                        $this->redirect(array('/tienda/look'));
                                    /** Redireccionar a la p{agina de información **/
                                      $this->redirect('');
                                    // $this->redirect(array('/user/profile/tutipo'));									
                                } else {
                                    Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please check your email."));
                                }
                                $this->refresh();
                            }
                        }
                    }
                    else
                        $profile->validate();
                }
            
            $this->render('/user/registration_ps', array('model' => $model, 'profile' => $profile));

        }
    
    
    public function actionSendValidationEmail(){
            $model = User::model()->notsafe()->findByPk(Yii::app()->user->id);
            $activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email));

            $message            = new YiiMailMessage;
            $message->view = "mail_template";
            $subject = 'Activa tu cuenta en Personaling';
            $body = 'Has recibido este correo porque solicitaste un nuevo enlace para validar tu cuenta en Personaling.com <br/>Valida tu cuenta haciendo click en el enlace que aparece a continuación:<br/><br/>  <a href="'.$activation_url.'">Click aquí</a>';
            $params              = array('subject'=>$subject, 'body'=>$body);
            $message->subject    = $subject;
            $message->setBody($params, 'text/html');                
            $message->addTo($model->email);
            $message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
            Yii::app()->mail->send($message);
            echo 'Enlace de validación enviado a <strong>'.$model->email.'</strong>';
    }

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

    public function passGenerator($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $n = strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $n - 1);
            $result .= substr($chars, $index, 1);
        }

        return $result;
    } 

        
    
	
}