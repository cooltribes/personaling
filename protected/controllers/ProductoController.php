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
				'actions'=>array('index','view','detalle','tallas','colores','imagenColor'), 
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','precios','producto','imagenes','multi','orden','eliminar','inventario','detalles','tallacolor','addtallacolor','varias','categorias','recatprod'),
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
				 	'proveedor'=>$_POST['Producto']['proveedor'],
				 	'descripcion'=>$_POST['Producto']['descripcion'],
				 	'estado'=>$_POST['Producto']['estado'],
				 	'fInicio'=>$_POST['Producto']['fInicio'],
					'fFin'=>$_POST['Producto']['fFin']
					));
					
					Yii::app()->user->updateSession();
					Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
					
					$this->redirect(array('create','id'=>$exist->id));
					
			}
			else // nuevo
			{
				$model->attributes=$_POST['Producto'];
				$model->status=1;
				if($model->save())
				{
					Yii::app()->user->updateSession();
					Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
					
				}
			}
			
			
				//$this->redirect(array('view','id'=>$model->id));
		}
//echo $model->fFin;
		$this->render('create',array(
			'model'=>$model,
		));
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
				}
				//	$this->redirect(array('view','id'=>$model->id));
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
			}
		}//else
		
		$this->render('_view_imagenes',array(
			'model'=>$model,'imagen'=>$imagen,
		));
	}
	
	// carga de imagenes
	public function actionMulti() {
				
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
		                $extension = ".jpg";

		                if ($pic->saveAs($nombre . $extension)) {
		
		                    $imagen->url = '/images/producto/'. $id .'/'. $imagen->id .".jpg";
		                    $imagen->save();
							
							Yii::app()->user->updateSession();
							Yii::app()->user->setFlash('success',UserModule::t("La imágen ha sido cargada exitosamente."));
			
							$image = Yii::app()->image->load($nombre . $extension);
		                    $image->save($nombre . "_orig.jpg"); 
				
							$image = Yii::app()->image->load($nombre . $extension); 
		                    $image->resize(770, 770);
		                    $image->save($nombre . ".jpg");
		
		                    $image = Yii::app()->image->load($nombre . $extension);
		                    $image->resize(200, 200)->quality(40);
		                    $image->save($nombre . "_thumb.jpg");
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
	        $datos=$datos."<td> Bs.".Yii::app()->numberFormatter->formatDecimal($precio->precioVenta); 
		else
        	$datos=$datos."<td>"; 

        $datos=$datos."</td></tr>";
        
        $datos=$datos."<tr>";
        $datos=$datos."<th scope='row'>Precio con descuento</th>";
		
		if($precio)
	        $datos=$datos."<td> Bs.".Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento); 
		else
        	$datos=$datos."<td>"; 

        $datos=$datos."</td></tr>";
        
		$datos=$datos."<tr>";
        $datos=$datos."<th scope='row'>Descuento </th>";
		
		if($precio)
			if($precio->tipoDescuento==0)
	        	$datos=$datos."<td>".Yii::app()->numberFormatter->formatDecimal($precio->valorTipo)."%";
			else
				$datos=$datos."<td> En Bs.";
		else
        	$datos=$datos."<td>"; 

        $datos=$datos."</td></tr>";
		
		$datos=$datos."<tr>";
        $datos=$datos."<th scope='row'>Total Descuento</th>";
		
		if($precio)
			if($precio)
				$datos=$datos."<td> Bs.".Yii::app()->numberFormatter->formatDecimal($precio->ahorro); 
			else
        		$datos=$datos."<td>"; 

        $datos=$datos."</td></tr>";
		$datos=$datos."</table><hr/>";
		
		$datos=$datos."<h4>Estadísticas</h4>";	
     	$datos=$datos."<table width='100%' border='0' cellspacing='0' cellpadding='0' class='table table-bordered table-condensed'>";
        $datos=$datos."<tr>";
        $datos=$datos."<th scope='row'>Vistas</th>";
		$datos=$datos."<td> 120";
        $datos=$datos."</td></tr>";
        
        $datos=$datos."<tr>";
        $datos=$datos."<th scope='row'>Looks que lo usan</th>";
		$datos=$datos."<td> 18";
		$datos=$datos."</td></tr>";
		$datos=$datos."</table>";
		$datos=$datos."</div></div>";
		// fin del body
		
		$datos=$datos."<div class='modal-footer'>";
		$datos=$datos."<a href='delete/".$producto->id."' title='eliminar' class='btn'><i class='icon-trash'></i> Eliminar</a>";
		$datos=$datos."<a href='#' title='Exportar' class='btn'><i class='icon-share-alt'></i> Exportar</a>";
		$datos=$datos."<a href='create/".$producto->id."' title='editar' class='btn'><i class='icon-edit'></i> Editar</a>";
		$datos=$datos."<a href='' title='ver' class='btn btn-info' target='_blank'><i class='icon-eye-open icon-white'></i> Ver</a> ";
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


	public function actionAdmin()
	{
		/* if(isset($_GET['caso'])){
			$caso = $_GET['caso'];
		
			if($caso==1)
			{
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('error',UserModule::t("Seleccione al menos un producto."));
			}
			
			if($caso==2)
			{
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('error',UserModule::t("Seleccione una acción"));
			}
			
			if($caso==3)
			{
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('success',UserModule::t("Los productos han sido activados."));
			}
		}// isset */
		
		$producto = new Producto; 

		if (isset($_POST['query']))
		{
			//echo($_POST['query']);	
			$producto->nombre = $_POST['query'];
		}	
		
		$producto->status = 1;
		
		$dataProvider = $producto->search();
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
			$tallas = explode(',',$_POST['tallas']);
			$colores = explode(',',$_POST['colores']);
			
		}
		$i = 0;
		foreach($tallas as $talla){
			foreach($colores as $color){
				$tallacolor[$i]= new Preciotallacolor;
				$color_tmp = Color::model()->findByAttributes(array('valor'=>$color));
				if (isset($color)){
					$tallacolor[$i]->color_id = $color_tmp->id;
					$tallacolor[$i]->color = $color_tmp->valor;
				}
				$talla_tmp = Talla::model()->findByAttributes(array('valor'=>$talla));
				if (isset($color)){
					$tallacolor[$i]->talla_id = $talla_tmp->id;
					$tallacolor[$i]->talla = $talla_tmp->valor;
				}
				
				
				$i++;
			//$this->renderPartial('_view_tallacolor',array('color'=>$color,'talla'=>$talla));
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
	                                  'status'=>'success'
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
	public function actionDetalle($id)
	{
		$producto = Producto::model()->findByPk($id);
		
		$this->render('_view_detalle',array('producto'=>$producto));

	}
	
	/**
 * Consigue las tallas al presionar un color
 */
	public function actionTallas()
	{
		$tallas = array();
		$imgs = array(); // donde se van a ir las imagenes
		
		$ptc = PrecioTallaColor::model()->findAllByAttributes(array('color_id'=>$_POST['idTalla'],'producto_id'=>$_POST['idProd']));
		
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
		
			//print_r($tallas);
		
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
		
		$ptc = PrecioTallaColor::model()->findAllByAttributes(array('talla_id'=>$_POST['idColor'],'producto_id'=>$_POST['idProd']));
		
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
				
				foreach($checks as $idCateg){
						
					if(!$prodCat = CategoriaHasProducto::model()->findByAttributes(array('tbl_producto_id'=>$idProducto,'tbl_categoria_id'=>$idCateg))) // reviso si ya esta en la BD esa asignacion
					{
						$prodCat = new CategoriaHasProducto;
						$prodCat->tbl_categoria_id = $idCateg; //id Categoria cambia en el foreach
						$prodCat->tbl_producto_id = $idProducto; // producto igual para todos
										
						$prodCat->save();
						//Producto::model()->updateByPk($id, array('estado'=>'0'));					
					}	
					// si ya está la ignora
					//$prodCat = new CategoriaHasProducto;
				}
				echo("ok"); // realizo la relación
			}
		}
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
