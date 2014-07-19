<?php

class ColorController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

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
				'actions'=>array('index','view','pruebazoho'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','upload','getcolores'),
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
	public function actionCreate($id = null)
	{
		if(is_null($id)){
			$model = new Color;
		}else{
			$model = Color::model()->findByPk($id);
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Color']))
		{
			$model->attributes=$_POST['Color'];
			if($model->save())
            {
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'success', 
                        'div'=>"El color se agrego con exito"
                        ));
                    exit;               
                }
                else{
                	if(!is_dir(Yii::getPathOfAlias('webroot').'/images/colores/')){
			   			mkdir(Yii::getPathOfAlias('webroot').'/images/colores/',0777,true);
			 		}
					
					$rnd = rand(0,9999);  
					$images=CUploadedFile::getInstanceByName('path_image');
					
					//var_dump($images);
					//echo "<br>".count($images);
					if (isset($images) && count($images) > 0) {
						$model->path_image = "{$rnd}-{$images}";
						
						$model->save();
						
				        
				        $nombre = Yii::getPathOfAlias('webroot').'/images/colores/'.$model->id;
				        $extension_ori = ".jpg";
						$extension = '.'.$images->extensionName;
				       
				       	if ($images->saveAs($nombre . $extension)) {
				
				       		$model->path_image = $model->id .$extension;
				            $model->save();
											
									
							Yii::app()->user->setFlash('success',UserModule::t("Marca guardada exitosamente."));

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
				        	$marca->delete();
						}
				        
					}
                	Yii::app()->user->setFlash('success',UserModule::t("Color guardado exitosamente"));
                    $this->redirect(array('admin'));
                }
            } 
		}

        if (Yii::app()->request->isAjaxRequest)
        {
            Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;	
			Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
			Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
			Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;	
            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('_addColor', array('model'=>$model), true,true)));
            exit;               
        }
        else
           $this->render('create',array('model'=>$model,));
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

		if(isset($_POST['Color']))
		{
			$model->attributes=$_POST['Color'];
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
		$precios_talla_color = Preciotallacolor::model()->findAllByAttributes(array('color_id'=>$id));
		if(sizeof($precios_talla_color) == 0){
			$this->loadModel($id)->delete();
			Yii::app()->user->setFlash('success',UserModule::t("Color eliminado"));
		}else{
			Yii::app()->user->setFlash('error',UserModule::t("El color está siendo utilizado y no se puede eliminar"));
		}
		
		$this->redirect(array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Color');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{ 
		$model=new Color('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Color']))
			$model->attributes=$_GET['Color'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	/**
	 * Subir la imagen
	 */
	public function actionUpload()
	{
	        Yii::import("ext.EAjaxUpload.qqFileUploader");
	 
	        $folder=Yii::app()->getBasePath().'/../images/colores/';// folder for uploaded files
	        Yii::trace('PrecioTallaColor Error:'.$folder, 'registro');
	        $allowedExtensions = array("jpg");//array("jpg","jpeg","gif","exe","mov" and etc...
	        $sizeLimit = 10 * 1024 * 1024;// maximum file size in bytes
	        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
	        $result = $uploader->handleUpload($folder);
	        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);
	 
	        $fileSize=filesize($folder.$result['filename']);//GETTING FILE SIZE
	        $fileName=$result['filename'];//GETTING FILE NAME
	 
	        echo $return;// it's array
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Color::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='color-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actiongetColores()
	{
		if (isset($_GET['search'])){
			$search = 	$_GET['search'];
			
			$colores = Color::model()->findAll(
				"valor LIKE :color",
				array(':color'=>"$search%")); // ordena alfeticamente por nombre			
		} else {
			$colores = Color::model()->findAll(array('order'=>'valor')); // ordena alfeticamente por nombre
		}
				 foreach($colores as $i => $row){
					$data[$i]['text']= $row->valor;
					$data[$i]['id'] = $row->id;
				 }
		echo CJSON::encode($data);
	}
	
	public function actionPruebazoho()
	{
		/*
		$zoho = New ZohoProductos; 
		$tallacolor = Preciotallacolor::model()->findByPk(1);
		$producto = Producto::model()->findByPk($tallacolor->producto_id);
		
		$zoho->nombre = $producto->nombre." - ".$tallacolor->sku;
		$zoho->cantidad = 45;
		$zoho->subcategoria2 = "Regalos";
		$zoho->metaDescripcion = "Nueva descripcion de prueba para editar desde la aplicacion";
		*/ 
		 
		$zoho = New ZohoProductos;
		$zoho->nombre = "Prueba desde Yii - 45787545M";
		$zoho->marca = "Fashion Prueba";
		$zoho->referencia = "POL0976GD";
		$zoho->estado = "TRUE";
		$zoho->peso = 0.6;
		$zoho->fecha = date("Y-m-d",strtotime("22-06-2014"));
		$zoho->categoria = "Mujer";
		$zoho->subcategoria1 = "Hombre";
		$zoho->subcategoria2 = "Complemento";
		$zoho->tienda = "Tienda de prueba";
		$zoho->tipo = "Externa"; 
		$zoho->url = "http://prueba.com/producto-de-prueba";
		$zoho->descripcion = "Un producto de prueba desde la app php";
		$zoho->costo = 15.3;
		$zoho->precioVenta = 26.3;
		$zoho->precioDescuento = 23;
		$zoho->descuento = 3.3;
		$zoho->precioImpuesto = 29;
		$zoho->porcentaje = 40; 
		$zoho->talla = "M";
		$zoho->color = "Azul";
		$zoho->SKU = "45787545M";
		$zoho->cantidad = 42;
		$zoho->titulo = "Prueba nueva desde Yii";
		$zoho->metaDescripcion = "Un producto de prueba desde la app php, Meta";
		$zoho->tags = "Prueba, Yii, desde, mujer, hombre, accesorios";
		
		$respuesta = $zoho->save_potential();
		
		echo $respuesta;
	}
	
}



