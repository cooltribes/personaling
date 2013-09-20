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
                                    'toggle_admin','resendvalidationemail','toggle_banned','contrasena','saldo',
                                    'compra','compradir','comprapago','compraconfirm','modal','credito','editardireccion','eliminardireccion','comprafin'),

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
            
            
            
             /*********************** Para los filtros *********************/
             
            //Filtros personalizados
            $filters = array();
            
            //Para guardar el filtro
            $filter = new Filter;            
            
            if(isset($_POST['dropdown_filter'])){           
                
                //Validar y tomar sólo los filtros válidos
                for($i=0; $i < count($_POST['dropdown_filter']); $i++){
                    if($_POST['dropdown_filter'][$i] && $_POST['dropdown_operator'][$i]
                            && trim($_POST['textfield_value'][$i]) != '' && $_POST['dropdown_relation'][$i]){

                        $filters['fields'][] = $_POST['dropdown_filter'][$i];
                        $filters['ops'][] = $_POST['dropdown_operator'][$i];
                        $filters['vals'][] = $_POST['textfield_value'][$i];
                        $filters['rels'][] = $_POST['dropdown_relation'][$i];                    

                    }
                }     
                //Respuesta ajax
                $response = array();
                
                if (isset($filters['fields'])) {      
                    
                    $dataProvider = $model->buscarPorFiltros($filters);                    
                    
                     //si va a guardar
                     if (isset($_POST['save'])){                        
                         
                         //si es nuevo
                         if (isset($_POST['name'])){
                            
                            $filter = Filter::model()->findByAttributes(
                                    array('name' => $_POST['name'], 'type' => '3') //Filtros para ventas
                                    ); 
                            if (!$filter) {
                                $filter = new Filter;
                                $filter->name = $_POST['name'];
                                $filter->type = 3;
                                
                                if ($filter->save()) {
                                    for ($i = 0; $i < count($filters['fields']); $i++) {

                                        $filterDetails[] = new FilterDetail();
                                        $filterDetails[$i]->id_filter = $filter->id_filter;
                                        $filterDetails[$i]->column = $filters['fields'][$i];
                                        $filterDetails[$i]->operator = $filters['ops'][$i];
                                        $filterDetails[$i]->value = $filters['vals'][$i];
                                        $filterDetails[$i]->relation = $filters['rels'][$i];
                                        $filterDetails[$i]->save();
                                    }
                                    
                                    $response['status'] = 'success';
                                    $response['message'] = 'Filtro <b>'.$filter->name.'</b> guardado con éxito';
                                    $response['idFilter'] = $filter->id_filter;                                    
                                    
                                }
                                
                            //si ya existe
                            } else {
                                $response['status'] = 'error';
                                $response['message'] = 'No se pudo guardar el filtro, el nombre <b>"'.
                                        $filter->name.'"</b> ya existe'; 
                            }

                          /* si esta guardadndo uno existente */
                         }else if(isset($_POST['id'])){
                            
                            $filter = Filter::model()->findByPk($_POST['id']); 

                            if ($filter) {
                                
                                //borrar los existentes
                                foreach ($filter->filterDetails as $detail){
                                    $detail->delete();
                                }
                                
                                for ($i = 0; $i < count($filters['fields']); $i++) {

                                    $filterDetails[] = new FilterDetail();
                                    $filterDetails[$i]->id_filter = $filter->id_filter;
                                    $filterDetails[$i]->column = $filters['fields'][$i];
                                    $filterDetails[$i]->operator = $filters['ops'][$i];
                                    $filterDetails[$i]->value = $filters['vals'][$i];
                                    $filterDetails[$i]->relation = $filters['rels'][$i];
                                    $filterDetails[$i]->save();
                                }

                                $response['status'] = 'success';
                                $response['message'] = 'Filtro <b>'.$filter->name.'</b> guardado con éxito';                                
                            //si NO existe el ID
                            } else {
                                $response['status'] = 'error';
                                $response['message'] = 'El filtro no existe'; 
                            }
                             
                         }
                        
                         echo CJSON::encode($response); 
                         Yii::app()->end();
                         
                     }//fin si esta guardando

                //si no hay filtros válidos    
                }else if (isset($_POST['save'])){
                    $response['status'] = 'error';
                    $response['message'] = 'No has seleccionado ningún criterio para filtrar'; 
                    echo CJSON::encode($response); 
                    Yii::app()->end();
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
		
		
		if (isset($_POST['valido'])&&isset($_POST['user'])){
				$id = $_POST['user'];
			// make the directory to store the pic:
				if(!is_dir(Yii::getPathOfAlias('webroot').'/images/avatar/'. $id))
				{
	   				mkdir(Yii::getPathOfAlias('webroot').'/images/avatar/'. $id,0777,true);
	 			}	 
				$images = CUploadedFile::getInstancesByName('filesToUpload');
				 if (isset($images) && count($images) > 0) {
		            foreach ($images as $image => $pic) {
		            	$nombre = Yii::getPathOfAlias('webroot').'/images/avatar/'. $id .'/'. $image;
						$extension = '.'.$pic->extensionName;
		            	$model->avatar_url = '/images/avatar/'. $id .'/'. $image .$extension;
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
							
						}
					}
				 }  	
		} 

		 $this->render('avatar',array(
	    	'model'=>$model,
			//'profile'=>$model->profile,
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

	public function actionSaldo(){
		$html="";	
		if(isset($_POST['id'])&&!isset($_POST['cant']))
			{	$id=$_POST['id'];
				
				$saldo=Profile::model()->getSaldo($id);				
				$html='<div class="modal-header">';
		    	$html=$html.'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
		    	$html=$html.'<h3>Cargar Saldo</h3>';
		  		$html=$html.'</div>';
		  		$html=$html.'<div class="modal-body">';
				$html=$html."<div class='pull-right'><h4>Saldo Actual: ".$saldo."</h4></div>";				
				$html=$html. CHtml::TextField('cant','',array('id'=>'cant','class'=>'span5','placeholder'=>'Escribe la cantidad separando los decimales con coma (,)')).
				"<div><a onclick='saldo(".$_POST['id'].")' class='btn btn-danger margin_bottom_medium pull-left'>Cargar Cantidad</a></div></div>";
	
				echo $html;
			}
		if(isset($_POST['cant'])&&isset($_POST['id']))	{
			
				$balance=new Balance;
				$balance->total=$_POST['cant'];
				$balance->orden_id=0;
				$balance->user_id=$_POST['id'];
				$balance->tipo=3;
				if($balance->save()){
					
					Yii::app()->user->setFlash('success', UserModule::t("Carga realizada exitosamente"));				
				}
				else{
					
					Yii::app()->user->setFlash('error', UserModule::t("No se pudo realizar carga"));
				}
							
		}
	}
	
	
	public function actionCompra($id)
	{
				if(isset($_POST['ptcs'])&&$_POST['ptcs']!='nothing')
			{
								
				
				Yii::app()->session['ptcs']=$_POST['ptcs'];
				Yii::app()->session['vals']=$_POST['vals'];
				$this->redirect(array('admin/compradir'));
				
			}

			
			if(isset(Yii::app()->session['ptcs'])){
				
				unset(Yii::app()->session['ptcs']);
			}
			if(isset(Yii::app()->session['vals'])){
				
				unset(Yii::app()->session['vals']);
			}
			if(isset(Yii::app()->session['usercompra'])){
				
				unset(Yii::app()->session['usercompra']);
			}
							
			  	$q=" order by p.nombre";
			  	
	            if (isset($_POST['query']))
	            {
	                $q=" AND p.nombre LIKE '%".$_POST['query']."%' ".$q;		
				      	
	            }
				
				Yii::app()->session['usercompra']=$id;
	 
	          	$sql='select p.marca_id as Marca, ptc.talla_id as Talla, ptc.color_id as Color, ptc.id as ptcid, p.id, p.nombre as Nombre, ptc.cantidad  
					from tbl_precioTallaColor ptc, tbl_producto p 
					where ptc.cantidad >0 and p.estado=0 and p.`status`=1 and ptc.producto_id = p.id '.$q;
				$rawData=Yii::app()->db->createCommand($sql)->queryAll();
				
				$data=array();
				foreach($rawData as $row){
					$row['Marca']=Marca::model()->getMarca($row['Marca']);
					$row['Talla']=Talla::model()->getTalla($row['Talla']);
					$row['url']=Imagen::model()->getImagen($row['id'],$row['Color']);
					$row['Color']=Color::model()->getColor($row['Color']);
					$row['precioDescuento']=Precio::model()->getPrecioDescuento($row['id']);	
					array_push($data,$row);
								 				
				}
				
				// or using: $rawData=User::model()->findAll(); <--this better represents your question
	
				$dataProvider=new CArrayDataProvider($data, array(
				    'id'=>'data',
				    'pagination'=>array(
				        'pageSize'=>12,
				    ),
					 
				    'sort'=>array(
				        'attributes'=>array(
				             'Nombre', 'Marca', 'Talla', 'Color'
				        ),
	    ),
				));
				
				
				
				 
				
				
	            $this->render('compra', array(   'dataProvider'=>$dataProvider,
	            ));	
	   
		
	}
	
	
	
	
	
	
	public function actionCompradir()
		{
			$dir = new Direccion;
			
			
			if(isset($_POST['tipo']) && $_POST['tipo']=='direccionVieja')
			{
				//echo "Id:".$_POST['Direccion']['id'];
				
				Yii::app()->session['idDireccion']=$_POST['Direccion']['id'];
				
				$this->redirect(array('admin/comprapago'));
			}
			else
			if(isset($_POST['Direccion'])) // nuevo registro
			{
				//if($_POST['Direccion']['nombre']!="")
			//	{
				
				// guardar en el modelo direccion
				$dir->attributes=$_POST['Direccion'];
				
				if($dir->pais=="1")
					$dir->pais = "Venezuela";
				
				if($dir->pais=="2")
					$dir->pais = "Colombia";
				
				if($dir->pais=="3")
					$dir->pais = "Estados Unidos"; 
				
				$dir->user_id = Yii::app()->user->id;
				
					if($dir->save())
					{
						$this->render('comprapago',array('idDireccion'=>$dir->id));
						//$this->redirect(array('bolsa/pagos','id'=>$dir->id)); // redir to action Pagos
					}
					
				//} // nombre
			//	else {
					//$this->render('direcciones',array('dir'=>$dir)); // regresa
				//}
				
			}else // si está viniendo de la pagina anterior que muestre todo 
			{
				$this->render('compradir',array('dir'=>$dir));
			}
			

		}

	public function actionComprapago()
		{
	
			if(isset($_POST['idDireccion'])) // escogiendo cual es la preferencia de pago
			{ 
				$idDireccion = $_POST['idDireccion'];
				$tipoPago = $_POST['tipoPago'];
				echo "if";
				$this->render('compraconfirm',array('idDireccion'=>$idDireccion,'tipoPago'=>$tipoPago));
				//$this->redirect(array('bolsa/confirmar','idDireccion'=>$idDireccion, 'tipoPago'=>$tipoPago)); 
				// se le pasan los datos al action confirmar	
			}  // de direcciones
		
				$this->render('comprapago');
			
			
		
		}  
	public function actionCompraconfirm()
		{
			
			// viene de pagos
			//var_dump($_POST);
			if(isset($_POST['tipo_pago'])){
				Yii::app()->getSession()->add('tipoPago',$_POST['tipo_pago']);
				if(isset($_POST['usar_balance']) && $_POST['usar_balance'] == '1'){
					Yii::app()->getSession()->add('usarBalance',$_POST['usar_balance']);
				}else{
					Yii::app()->getSession()->add('usarBalance','0');
				}
				//echo '<br/>'.$_POST['tipo_pago'];
				
			}
			
			$this->render('compraconfirm');
		}
	public function actionModal()
	{
		$tarjeta = new TarjetaCredito;
		
		$datos="";
		
		$datos=$datos."<div class='modal-header'>";
		$datos=$datos."Agregar datos de tarjeta de crédito";
    	$datos=$datos."</div>";
		
		$datos=$datos."<div class='modal-body'>";
		
		$datos=$datos.'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">';
  		$datos=$datos.'<tr>';			
		$datos=$datos.'<th scope="col" colspan="3">&nbsp;</th>';
		$datos=$datos.'<th scope="col">Número</th>';		
		$datos=$datos.'<th scope="col">Nombre en la Tarjeta</th>';
		$datos=$datos.'<th scope="col">Fecha de Vencimiento</th>';
		$datos=$datos.'</tr>';	
		
		$tarjetas = TarjetaCredito::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id));
		
		if(isset($tarjetas))
		{
			foreach($tarjetas as $cada){
				
				$datos=$datos.'<tr>';
				$datos=$datos.'<td><input class="radioss" type="radio" name="optionsRadios" id="tarjeta" value="'.$cada->id.'" ></td>';
				$datos=$datos.'<td><i class="icon-picture"></i></td>';
				$datos=$datos.'<td>Mastercard</td>';
				
				$rest = substr($cada->numero, -4);
				
				$datos=$datos.'<td>XXXX XXXX XXXX '.$rest.'</td>';
				$datos=$datos.'<td>'.$cada->nombre.'</td>';
				$datos=$datos.'<td>'.$cada->vencimiento.'</td>';
				$datos=$datos.'</tr>';
			}	
			$datos=$datos.'</table>';
		}
		else
			{
				$datos=$datos.'<tr>';
				$datos=$datos.'<td>No tienes tarjetas de credito asociadas.</td>';
				$datos=$datos.'</tr>';
				$datos=$datos.'</table>';
			}	
			
		
		$datos=$datos.'<button type="button" id="nueva" class="btn btn-info btn-small" data-toggle="collapse" data-target="#collapseOne"> Agregar una nueva tarjeta </button>';
    	
		$datos=$datos.'<div class="collapse" id="collapseOne">';
		$datos=$datos.'<form class="">';
        $datos=$datos.'<h5 class="braker_bottom">Nueva tarjeta de crédito</h5>';
		
		$datos=$datos.'<div class="control-group">';
        $datos=$datos.'<div class="controls">';     
		$datos=$datos. CHtml::activeTextField($tarjeta,'nombre',array('id'=>'nombre','class'=>'span5','placeholder'=>'Nombre impreso en la tarjeta'));
        $datos=$datos.'<div style="display:none" class="help-inline"></div>';  
		$datos=$datos.'</div></div>';
    	
  		$datos=$datos.'<div class="control-group">';
        $datos=$datos.'<div class="controls">';     
		$datos=$datos. CHtml::activeTextField($tarjeta,'numero',array('id'=>'numero','class'=>'span5','placeholder'=>'Número de la tarjeta'));
        $datos=$datos.'<div style="display:none" class="help-inline"></div>';  
		$datos=$datos.'</div></div>';
  
  		$datos=$datos.'<div class="control-group">';
        $datos=$datos.'<div class="controls">';     
		$datos=$datos. CHtml::activeTextField($tarjeta,'codigo',array('id'=>'codigo','class'=>'span2','placeholder'=>'Código de seguridad'));
        $datos=$datos.'<div style="display:none" class="help-inline"></div>';  
		$datos=$datos.'</div></div>';
  
  		$datos=$datos.'<div class="control-group">';
		$datos=$datos.'<label class="control-label required">Fecha de Vencimiento</label>';
        $datos=$datos.'<div class="controls">';     
	  	$datos=$datos. CHtml::dropDownList('mes','',array('Mes'=>'Mes','01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12'),array('id'=>'mes','class'=>'span1','placeholder'=>'Mes'));
        $datos=$datos. CHtml::dropDownList('ano','',array('Ano'=>'Año','2013'=>'2013','2014'=>'2014','2015'=>'2015','2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019'),array('id'=>'ano','class'=>'span1','placeholder'=>'Año'));
        $datos=$datos.'<div style="display:none" class="help-inline"></div>';  
		$datos=$datos.'</div></div>';
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeTextField($tarjeta,'direccion',array('id'=>'direccion','class'=>'span5','placeholder'=>'Dirección')) ;
		$datos=$datos."<div style='display:none' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeTextField($tarjeta,'ciudad',array('id'=>'ciudad','class'=>'span5','placeholder'=>'Ciudad'));
        $datos=$datos."<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeTextField($tarjeta,'estado',array('id'=>'estado','class'=>'span5','placeholder'=>'Estado'));
        $datos=$datos."<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeTextField($tarjeta,'zip',array('id'=>'zip','class'=>'span2','placeholder'=>'Código Postal'));
        $datos=$datos."<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."</div>"; // modal body
		
		$datos=$datos."<div class='modal-footer'>";
		
		$datos=$datos."<div class=''><a id='boton_pago_tarjeta' onclick='enviarTarjeta()' class='pull-left btn-large btn btn-danger'> Pagar </a></div>";
    	$datos=$datos."</form>";
		$datos=$datos."</div>";
		
		$datos=$datos."<input type='hidden' id='idTarjeta' value='0' />"; // despues aqui se mandaria el id si la persona escoge una tarjeta que ya utilizó
		
		$datos=$datos."</div>"; // footer
		
		$datos=$datos."<script>";
		$datos=$datos."$(document).ready(function() {";
		
			$datos=$datos.'$("#nueva").click(function() { ';
				$datos=$datos."$('.table').find('input:radio:checked').prop('checked',false);";
				$datos=$datos.'$("#tarjeta").prop("checked", false);';
				$datos=$datos.'$("#idTarjeta").val(0);'; // lo regreso a 0 para que sea tarjeta nueva
			$datos=$datos.'});';
		
			$datos=$datos.'$(".radioss").click(function() { ';
				$datos=$datos."var numero = $(this).attr('value');";
				//$datos=$datos." alert(numero); ";
        		$datos=$datos.'$("#idTarjeta").val(numero);';
        	$datos=$datos."});";
		
		$datos=$datos."});"; 
		$datos=$datos."</script>"; 
		
		
		echo $datos;
		
		
	}

	
	
	public function actionCredito(){
		
			if(isset($_POST['tipoPago']) && $_POST['tipoPago'] == 2){ // Pago con TDC
						
					if($_POST['idCard'] == 0) // creo una tarjeta nueva
					{
						$usuario = Yii::app()->user->id; 
							
						$exp = $_POST['mes']."/".$_POST['ano'];
							
							$data_array = array(
								"Amount"=>$_POST['total'], // MONTO DE LA COMPRA
								"Description"=>"Tarjeta de Credito", // DESCRIPCION 
								"CardHolder"=>$_POST['nom'], // NOMBRE EN TARJETA
								"CardNumber"=>$_POST['num'], // NUMERO DE TARJETA
								"CVC"=>$_POST['cod'], //CODIGO DE SEGURIDAD
								"ExpirationDate"=>$exp, // FECHA DE VENCIMIENTO
								"StatusId"=>"2", // 1 = RETENER 2 = COMPRAR
								"Address"=>$_POST['dir'], // DIRECCION
								"City"=>$_POST['ciud'], // CIUDAD
								"ZipCode"=>$_POST['zip'], // CODIGO POSTAL
								"State"=>$_POST['est'], //ESTADO
							);
							
						$output = Yii::app()->curl->putPago($data_array); // se ejecuto
							
							if($output->code == 201){ // PAGO AUTORIZADO
							
								$detalle = new Detalle;
							
								$detalle->nTarjeta = $_POST['num'];
								$detalle->nTransferencia = $output->id;
								$detalle->nombre = $_POST['nom'];
								$detalle->codigo = $_POST['cod'];
								$detalle->vencimiento = $exp;
								$detalle->monto = $_POST['total'];
								$detalle->fecha = date("Y-m-d H:i:s");
								$detalle->banco = 'TDC';
								$detalle->estado = 1; // aceptado
								
								if($detalle->save()){
												
									$tarjeta = new TarjetaCredito;
								
									$tarjeta->nombre = $_POST['nom'];
									$tarjeta->numero = $detalle->nTarjeta;
									$tarjeta->codigo = $detalle->codigo;
									$tarjeta->vencimiento = $exp;
									$tarjeta->direccion = $_POST['dir'];
									$tarjeta->ciudad = $_POST['ciud'];
									$tarjeta->zip = $_POST['zip'];
									$tarjeta->estado = $_POST['est'];
									$tarjeta->user_id = $usuario;		
										
									$tarjeta->save();
									
									
									// cuando finalice entonces envia id de la orden para redireccionar
									echo CJSON::encode(array(
										'status'=> $output->code, // paso o no
										'mensaje' => $output->message,
										'idDetalle' => $detalle->id
										
									));
									
								}//detalle
								
							}// 201
							else
							{	
								// cuando finalice entonces envia id de la orden para redireccionar
								echo CJSON::encode(array(
									'status'=> $output->code, // paso o no
									'mensaje' => $output->message									
								));
									
							}
							
							//$respCard = $respCard."Success: ".$output->success."<br>"; // 0 = FALLO 1 = EXITO
						//	$respCard = $respCard."Message:".$output->success."<br>"; // MENSAJE EN EL CASO DE FALLO
						//	$respCard = $respCard."Id: ".$output->id."<br>"; // EL ID DE LA TRANSACCION
						//	$respCard = $respCard."Code: ".$output->code."<br>"; // 201 = AUTORIZADO 400 = ERROR DATOS 401 = ERROR AUTENTIFICACION 403 = RECHAZADO 503 = ERROR INTERNO

						}
						else // escogio una tarjeta
						{
							
							$card = TarjetaCredito::model()->findByPk($_POST['idCard']);
							$usuario = Yii::app()->user->id; 
							
							$data_array = array(
								"Amount"=>$_POST['total'], // MONTO DE LA COMPRA
								"Description"=>"Tarjeta de Credito", // DESCRIPCION 
								"CardHolder"=>$card->nombre, // NOMBRE EN TARJETA
								"CardNumber"=>$card->numero, // NUMERO DE TARJETA
								"CVC"=>$card->codigo, //CODIGO DE SEGURIDAD
								"ExpirationDate"=>$card->vencimiento, // FECHA DE VENCIMIENTO
								"StatusId"=>"2", // 1 = RETENER 2 = COMPRAR
								"Address"=>$card->direccion, // DIRECCION
								"City"=>$card->ciudad, // CIUDAD
								"ZipCode"=>$card->zip, // CODIGO POSTAL
								"State"=>$card->estado, //ESTADO
							);
							
						$output = Yii::app()->curl->putPago($data_array); // se ejecuto
						echo"<div style='width 500px; height:500px; font-size:25px' >";print_r($output);echo "</div>";
						
					/*	if($output->code == 201){ // PAGO AUTORIZADO
							
								$detalle = new Detalle;
							
								$detalle->nTarjeta = $card->numero;
								$detalle->nTransferencia = $output->id;
								$detalle->nombre = $card->nombre;
								$detalle->codigo = $card->codigo;
								$detalle->vencimiento = $card->vencimiento;
								$detalle->monto = $_POST['total'];
								$detalle->fecha = date("Y-m-d H:i:s");
								$detalle->banco = 'TDC';
								$detalle->estado = 1; // aceptado
								
								if($detalle->save()){
									// cuando finalice entonces envia id de la orden para redireccionar
									echo CJSON::encode(array(
										'status'=> $output->code, // paso o no
										'mensaje' => $output->message,
										'idDetalle' => $detalle->id										
									));
								}
					
							}*/
						}


					}


	

	
	}
	
		public function actionEliminardireccion()
		{
			// if(isset($_POST['idDir']))
			// {
			// 	$direccion = Direccion::model()->findByPk($_POST['idDir']);
			// 	$direccion->delete();
				
			// 	echo "ok";
			// }
			$id = $_POST['idDir'];
			$direccion = Direccion::model()->findByPk( $id  );
			$user = User::model()->findByPk( Yii::app()->user->id );
			if($user){
				$facturas1 = Factura::model()->countByAttributes(array('direccion_fiscal_id'=>$id));
				$facturas2 = Factura::model()->countByAttributes(array('direccion_envio_id'=>$id));
				
				if($facturas1 == 0 && $facturas2 == 0){
					if($direccion->delete()){
						echo "ok";
					}else{
						echo "wrong";
					}
				}else{
					echo "bad";
				}
			}
		}
		
			/**
		 * editar una direccion.
		 */
		public function actionEditardireccion()
		{
			if(isset($_POST['idDireccion'])){
				$dirEdit = Direccion::model()->findByPk($_POST['idDireccion']);
				
				$dirEdit->nombre = $_POST['Direccion']['nombre'];
				$dirEdit->apellido = $_POST['Direccion']['apellido'];
				$dirEdit->cedula = $_POST['Direccion']['cedula'];
				$dirEdit->dirUno = $_POST['Direccion']['dirUno'];
				$dirEdit->dirDos = $_POST['Direccion']['dirDos'];
				$dirEdit->telefono = $_POST['Direccion']['telefono'];
				$dirEdit->ciudad_id = $_POST['Direccion']['ciudad_id'];
				$dirEdit->provincia_id = $_POST['Direccion']['provincia_id'];
				
				if($_POST['Direccion']['pais']==1)
					$dirEdit->pais = "Venezuela";
				
				if($_POST['Direccion']['pais']==2)
					$dirEdit->pais = "Colombia";
				
				if($_POST['Direccion']['pais']==3)
					$dirEdit->pais = "Estados Unidos";
				
				if($dirEdit->save()){
					$dir = new Direccion;
					$this->redirect(array('admin/compradir')); // redir to action
					//$this->render('direcciones',array('dir'=>$dir));
					}
				
			}
			else if($_GET['id']){ // piden editarlo
				$direccion = Direccion::model()->findByAttributes(array('id'=>$_GET['id'],'user_id'=>Yii::app()->user->id));
				$this->render('editarDir',array('dir'=>$direccion));
			}
			
			
		}
	
	public function actionComprafin()
	{
		 if (Yii::app()->request->isPostRequest) // asegurar que viene en post
		 {
		 	$respCard = "";
		 	$usuario = Yii::app()->session['usercompra']; 
		
			
			if($_POST['tipoPago']==1 || $_POST['tipoPago']==4 || $_POST['tipoPago']==2){ // transferencia o MP
				
				if($_POST['tipoPago']==2)
				{
					$detalle = Detalle::model()->findByPk($_POST['idDetalle']); // si viene de tarjeta de credito trae ya el detalle listo
				}
				else
				{
					$detalle = new Detalle;
				}
			
				if($detalle->save())
				{
					$pago = new Pago;
					$pago->tipo = $_POST['tipoPago']; // trans
					$pago->tbl_detalle_id = $detalle->id;
					
					if($pago->save()){
					
					// clonando la direccion
					$dir1 = Direccion::model()->findByAttributes(array('id'=>$_POST['idDireccion'],'user_id'=>$usuario));
					$dirEnvio = new DireccionEnvio;
					
					$dirEnvio->nombre = $dir1->nombre;
					$dirEnvio->apellido = $dir1->apellido;
					$dirEnvio->cedula = $dir1->cedula;
					$dirEnvio->dirUno = $dir1->dirUno;
					$dirEnvio->dirDos = $dir1->dirDos;
					$dirEnvio->telefono = $dir1->telefono;
					$dirEnvio->ciudad_id = $dir1->ciudad_id;
					$dirEnvio->provincia_id = $dir1->provincia_id;
					$dirEnvio->pais = $dir1->pais;
					
					
					
					
						if($dirEnvio->save()){
							// ya esta todo para realizar la orden
							
							$orden = new Orden;
							
							$orden->subtotal = $_POST['subtotal'];
							$orden->descuento = $_POST['descuento'];
							$orden->envio = $_POST['envio'];
							$orden->iva = $_POST['iva'];
							$orden->descuentoRegalo = 0;
							$orden->total = $_POST['total'];
							$orden->seguro = $_POST['seguro'];
							$orden->fecha = date("Y-m-d H:i:s"); // Datetime exacto del momento de la compra 
							$orden->estado = 1; // en espera de pago
							$orden->bolsa_id = 0; //compra desde admin
							$orden->user_id = $usuario;
							$orden->pago_id = $pago->id;
							$orden->detalle_id = $detalle->id;
							$orden->direccionEnvio_id = $dirEnvio->id;
							$orden->tipo_guia = $_POST['tipo_guia'];
							
							if($detalle->nTarjeta!="") // Pagó con TDC
							{
								$orden->estado = 3; // Estado: Pago Confirmado
							}
							
							if($orden->save()){
								if(isset($_POST['usar_balance']) && $_POST['usar_balance'] == '1'){
									$balance_usuario = Yii::app()->db->createCommand(" SELECT SUM(total) as total FROM tbl_balance WHERE user_id=".Yii::app()->user->id." GROUP BY user_id ")->queryScalar();
									if($balance_usuario > 0){
										$balance = new Balance;
										if($balance_usuario >= $_POST['total']){
											$orden->descuento = $_POST['total'];
											$orden->total = 0;
											$orden->estado = 2; // en espera de confirmación
											$balance->total = $_POST['total']*(-1);
										}else{
											$orden->descuento = $balance_usuario;
											$orden->total = $_POST['total'] - $balance_usuario;
											$balance->total = $balance_usuario*(-1);
										}
										$orden->save();
										
										//$balance->total = $orden->descuento*(-1);
										$balance->orden_id = $orden->id;
										$balance->user_id = $usuario;
										$balance->tipo = 1;
										$balance->save();
									}
								}
								
								$ptcs = explode(',',Yii::app()->session['ptcs']);
								$vals = explode(',',Yii::app()->session['vals']);
								$i=0;
								// añadiendo a orden producto
								foreach($ptcs as $ptc)
								{
									$prorden = new OrdenHasProductotallacolor;
									$prorden->tbl_orden_id = $orden->id;
									$prorden->preciotallacolor_id = $ptc;
									$prorden->cantidad = $vals[$i];
									$prorden->look_id = 0;
									
									$prtc = Preciotallacolor::model()->findByPk($ptc); // tengo preciotallacolor
									$precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$prtc->producto_id));
									
										$prorden->precio = $precio->precioDescuento;
									
								
									
									if($prorden->save()){
										//listo y que repita el proceso
									}
									$i++;
								}
								$i=0;
								//descontando del inventario
								foreach($ptcs as $ptc)
								{
									$uno = Preciotallacolor::model()->findByPk($ptc);
									$cantidadNueva = $uno->cantidad - $vals[$i]; // lo que hay menos lo que se compró
									
									Preciotallacolor::model()->updateByPk($ptc, array('cantidad'=>$cantidadNueva));
									// descuenta y se repite									
								}
								
								
								// para borrar los productos de la bolsa								
								
								
								// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
								// se agrega este estado en el caso de que no se haya pagado por TDC
								if($detalle->nTarjeta=="")
								{
									$estado = new Estado;
									
									$estado->estado = 1;
									$estado->user_id = $usuario;
									$estado->fecha = date("Y-m-d");
									$estado->orden_id = $orden->id;
									
									if($estado->save())
										echo "";
								}
								else // si pago con tarjeta
								{
									
									$estado = new Estado;
									
										$estado->estado = 1;
										$estado->user_id = $usuario;
										$estado->fecha = date("Y-m-d");
										$estado->orden_id = $orden->id;
										
										if($estado->save())
											{
												// otro estado de una vez ya que ya se pagó el dinero 
												$estado = new Estado;
									
												$estado->estado = 3;
												$estado->user_id = $usuario;
												$estado->fecha = date("Y-m-d");
												$estado->orden_id = $orden->id;
												
												if($estado->save())
												{
													$detalle->orden_id = $orden->id;
													$detalle->save();
												}
													
												
											}// estado
									
								}
								
								// Generar factura
								$factura = new Factura;
								$factura->fecha = date('Y-m-d');
								$factura->direccion_fiscal_id = $_POST['idDireccion'];  // esta direccion hay que cambiarla después, el usuario debe seleccionar esta dirección durante el proceso de compra
								$factura->direccion_envio_id = $_POST['idDireccion'];
								$factura->orden_id = $orden->id;
								$factura->save();
								
								// Enviar correo con resumen de la compra
								$user = User::model()->findByPk($usuario);
								$message            = new YiiMailMessage;
						           //this points to the file test.php inside the view path
						        $message->view = "mail_compra";
								$subject = 'Tu compra en Personaling';
						        $params              = array('subject'=>$subject, 'orden'=>$orden);
						        $message->subject    = $subject;
						        $message->setBody($params, 'text/html');
						        $message->addTo($user->email);
								$message->from = array('ventas@personaling.com' => 'Tu Personal Shopper Digital');
						        //$message->from = 'Tu Personal Shopper Digital <ventas@personaling.com>\r\n';   
						        Yii::app()->mail->send($message);
								
							// cuando finalice entonces envia id de la orden para redireccionar
							echo CJSON::encode(array(
								'status'=> 'ok',
								'orden'=> $orden->id,
								'total'=> $orden->total,
								'respCard' => $respCard,
								'descuento'=>$orden->descuento
							));
							
							
							}else{ //orden
								echo CJSON::encode(array(
								'status'=> 'error',
								'error'=> $orden->getErrors(),
							));
							}
						}//direccion de envio
					} // pago
				}// detalle
			}// transferencia
			
			// detalle de pago (caso transferencia todo vacio)
			// tipo de pago y copiar direccion envio
			// realizar la orden
			// mover los productos
			// quitarlos de bolsa tiene producto
			
		 }
		
	}
	
}
