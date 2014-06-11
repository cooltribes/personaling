<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'estado',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'codigo',array('class'=>'span5','maxlength'=>256)); ?>

	<?php echo $form->textFieldRow($model,'descuento',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tipo_descuento',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'inicio_vigencia',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'fin_vigencia',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'plantilla_url',array('class'=>'span5','maxlength'=>255)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
