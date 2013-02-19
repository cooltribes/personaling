<?php
$this->breadcrumbs=array(
	'Tallas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Talla','url'=>array('index')),
	array('label'=>'Create Talla','url'=>array('create')),
	array('label'=>'View Talla','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Talla','url'=>array('admin')),
);
?>

<h1>Update Talla <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>