<?php
/* @var $this PagoController */
/* @var $model Pago */

$this->breadcrumbs = array(
    'Pagos' => array('admin'),
    $model->id
);
?>
<!--Acciones del Pago-->
<style>            
    textarea {
       resize: none;
    }
</style>
<div class="container margin_top">
    <div class="page-header">
        <h1>Pago Nro. <?php echo $model->id; ?> - <small><?php echo $model->getEstado(); ?></small></h1>        
    </div>
    <!-- FLASH ON --> 
    <?php $this->widget('bootstrap.widgets.TbAlert', array(
            'block'=>true, // display a larger alert block?
            'fade'=>true, // use transitions?
            'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
            'alerts'=>array( // configurations per alert type
                'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
                'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            ),
        )
    ); ?>	
    <!-- FLASH OFF --> 
    <h2>
        
        Estado: <strong><?php echo $model->getEstado(); ?></strong>            
        -        
        Monto: <strong><?php echo $model->getMonto(); ?></strong>                        
        
    </h2>  
    <div class="row">                       
        <div class="span8">
            <h3 class="braker_bottom"> Información del Pago</h3>                
            <div class="row-fluid">
                <div class="span6">
                    <ul class="no_bullets no_margin_left">
                        <li><strong>Método de Pago: </strong>
                            <?php echo $model->getTipoPago(); ?>
                        </li> 
                        <li><strong>Fecha de Solicitud: </strong>
                            <?php echo date("d/m/Y h:i:s a", $model->getFechaSolicitud()); ?>
                        </li>
                        <li><strong>Fecha de Respuesta: </strong>
                            <?php echo $model->fecha_respuesta ? date("d/m/Y", $model->getFechaRespuesta())                
                            : "En espera"; ?> 
                        </li>
                        <li><strong>Observación: </strong>
                            <?php echo $model->observacion ? $model->observacion                
                            : "-"; ?> 
                        </li>
                    </ul>
                </div>
                <div class="span6">
                    <ul class="no_bullets no_margin_left">                         
                        <li><strong>Entidad Bancaria: </strong>
                            <?php echo $model->entidad; ?>
                        </li>
                        <li><strong>Cuenta (Nro. o PayPal): </strong>
                            <?php echo $model->cuenta; ?> 
                        </li>
                        <li><strong>ID de Transacción: </strong>
                            <?php echo $model->id_transaccion ? $model->id_transaccion:
                            "En espera"; ?>
                        </li>
                    </ul>
                </div>
            </div>

            <h3 class="braker_bottom"> Información del Personal Shopper</h3>
            <div class="row-fluid">
                <div class="span2">
                    <?php
                    echo CHtml::image($usuario->getAvatar(), '', array('width' => '90', 'height' => '90'));
                    ?>
                </div>
                <div class="span10">
                    <h2><?php echo $usuario->profile->getNombre(); ?>
                        <small> <?php if (Yii::app()->params['askId']) echo Yii::t('contentForm', 'C.I.') .
                                " " . $usuario->profile->cedula; ?>
                                - 
                                <a href="<?php echo $this->createUrl("controlpanel/misventas",
                                        array("id" => $usuario->id)); ?>">
                                Ver información completa
                                </a>
                        </small>
                    </h2>                    
                    <div class="row-fluid">
                        <div class="span6">
                            <ul class="no_bullets no_margin_left">
                                <li><strong>Correo electrónico: </strong>
                                    <?php echo $usuario->email; ?>
                                </li> 
                                <li><strong>Comisión actual: </strong>
                                    <?php echo $usuario->getComision(); ?>
                                </li>
                                <li><strong>Saldo en comisiones: </strong>
                                    <?php echo  $usuario->getSaldoPorComisiones() . " " . Yii::t('backEnd', 'currSym'); ?> 
                                </li>
                            </ul>
                        </div>
                        <div class="span6">
                            <ul class="no_bullets no_margin_left">
                                <li><strong>Registrado desde: </strong><?php echo date('d/m/Y h:i A', strtotime($usuario->create_at)); ?></li>
                                <li><strong>Productos vendidos: </strong>
                                    <?php
                                    echo $usuario->getProductosVendidos();
                                    ?>
                                </li>
                                <!--<li><strong>Total pagado: </strong><?php echo "5 " . Yii::t('contentForm', 'currSym'); ?> </li>-->
                            </ul>
                        </div>
                    </div>
                </div>
            </div> 
            

        </div>

        
        <div class="span4">
            <div class="well well-small margin_top_small well_personaling_small">
              
                <h3 class="braker_bottom margin_top">Acciones</h3> 
                <?php 
                //Solo mostrar acciones si esta En Espera
                if($model->estado == 0){ ?>
                
                <?php $form = $this->beginWidget("bootstrap.widgets.TbActiveForm", array(
                    'type' => 'inline',
                    'htmlOptions' => array(
                        'class' => 'margin_top_small',                        
                    ),
                )); ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <h4>Ingresa el ID de Transacción:</h4>
                            <?php echo TbHtml::textField("idTransaccion", "", array(
                                'placeholder' => "Código de la transacción"
                            )); ?>
                            <?php $this->widget("bootstrap.widgets.TbButton", array(
                                'label' => 'Aceptar Pago',
                                'type' => 'success',
                                'buttonType' => 'submit',
                                'icon' => 'ok white',
                                'htmlOptions' => array(
                                    'name' => 'aceptar',                                                                
                                ),
                            )) ?>                            
                        </div>
                    </div>
                    <hr>
                    <div class="row-fluid">
                        <div class="span12">
                            
                            <?php $this->widget("bootstrap.widgets.TbButton", array(
                                'label' => 'Rechazar Pago',
                                'type' => 'danger',
                                'buttonType' => 'submit',
                                'icon' => 'remove white',                                
                                'htmlOptions' => array(
                                    'name' => 'rechazar',                                                                
                                ),                            
                            )) ?>
                            <h4>Observación <small>(Opcional)</small> :</h4>
                            <?php echo TbHtml::textArea("observacion", "", array(
                                'placeholder' => 'Escribe algún comentario si lo deseas...',
                                'class' => 'span12',
                                'rows' => '4',
                            )); ?>
                        </div>

                    </div>                
                <?php $this->endWidget(); ?>
                    
                <?php 
                // si ya esta aceptado o rechazado
                }else{ ?>    
                    
                    <h4>El pago se encuentra en estado <strong><?php echo $model->getEstado(); ?></strong>. 
                        No hay acciones disponibles...</h4>
                    
                    
                <?php } ?>  
                  
            </div>
        </div>

    </div>

</div>