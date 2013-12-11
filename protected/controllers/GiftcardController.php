<?php

class GiftcardController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        
        
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
				'actions'=>array('create','update','enviarGiftCard','aplicar', 'comprar'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','admin','delete','update', 'enviar', 'createMasivo', 'desactivar','seleccionarusuarios',
                                    'envioMasivo', 'exportarExcel'),
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
                            $model->codigo = Giftcard::generarCodigo();
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
                                        
            
            if(isset($_POST["siguiente"]) && isset($_POST["seleccionadosH"])){
                Yii::app()->session["users"] = $_POST["seleccionadosH"];
                $this->redirect(array("envioMasivo"));

            }
            
            $model = new User('search');
            $model->unsetAttributes();
            
            $criteria = new CDbCriteria;

            $dataProvider = new CActiveDataProvider('User', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->getModule('user')->user_page_size,
                        //'params' => array('seleccionados' => 'f'),
                    ),
                ));
            
            
            /*********************** Para los filtros *********************/
             if((isset($_SESSION['todoPost']) && !isset($_GET['ajax'])))
            {
                unset($_SESSION['todoPost']);
            }
            //Filtros personalizados
            $filters = array();
            
            //Para guardar el filtro
            $filter = new Filter;            
            
            if(isset($_GET['ajax']) && !isset($_POST['dropdown_filter']) && isset($_SESSION['todoPost'])
               && !isset($_POST['nombre'])){
              $_POST = $_SESSION['todoPost'];
            }            
            
            if(isset($_POST['dropdown_filter'])){  
                                
                $_SESSION['todoPost'] = $_POST;           
                
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
                                    array('name' => $_POST['name'], 'type' => '3') 
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
            
            
            if (isset($_GET['nombre'])) {
                
                unset($_SESSION["todoPost"]);
                $criteria->alias = 'User';
                $criteria->join = 'JOIN tbl_profiles p ON User.id = p.user_id AND (p.first_name LIKE "%' . $_GET['nombre'] . '%" OR p.last_name LIKE "%' . $_GET['nombre'] . '%" OR User.email LIKE "%' . $_GET['nombre'] . '%")';
                
                $dataProvider = new CActiveDataProvider('User', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->getModule('user')->user_page_size,
                    ),
                ));
            }
            
		$this->render('seleccionarusuarios', array(
                    'dataProvider' => $dataProvider,
                ));
	}

	/*Action para enviar la Giftcard*/
        public function actionEnviar($id){
            $model = $this->loadModel($id);
            
            $envio = new EnvioGiftcard;
            
            if(isset($_POST["EnvioGiftcard"])){
               
                $envio->attributes = $_POST["EnvioGiftcard"];    
                    
                //Si es un email valido, enviar giftcard
                if($envio->validate()){                         

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
                    
                    
                    $personalMes = "";                  
                    if($envio->mensaje != ""){
                        $personalMes = "<br/><br/><i>" . $envio->mensaje . "</i><br/>";
                    }
                                      
                    $message = new YiiMailMessage;
                    $message->view = "mail_giftcard";
                    $subject = 'Gift Card de Personaling';
                    $body = "¡Hola<strong>{$envio->nombre}</strong>!<br><br> {$saludo} 
                            <br>
                            Comienza a disfrutarla entrando en Personaling.com. Y ¡Sientete estupenda! #mipersonaling<br/>
                            (Para ver la Gift Card permite mostrar las imagenes de este correo) <br/><br/>";
                            
                    
                    $params = array('subject' => $subject, 'body' => $body,'envio' => $envio, 'model'=> $model);
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

        
        public function actionAplicar(){                           
           
            $ajax = isset($_POST["aplicarAjax"]) && $_POST["aplicarAjax"] == 1;           

           
            $response = array();

            
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


                                    Yii::app()->user->updateSession();
                                    Yii::app()->user->setFlash('success',
                                            UserModule::t("¡Se ha aplicado tu Gift Card de <b>Bs. {$giftcard->monto}</b>, ahora puedes usar tu saldo para comprar en Personaling!"));                              
                                    
                                    if(!$ajax){
                                        $this->redirect(array('user/profile/micuenta'));                                        
                                    }                                    

                                }else{ //Vencida
                                   Yii::app()->user->updateSession();
                                   Yii::app()->user->setFlash('error',UserModule::t("¡Esta Gift Card ha expirado, ya no está disponible!"));                              
                                }                               
                               
                           }else{ //no ha entrado en vigencia
                              Yii::app()->user->updateSession();
                              Yii::app()->user->setFlash('warning', UserModule::t("¡No puedes usar esta Gift Card porque aún no está disponible!"));    
                           }
                                   
                       }else if($giftcard->estado == 1){ //Invalida
                           Yii::app()->user->updateSession();
                           Yii::app()->user->setFlash('error',UserModule::t("¡Gift Card inválida!"));
                       
                       }else if($giftcard->estado == 3){ //Aplicada
                           Yii::app()->user->updateSession();
                           Yii::app()->user->setFlash('error',UserModule::t("¡Esta Gift Card ya ha sido usada!"));
                       }
                   
                       
                   }else{ // Si no existe
                       Yii::app()->user->updateSession();
                       Yii::app()->user->setFlash('error',UserModule::t("¡Gift Card inválida!"));
                   }
                   
               }else{ //Invalido

                    
                    $cReq = 0;
                    $cLen = 0;
                    foreach($aplicar->errors as $att => $error){
                        $cReq += in_array("req", $error) ? 1:0;
                        $cLen += in_array("len", $error) ? 1:0;
                    }
                    $aplicar->clearErrors();

                    if($cReq){
                       $aplicar->addError("campo1", "Debes escribir el código de tu Gift Card completo."); 
                    }
                    if($cLen){
                       $aplicar->addError("campo1", "Los campos deben ser de 4 caracteres cada uno."); 
                    } 
                    
                    if($ajax){
                        foreach($aplicar->getErrors("campo1") as $mensajeError){
                            $response[] = array("type" => "error", "message" => $mensajeError);
                        }
                        
                    }
               }               
            }
            
            if(!$ajax){                    
                $this->render('aplicar', array('model' => $aplicar));
            }else{

                $flashes = Yii::app()->user->getFlashes();

                if(count($flashes)){
                    $keys = array_keys($flashes);
                    if($keys[0] == "success"){
                        
                        $balance = User::model()->findByPk(Yii::app()->user->id)->profile->getSaldo(Yii::app()->user->id);

                        $balance = Yii::app()->numberFormatter->formatCurrency($balance, "");                                               
                        $response[] = array("type" => $keys[0], "message" => $flashes[$keys[0]], "amount" => $balance);

                       
                        
                    }else{
                        
                        $response[] = array("type" => $keys[0], "message" => $flashes[$keys[0]]);                        
                    }

                }

                echo CJSON::encode($response);

                Yii::app()->end();
            }
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
//            if(isset(Yii::app()->session["documentoExcel"])){
//        
//                Yii::import('ext.phpexcel.XPHPExcel');    
//
//
//                 // Redirect output to a clientâ€™s web browser (Excel5)
//                header('Content-Type: application/vnd.ms-excel');
//                header('Content-Disposition: attachment;filename="GiftCards.xls"');
//                header('Cache-Control: max-age=0');
//                // If you're serving to IE 9, then the following may be needed
//                header('Cache-Control: max-age=1');
//
//                // If you're serving to IE over SSL, then the following may be needed
//                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
//                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
//                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//                header ('Pragma: public'); // HTTP/1.0
//
//
//                unset(Yii::app()->session["documentoExcel"]);
//
//
//            }
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
        
        /*Para seleccionar los datos de las tarjetas que se enviaran*/
        public function actionEnvioMasivo(){
            
            //Si estan seleccionados los usuarios
            if(!isset(Yii::app()->session["users"])){
               $this->redirect("createMasivo");
            }
            
            
            $giftcard = new Giftcard;
            $envio = new EnvioGiftcard("masivo");

            
            if(isset($_POST["Enviar"]) && isset($_POST['Giftcard'])){
                $envio->attributes = $_POST["EnvioGiftcard"];   
                
                $giftcard->attributes = $_POST['Giftcard'];
                $giftcard->estado = 1;
                $giftcard->comprador = Yii::app()->user->id;
                $giftcard->codigo = "x"; // para validar los otros campos 
               
                //valida mensaje
                if($giftcard->validate()){
                    $cantidad = count(Yii::app()->session["users"]);
                    $errors = $this->generarMasivo($giftcard, $envio, $cantidad);
                    
                    
                    if(isset(Yii::app()->session["users"])){
                        unset(Yii::app()->session["users"]);
                    }
                    //echo "Errores: ". $errors;

                    Yii::app()->user->updateSession();
                    Yii::app()->user->setFlash('success',
                    UserModule::t("Se han enviado <b>{$cantidad}.</b> Gift Cards con éxito"));
                    
                    $this->redirect(array("index"));
                    
                    
                }else{
                    

                }
                
            }
                        
            
            $this->render("envioMasivo", array(
                'envio' => $envio,
                'giftcard' => $giftcard,
                
            ));
            
        }
        
        /**
         * 
         * @param int $cant Cantidad de Giftcards a generar
         * @param GiftCard $modelo Giftcard modelo para usar en montos, fechas y comprador
         * @param EnvioGiftcard $envio datos del envio
         * @return int errores
         */
        private function generarMasivo($modelo, $envio, $cant = 1){
            
            $errores = 0;
            $usuarios = User::model()->findAllByAttributes(array("id" => Yii::app()->session["users"]));
            
//            echo "<pre>";
//            echo count($usuarios);//print_r($usuarios);
//            echo "</pre>";
//            Yii::app()->end();
            //Saludo del correo
            $saludo = "Personaling tiene una Gift Card como obsequio para tí.";
            //Mensaje que va en la tarjeta
            $personalMes = "";                  
            if($envio->mensaje != ""){
                $personalMes = "<br/><br/><i>" . $envio->mensaje . "</i><br/>";
            }
            
            for($i=0; $i< $cant; $i++){
               $model = new Giftcard;
               $model->attributes = $modelo->attributes;
                       
                do{  

                    $model->codigo = Giftcard::generarCodigo();
                    $existe = Giftcard::model()->countByAttributes(array('codigo' => $model->codigo));                        

                }while($existe);

                //Enviarla
                $model->estado = 2;
                //Direccion y nombre
                //Yii::app()->session["users"];
                //usuario $i
                $envio->nombre = $usuarios[$i]->profile->first_name;
                $envio->email = $usuarios[$i]->username;
                                      
                
                $message = new YiiMailMessage;
                $message->view = "mail_giftcard";
                $subject = 'Gift Card de Personaling';
                $body = "¡Hola <strong>{$envio->nombre}</strong>!<br><br> {$saludo} 
                        <br>Comienza a disfrutar de tu Gift Card usándola en Personaling.com<br/
                        Para ver la Gift Card permite mostrar las imagenes de este correo <br/><br/>";


                $params = array('subject' => $subject, 'body' => $body,'envio' => $envio, 'model'=> $model);
                $message->subject = $subject;
                $message->setBody($params, 'text/html');

                $message->addTo($envio->email);

                $message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
                Yii::app()->mail->send($message); 
                                                        
                if(!$model->save()){
                    $errores++;
                } 
            }
            
            return $errores;
            
        }
        
        /*Para seleccionar los datos de las tarjetas que se enviaran*/
        public function actionExportarExcel(){
                        
//            if(isset(Yii::app()->session["documentoExcel"])){    
//                unset(Yii::app()->session["documentoExcel"]);                                
//            }
            
        
            $giftcard = new Giftcard;
//             echo "<pre>";
//                print_r($_POST);
//                echo "</pre>";
//                Yii::app()->end();
            if(isset($_POST["Exportar"]) && $_POST["Exportar"] == 1 &&isset($_POST['Giftcard']) 
                    && isset($_POST['cantidadGC'])){
                
               

                $giftcard->attributes = $_POST['Giftcard'];
                $giftcard->estado = 1;
                $giftcard->comprador = Yii::app()->user->id;
                $giftcard->codigo = "x"; // para validar los otros campos 
               
                //valida mensaje
                if($giftcard->validate()){
                    if(is_int((int)$_POST['cantidadGC'])){
                        $cantidad = $_POST['cantidadGC'];
//                    echo "<pre>";
//                    print_r(Yii::app()->session["users"]);
//                    echo "</pre>";

                       
                        $response = $this->exportarMasivo($giftcard, $cantidad);
//                        echo "<pre>";
//                        print_r($_POST);
//                        echo "</pre>";
//                        //echo "Errores: ". $errors;
//                        Yii::app()->end();
                        


                        if(!$response["errors"]){
                            Yii::app()->session["documentoExcel"] = $response["document"];
                            Yii::app()->user->updateSession();
                            Yii::app()->user->setFlash('success',
                            UserModule::t("Se han exportado <b>{$cantidad}</b> Gift Cards con éxito."));
                        }else{
                            Yii::app()->user->updateSession();
                            Yii::app()->user->setFlash('error',
                            UserModule::t("Hubo un error generando las Gift Cards, intenta de nuevo."));
                            
                            if(isset(Yii::app()->session["documentoExcel"])){    
                                
                                unset(Yii::app()->session["documentoExcel"]);
                            }
                        }
                        
                            $this->redirect(array("index"));
                        
                        
                    }else{
                        //Agregar errores
                        $giftcard->addError("monto", "Error Cantidad");
                    }
                    
                }else{
                    

                }
                
            }
                        
            
            $this->render("exportarExcel", array(                
                'giftcard' => $giftcard,
                
            ));
            
        }
        
        
        /**
         * 
         * @param int $cant Cantidad de Giftcards a generar
         * @param GiftCard $GcModelo Giftcard modelo para usar en montos, fechas y comprador
         
         * @return int errores
         */
        private function exportarMasivo($GcModelo, $cant = 1){
            
            $errores = 0;
           
//            
            //Documento xls
            $title = array(
            'font' => array(
                'size' => 14,
                'bold' => true,
                'color' => array(
                            'rgb' => '000000'
                        ),
                ),
            );
            
            Yii::import('ext.phpexcel.XPHPExcel');    
	
            $objPHPExcel = XPHPExcel::createPHPExcel();

            $objPHPExcel->getProperties()->setCreator("Personaling.com")
                                     ->setLastModifiedBy("Personaling.com")
                                     ->setTitle("Listado-de-Gift-Cards")
                                     ->setSubject("Listado de Gift Cards")
                                     ->setDescription("Gift Cards Generadas")
                                     ->setKeywords("personaling")
                                     ->setCategory("personaling");
            // creando el encabezado
            $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A1', 'ID')
                        ->setCellValue('B1', 'CODIGO')
                        ->setCellValue('C1', 'INICIO DE VIGENCIA')
                        ->setCellValue('D1', 'FIN DE VIGENCIA');
                
            //Poner autosize todas las columnas
            foreach(range('A','D') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }
            
            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($title);
                
            
            for($i=0; $i< $cant; $i++){
               $model = new Giftcard;
               $model->attributes = $GcModelo->attributes;
                //generar los $cant codigos       
                do{  

                    $model->codigo = Giftcard::generarCodigo();
                    $existe = Giftcard::model()->countByAttributes(array('codigo' => $model->codigo));                        

                }while($existe);

                //Marcarla cmo activa
                $model->estado = 2;
                 
                if(!$model->save()){
                    $errores++;
                }else{
                   
                    //AGregar la fila al documento xls
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.($i + 2) ,$model->id) 
                            ->setCellValue('B'.($i + 2), $model->getCodigo())
                            ->setCellValue('C'.($i + 2) , date("d-m-Y", strtotime($model->inicio_vigencia))) 
                            ->setCellValue('D'.($i + 2) , date("d-m-Y", strtotime($model->fin_vigencia))) ;
                            
                }                                   
                 
            }//Fin for
            
            // Rename worksheet
	
            $objPHPExcel->setActiveSheetIndex(0);
           
            
            // Redirect output to a clientâ€™s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="GiftCards.xls"');
            header('Cache-Control: max-age=0');
