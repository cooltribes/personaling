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
				'actions'=>array('index','filtrar','categorias','imageneslooks',
                                    'segunda','ocasiones','modal','doble', 'crearFiltro',
                                    'getFilter','xmltest','rangoslook','bf080'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index', 'look', 'redirect', 'modalAjax'), //Se cambió el action look de * para acá.
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','filtrar','categorias'),
				//'users'=>array('admin'),
				'expression' => 'UserModule::isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionDoble()
	{
		/*$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1),array('order'=>'nombre ASC'));
		$producto = new Producto;		
		$producto->status = 1; actionindex
		 * // no borrados
		$producto->estado = 0; // solo productos activos
		
		$a ="a"; 
		if(isset(Yii::app()->session['idColor'])){
			unset(Yii::app()->session['idColor']);
			
		}
		if(isset(Yii::app()->session['idact'])){
			unset(Yii::app()->session['idact']);
			
		}
		$dataProvider = $producto->nueva($a);
		$this->render('index',
		array('index'=>$producto,
		'dataProvider'=>$dataProvider,'categorias'=>$categorias,
		));	*/
			
		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1),array('order'=>'nombre ASC'));
		$producto = new Producto;		
		$producto->status = 1; // no borrados
		$producto->estado = 0; // solo productos activos
		if(isset(Yii::app()->session['idColor'])){
			unset(Yii::app()->session['idColor']);
			
		}
		if(isset(Yii::app()->session['idact'])){
			unset(Yii::app()->session['idact']);
			
		}
		if(isset(Yii::app()->session['bsf'])){
			unset(Yii::app()->session['bsf']);
			
		}
		if(isset(Yii::app()->session['minpr'])){
			unset(Yii::app()->session['minpr']);
			
		}
		if(isset(Yii::app()->session['maxpr'])){
			unset(Yii::app()->session['maxpr']);
			
		}
		$a ="a"; 
		
		
		$dp=$producto->nueva($a);

		
		$arr=array();
		foreach($dp->getData() as $record) {
			array_push($arr,$record->getPrecio(false));	
		 }
		 
		Yii::app()->session['bsf']=$arr;

		$criteria = $producto->nueva2($a);
		$total=Producto::model()->count($criteria);
		$pages = new CPagination($total);
		
		$pages->pageSize = 12;
		$pages->applyLimit($criteria);
        $dataProvider = Producto::model()->findAll($criteria);
		//echo $pages->pageSize;
		$this->render('doble',
			array('doble'=>$producto,
				'pages'=>$pages,
				'dataProvider'=>$dataProvider,
				'categorias'=>$categorias,
	
				

		));	
			
	}
	public function actionRangoslook(){
		
		$rangosArray = Look::model()->getRangosPrecios();
		$this->renderPartial('_rangos',array('rangos'=>$rangosArray));
	}
	public function actionIndex()
	{
		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1),array('order'=>'nombre ASC'));
		$producto = new Producto;		
		$producto->status = 1; // no borrados
		$producto->estado = 0; // solo productos activos

		//var_dump(Yii::app()->session);
		//var_dump($_POST);
		if(isset($_POST['outlet'])){
			if($_POST['outlet'] == 'true'){
				$producto->outlet = 1; // productos en el outlet
				Yii::app()->session['outlet'] = $_POST['outlet'];
			}
		}else if(isset($_GET['outlet'])){
			if($_GET['outlet'] == 'true'){
				$producto->outlet = 1; // productos en el outlet
				Yii::app()->session['outlet'] = $_GET['outlet'];
			}
		}else{
			//$producto->outlet = null;
			if(isset(Yii::app()->session['outlet'])){
				unset(Yii::app()->session['outlet']);
			}
		}

		$seo = SeoStatic::model()->findByAttributes(array('name'=>'Tienda'));
		/*
		if(isset(Yii::app()->session['f_color'])){
			unset(Yii::app()->session['f_color']);
			
		}
		
		if(isset(Yii::app()->session['f_marca'])){
			unset(Yii::app()->session['f_marca']);
			
		}
		if(isset(Yii::app()->session['f_cat'])){
			unset(Yii::app()->session['f_cat']);
			
		}
		if(isset(Yii::app()->session['f_text'])){
			unset(Yii::app()->session['f_text']);
			
		}
		
		if(isset(Yii::app()->session['max'])){
			unset(Yii::app()->session['max']);
			
		}
		if(isset(Yii::app()->session['min'])){
			unset(Yii::app()->session['min']);
			
		}
		if(isset(Yii::app()->session['p_index'])){
			unset(Yii::app()->session['p_index']);
			
		}
		*/
		$a ="a"; 
	
		$lims=Precio::model()->getLimites();

		$dif=$lims['maximo']-$lims['minimo'];
				
		
		
		$orden[0]="t.fecha DESC";
		$orden[1]="t.fecha ASC";
		$orden[2]="t.descripcion DESC";
		$orden[3]="t.descripcion ASC";
		$orden[4]="t.view_counter DESC";
		$orden[5]="t.peso ASC";
		$orden[6]="t.peso DESC";
		$orden[7]="t.id DESC";
		$orden[8]="t.id ASC";
		
		
		
		
		$rangos[0]['min']=0;
		$rangos[0]['max']=($dif*.25)+$lims['minimo'];
		
		$rangos[1]['min']=$rangos[0]['max']+0.01;
		$rangos[1]['max']=($dif*.50)+$lims['minimo'];
		
		$rangos[2]['min']=$rangos[1]['max']+0.01;
		$rangos[2]['max']=($dif*.75)+$lims['minimo'];
		
		$rangos[3]['min']=$rangos[2]['max']+0.01;
		$rangos[3]['max']=$lims['maximo']+0.01;
		
		if($rangos[0]['max']>100){
			$rangos[0]['max']=round($rangos[0]['max']/100, 0)*100;
			$rangos[1]['max']=round($rangos[1]['max']/100, 0)*100;
			$rangos[2]['max']=round($rangos[2]['max']/100, 0)*100;
		}
		
		
		for($i=0;$i<4;$i++){
			$rangos[$i]['count']=Precio::model()->countxRango($rangos[$i]['min'],$rangos[$i]['max']);
		}
		
		  
    	if( isset($_POST['colorhid']) ||  (isset($_GET['page']) && isset(Yii::app()->session['bandera']) ) ){
    		//echo 'if gigante';
    	//	if(isset($_POST['colorhid'])){
    		Yii::app()->session['bandera'] = true;
		
    		
				
    			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;	
				Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
				Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
				Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;
				Yii::app()->clientScript->scriptMap['bootstrap-responsive.css'] = false;
				Yii::app()->clientScript->scriptMap['bootstrap-yii.css'] = false;
				Yii::app()->clientScript->scriptMap['jquery-ui-bootstrap.css'] = false;
				Yii::app()->clientScript->scriptMap['bootstrap.min.css'] = false;	
				Yii::app()->clientScript->scriptMap['bootstrap.min.js'] = false;
				Yii::app()->clientScript->scriptMap['bootstrap.min.js'] = false;
				
			if (isset($_POST['texthid']))
			if(strlen($_POST['texthid'])>0){
				Yii::app()->session['f_text'] = $_POST['texthid'];

				/*if(isset($_POST['outlet'])){
					if($_POST['outlet'] == 'true'){
						//$producto->outlet = 1; // productos en el outlet
						Yii::app()->session['outlet'] = $_POST['outlet'];
					}else{
						Yii::app()->session['outlet'] = 'false';
					}
				}else{
					if(isset(Yii::app()->session['outlet'])){
							unset(Yii::app()->session['outlet']);
						}
				}*/

				//var_dump(Yii::app()->session['outlet']);
				
			} else {
				if (isset($_POST['colorhid'])){	 
					if($_POST['colorhid']!=0){
					
						Yii::app()->session['f_color'] = $_POST['colorhid'];
					
					}else{
						if(isset(Yii::app()->session['f_color'])){
							unset(Yii::app()->session['f_color']);
						}
					}
				}

				if(isset($_POST['outlet'])){
					if($_POST['outlet'] == 'true'){
						//$producto->outlet = 1; // productos en el outlet
						Yii::app()->session['outlet'] = $_POST['outlet'];
					}else{
						Yii::app()->session['outlet'] = 'false';
					}
				}else{
					if(isset(Yii::app()->session['outlet'])){
							unset(Yii::app()->session['outlet']);
						}
				}

				
				
				if (isset($_POST['cathid'])){
					if($_POST['cathid']!=0){
					
						Yii::app()->session['f_cat'] = $_POST['cathid'];
		 			}
					else{
						if(isset(Yii::app()->session['f_cat'])){
							unset(Yii::app()->session['f_cat']);
						}
					}
				} 
				if (isset($_POST['padrehid'])){
					if($_POST['padrehid']!=0){
					
						Yii::app()->session['f_padre'] = $_POST['padrehid'];
		 			}
					else{
						if(isset(Yii::app()->session['f_padre'])){
							unset(Yii::app()->session['f_padre']);
						}
					}
				}
				if (isset($_POST['chic_hid'])){
					if($_POST['chic_hid']==1){
					
						Yii::app()->session['chic'] = $_POST['chic_hid'];
		 			}
					else{
						
							unset(Yii::app()->session['chic']);
						
					}
				}
				
				
				if (isset($_POST['marcahid'])){
					if($_POST['marcahid']!=0){
					
						Yii::app()->session['f_marca'] = $_POST['marcahid'];
						
					
					}
					else{
						if(isset(Yii::app()->session['f_marca'])){
							unset(Yii::app()->session['f_marca']);
						}
					}
				}
				
				if (isset($_POST['preciohid']))
				{	if($_POST['preciohid']<4){
					
						Yii::app()->session['max']=$rangos[$_POST['preciohid']]['max'];
						Yii::app()->session['min']=$rangos[$_POST['preciohid']]['min'];
						Yii::app()->session['p_index']=$_POST['preciohid'];
										
					}
					else{
						if(isset(Yii::app()->session['p_index'])){
							unset(Yii::app()->session['p_index']);
						}
					}
				
					
				}
				if (isset($_POST['resethid']))
				if($_POST['resethid']==1){
				
					if(isset(Yii::app()->session['f_color'])){
						unset(Yii::app()->session['f_color']);
						
					}
					
					if(isset(Yii::app()->session['chic'])){
						unset(Yii::app()->session['chic']);
						
					}
					
					if(isset(Yii::app()->session['f_marca'])){
						unset(Yii::app()->session['f_marca']);
						
					}
					if(isset(Yii::app()->session['f_cat'])){
						unset(Yii::app()->session['f_cat']);
						
					}
					
					if(isset(Yii::app()->session['max'])){
						unset(Yii::app()->session['max']);
						
					}
					if(isset(Yii::app()->session['min'])){
						unset(Yii::app()->session['min']);
						
					}
					if(isset(Yii::app()->session['p_index'])){
						unset(Yii::app()->session['p_index']);
						
					}	
					if(isset(Yii::app()->session['f_text'])){
						unset(Yii::app()->session['f_text']);
						
					}
					if(isset(Yii::app()->session['f_padre'])){
						unset(Yii::app()->session['f_padre']);
						
					}
									
				}
			
			}
			
			$criteria = $producto->nueva2($a);

			if (isset($_GET['page'])&&
			(!isset(Yii::app()->session['f_cat'])&&
			!isset(Yii::app()->session['f_text'])&&
			!isset(Yii::app()->session['f_color'])&&
			!isset(Yii::app()->session['chic'])))
				$criteria->order=$orden[Yii::app()->session['order']];
			$total=Producto::model()->count($criteria);
			if($total>0){
			
		
			$pages = new CPagination($total);
			
			$pages->pageSize = 12;
			
			$pages->applyLimit($criteria);
	
			
			
			 
			$dataProvider = Producto::model()->findAll($criteria);
			if ((isset($_GET['page']))){
				
				$marcas=Marca::model()->findAllByAttributes(array('padreId'=>0));
				$colores=Color::model()->findAll();
				ShoppingMetric::registro(ShoppingMetric::USER_TIENDA);//METRICAS
				$this->render('index_new',
						array('index'=>$producto,
						'dataProvider'=>$dataProvider,'categorias'=>$categorias, 
						'colores'=>$colores,'marcas'=>$marcas,'rangos'=>$rangos,
						'pages'=>$pages,
						'total'=>$total,
						'seo' => $seo,
						));	
			} else {
					
				   
				    echo CJSON::encode(array(  
                    'status' => 'success',
                    //'condicion' => $total,
                    'div' => $this->renderPartial('_datos', array('prods' => $dataProvider,
                        'pages' => $pages, 'total'=>$total), true,true)));
			}			 
			}
			else{
					
				echo CJSON::encode(array(  
                    'status' => 'success',
                    //'condicion' => $total,
                    'div' => "<span class='empty'>No se encontraron resultados para esta búsqueda.  </span>")); 
				 
			}
		}
		else{
			//echo 'else';
			unset(Yii::app()->session['bandera']);
		if(isset(Yii::app()->session['f_color'])){
			unset(Yii::app()->session['f_color']);
			
		}
		
		if(isset(Yii::app()->session['f_marca'])){
			unset(Yii::app()->session['f_marca']);
			
		}
		
		if(isset(Yii::app()->session['chic'])){
			unset(Yii::app()->session['chic']);
			
		}
		if(isset(Yii::app()->session['f_cat'])){
			unset(Yii::app()->session['f_cat']);
			
		}
		
		if(isset(Yii::app()->session['max'])){
			unset(Yii::app()->session['max']);
			
		}
		if(isset(Yii::app()->session['min'])){
			unset(Yii::app()->session['min']);
			
		}
		if(isset(Yii::app()->session['p_index'])){
			unset(Yii::app()->session['p_index']);
			
		}	
		if(isset(Yii::app()->session['f_text'])){
			unset(Yii::app()->session['f_text']);
			
		}
		if(isset(Yii::app()->session['f_padre'])){
			unset(Yii::app()->session['f_padre']);
			
		}
		if(!isset($_GET['page'])){
			Yii::app()->session['order']=rand(0,8);
		}
		$criteria = $producto->nueva2($a);

		$criteria->order=$orden[Yii::app()->session['order']];
		$total=Producto::model()->count($criteria);
		$pages = new CPagination($total);
		
		$pages->pageSize = 12;
		$pages->applyLimit($criteria);
        $dataProvider = Producto::model()->findAll($criteria);
	
		$marcas=Marca::model()->findAllByAttributes(array('padreId'=>0));
		$colores=Color::model()->findAllByAttributes(array('padreID'=>'0'));
		
		ShoppingMetric::registro(ShoppingMetric::USER_TIENDA);
		$this->render('index_new',
			array('index'=>$producto,
				'dataProvider'=>$dataProvider,'categorias'=>$categorias, 
				'colores'=>$colores,'marcas'=>$marcas,'rangos'=>$rangos,
				'pages'=>$pages,
				'total'=>$total,
				'seo' => $seo,
			));
		}
	}
	 
	
		public function actionFiltrar()
	{
		
		$producto = new Producto;
		$producto->status = 1; // que no haya sido borrado logicamente
		$producto->estado = 0; // que no estÃ© inactivo

		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1));
		
			if (isset($_POST['cate1'])){ // desde el select
				$producto->categoria_id = $_POST['cate1'];		
				$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>$producto->categoria_id));			
				Yii::app()->getSession()->add('categoria', $_POST['cate1']);
				Yii::app()->getSession()->add('valor',1);
			}
			
			if (isset($_POST['idact'])){ // actualizacion desde los ajaxlink
				 $producto->categoria_id = $_POST['idact'];		
				 Yii::app()->getSession()->add('categoria', $_POST['idact']);
				 Yii::app()->getSession()->add('valor',1);
			}		
		
			if (isset($_POST['busqueda'])){ // desde el input
				$producto->nombre = $_POST['busqueda'];
				Yii::app()->getSession()->add('nombre', $_POST['busqueda']);
				Yii::app()->getSession()->add('valor',1);
			}

			if( isset($_GET['Producto_page']) )
			{
				if ( Yii::app()->getSession()->get('categoria') )
					$producto->categoria_id = Yii::app()->getSession()->get('categoria');
					
				if ( Yii::app()->getSession()->get('nombre') )
					$producto->nombre = Yii::app()->getSession()->get('nombre');
				
				$todos = array();
				$todos = $this->getAllChildren(Categoria::model()->findAllByAttributes(array("padreId"=>$producto->categoria_id)));
				$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>$producto->categoria_id));	
				$dataProvider = $producto->busqueda($todos);
		
				$this->render('index',
				array('index'=>$producto,
				'dataProvider'=>$dataProvider,'categorias'=>$categorias,
				));	
			
			}
			/*
			if(Yii::app()->getSession()->get('valor') == 1) // ya hubo una busqueda. asegurando que los resultados sean los que se debian buscar
			{
				if ( Yii::app()->getSession()->get('categoria') )
					$producto->categoria_id = Yii::app()->getSession()->get('categoria');
					
				if ( Yii::app()->getSession()->get('nombre') )
					$producto->nombre = Yii::app()->getSession()->get('nombre');
				
				
				$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>$producto->categoria_id));	
		
			}
			*/
			$todos = array();
			$todos = $this->getAllChildren(Categoria::model()->findAllByAttributes(array("padreId"=>$producto->categoria_id)));
	
			$dataProvider = $producto->busqueda($todos);
	
			$this->render('index',
			array('index'=>$producto,
			'dataProvider'=>$dataProvider,'categorias'=>$categorias,
			));	
			}
 

	public function actionFiltrar2()
	{
		
		$producto = new Producto;
		$producto->status = 1; // que no haya sido borrado logicamente
		$producto->estado = 0; // que no estÃ© inactivo

		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1));
		
			if (isset($_POST['cate1'])){ // desde el select
				$producto->categoria_id = $_POST['cate1'];		
				$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>$producto->categoria_id));			
				Yii::app()->getSession()->add('categoria', $_POST['cate1']);
				Yii::app()->getSession()->add('valor',1);
			}
			/*
			if (isset($_POST['idact'])){ // actualizacion desde los ajaxlink
				 $producto->categoria_id = $_POST['idact'];		
				 Yii::app()->getSession()->add('categoria', $_POST['idact']);
				 Yii::app()->getSession()->add('valor',1);
			}	*/	
		
			if (isset($_POST['busqueda'])){ // desde el input
				$producto->nombre = $_POST['busqueda'];
				Yii::app()->getSession()->add('nombre', $_POST['busqueda']);
				Yii::app()->getSession()->add('valor',1);
				
				
				
		
					$key=new Keyword;
					$key->busqueda=$_POST['busqueda'];
					if(isset($_POST['usid']))					
						$key->user_id=$_POST['usid'];
					else
						$key->user_id=0;
					$key->save();
					
				
				
			}

			if( isset($_GET['Producto_page']) )
			{
				if ( Yii::app()->getSession()->get('categoria') )
					$producto->categoria_id = Yii::app()->getSession()->get('categoria');
					
				if ( Yii::app()->getSession()->get('nombre') )
					$producto->nombre = Yii::app()->getSession()->get('nombre');
				
				$todos = array();
				$todos = $this->getAllChildren(Categoria::model()->findAllByAttributes(array("padreId"=>$producto->categoria_id)));
				$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>$producto->categoria_id));	
				$dataProvider = $producto->busqueda($todos);
		
				$this->render('index',
				array('index'=>$producto,
				'dataProvider'=>$dataProvider,'categorias'=>$categorias,
				));	
			
			}
			/*
			if(Yii::app()->getSession()->get('valor') == 1) // ya hubo una busqueda. asegurando que los resultados sean los que se debian buscar
			{
				if ( Yii::app()->getSession()->get('categoria') )
					$producto->categoria_id = Yii::app()->getSession()->get('categoria');
					
				if ( Yii::app()->getSession()->get('nombre') )
					$producto->nombre = Yii::app()->getSession()->get('nombre');
				
				
				$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>$producto->categoria_id));	
		
			}
			*/
