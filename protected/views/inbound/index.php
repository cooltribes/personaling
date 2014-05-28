<?php
$this->breadcrumbs=array(
	'Inbounds',
);

$this->menu=array(
	array('label'=>'Create Inbound','url'=>array('create')),
	array('label'=>'Manage Inbound','url'=>array('admin')),
);
?>

<h1>Inbounds</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
