<?php
/* @var $this ShoppingMetricController */
/* @var $model ShoppingMetric */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'step'); ?>
		<?php echo $form->textField($model,'step'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_on'); ?>
		<?php echo $form->textField($model,'created_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_compra'); ?>
		<?php echo $form->textField($model,'tipo_compra'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'HTTP_USER_AGENT'); ?>
		<?php echo $form->textArea($model,'HTTP_USER_AGENT',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'REMOTE_ADDR'); ?>
		<?php echo $form->textField($model,'REMOTE_ADDR',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'HTTP_X_FORWARDED_FOR'); ?>
		<?php echo $form->textField($model,'HTTP_X_FORWARDED_FOR',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'HTTP_REFERER'); ?>
		<?php echo $form->textField($model,'HTTP_REFERER',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'data'); ?>
		<?php echo $form->textArea($model,'data',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->