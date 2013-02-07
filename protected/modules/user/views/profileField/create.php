<?php
$this->breadcrumbs=array(
	UserModule::t('Profile Fields')=>array('admin'),
	UserModule::t('Create'),
);
$this->menu=array(
    array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('admin')),
    array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin')),
);
?>
<div class="container margin_top">
  <div class="row">
    <div class="span6 offset3">
      <h1>Registro</h1>
      <article class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
<h1><?php echo UserModule::t('Create Profile Field'); ?></h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

      </article>
    </div>
  </div>
</div>