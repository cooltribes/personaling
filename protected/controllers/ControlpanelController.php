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
                                    'remuneraciones', 'personalshoppers'),
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
                $looks[$i]["porcentaje"] = ($looks[$i]["total"] / $total) * 100;
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

            /*Datos para las estadísticas*/
            $totalGeneradoComisiones = Yii::app()->db->createCommand()
                                       ->select("SUM(total)")->from("tbl_balance")
                                       ->where("tipo = 5")->queryScalar();
            
            $ventasGeneraronComision = Yii::app()->db->createCommand()
                                       ->select("count(distinct(orden_id))")->from("tbl_balance")
                                       ->where("tipo = 5")->queryScalar();
            
            $ventasNoGeneraronComision = Yii::app()->db->createCommand()
                                       ->select("count(distinct(orden_id))")->from("tbl_balance")
                                       ->where("tipo != 5")->queryScalar();
            
            $prodsVendidosComision = Yii::app()->db->createCommand(
                                        "SELECT IFNULL(SUM(o.cantidad), 0)
                                        FROM tbl_orden_has_productotallacolor o
                                        WHERE o.look_id > 0 AND o.tbl_orden_id IN 
                                        (SELECT DISTINCT(b.orden_id)
                                        FROM tbl_balance b
                                        WHERE tipo = 5)")->queryScalar();
            
            
            
            
            
            $model = new User('search');
            $model->unsetAttributes();  // clear any default values
            
            /*Enviar a la vista el listado de todos los PS*/
            $criteria = new CDbCriteria;
            $criteria->compare("personal_shopper", 1);

            $dataProvider = new CActiveDataProvider('User', array(
                'criteria' => $criteria,
                'pagination' => array(
                    'pageSize' => Yii::app()->getModule('user')->user_page_size,
                ),
            ));


            $this->render('personalShoppers', array(
                'model' => $model,                
                'dataProvider' => $dataProvider,
                'totalGeneradoComisiones' => $totalGeneradoComisiones,
                'ventasGeneraronComision' => $ventasGeneraronComision,
                'ventasNoGeneraronComision' => $ventasNoGeneraronComision,
                'prodsVendidosComision' => $prodsVendidosComision,
            ));
        }
        
        
        /* Ver el listado de personalshoppers con sus respectivos datos
         * relacionados a las comisiones
         */
        public function actionPersonalshoppers() {

            /*Datos para las estadísticas*/
            $totalGeneradoComisiones = Yii::app()->db->createCommand()
                                       ->select("SUM(total)")->from("tbl_balance")
                                       ->where("tipo = 5")->queryScalar();
            
            $ventasGeneraronComision = Yii::app()->db->createCommand()
                                       ->select("count(distinct(orden_id))")->from("tbl_balance")
                                       ->where("tipo = 5")->queryScalar();
            
            $ventasNoGeneraronComision = Yii::app()->db->createCommand()
                                       ->select("count(distinct(orden_id))")->from("tbl_balance")
                                       ->where("tipo != 5")->queryScalar();
            
            $prodsVendidosComision = Yii::app()->db->createCommand(
                                        "SELECT IFNULL(SUM(o.cantidad), 0)
                                        FROM tbl_orden_has_productotallacolor o
                                        WHERE o.look_id > 0 AND o.tbl_orden_id IN 
                                        (SELECT DISTINCT(b.orden_id)
                                        FROM tbl_balance b
                                        WHERE tipo = 5)")->queryScalar();
            
            $model = new User('search');
            $model->unsetAttributes();  // clear any default values
            
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
             if((isset($_SESSION['todoPost']) && !isset($_GET['ajax'])))
            {
                unset($_SESSION['todoPost']);
            }
            //Filtros personalizados
            $filters = array();
            
            //Para guardar el filtro
            $filter = new Filter;            
            
            if(isset($_GET['ajax']) && !isset($_POST['dropdown_filter']) && isset($_SESSION['todoPost'])
               && !isset($_POST['nombre'])){
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
                    
                     //si va a guardar
                     if (isset($_POST['save'])){                        
                         
                         //si es nuevo
                         if (isset($_POST['name'])){
                            
                            $filter = Filter::model()->findByAttributes(
                                    array('name' => $_POST['name'], 'type' => '3') 
                                    ); 
                            if (!$filter) {
                                $filter = new Filter;
                                $filter->name = $_POST['name'];
                                $filter->type = 3;
                                
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

                          
                         }
                         else if(isset($_POST['id'])){ /* si esta guardando uno existente */
                            
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


            $this->render('personalShoppers', array(
                'model' => $model,                
                'dataProvider' => $dataProvider,
                'totalGeneradoComisiones' => $totalGeneradoComisiones,
                'ventasGeneraronComision' => $ventasGeneraronComision,
                'ventasNoGeneraronComision' => $ventasNoGeneraronComision,
                'prodsVendidosComision' => $prodsVendidosComision,
            ));
        }
}
