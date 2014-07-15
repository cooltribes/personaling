<?php
/* @var $this TiendaExternaController */
/* @var $model Tienda */

$this->breadcrumbs=array(
	'Tiendas'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Tienda', 'url'=>array('index')),
	array('label'=>'Create Tienda', 'url'=>array('create')),
	array('label'=>'Update Tienda', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Tienda', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Tienda', 'url'=>array('admin')),
);
?>

<h1>View Tienda #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'logo',
		'type',
		'status',
		'url',
	),
)); ?>
