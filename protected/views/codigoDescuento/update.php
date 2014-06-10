<?php
$this->breadcrumbs=array(
	'Codigo Descuentos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CodigoDescuento','url'=>array('index')),
	array('label'=>'Create CodigoDescuento','url'=>array('create')),
	array('label'=>'View CodigoDescuento','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage CodigoDescuento','url'=>array('admin')),
);
?>

<h1>Update CodigoDescuento <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>