else{
			$todos = array();
			$todos = $this->getAllChildren(Categoria::model()->findAllByAttributes(array("padreId"=>$producto->categoria_id)));
	
			$dataProvider = $producto->busqueda($todos);
	
			$this->render('index',
			array('index'=>$producto,
			'dataProvider'=>$dataProvider,'categorias'=>$categorias,
			));	
}
			}



	
	
	public function actionColores()
	{
		
		$producto = new Producto;
		$producto->status = 1; // que no haya sido borrado logicamente
		$producto->estado = 0; // que no estÃ© inactivo
	
		$color="";
		$categoria="";
		
		if(isset($_POST['idColor'])) // llega como parametro el id del color presionado
		{
			Yii::app()->session['idColor']=$_POST['idColor'];	
		}		
		
		if(isset($_POST['rango'])) // llega como parametro el id del color presionado
		{
			$minmax = explode('A',$_POST['rango']);
			Yii::app()->session['minpr']=$minmax[0];	
			Yii::app()->session['maxpr']=$minmax[1];	
		}
					
		if(isset(Yii::app()->session['idact'])) // llega como parametro el id del color presionado
		{
					
			$categoria=Yii::app()->session['idact'];
		}
			
		
			
		if(isset(Yii::app()->session['idColor'])) // llega como parametro el id del color presionado
		{
			$color = explode('#',Yii::app()->session['idColor']);
			
			unset($color[0]);	
		}	

			
		
		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1),array('order'=>'nombre ASC'));
		
		if(count($color)==0&&(!isset(Yii::app()->session['idact']))&&(!isset(Yii::app()->session['minpr']))&&(!isset(Yii::app()->session['maxpr']))){
			$a="a";	
			$dataProvider = $producto->nueva($a);
			
		}else{
			
				
			$dataProvider = $producto->multipleColor($color,$categoria);
		}
		
		$this->render('index',
		array('index'=>$producto,
		'dataProvider'=>$dataProvider,'categorias'=>$categorias,
		));	
		
		
	}
	
	
	public function actionColores2()
	{
		
		$producto = new Producto;
		$producto->status = 1; // que no haya sido borrado logicamente
		$producto->estado = 0; // que no estÃ© inactivo
	
		$color="";
		$categoria="";
		
		if(isset($_POST['idColor'])) // llega como parametro el id del color presionado
		{
			Yii::app()->session['idColor']=$_POST['idColor'];	
		}		
		
		if(isset($_POST['rango'])) // llega como parametro el id del color presionado
		{
			$minmax = explode('A',$_POST['rango']);
			Yii::app()->session['minpr']=$minmax[0];	
			Yii::app()->session['maxpr']=$minmax[1];	
		}
					
		if(isset(Yii::app()->session['idact'])) // llega como parametro el id de la categoria presionada
		{
					
			$categoria=Yii::app()->session['idact'];
		}
			
		
			
		if(isset(Yii::app()->session['idColor'])) // llega como parametro el id del color presionado
		{
			$color = explode('#',Yii::app()->session['idColor']);
			
			unset($color[0]);	
		}	

			
		
		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1),array('order'=>'nombre ASC'));
		
		if(count($color)==0&&(!isset(Yii::app()->session['idact']))&&(!isset(Yii::app()->session['minpr']))&&(!isset(Yii::app()->session['maxpr']))){
			$a="a";	
			$criteria = $producto->nueva2($a);
			
		}else{
			
				
			$criteria = $producto->multipleColor2($color,$categoria);
		}
		 
		$total=Producto::model()->count($criteria);
		$pages = new CPagination($total);
		
		$pages->pageSize = 12;
		$pages->applyLimit($criteria);
        $dataProvider = Producto::model()->findAll($criteria);
		
		
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
		Yii::app()->clientScript->scriptMap['bootstrap.min.css'] = false;	
		Yii::app()->clientScript->scriptMap['bootstrap.min.js'] = false;		
		
	 //el de bodas - tuki elminarlo			
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
		Yii::app()->clientScript->scriptMap['bootstrap-responsive.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap-yii.css'] = false;
		Yii::app()->clientScript->scriptMap['jquery-ui-bootstrap.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.min.css'] = false;	
		Yii::app()->clientScript->scriptMap['bootstrap.min.js'] = false;		
		
		
		
		// para que tambiÃ©n filtre del lado del list view
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

