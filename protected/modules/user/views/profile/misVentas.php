<?php

$this->pageTitle=Yii::app()->name . ' - Productos Vendidos';

//$this->breadcrumbs=array(
//	'Productos',
//);
$pagerParams = array(
    'header' => '',
    'prevPageLabel' => Yii::t('contentForm', 'Previous'),
    'nextPageLabel' => Yii::t('contentForm', 'Next'),
    'firstPageLabel' => Yii::t('contentForm', 'First'),
    'lastPageLabel' => Yii::t('contentForm', 'Last'),
    'htmlOptions' => array(
        'class' => 'pagination pagination-right'))
?>

<div class="container margin_top">
    <div class="page-header">
        <h1>Productos Vendidos - Personal Shopper</h1>       
    </div>
    <div class="row">
        <div class="span12 box_shadow bg_color13">
            <div class="row"> 
                <!--Imagen-->
                <div class="span2">
                    <?php echo CHtml::image($personalShopper->getAvatar(), 
                        'Foto', array("width" => "200", "height" => "200")); ?>

                </div>
                <!--Datos-->
                <div class="span3 padding_top_medium">
                    <h2>
                        <?php echo $personalShopper->profile->first_name .
                        " " . $personalShopper->profile->last_name;
                        ?>
                    </h2>
                    <h4>Comisión actual:
                        <strong>
                            <?php echo $personalShopper->getComision(); ?>                            
                        </strong>
                    </h4>
                    <h4>Saldo en comisiones:
                        <strong>
                            <?php echo $personalShopper->getSaldoPorComisiones()." ".Yii::t('backEnd', 'currSym'); ?>                            
                        </strong>
                    </h4>
                </div>
                <!--Totales-->
                <div class="span7 padding_top_medium margin_top_medium text_align_center">                    
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">                        
                        <tr>
                            <td class="td-relative"><p class="T_xlarge margin_top_xsmall">
                                    <?php
                                    echo $personalShopper->getProductosVendidos();
                                    ?>
                                </p>
                                Productos vendidos
                            </td>
                            <td class="td-relative"><p class="T_xlarge margin_top_xsmall text-error">
                                    <?php
                                    echo 0;
                                    ?>
                                </p>
                                Looks vendidos
                            </td>
                            <td class="td-relative"><p class="T_xlarge margin_top_xsmall text-error"> 
                                    <?php
                                    echo 0;
                                    ?>
                                </p>
                                Otros
                            </td>
                            <td class="td-relative"><p class="T_xlarge margin_top_xsmall text-error">
                                    <?php
                                   echo 0;
                                    ?>
                                </p>
                                Otros más
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>

