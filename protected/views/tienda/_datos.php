
<style>
    div.infinite_navigation{
        display:none;
    }
</style>

			<?php //echo "paginas".$pages->pageCount; ?> 
			<?php //echo "items".$pages->itemCount; ?> 
			<?php //echo "page".$pages->currentPage; ?>
			<?php //echo "size".$pages->pageSize; ?>

<div class="items" id="catalogo">
   
      	
<?php
$cont = 1;

foreach($prods as $data): 

	//echo 'producto';

	$category_product = CategoriaHasProducto::model()->findByAttributes(array('tbl_producto_id'=>$data->id));
    $category = Categoria::model()->findByPk($category_product->tbl_categoria_id);

    
    ?>

    <?php

	// registrar impresión en google analytics
	Yii::app()->clientScript->registerScript('metrica_analytics_'.$cont,"
		console.log('tales');

		ga('ec:addImpression', {            // Provide product details in an impressionFieldObject.
		  'id': '".$data->id."',                   // Product ID (string).
		  'name': '".$data->nombre."', // Product name (string).
		  'category': '".$category->nombre."',   // Product category (string).
		  'brand': '".$data->mymarca->nombre."',                // Product brand (string).
		  //'variant': 'Black',               // Product variant (string).
		  'list': 'Product impression',         // Product list (string).
		  'position': ".$cont.",                    // Product position (number).
		  //'dimension1': 'Member'            // Custom dimension (string).
		});
		
		ga('send', 'pageview');              // Send product impressions with initial pageview.

		

	", CClientScript::POS_END);	

	$cont++;

	if($data->tipo){
		$tienda=Tienda::model()->findByPk($data->tienda_id);
	}
		
	else
		$tienda=null;
?>
	<div class="div_productos">
		<div class="json_product" style="display:none;">
    	<?php
    	// hidden div con json para la función que se ejecuta con el scroll infinito
    	echo json_encode(array(
    		'id' => $data->id,
    		'name' => $data->nombre,
    		'category' => $category->nombre,
    		'brand' => $data->mymarca->nombre,
    		'list' => 'Product impression',
    		'position' => $cont
    	));
    	?>
    </div>
	<?php
	
$id=0;
$entro=0;
$con=0;
$prePub="";
$a='';
$b='';
	
	$ims = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$data->id),array('order'=>'orden asc'));

	
	
	$ima=$ims[0];
	if(isset($ims[1]))
		$segunda=$ims[1];
	else
		$segunda=$ims[0];
	
	
	
	if(isset(Yii::app()->session['f_color'])){
					
		if(Yii::app()->session['f_color']!=0){
			
			$ims = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$data->id,'color_id'=>Yii::app()->session['f_color']),array('order'=>'orden asc'));
						
			if(count($ims)>0){
				$ima=$ims[0];
			}
			if(count($ims)>1){
				$segunda=$ims[1];
			}
		}
						
	}


	

	   	/*if($data->precios){
	   	foreach ($data->precios as $precio) {
	   		$prePub = Yii::app()->numberFormatter->format("#,##0.00",$precio->precioImpuesto);
	   		//$prePub = Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento);
			}
		}*/ 
		//var_dump($data);
		$prePub=$data->precio;
		echo ' <input id="productos" value="'.$data->id.'" name="ids" class="ids" type="hidden" >';
                
                //Icono de descuento - Color Negro
				$iconoDescuento = '';
				$precio_producto = Precio::model()->findByAttributes(array('tbl_producto_id'=>$data->id));
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
						$iconoDescuento = '<div class="icono-descuento">'.round($porcentaje).'%<span>Descuento</span></div>';
					}
				}

				// si no tiene descuento reviso si está marcada como precio especial para agregar el ícono
				if($iconoDescuento == '' && $data->precio_especial == 1){
					$iconoDescuento = '<div class="icono-descuento"><span style="font-size: 13px; line-height: 1.2em;">Precio especial</span></div>';
				}

				//var_dump($data->tipoDescuento);
				/*if($data->precioVenta < $data->getPrecioImpuesto()){
					$porcentaje = (($data->getPrecioImpuesto() - $data->precioVenta) * 100) / $data->getPrecioImpuesto();
					$iconoDescuento = '<div class="icono-descuento">'.round($porcentaje).'%<span>Descuento</span></div>';
				}*/
                
