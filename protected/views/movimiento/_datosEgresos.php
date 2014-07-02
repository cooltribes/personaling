<?php 
 
    echo"<tr> 
    <td>".$data->id."</td> 
    <td>".$data->user->username."</td> 
    <td>".date("d/m/Y",strtotime($data->fecha))."</td> 
	<td>".count($data->mptcs)."</td>
	<td>".$data->getEgresados($data->id)."</td>
	<td>".$data->motivo."</td>
	<td>".$data->comentario."</td>
	
      <td align='center'><a href='".Yii::app()->getBaseUrl()."/movimiento/detallesEgreso/".$data->id."' title='Ver detalles'><i class='icon-eye-open'></i> </a></td> 
   </tr>";


?>