<?php

class AdornoController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
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
	
		public function actionGetImage($id)
	{
		$model = $this->loadModel($id);
		//$image_url = $model->getImageUrl(array('type'=>'thumb','ext'=>'png')); <--- este caso para cuando exista thumb
		$image_url = $model->getImageUrl(array('ext'=>'png'));
		list($width, $height, $type, $attr) = getimagesize(Yii::getPathOfAlias('webroot').'/..'.$image_url);		
		echo '<div class="new" id="adorno'.$id.'">';
		echo '<img '.$attr.' src="'.$image_url.'" alt>';
		echo '<input type="hidden" name="adorno_id" value="'.$id.'">';
		
		echo '</div>';
		//height="180" width="180"
		
	}
		public function loadModel($id)
	{
		$model=Adorno::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}