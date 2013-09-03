<?php

class OrdenController extends Controller
{	
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('detallepedido','listado','modals','cancelar','recibo','imprimir'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','admin','modalventas','detalles','validar','enviar','factura','mensajes'),
				//'users'=>array('admin'),
				'expression' => 'UserModule::isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/*
	 * administrador de pedidos del usuario
	 * */
	public function actionListado()
	{
		$orden = new Orden;
		
		$orden->user_id = Yii::app()->user->id;
		$dataProvider = $orden->busqueda();
		
		$this->render('adminUsuario',
		array('orden'=>$orden,
		'dataProvider'=>$dataProvider,
		));

	}

	
	/*
	 * action de detalle desde usuario 
	 * */
	public function actionDetallepedido()
	{
		
		$orden = Orden::model()->findByAttributes(array('id'=>$_GET['id'],'user_id'=>Yii::app()->user->id));
		
		if(isset($orden))
			$this->render('detalleUsuario', array('orden'=>$orden,));
		else
			echo "error";
	}
	
		
	public function actionIndex()
	{
		$this->render('index');
	}
	
	/*
	 * lo envia al admin de pedidos
	 * */
	public function actionAdmin()
	{
		$orden = new Orden;
                
                //print_r($_POST);
                //exit();
		
		if (isset($_POST['query']))
		{
			$dataProvider = $orden->filtrado($_POST['query']);
		}
		else
			$dataProvider = $orden->search();
                
                //Ordenar por fecha descendiente
                $criteria = $dataProvider->getCriteria();
                $criteria->order = 'fecha DESC';
                $dataProvider->setCriteria($criteria);
                
		
		$this->render('admin',
		array('orden'=>$orden,
		'dataProvider'=>$dataProvider,
		));

	}
	

	public function actionModalventas(){
		$html='';
		$html=$html.'<div class="modal hide fade">';
  		$html=$html.'<div class="modal-header">';
    	$html=$html.'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
    	$html=$html.'<h3>Pedido #__ - Vista de prendas pedidas</h3>';
  		$html=$html.'</div>';
  		$html=$html.'<div class="modal-body">';
    	$html=$html.'';
    	// Tabla ON
    	//Header de la tabla ON
   		$html=$html.'<div class="well well-small margin_top well_personaling_small"> <h3 class="braker_bottom margin_top"> Resumen del Pedido</h3>';
      	$html=$html.'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">';
        $html=$html.'<thead><tr>';
        $html=$html.'<th scope="col">Nombre de la prenda</th>';
        $html=$html.'<th scope="col">Cantidad</th>';
        $html=$html.'<th scope="col">Precio por unidad</th>';
        $html=$html.'<th scope="col">Precio total</th>';
        $html=$html.'</tr>';
        $html=$html.'</thead><tbody>';
        //Header de la tabla OFF
        //Cuerpo de la tabla ON
        
        $html=$html.'<tr>';
        // Primera columna ON
        $html=$html.'<td> Vestido <br/> ';
        $html=$html.'Color: Gris Rata <br/>';
        $html=$html.'Talla: M ';
        $html=$html.'</td></tr>';
        // Primera columna OFF
        // Segunda columna ON
        $html=$html.'<td>';
		$html=$html.'__';
        $html=$html.'</td>';
        // Segunda columna OFF
        // Tercera columna ON
        $html=$html.'<td>';
		$html=$html.'__';
        $html=$html.'</td>';
        // Tercera columna OFF
        // Cuarta columna ON
        $html=$html.'<td>';
		$html=$html.'__';
        $html=$html.'</td>';
        // Cuarta columna OFF        

        $html=$html.'<tr>';
        
        //Cuerpo de la tabla OFF
        $html=$html.'</tbody></table></div>';
        // Tabla OFF
  		$html=$html.'</div>';
		$html=$html.'</div>';
		echo $html;

	}

	public function actionDetalles($id)
	{
		$orden = Orden::model()->findByPk($id);
		
		$this->render('detalle', array('orden'=>$orden,));
	}
	
	public function actionFactura($id)
	{
		$factura = Factura::model()->findByPk($id);
		
		$this->render('factura', array('factura'=>$factura));
	}
	
	public function actionRecibo($id)
	{
		$factura = Factura::model()->findByPk($id);
		
		$this->render('recibo', array('factura'=>$factura));
	}
	
	public function actionImprimir($id)
	{
		$factura = Factura::model()->findByPk($id);
		$mPDF1 = Yii::app()->ePdf->mpdf('', 'Letter-L', 0,'',15,15,16,16,9,9,'L');
		$mPDF1->WriteHTML($this->renderPartial('recibo', array('factura'=>$factura), true));
		$mPDF1->Output();	
		
		//$this->render('recibo', array('factura'=>$factura));
	}
	
	public function actionValidar()
	{
		// Elementos para enviar el correo, depende del estado en que quede la orden
		$message            = new YiiMailMessage;
		$message->view = "mail_template";
		
		$detalle = Detalle::model()->findByPk($_POST['id']);
		$orden = Orden::model()->findByAttributes(array('id'=>$detalle->orden_id));
		$factura = Factura::model()->findByAttributes(array('orden_id'=>$orden->id));
		
		$user = User::model()->findByPk($orden->user_id);
		//$subject = 'Recupera tu contraseña de Personaling';
		//$body = '<h2>Has solicitado cambiar tu contraseña de Personaling.</h2> Para recibir una nueva contraseña haz clic en el seiguiente link:<br/><br/> '.$activation_url;
		
		
		if($_POST['accion']=="aceptar")
		{
			
			$detalle->estado = 1; // aceptado
			
			
	
			if($detalle->save()){
				/*
				 * Revisando si lo depositado es > o = al total de la orden. 
				 * */
				if($detalle->monto >= $orden->total){
					/*
					 * Hacer varias cosas, si es igual que haga el actual proceso, si es mayor ponerlo como positivo
					 * Si es menor aceptarlo pero ponerle saldo negativo y no cambiar el estado de la orden
					 * 
					 * */
					$orden->estado = 3;
					
					if($orden->save()){
						if($factura){
							$factura->estado = 2;
							$factura->save();
						}
						// Subject y body para el correo
						$subject = 'Pago aceptado';
						$body = '<h2> Tu pago ha sido aceptado.</h2> Estamos preparando tu pedido para el envío.<br/><br/> ';
						
						$usuario = Yii::app()->user->id;
						
						$desc = Balance::model()->findByAttributes(array('orden_id'=>$orden->id,'user_id'=>$orden->user_id));
							
						if(isset($desc))
						{
							if($desc < 0)
							{
								$a = $desc->total + $detalle->monto; // si es menor le sumo lo que depositaron
								$desc->total = $a;
								$desc->save();
							}
							
							//si deposito de mas
							if($detalle->monto > $orden->total)
							{	
								$excede = $detalle->monto - $orden->total;
								$desc->total = $excede;							
								$desc->save();
								// Cambio el body del correo para agregar el saldo que sobra
								$body .= 'Tienes disponible un saldo a favor de '.$excede.' Bs.';
							}
						}
						else					
						if($detalle->monto > $orden->total)
						{
							$excede = $detalle->monto - $orden->total;
							
							$balance = new Balance;
							$balance->orden_id = $orden->id;
							$balance->user_id = $orden->user_id;
							$balance->total = $excede;
							
							$balance->save();
							$body .= 'Tienes disponible un saldo a favor de '.$excede.' Bs.';
						} // si es mayor hace el balance
						
													
							// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
							$estado = new Estado;
													
							$estado->estado = 3; // pago recibido
							$estado->user_id = $orden->user_id;
							$estado->fecha = date("Y-m-d");
							$estado->orden_id = $orden->id;
									
							if($estado->save())
							{
								echo "ok";	
							}					

					}//orden save
				}// si es mayor
				else{
					
					$desc = Balance::model()->findByAttributes(array('orden_id'=>$orden->id,'user_id'=>$orden->user_id));
					
					if(isset($desc)) // balance existe 
					{
						if($desc->total < 0) // debe
						{
							$debe = Yii::app()->numberFormatter->formatDecimal($desc->total); 
							$paga = Yii::app()->numberFormatter->formatDecimal($detalle->monto); 
							
							if(($debe * -1) == $paga) // paga exacta la deuda
							{
								$detalle->comentario = "deberia aqui";
								$detalle->save();
								
								$desc->delete(); // son identicos, no habria saldo a favor ni en contra por lo tanto se borra el balance
								
								$orden->estado = 3; // aprobado el pago
								$orden->save();
								if($factura){
									$factura->estado = 2;
									$factura->save();
								}
								$subject = 'Pago aceptado';
								$body = '<h2> Tu pago ha sido aceptado.</h2> Estamos preparando tu pedido para el envío.<br/><br/> ';
								
								// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
								$estado = new Estado;
														
								$estado->estado = 3; // pago recibido
								$estado->user_id = $orden->user_id;
								$estado->fecha = date("Y-m-d");
								$estado->orden_id = $orden->id;
								
							}else 
							if(($debe * -1) < $paga)
							{
								$detalle->comentario = "aqui no";
								$detalle->save();
								
								$valor = $desc->total + $detalle->monto; // lo que debia +lo que pague (como es negativo lo sumo para que subsane la deuda)
								$desc->total = $valor;
								$desc->save();
								
								$orden->estado = 3;
								$orden->save();
								if($factura){
									$factura->estado = 2;
									$factura->save();
								}
								$subject = 'Pago aceptado';
								$body = '<h2> Tu pago ha sido aceptado.</h2> Estamos preparando tu pedido para el envío.<br/><br/> ';
								
								// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
								$estado = new Estado;
														
								$estado->estado = 3; // pago recibido
								$estado->user_id = $orden->user_id;
								$estado->fecha = date("Y-m-d");
								$estado->orden_id = $orden->id;
								
							}else 							
							if(($debe * -1) > $paga) 
							{
								$valor = $desc->total + $detalle->monto; // lo que debia + lo que pague (como es negativo lo sumo para que subsane la deuda)
								$desc->total = $valor;
								$desc->save();
								
								$orden->estado = 7;// aun le faltó
								$orden->save();
								$subject = 'Pago insuficiente';
								$body = 'El pago que realizaste no cubre el monto del pedido, faltan '.$valor.' Bs para pagar toda la orden.<br/><br/> ';
								
								// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
								$estado = new Estado;
															
								$estado->estado = 7; // pago insuficiente
								$estado->user_id = Yii::app()->user->id;
								$estado->fecha = date("Y-m-d");
								$estado->orden_id = $orden->id;
								
							}
							
						if($estado->save())
							{
								echo "ok";	
							}	
							
						}
						
					}
					else { // no hay balance, solo pago menos
					
					$detalle->comentario = "aqui jamas";
					$detalle->save();
					
					$orden->estado = 7;
					if($orden->save()){
						$falta = $detalle->monto - $orden->total;
							
						$balance = new Balance;
						$balance->orden_id = $orden->id;
						$balance->user_id = $orden->user_id;
						$balance->total = $falta;
						
						$subject = 'Pago insuficiente';
						$body = 'El pago que realizaste no cubre el monto del pedido, faltan '.($falta*-1).' Bs para pagar toda la orden.<br/><br/> ';
								
						if($balance->save())
						{
						// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
							$estado = new Estado;
														
							$estado->estado = 7; // pago insuficiente
							$estado->user_id = Yii::app()->user->id;
							$estado->fecha = date("Y-m-d");
							$estado->orden_id = $orden->id;
										
							if($estado->save())
							{
								echo "ok";	
							}	
						}	
						
					}
				
					}
					
				}	
							
			}// detalle
		}
		else if($_POST['accion']=="rechazar")
		{
			$detalle = Detalle::model()->findByPk($_POST['id']);
			$detalle->estado = 2; // rechazado
			
			$orden = Orden::model()->findByAttributes(array('detalle_id'=>$detalle->id));
			$orden->estado = 1; // regresa a "En espera de pago"
			
			if($detalle->save()){
				if($orden->save()){
					$subject = 'Pago rechazado';
					$body = 'El pago que realizaste fue rechazado. Por favor procesa el pago nuevamente a través del sistema.<br/><br/> ';
					
					$usuario = Yii::app()->user->id; 
						
						// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
						$estado = new Estado;
											
						$estado->estado = 6; // pago rechazado
						$estado->user_id = $usuario;
						$estado->fecha = date("Y-m-d");
						$estado->orden_id = $orden->id;
							
						if($estado->save())
						{
							echo "ok";	
						}
				}
			}
		}
		$params              = array('subject'=>$subject, 'body'=>$body);
		$message->subject    = $subject;
		$message->setBody($params, 'text/html');                
		$message->addTo($user->email);
		$message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
		Yii::app()->mail->send($message);
	}

	/*
	 * Modal del listado
	 * 
	 * */
	public function actionModals($id)
	{
		$orden = Orden::model()->findByPk($id);
		
		if($orden->estado == 7){
			$detPago = new Detalle;
		}
		else {
			$detPago = Detalle::model()->findByPk($orden->detalle_id);
		}
		
		$datos="";
  		$datos=$datos."<div class='modal-header'>";
		$datos=$datos."<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>";
		$datos=$datos."<h4> Agregar Depósito o Transferencia bancaria ya realizada</h4>";
    	$datos=$datos."</div>";
  
  		$datos=$datos."<div class='modal-body'>";
  		$datos=$datos."<form class=''>";
		$datos=$datos."<input type='hidden'id='idOrden' value='".$orden->id."' />";
		
  		$datos=$datos."<div class='control-group'>";
    	$datos=$datos."<div class='controls'>";
      	$datos=$datos. CHtml::activeTextField($detPago,'nombre',array('id'=>'nombre','class'=>'span5','placeholder'=>'Nombre del Depositante')) ;
		$datos=$datos."<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeTextField($detPago,'nTransferencia',array('id'=>'numeroTrans','class'=>'span5','placeholder'=>'Número o Código del Depósito')) ;
		$datos=$datos."<div style='display:none' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeDropDownList($detPago,'banco',array('Seleccione'=>'Seleccione','Banesco'=>'Banesco. Cuenta: 0134 0277 98 2771093092'),array('id'=>'banco','class'=>'span5')); 
		//$datos=$datos. CHtml::activeTextField($detPago,'banco',array('id'=>'banco','class'=>'span5','placeholder'=>'Banco donde se realizó el deposito'));
        $datos=$datos."<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeTextField($detPago,'cedula',array('id'=>'cedula','class'=>'span5','placeholder'=>'Cedula del Depositante'));
        $datos=$datos."<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeTextField($detPago,'monto',array('id'=>'monto','class'=>'span5','placeholder'=>'Monto')); 
		$datos=$datos. "<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='controls controls-row'>";
		$datos=$datos. CHtml::TextField('dia','',array('id'=>'dia','class'=>'span1','placeholder'=>'Día'));
		$datos=$datos. CHtml::TextField('mes','',array('id'=>'mes','class'=>'span1','placeholder'=>'Mes')); 
		$datos=$datos. CHtml::TextField('ano','',array('id'=>'ano','class'=>'span2','placeholder'=>'Año')); 
      	$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeTextArea($detPago,'comentario',array('id'=>'comentario','class'=>'span5','rows'=>'6','placeholder'=>'Comentarios (Opcional)')); 
        $datos=$datos."<div style='display:none' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='form-actions'><a onclick='enviar()' class='btn btn-danger'>Confirmar Deposito</a></div>";
      	$datos=$datos."<p class='text_align_center'><a title='Formas de Pago' href='".Yii::app()->baseUrl."/site/formas_de_pago'> Terminos y Condiciones de Recepcion de pagos por Deposito y/o Transferencia</a><br/></p>";
    	$datos=$datos."</form>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		if($orden->estado == 7){
			$datos=$datos."<input type='hidden' id='idDetalle' value='0' />";
		}
		else {
			$datos=$datos."<input type='hidden' id='idDetalle' value='".$orden->detalle_id."' />";
		}
		echo $datos;
	}

