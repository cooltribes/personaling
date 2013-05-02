<?php

class OrdenController extends Controller
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
				'actions'=>array(''),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','admin','detalles','validar'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
			
			$orden = Orden::model()->findByAttributes(array('detalle_id'=>$detalle->id));
	
			if($detalle->save()){
				/*
				 * Revisando si lo depositado es > o = al total de la orden. 
				 * */
				if($detalle->monto >= $orden->total){
					$orden->estado = 3;
					
					if($orden->save()){
						$usuario = Yii::app()->user->id; 
						
						// agregar cual fue el usuario que realizó la compra para tenerlo en la tabla estado
						$estado = new Estado;
											
						$estado->estado = 3; // pago recibido
						$estado->user_id = $usuario;
						$estado->fecha = date("Y-m-d");
						$estado->orden_id = $orden->id;
							
						if($estado->save())
						{
							echo "ok";	
						}
						
					}//orden save
				}// si es mayor
			
			}// detalle
					
		}
		else if($_POST['accion']=="rechazar")
		{
			$detalle = Detalle::model()->findByPk($_POST['id']);
			$detalle->estado = 2; // rechazado
			
			$orden = Orden::model()->findByAttributes(array('detalle_id'=>$detalle->id));
			$orden->estado = 1; // regresa a "En espera de pago"
			
			if($detalle->save())
				if($orden->save())
					echo "ok"; 
		
			$detalle->estado = 1;
		
			if($detalle->save())
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