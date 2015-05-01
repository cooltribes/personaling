<?php
/* @var $this TiendaExternaController */
/* @var $model Tienda */
/* @var $form CActiveForm */
?>



<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tienda-form',
	'enableAjaxValidation'=>false,
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'type'=>'horizontal',
	'clientOptions'=>array(
		'validateOnSubmit'=>true, 
	),
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'class'=>'form-stacked personaling_form padding_top_small'
    ),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<fieldset>
	<?php echo $form->errorSummary($model, Funciones::errorMsg()); ?>

	<div class="control-group margin_top_medium">
		<?php echo $form->labelEx($model,'name'); ?>
		<div class="controls">
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100,'class'=>'span6')); ?>
		<?php echo $form->error($model,'name'); ?>
		</div>
	</div>

	<div class="control-group margin_top_medium">
		<?php echo $form->labelEx($model,'description'); ?>
		<div class="controls">
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50,'class'=>'span6')); ?>
		<?php echo $form->error($model,'description'); ?>
		</div>
	</div>

	<div class="control-group margin_top_medium">
		<?php echo $form->labelEx($model,'logo'); ?>
		<div class="controls">
		<?php echo $form->textField($model,'logo',array('size'=>60,'maxlength'=>100,'class'=>'span6')); ?>
		<?php echo $form->error($model,'logo'); ?>
		</div>
	</div>

	<div class="control-group margin_top_medium">
		<?php echo $form->labelEx($model,'url'); ?>
		<div class="controls">
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>100,'class'=>'span6')); ?>
		<?php echo $form->error($model,'url'); ?>
		</div>
	</div>

	<div class="control-group margin_top_medium">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
	</fieldset>
<?php $this->endWidget(); ?>

