<?php

class TiendaController extends Controller
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
				'actions'=>array('index','filtrar','categorias','imageneslooks','segunda','look','ocasiones'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','filtrar','categorias'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIndex()
	{
		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1),array('order'=>'nombre ASC'));
		$producto = new Producto;		
		$producto->status = 1; // no borrados
		$producto->estado = 0; // solo productos activos
		
		$a ="a"; 
		
		$dataProvider = $producto->nueva($a);
		$this->render('index',
		array('index'=>$producto,
		'dataProvider'=>$dataProvider,'categorias'=>$categorias,
		));	
			
	}
	
		public function actionFiltrar()
	{
		
		$producto = new Producto;
		$producto->status = 1; // que no haya sido borrado logicamente
		$producto->estado = 0; // que no esté inactivo

		if (isset($_POST['cate1'])) // desde el select
		{
			//if($_POST['cate1']!=0)	
				$producto->categoria_id = $_POST['cate1'];			
		}
		
		if (isset($_POST['idact'])) // actualizacion desde los ajaxlink
		{
			 $producto->categoria_id = $_POST['idact'];			
		}		
	
		if (isset($_POST['busqueda'])) // desde el input
		{	
			$producto->nombre = $_POST['busqueda'];
		}
	
		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1));
		
		$todos = array();
		$todos = $this->getAllChildren(Categoria::model()->findAllByAttributes(array("padreId"=>$producto->categoria_id)));
		
		$dataProvider = $producto->busqueda($todos);
		$this->render('index',
		array('index'=>$producto,
		'dataProvider'=>$dataProvider,'categorias'=>$categorias,
		));	
			
	}
	
	
	public function actionColores()
	{
		
		$producto = new Producto;
		$producto->status = 1; // que no haya sido borrado logicamente
		$producto->estado = 0; // que no esté inactivo
	
		$color="";
	
		if(isset($_POST['idColor'])) // llega como parametro el id del color presionado
		{	
			$color = $_POST['idColor'];
		}

		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1));

		$dataProvider = $producto->busColor($color);
		$this->render('index',
		array('index'=>$producto,
		'dataProvider'=>$dataProvider,'categorias'=>$categorias,
		));	
			
	}
	

	public function getAllChildren($models){
		$items = array();
		foreach($models as $model){
			if (isset($model->id)){
				$items[] = $model->id;
			 	if($model->hasChildren()){
                        $items= CMap::mergeArray($items,$this->getAllChildren($model->getChildren()));
                }
			}
		}
		return $items;
		
	}	
	 
	/*
	 * funcion original
	 * 
	 * 
	 * 	public function getAllChildren($models){
		$items = array();
		foreach($models as $model){
			if (isset($model->id)){
				$items[] = array('id'=> $model->id,'nombre'=> $model->nombre);
			 	if($model->hasChildren()){
                        $items= CMap::mergeArray($items,$this->getAllChildren($model->getChildren()));
                }
			}
		}
		return $items;
		
	}	
	 * 
	 * 
	 * */ 
	public function actionOcasiones(){

	  	$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>$_POST['padreId']),array('order'=>'nombre ASC'));
	  	Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;	
		Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap-responsive.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap-yii.css'] = false;
		Yii::app()->clientScript->scriptMap['jquery-ui-bootstrap.css'] = false;
		
		
				
	  if ($categorias){
		 echo CJSON::encode(array(
			'id'=> $_POST['padreId'],
			'accion'=>'padre',
			'div'=> $this->renderPartial('_view_ocasiones',array('categorias'=>$categorias),true,true)
		));
		exit;
	  }else {
	  		echo CJSON::encode(array(
			'id'=> $_POST['padreId'],
			'accion'=>'hijo'
		));
	  }		
	} 
	
	public function actionCategorias(){
	
	  	$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>$_POST['padreId']),array('order'=>'nombre ASC'));
	  	Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;	
		Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;	
		
		// para que también filtre del lado del list view
		/*
		$producto = new Producto;
		$producto->status = 1;
		$producto->categoria_id = $_POST['padreId']; // el id del que se le da click		
		$todos = array(); 
		$todos = $this->getAllChildren(Categoria::model()->findAllByAttributes(array("padreId"=>$producto->categoria_id)));
		$dataProvider = $producto->busqueda($todos);
		*/
		
	  if ($categorias){
		 echo CJSON::encode(array(
			'id'=> $_POST['padreId'],
			'accion'=>'padre',
			'div'=> $this->renderPartial('_view_categorias',array('categorias'=>$categorias),true,true)
		));
		exit;
	  }else {
	  		echo CJSON::encode(array(
			'id'=> $_POST['padreId'],
			'accion'=>'hijo'
		));
	  }
} 

	public function actionImageneslooks(){
		
		$look1 = LookHasProducto::model()->findAllByAttributes(array('producto_id'=>$_POST['pro1']));
		$look2 = LookHasProducto::model()->findAllByAttributes(array('producto_id'=>$_POST['pro2']));
		
		$mos1 = 0;
		$mos2 = 0;
		
		$l1 ="";
		$l2 ="";
		
		if(isset($look1)){		
			foreach($look1 as $uno)
			{
				if($mos1 == 0)
				{				
					$l1 = Look::model()->findByPk($uno->look_id);
					$mos1=1;
				}
				else
					break;
			}
		}
		
		if(isset($look2)){
			foreach($look2 as $dos)
			{
				if($mos2 == 0)
				{
					$l2 = Look::model()->findByPk($dos->look_id);
					$mos2=1;
				}
				else
					break;
			}
		}
		// tengo los dos looks. Ahora a generar lo que voy a devolver para que genere las imagenes.
		
		$ret = array();
		$base = Yii::app()->baseUrl;

		if($l1 != "")
			array_push($ret,'<a href="../look/view/'.$l1->id.'"><img width="400" height="400" class="img-polaroid" id="'.$l1->id.'" src="'.$base.'/look/getImage/'.$l1->id.'" alt="Look"></a>');
		
		array_push($ret,"<br><br>");
		
		if($l2 != "")
			array_push($ret,'<a href="../look/view/'.$l2->id.'"><img width="400" height="400" class="img-polaroid" id="'.$l2->id.'" src="'.$base.'/look/getImage/'.$l2->id.'" alt="Look"></a>');
		
		//array_push($ret,CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$l1->id)), "Look", array("width" => "400", "height" => "400", 'class'=>'img-polaroid')) );
		
		echo CJSON::encode(array(
			'status'=> 'ok',
			'datos'=> $ret  
			));
		exit;
	}
 
