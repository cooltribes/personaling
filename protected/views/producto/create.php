<?php
$this->breadcrumbs=array(
	'Tblproductos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List tblproducto','url'=>array('index')),
	array('label'=>'Manage tblproducto','url'=>array('admin')),
);
?>

<h1>Create tblproducto</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>