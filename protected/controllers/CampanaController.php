<?php

class CampanaController extends Controller
{
	public function actionCreate()
	{
		$campana = new Campana;
		
		if(isset($_POST['Campana'])){
			$campana->attributes = $_POST['Campana'];
			$campana->fecha_creacion = date('Y-m-d H:i:s');
			
			if($campana->save()){
				if($_POST['personal_shopper'] == 'todos'){
					$list_ps = User::model()->findAllByAttributes(array('personal_shopper'=>1));
					foreach ($list_ps as $ps) {
						$campana_ps = new CampanaHasPersonalShopper;
						$campana_ps->campana_id = $campana->id;
						$campana_ps->user_id = $ps->id;
						$campana_ps->fecha_invitacion = date('Y-m-d H:i:s');
						$campana_ps->save();
					}
					Yii::app()->user->setFlash('success','Campaña guardada con éxito');
					$this->redirect(array('index'));
				}else if($_POST['personal_shopper'] == 'seleccionar'){
					Yii::app()->session['campana_id'] = $campana->id;
					$dataProvider=new CActiveDataProvider('User', array(
					    'criteria'=>array(
					            'condition'=>'personal_shopper=1',
					    ),
					));
					$this->render('select_ps', array('campana'=>$campana, 'dataProvider'=>$dataProvider));
				}
			}else{
				Yii::app()->user->setFlash('error','No se pudo guardar la campaña');
			}
		}
		
		if(isset($_POST['personal_shopper'])){
			if($_POST['personal_shopper'] == 'todos'){
					$list_ps = User::model()->findAllByAttributes(array('personal_shopper'=>1));
					foreach ($list_ps as $ps) {
						$campana_ps = CampanaHasPersonalShopper::model()->findByAttributes(array('campana_id'=>Yii::app()->session['campana_id'], 'user_id'=>$ps->id));
						if(!$campana_ps){
							$campana_ps = new CampanaHasPersonalShopper;
							$campana_ps->campana_id = Yii::app()->session['campana_id'];
							$campana_ps->user_id = $ps->id;
							$campana_ps->fecha_invitacion = date('Y-m-d H:i:s');
							$campana_ps->save();
						}
					}
					Yii::app()->user->setFlash('success','Campaña guardada con éxito');
					$this->redirect(array('index'));
			}
		}
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

	public function actionInvite(){
		if(isset($_POST['id'])){
			$campana_ps = CampanaHasPersonalShopper::model()->findByAttributes(array('campana_id'=>Yii::app()->session['campana_id'], 'user_id'=>$_POST['id']));
			if(!$campana_ps){
				$campana_ps = new CampanaHasPersonalShopper;
				$campana_ps->campana_id = Yii::app()->session['campana_id'];
				$campana_ps->user_id = $_POST['id'];
				$campana_ps->fecha_invitacion = date('Y-m-d H:i:s');
				$campana_ps->save();
			}
		}
	}

	public function actionUninvite(){
		if(isset($_POST['id'])){
			$campana_ps = CampanaHasPersonalShopper::model()->findByAttributes(array('campana_id'=>Yii::app()->session['campana_id'], 'user_id'=>$_POST['id']));
			if($campana_ps){
				$campana_ps->delete();
			}
		}
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