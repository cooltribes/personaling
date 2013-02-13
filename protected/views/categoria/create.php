<?php
$this->breadcrumbs=array(
	'Tblcategorias'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List tblcategoria','url'=>array('index')),
	array('label'=>'Manage tblcategoria','url'=>array('admin')),
);
?>

<h1>Create tblcategoria</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>