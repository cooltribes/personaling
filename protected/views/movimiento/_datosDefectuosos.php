<?php 	 	
    echo"<tr>  
    <td><b>".$data['SKU'].'</b><br/>'.$data['Referencia']."</td>

    <td>".$data['Marca']."</td>
    <td>".$data['Nombre']."</td>

    
    <td>".$data['Color']."</td>
    <td>".$data['Talla']."</td>
    <td>".Yii::app()->numberFormatter->formatCurrency($data['Costo'], '')."</td>
    <td>".$data['Cantidad']."</td>
    <td>".$data['Usuario']."</td>
    <td>".date('d/m/Y',strtotime($data['Fecha']))."</td>
    <td>".$data['Procedencia']."</td>
  </tr>";

?>