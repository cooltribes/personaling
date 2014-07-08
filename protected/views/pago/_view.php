<?php
/* @var $this PagoController */
/* @var $data Pago */
?>

<tr>    
    <td>
        <input name="check" type="checkbox" value="">
    </td>
    
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
        <?php echo $data->monto; ?>
    </td>
    
    <!--Fecha de Solicitud-->
    <td>
        <?php echo date("d/m/Y h:i:s a", $data->getFechaSolicitud()); ?>
    </td>
    
    <!--Fecha de Respuesta-->
    <td>        
        <?php echo $data->fecha_respuesta ? date("d/m/Y", $data->getFechaRespuesta())                
                : "-"; ?>
    </td>  
    
    
    <td>
        <div class="dropdown"> 
            <a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="" title="acciones">
                <i class="icon-cog"></i> <b class='caret'></b>
            </a> 
            <!-- Link or button to toggle dropdown -->
            <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">
                <li>
                    <?php echo CHtml::link('<i class="icon-eye-open">  </i>  Ver Detalles', "#modalGiftCard", array(
                        'data-toggle' => "modal",
                        'onClick' => "ver({$data->id})",
                    )); ?>            
                </li>
                
                    <?php if ($data->estado == 1) { ?>
                        <li>
                        <?php echo CHtml::link('<i class="icon-envelope">  </i>  Enviar', array("enviar", "id" => $data->id)); ?>
                        </li>
                    <?php }else if ($data->estado == 2) { ?>
                        <li>
                        <?php echo  CHtml::link("<i class='icon-ban-circle'></i> Desactivar",
                                        $this->createUrl('index',array('id'=>$data->id)),
                                        array(
                                        'id'=>'linkDesactivar-'.$data->id)
                                    ); ?>
                        </li>
                    <?php } ?>
                
                
                    
            </ul>
        </div>
    </td>
</tr>
