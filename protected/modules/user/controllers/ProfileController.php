<?php
// Lib para conectar con el API de MailChimp
include("MailChimp.php");

class ProfileController extends Controller
{
	public $defaultAction = 'profile';
	//public $layout='//layouts/column2';
 
	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;
	/**
	 * Shows a particular model.
	 */
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
            return array(
                array('allow',  // allow all users to perform 'index' and 'view' actions

                        'actions'=>array('modal','modalshopper','listado'),

                        'users'=>array('*'),
                ),
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                    'actions'=>array('perfil','micuenta','direcciones','encantan',
                        'looksencantan', 'tusPerfiles', 'unsuscribeMail'),
                    'users'=>array('@'),
                ),
                array('allow', // allow admin user to perform 'admin' and 'delete' actions
                        'actions'=>array(),
                        //'users'=>array('admin'),
                        'expression' => 'UserModule::isAdmin()',
                ),
                array('allow', // acciones validas para el personal Shopper
                   'actions' => array('banner', 'misVentas'),
                   'expression' => 'UserModule::isPersonalShopper()'
            ),
			array('deny',  // deny all users
				'users'=>array('*'),
			), 
		);
	}
	
	public function actionInvitaciones()
	{
		$model = $this->loadUser();
		$invitacion = new FacebookInvite;
		$invitacion->user_id = $model->id;
		$dataProvider = $invitacion->search();
	    $this->render('invitaciones',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
			'dataProvider'=>$dataProvider,
	    ));
	}
        
         /**
	 * Envia las invitaciones por email
	 */
	public function actionSendEmailInvs()
	{	
            $result = array();
            
            if(isset($_POST['User']['emailList']) ){ //&& isset($_POST['invite-message'])){
                
                $emails = $_POST['User']['emailList'];                
                $textoMensaje = isset($_POST['invite-message'])? $_POST['invite-message'] : "";
                
                $model = $this->loadUser();  
                
                //Cada email de la lista de invitados
                foreach ($emails as $email) {
                    
                    $requestId = UserModule::encrypting($email.$model->id);
                    
                    $registration_url = $this->createAbsoluteUrl('/user/registration', array("email" => $email, "requestId" => $requestId));
                    
                    $message = new YiiMailMessage;
                    //Opciones de Mandrill
                    $message->activarPlantillaMandrill("plantilla-correo-invitacion");
                    $subject = 'Invitación a Personaling';
                    $body = Yii::t('contentForm','Hello! Has anyone thought that Personaling.com is perfect for you. Have an invitation to try from <strong>{name}.</strong><br/><br/><i>{message}</i><br/><br/>Start enjoying digital experience Personal Shoppers and enjoy the online sale of your favorite brands.<br/> You can register by clicking on the link below: <br/><br/><a href="{registration_url}">Click here</a>', array(
                            '{name}'=>$model->profile->first_name,
                            '{message}'=>$textoMensaje,
                            '{registration_url}'=>$registration_url));                        
                    
                    $message->subject = $subject;
                    $message->setBody($body, 'text/html');

                    $message->addTo($email);
                    Yii::app()->mail->send($message);   
//                    $message->view = "mail_invite";
                    // $body = '¡Hola! Alguien ha pensado que Personaling.com es perfecto para ti. Tienes una invitación para probarlo de parte de <strong>' . $model->profile->first_name . '</strong>.' .
                    //         '<br/><br/><i>' . $textoMensaje . '</i><br/><br/>' .
                    //         'Comienza a disfrutar de la experiencia de Personal Shoppers digital y a disfrutar de la venta online de tus marcas preferidas.<br/><br/>' .
                    //         'Puedes registrarte haciendo click en el enlace que aparece a continuación:<br/><br/> <a href="' . $registration_url.'">Click aquí</a>';
//                    $params = array('subject' => $subject, 'body' => $body);

//                    $message->from = array('info@personaling.com' => 'Tu Personal Shopper Online');
                    
                    //Guardar la invitacion en BD
                    $invitation = EmailInvite::model()->findByAttributes(array('user_id'=>$model->id, 'request_id'=>$requestId));                                       
                    
                    if(!$invitation){
                        $invitation = new EmailInvite();
                        $invitation->user_id = $model->id;
                        $invitation->email_invitado = $email;                    
                        $invitation->request_id = $requestId;
                        $invitation->fecha = date('Y-m-d H:i:s');
//                        if(isset($_POST['nombre'])){
//                            $invite->nombre_invitado = $_POST['nombre'];
//                        }                       
                                            
                    }else{
                        $invitation->fecha = date('Y-m-d H:i:s');                       
                    }
                     $invitation->save();

                }
                
                $result['status'] = 'success';
                $result['redirect'] = $this->createUrl('profile/micuenta');
                Yii::app()->user->updateSession();
                Yii::app()->user->setFlash('success', '¡Se ha enviado tu invitación!');
                
            }else{
               $result['status'] = 'error';
               $result['message'] = 'Debes ingresar al menos una dirección email';
            }
          
            echo function_exists('json_encode') ? json_encode($result) : CJSON::encode($result);                
            Yii::app()->end();       
                
	}
	
	public function actionProfile()
	{
//		$model = $this->loadUser();
//	    $this->render('perfil_user',array(//$this->render('profile',array(
//	    	'model'=>$model,
//			'profile'=>$model->profile,
//	    ));
            $this->actionPerfil();
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
				Yii::app()->user->setFlash('success',UserModule::t("Changes are saved."));				
			} else {
				Yii::trace('username:'.$model->username.' Error:'.print_r($model->getErrors(), true), 'registro');
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('error',UserModule::t("Changes not saved."));				
			}
			
			
		}
	    $this->render('privacidad',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}
	
	public function actionListado()
	{
		$criteria = new CDbCriteria;
			$criteria->with=array('user');
			$criteria->addCondition('personal_shopper = 1 ');
		
			
			
			$total=User::model()->totalPS;
			$pages = new CPagination($total);
			$pages->pageSize = 8;
			$pages->applyLimit($criteria);
			$profiles = Profile::model()->findAll($criteria);
                        
                        /***    Filtros por Perfil ***/
                        
                      
			$this->render('pshoppers', array(
				'profs' => $profiles,
				'pages' => $pages
			));		
	}
	
	 
	/*
	 * 
	 * */
	public function actionPerfil()
	{
            	
            if(!isset($_GET['alias'])){
            	
            if(!isset($_GET['id'])){
              $id = Yii::app()->user->id;                        
            }else{
              $id = $_GET['id'];  
            }
            
            $model = User::model()->findByPk($id);
			} else {
				$profile = Profile::model()->findByAttributes(array('url'=>$_GET['alias']));
				
				if (isset($profile)){
					//echo $profile->first_name;
					$model = $profile->user;
					$id = $model->id;
					//echo $model->username;
				} else {
					// echo "(site) Error: no existe el usuario ".$_GET['alias'];
					$this->redirect(array('listado'));   
				}
			}
        // Yii::app()->end();       
		if($model->personal_shopper == 1){
		
			//$looks = Look::model()->findAllByAttributes(array('user_id' => $_GET['id']));					
			$looks = new Look;
			$looks->user_id = $id;
			$looks->status = Look::STATUS_APROBADO; // looks aprobados 
			$datalook = $looks->busqueda(); 			
			$datalook->setPagination(array('pageSize'=>4));
			
			$producto = new Producto;
			
			$dataprod = $producto->ProductosLook($id); 
			//$dataprod->setPagination(array('pageSize'=>9)); 
						
			$this->render('perfil_ps',array('model'=>$model,'datalooks'=>$datalook,'dataprods'=>$dataprod));
		}
		else if($model->personal_shopper == 0){
                        //Cuando es usuari@ normal                    	
                       		
                        $looksEncantan = new Look;                        
                        $dataLooksEncantan = $looksEncantan->busquedaEncantan($model->id);
                        
                        
                        $prodEncantan = new Producto;	
                        $dataProdsEncantan = $prodEncantan->produtosEncantan($model->id);
					
			$this->render('perfil_user',array('model'=>$model,'datalooks'=>$dataLooksEncantan,'dataprods'=>$dataProdsEncantan));                   
                    
					
		}else{
                    // redireccion cuando intenten mostrar un perfil via url u ocurra un error
                }
		
	}
	
	/**
     * Revisar si el usuario tiene un id de facebook asociado, si no agregarlo
     */

    public function actionCheckFbUser($fb_id){
        $usuario = $this->loadUser();
        if(!$usuario->facebook_id){
            $usuario->facebook_id = $fb_id;
            $usuario->save();
        }
    }
	
	/**
     * Guardar amigos invitados a través de facebook
     */

    public function actionSaveInvite(){
        $usuario = $this->loadUser();
        if(isset($_POST['to'])){
            //foreach ($_POST['to'] as $fb_id) {
                //echo 'user_id: '.$usuario->id.' - fb_id_invitado: '.$fb_id;
                $invite = FacebookInvite::model()->findByAttributes(array('user_id'=>$usuario->id, 'fb_id_invitado'=>$_POST['to']));
                if(!$invite){
                    $invite = new FacebookInvite;
                    $invite->user_id = $usuario->id;
                    $invite->fb_id_invitado = $_POST['to'];
                    $invite->request_id = $_POST['request'];
                    $invite->fecha = date('Y-m-d H:i:s');
					if(isset($_POST['nombre'])){
						$invite->nombre_invitado = $_POST['nombre'];
					}
                    $invite->save();
					//echo 'Request controller: '.$invite->request_id;
                }else{
                	$invite->fecha = date('Y-m-d H:i:s');
					$invite->request_id = $_POST['request'];
					$invite->save();
                }
            //}
            //Yii::app()->user->setFlash('success',"Amigos invitados");
        }
        //$this->redirect(array('profile/direcciones'), false);
        //$this->refresh();
    }
	
	
	
