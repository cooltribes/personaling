<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'categoria-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

		<?php echo $form->labelEx($model,'padreId'); ?>
		<?php echo CHtml::activeDropDownList($model,'padreId',CHtml::listData( Categoria::model()->findAll(), 'id', 'nombre' ),array('prompt'=>'Ninguno')); ?>
		<?php echo $form->error($model,'padreId'); ?>

<?php 

$cat = Categoria::model()->findAllByAttributes(array('padreId'=>'0',));

	nodos($cat,$form,$model); 
	
	function nodos($items,$form,$model){
		echo "<ul>";
		foreach ($items as $item){
			
			echo $form->radioButtonListRow($model, 'padreId', array($item->nombre,));
			
			//echo "<li> <input type='checkbox'> ".$item->nombre."</li>";
			if ($item->hasChildren()){
				nodos($item->getChildren(),$form,$model);
			}
		}
		echo "</ul>";
		return 1;
	}


?>

	<?php //echo $form->textFieldRow($model,'padreId',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'nombre',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model,'urlImagen',array('class'=>'span5','maxlength'=>150)); ?>

	<?php echo $form->textFieldRow($model,'mTitulo',array('class'=>'span5','maxlength'=>80)); ?>

	<?php echo $form->textAreaRow($model,'mDescripcion',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
