<?php
$this->breadcrumbs=array(
	'Productos',
);
$pagerParams=array(
			'header'=>'',
			'prevPageLabel' => Yii::t('contentForm','Previous'),
			'nextPageLabel' => Yii::t('contentForm','Next'),
			'firstPageLabel'=> Yii::t('contentForm','First'),
			'lastPageLabel'=> Yii::t('contentForm','Last'),
			'htmlOptions'=>array(
				'class'=>'pagination pagination-right'))
?>

<div class="container margin_top">
	<!-- FLASH ON -->
  <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )
); ?>
  <!-- FLASH OFF -->
  <div class="page-header">
    <h1>Administrar Productos</small></h1>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table ">
    <tr>
      <th scope="col" colspan="6"> Totales </th>
    </tr>
    <tr>
      <td><p class="T_xlarge margin_top_xsmall">
<?php
/*
$sql = "select count( * ) as total from tbl_producto where status=1";
$num = Yii::app()->db->createCommand($sql)->queryScalar();
// echo $num;
*/

echo Producto::model()->countByAttributes(array('status'=>1));

?>
		</p>
        Totales</td>
      <td><p class="T_xlarge margin_top_xsmall">
<?php
/*
$sql = "select count( * ) as total from tbl_producto where estado=0 and status=1";
$num = Yii::app()->db->createCommand($sql)->queryScalar();
//echo $num;
*/

echo Producto::model()->countByAttributes(array('estado'=>0,'status'=>1));
?>
      	</p>
        Activos</td>
      <td><p class="T_xlarge margin_top_xsmall"> 
<?php
/*
$sql = "select count( * ) as total from tbl_producto where estado=1 and status=1";
$num = Yii::app()->db->createCommand($sql)->queryScalar();
//echo $num;
*/

echo Producto::model()->countByAttributes(array('estado'=>1,'status'=>1));
?>
		</p>
        Inactivos</td>
      <td><p class="T_xlarge margin_top_xsmall">
      	
<?php
$sql = "select count(cantidad) from tbl_orden_has_productotallacolor a, tbl_orden b where a.tbl_orden_id = b.id and b.estado = 4"; // estado 4 es enviado
$num = Yii::app()->db->createCommand($sql)->queryScalar();
echo $num;
?>     	
      	 	
      </p>
        Enviados</td>
<!--       <td><p class="T_xlarge margin_top_xsmall"> 1120</p>
        En tránsito </td> -->
      <td><p class="T_xlarge margin_top_xsmall"> <?php echo Producto::model()->getDevueltos(); ?> </p>
        Devueltos</td>
    </tr>
  </table>
  <hr/>
  
    <div class="row margin_top margin_bottom ">
	    <div class="span3">
	    <form class="no_margin_bottom form-search">
	     	<div class="input-append">
	    		<input type="text" name="query" id="query" class="span2">
	    		<a class="btn" id="btn_search_event">Buscar</a>
	    	</div>
		</form>
				
		<?php
		Yii::app()->clientScript->registerScript('query1',
			"var ajaxUpdateTimeout;
			var ajaxRequest;
			$('#btn_search_event').click(function(){
				$('.crear-filtro').click();
				ajaxRequest = $('#query').serialize();
				clearTimeout(ajaxUpdateTimeout);
				
				ajaxUpdateTimeout = setTimeout(function () {
					$.fn.yiiListView.update(
					'list-auth-items',
					{
					type: 'POST',	
					url: '" . CController::createUrl('producto/admin') . "',
					data: ajaxRequest}
					
					)
					},
			
			300);
			return false;
			});",CClientScript::POS_READY
		);
		
		// Codigo para actualizar el list view cuando presionen ENTER
		
		Yii::app()->clientScript->registerScript('query',
			"var ajaxUpdateTimeout;
			var ajaxRequest; 
			
			$(document).keypress(function(e) {
			    if(e.which == 13) {
	                    $('.crear-filtro').click();
			        ajaxRequest = $('#query').serialize();
					clearTimeout(ajaxUpdateTimeout);
					
					ajaxUpdateTimeout = setTimeout(function () {
						$.fn.yiiListView.update(
						'list-auth-items',
						{
						type: 'POST',	
						url: '" . CController::createUrl('producto/admin') . "',
						data: ajaxRequest}
						
						)
						},
				
				300);
				return false;
			    }
			});",CClientScript::POS_READY
		);	
		
		?>	
		
		</div>
	    <div class="span3">   
	        
	        <?php echo CHtml::dropDownList("Filtros", "", Chtml::listData(Filter::model()->findAll('type = 2'),
	                "id_filter", "name"), array('empty' => '-- Búsquedas avanzadas --', 'id' => 'all_filters')) ?>

	    </div>
    	<div class="span3"><a href="#" class="btn crear-filtro">Crear búsqueda avanzada</a></div>
	    <div class="span1">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'buttonType' => 'link',
		    'label'=>'Importar',
		    'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		    'size'=>'normal', // null, 'large', 'small' or 'mini'
		    'url' => 'importar',
		)); ?>    	
	    </div>
	    <div class="span2">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'buttonType' => 'link',
		    'label'=>'Añadir producto',
		    'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		    'size'=>'normal', // null, 'large', 'small' or 'mini'
		    'url' => 'create',
		)); ?>
	    </div>

    </div>
  </div>

  <hr/>
  
  <?php $this->renderPartial('_filters'); ?>
  <hr/>
