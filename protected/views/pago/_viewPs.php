<?php
/* @var $this PagoController */
/* @var $data Pago */
?>

<tr>        
    <td>
        <?php echo $data->id; ?>
    </td>
            
    <!--Estado-->
    <td>
        <?php echo $data->getEstado(); ?> 
    </td>
    
    <!--Tipo de Pago-->
    <td>
        <?php echo $data->getTipoPago(); ?> 
    </td>
    
    <!--Monto-->
    <td>
        <?php echo $data->getMonto(); ?>
    </td>
    
    <!--Fecha de Solicitud-->
    <td>
        <?php echo date("d/m/Y h:i:s a", $data->getFechaSolicitud()); ?>
    </td>
    
    <!--Fecha de Respuesta-->
    <td>        
       <?php echo $data->fecha_respuesta ? date("d/m/Y h:i:s a", $data->getFechaRespuesta())                
                : $data->getEstado(); ?>
    </td>     
    
    <!--Código de Transacción-->
    <td>        
       <?php echo $data->id_transaccion ? $data->id_transaccion : 
               ($data->estado == 2 ? "-" :$data->getEstado()); ?>
    </td>     
    
    
</tr>
