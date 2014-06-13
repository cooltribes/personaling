<?php 
 
    echo"<tr> 
    <td>".$data->id."</td> 
    <td>".$data->user->username."</td> 
    <td>".$data->orden_id."</td> 
    <td>".date("d/m/Y H:i:s",strtotime($data->fecha))."</td> 
    <td>".Devolucion::model()->getStatus($data->estado)."</td> 

      <td><div class='dropdown pull-right'>
	<a class='dropdown-toggle btn' id='dLabel' role='button' data-toggle='dropdown' data-target='#' href='admin_pedidos_detalles.php'>
	<i class='icon-cog'></i> <b class='caret'></b>
	</a> 

          <ul class='dropdown-menu' role='menu' aria-labelledby='dLabel'>
            <li><a tabindex='-1' href='".Yii::app()->getBaseUrl()."/orden/detallesDevolucion/".$data->id."'><i class='icon-eye-open'></i> Ver detalles</a></li>
           
            <li><a tabindex='-1' href='#'><i class='icon-trash'></i> Eliminar</a></li>
          </ul>
        </div></td> 
   </tr>";


?>