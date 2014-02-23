<tr>
	<td>
		<?php
		echo date('d/m/Y - h:i A', strtotime($data->fecha));
		?>
	</td>
	<td>
		<?php
		echo Yii::app()->numberFormatter->formatDecimal($data->total).' Bs.'; 
		?>
	</td>
	<td>
		<?php
		if($data->estado == 1)
			echo "En espera de pago"; 
	
		if($data->estado == 2)
			echo "En espera de confirmación"; 
		
		if($data->estado == 3)
			echo "Pago Confirmado";
			
		if($data->estado == 4)
			echo "Orden Enviada";
		
		if($data->estado == 5)
			echo "Orden Cancelada";
			
		if($data->estado == 7)
			echo "Pago Insuficiente";
		?>
	</td>
	<td>
		<?php
		if(count($data->detalles)){
                    foreach ($data->detalles as $detallePago){

                    if($detallePago->tipo_pago==1)
                        echo "Dep. o Transfer"; // metodo de pago
                    else if($detallePago->tipo_pago==2)
                            echo "Tarjeta de Crédito"; 
                    else if($detallePago->tipo_pago==3)
                            echo "Uso de Balance"; 
                    else if($detallePago->tipo_pago==4)
                            echo "MercadoPago"; 
                    else
                            echo "-ERROR EN EL PAGO-";
                    echo "</br>";

                }
                }else{
                    echo "Dep. o Transfer"; 
                }
		?>
	</td>
	<td>
		<?php
		echo CHtml::link('<i class="icon-eye-open"></i>', Yii::app()->baseUrl.'/orden/detalles/'.$data->id, array('title'=>'Ver'));
		?>
	</td>
</tr>