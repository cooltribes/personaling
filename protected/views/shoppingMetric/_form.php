<?php
/* @var $this ShoppingMetricController */
/* @var $model ShoppingMetric */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shopping-metric-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'step'); ?>
		<?php echo $form->textField($model,'step'); ?>
		<?php echo $form->error($model,'step'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_on'); ?>
		<?php echo $form->textField($model,'created_on'); ?>
		<?php echo $form->error($model,'created_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipo_compra'); ?>
		<?php echo $form->textField($model,'tipo_compra'); ?>
		<?php echo $form->error($model,'tipo_compra'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'HTTP_USER_AGENT'); ?>
		<?php echo $form->textArea($model,'HTTP_USER_AGENT',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'HTTP_USER_AGENT'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'REMOTE_ADDR'); ?>
		<?php echo $form->textField($model,'REMOTE_ADDR',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'REMOTE_ADDR'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'HTTP_X_FORWARDED_FOR'); ?>
		<?php echo $form->textField($model,'HTTP_X_FORWARDED_FOR',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'HTTP_X_FORWARDED_FOR'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'HTTP_REFERER'); ?>
		<?php echo $form->textField($model,'HTTP_REFERER',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'HTTP_REFERER'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'data'); ?>
		<?php echo $form->textArea($model,'data',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'data'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->