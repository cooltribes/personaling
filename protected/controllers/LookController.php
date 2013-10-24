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
		
			array('allow', 
			'actions'=>array('view'),
			
			'expression' => 'preg_match( "/^facebookexternalhit/", $_SERVER["HTTP_USER_AGENT"] )',
			
			),
			array('allow',  // allow all ips from facebook
				'actions'=>array('index','view'),
				'ips'=>array(
				'201.210.221.244',
				'204.15.20.0/22'
							,'69.63.176.0/20'
							,'66.220.144.0/20'
							,'66.220.144.0/21'
							,'69.63.184.0/21'
							,'69.63.176.0/21'
							,'74.119.76.0/22'
							,'69.171.255.0/24'
							,'173.252.64.0/18'
							,'69.171.224.0/19'
							,'69.171.224.0/20'
							,'103.4.96.0/22'
							,'69.63.176.0/24'
							,'173.252.64.0/19'
							,'173.252.70.0/24'
							,'31.13.64.0/18'
							,'31.13.24.0/21'
							,'66.220.152.0/21'
							,'66.220.159.0/24'
							,'69.171.239.0/24'
							,'69.171.240.0/20'
							,'31.13.64.0/19'
							,'31.13.64.0/24'
							,'31.13.65.0/24'
							,'31.13.67.0/24'
							,'31.13.68.0/24'
							,'31.13.69.0/24'
							,'31.13.70.0/24'
							,'31.13.71.0/24'
							,'31.13.72.0/24'
							,'31.13.73.0/24'
							,'31.13.74.0/24'
							,'31.13.75.0/24'
							,'31.13.76.0/24'
							,'31.13.77.0/24'
							,'31.13.96.0/19'
							,'31.13.66.0/24'
							,'173.252.96.0/19'
							,'69.63.178.0/24'
							,'31.13.78.0/24'
							,'31.13.79.0/24'
							,'31.13.80.0/24'
							,'31.13.82.0/24'
							,'31.13.83.0/24'
							,'31.13.84.0/24'
							,'31.13.85.0/24'
							,'31.13.86.0/24'
							,'31.13.87.0/24'
							,'31.13.88.0/24'
							,'31.13.89.0/24'
							,'31.13.90.0/24'
							,'31.13.91.0/24'
							,'31.13.92.0/24'
							,'31.13.93.0/24'
							,'31.13.94.0/24'
							,'31.13.95.0/24'
							,'31.13.97.0/24'
							,'69.171.253.0/24'
							,'69.63.186.0/24'
							,'31.13.81.0/24'
							,'204.15.20.0/22'
							,'69.63.176.0/20'
							,'69.63.176.0/21'
							,'69.63.184.0/21'
							,'66.220.144.0/20'
							,'69.63.176.0/20'),
			),
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','getimage','updateprice','encantar'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('precios','categorias','view','colores'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','categorias','publicar','admin','detalle','edit','update','create','publicar','marcas','mislooks','softdelete'),
				//'users'=>array('admin'),
				'expression' => 'UserModule::isAdmin()',
			),
			array('allow', // acciones validas para el personal Shopper
               'actions' => array('create','publicar','precios','categorias','view','colores','edit','marcas','mislooks','detalle','softdelete'),
               'expression' => 'UserModule::isPersonalShopper()'
            ),
			array('deny',  // deny all users
				'users'=>array('*'),
			), 
		);
	}
	public function actionSoftDelete($id)
	{
		$model = Look::model()->findByPk($id);
		if ($model->status!=Look::STATUS_APROBADO){
			$model->softDelete();
			Yii::app()->user->updateSession();
            Yii::app()->user->setFlash('success', 'Look eliminado');
		}
		else{
			Yii::app()->user->updateSession();
            Yii::app()->user->setFlash('error', 'No se puede eliminar un look que ya ha sido aprobado');
		}
		if (Yii::app()->user->isAdmin())
			$this->redirect(array('look/admin'));
		else 
			$this->redirect(array('look/mislooks'));

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
	
	/*
	 * Ver los looks del personal shopper 
	 * */
	public function actionMislooks()
	{
		$look = new Look; 

		if(UserModule::isPersonalShopper())
		{
			$look->user_id = Yii::app()->user->id;
		}	
		if(isset($_POST['buscar_look']))
		{
			$look->title = $_POST['buscar_look'];
		}			
		$dataProvider = $look->search();
		
		$this->render('ps', array('model'=>$look,'dataProvider'=>$dataProvider,'tipo'=>'ps','look'=>$look));	
		
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
	public function actionView()
	{
		if(isset($_GET['alias'])){
			$model = Look::model()->findByAttributes(array('url_amigable'=>$_GET['alias']));
		}
		else{
			$model = Look::model()->findByPk($_GET['id']);
		}		
		
		$model->increaseView();
	
		$productoView = new ProductoView;
		$productoView->user_id = Yii::app()->user->id;
		
		$looks = new Look;
		$user = User::model()->findByPk(Yii::app()->user->id);
		
		$this->render('view',array(
						'model'=>$model,
						'ultimos_vistos'=> $productoView->lastView(),
						'dataProvider' => $looks->match($user),
						'user'=>$user,	
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
		$filename = Yii::getPathOfAlias('webroot').'/images/look/'.$id.'.png'; 	   
		if (file_exists($filename)) {
			//session_start(); 
			header("Cache-Control: private, max-age=10800, pre-check=10800");
			header("Pragma: private");
			header("Expires: " . date(DATE_RFC822,strtotime(" 2 day")));	
					if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) 
					       && 
					  (strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == filemtime($filename))) {
					  // send the last mod time of the file back
					  header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($filename)).' GMT', 
					  true, 304);
					  exit;
					}
					  
			 $w = 710;
			 if (isset($_GET['w']))
			 	$w = $_GET['w'];
			 
			 
			 $h = 710;
			 if (isset($_GET['h']))
			 	$h = $_GET['h'];
							$ratio_orig = 1;

                        if ($w/$h > $ratio_orig) {
                           $w = $h*$ratio_orig;
                        } else {
                           $h = $w/$ratio_orig;
                        }
			//echo Yii::app()->baseUrl.'/images/look/'.$id.'.png';
			 $image_p = imagecreatetruecolor($w, $h);
			$src = imagecreatefrompng($filename);
			imagecopyresampled( $image_p, $src, 0, 0, 0, 0, $w, $h, 710, 710);
			//header('Pragma: public');
			//header('Cache-Control: max-age=86400');
			//header('Expires: '. gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
			//header('Content-Type: image/jpeg'); 
header("Content-type: image/jpeg");
header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($filename)) . ' GMT');
			imagejpeg($image_p, null, 100);
			//readfile($filename);
			//imagepng($src,null,9); // <------ se puso compresion 9 para mejorar la rapides al cargar la imagen
			imagedestroy($src);			
		} else {
		 $look = Look::model()->findByPk($id);
		 
		 /*
		 $w = 670;
		 if (isset($_GET['w']))
		 	$w = $_GET['w'];
		 $diff_w = 670/$w;
		 
		 $h = 670;
		 if (isset($_GET['h']))
		 	$h = $_GET['h'];
		 $diff_h = 670/$h;
		 */
		 $w = 710;
		 $diff_w = 1;
		  $h = 710;
		 $diff_h = 1;
		 $imagenes = array();
		 $i = 0;
		 
		 foreach($look->lookhasproducto as $lookhasproducto){
		 	$image_url = $lookhasproducto->producto->getImageUrl($lookhasproducto->color_id,array('ext'=>'png'));
		 	if (isset($image_url)){
		 			$imagenes[$i] = new stdClass();
				 	$imagenes[$i]->path = $_SERVER['DOCUMENT_ROOT'].$image_url;
					$imagenes[$i]->top = $lookhasproducto->top;
					$imagenes[$i]->left = $lookhasproducto->left;
					$imagenes[$i]->width = $lookhasproducto->width;
					$imagenes[$i]->height = $lookhasproducto->height;
					$imagenes[$i]->angle = $lookhasproducto->angle;
					$imagenes[$i]->zindex = $lookhasproducto->zindex;
			} 
			$i++;
		 }	
		 
		 foreach($look->lookHasAdorno as $lookhasadorno){
		 	$image_url = $lookhasadorno->adorno->getImageUrl(array('ext'=>'png'));
			$ador = Adorno::model()->findByPk($lookhasadorno->adorno_id);
		 	if (isset($image_url)){
		 			$imagenes[$i] = new stdClass();
				 	$imagenes[$i]->path = Yii::getPathOfAlias('webroot').'/images/adorno/'.$ador->path_image;
					$imagenes[$i]->top = $lookhasadorno->top;
					$imagenes[$i]->left = $lookhasadorno->left;
					$imagenes[$i]->width = $lookhasadorno->width;
					$imagenes[$i]->height = $lookhasadorno->height;
					$imagenes[$i]->angle = $lookhasadorno->angle;
					$imagenes[$i]->zindex = $lookhasadorno->zindex;
			} 

			$i++;
		 }	
		 
		 
		 $imagenes[$i] = new stdClass();
				 	$imagenes[$i]->path = Yii::getPathOfAlias('webroot').'/images/p70.png';
					$imagenes[$i]->top = 0;
					$imagenes[$i]->left = 5;
					$imagenes[$i]->width = 70;
					$imagenes[$i]->height = 70;
					$imagenes[$i]->angle = 0;
					$imagenes[$i]->zindex = 1000;
		 
		//Yii::trace('create a image look, Trace:'.print_r($imagenes, true), 'registro');
		function sortByIndex($a, $b) {
		    return $a->zindex - $b->zindex;
		} 
		
		usort($imagenes, 'sortByIndex');
		
		$canvas = imagecreatetruecolor($w, $h);
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
						//Yii::trace('create a image look, Trace:'.$image->path, 'registro');  
			          break;
			      }			
			$img = imagecreatetruecolor($image->width/$diff_w,$image->height/$diff_h);
			
			imagealphablending( $img, false );
			imagesavealpha( $img, true ); 
    		$pngTransparency = imagecolorallocatealpha($img , 0, 0, 0, 127); 
    		//imagecopyresized($img,$src,0,0,0,0,$image->width/$diff_w,$image->height/$diff_h,imagesx($src), imagesy($src));
			imagecopyresampled($img,$src,0,0,0,0,$image->width/$diff_w,$image->height/$diff_h,imagesx($src), imagesy($src)); // <----- Se cambio a sampled para mejorar la calidad de las imagenes
    		//imagecopyresized($img,$src,0,0,0,0,imagesx($src),imagesy($src),imagesx($src), imagesy($src));
			if ($image->angle){
				//Yii::trace('create a image look,'.$image->angle.' Trace:'.$image->path, 'registro');  	
				$img = imagerotate($img,$image->angle*(-1),$pngTransparency);
			}
			imagecopy($canvas, $img, $image->left/$diff_w, $image->top/$diff_h, 0, 0, imagesx($img), imagesy($img));
		}
		header('Content-Type: image/png'); 
		header('Cache-Control: max-age=86400, public');
		imagepng($canvas,Yii::getPathOfAlias('webroot').'/images/look/'.$look->id.'.png',9);
		imagepng($canvas,null,9); // <------ se puso compresion 9 para mejorar la rapides al cargar la imagen
		imagedestroy($canvas);
		}
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
	Yii::app()->clientScript->scriptMap['bootstrap.min.css'] = false;	
	Yii::app()->clientScript->scriptMap['bootstrap.min.js'] = false;	
	
	$productos = Producto::model()->with(array('preciotallacolor'=>array('condition'=>'color_id='.$_POST['colores'])))->findAll();
	echo $this->renderPartial('_view_productos',array('productos'=>$productos),true,true);	
	
}
public function actionCategorias(){
	  	$categorias = false;
		$categoria_padre = Categoria::model()->findByPk($_POST['padreId']);
	  Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;	
		Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;	
		Yii::app()->clientScript->scriptMap['bootstrap-responsive.css'] = false;
		Yii::app()->clientScript->scriptMap['jquery-ui-bootstrap.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.min.css'] = false;	
		Yii::app()->clientScript->scriptMap['bootstrap.min.js'] = false;	
	if ($_POST['padreId']!=0){ 
	  $categorias = Categoria::model()->findAllByAttributes(array("padreId"=>$_POST['padreId']),array('order'=>'nombre ASC'));
	  

	}
	  if ($categorias){
	  echo $this->renderPartial('_view_categorias',array('categorias'=>$categorias,'categoria_padre'=>$categoria_padre->padreId),true,true);
	  }else {
	  	$with = array();
	  	if(isset($_POST['padreId']))
		  	if ($_POST['padreId']!=0)
				$with['categorias'] = array('condition'=>'tbl_categoria_id='.$_POST['padreId']);
		if(isset($_POST['colores']))
			if ($_POST['colores']!='')
				$with['preciotallacolor'] = array('condition'=>'color_id='.$_POST['colores']);
			
	  	if(isset($_POST['marcas'])){
		  	if ($_POST['marcas']!='Todas las Marca')	
		  		$productos = Producto::model()->with($with)->findAllByAttributes(array('marca_id'=>$_POST['marcas']));
			else	
		  		$productos = Producto::model()->with($with)->findAll();
		} else {
			$productos = Producto::model()->with($with)->findAll();
		}
	  	if (isset($categoria_padre))
	  		echo $this->renderPartial('_view_productos',array('productos'=>$productos,'categoria_padre'=>$categoria_padre->padreId),true,true);
		else
			echo $this->renderPartial('_view_productos',array('productos'=>$productos,'categoria_padre'=>null),true,true);
	  	// echo 'rafa';
	  }
}


