<?php
$this->breadcrumbs=array(
	'Productos'=>array('admin'),
	'Añadir',
);

?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Producto - Información General</small></h1>
  </div>

<?php echo $this->renderPartial('menu_agregar_producto', array('model'=>$model)); ?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>

