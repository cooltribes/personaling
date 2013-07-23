<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Tu Perfil");

//$this->breadcrumbs=array(
//	UserModule::t("Profile")=>array('micuenta'),
//	'Datos de Personal Shopper',
//); 

?>

<div class="container margin_top tu_perfil">
  <div class="row"> 
    
    <!-- SIDEBAR ON -->
    <aside class="span3"> <?php echo $this->renderPartial('_sidebar'); ?> </aside>
    <!-- SIDEBAR ON -->
    
    <div class="span9"> 
      <!-- FLASH ON -->
      <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )
); ?>
      <!-- FLASH OFF -->
      <article class="bg_color3   margin_bottom_small padding_small box_1">
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'profile-form',
	'htmlOptions'=>array('class'=>'personaling_form','enctype'=>'multipart/form-data'),
    //'type'=>'stacked',
    'type'=>'inline',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	
)); ?>
        <fieldset>
          <h1>Personal Shopper</h1>
          <?php 
		$profileFields=$profile->getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
				//echo $field->varname;
			?>
          <div class="control-group">
            <div class="controls">
              <?php 
		if ($widgetEdit = $field->widgetEdit($profile)) {
			echo $widgetEdit;
		} elseif ($field->range) {
			if ($field->varname == 'sex')
				echo $form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range));
			else
				echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range));

		} elseif ($field->field_type=="TEXT") {
			echo $form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
		} else {
			if ($field->varname == 'bio')
				echo $form->textAreaRow($profile,$field->varname,array('rows'=>5, 'cols'=>50, 'maxlength'=>(($field->field_size)?$field->field_size:255), 'style'=>'width:476px;'));
			else
				echo $form->textFieldRow($profile,$field->varname,array('class'=>'span5','maxlength'=>(($field->field_size)?$field->field_size:255)));
		}
		 ?>
              <?php echo $form->error($profile,$field->varname); ?> </div>
          </div>
          <?php
			}
		}
?>
          <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
            				'buttonType'=>'submit',
						    'label'=>'Guardar',
						    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						    'size'=>'large', // null, 'large', 'small' or 'mini'
						)); ?>
            <?php //echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save')); ?>
          </div>
        </fieldset>
        <?php $this->endWidget(); ?>
      </article>
    </div>
  </div>
</div>
