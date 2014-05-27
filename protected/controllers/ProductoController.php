<?php

class ProductoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

	/**
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
				'actions'=>array('index','view','detalle','tallas','tallaspreview','colorespreview','colores','imagenColor','updateCantidad','encantar'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('getImage'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','update','suprimir','admin',
                                    'delete','precios','producto','imagenes','multi',
                                    'orden','eliminar','inventario','detalles',
                                    'tallacolor','addtallacolor','varias','categorias',
                                    'recatprod','seo','importar'
				,'reporte','reportexls', "createExcel"),
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
	
	public function actionReporte()
	{ 
   
		
		if(!isset($_GET['data_page'])){
			
			if(isset(Yii::app()->session['idMarca']))
				unset(Yii::app()->session['idMarca']);
		}
		
		if(isset($_POST['marcaId'])){
			Yii::app()->session['idMarca']=$_POST['marcaId'];

		}
	
	
			

	
			
			$dataProvider = Preciotallacolor::model()->existencia();
		
		
		//$orden->user_id = Yii::app()->user->id;
		
		$marcas=Marca::model()->getAll();
		$this->render('reporte',
		array(
		'dataProvider'=>$dataProvider,'marcas'=>$marcas
		));


	}


public function actionReportexls(){
	
	$title = array(
    'font' => array(
     
        'size' => 14,
        'bold' => true,
        'color' => array(
            'rgb' => '000000'
        ),
    ),
   /*'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => '6D2D56',
        ),
    ),*/
);

		Yii::import('ext.phpexcel.XPHPExcel');    
	
		$objPHPExcel = XPHPExcel::createPHPExcel();
	
		$objPHPExcel->getProperties()->setCreator("Personaling.com")
		                         ->setLastModifiedBy("Personaling.com")
		                         ->setTitle("Reporte-inventario")
		                         ->setSubject("Reporte de Inventario")
		                         ->setDescription("Reporte de Productos en existencia")
		                         ->setKeywords("personaling")
		                         ->setCategory("personaling");

			// creando el encabezado
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A1', 'SKU')
						->setCellValue('B1', 'Referencia')
						->setCellValue('C1', 'Marca')
						->setCellValue('D1', 'Nombre')
						
						->setCellValue('E1', 'Color')
						->setCellValue('F1', 'Talla')
						->setCellValue('G1', 'Cantidad')
						->setCellValue('H1', 'Costo (Bs)')
						->setCellValue('I1', 'Precio de Venta sin IVA (Bs)')
						->setCellValue('J1', 'Precio de Venta con IVA (Bs)');
			// encabezado end			
		 	
			foreach(range('A','I') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}  
			 
			
		 	$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($title);
			$objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($title);

		 	
		 	
		 	//Eliminar filtrado por marca antes de consultar
		 	/*$fake=false;
		 	if(isset(Yii::app()->session['idMarca'])){
		 		$marca=Yii::app()->session['idMarca'];
		 		$fake=true;
		 		unset(Yii::app()->session['idMarca']);
		 	}*/
			//fin			
		 	
		 	
		 	$ptc = Preciotallacolor::model()->existencia(false); 
		 	$fila = 2;
		
			
			//Reestablecer filtrado por marca si existia
			/*if($fake)
				Yii::app()->session['idMarca']=$marca;*/
		 	//fin	 
		 
		 	foreach($ptc->getData() as $data)
			{
					//Buscando los precios si los productos se vendieron en un look o dejando los de ordenhasptc
             
                    $I=number_format($data['Precio'],2,',','.'); 
                    $J=number_format($data['pIVA'],2,',','.');


					$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$fila , $data['SKU']) 
							->setCellValue('B'.$fila , $data['Referencia']) 							
							->setCellValue('C'.$fila , $data['Marca']) 
							->setCellValue('D'.$fila , $data['Nombre'])
							
							->setCellValue('E'.$fila , $data['Color'])
							->setCellValue('F'.$fila , $data['Talla']) 
							->setCellValue('G'.$fila , $data['Cantidad']) 
							->setCellValue('H'.$fila , number_format($data['Costo'],2,',','.')) 
							->setCellValue('I'.$fila , trim($I))							
							->setCellValue('J'.$fila , trim($J));
					$fila++;

			} // foreach
		 
			// Rename worksheet
	
			$objPHPExcel->setActiveSheetIndex(0);

			// Redirect output to a clientâ€™s web browser (Excel5)
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="ReporteInventario.xls"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');
		 
			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0
		 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			Yii::app()->end();
				  
	}
	
	
	
	
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$this->pageTitle = 'Personaling - '.$model->nombre;
    	$this->pageDesc = $model->descripcion;
		$this->display_seo();
		$view = new ProductoView;
		$view->producto_id = $id;
		$view->user_id = Yii::app()->user->id;
		if (!$view->save())
			Yii::trace('ProductoController.php:62, Error:'.print_r($view->getErrors(), true), 'registro');
		//$this->registerSEO($model);
		$this->render('view',array(
			'model'=>$model,
		));
	}
	public function actionUpdateCantidad()
	{
		$prenda = explode('_',$_POST['prenda']);
		$model = Producto::model()->findByPk($prenda[0]);
		
		echo CJSON::encode(array(
                        'status'=>'success', 
                        'div'=>$model->getCantidad($_POST['talla'],$prenda[1]),
                        'id'=>'cantidad'.$_POST['prenda'],
                        ));		
	}
	public function actionGetImage($id)
	{
		//$start = microtime(true);	
			
		//echo $inicio = $time = microtime();
		//echo "0"."<br>";	
		
		
		
		$model = $this->loadModel($id);
		
		//$time_taken = microtime(true) - $start;
		//echo $time_taken."<br>";
		
		$image_url = $model->getImageUrl($_GET['color_id'],array('type'=>'thumb','ext'=>'png','baseUrl'=> true ));
		
		//$time_taken = microtime(true) - $start;
		//echo $time_taken."<br>";
		
		list($width, $height, $type, $attr) = getimagesize(Yii::getPathOfAlias('webroot').$model->getImageUrl($_GET['color_id'],array('type'=>'thumb','ext'=>'png','baseUrl'=> false )));	
		
		
		 
		/*
		$SQL="Select * from tbl_imagen where tbl_producto_id = '$id' and color_id= '".$_GET['color_id']."' and orden=1";
		
		//$time_taken = microtime(true) - $start;
		//echo $time_taken."<br>";
		
		$list= Yii::app()->db->createCommand('select url from tbl_imagen where tbl_producto_id=:tbl_producto_id and color_id=:color_id')->bindValue('tbl_producto_id',$id)->bindValue('color_id',$_GET['color_id'])->queryAll();
		//$time_taken = microtime(true) - $start;
		//echo $time_taken."<br>";
		$image_url = Yii::app()->baseUrl.str_replace(".","_thumb.",$list[0]["url"]);
		//$time_taken = microtime(true) - $start;
		//echo $time_taken."<br>";
		list($width, $height, $type, $attr) = getimagesize(Yii::getPathOfAlias('webroot').str_replace(".","_thumb.",$list[0]["url"]));	
		
		//$time_taken = microtime(true) - $start;
		//echo $time_taken."<br>";
		*/ 		
		//echo $time = microtime()-$time."<br>";
		echo '<div class="new" id="div'.$id.'_'.$_GET['color_id'].'">';
		//echo $time = microtime()-$time."<br>";
		echo '<img '.$attr.' src="'.$image_url.'" alt>';
		//echo $time = microtime()-$time."<br>";
		echo '<input type="hidden" name="producto_id" value="'.$id.'">';
		//echo $time = microtime()-$time."<br>";
		echo '<input type="hidden" name="color_id" value="'.$_GET['color_id'].'">';
		//echo $time = microtime()-$time."<br>";
		echo '</div>';
		//echo $time = microtime()-$time."<br>";
		//echo microtime()-$inicio;
		//$time_taken = microtime(true) - $start;
		//echo $time_taken."<br>";
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

		}
		else {
			$model=new Producto;	
		}
		
