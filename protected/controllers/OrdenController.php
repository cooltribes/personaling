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
				'actions'=>array('detallepedido','listado','modals','cancelar','recibo','imprimir', 'getFilter','removeFilter','historial','mensajes'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions			

				'actions'=>array('index','cancel','admin','modalventas','detalles','devoluciones','validar','enviar','factura','entregar','calcularenvio','createexcel','importarmasivo','reporte'),

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
		$dataProvider = $orden->activas();
		
		$this->render('adminUsuario',
		array('orden'=>$orden,
		'dataProvider'=>$dataProvider,
		));

	}

public function actionReporte()
	{ 
		
  
		
		$orden = new Orden;
		
		//$orden->user_id = Yii::app()->user->id;
		$dataProvider = $orden->vendidas();
		
		$this->render('reporte',
		array(
		'dataProvider'=>$dataProvider,
		));


	}
	public function actionHistorial()
	{
		$orden = new Orden;
		
		$orden->user_id = Yii::app()->user->id;
		$dataProvider = $orden->historial();
		
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
			$this->render('detalleUsuario', array('orden'=>$orden));
		
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
            $dataProvider = $orden->search();               
            
            if((isset($_SESSION['todoPost']) && !isset($_GET['ajax'])))
            {
                unset($_SESSION['todoPost']);
            }
            
            //Filtros personalizados
            $filters = array();
            
            //Para guardar el filtro
            $filter = new Filter;
            
            
           if(isset($_GET['ajax']) && !isset($_POST['dropdown_filter']) && isset($_SESSION['todoPost'])
               && !isset($_POST['query'])){
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
                
                    $dataProvider = $orden->buscarPorFiltros($filters);                    
                     
                     //si va a guardar
                     if (isset($_POST['save'])){                        
                         
                         //si es nuevo
                         if (isset($_POST['name'])){
                            
                            $filter = Filter::model()->findByAttributes(
                                    array('name' => $_POST['name'], 'type' => '1') //Filtros para ventas
                                    ); 
                            if (!$filter) {
                                $filter = new Filter;
                                $filter->name = $_POST['name'];
                                $filter->type = 1;
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
                                
                                //Crear los nuevos
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

            if (isset($_POST['query'])){
                unset($_SESSION["todoPost"]);
                $dataProvider = $orden->filtrado($_POST['query']); 
                
            }
            
            //Ordenar por fecha descendiente
            $criteria = $dataProvider->getCriteria();
            $criteria->order = 'fecha DESC';
            $dataProvider->setCriteria($criteria);       

            $this->render('admin', array('orden' => $orden,
                'dataProvider' => $dataProvider,
            ));

	}
	
        
        /**          
         * Obtiene el filtro con id $id          
         */

        public function actionGetFilter() {
            
            $response = array();
            if(isset($_POST['id'])){
                $filter = Filter::model()->findByPk($_POST['id']);                
                
                if($filter){                
                   
                   $response['filter']  = $filter->filterDetails;
                   $response['status'] = 'success';
                    
                }else{
                  $response['status'] = 'error';
                  $response['message'] = 'Filtro no encontrado';
                }               
                
                
            }
            
            echo CJSON::encode($response);
            
        }
        
        
        /**
         * Elimina un filtro
         * */
        
        public function actionRemoveFilter() {
            
            $response = array();
            if(isset($_POST['id'])){
                $filter = Filter::model()->findByPk($_POST['id']);                
                
                if($filter){ 
                    
                   $filter->delete(); 
                   $response['status'] = 'success';
                   $response['message'] = 'Se ha eliminado el filtro <b>'.
                           $filter->name.'</b>';
                   
                    
                }else{
                  $response['status'] = 'error';
                  $response['message'] = 'Filtro no encontrado';
                }               
                
                
            }
            
            echo CJSON::encode($response);
            
        }
        
	public function actionModalventas($id){
		
		$id=$_POST['ord'];
	  	Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;	
		Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap-responsive.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap-yii.css'] = false;
		Yii::app()->clientScript->scriptMap['jquery-ui-bootstrap.css'] = false;		
	
		$ordhasptc= OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$id));
		$productos=Array();
		$ptc=Array();
		foreach($ordhasptc as $ohptc){				
			
				$ptc= Preciotallacolor::model()->findByPk($ohptc->preciotallacolor_id);
				$pr=Producto::model()->findByPk($ptc->producto_id);
				$var[0]=$pr->id;
				$var[1]=$ptc->id;
				$var[2]=$ohptc->precio;
				$var[3]=$ohptc->cantidad;
				array_push($productos,$var);
					
		}
		
		
		
		$html='';
		// $html=$html.'<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
  		$html=$html.'<div class="modal-header">';
    	$html=$html.'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
    	$html=$html.'<h3>Vista de prendas pedidas</h3>';
  		$html=$html.'</div>';
  		$html=$html.'<div class="modal-body">';
    	$html=$html.'';
		
		
		
		
    	// Tabla ON
    	//Header de la tabla ON
   		$html=$html.'<div class="well well-small margin_top well_personaling_small"><h3>Pedido #'.$id.'</h3>';
		
      	$html=$html.'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">';
        $html=$html.'<thead><tr>';
        $html=$html.'<th scope="col">Nombre de la prenda</th>';
        $html=$html.'<th scope="col">Cantidad</th>';
        $html=$html.'<th scope="col">Precio por unidad</th>';
        $html=$html.'<th scope="col">Precio total</th>';
        $html=$html.'</tr>';
        $html=$html.'</thead><tbody>';
        
		 foreach ($productos as $idp) {
			 $producto=Producto::model()->findByPk($idp[0]);
			 $marca=Marca::model()->findByPk($producto->marca_id);
			 $ptc=PrecioTallaColor::model()->findByPk($idp[1]);
			 $talla=Talla::model()->findByPk($ptc->talla_id);
			 $color=Color::model()->findByPk($ptc->color_id);
			 $precio=Precio::model()->getPrecioDescuento($idp[0]);
			 
			  $html=$html.'<tr>';
	        // Primera columna ON
	        $html=$html.'<td><strong>'.$producto->nombre.'</strong><br/> ';
	        $html=$html.'<small><strong>Marca:</strong>'.$marca->nombre.'</small> <br/>';
	        $html=$html.'<small><strong>Color:</strong>'.$color->valor.'</small> <br/>';
	        $html=$html.'<small><strong>Talla:</strong>'.$talla->valor.'</small> <br/>';
			$html=$html.'<small><strong>REF:</strong>'.$producto->codigo.'</small> ';
	        $html=$html.'</td>';
	        // Primera columna OFF
	        // Segunda columna ON
	        $html=$html.'<td>';
			$html=$html.$idp[3];
	        $html=$html.'</td>';
	        // Segunda columna OFF
	        // Tercera columna ON
	        $html=$html.'<td>';
			$html=$html.number_format($precio, 2, ',', '.')."  Bs.";
	        $html=$html.'</td>';
	        // Tercera columna OFF
	        // Cuarta columna ON
	        $html=$html.'<td>';
			$html=$html.number_format($precio*$idp[3], 2, ',', '.')." Bs.";
	        $html=$html.'</td>';
	        // Cuarta columna OFF        

        $html=$html.'<tr>';
			 
			 
			 
			 
			 
		 }
		
		
		
		
        //Header de la tabla OFF
        //Cuerpo de la tabla ON
        /*
        $html=$html.'<tr>';
        // Primera columna ON
        $html=$html.'<td><strong>Vestido</strong><br/> ';
        $html=$html.'<small><strong>Marca:</strong> Nidea </small> <br/>';
        $html=$html.'<small><strong>Color:</strong> Gris Rata </small> <br/>';
        $html=$html.'<small><strong>Talla:</strong> M </small> ';
        $html=$html.'</td>';
        // Primera columna OFF
        // Segunda columna ON
        $html=$html.'<td>';
		$html=$html.'5';
        $html=$html.'</td>';
        // Segunda columna OFF
        // Tercera columna ON
        $html=$html.'<td>';
		$html=$html.'52,00 Bs.';
        $html=$html.'</td>';
        // Tercera columna OFF
        // Cuarta columna ON
        $html=$html.'<td>';
		$html=$html.'104,00 Bs.';
        $html=$html.'</td>';
        // Cuarta columna OFF        

        $html=$html.'<tr>';
        
        $html=$html.'<tr>';
        // Primera columna ON
        $html=$html.'<td><strong>Ruana</strong><br/> ';
        $html=$html.'<small><strong>Marca:</strong> Nidea </small> <br/>';
        $html=$html.'<small><strong>Color:</strong> Horrible </small> <br/>';
        $html=$html.'<small><strong>Talla:</strong> 3 </small> ';
        $html=$html.'</td>';
        // Primera columna OFF
        // Segunda columna ON
        $html=$html.'<td>';
		$html=$html.'5';
        $html=$html.'</td>';
        // Segunda columna OFF
        // Tercera columna ON
        $html=$html.'<td>';
		$html=$html.'520,00 Bs.';
        $html=$html.'</td>';
        // Tercera columna OFF
        // Cuarta columna ON
        $html=$html.'<td>';
		$html=$html.'1040,00 Bs.';
        $html=$html.'</td>';
        // Cuarta columna OFF        

        $html=$html.'<tr>';

        $html=$html.'<tr>';
        // Primera columna ON
        $html=$html.'<td><strong>Vestido</strong><br/> ';
        $html=$html.'<small><strong>Marca:</strong> Nidea </small> <br/>';
        $html=$html.'<small><strong>Color:</strong> Gris Rata </small> <br/>';
        $html=$html.'<small><strong>Talla:</strong> M </small> ';
        $html=$html.'</td>';
        // Primera columna OFF
        // Segunda columna ON
        $html=$html.'<td>';
		$html=$html.'5';
        $html=$html.'</td>';
        // Segunda columna OFF
        // Tercera columna ON
        $html=$html.'<td>';
		$html=$html.'52,00 Bs.';
        $html=$html.'</td>';
        // Tercera columna OFF
        // Cuarta columna ON
        $html=$html.'<td>';
		$html=$html.'104,00 Bs.';
        $html=$html.'</td>';
        // Cuarta columna OFF        

        $html=$html.'<tr>';        
*/
        //Cuerpo de la tabla OFF
        $html=$html.'</tbody></table></div>';
        // Tabla OFF
  		$html=$html.'</div></div>';
		echo $html;
		
		
		
	


	}

	public function actionDetalles($id)
	{
		$orden = Orden::model()->findByPk($id);
		
		$this->render('detalle', array('orden'=>$orden,));
	}

	/*
	 * Action para las devoluciones 
	 * Recibe parametro id por get
	 */	  
    public function actionDevoluciones(){
    	

		if(isset($_POST['orden']) && isset($_POST['check']))
		{
			$checks = explode(',',$_POST['check']); // checks va a tener los id de preciotallacolor
			$cont = 0; 
			
			foreach($checks as $uno)
			{
				$orden = Orden::model()->findByPk($_POST['orden']);
				$ptcolor = Preciotallacolor::model()->findByAttributes(array('sku'=>$uno));
				$ptc = OrdenHasProductotallacolor::model()->findByAttributes(array('tbl_orden_id'=>$_POST['orden'],'preciotallacolor_id'=>$ptcolor->id)); // para asignarle el id
				
				$devuelto = new Devolucion; 
				
				$devuelto->user_id = $orden->user_id;
				$devuelto->orden_id = $orden->id;
				$devuelto->preciotallacolor_id = $ptcolor->id;
				$devuelto->motivo = $_POST['motivos'][$cont];
				$devuelto->montodevuelto = $_POST['monto'];
				$devuelto->montoenvio = $_POST['envio'];
				
				$devuelto->save();
				
				if($_POST['motivos'][$cont] != "Devolución por prenda dañada")
				{
					$ptcolor->cantidad ++; // devuelvo la prenda a inventario
					$ptcolor->save();
				}
				
				$ptc->devolucion_id = $devuelto->id;
				$ptc->save();

				$cont++;
			}
			
			// devolviendo el saldo
			
			$balance = new Balance;
			$balance->total = $_POST['monto'];
			$balance->orden_id = $_POST['orden'];
			$balance->user_id = $orden->user_id;
			$balance->tipo = 4;
			
			$balance->save();
			
			// revisando si es una devolucion completa o parcial
			$devueltos = count($_POST['motivos']);
			$total = OrdenHasProductotallacolor::model()->countByAttributes(array('tbl_orden_id'=>$_POST['orden']));
			
			if($devueltos == $total){
				$orden->estado = 9; // devuelto
				
				$estado = new Estado;
				
				$estado->estado = 9;
				$estado->user_id = $orden->user_id;
				$estado->fecha = date("Y-m-d");
				$estado->orden_id = $orden->id;
				
				$estado->save();
			}					
			else if($devueltos < $total){
				$orden->estado = 10; // parcialmente devuelto
				
				$estado = new Estado;
				
				$estado->estado = 10;
				$estado->user_id = $orden->user_id;
				$estado->fecha = date("Y-m-d");
				$estado->orden_id = $orden->id;
				
				$estado->save();
			}
			
			$orden->save();
			
			echo "ok";
		}
		
		if(isset($_GET['id']))
		{
			$orden = Orden::model()->findByPk($_GET['id']);
			$this->render('devoluciones',array('orden'=>$orden));
		}
        
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
	
	public function actionImprimir($id, $documento) {

            if (isset($documento)) {
                $factura = Factura::model()->findByPk($id);
                $mPDF1 = Yii::app()->ePdf->mpdf('', 'Letter-L', 0, '', 15, 15, 16, 16, 9, 9, 'L');

                if ($_GET['documento'] == "factura") {
                    $mPDF1->WriteHTML($this->renderPartial('factura', array('factura' => $factura), true));
                } else if ($documento == "recibo") {
                    $mPDF1->WriteHTML($this->renderPartial('recibo', array('factura' => $factura), true));
                }

                $mPDF1->Output();
            }
        //$this->render('recibo', array('factura'=>$factura));
	}
	
	                                                                    
                                             
public function actionValidar()
	{ 
		
		// Elementos para enviar el correo, depende del estado en que quede la orden
		$message            = new YiiMailMessage;
		$message->view = "mail_template";
		 
		$detalle = Detalle::model()->findByPk($_POST['id']);
		$orden = Orden::model()->findByAttributes(array('id'=>$detalle->orden_id));
		$acumulado=$detalle->getSumxOrden();
		
		$factura = Factura::model()->findByAttributes(array('orden_id'=>$orden->id));
		
		$user = User::model()->findByPk($orden->user_id);
		//$subject = 'Recupera tu contraseña de Personaling';
		//$body = '<h2>Has solicitado cambiar tu contraseña de Personaling.</h2> Para recibir una nueva contraseña haz clic en el seiguiente link:<br/><br/> '.$activation_url;
		$porpagar=$orden->getxPagar();
			
		if($_POST['accion']=="aceptar")
		{
			
			$detalle->estado = 1; // aceptado
			
			if($detalle->save()){
				/*
				 * Revisando si lo depositado es > o = al total de la orden. 
				 * */
				$difencia_pago = round(($detalle->monto - $porpagar),3,PHP_ROUND_HALF_DOWN);
				if( $diferencia_pago >= 0){
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
							$estado = new Estado;
													
							$estado->estado = 3; // pago recibido
							$estado->user_id = Yii::app()->user->id;
							$estado->fecha = date("Y-m-d");
							$estado->orden_id = $orden->id;
									
							if($estado->save())
							{
								echo "ok";
							}
						}
						// Subject y body para el correo
						$subject = 'Pago aceptado';
						$body = '<h2> ¡Genial! Tu pago ha sido aceptado.</h2> Estamos preparando tu pedido para el envío, muy pronto podrás disfrutar de tu compra. <br/><br/> ';
						
						$usuario = Yii::app()->user->id;
						$excede = ($detalle->monto-$porpagar);	
						if(($excede) > 0.5)
						{
							
						
							$balance = new Balance;
							$balance->orden_id = $orden->id;
							$balance->user_id = $orden->user_id;
							$balance->total = $excede;
							
							$balance->save();
							$body .= 'Tenemos una buena noticia, tienes disponible un saldo a favor de '.Yii::app()->numberFormatter->formatCurrency($excede, '').' Bs.';
						} // si es mayor hace el balance
						
													
							// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
					
					}//orden save
				}// si el pago realizado es mayor o igual
				else{
					
					
					$saldo = Profile::model()->getSaldo($orden->user_id);
					if($saldo>0){

						$det_bal=new Detalle;
						//$pag_bal=new Pago;
						if($saldo>($porpagar-$detalle->monto)){
							
							$det_bal->monto=($porpagar-$detalle->monto);
							$det_bal->fecha=date("Y-m-d H:m:s");
							$det_bal->comentario="Saldo para completar";
							$det_bal->estado=1;
							$det_bal->orden_id=$orden->id;
							$det_bal->tipo_pago = 3;
							if($det_bal->save()){
								//$pag_bal->tbl_detalle_id=$det_bal->id;
								//$pag_bal->tipo=3;
								$estado = new Estado;
													
								$estado->estado = 3; // pago recibido
								$estado->user_id = Yii::app()->user->id;
								$estado->fecha = date("Y-m-d");
								$estado->orden_id = $orden->id;
										
								if($estado->save())
								{
									//$pag_det->save();
									echo "ok";	
								}	
							}
												
							
							$orden->estado = 3;
							if($orden->save()){
								
								$subject = 'Pago aceptado';
								$body = '<h2> ¡Genial! Tu pago ha sido aceptado.</h2> Estamos preparando tu pedido para el envío, muy pronto podrás disfrutar de tu compra. <br/><br/> ';
								
								$usuario = Yii::app()->user->id;
								
								if($factura){
									$factura->estado = 2;
									$factura->save();
								}
								$balance = new Balance;
								$balance->orden_id = $orden->id;
								$balance->user_id = $orden->user_id;
								$balance->total = ($porpagar-$detalle->monto)*-1;
								$balance->tipo=1;
								
								$balance->save();
									
								
							}
								
						}//Saldo cubre la deuda
						else{
								
							$orden->estado = 7;
							
							if($orden->save()){
								$balance = new Balance;
								$balance->orden_id = $orden->id;
								$balance->user_id = $orden->user_id;
								$balance->total = $saldo*(-1);
								$balance->tipo=1;								
								if($balance->save()){
									$subject = 'Pago insuficiente';
									$body = '¡Upsss! El pago que realizaste no cubre el monto del pedido, faltan '.Yii::app()->numberFormatter->formatCurrency($orden->getxPagar(), '').' Bs para pagar toda la orden.<br/><br/> ';
									$estado = new Estado;
																
									
									$det_bal->monto=$saldo;
									$det_bal->fecha=date("Y-m-d H:m:s");
									$det_bal->comentario="Uso Saldo Falta Pago ";
									$det_bal->estado=1;
									$det_bal->orden_id=$orden->id;
									if($det_bal->save()){
										$estado->estado = 7; // pago insuficiente
									$estado->user_id = Yii::app()->user->id;
									$estado->fecha = date("Y-m-d");
									$estado->orden_id = $orden->id;
									
									if($estado->save())
									{
										
									}
									}	
								}
								
							}
						}//Saldo no cubrio la deuda
						
						
					}//Saldo positivo
					else{
						
							$subject = 'Pago insuficiente';
							$body = '¡Upsss! El pago que realizaste no cubre el monto del pedido, faltan '.$orden->total-$detalle->monto.' Bs para pagar toda la orden.<br/><br/> ';
							$estado = new Estado;
																	
							$estado->estado = 7; // pago insuficiente
							$estado->user_id = Yii::app()->user->id;
							$estado->fecha = date("Y-m-d");
							$estado->orden_id = $orden->id;
							$estado->save();
							//if($estado->save())
							//{
								//$pag_bal->tbl_detalle_id=$det_bal->id;
								//$pag_bal->tipo=3;
								//$pag_det->save();
							//}
						
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
		/*	
		$id = $_GET['id'];	
		
		$orden = Orden::model()->findByPk($id);
		
		//if($orden->estado == 7){
		//	$detPago = new Detalle;
		//}
		//else {
		//	$detPago = Detalle::model()->findByPk($orden->detalle_id);
		//}
		
		$detPago = new Detalle;
		//echo $orden->getxPagar();
		//$nf = new NumberFormatter("es_VE", NumberFormatter::CURRENCY);
		//echo $nf->formatCurrency($orden->getxPagar(),'Bs.');
		//echo Yii::app()->format->unformatNumber('123,55');
		//echo Yii::app()->numberFormatter->formatCurrency($orden->getxPagar(),'Bs.');
		
		$datos="";
  		$datos=$datos."<div class='modal-header'>";
		$datos=$datos."<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>";
		$datos=$datos."<h4> Agregar Depósito o Transferencia bancaria ya realizada</h4>";
    	$datos=$datos."</div>";
  
  		$datos=$datos."<div class='modal-body'>";
  		$datos=$datos."<form class=''>";
		$datos=$datos."<input type='hidden'id='idOrden' value='".$orden->id."' />";
		
  		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<!--[if lte IE 9]>      <label class='control-label required'>Nombre del Depositante <span class='required'>*</span></label><![endif]-->";
    	$datos=$datos."<div class='controls'>";
      	$datos=$datos. CHtml::activeTextField($detPago,'nombre',array('id'=>'nombre','class'=>'span5','placeholder'=>'Nombre del Depositante')) ;
		$datos=$datos."<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<!--[if lte IE 9]>      <label class='control-label required'>Número o Código del Depósito <span class='required'>*</span></label><![endif]-->";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeTextField($detPago,'nTransferencia',array('id'=>'numeroTrans','class'=>'span5','placeholder'=>'Número o Código del Depósito')) ;
		$datos=$datos."<div style='display:none' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<!--[if lte IE 9]>      <label class='control-label required'>Banco<span class='required'>*</span></label><![endif]-->";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeDropDownList($detPago,'banco',array('Seleccione'=>'Seleccione','Banesco'=>'Banesco. Cuenta: 0134 0277 98 2771093092'),array('id'=>'banco','class'=>'span5')); 
		//$datos=$datos. CHtml::activeTextField($detPago,'banco',array('id'=>'banco','class'=>'span5','placeholder'=>'Banco donde se realizó el deposito'));
        $datos=$datos."<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<!--[if lte IE 9]>      <label class='control-label required'>Cedula<span class='required'>*</span></label><![endif]-->";
		$datos=$datos."<div class='controls'>";
		$datos=$datos. CHtml::activeTextField($detPago,'cedula',array('id'=>'cedula','class'=>'span5','placeholder'=>'Cedula del Depositante'));
        $datos=$datos."<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<!--[if lte IE 9]>      <label class='control-label required'>Monto (separar decimales con coma ',')<span class='required'>*</span></label><![endif]-->";
		
		$datos=$datos."<div class='controls'>";
		//$porpagar=Yii::app()->numberFormatter->formatDecimal($data->total-Detalle::model()->getSumxOrden($data->id));	
		
		
		$datos=$datos. CHtml::activeTextField($detPago,'monto',array('id'=>'monto','class'=>'span5',
                    	'placeholder'=>'Monto. Separe los decimales con una coma (,)',
                    	'value'=>Yii::app()->numberFormatter->formatDecimal($orden->getxPagar())
						)
					); 
                
		$datos=$datos. "<div style='display:none' id='RegistrationForm_email_em_' class='help-inline'></div>";
		$datos=$datos."</div>";
		$datos=$datos."</div>";
		
		$datos=$datos."<div class='controls controls-row'>";
		$datos=$datos."<!--[if lte IE 9]>      <label class='control-label required'>Fecha del depósito DD/MM/YYYY <span class='required'>*</span></label><![endif]-->";
		$datos=$datos. CHtml::TextField('dia','',array('id'=>'dia','class'=>'span1','placeholder'=>'Día'));
		$datos=$datos. CHtml::TextField('mes','',array('id'=>'mes','class'=>'span1','placeholder'=>'Mes')); 
		$datos=$datos. CHtml::TextField('ano','',array('id'=>'ano','class'=>'span2','placeholder'=>'Año')); 
      	$datos=$datos."</div>";
		
		$datos=$datos."<div class='control-group'>";
		$datos=$datos."<!--[if lte IE 9]>      <label class='control-label required'>Comentario <span class='required'>*</span></label><![endif]-->";
		
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
		
		
		//if($orden->estado == 7){
		//	$datos=$datos."<input type='hidden' id='idDetalle' value='0' />";
		//}
		//else {
		//	$datos=$datos."<input type='hidden' id='idDetalle' value='".$orden->detalle_id."' />";
		//}
		
		$datos=$datos."<input type='hidden' id='idDetalle' value='0' />";
		echo $datos;
		 * */
		echo $this->renderPartial('_modal_pago',array('orden_id'=>$id),true,false); 
		
	}

	public function actionCancelar($id)
	{   
            
            $orden = Orden::model()->findByPK($id);
		$end="";
		if($orden->estado==1)
		{
				$ban=true;
				$ohptcs=OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id));
				foreach($ohptcs as $ohptc){
					$ptc=Preciotallacolor::model()->findByPk($ohptc->preciotallacolor_id);
					$ptc->cantidad=$ptc->cantidad+$ohptc->cantidad;
						if($ptc->save())
							$ban=true;
						else{
							print_r($ptc->getErrors());
							break;
						}
						
				}
							
						
					
				$orden->estado = 5;	// se canceló la orden
					
					if($orden->save()&&$ban)
					{
						// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado						
						
						$estado = new Estado;
												
						$estado->estado = 5;
						$estado->user_id = Yii::app()->user->id; // quien cancelo la orden
						$estado->fecha = date("Y-m-d H:i:s");
						$estado->orden_id = $orden->id;
                                                
                                                //Si hay un motivo de cancelacion
                                                if(isset($_GET['mensaje']) && $_GET['mensaje'] != ""){
                                                    $estado->observacion = $_GET['mensaje'];
                                                }
                                                
								
						if($estado->save())
						{
							Yii::app()->user->setFlash('success', 'Se ha cancelado la orden.');
							$end='ok';
							
							
						}
					}	
		}
		else
		{
			Yii::app()->user->setFlash('error', "No es posible cancelar la orden dado que ya se ha registrado algún pago.");
			$end='no';
		}
		if(isset($_POST['admin']) || isset($_GET['admin'])){
			echo $end;
			return 0;
		}else
			$this->redirect(array('listado'));
	}

	
	/*
	 *  Action para añadir el tracking y cambiar el estado a enviado
	 * */

		public function actionEntregar()
	{
		$orden = Orden::model()->findByPK($_POST['id']);
		

		$orden->estado=8; // Entregado
		
		if($orden->save())
			{
				
				//agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
				$estado = new Estado;
										
				$estado->estado = 8;
				$estado->user_id = Yii::app()->user->id; // 
				$estado->fecha = date("Y-m-d");
				$estado->orden_id = $orden->id;
						
					if($estado->save())
				{
					Yii::app()->user->setFlash('success',"La Entrega fué Registrada");
					
					echo "ok";	
						
					
					/*	$user = User::model()->findByPk($orden->user_id);		
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
					
					
					Yii::app()->user->setFlash('success', 'Se ha enviado la orden.');
					
					echo "ok";
				}*/
					
			
			}
		else{
			
			Yii::app()->user->setFlash('success',"No se pudo registrar la Entrega");
		}	
		}
	}

	

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
						$body = "Nos complace informarte que tu pedido #".$orden->id." esta en camino y pronto podrás disfrutar de tu compra
								<br/>
								<br/>
								Puedes hacer seguimiento a tu pedido a través de la página de Zoom: http://www.grupozoom.com con el siguiente número de seguimiento: ".$orden->tracking." <br/> 
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
		if(isset($_POST['notificar']))
			$notificar = $_POST['notificar'];
		else 
			$notificar=0;
		if(isset($_POST['visible']))
			$visible = $_POST['visible'];
		else 
			$visible=1;
			
		$mensaje = new Mensaje;
		
		$mensaje->asunto = $_POST['asunto'];
		$mensaje->cuerpo = $_POST['cuerpo'];
		$mensaje->visible = $visible; // llega 0 o 1, 1 visible, 0 no
		$mensaje->user_id = $_POST['user_id'];
		$mensaje->orden_id = $_POST['orden_id']; 
		if(isset($_POST['admin'])){
			$mensaje->admin=1;
			
		}
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
                if(isnull($mensaje->admin))
                	$message->addTo($usuario->email);
                $message->from = array('info@personaling.com' => 'Tu Personal Shopper Digital');
                Yii::app()->mail->send($message);	
			}		
			
			Yii::app()->user->setFlash('success', 'Se ha enviado el mensaje correctamente.');
			echo "ok";	
		}	
		
	}

	
	
	public function actionGetprendas($ord){
		$ordhasptc= OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$ord));
		$productos=Array();
		foreach($ordhasptc as $ohptc){
			$ptc= PrecioTallaColor::model()->findByPk($ohptc->preciotallacolor_id);	
			$pr=Producto::model()->findByPk($ptc->producto_id);
			array_push($productos,$pr->id);			
		}
		print_r($productos);				
	}


    public function actionCalcularenvio(){
    	
		if(isset($_POST['orden']) && isset($_POST['check']))
		{
			$orden = Orden::model()->findByPk($_POST['orden']);
			
			$checks = explode(',',$_POST['check']); // checks va a tener los id de preciotallacolor
			$cont = 0; 
			
			$totalenvio = 0;
			
			foreach($checks as $uno)
			{
				$orden = Orden::model()->findByPk($_POST['orden']);
				$ptcolor = Preciotallacolor::model()->findByAttributes(array('sku'=>$uno)); 
				
				if($_POST['motivos'][$cont] == "Devolución por prenda dañada" || $_POST['motivos'][$cont] == "Devolución por pedido equivocado")
				{
					// calculo envio
					
					$producto = Producto::model()->findByPk($ptcolor->producto_id);
					$peso_total = $producto->peso; 
					
					if($peso_total <= 0.5){
						$envio = 80.08;
					}else if($peso_total < 5){
						$peso_adicional = ceil($peso_total-0.5);
						$direccion = DireccionEnvio::model()->findByPk($orden->direccionEnvio_id);
						$ciudad_destino = Ciudad::model()->findByPk($direccion->ciudad_id);
						$envio = 80.08 + ($peso_adicional*$ciudad_destino->ruta->precio);
										
							if($envio > 163.52){
								$envio = 163.52;
							}
							
						$tipo_guia = 1;
					}else{
							$peso_adicional = ceil($peso_total-5);
							$direccion = DireccionEnvio::model()->findByPk($orden->direccionEnvio_id);
							$ciudad_destino = Ciudad::model()->findByPk($direccion->ciudad_id);
							$envio = 163.52 + ($peso_adicional*$ciudad_destino->ruta->precio);
							
						if($envio > 327.04){
							$envio = 327.04;
						}
							
						$tipo_guia = 2;
					}
					
					$totalenvio += $envio;
					
				} // if motivos

				$cont++;
			} // foreach
			
		echo $totalenvio;						

		}	

	}

	public function actionCreateExcel(){
		
		Yii::import('ext.phpexcel.XPHPExcel');    
	
		$objPHPExcel = XPHPExcel::createPHPExcel();
	
		$objPHPExcel->getProperties()->setCreator("Personaling.com")
		                         ->setLastModifiedBy("Personaling.com")
		                         ->setTitle("plantilla-masiva-prepagada")
		                         ->setSubject("Plantilla masiva prepagada")
		                         ->setDescription("Plantilla masiva prepagada creada a través de la aplicación.")
		                         ->setKeywords("personaling")
		                         ->setCategory("personaling");
/*
			// Add some data
			$objPHPExcel->setActiveSheetIndex(0)
			            ->setCellValue('A1', 'Hello')
			            ->setCellValue('B2', 'world!')
			            ->setCellValue('C1', 'Hello')
			            ->setCellValue('D2', 'world!');
*/
			// creando el encabezado
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A1', 'REMITENTE')
						->setCellValue('A2', 'Persona Contacto')
						->setCellValue('B2', 'Teléfono')
						->setCellValue('C2', 'Dirección')
						->setCellValue('D1', 'DESTINATARIO')
						->setCellValue('D2', 'Ciudad Destino')
						->setCellValue('E2', 'Destinatarios')
						->setCellValue('F2', 'Persona Contacto')
						->setCellValue('G2', 'R.I.F/C.I')
						->setCellValue('H2', 'Teléfono')
						->setCellValue('I2', 'Dirección')
						->setCellValue('J1', 'DATOS DEL ENVIO')
						->setCellValue('J2', 'Referencia')
						->setCellValue('K2', 'Pzas')
						->setCellValue('L2', 'Peso Ref (Kg) ')
						->setCellValue('M2', 'Tipo de Envio')
						->setCellValue('N2', 'Descripción de Contenido')
						->setCellValue('O2', 'Valor Declarado (Bs)')
						->setCellValue('Q1', 'Nota:')
						->setCellValue('Q2', 'En Tipo de Envio solo debe escribir D ó M')
						->setCellValue('S1', 'D = Documento')
						->setCellValue('S2', 'M = Mercancia');	
			// encabezado end			
		 
		 	$ordenes = Orden::model()->findAllByAttributes(array('estado'=>3)); // pago confirmado
		 	$fila = 3;
			
		 	// el remitente siempre será el mismo por tanto		 	
		 	foreach($ordenes as $orden)
			{
				if($orden->peso < 5){
					$dir = DireccionEnvio::model()->findByPk($orden->direccionEnvio_id);
					$prov = Provincia::model()->findByPk($dir->provincia_id);
					$usuario = User::model()->findByPk($orden->user_id);
					/*
					$peso = 0;
					$orden_ptc = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id));
					
					foreach($orden_ptc as $uno)
					{
						if($uno->look_id != 0){ // eslook
									
						}
						else{
							$ptaco = Preciotallacolor::model()->findByPk($uno->preciotallacolor_id);
							$producto = Producto::model()->findByPk($ptaco->producto_id);
						
							$peso += $producto->peso;
						}
					}*/
				
					$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$fila , 'PERSONALING, C.A.') // Persona Contacto
							->setCellValue('B'.$fila , '04144239902') // Teléfono
							->setCellValue('C'.$fila , 'AV BOLIVAR C.C. CM, PISO 2 OFICINA 210. MUNICIPIO MARIÑO, PORLAMAR, NUEVA ESPARTA. 6301') // Direccion
							->setCellValue('D'.$fila , $prov->nombre) // ciudad destino
							->setCellValue('E'.$fila , $usuario->profile->first_name." ".$usuario->profile->first_name) // destinatario
							->setCellValue('F'.$fila , $usuario->profile->first_name." ".$usuario->profile->first_name) // persona contacto
							->setCellValue('G'.$fila , $usuario->profile->cedula) // cedula
							->setCellValue('H'.$fila , $usuario->profile->tlf_celular) // telefono
							->setCellValue('I'.$fila , $dir->dirUno.", ".$dir->dirDos) // Direccion
							->setCellValue('J'.$fila , $orden->id) // referencia
							->setCellValue('K'.$fila , '1') // Piezas
							->setCellValue('L'.$fila , $orden->peso) // Peso ref
							->setCellValue('M'.$fila , 'M') // tipo de envio
							->setCellValue('N'.$fila , 'Ropa') // Descripcion
							->setCellValue('O'.$fila , ($orden->total - $orden->envio)); // valor declarado
					$fila++;
						
				}// orden
			} // foreach
		 
			// Rename worksheet
		//	$objPHPExcel->getActiveSheet()->setTitle('plantillamasivaprepagada');
			 
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);

			// Redirect output to a clientâ€™s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="plantillamasivaprepagada.xls"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
		 
			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
		 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			      Yii::app()->end();
				  
	}

	// importar desde excel
	public function actionImportarMasivo()
	{

		$tabla = "";		
		
		if( isset($_POST['valido']) ){ // enviaron un archivo
			
		$archivo = CUploadedFile::getInstancesByName('url');
			
			if(isset($archivo) && count($archivo) > 0){

				foreach ($archivo as $arc => $xls) {
					
	            	$nombre = Yii::getPathOfAlias('webroot').'/docs/xlsImported/'. date('d-m-Y-H:i:s', strtotime('now')) ;
	            	$extension = '.'.$xls->extensionName;
				//	$model->banner_url = '/images/banner/'. $id .'/'. $image .$extension;
				 
			//	 if (!$model->save())	
			//			Yii::trace('username:'.$model->username.' Crear Banner Error:'.print_r($model->getErrors(),true), 'registro');										
					
		            if($xls->saveAs($nombre . $extension)){
			                Yii::app()->user->updateSession();
							Yii::app()->user->setFlash('success',UserModule::t("El archivo ha sido cargado y procesado exitosamente."));			            										            	
	            	}
					else{
						Yii::app()->user->updateSession();
						Yii::app()->user->setFlash('error',UserModule::t("Error al cargar el archivo."));	
					}	            	
				}

			}
			
			// ==============================================================================
			
			$sheet_array = Yii::app()->yexcel->readActiveSheet($nombre . $extension);
 /*
			$tabla = $tabla . "<table class='table table-bordered table-hover table-striped'>";
			 
			foreach( $sheet_array as $row ) {
			    $tabla = $tabla . "<tr>";
			    
			    foreach( $row as $column )
			        $tabla = $tabla . "<td>$column</td>"; 
				
			    $tabla = $tabla . "</tr>";
			} 
			 
			$tabla = $tabla . "</table>"; */
			$tabla = $tabla ."<br/>";
		 	
			
			foreach( $sheet_array as $row ) {
				
				if($row['A']=="VENTA DE ENVIOS DE TAQUILLA" || $row['A']=="Fecha" || $row['A']==""){
					// do nothing
				}else
				{/*
					$tabla = $tabla.'fecha: '.$row['A'].
									' servicio: '.$row['B'].
									' guia: '.$row['C'].
									' referencia: '.$row['D'].
									' remitente: '.$row['E'].
									' destinatario: '.$row['F'].
									' destino: '.$row['G'].
									' peso: '.$row['H'].
									' Estatus: '.$row['I'].
									' Flete origen: '.$row['J'].
									' flete destino: '.$row['K'].
									' proteccion mercancia: '.$row['L'].
									' iva: '.$row['M'].
									' frac: '.$row['N'].
									' valor mercancia: '.$row['O'].
									' total a pagar: '.$row['P'].
					 				' usuario: '.$row['Q'].
									'<br/>';*/
									
					$status = strtolower($row['I']);
					
					if($status == "guia recibida por zoom") // se debe cambiar el estado de la orden
					{
						$orden = Orden::model()->findByPk($row['D']);
						
						if($orden->estado == 3) // pago confirmado
						{
							$orden->estado = 4; // enviado
							$orden->tracking = $row['C']; // guia
							$orden->save();
						
							$tabla .= "La orden #".$row['D']." cambió a estado Enviado. Numero de Guia: ".$row['C']." </br>"; 
						}
						
					}				
					
				}		
					
			}

			
			
		}// isset 
		
		$this->render('importar_masivo',array(
			'tabla'=>$tabla,
		));
		
	} // action


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
