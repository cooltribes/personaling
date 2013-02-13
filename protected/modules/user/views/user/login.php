<?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
$this->breadcrumbs=array(
	UserModule::t("Login"),
);
?>

<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>
<div class="container margin_top">
  <div class="row">
    <div class="span6 offset3">
      <h1>Ingresa</h1>
      <div class="row margin_bottom margin_top">
        <div class="span3"> <a onclick="loadLiData()" id="registro_linkedin" title="sign up with linkedin" class="btn transition_all" href="#">Ingresa con twitter</a> 
          <!--                            <script type="IN/Login" data-onAuth="onLinkedInAuth"></script>--> 
        </div>
        <div class="span3"><a title="sign up with facebook" class="btn transition_all" onclick="check_fb()" href="#">Ingresa con facebook</a></div>
      </div>
      <article class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
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
            <legend >O ingresa tus datos: </legend>
            
            <div class="control-group">
            	 <div class="controls"> 
            		<?php echo $form->textFieldRow($model,'username',array("class"=>"span5","placeholder"=>"correoelectronico@cuenta.com")); ?>
            	</div>  
            </div>
             <div class="control-group"> 
             	<div class="controls">
            		<?php echo $form->passwordFieldRow($model,'password',array(
            			'class'=>'span5',
        				'hint'=>'Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>',
    				)); ?>
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
	</div>
          </fieldset>
        <?php $this->endWidget(); ?>
      </article>
    </div>
  </div>
</div>
