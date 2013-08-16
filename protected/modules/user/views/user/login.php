<?php /*?><?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
$this->breadcrumbs=array(
	UserModule::t("Login"),
);
?><?php */?>

<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>
<div class="container margin_top">
  <div class="row">
    <div class="span6 offset3">
      <h1>Inicia sesión</h1>
      <div  class="row-fluid  margin_top">
              <div id="boton_facebook" class="span5 margin_bottom "><a title="Inicia sesión con facebook" class="transition_all" onclick="check_fb()" href="#">Inicia sesión con Facebook</a></div>

              <div id="boton_twitter" class="span5 offset2 margin_bottom "><a id="registro_twitter" title="Inicia sesión con Twitter" class="transition_all" href="<?php echo Yii::app()->request->baseUrl; ?>/user/registration/twitterStart">Inicia sesión con Twitter</a> 
              <!--                            <script type="IN/Login" data-onAuth="onLinkedInAuth"></script>--> 
        </div>
      </div>
      <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'login-form',
			'htmlOptions'=>array('class'=>'personaling_form'),
		    //'type'=>'stacked',
		    'type'=>'inline',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>
          <fieldset>
            <legend >O usa tus credenciales de personaling: </legend>
            
            <div class="control-group row-fluid">
            	 <div class="controls"> 
            		<?php echo $form->textFieldRow($model,'username',array("class"=>"span12","placeholder"=>"correoelectronico@cuenta.com")); ?>
            		<?php echo $form->error($model,'username'); ?>
            	</div>  
            </div>
             <div class="control-group row-fluid"> 
             	<div class="controls">
            		<?php echo $form->passwordFieldRow($model,'password',array(
            			'class'=>'span12',
        				'hint'=>'Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>',
    				)); ?>
                     <span class="help-block muted text_align_right padding_right"><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/recovery" class="muted" title="Recuperar contraseña">Olvidaste tu contraseña?</a></span>
    				<?php echo $form->error($model,'password'); ?>
                                <?php echo $form->error($model,'status'); ?>
                </div>
    		</div>
            <?php echo $form->checkBoxRow($model,'rememberMe'); ?>
            
            
            	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'danger',
            'size'=>'large',
            'label'=>'Entrar',
        )); ?>
         <span class="margin_left_small"> Si no tienes cuenta, <a href="<?php echo Yii::app()->request->baseUrl; ?>/user/registration" title="Registrate">Regístrate aqui</a></span>
	</div>
          </fieldset>
        <?php $this->endWidget(); ?>
      </section>
    </div>
  </div>
</div>

<?php  
 $baseUrl = Yii::app()->baseUrl;
 $cs = Yii::app()->getClientScript();
 $cs->registerScriptFile($baseUrl.'/js/facebook.js');

?>
