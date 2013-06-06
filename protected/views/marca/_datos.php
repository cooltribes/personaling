<?php

$ima ='';

echo"<tr>";

	$ima = CHtml::image(Yii::app()->baseUrl.'/images/marca/'.$data->id.'_thumb.jpg', $data->nombre);

	if(isset($ima))
   		echo "<td>".$ima."</td>";
	else
		echo '<td><img src="http://placehold.it/100" align="Nombre de la marca"/> </td>';
   	
   	echo "<td>".$data->nombre."</td>";
	echo "<td>".$data->descripcion."</td>";
	
	echo '<td><a href="crear/'.$data->id.'" class="btn btn-mini" ><i class="icon-cog"></i></a></td>';
	
echo"</tr>";

?>