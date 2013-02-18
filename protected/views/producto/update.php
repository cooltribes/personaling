<?php
$this->breadcrumbs=array(
	'Productos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Producto - Información General</small></h1>
  </div>
  <div class="navbar margin_top">
    <div class="navbar-inner">
      <ul class="nav">
        <li class="active"><a href="#">Información general</a></li>
        <li><a href="#">Precios</a></li>
        <li><a href="#">SEO</a></li>
        <li><a href="#">Imágenes</a></li>
        <li><a href="#">Categorías</a></li>
        <li><a href="#">Inventario</a></li>
        <li><a href="#">Envíos y Transporte</a></li>
        <li><a href="#">Ventas Cruzadas</a></li>
      </ul>
    </div>
  </div>
<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
</div>


