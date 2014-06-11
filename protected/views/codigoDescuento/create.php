<?php
$this->breadcrumbs=array(
	'Codigo Descuentos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CodigoDescuento','url'=>array('index')),
	array('label'=>'Manage CodigoDescuento','url'=>array('admin')),
);
?>

<h1>Create CodigoDescuento</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>