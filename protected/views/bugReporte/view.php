<?php
/* @var $this BugReporteController */
/* @var $model BugReporte */

$this->breadcrumbs=array(
	'Bug Reportes'=>array('index'),
	$model->bug_id,
);

$this->menu=array(
	array('label'=>'List BugReporte', 'url'=>array('index')),
	array('label'=>'Create BugReporte', 'url'=>array('create')),
	array('label'=>'Update BugReporte', 'url'=>array('update', 'id'=>$model->bug_id)),
	array('label'=>'Delete BugReporte', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->bug_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BugReporte', 'url'=>array('admin')),
);
?>

<h1>View BugReporte #<?php echo $model->bug_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'user_id',
		'bug_id',
		'fecha',
		'descripcion',
		'estado',
	),
)); ?>
