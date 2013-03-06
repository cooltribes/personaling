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
				'actions'=>array('admin','delete','precios','imagenes','multi','orden','eliminar','inventario','detalles','tallacolor','addtallacolor'),
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
			
		//	$in = substr($model->fInicio, 11, 5);	
			//$fin = substr($model->fFin, 11, 5);	

			//$model->horaInicio = Yii::app()->dateFormatter->formatDateTime($model->fInicio, false, 'medium');

		}
		else {
			$model=new Producto;	
		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Producto']))
		{
			$model->attributes=$_POST['Producto'];
			$model->status=1;
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
		}


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
		}
		
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

                    $image = Yii::app()->image->load($nombre . $extension);
                    $image->resize(640, 480);
                    $image->save($nombre . ".jpg");

                    $image = Yii::app()->image->load($nombre . $extension);
                    $image->resize(150, 150)->quality(40);
                    $image->save($nombre . "_thumb.jpg");
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
	        $datos=$datos."<td> Bs.".$precio->precioVenta; 
		else
        	$datos=$datos."<td>"; 

        $datos=$datos."</td></tr>";
        
        $datos=$datos."<tr>";
        $datos=$datos."<th scope='row'>Precio con descuento</th>";
		
		if($precio)
	        $datos=$datos."<td> Bs.".$precio->precioDescuento; 
		else
        	$datos=$datos."<td>"; 

        $datos=$datos."</td></tr>";
        
		$datos=$datos."<tr>";
        $datos=$datos."<th scope='row'>Descuento </th>";
		
		if($precio)
			if($precio->tipoDescuento==0)
	        	$datos=$datos."<td>".$precio->valorTipo."%";
			else
				$datos=$datos."<td> En Bs.";
		else
        	$datos=$datos."<td>"; 

        $datos=$datos."</td></tr>";
		
		$datos=$datos."<tr>";
        $datos=$datos."<th scope='row'>Total Descuento</th>";
		
		if($precio)
			if($precio)
				$datos=$datos."<td> Bs.".$precio->ahorro;
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
	public function actionInventario($id)
	{

		if(isset($_GET['id'])){
			if(!$inventario = Inventario::model()->findByAttributes(array('tbl_producto_id'=>$id)))
				$inventario=new Inventario;
			
			$model = Producto::model()->findByPk($id);
		}
		else {
			$inventario=new Inventario;
			$model = new Producto;
		}
		
		if(isset($_POST['Inventario']))
		{
			$inventario->attributes=$_POST['Inventario'];
			$inventario->tbl_producto_id = $id;
			
			if($inventario->save())
			{
				Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('success',UserModule::t("Los cambios han sido guardados."));
			}
			//	$this->redirect(array('view','id'=>$model->id));
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
		else{
			$model=Producto::model()->findByPk($id);
			$model->status = 0;
			$model->save();
			$this->redirect(array('admin'));
		}
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
 * Genera la fila para talla color
 */
	public function actionAddTallacolor(){
		if(isset($_GET['id'])){
			//if(!$inventario = Inventario::model()->findByAttributes(array('tbl_producto_id'=>$id)))
			//	$inventario=new Inventario;
			
			$model = Producto::model()->findByPk($id);
		}
		else {
			//$inventario=new Inventario;
			$model = new Producto;
		}		
		$this->render('tallacolor',array(
			'model'=>$model
		));
	}
/**
 * Manejador de Colors y Tallas
 */
	public function actionTallacolor(){
		if(isset($_GET['id'])){
			//if(!$inventario = Inventario::model()->findByAttributes(array('tbl_producto_id'=>$id)))
			//	$inventario=new Inventario;
			
			$model = Producto::model()->findByPk($id);
		}
		else {
			//$inventario=new Inventario;
			$model = new Producto;
		}		
		$this->render('tallacolor',array(
			'model'=>$model
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
