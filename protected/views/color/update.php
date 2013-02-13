<?php
$this->breadcrumbs=array(
	'Tblcolors'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List tblcolor','url'=>array('index')),
	array('label'=>'Create tblcolor','url'=>array('create')),
	array('label'=>'View tblcolor','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage tblcolor','url'=>array('admin')),
);
?>

<h1>Update tblcolor <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>