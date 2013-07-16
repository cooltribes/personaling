<?php

$id=0;
$entro=0;
$con=0;
$prePub="";

	$producto = Producto::model()->findByAttributes(array('id'=>$data->producto_id));

	$ima = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'orden'=>'1'));
	
	
	foreach ($producto->precios as $precio) {
		$prePub = Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento);
	}
	
	
		$a = CHtml::image(Yii::app()->baseUrl . $ima->url, "Imagen ", array("width" => "270", "height" => "270",'class'=>''));
				
		echo("<td>
		
		<article class='span3'>
			<div class='producto'> 
		
		".$a." <a href='#myModal' role='button' class='btn  btn-block btn-small vista_rapida  hidden-phone' data-toggle='modal'>Vista Rápida</a><header><h3>
		<a href='../producto/detalle/".$producto->id."' title='".$producto->nombre."'>".$producto->nombre."</a></h3>
		<a href='../producto/detalle/".$producto->id."' class='ver_detalle entypo icon_personaling_big' title='Ver detalle de ".$producto->nombre."'>&#128269;</a></header>
		<span class='precio'>Bs. ".$prePub." </span>
		<a id='like".$producto->id."' onclick='encantar(".$producto->id.")' style='cursor:pointer' title='Me encanta' class='entypo like icon_personaling_big like-active'>&hearts;</a></div></article></td>");
		/*
		echo("<td><a href='../producto/detalle/".$data->id."' title='".$data->nombre."'><article class='span3'> ".$a." <h3>".$data->nombre."</h3>
		<a href='../producto/detalle/".$data->id."' class='ver_detalle entypo icon_personaling_big' title='Ver detalle'>&#128269;</a>
		<span class='precio'>Bs. ".$prePub."</span><br/>
		<a id='like".$data->id."' onclick='encantar(".$data->id.")' style='cursor:pointer' title='Me encanta' class='entypo like icon_personaling_big like-active'>&hearts;</a></article></a></td>");
						
		$con=$id;
*/
?>
