<?php 

    echo"<tr>  
    <td>".$data['SKU']."</td>
    <td>".$data['Referencia']."</td>
    
    <td>".$data['Marca']."</td>
    <td>".$data['Nombre']."</td>
    
    <td>".$data['Color']."</td>
    <td>".$data['Talla']."</td>
    <td>".$data['Cantidad']."</td>
    <td>".Yii::app()->numberFormatter->formatCurrency($data['Costo'], '')."</td>
    <td>".Yii::app()->numberFormatter->formatCurrency($data['Precio'], '')."</td>
    <td>".Yii::app()->numberFormatter->formatCurrency($data['pIVA'], '')."</td></tr>";

?>