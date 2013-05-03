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
				'actions'=>array('index','filtrar','categorias'),
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
		$producto->status = 1; // no borrados
		$producto->estado = 0; // solo productos activos
		
		$a ="a"; 
		
		$dataProvider = $producto->busqueda($a);
		$this->render('index',
		array('index'=>$producto,
		'dataProvider'=>$dataProvider,'categorias'=>$categorias,
		));	
			
	}
	
		public function actionFiltrar()
	{
		
		$producto = new Producto;
		$producto->status = 1; // que no haya sido borrado logicamente
		$producto->estado = 0; // que no esté inactivo

		if (isset($_POST['cate1'])) // desde el select
		{
			//if($_POST['cate1']!=0)	
				$producto->categoria_id = $_POST['cate1'];			
		}
		
		if (isset($_POST['idact'])) // actualizacion desde los ajaxlink
		{
			 $producto->categoria_id = $_POST['idact'];			
		}		
	
		if (isset($_POST['busqueda'])) // desde el input
		{	
			$producto->nombre = $_POST['busqueda'];
		}
	
		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1));
		
		$todos = array();
		$todos = $this->getAllChildren(Categoria::model()->findAllByAttributes(array("padreId"=>$producto->categoria_id)));
		
		$dataProvider = $producto->busqueda($todos);
		$this->render('index',
		array('index'=>$producto,
		'dataProvider'=>$dataProvider,'categorias'=>$categorias,
		));	
			
	}
	
	
	public function actionColores()
	{
		
		$producto = new Producto;
		$producto->status = 1; // que no haya sido borrado logicamente
		$producto->estado = 0; // que no esté inactivo
	
		$color="";
	
		if(isset($_POST['idColor'])) // desde el input
		{	
			$color = $_POST['idColor'];
		}

		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1));

		$dataProvider = $producto->busColor($color);
		$this->render('index',
		array('index'=>$producto,
		'dataProvider'=>$dataProvider,'categorias'=>$categorias,
		));	
			
	}
	

	public function getAllChildren($models){
		$items = array();
		foreach($models as $model){
			if (isset($model->id)){
				$items[] = $model->id;
			 	if($model->hasChildren()){
                        $items= CMap::mergeArray($items,$this->getAllChildren($model->getChildren()));
                }
			}
		}
		return $items;
		
	}	
	 
	/*
	 * funcion original
	 * 
	 * 
	 * 	public function getAllChildren($models){
		$items = array();
		foreach($models as $model){
			if (isset($model->id)){
				$items[] = array('id'=> $model->id,'nombre'=> $model->nombre);
			 	if($model->hasChildren()){
                        $items= CMap::mergeArray($items,$this->getAllChildren($model->getChildren()));
                }
			}
		}
		return $items;
		
	}	
	 * 
	 * 
	 * */ 
	 
	public function actionCategorias(){
	
	  $categorias = Categoria::model()->findAllByAttributes(array("padreId"=>$_POST['padreId']));
	  Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;	
		Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;	
		
		// para que también filtre del lado del list view
		/*
		$producto = new Producto;
		$producto->status = 1;
		$producto->categoria_id = $_POST['padreId']; // el id del que se le da click		
		$todos = array(); 
		$todos = $this->getAllChildren(Categoria::model()->findAllByAttributes(array("padreId"=>$producto->categoria_id)));
		$dataProvider = $producto->busqueda($todos);
		*/
		
	  if ($categorias){
		 echo CJSON::encode(array(
			'id'=> $_POST['padreId'],
			'accion'=>'padre',
			'div'=> $this->renderPartial('_view_categorias',array('categorias'=>$categorias),true,true)
		));
		exit;
	  }else {
	  		echo CJSON::encode(array(
			'id'=> $_POST['padreId'],
			'accion'=>'hijo'
		));
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