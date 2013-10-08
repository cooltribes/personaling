<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Cambiar Contraseña");
$this->breadcrumbs=array(
	UserModule::t("Mi cuenta") => array('micuenta'),
	UserModule::t("Cambiar Contraseña"),
);

?>
<div class="container margin_top tu_perfil"> 
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
 
  <div class="row">
   <!-- SIDEBAR ON -->
  <aside class="span3"> <?php echo $this->renderPartial('_sidebar'); ?> </aside>
  <!-- SIDEBAR ON --> 
    <div class="span9 ">
      <h1>Cambia tu contraseña</h1>
      
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
             
             </div>
          </fieldset>
         <?php $this->endWidget(); ?>
      </article>
    </div>
  </div>
</div>
