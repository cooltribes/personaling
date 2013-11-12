<?php

class GiftcardController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        const DIGITOS_CODIGO = 16;
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','enviarGiftCard','aplicar'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','admin','delete','update', 'enviar', 'createMasivo', 'desactivar','seleccionarusuarios'),
				//'users'=>array('admin'),
                                'expression' => 'UserModule::isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Giftcard;

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(isset($_POST['Giftcard']))
		{                                        
//                    echo "DAtos";
//                    echo "<pre>";
//                    print_r($_POST);
//                    echo "</pre>";
//
//                    Yii::app()->end();  
                    
                    $model->attributes = $_POST['Giftcard'];
                    $model->estado = 1;
                    $model->comprador = Yii::app()->user->id;
                    $model->codigo = "x"; // para validar los otros campos                                      

                    if($model->validate()){
                        
                        //Generar un codigo que no exista.
                        do{  
                            $model->codigo = $this->generarCodigo();
                            $existe = Giftcard::model()->countByAttributes(array('codigo' => $model->codigo));                        
                            
                        }while($existe);
                        
                        if($model->save()){
                            Yii::app()->user->updateSession();
                            Yii::app()->user->setFlash('success',UserModule::t("Se ha guardado la Gift Card."));
                                
                            if(isset($_POST["Guardar"])){
                                $this->redirect(array('index'));
                            }else if(isset($_POST["Enviar"])){
                                $this->redirect(array('enviar','id'=>$model->id));
                            }
                            
                        }                        
                    }			
		}
                
		$this->render('create',array(
			'model'=>$model,
		));
	}
	public function actionCreateMasivo(){
		$this->render('createMasivo');
	}
	public function actionSeleccionarusuarios(){
		$this->render('seleccionarusuarios');
	}

	/*Action para enviar la Giftcard*/
        public function actionEnviar($id){
            $model = $this->loadModel($id);
            
            $envio = new EnvioGiftcard;
            
            if(isset($_POST["EnvioGiftcard"])){
               
                $envio->attributes = $_POST["EnvioGiftcard"];                
               
                    
                //Si es un email valido, enviar giftcard
                if($envio->validate()){      
                    
//                    echo "<pre>";
//                    print_r($model->attributes);
//                    echo "</pre>";
//                    Yii::app()->end();
                    

                    //Activar la giftcard solo si ya no ha sido aplicada
                    if($model->estado != 3){
                        $model->estado = 2;
                        $model->save();
                    }
                    //De donde proviene la GC
                    if($model->comesFromAdmin()){
                        $saludo = "Personaling tiene una Gift Card como obsequio para tí.";
                    }else{                        
                        $saludo = "<strong>{$model->UserComprador->profile->first_name}</strong> te ha enviado una Gift Card como obsequio.";
                    }
                    
                    $datosTarjeta = "<h3>Datos de la Gift Card:</h3>
                                      <strong>Monto: </strong>{$model->monto} Bs.<br>
                                      <strong>Codigo: </strong>{$model->getCodigo()}<br>
                                      <strong>Válida desde: </strong>".date("d-m-Y", $model->getInicioVigencia())."<br>
                                      <strong>Válida hasta: </strong>".date("d-m-Y", $model->getFinVigencia())."<br>";
                    
                    $personalMes = "";                  
                    if($envio->mensaje != ""){
                        $personalMes = "<br/><br/><i>" . $envio->mensaje . "</i><br/>";
                    }
                                      
                    $message = new YiiMailMessage;
                    $message->view = "mail_invite";
                    $subject = 'Gift Card de Personaling';
                    $body = "¡Hola <strong>{$envio->nombre}</strong> !<br><br> {$saludo} 
                            {$personalMes}
                            <br>Comienza a disfrutar de tu Gift Card usándola en Personaling.com.<br/><br/>"
                            .$datosTarjeta;
                            
//                    echo "Despues<pre>";
//                    print_r($envio->attributes);
//                    echo "</pre>";
//
//                    Yii::app()->end();
                    
                    $params = array('subject' => $subject, 'body' => $body);
                    $message->subject = $subject;
                    $message->setBody($params, 'text/html');

                    $message->addTo($envio->email);

                    $message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
                    Yii::app()->mail->send($message); 
                    
                    Yii::app()->user->updateSession();
                    Yii::app()->user->setFlash('success',
                            UserModule::t("La Gift Card se ha enviado con éxito a <b>{$envio->email}.</b>"));
                    
                    $this->redirect(array("index"));
                    
                }
                
            }
            
            
            $this->render('enviargiftcard', array('model' => $model, 'envio' => $envio));
                
	}
        
	public function actionEnviarGiftCard(){
		$this->render('enviargiftcard_usuario');
	}

        
        public function actionAplicar(){
            $aplicar = new AplicarGC;
            
            if(isset($_POST["AplicarGC"])){
               $aplicar->attributes = $_POST["AplicarGC"];
               
               if($aplicar->validate()){
                   $codigo = implode("", $aplicar->attributes);
                   
                   $giftcard = Giftcard::model()->findByAttributes(array('codigo' => $codigo));
                   
                   //si la Giftcard existe y esta activa
                   if($giftcard){
                       
                       if($giftcard->estado == 2){ //Si esta activa
                           
                           if($giftcard->inicio_vigencia <= date("Y-m-d")){
                               
                               if($giftcard->fin_vigencia >= date("Y-m-d") ){
                               
                                    /*Cambiar la giftcard a APLICADA*/
                                    $giftcard->estado = 3;
                                    /*Quien la uso*/
                                    $giftcard->beneficiario = Yii::app()->user->id;
                                    /*Cuando se usa*/
                                    $giftcard->fecha_uso = date("Y-m-d");
                                    $giftcard->save();


                                     //Sumar saldo
                                    $balance = new Balance();
                                    $balance->total = $giftcard->monto;
                                    $balance->user_id = Yii::app()->user->id;
                                    $balance->orden_id = 0;
                                    $balance->tipo = 2; //tipo GiftCard
                                    $balance->save();
                                    
                                    
//                                    echo "<pre>";
//                                    print_r($balance->getErrors());
//                                    echo "</pre>";
//                                    Yii::app()->end();


                                    Yii::app()->user->updateSession();
                                    Yii::app()->user->setFlash('success',UserModule::t("Se ha aplicado tu Gift Card con éxito, ahora puedes usar tu saldo para comprar en Personaling."));                              
                                    $this->redirect(array('user/profile/micuenta'));

                                }else{ //Vencida
                                   Yii::app()->user->updateSession();
                                   Yii::app()->user->setFlash('error',UserModule::t("Esta Gift Card ha expirado, ya no está disponible."));                              

                                }
                               
                               
                           }else{ //no ha entrado en vigencia
                              Yii::app()->user->updateSession();
                              Yii::app()->user->setFlash('warning', UserModule::t("¡ No puedes usar esta Gift Card porque aún no está disponible !"));    
                           }
                                   
                       }else if($giftcard->estado == 1){ //Invalida
                           Yii::app()->user->updateSession();
                           Yii::app()->user->setFlash('error',UserModule::t("¡ Gift Card inválida !"));
                       
                       }else if($giftcard->estado == 3){ //Aplicada
                           Yii::app()->user->updateSession();
                           Yii::app()->user->setFlash('error',UserModule::t("¡ Esta Gift Card ya ha sido usada !"));
                       }
                   
                       
                   }else{ // Si no existe
                       Yii::app()->user->updateSession();
                       Yii::app()->user->setFlash('error',UserModule::t("¡ Gift Card inválida !"));
                   }
                   
               }
               
            }
            
		$this->render('aplicar', array('model' => $aplicar));
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Giftcard']))
		{
			$model->attributes=$_POST['Giftcard'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Giftcard');
                
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Giftcard('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Giftcard']))
			$model->attributes=$_GET['Giftcard'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Giftcard the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Giftcard::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Giftcard $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='giftcard-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        private function generarCodigo(){
            $cantNum = 8;
            $cantLet = 8;
            
            $l = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            
            $LETRAS = str_split($l);
            $NUMEROS = range(0, 9);

            $codigo = array();
            //Seleccionar cantLet letras
            for ($i = 0; $i < $cantLet; $i++) {
                $codigo[] = $LETRAS[array_rand($LETRAS)];
            }
            for ($i = 0; $i < $cantNum; $i++) {
                $codigo[] = array_rand($NUMEROS);
            }
            
            shuffle($codigo);

            $codigo = implode("", $codigo);
            
            return $codigo;
        }
        
        public function actionDesactivar(){
            
            $result = array();
            
            if(isset($_POST["id"])){
                
                $giftcard = Giftcard::model()->findByPk($_POST["id"]);
                
                if($giftcard){
                    if($giftcard->estado != 3){
                        
                        $giftcard->estado = 1;
                        $giftcard->save();
                        
                        $result["status"] = "success"; 
                        //$result["mensaje"] = $giftcard->getErrors(); 
                        
                        
                    }else{
                        $result["status"] = "error"; 
                    }                    
                    
                }else{
                   $result["status"] = "error"; 
                }
                
            }else{
                $result["status"] = "error";
                
            }
            
            echo CJSON::encode($result);
            
        }
}
