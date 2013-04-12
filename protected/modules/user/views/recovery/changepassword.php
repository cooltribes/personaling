<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Cambiar Contraseña"),
);
?>

<div class="row">
  <div class="span6 offset3">
    <h1><?php echo UserModule::t("Cambiar Contraseña"); ?></h1>
    <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
    <div class="form personaling_form"> <?php echo CHtml::beginForm(); ?>
      
      <?php echo CHtml::errorSummary($form); ?>
      <div class="control-group"> <?php echo CHtml::activeLabelEx($form,'password'); ?>
        <div class="controls"><?php echo CHtml::activePasswordField($form,'password', array('class'=>'span5')); ?>
          <p class="hel-block muted"> <?php echo UserModule::t("Minimal password length 4 symbols."); ?> </p>
        </div>
      </div>
      <div class="control-group"> <?php echo CHtml::activeLabelEx($form,'verifyPassword'); ?>
        <div class="controls"> <?php echo CHtml::activePasswordField($form,'verifyPassword', array('class'=>'span5')); ?> </div>
      </div>
      <div class="form-actions"> <?php echo CHtml::submitButton(UserModule::t("Save"), array('class'=>'btn btn-danger btn-large')); ?> </div>
      <?php echo CHtml::endForm(); ?> </div>
  </div>
  <!-- form --> 
</div>
