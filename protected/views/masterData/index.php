<?php
$this->breadcrumbs=array(
	'Master Datas',
);

$this->menu=array(
	array('label'=>'Create MasterData','url'=>array('create')),
	array('label'=>'Manage MasterData','url'=>array('admin')),
);
?>

<h1>Master Datas</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
