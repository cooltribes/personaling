<?php
/* @var $this CampanaController */

$this->breadcrumbs=array(
	'Campañas',
);
?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Administrar Campañas</h1>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table ">
    <tr>
      <th scope="col" colspan="6"> Totales </th>
    </tr>
    <tr>
      <td><p class="T_xlarge margin_top_xsmall">120 </p>
        Totales</td>
      <td><p class="T_xlarge margin_top_xsmall"> 144 </p>
        Programada</td>
      <td><p class="T_xlarge margin_top_xsmall"> 156</p>
        Recepción</td>
      <td><p class="T_xlarge margin_top_xsmall">150</p>
        Revisión</td>
      <td><p class="T_xlarge margin_top_xsmall"> 1120</p>
        Ventas </td>
      <td><p class="T_xlarge margin_top_xsmall"> 182 </p>
        Finalizadas</td>
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
    <div class="span2"><a href="#" class="btn">Crear nuevo filtro</a></div>
    <div class="span3">
    	<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'buttonType' => 'link',
		    'label'=>'Crear nueva campaña',
		    'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		    'size'=>'normal', // null, 'large', 'small' or 'mini'
		    'url' => '/create',
		)); ?>
    </div>
  </div>
  <hr/>
  
  <?php
$template = '{summary}
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
    <tr>
      <th rowspan="2" scope="col">&nbsp;</th>
      <th rowspan="2" scope="col">ID</th>
      <th rowspan="2" scope="col">Campaña</th>
      <th rowspan="2" scope="col">Estado</th>
      <th colspan="2" scope="col" width="20%">Fecha de publicación</th>
      <th rowspan="2" scope="col">Items</th>
      <th colspan="2" scope="col">Looks</th>
      <th rowspan="2" scope="col">Personal Shoppers</th>
      <th rowspan="2" scope="col">Marcas</th>
      <th rowspan="2" scope="col">Ventas (Bs.)</th>
      <th rowspan="2" scope="col">Acción</th>
    </tr>
    <tr>
      <th scope="col">Inicio</th>
      <th scope="col">Fin</th>
      <th scope="col">Creados</th>
      <th scope="col">Aprobados</th>
    </tr>
    {items}
    </table>
    {pager}
	';

		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-campanas',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_view',
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
  
  <hr/>
  <div class="row">
    <div class="span3">
      <select class="span3">
        <option>Acciones en lote </option>
        <option>Borrar</option>
        <option>Pausar</option>
      </select>
    </div>
    <div class="span1"><a href="#" title="procesar" class="btn btn-danger">Procesar</a></div>
    <div class="span2"><a href="#" title="Exportar a excel" class="btn btn-info">Exportar a excel</a></div>
  </div>
</div>
<!-- /container --> 
<!------------------- MODAL WINDOW ON -----------------> 

<!-- Modal 1 -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Personal shoppers participantes</h3>
  </div>
  <div class="modal-body">
    <h4>Nombre de la campaña: "Junio lluvioso"</h4>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
      <tbody>
        <tr>
          <th colspan="1" scope="col">Avatar</th>
          <th colspan="1" scope="col" width="80%">E-mail</th>
        </tr>
        <tr>
          <td><img src="images/kitten.png" width="30" height="30" alt="avatar"></td>
          <td>Scott pilgrim</td>
        </tr>
        <tr>
          <td><img src="images/kitten.png" width="30" height="30" alt="avatar"></td>
          <td>Scott pilgrim</td>
        <tr>
          <td><img src="images/kitten.png" width="30" height="30" alt="avatar"></td>
          <td>Scott pilgrim</td>
      </tbody>
    </table>
  </div>
  <div class="modal-footer"> <a href="#" title="Cerrar" class="btn"  data-dismiss="modal"> cerrar</a> </div>
</div>

<!-- Modal 2 -->
<div id="myModal2" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Marcas participantes</h3>
  </div>
  <div class="modal-body">
    <h4>Nombre de la campaña: "Junio lluvioso"</h4>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
      <tbody>
        <tr>
          <th colspan="1" scope="col">Nombre</th>
          <th colspan="1" scope="col" width="80%">Logo</th>
        </tr>
        <tr>
          <td><img src="images/kitten.png" width="30" height="30" alt="avatar"></td>
          <td>Scott pilgrim</td>
        </tr>
        <tr>
          <td><img src="images/kitten.png" width="30" height="30" alt="avatar"></td>
          <td>Scott pilgrim</td>
        <tr>
          <td><img src="images/kitten.png" width="30" height="30" alt="avatar"></td>
          <td>Scott pilgrim</td>
      </tbody>
    </table>
  </div>
  <div class="modal-footer"> <a href="#" title="Cerrar" class="btn"  data-dismiss="modal"> cerrar</a> </div>
</div>

<!------------------- MODAL WINDOW OFF ----------------->

