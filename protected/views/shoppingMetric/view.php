<?php
/* @var $this ShoppingMetricController */
/* @var $model ShoppingMetric */

$this->breadcrumbs=array(
	'Shopping Metrics'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ShoppingMetric', 'url'=>array('index')),
	array('label'=>'Create ShoppingMetric', 'url'=>array('create')),
	array('label'=>'Update ShoppingMetric', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ShoppingMetric', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ShoppingMetric', 'url'=>array('admin')),
);
?>

<h1>View ShoppingMetric #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'step',
		'created_on',
		'tipo_compra',
		'HTTP_USER_AGENT',
		'REMOTE_ADDR',
		'HTTP_X_FORWARDED_FOR',
		'HTTP_REFERER',
		'data',
	),
)); ?>