/* 
 * Se trae el url de la segunda imagen 
 * */
	public function actionSegunda(){
		
		$segunda = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$_POST['id'],'orden'=>$_POST['orden']));
		
		$url = $segunda->getUrl(array('type'=>'thumb'));
		
		if(isset($segunda))
			echo $url;		
		else
			echo "no";
	
	}

	public function actionLook(){
			

		if (isset($_POST['ocasiones'])){
					
			$criteria = new CDbCriteria;
			$criteria->with = array('categorias');	
			$criteria->together = true;
			$criteria->compare('categorias_categorias.categoria_id',$_POST['ocasiones'],true,'OR');
			$total = Look::model()->count();
			$pages = new CPagination($total);
			$pages->pageSize = 9;
			$pages->applyLimit($criteria);
			$looks = Look::model()->findAll($criteria);
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;	
			Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
			Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
			Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;
			Yii::app()->clientScript->scriptMap['bootstrap-responsive.css'] = false;
			Yii::app()->clientScript->scriptMap['bootstrap-yii.css'] = false;
			Yii::app()->clientScript->scriptMap['jquery-ui-bootstrap.css'] = false;			
			echo CJSON::encode(array(
	                'status'=>'success', 
	                'div'=>$this->renderPartial('_look', array('looks' => $looks,
				'pages' => $pages,), true,true)));
		} else  {
			$search = "";	
			if(isset($_GET['search']))
				$search =  	$_GET['search'];
			
			$criteria = new CDbCriteria;
			$criteria->compare('title',$search,true,'OR');
			$criteria->compare('description',$search,true,'OR');
			
			$total = Look::model()->count();
			 
			$pages = new CPagination($total);
			$pages->pageSize = 9;
			$pages->applyLimit($criteria);
			$looks = Look::model()->findAll($criteria);
			$this->render('look', array(
				'looks' => $looks,
				'pages' => $pages,
			));		
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