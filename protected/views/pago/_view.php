<?php
/* @var $this PagoController */
/* @var $data Pago */
?>

<tr>       
    <td>
        <?php echo $data->id; ?>
    </td>
    
    <!--Usuario-->
    <td>
        <h5 class="no_margin_bottom no_margin_top"> <?php echo $data->user->profile->getNombre();?></h5>
        <small>
            <?php            
               echo $data->user->email;            
            ?>
        </small>
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
    
    
    <td>
        <div class="dropdown"> 
            <a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="" title="acciones">
                <i class="icon-cog"></i> <b class='caret'></b>
            </a> 
            <!-- Link or button to toggle dropdown -->
            <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">
                <li>
                    <?php echo CHtml::link('<i class="icon-eye-open">  </i>  Ver Detalles',
                            $this->createUrl("detalle", array("id" => $data->id)), array(
//                        'data-toggle' => "modal",
//                        'onClick' => "ver({$data->id})",
                    )); ?>            
                </li>
                
                    
            </ul>
        </div>
    </td>
</tr>
