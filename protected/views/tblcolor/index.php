<?php
$this->breadcrumbs=array(
	'Tblcolors',
);

$this->menu=array(
	array('label'=>'Create tblcolor','url'=>array('create')),
	array('label'=>'Manage tblcolor','url'=>array('admin')),
);
?>

<h1>Tblcolors</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
