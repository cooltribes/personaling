<?php
$this->breadcrumbs=array(
	'Tblcategorias'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List tblcategoria','url'=>array('index')),
	array('label'=>'Create tblcategoria','url'=>array('create')),
	array('label'=>'View tblcategoria','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage tblcategoria','url'=>array('admin')),
);
?>

<h1>Update tblcategoria <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>