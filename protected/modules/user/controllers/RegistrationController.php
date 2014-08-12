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
			$referencia = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
			if (strpos($referencia, 'tienda/look') === false)
				$referencia='';
			else 
				$referencia='look';
			$referencia_tmp = isset($_POST['referencia'])?$_POST['referencia']:'';
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
					$profile->ciudad=$_POST['Profile']['ciudad'];
                    if(isset($_POST['Profile']['suscribir'])){
                        if($_POST['Profile']['suscribir'] == 'suscribir'){
                            $model->suscrito_nl = 1;
                        }
                    }
					
					
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
                            // Get profile picture from facebook url
                            if ( isset($_POST['facebook_picture']) && $_POST['facebook_picture']!="" ) {
                                if(!is_dir(Yii::getPathOfAlias('webroot').'/images/avatar/'. $model->id)){
                                    mkdir(Yii::getPathOfAlias('webroot').'/images/avatar/'. $model->id,0777,true);
                                }
                                $content = file_get_contents($_POST['facebook_picture']);
                                $extension = '.jpg';
                                $nombre = Yii::getPathOfAlias('webroot').'/images/avatar/'.$model->id.'/0';
                                $nombre_orig = Yii::getPathOfAlias('webroot').'/images/avatar/'.$model->id.'/0_orig';
                                file_put_contents($nombre . $extension, $content);
                                file_put_contents($nombre_orig . $extension, $content);
                                $model->avatar_url = '/images/avatar/'. $model->id .'/0' . $extension;
                                $model->save();

                                $image = Yii::app()->image->load($nombre_orig.$extension);
                                $avatar_x = isset($_POST['avatar_x'])?$_POST['avatar_x']:0;
                                $avatar_x = $avatar_x*(-1);
                                $avatar_y = isset($_POST['avatar_y'])?$_POST['avatar_y']:0;
                                $avatar_y = $avatar_y*(-1);
                                
                                $proporcion = $image->__get('width')<$image->__get('height')?Image::WIDTH:Image::HEIGHT;
                                $image->resize(270,270,$proporcion)->crop(270, 270,$avatar_y,$avatar_x);
                                $image->save($nombre . $extension);
                                
                                $proporcion = $image->__get('width')<$image->__get('height')?Image::WIDTH:Image::HEIGHT;
                                $image->resize(30,30,$proporcion)->crop(30, 30,$avatar_y,$avatar_x);
                                $image->save($nombre . "_x30". $extension);
                                
                                $proporcion = $image->__get('width')<$image->__get('height')?Image::WIDTH:Image::HEIGHT;
                                $image->resize(60,60,$proporcion)->crop(60, 60,$avatar_y,$avatar_x);
                                $image->save($nombre . "_x60". $extension);
                            }

                            if (isset($_POST['facebook_request'])) {
                                $invite = FacebookInvite::model()->findByAttributes(array('request_id' => $_POST['facebook_request']));
                                if ($invite) {
                                    $invite->estado = 1;
                                    $invite->save();
                                }
                            }
                            $profile->user_id = $model->id;
                            $profile->save();

                            // save user to zoho
                            $zoho = new Zoho();
                            $zoho->email = $model->email;
                            $zoho->first_name = $profile->first_name;
                            $zoho->last_name = $profile->last_name;
                            $zoho->birthday = $profile->birthday;
                            if($profile->sex == 1)
                                $zoho->sex = 'Mujer';
                            else if($profile->sex == 2)
                                $zoho->sex = 'Hombre';

                            $zoho->admin = 'No';
                            $zoho->ps = 'No';
							$zoho->tipo = "Externo";
                            $zoho->no_suscrito = true;
							
                            if($model->superuser == 1){
                                $zoho->admin = 'Si';
                            }
                            if($model->personal_shopper == 1){
                                $zoho->ps = 'Si';
                            }
                            //$zoho->save_potential();

                            $result = $zoho->save_potential();

                            $xml = simplexml_load_string($result);
                            $id = (int)$xml->result[0]->recorddetail->FL[0];

                            $model->zoho_id = $id;
                            if($model->save()){
                                //$success++;
                            }else{
                                //$error++;
                            }


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
                                $body = Yii::t('contentForm','<h2>Welcome to Personaling</h2>Receiving this email because you registered your address Personaling. Please validate your account by clicking on the link below:<br/><br/><a href="{url}">Click here</a>',array('{url}'=>$activation_url));
                                $params = array('subject' => $subject, 'body' => $body);
                                $message->subject = $subject;
                                $message->setBody($params, 'text/html');
                                $message->addTo($model->email);
                                $message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
                                Yii::app()->mail->send($message);

                                //UserModule::sendRegistrationMail($model->id, $activation_url);
                                //UserModule::sendMail($model->email,UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)));
                            }


                            $group = array();

                            // Para registrar en la lista de correo
                            if (isset($_POST['Profile']['suscribir'])) {
                                $group = array(
                                    array(
                                        'name' => 'Personaling Newsletter',
                                        'groups' => array('Suscrito'),
                                    )
                                );                                								
                            }

                            //API key para lista de Personaling en Mailchimp
                            $MailChimp = new MailChimp('c95c8ab0290d2e489425a2257e89ea58-us5');
                            $result = $MailChimp->call('lists/subscribe', array(
                                'id' => Yii::t('contentForm','List ID Mailchimp'),
                                'email' => array('email' => $_POST['RegistrationForm']['email']),
                                'merge_vars' => array('FNAME' => $_POST['Profile']['first_name'], 'LNAME' => $_POST['Profile']['last_name'], 'GROUPINGS' => $group),
                                'birthday' => $_POST['Profile']['month'] . '/' . $_POST['Profile']['year'],
                                'mc_language' => 'es',
                                'update_existing' => true,
                                'replace_interests' => false,
                                'double_optin' => false,
                                'send_welcome' => false,
                            ));


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
                                //se vale comentar aqui para entender
                                if (Yii::app()->params['registro'] || $referencia_tmp == 'look') {
                                    if ($profile->sex == 1) { // mujer
                                        Yii::app()->session['registerStep'] = 1;
                                        if (isset($_POST['facebook_id']) && $_POST['facebook_id'] != "") { // se registro con fb, guardo info necesaria para agregar pixel de conversión al header
                                            $this->redirect(array('/user/profile/tutipo', 'fb' => 'true'));
                                        } else {
                                            $this->redirect(array('/user/profile/tutipo'));
                                        }
                                    } else if ($profile->sex == 2) { // hombre
                                        if (isset($_POST['facebook_id']) && $_POST['facebook_id'] != "") { // se registro con fb, guardo info necesaria para agregar pixel de conversión al header
                                            $this->redirect(array('/tienda/look', 'fb' => 'true'));
                                        } else {
                                            $this->redirect(array('/tienda/look'));
                                        }
                                    }
                                } else {
                                    if ($profile->sex == 1) { // mujer
                                        Yii::app()->session['registerStep'] = 1;
                                        if (isset($_POST['facebook_id']) && $_POST['facebook_id'] != "") { // se registro con fb, guardo info necesaria para agregar pixel de conversión al header
                                            $this->redirect(array('/user/profile/tutipo', 'fb' => 'true'));
                                        } else {
                                            $this->redirect(array('/user/profile/tutipo'));
                                        }
                                    } else {
                                        if (isset($_POST['facebook_id']) && $_POST['facebook_id'] != "") { // se registro con fb, guardo info necesaria para agregar pixel de conversión al header
                                            $this->redirect(array('/tienda/look', 'fb' => 'true'));
                                        } else {
                                            $this->redirect(array('/tienda/look'));
                                        }
                                    }
                                }
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
									
                                    if (Yii::app()->params['registro'] || $referencia_tmp =='look'){
	                                    if ($profile->sex == 1) // mujer
	                                        $this->redirect(array('/user/profile/tutipo', $fb));
	                                    else if ($profile->sex == 2) // hombre
                                            $this->redirect(array('/tienda/look'));
									} else {
										$this->redirect(array('/tienda/look', $fb));
									}

                                    // $this->redirect(array('/user/profile/tutipo'));									
                                } else {
                                    Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please check your email."));
                                }
                                $this->refresh();
                            }
                        }
                    }
                    else {
                        $profile->validate();
						if ($model->validate()) {
                			$registro = new Registro;
							$registro->email = $model->email;
							$registro->source = 0;
							$profile = new Profile;
							$profile->regMode = true;
							if (!$registro->save())
        		        		Yii::trace('Guardando correo en registro:'.print_r($registro->getErrors(),true), 'registro');
						}
            
						
					}
                }  
                	
                $seo = SeoStatic::model()->findByAttributes(array('name'=>'Registro'));

                




                $this->render('/user/registration', array('model' => $model, 'profile' => $profile,'referencia'=>$referencia, 'seo'=>$seo));
            }//else
    }

    public function setParameter($key, $value, $parameter) {
        if ($parameter === "" || strlen($parameter) == 0) {
            $parameter = $key . '=' . $value;
        } else {
            $parameter .= '&' . $key . '=' . $value;
        }
        return $parameter;
    }

