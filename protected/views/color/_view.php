<?php

$ima ='';

echo"<tr>";

	$ima = CHtml::image(Yii::app()->baseUrl.'/images/colores/'.$data->path_image, $data->valor, array('width'=>50, 'style'=>'border-style: solid; border-width: 1px; border-color: #666'));

	if(isset($ima))
   		echo "<td>".$ima."</td>";
	else
		echo '<td><img src="http://placehold.it/100" align="Nombre de la marca"/> </td>';
   	
   	if($data->padreID == 0){
   		echo "<td>No tiene</td>";
   	}else{
   		$padre = Color::model()->findByPk($data->padreID);
   		if($padre){
   			echo "<td>".$padre->valor."</td>";
   		}else{
   			echo "<td>No tiene</td>";
   		}
   	}
   	echo "<td>".$data->valor."</td>";
	echo "<td>".$data->title."</td>";
	echo "<td>".$data->description."</td>";
	echo "<td>".$data->keywords."</td>";
	echo "<td>".$data->url."</td>";
	
	echo '<td>
		<a href="create/'.$data->id.'" class="btn btn-mini" ><i class="icon-cog"></i></a>
		<a href="delete/'.$data->id.'" class="btn btn-mini" ><i class="icon-trash"></i></a>
	</td>';
	
echo"</tr>";

?>