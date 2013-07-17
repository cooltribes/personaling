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
		if($data->pago->tipo==1)
			echo "Depósito / Transferencia"; // metodo de pago
		if($data->pago->tipo==4)
			echo "MercadoPago"; 
		?>
	</td>
	<td>
		<?php
		echo CHtml::link('<i class="icon-eye-open"></i>', Yii::app()->baseUrl.'/orden/detalles/'.$data->id, array('title'=>'Ver'));
		?>
	</td>
</tr>