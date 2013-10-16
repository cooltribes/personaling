<?php

class ControlpanelController extends Controller
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
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','delete','ventas','pedidos','usuarios', 'looks', 'productos'),
				//'users'=>array('admin'),
				'expression' => 'UserModule::isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}	
	
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionVentas()
	{
		$this->render('panel_ventas');
	}
	
	public function actionPedidos()
	{
		$this->render('pedidos');
	}

	public function actionUsuarios()
	{
		$this->render('usuarios');
	}
        
        public function actionLooks()
	{
            //Para obtener por estados
            $total = 0;
            $total += $looks[]["total"] = Look::model()->countByAttributes(array("status" => Look::STATUS_CREADO));
            $total += $looks[]["total"] = Look::model()->countByAttributes(array("status" => Look::STATUS_ENVIADO));
            $total += $looks[]["total"] = Look::model()->countByAttributes(array("status" => Look::STATUS_APROBADO));

            for ($i=0; $i<3;$i++) {
                $looks[$i]["porcentaje"] = ($looks[$i]["total"] / $total) * 100;
            }
            $looks[0]["nombre"] = "Borrador";
            $looks[1]["nombre"] = "Enviados";
            $looks[2]["nombre"] = "Aprobados";
            
            //Por visitas
            $views = Look::masVistos();
            
            $this->render('looks', array('status' => $looks, 'views' => $views));
            
            
	}
        
        public function actionProductos()
	{           
            
            //Por visitas
            $views = Producto::masVistos();
            $this->render('productos', array('views' => $views));
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