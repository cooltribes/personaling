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
      <div class="row  margin_top">
              <div class="span3 margin_bottom"><a title="Inicia sesión con facebook" class="transition_all" onclick="check_fb()" href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/login_facebook.png" width="230" height="39" alt="Inicia sesión con Facebook"></a></div>

        <div class="span3 margin_bottom"> <a onclick="loadLiData()" id="registro_linkedin" title="Inicia sesión con Twitter" class="transition_all" href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/login_twitter.png" width="230" height="39" alt="Inicia sesión con twitter"></a> 
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
            
            <div class="control-group">
            	 <div class="controls"> 
            		<?php echo $form->textFieldRow($model,'username',array("class"=>"span5","placeholder"=>"correoelectronico@cuenta.com")); ?>
            		<?php echo $form->error($model,'username'); ?>
            	</div>  
            </div>
             <div class="control-group"> 
             	<div class="controls">
            		<?php echo $form->passwordFieldRow($model,'password',array(
            			'class'=>'span5',
        				'hint'=>'Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>',
    				)); ?>
                     <span class="help-block muted text_align_right padding_right"><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/recovery" class="muted" title="Recuperar password">Olvidaste tu password?</a></span>
    				<?php echo $form->error($model,'password'); ?>
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
