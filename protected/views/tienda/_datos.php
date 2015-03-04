
<style>
    div.infinite_navigation{
        display:none;
    }
</style>
<?php //PC::debug("APPLICATION_ENV: ".$_SERVER['HTTP_APPLICATION_ENV'],'debug'); ?>
<div class="items" id="catalogo">
<?php
$cont = 1;
foreach($prods as $data): 
	$category = $data->categorias[0];
    if (isset($category)){
		// registrar impresión en google analytics
		Yii::app()->clientScript->registerScript('metrica_analytics_'.$cont,"
			//console.log('tales');

			ga('ec:addImpression', {            // Provide product details in an impressionFieldObject.
			  'id': '".$data->id."',                   // Product ID (string).
			  'name': '".addslashes ($data->nombre)."', // Product name (string).
			  'category': '".addslashes ($category->nombre)."',   // Product category (string).
			  'brand': '".addslashes ($data->mymarca->nombre)."',                // Product brand (string).
			  //'variant': 'Black',               // Product variant (string).
			  'list': 'Product impression',         // Product list (string).
			  'position': ".$cont.",                    // Product position (number).
			  //'dimension1': 'Member'            // Custom dimension (string).
			});
			
			ga('send', 'pageview');              // Send product impressions with initial pageview.
		", CClientScript::POS_END);	

	}
	if($data->tipo)	$tienda=Tienda::model()->findByPk($data->tienda_id);
	else $tienda=null;
	$string= $data->mymarca->nombre;
	$string=str_replace("'","/",$string);
	$json_detalle_producto = json_encode(array(
							    		'id' => $data->id,
							    		'name' => $data->nombre,
							    		'category' => $category->nombre,
							    		//'brand' => str_replace("'","\'",$data->mymarca->nombre),
                                        'brand' => $data->mymarca->nombre,
							    		'list' => 'Product clicks',
							    		'position' => $cont,
							    		'url' => $data->getUrl()
									), JSON_HEX_APOS);

?>
	<div class="div_productos">
		<div class="json_product" style="display:none;">
	    	<?php
	    	// hidden div con json para la función que se ejecuta con el scroll infinito
	    	echo $json_detalle_producto;
	    	?>
	    </div>
<?php
	
	$id=0;
	$entro=0;
	$con=0;
	$prePub="";
	$a='';
	$b='';
	//$ims = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$data->id),array('order'=>'orden asc'));
	$ims = $data->imagenes;
	$ima=$ims[0];
	$segunda = isset($ims[1])?$ims[1]:$ims[0];
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
		$porcentaje=0;
		$prePub=$data->precio;
		echo ' <input id="productos" value="'.$data->id.'" name="ids" class="ids" type="hidden" >';
                
                //Icono de descuento - Color Negro
				$iconoDescuento = '';
				//$precio_producto = Precio::model()->findByAttributes(array('tbl_producto_id'=>$data->id));
				$precio_producto = $data->precios[0];
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
								//$porcentaje = 0;
								break;
						}
						$iconoDescuento = '<div class="icono-descuento">'.round($porcentaje).'%<span>Descuento</span></div>';
					}
				}
				if(round($porcentaje)==0)
					$iconoDescuento="";
				
				// si no tiene descuento reviso si está marcada como precio especial para agregar el ícono
				if($iconoDescuento == '' && $data->precio_especial == 1 ) 
				{
					$iconoDescuento = '<div class="icono-descuento"><span style="font-size: 13px; line-height: 1.2em;">Precio especial</span></div>';
				}
				if($data->preciotallacolorSum<1) //si no quedan productos, no mostrar ofertas; si no decir que el producto esta agotado.
				{
					$iconoDescuento = '<div class="icono-descuento"><span style="font-size: 13px; line-height: 2.6em;">Agotado</span></div>';
				}
	
	if (isset($ima)): 

 		$like = UserEncantan::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'producto_id'=>$data->id)); ?>	
 		<article class='span3'>
 			<div onmouseover='javascript:over(<?php echo $data->id; ?>);' onmouseout='javascript:out(<?php echo $data->id; ?>);' class='producto articulo' id='prod<?php echo $data->id; ?>'> 	
	 			<input id='idprod' value='".$data->id."' type='hidden' >
	 			<a class='detalle_producto' 
	 				href='#' 
	 				onclick='event.preventDefault(); detalle_producto(<?php echo $json_detalle_producto; ?>)'>
					<?php 
					echo CHtml::image(str_replace(".","_thumb.",$ima->getUrl()), "Personaling - ".addslashes($data->nombre),
								 array("class"=>"img_hover bg_color3",
								 	"width" => "270", 
								 	"height" => "270",
								 	'id'=>'img-'.$data->id
								 )); 
					if(isset($segunda))
						echo CHtml::image(str_replace(".","_thumb.",$segunda->getUrl()), "Personaling - ".addslashes($data->nombre), 
									array("class"=>"img_hover_out bg_color3",
										"style"=>"display:none",
										"width" => "270",
										"height" => "270"
									));
					echo CHtml::link("Vista Rápida",
								    $this->createUrl('modal',array('id'=>$data->id)),
								    array(// for htmlOptions
								      'onclick'=>' '.CHtml::ajax( array(
								      'url'=>CController::createUrl('quickview',array('id'=>$data->id)),
								           'success'=>"js:function(data){ $('#myModal').html(data);
													$('#myModal').modal(); }")).
								         'return false;',
								    'class'=>'btn btn-block btn-small vista_rapida hidden-phone',
								    'id'=>'prodencanta')
								);
					if($data->mymarca->is_100chic):
					?>
						<span class='btn-block is_080'><img src='<?php echo Yii::app()->baseUrl; ?>/images/080_270x34.jpg'/></span>
					<?php endif; ?>
				</a>
				<header>
					<h3>
						<a class='link_producto detalle_producto' href='#' title='<?php echo $data->nombre; ?>' onclick='event.preventDefault(); detalle_producto(<?php echo $json_detalle_producto; ?>)'><?php echo $data->nombre; ?></a>
					</h3>
					<a href='#' class='ver_detalle icon_lupa detalle_producto' title='Ver detalle' onclick='event.preventDefault(); detalle_producto(<?php echo $json_detalle_producto; ?>)'></a>
				</header>
				<?php if(!is_null($tienda)): ?>
					<span class='precio' style='display:inline'><?php echo Yii::t('contentForm', 'currSym')." ".$data->getPrecioImpuesto(); ?></span>&nbsp;&nbsp;&nbsp;
					<span>
						<a class='detalle_producto' href='#' style='color:#3286A5; cursor:pointer' onclick='event.preventDefault(); detalle_producto(<?php echo $json_detalle_producto; ?>)'><?php echo $data->mymarca->nombre; //echo Marca::model()->findByPk($data->marca_id)->nombre; ?></a>
					</span>
				<?php elseif (!is_null($precio_producto->tipoDescuento) && $precio_producto->valorTipo > 0 && $precio_producto):	?>
					<span class='preciostrike strikethrough'><small><?php echo Yii::t('contentForm', 'currSym')." ".$data->getPrecioImpuesto(); ?></small></span> | <?php echo Yii::t('contentForm', 'currSym')." ".$data->getPrecioDescuento(); ?>					
				<?php else: ?>
					<span class='precio'><?php echo Yii::t('contentForm', 'currSym')." ".$data->getPrecioImpuesto(); ?></span>
				<?php endif; ?>	
				<?php echo "{$iconoDescuento}"; ?>
				<?php if(!Yii::app()->user->isGuest): ?> 
					<a id='like".$data->id."' onclick='encantar(<?php echo $data->id; ?>)' style='cursor:pointer' title='Me encanta' class='entypo like icon_personaling_big <?php echo isset($like)?"like-active":"";?>'><?php echo isset($like)?"&hearts;":"&#9825;";?></a>	 
				<?php endif; ?>	
			</div>
		</article>
	<?php $con=$id; ?>
	<?php endif; ?>

	<?php			
        /*        
		if(isset($ima)){
			

				$like = UserEncantan::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'producto_id'=>$data->id));
            	
            	if(isset($like)) // le ha dado like
				{
					$encabezado="<article class='span3'><div onmouseover='javascript:over(".$data->id.");' onmouseout='javascript:out(".$data->id.");' class='producto articulo' id='prod".$data->id."'> ";
					$gusta="{$iconoDescuento}<a id='like".$data->id."' onclick='encantar(".$data->id.")' style='cursor:pointer' title='Me encanta' class='entypo like icon_personaling_big like-active'>&hearts;
                                            </a></div></article>";
				}
				else{
					$encabezado="<article class='span3'><div  onmouseover='javascript:over(".$data->id.");' onmouseout='javascript:out(".$data->id.");' class='producto articulo' id='prod".$data->id."'>";
					$gusta="{$iconoDescuento}<a id='like".$data->id."' onclick='encantar(".$data->id.")' style='cursor:pointer' title='Me encanta' class='entypo like icon_personaling_big'>&#9825;
                                            </a></div></article>";
				}
				if(Yii::app()->user->isGuest){
					$gusta="{$iconoDescuento}</div></article>";
				}
					$a = CHtml::image(str_replace(".","_thumb.",$ima->getUrl()), "Personaling - ".addslashes($data->nombre), array("class"=>"img_hover bg_color3","width" => "270", "height" => "270",'id'=>'img-'.$data->id));
					$b = '';
					$style='';
					if($data->mymarca->is_100chic){
						$style="<span class='btn-block is_080'><img src='".Yii::app()->baseUrl."/images/080_270x34.jpg'/></span> ";
					}
					if(isset($segunda))
						$b = CHtml::image(str_replace(".","_thumb.",$segunda->getUrl()), "Personaling - ".addslashes($data->nombre), array("class"=>"img_hover_out bg_color3","style"=>"display:none","width" => "270", "height" => "270"));

					//reviso si tiene descuento para mostrarlo
						
						$precio = "<span class='precio'>".Yii::t('contentForm', 'currSym')." ".$data->getPrecioImpuesto()."</span>";
						if($precio_producto){
							if(!is_null($precio_producto->tipoDescuento) && $precio_producto->valorTipo > 0){
								$precio_mostrar = $precio_producto->precioImpuesto;
								$precio = "<span class='preciostrike strikethrough'><small>".Yii::t('contentForm', 'currSym')." ".$data->getPrecioImpuesto()."</small></span> | ".Yii::t('contentForm', 'currSym')." ".$data->getPrecioDescuento();
							}
						}
						if(!is_null($tienda))
							$precio = "<span class='precio' style='display:inline'>".Yii::t('contentForm', 'currSym')." ".$data->getPrecioImpuesto()."</span>&nbsp;&nbsp;&nbsp;<span><a class='detalle_producto' href='' style='color:#3286A5; cursor:pointer' onclick='event.preventDefault(); detalle_producto(".json_encode(array(
																												    		'id' => $data->id,
																												    		'name' => addslashes ($data->nombre),
																												    		'category' => addslashes ($category->nombre),
																												    		'brand' => addslashes ($data->mymarca->nombre),
																												    		'list' => 'Product clicks',
																												    		'position' => $cont,
																												    		'url' => $data->getUrl()
																												    	)).")'> ".Marca::model()->findByPk($data->marca_id)->nombre."</a></span>";
							

						echo($encabezado."
						<input id='idprod' value='".$data->id."' type='hidden' ><a class='detalle_producto' href='' onclick='event.preventDefault(); detalle_producto(".json_encode(array(
																												    		'id' => $data->id,
																												    		'name' => addslashes ($data->nombre),
																												    		'category' => addslashes ($category->nombre),
																												    		'brand' => addslashes ($data->mymarca->nombre),
																												    		'list' => 'Product clicks',
																												    		'position' => $cont,
																												    		'url' => $data->getUrl()
																												    	)).")'>
						".$a.$b.
						CHtml::link("Vista Rápida",
						    $this->createUrl('modal',array('id'=>$data->id)),
						    array(// for htmlOptions
						      'onclick'=>' '.CHtml::ajax( array(
						      'url'=>CController::createUrl('quickview',array('id'=>$data->id)),
						           'success'=>"js:function(data){ $('#myModal').html(data);
											$('#myModal').modal(); }")).
						         'return false;',
						    'class'=>'btn btn-block btn-small vista_rapida hidden-phone',
						    'id'=>'prodencanta')
						).$style."		 
												
						</a>
						<header><h3><a class='link_producto detalle_producto' href='' title='".$data->nombre."' onclick='event.preventDefault(); detalle_producto(".json_encode(array(
																												    		'id' => $data->id,
																												    		'name' => addslashes ($data->nombre),
																												    		'category' => addslashes ($category->nombre),
																												    		'brand' => addslashes ($data->mymarca->nombre),
																												    		'list' => 'Product clicks',
																												    		'position' => $cont,
																												    		'url' => $data->getUrl()
																												    	)).")'>".$data->nombre."</a></h3>
						<a href='' class='ver_detalle icon_lupa detalle_producto' title='Ver detalle' onclick='event.preventDefault(); detalle_producto(".json_encode(array(
																												    		'id' => $data->id,
																												    		'name' => addslashes ($data->nombre),
																												    		'category' => addslashes ($category->nombre),
																												    		'brand' => addslashes ($data->mymarca->nombre),
																												    		'list' => 'Product clicks',
																												    		'position' => $cont,
																												    		'url' => $data->getUrl()
																												    	)).")'></a></header>
						".$precio.$gusta);
						
						
						$con=$id;
					
				

		
		}*/

?>
</div>

<?php
$cont++;

endforeach;?>
<?php
//echo "LORE";
//PC::debug('Pages: '.print_r($pages), 'scroll');
$this->widget('ext.yiinfinite-scroll.YiinfiniteScroller', array(
    'contentSelector' => '#catalogo',
    'itemSelector' => 'div.div_productos',
    'loadingText' => 'Consultando Productos',
    'donetext' => 'No more',

    //'afterAjaxUpdate' => 'alert("hola");',
    'pages' => $pages,
));



?>
</div>
<script>	

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


function detalle_producto(product){
	ga('ec:addProduct', {
	    'id': product.id,
	    'name': product.name,
	    'category': product.category,
	    'brand': product.brand,
	    'position': product.position
	});
	ga('ec:setAction', 'click', {list: 'Product impression'});

	  // Send click with an event, then send user to product page.
	ga('send', 'event', 'UX', 'click', 'Results', {
	      'hitCallback': function() {
	      	//console.log('redirect');
	        //document.location = product.url;
	      }
	});
	document.location = product.url;
}
	

</script>