<?php
$template = '{summary}
  <table id="table" width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
    <tr>
      <th rowspan="2" scope="col"><input name="check" type="checkbox" id="todos"></th>
      <th rowspan="2" scope="col">Producto</th>
      <th rowspan="2" scope="col">Referencia</th>
      <th rowspan="2" scope="col">Categoría</th>
      <th rowspan="2" scope="col">Precio ('.Yii::t('contentForm','currSym').')</th>
      <th colspan="3" scope="col">Cantidad</th>
      <th rowspan="2" scope="col">Ventas '.Yii::t('contentForm','currSym').'</th>
      <th rowspan="2" scope="col">Estado</th>
      <th rowspan="2" scope="col">Fecha de Carga</th>
      <th rowspan="2" scope="col">Progreso de la campaña</th>
      <th rowspan="2" scope="col">Acción</th>
    </tr>
    <tr>
      <th scope="col">Total</th>
      <th scope="col">Disp.</th>
      <th scope="col">Vendido</th>
    </tr>
    {items}
    </table>
    {pager}
	';

		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_authitem',
	    'template'=>$template,
	    'summaryText' => "Mostrando {start} - {end} de {count} Resultados",

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
		'pager'=>$pagerParams,					
	));    
	?>

	  <hr/>
  <div class="row">
    <div class="span3">
      <select class="span3" id="accion">
        <option id="accion">Acciones</option>
        <option>Activar</option>
        <option>Inactivar</option>
        <option>Borrar</option>
        <option>Descuentos</option>
        <option>Outlet</option>
      </select>
    </div>

		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'ajaxButton',
			'type'=>'danger',
			'label'=>'Procesar',
			'url'=>array('producto/varias'),
			'htmlOptions'=>array('id'=>'procesar','class'=>'span0.5'),
			'ajaxOptions'=>array(
			'type' => 'POST',
			'dataType' => 'json',
			'beforeSend' => "function( request )
			{
				 var checkValues = $(':checkbox:checked').map(function() {
			        return this.id;
			    }).get().join();
				
				var uno = $('#accion').val();
			
			this.data += '&accion='+uno+'&check='+checkValues;
			}",
			
			'data'=>array('a'=>'5'),
			'success'=>"function(data){
				console.log(data);
				if(data.status==1)
					alert('No ha seleccionado ningún producto.');
				
				if(data.status==2)
					alert('No ha seleccionado ninguna acción.');
					
					
				if(data.status==3 || data.status==4){
					
						ajaxUpdateTimeout = setTimeout(function () {
						$.fn.yiiListView.update(
						'list-auth-items',
						{
						type: 'POST',	
						url: '" . CController::createUrl('producto/admin') . "',
						data: ajaxRequest}
						
						)
						},0);
					alert('Los productos han sido actualizados');
					}
				
				if(data.status==5)
				{
					ajaxUpdateTimeout = setTimeout(function () {
						$.fn.yiiListView.update(
						'list-auth-items',
						{
						type: 'POST',	
						url: '" . CController::createUrl('producto/admin') . "',
						data: ajaxRequest}
						
						)
						},0);
				}

				if(data.status==6)
				{
					$('#myModal').html(data.html);
					$('#myModal').modal();
				}

				if(data.status==7)
				{
					$('#myModal').html(data.html);
					$('#myModal').modal();
				}
				
			}",
			),
			)); ?>

    <div class="span2"><a href="exportarExcel" title="Exportar a excel" class="btn btn-info">Exportar a excel</a></div>
    <div class="span3"><a href="plantillaDescuentos" title="Exportar plantilla" class="btn btn-success">
            <i class="icon icon-download icon-white"></i> Descargar planilla de precios</a></div>
    
  </div>	  
		  
  </div>
<?php
function compara_fechas($fecha1,$fecha2)
{
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha1))
              list($dia1,$mes1,$año1)=explode("/",$fecha1);
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha1))
              list($dia1,$mes1,$año1)=explode("-",$fecha1);
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha2))
              list($dia2,$mes2,$año2)=explode("/",$fecha2);
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha2))
              list($dia2,$mes2,$año2)=explode("-",$fecha2);
        $dif = mktime(0,0,0,$mes1,$dia1,$año1) - mktime(0,0,0, $mes2,$dia2,$año2); 
        return ($dif);
}
?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal','htmlOptions'=>array('class'=>'modal hide fade','tabindex'=>'-1','role'=>'dialog','aria-labelleby'=>'myModalLabel','aria-hidden'=>'true'))); ?>

<?php $this->endWidget(); ?>

<script type="text/javascript">

$(document).ready(function(){
	
            $("#todos").click(function() { 
            	
               inputs = $('table').find('input').filter('[type=checkbox]');
 
               if($(this).attr("checked")){
                     inputs.attr('checked', true);
               }else {
                     inputs.attr('checked', false);
               } 	
		});
       
                var selected = new Array();                   
});

function validar_descuento(){
	if($('#tipo').val() == 'monto'){
		if($.isNumeric($('#valor').val())){
			$('#error').hide();
		}else{
			$('#error').html('Valor no válido');
			$('#error').show();
			return false;
		}
	}else{ // el descuento es porcentaje
		if($.isNumeric($('#valor').val())){
			if($('#valor').val() <= 100 && $('#valor').val() > 0){
				$('#error').hide();
			}else{
				$('#error').html('Porcentaje debe estar entre 1 y 100');
				$('#error').show();
				return false;
			}
		}else{
			$('#error').html('Valor no válido');
			$('#error').show();
			return false;
		}
	}
	$('#descuento-form').submit();
}
  
</script>