<?php
/* @var $this PagoController */
/* @var $model Pago */

$this->breadcrumbs=array(
	'Pagos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Pago', 'url'=>array('index')),
	array('label'=>'Create Pago', 'url'=>array('create')),
	array('label'=>'Update Pago', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Pago', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pago', 'url'=>array('admin')),
);
?>

<h1>View Pago #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'estado',
		'monto',
		'fecha_solicitud',
		'fecha_respuesta',
		'user_id',
		'admin_id',
		'tipo',
		'entidad',
		'cuenta',
		'id_transaccion',
	),
)); ?>
