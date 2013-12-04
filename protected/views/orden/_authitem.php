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
                    <td>".Yii::app()->numberFormatter->formatCurrency(($data['Precio']+($data['Precio']*0.12)), '')."</td>
                    <td>".date("d/m/Y",strtotime($data['Fecha']))."</td></tr>";

?>