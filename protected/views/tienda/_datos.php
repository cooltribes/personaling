<?php

echo"<tr>";
$id=0;
$con=0;

	$ima = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$data->id,'orden'=>'1'));
	
	// limitando a que se muestren los status 1 y estado 0
	

		if(isset($ima)){
				$a = CHtml::image(Yii::app()->baseUrl . $ima->url, "Imagen ", array("width" => "270", "height" => "270",'class'=>'img-polaroid'));
				echo("<td><a href='../producto/detalle/".$data->id."' ><article class='span3'> ".$a." <h3>Nombre del producto</h3>
				<a href='#' class='ver_detalle entypo icon_personaling_big'>&#128269;</a>
				<span class='precio'>Bs. 50.000,00</span><br/><a href='#' title='Me encanta' class='entypo like icon_personaling_big'>&#9825;</a></article></a></td>");
				$con=$id;
			}
			else {
					echo "<td><article class='span3'> <img src='http://placehold.it/270'/><h3>Nombre del producto</h3>
					<a href='#' class='ver_detalle entypo icon_personaling_big'>&#128269;</a>
					<span class='precio'><span class='label label-important'>Promoción</span>Bs. 50.000,00</span> <br/><a href='#' title='Me encanta' class='entypo like icon_personaling_big'>&#9825;</a></article></td>";
					$con=$id;
				}
	//}

	/*foreach ($data->imagenes as $ima) {
		
		$id = $data->id;
		
		if($id!=$con)
		{
			
			$ima = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$data->id,'orden'=>'1'));
			if(isset($ima)){
				$a = CHtml::image(Yii::app()->baseUrl . $ima->url, "Imagen ", array("width" => "270", "height" => "320",'class'=>'img-polaroid'));
				echo("<td> <article class='span3'> ".$a."</article> </td>");
				$con=$id;
			}
			else {
				{
					echo "<td><article class='span3'> <img src='http://placehold.it/270x320'/> </article></td>";
					$con=$id;
				}
			}
			
		}
	}*/

echo("</tr>");

?>