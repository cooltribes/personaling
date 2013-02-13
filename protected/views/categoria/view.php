<?php
$this->breadcrumbs=array(
	'Tblcategorias'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List tblcategoria','url'=>array('index')),
	array('label'=>'Create tblcategoria','url'=>array('create')),
	array('label'=>'Update tblcategoria','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete tblcategoria','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage tblcategoria','url'=>array('admin')),
);
?>

<h1>View tblcategoria #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'padreId',
		'nombre',
		'urlImagen',
		'mTitulo',
		'mDescripcion',
	),
)); ?>
