<?php
$this->breadcrumbs=array(
	'Tblproductos',
);

$this->menu=array(
	array('label'=>'Create tblproducto','url'=>array('create')),
	array('label'=>'Manage tblproducto','url'=>array('admin')),
);
?>

<h1>Tblproductos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
