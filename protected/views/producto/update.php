<?php
$this->breadcrumbs=array(
	'Tblproductos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List tblproducto','url'=>array('index')),
	array('label'=>'Create tblproducto','url'=>array('create')),
	array('label'=>'View tblproducto','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage tblproducto','url'=>array('admin')),
);
?>

<h1>Update tblproducto <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>