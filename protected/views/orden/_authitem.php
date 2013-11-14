<?php 
foreach($data->ohptc as $reg){
	if($reg->cantidad>0){
	echo"<tr> 

			      <td>".$reg->preciotallacolor->producto->mymarca->nombre."</th>
                    <td>".$reg->preciotallacolor->producto->nombre."</td>
                    <td>".$reg->preciotallacolor->sku."</td>
                    <td>".$reg->preciotallacolor->mycolor->valor."</td>
                    <td>".$reg->preciotallacolor->mytalla->valor."</td>
                    <td>".$reg->cantidad."</td>
                    <td>".$reg->preciotallacolor->producto->precios[0]->costo."</td>";
                   if($reg->look_id == 0)
                    	echo "<td>".($reg->precio/1.12)."</td><td>".$reg->precio."</td></tr>";
				   else
               			echo "<td>".$reg->preciotallacolor->producto->precios[0]->precioVenta."</td><td>".$reg->preciotallacolor->producto->precios[0]->precioImpuesto."</td></tr>";
			
	} }





	?>