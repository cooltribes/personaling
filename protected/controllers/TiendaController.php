<?php

class TiendaController extends Controller
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
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','filtrar','categorias'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex()
	{
		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1));
		$producto = new Producto;		
		$producto->status = 1;
		
		$dataProvider = $producto->busqueda();
		$this->render('index',
		array('index'=>$producto,
		'dataProvider'=>$dataProvider,'categorias'=>$categorias,
		));	
			
	}
	
		public function actionFiltrar()
	{
		
		/*
		foreach ($data->categorias as $categ) {
		
			$cat = Categoria::model()->findByPk($categ->id);
		
   	echo "<td>".$cat->nombre."</td>"; // categoria
	$r=1;
	}
		*/
		
		$producto = new Producto;
		$producto->status = 1;

		if (isset($_POST['cate1']))
		{
			 if($_POST['cate1']==0)
			 	{}
			 else
			 	$producto->categoria_id = $_POST['cate1'];
			
		}	
	
		if (isset($_POST['busqueda']))
		{	
			$producto->nombre = $_POST['busqueda'];
		}
	
		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1));
		
		$dataProvider = $producto->busqueda();
		$this->render('index',
		array('index'=>$producto,
		'dataProvider'=>$dataProvider,'categorias'=>$categorias,
		));	
			
	}
	
	
	public function actionCategorias(){
	
	  $categorias = Categoria::model()->findAllByAttributes(array("padreId"=>$_POST['padreId']));
	  Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;	
		Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;	
	  if ($categorias){
	  echo $this->renderPartial('_view_categorias',array('categorias'=>$categorias),true,true);
	  }else {
	  		echo("2");
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