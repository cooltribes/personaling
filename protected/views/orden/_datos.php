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
	 $indiv=OrdenHasProductotallacolor::model()->countIndividuales($data->id);
	 $looks=OrdenHasProductotallacolor::model()->countLooks($data->id);
		
	echo "<td><strong>Looks</strong>:     (".$looks.")<br><strong>Prendas</strong>: (".$indiv.")</td>"; // totales en look y indiv
	
	echo "<td>".Yii::app()->numberFormatter->format("#,##0.00",$data->total)."</td>"; // precio
	//echo "<td>".$data->total."</td>"; // monto total
	//--------------------
	echo "<td>";
        
        if(count($data->detalles)){
            foreach ($data->detalles as $detallePago){
            
            if($detallePago->pagos[0]->tipo==1)
		echo "Dep. o Transfer"; // metodo de pago
            if($detallePago->pagos[0]->tipo==2)
                    echo "Tarjeta de Crédito"; 
            if($detallePago->pagos[0]->tipo==3)
                    echo "Uso de Balance"; 
            if($detallePago->pagos[0]->tipo==4)
                    echo "MercadoPago"; 
            
            echo "</br>";
            
        }
        }else{
            echo "Dep. o Transfer"; 
        }
	echo "</td>";
	
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
        
    if($data->estado == 8)
		echo "<td>Entregado</td>";
	
	if($data->estado == 9)
		echo "<td>Orden Devuelta</td>";
		
	if($data->estado == 10)
		echo "<td>Parcialmente Devuelto</td>";
	
	// agregar demas estados
	
	//------------------ acciones
	$canc="";
	if($data->estado==1)
		$canc="<li><a onclick='cancelar(".$data->id.")' tabindex='-1' href=''><i class='icon-ban-circle'></i> Cancelar Orden</a></li>";
	
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
            ".$canc."
            
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
		//'url' :'/site/orden/modalventas/'+id,
		'url' : '<?php echo $this->createUrl('orden/modalventas',array('id'=>$data->id)); ?>',
		data: { 'ord':id}, 
		'success': function(data){
			$('#myModal').html(data);
			$('#myModal').modal(); 
		},
		'cache' :false});	    
		
		
}

function cancelar(id){
	
	$.ajax({
		type: "post",
		//'url' :'/site/orden/modalventas/'+id,
		'url' : '<?php echo $this->createUrl('orden/cancelar'); ?>/'+id,
		data: { 'admin':id}, 
		'success': function(data){
			if(data=='ok'){
			 ajaxUpdateTimeout = setTimeout(function () {
                        $.fn.yiiListView.update(
                        'list-auth-items',
                        {
                        type: 'POST',	
                        url: '<?php echo CController::createUrl('orden/admin')?>',
                        data: ajaxRequest}
                        
                        )
                        },
                
                300);
             } if(data=='no')
             	alert("No se pudo cancelar la orden");
			
		},
		'cache' :false});	    
		
		
}
</script>


