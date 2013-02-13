<?php
$this->breadcrumbs=array(
	'Tbltallas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List tbltalla','url'=>array('index')),
	array('label'=>'Manage tbltalla','url'=>array('admin')),
);
?>

<h1>Create tbltalla</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>