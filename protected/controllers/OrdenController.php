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
				'actions'=>array('detallepedido','listado','modals'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','admin','detalles','validar'),
				'users'=>array('admin'),
				'expression' => 'Yii::app()->user->isAdmin()',
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
		
		//if (isset($_POST['query']))
		//{
			//echo($_POST['query']);	
			//$producto->nombre = $_POST['query'];
		//}	
		
		$dataProvider = $orden->search();
		
		$this->render('admin',
		array('orden'=>$orden,
		'dataProvider'=>$dataProvider,
		));

	}
	
	public function actionDetalles($id)
	{
		$orden = Orden::model()->findByPk($id);
		
		$this->render('detalle', array('orden'=>$orden,));
	}
	
	public function actionValidar()
	{
		if($_POST['accion']=="aceptar")
		{
			$detalle = Detalle::model()->findByPk($_POST['id']);
			$detalle->estado = 1; // aceptado
			
			$orden = Orden::model()->findByAttributes(array('id'=>$detalle->orden_id));
	
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

	}

	/*
	 * Modal del listado
	 * 
	 * */
	public function actionModals($id)
	{
		$orden = Orden::model()->findByPk($id);
		$detPago = Detalle::model()->findByPk($orden->detalle_id);
		
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
		$datos=$datos. CHtml::activeTextField($detPago,'banco',array('id'=>'banco','class'=>'span5','placeholder'=>'Banco donde se realizó el deposito'));
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
      	$datos=$datos."<p class='well well-small'><strong>Terminos y Condiciones de Recepcion de pagos por Deposito y/o Transferencia</strong><br/>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ul </p>";
    	$datos=$datos."</form>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<input type='hidden' id='idDetalle' value='".$orden->detalle_id."' />";

		echo $datos;
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