<?php 

		echo"<tr> 

			      <td>".$data['Marca']."</td>
                    <td>".$data['Nombre']."</td>
                    <td>".$data['SKU']."</td>
                    <td>".$data['Color']."</td>
                    <td>".$data['Talla']."</td>
                    <td>".$data['Cantidad']."</td>
                    <td>".$data['Costo']."</td>";
                   if($data['look'] == 0)
                    	echo "<td>".($data['Precio']/1.12)."</td><td>".$data['Precio']."</td></tr>";
				   else
               			echo "<td>".$data['pVenta']."</td><td>".$data['pIVA']."</td></tr>";

?>