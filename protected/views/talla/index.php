<?php
$this->breadcrumbs=array(
	'Tbltallas',
);

$this->menu=array(
	array('label'=>'Create tbltalla','url'=>array('create')),
	array('label'=>'Manage tbltalla','url'=>array('admin')),
);
?>

<h1>Tbltallas</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
