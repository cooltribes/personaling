<?php
$this->breadcrumbs=array(
	'Colors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Color','url'=>array('index')),
	array('label'=>'Manage Color','url'=>array('admin')),
);
?>

<h1>Create Color</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>