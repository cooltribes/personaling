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
				'actions'=>array('index','admin','delete','update', 'enviar', 'createMasivo', 'desactivar','seleccionarusuarios',
                                    'envioMasivo'),
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
            
            if(isset(Yii::app()->session['selected']) && !isset($_GET['ajax'])){
                Yii::app()->session['selected'] = array();
            }
            
            if(isset($_GET['ajax'])){
                
                //array_merge(Yii::app()->session['selected'], )
                echo "Session";
                echo "<pre>";
                //print_r(Yii::app()->session['selected']);
                
                if(isset($_POST)){
                    print_r($_POST);
                }else{
                    echo "NADA";
                }
                echo "</pre>";
                
            }
            
            if(isset($_POST["siguiente"]) && isset($_POST["seleccionados"])){
//                echo "<pre>";
//                print_r($_POST["seleccionados"]);
//                echo "</pre>";
            //array_merge(Yii::app()->session['selected'], $_)

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
                    
                    $datosTarjeta = '<h3>Datos de la Gift Card:</h3>
									<table class="w470" width="470" style="margin: 0 auto;" cellpadding="0" height="287" cellspacing="0" border="0" background="http://personaling.com'.Yii::app()->baseUrl.'/images/giftcards/gift_card_one_x470.png">'."
										<tbody>
                                        <tr>
                                            <td height='30'>
                                            </td>
                                        </tr>                                         
										<tr>
											<td  class='w460' width='460' style='text-align:right; font-size:42px; position: relative;top: 30px; color: #333333; '>
	                                      		{$model->monto} Bs.
                                      		</td>
                                      	</tr>
                                        <tr>
                                            <td height='10'>
                                            </td>
                                        </tr>                                        
                                      	<tr>
                                            <td class='w5' width='5'> </td>
                                      		<td class='w465' width='465' style='position: relative; top: 18px; left: 10px;'>
                                      		    Para: {$envio->nombre}
                                      		</td>
                                      	</tr>
                                      	<tr>
                                            <td class='w5' width='5'>  </td>
                                      		<td class='w465' width='465' style='position: relative; top: -10px; left: 10px;'>
                                      			Mensaje: {$envio->mensaje}
                                      		</td>
                                      	</tr>
                                      	<tr>
                                      		<td style='color: #555; font-size: 28px; text-align: center;'>
                                      			{$model->getCodigo()}
                                      		</td>
                                      	</tr>   
                                      	<tr>
                                      		<td style='font-size: 11px; color: #333; position: relative;left: 10px;'>
                                      			Válida desde ".date("d-m-Y", $model->getInicioVigencia())." hasta ".date("d-m-Y", $model->getFinVigencia())."
                                      		</td>                                      		
                                      	</tr>
                                        <tr>
                                        </tr>                                  	
                                     	</tbody>
                                    </table> ";
                    
                    $personalMes = "";                  
                    if($envio->mensaje != ""){
                        $personalMes = "<br/><br/><i>" . $envio->mensaje . "</i><br/>";
                    }
                                      
                    $message = new YiiMailMessage;
                    $message->view = "mail_giftcard";
                    $subject = 'Gift Card de Personaling';
                    $body = "¡Hola <strong>{$envio->nombre}</strong> !<br><br> {$saludo} 
                            <br>Comienza a disfrutar de tu Gift Card usándola en Personaling.com.<br/><br/>".$datosTarjeta;
                            
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
                        
//                        echo "<pre>";
//                        print_r($response);
//                        echo "</pre>";
//
//                        Yii::app()->end();
                        
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
        
        /*Para seleccionar los datos de las tarjetas que se enviaran*/
        public function actionEnvioMasivo(){
            
            if(isset($_POST["Enviar"])){
                echo "ENVIAR";
            }
            
            $model = new EnvioGiftcard();
            $aplicar = new AplicarGC();
            
            
            $this->render("envioMasivo", array(
                'envio' => $model,
                'aplica' => $aplicar,
            ));
            
        }
}
