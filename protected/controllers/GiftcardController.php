<?php

class GiftcardController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        const DIGITOS_CODIGO = 15;
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','enviar'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','admin','delete','update'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Giftcard;

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(isset($_POST['Giftcard']))
		{
                    
                    $model->attributes = $_POST['Giftcard'];
                    $model->estado = 1;
                    $model->comprador = Yii::app()->user->id;
                    $model->codigo = "x";
                    
//                    echo "DAtos";
//                    echo "<pre>";
//                    print_r($model->attributes);
//                    echo "</pre>";
//
//                    Yii::app()->end();                    

                    if($model->validate()){
                        
                        do{  
                            $model->codigo = $this->generarCodigo();
                            $existe = Giftcard::model()->countByAttributes(array('codigo' => $model->codigo));                        
                            
                        }while($existe);
                        
                        if($model->save()){
                            $this->redirect(array('enviar','id'=>$model->id));
                        }
                        
                    }
			
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionEnviar($id){
            $model = $this->loadModel($id);
		$this->render('enviargiftcard', array('model' => $model));
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

		if(isset($_POST['Giftcard']))
		{
			$model->attributes=$_POST['Giftcard'];
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Giftcard');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Giftcard('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Giftcard']))
			$model->attributes=$_GET['Giftcard'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Giftcard the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Giftcard::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Giftcard $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='giftcard-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        private function generarCodigo(){
            $cantNum = 7;
            $cantLet = 8;
            
            $l = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            //$n = '0123456789';
            
            $LETRAS = str_split($l);
            $NUMEROS = range(0, 9);
            
            //aleatorizar numeros
//            shuffle($NUMEROS);            
//            //aleatorizar Letras
//            shuffle($LETRAS);
//            //            for ($i = 0, $result = ''; $i < $cantLet; $i++) {
////                $indice = rand(0, $letrasTotal - 1);
////                $result .= substr($chars, $indice, 1);
////            }
//            
//            
//            array_r
//            
//            $letrasTotal = strlen($LETRAS);
//            $numerosTotal = strlen($NUMEROS);

            $codigo = array();
            //Seleccionar cantLet letras
            for ($i = 0; $i < $cantLet; $i++) {
                $codigo[] = $LETRAS[array_rand($LETRAS)];
            }
            for ($i = 0; $i < $cantNum; $i++) {
                $codigo[] = array_rand($NUMEROS);
            }
            
            shuffle($codigo);
            
//            echo "LeTRAS";
//            echo "<pre>";
//            print_r($LETRAS);
//            echo "</pre>";
//            
//            echo "NUMEROS";
//            echo "<pre>";
//            print_r($NUMEROS);
//            echo "</pre>";

//            echo "alearorio<br>";
//            echo array_rand($LETRAS);


//            echo "<pre>";
//            print_r($codigo);
//            echo "</pre>";



            $codigo = implode("", $codigo);
            
//            echo $codigo;
//            Yii::app()->end();
            
            return $codigo;
        }
}
