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
				'actions'=>array('index','agregar'),
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
				
			$pn = new BolsaHasProductotallacolor;
			$pn->bolsa_id = $carrito->id;
			$pn->preciotallacolor_id = $ptcolor->id;
			$pn->cantidad = 1;
				
			if($pn->save())
			{// en bolsa tengo id de usuario e id de bolsa
			
				echo "ok";
			
			//	$this->render('bolsa', array('preciotallacolor' => $ptcolor, 'bolsa'=>$carrito));
			}
				
		}//else bolsa		
	}// isset usuario
	else
	{
	echo "no es usuario";	
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