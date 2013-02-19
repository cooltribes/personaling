<?php
$this->breadcrumbs=array(
	'Tallas',
);

$this->menu=array(
	array('label'=>'Create Talla','url'=>array('create')),
	array('label'=>'Manage Talla','url'=>array('admin')),
);
?>

<h1>Tallas</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
