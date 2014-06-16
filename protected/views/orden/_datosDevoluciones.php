<?php 
 
    echo"<tr> 
    <td>".$data->id."</td> 
    <td>".$data->user->username."</td> 
    <td>".$data->orden_id."</td> 
    <td>".date("d/m/Y H:i:s",strtotime($data->fecha))."</td> 
    <td>".Devolucion::model()->getStatus($data->estado)."</td> 

      <td align='center'><a href='".Yii::app()->getBaseUrl()."/orden/detallesDevolucion/".$data->id."' title='Ver detalles'><i class='icon-eye-open'></i> </a></td> 
   </tr>";


?>