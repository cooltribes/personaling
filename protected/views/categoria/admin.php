<?php
$this->breadcrumbs=array(
	'Categorias'=>array('index'),
	'Administrador',
);

$this->menu=array(
	array('label'=>'List Categoria','url'=>array('index')),
	array('label'=>'Create Categoria','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('categoria-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Categorias</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'categoria-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'padreId',
		'nombre',
		'urlImagen',
		'mTitulo',
		'mDescripcion',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Administrar Categorías</small></h1>
  </div>
  <!-- SUBMENU ON -->
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span12">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped ">
  <tr>
    <th scope="col">Nombre</th>
    <th scope="col">Categoría Padre</th>
    <th scope="col">Estado</th>
    <th scope="col">Descripción</th>
    <th scope="col">Acciones</th>
  </tr>
  <tr>
    <td>Vestidos</td>
    <td>Ropa</td>
    <td>Activa</td>
    <td>Ropa Variada</td>
    <td>
     <a title="editar" href="admin_editar_categoria.php" class="btn">  <i class="icon-edit">  </i>  Editar</a>
      </td>
  </tr>
  <tr>
    <td>Plataformas</td>
    <td>Zapatos</td>
    <td>Activa</td>
    <td>Aqui se guardan los zapatos</td>
   <td>
     <a title="editar" href="admin_editar_categoria.php" class="btn">  <i class="icon-edit">  </i>  Editar</a>
      </td>  </tr>
  <tr>
    <td>Medias</td>
    <td>Accesorios</td>
    <td>Inactiva</td>
    <td>Son las medias</td>
   <td>
     <a title="editar" href="admin_editar_categoria.php" class="btn">  <i class="icon-edit">  </i>  Editar</a>
      </td>  </tr>
</table>
    </div>
    
  </div>
</div>
<!-- /container -->
