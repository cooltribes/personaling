<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nombre',array('class'=>'span5','maxlength'=>70)); ?>

	<?php echo $form->textFieldRow($model,'apellido',array('class'=>'span5','maxlength'=>70)); ?>

	<?php echo $form->textFieldRow($model,'cedula',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'dirUno',array('class'=>'span5','maxlength'=>120)); ?>

	<?php echo $form->textFieldRow($model,'dirDos',array('class'=>'span5','maxlength'=>120)); ?>

	<?php echo $form->textFieldRow($model,'ciudad',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'estado',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'pais',array('class'=>'span5','maxlength'=>80)); ?>

	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