/**
 * Configuracion de Eliminar  
 */
	public function actionDelete()
	{
		$model = $this->loadUser();
		if (isset($_POST['acepto'])){
			$model->status = User::STATUS_DELETED;
			if ($model->save()){
				$this->redirect(array('/site/logout'));
			}	
		}
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
         * Darse de baja en la lista de correos
         */
	public function actionUnsuscribeMail()
	{
            $model = $this->loadUser();
            
            //si hizo click en el boton
            if(isset($_POST["unsuscribe"]) && $_POST["unsuscribe"]){
                
                //LLamar la API
                //API key para lista de Personaling en Mailchimp
                $MailChimp = new MailChimp('c95c8ab0290d2e489425a2257e89ea58-us5');
                $result = $MailChimp->call('lists/unsubscribe', array(
                    'id' => Yii::t('contentForm','List ID Mailchimp'),
                    'email' => array('email' => $model->email),                    
                    'send_goodbye' => false,
                ));                
               
                $model->suscrito_nl = 0; //desuscribir en la BD
                $model->save();
                
                Yii::app()->user->updateSession();
                Yii::app()->user->setFlash("success", "Te has dado de baja en la lista de correos.");
            }
            
            
	    $this->render('unsuscribe',array(
	    	'user'=>$model,
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
 * Crear dir
 */
	public function actionCrearDireccion($id = null)
	{
		$usuario = $this->loadUser();
		
		if(!$id){
			$model = new Direccion;
		}else{
			$model = Direccion::model()->findByPk($id);
		}
		
		if(isset($_POST['Direccion']))
		{
			$model->attributes = $_POST['Direccion'];
			if(isset($_POST['Direccion']['codigo_postal_id']))
			     $model->codigo_postal_id = $_POST['Direccion']['codigo_postal_id'];
            else
                $model->codigo_postal_id = CodigoPostal::model()->getCode($model->ciudad_id,'id');
			
			if(is_numeric($model->pais))
		 			$model->pais=Pais::model()->getOficial($model->pais);
			$model->user_id = $usuario->id;
			
			if($model->save()){
				// update potential at zoho
                $zoho = new Zoho();
                $zoho->email = $usuario->email;

                $zoho->calle = $model->dirUno;
                $zoho->ciudad = $model->ciudad->nombre;
                $zoho->estado = $model->provincia->nombre;
                $zoho->codigo_postal = $model->codigopostal->codigo;
                $zoho->pais = $model->pais;
                
                $result = $zoho->save_potential();

				$this->redirect(array('direcciones'));
			}
		}

		$this->render('create_dir',array(
			'model'=>$model,
			'usuario'=>$usuario,
			'profile'=>$usuario->profile,
		));
	}

/*
 * Borrar direccion 
 */
	public function actionBorrardireccion($id)
	{
		$direccion = Direccion::model()->findByPk($id);
		$user = $this->loadUser();
		$facturas1 = Factura::model()->countByAttributes(array('direccion_fiscal_id'=>$id));
		$facturas2 = Factura::model()->countByAttributes(array('direccion_envio_id'=>$id));
		
		if($facturas1 == 0 && $facturas2 == 0){
			if($direccion->delete()){
				Yii::app()->user->setFlash('success',UserModule::t("Dirección eliminada exitosamente."));
			}else{
				Yii::app()->user->setFlash('error',UserModule::t("La dirección no pudo ser eliminada."));
			}
		}else{
			Yii::app()->user->setFlash('error',UserModule::t("La dirección seleccionada no se puede eliminar"));
		}
		$this->redirect(array('direcciones'));		
	}

/**
 * Direcciones
 */
	public function actionDirecciones()
	{
		$model = $this->loadUser();
		
		/*if  (UserModule::isPersonalShopper()) 
	    	echo "";
		else*/
	    $this->render('direcciones',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));			
	}

/**
 * Editar tu estilo  
 */
	public function actionEdittuestilo($id)
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
                                    $model->save();
                                    Yii::app()->user->updateSession();
                                    Yii::app()->user->setFlash('success',UserModule::t("Changes are saved."));

						// update potential at zoho
		                $zoho = new Zoho();
		                $zoho->email = $model->email;

		                $rangos = array();
                        
                        $profileFields=$profile->getFields();
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
                        //var_dump($rangos);

		                $zoho->diario = Profile::range($rangos[0],$profile->coctel);
		                $zoho->fiesta = Profile::range($rangos[1],$profile->fiesta);
		                $zoho->vacaciones = Profile::range($rangos[2],$profile->playa);
		                $zoho->deporte = Profile::range($rangos[3],$profile->sport);
		                $zoho->oficina = Profile::range($rangos[4],$profile->trabajo);
		                
		                $result = $zoho->save_potential();

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
					Yii::trace('username:'.$model->username.' Error:'.print_r($profile->getErrors(),true), 'registro');
				}
			} else {
				Yii::trace('username:'.$model->username.' Error:'.print_r($profile->getErrors(),true), 'registro');
			}
		}	
	    $this->render('tuestilo',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
			'estilo'=>$id,
	    ));
	}
	public function actionAvatar()
	{
		$model = $this->loadUser();
	    if (isset($_POST['valido'])){
				$id = $model->id;
			// make the directory to store the pic:
				if(!is_dir(Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->language.'/avatar/'. $id))
				{
	   				mkdir(Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->language.'/avatar/'. $id,0777,true);
	 			}	 
				$images = CUploadedFile::getInstancesByName('filesToUpload');
				 if (isset($images) && count($images) > 0) {
		            foreach ($images as $image => $pic) {
		            	$nombre = Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->language.'/avatar/'. $id .'/'. $image;
						$extension = '.'.$pic->extensionName;
		            	$model->avatar_url = $id .'/'. $image .$extension;
		            	if (!$model->save())	
							Yii::trace('username:'.$model->username.' Crear Avatar Error:'.print_r($model->getErrors(),true), 'registro');
				
                                if ($pic->saveAs($nombre ."_orig". $extension)) {
				                	//echo $nombre;
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
									
				                	Yii::app()->user->updateSession();
									Yii::app()->user->setFlash('success',UserModule::t("La imágen ha sido cargada exitosamente."));	

									// reload page with no cache to show the new avatar
									header("Refresh: 0; URL=".$this->createUrl('avatar'));
								}
					}
				 }  	
		}else{
			$this->render('avatar',array(
		    	'model'=>$model,
				//'profile'=>$model->profile,
		    ));
	    }
		
		
	}

