<?php

class ShoppingMetricController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'create', 'update', 'index', 'view'),
				//'users'=>array('admin'),
				'expression' => 'UserModule::isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new ShoppingMetric;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShoppingMetric']))
		{
			$model->attributes=$_POST['ShoppingMetric'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ShoppingMetric']))
		{
			$model->attributes=$_POST['ShoppingMetric'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ShoppingMetric');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ShoppingMetric('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ShoppingMetric']))
			$model->attributes=$_GET['ShoppingMetric'];
		
			$criteria = new CDbCriteria;
			$criteria->condition = 'data like "%look_id%"';
			$criteria->order = 'id DESC';
			$dataProvider = new CActiveDataProvider('ShoppingMetric', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        #'pageSize' => Yii::app()->getModule('user')->user_page_size,
                    	),
                	));
	
		        
		        if((isset($_SESSION['todoPost']) && !isset($_GET['ajax'])))
	            {
	                unset($_SESSION['todoPost']);
	            }
            
	            if((isset($_SESSION['searchBox']) && !isset($_POST['query']) && !isset($_GET['ajax'])))
	            {
	                unset($_SESSION['searchBox']);
	            }
				
		        if(isset($_GET['ajax']) && !isset($_POST['dropdown_filter']) && isset($_SESSION['todoPost'])
               && !isset($_POST['query']))
               {
              		$_POST = $_SESSION['todoPost'];
           		 }
				
		        
		        if((isset($_SESSION['searchBox']) && !isset($_POST['query']) && !isset($_GET['ajax'])))
	            {
	                unset($_SESSION['searchBox']);
	            }
		       
		       if(isset($_GET['ajax']) && isset($_SESSION['searchBox'])  && !isset($_POST['query']))
               {
              		$_POST['query'] = $_SESSION['searchBox'];
               }
            
			

			   
			   if(isset($_POST['dropdown_filter']))
			   {   
                
                unset($_SESSION['searchBox']);
                $_SESSION['todoPost'] = $_POST;
                //Validar y tomar sólo los filtros válidos
                for($i=0; $i < count($_POST['dropdown_filter']); $i++)
                {
                    if($_POST['dropdown_filter'][$i] && $_POST['dropdown_operator'][$i]
                            && trim($_POST['textfield_value'][$i]) != '' && $_POST['dropdown_relation'][$i])
                            {

	                        $filters['fields'][] = $_POST['dropdown_filter'][$i];
	                        $filters['ops'][] = $_POST['dropdown_operator'][$i];
	                        $filters['vals'][] = $_POST['textfield_value'][$i];
	                        $filters['rels'][] = $_POST['dropdown_relation'][$i];                    

                           }
                }
				if (isset($filters['fields'])) {                    
                    
                    $dataProvider = $model->buscarPorFiltros($filters); 
				}     
			   
			   }
			   
			      
			   if (isset($_POST['query'])) 
               {
                    //echo($_POST['query']);	
                    $_SESSION['searchBox'] = $_POST['query'];
                   # unset($_SESSION["todoPost"]);
                   # $producto->nombre = $_POST['query'];
                   # $dataProvider = $producto->busquedaNombreReferencia($_POST['query']);
                   
                   $match=$_POST['query'];
                     if(Look::model()->findAll('title LIKE :match',array(':match' => "%$match%"))!="")
					 {
					 	#$var=Look::model()->findByPk($_POST['query']);
					 	$var = Look::model()->find('title LIKE :match',array(':match' => "%$match%"));
						$dataProvider=$model->buscarFiltro($var->id);
					 }
					 else 
					 {
						$dataProvider=$model->buscarFiltro(""); 
						
					 }
      
                 }
	
		
		
		$this->render('admin',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ShoppingMetric the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ShoppingMetric::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ShoppingMetric $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shopping-metric-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
