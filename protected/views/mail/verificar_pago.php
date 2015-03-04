<table width="100%" border="0" cellspacing="3" style="margin-bottom:10px;" cellpadding="5">
<div  style="background-color:#FCF8E3;  color:#BF9A70">
	 <div class='alert'>
    	 <h2> <?php echo Yii::t('contentForm', 'Order is process') ?></h2>
    	 <p> <?php echo Yii::t('contentForm', 'We received the order data as well as your payment transfer or bank deposit') ?></p>
 	</div>        
 </div >
 <div>
 	
 </div>
</table>
<p> <?php echo Yii::t('contentForm', 'We will verify the transfer or deposit in the next 2-3 business days and will notify you when it has been approved') ?></p>
<h3 style="color:#999999;">RESUMEN DEL PEDIDO</h3> 
<table width="100%" border="0" cellspacing="3" style="margin-bottom:10px;" cellpadding="5">
    <tr>
        <td style=" background-color:#dff0d8; padding:6px;  color:#468847; margin-bottom:5px">
            <p class="well well-small"><strong>Número de confirmación:</strong> <?php echo $orden->id; ?></p>
        </td>
        <td style=" background-color:#dff0d8; color:#468847;">
            <p> <strong>Fecha estimada de entrega</strong>: 
                <?php echo  date('d/m/Y', strtotime($orden->fecha.'+1 week')); ?></p>
        </td>
    </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td  style="text-align:left"><b>Subtotal:</b></th>
        <td><?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency($orden->subtotal, ''); ?></td>
    </tr>
    <?php if($orden->descuento != 0){ // si no hay descuento ?> 
    <tr>
        <td style="text-align:left"><b>Descuento:</b></th>
        <td><?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency($orden->descuento, ''); ?></td>
    </tr>
    <?php } ?>
     <?php if($orden->descuento_look != 0){ // si no hay descuento de look ?> 
    <tr>
        <td style="text-align:left"><b>Descuento por Look:</b></th>
        <td><?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency($orden->descuento_look, ''); ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td style="text-align:left"><b>Envío:</b></th>
        <td><?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency($orden->envio+$orden->seguro, ''); ?></td>
    </tr>
    <tr>
        <td style="text-align:left"><b>I.V.A. (<?php echo Yii::t('contentForm','IVAtext'); ?>):</b></th>
        <td><?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency($orden->iva, ''); ?></td>
    </tr>

    <tr>
        <td style="text-align:left"><h4 class="color1">TOTAL:</h4></th>
        <td><h4 class="color1"><?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency($orden->total, ''); ?></h4></td>
    </tr>
</table>

<hr/>
		