//            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            Yii::app()->end();
            
//            $objWriter->save(Yii::getPathOfAlias("webroot")."/docs/giftcards/GiftCards.xls");
            //$objWriter->save("GiftCards.xls");
//            echo "FINAL";
          
            
            return array("document" => $objPHPExcel, "errors" => $errores);
            
        }
        
        
        /**
	 * Crear una giftcard desde el usuario, para luego pasar al proceso de compra.
	 */
	public function actionComprar()
	{		
                $model = new BolsaGC;
                $model->monto = 4; //Default
                $model->plantilla_url = "gift_card_one"; //Default
                $envio = new EnvioGiftcard("masivo");
                
                if(isset($_POST['BolsaGC']))
		{                                        
  
                    
                    $model->attributes = $_POST['BolsaGC'];
                    
                    $model->user_id = Yii::app()->user->id;
                    

                    if($model->validate()){
                        
                        $envio->attributes = $_POST['EnvioGiftcard'];
                        
                        Yii::app()->getSession()->remove('entrega');                        
                        Yii::app()->getSession()->add('entrega',$_POST['entrega']);
                        
                        //si es para enviar por correo, validar email
                        if(($_POST['entrega'] == 2 && $envio->validate()) ||
                                $_POST['entrega'] == 1){
                            
                            //Guardar los datos del envio pero borrar los anteriores                        
                            Yii::app()->getSession()->remove('envio');                        
                            Yii::app()->getSession()->add('envio',$_POST['EnvioGiftcard']);

                            /*
                            por los momentos se van a borrar todas las existentes
                            en la bolsa del usuario
                            porque se va a trabajar con una sola
                             */
                            BolsaGC::model()->deleteAllByAttributes(array("user_id" => Yii::app()->user->id));

                            if($model->save()){                              
                                $this->redirect($this->createAbsoluteUrl('bolsa/authGC',array(),'https'));
                            }  
                            
                        }
                        
                                              
                    }			
		}else{
                   Yii::app()->getSession()->remove('entrega');  
                }
                
		$this->render('comprar',array(
			'model'=>$model,
			'envio'=>$envio,
		));
	}
        
      
        
}
