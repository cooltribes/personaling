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
	echo "</td>";
	
	//----------------------Estado
	echo "<td>".$data->textestado."</td>";
	// agregar demas estados	
        
	//------------------ acciones
	$canc="";
	if($data->estado == Orden::ESTADO_ESPERA || $data->estado == Orden::ESTADO_CONFIRMADO
            ||$data->estado == Orden::ESTADO_RECHAZADO
            || $data->estado == Orden::ESTADO_INSUFICIENTE){
		//$canc="<li><a onclick='cancelar(".$data->id.")' tabindex='-1' href=''><i class='icon-ban-circle'></i> Cancelar Orden</a></li>";
            
            $canc = "<li>".
                    CHtml::link("<i class='icon-ban-circle'></i> Cancelar Orden",
                        $this->createUrl('orden/cancelar',array('id'=>$data->id)),
                        array(
                        'id'=>'linkCancelar'.$data->id,
                        //'onclick' => "cancelarOrden()",
                         )
                    )            
                    ."</li>";
            
        }
        
        //Si es cancelada, ver motivo
	$motivo = "";
        
	if($data->estado == Orden::ESTADO_CANCELADO){
		//$canc="<li><a onclick='cancelar(".$data->id.")' tabindex='-1' href=''><i class='icon-ban-circle'></i> Cancelar Orden</a></li>";
            $message = Estado::model()->findByAttributes(array(
               "orden_id" => $data->id,
               "estado" => Orden::ESTADO_CANCELADO,
            ), array(
                'order' => 'fecha DESC'
            ));
            
            $message = $message ? $message->observacion : "";            
                        
            $motivo = "<li>".
                        CHtml::link("<i class='icon-comment'></i> Ver motivo de cancelación",
                                        'javascript:verMotivo("'.$message.'")', array(
                                        
                                        )
                                    )            
                     ."</li>";
            
        }
        
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
            ".$canc.
             $motivo."
                    
            
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
    
function verMotivo(mensaje){
    if(mensaje.trim() == ""){
        mensaje = "<i>El usuario no indicó ningun motivo.</i>";
    }

    bootbox.alert("\"" + mensaje + "\".");
}
    
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



</script>


