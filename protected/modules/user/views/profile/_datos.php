<?php

$id=0;
$entro=0;
$con=0;
$prePub="";

	$producto = Producto::model()->findByAttributes(array('id'=>$data->producto_id));

	$ima = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'orden'=>'1'));
	$segunda = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'orden'=>'2'));
	
	foreach ($producto->precios as $precio) {
		$prePub = Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento);
	}
	
	
	$a = CHtml::image(Yii::app()->baseUrl . $ima->url, "Imagen ", array("width" => "270", "height" => "270",'class'=>''));
	$b = CHtml::image($segunda->getUrl(array('type'=>'thumb')), "Imagen ", array("class"=>"img_hover_out","style"=>"display:none","width" => "270", "height" => "270"));
						
			echo("<td><article class='span3'><div class='producto'> 
				<input id='idprod' value='".$producto->id."' type='hidden' ><a href='../../producto/detalle/".$producto->id."'>
				".$a.$b." 
						
				".CHtml::link("Vista Rápida",
					$this->createUrl('modal',array('id'=>$producto->id)),
					array(// for htmlOptions
						'onclick'=>' {'.CHtml::ajax( array(
						'url'=>CController::createUrl('modal',array('id'=>$producto->id)),
						'success'=>"js:function(data){ $('#myModal').html(data);
							$('#myModal').modal(); }")).
						         'return false;}',
						'class'=>'btn btn-block btn-small vista_rapida hidden-phone',
						'id'=>'prodencanta')
				)."		
												
			</a>
			<header><h3><a href='../../producto/detalle/".$producto->id."' title='".$producto->nombre."'>".$producto->nombre."</a></h3>
			<a href='../../producto/detalle/".$producto->id."' class='ver_detalle entypo icon_personaling_big' title='Ver detalle'>&#128269;</a></header>
			<span class='precio'>Bs. ".$prePub."</span>
			<a id='like".$producto->id."' onclick='encantar(".$producto->id.")' style='cursor:pointer' title='Me encanta' class='entypo like icon_personaling_big like-active'>&hearts;</a></div></article></td>");

?>