//                $iconoDescuento = '';
                
		if(isset($ima)){
			
			//if($prePub!=""){
			
				//echo"<tr>";
				$like = UserEncantan::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'producto_id'=>$data->id));
            	
            	if(isset($like)) // le ha dado like
				{
					$encabezado="<td><article class='span3'><div onmouseover='javascript:over(".$data->id.");' onmouseout='javascript:out(".$data->id.");' class='producto articulo' id='prod".$data->id."'> ";
					$gusta="{$iconoDescuento}<a id='like".$data->id."' onclick='encantar(".$data->id.")' style='cursor:pointer' title='Me encanta' class='entypo like icon_personaling_big like-active'>&hearts;
                                            </a></div></article></td>";
				}
				else{
					$encabezado="<article class='span3'><div  onmouseover='javascript:over(".$data->id.");' onmouseout='javascript:out(".$data->id.");' class='producto articulo' id='prod".$data->id."'>";
					$gusta="{$iconoDescuento}<a id='like".$data->id."' onclick='encantar(".$data->id.")' style='cursor:pointer' title='Me encanta' class='entypo like icon_personaling_big'>&#9825;
                                            </a></div></article>";
				}
				if(Yii::app()->user->isGuest){
					$gusta="{$iconoDescuento}</div></article>";
				}
					$a = CHtml::image(str_replace(".","_thumb.",$ima->getUrl()), "Imagen ", array("class"=>"img_hover bg_color3","width" => "270", "height" => "270",'id'=>'img-'.$data->id));
					$b = '';
					$style='';
					if($data->mymarca->is_100chic){
						$style="<span class='btn-block is_080'><img src='".Yii::app()->baseUrl."/images/080_270x34.jpg'/></span> ";
					}
					if(isset($segunda))
						//echo "<input id='img2-".$data->id."' value='".$segunda->getUrl()."' type='hidden' >";
						//$b = CHtml::image($segunda->ge     tUrl(), "Segunda ", array("width" => "270", "height" => "270",'display'=>'none','id'=>'img2-'.$data->id));
						$b = CHtml::image(str_replace(".","_thumb.",$segunda->getUrl()), "Imagen ", array("class"=>"img_hover_out bg_color3","style"=>"display:none","width" => "270", "height" => "270"));

					//reviso si tiene descuento para mostrarlo
						
						$precio = "<span class='precio'>".Yii::t('contentForm', 'currSym')." ".$data->getPrecioImpuesto()."</span>";
						if($precio_producto){
							if(!is_null($precio_producto->tipoDescuento) && $precio_producto->valorTipo > 0){
								$precio_mostrar = $precio_producto->precioImpuesto;
								$precio = "<span class='preciostrike strikethrough'><small>".Yii::t('contentForm', 'currSym')." ".$data->getPrecioImpuesto()."</small></span> | ".Yii::t('contentForm', 'currSym')." ".$data->getPrecioDescuento();
							}
						}
						if(!is_null($tienda))
							$precio = "<span class='precio' style='display:inline'>".Yii::t('contentForm', 'currSym')." ".$data->getPrecioImpuesto()."</span>&nbsp;&nbsp;&nbsp;<span><a href='".$data->getUrl()."' style='color:#3286A5; cursor:pointer'>".$tienda->urlVista."</a></span>";
							

						echo($encabezado."
						<input id='idprod' value='".$data->id."' type='hidden' ><a href='".$data->getUrl()."'>
						".$a.$b.
						CHtml::link("Vista Rápida",
						    $this->createUrl('modal',array('id'=>$data->id)),
						    array(// for htmlOptions
						      'onclick'=>' {'.CHtml::ajax( array(
						      'url'=>CController::createUrl('modal',array('id'=>$data->id)),
						           'success'=>"js:function(data){ $('#myModal').html(data);
											$('#myModal').modal(); }")).
						         'return false;}',
						    'class'=>'btn btn-block btn-small vista_rapida hidden-phone',
						    'id'=>'prodencanta')
						).$style."		 
												
						</a>
						<header><h3><a class='link_producto' href='".$data->getUrl()."' title='".$data->nombre."'>".$data->nombre."</a></h3>
						<a href='".$data->getUrl()."' class='ver_detalle icon_lupa' title='Ver detalle'></a></header>
						".$precio.$gusta);
						
						
						$con=$id;
					
				
				/*	$a = CHtml::image(str_replace(".","_thumb.",$ima->getUrl()), "Imagen ", array("class"=>"img_hover","width" => "270", "height" => "270",'id'=>'img-'.$data->id));	
					$b = '';
					$style='';
					if($data->mymarca->is_100chic){
						$style="<div class='is_100chic'> </div> ";
					}
					if(isset($segunda))
					{	$b = CHtml::image(str_replace(".","_thumb.",$segunda->getUrl()), "Imagen ", array("class"=>"img_hover_out","style"=>"display:none","width" => "270", "height" => "270"));
					}
					echo("<article class='span3'><div  onmouseover='javascript:over(".$data->id.");' onmouseout='javascript:out(".$data->id.");' class='producto articulo' id='prod".$data->id."'>".$style."
					<input id='idprod' value='".$data->id."' type='hidden' ><a href='".$data->getUrl()."'>
					".$a.$b." 
						
					".CHtml::link("Vista Rápida",
					    $this->createUrl('modal',array('id'=>$data->id)),
					    array(// for htmlOptions
					      'onclick'=>' {'.CHtml::ajax( array(
					      'url'=>CController::createUrl('modal',array('id'=>$data->id)),
					           'success'=>"js:function(data){ $('#myModal').html(data);
										$('#myModal').modal(); }")).
					         'return false;}',
					    'class'=>'btn btn-block btn-small vista_rapida hidden-phone',
					    'id'=>'pago')
					)."		
						 
					</a>
					<header><h3><a href='".$data->getUrl()."' title='".$data->nombre."'>".$data->nombre."</a></h3>
					<a href='".$data->getUrl()."' class='ver_detalle  icon_lupa' title='Ver detalle'></a></header>
					<span class='precio'>Bs. ".$prePub."</span>
					<a id='like".$data->id."' onclick='encantar(".$data->id.")' style='cursor:pointer' title='Me encanta' class='entypo like icon_personaling_big'>&#9825;</a></div></article>");
					
					$con=$id;*/
						
				  
				
				//echo("</tr>");
			//}
		
		}

?>
</div>

<?php

endforeach;?>
</div>
<script>	
mixpanel.track_links(".link_producto", "Clicked Productos",function(ele) { 
    alert('asd');
    return { type: $(ele).attr('href')}
    });
function over(id){
		

		if ($("#prod"+id.toString()).find("img").length > 1){
		$("#prod"+id.toString()).find("img").eq(0).hide();
		
		$("#prod"+id.toString()).find("img").eq(0).next().show();
		}
}
function out(id){
 		
 	
		if ($("#prod"+id.toString()).find("img").length > 1){
		$("#prod"+id.toString()).find("img").eq(0).show();
		
		$("#prod"+id.toString()).find("img").eq(0).next().hide();
		}
}
	

</script>

<?php 
//echo "LORE"; 
$this->widget('ext.yiinfinite-scroll.YiinfiniteScroller', array(
	    'contentSelector' => '#catalogo',
	    'itemSelector' => 'div.div_productos',
	    'loadingText' => 'Consultando Productos',
	    'donetext' => 'No more',

	    //'afterAjaxUpdate' => 'alert("hola");',
	    'pages' => $pages,
	)); 
			


?>

