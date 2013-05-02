<?php
$this->breadcrumbs=array(
	'Categorías'
);
?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Administrar Categorías</small></h1>
  </div>
  <!-- SUBMENU ON -->
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span12">
    	<div class="clearfix">
    	<?php $this->widget('bootstrap.widgets.TbButton', array(
	    'buttonType' => 'link',
	    'label'=>'Agregar Categoría',
	    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	    'size'=>'normal', // null, 'large', 'small' or 'mini'
	    'url' =>'create',
	    'htmlOptions' => array('class'=>'btn pull-right margin_bottom_small'),
		)); ?>
    	</div>
   
  <?php
  
$template = '{summary}
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped ">
  <tr>
    <th scope="col">Nombre</th>
    <th scope="col">Categoría Padre</th>
    <th scope="col">Estado</th>
    <th scope="col">Descripción</th>
    <th scope="col">Acciones</th>
  </tr>
    {items}
    </table>
    {pager}
	';
    
  $this->widget('zii.widgets.CListView', array(
	    'id'=>'categoria-listado',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_datos',
	    'template'=>$template,
	    'enableSorting'=>'true',
	    'afterAjaxUpdate'=>" function(id, data) {
						    	
							$('#todos').click(function() { 
				            	inputs = $('table').find('input').filter('[type=checkbox]');
				 
				 				if($(this).attr('checked')){
				                     inputs.attr('checked', true);
				               	}else {
				                     inputs.attr('checked', false);
				               	} 	
							});
						   
							} ",
		'pager'=>array(
			'header'=>'',
			'htmlOptions'=>array(
			'class'=>'pagination pagination-right',
		)
		),					
	));
	
	?> 
    	
    </div>
    
  </div>
</div>
<!-- /container -->
