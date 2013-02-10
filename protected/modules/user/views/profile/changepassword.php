<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");
$this->breadcrumbs=array(
	UserModule::t("Profile") => array('/user/profile'),
	UserModule::t("Change Password"),
);

?>
<div class="container margin_top">
  <div class="row">
    <div class="span6 offset3">
      <h1>Cambiar contraseña</h1>
      
      <article class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'changepassword-form',
			'htmlOptions'=>array('class'=>'personaling_form'),
		    //'type'=>'stacked',
		    'type'=>'inline',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>
          <fieldset>
            <legend >Ingresa los datos a continuación: </legend>
            <p class="note">Campos con <span class="required">*</span> son requeridos.</p>
            <div class="control-group"> 
           
            <label for="RegistrationForm_email" class="control-label required">Ingresa tu contraseña actual: <span class="required">*</span></label>

              <div class="controls">
              	<?php echo $form->passwordFieldRow($model,'oldPassword',array('class'=>'span5','maxlength'=>128)); ?>
              	<?php echo $form->error($model,'oldPassword'); ?>

              </div>
            </div>
            <div class="control-group"> 
          
            <label for="RegistrationForm_email" class="control-label required">Ingresa tu nueva contraseña: <span class="required">*</span></label>

              <div class="controls">
              	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>128)); ?>
              	<?php echo $form->error($model,'password'); ?>
              </div>
            </div>
            <div class="control-group"> 
       
            <label for="RegistrationForm_email" class="control-label required">Escríbela de nuevo: <span class="required">*</span></label>

              <div class="controls">
              	<?php echo $form->passwordFieldRow($model,'verifyPassword',array('class'=>'span5','maxlength'=>128)); ?>
              	<?php echo $form->error($model,'verifyPassword'); ?>
              </div>
            </div>
            
             <div class="form-actions"> 
             	<?php $this->widget('bootstrap.widgets.TbButton', array(
            				'buttonType' => 'submit',
						    'label'=>'Cambiar Contraseña',
						    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						    'size'=>'large', // null, 'large', 'small' or 'mini'
						)); ?> 
             	<a href="login_2.php" class="btn-large btn btn-danger">Cambiar Contraseña</a> 
             </div>
          </fieldset>
         <?php $this->endWidget(); ?>
      </article>
    </div>
  </div>
</div>
