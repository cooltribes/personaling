<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<div class="container margin_top">
  <div class="row">
    <div class="span6 offset3">
      <h1>Ingresa</h1>
      <div class="row margin_bottom margin_top">
        <div class="span3"> <a onclick="loadLiData()" id="registro_linkedin" title="sign up with linkedin" class="btn transition_all" href="#">Registrate con twitter</a> 
          <!--                            <script type="IN/Login" data-onAuth="onLinkedInAuth"></script>--> 
        </div>
        <div class="span3"><a title="sign up with facebook" class="btn transition_all" onclick="check_fb()" href="#">Registrate con facebook</a></div>
      </div>
      <article class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked personaling_form" enctype="multipart/form-data">
          <fieldset>
            <legend >O crea tu cuenta: </legend>
            <div class="control-group"> 
              <!--[if lte IE 7]>
            <label for="RegistrationForm_email" class="control-label required">E-mail address: <span class="required">*</span></label>
<![endif]-->
              <div class="controls">
                <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="correoelectronico@cuenta.com" name="RegistrationForm[email]" class="span5">
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
              <!--[if lte IE 7]>
 <label for="RegistrationForm_password" class="control-label required">Choose a password <span class="required">*</span></label><![endif]-->
              <div class="controls">
                <input type="password" maxlength="128" id="RegistrationForm_password" placeholder="Contrasena" name="RegistrationForm[password]" class="span5">
                <div style="display:none" id="RegistrationForm_password_em_" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <label class="checkbox"> Al hacer clic en "Crear Cuenta" estas indicando que has leido y aceptado los <a href="#" title="terminos y condiciones">Terminos de Servicio</a> y la <a href="#" title="Politicas de Privacidad">Politica de Privacidad</a>. </label>
            <div class="form-actions"> <a href="login_2.php" class="btn-large btn btn-danger">Crear cuenta</a> </div>
          </fieldset>
        </form>
      </article>
    </div>
  </div>
</div>
<h1>Login</h1>

<p>Please fill out the following form with your login credentials:</p>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->textFieldRow($model,'username'); ?>

	<?php echo $form->passwordFieldRow($model,'password',array(
        'hint'=>'Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>',
    )); ?>

	<?php echo $form->checkBoxRow($model,'rememberMe'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>'Login',
        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
