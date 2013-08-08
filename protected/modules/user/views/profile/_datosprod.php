
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
						    'url'=>CController::createUrl('modal',array('id'=>$data['id'])),
						    	'success'=>"js:function(data){ $('#myModal').html(data);
											$('#myModal').modal(); }")).
						         'return false;}',
						    'class'=>'btn btn-block btn-small vista_rapida hidden-phone',
						    'id'=>'prodencanta')
						)."		
												
				</a>
				<header><h3><a href='".Yii::app()->baseUrl."/producto/detalle/".$data['id']."' title='".$data['nombre']."'>".$data['nombre']."</a></h3>
				<a href='".Yii::app()->baseUrl."/producto/detalle/".$data['id']."' class='ver_detalle entypo icon_personaling_big' title='Ver detalle'>&#128269;</a></header>
				<span class='precio'>Bs. ".$prePub."</span>
				<a id='like".$data['id']."' onclick='encantar(".$data['id'].")' style='cursor:pointer' title='Me encanta' class='entypo like icon_personaling_big like-active'>&hearts;</a></div></article></td>");


?>    
      <!--    
            <div class="producto"> <img width="270" height="270" alt="Imagen" src="http://personaling.com/site/images/producto/1/87.jpg" id="img-1" class="img_hover">
            	<img width="270" height="270" alt="Imagen " src="http://personaling.com/site/images/producto/1/88.jpg" style="display:none" class="img_hover_out"> 
            	<a data-toggle="modal" class="btn btn-block btn-small vista_rapida hidden-phone" role="button" href="#myModal">Vista RÃ¡pida</a>
              <header>
                <h3><a title="Blusa Roja " href="../producto/detalle/1">Blusa Roja </a></h3>
                <a title="Ver detalle" class="ver_detalle entypo icon_personaling_big" href="../producto/detalle/1">&#128269;</a></header>
              <span class="precio">Bs. 200</span> <a class="entypo like icon_personaling_big" title="Me encanta" style="cursor:pointer" onclick="encantar(1)" id="like1">&hearts;</a></div>
          </article>
          -->
