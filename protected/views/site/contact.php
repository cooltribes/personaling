<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contacto';
$this->breadcrumbs=array(
	'Contacto',
);
?>

Aqui

<h1>Ponte en contacto con nosotros</h1>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<p>
Si tienes alguna duda, propuesta de negocio o quieres reportar alguna falla por favor contáctanos a través del siguiente formulario:</p>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<div class="control-group">
		<?php echo $form->labelEx($model,'Nombre'); ?>
		<div class="controls"><?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?></div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'Correo electrónico'); ?>
		<div class="controls"><?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?></div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'Asunto'); ?>
		<div class="controls"><?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'subject'); ?></div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'Mensaje'); ?>
	<div class="controls">	<?php echo $form->textArea($model,'body',array('rows'=>4, 'cols'=>40)); ?>
		<?php echo $form->error($model,'body'); ?></div>
	</div>

	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="control-group">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
		<?php echo $form->error($model,'verifyCode'); ?>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>