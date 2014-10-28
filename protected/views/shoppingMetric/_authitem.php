<?php
	$es="";
   	$r="";
	$cats="";
	
echo"<tr>";

	#echo "<td><input name='check' type='checkbox' id='".$data->id."' /></td>";
	$partir=explode(",", $data->data);
	$partir[0]; // tendria algo como {"look_id":"770"
	
	$close=explode(":", $partir[0]);
	$look_id=str_replace('"', '', $close[1]);
	
   	echo "<td>".$look_id."</td>";
   	echo "<td>".$data->data."</td>";
	echo "<td>".$look_id."</td>"; 
	echo "<td>".$data->id."</td>";
	echo "<td>tota</td>"; 
	echo "<td>dispo</td>"; 
	echo "<td>fsdfsdf</td>"; 
   	echo "<td>ventas bs</td>"; 
	echo "<td> Inactivo </td>";   	
	echo "<td>".$data->data."</td>";	
	echo "<td> Sin rango de fechas.</td>";
	echo "<td> Sin rango de fechas.</td>";
	/*echo "<td>";

	 
echo CHtml::link("<i class='icon-eye-open'></i>",
    $this->createUrl('producto/detalles',array('id'=>$data->id)),
    array(// for htmlOptions
      'onclick'=>' {'.CHtml::ajax( array(
      'url'=>CController::createUrl('producto/detalles',array('id'=>$data->id)),
          // 'beforeSend'=>'js:function(){if(confirm("Are you sure you want to delete?"))return true;else return false;}',
           'success'=>"js:function(data){ $('#myModal').html(data);
					$('#myModal').modal(); }")).
         'return false;}',// returning false prevents the default navigation to another url on a new page 
   // 'class'=>'delete-icon',
    'id'=>'link'.$data->id)
);		

	echo "</td>";*/
  // 	echo "<td><a href='#myModal' role='button' class='btn btn-mini' data-toggle='modal'><i class='icon-eye-open'></i></a></td>";
	
echo"</tr>";


?>