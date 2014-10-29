<?php
/* @var $this ShoppingMetricController */
/* @var $data ShoppingMetric */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('step')); ?>:</b>
	<?php echo CHtml::encode($data->step); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_on')); ?>:</b>
	<?php echo CHtml::encode($data->created_on); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_compra')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_compra); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('HTTP_USER_AGENT')); ?>:</b>
	<?php echo CHtml::encode($data->HTTP_USER_AGENT); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('REMOTE_ADDR')); ?>:</b>
	<?php echo CHtml::encode($data->REMOTE_ADDR); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('HTTP_X_FORWARDED_FOR')); ?>:</b>
	<?php echo CHtml::encode($data->HTTP_X_FORWARDED_FOR); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('HTTP_REFERER')); ?>:</b>
	<?php echo CHtml::encode($data->HTTP_REFERER); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('data')); ?>:</b>
	<?php echo CHtml::encode($data->data); ?>
	<br />

	*/ ?>

</div>