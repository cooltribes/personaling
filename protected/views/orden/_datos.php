<?php
	
	$looks=0;
	$indiv=0;
	
echo"<tr>";
	echo "<td><input name='check' type='checkbox' id='".$data->id."' /></td>";
   	echo "<td>".$data->id."</td>"; // id
	
	$user = User::model()->findByPk($data->user_id);
   	echo "<td>".$user->username."</td>";	 // usuario
	
   //	echo "<td>".$data->fecha."</td>"; // fecha
   	if($data->fecha!="")
   		echo "<td>".date("d-m-Y H:i:s",strtotime($data->fecha))."</td>";
	else
		echo "<td></td>";
	$compra = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$data->id));
	
		foreach ($compra as $tot) {
			
			if($tot->look_id == 0)
			{
				$indiv++;
			}else{
				$looks++;
			}
			
		}
		
	echo "<td><strong>Looks</strong>:     (".$looks.")<br><strong>Prendas</strong>: (".$indiv.")</td>"; // totales en look y indiv
	
	echo "<td>".Yii::app()->numberFormatter->format("#,##0.00",$data->total)."</td>"; // precio
	//echo "<td>".$data->total."</td>"; // monto total
	//--------------------
	$tipoPago = Pago::model()->findByAttributes(array('id'=>$data->pago_id));
	
	if($tipoPago->tipo==1)
		echo "<td>Dep. o Transfer</td>"; // metodo de pago
	if($tipoPago->tipo==2)
		echo "<td>Tarjeta de Credito</td>"; 
	if($tipoPago->tipo==4)
		echo "<td>MercadoPago</td>"; 
	// incluir demas tipos luego
	
	
	//----------------------Estado
	if($data->estado == 1)
		echo "<td>En espera de pago</td>"; 
	
	if($data->estado == 2)
		echo "<td>En espera de confirmación</td>"; 
	
	if($data->estado == 3)
		echo "<td>Pago Confirmado</td>";
		
	if($data->estado == 4)
		echo "<td>Orden Enviada</td>";
	
	if($data->estado == 5)
		echo "<td>Orden Cancelada</td>";
		
	if($data->estado == 7)
		echo "<td>Pago Insuficiente</td>";	
	
	// agregar demas estados
	
	//------------------ acciones
	
	echo "
	<td>
	<div class='dropdown'>
	<a class='dropdown-toggle btn' id='dLabel' role='button' data-toggle='dropdown' data-target='#' href='admin_pedidos_detalles.php'>
	<i class='icon-cog'></i> <b class='caret'></b>
	</a> 
          <!-- Link or button to toggle dropdown -->
          <ul class='dropdown-menu' role='menu' aria-labelledby='dLabel'>
            <li><a tabindex='-1' href='detalles/".$data->id."'><i class='icon-eye-open'></i> Ver detalles</a></li>
            <li><a onclick='modal(".$data->id.")' tabindex='-1' href='#'><i class='icon-th-list'></i> Ver prendas</a></li>
            <li><a tabindex='-1' href='#'><i class='icon-edit'></i> Cambiar estado</a></li>
            <li><a tabindex='-1' href='#'><i class='icon-file'></i> Generar etiqueta de dirección</a></li>
            <li class='divider'></li>
            <li><a tabindex='-1' href='#'><i class='icon-trash'></i> Eliminar</a></li>
          </ul>
        </div></td>
        <div id='myModal' class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
        </div>
	";
		
?>
<script >
function modal(id){

	$.ajax({
		type: "post",
		'url' :'/site/orden/modalventas/'+id,
		data: { 'ord':id}, 
		'success': function(data){
			$('#myModal').html(data);
			$('#myModal').modal(); 
		},
		'cache' :false});


	    
		
		
}
</script>


