<?php

$ima ='';
if($data->type)
	$tipo="<br/><br/><small><b>Tienda Multimarca</b></small>";
else
	$tipo="<br/><br/><small><b>Tienda Monomarca</b></small>";
echo"<tr>"; 

	$ima = CHtml::image(Yii::app()->baseUrl.'/images/tienda/'.$data->id.'_thumb.jpg', $data->name);

	if(isset($ima))
   		echo "<td>".$ima."</td>";
	else
		echo '<td><img src="http://placehold.it/100" align="Nombre de la marca"/> </td>';
   	
   	echo "<td>".$data->name.$tipo."</td>";
	echo "<td>".$data->description."</td>";
	
	echo '<td><a href="create/'.$data->id.'" class="btn btn-mini" ><i class="icon-cog"></i></a></td>';
	
echo"</tr>";

?>