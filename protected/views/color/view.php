<?php
$this->breadcrumbs=array(
	'Colors'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Color','url'=>array('index')),
	array('label'=>'Create Color','url'=>array('create')),
	array('label'=>'Update Color','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Color','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Color','url'=>array('admin')),
);
?>

<h1>View Color #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'valor',
	),
)); ?>
