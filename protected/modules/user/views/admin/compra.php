<?php
/* $this->breadcrumbs=array(
	'Compra',
);
*/
?> 

<div class="container margin_top">
  <div class="page-header">
    <h1>Generar Orden de Compra</small></h1>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table ">
    <tr>
      <th scope="col" colspan="6"> Totales </th>
    </tr>
    <tr>
      <td><p class="T_xlarge margin_top_xsmall">
<?php

echo Producto::model()->countByAttributes(array('status'=>1));

?>
		</p>
        Totales</td>
      <td><p class="T_xlarge margin_top_xsmall">
<?php


echo Producto::model()->countByAttributes(array('estado'=>0,'status'=>1));
?>
      	</p>
        Activos</td>
      <td><p class="T_xlarge margin_top_xsmall"> 
<?php


echo Producto::model()->countByAttributes(array('estado'=>1,'status'=>1));
?>
		</p>
        Inactivos</td>
      <td><p class="T_xlarge margin_top_xsmall">
      	
<?php
$sql = "select sum(cantidad) from tbl_orden_has_productotallacolor a, tbl_orden b where a.tbl_orden_id = b.id and b.estado = 4"; // estado 4 es enviado
$num = Yii::app()->db->createCommand($sql)->queryScalar();
echo $num;
?>     	
      	 	
      </p>
        Enviados</td>
      <td><p class="T_xlarge margin_top_xsmall"> 1120</p>
        En tránsito </td>
      <td><p class="T_xlarge margin_top_xsmall"> 182 </p>
        Devueltos</td>
    </tr>
  </table>
  <hr/>
  
    <div class="row margin_top margin_bottom ">
    <div class="span12">
   
    <form class="no_margin_bottom form-search">
    <input type="text" name="query" id="query" class="span3">
    <a class="btn" id="btn_search_event">Buscar</a>
	</form>
		
	<?php
	Yii::app()->clientScript->registerScript('query1',
		"var ajaxUpdateTimeout;
		var ajaxRequest;
		$('#btn_search_event').click(function(){
			
			ajaxRequest = $('#query').serialize();
			clearTimeout(ajaxUpdateTimeout);
			
			ajaxUpdateTimeout = setTimeout(function () {
				$.fn.yiiListView.update(
				'list-auth-items',
				{
				type: 'POST',	
				url: '" . CController::createUrl('admin/compra/id/'.Yii::app()->session['usercompra']) . "',
				data: ajaxRequest}
				
				)
				},
		
		300);
		return false;
		});",CClientScript::POS_READY
	);
	
	
	$template = '{summary}
			  <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered ta table-hover table-striped">
			  <thead>
			    <tr>
			      
			      <th>Imagen</th>
                    <th>Descripcion</th>
                    <th>Marca</th>
                    <th>Color</th>
                    <th>Talla</th>
                    <th>Precio</th>
                    <th>Disponibles</th>
                    <th>CANTIDAD A AGREGAR</th>
                </tr>
			    </thead>
			    <tbody>
			    {items}
				</tbody>
			    </table>
			    {pager}
				';


		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_item',
	    'template'=>$template
	 					
	));




	
	// Codigo para actualizar el list view cuando presionen ENTER
	
	Yii::app()->clientScript->registerScript('query',
		"var ajaxUpdateTimeout;
		var ajaxRequest; 
		
		$(document).keypress(function(e) {
		    if(e.which == 13) {
		        ajaxRequest = $('#query').serialize();
				clearTimeout(ajaxUpdateTimeout);
				
				ajaxUpdateTimeout = setTimeout(function () {
					$.fn.yiiListView.update(
					'list-auth-items',
					{
					type: 'POST',	
					url: '" . CController::createUrl('admin/compra/id/'.Yii::app()->session['usercompra']) . "',
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
                "id_filter", "name"), array('empty' => '-- Filtros Preestablecidos --', 'id' => 'all_filters')) ?>

    </div>
    <div class="span2"><a href="#" class="btn">Crear nuevo filtro</a></div>
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
      <th rowspan="2" scope="col">Precio (Bs.)</th>
      <th colspan="3" scope="col">Cantidad</th>
      <th rowspan="2" scope="col">Ventas Bs.</th>
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
    
	?>

	  <hr/>
  <div class="row">
    <div class="span3">
      <select class="span3" id="accion">
        <option id="accion">Acciones</option>
        <option>Activar</option>
        <option>Inactivar</option>
        <option>Borrar</option>
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
				
				if(data==1)
					alert('No ha seleccionado ningún producto.');
				
				if(data==2)
					alert('No ha seleccionado ninguna acción.');
					
					
				if(data==3 || data==4){
					
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
				
				if(data==5)
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
				
			}",
			),
			)); ?>

    <div class="span2"><a href="#" title="Exportar a excel" class="btn btn-info">Exportar a excel</a></div>
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
	
	 $(".cant").onChange(function() { 
            if(isNaN($(this).val())){ 
            	$(this).val(''); 
            	alert('BAH');}
            	else{alert('BEH');}
              	
		});
       
	
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
  
</script>	