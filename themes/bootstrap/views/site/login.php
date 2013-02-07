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
            <legend >O crea tu cuenta: </legend>
            
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
            <label class="checkbox"> Al hacer clic en "Crear Cuenta" estas indicando que has leido y aceptado los <a href="#" title="terminos y condiciones">Terminos de Servicio</a> y la <a href="#" title="Politicas de Privacidad">Politica de Privacidad</a>. </label>
            
            	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'danger',
            'size'=>'large',
            'label'=>'Crear cuenta',
        )); ?>
	</div>
          </fieldset>
        <?php $this->endWidget(); ?>
      </article>
    </div>
  </div>
</div>

