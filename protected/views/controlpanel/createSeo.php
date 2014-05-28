<?php
/* @var $this CampanaController */

$this->breadcrumbs=array(
	'Seo'=>array('/controlpanel/seo'),
	'Crear',
);
?>
<div class="container margin_top">

  <div class="page-header">
    <h1>Crear Elemento SEO</h1>
  </div>
  <div class="row">
    
     
     	<?php echo $this->renderPartial('_form_seo', array('model'=>$model)); ?>
     
    
    
  </div>
</div>