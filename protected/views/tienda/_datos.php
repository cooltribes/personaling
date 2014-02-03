
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


foreach($prods as $data): ?>
	<div class="div_productos">
	<?php
	
$id=0;
$entro=0;
$con=0;
$prePub="";
$a='';
$b='';
	
	$ims = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$data->id),array('order'=>'orden asc'));

	/*if(isset(Yii::app()->session['f_color'])){
					
		if(Yii::app()->session['f_color']!=0){
			
			$ims = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$data->id,'color_id'=>$Yii::app()->session['f_color']),array('order'=>'orden asc'));
						
		}
						
	}*/
	
	$ima=$ims[0];
	if(isset($ims[1]))
		$segunda=$ims[1];
	else
		$segunda=$ims[0];


	

	   	if($data->precios){
	   	foreach ($data->precios as $precio) {
	   		$prePub = Yii::app()->numberFormatter->format("###0.00",$precio->precioImpuesto);
	   		//$prePub = Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento);
			}
		}
		
		echo ' <input id="productos" value="'.$data->id.'" name="ids" class="ids" type="hidden" >';
		if(isset($ima)){
			
			if($prePub!="")
			{
				//echo"<tr>";
				$like = UserEncantan::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'producto_id'=>$data->id));
            	
            	if(isset($like)) // le ha dado like
				{
					$encabezado="<td><article class='span3'><div class='articulo producto'> ";
					$gusta="<a id='like".$data->id."' onclick='encantar(".$data->id.")' style='cursor:pointer' title='Me encanta' class='entypo like icon_personaling_big like-active'>&hearts;</a></div></article></td>";
				}
				else{
					$encabezado="<article class='span3'><div  onmouseover='javascript:over(".$data->id.");' onmouseout='javascript:out(".$data->id.");' class='producto articulo' id='prod".$data->id."'>";
					$gusta="<a id='like".$data->id."' onclick='encantar(".$data->id.")' style='cursor:pointer' title='Me encanta' class='entypo like icon_personaling_big'>&#9825;</a></div></article>";
				}
				
					$a = CHtml::image(str_replace(".","_thumb.",$ima->getUrl()), "Imagen ", array("class"=>"img_hover","width" => "270", "height" => "270",'id'=>'img-'.$data->id));
					$b = '';
					$style='';
					if($data->mymarca->is_100chic){
						$style="<span class=' btn btn-block is_100chic'> <span>100% Chic</span> </span> ";
					}
					if(isset($segunda))
						//echo "<input id='img2-".$data->id."' value='".$segunda->getUrl()."' type='hidden' >";
						//$b = CHtml::image($segunda->ge     tUrl(), "Segunda ", array("width" => "270", "height" => "270",'display'=>'none','id'=>'img2-'.$data->id));
						$b = CHtml::image(str_replace(".","_thumb.",$segunda->getUrl()), "Imagen ", array("class"=>"img_hover_out","style"=>"display:none","width" => "270", "height" => "270"));
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
						<header><h3><a href='".$data->getUrl()."' title='".$data->nombre."'>".$data->nombre."</a></h3>
						<a href='".$data->getUrl()."' class='ver_detalle icon_lupa' title='Ver detalle'></a></header>
						<span class='precio'>".Yii::t('contentForm', 'currSym')." ".$prePub."</span>".$gusta);
						
						
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
			}
		
		}

?>
</div>

<?php

endforeach;?>
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
	

</script>

<?php 
//echo "LORE"; 
$this->widget('ext.yiinfinite-scroll.YiinfiniteScroller', array(
	    'contentSelector' => '#catalogo',
	    'itemSelector' => 'div.div_productos',
	    'loadingText' => 'Consultando Productos',
	    'donetext' => 'No more',

	  //  'afterAjaxUpdate' => 'alert("hola");',
	    'pages' => $pages,
	)); 
			


?>

