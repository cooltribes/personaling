<?php

class AdornoController extends Controller
{
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
				'actions'=>array(''), 
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('getImage'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','create', 'delete'),
				//'users'=>array('admin'),
				'expression' => 'UserModule::isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		); 
	}
	public function actionIndex()
	{
		$adorno = new Adorno; 

		if (isset($_POST['query']))
		{
			//echo($_POST['query']);	
			$adorno->nombre = $_POST['query'];
		}
		
		$dataProvider = $adorno->search();
		$this->render('index',
			array('model'=>$adorno,
			'dataProvider'=>$dataProvider,
		));	
	}
	
	public function actionCreate($id = null)
	{
		if(!$id){
			$adorno = new Adorno;
		}else{
			$adorno = Adorno::model()->findByPk($id);
		}
		
		if(isset($_POST['Adorno'])){
			$adorno->attributes=$_POST['Adorno'];
			//$adorno->path_url = $_POST['path_image'];
		
			if(!is_dir(Yii::getPathOfAlias('webroot').'/images/adorno/'))
				{
	   				mkdir(Yii::getPathOfAlias('webroot').'/images/adorno/',0777,true);
	 			}
			
			//$rnd = rand(0,9999);  // generate random number between 0-9999
           //$adorno->attributes=$_POST['Banner'];
 
            $images=CUploadedFile::getInstance($adorno,'path_image');
			//var_dump($images);
			//echo '<br/>Count: '.count($images);
			if (isset($images) && count($images) > 0) {
		            //foreach ($images as $image => $pic) {
						
							//$adorno->path_image = "{$rnd}-{$images}";
						
						
						//var_dump($adorno);
						if($adorno->save()){
		                
		
		                $nombre = Yii::getPathOfAlias('webroot').'/images/adorno/'.$adorno->id;
		                $extension_ori = ".jpg";
						$extension = '.'.$images->extensionName;
		                if ($images->saveAs($nombre . $extension)) {
		
		                    $adorno->path_image = $adorno->id .$extension;
		                    $adorno->save();
							
							if($extension == '.png'){
								$image = Yii::app()->image->load($nombre.$extension);
								//$image->save($nombre.'jpg');
							}else if($extension == '.jpeg'){
								$image = Yii::app()->image->load($nombre.$extension);
								$image->resize(130, 130);
								$image->save($nombre.'_thumb.jpg');
								$imageObject = imagecreatefromjpeg($nombre.$extension);
								imagepng($imageObject, $nombre . '.png');
								imagejpeg($imageObject, $nombre . '.jpg');
								$adorno->path_image = $adorno->id .'.jpg';
		                    	$adorno->save();
							}else{
								$image = Yii::app()->image->load($nombre.$extension);
								$image->save($nombre.'.png');
							}
							
							Yii::app()->user->setFlash('success',UserModule::t("Elemento gráfico guardado exitosamente"));
							
							if($extension != '.jpeg'){
								$image = Yii::app()->image->load($nombre.$extension);
								$image->resize(130, 130);
								$image->save($nombre.'_thumb'.$extension);
								if($extension == '.png'){
									$image = Yii::app()->image->load($nombre.$extension);
									$image->resize(130, 130);
									$image->save($nombre.'_thumb.jpg');
								}
							}
		                } else {
		                    $adorno->delete();
		                }
		                }else{
		                	Yii::app()->user->setFlash('error',UserModule::t("Elemento gráfico no pudo ser guardado"));
		                }
		            //}// foreach
		        }else{
		        	if($adorno->save()){
		        		Yii::app()->user->setFlash('success',UserModule::t("Elemento gráfico guardado exitosamente"));
		        	}else{
		        		Yii::app()->user->setFlash('error',UserModule::t("Elemento gráfico no pudo ser guardado"));
		        	}
		        }// isset
			
			
			
			
			/*
            $fileName = "{$rnd}-{$images}";  // random number + file name
            $adorno->path_image = $fileName;
 
            if($adorno->save())
            {
                $images->saveAs(Yii::app()->basePath.'/../images/adorno/'.$fileName);  // image will uplode to rootDirectory/banner/
                //$this->redirect(array('index'));
            }*/
	
				

		        //if (isset($images)) {
		            //foreach ($images as $image => $pic) {
		
		                //$imagen = new Imagen;
		                //$imagen->tbl_producto_id = $_GET['id'];
		                //$imagen->orden = 1 + Imagen::model()->count('`tbl_producto_id` = '.$_GET['id'].'');
		                //$imagen->save();
		
		                $this->redirect(array('index'));
			}
		
		$this->render('create',
			array('model'=>$adorno,
		));	
	}

	public function actionDelete($id)
	{
		$adorno = Adorno::model()->findByPk($id);;
		if($adorno->delete()){
			Yii::app()->user->setFlash('success',UserModule::t("Elemento gráfico eliminado exitosamente."));
		}else{
			Yii::app()->user->setFlash('error',UserModule::t("Elemento gráfico no pudo ser eliminado."));
		}
		$this->redirect(array('index'));		
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
	
		public function actionGetImage($id)
	{
		$model = $this->loadModel($id);
		//$image_url = $model->getImageUrl(array('type'=>'thumb','ext'=>'png')); <--- este caso para cuando exista thumb
		$image_url = $model->getImageUrl(array('ext'=>'png'));
		
		list($width, $height, $type, $attr) = getimagesize(Yii::getPathOfAlias('webroot').'/images/adorno/'.$model->path_image);		
		echo '<div class="new" id="adorno'.$id.'">';
		echo '<img '.$attr.' src="'.$image_url.'" alt>';
		echo '<input type="hidden" name="adorno_id" value="'.$id.'">';
		
		echo '</div>';
		//height="180" width="180"
		
	}
		public function loadModel($id)
	{
		$model=Adorno::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}