<?php

class CampanaController extends Controller
{
	public function actionCreate()
	{
		$campana = new Campana;
		$this->render('create', array('campana'=>$campana));
	}

	public function actionDelete()
	{
		$this->render('delete');
	}

	public function actionEdit()
	{
		$this->render('edit');
	}

	public function actionIndex()
	{
		$campana = new Campana; 

		if (isset($_POST['query']))
		{
			$campana->nombre = $_POST['query'];
		}
		
		$dataProvider = $campana->search();
		$this->render('index',array(
			'model'=>$campana,
			'dataProvider'=>$dataProvider,
		));
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
}