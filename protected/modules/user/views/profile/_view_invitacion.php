<tr>
	<td><?php echo $data->nombre_invitado; ?></td>
	<td><?php echo date('d/m/Y', strtotime($data->fecha)); ?></td>
	<td>
		<?php
		switch($data->estado){
			case 0:
				echo 'Pendiente';
				break;
			case 1:
				echo 'Aceptada';
			default:
				//echo 'Desconocido';
				break;
		}
		?>
	</td>
	<td>
		<?php
		switch ($data->estado) {
			case 0:
				echo '0';
				break;
			case 1:
				echo '+5';
			default:
				//echo '0';
				break;
		}
		?>
	</td>
</tr>