<?php

$id=0;
$entro=0;
$con=0;
$prePub="";

	$ima = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$data->id,'orden'=>'1'));
	
	// limitando a que se muestren los status 1 y estado 0
	
	   	if($data->precios){
	   	foreach ($data->precios as $precio) {
	   		$prePub = Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento);
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
					$a = CHtml::image($ima->getUrl(), "Imagen ", array("width" => "270", "height" => "270",'class'=>''));
				
						echo("<td><a href='../producto/detalle/".$data->id."' title='".$data->nombre."'><article class='span3'> ".$a." <h3>".$data->nombre."</h3>
						<a href='../producto/detalle/".$data->id."' class='ver_detalle entypo icon_personaling_big' title='Ver detalle'>&#128269;</a>
						<span class='precio'>Bs. ".$prePub."</span><br/>
						<a id='like".$data->id."' onclick='encantar(".$data->id.")' style='cursor:pointer' title='Me encanta' class='entypo like icon_personaling_big like-active'>&hearts;</a></article></a></td>");
						
						$con=$id;
						$entro=1;
					
				}
				else
				{
					
					$a = CHtml::image($ima->getUrl(), "Imagen ", array("width" => "270", "height" => "270",'class'=>''));
					
					echo("<a href='../producto/detalle/".$data->id."' title='".$data->nombre."'><article class='span3'> ".$a." <h3>".$data->nombre."</h3>
					<a href='../producto/detalle/".$data->id."' class='ver_detalle entypo icon_personaling_big' title='Ver detalle'>&#128269;</a>
					<span class='precio'>Bs. ".$prePub."</span><br/>
					<a id='like".$data->id."' onclick='encantar(".$data->id.")' style='cursor:pointer' title='Me encanta' class='entypo like icon_personaling_big'>&#9825;</a></article></a>");
					
					$con=$id;
						
				}
				
				//echo("</tr>");
			}
		
		}




?>
<script>

function encantar(id)
   	{
   		var idProd = id;
   		//alert("id:"+idProd);		
   		
   		$.ajax({
	        type: "post",
	        url: "../producto/encantar", // action Tallas de Producto
	        data: { 'idProd':idProd}, 
	        success: function (data) {
				
				if(data=="ok")
				{					
					var a = "♥";
					
					//$("#meEncanta").removeClass("btn-link");
					$("a#like"+id).addClass("like-active");
					$("a#like"+id).text(a);
					
				}
				
				if(data=="no")
				{
					alert("Debes ingresar con tu cuenta de usuario o registrarte antes de dar Me Encanta a un producto");
					//window.location="../../user/login";
				}
				
				if(data=="borrado")
				{
					var a = "♡";
					
					//alert("borrando");
					
					$("a#like"+id).removeClass("like-active");
					//$("#meEncanta").addClass("btn-link-active");
					$("a#like"+id).text(a);

				}
					
	       	}//success
	       })
   		
   		
   	}
   	
</script>