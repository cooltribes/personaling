<?php

$ima ='';

echo"<tr>";
	$fora=$data->image;
	$formato= explode(".",$fora);
	//if($formato[1]=="jpg")
	
   	$ruta=Yii::app(true)->baseUrl.'/images/'.Yii::app()->language.'/bug/'.$data->id.".".$formato[1];
	$peque=Yii::app(true)->baseUrl.'/images/'.Yii::app()->language.'/bug/'.$data->id."_thumb.".$formato[1];
	//$ima = CHtml::image(Yii::app(true)->baseUrl.'/images/'.Yii::app()->language.'/bug/'.$data->id.".jpg", $data->name);
	if(isset($ima))
	echo "<td><a href='".$ruta."' target='_blank' > <img src='".$peque."' title='Haz Click encima para ver Imagen con detalle'/></a></td>";
	else
		echo '<td><img src="http://placehold.it/100" align="Nombre de la marca"/> </td>';
	
   	echo "<td>".$data->name."</td>";
	echo "<td>".$data->description."</td>";
	echo "<td>".$data->url."</td>";
	if($data->estado==1)
	{
		echo "<td>No solucionado</td>";
	}
	else 
	{
		if($data->estado==0)
		{
			echo "<td>solucionado</td>";
		}
		
	}
	
	
	
	echo "<td>".$data->date."</td>";
	echo "<td> detalles</td>";
	/*echo "<td>".$data->title."</td>";
	echo "<td>".$data->description."</td>";
	echo "<td>".$data->keywords."</td>";
	echo "<td>".$data->url."</td>";
	
	echo '<td>
		<a href="create/'.$data->id.'" class="btn btn-mini" ><i class="icon-cog"></i></a>
		<a href="delete/'.$data->id.'" class="btn btn-mini" ><i class="icon-trash"></i></a>
	</td>';*/
	
echo"</tr>";

?>