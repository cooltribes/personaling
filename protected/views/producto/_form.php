<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'producto-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'nombre',array('class'=>'span5','maxlength'=>50)); ?>

	<?php echo $form->textFieldRow($model,'codigo',array('class'=>'span5','maxlength'=>25)); ?>
	
	<?php echo $form->dropDownListRow($model, 'proveedor', array('Seleccione...', Producto::zara, Producto::bershka, Producto::mango)); ?>
	
	<?php echo $form->html5EditorRow($model, 'descripcion', array('class'=>'span4', 'rows'=>5, 'height'=>'200', 'options'=>array('color'=>true))); ?>
	
	<?php // echo $form->textAreaRow($model,'descripcion',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
	
	<?php echo $form->radioButtonListInlineRow($model, 'estado', array(0 => 'Activo', 1 => 'Inactivo',)); ?>

	<?php echo $form->textFieldRow($model,'fInicio',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fFin',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
