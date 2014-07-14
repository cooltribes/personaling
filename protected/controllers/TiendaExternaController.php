<?php

class TiendaExternaController extends Controller
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
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		$model=new Tienda;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tienda']))
		{
			$tienda->attributes = $_POST['Tienda'];
			$tienda->type=$_POST['multi'];
			
			//$tienda->urlImagen = $_POST['Tienda']['Urlimagen'];
		
			
		
			if(!is_dir(Yii::getPathOfAlias('webroot').'/images/tienda/'))
				{
	   				mkdir(Yii::getPathOfAlias('webroot').'/images/tienda/',0777,true);
	 			}
			
			$rnd = rand(0,9999);  
			$images=CUploadedFile::getInstanceByName('logo');
			
	
		
			if (isset($images) && count($images) > 0) {
				$tienda->urlImagen = "{$rnd}-{$images}";
				
				$tienda->save();
					        
		        $nombre = Yii::getPathOfAlias('webroot').'/images/tienda/'.$tienda->id;
		        $extension_ori = ".jpg";
				$extension = '.'.$images->extensionName;
		       
		       	if ($images->saveAs($nombre . $extension)) {
		
		       		$tienda->logo = $tienda->id .$extension;
		            $tienda->save();
									
							
					Yii::app()->user->setFlash('success',UserModule::t("Tienda guardada exitosamente."));

					$image = Yii::app()->image->load($nombre.$extension);
					$image->resize(150, 150);
					$image->save($nombre.'_thumb'.$extension);
					
					if($extension == '.png'){
						$image = Yii::app()->image->load($nombre.$extension);
						$image->resize(150, 150);
						$image->save($nombre.'_thumb.jpg');
					}	
					
				}
				else {
		        	$tienda->delete();
				}
		        
			}else{
		    	if(!$tienda->save())
		    		Yii::app()->user->setFlash('error',UserModule::t("Tienda no pudo ser guardada.").$adicional);
		        
			}// isset
			
		                
		                
		                
		                $this->redirect(array('admin'));
		}

		$this->render('create',array(
			'tienda'=>$model,
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

		if(isset($_POST['Tienda']))
		{
			$model->attributes=$_POST['Tienda'];
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
		$dataProvider=new CActiveDataProvider('Tienda');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Tienda('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tienda']))
			$model->attributes=$_GET['Tienda'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Tienda the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Tienda::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Tienda $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tienda-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
