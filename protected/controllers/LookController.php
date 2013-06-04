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
				'actions'=>array('index','getimage','updateprice','encantar'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update','precios','create','categorias','publicar','view','colores'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','categorias','publicar','admin','detalle','edit'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			), 
		);
	}
	public function actionUpdatePrice()
	{
		$model = Look::model()->findByPk($_POST['look_id']);
		$precio = 0;
		$prendas = explode(',',$_POST['prendas']);
		
		foreach($model->lookhasproducto as $lookhasproducto){
			
			//if ($lookhasproducto->producto->getCantidad(null,$lookhasproducto->color_id) > 0)
			if (in_array($lookhasproducto->producto->id.'_'.$lookhasproducto->color_id,$prendas))
				$precio += $lookhasproducto->producto->getPrecio(false);
		}	
		echo CJSON::encode(array(
                        'status'=>'success', 
                        'div'=>Yii::app()->numberFormatter->formatDecimal($precio)
                        ));
	}
	public function actionDetalle($id)
	{
		$model = Look::model()->findByPk($id);
		echo $this->renderPartial('_view_detalle_look',array(
						'model'=>$model,
						//'categorias'=>$categorias,
					),true
				);		
	}
	public function actionView($id)
	{
		$model = Look::model()->findByPk($id);
		$this->render('view',array(
						'model'=>$model,
						//'categorias'=>$categorias,
					)
				);		
	}
	public function actionIndex() 
	{
		$this->render('index');
	}
	public function actionGetImage($id)
	{ 
		 	   
		 $look = Look::model()->findByPk($id);
		 $imagenes = array();
		 $i = 0;
		 
		 foreach($look->lookhasproducto as $lookhasproducto){
		 	$image_url = $lookhasproducto->producto->getImageUrl($lookhasproducto->color_id,array('ext'=>'png'));
		 	//echo substr_replace($producto->mainimage->url, '_thumb', strrchr($producto->mainimage->url,'.'), 0);
		 	if (isset($image_url)){
				 //	$imagenes[$i]->path = Yii::app()->getBasePath() .'/..' . substr_replace($image_url, '_thumb', strrpos($image_url,'.'), 0);
				 	$imagenes[$i]->path = Yii::app()->getBasePath() .'/../..'.$image_url;
					//$imagenes[$i]->image = imagecreatefromstring(file_get_contents($imagenes[$i]->path));
					$imagenes[$i]->top = $lookhasproducto->top;
					$imagenes[$i]->left = $lookhasproducto->left;
					$imagenes[$i]->width = $lookhasproducto->width;
					$imagenes[$i]->height = $lookhasproducto->height;
			} 
			//else {
			//	echo $lookhasproducto->producto->id;
			//}
			$i++;
		 }	
		 
		 foreach($look->lookHasAdorno as $lookhasadorno){
		 	
		 	$image_url = $lookhasadorno->adorno->getImageUrl(array('ext'=>'png'));
			 
		 	if (isset($image_url)){
				 	$imagenes[$i]->path = Yii::app()->getBasePath() .'/../..'.$image_url;
					$imagenes[$i]->top = $lookhasadorno->top;
					$imagenes[$i]->left = $lookhasadorno->left;
					$imagenes[$i]->width = $lookhasadorno->width;
					$imagenes[$i]->height = $lookhasadorno->height;
			} 
			//else {
			//	echo $lookhasproducto->producto->id;
			//}
			$i++;
		 }	
		 
/*
		$images = array();
		$i = 0;
		$large_width = 0;
		$large_height = 0;
		$total_width = 0;
		foreach ($images_path as $image_path){
			$images[$i] = imagecreatefromstring(file_get_contents($image_path));
			$width = imagesx($images[$i]);
			$height = imagesy($images[$i]);
			if ($large_width<$width) $large_width=$width;
			if ($large_height<$height) $large_height=$height;
    		$total_width += $width;
			$i++;
		}
*/

		$canvas = imagecreatetruecolor(670, 670);
		$white = imagecolorallocate($canvas, 255, 255, 255);
		imagefill($canvas, 0, 0, $white);
		$inicio_x = 0;
		foreach($imagenes as $image){

			$ext = pathinfo($image->path, PATHINFO_EXTENSION);
			
			
			 switch($ext) {
			          case 'gif':
			          $src = imagecreatefromgif($image->path);
			          break;
			          case 'jpg':
			          $src = imagecreatefromjpeg($image->path);
			          break;
			          case 'png':
			          $src = imagecreatefrompng($image->path);
			          break;
			      }			
			 
			// echo(" ".$ext."-".$src."   ");

			$img = imagecreatetruecolor($image->width,$image->height); 
			imagealphablending( $img, false );
			imagesavealpha( $img, true ); 

    		imagecopyresized($img,$src,0,0,0,0,$image->width,$image->height,imagesx($src), imagesy($src));

			imagecopy($canvas, $img, $image->left, $image->top, 0, 0, imagesx($img), imagesy($img));

		}

		
		header('Content-Type: image/png');
		
		imagepng($canvas);
		 
		imagedestroy($canvas);
		
		
	}

	public function actionGetImage2($id)
	{
		 	 
		 $look = Look::model()->findByPk($id);
		 $images_path = array();
		 foreach($look->productos as $producto){
		 	//echo substr_replace($producto->mainimage->url, '_thumb', strrchr($producto->mainimage->url,'.'), 0);
		 	echo $images_path[] = Yii::app()->getBasePath() .'/..' . substr_replace($producto->mainimage->url, '_thumb', strrpos($producto->mainimage->url,'.'), 0);
		 }	
		 /*
		 $image1_path=Yii::app()->getBasePath().'/../images/producto/1/27_thumb.jpg';
		 $image2_path=Yii::app()->getBasePath().'/../images/producto/1/28_thumb.jpg';
		 $image3_path=Yii::app()->getBasePath().'/../images/producto/1/29_thumb.jpg';
		 $image4_path=Yii::app()->getBasePath().'/../images/producto/1/39_thumb.jpg';
		 $image5_path=Yii::app()->getBasePath().'/../images/producto/1/40_thumb.jpg';
		 $image6_path=Yii::app()->getBasePath().'/../images/producto/1/41_thumb.jpg';
		  * */
		// $image1_path=Yii::app()->baseUrl.'/images/producto/1/27_thumb.jpg';
		
		// imagealphablending($image1, false);
		//imagesavealpha($image2, true);
		
		$images = array();
		$i = 0;
		$large_width = 0;
		$large_height = 0;
		$total_width = 0;
		foreach ($images_path as $image_path){
			$images[$i] = imagecreatefromstring(file_get_contents($image_path));
			$width = imagesx($images[$i]);
			$height = imagesy($images[$i]);
			if ($large_width<$width) $large_width=$width;
			if ($large_height<$height) $large_height=$height;
    		$total_width += $width;
			$i++;
		}
		//echo 'w'.$large_width;
		//echo 'h'.$large_height;
		
		$canvas = imagecreatetruecolor($total_width, $large_height);
		//$canvas = imagecreatetruecolor(670, 670);
		$white = imagecolorallocate($canvas, 255, 255, 255);
		imagefill($canvas, 0, 0, $white);
		
		
		 
		 

		  
		  
		 /*
		$image1 = imagecreatefromstring(file_get_contents($image1_path));
		$image2 = imagecreatefromstring(file_get_contents($image2_path));
		$image3 = imagecreatefromstring(file_get_contents($image3_path));
		$image4 = imagecreatefromstring(file_get_contents($image4_path));
		$image5 = imagecreatefromstring(file_get_contents($image5_path));
		$image6 = imagecreatefromstring(file_get_contents($image6_path));
*/		
		//imagecopymerge($image1, $image2, 100, 0, 0, 0, 300, 113, 100); //have to play with these numbers for it to work for you, etc.
		$inicio_x = 0;
		foreach($images as $image){
			imagecopy($canvas, $image, $inicio_x, 0, 0, 0, imagesx($image), imagesy($image));
			$inicio_x += imagesx($image);
		}
		//imagecopy($canvas, $images[0], 0, 0, 0, 0, imagesx($images[0]), imagesy($images[0]));
		//imagecopy($canvas, $images[1], 150, 0, 0, 0, imagesx($images[1]), imagesy($images[1]));
		//imagecopy($canvas, $images[2], 300, 0, 0, 0, imagesx($images[2]), imagesy($images[2]));
		
		//imagecopy($canvas, $image4, 0, 113, 0, 0, 150, 113);
		//imagecopy($canvas, $image5, 150, 113, 0, 0, 150, 113);
		//imagecopy($canvas, $image6, 300, 113, 0, 0, 150, 113);
		
		header('Content-Type: image/png');
		imagepng($canvas);
		
		imagedestroy($canvas);
		imagedestroy($images[0]);
		imagedestroy($images[1]);
		imagedestroy($images[2]);
		 
		
	}
