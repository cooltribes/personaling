<?php
$this->breadcrumbs=array(
	'Tblproductos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List tblproducto','url'=>array('index')),
	array('label'=>'Create tblproducto','url'=>array('create')),
	array('label'=>'Update tblproducto','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete tblproducto','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage tblproducto','url'=>array('admin')),
);
?>

<h1>View tblproducto #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'codigo',
		'nombre',
		'estado',
		'descripcion',
		'fInicio',
		'fFin',
	),
)); ?>
