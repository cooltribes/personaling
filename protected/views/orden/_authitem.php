<?php 
foreach($data->ohptc as $reg){
	echo"<tr> 

			      <td>".$reg->preciotallacolor->producto->mymarca->nombre."</th>
                    <td>".$reg->preciotallacolor->producto->nombre."</td>
                    <td>".$reg->preciotallacolor->sku."</td>
                    <td>".$reg->preciotallacolor->mycolor->valor."</td>
                    <td>".$reg->preciotallacolor->mytalla->valor."</td>
                    <td>".$reg->cantidad."</td>
                    <td></td>
                    <td>Precio sin IVA</td>
                    <td>Precio con IVA</td>
                </tr>";
				print_r($reg->preciotallacolor->producto->precios->costo);
	}





	?>