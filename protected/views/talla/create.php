<?php
$this->breadcrumbs=array(
	'Tallas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Talla','url'=>array('index')),
	array('label'=>'Manage Talla','url'=>array('admin')),
);
?>

<h1>Create Talla</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>