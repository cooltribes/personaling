<?php
	$es="";
   	$r="";
	$cats="";
	
echo"<tr>";
   	echo "<td>".CHtml::image(Yii::app()->baseUrl.'/images/'.$data->path_image, $data->nombre, array('width'=>100))."</td>";
   	echo "<td>".$data->nombre."</td>";
	
echo "<td>";
echo CHtml::link("<i class='icon-edit'></i>",
    $this->createUrl('adorno/detalles',array('id'=>$data->id)),
    array(// for htmlOptions
      'onclick'=>' {'.CHtml::ajax( array(
      'url'=>CController::createUrl('adorno/detalles',array('id'=>$data->id)),
          // 'beforeSend'=>'js:function(){if(confirm("Are you sure you want to delete?"))return true;else return false;}',
           'success'=>"js:function(data){ $('#myModal').html(data);
					$('#myModal').modal(); }")).
         'return false;}',// returning false prevents the default navigation to another url on a new page 
   // 'class'=>'delete-icon',
    'id'=>'link'.$data->id,
	'role'=>'button',
	'class'=>'btn')
);		

	echo "</td>";
  // 	echo "<td><a href='#myModal' role='button' class='btn btn-mini' data-toggle='modal'><i class='icon-eye-open'></i></a></td>";
	
echo"</tr>";


?>