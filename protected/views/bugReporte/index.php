<?php
/* @var $this BugReporteController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Bug Reportes',
);

$this->menu=array(
	array('label'=>'Create BugReporte', 'url'=>array('create')),
	array('label'=>'Manage BugReporte', 'url'=>array('admin')),
);
?>

<h1>Bug Reportes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
