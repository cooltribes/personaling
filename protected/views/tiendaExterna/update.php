<?php
/* @var $this TiendaExternaController */
/* @var $model Tienda */

$this->breadcrumbs=array(
	'Tiendas'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Tienda', 'url'=>array('index')),
	array('label'=>'Create Tienda', 'url'=>array('create')),
	array('label'=>'View Tienda', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Tienda', 'url'=>array('admin')),
);
?>

<h1>Update Tienda <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>