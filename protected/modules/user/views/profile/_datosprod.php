
<?php

$prod = Producto::model()->findByPk($data['id']);

	$ima = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$prod->id,'orden'=>'1'));
	$segunda = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$prod->id,'orden'=>'2'));
	
	// limitando a que se muestren los status 1 y estado 0
	
	   	if($prod->precios){
	   	foreach ($prod->precios as $precio) {
	   		$prePub = Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento);
			}
		}

			$like = UserEncantan::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'producto_id'=>$data['id']));

			$a = CHtml::image($ima->getUrl(), "Imagen ", array("class"=>"img_hover","width" => "270", "height" => "270",'id'=>'img-'.$data['id']));
			$b = '';
			
		if(isset($segunda))
			$b = CHtml::image($segunda->getUrl(), "Imagen ", array("class"=>"img_hover_out","style"=>"display:none","width" => "270", "height" => "270"));
			
			echo("<td>
			<article class='span4 item_producto'>
			<div class='producto'> 
				<input id='idprod' value='".$data['id']."' type='hidden' ><a href='".Yii::app()->baseUrl."/producto/detalle/".$data['id']."'>
				".$a.$b." 
						
				".CHtml::link("Vista Rápida",
					$this->createUrl('modal',array('id'=>$data['id'])),
						array(// for htmlOptions
							'onclick'=>' {'.CHtml::ajax( array(
						    'url'=>CController::createUrl('modalshopper',array('id'=>$data['id'])),
						    	'success'=>"js:function(data){ $('#myModal').html(data);
											$('#myModal').modal(); }")).
						         'return false;}',
						    'class'=>'btn btn-block btn-small vista_rapida hidden-phone',
						    'id'=>'prodencanta')
						)."		
												
				</a>
				<header><h3><a href='".Yii::app()->baseUrl."/producto/detalle/".$data['id']."' title='".$data['nombre']."'>".$data['nombre']."</a></h3>
				<a href='".Yii::app()->baseUrl."/producto/detalle/".$data['id']."' class='ver_detalle entypo icon_personaling_big' title='Ver detalle'>&#128269;</a></header>
				<span class='precio'>Bs. ".$prePub."</span>");
				
			if(isset($like)) // le ha dado like	
				echo "<a id='like".$data['id']."' onclick='encantar(".$data['id'].")' style='cursor:pointer' title='Me encanta' class='entypo like icon_personaling_big like-active'>&hearts;</a></div></article></td>";
			else 
				echo "<a id='like".$data['id']."' onclick='encantar(".$data['id'].")' style='cursor:pointer' title='Me encanta' class='entypo like icon_personaling_big like-active'>&#9825;</a></div></article></td>";
				
			

?>    

