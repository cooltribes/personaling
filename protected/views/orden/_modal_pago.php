<?php
$orden = Orden::model()->findByPk($orden_id);
$detPago = new Detalle;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4>Agregar Depósito o Transferencia bancaria ya realizada</h4>
</div>
<div class="modal-body">
    <form class="">
        <div class="control-group"> 
            <!--[if lte IE 9]>
                <label class="control-label required">Nombre del Depositante <span class="required">*</span></label>
    <![endif]-->
            <div class="controls"> <?php echo CHtml::activeTextField($detPago, 'nombre', array('id' => 'nombre', 'class' => 'span5', 'placeholder' => 'Nombre del Depositante')); ?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
            </div>
        </div>
        <div class="control-group"> 
            <!--[if lte IE 9]>
                <label class="control-label required">Número o Código del Depósito<span class="required">*</span></label>
    <![endif]-->
            <div class="controls"> <?php echo CHtml::activeTextField($detPago, 'nTransferencia', array('id' => 'numeroTrans', 'class' => 'span5', 'placeholder' => 'Número o Código del Depósito')); ?>
                <div style="display:none" class="help-inline"></div>
            </div>
        </div>
        <div class="control-group"> 
            <!--[if lte IE 9]>
                <label class="control-label required">Nombre del Depositante <span class="required">*</span></label>
    <![endif]-->
            <div class="controls">   <!--  <?php echo CHtml::activeTextField($detPago, 'banco', array('id' => 'banco', 'class' => 'span5', 'placeholder' => 'Banco donde se realizó el depósito')); ?>-->
                <?php echo CHtml::activeDropDownList($detPago, 'banco', array('Seleccione' => 'Seleccione', 'Banesco' => 'Banesco. Cuenta: 0134 0277 98 2771093092'), array('id' => 'banco', 'class' => 'span5')); ?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
            </div>
        </div>
        <div class="control-group"> 
            <!--[if lte IE 9]>
                <label class="control-label required">Nombre del Depositante <span class="required">*</span></label>
    <![endif]-->
            <div class="controls"> <?php echo CHtml::activeTextField($detPago, 'cedula', array('id' => 'cedula', 'class' => 'span5', 'placeholder' => 'Cédula del Depositante')); ?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
            </div>
        </div>
        <div class="control-group"> 
            <!--[if lte IE 9]>
                <label class="control-label required">Nombre del Depositante <span class="required">*</span></label>
    <![endif]-->
            <div class="controls"> <?php echo CHtml::activeTextField($detPago, 'monto', array('id' => 'monto', 'title' => 'Monto', 'class' => 'span5', 'placeholder' => 'Monto. Separe los decimales con una coma (,)', 'value' => Yii::app()->numberFormatter->formatDecimal(round($orden->getxPagar(), 2, PHP_ROUND_HALF_UP)))); ?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
            </div>
        </div>
        <div class="controls controls-row"> 
            <!--[if lte IE 9]>
                <label class="control-label required">Fecha del depósito DD/MM/YYY<span class="required">*</span></label>
    <![endif]--> 
            <?php echo CHtml::TextField('dia', date("d"), array('id' => 'dia', 'class' => 'span1', 'placeholder' => 'Día', 'title' => 'Día')); ?> 
            <?php echo CHtml::TextField('mes', date("m"), array('id' => 'mes', 'class' => 'span1', 'placeholder' => 'Mes', 'title' => 'Mes')); ?> 
            <?php echo CHtml::TextField('ano', date("Y"), array('id' => 'ano', 'class' => 'span2', 'placeholder' => 'Año', 'title' => 'Año')); ?> </div>
        <div class="control-group"> 
            <!--[if lte IE 9]>
                <label class="control-label required">Comentarios (Opcional) <span class="required">*</span></label>
    <![endif]-->
            <div class="controls"> <?php echo CHtml::activeTextArea($detPago, 'comentario', array('id' => 'comentario', 'class' => 'span5', 'rows' => '6', 'placeholder' => 'Comentarios (Opcional)')); ?>
                <div style="display:none" class="help-inline"></div>
            </div>
        </div>
        <div class="form-actions"> <a onclick="enviar(<?php echo $orden->id ?>)" class="btn btn-danger">Confirmar Depósito</a> </div>
        <a title='Formas de Pago' href='<?php echo Yii::app()->baseUrl . "/site/formas_de_pago"; ?>'> Términos y Condiciones de Recepción de pagos por Depósito y/o Transferencia</a><br/></p>
        </p>
    </form>
</div>