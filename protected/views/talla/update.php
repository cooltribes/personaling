<?php
$this->breadcrumbs=array(
	'Tbltallas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List tbltalla','url'=>array('index')),
	array('label'=>'Create tbltalla','url'=>array('create')),
	array('label'=>'View tbltalla','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage tbltalla','url'=>array('admin')),
);
?>

<h1>Update tbltalla <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>