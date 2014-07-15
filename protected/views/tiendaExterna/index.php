<?php
/* @var $this TiendaExternaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tiendas',
);

$this->menu=array(
	array('label'=>'Create Tienda', 'url'=>array('create')),
	array('label'=>'Manage Tienda', 'url'=>array('admin')),
);
?>

<h1>Tiendas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
