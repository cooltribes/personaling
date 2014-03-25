<?php 

    echo"<tr>  
    <td>".$data['Marca']."</td>
    <td>".$data['Nombre']."</td>
    <td>".$data['SKU']."</td>
    <td>".$data['Color']."</td>
    <td>".$data['Talla']."</td>
    <td>".$data['Cantidad']."</td>
    <td>".Yii::app()->numberFormatter->formatCurrency($data['Costo'], '')."</td>
    <td>".Yii::app()->numberFormatter->formatCurrency($data['Precio'], '')."</td>
    <td>".Yii::app()->numberFormatter->formatCurrency(($data['Precio']*1.12), '')."</td></tr>";

?>