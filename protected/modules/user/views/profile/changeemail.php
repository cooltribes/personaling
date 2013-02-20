<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");
$this->breadcrumbs=array(
	UserModule::t("Mi cuenta") => array('micuenta'),
	UserModule::t("Cambiar Correo"),
);

?>
<div class="container margin_top"> 
	<!-- FLASH ON --> 
<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
        ),
    )
); ?>	
<!-- FLASH OFF --> 	
  <!-- SUBMENU ON -->
 <?php $this->renderPartial("_menu"); ?>
  <!-- SUBMENU OFF -->
  <div class="row">
    <div class="span6 offset3">
      <h1>Cambiar correo electrónico</h1>
      <article class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
                <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'changeemail-form',
			'htmlOptions'=>array('class'=>'personaling_form'),
		    //'type'=>'stacked',
		    'type'=>'inline',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>  <fieldset>
            <legend >Ingresa los datos a continuación: </legend>
            <div class="control-group">
              <label for="RegistrationForm_email" class="control-label required">Dirección de correo electrónico actual: <span class="required">*</span></label>
              <div class="controls">
                <?php echo $form->textFieldRow($model,'oldEmail',array('class'=>'span5')); ?>
                <?php echo $form->error($model,'oldEmail'); ?>
              </div>
            </div>
            
            <div class="control-group">
              <label for="RegistrationForm_email" class="control-label required">Ingresa tu nueva dirección de correo electrónico: <span class="required">*</span></label>
              <div class="controls">
                <?php echo $form->textFieldRow($model,'newEmail',array('class'=>'span5')); ?>
                <?php echo $form->error($model,'newEmail'); ?>
              </div>
            </div>
            
            <div class="control-group">
              <label for="RegistrationForm_email" class="control-label required">Escríbela de nuevo: <span class="required">*</span></label>
              <div class="controls">
                <?php echo $form->textFieldRow($model,'verifyEmail',array('class'=>'span5')); ?>
                <?php echo $form->error($model,'verifyEmail'); ?>
              </div>
            </div>
            
            <div class="control-group">
              <label for="RegistrationForm_password" class="control-label required">Ingresa tu contraseña para finalizar: <span class="required">*</span></label>
              <div class="controls">
              	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>128)); ?>
              	<?php echo $form->error($model,'password'); ?>
              </div>
            </div>
            
            <div class="form-actions"> 
                         	<?php $this->widget('bootstrap.widgets.TbButton', array(
            				'buttonType' => 'submit',
						    'label'=>'Cambiar correo electrónico',
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
<!-- /container -->


