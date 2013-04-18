<?php

class BolsaController extends Controller
{

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
				'actions'=>array('index','agregar','actualizar','pagos','compra','eliminar','direcciones','confirmar','comprar','cpago'),
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
				
				$this->render('confirmar',array('idDireccion'=>$idDireccion,'tipoPago'=>$tipoPago));
				//$this->redirect(array('bolsa/confirmar','idDireccion'=>$idDireccion, 'tipoPago'=>$tipoPago)); 
				// se le pasan los datos al action confirmar	
			}else if(isset($_GET['id'])){ // de direcciones
				$this->render('pago',array('id_direccion'=>$_GET['id']));
			}
			
		
		}
		
		public function actionConfirmar()
		{
			// viene de pagos
				$this->render('confirmar');						
		}
		
		public function actionDirecciones()
		{
			$dir = new Direccion;
			
			if(isset($_POST['Direccion'])) // nuevo registro
			{
				
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
			
			if($_POST['tipoPago']==1){ // transferencia
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
					$dirEnvio->ciudad = $dir1->ciudad;
					$dirEnvio->estado = $dir1->estado;
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
							$orden->estado = 1; // en espera de pago (?)
							$orden->bolsa_id = $bolsa->id; 
							$orden->user_id = $usuario;
							$orden->pago_id = $pago->id;
							$orden->detalle_id = $detalle->id;
							$orden->direccionEnvio_id = $dirEnvio->id;	
							
							if($orden->save()){
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
								
							// cuando finalice entonces envia id de la orden para redireccionar
							echo CJSON::encode(array(
								'status'=> 'ok',
								'orden'=> $orden->id
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
		
		$this->render('pedido',array('orden'=>$orden));
	}

	/*
	 * 
	 * */
	public function actionCpago()
	{
		if (Yii::app()->request->isPostRequest) // asegurar que viene en post
		{
			$detPago = Detalle::model()->findByPk($_POST['idDetalle']);
			
			$detPago->nombre = $_POST['nombre'];
			$detPago->nTransferencia = $_POST['numeroTrans'];
			$detPago->comentario = $_POST['comentario'];
			
			$detPago->fecha = $_POST['ano']."/".$_POST['mes']."/".$_POST['dia'];
			
			if($detPago->save())
			{
				$orden = Orden::model()->findByAttributes(array('detalle_id'=>$_POST['idDetalle']));
				$orden->estado = 2;	// se recibió los datos de pago por transferencia			 
				
				if($orden->save())
				{
					echo "ok";
				}				
			}
			
		}
		
		
	}
		
}