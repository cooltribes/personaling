<?php
/* @var $this BugReporteController */
/* @var $model BugReporte */

$this->breadcrumbs=array(
	'Bug Reportes'=>array('index'),
	$model->bug_id=>array('view','id'=>$model->bug_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BugReporte', 'url'=>array('index')),
	array('label'=>'Create BugReporte', 'url'=>array('create')),
	array('label'=>'View BugReporte', 'url'=>array('view', 'id'=>$model->bug_id)),
	array('label'=>'Manage BugReporte', 'url'=>array('admin')),
);
?>

<h1>Update BugReporte <?php echo $model->bug_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>