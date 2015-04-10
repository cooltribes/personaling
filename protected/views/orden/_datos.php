<?php
        //si la orden tiene discrepancias, mostrar en rojo el estado de LF
        $claseFila = $data->tieneDiscrepancias()?" class='error'":
                $data->fueCorregido()? " class='success'":"";
	
    echo"<tr{$claseFila}>";
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
		$xlook=OrdenHasProductotallacolor::model()->countPrendasEnLooks($data->id);
		
	echo "<td>".$looks."</td><td>".$indiv."</td><td>".($indiv+$xlook)."</td>"; // totales en look y indiv
	
	echo "<td>".Yii::app()->numberFormatter->format("#,##0.00",$data->total)."</td>"; // precio
	//echo "<td>".$data->total."</td>"; // monto total
	//--------------------
	echo "<td>";
        
          echo $data->getPagoMonto();  
       
	echo "</td>";
	
	//----------------------Estado
	echo "<td>".$data->textestado."</td>";
	
        
		if(!isset($data->zoho_error))
		{
			echo "<td><i class='icon-ok'></i> Transaccion exitosa</td>";
		}
		else 
		{
			if($data->zoho_error==1)
			{
				     	echo "<td>".
                             CHtml::link("<i class='icon-exclamation-sign'></i> Revisar Zoho",
                                        'javascript:verMotivo("'.Orden::$zoho_error[1].'")') 
     						."</td>";
			}
			if($data->zoho_error==2)
			{
						echo "<td>".
                             CHtml::link("<i class='icon-exclamation-sign'></i> Revisar Zoho",
                                        'javascript:verMotivo("'.Orden::$zoho_error[2].'")' ) 
          						."</td>";
			}
			if($data->zoho_error==3)
			{
						echo "<td>".
                             CHtml::link("<i class='icon-exclamation-sign'></i> Revisar Zoho",
                                        'javascript:verMotivo("'.Orden::$zoho_error[3].'")') 
     						."</td>";
			}
		}
		
		
   		 
    
    	
    

        
        
        
        
	//------------------ acciones
	$canc="";
	if($data->estado == Orden::ESTADO_ESPERA || $data->estado == Orden::ESTADO_CONFIRMADO
            ||$data->estado == Orden::ESTADO_RECHAZADO
            || $data->estado == Orden::ESTADO_INSUFICIENTE){
		//$canc="<li><a onclick='cancelar(".$data->id.")' tabindex='-1' href=''><i class='icon-ban-circle'></i> Cancelar Orden</a></li>";
            
            $canc = "<li>".
                    CHtml::link("<i class='icon-ban-circle'></i> Cancelar Orden",
                        $this->createUrl('orden/cancelar',array('id'=>$data->id, 'admin'=>1)),
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
        
        //Si tiene discrepancias, boton de resolver
        $resolver = "";
        if($data->tieneDiscrepancias()){	
            
            $resolver = "<li>".
                    CHtml::link("<i class='icon-ok'></i> Marcar Resuelta","#",
                        //$this->createUrl('orden/resolverOutbound',array('id'=>$data->id)),
                        array(
                        //'id'=>'linkCancelar'.$data->id,
                        'onclick' => "resolverOutbound($data->id)",
                         )
                    )            
                    ."</li>";
            
        }       
        //Si es corregida, ver la observacion
	$correccion = "";
        
	if($data->fueCorregido()){
            
            if($data->outbound && $data->outbound->observacion != ""){
                
                $message = $data->outbound->observacion;
            }else{
                
                $message = "";
            }
                        
            $correccion = "<li>".
                        CHtml::link("<i class='icon-comment'></i> Ver corrección",
                                        'javascript:verObservacion("'.$message.'")', array(
                                        
                                        )
                                    )            
                     ."</li>";
            
        }   
        
        
	echo "
	<td>
	<div class='dropdown pull-right'>
	<a class='dropdown-toggle btn' id='dLabel' role='button' data-toggle='dropdown' data-target='#' href='admin_pedidos_detalles.php'>
	<i class='icon-cog'></i> <b class='caret'></b>
	</a> 
          <!-- Link or button to toggle dropdown -->
          <ul class='dropdown-menu' role='menu' aria-labelledby='dLabel'>
            <li><a tabindex='-1' href='detalles/".$data->id."'><i class='icon-eye-open'></i> Ver detalles</a></li>
            <li><a onclick='modal(".$data->id.")' tabindex='-1' href='#'><i class='icon-th-list'></i> Ver prendas</a></li>
            ".$canc.
             $motivo.
             $resolver.
            $correccion."
                    
            
            <li><a tabindex='-1' href='#'><i class='icon-file'></i> Generar etiqueta de dirección</a></li>
            <li class='divider'></li>
            
            <li><a tabindex='-1' href='".$this->createUrl('orden/generarExcelOut',array('id'=>$data->id)).
                "'><i class='icon-file'></i> Generar Excel para Outbound</a></li>            
                    
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
function verObservacion(mensaje){
    if(mensaje.trim() == ""){
        mensaje = "<i>No se indicó ninguna observación.</i>";
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


