<?php
$this->breadcrumbs=array(
	'Tallas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Talla','url'=>array('index')),
	array('label'=>'Create Talla','url'=>array('create')),
	array('label'=>'Update Talla','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Talla','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Talla','url'=>array('admin')),
);
?>

<h1>View Talla #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'valor',
	),
)); ?>