public function actionColores(){
	Yii::app()->clientScript->scriptMap['jquery.js'] = false;
	Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;	
	Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
	Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
	Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;	
	$productos = Producto::model()->with(array('preciotallacolor'=>array('condition'=>'color_id='.$_POST['color_id'])))->findAll();
	echo $this->renderPartial('_view_productos',array('productos'=>$productos),true,true);	
	
}
public function actionCategorias(){
	
	  $categorias = Categoria::model()->findAllByAttributes(array("padreId"=>$_POST['padreId']),array('order'=>'nombre ASC'));
	  Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;	
		Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;	
	  if ($categorias){
	  echo $this->renderPartial('_view_categorias',array('categorias'=>$categorias),true,true);
	  }else {
	  	$productos = Producto::model()->with(array('categorias'=>array('condition'=>'tbl_categoria_id='.$_POST['padreId'])))->findAll();
	  	echo $this->renderPartial('_view_productos',array('productos'=>$productos),true,true);
	  	// echo 'rafa';
	  }
}
	public function actionCreate2()
	{
		$model = new PublicarForm;	
		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1));
		
		$this->render('create',array(
						'model'=>$model,
						'categorias'=>$categorias,
					)
				);
	}

	public function actionPublicar($id)
	{
		$model = Look::model()->findByPk($id);
		if(isset($_POST['Look'])){
			$model->attributes=$_POST['Look'];
			if($model->save())
            {
                if (isset($_POST['categorias'])){
                	CategoriaHasLook::model()->deleteAll(
    					"`look_id` = :look_id",
    					array(':look_id' => $model->id)
					);
                	foreach(explode('#',$_POST['categorias']) as $categoria){
                		$categoriahaslook = new CategoriaHasLook;
						$categoriahaslook->categoria_id = $categoria;
						$categoriahaslook->look_id = $model->id;
						$categoriahaslook->save();
						
                	}
                }	
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'success', 
                        'div'=>"El color se agrego con exito"
                        ));
                    exit;               
                }
                else {
                    //$this->redirect(array('view','id'=>$model->id));
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('success',UserModule::t("Tu look se a publicado."));	
                }
            } 
		}	
	    $this->render('publicar',array(
			'model'=>$model,
			
			)
		);
				
	}
	public function actionEdit($id)
	{
		$model= Look::model()->findByPK($id);
		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1));	
		//echo $_POST['productos_id'];
		if (isset($_POST['productos_id'])){
			/*	
			$model->title = "Look Nuevo";
			$model->altura = 0;
			$model->contextura = 0;
			$model->pelo = 0;
			$model->ojos = 0;
			$model->tipo_cuerpo = 0;
			$model->piel = 0;
			$model->tipo = 0;
			$model->user_id = Yii::app()->user->id;
			*/
			//if($model->save()){
				 
				$colores_id = explode(',',$_POST['colores_id']); 
				$left = explode(',',$_POST['left']);
				$top = explode(',',$_POST['top']);
				$width = explode(',',$_POST['width']);
				$height = explode(',',$_POST['height']);
				LookHasProducto::model()->deleteAllByAttributes(array('look_id'=>$model->id));
				foreach(explode(',',$_POST['productos_id']) as $index => $producto_id){
					/*	
					$lookhasproducto = LookHasProducto::model()->findByPk(array('look_id'=>$model->id,'producto_id'=>$producto_id));
					if (is_null($lookhasproducto)){
						$lookhasproducto = new LookHasProducto;
						$lookhasproducto->look_id = $model->id;
						$lookhasproducto->producto_id = $producto_id;
					}
					*/
					$lookhasproducto = new LookHasProducto;
					$lookhasproducto->look_id = $model->id;
					$lookhasproducto->producto_id = $producto_id;
					$lookhasproducto->color_id = $colores_id[$index];
					$lookhasproducto->cantidad = 1;
					$lookhasproducto->left = $left[$index];
					$lookhasproducto->top = $top[$index];
					$lookhasproducto->width = $width[$index];
					$lookhasproducto->height = $height[$index];
					if (!$lookhasproducto->save())
					 Yii::trace('create a look has producto, Error:'.print_r($lookhasproducto->getErrors(), true), 'registro');
					
					 
				}
				if ($_POST['tipo']==1){
			   		$this->redirect(array('look/publicar','id'=>$model->id)); 
					Yii::app()->end();
				} else {
					Yii::app()->user->updateSession();
					Yii::app()->user->setFlash('success',UserModule::t("Tu look se a guardado."));	
					$this->render('create',array(
							'model'=>$model,
							'categorias'=>$categorias,
						)
					);
				}		
			
			//} else{
			//		Yii::trace('edit a look, Error:'.print_r($model->getErrors(), true), 'registro');
			//}
		} else {
       $this->render('create',array(
				'model'=>$model,
				'categorias'=>$categorias,
			)
		);
		}
	}
	public function actionCreate()
	{
		if (isset($_GET['id']))
		$model= Look::model()->findByPk($_GET['id']);	
		else
		$model=new Look;
		
		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1),array('order'=>'nombre ASC'));	
		//echo $_POST['productos_id'];
		if (isset($_POST['productos_id'])){
			$model->title = "Look Nuevo";
			$model->altura = 0;
			$model->contextura = 0;
			$model->pelo = 0;
			$model->ojos = 0;
			$model->tipo_cuerpo = 0;
			$model->piel = 0;
			$model->tipo = 0;
			$model->user_id = Yii::app()->user->id;
			
			if($model->save()){
				$colores_id = explode(',',$_POST['colores_id']);
				$left = explode(',',$_POST['left']);
				$top = explode(',',$_POST['top']);
				$width = explode(',',$_POST['width']);
				$height = explode(',',$_POST['height']);
				
				// para los valores de los adornos
				$left_a = explode(',',$_POST['left_a']);
				$top_a = explode(',',$_POST['top_a']);
				$width_a = explode(',',$_POST['width_a']);
				$height_a = explode(',',$_POST['height_a']);

				foreach(explode(',',$_POST['productos_id']) as $index => $producto_id){
						
					$temporal = LookHasProducto::model()->findByPk(array('look_id'=>$model->id,'producto_id'=>$producto_id));
					if (!isset($temporal)){
						$lookhasproducto = new LookHasProducto;
						$lookhasproducto->look_id = $model->id;
						$lookhasproducto->producto_id = $producto_id;
						$lookhasproducto->color_id = $colores_id[$index];
						$lookhasproducto->cantidad = 1;
						$lookhasproducto->left = $left[$index];
						$lookhasproducto->top = $top[$index];
						$lookhasproducto->width = $width[$index];
						$lookhasproducto->height = $height[$index];
						
					if (!$lookhasproducto->save())
					 Yii::trace('create a look has producto, Error:'.print_r($lookhasproducto->getErrors(), true), 'registro');
					}
				}
				
				/* adornos */
				foreach(explode(',',$_POST['adornos_id']) as $index => $adorno_id){
						
					$temporal = LookHasAdorno::model()->findByAttributes(array('look_id'=>$model->id,'adorno_id'=>$adorno_id));
					
					if (!isset($temporal)){
						$lookhasadorno = new LookHasAdorno;
						$lookhasadorno->look_id = $model->id;
						$lookhasadorno->adorno_id = $adorno_id;
						$lookhasadorno->left = $left_a[$index];
						$lookhasadorno->top = $top_a[$index];
						$lookhasadorno->width = $width_a[$index];
						$lookhasadorno->height = $height_a[$index];
						
					if (!$lookhasadorno->save())
					 Yii::trace('create a look has producto, Error:'.print_r($lookhasadorno->getErrors(), true), 'registro');
					
					}
				}
				
				
				if ($_POST['tipo']==1){
			   		$this->redirect(array('look/publicar','id'=>$model->id)); 
					Yii::app()->end();
				} else {
					Yii::app()->user->updateSession();
					Yii::app()->user->setFlash('success',UserModule::t("Tu look se ha guardado."));	
					$this->render('create',array(
							'model'=>$model,
							'categorias'=>$categorias,
						)
					);
				}			
			} else{
					Yii::trace('create a look, Error:'.print_r($model->getErrors(), true), 'registro');
				}
		} else {
       $this->render('create',array(
				'model'=>$model,
				'categorias'=>$categorias,
			)
		);
		}
	}
	public function actionAdmin()
	{

		
		$look = new Look; 


		
		$dataProvider = $look->search();
		$this->render('admin',
		array('model'=>$look,
		'dataProvider'=>$dataProvider,
		));	

	}// fin	
	public function actionCreate3()
	{
		$model=new Look;
		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1));
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Look']))
		{
			$model->attributes=$_POST['Look'];
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
                else
                    $this->redirect(array('view','id'=>$model->id));
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
                'div'=>$this->renderPartial('_modal_publicar', array('model'=>$model), true,true)));
            exit;               
        }
        else
           $this->render('create',array(
           						'model'=>$model,
           						'categorias'=>$categorias,
						)
				);
	}
	
	
	/*
	 * Action para que la usuaria le encante un look
	 * 
	 * */
	public function actionEncantar()
	{
		
		if(Yii::app()->user->isGuest==false) // si está logueado
		{
			
			$like = LookEncantan::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'look_id'=>$_POST['idLook']));
			
			if(isset($like)) // si ya le dio like
			{
				$like->delete();
				
				echo "borrado";				
			}
			else // esta logueado y es un like nuevo
			{
				$encanta = new LookEncantan;
				
				$encanta->look_id = $_POST['idLook'];
				$encanta->user_id = Yii::app()->user->id;
				
				if($encanta->save())
					echo "ok"; // guardó y le encantó	
			}
		}
		else
			echo "no";

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