<?php
$this->breadcrumbs=array(
	'Master Datas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MasterData','url'=>array('index')),
	array('label'=>'Create MasterData','url'=>array('create')),
	array('label'=>'Update MasterData','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete MasterData','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MasterData','url'=>array('admin')),
);
?>

<h1>View MasterData #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fecha_carga',
		'user_id',
		'prod_nuevos',
		'prod_actualizados',
	),
)); ?>
