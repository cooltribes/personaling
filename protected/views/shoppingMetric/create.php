<?php
/* @var $this ShoppingMetricController */
/* @var $model ShoppingMetric */

$this->breadcrumbs=array(
	'Shopping Metrics'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ShoppingMetric', 'url'=>array('index')),
	array('label'=>'Manage ShoppingMetric', 'url'=>array('admin')),
);
?>

<h1>Create ShoppingMetric</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>