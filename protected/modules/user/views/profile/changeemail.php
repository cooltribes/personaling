<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");
$this->breadcrumbs=array(
	UserModule::t("Mi cuenta") => array('micuenta'),
	UserModule::t("Cambiar Correo"),
);

?>
<div class="container margin_top"> 
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
                <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="correoelectronico@cuenta.com" name="RegistrationForm[email]" class="span5 uneditable-input" value="jpernia@cooltribes.com">
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group">
              <label for="RegistrationForm_email" class="control-label required">Ingresa tu nueva dirección de correo electrónico: <span class="required">*</span></label>
              <div class="controls">
                <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Ej.: correoelectronico@cuenta.com" name="RegistrationForm[email]" class="span5" >
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group">
              <label for="RegistrationForm_email" class="control-label required">Escríbela de nuevo: <span class="required">*</span></label>
              <div class="controls">
                <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Ej.: correoelectronico@cuenta.com" name="RegistrationForm[email]" class="span5" >
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group">
              <label for="RegistrationForm_password" class="control-label required">Ingresa tu contraseña para finalizar: <span class="required">*</span></label>
              <div class="controls">
                <input type="password" maxlength="128" id="RegistrationForm_password" placeholder="Contraseña" name="RegistrationForm[password]" class="span5">
                <div style="display:none" id="RegistrationForm_password_em_" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <div class="form-actions"> <a href="login_2.php" class="btn-large btn btn-danger">Cambiar correo electrónico</a> </div>
          </fieldset>
         <?php $this->endWidget(); ?>
      </article>
    </div>
  </div>
</div>
<!-- /container -->


