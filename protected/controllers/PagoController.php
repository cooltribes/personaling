<?php

class PagoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('solicitar','index'),
				'expression'=>"UserModule::isPersonalShopper()",
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','view', 'detalle'),
				'expression'=>"UserModule::isAdmin()",
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
	 * Crear una nueva solicitud
	 */
	public function actionSolicitar()
	{
		$model = new Pago;
                $user = User::model()->findByPk(Yii::app()->user->id);
                $balance = $user->getSaldoPorComisiones();
            
                if($balance <= 0){
                    Yii::app()->user->setFlash("error", "No tienes suficiente balance
                        en comisiones para poder hacer una solicitud de cobro.");
                }
                
                
		if(isset($_POST['Pago']))
		{
                    $model->attributes = $_POST['Pago'];
                    $model->user_id = Yii::app()->user->id;
                    $model->fecha_solicitud = date("Y-m-d H:i:s");

                    //si metodo de pago es paypal
                    if($model->tipo == 0){                            
                        //poner el nombre del banco "PAYPAL" para no dejarlo vacío
                        $model->entidad = "PayPal";                            
                    }
                    //si el tipo de pago es Agregar al Balance
                    if($model->tipo == 2){                            
                        //poner el nombre del banco "Personaling" para no dejarlo vacío
                        $model->entidad = "Personaling";                            
                        //poner como cuenta "Balance" ya que no se indicó en el formulario
                        $model->cuenta = "Balance";                            
                    }
                    
                    if($model->save()){
                        
                        //Bloquear saldo
                        $saldo = new Balance();
                        $saldo->total = - $model->monto;
                        $saldo->orden_id = $model->id;
                        $saldo->user_id = $model->user_id;
                        //ningun admin, el mismo usuario para no romper la integridad
                        $saldo->admin_id = $model->user_id; 
                        $saldo->tipo = 7; //por retiro de dinero PS                        
                        $saldo->fecha = date("Y-m-d H:i:s");
                        $saldo->save();
                        
                        Yii::app()->user->setFlash("success", "Se ha realizado tu solicitud con éxito,
                            en breve Personaling te dará respuesta.");
                        
                        /*Enviar correo OPERACIONES (operaciones@personaling.com
                         si no esta en develop                          
                         */  
                        if(strpos(Yii::app()->baseUrl, "develop") === false){

                            $this->enviarEmailOperaciones($model);  

                        }
                        
                        //Notificar por correo al Personal Shopper
                        $this->enviarNotificacionPersonalShopper($model);
                        
                        
                        $this->redirect(array('index'));

                    }else{
                        Yii::trace('Solicitando pago, Error:'.print_r($model->getErrors(), true), 'Pagos');                        
                        
                        if($model->tipo == 0){                            
                            $model->entidad = "";                                                    
                        }
                       
                    } 
                            
		}
                
		$this->render('solicitar',array(
			'model'=>$model,
			'balance'=>$balance,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionDetalle($id)
	{
            /* @var $model Pago */
            $model=$this->loadModel($id);
            $user = $model->user;

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['aceptar']))
            {
                //Si ingresaron algun id de transaccion o si es un pago para agregar
                //al balance, no necesitaria idTransaccion
                if($_POST['idTransaccion'] != "" || $model->tipo == 2){

                    //Marcar el pago como aceptado, necesita un idTransaccion
                    //para identificar la operacion bancaria o tranferencia de paypal
                    $model->fecha_respuesta = date("Y-m-d H:i:s");
                    $model->id_transaccion = $_POST['idTransaccion'] ? $_POST['idTransaccion']
                            : ($model->tipo == 2 ? 0:"") ;
                    $model->admin_id = Yii::app()->user->id;
                    $model->estado = 1;

                    if($model->save()){
                        
                        //Si el tipo de pago fue agregar al balance, el idTransaccion
                        //será el mismo ID
                        $model->id_transaccion = $model->id;
                        $model->save();
                        
                        //Pasar para el saldo
                        $saldo = new Balance();
                        $saldo->total = $model->monto;
                        $saldo->orden_id = $model->id;
                        $saldo->user_id = $model->user_id;
                        $saldo->admin_id = Yii::app()->user->id;
                        $saldo->tipo = 9; //por pago al cobrar agregando al balance
                        $saldo->fecha = date("Y-m-d H:i:s");
                        $saldo->save();
                        
                        //enviar email a PS
                        $this->enviarRespuestaPersonalShopper($model, 1);                        
                        Yii::app()->user->setFlash("success", "Se ha registrado el pago exitosamente.");                           

                    }else{
                        Yii::trace('Aceptando pago, Error:'.print_r($model->getErrors(), true), 'Pagos');
                        Yii::app()->user->setFlash("error", "No se pudo registrar el pago.");                           
                        
                        $model=$this->loadModel($id);
                    }                     

                }else{
                    Yii::app()->user->setFlash("error", "Debes ingresar un código de transacción.");
                }

                
            }else if(isset($_POST['rechazar'])){                    

                if($_POST['observacion'] != ""){
                   $model->observacion = $_POST['observacion'];
                }
                
                $model->fecha_respuesta = date("Y-m-d H:i:s");
                $model->admin_id = Yii::app()->user->id;
                $model->estado = 2; //Rechazado
                if($model->save()){

                    //Reintegrar saldo
                    $saldo = new Balance();
                    $saldo->total = $model->monto;
                    $saldo->orden_id = $model->id;
                    $saldo->user_id = $model->user_id;
                    $saldo->admin_id = Yii::app()->user->id;
                    $saldo->tipo = 8; //por reintegro de dinero PS       
                    $saldo->fecha = date("Y-m-d H:i:s");
                    $saldo->save();
                    
                    //enviar email a la PS
                    $this->enviarRespuestaPersonalShopper($model, 2);
                    Yii::app()->user->setFlash("success", "Se ha rechazado el pago exitosamente.");                           

                }else{
                    Yii::trace('Rechazando pago, Error:'.print_r($model->getErrors(), true), 'Pagos');
                    Yii::app()->user->setFlash("error", "No se pudo rechazar el pago.");  
                    $model=$this->loadModel($id);
//                    echo "<pre>";
//                    print_r($model->getErrors());
//                    echo "</pre><br>";
//                    Yii::app()->end();
                
                }  

            }            

            $this->render('detalle',array(
                    'model'=>$model,
                    'usuario'=>$user,
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
	 * Para el listado que ve el PS
	 */
	public function actionIndex()
	{
            $pago = new Pago();
            //Buscar mis solicitudes y pagos
            $pago->unsetAttributes();
            $pago->user_id = Yii::app()->user->id;
            $dataProvider = $pago->search();                
            
            $this->render('index',array(
                'dataProvider'=>$dataProvider,
            ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Pago('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pago']))
			$model->attributes=$_GET['Pago'];
                
                $dataProvider = $model->search();

		$this->render('admin',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pago the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Pago::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Pago $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pago-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /*Enviar el correo para notificar a Operaciones*/
        function enviarEmailOperaciones($pago) {
            
            $message = new YiiMailMessage;
            //this points to the file test.php inside the view path
            $message->view = "mail_template";
            
            $subject = 'Solicitud de pago';
            $body = Yii::t('contentForm',
                    'Se ha generado una solicitud de pago por parte de un Personal
                     Shopper.
                     <br>
                     <b>Nombre:</b> '.$pago->user->profile->getNombre().'<br/>
                     <b>Email:</b> '.$pago->user->email.'<br/>
                     <br>
                     <br>
                     <a title="Ver solicitudes" 
                     href="http://www.personaling.es'.Yii::app()->baseUrl.
                    '/pago/admin" 
                        style="text-align:center;text-decoration:none;color:#ffffff;
                        word-wrap:break-word;background: #231f20; padding: 12px;" 
                        target="_blank">Ver solicitudes</a><br><br/><br/>'
                     ."Los datos de la solicitud generada son:<br/>
                     <b>Nro. de Solicitud:</b> {$pago->id}<br/>
                     <b>Fecha</b>: ".date("d/m/Y h:i:s a", $pago->getFechaSolicitud())."<br/>
                     <br/>
                         
                     <br/>");
                     
                     
            $destinatario = "operaciones@personaling.com";
            //si esta en test, enviarlo a cristal
            if(strpos(Yii::app()->baseUrl, "test") !== false){
                
                $destinatario = "cmontanez@upsidecorp.ch";               
            }     
                     
            $params = array('subject'=>$subject, 'body'=>$body);
            $message->subject = $subject;
            $message->setBody($params, 'text/html');
            $message->addTo($destinatario);
            $message->from = array('operaciones@personaling.com' => 'Tu Personal Shopper Digital');            
            Yii::app()->mail->send($message);
        }
        
        /*Enviar el correo para notificar al PS sobre su pago
         * 
         * @param $accion si fue aprobado o rechazado
         * 1: aprobado
         * 2: rechazado
         */
        function enviarRespuestaPersonalShopper($pago, $accion) {
            
            $message = new YiiMailMessage;
            //Opciones de Mandrill
            $message->activarPlantillaMandrill();
//            $message->view = "mail_template";
            
            $subject = 'Solicitud de pago';
            
            //Aprobado
            if($accion == 1){
                
                //Si el pago fue agregar al balance (2) u otro
                $tipoPago = $pago->tipo == 2 ? "Se ha hecho el pago cargándose 
                    a tu balance Personaling"
                        :"Se ha hecho el pago a tu cuenta. (Paypal o Banco) por";
                $body = Yii::t('contentForm',
                    'Tu solicitud de pago <b>Nro.'.$pago->id.'</b> ha sido aprobada.
                     '.$tipoPago.' un monto
                     de <b>'.$pago->getMonto().'</b>
                     <br>                    
                     <br>
                     <br>
                     <a title="Mis pagos" 
                     href="http://www.personaling.es'.Yii::app()->baseUrl.
                    '/pago/index" 
                        style="text-align:center;text-decoration:none;color:#ffffff;
                        word-wrap:break-word;background: #231f20; padding: 12px;" 
                        target="_blank">
                        
                        Mis pagos
                        
                      </a><br><br/><br/>'
                     ."<br/>");
            }else{
                
                $body = Yii::t('contentForm',
                    'Tu solicitud de pago <b>Nro.'.$pago->id.'</b> ha sido rechazada.
                     <br>                    
                     <br>
                     <br>
                     <a title="Mis pagos" 
                     href="http://www.personaling.es'.Yii::app()->baseUrl.
                    '/pago/index" 
                        style="text-align:center;text-decoration:none;color:#ffffff;
                        word-wrap:break-word;background: #231f20; padding: 12px;" 
                        target="_blank">
                        
                        Mis pagos
                        
                      </a><br><br/><br/>'
                     ."<br/>");
            }        
                     
            $destinatario = $pago->user->email;
            
            if(strpos(Yii::app()->baseUrl, "develop") !== false){
                
                $destinatario = "nramirez@upsidecorp.ch";               
            }     
                     
//            $params = array('subject'=>$subject, 'body'=>$body);
            $message->subject = $subject;
            $message->setBody($body, 'text/html');
            $message->addTo($destinatario);
//            $message->from = array('operaciones@personaling.com' => 'Tu Personal Shopper Digital');            
            Yii::app()->mail->send($message);
        }
        
        function enviarNotificacionPersonalShopper($pago) {
            
            $message = new YiiMailMessage;
            //Opciones de Mandrill
            $message->activarPlantillaMandrill();
            
//            $message->view = "mail_template";
            
            $subject = 'Solicitud de pago';            
            
            $body = Yii::t('contentForm',
                'Se ha generado tu solicitud de pago <b>Nro.'.$pago->id.'</b> por un 
                 monto de <b>'.$pago->getMonto().'</b>.
                 En breve Personaling te dará respuesta.
                 <br>                    
                 <br>
                 <br>
                 <a title="Mis pagos" 
                 href="http://www.personaling.es'.Yii::app()->baseUrl.
                '/pago/index" 
                    style="text-align:center;text-decoration:none;color:#ffffff;
                    word-wrap:break-word;background: #231f20; padding: 12px;" 
                    target="_blank">

                    Mis pagos

                  </a><br><br/><br/>'
                 ."<br/>");
                     
            $destinatario = $pago->user->email;
            
            if(strpos(Yii::app()->baseUrl, "develop") !== false){
                
                $destinatario = "nramirez@upsidecorp.ch";               
            }     
                     
//            $params = array('subject'=>$subject, 'body'=>$body);
            $message->subject = $subject;
            $message->setBody($body, 'text/html');
            $message->addTo($destinatario);
//            $message->from = array('operaciones@personaling.com' => 'Tu Personal Shopper Digital');            
            Yii::app()->mail->send($message);
        }
        
}