// si es un producto nuevo viene así
		if(isset($_POST['Producto']))
		{
			$exist = Producto::model()->findByAttributes(array('codigo'=>$_POST['Producto']['codigo']));
			
			if(isset($exist)) // si existe
			{
				 Producto::model()->updateByPk($exist->id, array(
				 	'nombre' => $_POST['Producto']['nombre'],
				 	'marca_id'=>$_POST['marcas'],
				 	'descripcion'=>$_POST['Producto']['descripcion'],
				 	'estado'=>$_POST['Producto']['estado'],
				 	'fInicio'=>$_POST['Producto']['fInicio'],
					'fFin'=>$_POST['Producto']['fFin'],
					'destacado' => $_POST['Producto']['destacado'],
					'peso' => $_POST['Producto']['peso'],
					'almacen' => $_POST['Producto']['almacen'],
					'temporada' => $_POST['Producto']['temporada']
					));
					
					Yii::app()->user->updateSession();
					Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
					
					if($_POST['accion'] == "normal") // si es el boton principal
						$this->redirect(array('create','id'=>$exist->id));
					
					if($_POST['accion'] == "avanzar") // guardar y avanzar
						$this->redirect(array('precios','id'=>$exist->id));
					
					if($_POST['accion'] == "nuevo") // guardar y nuevo
						$this->redirect(array('create'));
					
					if($_POST['accion'] == "siguiente") // guardar y siguiente
						$this->redirect(array('create','id'=>$_POST['id_sig']));
					
			}
			else // nuevo
			{
				$model->attributes = $_POST['Producto'];
				$model->destacado = $_POST['Producto']['destacado'];
				$model->peso = $_POST['Producto']['peso'];
				$model->marca_id = $_POST['marcas'];
				$model->status=1;
				$model->almacen = $_POST['Producto']['almacen'];
				$model->temporada = $_POST['Producto']['temporada'];
				if($model->save())
				{
					Yii::app()->user->updateSession();
					Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
					
					if($_POST['accion'] == "normal") // si es el boton principal
						$this->redirect(array('create','id'=>$model->id));
					
					if($_POST['accion'] == "avanzar") // guardar y avanzar
						$this->redirect(array('precios','id'=>$model->id));
					
					if($_POST['accion'] == "nuevo") // guardar y nuevo
						$this->redirect(array('create'));
					
					
				}
			}
	
	}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionSeo()
	{
		if(isset($_GET['id'])){
			
			$id = $_GET['id'];
			
			if(!$seo = Seo::model()->findByAttributes(array('tbl_producto_id'=>$id)))
				$seo=new Seo;
			
			$model = Producto::model()->findByPk($id);
		}
		else {
			$seo = new Seo;
			$model = new Producto;
			$id="";
		}


		if(isset($_POST['Seo']))
		{
			$seo->attributes=$_POST['Seo'];
			
			if($id==""){
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('error',UserModule::t("No es posible almacenar los datos SEO si aún no se ha creado el producto."));
			}			
			else{
							
				$seo->tbl_producto_id = $id;
				
				if($seo->save())
				{
					Yii::app()->user->updateSession();
					Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
					
					if($_POST['accion'] == "normal"){ // si es el boton principal
						//$this->render('_view_seo',array('model'=>$model,'seo'=>$seo,));
						$this->redirect(array('seo', 'id'=>$id));
					}else if($_POST['accion'] == "nuevo"){ // guardar y nuevo
						$this->redirect(array('create'));
					}else if($_POST['accion'] == "siguiente"){ // guardar y siguiente
						$this->redirect(array('create','id'=>$_POST['id_sig']));
					}
					
				}
				//	$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('_view_seo',array('model'=>$model,'seo'=>$seo,));
	}

	//acceso para la pestaña de precios
	public function actionPrecios()
	{

		if(isset($_GET['id'])){
			
			$id = $_GET['id'];
			
			if(!$precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$id)))
				$precio=new Precio;
			
			$model = Producto::model()->findByPk($id);
		}
		else {
			$precio = new Precio;
			$model = new Producto;
			$id="";
		}


		if(isset($_POST['Precio']))
		{
			$precio->attributes=$_POST['Precio'];
			$precio->ganancia=$_POST['Precio']['ganancia'];
			$precio->gananciaImpuesto=$_POST['Precio']['gananciaImpuesto'];
			
			if($id==""){
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('error',UserModule::t("No es posible almacenar los precios si aún no se ha creado el producto."));
			}			
			else{
							
				$precio->tbl_producto_id = $id;
				
				if($precio->save())
				{
					
					Yii::app()->user->updateSession();
					Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
						
					if($_POST['accion'] == "normal") // si es el boton principal
						$this->render('_view_precios',array('model'=>$model,'precio'=>$precio,));
					
					if($_POST['accion'] == "avanzar") // guardar y avanzar
						$this->redirect(array('categorias','id'=>$model->id));

				}
				
			}
		}

		$this->render('_view_precios',array(
			'model'=>$model,'precio'=>$precio,
		));
	}

	
	// mostrar la pagina
	public function actionImagenes()
	{
		if(isset($_GET['id'])){
			
			$id = $_GET['id'];
			
			if(!$imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$id)))
				$imagen = new Imagen;
			
			$model = Producto::model()->findByPk($id);
			
		}
		else {
			$imagen = new Imagen;
			$model = new Producto;
			$id="";
		}
		
		// revisa si tiene o no un id
		if($id==""){
			Yii::app()->user->updateSession();
			Yii::app()->user->setFlash('error',UserModule::t("No es posible almacenar imágenes si aún no se ha creado el producto."));
		}else{

			if(isset($_POST['Imagen']))
			{
					Yii::app()->user->updateSession();
					Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
					
					if($_POST['accion'] == "normal") // si es el boton principal
						$this->render('_view_imagenes',array('model'=>$model,'imagen'=>$imagen,));
					
					if($_POST['accion'] == "avanzar") // guardar y avanzar
						$this->redirect(array('seo','id'=>$model->id));
					
					if($_POST['accion'] == "siguiente") // guardar y siguiente
						$this->redirect(array('create','id'=>$_POST['id_sig']));
					
			}


			
		}//else
		
		$this->render('_view_imagenes',array(
			'model'=>$model,'imagen'=>$imagen,
		));
	}
	
	// carga de imagenes
	public function actionMulti() {
		
		if($_POST['accion'] == "siguiente") // guardar y siguiente
			$this->redirect(array('create','id'=>$_POST['id_sig']));
				
		if(!isset($_GET['id'])){
			$this->redirect(array('producto/imagenes'));
		}
		else {
				$id = $_GET['id'];
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
		                $extension_ori = ".jpg";
						$extension = '.'.$pic->extensionName;
		                if ($pic->saveAs($nombre . $extension)) {
		
		                    $imagen->url = '/images/producto/'. $id .'/'. $imagen->id .$extension;
		                    $imagen->save();
							
							Yii::app()->user->updateSession();
							Yii::app()->user->setFlash('success',UserModule::t("La imágen ha sido cargada exitosamente."));
			
							$image = Yii::app()->image->load($nombre . $extension);
		                    $image->save($nombre . "_orig".$extension); 
							
							if ($extension == '.png')
								$image->save($nombre ."_orig". $extension_ori);
							
							/* thumb */
							$image = Yii::app()->image->load($nombre . $extension);
		                    $image->resize(270, 270);
		                    $image->save($nombre . "_thumb".$extension);
							
							if ($extension == '.png'){
								$image->resize(270, 270)->quality(95);	
								$image->super_crop(270,270,"top","left");
								$image->save($nombre .  "_thumb".$extension_ori);	
							}	
							
							/* thumb retina */
							$image = Yii::app()->image->load($nombre . $extension);
		                    $image->resize(540, 540);
		                    $image->save($nombre . "_x540".$extension);
							
							if ($extension == '.png'){
								$image->resize(540, 540)->quality(95);	
								$image->super_crop(540,540,"top","left");
								$image->save($nombre .  "_x540".$extension_ori);	
							}	
							
							/* productos thumb */
							$image = Yii::app()->image->load($nombre . $extension);
		                    $image->resize(90, 90);
		                    $image->save($nombre . "_x90".$extension);
							
							if ($extension == '.png'){
								$image->resize(90, 90)->quality(95);	
								$image->super_crop(90,90,"top","left");
								$image->save($nombre .  "_x90".$extension_ori);	
							}
							
							/* productos thumb retina */
							$image = Yii::app()->image->load($nombre . $extension);
		                    $image->resize(180, 180);
		                    $image->save($nombre . "_x180".$extension);
							
							if ($extension == '.png'){
								$image->resize(180, 180)->quality(95);	
								$image->super_crop(180,180,"top","left");
								$image->save($nombre .  "_x180".$extension_ori);	
							}		
							
							/* pop over carrito */
							$image = Yii::app()->image->load($nombre . $extension);
		                    $image->resize(30, 30);
		                    $image->save($nombre . "_x30".$extension);
							
							if ($extension == '.png'){
								$image->resize(30, 30)->quality(60);	
								$image->super_crop(30,30,"top","left");
								$image->save($nombre .  "_x30".$extension_ori);	
							}	
							
							/* pop over carrito retina */
							$image = Yii::app()->image->load($nombre . $extension);
		                    $image->resize(60, 60);
		                    $image->save($nombre . "_x60".$extension);
							
							if ($extension == '.png'){
								$image->resize(60, 60)->quality(60);	
								$image->super_crop(60,60,"top","left");
								$image->save($nombre .  "_x60".$extension_ori);	
							}	
							
							/* imagen principal del producto */
							$image = Yii::app()->image->load($nombre . $extension); 
		                    $image->resize(566, 566);
		                    $image->save($nombre . $extension);
							
							if ($extension == '.png'){
								$image->resize(566, 566)->quality(95);	
								$image->super_crop(566,566,"top","left");
								$image->save($nombre . $extension_ori);		
							}
																	
		                } else {
		                    $imagen->delete();
		                }
						
		            }// foreach
		        }// isset
		        else {
						Yii::app()->user->updateSession();
						Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));	
				}


        		$this->redirect(array('producto/imagenes', 'id' => $id));
        }//else principal
    }

//detalles producto
    public function actionDetalles($id) {
			
		$precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$id));
		$producto = Producto::model()->findByPk($id);
		$imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$id,'orden'=>'1'));		
			
		$datos="";
		$datos=$datos."	<div class='modal-header'>"; 
		$datos=$datos. "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>";
		$datos=$datos."<h3 id='myModalLabel'>";
		$datos=$datos. $producto->nombre;
		$datos=$datos."</h3></div>";
		
