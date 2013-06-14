<?php

$this->breadcrumbs=array(
	'Usuarios',
);


$usuarios_totales = User::model()->count();
$usuarios_activos = User::model()->countByAttributes(array('status'=>1));
$usuarios_inactivos = User::model()->countByAttributes(array('status'=>0));
$personal_shoppers = User::model()->countByAttributes(array('personal_shopper'=>1));
$usuarios_facebook = User::model()->count('facebook_id IS NOT NULL');
$usuarios_twitter = User::model()->count('twitter_id IS NOT NULL');

?>
<div class="container margin_top">
  <div class="page-header">
    <h1>Administrar usuarios</h1>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table ">
    <tr>
      <th scope="col" colspan="6"> Totales </th>
    </tr>
    <tr>
      <td><p class="T_xlarge margin_top_xsmall"><?php echo $usuarios_totales; ?></p>
        Usuarios Totales</td>
      <td><p class="T_xlarge margin_top_xsmall"><?php echo $usuarios_activos; ?></p>
        Usuarios Activos</td>
      <td><p class="T_xlarge margin_top_xsmall"><?php echo $usuarios_inactivos; ?></p>
        Usuarios Inactivos</td>
      <td><p class="T_xlarge margin_top_xsmall"><?php echo $personal_shoppers; ?></p>
        Personal Shoppers</td>
      <td><p class="T_xlarge margin_top_xsmall"><?php echo $usuarios_facebook; ?></p>
        Usuarios de Facebook </td>
      <td><p class="T_xlarge margin_top_xsmall"><?php echo $usuarios_twitter; ?> </p>
        Usuarios de Twitter</td>
    </tr>
  </table>
  <hr/>
  <div class="row margin_top margin_bottom ">
    <div class="span4">
      <div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>
        <input class="span3" id="prependedInput" type="text" placeholder="Buscar">
      </div>
    </div>
    <div class="span3">
      <select class="span3">
        <option>Filtros prestablecidos</option>
        <option>Filtro 1</option>
        <option>Filtro 2</option>
        <option>Filtro 3</option>
      </select>
    </div>
    <div class="span3"><a href="#" class="btn">Crear nuevo filtro</a></div>
    <div class="span2"><a href="#" class="btn btn-success">Crear usuario</a></div>
  </div>
    <hr/>
   <?php
$template = '{summary}
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
    <tr>
      <th rowspan="2" scope="col"><input name="Check" type="checkbox" value="Check"></th>
      <th colspan="3" rowspan="2" scope="col">Usuario</th>
      <th colspan="2" scope="col">Pedidos</th>
      <th rowspan="2" scope="col">Saldo Disponible</th>
      <th colspan="2" scope="col">Ingresos al Portal</th>
      <th rowspan="2" scope="col">Fecha de Registro</th>
      <th rowspan="2" scope="col"></th>
    </tr>
        <tr>
      <th scope="col">Pedidos</th>
      <th scope="col">Direcciones</th>
      <th scope="col">#</th>
      <th scope="col">Ultima Fecha</th>
    </tr>
    {items}
    </table>
    {pager}
	';

		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-user',
	    'dataProvider'=>$model->search(),
	    'itemView'=>'_view_user',
	    'template'=>$template,
/*	    'afterAjaxUpdate'=>" function(id, data) {
						    	
							$('#todos').click(function() { 
				            	inputs = $('table').find('input').filter('[type=checkbox]');
				 
				 				if($(this).attr('checked')){
				                     inputs.attr('checked', true);
				               	}else {
				                     inputs.attr('checked', false);
				               	} 	
							});
						   
							} ",
*/		'pager'=>array(
			'header'=>'',
			'htmlOptions'=>array(
			'class'=>'pagination pagination-right',
		)
		),					
	));    
	?> 
	
  <hr/>
   <div class="row">
   <div class="span3"><select class="span3">
        <option>Seleccionar usuarios</option>
        <option>Lorem</option>
        <option>Ipsum 2</option>
        <option>Lorem</option>
      </select></div>
      <div class="span1"><a href="#" title="procesar" class="btn btn-danger">Procesar</a></div>
      </div>
</div>
<!-- /container -->

