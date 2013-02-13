<?php
$this->breadcrumbs=array(
	'Tbltallas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List tbltalla','url'=>array('index')),
	array('label'=>'Create tbltalla','url'=>array('create')),
	array('label'=>'Update tbltalla','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete tbltalla','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage tbltalla','url'=>array('admin')),
);
?>

<h1>View tbltalla #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'valor',
	),
)); ?>
