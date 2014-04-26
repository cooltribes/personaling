<?php

class DireccionController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','editar','cargarCiudades','addDireccion','decode','cargarProvincias','cargarCodigos'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
	
	public function actionCargarCiudades(){
		if(isset($_POST['provincia_id'])){
			$ciudades = Ciudad::model()->findAllBySql("SELECT * FROM tbl_ciudad WHERE provincia_id =".$_POST['provincia_id']." AND cod_zoom IS NOT NULL order by nombre ASC");
			if(sizeof($ciudades) > 0){
				$return = '<option>'.Yii::t('contentForm','Select a city').'</option>';
				foreach ($ciudades as $ciudad) {
					$return .= '<option value="'.$ciudad->id.'">'.$ciudad->nombre.'</option>';
				}
				echo $return;
			}
		}
	}
	 
	public function actionCargarCodigos(){
		if(isset($_POST['ciudad_id'])){
			$codigos= CodigoPostal::model()->findAllBySql("SELECT * FROM tbl_codigo_postal WHERE ciudad_id =".$_POST['ciudad_id']);
			if(sizeof($codigos) > 0){
				$return = '<option>'.Yii::t('contentForm','Select a zip code').'</option>';
				foreach ($codigos as $codigo) {
					$return .= '<option value="'.$codigo->id.'">'.$codigo->codigo.'</option>';
				}
				echo $return;
			}
		}
	}
	
	public function actionCargarProvincias(){
		if(isset($_POST['pais_id'])){
			$provincias = Ciudad::model()->findAllBySql("SELECT * FROM tbl_provincia WHERE pais_id =".$_POST['pais_id']." order by nombre ASC");
			if(sizeof($provincias) > 0){
				$return = '<option value>'.Yii::t('contentForm','Select a province').'</option>';
				foreach ($provincias as $provincia) {
					$return .= '<option value="'.$provincia->id.'">'.$provincia->nombre.'</option>';
				}
				echo $return;
			}
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id = null)
	{
		if(!$id){
			$model=new Direccion;
		}else{
			$model = Direccion::model()->findByPk($id);
		}
		
		if(isset($_POST['Direccion']))
		{
			$model->attributes=$_POST['Direccion'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
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

		if(isset($_POST['Direccion']))
		{
			$model->attributes=$_POST['Direccion'];
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
		$dataProvider=new CActiveDataProvider('Direccion');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Direccion('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Direccion']))
			$model->attributes=$_GET['Direccion'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	public function actionAddDireccion($user){
		$direccion=new Direccion;
		$direccion->attributes=$_POST;
		$direccion->codigo_postal_id=$_POST['codigo_postal_id'];
		if($direccion->save()){
			$direcciones = Direccion::model()->findAllByAttributes(array('user_id'=>$direccion->user_id));
			echo '<legend >'
				.Yii::t('contentForm','Addresses used above').': </legend>'
				.$this->renderPartial('/bolsa/_direcciones', array(
	       			'direcciones'=>$direcciones,'user'=>$user, 'iddireccionNueva' =>$direccion->id ),true)
	       		."<script> $('#direccionUsada').submit(function(e) {
	       			if($('#billAdd').val()=='0'){
    			e.preventDefault();
    			alert('Debes seleccionar una dirección de Facturación');
	    		}
	    		else{ $('#direccionUsada').submit();}});
	 			$('.billingAddress').change(function(){
	 				$('.hidBill').val($(this).val());
	 				$('.billingAddress').attr('checked', false);
	 				$(this).attr('checked','checked');});
				 </script>";
		}
		
	}
	
	public function actionProvinciasSeur(){
		$soapclient = new SoapClient('https://ws.seur.com/WSEcatalogoPublicos/servlet/XFireServlet/WSServiciosWebPublicos?wsdl');
		$params2 = array(
			'in0'=>'',
			'in1'=>'',
			'in2'=>'',
			'in3'=>'WSPERSONALING',
			'in4'=>'ORACLE',
			
			);
		$response = $soapclient->infoProvinciasStr($params2);
		$xml = simplexml_load_string($response->out);
		foreach ($xml as $reg){
			/*
			$provincia= new Provincia;
			$provincia->nombre=utf8_decode($reg->NOM_PROVINCIA);
			$provincia->pais_id;*/
			print_r($reg);
			echo"<br/><br/>";
			/*
			if($provincia->save())
				echo "OK <br/>";
			else
				echo "BAD <br/>";*/
		}
		
	}
	
	public function actionPoblacionesSeur(){
		$soapclient = new SoapClient('https://ws.seur.com/WSEcatalogoPublicos/servlet/XFireServlet/WSServiciosWebPublicos?wsdl');
		$params4 = array(
			'in0'=>'',
			'in1'=>'%%',
			'in2'=>'',
			'in3'=>'',
			'in4'=>'',
			'in5'=>'WSPERSONALING',
			'in6'=>'ORACLE',
			
			);
		$response = $soapclient->infoPoblacionesCortoStr($params4);
		$xml = simplexml_load_string($response->out);
		foreach ($xml as $reg){
			
			$provincia= Provincia::model()->findByAttributes(array('nombre'=>utf8_encode($reg->NOM_PROVINCIA)));
			if(!is_null($provincia)){
				$ciudad= new Ciudad;
				$ciudad->nombre=utf8_decode($reg->NOM_POBLACION);
				$ciudad->provincia_id=$provincia->id;
				$ciudad->ruta_id=$provincia->pais_id;
				$ciudad->cod_zoom=0;
				/*	
				if($ciudad->save())
					echo "OK <br/>";
				else
					echo "BAD <br/>";*/
			}
			else
					echo "WORSE <br/>";
			
			
		}
		
	}
	public function actionDecode(){
	$soapclient = new SoapClient('https://ws.seur.com/WSEcatalogoPublicos/servlet/XFireServlet/WSServiciosWebPublicos?wsdl');
		$all=Ciudad::model()->findAll(array(
		    'condition'=>" ruta_id>4 AND id NOT IN (select distinct(ciudad_id) from tbl_codigo_postal )"
		    ));
			$i=1;
		foreach($all as $city){

			$params4 = array(
			'in0'=>'',
			'in1'=>'%%' , 
			'in2'=>'',
			'in3'=>'',
			'in4'=>'',
			'in5'=>'WSPERSONALING',
			'in6'=>'ORACLE',
			
			);
			$response = $soapclient->infoPoblacionesCortoStr($params4);
			$xml = simplexml_load_string($response->out);
			foreach ($xml as $reg){
				echo $i.' <b>'.$city->nombre."</b> ----> ".utf8_decode($reg->NOM_POBLACION)."<br/>";
			
			}
			
			
			
		}
		
			
	}
	public function actionCodigosPostalesSeur(){
		$soapclient = new SoapClient('https://ws.seur.com/WSEcatalogoPublicos/servlet/XFireServlet/WSServiciosWebPublicos?wsdl');
		$all=Ciudad::model()->findAll(array(
		    'condition'=>'ruta_id > 4 AND id NOT IN (select distinct(ciudad_id) from tbl_codigo_postal )'
		    ));
			
		foreach($all as $city){
			print_r('<b>'.$city->nombre.'</b><br/>');
			$params4 = array(
			'in0'=>'',
			'in1'=>$city->nombre, 
			'in2'=>'',
			'in3'=>'',
			'in4'=>'',
			'in5'=>'WSPERSONALING',
			'in6'=>'ORACLE',
			
			);
			$response = $soapclient->infoPoblacionesCortoStr($params4);
			$xml = simplexml_load_string($response->out);
			foreach ($xml as $reg){
				$codigo=new CodigoPostal;
				$codigo->codigo=$reg->CODIGO_POSTAL;
				$codigo->ciudad_id=$city->id;
				/*if($codigo->save())
					echo "OK<br/>";
				else	
					echo "BAD<br/>";*/
			}
			echo "<br/><br/>";
			
			
		}
		
		
		
	
		
		
	}
	
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Direccion::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='direccion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