/*
 * filtrado por marcas
 * */
	public function actionMarcas(){
		
			$productos = Producto::model()->findAllByAttributes(array('marca_id'=>$_POST['marcas']));
		  
		  	Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;	
			Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
			Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
			Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;	
			Yii::app()->clientScript->scriptMap['bootstrap.min.css'] = false;	
			Yii::app()->clientScript->scriptMap['bootstrap.min.js'] = false;	
		 	
		 	echo $this->renderPartial('_view_productos',array('productos'=>$productos),true,true);
		  
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
		
		$temporal = '';
		foreach($model->categoriahaslook as $categoriahaslook){
			$temporal .= $categoriahaslook->categoria_id.'#';
		}
		if ($temporal!='')
			$model->has_ocasiones = substr($temporal, 0, -1);
		//echo $model->has_ocasiones;
		
		if(isset($_POST['Look'])){
			$model->attributes=$_POST['Look'];
			
			if($model->url_amigable == "")
				$model->url_amigable = NULL; 
			
			if (Yii::app()->user->isAdmin()){
                            $model->status = Look::STATUS_APROBADO;
                            $model->approved_on = date("Y-m-d H:i:s");
                            
                            if(!$model->sent_on){
                                $model->sent_on = date("Y-m-d H:i:s");
                            }
                            
                        }else{
                            $model->status = Look::STATUS_ENVIADO;
                            $model->sent_on = date("Y-m-d H:i:s");
                        }	
			
				

			 
			
			if($model->save())
            {
                if (isset($_POST['categorias'])){ 
                	CategoriaHasLook::model()->deleteAll(
    					"`look_id` = :look_id",
    					array(':look_id' => $model->id)
					);
					//$temporal = '';
					$model->has_ocasiones = $_POST['categorias'];
                	foreach(explode('#',$_POST['categorias']) as $categoria){
                		$categoriahaslook = new CategoriaHasLook;
						$categoriahaslook->categoria_id = $categoria;
						$categoriahaslook->look_id = $model->id;
						if (!$categoriahaslook->save()){
							 Yii::trace('save categoriahaslook'.print_r($_POST['categorias'],true).', 384 Error:'.print_r($categoriahaslook->getErrors(), true), 'registro');
						}
						//$temporal .= $categoriahaslook->categoria_id.'#';
                	}
					//if ($temporal!='')
					//	$model->has_ocasiones = substr($temporal, 0, -1);
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
				if (Yii::app()->user->isAdmin())
					Yii::app()->user->setFlash('success',UserModule::t("Tu look se ha publicado."));
				else 	
					Yii::app()->user->setFlash('success',UserModule::t("Tu look se ha enviado."));
                }
            } 
		}	
		$model = Look::model()->findByPk($id);
		if (isset($_POST['categorias'])){ 
	 		$model->has_ocasiones = $_POST['categorias'];
		} else {
			if ($temporal!='')
				$model->has_ocasiones = substr($temporal, 0, -1);
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
			if (isset($_POST['Look']['campana_id'])){
				$model->campana_id =$_POST['Look']['campana_id'];
				$model->save();
			}
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
					
				// para los valores de los adornos
				$left_a = explode(',',$_POST['left_a']);
				$top_a = explode(',',$_POST['top_a']);
				$width_a = explode(',',$_POST['width_a']);
				$height_a = explode(',',$_POST['height_a']);		
				 
				$colores_id = explode(',',$_POST['colores_id']); 
				$left = explode(',',$_POST['left']);
				$top = explode(',',$_POST['top']);
				$width = explode(',',$_POST['width']);
				$height = explode(',',$_POST['height']);
				$angle = explode(',',$_POST['angle']);
				$zindex = explode(',',$_POST['index']);
								
				$angle_a = explode(',',$_POST['angle_a']);
				$zindex_a = explode(',',$_POST['index_a']);				
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
					$lookhasproducto->left = round($left[$index]);
					$lookhasproducto->top = round($top[$index]);
					$lookhasproducto->width = $width[$index];
					$lookhasproducto->height = $height[$index];
					$lookhasproducto->angle = $angle[$index];  
					$lookhasproducto->zindex = $zindex[$index];
					if (!$lookhasproducto->save())
					 Yii::trace('create a look has producto, Error:'.print_r($lookhasproducto->getErrors(), true), 'registro');
					
					
				/* adornos */ 
				LookHasAdorno::model()->deleteAllByAttributes(array('look_id'=>$model->id));
				foreach(explode(',',$_POST['adornos_id']) as $index => $adorno_id){
						
					//$temporal = LookHasAdorno::model()->findByAttributes(array('look_id'=>$model->id,'adorno_id'=>$adorno_id));
					
					//if (!isset($temporal)){
						$lookhasadorno = new LookHasAdorno;
						$lookhasadorno->look_id = $model->id;
						$lookhasadorno->adorno_id = $adorno_id;
						$lookhasadorno->left = round($left_a[$index]);
						$lookhasadorno->top = round($top_a[$index]);
						$lookhasadorno->width = $width_a[$index];
						$lookhasadorno->height = $height_a[$index];
						$lookhasadorno->angle = $angle_a[$index];
						$lookhasadorno->zindex = $zindex_a[$index];						
					if (!$lookhasadorno->save())
					 Yii::trace('create a look has producto, Error:'.print_r($lookhasadorno->getErrors(), true), 'registro');
					 
					//}
				}
					
					 
				}
				$model->createImage();
				if ($_POST['tipo']==1){ 
			   		$this->redirect(array('look/publicar','id'=>$model->id)); 
					Yii::app()->end();
				} else {
					Yii::app()->user->updateSession();
					Yii::app()->user->setFlash('success',UserModule::t("Tu look se ha guardado."));	
					
					if ($model->status == 0 || UserModule::isAdmin()){ // comprueba que el look no se haya enviado o aprovado
					$user = User::model()->findByPk(Yii::app()->user->id);
					$criteria=new CDbCriteria;
					$criteria->condition = 'estado = 2 AND "'.date('Y-m-d H:i:s').'" > recepcion_inicio AND "'.date('Y-m-d H:i:s').'" < recepcion_fin';
					if($user->superuser != '1'){
						$criteria->join = 'JOIN tbl_campana_has_personal_shopper ps ON t.id = ps.campana_id and ps.user_id = '.Yii::app()->user->id;
					}
					$models = Campana::model()->findAll($criteria);
					
			        $this->render('create',array(
							'model'=>$model,
							'categorias'=>$categorias,
							'models'=>$models,
						)
					);
					} else {
						$this->redirect(array('look/publicar','id'=>$model->id)); 
						Yii::app()->end();
					}
				}		 
			
			//} else{
			//		Yii::trace('edit a look, Error:'.print_r($model->getErrors(), true), 'registro');
			//}
		} else {
			
			if ($model->status == 0 || UserModule::isAdmin()){ // comprueba que el look no se haya enviado o aprovado
			$user = User::model()->findByPk(Yii::app()->user->id);
			$criteria=new CDbCriteria;
			$criteria->condition = 'estado = 2 AND "'.date('Y-m-d H:i:s').'" > recepcion_inicio AND "'.date('Y-m-d H:i:s').'" < recepcion_fin';
			if($user->superuser != '1'){
				$criteria->join = 'JOIN tbl_campana_has_personal_shopper ps ON t.id = ps.campana_id and ps.user_id = '.Yii::app()->user->id;
			}
			$models = Campana::model()->findAll($criteria);
			
	        $this->render('create',array(
					'model'=>$model,
					'categorias'=>$categorias,
					'models'=>$models,
				)
			);
			} else {
				$this->redirect(array('look/publicar','id'=>$model->id)); 
				Yii::app()->end();
			}
			
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
			
			$model->campana_id = $_POST['Look']['campana_id'];
			
			if($model->save()){
				$colores_id = explode(',',$_POST['colores_id']);
				$left = explode(',',$_POST['left']);
				$top = explode(',',$_POST['top']);
				$width = explode(',',$_POST['width']);
				$height = explode(',',$_POST['height']);
				$angle = explode(',',$_POST['angle']);
				$zindex = explode(',',$_POST['index']);
				// para los valores de los adornos
				$left_a = explode(',',$_POST['left_a']);
				$top_a = explode(',',$_POST['top_a']);
				$width_a = explode(',',$_POST['width_a']);
				$height_a = explode(',',$_POST['height_a']);
				$angle_a = explode(',',$_POST['angle_a']);
				$zindex_a = explode(',',$_POST['index_a']);

				foreach(explode(',',$_POST['productos_id']) as $index => $producto_id){
						 
					$temporal = LookHasProducto::model()->findByPk(array('look_id'=>$model->id,'producto_id'=>$producto_id));
					if (!isset($temporal)){
						$lookhasproducto = new LookHasProducto;
						$lookhasproducto->look_id = $model->id;
						$lookhasproducto->producto_id = $producto_id;
						$lookhasproducto->color_id = $colores_id[$index];
						$lookhasproducto->cantidad = 1;
						$lookhasproducto->left = round($left[$index]);
						$lookhasproducto->top = round($top[$index]);
						$lookhasproducto->width = $width[$index];
						$lookhasproducto->height = $height[$index];
						$lookhasproducto->angle = $angle[$index];
						$lookhasproducto->zindex = $zindex[$index];
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
						$lookhasadorno->left = round($left_a[$index]);
						$lookhasadorno->top = round($top_a[$index]);
						$lookhasadorno->width = $width_a[$index];
						$lookhasadorno->height = $height_a[$index];
						$lookhasadorno->angle = $angle_a[$index];
						$lookhasadorno->zindex = $zindex_a[$index];
						
					if (!$lookhasadorno->save())
					 Yii::trace('create a look has producto, Error:'.print_r($lookhasadorno->getErrors(), true), 'registro');
					
					}
				}
				
				$model->createImage();
				if ($_POST['tipo']==1){
			   		$this->redirect(array('look/publicar','id'=>$model->id)); 
					Yii::app()->end();
				} else {
					Yii::app()->user->updateSession();
					Yii::app()->user->setFlash('success',UserModule::t("Tu look se ha guardado."));	
					
					$user = User::model()->findByPk(Yii::app()->user->id);
					$criteria=new CDbCriteria;
					$criteria->condition = 'estado = 2 AND "'.date('Y-m-d H:i:s').'" >= recepcion_inicio AND "'.date('Y-m-d H:i:s').'" <= recepcion_fin';
					if($user->superuser != '1'){
						$criteria->join = 'JOIN tbl_campana_has_personal_shopper ps ON t.id = ps.campana_id and ps.user_id = '.Yii::app()->user->id;
					}
					
					$models = Campana::model()->findAll($criteria);
					
					if(sizeof($models) > 0){
				        $this->render('create',array(
								'model'=>$model,
								'categorias'=>$categorias,
								'models'=>$models,
							)
						);
					}else{
						$this->render('no_campanas');
					}
				}			
			} else{
					Yii::trace('create a look, Error:'.print_r($model->getErrors(), true), 'registro');
				}
		} else {
			$user = User::model()->findByPk(Yii::app()->user->id);
			$criteria=new CDbCriteria;
			$criteria->condition = 'estado = 2 AND "'.date('Y-m-d H:i:s').'" > recepcion_inicio AND "'.date('Y-m-d H:i:s').'" < recepcion_fin';
			if($user->superuser != '1'){
				$criteria->join = 'JOIN tbl_campana_has_personal_shopper ps ON t.id = ps.campana_id and ps.user_id = '.Yii::app()->user->id;
			}
			
			$models = Campana::model()->findAll($criteria);
			
			if(sizeof($models) > 0){
		        $this->render('create',array(
						'model'=>$model,
						'categorias'=>$categorias,
						'models'=>$models,
					)
				);
			}else{
				$this->render('no_campanas');
			}
		}
	}
	public function actionAdmin()
        {
              
            
            $model = new Look;
            if (isset($_POST['buscar_look'])) {
                $model->title = $_POST['buscar_look'];
            }
            $dataProvider = $model->lookAdminAprobar();
            
            
            
            /**********************   Para Filtros   *************************/
            if((isset($_SESSION['todoPost']) && !isset($_GET['ajax'])))
            {
                unset($_SESSION['todoPost']);
            }
            //Filtros personalizados
            $filters = array();
            
            //Para guardar el filtro
            $filter = new Filter;
            
            
           if(isset($_GET['ajax']) && !isset($_POST['dropdown_filter']) && isset($_SESSION['todoPost'])
               && !isset($_POST['buscar_look'])){
              $_POST = $_SESSION['todoPost'];
           }            
            
            if(isset($_POST['dropdown_filter'])){  
                                
                $_SESSION['todoPost'] = $_POST;          
                
                //Validar y tomar sólo los filtros válidos
                for($i=0; $i < count($_POST['dropdown_filter']); $i++){
                    if($_POST['dropdown_filter'][$i] && $_POST['dropdown_operator'][$i]
                            && trim($_POST['textfield_value'][$i]) != '' && $_POST['dropdown_relation'][$i]){

                        $filters['fields'][] = $_POST['dropdown_filter'][$i];
                        $filters['ops'][] = $_POST['dropdown_operator'][$i];
                        $filters['vals'][] = $_POST['textfield_value'][$i];
                        $filters['rels'][] = $_POST['dropdown_relation'][$i];                    

                    }
                }     
                //Respuesta ajax
                $response = array();
                
                if (isset($filters['fields'])) {                    
                
                    $dataProvider = $model->buscarPorFiltros($filters);                    
                    //echo "Total: " . $dataProvider->getItemCount();
                     //si va a guardar
                     if (isset($_POST['save'])){                        
                         
                         //si es nuevo
                         if (isset($_POST['name'])){
                            
                            $filter = Filter::model()->findByAttributes(
                                    array('name' => $_POST['name'], 'type' => '4') //Filtros para ventas
                                    ); 
                            
                            if (!$filter) {
                                $filter = new Filter;
                                $filter->name = $_POST['name'];
                                $filter->type = 4;
                                if ($filter->save()) {
                                    for ($i = 0; $i < count($filters['fields']); $i++) {

                                        $filterDetails[] = new FilterDetail();
                                        $filterDetails[$i]->id_filter = $filter->id_filter;
                                        $filterDetails[$i]->column = $filters['fields'][$i];
                                        $filterDetails[$i]->operator = $filters['ops'][$i];
                                        $filterDetails[$i]->value = $filters['vals'][$i];
                                        $filterDetails[$i]->relation = $filters['rels'][$i];
                                        $filterDetails[$i]->save();
                                    }
                                    
                                    $response['status'] = 'success';
                                    $response['message'] = 'Filtro <b>'.$filter->name.'</b> guardado con éxito';
                                    $response['idFilter'] = $filter->id_filter;                                    
                                    
                                }
                                
                            //si ya existe
                            } else {
                                $response['status'] = 'error';
                                $response['message'] = 'No se pudo guardar el filtro, el nombre <b>"'.
                                        $filter->name.'"</b> ya existe'; 
                            }

                          /* si esta guardadndo uno existente */
                         }else if(isset($_POST['id'])){
                            
                            $filter = Filter::model()->findByPk($_POST['id']); 

                            if ($filter) {
                                
                                //borrar los existentes
                                foreach ($filter->filterDetails as $detail){
                                    $detail->delete();
                                }
                                
                                //Crear los nuevos
                                for ($i = 0; $i < count($filters['fields']); $i++) {

                                    $filterDetails[] = new FilterDetail();
                                    $filterDetails[$i]->id_filter = $filter->id_filter;
                                    $filterDetails[$i]->column = $filters['fields'][$i];
                                    $filterDetails[$i]->operator = $filters['ops'][$i];
                                    $filterDetails[$i]->value = $filters['vals'][$i];
                                    $filterDetails[$i]->relation = $filters['rels'][$i];
                                    $filterDetails[$i]->save();
                                }

                                $response['status'] = 'success';
                                $response['message'] = 'Filtro <b>'.$filter->name.'</b> guardado con éxito';                                
                            //si NO existe el ID
                            } else {
                                $response['status'] = 'error';
                                $response['message'] = 'El filtro no existe'; 
                            }
                             
                         }
                        
                         echo CJSON::encode($response); 
                         Yii::app()->end();
                         
                     }//fin si esta guardando

                //si no hay filtros válidos    
                }else if (isset($_POST['save'])){
                    $response['status'] = 'error';
                    $response['message'] = 'No has seleccionado ningún criterio para filtrar'; 
                    echo CJSON::encode($response); 
                    Yii::app()->end();
                }
            }
            
            if (isset($_POST['buscar_look'])) {
                unset($_SESSION["todoPost"]);
                $model->title = $_POST['buscar_look'];
                $dataProvider = $model->lookAdminAprobar();
            }
            
            $this->render('admin', array('model' => $model,
                'dataProvider' => $dataProvider,
                'look' => $model,
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
				// echo "borrado";
				
				$total = LookEncantan::model()->countByAttributes(array('look_id'=>$_POST['idLook']));
				
				echo CJSON::encode(array( 
					'mensaje'=> 'borrado',
					'total'=> $total
				));
				exit;
				
			}
			else // esta logueado y es un like nuevo
			{
				$encanta = new LookEncantan;
				
				$encanta->look_id = $_POST['idLook'];
				$encanta->user_id = Yii::app()->user->id;
				
				if($encanta->save())
				{
					// echo "ok"; // guardó y le encantó	
					
					$total = LookEncantan::model()->countByAttributes(array('look_id'=>$_POST['idLook']));	
				
					echo CJSON::encode(array(
						'mensaje'=> 'ok',
						'total'=> $total
					));
					exit;

				}
					
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
