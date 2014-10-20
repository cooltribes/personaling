<?php

class ControlpanelController extends Controller
{
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),			
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
                            'actions'=>array('index','delete','ventas',
                                'pedidos','usuarios', 'looks', 'productos','ingresos',
                                'remuneraciones', 'personalshoppers','seo','createSeo',
                                'deleteSeo', 'misventas','comisionesClic'),
                            //'users'=>array('admin'),
                            'expression' => 'UserModule::isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}	
	
	public function actionIndex() 
	{
		$this->render('index');
	}

	public function actionVentas()
	{
		$this->render('panel_ventas');
	}
	
	public function actionPedidos()
	{
		$this->render('pedidos');
	}

	public function actionUsuarios()
	{
		$this->render('usuarios');
	}
	
	public function actionIngresos()
	{
		$this->render('ingreso_usuarios');
	}
        
        public function actionLooks()
	{
            //Para obtener por estados
            $total = 0;
            $total += $looks[]["total"] = Look::model()->countByAttributes(array("status" => Look::STATUS_CREADO));
            $total += $looks[]["total"] = Look::model()->countByAttributes(array("status" => Look::STATUS_ENVIADO));
            $total += $looks[]["total"] = Look::model()->countByAttributes(array("status" => Look::STATUS_APROBADO));

            for ($i=0; $i<3;$i++) {
                if($total > 0){
                    $looks[$i]["porcentaje"] = ($looks[$i]["total"] / $total) * 100;
                }else{
                    $looks[$i]["porcentaje"] = 0;
                }
            }
            $looks[0]["nombre"] = "Borrador";
            $looks[1]["nombre"] = "Enviados";
            $looks[2]["nombre"] = "Aprobados";
            
            //Por visitas
            $views = Look::masVistos();
            
            
            /*************      Grafico MES       ****************/
            
            $ya = date('Y-m-d', strtotime('now'));                            	

            $valores = array();

            /*CREADOS*/
            $sql = "select count(*) from tbl_look where created_on between '".date('Y-m-d', strtotime($ya. ' -2 month'))."' and '".date('Y-m-d', strtotime($ya. ' -1 month'))."' ";
            $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
            $sql = "select count(*) from tbl_look where created_on between '".date('Y-m-d', strtotime($ya. ' -1 month'))."' and '".$ya."' ";
            $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
            $mes[] = $valores;

            /*ENVIADOS*/
            $valores = array();
            $sql = "select count(*) from tbl_look where sent_on between '".date('Y-m-d', strtotime($ya. ' -2 month'))."' and '".date('Y-m-d', strtotime($ya. ' -1 month'))."' ";
            $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
            $sql = "select count(*) from tbl_look where sent_on between '".date('Y-m-d', strtotime($ya. ' -1 month'))."' and '".$ya."' ";
            $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
            $mes[] = $valores;

            /*APROBADOS*/
            $valores = array();
            $sql = "select count(*) from tbl_look where approved_on between '".date('Y-m-d', strtotime($ya. ' -2 month'))."' and '".date('Y-m-d', strtotime($ya. ' -1 month'))."' ";
            $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
            $sql = "select count(*) from tbl_look where approved_on between '".date('Y-m-d', strtotime($ya. ' -1 month'))."' and '".$ya."' ";
            $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
            $mes[] = $valores;

           // de dos meses a un mes como primer punto del grafico
            $datesM[] = date('d-m-Y', strtotime($ya. ' -1 month'));            
            //hoy como segundo punto
            $datesM[] = date('d-m-Y', strtotime('now'));
            
            
            
            /*************      Grafico SEMANA       ****************/
            
            /*CREADOS*/
            $valores = array();
            
            for($i = -4; $i < 0; $i++){
                $sql = "select count(*) from tbl_look where created_on between '".
                        date('Y-m-d', strtotime($ya. " ". ($i - 1) . " week"))."' and '".date('Y-m-d', strtotime($ya. " {$i} week"))."' "; 
                        
                        $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
                        
                        $datesW[] = date('d-m-Y', strtotime(" {$i} week"));
            }            
            
            $sql = "select count(*) from tbl_look where created_on between '".date('Y-m-d', strtotime($ya. ' -1 week'))."' and '".$ya."' "; 
            $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
            
            $semana[] = $valores;
            
            $datesW[] = date('d-m-Y', strtotime('now'));
            
            
            /*ENVIADOS*/
            $valores = array();
            
            for($i = -4; $i < 0; $i++){
                $sql = "select count(*) from tbl_look where sent_on between '".
                        date('Y-m-d', strtotime($ya. " ". ($i - 1) . " week"))."' and '".date('Y-m-d', strtotime($ya. " {$i} week"))."' "; 
                        
                        $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
            }            
            
            $sql = "select count(*) from tbl_look where sent_on between '".date('Y-m-d', strtotime($ya. ' -1 week'))."' and '".$ya."' "; 
            $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
            
            $semana[] = $valores;
            
            
            /*APROBADOS*/
            $valores = array();
            
            for($i = -4; $i < 0; $i++){
                $sql = "select count(*) from tbl_look where approved_on between '".
                        date('Y-m-d', strtotime($ya. " ". ($i - 1) . " week"))."' and '".date('Y-m-d', strtotime($ya. " {$i} week"))."' "; 
                        
                        $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
            }            
            
            $sql = "select count(*) from tbl_look where approved_on between '".date('Y-m-d', strtotime($ya. ' -1 week'))."' and '".$ya."' "; 
            $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
            
            $semana[] = $valores;
            
           
            /*************      Grafico DIAS       ****************/
            /*CREADOS*/
            $valores = array();
            
            for($i = -30; $i < 0; $i++){
                $sql = "select count(*) from tbl_look where created_on between '".
                        date('Y-m-d', strtotime($ya. " ". ($i - 1) . " day"))."' and '".date('Y-m-d', strtotime($ya. " {$i} day"))."' "; 
                        
                        $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
                        
                        $datesD[] = date('d-m', strtotime(" {$i} day"));
            }            
            
            $sql = "select count(*) from tbl_look where created_on between '".date('Y-m-d', strtotime($ya. ' -1 day'))."' and '".$ya."' "; 
            $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
            
            $dia[] = $valores;
            
            $datesD[] = date('d-m', strtotime('now'));
            
            
            /*ENVIADOS*/
            
            $valores = array();
            
            for($i = -30; $i < 0; $i++){
                $sql = "select count(*) from tbl_look where sent_on between '".
                        date('Y-m-d', strtotime($ya. " ". ($i - 1) . " day"))."' and '".date('Y-m-d', strtotime($ya. " {$i} day"))."' "; 
                        
                        $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
                        
                     
            }            
            
            $sql = "select count(*) from tbl_look where sent_on between '".date('Y-m-d', strtotime($ya. ' -1 day'))."' and '".$ya."' "; 
            $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
            
            $dia[] = $valores;
            
            /*APROBADOS*/
            
            $valores = array();
            
            for($i = -30; $i < 0; $i++){
                $sql = "select count(*) from tbl_look where approved_on between '".
                        date('Y-m-d', strtotime($ya. " ". ($i - 1) . " day"))."' and '".date('Y-m-d', strtotime($ya. " {$i} day"))."' "; 
                        
                        $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
                        
                     
            }            
            
            $sql = "select count(*) from tbl_look where approved_on between '".date('Y-m-d', strtotime($ya. ' -1 day'))."' and '".$ya."' "; 
            $valores[] = (int) Yii::app()->db->createCommand($sql)->queryScalar();
            
            $dia[] = $valores;
                
//            $i = 0;
//            echo "HOy: " . $ya. " ". ($i - 1 ). " week";
//            echo "Fecha: " . date('Y-m-d', strtotime($ya. " ". ($i - 1) . " week")); 
//            Yii::app()->end();
            
            
            $this->render('looks', array(
                        'status' => $looks,
                        'views' => $views,
                        'mes' => $mes,
                        'datesM' => $datesM,
                        'semana' => $semana,
                        'datesW' => $datesW,
                        'dia' => $dia,
                        'datesD' => $datesD,                        
                        ));
            
            
	}
        
        public function actionProductos()
	{           
            
            //Por visitas
            $views = Producto::masVistos();
            $this->render('productos', array('views' => $views));
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
        
    /*Ver las estadisticas generales referentes a remuneraciones*/
    public function actionRemuneraciones() {

        
    }
    
    
    /* Ver el listado de personalshoppers con sus respectivos datos
     * relacionados a las comisiones
     */
    public function actionPersonalshoppers() {
        
        
        //Para hacer cambios masivas
        if(isset($_POST["action"])){                
            
            $response = array();
            //Obtener el criteria guardado de la ultima busqueda
            $resultados = Yii::app()->getSession()->get("resultado");
            $resultados->select = "t.*";
            
            $resultados = new CActiveDataProvider('User', array(
                'criteria' => $resultados,
            ));
            
	$resultados->setPagination(false);
             
            //$resultados->getData();
            $resultados = $resultados->getData();                
            $total = count($resultados);
            $error = false;

            if($_POST["action"] == 1){ //Cambiar comisión
                
                foreach($resultados as $usuario) {                        
                    
                    $perfil = $usuario->profile;
                    $perfil->profile_type = 5;
                    $perfil->comision = $_POST["cambiarVlComision"];
                    $perfil->tipo_comision = $_POST["cambiarTpComision"];
                    if(!$perfil->save()){
                        $error = true;
                    }  
                }
                
                if($error){                        
                    $response["status"] = "error";
                    $response["message"] = "¡Hubo un error cambiando las comisiones!";
                }else{                        
                    $response["status"] = "success";
                    $response["message"] = "¡Se ha actualizado la comisión de <b>$total</b>
                            Personal Shoppers!";                        
                }
                
            }else if($_POST["action"] == 2){ //cambiar tiempo de validez en bolsa
                
                foreach($resultados as $usuario) {
                    $perfil = $usuario->profile;
                    $perfil->profile_type = 5;
                    
                    $perfil->tiempo_validez = $_POST["cambiarLmTiempo"];                        
                    if(!$perfil->save()){
                        $error = true;
                    }
                }
                
                if($error){                        
                    $response["status"] = "error";
                    $response["message"] = "¡Hubo un error cambiando el tiempo de validez
                    en la bolsa!";
                }else{                        
                    $response["status"] = "success";
                    $response["message"] = "¡Se ha actualizado el tiempo de validez
                    en la bolsa para <b>$total</b> Personal Shoppers!";                        
                }                    
            } else if($_POST["action"] == 3){ //Cambiar pago por click
                
                foreach($resultados as $usuario) {        
                    
                    $perfil = $usuario->profile;
                    $perfil->profile_type = 5;
                    $perfil->pago_click = $_POST["totalClick"];
                    
                    if(!$perfil->save()){
                        $error = true;
                    }  
                }
                
                if($error){                        
                    $response["status"] = "error";
                    $response["message"] = "¡Hubo un error cambiando las comisiones!";
                }else{                        
                    $response["status"] = "success";
                    $response["message"] = "¡Se ha actualizado la comisión de <b>$total</b>
                            Personal Shoppers!";                        
                }
                
            } 
            
            echo CJSON::encode($response); 
            Yii::app()->end();
            
        }

        /*Datos para las estadísticas*/ 
        
        $ventasGeneraronComision = Yii::app()->db->createCommand()
                                   ->select("COUNT(DISTINCT(tbl_orden_id))")
                                   ->from("tbl_orden_has_productotallacolor")
                                   ->where("status_comision = 2")                                       
                                   ->queryScalar();
        
        $ventasNoGeneraronComision = Yii::app()->db->createCommand()
                                   ->select("COUNT(DISTINCT(tbl_orden_id))")
                                   ->from("tbl_orden_has_productotallacolor")
                                   ->where("status_comision = 0")
                                   ->andWhere("devolucion_id = 0")
                                   ->andWhere("look_id > 0")
                                   ->queryScalar();
        
         $totalGeneradoComisiones = Yii::app()->db->createCommand()
                                   ->select("count(distinct(orden_id))")->from("tbl_balance")
                                   ->where("tipo = 5")->queryScalar();
        
         $prodsVendidosComision = Yii::app()->db->createCommand(
                                    "SELECT IFNULL(SUM(o.cantidad), 0)
                                    FROM tbl_orden_has_productotallacolor o
                                    WHERE o.status_comision = 2")
                                    ->queryScalar();
                      
         $psConVentas = Yii::app()->db->createCommand()
                       ->select("COUNT(DISTINCT(l.user_id))")
                       ->from(array("tbl_orden_has_productotallacolor o", "tbl_look l"))
                       ->where("o.look_id = l.id")                                       
                       ->andWhere("status_comision = 2")                                       
                       ->queryScalar();
        /*FIN de los datos para estadisticas*/           
        
        
        $model = new User('search');
        $model->unsetAttributes();  
        
        /*Enviar a la vista el listado de todos los PS*/
        $criteria = new CDbCriteria;
        $criteria->compare("personal_shopper", 1);

        $dataProvider = new CActiveDataProvider('User', array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->getModule('user')->user_page_size,
            ),
        ));
        
        /*********************** Para los filtros *********************/
        Filter::procesarFiltros(8, $dataProvider, $model, 'nombre');

        if (isset($_GET['nombre'])) {       
            unset($_SESSION["todoPost"]);
            $criteria->alias = 'User';
            $criteria->join = 'JOIN tbl_profiles p ON User.id = p.user_id AND (p.first_name LIKE "%' . $_GET['nombre'] . '%" OR p.last_name LIKE "%' . $_GET['nombre'] . '%" OR User.email LIKE "%' . $_GET['nombre'] . '%")';                                
            
            $dataProvider = new CActiveDataProvider('User', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => Yii::app()->getModule('user')->user_page_size,
                ),
            ));
            
        
        }

        //guardar los usuarios para las acciones masivas
        Yii::app()->getSession()->add("resultado", $dataProvider->getCriteria());
        
        $this->render('personalShoppers', array(
            'model' => $model,                
            'dataProvider' => $dataProvider,
            'totalGeneradoComisiones' => $totalGeneradoComisiones,
            'ventasGeneraronComision' => $ventasGeneraronComision,
            'ventasNoGeneraronComision' => $ventasNoGeneraronComision,
            'prodsVendidosComision' => $prodsVendidosComision,
            'psConVentas' => $psConVentas,
        ));
        
    }
    
    
    /* Ver el listado de productos vendidos con su detalles de comision
     * Ver algunos datos generales sobre las ventas de un PS determinado
     */
    public function actionMisventas($id) {
        
        $personalShopper = User::model()->findByPk($id); 
        //Que solo puedan entrar los admin y el propietario PS
//        if($personalShopper===null || 
//                (UserModule::isPersonalShopper() && $id != Yii::app()->user->id))
//                throw new CHttpException(404,'The requested page does not exist.');
        if($personalShopper===null)
                throw new CHttpException(404,'The requested page does not exist.');
        
        $producto = new OrdenHasProductotallacolor;

        $dataProvider = $producto->vendidosComision($id);
        
        $this->render('misVentas',array(
                    'personalShopper' => $personalShopper,
                    'dataProvider'=>$dataProvider,
        ));	
        
    }

    /* Ver el listado de comisiones pagadas por clic de un PS determinado */
    public function actioncomisionesClic($id) {
        
        $personalShopper = User::model()->findByPk($id); 
        //Que solo puedan entrar los admin y el propietario PS
        if($personalShopper===null)
                throw new CHttpException(404,'The requested page does not exist.');
        
        $balance = New Balance;
        $balance->user_id = $id;
        $balance->tipo = 11;

        $dataProvider = $balance->search();
        
        $this->render('comisionesClic',array(
                    'personalShopper' => $personalShopper, 
                    'dataProvider'=>$dataProvider,
        ));         
    }

    public function actionSeo(){
        $model = new SeoStatic;
        $dataProvider = $model->search();
        
        if (isset($_POST['query'])){
                $model->nombre = $_POST['query'];
                $dataProvider = $model->busquedaNombreReferencia($_POST['query']);
        }   

        $this->render('seo', array(
            'model'=>$model,
            'dataProvider'=>$dataProvider,
        )); 
    }

    public function actionCreateSeo(){
        if(isset($_GET['id'])){
            $model = SeoStatic::model()->findByPk($_GET['id']);
        }else{
            $model = new SeoStatic;
        }
        
        
        if(isset($_POST['SeoStatic'])){
            $model->attributes = $_POST['SeoStatic'];
            
            
            if($model->save()){
                Yii::app()->user->setFlash('success','Elemento guardado con éxito');
                $this->redirect(array('seo'));
            }else{
                Yii::app()->user->setFlash('error','No se pudo guardar el elemento');
            }
        }

        $this->render('createSeo', array(
            'model'=>$model
        ));
    }

    public function actionDeleteSeo(){
        if(isset($_GET['id'])){
            $model = SeoStatic::model()->findByPk($_GET['id']);
            if($model){
                if($model->delete()){
                    Yii::app()->user->setFlash('success','Elemento eliminado con éxito');
                }else{
                    Yii::app()->user->setFlash('error','No se pudo eliminar el elemento');
                }
            }else{
                Yii::app()->user->setFlash('error','Petición no válida');
            }
        }else{
            Yii::app()->user->setFlash('error','Petición no válida');
        }
        $this->redirect(array('seo'));
    }
        
}
