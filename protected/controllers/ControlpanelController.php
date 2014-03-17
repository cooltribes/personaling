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
                                    'remuneracion'),
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
        
        public function actionRemuneracion() {

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


            $this->render('remuneracion', array(
                'model' => $model,                
                'dataProvider' => $dataProvider,
            ));
        }
}
