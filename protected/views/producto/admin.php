<?php
$this->breadcrumbs=array(
	'Productos'=>array('index'),
	'Manage',
);
/*
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('producto-grid', {
		data: $(this).serialize()
	});
	return false;
});
");*/
?>

<?php // include('admin_header.php'); ?>
<div class="container margin_top">
  <div class="page-header">
    <h1>Administrar Productos</small></h1>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table ">
    <tr>
      <th scope="col" colspan="6"> Totales </th>
    </tr>
    <tr>
      <td><p class="T_xlarge margin_top_xsmall">120 </p>
        Totales</td>
      <td><p class="T_xlarge margin_top_xsmall"> 144 </p>
        Activos</td>
      <td><p class="T_xlarge margin_top_xsmall"> 156</p>
        Inactivos</td>
      <td><p class="T_xlarge margin_top_xsmall">150</p>
        Enviados</td>
      <td><p class="T_xlarge margin_top_xsmall"> 1120</p>
        En tránsito </td>
      <td><p class="T_xlarge margin_top_xsmall"> 182 </p>
        Devueltos</td>
    </tr>
  </table>
  <hr/>
  
    <div class="row margin_top margin_bottom ">
    <div class="span4">
      <div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>
		<?php echo CHtml::textField('Buscar','Buscar', array('id'=>'prependedInput','class'=>'span3')); //<input class="span3" id="prependedInput" type="text" placeholder="Buscar"> ?>
	</div>
    </div>
    <div class="span3">

       <?php $select=''; echo CHtml::dropDownList('listname', $select, 
              array('M' => 'Male', 'F' => 'Female'),
              array('empty' => '(Filtros Preestablecidos)')); 
              array('class'=>'span3')?>

    </div>
    <div class="span3"><a href="#" class="btn">Crear nuevo filtro</a></div>
    <div class="span2"><a href="#" class="btn btn-success">Añadir producto</a></div>
  </div>
  <hr/>
  
  </div>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'producto-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		'codigo',
		'estado',
		'descripcion',
		'proveedor',
		'fInicio',
		'fFin',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
