<?php

class InboundController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
//	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','detalle','descargarExcel',
                                    'descargarXml', "corregirItem",),
				'expression' => 'UserModule::isAdmin()',
			),
			array('allow', 
				'actions'=>array('revisarFTP'),
				'users' => array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Muestra los productos contenidos en un Inbound
	 */
	public function actionDetalle($id)
	{
            $dataProvider = $this->loadModel($id)->buscarProductos();
            
            $this->render('adminDetalle',array(
                    'dataProvider'=>$dataProvider,
                    'id'=>$id,
            ));
	}	
        
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Inbound('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Inbound']))
			$model->attributes=$_GET['Inbound'];

		$this->render('admin',array(
			'dataProvider'=>$model->search(),
		));
	}
        
	/**
	 * Cambiar estado a "Corregido"
	 */
	public function actionCorregirItem()
	{
            if(isset($_GET['id'])){
                $response = array();
                
                $response["status"] = "success";
                echo CJSON::encode($response);
            }            
            
            Yii::app()->end();
		
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Inbound::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='inbound-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        /**
	 * Descargar el archivo excel correspondiente al MasterData cargado
	 */
	public function actionDescargarExcel()
	{
            //Revisar la extension
            $archivo = Yii::getPathOfAlias("webroot").Inbound::RUTA_ARCHIVOS.
                    $_GET["id"].".xlsx";
            $existe = file_exists($archivo);
            
            //si no existe con extension xlsx, poner xls
            if(!$existe){
                $archivo = substr($archivo, 0, -1);
            }
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=Inbound-'.basename($archivo));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($archivo));
            ob_clean();
            flush();
            readfile($archivo);
            
	}
        
	/**
	 * Descargar el archivo XML correspondiente al MasterData cargado
	 */
	public function actionDescargarXml()
	{
            //Revisar la extension
            $archivo = Yii::getPathOfAlias("webroot").Inbound::RUTA_ARCHIVOS.
                    $_GET["id"].".xml";
            $existe = file_exists($archivo);
            
            //si no existe con extension xlsx, poner xls
            if(!$existe){
                throw new CHttpException(404,'The requested page does not exist.');
            }
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=Inbound-'.basename($archivo));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($archivo));
            ob_clean();
            flush();
            readfile($archivo);
            
	}
        
	/**
	 * revisar el ftp automaticamente y descagar confirmations pendientes
	 */
	public function actionRevisarFTP(){
            
            //Obtener los inbounds que no han sido confirmados
            $noConfirmados = Inbound::model()->findAllByAttributes(array(
                "estado" => 1 //esperando confirmacion
            ));
            
            //Revisar en el ftp por cada uno de ellos
            foreach ($noConfirmados as $elemento){                
                //$this->getInboundConf($elemento->id);            
            }
			
			
			$returns = Retturn::model()->findAllByAttributes(array(),
			array('condition'=>'estadoConfirmation IS NULL'));
            
            //Revisar en el ftp por cada uno de ellos
            foreach ($returns as $elemento){                
                $elemento->getConfirmation($elemento->id);            
            }
            
            
            //Buscar los outbounds que estan en espera de respuesta
            $outbounds = Outbound::model()->findAllByAttributes(array(
                "estado" => array(0,1,4)
            ));        
            
//            foreach ($ordenes as $orden){
//                
//            echo "<pre>";
//            print_r($orden->attributes);
//            echo "</pre><br>";
//            }
//            Yii::app()->end();


            //Revisar en el ftp con todas las ordenes
            $this->getOutboundConfirmations($outbounds);            
            
        }
        
	/**
	 * Analizar el confirmation de un inbound enviado.
	 */
	function getInboundConfirmations($id){
            
            $enProduccion = strpos(Yii::app()->baseUrl, "develop") == false 
                && strpos(Yii::app()->baseUrl, "test") == false;
            
            $ftpServer = "localhost";
            $userName = "personaling";
            $userPwd = "P3rs0n4l1ng";            

            if($enProduccion){
                $ftpServer = "ftp.logisfashion.com";
                $userName = "personaling@ftp.logisfashion.com";
                $userPwd = "Personaling789"; 
            }       
            
            $tipoArchivo = "InboundStatus_";
            $rutaArchivo = Yii::getPathOfAlias('webroot').Inbound::RUTA_ARCHIVOS;        
            
            /* Directorio OUT donde estan los confirmation*/
            $directorio = "html/develop/develop/protected/OUT/";
            if($enProduccion){
                $directorio = "OUT/"; // En LogisFashion
            }
            
            //realizar la conexion ftp
            $conexion = ftp_connect($ftpServer); 
            $loginResult = ftp_login($conexion, $userName, $userPwd); 
            
            if ((!$conexion) || (!$loginResult)) {  
                return false; 
            }        
            
            //ubicarse en el directorio y obtener un listado
            ftp_chdir($conexion, $directorio);  
            $listado = ftp_nlist($conexion, "");
            $nombreArchivo =  $tipoArchivo.$id."_";

            $encontrado = false;
            
            foreach ($listado as $arch){
                
                //Si ya ha sido cargado el inbound                
                if(strpos($arch, $nombreArchivo) !== false){                                       
                    //Descargar el archivo
                    if(ftp_get($conexion, $rutaArchivo.$arch, $arch, FTP_BINARY)){
                       
                    }            
                    
                    $xml = simplexml_load_file($rutaArchivo.$arch);   
                    $conDiscrepancias = false;                    
                    
                    foreach ($xml as $elemento){
                        
                        if($elemento->getName() == "Item"){
                            
                            //Consultar en BD
                            $item = ItemInbound::model()->with(array(
                                        "producto" => array(
                                            "condition" => "sku = '".$elemento->EAN."'",
                                        )
                                    ))->findByAttributes(array(
                                        "inbound_id"=>$id,
                                        ));
                            //Guardar lo que viene en el XML
                            $item->cant_recibida = $elemento->Cantidad;
                            
                            if($item->cant_recibida != $item->cant_enviada){
                                $item->estado = 3; //con discrepancias
                                $conDiscrepancias = true; //para marcar el inbound completo
                            }else{
                                $item->estado = 2; //confirmado
                            }
                            
                            $item->save();   
                        }                        
                    }
                    
                    //Marcar inbound con estado
                    $inbound = Inbound::model()->findByPk($id);
                    if($conDiscrepancias){
                        $inbound->estado = 3;
                    }else{
                        $inbound->estado = 2;                        
                    }
                    $inbound->save();
                    
                    $encontrado = true;
                    break;
                }
            }
            // cerrar la conexión ftp 
            ftp_close($conexion);
            
        }
	
        /**
	 * Analizar el confirmation de un outbound enviado.
	 */
	function getOutboundConfirmations($outbounds){
            
            $ftpServer = "localhost";
            $userName = "personaling";
            $userPwd = "P3rs0n4l1ng";            
            
            $tipoArchivo = "OutboundStatus"; /*CORREGIR*/
            $rutaArchivo = Yii::getPathOfAlias('webroot').Outbound::RUTA_ARCHIVOS;                    
            
            
            /* Directorio OUT donde estan los confirmation*/
            $directorio = "html/develop/develop/protected/OUT/";
            if(strpos(Yii::app()->baseUrl, "develop") == false 
                && strpos(Yii::app()->baseUrl, "test") == false){

                $directorio = "OUT/"; // En LogisFashion
            }
            
            //realizar la conexion ftp
            $conexion = ftp_connect($ftpServer); 
            $loginResult = ftp_login($conexion, $userName, $userPwd); 
            
            if ((!$conexion) || (!$loginResult)) {  
                return false; 
            }        
            
            //ubicarse en el directorio y obtener un listado
            ftp_chdir($conexion, $directorio);  
            $listadoArchivos = ftp_nlist($conexion, "");

            //Recorrer las ordenes
            foreach($outbounds as $outB){
                
                $estadoABuscar = "";
                
                //si la orden esta en estadoLF 0, buscar los confirmados
                if($outB->estado == 0){
                    $estadoABuscar = "_CONFIRMADO_";
                }else if($outB->estado == 1){
                    $estadoABuscar = "_FINALIZADO_";
                }
                
                $nombreArchivo = $tipoArchivo . $estadoABuscar . $outB->orden_id . "_";

                //Revisar los archivos del ftp
                foreach ($listadoArchivos as $archivo){
                    
                    if(strpos($archivo, $nombreArchivo) !== false){
                        
                        if($outB->estado == 0){ //si estaba enviado a lf
                            
                            $outB->estado = 1; //cambiarlo a confirmado
                            
                        }else if($outB->estado == 1){ //si estaba confirmado
                        
                            //Revisar inconsistencias
                            //Descargar el archivo
                            ftp_get($conexion, $rutaArchivo.$archivo, $archivo, FTP_BINARY);
                            $xml = simplexml_load_file($rutaArchivo.$archivo);   
                            $discrepancias =  0; //inicialmente no hay discrepancias                                                        
                            
                            $outB->cantidad_bultos = count($xml->Bulto);
                                
                            foreach ($xml->Bulto as $bulto){
                                //Tracking
                                //Cada elemento del bulto
                                foreach ($bulto->Item as $item){

                                    $productoOrden = OrdenHasProductotallacolor::model()->with(array(
                                        "preciotallacolor" => array(
                                            "condition" => "sku = '".$item->EAN."'",
                                        )
                                        ))->findByAttributes(array(
                                            "tbl_orden_id"=>$outB->orden_id,
                                        ));

                                    //cantidad recibida de LF
                                    $productoOrden->cantidadLF = $item->Cantidad;
                                    //si hay discrepancias en las cant enviadas
                                    if($productoOrden->cantidadLF != $productoOrden->cantidad){

                                        $productoOrden->estadoLF = 2; //con discrep
                                        $discrepancias = 1;

                                    }else{                                            
                                        $productoOrden->estadoLF = 1; //confirmado                                            
                                    }

                                    $productoOrden->save();                                        
                                }                                    

                            } //Fin recorrer los bultos

                            //buscar los que quedaron en 0 (no recibidos de LF)
                            $productosOrden = OrdenHasProductotallacolor::model()
                                         ->findAllByAttributes(array(
                                            "tbl_orden_id"=>$outB->orden_id,
                                            "cantidadLF"=>0,
                                        ));

                            //si hubo productos con cant 0 recibida de LF
                            if($productosOrden){
                                $discrepancias = 1; //hay productos que no se enviaron
//                                    Cambiar cada uno a estado 2 (con discrep)
                                foreach($productosOrden as $producto){

                                    $producto->estadoLF = 2;                                       
                                    $producto->save();                                    
                                }                              

                            }

                            $outB->discrepancias = $discrepancias;
                            $outB->estado = 4; //cambiarlo a finalizado
                            
                            if($discrepancias == 1){
                                //notificar a Operaciones
                                $this->enviarEmailOperaciones($outB->orden);
                            }
                            
                            
                        }//fin si estaba finalizado
                        else if($outB->estado == 4)
                        {
                            //marcarlo enviado
                        }
                        
                        $outB->save();
                        break;
                    }

                } //Fin for revisar listado de archivos
            
            }
            
            // cerrar la conexión ftp 
            ftp_close($conexion);
            
            
        }
        
        /*Enviar el correo para notificar a Operaciones*/
        function enviarEmailOperaciones($orden) {
            
            $message = new YiiMailMessage;
            //this points to the file test.php inside the view path
            $message->view = "mail_template";
            
            $subject = 'Error en Compra de Personaling';
            $body = $body = Yii::t('contentForm',
                    'Ha habido una discrepancia entre los productos incluidos en la Orden Nro. '.$orden->id.
                    ' y los que fueron enviados por LogisFashion.
                     <br>
                     <br>
                     <br>
                     <a title="Ver órdenes" 
                     href="http://www.personaling.es'.Yii::app()->baseUrl.
                    '/orden/admin" 
                        style="text-align:center;text-decoration:none;color:#ffffff;
                        word-wrap:break-word;background: #231f20; padding: 12px;" 
                        target="_blank">Ver órdenes</a><br><br/><br/><br/><br/>'
                     ."Los datos de la orden son:<br/>
                     Codigo: {$orden->id}<br/>
                     Fecha: {$orden->fecha}<br/>
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
        
        
}
