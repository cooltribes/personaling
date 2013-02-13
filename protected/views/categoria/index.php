<?php
$this->breadcrumbs=array(
	'Tblcategorias',
);

$this->menu=array(
	array('label'=>'Create tblcategoria','url'=>array('create')),
	array('label'=>'Manage tblcategoria','url'=>array('admin')),
);
?>

<h1>Tblcategorias</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
