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
				'actions'=>array('index','agregar','actualizar','pagos','compra','eliminar','direcciones','confirmar','comprar'),
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
					
				if($pn->save())
				{// en bolsa tengo id de usuario e id de bolsa
				
					echo "ok";
				
				//	$this->render('bolsa', array('preciotallacolor' => $ptcolor, 'bolsa'=>$carrito));
				}
					
			}
				
			
				
		}//else bolsa		
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
		
		$bolsa = BolsaHasProductotallacolor::model()->findByAttributes(array('preciotallacolor_id'=>$_POST['prtc']));
		
		$bolsa->cantidad = $_POST['cantidad'];
		
		if($bolsa->save())
		{
			echo "ok";
		}
		
		
	}
	
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
		$this->render('compra');
		
	}
		
}