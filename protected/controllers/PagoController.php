<?php

class PagoController extends Controller
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
			'postOnly + delete', // we only allow deletion via POST request
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('solicitar','index'),
				'expression'=>"UserModule::isPersonalShopper()",
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','view', 'detalle'),
				'expression'=>"UserModule::isAdmin()",
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
	 * Crear una nueva solicitud
	 */
	public function actionSolicitar()
	{
		$model = new Pago;
                $user = User::model()->findByPk(Yii::app()->user->id);
                
		if(isset($_POST['Pago']))
		{
			$model->attributes = $_POST['Pago'];
                        $model->user_id = Yii::app()->user->id;
                        $model->fecha_solicitud = date("Y-m-d H:i:s");
                        
                        //si metodo de pago es paypal
                        if($model->tipo == 0){                            
                            //poner el nombre del banco "PAYPAL"
                            $model->entidad = "PayPal";                            
                        }
                        
                        //Validar con el saldo disponible
                        
                        if($model->save()){
//                            $this->redirect(array('view','id'=>$model->id));
                            //Bloquear saldo
                            //Notificar a operaciones
                            $this->redirect(array('index'));
                            
                        }
                            
		}

                
                
		$this->render('solicitar',array(
			'model'=>$model,
			'user'=>$user,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionDetalle($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pago']))
		{
			$model->attributes=$_POST['Pago'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('detalle',array(
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Para el listado que ve el PS
	 */
	public function actionIndex()
	{
            $pago = new Pago();
            //Buscar mis solicitudes y pagos
            $pago->unsetAttributes();
            $pago->user_id = Yii::app()->user->id;
            $dataProvider = $pago->search();
                
            $this->render('index',array(
                'dataProvider'=>$dataProvider,
            ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Pago('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pago']))
			$model->attributes=$_GET['Pago'];
                
                $dataProvider = $model->search();

		$this->render('admin',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Pago the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Pago::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Pago $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pago-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
