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
  <?php 
  if(Yii::app()->user->hasFlash('success')){
  	?>
    <div class="alert alert-success text_align_center">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
  	<?php 
  } 
  ?>
  
  <?php 
  if(Yii::app()->user->hasFlash('error')){
  	?>
    <div class="alert alert-error text_align_center">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
  	<?php 
  } 
  ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table ">
    <tr>
      <th scope="col" colspan="6"> Totales </th>
    </tr>
    <?php
    $total = Campana::model()->count();
	$programadas = Campana::model()->countByAttributes(array('estado'=>1));
	$recepcion = Campana::model()->countByAttributes(array('estado'=>2));
	$revision = Campana::model()->countByAttributes(array('estado'=>3));
	$ventas = Campana::model()->countByAttributes(array('estado'=>4));
	$finalizadas = Campana::model()->countByAttributes(array('estado'=>5));
    ?>
    <tr>
      <td><p class="T_xlarge margin_top_xsmall"><?php echo $total; ?> </p>
        Totales</td>
      <td><p class="T_xlarge margin_top_xsmall"> <?php echo $programadas; ?> </p>
        Programadas</td>
      <td><p class="T_xlarge margin_top_xsmall"> <?php echo $recepcion; ?></p>
        Recepción</td>
      <td><p class="T_xlarge margin_top_xsmall"><?php echo $revision; ?></p>
        Revisión</td>
      <td><p class="T_xlarge margin_top_xsmall"> <?php echo $ventas; ?></p>
        Ventas </td>
      <td><p class="T_xlarge margin_top_xsmall"> <?php echo $finalizadas; ?> </p>
        Finalizadas</td>
    </tr>
  </table>
  <hr/>
  <div class="row margin_top margin_bottom ">
    <div class="span4">
    	<?php
    	echo CHtml::beginForm(CHtml::normalizeUrl(array('index')), 'get', array('id'=>'search-form'))
			. '<div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>'
		    . CHtml::textField('nombre', (isset($_GET['string'])) ? $_GET['string'] : '', array('id'=>'textbox_buscar', 'class'=>'span3', 'placeholder'=>'Buscar'))
		    . CHtml::endForm();
		?>
    	
    	

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
		    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		    'size'=>'normal', // null, 'large', 'small' or 'mini'
		    'url' => $this->createUrl('create'),
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
	/*    'enableSorting'=>'true',
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
*/		'pager'=>array(
			'header'=>'',
			'htmlOptions'=>array(
			'class'=>'pagination pagination-right',
		)
		),					
	));    
	
	
		Yii::app()->clientScript->registerScript('search',
	    "var ajaxUpdateTimeout;
	    var ajaxRequest;
	    $('#textbox_buscar').keyup(function(e){
	    	
			
			if(e.which != 13) {
				
				ajaxRequest = $(this).serialize();
	        clearTimeout(ajaxUpdateTimeout);
	        ajaxUpdateTimeout = setTimeout(function () {
	            $.fn.yiiListView.update(
	// this is the id of the CListView
	                'list-campanas',
	                {data: ajaxRequest}
	            )
	        },
	// this is the delay
	        300);
		        
		    }
	        	/*else{
	        		
	        		window.location.href = document.URL;
	        	}*/
				
				
				
	        
	    });"
	);
	
	
	
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
<div id="ps_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Personal shoppers participantes</h3>
  </div>
  <div class="modal-body" id="ps_modal_body">
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
  <div class="modal-footer"> <a href="#" title="Cerrar" class="btn"  data-dismiss="modal">Aceptar</a> </div>
</div>

<!-- Modal 2 -->
<div id="marca_modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Marcas participantes</h3>
  </div>
  <div class="modal-body" id="marca_modal_body">
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

<!------------------- MODAL WINDOW ON -----------------> 

<!-- Modal Ver Campaña -->
<div id="modalVer" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header" id="modalVerHeader">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Nombre Campaña</h3>
  </div>
  <div class="modal-body" id="modalVerBody">
 
 	<p>Resumen de la campaña:</p>
 

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
	  <tr>
	    <th scope="col">Descripción</th>
	    <th scope="col">Detalle</th>
	  </tr>
	  <tr>
	    <td>Recepción de los looks:</td>
	    <td>del 17/10/1985 al 17/10/2013</td>
	  </tr>
	  <tr>
	    <td>Actividad de la campaña:</td>
	    <td>del 17/10/1985 al 17/10/2013</td>
	  </tr>
	  <tr>
	    <td>Personal shopper invitados:</td>
	    <td>500</td>
	  </tr>
	</table>
  </div>
  <div class="modal-footer">  <a href="admin_anadir_campana.php" title="editar" class="btn"><i class="icon-edit"></i> Editar</a> <a href="admin_campanas.php" title="Salir" class="btn" target="_blank"> Salir al listado de campañas</a> </div>
</div>
<!------------------- MODAL WINDOW OFF ----------------->

<script>
	function ver_campana(id_campana){
		var path = location.pathname.split('/');
		$.ajax({
		      url: "/"+path[1]+"/campana/view",
		      type: "post",
		      data: { id : id_campana },
		      success: function(data){
		           $('#modalVer').html(data);
		           $('#modalVer').modal();
		      },
		});
	}
</script>