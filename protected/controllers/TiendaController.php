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
				'actions'=>array('index','filtrar','categorias','imageneslooks','segunda','look','ocasiones','modal'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index'),
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
			//echo $producto->nombre = '%'.$_POST['busqueda'].'%';
			$producto->nombre = $_POST['busqueda'];
		}
	
		$categorias = Categoria::model()->findAllByAttributes(array("padreId"=>1));
		
		$todos = array();
		$todos = $this->getAllChildren(Categoria::model()->findAllByAttributes(array("padreId"=>$producto->categoria_id)));
		//print_r($todos);
		//$dataProvider = $producto->busqueda('');
		$dataProvider = $producto->busqueda($todos);
		//$dataProvider = $producto->search();
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
			

		if (isset($_POST['check_ocasiones']) || isset($_POST['check_shopper'])){
					
			$criteria = new CDbCriteria;
			
			
			if (isset($_POST['check_ocasiones'])){
			$condicion = "";	
			$criteria->with = array('categorias');	
			$criteria->together = true;
			foreach ($_POST['check_ocasiones'] as $categoria_id)
				$condicion .= "categorias_categorias.categoria_id = ".$categoria_id." OR ";
			$condicion = substr($condicion, 0, -3);
			$criteria->addCondition($condicion);
			}
			if (isset($_POST['check_shopper'])){
			$condicion = "";		
			foreach ($_POST['check_shopper'] as $user_id)
				$condicion .= "user_id = ".$user_id." OR ";
			$condicion = substr($condicion, 0, -3);
			$criteria->addCondition($condicion);				
			}
			//	$criteria->compare('categorias_categorias.categoria_id',$categoria_id,true,'OR');
			//$criteria->compare('categorias_categorias.categoria_id',$_POST['check_ocasiones']);
			$total = Look::model()->count($criteria);
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
	                'condicion'=>$total,
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


	public function actionModal($id)
	{ 
		
		$datos="";
		
		$producto = Producto::model()->findByPk($id);
		
		//$datos=$datos."<div id='myModal' class='modal hide tienda_modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>";
    	$datos=$datos."<div class='modal-header'>";
		$datos=$datos."<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>";
		$datos=$datos."<h3 id='myModalLabel'>".$producto->nombre."</h3></div>";
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
        $datos=$datos.'<a data-slide="prev" href="#myCarousel" class="left carousel-control">‹</a>';
        $datos=$datos.'<a data-slide="next" href="#myCarousel" class="right carousel-control">›</a>';
        $datos=$datos.'</div></div>';
        
        $datos=$datos.'<div class="span5">';
        $datos=$datos.'<div class="row-fluid call2action">';
       	$datos=$datos.'<div class="span7">';
		
		foreach ($producto->precios as $precio) {
   			$datos=$datos.'<h4 class="precio"><span>Subtotal</span> Bs. '.Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento).'</h4>';
   		}

        $datos=$datos.'</div>';
        
        $datos=$datos.'<div class="span5">';
        $datos=$datos.'<a class="btn btn-warning btn-block" title="agregar a la bolsa" id="agregar" onclick="c()"> Comprar </a>';
        $datos=$datos.'</div></div>';
        
        $datos=$datos.'<p class="muted t_small CAPS">Selecciona Color y talla </p>';
        $datos=$datos.'<div class="row-fluid">';
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
        $datos=$datos.'</div></div></div>';
          
        $datos=$datos.'</div>';
        $datos=$datos.'</div>';
   
   		$datos=$datos.'</div>';
    	$datos=$datos.'<div class="modal-footer">';
    	$datos=$datos.'<button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>';
    	$datos=$datos.'</div>';
    //	$datos=$datos.'</div>';
    
    	$datos=$datos."<script>";
		
		$datos=$datos."$(document).ready(function() {";
			$datos=$datos."$('.coloress').click(function(ev){"; // Click en alguno de los colores -> cambia las tallas disponibles para el color
				$datos=$datos."ev.preventDefault();";
				//$datos=$datos."alert($(this).attr('id'));";
				
				$datos=$datos.' var prueba = $("#vTa div.tallass.active").attr("value");';
			$datos=$datos."if(prueba == 'solo'){";
   				$datos=$datos."$(this).addClass('coloress active');"; // añado la clase active al seleccionado
   				$datos=$datos."$('#vTa div.tallass.active').attr('value','0');";
			$datos=$datos.'}';
   			$datos=$datos.'else{';
				$datos=$datos.'$("#vCo").find("div").siblings().removeClass("active");'; // para quitar el active en caso de que ya alguno estuviera seleccionado
   				$datos=$datos.'var dataString = $(this).attr("id");';
     			$datos=$datos.'var prod = $("#producto").attr("value");';
     			$datos=$datos."$(this).removeClass('coloress');";
  				$datos=$datos."$(this).addClass('coloress active');"; // añado la clase active al seleccionado
				
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
   				$datos=$datos."$(this).addClass('tallass active');"; // añado la clase active al seleccionado
   				$datos=$datos.'$("#vCo div.coloress.active").attr("value","0");';
   			$datos=$datos."}";
   			$datos=$datos."else{";
		   		$datos=$datos.'$("#vTa").find("div").siblings().removeClass("active");'; // para quitar el active en caso de que ya alguno estuviera seleccionado
		   		$datos=$datos.'var dataString = $(this).attr("id");';
     			$datos=$datos.'var prod = $("#producto").attr("value");';
     
     			$datos=$datos."$(this).removeClass('tallass');";
  				$datos=$datos."$(this).addClass('tallass active');"; // añado la clase active al seleccionado
     
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
		
		$datos=$datos."function c(){"; // comprobar quienes están seleccionados
   		
   			$datos=$datos.'var talla = $("#vTa").find(".tallass.active").attr("id");';
   			$datos=$datos.'var color = $("#vCo").find(".coloress.active").attr("id");';
   			$datos=$datos.'var producto = $("#producto").attr("value");';
   		
   			// llamada ajax para el controlador de bolsa
 		  
 			$datos=$datos."if(talla==undefined && color==undefined){"; // ninguno
 				$datos=$datos.'alert("Seleccione talla y color para poder añadir.");';
 			$datos=$datos."}";
 		
 			$datos=$datos."if(talla==undefined && color!=undefined){"; // falta talla 
 				$datos=$datos.'alert("Seleccione la talla para poder añadir a la bolsa.");';
 			$datos=$datos.'}';
 		
 			$datos=$datos.'if(talla!=undefined && color==undefined){'; // falta color
 				$datos=$datos.'alert("Seleccione el color para poder añadir a la bolsa.");';
 			$datos=$datos.'}';
		
			$datos=$datos.'if(talla!=undefined && color!=undefined){';
		
				$datos=$datos. CHtml::ajax(array(
	            	'url'=>array('bolsa/agregar'),
			        'data'=>array('producto'=>$id,'talla'=>'js:$("#vTa").find(".tallass.active").attr("id")','color'=>'js:$("#vCo").find(".coloress.active").attr("id")'),
			        'type'=>'post',
			        'success'=>"function(data)
			        {
						if(data=='ok'){
							//alert('redireccionar mañana');
							window.location='../bolsa/index';
						}
						
						if(data=='no es usuario'){
							alert('Debes primero ingresar con tu cuenta de usuario o registrarte');
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
}