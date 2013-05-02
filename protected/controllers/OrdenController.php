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
		
			$detalle->estado = 1;
		
			if($detalle->save())
				echo "ok";
			
			//faltaria cambiar el estado del pedido
		}
		else if($_POST['accion']=="rechazar")
		{
			$detalle = Detalle::model()->findByPk($_POST['id']);
		
			$detalle->estado = 2; // rechazado
		
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