// fin del header

		$datos=$datos."<div class='modal-body'><div class='pull-left margin_right'>";
		if($imagen){
			$datos=$datos. CHtml::image(Yii::app()->baseUrl . str_replace(".","_thumb.",$imagen->url), "Imagen ", array("width" => "200", "height" => "200",'class'=>'img-polaroid'));
			$datos=$datos."</div>";
		}else
			$datos=$datos."<img src='http://placehold.it/200' class='img-polaroid'/></div>"; 
		
		
		$datos=$datos."<div class='pull-left'><h4>Precios</h4>";
      	$datos=$datos."<table width='100%' border='0' cellspacing='0' cellpadding='0' class='table table-bordered table-condensed'>";
        $datos=$datos."<tr>";
        $datos=$datos."<th scope='row'>Precio base</th>";
		
		if($precio)
	        $datos=$datos."<td>".Yii::t('contentForm','currSym')." ".Yii::app()->numberFormatter->formatDecimal($precio->precioVenta); 
		else
        	$datos=$datos."<td>"; 

        $datos=$datos."</td></tr>";
        
        $datos=$datos."<tr>";
        $datos=$datos."<th scope='row'>Precio con descuento</th>";
		
		if($precio)
	        $datos=$datos."<td>".Yii::t('contentForm','currSym')." ".Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento); 
		else
        	$datos=$datos."<td>"; 

        $datos=$datos."</td></tr>";
        
		$datos=$datos."<tr>";
        $datos=$datos."<th scope='row'>Descuento </th>";
		
		if($precio)
			if($precio->tipoDescuento==0)
	        	$datos=$datos."<td>".Yii::app()->numberFormatter->formatDecimal($precio->valorTipo)."%";
			else
				$datos=$datos."<td> En ".Yii::t('contentForm','currSym');
		else
        	$datos=$datos."<td>"; 

        $datos=$datos."</td></tr>";
		
		$datos=$datos."<tr>";
        $datos=$datos."<th scope='row'>Total Descuento</th>";
		
		if($precio)
			if($precio)
				$datos=$datos."<td>".Yii::t('contentForm','currSym')." ".Yii::app()->numberFormatter->formatDecimal($precio->ahorro); 
			else
        		$datos=$datos."<td>"; 

        $datos=$datos."</td></tr>";
		$datos=$datos."</table><hr/>";
		
		$datos=$datos."<h4>Estadísticas</h4>";	
     	$datos=$datos."<table width='100%' border='0' cellspacing='0' cellpadding='0' class='table table-bordered table-condensed'>";
        $datos=$datos."<tr>";
        $datos=$datos."<th scope='row'>Vistas</th>";
		$datos=$datos."<td> ".$producto->view_counter;
        $datos=$datos."</td></tr>";
        
		$looks_usan = LookHasProducto::model()->countByAttributes(array('producto_id'=>$id));
		
        $datos=$datos."<tr>";
        $datos=$datos."<th scope='row'>Looks que lo usan</th>";
		$datos=$datos."<td> ".$looks_usan;
		$datos=$datos."</td></tr>";
		$datos=$datos."</table>";
		$datos=$datos."</div></div>";
		// fin del body
		
		$datos=$datos."<div class='modal-footer'>";
		$datos=$datos."<a href='seo/".$producto->id."' title='Editar Detalles SEO' class='btn'><i class='icon-pencil'></i> SEO</a>";
		$datos=$datos."<a href='delete/".$producto->id."' title='eliminar' class='btn'><i class='icon-trash'></i> Eliminar</a>";
		$datos=$datos."<a href='#' title='Exportar' class='btn'><i class='icon-share-alt'></i> Exportar</a>";
		$datos=$datos."<a href='create/".$producto->id."' title='editar' class='btn'><i class='icon-edit'></i> Editar</a>";
		$datos=$datos."<a href='detalle/".$producto->id."' title='ver' class='btn btn-info'><i class='icon-eye-open icon-white'></i> Ver</a> ";
		$datos=$datos."</div>";	
		$datos=$datos."</div>";	
		
		echo $datos;
	}
    // le asigna un color a la imagen
    public function actionImagenColor()
	{
		 Imagen::model()->updateByPk($_POST['id'], array('color_id' => $_POST['color_id']));
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
				{
                    unlink(Yii::app()->basePath . '/..' . $model->url);
					unlink(Yii::app()->basePath . '/..' . str_replace(".","_thumb.",$model->url));
				}
                $model->delete();
            }
            echo "OK";
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
	
	//
	// trabajo con el inventario
	public function actionInventario()
	{

		if(isset($_GET['id'])){
			
			$id = $_GET['id'];
			
			if(!$inventario = Inventario::model()->findByAttributes(array('tbl_producto_id'=>$id)))
				$inventario=new Inventario;
			
			$model = Producto::model()->findByPk($id);
		}
		else {
			$inventario=new Inventario;
			$model = new Producto;
			$id="";
		}
		
		if(isset($_POST['Inventario']))
		{
			$inventario->attributes=$_POST['Inventario'];
			
			if($id==""){
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('error',UserModule::t("No es posible almacenar los datos de inventario si aún no se ha creado el producto."));
			}			
			else{
				$inventario->tbl_producto_id = $id;
			
				if($inventario->save())
				{
					Yii::app()->user->updateSession();
					Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
				}
				//	$this->redirect(array('view','id'=>$model->id));
				
			}//else grande
		}

		$this->render('_view_inventario',array(
			'model'=>$model,'inventario'=>$inventario,
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
				$this->redirect(array('admin'));
		}
		else if(isset($_GET['id'])){
			$model=Producto::model()->findByPk($id);
			$model->status = 0;
			Producto::model()->updateByPk($id, array('status'=>'0'));
			$this->redirect(array('admin'));
			
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model = new Producto($scenario='search');
		  $model->unsetAttributes();
		  $model->nombre = $_GET['query'];
		
		  //add the ->search() call: 
		  $this->render('index',array('dataProvider'=>$model->search())); 

	//	$dataProvider=new CActiveDataProvider('Producto');
	//	$this->render('index',array(
	//		'dataProvider'=>$dataProvider,
	//	));
	}
	
	public function actionSuprimir()
	{
		if(isset($_POST['id']))
		{
			$ptc=Preciotallacolor::model()->findByPk($_POST['id']);
			$lk=$ptc->enLooks();
			$ord=$ptc->enOrdenes();
			
				if(($lk+$ord)>0)
				{
						Yii::app()->user->setFlash('error',UserModule::t("Combinación no puede ser eliminada ya que se encuentra en ".$ord." Ordenes y ".$lk." Looks."));				
				}
				else{
					if($ptc->delete())
						Yii::app()->user->setFlash('success',UserModule::t("Combinación de Talla y Color Eliminada"));
				}
		}else{
			Yii::app()->user->setFlash('error',UserModule::t("Combinación no pudo ser eliminada."));
		}
	}
	
	

	public function actionAdmin()
	{
                      
            $producto = new Producto;

            $producto->status = 1;

            $dataProvider = $producto->search();

            /**********************   Para Filtros   *************************/
            if((isset($_SESSION['todoPost']) && !isset($_GET['ajax'])))
            {
                unset($_SESSION['todoPost']);
            }
            
            if((isset($_SESSION['searchBox']) && !isset($_POST['query']) && !isset($_GET['ajax'])))
            {
                unset($_SESSION['searchBox']);
            }
            
             //Filtros personalizados
            $filters = array();
            
            //Para guardar el filtro
            $filter = new Filter;
            
            if(isset($_GET['ajax']) && !isset($_POST['dropdown_filter']) && isset($_SESSION['todoPost'])
               && !isset($_POST['query'])){
              $_POST = $_SESSION['todoPost'];
            }
            
            
            if(isset($_POST['dropdown_filter'])){   
                
                unset($_SESSION['searchBox']);
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
                    
                    $dataProvider = $producto->buscarPorFiltros($filters);                    
                    
                     //si va a guardar
                     if (isset($_POST['save'])){                        
                         
                         //si es nuevo
                         if (isset($_POST['name'])){
                            
                            $filter = Filter::model()->findByAttributes(
                                    array('name' => $_POST['name'], 'type' => '2') //Filtros para ventas
                                    ); 
                            if (!$filter) {
                                $filter = new Filter;
                                $filter->name = $_POST['name'];
                                $filter->type = 2;
                                
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

//            if(isset($_SESSION['searchBox'])){
//                
//            echo "<pre>";
//            print_r($_SESSION['searchBox']);
//            echo "</pre>";
//            Yii::app()->end();
//            }

            if(isset($_GET['ajax']) && isset($_SESSION['searchBox'])
               && !isset($_POST['query'])){
//                echo "dd";
//                Yii::app()->end();
              $_POST['query'] = $_SESSION['searchBox'];
            }
            
            if (isset($_POST['query']))
            {
                    //echo($_POST['query']);	
                    $_SESSION['searchBox'] = $_POST['query'];
                    unset($_SESSION["todoPost"]);
                    $producto->nombre = $_POST['query'];
                    $dataProvider = $producto->busquedaNombreReferencia($_POST['query']);
            }	

            $this->render('admin',
            array('model'=>$producto,
            'dataProvider'=>$dataProvider,
            ));	

	}// fin

	/**
	 * Maneja las acciones para varios productos
	 */
	public function actionVarias()
	{
		if($_POST['check']!=""){
			
			$checks = explode(',',$_POST['check']);
			$accion = $_POST['accion'];	
		
			if($accion=="Acciones")
			{
				echo("2"); // no selecciono una accion
			}
			else if($accion=="Activar")
			{
				foreach($checks as $id){
					$model = Producto::model()->findByPk($id);
					$model->estado=0;
					Producto::model()->updateByPk($id, array('estado'=>'0'));
					/*if($model->save())
						echo("guarda");
					else {
						print_r($model->getErrors());
					}*/				
				}
				echo("3"); // activo los productos
			}
			else if($accion=="Inactivar")
			{
				foreach($checks as $id){
					$model = Producto::model()->findByPk($id);
					$model->estado=1;
					Producto::model()->updateByPk($id, array('estado'=>'1'));
					/*if($model->save())
						echo("guarda");
					else {
						print_r($model->getErrors());
					}*/				
				}
				echo("4");				
			}
			else if($accion=="Borrar")
			{
				foreach($checks as $id){
					$model = Producto::model()->findByPk($id);
					$model->status=0;
					Producto::model()->updateByPk($id, array('status'=>'0'));
					/*if($model->save())
						echo("guarda");
					else {
						print_r($model->getErrors());
					}*/				
				}
				echo("5");	
			}

		}
		else {
			echo("1"); // no selecciono checks
		}
	}
/**
 * Genera la fila para talla color
 */
	public function actionAddTallacolor(){
			
		//if(isset($_GET['id'])){
			//if(!$inventario = Inventario::model()->findByAttributes(array('tbl_producto_id'=>$id)))
			//	$inventario=new Inventario;
			
			$model = Producto::model()->findByPk($_POST['id']);
		//}
		//else {
			//$inventario=new Inventario;
		//	$model = new Producto; 
		//}	
		
		if(isset($_POST['tallas'])){
			$tallas = explode('#',$_POST['tallas']);
			$colores = explode(',',$_POST['colores']);
			
		}
		$i = 0;
		$tallacolor = array();
		foreach($tallas as $talla){
			if ($talla!=''){
				foreach($colores as $color){
					$preciotallacolor = '';
					$color_tmp = Color::model()->findByAttributes(array('valor'=>$color));
					if (isset($color_tmp)){
						$preciotallacolor = Preciotallacolor::model()->findByAttributes(array('producto_id'=>$model->id,'talla_id'=>$talla,'color_id'=>$color_tmp->id));
						if (!isset($preciotallacolor)){
							$tallacolor[$i]= new Preciotallacolor;	
							$tallacolor[$i]->color_id = $color_tmp->id;
							$tallacolor[$i]->color = $color_tmp->valor;
						}
					}
					if (!isset($preciotallacolor)){
						$talla_tmp = Talla::model()->findByPk($talla);
						if (isset($talla_tmp)){
							$tallacolor[$i]->talla_id = $talla_tmp->id;
							$tallacolor[$i]->talla = $talla_tmp->valor;
						}
						$tallacolor[$i]->cantidad = 0;
						
						$i++;
					}
				
				}
			}
		}
		if (count($model->preciotallacolor))
			$tallacolor = CMap::mergeArray($tallacolor,$model->preciotallacolor);
		$this->renderPartial('_view_tallacolor',array('tallacolor'=>$tallacolor));	
		/*
		$this->render('tallacolor',array(
			'model'=>$model
		));
		 * */
	}
/**
 * Manejador de Colors y Tallas
 */
	public function actionTallacolor($id){
			//	$pree = Preciotallacolor::model()->findByPk(7);
		//$pree->validate();
		//if(isset($_GET['id'])){
			//if(!$inventario = Inventario::model()->findByAttributes(array('tbl_producto_id'=>$id)))
			//	$inventario=new Inventario;
			
			$model = Producto::model()->findByPk($id);
		//}
		//else {
			//$inventario=new Inventario;
		//	$model = new Producto;
		//}	
		
		if (isset($_POST['PrecioTallaColor'])){
			$valid = true;
			 foreach ( $_POST['PrecioTallaColor'] as $i => $tallacolor ) {
			 	if ($tallacolor['id']!='')
			 		$preciotallacolor[$i] = Preciotallacolor::model()->findByPk($tallacolor['id']);
				else 
					$preciotallacolor[$i] = new Preciotallacolor;
				if ($tallacolor['sku']!='' && $tallacolor['cantidad']!=''){
				$this->performAjaxValidation($preciotallacolor[$i]);  
					$preciotallacolor[$i]->attributes=$tallacolor; 
					$preciotallacolor[$i]->producto_id = $model->id;
					$valid  = $valid  && $preciotallacolor[$i]->validate();
					if(!($valid)){
						$error = CActiveForm::validate($preciotallacolor[$i]);
	                    if($error!='[]'){
	                    	$error = CJSON::decode($error);
	                    	$error['id']= $i;
							echo CJSON::encode($error);
						}
	                    Yii::app()->end();	  				
					}
				} else {
					if ($preciotallacolor[$i]->isNewRecord){
						unset($preciotallacolor[$i]);
					}else{
						try{
							$preciotallacolor[$i]->delete(); 
						} catch (Exception $e) {
	                    	$error['PrecioTallaColor_sku'] = "No es posible eliminar este codigo.";
							$error['id']= $i;
							echo CJSON::encode($error);
						 	Yii::app()->end();
						}
						
					}
				}
			 }
			if ($valid){
				
				  foreach ( $preciotallacolor as $i => $tallacolor ) {
					//	$preciotallacolor->attributes=$tallacolor;  
					  
					  if ($tallacolor->save()){
						Yii::app()->user->updateSession();
						Yii::app()->user->setFlash('success',UserModule::t("Se guardaron las cantidades"));	
						
							
							 	  	
					  }	else {
					  	$valid = false;
					  	Yii::trace('PrecioTallaColor Error:'.print_r($tallacolor->getErrors(),true), 'registro');
						Yii::app()->user->updateSession();
						Yii::app()->user->setFlash('error',UserModule::t("No se pudieron guardar las cantidades, por favor intente de nuevo mas tarde"));				  	
					  }
				  }
				if ($valid)  
					echo CJSON::encode(array(
	                                  'status'=>'success',
	                                  'id'=>$model->id
	                             ));
			}
		} 
		else {
		$this->render('tallacolor',array(
			'model'=>$model
		));
		}
		
		
	}


/**
 * Manejador de la vista general para el producto
 */
	public function actionDetalle()
	{
            if (isset($_GET['alias'])) {
                $seo = Seo::model()->findByAttributes(array('urlAmigable' => $_GET['alias']));
    //			$producto = Producto::model()->activos()->noeliminados()->findByPk($seo->tbl_producto_id);
                $producto = Producto::model()->noeliminados()->findByPk($seo->tbl_producto_id);
            } else {
    //			$producto = Producto::model()->activos()->noeliminados()->findByPk($_GET['id']);
                $producto = Producto::model()->noeliminados()->findByPk($_GET['id']);
                $seo = Seo::model()->findByAttributes(array('tbl_producto_id' => $producto->id));
            }

            $contador = $producto->view_counter + 1;

            Producto::model()->updateByPk($producto->id, array(
                'view_counter' => $contador
            ));

            if ($seo) {
                $this->pageDesc = $seo->mDescripcion;
                $this->pageTitle = 'Personaling - ' . $seo->mTitulo;
                $this->keywords = $seo->pClave;
            } else {
                $this->pageDesc = $producto->descripcion;
                $this->pageTitle = 'Personaling - ' . $producto->nombre;
            }

            $this->display_seo();
            $view = new ProductoView;
            $view->producto_id = $producto->id;
            $view->user_id = Yii::app()->user->id;

            if (!$view->save())
                Yii::trace('ProductoController.php:946, Error:' . print_r($view->getErrors(), true), 'registro');

            $this->render('_view_detalle', array('producto' => $producto));
        }
	
	/**
 * Consigue las tallas al presionar un color
 */
	public function actionTallas()
	{
		

		$tallas = array();
		$imgs = array(); // donde se van a ir las imagenes
		
		$ptc = Preciotallacolor::model()->findAllByAttributes(array('color_id'=>$_POST['idTalla'],'producto_id'=>$_POST['idProd']));
		
		foreach($ptc as $p)
		{
			if($p->cantidad>0) // que haya disponibilidad para mostrarlo
			{
				$datos = array();
				
				$ta = Talla::model()->findByPk($p->talla_id);
				
				array_push($datos,$ta->id);
				array_push($datos,$ta->valor); // para cada talla guardo su id y su valor
				array_push($tallas,$datos); // se envian en un array de datos de tallas
				
			}
		}
		
		$imagenes = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$_POST['idProd'],'color_id'=>$_POST['idTalla']),array('order'=>'orden ASC'));
				
			foreach ($imagenes as $img) {
				$todos = array();					
						
				array_push($todos,$img->url);
				array_push($todos,$img->orden);
				array_push($todos,$img->id);
				array_push($imgs,$todos); // array de datos de imagenes
			}	
		
		
		echo CJSON::encode(array(
			'status'=> 'ok',
			'datos'=> $tallas,
			'imagenes'=>$imgs
		));
		exit;
	}
	
	
	/**
 * Consigue los colores al presionar una talla
 */
	public function actionColores()
	{
		$colores = array();
		
		$ptc = Preciotallacolor::model()->findAllByAttributes(array('talla_id'=>$_POST['idColor'],'producto_id'=>$_POST['idProd']));
		
		foreach($ptc as $p)
		{
			if($p->cantidad > 0) // que haya disponibilidad para mostrarlo
			{
				$datos = array();
				
				$co = Color::model()->findByPk($p->color_id);
				 
				array_push($datos,$co->id);
				array_push($datos,$co->valor); // para cada talla guardo su id y su valor
				array_push($datos,$co->path_image); // y su path de imagen
				
				array_push($colores,$datos); // se envian en un array de datos de colores
			}
		}	
		
			//print_r($tallas);
		
		echo CJSON::encode(array(
			'status'=> 'ok',
			'datos'=> $colores
		));
		exit;

	} 
	
	/*
	 * Relacionando el producto a una o varias categorias
	 * 
	 * */
	public function actionCategorias()
	{
		if(isset($_GET['id'])){
			$id = $_GET['id'];			
			$model = Producto::model()->findByPk($id);
			$categorias = CategoriaHasProducto::model()->findAllByAttributes(array('tbl_producto_id'=>$id));
		}
		else {
			$model = new Producto;
			$id="";
			$categorias = new CategoriaHasProducto;
		}
		
		$this->render('_view_categoria',array(
			'model'=>$model,'categorias'=>$categorias,
		));
	}
	
	/*
	 * Relacionando el producto a una o varias categorias
	 * 
	 * */
	public function actionReCatProd()
	{
		if(isset($_POST['check'])){
			if($_POST['check']!=""){

				$checks = explode(',',$_POST['check']);
				$idProducto = $_POST['idProd'];
				
				$cuales = CategoriaHasProducto::model()->findAllByAttributes(array('tbl_producto_id'=>$idProducto));
				$todos = array();
				$BD = array();
				$total = count($cuales);
				$contador=0;
				
				// en el caso que sea una segunda modificacion y se quita alguna categoria debe eliminarse de la BD
				foreach($cuales as $uno){
					
					array_push($BD,$uno->tbl_categoria_id);
					
					foreach($checks as $vienen){
						
						$separa = (explode("-",$vienen));
						
						if($separa[1] == $uno->tbl_categoria_id){
							$contador++;
							array_push($todos,$uno->tbl_categoria_id);
						}
					}
				}				
				
				// tengo los que llegaron y estan dentro de la BD en dos array, busco la diferencia
				$r = array_diff($BD, $todos);
				/*var_dump($BD);
				var_dump($todos);
				var_dump($r);*/
				
				if(isset($r)){
					foreach($r as $cadauno){
						$borr = CategoriaHasProducto::model()->findByAttributes(array('tbl_categoria_id'=>$cadauno));
						
						if(isset($borr))
							$borr->delete();
					
					}
					
				}
				
				foreach($checks as $idCateg){
						
					$separa = (explode("-",$idCateg));	
						
					if(!$prodCat = CategoriaHasProducto::model()->findByAttributes(array('tbl_producto_id'=>$idProducto,'tbl_categoria_id'=>$separa[1]))) // reviso si ya esta en la BD esa asignacion
					{
						$prodCat = new CategoriaHasProducto;
						$prodCat->tbl_categoria_id = $separa[1]; //id Categoria cambia en el foreach
						$prodCat->tbl_producto_id = $idProducto; // producto igual para todos
										
						$prodCat->save();
						//Producto::model()->updateByPk($id, array('estado'=>'0'));					
					}	
					// si ya está la ignora
					//$prodCat = new CategoriaHasProducto;
				}
				
				Yii::app()->user->setFlash('success', "Se ha relacionado el producto a las categorias.");
				
				if($_POST['accion'] == 'normal')
					echo("ok"); // realizo la relación
				else if($_POST['accion'] == 'avanzar')
					echo($idProducto); // realizo la relación
					
			}
		}
	}
	
	/*
	 * Action para que la usuaria le encante un producto
	 * 
	 * */
	public function actionEncantar()
	{
		
		if(Yii::app()->user->isGuest==false) // si está logueado
		{
			
			$like = UserEncantan::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'producto_id'=>$_POST['idProd']));
			
			if(isset($like)) // si ya le dio like
			{
				$like->delete();
				//echo "borrado";	
				
				$total = UserEncantan::model()->countByAttributes(array('producto_id'=>$_POST['idProd']));  	
				
				echo CJSON::encode(array(
					'mensaje'=> 'borrado',
					'total'=> $total
				));
				exit; 
									
			}
			else // esta logueado y es un like nuevo
			{
				$encanta = new UserEncantan;
				
				$encanta->producto_id = $_POST['idProd'];
				$encanta->user_id = Yii::app()->user->id;
				
				if($encanta->save())
				{
					// echo "ok"; // guardó y le encantó
					
					$total = UserEncantan::model()->countByAttributes(array('producto_id'=>$_POST['idProd']));  	
				
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
 * Consigue las tallas para el preview
 */
	public function actionTallaspreview()
	{
		$tallas = array();
		$imgs = array(); // donde se van a ir las imagenes
		$div ="";
		$imag="";
		$cont=0;
		
		$ptc = Preciotallacolor::model()->findAllByAttributes(array('color_id'=>$_POST['idTalla'],'producto_id'=>$_POST['idProd']));
		
		foreach($ptc as $p)
		{
			if($p->cantidad>0) // que haya disponibilidad para mostrarlo
			{
				$ta = Talla::model()->findByPk($p->talla_id);
				$div = $div."<div onclick='a(".$ta->id.")' id='".$ta->id."' style='cursor: pointer' class='tallass' title='talla'>".$ta->valor."</div>";
			}
		}
		
		$imagenes = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$_POST['idProd'],'color_id'=>$_POST['idTalla']),array('order'=>'orden ASC'));
				
			foreach ($imagenes as $img) {
				$todos = array();				
				
				if($cont==0){
					$imag=$imag.'<div class="item active">';
					$imag=$imag.CHtml::image($img->getUrl(array('ext'=>'jpg')),'producto', array("width" => "450", "height" => "450"));
					$imag=$imag.'</div>';	
					$cont++;
				}
				else{
					$imag=$imag.'<div class="item">';
					$imag=$imag.CHtml::image($img->getUrl(array('ext'=>'jpg')),'producto', array("width" => "450", "height" => "450"));
					$imag=$imag.'</div>';	
				}

			}
		
		echo CJSON::encode(array(
			'status'=> 'ok',
			'datos'=> $div,
			'imagenes'=>$imag
		));
		exit;
	}


/**
 * Consigue los colores al presionar una talla en la vista rapida
 */
	public function actionColorespreview()
	{
		$div="";

		$ptc = Preciotallacolor::model()->findAllByAttributes(array('talla_id'=>$_POST['idColor'],'producto_id'=>$_POST['idProd']));
		
		foreach($ptc as $p)
		{
			if($p->cantidad > 0) // que haya disponibilidad para mostrarlo
			{
				$base = Yii::app()->baseUrl;		
				$co = Color::model()->findByPk($p->color_id);
				
				$div = $div."<div onclick='b(".$co->id.")' id='".$co->id."' style='cursor: pointer' class='coloress' title='".$co->valor."'><img src='".$base."/images/colores/".$co->path_image."'></div>";
			}
		}	
		
		echo CJSON::encode(array(
			'status'=> 'ok',
			'datos'=> $div
		));
		exit;

	}

	// importar desde excel
	public function actionImportar()
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
                            $nombre = Yii::getPathOfAlias('webroot') . '/docs/xlsMasterData/' . "Temporal";//date('d-m-Y-H:i:s', strtotime('now'));
                            $extension = '.' . $xls->extensionName;                     

                            if ($xls->saveAs($nombre . $extension)) {

                            } else {
                                Yii::app()->user->updateSession();
                                Yii::app()->user->setFlash('error', UserModule::t("Error al cargar el archivo."));
                                $this->render('importar_productos', array(
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
                    if(is_array($resValidacion = $this->validarArchivoV2($nombre . $extension))){
                        
                        Yii::app()->user->updateSession();
                        Yii::app()->user->setFlash('success', "Éxito! El archivo no tiene errores.
                                                    Puede continuar con el siguiente paso.<br><br>
                                                    Este archivo contiene <b>{$resValidacion['nProds']}
                                                    </b> productos.");                    
                    }                    
                    
                    $this->render('importar_productos', array(
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
                        $rutaArchivo = Yii::getPathOfAlias('webroot').'/docs/xlsMasterData/';
                        foreach ($archivo as $arc => $xls) {

                            $nombre = $rutaArchivo.$nombreTemporal;
                            $extension = '.' . $xls->extensionName;
                            
                            if ($xls->saveAs($nombre . $extension)) {
                                
                            } else {
                                Yii::app()->user->updateSession();
                                Yii::app()->user->setFlash('error', UserModule::t("Error al cargar el archivo."));
                                $this->render('importar_productos', array(
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
                    if( !is_array($resValidacion = $this->validarArchivoV2($nombre . $extension)) ){
                        
                        // Archivo con errores, eliminar del servidor
                        unlink($nombre . $extension);
                        
                        $this->render('importar_productos', array(
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

                    //Esto no se pa que es
                    $anterior;
                    $pr_id;                   
                    /*
                    Para el MasterData en XML
                     */
                    $xml = new SimpleXMLElement('<xml version="1.0"/>');
                    $masterData = $xml->addChild('MasterData');
                    //Agregar la fecha de creacion
                    $masterData->addChild("FechaCreacion", date("Y-m-d")); 
                   
                // segundo foreach, si llega aqui es para insertar y todo es valido
                    foreach ($sheet_array as $row) {
                        
                        if ($row['A'] != "" && $row['A'] != "SKU") { // para que no tome la primera ni vacios
                            
                            //Modificaciones a las columnas
                            //antes de procesarlas                            
                            //Transformar los datos numericos: Peso, costo y Precio
                            $row['K'] = str_replace(",", ".", $row['K']);
                            $row['L'] = str_replace(",", ".", $row['L']);
                            $row['M'] = str_replace(",", ".", $row['M']); 
                            
                            $rSku = $row['A'];
                            $rRef = $row['B'];
                            $rMarca = $row['C'];
                            $rNombre = $row['D'];
                            $rDescrip = $row['E'];
                            $rCatego1 = $row['F'];
                            $rCatego2 = $row['G'];
                            $rCatego3 = $row['H'];
                            $rTalla = $row['I'];
                            $rColor = $row['J'];
                            $rPeso = $row['K'];
                            $rCosto = $row['L'];
                            $rPrecio = $row['M'];
                            $rmDesc = $row['N'];
                            $rmTags = $row['O'];
                            $rAlmacen = $row['P'];
                            
                            $anterior = $row;

                            $producto = Producto::model()->findByAttributes(array('codigo' => $rRef));

                            // la referencia existe, hay que actualizar los campos
                            $prodExiste = isset($producto);
                            
                            // Marca para actualizar
                            $marca = Marca::model()->findByAttributes(array('nombre' => $rMarca));                                                        
                            
                            if($prodExiste){
                                $actualizar++; //suma un producto actualizado                                
                                // actualiza el producto
                                Producto::model()->updateByPk($producto->id, array(
                                    'nombre' => $rNombre,
                                    'marca_id' => $marca->id,
                                    'descripcion' => $rDescrip,
                                    'peso' => $rPeso,
                                    'almacen' => $rAlmacen,
                                    'status' => 1
                                )); 
                                
                                
                            } else
                            { // no existe la referencia, es producto nuevo                           
                                $total++; // suma un producto nuevo
                                
                                $producto = new Producto;
                                $producto->nombre = $rNombre;
                                $producto->codigo = $rRef;
                                $producto->estado = 1; // inactivo
                                $producto->descripcion = $rDescrip;
                                $producto->fecha = date('Y-m-d H:i:s');
                                $producto->peso = $rPeso;
                                $producto->almacen = $rAlmacen;
                                $producto->status = 1; // no está eliminado
                                $producto->marca_id = $marca->id;
                                $producto->save();  
                                                                
                            }
                            
                            // Si existe o no el producto, actualizar o insertar precio nuevo
                            $precio = Precio::model()->findByAttributes(array('tbl_producto_id' => $producto->id));
                            
                            if (isset($precio)) {
                                $precio->costo = $rCosto;
                                $precio->precioVenta = $rPrecio;
                                $precio->precioDescuento = $rPrecio;
                                $precio->impuesto = 1;
                                $precio->precioImpuesto = (double) $rPrecio * (Yii::app()->params['IVA'] + 1);
                            } 
                            else
                            {
                                $precio = new Precio;
                                $precio->costo = $rCosto;
                                $precio->precioVenta = $rPrecio;
                                $precio->tbl_producto_id = $producto->id;
                                $precio->precioDescuento = $rPrecio;
                                $precio->impuesto = 1;
                                $precio->precioImpuesto = (double) $rPrecio * (Yii::app()->params['IVA'] + 1);
                            }
                            
                            $precio->save();
                            
                            //Consultar las categorias
                            $categorias = CategoriaHasProducto::model()->findAllByAttributes(array('tbl_producto_id' => $producto->id));
                            // borrar todas las categorias
                            if (isset($categorias)) {
                                foreach ($categorias as $categoria) {
                                    $categoria->delete();
                                }
                            }

                            $cat = new CategoriaHasProducto;
                            $cat2 = new CategoriaHasProducto;
                            $cat3 = new CategoriaHasProducto;

                            //Agregar 3 categorias al producto
                            if ($rCatego1 != "") {
                                $x = Categoria::model()->findByAttributes(array('nombre' => $rCatego1));
                                $cat->tbl_producto_id = $producto->id;
                                $cat->tbl_categoria_id = $x->id;

                                $cat->save();
                            }
                            
                            if ($rCatego2 != "") {
                                $x = Categoria::model()->findByAttributes(array('nombre' => $rCatego2));
                                $cat2->tbl_producto_id = $producto->id;
                                $cat2->tbl_categoria_id = $x->id;

                                $cat2->save();
                            }

                            if ($rCatego3 != "") {
                                $x = Categoria::model()->findByAttributes(array('nombre' => $rCatego2));
                                $cat3->tbl_producto_id = $producto->id;
                                $cat3->tbl_categoria_id = $x->id;

                                $cat3->save();
                            }
                            
                            $ptc = Preciotallacolor::model()->findByAttributes(array(
                                            'producto_id' => $producto->id,
                                            'sku' => $rSku,
                                            'talla_id' => $rTalla,
                                            'color_id' => $rColor,
                                        ));                                   
                                    
                            // si ya existe no hacer nada, si no, Crear uno nuevo
                            if (!isset($ptc)) { 

                                $ptc = new Preciotallacolor;                                        
                                $ptc->cantidad = 0; //Creando un producto nuevo, sin existencia
                                $ptc->sku = $rSku;
                                $ptc->producto_id = $producto->id;

                                $talla = Talla::model()->findByAttributes(array('valor' => $rTalla));
                                $color = Color::model()->findByAttributes(array('valor' => $rColor));

                                $ptc->talla_id = $talla->id;
                                $ptc->color_id = $color->id;
                                $ptc->save();
                            }
                            
                            // seo
                            $seo = Seo::model()->findByAttributes(array('tbl_producto_id' => $producto->id));

                            if (isset($seo)) {

                                $seo->mTitulo = $producto->nombre;
                                $seo->mDescripcion = $rmDesc;
                                $seo->pClave = $rmTags;
                                $seo->save();

                            } else {

                                $seo = new Seo;
                                $seo->mTitulo = $producto->nombre;
                                $seo->mDescripcion = $rmDesc;
                                $seo->pClave = $rmTags;
                                $seo->tbl_producto_id = $producto->id;
                                $seo->save();
                            }
                            
                            //Agregar el item al XML
                            $item = $masterData->addChild('Item');
                            
                            //Primera Categoria que haya                            
                            $categorias = CategoriaHasProducto::model()->findAllByAttributes(
                                    array('tbl_producto_id' => $producto->id));     
                            
                            if (isset($categorias)) {
                                foreach ($categorias as $categoria) {
                                    $cat = Categoria::model()->findByAttributes(
                                            array('id' => $categoria->tbl_categoria_id));
                                    $item->addChild('CodigoFamilia', $cat->id);
                                    $item->addChild('DescripcionFamilia', $cat->nombre);
                                    break;
                                }
                            }
                            
                            //Agregar el modelo
                            $item->addChild('CodigoModelo', $producto->codigo);
                            $item->addChild('DescripcionModelo', $producto->nombre);
                            
                            //Agregar el color
                            $item->addChild('CodigoColor', $color->id);
                            $item->addChild('DescripcionColor', $color->valor);
                            
                            //Agregar la talla
                            $item->addChild('CodigoTalla', $talla->id);
                            $item->addChild('DescripcionTalla', $talla->valor);
                            
                            //Agregar la clave auxiliar 1 - ID
                            $item->addChild('CodigoClaveAuxiliar1', $producto->id);
                            $item->addChild('DescripcionClaveAuxiliar1', "ID del Producto");
                            
                            //Agregar el SKU
                            $item->addChild('EAN1', $rSku);
                            
//                            $tabla .= 'Se agregó el producto con ID: ' . $producto->id
//                                    .', Nombre: ' . $producto->nombre
//                                    . ', Precio_id: ' . $precio->id
//                                    . ', actualizadas categorias, Seo_id: ' . $seo->id . '<br/>';
                                    
                            
                            //===============================================
                            
                            
                            
                        } 
                        else if ($row['A'] == "") 
                        { // si está vacia la primera
                            
//                            if ($row['K'] != "" && $row['L'] != "" && $row['M'] != "" && $row['N'] != "") {
//
//                                $tabla = $tabla . 'esta combinacion pertenece al producto: ' . $anterior['A'] . ' <br/>';
//                                $tabla = $tabla . 'Talla: ' . $row['K'] .
//                                        ' Color: ' . $row['L'] .
//                                        ' Cantidad: ' . $row['M'] .
//                                        ' Sku: ' . $row['N'] .
//                                        '<br/>';
//
//                                // ahora precio talla color
//
//                                $ptc = Preciotallacolor::model()->findByAttributes(array(
//                                    'sku' => $row['N'],
//                                    'producto_id' => $pr_id,
//                                    'talla_id' => $row['K'], 
//                                    'color_id' => $row['L']));
//
//                                if (isset($ptc)) { // existe el sku, hay que actualizar
//                                    $a = $ptc->cantidad;
//
//                                    $ptc->cantidad = $a + $row['M'];
//                                    $ptc->save();
//
//                                    $tabla = $tabla . 'se actualizaaron cantidades para el Producto-Talla-Color id ' . $ptc->id . '<br/>';
//                                } else { // nueva combinacion
//                                    $pre = new Preciotallacolor;
//                                    $pre->cantidad = $row['M'];
//                                    $pre->sku = $row['N'];
//                                    $pre->producto_id = $pr_id;
//
//                                    $talla = Talla::model()->findByAttributes(array('valor' => $row['K']));
//                                    $color = Color::model()->findByAttributes(array('valor' => $row['L']));
//
//                                    $pre->talla_id = $talla->id;
//                                    $pre->color_id = $color->id;
//
//                                    $pre->save();
//
//                                    $tabla = $tabla . 'se actualizaaron cantidades para el Producto-Talla-Color id ' . $pre->id . '<br/>';
//                                }
//                            }
                        }
                    }// foreach
                    
                    //Insertar nuevo MasterData
                    $masterDataBD = new MasterData();
                    $masterDataBD->fecha_carga = date("Y-m-d H:i:s");
                    //el admin que esta cargando
                    $masterDataBD->user_id = Yii::app()->user->id;
                    $masterDataBD->prod_actualizados = $actualizar;
                    $masterDataBD->prod_nuevos = $total;
                    $masterDataBD->save();

                    // Cambiar nombre al archivo xls                            
                    rename($nombre.$extension, $rutaArchivo."$masterDataBD->id".$extension);
                    
                    $mensajeSuccess = "Se ha cargado con éxito el archivo.
                                Puede ver los detalles de la carga a continuación.<br>";
                            
                    /*Enviar MasterData a logisFashion guardar respaldo del xml
                     *  y mostrar notificacion*/
                    $subido = MasterData::subirArchivoFtp($xml, 1, $masterDataBD->id);
                    $mensajeLF = "El archivo <b>MasterData.xml</b> se ha enviado
                        satisfactoriamente a LogisFashion. <i class='icon icon-thumbs-up'></i>";

                    Yii::app()->user->updateSession();
                    //Si hubo error conectandose al ftp logisfashion
                    if(!$subido){
                        $mensajeLF = "Ha ocurrido un error enviando el
                            archivo <b>MasterData.xml</b> a LogisFashion. <i class='icon icon-thumbs-down'></i>";
                        Yii::app()->user->setFlash("error", $mensajeLF);                                   
                        $mensajeLF = "";

                    }
                    Yii::app()->user->setFlash("success", $mensajeSuccess.$mensajeLF);                                   


                //Tercer paso - Descargar archivo para Inbound
                }
                else if(isset($_POST["generar"])){
                    
                    if(!isset($_POST["Marca"]) || $_POST["Marca"] == ""){
                     
                        Yii::app()->user->updateSession();
                        Yii::app()->user->setFlash("error", "Debe seleccionar una marca para
                            poder exportar el archivo de Excel."); 
                        
                    }else{
                        
                        $this->exportarExcelInbound($_POST["Marca"]);
                        
                    }
                    //Cuarto paso - Subir Inbound
                }
                else if(isset($_POST["cargarIn"])){
                    
                    $archivo = CUploadedFile::getInstancesByName('inbound');
                             
                    if (isset($archivo) && count($archivo) > 0) {
                        $nombreTemporal = "Archivo";
                        $rutaArchivo = Yii::getPathOfAlias('webroot').'/docs/xlsInbound/';
                        foreach ($archivo as $arc => $xls) {

                            $nombre = $rutaArchivo.$nombreTemporal;
                            $extension = '.' . $xls->extensionName;
                            
                            if ($xls->saveAs($nombre . $extension)) {
                                
                            } else {
                                Yii::app()->user->updateSession();
                                Yii::app()->user->setFlash('error', UserModule::t("Error al cargar el archivo."));
                                $this->render('importar_productos', array(
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
                    
                    /*Validar el inbound*/
                    if( !$this->validarArchivoInbound($nombre . $extension) ){
                        
                        // Archivo con errores, eliminar del servidor
                        unlink($nombre . $extension);
                        
                        $this->render('importar_productos', array(
                            'tabla' => $tabla,
                            'total' => $total,
                            'actualizar' => $actualizar,
                            'totalInbound' => $totalInbound,
                            'actualizadosInbound' => $actualizadosInbound,
                        ));
                        Yii::app()->end();
                    }
                    
                     /*
                    Para el Inbound en XML
                     */
                    $fecha = time();
                    $xml = new SimpleXMLElement('<xml version="1.0" encoding="UTF-8"/>');
                    $inbound = $xml->addChild('Inbound');
                    $inbound->addChild('Albaran');
                    $inbound->addChild('FechaAlbaran', date("Y-m-d", $fecha));                    
//                    $cliente = $inbound->addChild('Cliente', date("Y-m-d")); 
                    
                    /*Leer el XLS*/
                    $sheetArray = Yii::app()->yexcel->readActiveSheet($nombre . $extension);
                    $fila = 1;
                    $totalCantidades = 0;
                    foreach ($sheetArray as $row){
                        
                        //Modificaciones a las columnas
                        //antes de procesarlas
                        $row['B'] = strval($row['B']);
                        
                        $rSku = $row['A'];
                        $rCant = $row['B'];
                        
                        if($fila > 1){
                            
                            /*Solo si la cantidad es mayor a 0
                             * Agregar el Item al inbound*/
                            
                            if($rCant > 0){
                                
                                $item = $inbound->addChild('Item');
                                $item->addChild("EAN", $rSku);
                                $item->addChild("Cantidad", $rCant);

                                $totalCantidades += $rCant;

                                /*Incrementar cantidad en la BD*/
                                $producto = Preciotallacolor::model()->findByAttributes(array(
                                         "sku" => $rSku,
                                     ));

                                $producto->cantidad += $rCant;
                                $producto->save();
                                
                                $actualizadosInbound++;
                                
                            }
                        }
                        $fila++;                        
                    }
                    
                    //Insertar nuevo Inbound
                    $inboundRow = new Inbound();
                    $inboundRow->fecha_carga = date("Y-m-d H:i:s", $fecha);
                    $inboundRow->user_id = Yii::app()->user->id;
                    $inboundRow->total_productos = $fila-2;
                    $inboundRow->total_cantidad = $totalCantidades;
                    $inboundRow->save();
                    
                    //Totales
                    $totalInbound = $fila - 2;
                    
                   //Agregar el codigo en el XML
                    $inbound->Albaran = $inboundRow->id;
                   //Cambiar nombre al archivo Excel                           
                    rename($nombre.$extension, $rutaArchivo."$inboundRow->id".$extension);
                   
                    $mensajeSuccess = "Se ha cargado con éxito el archivo.
                                Puede ver los detalles de la carga a continuación<br>";
                            
                    /*Enviar Inbound a logisFashion, guardar respaldo del xml
                     *  y mostrar notificacion*/
                    $subido = MasterData::subirArchivoFtp($xml, 2, $inboundRow->id);
                    $mensajeLF = "El archivo <b>Inbound.xml</b> se ha enviado
                        satisfactoriamente a LogisFashion. <i class='icon icon-thumbs-up'></i>";                    

                    Yii::app()->user->updateSession();
                    //Si hubo error conectandose al ftp logisfashion
                    if(!$subido){
                        $mensajeLF = "Ha ocurrido un error enviando el
                            archivo <b>Inbound.xml</b> a LogisFashion. <i class='icon icon-thumbs-down'></i>";
                        Yii::app()->user->setFlash("error", $mensajeLF);                                   
                        $mensajeLF = "";

                    }
                    Yii::app()->user->setFlash("success", $mensajeSuccess.$mensajeLF);
                    
                }
                
                
            }// isset

            $this->render('importar_productos', array(
                'tabla' => $tabla,
                'total' => $total,
                'actualizar' => $actualizar,
                'totalInbound' => $totalInbound,
                'actualizadosInbound' => $actualizadosInbound,
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
        
        protected function validarArchivoV2($archivo){
            
            $sheet_array = Yii::app()->yexcel->readActiveSheet($archivo);

            $falla = "";
            $erroresMarcas = "";
            $erroresCategorias = "";
            $erroresCatRepetidas = "";
            $erroresCatVacias = "";
            $erroresTallas = "";
            $erroresColores = "";
            $erroresPeso = "";
            $erroresCosto = "";
            $erroresPrecio = "";
            

            $linea = 1;
            $lineaProducto = 0;

            //Revisar cada fila de la hoja de excel.
            foreach ($sheet_array as $row) {

                if ($row['A'] != "") {

                    if ($linea == 1) { // revisar los nombres / encabezados de las columnas
                        if ($row['A'] != "SKU")
                            $falla = "SKU";
                        else if ($row['B'] != "Referencia")
                            $falla = "Referencia";
                        else if ($row['C'] != "Marca")
                            $falla = "Marca";
                        if ($row['D'] != "Nombre")
                            $falla = "Nombre";
                        else if ($row['E'] != "Descripción")
                            $falla = "Descripción";
                        else if ($row['F'] != "Categorías")
                            $falla = "Categorías";
                        else if ($row['G'] != "Categorías")
                            $falla = "Categorías";
                        else if ($row['H'] != "Categorías")
                            $falla = "Categorías";
                        else if ($row['I'] != "Talla")
                            $falla = "Talla";
                        else if ($row['J'] != "Color")
                            $falla = "Color";
                        else if ($row['K'] != "Peso")
                            $falla = "Peso";                                                
                        else if ($row['L'] != "Costo sin iva")
                            $falla = "Costo";
                        else if ($row['M'] != "Precio Venta sin iva")
                            $falla = "Precio Venta";
                        else if ($row['N'] != "MetaDescripción")
                            $falla = "MetaDescripción";
                        else if ($row['O'] != "Meta tags")
                            $falla = "Meta tags";
                        else if ($row['P'] != "Almacén")
                            $falla = "Almacén";

                        if ($falla != "") { // algo falló
                            Yii::app()->user->updateSession();
                            Yii::app()->user->setFlash('error', UserModule::t("La columna <b>" .
                                            $falla . "</b> no se encuentra en el lugar que debe ir o está mal escrita"));                                   

                            return false;
                        }
                    }

                    /*si pasa las columnas entonces que revise
                    Marcas, categorias, tallas y colores.*/                          
                    if($linea > 1){
                        
                        $categoriasRepetidas = array();
                        $cantCategorias = 0;
                        
                        $row['K'] = str_replace(",", ".", $row['K']);
                        $row['L'] = str_replace(",", ".", $row['L']);
                        $row['M'] = str_replace(",", ".", $row['M']);                        
                        
                        //Peso
                        if(isset($row['K']) && $row['K'] != "" && !is_numeric($row['K'])){
                            $erroresPeso = "<li> <b>" . $row['K'] . "</b>, en la línea <b>" . $linea."</b></li>";                                                        
                        }
                        //Costo
                        if(isset($row['L']) && $row['L'] != "" && !is_numeric($row['L'])){
                            $erroresCosto = "<li> <b>" . $row['L'] . "</b>, en la línea <b>" . $linea."</b></li>";                                                        
                        }
                        //Precio
                        if(isset($row['M']) && $row['M'] != "" && !is_numeric($row['M'])){
                            $erroresPrecio = "<li> <b>" . $row['M'] . "</b>, en la línea <b>" . $linea."</b></li>";                                                        
                        }

                        //Marcas
                        if (isset($row['C']) && $row['C'] != "") {                        
                            $marca = Marca::model()->findByAttributes(array("nombre" => $row["C"]));

                            if (!isset($marca)) {
                                $erroresMarcas .= "<li> <b>" . $row['C'] . "</b>, en la línea <b>" . $linea."</b></li>";
                            }
                        }                    
                        
                        //Categorias
                        if (isset($row['F']) && $row['F'] != "") {                        
                            $categoria = Categoria::model()->findByAttributes(array("nombre" => $row["F"]));

                            if (!isset($categoria)) {
                                $erroresCategorias .= "<li> <b>" . $row['F'] . "</b>, en la línea <b>" . $linea."</b></li>";
                            }else{
                                //si esta repetida
                                $categoriasRepetidas[] = $categoria->id;
                            }
                            $cantCategorias++;                        
                        }                    
                        if (isset($row['G']) && $row['G'] != "") {                        
                            $categoria = Categoria::model()->findByAttributes(array("nombre" => $row["G"]));

                            if (!isset($categoria)) {
                                $erroresCategorias .= "<li> <b>" . $row['G'] . "</b>, en la línea <b>" . $linea."</b></li>";
                            }else{
                                //si existe y esta repetida
                                if (in_array($categoria->id, $categoriasRepetidas)) {
                                    $erroresCatRepetidas .= "<li> <b>" . $row['G'] . "</b>, en la línea <b>" . $linea."</b></li>";
                                }
                                $categoriasRepetidas[] = $categoria->id;
                            }
                            $cantCategorias++;
                        }                    
                        if (isset($row['H']) && $row['H'] != "") {                        
                            $categoria = Categoria::model()->findByAttributes(array("nombre" => $row["H"]));

                            if (!isset($categoria)) {
                                $erroresCategorias .= "<li> <b>" . $row['H'] . "</b>, en la línea <b>" . $linea."</b></li>";
                            }else{
                               if (in_array($categoria->id, $categoriasRepetidas)) {
                                    $erroresCatRepetidas .= "<li> <b>" . $row['H'] . "</b>, en la línea <b>" . $linea."</b></li>";
                                }                                
                                $categoriasRepetidas[] = $categoria->id;
                            }
                            $cantCategorias++;
                        }   
                                                
                        //tallas
                        if (isset($row['I']) && $row['I'] != "" ) {
                            $talla = Talla::model()->findByAttributes(array('valor' => $row['I']));

                            if (!isset($talla)) {
                                $erroresTallas .= "<li> <b>" . $row['I'] . "</b>, en la línea <b>" . $linea."</b></li>";
                            }
                        }
                        
                        //colores
                        if (isset($row['J']) && $row['J'] != "") {
                            $color = Color::model()->findByAttributes(array('valor' => $row['J']));

                            if (!isset($color)) {
                                $erroresColores .= "<li> <b>" . $row['J'] . "</b>, en la línea <b>" . $linea."</b></li>";
                            }	
                        }
                        
                        //la cantidad de categorias
                        if ($cantCategorias == 0){
                            $erroresCatVacias .= "<li> Línea <b>" . $linea."</b></li>";
                        }
                    
                        //sumar solo si la linea tiene algo
                        //y si esta por encima de la fila 1 (header)
                        $lineaProducto++;
                    }
                    
                }

                $linea++;
            }
            

            //Si hubo errores en marcas, cat, tallas, colores
            if($erroresCategorias != ""){
                $erroresCategorias = "Las siguientes Categorías no existen en la plataforma o están mal escritas:<br><ul>
                                 {$erroresCategorias}
                                 </ul><br>";
            }
            if($erroresCatRepetidas != ""){
                $erroresCatRepetidas = "Las siguientes Categorías están repetidas para el mismo producto:<br><ul>
                                 {$erroresCatRepetidas}
                                 </ul><br>";
            }
            if($erroresCatVacias != ""){
                $erroresCatVacias = "Los siguientes productos deben tener al menos una (1) categoría asociada:<br><ul>
                                 {$erroresCatVacias}
                                 </ul><br>";
            }
            if($erroresMarcas != ""){
                $erroresMarcas = "Las siguientes Marcas no existen en la plataforma o están mal escritas:<br><ul>
                                 {$erroresMarcas}
                                 </ul><br>";
            }
            if($erroresTallas != ""){
                $erroresTallas = "Las siguientes Tallas no existen en la plataforma o están mal escritas:<br><ul>
                                 {$erroresTallas}
                                 </ul><br>";
            }
            if($erroresColores != ""){
                $erroresColores = "Los siguientes Colores no existen en la plataforma o están mal escritos:<br><ul>
                                 {$erroresColores}
                                 </ul><br>";
            }
            
            //Errores numericos
            if($erroresPeso != ""){
                $erroresPeso = "Los siguientes Pesos están mal escritos, recuerde usar un solo punto (.) o coma (,):<br><ul>
                                 {$erroresPeso}
                                 </ul><br>";
            }
            if($erroresCosto != ""){
                $erroresCosto = "Los siguientes Costos están mal escritos, recuerde usar un solo punto (.) o coma (,):<br><ul>
                                 {$erroresCosto}
                                 </ul><br>";
            }
            if($erroresPrecio != ""){
                $erroresPrecio = "Los siguientes Precios están mal escritos, recuerde usar un solo punto (.) o coma (,):<br><ul>
                                 {$erroresPrecio}
                                 </ul><br>";
            }

                
            $errores = $erroresTallas .$erroresColores . $erroresMarcas .
                    $erroresCatRepetidas. $erroresCategorias . $erroresCatVacias.
                    $erroresPrecio . $erroresCosto . $erroresPeso;
            
            if($errores != ""){
                
                Yii::app()->user->updateSession();
                Yii::app()->user->setFlash('error', $errores);

                return false;                
            } 
            
            return array(
                "valid"=>true,
                "nProds"=>$lineaProducto,
                "nLineas"=>$linea-2,
                );            
        }
        
        protected function validarArchivoInbound($archivo){
            
            $sheet_array = Yii::app()->yexcel->readActiveSheet($archivo);

            $falla = "";
            $erroresSKU = "";
            $erroresCantidad = "";

            $linea = 1;                    
            foreach ($sheet_array as $row) {

                if ($row['A'] != "") {

                    if ($linea == 1) { // revisar los nombres / encabezados de las columnas
                        
                        if ($row['A'] != "SKU")
                            $falla = "SKU";
                        else if ($row['B'] != "Cantidad")
                            $falla = "Cantidad";                        

                        if ($falla != "") { // algo falló
                            Yii::app()->user->updateSession();
                            Yii::app()->user->setFlash('error', UserModule::t("La columna <b>" .
                                            $falla . "</b> no se encuentra el lugar correspondiente que debe ir o está mal escrita"));                                   

                            return false;
                        }
                    }

                    /*si pasa las columnas entonces que revise
                    SKU y Cantidad */                          
                    if($linea > 1){
                        
                        //SKU
                        if (isset($row['A']) && $row['A'] != "") {                        
                            $producto = Preciotallacolor::model()->findByAttributes(
                                    array("sku" => $row["A"]));

                            if (!isset($producto)) {
                                $erroresSKU .= "<li><b>" . $row['A'] . "</b>, en la línea <b>" . $linea."</b></li>";
                            }
                        }                    
                        //Cantidades
                        if (isset($row['B']) && $row['B'] != "") {                        
                            $row['B'] = strval($row['B']);
                            if (!ctype_digit($row['B']) || $row['B'] < 0){
                                $erroresCantidad .= "<li> <b>" . $row['B'] . "</b>, en la línea <b>" . $linea."</b></li>";
                            }
                        } 

                    }
                }

                $linea++;
            } 

            //Si hubo errores en marcas, cat, tallas, colores
            if($erroresSKU!= ""){
                $erroresSKU = "Los siguientes SKU no existen en la plataforma:<br><ul>
                                 {$erroresSKU}
                                 </ul><br>";
            }
            if($erroresCantidad!= ""){
                $erroresCantidad = "Las siguientes cantidades están mal escritas:<br><ul>
                                 {$erroresCantidad}
                                 </ul><br>";
            }

            if($erroresSKU != "" || $erroresCantidad != ""){

                $erroresSKU .= $erroresCantidad."No se ha cargado el archivo Inbound debido a que presenta errores.";
                Yii::app()->user->updateSession();
                Yii::app()->user->setFlash('error', $erroresSKU);

                return false;                
            } 
            
            return true;            
        }
        
        public function exportarExcelInbound($idMarca){
		
            Yii::import('ext.phpexcel.XPHPExcel');
            $objPHPExcel = XPHPExcel::createPHPExcel();

            $marca = Marca::model()->findByPk($idMarca);

            $objPHPExcel->getProperties()->setCreator("Personaling.com")
                                     ->setLastModifiedBy("Personaling.com")
                                     ->setTitle("Inbound $marca->nombre");

            // creando el encabezado
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'SKU')
                ->setCellValue('B1', 'Cantidad');

            //Poner autosize todas las columnas
            foreach(range('A','B') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }           
            
            //Formato del encabezado
            $title = array(
                'font' => array(
                    'size' => 14,
                    'bold' => true,
                    'color' => array(
                                'rgb' => '000000'
                            ),
                    ),
                'text-align' => array(
                    'horizontal' => 'center',
                ),
            );
            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($title);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($title);

            $objPHPExcel->getDefaultStyle()
                        ->getNumberFormat()
                        ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            
            //Consulta los sku de esta marca
            //Y los agrega al excel
            
            $prodsMarca = $marca->productos;
//            preciotallacolor
            $i = 0;
            foreach ($prodsMarca as $producto){
                
                $precioTallaColores = $producto->preciotallacolor;
                
                foreach ($precioTallaColores as $precTColor){                    
                    
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A'.($i + 2) ,$precTColor->sku) 
                        ->setCellValue('B'.($i + 2), 0);
                    //AGregar la fila al documento xls
                    $i++;
                }   
            }
            
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);

            // Redirect output to a clientâ€™s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Inbound '.$marca->nombre.'.xls"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0                        

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            Yii::app()->end();
				  
	}
        
}