public function actionCategorias2(){
	
	  	$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>$_POST['padreId']),array('order'=>'nombre ASC'));
	  	Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;	
		Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap-responsive.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap-yii.css'] = false;
		Yii::app()->clientScript->scriptMap['jquery-ui-bootstrap.css'] = false;
		Yii::app()->clientScript->scriptMap['bootstrap.min.css'] = false;	
		Yii::app()->clientScript->scriptMap['bootstrap.min.js'] = false;	
		// para que tambiÃ©n filtre del lado del list view
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
			'div'=> $this->renderPartial('_view_categorias2',array('categorias'=>$categorias),true,true)
		));
		Yii::app()->session['idact']=$_POST['padreId'];
		exit;
	  }else {
	  		echo CJSON::encode(array(
			'id'=> $_POST['padreId'],
			'accion'=>'hijo'
		));
		Yii::app()->session['idact']=$_POST['padreId'];
	  }
	  
} 


	public function actionImageneslooks(){
		
		$look1 = LookHasProducto::model()->findAllByAttributes(array('producto_id'=>$_POST['pro1']));
		$look2 = LookHasProducto::model()->findAllByAttributes(array('producto_id'=>$_POST['pro2']));	
		$look3 = LookHasProducto::model()->findAllByAttributes(array('producto_id'=>$_POST['pro3']));
		$look4 = LookHasProducto::model()->findAllByAttributes(array('producto_id'=>$_POST['pro4']));
		
		$band = 0;
		$band1 = 0;
		$band2 = 0;
		$band3 = 0;
		
		$l1 ="";
		$l2 ="";
		$l3 ="";
		$l4 ="";
		
		if(isset($look1)){		
			foreach($look1 as $uno){
				if($band == 0){				
					$l1 = Look::model()->aprobados()->findByPk($uno->look_id);
					
					if(isset($l1))
						$band=1;
					
				}
			}
		}else if(isset($look3)){		
			foreach($look3 as $uno){
				if($band2 == 0){				
					$l3 = Look::model()->aprobados()->findByPk($uno->look_id);
					
					if(isset($l3))
						$band2=1;
					
				}
			}
		}
		
		
		
		if(isset($look2)){
			foreach($look2 as $dos){
				if($band1 == 0){
					if($band==1) // hay l1
					{
						if($l1->id == $dos->look_id){ // si son iguales no haga nada y busque otro
							$band1=0;
						}
						else{
							$l2 = Look::model()->aprobados()->findByPk($dos->look_id);
						
							if(isset($l2))
								$band1=1;
						}		
					}
					else if($band2 == 1) // hay l3
					{
						if($l3->id == $dos->look_id ){ // si son iguales no haga nada y busque otro
							$band1=0;
						} else{
							$l2 = Look::model()->aprobados()->findByPk($dos->look_id);
							
							if(isset($l2))
								$band1=1;
						}	
					}
				}
			}
		}else if(isset($look4)){		
			foreach($look4 as $dos){
				if($band3 == 0){
					if($band==1) // hay l1
					{
						if($l1->id == $dos->look_id){ // si son iguales no haga nada y busque otro
							$band3=0;
						}
						else{
							$l4 = Look::model()->aprobados()->findByPk($dos->look_id);
						
							if(isset($l4))
								$band3=1;
						}		
					}
					else if($band2 == 1) // hay l3
					{
						if($l3->id == $dos->look_id ){ // si son iguales no haga nada y busque otro
							$band3=0;
						} else{
							$l4 = Look::model()->aprobados()->findByPk($dos->look_id);
							
							if(isset($l4))
								$band3=1;
						}	
					}
					
				}
			}
		}
		
		$contador = 0;
		
		// tengo los looks. Ahora a generar lo que voy a devolver para que genere las imagenes.
		
		$ret = array();
		$base = Yii::app()->baseUrl;

		if($l1 != ""){
			array_push($ret,'<a href="'.$l1->getUrl().'"><img width="400" height="400" class="img-polaroid" id="'.$l1->id.'" src="'.$base.'/look/getImage/'.$l1->id.'" alt="Look"></a>');
			array_push($ret,"<br><br>");
			$contador++;
		}
		
		if($l3 != ""){
			array_push($ret,'<a href="'.$l3->getUrl().'"><img width="400" height="400" class="img-polaroid" id="'.$l3->id.'" src="'.$base.'/look/getImage/'.$l3->id.'" alt="Look"></a>');
			array_push($ret,"<br><br>");
			$contador++;
		}
		
		if($l2 != ""){
			if($contador < 2){
				array_push($ret,'<a href="'.$l2->getUrl().'"><img width="400" height="400" class="img-polaroid" id="'.$l2->id.'" src="'.$base.'/look/getImage/'.$l2->id.'" alt="Look"></a>');
				array_push($ret,"<br><br>");
				$contador++;
			}	
		}
		
		if($l4 != ""){
			if($contador < 2){
				array_push($ret,'<a href="'.$l4->getUrl().'"><img width="400" height="400" class="img-polaroid" id="'.$l4->id.'" src="'.$base.'/look/getImage/'.$l4->id.'" alt="Look"></a>');
				array_push($ret,"<br><br>");
				$contador++;
			}
		}
		
		echo CJSON::encode(array(
			'status'=> 'ok',
			'datos'=> $ret,
			'uno'=>$l1,
			'dos'=>$l2,
			'tres'=>$l3,
			'cuatro'=>$l4
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
            	 
			//$start = microtime(true);
            $userTmp = User::model()->findByPk(Yii::app()->user->id);
            $todosLosLooks = true;
            if (isset($userTmp)) {
                
                //echo "user".$userTmp->status_register;
                //echo "status".$userTmp->status;
                //echo "destacado".$userTmp->ps_destacado;
                //echo "email".$userTmp->email;
                
               // $perfil_propio = null;
				//if (isset($_POST['perfil_propio']))
                if (($userTmp->status_register != User::STATUS_REGISTER_ESTILO) && !isset($_POST['perfil_propio'])) {
                    //echo "entro"; 
                    $_POST['perfil_propio'] = 0;
                   // $_POST['reset'] = true;
                    $todosLosLooks = true;
                }
            } else {
                // 	$_POST['perfil_propio'] = 0;
                //	 $_POST['reset'] = true;			
                $todosLosLooks = true;
            }


            /*
             * Si se utilizan filtros y estaba seteada la variable de sesion
             * Borrarla porque se va a realizar una nueva busqueda por filtros
             */
            if ((isset(Yii::app()->session['todoPost']) && !isset($_GET['page']))) {
                unset(Yii::app()->session['todoPost']);
            }


            //Comparar si vienen todos los campos de perfil
            $filtroPerfil = false;

            if (isset($_POST['Profile'])) {
                foreach ($_POST['Profile'] as $campo) {
                    if (!empty($campo)) {
                        $filtroPerfil = true;
                        break;
                    }
                }
            }

            /*
             * Si viene la variable page (si se esta paginando con infinitescroll)
             * y ademas existe la variable de session (ya se habia filtrado) y no viene
             * nada por el post (no se esta haciendo una nueva busqueda por filtros)
             * Entonces se saca el valor de la variable de session y se pone en el POST
             */
            if (isset($_GET['page']) && isset(Yii::app()->session['todoPost']) && 
		            !(isset($_POST['check_ocasiones']) || 
		            isset($_POST['check_shopper']) || 
		            $filtroPerfil || 
		            isset($_POST['reset']) 
		            || isset($_POST['precios']) 
		            //|| isset($_POST['perfil_propio'])
					)  
				){

                $_POST = Yii::app()->session['todoPost'];
				
            }

            $filtroPerfil = false;

            if (isset($_POST['Profile'])) {
                foreach ($_POST['Profile'] as $campo) {
                    if (!empty($campo)) {
                        $filtroPerfil = true;
                        break;
                    }
                }
            }

            if ((isset($_POST['check_ocasiones']) || isset($_POST['check_shopper']) || $filtroPerfil || isset($_POST['reset']) || isset($_POST['precios']) || isset($_POST['perfil_propio']))) {

				//echo "rafa entro de nuevo";
                Yii::app()->session['todoPost'] = $_POST;

                $criteria = new CDbCriteria;
              
                //Si no se resetearon - revisar lo que viene de los inputs 
                if (!isset($_POST['reset'])) {

                    if (isset($_POST['check_ocasiones'])) {
                        $condicion = "";
                        $criteria->with = array('categorias');
                        $criteria->together = true;
                        foreach ($_POST['check_ocasiones'] as $categoria_id)
                            $condicion .= "categorias_categorias.categoria_id = " . $categoria_id . " OR ";
                        $condicion = substr($condicion, 0, -3);
                        $criteria->addCondition($condicion);
                    }
                    if (isset($_POST['check_shopper'])) {
                        $condicion = "";
                        foreach ($_POST['check_shopper'] as $user_id)
                            $condicion .= "user_id = " . $user_id . " OR ";
                        $condicion = substr($condicion, 0, -3);
                        $criteria->addCondition($condicion);
                    }

                    if (isset($_POST['precios']) && $_POST['precios'] != "") {
                       // echo "NELSON";
                       //                         Yii::app()->end();
                        $limits = explode("-", $_POST['precios']);

                        $looks = Look::model()->findAll("status = 2");

                        $inValues = array();

                        foreach ($looks as $look) {

                           // $price = $look->getPrecio(false);
                            $price = $look->getPrecioDescuento(false);

                            if ($price >= $limits[0] && $price <= $limits[1]) {
                                $inValues[] = $look->id;
                            }
                        }

                        $criteria->addInCondition('t.id', $inValues);
                    }
                }

                //Looks recomendados para el usuario
                if ($_POST['perfil_propio'] == 1) {

                    //$userTmp = User::model()->findByPk(Yii::app()->user->id);

                    $looks = new Look();
                    $ids = $looks->match($userTmp);
                    $ids = $ids->getData();

                    $inValues = array();

                    foreach ($ids as $row) {

                        $look = Look::model()->findByPk($row['id']);
                        if ($look->matchOcaciones($userTmp)) {
                            $inValues[] = $row["id"];
                        }
                    }

                    $criteria->addInCondition('t.id', $inValues);

                    //Looks recomendados para un perfil   
                } 
                else if ($filtroPerfil) {



                    $userTmp->profile->attributes = $_POST['Profile']; //cambiar perfil temporalmente solo para buscar
                    $looks = new Look();
                    $ids = $looks->match($userTmp);
                    $ids = $ids->getData();

                    $inValues = array();

                    foreach ($ids as $row) {
                        $inValues[] = $row["id"];
                    }

                    $criteria->addInCondition('t.id', $inValues);
                }

                $sort = new CSort("Look");                

                $sort->applyOrder($criteria);

                $criteria->compare('status', 2);
                $criteria->order = "orden DESC";
                
                $total = Look::model()->count($criteria);
                $pages = new CPagination($total);
                $pages->pageSize = 9;
                $pages->applyLimit($criteria);
                $looks = Look::model()->findAll($criteria);
                $status_register_tmp = isset($userTmp->status_register) ? $userTmp->status_register : User::STATUS_REGISTER_ESTILO;

                if (($status_register_tmp != User::STATUS_REGISTER_ESTILO) && $todosLosLooks && !isset($_GET["page"])) {
                    //$rangosArray = Look::model()->getRangosPrecios();
                    $profile = new Profile;
                    $this->render('look', array(
                        'looks' => $looks,
                        'pages' => $pages,
                        'profile' => $profile,
                        'editar' => true,
                        'gift' => false,
                       // 'rangos' => $rangosArray,
                        'todosLosLooks' => $todosLosLooks,
                    ));
                } 
                else {
                    Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                    Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                    Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
                    Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
                    Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;
                    Yii::app()->clientScript->scriptMap['bootstrap-responsive.css'] = false;
                    Yii::app()->clientScript->scriptMap['bootstrap-yii.css'] = false;
                    Yii::app()->clientScript->scriptMap['jquery-ui-bootstrap.css'] = false;
                    Yii::app()->clientScript->scriptMap['bootstrap.min.css'] = false;
                    Yii::app()->clientScript->scriptMap['bootstrap.min.js'] = false;

                    if (!isset($_GET["page"])) {

                        echo CJSON::encode(array(
                            'status' => 'success',
                            'condicion' => $total,
                            'div' => $this->renderPartial('_look', array('looks' => $looks,
                                'pages' => $pages,), true, true)));
                    } else {

                        echo $this->renderPartial('_look', array('looks' => $looks,
                            'pages' => $pages,), true, true);
                    }
                }
            
            /*Cargando la Pagina por primera vez*/    
            } else {

                $search = "";
                if (isset($_GET['search']))
                    $search = $_GET['search'];

                $criteria = new CDbCriteria;

                //Para mostrar por defecto los looks recomendados para el usuario
                //siempre la primera vez que se cargue la página
                // $userTmp = User::model()->findByPk(Yii::app()->user->id);

                //Si esta logueado un usuario
                if(!$todosLosLooks){
                    
                    $looks = new Look();
                    $ids = $looks->match($userTmp);
                    $ids = $ids->getData();

                    $inValues = array();

                    foreach ($ids as $row) {

                        $look = Look::model()->findByPk($row['id']);
                        if ($look->matchOcaciones($userTmp)) {
                            $inValues[] = $row["id"];
                        }
                    }

                    $criteria->addInCondition('t.id', $inValues);
                
                }

                $criteria->compare('title', $search, true, 'OR');
                $criteria->compare('description', $search, true, 'OR');
                $criteria->compare('status', 2);
                $criteria->order = "orden DESC";
                
                $total = Look::model()->count($criteria);

                $pages = new CPagination($total);
                $pages->pageSize = 9;
                $pages->applyLimit($criteria);
                $looks = Look::model()->findAll($criteria);
//$time_taken = microtime(true) - $start;
//echo $time_taken."a<br>"; 
                /**    Filtros por Perfil * */
                $profile = new Profile;
               // $rangosArray = Look::model()->getRangosPrecios();
//$time_taken = microtime(true) - $start;
//echo $time_taken."b<br>"; 
    //                echo "<pre>"; print_r($count);echo "</pre>";               
				$gift=false;
				if(isset(Yii::app()->session['registerStep'])){
					if(Yii::app()->session['registerStep']==3&&Yii::app()->params['registerGift']>0){
						$balance=new Balance;
						$balance->user_id=Yii::app()->user->id;
						$balance->tipo=6;
						$balance->orden_id=0;
						$balance->total=Yii::app()->params['registerGift'];
						if($balance->save()){
							$gift=true;
						}
						
					}
						unset(Yii::app()->session['registerStep']);
				}

				$seo = SeoStatic::model()->findByAttributes(array('name'=>'Looks'));

                $this->render('look', array(
                    'looks' => $looks,
                    'pages' => $pages,
                    'profile' => $profile,
                    'editar' => true,
                    //'rangos' => $rangosArray,
                    'todosLosLooks' => $todosLosLooks,
                    'gift'=>$gift,
                    'seo' => $seo,
                    'user' => $userTmp,
                ));
				
//$time_taken = microtime(true) - $start;
//echo $time_taken."<br>"; 
            }
			
		
	}


	public function actionModal($id)
	{ 
		
		$datos="";
		
		$producto = Producto::model()->findByPk($id);
		if($producto->tipo){
			$left="span4";
			$right="span8";
			$tienda=Tienda::model()->findByPk($producto->tienda_id);
			if(strlen($tienda->urlVista)>9)
				$msj="Ir a ".$tienda->urlVista;
			else
				$msj="Comprar en ".$tienda->urlVista;
		}
			
		else{
			$tienda=null;
			$left="span7";
			$right="span5";
		}
		
		
		//$datos=$datos."<div id='myModal' class='modal hide tienda_modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>";
    	$datos=$datos."<div class='modal-header'>";
		$datos=$datos."<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>";
		$datos=$datos."<h3 id='myModalLabel'><a href='".$producto->getUrl()."' title='".$producto->nombre."'>".$producto->nombre."</a></h3></div>";
		$datos=$datos."<div class='modal-body'>";
   
   		$datos=$datos."<div class='row-fluid'>";
   		$datos=$datos."<div class='span7'><div class='carousel slide' id='myCarousel'>";
		$datos=$datos."<ol class='carousel-indicators'>";
		$datos=$datos."<li class='' data-slide-to='0' data-target='#myCarousel'></li>";
		$datos=$datos.'<li data-slide-to="1" data-target="#myCarousel" class="active"></li>';
        $datos=$datos.'<li data-slide-to="2" data-target="#myCarousel" class=""></li>';
       	$datos=$datos.'</ol>';
        $datos=$datos.'<div class="carousel-inner" id="carruselImag">';
       // $datos=$datos.'<div class="item">';
		
		$ima = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$producto->id),array('order'=>'orden ASC'));
		
		foreach ($ima as $img){
					
			if($img->orden==1)
			{ 
				$colorPredet = $img->color_id;
				
				$datos=$datos.'<div class="item active">';	
				$datos=$datos. CHtml::image($img->getUrl(array('ext'=>'jpg')), $producto->nombre, array("width" => "450", "height" => "450"));
				$datos=$datos.'</div>';
			}
				
			if($img->orden!=1){
				if($colorPredet == $img->color_id)
				{
					$datos=$datos.'<div class="item">';
					$datos=$datos.CHtml::image($img->getUrl(array('ext'=>'jpg')), $producto->nombre, array("width" => "450", "height" => "450"));
					$datos=$datos.'</div>';
				}
			}// que no es la primera en el orden
		}
		
        $datos=$datos.'</div>';
        $datos=$datos.'<a data-slide="prev" href="#myCarousel" class="left carousel-control">&lsaquo;</a>';
        $datos=$datos.'<a data-slide="next" href="#myCarousel" class="right carousel-control">&rsaquo;</a>';
        $datos=$datos.'</div></div>';
        
        $datos=$datos.'<div class="span5">';
        $datos=$datos.'<div class="row-fluid call2action">';
       	$datos=$datos.'<div class="'.$left.'">';
		
		/*foreach ($producto->precios as $precio) {
			if($precio->precioDescuento < $precio->precioImpuesto){
				$porcentaje = 100 - (($precio->precioDescuento * 100) / $precio->precioImpuesto);
				//$precio = "<span class='preciostrike strikethrough'>".Yii::t('contentForm', 'currSym')." ".$data->precio."</del></span> | ".Yii::t('contentForm', 'currSym')." ".$data->precioDescuento;
			$datos=$datos.'<span class="preciostrike strikethrough color9 T_mediumLarge">'.Yii::app()->numberFormatter->formatDecimal($precio->precioImpuesto)."</span><span class='T_large'> |</span> <span class='pDescuento'> ".''.Yii::t('contentForm', 'currSym')." ".$precio->precioDescuento.'</span><br/> <span class="conDescuento">Con '.round($porcentaje).'% de descuento</span>';

			}else{
				$datos=$datos.''.Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatDecimal($precio->precioImpuesto).'';
			}
   			//$datos=$datos.'<h4 class="precio"><span>Subtotal</span> '.Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatDecimal($precio->precioImpuesto).'</h4>';
   		}*/

   		$precio_producto = Precio::model()->findByAttributes(array('tbl_producto_id'=>$producto->id));
	    if($precio_producto){
	        if(!is_null($precio_producto->tipoDescuento) && $precio_producto->valorTipo > 0){
	          switch ($precio_producto->tipoDescuento) {
	            case 0:
	              $porcentaje = $precio_producto->valorTipo;
	              break;
	            case 1:
	              $porcentaje = ($precio_producto->valorTipo * 100) / $precio_producto->precioImpuesto;
	              break;
	            default:
	              # code...
	              break;
	          }
	          $precio_mostrar = $precio_producto->precioImpuesto;
	          $datos=$datos.'<span class="preciostrike strikethrough color9 T_mediumLarge">'.Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->format("#,##0.00",$precio_mostrar)."</span><span class='T_large'>|</span><span class='pDescuento'>".''.Yii::t('contentForm', 'currSym')." ".Yii::app()->numberFormatter->format("#,##0.00",$precio_producto->precioDescuento).'</span><br/> <span class="conDescuento">Con '.Yii::app()->numberFormatter->format("#",$porcentaje).'% de descuento</span>';
	          //echo '<span class="preciostrike strikethrough">'.Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatDecimal($precio_mostrar).'</span> | '.''.Yii::t('contentForm', 'currSym')." ".$precio_producto->precioImpuesto.' Con '.round($porcentaje).'% de descuento';
	        }else{
	        	$datos=$datos.'<div class="pDetalle"><span>'.Yii::t('contentForm', 'currSym').'</span>'.Yii::app()->numberFormatter->format("#,##0.00",$precio_producto->precioImpuesto).'</div>';
			}
	    }

        $datos=$datos.'</div>';
        
        $datos=$datos.'<div class="'.$right.' margin_top_xsmall">';
		if(is_null($tienda))
       		$datos=$datos.'<a class="btn btn-warning btn-block" title="agregar a la bolsa" id="agregar" onclick="c()"> Comprar </a>';
		else
			$datos=$datos.'<a class="btn btn-warning btn-block" target="_blank" href="'.$producto->url_externa.'" title="'.$msj.'" >'.$msj.'</a>';
        $datos=$datos.'</div></div>';
        
        $datos=$datos.'<p class="muted t_small CAPS">Selecciona Color y talla </p>';
        if($producto->mymarca->is_100chic)
        	$datos=$datos.'<div class="row-fluid"><div class="span12"><img src="'.Yii::app()->baseUrl.'/images/080bannerprevia.jpg'.'"</div><div class="row-fluid">';
		else
			$datos=$datos.'<div class="row-fluid"><div class="row-fluid">';
        $datos=$datos.'<div class="span6">';
        $datos=$datos.'<h5>Colores</h5>';
        $datos=$datos.'<div class="clearfix colores" id="vCo">';
        
        	$valores = Array();
            $cantcolor = Array();
            $cont1 = 0;
              	

			// revisando cuantos colores distintos hay 
			foreach ($producto->preciotallacolor as $talCol){ 


				if($talCol->cantidad > 0){
					$color = Color::model()->findByPk($talCol->color_id);
					
					if(in_array($color->id, $cantcolor)){	// no hace nada para que no se repita el valor			
					}
					else {
						array_push($cantcolor, $color->id);
						$cont1++;
					}	
				}
			}
				
			if( $cont1 == 1){ // Si solo hay un color seleccionelo
				$color = Color::model()->findByPk($cantcolor[0]);							
				$datos=$datos. "<div value='solo' id=".$color->id." style='cursor: pointer' class='coloress active' title='".$color->valor."'><img src='".Yii::app()->baseUrl."/images/colores/".$color->path_image."'></div>"; 		
			}
			else{
				foreach ($producto->preciotallacolor as $talCol) {
		        	if($talCol->cantidad > 0){ // que haya disp
						$color = Color::model()->findByPk($talCol->color_id);		
								
						if(in_array($color->id, $valores)){	// no hace nada para que no se repita el valor			
						}
						else{
							$datos=$datos. "<div id=".$color->id." style='cursor: pointer' class='coloress' title='".$color->valor."'><img src='".Yii::app()->baseUrl."/images/colores/".$color->path_image."'></div>"; 
							array_push($valores, $color->id);
						}
					}
		   		}
				
			} // else 
		
		//$datos=$datos.'<div title="Rojo" class="coloress" style="cursor: pointer" id="8"><img src="/site/images/colores/C_Rojo.jpg"></div>              </div>';
        $datos=$datos.'</div></div>';
		
        $datos=$datos.'<div class="span6">';
        $datos=$datos.'<h5>Tallas</h5>';
		$datos=$datos.'<div class="clearfix tallas" id="vTa">';
		
		$valores = Array();
		$canttallas= Array();
        $cont2 = 0;
              	
		// revisando cuantas tallas distintas hay
		foreach ($producto->preciotallacolor as $talCol){ 
			if($talCol->cantidad > 0){
				$talla = Talla::model()->findByPk($talCol->talla_id);
						
				if(in_array($talla->id, $canttallas)){	// no hace nada para que no se repita el valor			
				}
				else{
					array_push($canttallas, $talla->id);
					$cont2++;
				}
							
			}
		}

		if( $cont2 == 1){ // Si solo hay un color seleccionelo
			$talla = Talla::model()->findByPk($canttallas[0]);
			$datos=$datos. "<div value='solo' id=".$talla->id." style='cursor: pointer' class='tallass active' title='talla'>".$talla->valor."</div>"; 
		}
		else{            	
			foreach ($producto->preciotallacolor as $talCol) {
	        	if($talCol->cantidad > 0){ // que haya disp
					$talla = Talla::model()->findByPk($talCol->talla_id);
		
					if(in_array($talla->id, $valores)){	// no hace nada para que no se repita el valor			
					}
					else{
						$datos=$datos. "<div id=".$talla->id." style='cursor: pointer' class='tallass' title='talla'>".$talla->valor."</div>"; 
						array_push($valores, $talla->id);
					}
				}
	   		}	
	   	}// else
		
       // $datos=$datos.'<div title="talla" class="tallass" style="cursor: pointer" id="10">S</div>';         	     	
        $datos=$datos.'</div></div></div> <div class="row-fluid"> <hr/> ';
		$marca = Marca::model()->findByPk($producto->marca_id);
        $datos=$datos.'<h5>Marca</h5>';
        $datos=$datos.'<div class="thumbnails">';
        $datos=$datos.'<img width="66px" height="66px" src="'.Yii::app()->baseUrl .'/images/marca/'. str_replace(".","_thumb.",$marca->urlImagen).'"/>';
        $datos=$datos.'</div>';
        $datos=$datos.'</div></div></div>';
        $datos=$datos.'</div>';
   
   		$datos=$datos.'</div>';
    	$datos=$datos.'<div class="modal-footer">';
		$datos=$datos.'<a href="'.$producto->getUrl().'" class="btn btn-info pull-left"> Ver el producto </a>';
    	$datos=$datos.'<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>';
    	$datos=$datos.'</div>';
    	$datos=$datos.'
    	<div id="alertRegister" class="modal hide" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" >
		 <div class="modal-header">
		    <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">×</button>
		     <h3 >'.Yii::t('contentForm','Important').'</h3>
		 
		  </div>
		  <div class="modal-body">
		 		 <h4>'.Yii::t('contentForm','Please complete your registration to make a purchase on Personaling.').'</h4>
		 		 
		  </div>  
		  <div class="modal-footer">  
		  	<div class="row-fluid">
		  		<a class="btn btn-danger span3" href="<?php echo Yii::app()->baseUrl;?>/registro-personaling">'.Yii::t('contentForm','Complete Registration').'</a>
		 		<div class="span6"></div>
		 		<button class="btn closeModal span3" data-dismiss="modal" aria-hidden="true">Cerrar</button>
		 	
		  	</div>
		  	
		  	
		  </div>
		</div>';
    
    	$datos=$datos."<script>";
		$datos.='$("body").removeClass("aplicacion-cargando");var bandera=false;';
		$datos=$datos."$(document).ready(function() {";
		$datos=$datos."$('.closeModal').click(function(event){";
		$datos=$datos."$('#alertRegister').hide();});";
			$datos=$datos."$('.coloress').click(function(ev){"; // Click en alguno de los colores -> cambia las tallas disponibles para el color
				$datos=$datos."ev.preventDefault();";
				//$datos=$datos."alert($(this).attr('id'));";
				
				$datos=$datos.' var prueba = $("#vTa div.tallass.active").attr("value");';
			$datos=$datos."if(prueba == 'solo'){";
   				$datos=$datos."$(this).addClass('coloress active');"; // aÃ±ado la clase active al seleccionado
   				$datos=$datos."$('#vTa div.tallass.active').attr('value','0');";
			$datos=$datos.'}';
   			$datos=$datos.'else{';
				$datos=$datos.'$("#vCo").find("div").siblings().removeClass("active");'; // para quitar el active en caso de que ya alguno estuviera seleccionado
   				$datos=$datos.'var dataString = $(this).attr("id");';
     			$datos=$datos.'var prod = $("#producto").attr("value");';
     			$datos=$datos."$(this).removeClass('coloress');";
  				$datos=$datos."$(this).addClass('coloress active');"; // aÃ±ado la clase active al seleccionado
				
  				$datos=$datos. CHtml::ajax(array(
            		'url'=>array('producto/tallaspreview'),
		            'data'=>array('idTalla'=>"js:$(this).attr('id')",'idProd'=>$id),
		            'type'=>'post',
		            'dataType'=>'json',
		            'success'=>"function(data)
		            {
						//alert(data.datos);
						
						$('#vTa').fadeOut(100,function(){
			     			$('#vTa').html(data.datos); // cambiando el div
			     		});
			
			      		$('#vTa').fadeIn(20,function(){});
						
						$('#carruselImag').fadeOut(100,function(){
			     			$('#carruselImag').html(data.imagenes); 
			     		});
			
			      		$('#carruselImag').fadeIn(20,function(){});
						
						//$('#carruselImag').html(data.imagenes);
						
		 				
		            } ",
		            ));
		    	$datos=$datos." return false; ";

				
				$datos=$datos.'}'; // else
				
			$datos=$datos."});";// coloress click
			
			
		$datos=$datos.'$(".tallass").click(function(ev){ '; // click en tallas -> recarga los colores para esa talla
			$datos=$datos."ev.preventDefault();";
			//$datos=$datos."alert($(this).attr('id'));";
		
			$datos=$datos.'var prueba = $("#vCo div.coloress.active").attr("value");';

   			$datos=$datos."if(prueba == 'solo'){";
   				$datos=$datos."$(this).addClass('tallass active');"; // aÃ±ado la clase active al seleccionado
   				$datos=$datos.'$("#vCo div.coloress.active").attr("value","0");';
   			$datos=$datos."}";
   			$datos=$datos."else{";
		   		$datos=$datos.'$("#vTa").find("div").siblings().removeClass("active");'; // para quitar el active en caso de que ya alguno estuviera seleccionado
		   		$datos=$datos.'var dataString = $(this).attr("id");';
     			$datos=$datos.'var prod = $("#producto").attr("value");';
     
     			$datos=$datos."$(this).removeClass('tallass');";
  				$datos=$datos."$(this).addClass('tallass active');"; // aÃ±ado la clase active al seleccionado
     
     			$datos=$datos. CHtml::ajax(array(
            		'url'=>array('producto/colorespreview'),
		            'data'=>array('idColor'=>"js:$(this).attr('id')",'idProd'=>$id),
		            'type'=>'post',
		            'dataType'=>'json',
		            'success'=>"function(data)
		            {
						//alert(data.datos);
						
						$('#vCo').fadeOut(100,function(){
			     			$('#vCo').html(data.datos); // cambiando el div
			     		});
			
				      	$('#vCo').fadeIn(20,function(){});				

		            } ",
		            ));
		    		$datos=$datos." return false; ";     
     
				$datos=$datos."}"; //else
			$datos=$datos."});"; // tallas click
			
		$datos=$datos."});"; // ready
		
		// fuera del ready
		
		$datos=$datos."function a(id){";// seleccion de talla
			$datos=$datos.'$("#vTa").find("div").siblings().removeClass("active");';
			$datos=$datos.'$("#vTa").find("div#"+id+".tallass").removeClass("tallass");';
			$datos=$datos.'$("#vTa").find("div#"+id).addClass("tallass active");';
   		$datos=$datos."}";
   
   		$datos=$datos."function b(id){"; // seleccion de color
   			$datos=$datos.'$("#vCo").find("div").siblings().removeClass("active");';
   			$datos=$datos.'$("#vCo").find("div#"+id+".coloress").removeClass("coloress");';
			$datos=$datos.'$("#vCo").find("div#"+id).addClass("coloress active");';		
   		$datos=$datos."}";
		
		$datos=$datos."function c(){"; // comprobar quienes estÃ¡n seleccionados
   		
   			$datos=$datos.'var talla = $("#vTa").find(".tallass.active").attr("id");';
   			$datos=$datos.'var color = $("#vCo").find(".coloress.active").attr("id");';
   			$datos=$datos.'var producto = $("#producto").attr("value");';
   		
   			// llamada ajax para el controlador de bolsa
 		  
 			$datos=$datos."if(talla==undefined && color==undefined){"; // ninguno
 				$datos=$datos.'alert("Seleccione talla y color para poder aÃ±adir.");';
 			$datos=$datos."}";
 		
 			$datos=$datos."if(talla==undefined && color!=undefined){"; // falta talla 
 				$datos=$datos.'alert("Seleccione la talla para poder aÃ±adir a la bolsa.");';
 			$datos=$datos.'}';
 		
 			$datos=$datos.'if(talla!=undefined && color==undefined){'; // falta color
 				$datos=$datos.'alert("Seleccione el color para poder aÃ±adir a la bolsa.");';
 			$datos=$datos.'}';
			
			$datos=$datos.'if(talla!=undefined && color!=undefined){';
			 $datos.= 'if(bandera==true) return false; bandera = true;';
			$datos=$datos.'$("#agregar").click(function(e){e.preventDefault();});$("#agregar").addClass("disabled"); ';
				$datos=$datos. CHtml::ajax(array(
	            	'url'=>array('bolsa/agregar'),
			        'data'=>array('producto'=>$id,'talla'=>'js:$("#vTa").find(".tallass.active").attr("id")','color'=>'js:$("#vCo").find(".coloress.active").attr("id")'),
			        'type'=>'post',
			        'success'=>"function(data)
			        {
						if(data=='ok'){
							//alert('redireccionar maÃ±ana');
							window.location='../bolsa/index';
						}
						
						if(data=='no es usuario'){
							$('#alertRegister').show();
						}
						
			        } ",
		   		));
				$datos=$datos." return false; ";     
 			$datos=$datos.'}'; // cerro   
			
		$datos=$datos.'}'; // c
			
    $datos=$datos."</script>";
		
	echo $datos;
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
        
        
       public function actionGuardarFiltro() {

           $filtroPerfil = true;
            
            if(isset($_POST['Profile'])){
                
                foreach ($_POST['Profile'] as $campo){
                    
                    if(empty($campo)){
                       $filtroPerfil = false;
                       break;
                   } 
                }        
            }
            
//            echo "<pre>";
//                print_r($_POST);
//                echo "</pre>";
//                echo "filtroperfil: ".$filtroPerfil;
//                
//                exit();
            
            if(!$filtroPerfil)
            {
                $response['status'] = 'error';
                $response['message'] = 'No se pudo guardar el filtro, faltan campos para el perfil';
            }
            else                
            {
                //si es nuevo
                if (isset($_POST['name'])) {

                    $filter = Filter::model()->findByAttributes(
                            array('name' => $_POST['name'], 'type' => '0', 'user_id' => Yii::app()->user->id) //Comprobar que no exista el nombre
                    );

                    if (!$filter) {
                        $filter = new Filter;
                        $filter->name = $_POST['name'];
                        $filter->type = 0;
                        $filter->user_id = Yii::app()->user->id;

                        if ($filter->save()) {
                            $filterProfile = new FilterProfile;
                            $filterProfile->attributes = $_POST['Profile'];
                            $filterProfile->id_filter = $filter->id_filter;

                            if($filterProfile->validate()){
                                $filterProfile->save();
                                $response['status'] = 'success';
                                $response['message'] = 'Filtro <b>' . $filter->name . '</b> guardado con Éxito';
                                $response['idFilter'] = $filter->id_filter;                        
                            }
                        }

                    }
                    else //si ya existe
                    {
                        $response['status'] = 'error';
                        $response['message'] = 'No se pudo guardar el filtro, el nombre <b>"' .
                                               $filter->name . '"</b> ya existe';
                    }

                    /* si esta guardando uno existente */
                } else if (isset($_POST['id'])) {

                    $filter = Filter::model()->findByPk($_POST['id']);

                    if ($filter) {

                        $filterProfile = $filter->filterProfiles[0];
                        $filterProfile->attributes = $_POST['Profile'];

                        if($filterProfile->validate()){

                            $filterProfile->save();
                            $response['status'] = 'success';
                            $response['message'] = 'Filtro <b>' . $filter->name . '</b> guardado con éxito';                        
                        }

                        //si NO existe el ID
                    } else {
                        $response['status'] = 'error';
                        $response['message'] = 'El filtro no existe';
                    }
                }
                
            }



        

        echo CJSON::encode($response);
    }
       
       public function actionGetFilter() {
           $response = array();
            if(isset($_POST['id'])){
                $filter = Filter::model()->findByPk($_POST['id']);                
                
                if($filter){     
                   $response['filter']  = $filter->filterProfiles[0]->attributes;
                   $response['status'] = 'success';
                   $response['message'] = 'Filtro encontrado';
                   $response['name'] = $filter->name;
                    
                }else{
                  $response['status'] = 'error';
                  $response['message'] = 'Filtro no encontrado';
                }               
                
                
            }
            
            echo CJSON::encode($response);
       }


	
    //Funcion que se llama cuando se intenta comprar para alguien mas desde afuera de la tienda
    public function actionRedirect() {
        
        $response = array();
        $response["status"] = "success";
        
        if(isset($_POST["agregar"])){            
         
          Yii::app()->session["modalOn"] = true;
          //$this->redirect("look");
          
        }elseif(isset($_POST["perfil"])) {
            
            Yii::app()->session["profileOn"] = $_POST["perfil"];
            
        }else{
            
          $response["status"] = "error";
          
        }
        
        echo CJSON::encode($response);
        
    }    
    
    /**
     * Retorna el codigo html para un modal especificado en la variable POST "modal"
     * En el archivo main se puso un div con id=modalAjax que esta disponible en
     * todo el sitio para cuando se requiera mostrar un modal dinamico
     */
    public function actionModalAjax() {
        Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;	
        Yii::app()->clientScript->scriptMap['bootstrap.js'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap.css'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap.bootbox.min.js'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap-responsive.css'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap-yii.css'] = false;
        Yii::app()->clientScript->scriptMap['jquery-ui-bootstrap.css'] = false;
        Yii::app()->clientScript->scriptMap['bootstrap.min.css'] = false;	
        Yii::app()->clientScript->scriptMap['bootstrap.min.js'] = false;
                                
        
        if($_POST["modal"] == "perfiles"){
            
           $response["data"] =  $this->renderPartial("_modalAjax", array(), true, true);           
            
        }     
        if($_POST["modal"] == "giftcard"){
            
           $response["data"] =  $this->renderPartial("//giftcard/_modalGiftCard", array("id" => $_POST["id"]), true, true);           
            
        }     
        
        
        echo CJSON::encode($response);
        
    }

	public function actionXmltest(){
		$this->renderPartial('xmltest');
	}
      
	public function actionBF080(){
		Yii::app()->session['080']=1;
		$this->redirect(array('index'));
	}
        
}
