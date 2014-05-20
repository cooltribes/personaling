<?php

class MarcaController extends Controller
{
	
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
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','crear','delete'),
				//'users'=>array('admin'),
				'expression' => 'UserModule::isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			), 
		);
	}
	
	public function actionAdmin()
	{
		$marca = new Marca; 

		if (isset($_POST['query']))
		{
			//echo($_POST['query']);	
			$marca->nombre = $_POST['query'];
		}
		
		$dataProvider = $marca->search();
		$this->render('admin',
			array('marca'=>$marca,
			'dataProvider'=>$dataProvider,
		));	
	}

	
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionCrear($id = null)
	{
		if(!$id){
			$marca = new Marca;
		}else{
			$marca = Marca::model()->findByPk($id);
		}
		
		if(isset($_POST['Marca'])){
			
			$marca->attributes = $_POST['Marca'];
			if(isset($_POST['Marca']['ciudad_id'])){				
				$marca->contacto= $_POST['Marca']['contacto'];	
				$marca->cif= $_POST['Marca']['cif'];
				$marca->dirUno = $_POST['Marca']['dirUno'];
				$marca->dirDos = $_POST['Marca']['dirDos'];
				$marca->telefono = $_POST['Marca']['telefono'];
				$marca->ciudad_id = $_POST['Marca']['ciudad_id'];
				$marca->provincia_id = $_POST['Marca']['provincia_id'];
				$marca->pais = $_POST['Marca']['pais'];
				if(isset($_POST['Marca']['codigo_postal_id']))
					$marca->codigo_postal_id = $_POST['Marca']['codigo_postal_id'];
				$marca->setScenario('adicional');
				if($marca->validate()){
					$marca->save();
					$adicional="<br/>".Yii::t('contentForm','Contact information succesfully saved');	
				}else{
					unset($marca);
					$adicional="<br/>".Yii::t('contentForm','Contact information could not been saved');	
					if(!$id){
						$marca = new Marca;
					}else{
						$marca = Marca::model()->findByPk($id);
					}
					
				}
				
			}
			else
				$adicional="";
			//$marca->urlImagen = $_POST['Marca']['Urlimagen'];
		
			echo($_POST['url']);
		
			if(!is_dir(Yii::getPathOfAlias('webroot').'/images/marca/'))
				{
	   				mkdir(Yii::getPathOfAlias('webroot').'/images/marca/',0777,true);
	 			}
			
			$rnd = rand(0,9999);  
			$images=CUploadedFile::getInstanceByName('url');
			
			var_dump($images);
			echo "<br>".count($images);
			if (isset($images) && count($images) > 0) {
				$marca->urlImagen = "{$rnd}-{$images}";
				
				$marca->save();
				if(isset($_POST['chic']))	{
						$cmarca=new ClasificacionMarca;
						$cmarca->clasificacion=1;
						$cmarca->marca_id=$marca->id;
						$cmarca->save();
				}
				else {
					if($marca->is_100chic){
							$cmarca=ClasificacionMarca::model()->findByPk(array('marca_id'=>$marca->id,'clasificacion'=>1));
							$cmarca->delete();			
						}
				}
		        
		        $nombre = Yii::getPathOfAlias('webroot').'/images/marca/'.$marca->id;
		        $extension_ori = ".jpg";
				$extension = '.'.$images->extensionName;
		       
		       	if ($images->saveAs($nombre . $extension)) {
		
		       		$marca->urlImagen = $marca->id .$extension;
		            $marca->save();
									
							
					Yii::app()->user->setFlash('success',UserModule::t("Marca guardada exitosamente.").$adicional);

					$image = Yii::app()->image->load($nombre.$extension);
					$image->resize(150, 150);
					$image->save($nombre.'_thumb'.$extension);
					
					if($extension == '.png'){
						$image = Yii::app()->image->load($nombre.$extension);
						$image->resize(150, 150);
						$image->save($nombre.'_thumb.jpg');
					}	
					
				}
				else {
		        	$marca->delete();
				}
		        
			}else{
		    	if($marca->save()){
		    		if(isset($_POST['chic']))	{
			    		if(!$marca->is_100chic){
							$cmarca=new ClasificacionMarca;
							$cmarca->clasificacion=1;
							$cmarca->marca_id=$marca->id;
							$cmarca->save();				
						}
					}
				else {
					if($marca->is_100chic){
							$cmarca=ClasificacionMarca::model()->findByPk(array('marca_id'=>$marca->id,'clasificacion'=>1));
							$cmarca->delete();			
						}
				}
		        	Yii::app()->user->setFlash('success',UserModule::t("Marca guardada exitosamente.").$adicional);
					
					
		        }else{
		        	Yii::app()->user->setFlash('error',UserModule::t("Marca no pudo ser guardada.").$adicional);
		        }
			}// isset
			
		                
		                
		                
		                $this->redirect(array('admin'));
			}
		
		
		$this->render('crear',array('marca'=>$marca));
	}



	public function actionDelete($id)
	{
		$marca = Marca::model()->findByPk($id);
		$sql = "select count(*) from tbl_producto WHERE marca_id = ".$id;
		$num = Yii::app()->db->createCommand($sql)->queryScalar();
		
		if($num<1){
			if($marca->delete()){
				Yii::app()->user->setFlash('success',UserModule::t("Marca eliminada exitosamente."));
			}else{
				Yii::app()->user->setFlash('error',UserModule::t("Marca no pudo ser eliminada."));
			}
		}else{
			Yii::app()->user->setFlash('error',UserModule::t("Marca no puede ser eliminada. Existen productos asociados a ella."));
		}
		$this->redirect(array('admin'));		
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