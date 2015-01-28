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
	
	$modelado=BugReporte::model()->findAllBySql('select * from tbl_bugReporte where bug_id='.$data->id.' order by fecha desc limit 1'); //ultimo registro

	foreach($modelado as $mode) //hace un solo recorrido
	{
			echo "<td>".$mode->descripcion."</td>";	
			echo "<td>".$data->url."</td>";
			echo "<td>".$mode->getEstados($mode->estado)."</td>";
			echo "<td>".$mode->fecha."</td>";
			
	}

	$todo=CHtml::link('<i class="icon-eye-open">  </i>  Ver Detalles',
                            $this->createUrl("bugReporte/create", array("id" => $data->id)), array(
//                        'data-toggle' => "modal",
//                        'onClick' => "ver({$data->id})",
                    ));   
	echo "<td> ".$todo."</td>";
	
echo"</tr>";

?>