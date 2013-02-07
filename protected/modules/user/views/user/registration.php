<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
$this->breadcrumbs=array(
	UserModule::t("Registration"),
);
?>



<?php if(Yii::app()->user->hasFlash('registration')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('registration'); ?>
</div>
<?php else: ?>

<div class="container margin_top">
  <div class="row">
    <div class="span6 offset3">
      <h1>Registro</h1>
      <article class="bg_color3 margin_top  margin_bottom_small padding_small box_1">

        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'registration-form',
	'htmlOptions'=>array('class'=>'personaling_form'),
    //'type'=>'stacked',
    'type'=>'inline',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
          <fieldset>
            <legend >Datos personales: </legend>	
	<?php echo $form->errorSummary(array($model,$profile)); ?>
	

	<?php echo $form->textFieldRow($model,'email',array("class"=>"span5")); ?>
	
	<?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span5')); ?>


	
<?php 
		$profileFields=$profile->getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
				//echo $field->varname;
			?>

		<?php 
		if ($widgetEdit = $field->widgetEdit($profile)) {
			echo $widgetEdit;
		} elseif ($field->range) {
			
			echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range));
			//echo $form->radioButtonListRow($profile,$field->varname,Profile::range($field->range));
		} elseif ($field->field_type=="TEXT") {
			echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
		} else {
			echo $form->textFieldRow($profile,$field->varname,array('class'=>'span5','maxlength'=>(($field->field_size)?$field->field_size:255)));
		}
		 ?>

			<?php
			}
		}
?>

	<div class="form-actions"> 
		
			
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Siguiente',
		    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		    'size'=>'large', // null, 'large', 'small' or 'mini'
		)); ?>
	</div>

</fieldset>
<?php $this->endWidget(); ?>
      </article>
    </div>
  </div>
</div>
<?php endif; ?>