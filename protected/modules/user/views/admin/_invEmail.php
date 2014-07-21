<tr>
	<td><?php echo $data->email_invitado; ?></td>
	<td><?php echo "<strong>".date("d/m/Y",strtotime($data->fecha))."    </strong>".date("H:i:s",strtotime($data->fecha))?></td>
	<td><?php echo $data->registrado['status']?></td>
	<td><?php echo $data->registrado['fecha']?></td>
	

</tr>