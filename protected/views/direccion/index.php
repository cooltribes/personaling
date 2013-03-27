<?php
$this->breadcrumbs=array(
	'Direccions',
);

$this->menu=array(
	array('label'=>'Create Direccion','url'=>array('create')),
	array('label'=>'Manage Direccion','url'=>array('admin')),
);
?>

<h1>Direccions</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