// registration
        
    public function actionAplicarPS() {
            //$model = new RegistrationForm;
            $model = new ApplyPsForm;
            $profile = new Profile;
            $profile->regMode = true;
            $profile->profile_type = 4;
            
            // ajax validator
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') {
               
               // echo UActiveForm::validate(array($model, $profile));
                //echo preg_replace('/,"ApplyPsForm_avatarPs":\[".*?"\]/' , '' , UActiveForm::validate(array($model, $profile)));
               //unset($model->attributes['avatarPs']);
//               echo  "<pre>";
//               print_r(array_keys($model->attributes));               
//               echo "</pre>";
               
                
            //echo UActiveForm::validate(array($model, $profile), array_merge($model->attributes, $profile->attributes));
                echo UActiveForm::validate(array($model, $profile), array_keys(array_merge($model->attributes, $profile->attributes)));
                //echo UActiveForm::validate(array($model, $profile), array('email'));
                Yii::app()->end();
            }
         
            
            if (isset($_POST['ApplyPsForm'])) {
                    	
                    $model->attributes = $_POST['ApplyPsForm'];
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
                            
                            /*Avatar*/
                            if (isset($_POST['valido'])){
                                
				$id = $model->id;
                                // make the directory to store the pic:
				if(!is_dir(Yii::getPathOfAlias('webroot').'/images/avatar/'. $id))
				{
	   				mkdir(Yii::getPathOfAlias('webroot').'/images/avatar/'. $id,0777,true);
	 			}	 
				$images = CUploadedFile::getInstancesByName('ApplyPsForm[avatarPs]');
                                
                                if (isset($images) && count($images) > 0) {
                                    
                                    foreach ($images as $image => $pic) {
                                        $nombre = Yii::getPathOfAlias('webroot').'/images/avatar/'. $id .'/'. $image;
                                        $extension = '.'.$pic->extensionName;
                                        $model->avatar_url = '/images/avatar/'. $id .'/'. $image .$extension;                                        
                                       
                                        if (!$model->save()){	
                                            Yii::trace('username:'.$model->username.' Crear Avatar Error:'.print_r($model->getErrors(),true), 'registro');
                                        }
                                        if ($pic->saveAs($nombre ."_orig". $extension)) {
                                            $image = Yii::app()->image->load($nombre ."_orig". $extension);
                                            $avatar_x = isset($_POST['avatar_x'])?$_POST['avatar_x']:0;
                                            $avatar_x = $avatar_x*(-1);
                                            $avatar_y = isset($_POST['avatar_y'])?$_POST['avatar_y']:0;
                                            $avatar_y = $avatar_y*(-1);

                                            $proporcion = $image->__get('width')<$image->__get('height')?Image::WIDTH:Image::HEIGHT;
                                            $image->resize(270,270,$proporcion)->crop(270, 270,$avatar_y,$avatar_x);
                                            $image->save($nombre . $extension);

                                            $proporcion = $image->__get('width')<$image->__get('height')?Image::WIDTH:Image::HEIGHT;
                                            $image->resize(30,30,$proporcion)->crop(30, 30,$avatar_y,$avatar_x);
                                            $image->save($nombre . "_x30". $extension);

                                            $proporcion = $image->__get('width')<$image->__get('height')?Image::WIDTH:Image::HEIGHT;
                                            $image->resize(60,60,$proporcion)->crop(60, 60,$avatar_y,$avatar_x);
                                            $image->save($nombre . "_x60". $extension);

//                                            Yii::app()->user->updateSession();
//                                            Yii::app()->user->setFlash('success',UserModule::t("La imágen ha sido cargada exitosamente."));	
                                         }
                                      }
                                   }  	
                               } 
                            
                            
                            
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
                            $url = $this->createAbsoluteUrl('/user/admin/update', array("id" => $model->id));
                            $message = new YiiMailMessage;
                            $message->view = "mail_apply";
                            $subject = 'Aplicación de un Personal Shopper';
                            $body = '<h2>¡Hola Admin!</h2>
                                <br/>Vamos creciendo como la espuma 
                                ¡Otro Personal Shopper esta en el horno! <br/>
                                ¿Quieres revisar su aplicación y dar un veredicto? 
                                Capaz estás impulsando la carrera del próximo Marc Jacobs o Carolina Herrera.
                                <br/><br/>'.                                
                                CHtml::link('Mira su perfil', $url , array('class' => 'btn btn-danger'))
                                .'<br/><br/>';
                            $footer = '<span>Recibes este correo porque un nuevo Personal Shopper desea unirse a <a href="http://personaling.com/" title="personaling" style="color:#FFFFFF">Personaling.com</a> </span>';
                            $params = array('subject'=>$subject, 'body'=>$body, 'footer' => $footer);
                            $message->subject    = $subject;
                            $message->setBody($params, 'text/html');                
                            $message->addTo('info@personaling.com');
                            $message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
                            Yii::app()->mail->send($message);
                            
                            
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
                                
                                 /* REGISTRAR PERSONAL SHOPPER EN ZOHO */
            					
	            					$user=User::model()->findByPk($model->id);
									
									$rangos = array();
	            
						            $profileFields=$user->profile->getFields();
						            if ($profileFields) {
						                foreach($profileFields as $field) {
						                    if($field->id > 4 && $field->id < 16){
						                        $rangos[] =  $field->range.";0==Ninguno";
						                    }
						                    if($field->id == 4){
						                        $rangosSex = $field->range;
						                    }
						                    
						                }
						            }
						
						            $time = strtotime($user->profile->birthday);
						
						            $admin = 'No';
						            $ps = 'Aplicante';
						            $no_suscrito = true;
						            $interno = 'Externo'; 
						
						            $zoho = new Zoho();
						            $zoho->email = $user->email;
						            $zoho->first_name = $user->profile->first_name;
						            $zoho->last_name = $user->profile->last_name;
						            $zoho->birthday = date('d/m/Y', $time);
						            $zoho->sex = Profile::range($rangosSex,$user->profile->sex); 
						            $zoho->bio = $user->profile->bio;
						            $zoho->dni = $user->profile->cedula;
						            $zoho->tlf_casa = $user->profile->tlf_casa;
						            $zoho->tlf_celular = $user->profile->tlf_celular;
						            $zoho->pinterest = $user->profile->pinterest;
						            $zoho->twitter = $user->profile->twitter;
						            $zoho->facebook = $user->profile->facebook;
						            $zoho->url = $user->profile->url;
						            $zoho->admin = $admin;
						            $zoho->ps = $ps;
						            $zoho->no_suscrito = $no_suscrito;
						            $zoho->tipo = $interno;
					
						            $zoho->status = $user->getStatus($user->status);
									
						            $result = $zoho->save_potential();
						
						            $xml = simplexml_load_string($result);
						            $id = (int)$xml->result[0]->recorddetail->FL[0];
						
						            $user->zoho_id = $id;
						            $user->save();
									
								/* Creando el caso */ 
									
									$zohoCase = new ZohoCases;
									$zohoCase->Subject = "Aplicación PS - ".$user->email;
									$zohoCase->Priority = "High";
									$zohoCase->Email = $user->email;
					            	$zohoCase->Description = "Aplicación de ".$user->profile->first_name." ".$user->profile->last_name." (".$user->email.") para personal Shopper.";
									$zohoCase->internal = "Sin revisar";
									
									$respuesta = $zohoCase->save_potential(); 
                                
                                /** Redireccionar a la p{agina de información **/
                                     $this->redirect(array('/site/afterApply'));
                                
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
            $body = Yii::t('contentForm','You are receiving this email because you have requested a new link to validate your account. You can continue by clicking on the link below:<br/><br/>{{link}}<br/>', array('{{link}}'=>$activation_url));
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
                                    //$this->redirect(array("/site/personal"));
                                    $this->redirect(array("/tienda/look"));
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