// Subir o editar banner
	public function actionBanner(){
		$model = $this->loadUser();

		if( isset($_POST['valido']) ){
			$id = $model->id;

			if(!is_dir( Yii::getPathOfAlias('webroot').'/images/banner/'.$id) ){
				mkdir( Yii::getPathOfAlias('webroot').'/images/banner/'.$id ,0777,true );
			}

			$images = CUploadedFile::getInstancesByName('filesToUpload');
			if(isset($images) && count($images) > 0){

				foreach ($images as $image => $pic) {
	            	$nombre = Yii::getPathOfAlias('webroot').'/images/banner/'.$id.'/'. $image;	
	            	$extension = '.'.$pic->extensionName;
					$model->banner_url = '/images/banner/'. $id .'/'. $image .$extension;

				
				 if (!$model->save())	
						Yii::trace('username:'.$model->username.' Crear Banner Error:'.print_r($model->getErrors(),true), 'registro');										
					
		            	if($pic->saveAs($nombre . $extension)){
			                   
		          
			                Yii::app()->user->updateSession();
							Yii::app()->user->setFlash('success',UserModule::t("La imágen ha sido cargada exitosamente."));			            										            	
		            

	            	}
						else{
								Yii::app()->user->updateSession();
								Yii::app()->user->setFlash('error',UserModule::t("La imágen debe ser jpg png o gif"));	
									                	            		}	            	
				}

			}

		}

		$this->render('banner', array('user'=>$model));

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
		if(isset($_POST['ajax']) && $_POST['ajax']==='tuestilo-registro-form')
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
					if ($model->save())	{
						if(isset(Yii::app()->session['registerStep'])){
                                    	if(Yii::app()->session['registerStep']==2)
											Yii::app()->session['registerStep']=3;
										else
											unset(Yii::app()->session['registerStep']);
                                    		
                                    }

                        // update potential at zoho
		                $zoho = new Zoho();
		                $zoho->email = $model->email;

		                $rangos = array();
                        
                        $profileFields=$profile->getFields();
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

		                $zoho->diario = Profile::range($rangos[0],$profile->coctel);
		                $zoho->fiesta = Profile::range($rangos[1],$profile->fiesta);
		                $zoho->vacaciones = Profile::range($rangos[2],$profile->playa);
		                $zoho->deporte = Profile::range($rangos[3],$profile->sport);
		                $zoho->oficina = Profile::range($rangos[4],$profile->trabajo);
		                
		                $result = $zoho->save_potential();

						$this->redirect(array('/tienda/look'));
					}
						
					else 
						Yii::trace('username:'.$model->username.' Error:'.implode('|',$model->getErrors()), 'registro');
					
				} else {
					Yii::trace('username:'.$model->username.' Error:'.implode('|',$profile->getErrors()), 'registro');
				}
			}
		}
                
                $ref = isset($_GET['ref']) && $_GET['ref'] == "looks";
	    $this->render('tuestilo_registro',array(
	    	'ref'=>$ref,
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
            $profile = $model->profile;
            $profile->profile_type = 3;
            $errorValidando = false;
            //$profile=new Profile;
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'tutipo-form') {
                echo CActiveForm::validate($profile);
                Yii::app()->end();
            }
            if (isset($_POST['Profile'])) 
            {
                $profile->attributes = $_POST['Profile'];
                
                if ($profile->validate()) {
                    
                    if ($profile->save()) {
                        
                        $model->status_register = User::STATUS_REGISTER_TIPO;
                        
                        /* Crear el filtro de perfil propio */
                        $filter = Filter::model()->findByAttributes(
                                array('name' => "Mi Perfil", 'type' => '0', 'user_id' => Yii::app()->user->id) //Comprobar que no exista el nombre
                        );

                        //si existe ya un filtro, borrarlo.
                        if ($filter) {
                            $filter->delete();
                        }

                        $filter = new Filter;
                        $filter->name = "Mi Perfil";
                        $filter->type = 0;
                        $filter->user_id = Yii::app()->user->id;

                        if ($filter->save()) {
                            $filterProfile = new FilterProfile;
                            $filterProfile->attributes = $_POST['Profile'];
                            $filterProfile->id_filter = $filter->id_filter;

                            if ($filterProfile->validate()) {
                                $filterProfile->save();
                            }
                        }

                        if ($model->save()) {
                            if (isset(Yii::app()->session['registerStep'])) {
                                if (Yii::app()->session['registerStep'] == 1)
                                    Yii::app()->session['registerStep'] = 2;
                                else
                                    unset(Yii::app()->session['registerStep']);
                            }

                            //save data to Zoho
                            $zoho = new Zoho();
			                $zoho->email = $model->email;

			                $rangos = array();
	                        
	                        $profileFields=$profile->getFields();
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

			                $zoho->altura = Profile::range($rangos[1],$profile->altura);
			                $zoho->condicion_fisica = Profile::range($rangos[2],$profile->contextura);
			                $zoho->color_piel = Profile::range($rangos[0],$profile->piel);
			                $zoho->color_cabello = Profile::range($rangos[3],$profile->pelo);
			                $zoho->color_ojos = Profile::range($rangos[4],$profile->ojos);
			                $zoho->tipo_cuerpo = Profile::range($rangos[5],$profile->tipo_cuerpo);
			                
			                $result = $zoho->save_potential();

                            $this->redirect(array('/user/profile/tuestilo'));
                        }
                        else{
                            Yii::trace('username:' . $model->username . ' Error:' . implode('|', $model->getErrors()), 'registro');
                        }
                    } else {
                        Yii::trace('username:' . $model->username . ' Error:' . implode('|', $profile->getErrors()), 'registro');
                    }
                } else {
                    $errorValidando = true;
                }
            }
            
            //para saber si viene de la tienda de looks y mostrar un mensaje
            //explicativo
            $ref = isset($_GET['ref']) && $_GET['ref'] == "looks";
            
            $this->render('tutipo', array(
                'model' => $model,
                'profile' => $model->profile,
                'errorValidando' => $errorValidando,
                'ref' => $ref,
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
		$errorValidando = false;
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
                                    
                                    /*Marcar como que ya completo esta parte del registro*/
                                    $model->status_register = User::STATUS_REGISTER_TIPO;
                                    $model->save();
                                    
                                    /*Crear el filtro de perfil propio*/
                                        
                                        $filter = Filter::model()->findByAttributes(
                                                array('name' => "Mi Perfil", 'type' => '0', 'user_id' => Yii::app()->user->id) //Comprobar que no exista el nombre
                                        );

                                        //si NO existe, crear uno nuevo.
                                        if (!$filter) {                                            
                                            $filter = new Filter;
                                            $filter->name = "Mi Perfil";
                                            $filter->type = 0;
                                            $filter->user_id = Yii::app()->user->id;
                                            
                                            if ($filter->save()) {
                                                $filterProfile = new FilterProfile;
                                                $filterProfile->attributes = $_POST['Profile'];
                                                $filterProfile->id_filter = $filter->id_filter;

                                                if($filterProfile->validate()){
                                                    $filterProfile->save();                                                                  
                                                }
                                            }
                                            
                                        }else{
                                            
                                            $filterProfile = $filter->filterProfiles[0];
                                            $filterProfile->attributes = $_POST['Profile'];

                                            if($filterProfile->validate()){

                                                $filterProfile->save();
                                                
                                            }
                                            
                                        }            
                                    
					//$model->status_register = User::STATUS_REGISTER_TIPO;
					//if ($model->save()){	
						Yii::app()->user->updateSession();
						Yii::app()->user->setFlash('success',UserModule::t("Changes are saved."));	

						// update potential at zoho
		                $zoho = new Zoho();
		                $zoho->email = $model->email;

		                $rangos = array();
                        
                        $profileFields=$profile->getFields();
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

		                $zoho->altura = Profile::range($rangos[1],$profile->altura);
		                $zoho->condicion_fisica = Profile::range($rangos[2],$profile->contextura);
		                $zoho->color_piel = Profile::range($rangos[0],$profile->piel);
		                $zoho->color_cabello = Profile::range($rangos[3],$profile->pelo);
		                $zoho->color_ojos = Profile::range($rangos[4],$profile->ojos);
		                $zoho->tipo_cuerpo = Profile::range($rangos[5],$profile->tipo_cuerpo);
		                
		                $result = $zoho->save_potential();

						/*$this->render('tutipo',array(
					    	'model'=>$model,
							'profile'=>$model->profile,
							'editar'=>true,
					    ));*/
						// Yii::app()->end();
					//}else{ 
					//	Yii::trace('username:'.$model->username.' Error:'.implode('|',$model->getErrors()), 'registro');
					//}
				} else {
					Yii::trace('username:'.$model->username.' Error:'.print_r($profile->getErrors(),true), 'registro');
				}
			} else {
				Yii::trace('username:'.$model->username.' Error:'.print_r($profile->getErrors(),true), 'registro');
				$errorValidando = true;
				//Yii::trace('username:'.$model->username.' Error:'.$profile->getErrors(), 'registro');
			}
		}	
	    $this->render('tutipo',array(
	    	'model'=>$model,
			'profile'=>$model->profile,
			'editar'=>true,
			'errorValidando'=>$errorValidando,
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
        if(User::model()->is_personalshopper($model->id)){
            $profile->profile_type = 6;
        } else {
            $profile->profile_type = 1;
        }

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
				Yii::app()->user->setFlash('success',UserModule::t("Changes are saved."));

				// update potential at zoho
                $zoho = new Zoho();
                $zoho->email = $model->email;
                $zoho->first_name = $profile->first_name;
                $zoho->last_name = $profile->last_name;
                $zoho->birthday = $profile->birthday;
                if($profile->sex == 1)
                    $zoho->sex = 'Mujer';
                else if($profile->sex == 2)
                    $zoho->sex = 'Hombre';
                $zoho->bio = $profile->bio;
                $zoho->dni = $profile->cedula;
                $zoho->tlf_casa = $profile->tlf_casa;
                $zoho->tlf_celular = $profile->tlf_celular;
                $zoho->pinterest = $profile->pinterest;
                $zoho->twitter = $profile->twitter;
                $zoho->facebook = $profile->facebook;
                $zoho->url = $profile->url;
                $result = $zoho->save_potential();

                //var_dump($result);

				/*if(isset($_POST['Profile']['ciudad'])){
					//API key para lista de Personaling en Mailchimp
                    $MailChimp = new MailChimp('c95c8ab0290d2e489425a2257e89ea58-us5');
                    $result = $MailChimp->call('lists/update-member', array(
                        'id' => 'e5d30a0894',
                        'email' => array('email' => $model->email),
                        'merge_vars' => array('CITY' => $_POST['Profile']['ciudad']),
                    ));
				}*/
				//$this->redirect(array('/user/profile'));
				} else {
					Yii::app()->user->setFlash('error',UserModule::t("Lo sentimos, no se guardaron los cambios, intente mas tarde."));
					Yii::trace('username:'.$model->username.' Error:'.implode('|',$profile->getErrors()), 'registro');
				}
			} else {
                Yii::trace('username:'.$model->username.' Error:'.implode('|',$profile->getErrors()), 'registro');
                $profile->validate();
            }
		}

		$this->render('edit',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}

	/*
	Edita los campos del personal Shopper
	 */
	public function actionEditShopper()
	{
		
		$model = $this->loadUser();
		
		$profile=$model->profile;
		$profile->profile_type = 4;
		
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}
		
		if(isset($_POST['Profile']))
		{
			$profile->attributes=$_POST['Profile'];
            $profile->web=$_POST['Profile']['web'];
            $profile->blog=$_POST['Profile']['blog'];
           
			
			if($profile->validate()) {
				//$model->save();
				if ($profile->save()){
                	Yii::app()->user->updateSession();
					Yii::app()->user->setFlash('success',UserModule::t("Changes are saved."));
				} else {
					Yii::app()->user->setFlash('error',UserModule::t("Lo sentimos, no se guardaron los cambios, intente mas tarde."));
					Yii::trace('username:'.$model->username.' Error:'.implode('|',$profile->getErrors()), 'registro');
				}
			} else $profile->validate();
		}

		$this->render('editShopper',array(
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
							$model->oldEmail = $user->email;
							Yii::app()->user->setFlash('success',UserModule::t("Se guardo el nuevo Correo."));
						} else {
							Yii::trace('username:'.$user->username.' Error:'.print_r($user->getErrors(),true), 'registro');
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
						Yii::app()->user->setFlash('success',UserModule::t("New password is saved."));
						//$this->redirect(array("profile"));
					} else {
						#Yii::trace('username:'.$new_password->username.' Error:'.print_r($new_password->getErrors(),true), 'registro');
						Yii::app()->user->setFlash('error',UserModule::t("Contraseña Actual no es valida."));
					}
			}
			$this->render('changepassword',array('model'=>$model));
	    }
	}

	/**
	 * Productos que le encantan a la usuaria
	 */
	public function actionEncantan() {
		
		$prodEncantan = new UserEncantan;
		$prodEncantan->user_id = Yii::app()->user->id;
		
		$dataProvider = $prodEncantan->search();
		$numeroItems = $dataProvider->getTotalItemCount();
		$this->render('productosEncantan',array('prodEncantan'=>$prodEncantan,'dataProvider'=>$dataProvider,'numeroItems' =>$numeroItems ));
		
	}
	
	/**
	 * Looks que le encantan
	 */
	public function actionLooksencantan()
	{
		$user = User::model()->findByPk(Yii::app()->user->id);
		$lookEncantan = LookEncantan::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id));
		
		$this->render('looksEncantan',array(
					'looks' => $lookEncantan,
					'user'=>$user,	
				));
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
	
	public function actionModal($id)
	{ 
		
		$datos="";
		
		$producto = Producto::model()->findByPk($id);
		
		//$datos=$datos."<div id='myModal' class='modal hide tienda_modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>";
    	$datos=$datos."<div class='modal-header'>";
		$datos=$datos."<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>";
		$datos=$datos."<h3 id='myModalLabel'>".$producto->nombre."</h3></div>";
		$datos=$datos."<div class='modal-body'>";
   
   		$datos=$datos."<div class='row-fluid'>";
   		$datos=$datos."<div class='span7'><div class='carousel slide' id='myCarousel'>";
		$datos=$datos."<ol class='carousel-indicators'>";
		$datos=$datos."<li class='' data-slide-to='0' data-target='#myCarousel'></li>";
		$datos=$datos.'<li data-slide-to="1" data-target="#myCarousel" class="active"></li>';
        $datos=$datos.'<li data-slide-to="2" data-target="#myCarousel" class=""></li>';
       	$datos=$datos.'</ol>';
        $datos=$datos.'<div class="carousel-inner" id="carruselImag">';
       // $datos=$datos.'<div class="item">';
		
		$ima = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$producto->id),array('order'=>'orden ASC'));
		
		foreach ($ima as $img){
					
			if($img->orden==1)
			{ 
				$colorPredet = $img->color_id;
				
				$datos=$datos.'<div class="item active">';	
				$datos=$datos. CHtml::image($img->getUrl(array('ext'=>'jpg')), $producto->nombre, array("width" => "450", "height" => "450"));
				$datos=$datos.'</div>';
			}
				
			if($img->orden!=1){
				if($colorPredet == $img->color_id)
				{
					$datos=$datos.'<div class="item">';
					$datos=$datos.CHtml::image($img->getUrl(array('ext'=>'jpg')), $producto->nombre, array("width" => "450", "height" => "450"));
					$datos=$datos.'</div>';
				}
			}// que no es la primera en el orden
		}
		
        $datos=$datos.'</div>';
        $datos=$datos.'<a data-slide="prev" href="#myCarousel" class="left carousel-control">‹</a>';
        $datos=$datos.'<a data-slide="next" href="#myCarousel" class="right carousel-control">›</a>';
        $datos=$datos.'</div></div>';
        
        $datos=$datos.'<div class="span5">';
        $datos=$datos.'<div class="row-fluid call2action">';
       	$datos=$datos.'<div class="span7">';
		
		foreach ($producto->precios as $precio) {
   			$datos=$datos.'<h4 class="precio"><span>Subtotal</span> Bs. '.Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento).'</h4>';
   		}

        $datos=$datos.'</div>';
        
        $datos=$datos.'<div class="span5">';
        $datos=$datos.'<a class="btn btn-warning btn-block" title="agregar a la bolsa" id="agregar" onclick="c()"> Comprar </a>';
        $datos=$datos.'</div></div>';
        
        $datos=$datos.'<p class="muted t_small CAPS">Selecciona Color y talla </p>';
        $datos=$datos.'<div class="row-fluid">';
        $datos=$datos.'<div class="span6">';
        $datos=$datos.'<h5>Colores</h5>';
        $datos=$datos.'<div class="clearfix colores" id="vCo">';
        
        	$valores = Array();
            $cantcolor = Array();
            $cont1 = 0;
              	
			// revisando cuantos colores distintos hay
			foreach ($producto->preciotallacolor as $talCol){ 
				if($talCol->cantidad > 0){
					$color = Color::model()->findByPk($talCol->color_id);
					
					if(in_array($color->id, $cantcolor)){	// no hace nada para que no se repita el valor			
					}
					else {
						array_push($cantcolor, $color->id);
						$cont1++;
					}	
				}
			}
				
			if( $cont1 == 1){ // Si solo hay un color seleccionelo
				$color = Color::model()->findByPk($cantcolor[0]);							
				$datos=$datos. "<div value='solo' id=".$color->id." style='cursor: pointer' class='coloress active' title='".$color->valor."'><img src='".Yii::app()->baseUrl."/images/".Yii::app()->language."/colores/".$color->path_image."'></div>"; 		
			}
			else{
				foreach ($producto->preciotallacolor as $talCol) {
		        	if($talCol->cantidad > 0){ // que haya disp
						$color = Color::model()->findByPk($talCol->color_id);		
								
						if(in_array($color->id, $valores)){	// no hace nada para que no se repita el valor			
						}
						else{
							$datos=$datos. "<div id=".$color->id." style='cursor: pointer' class='coloress' title='".$color->valor."'><img src='".Yii::app()->baseUrl."/images/".Yii::app()->language."/colores/".$color->path_image."'></div>"; 
							array_push($valores, $color->id);
						}
					}
		   		}
				
			} // else 
		
		//$datos=$datos.'<div title="Rojo" class="coloress" style="cursor: pointer" id="8"><img src="/site/images/colores/C_Rojo.jpg"></div>              </div>';
        $datos=$datos.'</div></div>';
		
        $datos=$datos.'<div class="span6">';
        $datos=$datos.'<h5>Tallas</h5>';
		$datos=$datos.'<div class="clearfix tallas" id="vTa">';
		
		$valores = Array();
		$canttallas= Array();
        $cont2 = 0;
              	
		// revisando cuantas tallas distintas hay
		foreach ($producto->preciotallacolor as $talCol){ 
			if($talCol->cantidad > 0){
				$talla = Talla::model()->findByPk($talCol->talla_id);
						
				if(in_array($talla->id, $canttallas)){	// no hace nada para que no se repita el valor			
				}
				else{
					array_push($canttallas, $talla->id);
					$cont2++;
				}
							
			}
		}

		if( $cont2 == 1){ // Si solo hay un color seleccionelo
			$talla = Talla::model()->findByPk($canttallas[0]);
			$datos=$datos. "<div value='solo' id=".$talla->id." style='cursor: pointer' class='tallass active' title='talla'>".$talla->valor."</div>"; 
		}
		else{            	
			foreach ($producto->preciotallacolor as $talCol) {
	        	if($talCol->cantidad > 0){ // que haya disp
					$talla = Talla::model()->findByPk($talCol->talla_id);
		
					if(in_array($talla->id, $valores)){	// no hace nada para que no se repita el valor			
					}
					else{
						$datos=$datos. "<div id=".$talla->id." style='cursor: pointer' class='tallass' title='talla'>".$talla->valor."</div>"; 
						array_push($valores, $talla->id);
					}
				}
	   		}	
	   	}// else
		
       // $datos=$datos.'<div title="talla" class="tallass" style="cursor: pointer" id="10">S</div>';         	     	
        $datos=$datos.'</div></div></div>';
          
        $datos=$datos.'</div>';
        $datos=$datos.'</div>';
   
   		$datos=$datos.'</div>';
    	$datos=$datos.'<div class="modal-footer">';
    	$datos=$datos.'<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>';
    	$datos=$datos.'</div>';
    //	$datos=$datos.'</div>';
    
    	$datos=$datos."<script>";
		
		$datos=$datos."$(document).ready(function() {";
			$datos=$datos."$('.coloress').click(function(ev){"; // Click en alguno de los colores -> cambia las tallas disponibles para el color
				$datos=$datos."ev.preventDefault();";
				//$datos=$datos."alert($(this).attr('id'));";
				
				$datos=$datos.' var prueba = $("#vTa div.tallass.active").attr("value");';
			$datos=$datos."if(prueba == 'solo'){";
   				$datos=$datos."$(this).addClass('coloress active');"; // añado la clase active al seleccionado
   				$datos=$datos."$('#vTa div.tallass.active').attr('value','0');";
			$datos=$datos.'}';
   			$datos=$datos.'else{';
				$datos=$datos.'$("#vCo").find("div").siblings().removeClass("active");'; // para quitar el active en caso de que ya alguno estuviera seleccionado
   				$datos=$datos.'var dataString = $(this).attr("id");';
     			$datos=$datos.'var prod = $("#producto").attr("value");';
     			$datos=$datos."$(this).removeClass('coloress');";
  				$datos=$datos."$(this).addClass('coloress active');"; // añado la clase active al seleccionado
				
  				$datos=$datos. CHtml::ajax(array(
            		'url'=>array('/producto/tallaspreview'),
		            'data'=>array('idTalla'=>"js:$(this).attr('id')",'idProd'=>$id),
		            'type'=>'post',
		            'dataType'=>'json',
		            'success'=>"function(data)
		            {
						//alert(data.datos);
						
						$('#vTa').fadeOut(100,function(){
			     			$('#vTa').html(data.datos); // cambiando el div
			     		});
			
			      		$('#vTa').fadeIn(20,function(){});
						
						$('#carruselImag').fadeOut(100,function(){
			     			$('#carruselImag').html(data.imagenes); 
			     		});
			
			      		$('#carruselImag').fadeIn(20,function(){});
						
						//$('#carruselImag').html(data.imagenes);
						
		 				
		            } ",
		            ));
		    	$datos=$datos." return false; ";

				
				$datos=$datos.'}'; // else
				
			$datos=$datos."});";// coloress click
			
			
		$datos=$datos.'$(".tallass").click(function(ev){ '; // click en tallas -> recarga los colores para esa talla
			$datos=$datos."ev.preventDefault();";
			//$datos=$datos."alert($(this).attr('id'));";
		
			$datos=$datos.'var prueba = $("#vCo div.coloress.active").attr("value");';

   			$datos=$datos."if(prueba == 'solo'){";
   				$datos=$datos."$(this).addClass('tallass active');"; // añado la clase active al seleccionado
   				$datos=$datos.'$("#vCo div.coloress.active").attr("value","0");';
   			$datos=$datos."}";
   			$datos=$datos."else{";
		   		$datos=$datos.'$("#vTa").find("div").siblings().removeClass("active");'; // para quitar el active en caso de que ya alguno estuviera seleccionado
		   		$datos=$datos.'var dataString = $(this).attr("id");';
     			$datos=$datos.'var prod = $("#producto").attr("value");';
     
     			$datos=$datos."$(this).removeClass('tallass');";
  				$datos=$datos."$(this).addClass('tallass active');"; // añado la clase active al seleccionado
     
     			$datos=$datos. CHtml::ajax(array(
            		'url'=>array('/producto/colorespreview'),
		            'data'=>array('idColor'=>"js:$(this).attr('id')",'idProd'=>$id),
		            'type'=>'post',
		            'dataType'=>'json',
		            'success'=>"function(data)
		            {
						//alert(data.datos);
						
						$('#vCo').fadeOut(100,function(){
			     			$('#vCo').html(data.datos); // cambiando el div
			     		});
			
				      	$('#vCo').fadeIn(20,function(){});				

		            } ",
		            ));
		    		$datos=$datos." return false; ";     
     
				$datos=$datos."}"; //else
			$datos=$datos."});"; // tallas click
			
		$datos=$datos."});"; // ready
		
		// fuera del ready
		
		$datos=$datos."function a(id){";// seleccion de talla
			$datos=$datos.'$("#vTa").find("div").siblings().removeClass("active");';
			$datos=$datos.'$("#vTa").find("div#"+id+".tallass").removeClass("tallass");';
			$datos=$datos.'$("#vTa").find("div#"+id).addClass("tallass active");';
   		$datos=$datos."}";
   
   		$datos=$datos."function b(id){"; // seleccion de color
   			$datos=$datos.'$("#vCo").find("div").siblings().removeClass("active");';
   			$datos=$datos.'$("#vCo").find("div#"+id+".coloress").removeClass("coloress");';
			$datos=$datos.'$("#vCo").find("div#"+id).addClass("coloress active");';		
   		$datos=$datos."}";
		
		$datos=$datos."function c(){"; // comprobar quienes están seleccionados
   		
   			$datos=$datos.'var talla = $("#vTa").find(".tallass.active").attr("id");';
   			$datos=$datos.'var color = $("#vCo").find(".coloress.active").attr("id");';
   			$datos=$datos.'var producto = $("#producto").attr("value");';
   		
   			// llamada ajax para el controlador de bolsa
 		  
 			$datos=$datos."if(talla==undefined && color==undefined){"; // ninguno
 				$datos=$datos.'alert("Seleccione talla y color para poder añadir.");';
 			$datos=$datos."}";
 		
 			$datos=$datos."if(talla==undefined && color!=undefined){"; // falta talla 
 				$datos=$datos.'alert("Seleccione la talla para poder añadir a la bolsa.");';
 			$datos=$datos.'}';
 		
 			$datos=$datos.'if(talla!=undefined && color==undefined){'; // falta color
 				$datos=$datos.'alert("Seleccione el color para poder añadir a la bolsa.");';
 			$datos=$datos.'}';
		
			$datos=$datos.'if(talla!=undefined && color!=undefined){';
		
				$datos=$datos. CHtml::ajax(array(
	            	'url'=>array('/bolsa/agregar'),
			        'data'=>array('producto'=>$id,'talla'=>'js:$("#vTa").find(".tallass.active").attr("id")','color'=>'js:$("#vCo").find(".coloress.active").attr("id")'),
			        'type'=>'post',
			        'success'=>"function(data)
			        {
						if(data=='ok'){
							//alert('redireccionar mañana');
							window.location='../../bolsa/index';
						}
						
						if(data=='no es usuario'){
							alert('Debes primero ingresar con tu cuenta de usuario o registrarte');
						}
						
			        } ",
		   		));
				$datos=$datos." return false; ";     
 			$datos=$datos.'}'; // cerro   
			
		$datos=$datos.'}'; // c
			
    $datos=$datos."</script>";
		
	echo $datos;
	}
		
	
	
	public function actionModalshopper($id)
	{ 
		
		$datos="";
		
		$producto = Producto::model()->findByPk($id);
		
		//$datos=$datos."<div id='myModal' class='modal hide tienda_modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>";
    	$datos=$datos."<div class='modal-header'>";
		$datos=$datos."<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>";
		$datos=$datos."<h3 id='myModalLabel'>".$producto->nombre."</h3></div>";
		$datos=$datos."<div class='modal-body'>";
   
   		$datos=$datos."<div class='row-fluid'>";
   		$datos=$datos."<div class='span7'><div class='carousel slide' id='myCarousel'>";
		$datos=$datos."<ol class='carousel-indicators'>";
		$datos=$datos."<li class='' data-slide-to='0' data-target='#myCarousel'></li>";
		$datos=$datos.'<li data-slide-to="1" data-target="#myCarousel" class="active"></li>';
        $datos=$datos.'<li data-slide-to="2" data-target="#myCarousel" class=""></li>';
       	$datos=$datos.'</ol>';
        $datos=$datos.'<div class="carousel-inner" id="carruselImag">';
       // $datos=$datos.'<div class="item">';
		
		$ima = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$producto->id),array('order'=>'orden ASC'));
		
		foreach ($ima as $img){
					
			if($img->orden==1)
			{ 
				$colorPredet = $img->color_id;
				
				$datos=$datos.'<div class="item active">';	
				$datos=$datos. CHtml::image($img->getUrl(array('ext'=>'jpg')), $producto->nombre, array("width" => "450", "height" => "450"));
				$datos=$datos.'</div>';
			}
				
			if($img->orden!=1){
				if($colorPredet == $img->color_id)
				{
					$datos=$datos.'<div class="item">';
					$datos=$datos.CHtml::image($img->getUrl(array('ext'=>'jpg')), $producto->nombre, array("width" => "450", "height" => "450"));
					$datos=$datos.'</div>';
				}
			}// que no es la primera en el orden
		}
		
        $datos=$datos.'</div>';
        $datos=$datos.'<a data-slide="prev" href="#myCarousel" class="left carousel-control">‹</a>';
        $datos=$datos.'<a data-slide="next" href="#myCarousel" class="right carousel-control">›</a>';
        $datos=$datos.'</div></div>';
        
        $datos=$datos.'<div class="span5">';
        $datos=$datos.'<div class="row-fluid call2action">';
       	$datos=$datos.'<div class="span7">';
		
		foreach ($producto->precios as $precio) {
   			$datos=$datos.'<h4 class="precio"><span>Subtotal</span> Bs. '.Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento).'</h4>';
   		}

        $datos=$datos.'</div>';
        
        $datos=$datos.'<div class="span5">';
        $datos=$datos.'<a class="btn btn-warning btn-block" title="agregar a la bolsa" id="agregar" onclick="c()"> Comprar </a>';
        $datos=$datos.'</div></div>';
        
        $datos=$datos.'<p class="muted t_small CAPS">Selecciona Color y talla </p>';
        $datos=$datos.'<div class="row-fluid">';
        $datos=$datos.'<div class="span6">';
        $datos=$datos.'<h5>Colores</h5>';
        $datos=$datos.'<div class="clearfix colores" id="vCo">';
        
        	$valores = Array();
            $cantcolor = Array();
            $cont1 = 0;
              	
			// revisando cuantos colores distintos hay
			foreach ($producto->preciotallacolor as $talCol){ 
				if($talCol->cantidad > 0){
					$color = Color::model()->findByPk($talCol->color_id);
					
					if(in_array($color->id, $cantcolor)){	// no hace nada para que no se repita el valor			
					}
					else {
						array_push($cantcolor, $color->id);
						$cont1++;
					}	
				}
			}
				
			if( $cont1 == 1){ // Si solo hay un color seleccionelo
				$color = Color::model()->findByPk($cantcolor[0]);							
				$datos=$datos. "<div value='solo' id=".$color->id." style='cursor: pointer' class='coloress active' title='".$color->valor."'><img src='".Yii::app()->baseUrl."/images/".Yii::app()->language."/colores/".$color->path_image."'></div>"; 		
			}
			else{
				foreach ($producto->preciotallacolor as $talCol) {
		        	if($talCol->cantidad > 0){ // que haya disp
						$color = Color::model()->findByPk($talCol->color_id);		
								
						if(in_array($color->id, $valores)){	// no hace nada para que no se repita el valor			
						}
						else{
							$datos=$datos. "<div id=".$color->id." style='cursor: pointer' class='coloress' title='".$color->valor."'><img src='".Yii::app()->baseUrl."/images/".Yii::app()->language."/colores/".$color->path_image."'></div>"; 
							array_push($valores, $color->id);
						}
					}
		   		}
				
			} // else 
		
		//$datos=$datos.'<div title="Rojo" class="coloress" style="cursor: pointer" id="8"><img src="/site/images/colores/C_Rojo.jpg"></div>              </div>';
        $datos=$datos.'</div></div>';
		
        $datos=$datos.'<div class="span6">';
        $datos=$datos.'<h5>Tallas</h5>';
		$datos=$datos.'<div class="clearfix tallas" id="vTa">';
		
		$valores = Array();
		$canttallas= Array();
        $cont2 = 0;
              	
		// revisando cuantas tallas distintas hay
		foreach ($producto->preciotallacolor as $talCol){ 
			if($talCol->cantidad > 0){
				$talla = Talla::model()->findByPk($talCol->talla_id);
						
				if(in_array($talla->id, $canttallas)){	// no hace nada para que no se repita el valor			
				}
				else{
					array_push($canttallas, $talla->id);
					$cont2++;
				}
							
			}
		}

		if( $cont2 == 1){ // Si solo hay un color seleccionelo
			$talla = Talla::model()->findByPk($canttallas[0]);
			$datos=$datos. "<div value='solo' id=".$talla->id." style='cursor: pointer' class='tallass active' title='talla'>".$talla->valor."</div>"; 
		}
		else{            	
			foreach ($producto->preciotallacolor as $talCol) {
	        	if($talCol->cantidad > 0){ // que haya disp
					$talla = Talla::model()->findByPk($talCol->talla_id);
		
					if(in_array($talla->id, $valores)){	// no hace nada para que no se repita el valor			
					}
					else{
						$datos=$datos. "<div id=".$talla->id." style='cursor: pointer' class='tallass' title='talla'>".$talla->valor."</div>"; 
						array_push($valores, $talla->id);
					}
				}
	   		}	
	   	}// else
		
        $datos=$datos.'</div></div></div> <div class="row-fluid"> <hr/> ';
		$marca = Marca::model()->findByPk($producto->marca_id);
        $datos=$datos.'<h5>Marca</h5>';
        $datos=$datos.'<div class="thumbnails">';
        $datos=$datos.'<img width="66px" height="66px" src="'.Yii::app()->baseUrl .'/images/'.Yii::app()->language.'/marca/'. str_replace(".","_thumb.",$marca->urlImagen).'"/>';
        $datos=$datos.'</div>';
        $datos=$datos.'</div></div></div>';
        $datos=$datos.'</div>';
   
   		$datos=$datos.'</div>';
    	$datos=$datos.'<div class="modal-footer">';
		$datos=$datos.'<a href="'.$producto->getUrl().'" class="btn btn-info pull-left"> Ver el producto </a>';
    	$datos=$datos.'<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>';
    	$datos=$datos.'</div>';
    
    	$datos=$datos."<script>";
		
		$datos=$datos."$(document).ready(function() {";
			$datos=$datos."$('.coloress').click(function(ev){"; // Click en alguno de los colores -> cambia las tallas disponibles para el color
				$datos=$datos."ev.preventDefault();";
				//$datos=$datos."alert($(this).attr('id'));";
				
				$datos=$datos.' var prueba = $("#vTa div.tallass.active").attr("value");';
			$datos=$datos."if(prueba == 'solo'){";
   				$datos=$datos."$(this).addClass('coloress active');"; // añado la clase active al seleccionado
   				$datos=$datos."$('#vTa div.tallass.active').attr('value','0');";
			$datos=$datos.'}';
   			$datos=$datos.'else{';
				$datos=$datos.'$("#vCo").find("div").siblings().removeClass("active");'; // para quitar el active en caso de que ya alguno estuviera seleccionado
   				$datos=$datos.'var dataString = $(this).attr("id");';
     			$datos=$datos.'var prod = $("#producto").attr("value");';
     			$datos=$datos."$(this).removeClass('coloress');";
  				$datos=$datos."$(this).addClass('coloress active');"; // añado la clase active al seleccionado
				
  				$datos=$datos. CHtml::ajax(array(
            		'url'=>array('/producto/tallaspreview'),
		            'data'=>array('idTalla'=>"js:$(this).attr('id')",'idProd'=>$id),
		            'type'=>'post',
		            'dataType'=>'json',
		            'success'=>"function(data)
		            {
						//alert(data.datos);
						
						$('#vTa').fadeOut(100,function(){
			     			$('#vTa').html(data.datos); // cambiando el div
			     		});
			
			      		$('#vTa').fadeIn(20,function(){});
						
						$('#carruselImag').fadeOut(100,function(){
			     			$('#carruselImag').html(data.imagenes); 
			     		});
			
			      		$('#carruselImag').fadeIn(20,function(){});
						
						//$('#carruselImag').html(data.imagenes);
						
		 				
		            } ",
		            ));
		    	$datos=$datos." return false; ";

				
				$datos=$datos.'}'; // else
				
			$datos=$datos."});";// coloress click
			
			
		$datos=$datos.'$(".tallass").click(function(ev){ '; // click en tallas -> recarga los colores para esa talla
			$datos=$datos."ev.preventDefault();";
			//$datos=$datos."alert($(this).attr('id'));";
		
			$datos=$datos.'var prueba = $("#vCo div.coloress.active").attr("value");';

   			$datos=$datos."if(prueba == 'solo'){";
   				$datos=$datos."$(this).addClass('tallass active');"; // añado la clase active al seleccionado
   				$datos=$datos.'$("#vCo div.coloress.active").attr("value","0");';
   			$datos=$datos."}";
   			$datos=$datos."else{";
		   		$datos=$datos.'$("#vTa").find("div").siblings().removeClass("active");'; // para quitar el active en caso de que ya alguno estuviera seleccionado
		   		$datos=$datos.'var dataString = $(this).attr("id");';
     			$datos=$datos.'var prod = $("#producto").attr("value");';
     
     			$datos=$datos."$(this).removeClass('tallass');";
  				$datos=$datos."$(this).addClass('tallass active');"; // añado la clase active al seleccionado
     
     			$datos=$datos. CHtml::ajax(array(
            		'url'=>array('/producto/colorespreview'),
		            'data'=>array('idColor'=>"js:$(this).attr('id')",'idProd'=>$id),
		            'type'=>'post',
		            'dataType'=>'json',
		            'success'=>"function(data)
		            {
						//alert(data.datos);
						
						$('#vCo').fadeOut(100,function(){
			     			$('#vCo').html(data.datos); // cambiando el div
			     		});
			
				      	$('#vCo').fadeIn(20,function(){});				

		            } ",
		            ));
		    		$datos=$datos." return false; ";     
     
				$datos=$datos."}"; //else
			$datos=$datos."});"; // tallas click
			
		$datos=$datos."});"; // ready
		// fuera del ready
		  
		$datos=$datos."function a(id){";// seleccion de talla
			$datos=$datos.'$("#vTa").find("div").siblings().removeClass("active");';
			$datos=$datos.'$("#vTa").find("div#"+id+".tallass").removeClass("tallass");';
			$datos=$datos.'$("#vTa").find("div#"+id).addClass("tallass active");';
   		$datos=$datos."}";
   
   		$datos=$datos."function b(id){"; // seleccion de color
   			$datos=$datos.'$("#vCo").find("div").siblings().removeClass("active");';
   			$datos=$datos.'$("#vCo").find("div#"+id+".coloress").removeClass("coloress");';
			$datos=$datos.'$("#vCo").find("div#"+id).addClass("coloress active");';		
   		$datos=$datos."}";
		
		$datos=$datos."function c(){"; // comprobar quienes están seleccionados
   		
   			$datos=$datos.'var talla = $("#vTa").find(".tallass.active").attr("id");';
   			$datos=$datos.'var color = $("#vCo").find(".coloress.active").attr("id");';
   			$datos=$datos.'var producto = $("#producto").attr("value");';
   		 
   			// llamada ajax para el controlador de bolsa
 		  
 			$datos=$datos."if(talla==undefined && color==undefined){"; // ninguno
 				$datos=$datos.'alert("Seleccione talla y color para poder añadir.");';
 			$datos=$datos."}";
 		
 			$datos=$datos."if(talla==undefined && color!=undefined){"; // falta talla 
 				$datos=$datos.'alert("Seleccione la talla para poder añadir a la bolsa.");';
 			$datos=$datos.'}';
 		
 			$datos=$datos.'if(talla!=undefined && color==undefined){'; // falta color
 				$datos=$datos.'alert("Seleccione el color para poder añadir a la bolsa.");';
 			$datos=$datos.'}';
		
			$datos=$datos.'if(talla!=undefined && color!=undefined){';
		
				$datos=$datos. CHtml::ajax(array(
	            	'url'=>array('/bolsa/agregar'),
			        'data'=>array('producto'=>$id,'talla'=>'js:$("#vTa").find(".tallass.active").attr("id")','color'=>'js:$("#vCo").find(".coloress.active").attr("id")'),
			        'type'=>'post',
			        'success'=>"function(data)
			        {
						if(data=='ok'){
							//alert('redireccionar mañana');
							window.location='".Yii::app()->baseUrl."/bolsa/index'; 
						}
						
						if(data=='no es usuario'){
							alert('Debes primero ingresar con tu cuenta de usuario o registrarte');
						}
						
			        } ",
		   		));
				$datos=$datos." return false; ";     
 			$datos=$datos.'}'; // cerro   
			
		$datos=$datos.'}'; // c
			
    $datos=$datos."</script>";
		
	echo $datos;
	}


        /*Vista donde se administran todos los perfiles creados, para editarlos o borrarlos*/
        public function actionTusPerfiles() {
            if(isset($_POST['id'])){
                $filter = Filter::model()->findByPk($_POST['id']);                
                
                if($filter){ 
                    
                   $filter->delete(); 
                   Yii::app()->user->updateSession();
                   Yii::app()->user->setFlash('success', 'Se ha eliminado el filtro <b>'.
                           $filter->name.'</b>');
                    
                }else{
                  Yii::app()->user->updateSession();
                   Yii::app()->user->setFlash('error', 'Filtro no encontrado');
                }               
                
                
            }
            $this->render("tusperfiles");
            
            
        }
		
        /*Muestra el panel de ventas de una PS, datos referentes a comisiones*/
        public function actionMisVentas() {
            $personalShopper = $this->loadUser();                    
       
            if($personalShopper===null)
                    throw new CHttpException(404,'The requested page does not exist.');

            $producto = new OrdenHasProductotallacolor;

            /*Consultar los productos vendidos por la actual PS*/
            $dataProvider = $producto->vendidosComision(Yii::app()->user->id);

            $this->render('misVentas',array(
                        'personalShopper' => $personalShopper,
                        'dataProvider'=>$dataProvider,
            ));	
        }
			
		
	
}
