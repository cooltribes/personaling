<?php 

		echo"<tr> 

			      <td>".$data['Marca']."</td>
                    <td>".$data['Nombre']."</td>
                    <td>".$data['SKU']."</td>
                    <td>".$data['Color']."</td>
                    <td>".$data['Talla']."</td>
                    <td>".$data['Cantidad']."</td>
                    <td>".Yii::app()->numberFormatter->formatCurrency($data['Costo'], '')."</td>";
                   if($data['look'] == 0)
                    	echo "<td>".Yii::app()->numberFormatter->formatCurrency(($data['Precio']/1.12), '')."</td><td>".Yii::app()->numberFormatter->formatCurrency($data['Precio'], '')."</td></tr>";
				   else
               			echo "<td>".Yii::app()->numberFormatter->formatCurrency($data['pVenta'], '')."</td><td>".Yii::app()->numberFormatter->formatCurrency($data['pIVA'], '')."</td></tr>";

?>