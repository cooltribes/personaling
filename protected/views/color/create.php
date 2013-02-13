<?php
$this->breadcrumbs=array(
	'Tblcolors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List tblcolor','url'=>array('index')),
	array('label'=>'Manage tblcolor','url'=>array('admin')),
);
?>

<h1>Create tblcolor</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>