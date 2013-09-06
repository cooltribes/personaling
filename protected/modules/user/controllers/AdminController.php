<?php

class AdminController extends Controller
{
	public $defaultAction = 'admin';
	public $layout='//layouts/column2';
	
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions

				'actions'=>array('admin','delete','create','update',
                                    'view','corporal','estilos','pedidos','carrito',
                                    'direcciones','avatar', 'productos', 'looks','toggle_ps',
                                    'toggle_admin','resendvalidationemail','toggle_banned','contrasena'),

								//'users'=>array('admin'),
				'expression' => 'UserModule::isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
            $model = new User('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['User']))
                $model->attributes = $_GET['User'];

            $criteria = new CDbCriteria;

            if (isset($_GET['nombre'])) {
                //$model->nom=$_POST['nombre'];
                $criteria->alias = 'User';
                $criteria->join = 'JOIN tbl_profiles p ON User.id = p.user_id AND (p.first_name LIKE "%' . $_GET['nombre'] . '%" OR p.last_name LIKE "%' . $_GET['nombre'] . '%" OR User.email LIKE "%' . $_GET['nombre'] . '%")';
            }

            $dataProvider = new CActiveDataProvider('User', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => Yii::app()->getModule('user')->user_page_size,
                ),
            ));

            //Modelos para el formulario de crear Usuario
            $modelUser = new User;
            $profile = new Profile;
            $profile->regMode = true;

            if (isset($_POST['ajax']) && $_POST['ajax'] === 'newUser-form') {
                echo UActiveForm::validate(array($modelUser, $profile));
                Yii::app()->end();
            }

            if (isset($_POST['User']) && isset($_POST['Profile']) && isset($_POST['tipoUsuario']) && isset($_POST['genero'])) {

                $modelUser->attributes = $_POST['User'];
                $modelUser->username = $modelUser->email;
                $modelUser->password = $this->passGenerator();
                $modelUser->activkey = Yii::app()->controller->module->encrypting(microtime() . $modelUser->password);

                if ($_POST['tipoUsuario'] == 1) { //personalShopper
                    $modelUser->personal_shopper = 1;
                } else if ($_POST['tipoUsuario'] == 2) { //Admin
                    $modelUser->superuser = 1;
                }

                $profile->attributes = $_POST['Profile'];
                $profile->user_id = 0;                
    //            
                $profile->sex = $_POST['genero'];



                if ($modelUser->validate() && $profile->validate()) {
                    
                    $originalPass = $modelUser->password;
                    $modelUser->password = Yii::app()->controller->module->encrypting($modelUser->password);

                    if ($modelUser->save()) {
                        $profile->user_id = $modelUser->id;
                        $profile->save();

                        Yii::app()->user->updateSession();
                        Yii::app()->user->setFlash('success', UserModule::t("El usuario ha sido creado."));

                        //Enviar Correo
                        
                        $activation_url = $this->createAbsoluteUrl('/user/activation/activation', array("activkey" => $modelUser->activkey, "email" => $modelUser->email));

                        $message = new YiiMailMessage;
                        $message->view = "mail_template";
                        $subject = 'Registro Personaling';
                        $body = '<h2>Te damos la bienvenida a Personaling.</h2>' . 
                                '<br/>Tu contraseña provisional es: <strong>'.$originalPass.'</strong><br/>' .
                                'Puedes cambiarla accediento a tu cuenta y luego haciendo click '. 
                                'en la opción Cambiar Contraseña.<br/><br/>Recibes este correo porque se'.
                                'ha registrado tu dirección en Personaling.'. 
                                'Por favor valida tu cuenta haciendo click en el enlace que aparece a continuación:<br/>  <a href="'.$activation_url.'">Haz click aquí</a>';
                        $params = array('subject' => $subject, 'body' => $body);
                        $message->subject = $subject;
                        $message->setBody($params, 'text/html');
                        $message->addTo($modelUser->email);
                        $message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
                        Yii::app()->mail->send($message);

                        $modelUser->unsetAttributes();
                        $profile->unsetAttributes();
                        $profile->day = $profile->month = $profile->month = '';
                    }
                    //$this->redirect(array('view','id'=>$model->id));
                } else {
                    $profile->validate();
                    $profile->birthday = '';
                    Yii::app()->user->updateSession();
                    Yii::app()->user->setFlash('error', UserModule::t("Ha habido un error creando el usuario."));

    //             echo "<pre>";
    //            print_r($modelUser->getErrors());
    //            echo "</pre><br>";
    //            echo "<pre>";
    //            print_r($profile->getErrors());
    //            echo "</pre><br>";
    //            exit();
                }
            }
            $this->render('index', array(
                'model' => $model,
                'modelUser' => $modelUser,
                'profile' => $profile,
                'dataProvider' => $dataProvider,
            ));
        
	}


	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}

	public function actionToggle_admin($id){
		$model = User::model()->findByPk($id);
		$model->superuser = 1-$model->superuser; // hacer el toggle
		if ($model->save()){
		echo CJSON::encode(array(
	            'status'=>'success',
	            'admin'=>$model->superuser,
	     ));	
	     }else{
	     	Yii::trace('AdminController:100 Error toggle:'.print_r($model->getErrors(),true), 'registro');
			echo CJSON::encode(array(
	            'status'=>'error',
	            'admin'=>$model->superuser,
	     ));
	     }
	}
	
	public function actionToggle_ps($id){
		$model = User::model()->findByPk($id);
		$model->personal_shopper = 1-$model->personal_shopper; // hacer el toggle
		if ($model->save()){
		echo CJSON::encode(array(
	            'status'=>'success',
	            'personal_shopper'=>$model->personal_shopper,
	     ));	
	     }else{
	     	Yii::trace('AdminController:117 Error toggle:'.print_r($model->getErrors(),true), 'registro');
			echo CJSON::encode(array(
	            'status'=>'error',
	            'personal_shopper'=>$model->personal_shopper,
	     ));
	     }
	}
       /**
        * Bloquear al usuario, queda en estado STATUS_BANNED
        * @param int $id id del usuario
        * 
        */ 
       public function actionToggle_banned($id) {
            $model = User::model()->findByPk($id);
            $model->status = -($model->status);

            if ($model->save()) {
                echo CJSON::encode(array(
                    'status' => 'success',
                    'user_status' => User::getStatus($model->status),
                ));
            } else {
                Yii::trace('AdminController:118 Error Toggle_banned:' . print_r($model->getErrors(), true), 'registro');
                echo CJSON::encode(array(
                    'status' => 'error',
                    'error' => $model->getErrors(),
                ));
            }
           
        }
        
        
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;
		$profile=new Profile;
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
			$profile->attributes=$_POST['Profile'];
			$profile->user_id=0;
			if($model->validate()&&$profile->validate()) {
				$model->password=Yii::app()->controller->module->encrypting($model->password);
				if($model->save()) {
					$profile->user_id=$model->id;
					$profile->save();
				}
				//$this->redirect(array('view','id'=>$model->id));
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
			} else $profile->validate();
		}

		$this->render('create',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}

	public function actionEstilos()
	{
		$model=$this->loadModel();
		$profile=$model->profile;
		$profile->profile_type = 2;
if(isset($_POST['Profile']))
		{
			//$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($profile->validate()) {
				
				
				$profile->save();
				//$this->redirect(array('view','id'=>$model->id));
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
			} else $profile->validate();
		}		
		$this->render('estilos',array(
			'model'=>$model,
			'profile'=>$profile,
		));		
	}
	
	public function actionLooks($id)
	{
		$model=$this->loadModel();
		$criteria=new CDbCriteria;
		$criteria->condition = 'user_id = '.$id;
		
        $dataProvider = new CActiveDataProvider('LookEncantan', array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
		
		$this->render('looks',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionPedidos($id)
	{
		$model=$this->loadModel();
		$criteria=new CDbCriteria;
		$criteria->condition = 'user_id = '.$id;
		
        $dataProvider = new CActiveDataProvider('Orden', array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
		
		$this->render('pedidos',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionProductos($id)
	{
		$model=$this->loadModel();
		$criteria=new CDbCriteria;
		$criteria->condition = 'user_id = '.$id;
		
        $dataProvider = new CActiveDataProvider('UserEncantan', array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
		
		$this->render('productos',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionDirecciones()
	{
		$model=$this->loadModel();
		$this->render('direcciones',array(
			'model'=>$model,
			
		));
	}
	public function actionAvatar()
	{
		$model=$this->loadModel();
		$this->render('avatar',array(
			'model'=>$model,
			
		));
	}
			
	public function actionCarrito($id)
	{
		$model=$this->loadModel();
		$bolsa = Bolsa::model()->findByAttributes(array('user_id'=>$id));
		$this->render('carrito',array(
			'model'=>$model,
			'bolsa'=>$bolsa,
			'usuario'=>$id,
		));
	}
	public function actionCorporal()
	{
		$model=$this->loadModel();
		$profile=$model->profile;
		$profile->profile_type = 3;
		$this->performAjaxValidation(array($profile));
if(isset($_POST['Profile']))
		if(isset($_POST['Profile']))
		{
			//$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($profile->validate()) {
				
				
				if ($profile->save()){
				//$this->redirect(array('view','id'=>$model->id));
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
					} else {
					Yii::trace('username:'.$model->username.' Error:'.print_r($profile->getErrors(),true), 'registro');
				}
				
			} else{
				//echo CActiveForm::validate($profile);
				 $profile->validate();
				// echo 'RAFA';
				//Yii::app()->end(); 
			}
		}		
		$this->render('corporal',array(
			'model'=>$model,
			'profile'=>$profile,
		));		
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		$profile=$model->profile;
		$profile->profile_type = 1;
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($model->validate()&&$profile->validate()) {
				$old_password = User::model()->notsafe()->findByPk($model->id);
				if ($old_password->password!=$model->password) {
					$model->password=Yii::app()->controller->module->encrypting($model->password);
					$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
				}
				$model->save();
				$profile->save(); 
				
				//$this->redirect(array('view','id'=>$model->id));
				
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
			} else $profile->validate();
		}

		$this->render('update',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}

	public function actionReSendValidationEmail($id)
	{
		

			$model = User::model()->notsafe()->findByPk( $id );
			$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email));
			
			$message            = new YiiMailMessage;
			$message->view = "mail_template";
			$subject = 'Activa tu cuenta en Personaling';
			$body = '<h2>Te damos la bienvenida a Personaling.</h2><br/><br/>Recibes este correo porque se ha registrado tu dirección en Personaling. Por favor valida tu cuenta haciendo click en el enlace que aparece a continuación:<br/> <br/>  <a href="'.$activation_url.'">Haz click aquí</a>';			
			$params              = array('subject'=>$subject, 'body'=>$body);
			$message->subject    = $subject;
			$message->setBody($params, 'text/html');                
			$message->addTo($model->email);
			$message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
			Yii::app()->mail->send($message);
			Yii::app()->user->setFlash('success',"El email de verificacion ha sido reenviado a <strong>".$model->email."</strong>");
			$this->redirect(array('/user/admin'));
		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel();
			$profile = Profile::model()->findByPk($model->id);
			$profile->delete();
			$model->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('/user/admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($validate)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($validate);
            Yii::app()->end();
        }
    }
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
        
   	protected function passGenerator($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $n = strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $n - 1);
            $result .= substr($chars, $index, 1);
        }

        return $result;
    }
	
	public function actionContrasena(){
		$html="";	
		if(isset($_POST['id'])&&!isset($_POST['psw']))
			{	$id=$_POST['id'];
				
				$html='<div class="modal-header">';
		    	$html=$html.'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
		    	$html=$html.'<h3>Cambiar Contraseña</h3>';
		  		$html=$html.'</div>';
		  		$html=$html.'<div class="modal-body">';
				$html=$html. CHtml::PasswordField('psw1','',array('id'=>'psw1','class'=>'span5','placeholder'=>'Escribe la nueva contraseña')).
				CHtml::PasswordField('psw2','',array('id'=>'psw2','class'=>'span5','placeholder'=>'Escribe la nueva contraseña')).
				"<div><a onclick='cambio(".$_POST['id'].")' class='btn btn-danger margin_bottom_medium pull-left'>Guardar Cambio</a></div></div>";
				echo $html;
			}
		if(isset($_POST['psw'])&&isset($_POST['id']))	{
				$user=User::model()->findByPk($_POST['id']);
				$user->password=Yii::app()->controller->module->encrypting($_POST['psw']);
				if($user->save()){
					Yii::app()->user->setFlash('success', UserModule::t("Cambio realizado exitosamente"));				
				}					
				
			
		}
	} 
	
}