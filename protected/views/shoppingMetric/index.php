<?php
/* @var $this ShoppingMetricController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shopping Metrics',
);

$this->menu=array(
	array('label'=>'Create ShoppingMetric', 'url'=>array('create')),
	array('label'=>'Manage ShoppingMetric', 'url'=>array('admin')),
);
?>

<h1>Shopping Metrics</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
