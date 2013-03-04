<?php

class LookController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update','precios'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','categorias'),
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
	  	$productos = Producto::model()->with(array('categorias'=>array('condition'=>'tbl_categoria_id=7')))->findAll();
	  	echo $this->renderPartial('_view_productos',array('productos'=>$productos),true,true);
	  	// echo 'rafa';
	  }
}
	public function actionCreate()
	{
		$model ='';	
		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1));
		
		$this->render('create',array(
						'model'=>$model,
						'categorias'=>$categorias,
					)
				);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Producto::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='producto-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
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