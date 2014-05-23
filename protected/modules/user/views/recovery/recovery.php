<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Restore"),
);
?>

<div class="row">
  <div class="span6 offset3">
    <h1><?php echo UserModule::t("Restore"); ?></h1>
    <?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
    <div class="success box_1 padding_large margin_bottom_small">
      <div class="alert alert-success padding_large margin_top_small"> <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?> </div>
    </div>
    <?php else: ?>
    <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
      <div class="form personaling_form"> <?php echo CHtml::beginForm(); ?> <?php echo CHtml::errorSummary($form); ?>
        <div class="control-group"> <?php echo CHtml::activeLabel($form,'login_or_email'); ?>
          <div class="controls"><?php echo CHtml::activeTextField($form,'login_or_email', array('class'=>'span5',)) ?>
            <p class="hint"><?php echo UserModule::t("Please enter your login or email addres."); ?></p>
          </div>
        </div>
        <div> <?php echo CHtml::submitButton(UserModule::t("Restore"), array('class'=>'btn btn-danger btn-large')); ?> </div>
        <?php echo CHtml::endForm(); ?> </div>
      <!-- form --> 
    </section>
  </div>
</div>
</div>
<?php endif; ?>
