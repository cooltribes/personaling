<?php
$this->breadcrumbs=array(
	'Codigo Descuentos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CodigoDescuento','url'=>array('index')),
	array('label'=>'Create CodigoDescuento','url'=>array('create')),
	array('label'=>'Update CodigoDescuento','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete CodigoDescuento','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CodigoDescuento','url'=>array('admin')),
);
?>

<h1>View CodigoDescuento #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'estado',
		'codigo',
		'descuento',
		'tipo_descuento',
		'inicio_vigencia',
		'fin_vigencia',
		'plantilla_url',
	),
)); ?>