<!--    <div class="row margin_top margin_bottom ">
        <div class="span4">
            <div class="input-prepend">
                <form class="no_margin_bottom form-search">
                    <input type="text" name="query" id="query" class="span3">
                    <a class="btn" id="btn_search_event">Buscar</a>
                </form>

                <?php
                Yii::app()->clientScript->registerScript('query1', "var ajaxUpdateTimeout;
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
		});", CClientScript::POS_READY
                );

                // Codigo para actualizar el list view cuando presionen ENTER

                Yii::app()->clientScript->registerScript('query', "var ajaxUpdateTimeout;
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
		});", CClientScript::POS_READY
                );
                ?>	

            </div>
        </div>
        <div class="span3">   

            <?php echo CHtml::dropDownList("Filtros", "", Chtml::listData(Filter::model()->findAll('type = 2'), "id_filter", "name"), array('empty' => '-- Filtros Preestablecidos --', 'id' => 'all_filters'))
            ?>

        </div>
        <div class="span2"><a href="#" class="btn crear-filtro">Crear nuevo filtro</a></div>
        <div class="span1">
           	
        </div>
        <div class="span2">

        </div>
    </div>-->
    <hr/>

    <?php //$this->renderPartial('_filters');    ?>
    <hr/>
    <?php
    $template = '{summary}
  <table id="table" width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
    <tr>
     
      <th rowspan="2" scope="col" colspan="2" style="width:30%;">Producto</th>
      <th rowspan="2" scope="col">Look</th>      
      <th rowspan="2" scope="col">Fecha de Venta</th>
      <th rowspan="2" scope="col" style="text-align:center">Precio de Venta ('.Yii::t('backEnd', 'currSym').')</th>
      <th colspan="3" scope="col" style="text-align:center">Vendido</th>
      <th rowspan="2" scope="col">Total ('.Yii::t('backEnd', 'currSym').')</th>
      <th rowspan="2" scope="col">Comisión<br>aplicada</th>
      <th rowspan="2" scope="col">Monto<br>Ganado ('.Yii::t('backEnd', 'currSym').')</th>
      
    </tr>
    <tr>
      <th scope="col">Talla</th>
      <th scope="col">Color</th>
      <th scope="col">Cant.</th>
    </tr>
    {items}
    </table>
    {pager}
	';

    $this->widget('zii.widgets.CListView', array(
        'id' => 'list-auth-items',
        'dataProvider' => $dataProvider,
        'itemView' => '_viewProducto',
        'template' => $template,
        'summaryText' => "Mostrando {start} - {end} de {count} Resultados",
        'enableSorting' => 'true',
        'afterAjaxUpdate' => " function(id, data) {
						    	
							$('#todos').click(function() { 
				            	inputs = $('table').find('input').filter('[type=checkbox]');
				 
				 				if($(this).attr('checked')){
				                     inputs.attr('checked', true);
				               	}else {
				                     inputs.attr('checked', false);
				               	} 	
							});
						   
							} ",
        'pager' => $pagerParams,
    ));
    ?>

    <hr/>
<!--    <div class="row">
        <div class="span3">
            <select class="span3" id="accion">
                <option id="accion">Acciones</option>
                <option>Activar</option>
                <option>Inactivar</option>
                <option>Borrar</option>
            </select>
        </div>

        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'ajaxButton',
            'type' => 'danger',
            'label' => 'Procesar',
            'url' => array('producto/varias'),
            'htmlOptions' => array('id' => 'procesar', 'class' => 'span0.5'),
            'ajaxOptions' => array(
                'type' => 'POST',
                'beforeSend' => "function( request )
			{
				 var checkValues = $(':checkbox:checked').map(function() {
			        return this.id;
			    }).get().join();
				
				var uno = $('#accion').val();
			
			this.data += '&accion='+uno+'&check='+checkValues;
			}",
                'data' => array('a' => '5'),
                'success' => "function(data){
				
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
        ));
        ?>

        <div class="span2"><a href="#" title="Exportar a excel" class="btn btn-info">Exportar a excel</a></div>
    </div>	  -->

</div>
<?php

function compara_fechas($fecha1, $fecha2) {
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/", $fecha1))
        list($dia1, $mes1, $año1) = explode("/", $fecha1);
    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/", $fecha1))
        list($dia1, $mes1, $año1) = explode("-", $fecha1);
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/", $fecha2))
        list($dia2, $mes2, $año2) = explode("/", $fecha2);
    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/", $fecha2))
        list($dia2, $mes2, $año2) = explode("-", $fecha2);
    $dif = mktime(0, 0, 0, $mes1, $dia1, $año1) - mktime(0, 0, 0, $mes2, $dia2, $año2);
    return ($dif);
}
?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'myModal', 'htmlOptions' => array('class' => 'modal hide fade', 'tabindex' => '-1', 'role' => 'dialog', 'aria-labelleby' => 'myModalLabel', 'aria-hidden' => 'true'))); ?>

<?php $this->endWidget(); ?>

<script type="text/javascript">

    $(document).ready(function() {

        $("#todos").click(function() {

            inputs = $('table').find('input').filter('[type=checkbox]');

            if ($(this).attr("checked")) {
                inputs.attr('checked', true);
            } else {
                inputs.attr('checked', false);
            }
        });

        var selected = new Array();
    });

</script>	