	public function actionCancelar($id)
	{
			
		$orden = Orden::model()->findByPK($id);
		
		if($orden->estado==1)
		{
			$orden->estado = 5;	// se canceló la orden
					
			if($orden->save())
			{
				// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
				$estado = new Estado;
										
				$estado->estado = 5;
				$estado->user_id = Yii::app()->user->id; // quien cancelo la orden
				$estado->fecha = date("Y-m-d H:i:s");
				$estado->orden_id = $orden->id;
						
				if($estado->save())
				{
					Yii::app()->user->setFlash('success', 'Se ha cancelado la orden.');
					
					$this->redirect(array('listado'));
					
				}
			}	
		}
		else
		{
			Yii::app()->user->setFlash('error', "No es posible cancelar la orden dado que ya se ha registrado algún pago.");
			$this->redirect(array('listado'));
		}
		
	}

	/*
	 *  Action para añadir el tracking y cambiar el estado a enviado
	 * */

	public function actionEnviar()
	{
		$orden = Orden::model()->findByPK($_POST['id']);
		
		$orden->tracking = $_POST['guia'];
		$orden->estado=4; // enviado
		
		if($orden->save())
			{
				// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
				$estado = new Estado;
										
				$estado->estado = 4;
				$estado->user_id = Yii::app()->user->id; // quien cancelo la orden
				$estado->fecha = date("Y-m-d H:i:s");
				$estado->orden_id = $orden->id;
						
				if($estado->save())
				{
						$user = User::model()->findByPk($orden->user_id);		
						$message            = new YiiMailMessage;
						$message->view = "mail_template";
						$subject = 'Tu compra en Personaling #'.$orden->id.' ha sido enviada';
						$body = "Nos complace informar que tu pedido #".$orden->id." ha sido enviado <br/>
								<br/>
								Empresa: Zoom <br/>
								Número de seguimiento: ".$orden->tracking." <br/> 
								";
						$params              = array('subject'=>$subject, 'body'=>$body);
						$message->subject    = $subject;
						$message->setBody($params, 'text/html');                
						$message->addTo($user->email);
						$message->from = array('ventas@personaling.com' => 'Tu Personal Shopper Digital');
						Yii::app()->mail->send($message);
						
					/*
						// Enviar correo cuando se envia la compra
						$user = User::model()->findByPk($orden->user_id);
						$message             = new YiiMailMessage;
						//this points to the file test.php inside the view path
						$message->view = "mail_template";
						$subject = 'Tu compra en Pesonaling #'.$orden->id.' ha sido enviada';
						$body = "Nos complace informarte que tu pedido #".$orden->id." ha sido enviado </br>
								</br>
								Empresa: Zoom </br>
								Número de seguimiento: ".$orden->tracking." </br> 
								";
						$params              = array('body'=>$body);
						$message->subject    = $subject;
						$message->setBody($params, 'text/html');
						$message->addTo($user->email);
						$message->from = array('ventas@personaling.com' => 'Tu Personal Shopper Digital');
						
						Yii::app()->mail->send($message);					
					*/
					
					Yii::app()->user->setFlash('success', 'Se ha enviado la orden.');
					
					echo "ok";
				}
		}	
		
	}

