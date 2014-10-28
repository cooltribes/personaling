<?php
/* @var $this ShoppingMetricController */
/* @var $model ShoppingMetric */

$this->breadcrumbs=array(
	'Shopping Metrics'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ShoppingMetric', 'url'=>array('index')),
	array('label'=>'Create ShoppingMetric', 'url'=>array('create')),
	array('label'=>'View ShoppingMetric', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ShoppingMetric', 'url'=>array('admin')),
);
?>

<h1>Update ShoppingMetric <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>