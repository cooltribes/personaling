<?php
$this->breadcrumbs=array(
	'Colors',
);

$this->menu=array(
	array('label'=>'Create Color','url'=>array('create')),
	array('label'=>'Manage Color','url'=>array('admin')),
);
?>

<h1>Colors</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