	public function actionMensajes()
	{
		$notificar = $_POST['notificar'];
			
		$mensaje = new Mensaje;
		
		$mensaje->asunto = $_POST['asunto'];
		$mensaje->cuerpo = $_POST['cuerpo'];
		$mensaje->visible = $_POST['visible']; // llega 0 o 1, 1 visible, 0 no
		$mensaje->user_id = $_POST['user_id'];
		$mensaje->orden_id = $_POST['orden_id']; 
		$mensaje->fecha =  date('Y-m-d H:i:s', strtotime('now'));
		$mensaje->estado = 0; // sin leer
		
		if($mensaje->save())
		{
			if($notificar == 1) // pidió notificar por email 	
			{
				$usuario = User::model()->findByPk($_POST['user_id']); 
				
				$message = new YiiMailMessage;
                $message->view = "mail_template";
                $subject = 'Tienes un mensaje nuevo en Personaling';
                $body = '<h2>Tienes un mensaje en Personaling.</h2>' . 
                        '<br/><br/>' .
                        'El Administrador del sistema te ha enviado un mensaje referente a tu compra <br/>'. 
                        'Ingresa con tu usuario y revisa tus notificaciones.';
				$params = array('subject' => $subject, 'body' => $body);
                $message->subject = $subject;
                $message->setBody($params, 'text/html');
                $message->addTo($usuario->email);
                $message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
                Yii::app()->mail->send($message);	
			}		
			
			Yii::app()->user->setFlash('success', 'Se ha enviado el mensaje correctamente.');
			echo "ok";	
		}	
		
	}
		

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}