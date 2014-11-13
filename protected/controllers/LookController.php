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
				'users'=>Yii::app()->params['registro']?array('@'):array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
                            'actions'=>array('admin','delete','create','categorias',
                                'publicar','admin','detalle','edit','update','create',
                                'publicar','marcas','mislooks','softdelete','descuento',
                                'calcularPrecioDescuento', 'exportarCSV',
                                'plantillaDescuentos', 'importarDescuentos',
                                'enabledLook', 'varias', 'informacion', 'autocomplete'),
                            //'users'=>array('admin'),
                            'expression' => 'UserModule::isAdmin()',
			),
			array('allow', // acciones validas para el personal Shopper
               'actions' => array('create','publicar','precios','categorias','view','colores','edit','marcas','mislooks','detalle','softdelete','listarLooks', 'setVar', 'autocomplete'),
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

                        $dataProvider = $look->buscarPorFiltros($filters, Yii::app()->user->id);                    
                        //echo "Total: " . $dataProvider->getItemCount();
                         //si va a guardar
                         if (isset($_POST['save'])){                        

                             //si es nuevo
                             if (isset($_POST['name'])){

                                $filter = Filter::model()->findByAttributes(
                                                    array('name' => $_POST['name'], 'type' => '5', 'user_id' => Yii::app()->user->id) //Comprobar que no exista el nombre
                                            );

                                if (!$filter) {
                                    $filter = new Filter;
                                    $filter->name = $_POST['name'];
                                    $filter->type = 5;
                                    $filter->user_id = Yii::app()->user->id;
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
                
                	
                if(isset($_POST['buscar_look']))
                {
                    unset($_SESSION["todoPost"]);
                    $look->user_id = Yii::app()->user->id;
                    $look->title = $_POST['buscar_look'];
                    $dataProvider = $look->search();
                }			                                
                
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

	public function actionDescuento($id){
		$model = Look::model()->findByPk($id);
		$model->scenario = 'descuento';

		// si el look tiene prendas externas no se puede aplicar descuento
		if($model->hasProductosExternos()){
			Yii::app()->user->setFlash('error',UserModule::t("Este look no puede tener descuento"));
			$this->redirect(array('admin'));
		}

		if(isset($_POST['Look'])){
			if($_POST['Look']['valorDescuento'] != ''){
				$model->tipoDescuento = $_POST['Look']['tipoDescuento'];
				$model->valorDescuento = $_POST['Look']['valorDescuento'];
				if($model->save()){
					Yii::app()->user->setFlash('success',UserModule::t("Descuento guardado"));
				}else{
					Yii::app()->user->setFlash('error',UserModule::t("No se pudo guardar el descuento"));
				}
				$this->redirect(array('admin')); 
			}else{
				Yii::app()->user->setFlash('error',UserModule::t("Debe ingresar un valor para el descuento"));
			}
		}

		$this->render('descuento',array(
				'model'=>$model,
			)
		);
	}

	public function actionCalcularPrecioDescuento(){
		$model = Look::model()->findByPk($_POST['id']);
		$model->tipoDescuento = $_POST['tipo_descuento'];
		$model->valorDescuento = $_POST['valor_descuento'];
		echo Yii::t('contentForm', 'currSym').' '.$model->getPrecioDescuento();
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
        $look_id = 0;
        if (isset($_GET['id']))
                $look_id = $_GET['id'];
        $ps_id = 0;
        if (isset($_GET['ps_id']))
            $ps_id = $_GET['ps_id'];
        ShoppingMetric::registro(ShoppingMetric::USER_VIEW_LOOK,array('look_id'=>$look_id,'ps_id'=>$ps_id));
		$productoView = new ProductoView;
		$productoView->user_id = Yii::app()->user->id;
		
		$looks = new Look;
		$user = User::model()->findByPk(Yii::app()->user->id);

		// registrar impresión en google analytics
		Yii::app()->clientScript->registerScript('metrica_analytics',"
			ga('ec:addProduct', {               // Provide product details in an productFieldObject.
			  'id': '".$model->id."',                   // Product ID (string).
			  'name': '".addslashes($model->title)."', // Product name (string).
			  'category': 'Looks',   // Product category (string).
			  'brand': 'Personaling',                // Product brand (string).
			});
			
				ga('ec:setAction', 'detail');       // Detail action.
				ga('send', 'pageview');       // Send product details view with the initial pageview.
		");	
		
		 
		$detect = new Mobile_Detect;
			if(($detect->isMobile()||$detect->isTablet())) 
            	$this->render('view_mobile',array(
						'model'=>$model,
						'ultimos_vistos'=> $productoView->lastView(),
						'dataProvider' => $looks->match($user),
						'user'=>$user,	
						//'categorias'=>$categorias,
					) 
				);
			else
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
		$filename = Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->language.'/look/'.$id.'.png'; 	   
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
		//imagefilter($image_p, IMG_FILTER_MEAN_REMOVAL);
		imageinterlace($image_p, 1);
		header("Content-type: image/jpeg");
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($filename)) . ' GMT');
		imagejpeg($image_p, null, 100);
			//readfile($filename);
			//imagepng($src,null,9); // <------ se puso compresion 9 para mejorar la rapides al cargar la imagen
		imagedestroy($src);
		imagedestroy($image_p);			
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
				 	$imagenes[$i]->path = Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->language.'/adorno/'.$ador->path_image;
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
				 	$imagenes[$i]->path = Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->language.'/p70.png';
					$imagenes[$i]->top = 5;
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
			$b_top = 0;
            $b_btm = 0;
            $b_lft = 0;
            $b_rt = 0;
			 switch($ext) { 
			          case 'gif':
			          $src = imagecreatefromgif($image->path);
			          break;
			          case 'jpg':
			          $src = imagecreatefromjpeg($image->path);
			          break;
			          case 'png':
				          $src = imagecreatefrompng($image->path);
				          //top
					        for(; $b_top < imagesy($src); ++$b_top) {
					            for($x = 0; $x < imagesx($src); ++$x) {
					                $color        = imagecolorat($src, $x, $b_top);
					                $transparency = ($color >> 24) & 0x7F;
					                if(!$transparency) {
					                    break 2; //out of the 'top' loop
					                }
					            }
					        }
					
					        //bottom
					        for(; $b_btm < imagesy($src); ++$b_btm) {
					            for($x = 0; $x < imagesx($src); ++$x) {
					                $color        = imagecolorat($src, $x, imagesy($src) - $b_btm-1);
					                $transparency = ($color >> 24) & 0x7F;
					                if(!$transparency) {
					                    break 2; //out of the 'bottom' loop
					                }
					            }
					        }
					
					        //left
					        for(; $b_lft < imagesx($src); ++$b_lft) {
					            for($y = 0; $y < imagesy($src); ++$y) {
					                $color        = imagecolorat($src, $b_lft, $y);
					                $transparency = ($color >> 24) & 0x7F;
					                if(!$transparency) {
					                    break 2; //out of the 'left' loop
					                }
					            }
					        }
					
					        //right
					        for(; $b_rt < imagesx($src); ++$b_rt) {
					            for($y = 0; $y < imagesy($src); ++$y) {
					                $color        = imagecolorat($src, imagesx($src) - $b_rt-1, $y);
					                $transparency = ($color >> 24) & 0x7F;
					                if(!$transparency) {
					                    break 2; //out of the 'right' loop
					                }
					            }
					        }
							//Yii::trace('create a image look, Trace:'.$image->path, 'registro');  
				          break;
			      }			
			$img = imagecreatetruecolor($image->width/$diff_w,$image->height/$diff_h);
			
			imagealphablending( $img, false );
			imagesavealpha( $img, true ); 
    		$pngTransparency = imagecolorallocatealpha($img , 0, 0, 0, 127); 
    		//imagecopyresized($img,$src,0,0,0,0,$image->width/$diff_w,$image->height/$diff_h,imagesx($src), imagesy($src));
			//imagecopyresampled($img,$src,0,0,0,0,$image->width/$diff_w,$image->height/$diff_h,imagesx($src), imagesy($src)); // <----- Se cambio a sampled para mejorar la calidad de las imagenes
			if ($look->id >= 638){
				// para vzla probablemente haya que cambiar esto, los ids no son iguales y algunas imágenes se ven estiradas
                imagecopyresampled($img,$src,0,0,$b_lft, $b_top,imagesx($img), imagesy($img),imagesx($src)-($b_lft+$b_rt), imagesy($src)-($b_top+$b_btm));
                //imagecopyresampled($img,$src,0,0,0,0,$image->width/$diff_w,$image->height/$diff_h,imagesx($src), imagesy($src)); // <----- Se cambio a sampled para mejorar la calidad de las imagenes
            }else{
			    imagecopyresampled($img,$src,0,0,0,0,$image->width/$diff_w,$image->height/$diff_h,imagesx($src), imagesy($src)); // <----- Se cambio a sampled para mejorar la calidad de las imagenes

			}
    		//imagecopyresized($img,$src,0,0,0,0,imagesx($src),imagesy($src),imagesx($src), imagesy($src));
			if ($image->angle){
				//Yii::trace('create a image look,'.$image->angle.' Trace:'.$image->path, 'registro');  	
				$img = imagerotate($img,$image->angle*(-1),$pngTransparency);
			}
			imagecopy($canvas, $img, $image->left/$diff_w, $image->top/$diff_h, 0, 0, imagesx($img), imagesy($img));
		} 
		imagefilter($canvas, IMG_FILTER_MEAN_REMOVAL);
		imageinterlace($canvas, 1);
		header('Content-Type: image/png'); 
		header('Cache-Control: max-age=86400, public');
		imagepng($canvas,Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->language.'/look/'.$look->id.'.png',9);
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
	echo $this->renderPartial('_view_productos',array('productos'=>$productos,'page'=>1,'pages'=>1),true,true);
	
}
public function actionCategorias(){
    $page = (isset($_POST['page']) ? $_POST['page'] : 1);
	$categorias = false;
	if(isset($_POST['padreId'])){
		switch ($_POST['padreId']) {
			case 'Complementos':
				$categoria_padre = Categoria::model()->findByAttributes(array('nombre'=>$_POST['padreId']));
				break;

			case 'Ropa':
				$categoria_padre = Categoria::model()->findByAttributes(array('nombre'=>$_POST['padreId']));
				break;

			case 'Zapatos':
				$categoria_padre = Categoria::model()->findByAttributes(array('nombre'=>$_POST['padreId']));
				break;
			
			default:
				$categoria_padre = Categoria::model()->findByPk($_POST['padreId']);
				break;
		}
	}
	//$categoria_padre = Categoria::model()->findByPk($_POST['padreId']);
	$color = null;
	Yii::app()->clientScript->scriptMap['jquery.js'] = false;
	Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;	
	Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
	Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
	Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;	
	Yii::app()->clientScript->scriptMap['bootstrap-responsive.css'] = false;
	Yii::app()->clientScript->scriptMap['jquery-ui-bootstrap.css'] = false;
	Yii::app()->clientScript->scriptMap['bootstrap.min.css'] = false;	
	Yii::app()->clientScript->scriptMap['bootstrap.min.js'] = false;	
	if ($_POST['padreId']!=0 && $_POST['padreId']!='Complementos' && $_POST['padreId']!='Ropa' && $_POST['padreId']!='Zapatos'){ 
		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>$_POST['padreId']),array('order'=>'nombre ASC'));
	}
	if ($categorias){
		echo $this->renderPartial('_view_categorias',array('categorias'=>$categorias,'categoria_padre'=>$categoria_padre->padreId),true,true);
	}else{
		$with = array();
        $padreId = '';
		if(isset($_POST['padreId'])){
            $padreId = $_POST['padreId'];
			switch ($_POST['padreId']) {
				case 'Complementos':
					$with['categorias'] = array('condition'=>'tbl_categoria_id='.$categoria_padre->id,'together'=>true);
					break;

				case 'Ropa':
					$with['categorias'] = array('condition'=>'tbl_categoria_id='.$categoria_padre->id,'together'=>true);
					break;

				case 'Zapatos':
					$with['categorias'] = array('condition'=>'tbl_categoria_id='.$categoria_padre->id,'together'=>true);
					break;
				
				default:
					if ($_POST['padreId']!=0)
						$with['categorias'] = array('condition'=>'tbl_categoria_id='.$categoria_padre->id,'together'=>true);
					break;
			}
			/*if ($_POST['padreId']!=0)
				$with['categorias'] = array('condition'=>'tbl_categoria_id='.$categoria_padre->id);*/
				//$with['categorias'] = array('condition'=>'tbl_categoria_id='.$_POST['padreId']);
		}
        $colores = "";
		if(isset($_POST['colores'])){
            $colores = $_POST['colores'];
			if ($_POST['colores']!=''){
				//condicion base, el color seleccionado
				$condition = 'color_id='.$_POST['colores'];

				// busco si tiene colores hijos para incluirlos en la búsqueda
				$colores_hijos = Color::model()->findAllByAttributes(array('padreID'=>$_POST['colores']));
				if(sizeof($colores_hijos) > 0){
					foreach ($colores_hijos as $hijo) {
						$condition .= ' OR color_id='.$hijo->id;
					}
				}
				$with['preciotallacolor'] = array('condition'=>$condition,'together'=>true);
				$color = $_POST['colores'];
			}
        }
        $limit = 15;
        $offset = ($page -1) * $limit;
        //$limit = 0;
        $marcas = "";
        $criteria = new CDbCriteria();
        //$with['options'] = array("together"=>true);
        $criteria->with = $with;
        $criteria->offset    = $offset;
        $criteria->limit     = $limit;
		
		if(isset($_POST['marcas']))
		{
			
            $marcas = $_POST['marcas'];
			#Yii::app()->session["igual"]=$_POST['marcas'];
			
			if(Marca::model()->findByAttributes(array('nombre'=>$marcas)))
			{
				$co=Marca::model()->findByAttributes(array('nombre'=>$marcas));
				$_POST['marcas']=$co->id;
			}
			else 
			{
				$_POST['marcas']='Todas las Marcas';
			}

			if ($_POST['marcas']!='Todas las Marcas')	{

               // $productos = Producto::model()->with($with)->noeliminados()->activos()->findAllByAttributes(array('marca_id'=>$_POST['marcas']),$criteria);
                $count_productos = Producto::model()->with($with)->noeliminados()->activos()->countByAttributes(array('marca_id'=>$_POST['marcas']));
                $productos = Producto::model()->with($with)->noeliminados()->activos()->findAllByAttributes(array('marca_id'=>$_POST['marcas']),array('limit'=>$limit,'offset'=>$offset));
            }else{
                //$productos = Producto::model()->with($with)->noeliminados()->activos()->findAll($criteria);
                $count_productos = Producto::model()->with($with)->noeliminados()->activos()->count();
                $productos = Producto::model()->with($with)->noeliminados()->activos()->findAll(array('limit'=>$limit,'offset'=>$offset));
            }
		} else {
			//$productos = Producto::model()->with($with)->noeliminados()->activos()->findAll($criteria);
            $count_productos = Producto::model()->with($with)->noeliminados()->activos()->count();
            $productos = Producto::model()->with($with)->noeliminados()->activos()->findAll(array('limit'=>$limit,'offset'=>$offset));
		}
		$pages = ceil($count_productos/$limit);



        echo $this->renderPartial('_view_productos',array(
            'productos'=>$productos,
            'categoria_padre'=>isset($categoria_padre)?$categoria_padre->padreId:null,
            'categoria'=>$padreId,
            'color'=>$color,
            'page'=>$page,
            'marcas'=>$marcas,
            'colores'=>$colores,
            'pages'=>$pages,
            'space'=>isset($_POST["space"])?$_POST["space"]:null,
        ),true,true);
        /*
        if (isset($categoria_padre))
            echo $this->renderPartial('_view_productos',array('productos'=>$productos,'categoria_padre'=>$categoria_padre->padreId,'categoria'=>$padreId, 'color'=>$color, 'page'=>$page,'marcas'=>$marcas,'colores'=>$colores),true,true);
        else
            echo $this->renderPartial('_view_productos',array('productos'=>$productos,'categoria_padre'=>null,'categoria'=>$padreId, 'color'=>$color,'page'=>$page,'marcas'=>$marcas,'colores'=>$colores),true,true);
        */
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
		 	
		 	echo $this->renderPartial('_view_productos',array('productos'=>$productos,'page'=>1,'pages'=>1),true,true);
		  
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
			
			if(isset($_POST['save_draft']) && $_POST['save_draft'] == 1){
                        		$model->status = Look::STATUS_CREADO;
                            	$model->sent_on = date("Y-m-d H:i:s");
            }else{
				if (Yii::app()->user->isAdmin()){
	                $model->status = Look::STATUS_APROBADO;
	                $model->approved_on = date("Y-m-d H:i:s");
	                
	                if(!$model->sent_on){
	                    $model->sent_on = date("Y-m-d H:i:s");
	                }
                    $this->enviarAprobadoPS($model->user, $model->title);
	                

	            }else{
	            	$model->status = Look::STATUS_ENVIADO;
	                $model->approved_on = date("Y-m-d H:i:s");
	                
	                if(!$model->sent_on){
	                    $model->sent_on = date("Y-m-d H:i:s");
	                }
	            }
            }
			
				
			$model->edadMin=$_POST['Look']['edadMin'];
			$model->edadMax=$_POST['Look']['edadMax'];

			
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

				if(isset($_POST['save_draft']) && $_POST['save_draft'] == 1){
					Yii::app()->user->setFlash('success',UserModule::t("Tu look se ha guardado."));
				}else{
					if (Yii::app()->user->isAdmin())
						Yii::app()->user->setFlash('success',UserModule::t("Tu look se ha publicado."));
					else 	
						Yii::app()->user->setFlash('success',UserModule::t("Tu look se ha enviado."));
	                }
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
			$model->modified_on = date('Y-m-d H:i:s', time());
			$model->scenario = 'draft';
			if(!$model->save()){
				print_r($model->getErrors());
			}
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

				// verificar si tiene productos externos para eliminar descuentos
				if ($model->hasProductosExternos()){
					$model->tipoDescuento = NULL;
					$model->valorDescuento = NULL;
					$model->save();
				}

				/*$model->modified_on = date('Y-m-d H:i:s');
				$model->save();*/
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
	
//            if(!isset(Yii::app()->session["acceptBrowser"])){
//                
//                $browser = get_browser();
//            
//                echo "<pre>";
//                print_r($browser);
//                echo "</pre>";
//                
//                if($browser->)
//            }
            //Yii::app()->end();
            
        if (isset($_GET['id']))
			$model= Look::model()->findByPk($_GET['id']);
		else
			$model=new Look;
		
		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1),array('order'=>'nombre ASC'));	
		//echo $_POST['productos_id'];
		if (isset($_POST['productos_id'])){
			/*$products_count = array_count_values(explode(',',$_POST['productos_id']));
			$repeated = false;
			foreach ($products_count as $key => $value) {
				if($value > 1){
					$repeated = true;
				}
			}

			if($repeated){
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('error',UserModule::t("No puedes incluir prendas repetidas"));	
				
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
			}*/

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
					$criteria->condition = 'activo=1 AND estado = 2 AND "'.date('Y-m-d H:i:s').'" >= recepcion_inicio AND "'.date('Y-m-d H:i:s').'" <= recepcion_fin';
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
			$criteria->condition = 'activo=1 AND estado = 2 AND "'.date('Y-m-d H:i:s').'" > recepcion_inicio AND "'.date('Y-m-d H:i:s').'" < recepcion_fin';
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
                       
            /*Agregar el criteria a la sesion para cuando se pida exportar*/
            Yii::app()->getSession()->add("looksCriteria", $dataProvider->getCriteria());
            
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
        
    public function actionExportarExcel(){
        
        ini_set('memory_limit','256M'); 

        $criteria = Yii::app()->getSession()->get("looksCriteria");
        $arrayLooks = Look::model()->findAll($criteria);

        /*Formato del titulo*/
        $title = array(
	    'font' => array(
	     
	        'size' => 14,
	        'bold' => true,
	        'color' => array(
	            'rgb' => '000000'
	        ),
    	));
        

        Yii::import('ext.phpexcel.XPHPExcel');    
        $objPHPExcel = XPHPExcel::createPHPExcel();

        $objPHPExcel->getProperties()->setCreator("Personaling.com")
                                 ->setLastModifiedBy("Personaling.com")
                                 ->setTitle("Listado de Looks");
        
        // creando el encabezado
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'TITULO')
                    ->setCellValue('C1', 'NRO. ITEMS')
                    ->setCellValue('D1', 'PERSONAL SHOPPER')
                    ->setCellValue('E1', 'PRECIO ('.Yii::t('contentForm', 'currSym').')')
                    ->setCellValue('F1', 'VENDIDOS')
                    ->setCellValue('G1', 'VENTAS '.Yii::t('contentForm', 'currSym'))
                    ->setCellValue('H1', 'ESTADO')
                    ->setCellValue('I1', 'URL');
        
        $colI = 'A';
        $colF = 'I';
        
        //Poner autosize todas las columnas
        foreach(range($colI,$colF) as $columnID) {
            
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            
            $objPHPExcel->getActiveSheet()->getStyle($columnID.'1')->applyFromArray($title);
            
        }
        
        
        //$this->createUrl('look/detalle',array('id'=>$data->id))
        
        //Agregar los looks al documento
        $i = 2;
        foreach ($arrayLooks as $look) {
            //AGregar la fila al documento xls
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.($i) ,$look->id) 
                    ->setCellValue('B'.($i), $look->title)
                    ->setCellValue('C'.($i), $look->countItems())
                    ->setCellValue('D'.($i), $look->user->profile->getNombre())
                    ->setCellValue('E'.($i), $look->getPrecio())
                    ->setCellValue('F'.($i), $look->getLookxStatus(3))
                    ->setCellValue('G'.($i), $look->getMontoVentas())
                    ->setCellValue('H'.($i), $look->getStatus())
                    ->setCellValue('I'.($i), $this->createAbsoluteUrl('look/detalle',array('id'=>$look->id))) ;
            $i++;
        }
        
        $objPHPExcel->setActiveSheetIndex(0);          
        
        // Redirect output to a client's web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Reporte de Looks.xls"');
        header('Cache-Control: max-age=0');
       
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        Yii::app()->end();
	}

	public function actionExportarCSV(){
        
        ini_set('memory_limit','256M'); 

        $criteria = Yii::app()->getSession()->get("looksCriteria");
        $arrayLooks = Look::model()->findAll($criteria);
		header( "Content-Type: text/csv;charset=utf-8" );
		header('Content-Disposition: attachment; filename="Looks.csv"');
		$fp = fopen('php://output', 'w');
        // creando el encabezado
        fputcsv($fp,array(' ID', 'TITULO', 'NRO. ITEMS', 'PERSONAL SHOPPER', utf8_decode('PRECIO ('.Yii::t('contentForm', 'currSym').')')
                , 'VENDIDOS', utf8_decode('VENTAS '.Yii::t('contentForm', 'currSym')), 'ESTADO', 'URL'),";",'"');
 
        foreach ($arrayLooks as $look) {
            //AGregar la fila al documento xls
            $vals=array(	$look->id,
            				utf8_decode($look->title),
            				$look->countItems(),
            				utf8_decode($look->user->profile->getNombre()),
            				$look->getPrecio(), $look->getLookxStatus(3),
            				$look->getMontoVentas(), $look->getStatus(),
            				$this->createAbsoluteUrl('look/detalle',array('id'=>$look->id))) ;
			fputcsv($fp,$vals,";",'"');
           
        }
        
       	fclose($fp); 
		ini_set('memory_limit','128M'); 
		Yii::app()->end();
	}

        
   	public function actionPlantillaDescuentos(){
        
        ini_set('memory_limit','256M'); 

        $criteria = Yii::app()->getSession()->get("looksCriteria");
        $arrayLooks = Look::model()->findAll($criteria);

        /*Formato del titulo*/
        $title = array(
	    'font' => array(
	     
	        'size' => 14,
	        'bold' => true,
	        'color' => array(
	            'rgb' => '000000'
	        ),
    	));
        

        Yii::import('ext.phpexcel.XPHPExcel');
        $objPHPExcel = XPHPExcel::createPHPExcel();

        $objPHPExcel->getProperties()->setCreator("Personaling.com")
                                 ->setLastModifiedBy("Personaling.com")
                                 ->setTitle("Listado de Looks");
        
        // creando el encabezado
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'CÓDIGO')
                    ->setCellValue('B1', 'PRECIO PRODUCTOS')
                    ->setCellValue('C1', 'PRECIO PRODUCTOS CON DESCUENTO')
                    ->setCellValue('D1', '% DESCUENTO ADICIONAL')
                    ->setCellValue('E1', 'PRECIO TOTAL');
        
        $colI = 'A';
        $colF = 'E';
        
        //Poner autosize todas las columnas
        foreach(range($colI,$colF) as $columnID) {
            
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
            
            $objPHPExcel->getActiveSheet()->getStyle($columnID.'1')->applyFromArray($title);
            
        }
        
        
        //$this->createUrl('look/detalle',array('id'=>$data->id))
        
        //Agregar los looks al documento
        $i = 2;
        foreach ($arrayLooks as $look) {
            //AGregar la fila al documento xls
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.($i), $look->id) 
                    ->setCellValue('B'.($i), $look->getPrecioProductosFull())
                    ->setCellValue('C'.($i), $look->getPrecioProductosDescuento())
                    ->setCellValue('D'.($i), $look->getPorcentajeDescuento())
                    ->setCellValue('E'.($i), $look->getPrecioDescuento());
            $i++;
        }
        
        $objPHPExcel->setActiveSheetIndex(0);          
        
        // Redirect output to a client's web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Descuentos Looks.xls"');
        header('Cache-Control: max-age=0');
       
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        Yii::app()->end();
	}




	




	// importar descuentos masivos desde excel
	public function actionImportarDescuentos()
	{
            $total_prod = 0;
            $total = 0;
            $actualizar = 0;
            $tabla = "";
            $totalInbound = 0;
            $actualizadosInbound = 0;

            if (isset($_POST['valido'])) { // enviaron un archivo

                /*Primer paso - Validar el archivo*/
                if(isset($_POST["validar"])){
                    
                    $archivo = CUploadedFile::getInstancesByName('validar');
                    
                    //Guardarlo en el servidor para luego abrirlo y revisar
                    
                    if (isset($archivo) && count($archivo) > 0) {
                        foreach ($archivo as $arc => $xls) {
                            $nombre = Yii::getPathOfAlias('webroot') . '/docs/xlsDescuentosLooks/' . "Temporal";//date('d-m-Y-H:i:s', strtotime('now'));
                            $extension = '.' . $xls->extensionName;                     

                            if ($xls->saveAs($nombre . $extension)) {

                            } else {
                                Yii::app()->user->updateSession();
                                Yii::app()->user->setFlash('error', UserModule::t("Error al cargar el archivo."));
                                $this->render('importar_descuentos', array(
                                    'tabla' => $tabla,
                                    'total' => $total,
                                    'actualizar' => $actualizar,
                                    'totalInbound' => $totalInbound,
                                    'actualizadosInbound' => $actualizadosInbound,
                                ));
                                Yii::app()->end();
                            }
                        }
                    }                    
                    
                    //Si no hubo errores
                    if(is_array($resValidacion = $this->validarArchivo($nombre . $extension))){
                        
                        Yii::app()->user->updateSession();
                        Yii::app()->user->setFlash('success', "Éxito! El archivo no tiene errores.
                                                    Puede continuar con el siguiente paso.<br><br>
                                                    Este archivo contiene <b>{$resValidacion['nLooks']}
                                                    </b> looks.");                    
                    }                    
                    
                    $this->render('importar_descuentos', array(
                        'tabla' => $tabla,
                        'total' => $total,
                        'actualizar' => $actualizar,
                        'totalInbound' => $totalInbound,
                        'actualizadosInbound' => $actualizadosInbound,
                    ));
                    Yii::app()->end();

                //Segundo paso - Subir el Archivo
                }
                else if(isset($_POST["cargar"])){
                    
                    $archivo = CUploadedFile::getInstancesByName('url');
                           
                    if (isset($archivo) && count($archivo) > 0) {
                        $nombreTemporal = "Archivo";
                        $rutaArchivo = Yii::getPathOfAlias('webroot').'/docs/xlsDescuentosLooks/';
                        foreach ($archivo as $arc => $xls) {

                            $nombre = $rutaArchivo.$nombreTemporal;
                            $extension = '.' . $xls->extensionName;
                            
                            if ($xls->saveAs($nombre . $extension)) {
                                
                            } else {
                                Yii::app()->user->updateSession();
                                Yii::app()->user->setFlash('error', UserModule::t("Error al cargar el archivo."));
                                $this->render('importar_descuentos', array(
                                    'tabla' => $tabla,
                                    'total' => $total,
                                    'actualizar' => $actualizar,
                                    'totalInbound' => $totalInbound,
                                    'actualizadosInbound' => $actualizadosInbound,
                                ));
                                Yii::app()->end();
                                
                            }
                        }
                    }
                    
                    // ==============================================================================

                    // Validar (de nuevo)
                    if( !is_array($resValidacion = $this->validarArchivo($nombre . $extension)) ){
                        
                        // Archivo con errores, eliminar del servidor
                        unlink($nombre . $extension);
                        
                        $this->render('importar_descuentos', array(
                            'tabla' => $tabla,
                            'total' => $total,
                            'actualizar' => $actualizar,
                            'totalInbound' => $totalInbound,
                            'actualizadosInbound' => $actualizadosInbound,
                        ));
                        Yii::app()->end();
                    }
                    
                    // Si pasa la validacion
                    $sheet_array = Yii::app()->yexcel->readActiveSheet($nombre . $extension);
                    $errores = '';
                   
                    // segundo foreach, si llega aqui es para insertar y todo es valido
                    foreach ($sheet_array as $row) {
                        
                        if ($row['A'] != "" && $row['A'] != "CÓDIGO") { // para que no tome la primera ni vacios
                            
                            //Modificaciones a las columnas
                            //antes de procesarlas                            
                            //Transformar los datos numericos
                            $row['B'] = str_replace(",", ".", $row['B']);
                            $row['C'] = str_replace(",", ".", $row['C']);
                            $row['D'] = str_replace(",", ".", $row['D']); 
                            $row['E'] = str_replace(",", ".", $row['E']); 
                            
                            $look = Look::model()->findByPK($row['A']);
                            if($look){
                            	if(!$look->hasProductosExternos()){
	                            	$look->scenario = 'descuentosMasivos';
	                            	if($row['D'] > 0){
		                            	$look->tipoDescuento = 0;
		                            	$look->valorDescuento = $row['D'];
		                            }else{
		                            	$look->tipoDescuento = NULL;
		                            	$look->valorDescuento = NULL;
		                            }
	                            	//$look->save();
	                            	if(!$look->save()){
	                            		foreach ($look->getErrors() as $key => $value) {
	                            			$errores .= $value;
	                            		}
	                            	}
                            	}
                            }
                            
                            $anterior = $row;
                            
                        } 
                        
                    }// foreach
                    
                    $mensajeSuccess = "Se ha cargado con éxito el archivo.<br>";
                    Yii::app()->user->setFlash("success", $mensajeSuccess.$errores);                                   
                }
            }// isset

            $this->render('importar_descuentos', array(
                'tabla' => $tabla,
                'total' => $total,
                'actualizar' => $actualizar,
                'totalInbound' => $totalInbound,
                'actualizadosInbound' => $actualizadosInbound,
            ));

	}

	public function actionListarLooks(){
		$criteria = new CDbCriteria;
		$criteria->compare('user_id', Yii::app()->user->id, true);

    	$total = Look::model()->count($criteria);
    	$pages = new CPagination($total);
       // $pages->pageSize = 9;
        $pages->setPageSize(9);
        $pages->applyLimit($criteria);
        $looks = Look::model()->findAll($criteria);
       // echo $total.'total';
        //echo $pages->pageSize."pagesize";
    	if (!isset($_GET['page'])){
            $this->render('listar_looks', array(
                'looks' => $looks,
                'pages'=>$pages,
            ));
        } else {
            echo $this->renderPartial('_look', array('looks' => $looks,
                'pages' => $pages,), true, true);
        }
    }

	protected function validarArchivo($archivo){
            
        $sheet_array = Yii::app()->yexcel->readActiveSheet($archivo);

        $falla = "";
        $erroresCodigos = "";
        $erroresPrecioFullIva = "";
        $erroresPrecioDescuentoIva = "";
        $erroresPorcentaje = "";
        $erroresPrecioDescuento = "";
        $erroresColumnasVacias = "";
        $erroresPrecioProcentaje = "";
        $erroresDescuentosExternos = "";
        

        $linea = 1;
        $lineaProducto = 0;

        //Revisar cada fila de la hoja de excel.
        foreach ($sheet_array as $row) {

            if ($row['A'] != "") {

                if ($linea == 1) { // revisar los nombres / encabezados de las columnas
                    if ($row['A'] != "CÓDIGO")
                        $falla = "CÓDIGO";
                    else if ($row['B'] != "PRECIO PRODUCTOS")
                        $falla = "PRECIO PRODUCTOS CON IVA";
                    else if ($row['C'] != "PRECIO PRODUCTOS CON DESCUENTO")
                        $falla = "PRECIO PRODUCTOS SIN IVA";
                    if ($row['D'] != "% DESCUENTO ADICIONAL")
                        $falla = "% DESCUENTO ADICIONAL";
                    else if ($row['E'] != "PRECIO TOTAL")
                        $falla = "PRECIO TOTAL";

                    if ($falla != "") { // algo falló :O
                        Yii::app()->user->updateSession();
                        Yii::app()->user->setFlash('error', UserModule::t("La columna <b>" .
                                        $falla . "</b> no se encuentra en el lugar que debe ir o está mal escrita"));                                   

                        return false;
                    }
                }

                /*si pasa las columnas entonces que revise
                Código, porcentaje de descuento y precio descuento*/                          
                if($linea > 1){
                    
                    $row['B'] = str_replace(",", ".", $row['B']);
                    $row['C'] = str_replace(",", ".", $row['C']);
                    //php cont$row['D'] = str_replace(",", ".", $row['D']);
                    $row['E'] = str_replace(",", ".", $row['E']);
                    
                    /*Columnas Vacias*/
                    foreach ($row as $col => $valor){
                        if($col != 'D'){
                        if(!isset($valor) || $valor == ""){
                            $erroresColumnasVacias.= "<li> Columna: <b>" . $col .
                                    "</b>, en la línea <b>" . $linea."</b></li>";
                        }
                        }
                        
                        if($col == "E"){
                            break;
                        }
                    }

                    //Código
                    if (isset($row['A']) && $row['A'] != "") {                        
                        $look = Look::model()->findByPk($row["A"]);

                        if (isset($look)) { // valido que el look no contenga productos de catálogo de terceros
                            if($look->hasProductosExternos()){
                            	$erroresDescuentosExternos .= "<li> <b>" . $row['A'] . "</b>, en la línea <b>" . $linea."</b></li>";
                            }
                        }else{
                        	$erroresCodigos .= "<li> <b>" . $row['A'] . "</b>, en la línea <b>" . $linea."</b></li>";
                        }
                    }                    
                    
                    //Precio venta full con iva
                    if(isset($row['B']) && $row['B'] != "" && !is_numeric($row['B'])){
                        $erroresPrecioFullIva = "<li> <b>" . $row['B'] . "</b>, en la línea <b>" . $linea."</b></li>";                                                        
                    }

                    //Precio descuento con iva
                    if(isset($row['C']) && $row['C'] != "" && !is_numeric($row['C'])){
                        $erroresPrecioDescuentoIva = "<li> <b>" . $row['C'] . "</b>, en la línea <b>" . $linea."</b></li>";                                                        
                    }
                    
                    //Porcentaje
                    if(isset($row['D']) && !is_numeric($row['D'])){
                        $erroresPorcentaje .= "<li> <b>" . $row['D'] . "</b>, en la línea <b>" . $linea."</b></li>";   
                                                                           
                    }
                    //No permitir decimales para el porcentaje
                    if (strpos($row['D'], '.') !== FALSE){
                    	$erroresPorcentaje .= "<li> <b>" . $row['D'] . "</b>, en la línea <b>" . $linea."</b></li>";   
                    }  
                    //Precio Descuento
                    if(isset($row['E']) && $row['E'] != "" && !is_numeric($row['E'])){
                        $erroresPrecioDescuento = "<li> <b>" . $row['E'] . "</b>, en la línea <b>" . $linea."</b></li>";                                                        
                    }

                    // comprobar que el porcentaje y el precio final con descuento coincidan, esto en realidad no importa pero ellas lo quieren, si falla y jode mucho solo se quita este bloque
                    if(floatval($row['D'] > 0)){
                    	//$precio_con_descuento = $row['C']-($row['C']*($row['D']/100));
                    	$precio_con_descuento = $row['E'];
                    	//$iva = $precio_con_descuento*0.21;
                    	//$precio_total = $precio_con_descuento + $iva;
                    	$precio_total = $precio_con_descuento;
                    	$precio_formato = Yii::app()->numberFormatter->format("#,##0.00",$precio_total);
                    	$precio_formato = str_replace(",", ".", $precio_formato);
	                    //$precio_calculado = Yii::app()->numberFormatter->format("#,##0.00",$row['B']-($row['B']*($row['D']/100)));

	                    if($precio_formato != floatval($row['E'])){
	                   		$erroresPrecioProcentaje .= "<li> El precio final (".$row['E'].") y el porcentaje (".$row['D'].") no coinciden en la línea <b>" . $linea."</b></li>";
	                    }
                    }
                    
                    
                
                    //sumar solo si la linea tiene algo
                    //y si esta por encima de la fila 1 (header)
                    $lineaProducto++;
                }
                
            }

            $linea++;
        }
        

        //Si hubo errores en marcas, cat, tallas, colores
        if($erroresColumnasVacias != ""){
            $erroresColumnasVacias = "Las siguientes Columnas están vacías:<br><ul>
                             {$erroresColumnasVacias}
                             </ul><br>";
        }
        if($erroresCodigos != ""){
            $erroresCodigos = "Los siguientes Looks no existen en la plataforma o están mal escrit0s:<br><ul>
                             {$erroresCodigos}
                             </ul><br>";
        }
        
        
        if($erroresPrecioFullIva != ""){
            $erroresPrecioFullIva = "Los siguientes Precios están mal escritos, recuerde usar un solo punto (.) o coma (,):<br><ul>
                             {$erroresPrecioFullIva}
                             </ul><br>";
        }
        if($erroresPrecioDescuentoIva != ""){
            $erroresPrecioDescuentoIva = "Los siguientes Precios están mal escritos, recuerde usar un solo punto (.) o coma (,):<br><ul>
                             {$erroresPrecioDescuentoIva}
                             </ul><br>";
        }
        if($erroresPorcentaje != ""){
            $erroresPorcentaje = "Los siguientes porcentajes están mal escritos (no se permiten decimales):<br><ul>
                             {$erroresPorcentaje}
                             </ul><br>";
        }
        if($erroresPrecioDescuento != ""){
            $erroresPrecioDescuento = "Los siguientes Precios están mal escritos, recuerde usar un solo punto (.) o coma (,):<br><ul>
                             {$erroresPrecioDescuento}
                             </ul><br>";
        }
        if($erroresPrecioProcentaje != ""){
            $erroresPrecioProcentaje = "Algunos precios no coinciden:<br><ul>
                             {$erroresPrecioProcentaje}
                             </ul><br>";
        }
        if($erroresDescuentosExternos != ""){
            $erroresDescuentosExternos = "Los siguientes Looks no pueden tener descuento porque contienen productos de catálogo de terceros:<br><ul>
                             {$erroresDescuentosExternos}
                             </ul><br>";
        }

            
        $errores = $erroresColumnasVacias .$erroresCodigos . $erroresPrecioFullIva .
                $erroresPrecioDescuentoIva. $erroresPorcentaje . $erroresPrecioDescuento. $erroresPrecioProcentaje . $erroresDescuentosExternos;
        
        if($errores != ""){
            
            Yii::app()->user->updateSession();
            Yii::app()->user->setFlash('error', $errores);

            return false;                
        } 
        
        return array(
            "valid"=>true,
            "nLooks"=>$lineaProducto,
            "nLineas"=>$linea-2,
            );            
    }
    
    public function actionEnabledLook($id)
	{
		$model = Look::model()->findByPk($id);
		
		if($model->activo=="0")
		{
			$model->activo=1;
			Yii::app()->user->setFlash('success', 'Look Activado');
		}
		else
		{
			$model->activo=0;	
			Yii::app()->user->setFlash('success', 'Look Desactivado');
		}
		$model->scenario="enabledLook";
		
		if(!$model->save())
			Yii::app()->user->setFlash('error', 'Look no ha sido guardado.');
		
		$this->redirect(array('look/admin'));
		
	}
	
	public function actionVarias()
	{            
		$result = array();
		if($_POST['check']!=""){
			
			$checks = explode(',',$_POST['check']);
			$accion = $_POST['accion'];	
		
			if($accion=="Acciones")
			{
				//echo("2"); // no selecciono una accion
				$result['status'] = "2";
			}
			else if($accion=="Activar")
			{
				foreach($checks as $id){
					$model = Look::model()->findByPk($id);
					$model->activo=1;
					Look::model()->updateByPk($id, array('activo'=>'1'));	
				}
				$result['status'] = "3";
			}
			else if($accion=="Inactivar")
			{
				foreach($checks as $id){
					$model = Look::model()->findByPk($id);
					$model->activo=0;
					Look::model()->updateByPk($id, array('activo'=>'0'));
		
				}				
				$result['status'] = "4";
			}
             else if($accion=="Destacar")
            {
                foreach($checks as $id){
                    $model = Look::model()->findByPk($id);
                    $model->destacado=1;
                    Look::model()->updateByPk($id, array('destacado'=>'1'));

                }
                $result['status'] = "5";
            }
            else if($accion=="Quitar Destacado")
            {
                foreach($checks as $id){
                    $model = Look::model()->findByPk($id);
                    $model->destacado=0;
                    Look::model()->updateByPk($id, array('destacado'=>'0'));

                }
                $result['status'] = "6";
            } 
		}
		else {
			//echo("1"); // no selecciono checks
			$result['status'] = "1";
		}
		echo CJSON::encode($result);
	}
        
        
        public function actionInformacion($id) {
            
            $look = Look::model()->findByPk($id);
            
            $this->render("informacion", array(
                'look' => $look,
            ));
        } 
		
		public function actionSetVar() 
		{
			if (isset($_POST['id'])) 
			{
				$id=$_POST['id']; 
				$look = Look::model()->findByPk($id);
				echo Yii::app()->getBaseUrl(true)."/l/".$look->encode_url("123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ");
			}
			Yii::app()->end();
		}   
        
       function enviarAprobadoPS($user,$lookName) {
            
            $message = new YiiMailMessage;
            //Opciones de Mandrill
            $message->activarPlantillaMandrill();            
            $subject = 'Cambio de status de Look';
            
            $body = Yii::t('contentForm', "<div style='font-size:14px'><p><b>Genial!</b></p>
                <br>                    
                 <br>
                 Tu look <b style='font-size:18px'>{$lookName}</b> ha sido aprobado y está listo 
                 para ser compartido en tus redes sociales, 
                 que todos se enteren de tu talento como Personal Shopper!</div><br>                    
                 <br>");                    
                     
            $destinatario = $user->email;                 
            //$destinatario = "cruiz@upsidecorp.ch";  
            $message->subject = $subject;
            $message->setBody($body, 'text/html');
            $message->addTo($destinatario);
            Yii::app()->mail->send($message);
        }

		public function actionAutocomplete()
		{
	    	$res =array();
	    	if (isset($_GET['term'])) 
			{
				$qtxt ="SELECT nombre FROM tbl_marca WHERE nombre LIKE :nombre";
				$command =Yii::app()->db->createCommand($qtxt);
				$command->bindValue(":nombre", '%'.$_GET['term'].'%', PDO::PARAM_STR);
				$res =$command->queryColumn();
	    	}
	     	echo CJSON::encode($res);
	    	Yii::app()->end();
		}
        
        public function actionUpdateAvailability(){
            $looks=Look::model()->findAllByAttributes(array('activo'=>1));
            foreach($looks as $look){
                $look->updateAvailability();
            }
        }

}
