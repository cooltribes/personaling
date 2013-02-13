<?php
$this->breadcrumbs=array(
	'Tblcolors'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List tblcolor','url'=>array('index')),
	array('label'=>'Create tblcolor','url'=>array('create')),
	array('label'=>'Update tblcolor','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete tblcolor','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage tblcolor','url'=>array('admin')),
);
?>

<h1>View tblcolor #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'valor',
	),
)); ?>
