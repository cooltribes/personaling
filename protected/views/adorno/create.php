<?php
/* @var $this AdornoController */

$this->breadcrumbs=array(
	'Elementos Gráficos',
);
?>
<div class="container margin_top">
    <div class="page-header">
        <h1>Crear Elemento Gráfico</h1>
    </div>
    
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
<!-- /container -->