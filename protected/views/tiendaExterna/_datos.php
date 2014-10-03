<?php

$ima ='';
if($data->type)
	$tipo="<div style='height:20%; width:100%; float:left; vertical-align:bottom'><small><b>Tienda Multimarca</b></small></div>";
else
	$tipo="<div style='height:20%; width:100%; float:left; vertical-align:bottom'><small><b>Tienda Monomarca</b></small></div>";
echo"<tr>"; 
	$ruta=Yii::app()->baseUrl.'/images/'.Yii::app()->language.'/tienda/'.$data->id.'_thumb.jpg';
	$ima = CHtml::image(Yii::app()->baseUrl.'/images/'.Yii::app()->language.'/tienda/'.$data->id.'_thumb.jpg', $data->name); 

	if(isset($ima)) {
		
		 $tal=getimagesize(Yii::getPathOfAlias('webroot').'/images/'.Yii::app()->language.'/tienda/'.$data->id.'_thumb.jpg'); 
		 $tal=explode('=',str_replace('"','',$tal[3]));
		($tal[2]>25?$tal=$tal[2]-25:$tal=0);
		 echo "<td><img src='".$ruta."?".time()."' /></td>";
		 
	}
	 		
	else {
		echo '<td><img src="http://placehold.it/100" align="'.$data->name.'"/> </td>';
		$tal=80;
		
	}
		
  
   	echo "<td><div style='padding-bottom:".$tal."px; width:100%; float:left; vertical-align:middle'>".$data->name."</div>".$tipo."</td>";
	echo "<td>".$data->description."</td>";
	
	echo '<td><a href="create/'.$data->id.'" class="btn btn-mini" ><i class="icon-cog"></i></a></td>';
	
echo"</tr>";

?>