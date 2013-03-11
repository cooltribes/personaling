<?php

echo"<tr>";
$id=0;
$con=0;

	$ima = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$data->id,'orden'=>'1'));
	
		if(isset($ima)){
				$a = CHtml::image(Yii::app()->baseUrl . $ima->url, "Imagen ", array("width" => "270", "height" => "320",'class'=>'img-polaroid'));
				echo("<td> <article class='span3'> ".$a."</article> </td>");
				$con=$id;
			}
			else {
					echo "<td><article class='span3'> <img src='http://placehold.it/270x320'/> </article></td>";
					$con=$id;
				}
	

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