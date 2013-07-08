<?php

class BolsaController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','limpiar','eliminardireccion','editar','editardireccion','agregar','actualizar','pagos','compra','eliminar','direcciones','confirmar','comprar','cpago','cambiarTipoPago','successMP'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex()
	{
		$usuario = Yii::app()->user->id;
		$bolsa = Bolsa::model()->findByAttributes(array('user_id'=>$usuario));
		
		$this->render('bolsa', array('bolsa' => $bolsa));
	}


	public function actionAgregar(){
		//si no tiene una bolsa aun asociada se crea
		
		
	if(Yii::app()->user->isGuest==false) 
	{
		
		$usuario = Yii::app()->user->id;
		$bolsa = Bolsa::model()->findByAttributes(array('user_id'=>$usuario));
		
		if(!isset($bolsa)) // si no tiene aun un carrito asociado se crea y se añade el producto
		{
			$bolsa = new Bolsa;
			$bolsa->user_id = $usuario;
			$bolsa->created_on = date("Y-m-d H:i:s");
			$bolsa->save();
		}
		if (isset($_POST['look_id'])){
			foreach($_POST['producto'] as $key => $value){
				list($producto_id,$color_id) = split("_",$value);
				echo $bolsa->addProducto($producto_id,$_POST['talla'.$value],$color_id,$_POST['look_id']);
			}
		} else {
			echo $bolsa->addProducto($_POST['producto'],$_POST['talla'],$_POST['color']);
		}
		 /*	
		$usuario = Yii::app()->user->id;
		$bolsa = Bolsa::model()->findByAttributes(array('user_id'=>$usuario));
		
		if(!isset($bolsa)) // si no tiene aun un carrito asociado se crea y se añade el producto
		{
			$model = new Bolsa;
			$model->user_id = $usuario;
			$model->created_on = date("Y-m-d H:i:s");
			
			if($model->save()) // si guarda entonces se añade el nuevo producto
			{
				$carrito = Bolsa::model()->findByAttributes(array('user_id'=>$usuario));
				$ptcolor = PrecioTallaColor::model()->findByAttributes(array('producto_id'=>$_POST['producto'],'talla_id'=>$_POST['talla'],'color_id'=>$_POST['color']));
				
				$pn = new BolsaHasProductotallacolor;
				$pn->bolsa_id = $carrito->id;
				$pn->preciotallacolor_id = $ptcolor->id;
				$pn->cantidad = 1;
				if (isset($_POST['look']))
					$pn->look_id = $_POST['look'];
				if($pn->save())
				{// en bolsa tengo id de usuario e id de bolsa
					//$this->render('bolsa', array('preciotallacolor' => $ptcolor, 'bolsa'=>$carrito));
					echo "ok";
				}
			}
		}
		else // si ya tiene una bolsa
		{
			$carrito = Bolsa::model()->findByAttributes(array('user_id'=>$usuario));
			$ptcolor = PrecioTallaColor::model()->findByAttributes(array('producto_id'=>$_POST['producto'],'talla_id'=>$_POST['talla'],'color_id'=>$_POST['color']));
			
			//revisar si está o no en el carrito
			
			$nuevo = BolsaHasProductotallacolor::model()->findByAttributes(array('preciotallacolor_id'=>$ptcolor->id));
			
			if(isset($nuevo)) // existe
			{
				$cantidadnueva = $nuevo->cantidad + 1;
				BolsaHasProductotallacolor::model()->updateByPk($nuevo->preciotallacolor_id, array('cantidad'=>$cantidadnueva));
				echo "ok";
							
			}
			else{ // si el producto es nuevo en la bolsa
			
				$pn = new BolsaHasProductotallacolor;
				$pn->bolsa_id = $carrito->id;
				$pn->preciotallacolor_id = $ptcolor->id;
				$pn->cantidad = 1;
				if (isset($_POST['look']))
					$pn->look_id = $_POST['look'];	
				if($pn->save())
				{// en bolsa tengo id de usuario e id de bolsa
				
					echo "ok";
				
				//	$this->render('bolsa', array('preciotallacolor' => $ptcolor, 'bolsa'=>$carrito));
				}
					
			}
				
			
				
		}//else bolsa	
		 * */	
	}// isset usuario
		
	else
	{
	echo "no es usuario";	
	}

}
/*
 * action para actualizar las cantidades del producto en el carrito
 * 
 * */
	public function actionActualizar(){
			
		if($_POST['cantidad']==0)
		{
			$bolsa = BolsaHasProductotallacolor::model()->findByAttributes(array('preciotallacolor_id'=>$_POST['prtc']));
			$bolsa->delete();
			
			echo "ok";
			
		}
		else if($_POST['cantidad']>0){
		
			$bolsa = BolsaHasProductotallacolor::model()->findByAttributes(array('preciotallacolor_id'=>$_POST['prtc']));
			
			$pr = PrecioTallaColor::model()->findByPk($_POST['prtc']);
			
			$mientras = $pr->cantidad;
			if(($mientras - $_POST['cantidad']) < 0){
				echo "NO";
			}
			else
			{
				$bolsa->cantidad = $_POST['cantidad'];
				
				if($bolsa->save())
				{
					echo "ok";
				}
			}

		}// mayor que 0
		
	} // actualizar
	
	/*
	 * 
	 * action para eliminar desde la bolsa
	 * 
	 * */
    public function actionEliminar() {
        if (Yii::app()->request->isPostRequest) {
			$model= BolsaHasProductotallacolor::model()->findByAttributes(array('preciotallacolor_id'=>$_POST['prtc']));
			           
            if ($model) {
                $model->delete();
            	echo "ok";
			}   
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
	/*
	 * 
	 * para validar los datos del usuario 
	 * 
	 */
	
		public function actionPagos()
		{
			
			if(isset($_POST['idDireccion'])) // escogiendo cual es la preferencia de pago
			{ 
				$idDireccion = $_POST['idDireccion'];
				$tipoPago = $_POST['tipoPago'];
				echo "if";
				$this->render('confirmar',array('idDireccion'=>$idDireccion,'tipoPago'=>$tipoPago));
				//$this->redirect(array('bolsa/confirmar','idDireccion'=>$idDireccion, 'tipoPago'=>$tipoPago)); 
				// se le pasan los datos al action confirmar	
			}else if(isset($_GET['id'])){ // de direcciones
			echo "else";
				$this->render('pago',array('id_direccion'=>$_GET['id']));
			}
			
		
		}
		
		public function actionSuccessMP(){
			echo 'Tipo: '.Yii::app()->getSession()->get('tipoPago').'';
			$usuario = Yii::app()->user->id; 
			$bolsa = Bolsa::model()->findByAttributes(array('user_id'=>$usuario));
			
			if(Yii::app()->getSession()->get('tipoPago')==1 || Yii::app()->getSession()->get('tipoPago')==4){ // transferencia o MP
				$detalle = new Detalle;
			
				if($detalle->save())
				{
					$pago = new Pago;
					$pago->tipo = Yii::app()->getSession()->get('tipoPago'); // trans
					$pago->tbl_detalle_id = $detalle->id;
					
					if($pago->save()){
					
					// clonando la direccion
					$dir1 = Direccion::model()->findByAttributes(array('id'=>Yii::app()->getSession()->get('idDireccion'),'user_id'=>$usuario));
					$dirEnvio = new DireccionEnvio;
					
					$dirEnvio->nombre = $dir1->nombre;
					$dirEnvio->apellido = $dir1->apellido;
					$dirEnvio->cedula = $dir1->cedula;
					$dirEnvio->dirUno = $dir1->dirUno;
					$dirEnvio->dirDos = $dir1->dirDos;
					$dirEnvio->telefono = $dir1->telefono;
					$dirEnvio->ciudad = $dir1->ciudad;
					$dirEnvio->estado = $dir1->estado;
					$dirEnvio->pais = $dir1->pais;
					
					if(isset($_GET['collection_id']) && Yii::app()->getSession()->get('tipoPago') == 4){ // Pago con Mercadopago
						$detalle->nTransferencia = $_GET['collection_id'];
						$detalle->nombre = $dirEnvio->nombre.' '.$dirEnvio->apellido;
						$detalle->cedula = $dirEnvio->cedula;
						$detalle->monto = Yii::app()->getSession()->get('total');
						$detalle->fecha = date("Y-m-d H:i:s");
						$detalle->banco = 'Mercadopago';
						
						$detalle->estado = 0;
						
						$detalle->save();
					}

						if($dirEnvio->save()){
							// ya esta todo para realizar la orden
							
							$orden = new Orden;
							
							$orden->subtotal = Yii::app()->getSession()->get('subtotal');
							$orden->descuento = Yii::app()->getSession()->get('descuento');
							$orden->envio = Yii::app()->getSession()->get('envio');
							$orden->iva = Yii::app()->getSession()->get('iva');
							$orden->descuentoRegalo = 0;
							$orden->total = Yii::app()->getSession()->get('total');
							$orden->fecha = date("Y-m-d H:i:s"); // Datetime exacto del momento de la compra 
							$orden->estado = 1; // en espera de pago
							$orden->bolsa_id = $bolsa->id; 
							$orden->user_id = $usuario;
							$orden->pago_id = $pago->id;
							$orden->detalle_id = $detalle->id;
							$orden->direccionEnvio_id = $dirEnvio->id;	
							
							if($orden->save()){
								$productosBolsa = BolsaHasProductotallacolor::model()->findAllByAttributes(array('bolsa_id'=>$bolsa->id));	
								$detalle->orden_id = $orden->id;
								$detalle->save();
								// añadiendo a orden producto
								foreach($productosBolsa as $prod)
								{
									$prorden = new OrdenHasProductotallacolor;
									$prorden->tbl_orden_id = $orden->id;
									$prorden->preciotallacolor_id = $prod->preciotallacolor_id;
									$prorden->cantidad = $prod->cantidad;
									$prorden->look_id = $prod->look_id;
									
									if($prorden->save()){
										//listo y que repita el proceso
									}
								}
								
								//descontando del inventario
								foreach($productosBolsa as $prod)
								{
									$uno = PrecioTallaColor::model()->findByPk($prod->preciotallacolor_id);
									$cantidadNueva = $uno->cantidad - $prod->cantidad; // lo que hay menos lo que se compró
									
									PrecioTallaColor::model()->updateByPk($prod->preciotallacolor_id, array('cantidad'=>$cantidadNueva));
									// descuenta y se repite									
								}
								
								
								// para borrar los productos de la bolsa								
								foreach($productosBolsa as $prod)
								{
									$prod->delete();															
								}
								
								// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
								$estado = new Estado;
									
								$estado->estado = 1;
								$estado->user_id = $usuario;
								$estado->fecha = date("Y-m-d");
								$estado->orden_id = $orden->id;
								
								if($estado->save())
									echo "";
								
								// Generar factura
								$factura = new Factura;
								$factura->fecha = date('Y-m-d');
								$factura->direccion_fiscal_id = Yii::app()->getSession()->get('idDireccion');  // esta direccion hay que cambiarla después, el usuario debe seleccionar esta dirección durante el proceso de compra
								$factura->direccion_envio_id = Yii::app()->getSession()->get('idDireccion');
								$factura->orden_id = $orden->id;
								$factura->save();
								
								// Enviar correo con resumen de la compra
								$user = User::model()->findByPk($usuario);
								$message            = new YiiMailMessage;
						           //this points to the file test.php inside the view path
						        $message->view = "mail_compra";
								$subject = 'Tu compra en Pesonaling';
						        $params              = array('subject'=>$subject, 'orden'=>$orden);
						        $message->subject    = $subject;
						        $message->setBody($params, 'text/html');
						        $message->addTo($user->email);
								$message->from = array('ventas@personaling.com' => 'Tu Personal Shopper Digital');
						        //$message->from = 'Tu Personal Shopper Digital <ventas@personaling.com>\r\n';   
						        Yii::app()->mail->send($message);
								
							// cuando finalice entonces envia id de la orden para redireccionar
							$this->redirect(array('bolsa/pedido/'.$orden->id));
							
							
							
							}//orden
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
		
		public function actionCambiarTipoPago()
		{
			
			if(isset($_POST['tipoPago'])) // escogiendo cual es la preferencia de pago
			{
				//Yii::app()->getSession()->remove('tipoPago'); 
				//Yii::app()->getSession()->add('tipoPago',1) = $_POST['tipoPago'];
			}
		}
		
		public function actionConfirmar()
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
				$this->render('confirmar');
			}
		}
		
		public function actionEliminardireccion()
		{
			if(isset($_POST['idDir']))
			{
				$direccion = Direccion::model()->findByPk($_POST['idDir']);
				$direccion->delete();
				
				echo "ok";
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
				$dirEdit->ciudad = $_POST['Direccion']['ciudad'];
				$dirEdit->estado = $_POST['Direccion']['estado'];
				
				if($_POST['Direccion']['pais']==1)
					$dirEdit->pais = "Venezuela";
				
				if($_POST['Direccion']['pais']==2)
					$dirEdit->pais = "Colombia";
				
				if($_POST['Direccion']['pais']==3)
					$dirEdit->pais = "Estados Unidos";
				
				if($dirEdit->save()){
					$dir = new Direccion;
					$this->redirect(array('bolsa/direcciones')); // redir to action
					//$this->render('direcciones',array('dir'=>$dir));
					}
				
			}
			else if($_GET['id']){ // piden editarlo
				$direccion = Direccion::model()->findByAttributes(array('id'=>$_GET['id'],'user_id'=>Yii::app()->user->id));
				$this->render('editarDir',array('dir'=>$direccion));
			}
			
			
		}
		
		public function actionDirecciones()
		{
			$dir = new Direccion;
			
			if(isset($_POST['tipo']) && $_POST['tipo']=='direccionVieja')
			{
				//echo "Id:".$_POST['Direccion']['id'];
				$dirEnvio = $_POST['Direccion']['id'];
				
				$this->render('pago',array('idDireccion'=>$dirEnvio));
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
						$this->render('pago',array('idDireccion'=>$dir->id));
						//$this->redirect(array('bolsa/pagos','id'=>$dir->id)); // redir to action Pagos
					}
					
				//} // nombre
			//	else {
					//$this->render('direcciones',array('dir'=>$dir)); // regresa
				//}
				
			}else // si está viniendo de la pagina anterior que muestre todo 
			{
				$this->render('direcciones',array('dir'=>$dir));
			}
			

		}
	
		/**
	 * Displays the login page
	 */
	public function actionCompra()
	{
		if (!Yii::app()->user->isGuest) { // que esté logueado para llegar a esta acción
			
			$model=new UserLogin;
			
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				
				if($model->validate()) {
					$user = User::model()->notsafe()->findByPk(Yii::app()->user->id);
					$this->redirect(array('bolsa/direcciones'));
				}else{
					$this->render('login',array('model'=>$model));
					Yii::app()->user->setFlash('error',UserModule::t("La contraseña es incorrecta.")); 
				}	
			}else{
				// si no viene del formulario. O bien viene de la pagina anterior
				$this->render('login',array('model'=>$model));
			}
		} else{
			// no va a llegar nadie que no esté logueado
		}
	}//fin

	/*
	 * 
	 * */
	public function actionComprar()
	{
		 if (Yii::app()->request->isPostRequest) // asegurar que viene en post
		 {
		 	$usuario = Yii::app()->user->id; 
			$bolsa = Bolsa::model()->findByAttributes(array('user_id'=>$usuario));
			
			if($_POST['tipoPago']==1 || $_POST['tipoPago']==4){ // transferencia o MP
				$detalle = new Detalle;
			
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
					$dirEnvio->ciudad = $dir1->ciudad;
					$dirEnvio->estado = $dir1->estado;
					$dirEnvio->pais = $dir1->pais;
					
					if(isset($_POST['id_transaccion']) && $_POST['tipoPago'] == 4){ // Pago con Mercadopago
						$detalle->nTransferencia = $_POST['id_transaccion'];
						$detalle->nombre = $dirEnvio->nombre.' '.$dirEnvio->apellido;
						$detalle->cedula = $dirEnvio->cedula;
						$detalle->monto = $_POST['total'];
						$detalle->fecha = date("Y-m-d H:i:s");
						$detalle->banco = 'Mecadopago';
						
						$detalle->estado = 0;
						
						$detalle->save();
					}

						if($dirEnvio->save()){
							// ya esta todo para realizar la orden
							
							$orden = new Orden;
							
							$orden->subtotal = $_POST['subtotal'];
							$orden->descuento = $_POST['descuento'];
							$orden->envio = $_POST['envio'];
							$orden->iva = $_POST['iva'];
							$orden->descuentoRegalo = 0;
							$orden->total = $_POST['total'];
							$orden->fecha = date("Y-m-d H:i:s"); // Datetime exacto del momento de la compra 
							$orden->estado = 1; // en espera de pago
							$orden->bolsa_id = $bolsa->id; 
							$orden->user_id = $usuario;
							$orden->pago_id = $pago->id;
							$orden->detalle_id = $detalle->id;
							$orden->direccionEnvio_id = $dirEnvio->id;	
							
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
								
								$productosBolsa = BolsaHasProductotallacolor::model()->findAllByAttributes(array('bolsa_id'=>$bolsa->id));	
								
								// añadiendo a orden producto
								foreach($productosBolsa as $prod)
								{
									$prorden = new OrdenHasProductotallacolor;
									$prorden->tbl_orden_id = $orden->id;
									$prorden->preciotallacolor_id = $prod->preciotallacolor_id;
									$prorden->cantidad = $prod->cantidad;
									$prorden->look_id = $prod->look_id;
									
									if($prorden->save()){
										//listo y que repita el proceso
									}
								}
								
								//descontando del inventario
								foreach($productosBolsa as $prod)
								{
									$uno = PrecioTallaColor::model()->findByPk($prod->preciotallacolor_id);
									$cantidadNueva = $uno->cantidad - $prod->cantidad; // lo que hay menos lo que se compró
									
									PrecioTallaColor::model()->updateByPk($prod->preciotallacolor_id, array('cantidad'=>$cantidadNueva));
									// descuenta y se repite									
								}
								
								
								// para borrar los productos de la bolsa								
								foreach($productosBolsa as $prod)
								{
									$prod->delete();															
								}
								
								// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
								$estado = new Estado;
									
								$estado->estado = 1;
								$estado->user_id = $usuario;
								$estado->fecha = date("Y-m-d");
								$estado->orden_id = $orden->id;
								
								if($estado->save())
									echo "";
								
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
								$subject = 'Tu compra en Pesonaling';
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
								'descuento'=>$orden->descuento
							));
							
							
							}//orden
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

	/*
	 * 
	 * */
	public function actionPedido($id)
	{
		$orden = Orden::model()->findByPk($id);
		//$pago = Pago::model()->findByPk($orden->pago_id);
		$this->render('pedido',array('orden'=>$orden));
	}

	/*
	 * 
	 * */
	public function actionCpago()
	{
		if (Yii::app()->request->isPostRequest) // asegurar que viene en post
		{
			$usuario = Yii::app()->user->id; 
			
			if($_POST['idDetalle'] != 0)
				$detPago = Detalle::model()->findByPk($_POST['idDetalle']);
			else
				$detPago = new Detalle;
				
			$detPago->nombre = $_POST['nombre'];
			$detPago->nTransferencia = $_POST['numeroTrans'];
			$detPago->comentario = $_POST['comentario'];
			$detPago->banco = $_POST['banco'];
			$detPago->monto = $_POST['monto'];
			$detPago->cedula = $_POST['cedula'];
			$detPago->estado = 0; // defecto
			$detPago->orden_id = $_POST['idOrden'];
							
			$detPago->fecha = $_POST['ano']."/".$_POST['mes']."/".$_POST['dia'];
			
			if($detPago->save())
			{
				
				if($_POST['idDetalle'] != 0)
					$orden = Orden::model()->findByAttributes(array('detalle_id'=>$_POST['idDetalle']));
				else
				{
					$orden = Orden::model()->findByAttributes(array('id'=>$_POST['idOrden']));
				}
					
				$orden->estado = 2;	// se recibió los datos de pago por transferencia
				
				if($orden->save())
				{
					// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
					$estado = new Estado;
									
					$estado->estado = 2;
					$estado->user_id = $usuario;
					$estado->fecha = date("Y-m-d");
					$estado->orden_id = $orden->id;
					
					if($estado->save())
					{
						Yii::app()->user->setFlash('success', 'Hemos recibido tu pago y está en espera de confirmación');
						echo "ok";	
					}	
					
				}				
			}
			else {
				echo "no";
			}
			
		}
		
		
	}

	/*
	 * 
	 * */
	public function actionLimpiar()
	{
		
		if(isset($_POST['idBolsa'])){	
		
			$bolsahas = BolsaHasProductotallacolor::model()->findAllByAttributes(array('bolsa_id'=>$_POST['idBolsa']));
			
			foreach($bolsahas as $uno){
				$uno->delete();
			}
			
			echo "ok";
		
		}
	}

		
}