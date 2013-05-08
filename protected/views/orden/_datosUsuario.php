<?php
	echo"<tr>";
	   	echo "<td>".$data->id."</td>"; // id
	   	
	   	if($data->fecha!="")
	   		echo "<td>".date("d-m-Y",strtotime($data->fecha))."</td>";
		else
			echo "<td></td>";
		
		echo "<td>".Yii::app()->numberFormatter->formatDecimal($data->total)."</td>"; // precio
		
		//----------------------Estado
		if($data->estado == 1)
			echo "<td>En espera de pago</td>"; 
		
		if($data->estado == 2)
			echo "<td>En espera de confirmación</td>"; 
		
		if($data->estado == 3)
			echo "<td>Pago Confirmado</td>";
		
		if($data->estado == 6)
			echo "<td>Pago Rechazado</td>"; 
		
		// agregar demas estados
		
		echo "<td>
      		<div class='dropdown'><a class='dropdown-toggle btn' id='dLabel' role='button' data-toggle='dropdown' data-target='#' href='/page.html'>
      		<i class='icon-cog'></i></a> 
          	<!-- Link or button to toggle dropdown -->
          	<ul class='dropdown-menu' role='menu' aria-labelledby='dLabel'>";
			
            //	<li><a href='#myModal".$data->id."' role='button' data-toggle='modal' tabindex='-1'><i class='icon-edit'></i> Registrar pago</a></li>
            echo "<li>";

            echo CHtml::link("<i class='icon-edit'></i> Registrar Pago ",
			    $this->createUrl('orden/modals',array('id'=>$data->detalle_id)),
			    array(// for htmlOptions
			      'onclick'=>' {'.CHtml::ajax( array(
			      'url'=>CController::createUrl('orden/modals',array('id'=>$data->detalle_id)),
			           'success'=>"js:function(data){ $('#myModal').html(data);
								$('#myModal').modal(); }")).
			         'return false;}',
			   // 'class'=>'delete-icon',
			    'id'=>'link'.$data->id)
			);		
			
			echo "</li>";
			            
            echo "<li><a tabindex='-1' href='detallepedido/".$data->id."'><i class='icon-eye-open'></i> Ver detalles</a></li>
            	<li class='divider'></li>
            	<li><a tabindex='-1' href='#'><i class='icon-ban-circle'></i> Cancelar Orden</a></li>
          	</ul>
        	</div></td>	
			";
			
	echo("</tr>");		

?>