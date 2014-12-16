<?php
$orden = Orden::model()->findByPk($orden_id);
$detPago = new Detalle;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4><?php echo Yii::t("backEnd", "Add made bank deposit or transfer"); ?></h4>
</div>
<div class="modal-body">
    <form class="">
        <div class="control-group"> 
            <!--[if lte IE 9]>
                <label class="control-label required"><?php echo Yii::t('backEnd', 'Depositor name'); ?><span class="required">*</span></label>
    <![endif]-->
            <div class="controls"> <?php echo CHtml::activeTextField($detPago, 'nombre', array('id' => 'nombre', 'class' => 'span5', 'placeholder' => Yii::t('backEnd', 'Depositor name'))); ?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
            </div>
        </div>
        <div class="control-group"> 
            <!--[if lte IE 9]>
                <label class="control-label required"><?php echo Yii::t('backEnd', 'Deposit number'); ?><span class="required">*</span></label>
    <![endif]-->
            <div class="controls"> <?php echo CHtml::activeTextField($detPago, 'nTransferencia', array('id' => 'numeroTrans', 'class' => 'span5', 'placeholder' => 'Número o Código del Depósito')); ?>
                <div style="display:none" class="help-inline"></div>
            </div>
        </div>
        <div class="control-group"> 
            <!--[if lte IE 9]>
                <label class="control-label required"><?php echo Yii::t('backEnd', 'Bank'); ?><span class="required">*</span></label>
    <![endif]-->
            <div class="controls">   <!--  <?php echo CHtml::activeTextField(
                    $detPago, 'banco', array('id' => 'banco', 'class' => 'span5', 'placeholder' => Yii::t('backEnd', 'Bank'))); ?>-->
                <?php echo CHtml::activeDropDownList($detPago, 'banco', array(
                    'Seleccione' => 'Seleccione', 'Banesco' => Yii::t('backEnd', 'Banesco. Account:').'0134 0277 98 2771093092'),
                        array('id' => 'banco', 'class' => 'span5')); ?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
            </div>
        </div>
        <div class="control-group"> 
            <!--[if lte IE 9]>
                <label class="control-label required"><?php echo Yii::t('backEnd', 'Depositor ID'); ?><span class="required">*</span></label>
    <![endif]-->
            <div class="controls"> <?php echo CHtml::activeTextField($detPago, 'cedula', array(
                'id' => 'cedula', 'class' => 'span5', 'placeholder' => Yii::t('backEnd', 'Depositor ID'))); ?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
            </div>
        </div>
        <div class="control-group"> 
            <!--[if lte IE 9]>
                <label class="control-label required"><?php echo Yii::t('backEnd', 'Amount. Use comma (,) as decimal separator'); ?><span class="required">*</span></label>
    <![endif]-->
            <div class="controls input-append"> <?php echo CHtml::activeTextField(
                    $detPago, 'monto', array('id' => 'monto', 'title' => 'Monto',
                        'class' => 'span4', 'placeholder' => Yii::t('backEnd', 'Amount. Use comma (,) as decimal separator'),
                        'value' => Yii::app()->numberFormatter->formatDecimal(round($orden->getxPagar(), 2, PHP_ROUND_HALF_UP)))); ?>
                <span class="add-on"><?php echo Yii::t('backEnd', 'currSym'); ?></span>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
            </div>
        </div>
        <div class="controls controls-row"> 
            <!--[if lte IE 9]>
                <label class="control-label required"><?php echo Yii::t('backEnd', 'Deposit date'); ?><span class="required">*</span></label>
    <![endif]--> 
            <span class="label-row">Día</span>
            <?php echo CHtml::TextField('dia', date("d"), array('id' => 'dia', 'class' => 'span1', 'placeholder' => 'Día', 'title' => Yii::t('backEnd', 'Day'))); ?> 
            <span class="label-row">Mes</span>
            <?php echo CHtml::TextField('mes', date("m"), array('id' => 'mes', 'class' => 'span1', 'placeholder' => 'Mes', 'title' => Yii::t('backEnd', 'Month'))); ?> 
            <span class="label-row">Año</span>
            <?php echo CHtml::TextField('ano', date("Y"), array('id' => 'ano', 'class' => 'span2', 'placeholder' => 'Año', 'title' => Yii::t('backEnd', 'Year'))); ?> </div>
        <div class="control-group"> 
            <!--[if lte IE 9]>
                <label class="control-label required"><?php echo Yii::t('backEnd', 'Comments (Optional)'); ?><span class="required">*</span></label>
    <![endif]-->
            <div class="controls"> <?php echo CHtml::activeTextArea($detPago, 'comentario', 
                    array('id' => 'comentario', 'class' => 'span5', 'rows' => '6',
                        'placeholder' => Yii::t('backEnd', Yii::t('backEnd', 'Comments (Optional)')))); ?>
                <div style="display:none" class="help-inline"></div>
            </div>
        </div>
        <div class="form-actions"> <a onclick="enviar(<?php echo $orden->id ?>)" class="btn btn-danger"><?php echo Yii::t('backEnd', 'Confirm Deposit'); ?></a> </div>
        <a title='<?php echo Yii::t('backEnd', 'Payment Methods'); ?>' href='<?php echo Yii::app()->baseUrl . "/site/formas_de_pago"; ?>'><?php echo Yii::t('backEnd', 'Terms and Conditions of Depósits and Transfers payments'); ?></a><br/></p>
        </p>
    </form>
</div>