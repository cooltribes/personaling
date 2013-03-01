<?php

class ProductoController extends Controller
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
				'actions'=>array('admin','delete','precios','imagenes','multi','orden','eliminar'),
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
		if(isset($_GET['id']))
		{
			$model = Producto::model()->findByPk($_GET['id']);
			//$model->horaInicio = Yii::app()->dateFormatter->formatDateTime($model->fInicio, false, 'medium');
			$model->horaInicio = '05:00 AM';
		}
		else {
			$model=new Producto;	
		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Producto']))
		{
			$model->attributes=$_POST['Producto'];
			if($model->save())
			{
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
				
			}
				//$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	//acceso para la pestaña de precios
	public function actionPrecios($id)
	{

		if(isset($_GET['id'])){
			if(!$precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$id)))
				$precio=new Precio;
			
			$model = Producto::model()->findByPk($id);
		}
		else {
			$precio=new Precio;
			$model = new Producto;
		}
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Precio']))
		{
			$precio->attributes=$_POST['Precio'];
			$precio->tbl_producto_id = $id;
			
			if($precio->save())
			{
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
			}
			//	$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('_view_precios',array(
			'model'=>$model,'precio'=>$precio,
		));
	}
	
	// mostrar la pagina
	public function actionImagenes($id)
	{
		if(isset($_GET['id'])){
			
			if(!$imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$id)))
				$imagen = new Imagen;
			
		}
		else {
			$imagen = new Imagen;
		}
		
		$model = Producto::model()->findByPk($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Imagen']))
		{
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
		}

		$this->render('_view_imagenes',array(
			'model'=>$model,'imagen'=>$imagen,
		));
	}
	
	// carga de imagenes
	public function actionMulti($id) {
				
			
		// make the directory to store the pic:
			if(!is_dir(Yii::getPathOfAlias('webroot').'/images/producto/'. $id))
			{
   				mkdir(Yii::getPathOfAlias('webroot').'/images/producto/'. $id,0777,true);
 			}

        $images = CUploadedFile::getInstancesByName('url');

        if (isset($images) && count($images) > 0) {
            foreach ($images as $image => $pic) {

                $imagen = new Imagen;
                $imagen->tbl_producto_id = $_GET['id'];
                $imagen->orden = 1 + Imagen::model()->count('`tbl_producto_id` = '.$_GET['id'].'');
                $imagen->save();

                $nombre = Yii::getPathOfAlias('webroot').'/images/producto/'. $id .'/'. $imagen->id;
                $extension = ".jpg";


                if ($pic->saveAs($nombre . $extension)) {

                    $imagen->url = '/images/producto/'. $id .'/'. $imagen->id .".jpg";
                    $imagen->save();
					
					Yii::app()->user->updateSession();
					Yii::app()->user->setFlash('success',UserModule::t("La imágen ha sido cargada exitosamente."));

                 /*   $image = Yii::app()->image->load($nombre . $extension);
                    $image->resize(640, 480);
                    $image->save($nombre . ".jpg");

                    $image = Yii::app()->image->load($nombre . $extension);
                    $image->resize(300, 200)->quality(40);
                    $image->save($nombre . "_thumb.jpg");*/
                } else {
                    $imagen->delete();
                }
            }
        }
        else {
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));	
		}


        $this->redirect(array('producto/imagenes', 'id' => $id));
    }

    // le da un nuevo orden a las imagenes
    public function actionOrden() {
        if (Yii::app()->request->isPostRequest) {

            $action = $_POST['action'];
            $actualizarImgs = $_POST['img'];
			
//	foreach ($actualizarImgs as $ima) {
	//	echo("<br> ".$ima);
	//}


            if ($action == "actualizar_orden") {
                $orden = 1;
                foreach ($actualizarImgs as $img) {
                    Imagen::model()->updateByPk($img, array('orden' => $orden));
                    echo("<br> ".$img);
					echo($orden);
                    $orden++;
                
			//	Post::model()->updateByPk($pks, 'author_id = :author_id', array('author_id'=>$myId));
				
				}
            }
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

// eliminacion en bd y fisica
    public function actionEliminar() {
        if (Yii::app()->request->isPostRequest) {

			$model=Imagen::model()->findByPk($_POST['id']);
            
            if ($model) {
                if (is_file(Yii::app()->basePath . '/..' . $model->url))
                     unlink(Yii::app()->basePath . '/..' . $model->url);
                $model->delete();
            }
            echo "OK";
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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

		if(isset($_POST['Producto']))
		{
			$model->attributes=$_POST['Producto'];
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
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Producto');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Producto('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Producto']))
			$model->attributes=$_GET['Producto'];

		$this->render('admin',array(
			'model'=>$model,
		));
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
}
