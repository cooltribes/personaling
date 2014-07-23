<?php
/* @var $this OrdenController */
//$this->breadcrumbs=array(
//	'Pedidos',
//);        
?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Administrar Pedidos</h1>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table ">
    <tr>
      <th scope="col" colspan="7"> Totales </th>
    </tr>
    <tr>
      <td><p class="T_xlarge margin_top_xsmall">
      	
      	<?php
        $sql = "select count( * ) as total from tbl_orden";
        $num = Yii::app()->db->createCommand($sql)->queryScalar();
        echo $num;
        ?>
      </p>
        Totales</td>
      <td>
        <p class="T_xlarge margin_top_xsmall"> 
            <?php
                echo $orden->countxEstado(1);
            ?>    	 
        </p>
        En espera de pago
      </td>
      <td>
        <p class="T_xlarge margin_top_xsmall"> 
            <?php
            echo $orden->countxEstado(5);
            ?>    	 
        </p>
        Cancelados
      </td>
      <td><p class="T_xlarge margin_top_xsmall">
      	      	<?php
                $sql = "SELECT count( * ) as total FROM tbl_orden where estado=2";
                $num = Yii::app()->db->createCommand($sql)->queryScalar();
                echo $num;
                ?> 
      </p>
        Esperando<br/>
        Confirmación</td>
      <td><p class="T_xlarge margin_top_xsmall">
	<?php
	echo $orden->countxEstado(3);
	?>
	</p>
        Pago Confirmado</td>
      
      <td><p class="T_xlarge margin_top_xsmall"> <?php echo $orden->countxEstado(7);?> </p>
        Pago Insuficiente </td>
        <?php
        
        ?>
      <td><p class="T_xlarge margin_top_xsmall"> <?php echo $orden->countxEstado(4); ?> </p>
        Enviados </td>
        <?php
        
        ?>
      <td><p class="T_xlarge margin_top_xsmall"> <?php echo $orden->countxEstado(8); ?>  </p>
        Recibidos</td>
      <td><p class="T_xlarge margin_top_xsmall">  <?php echo Orden::model()->getDevueltas(); ?>  </p>
        Devuelto</td>
    </tr>
  </table>
  <hr/>
  <div class="row margin_top margin_bottom ">
    <div class="span4">
    	
    	<form class="no_margin_bottom form-search">
       		<div class="input-append"> 
				<input class="span3" id="query" name="query" type="text" placeholder="Buscar por palabras clave">
       			<a href="#" class="btn" id="btn_search_event">Buscar</a>
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
                        url: '" . CController::createUrl('orden/admin') . "',
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
                            url: '" . CController::createUrl('orden/admin') . "',
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
        <?php echo CHtml::dropDownList("Filtros", "", Chtml::listData(Filter::model()->findAll('type = 1'),
                "id_filter", "name"), array('empty' => '-- Búsquedas avanzadas --', 'id' => 'all_filters')) ?>
<!--      <select class="span3">
        <option>Filtros preestablecidos</option>
        <option>Filtro 1</option>
        <option>Filtro 2</option>
        <option>Filtro 3</option>
      </select>-->
    </div>
    <div class="span3">
      <a href="#" class="btn crear-filtro" title="Crear nuevo filtro">Crear búsqueda avanzada</a>
    </div>
  </div>
  <hr/>
  <?php $this->renderPartial('_filters'); ?>
  <hr/>
  <style>
      .table tbody tr.success td {
          background-color: #dff0d8;
      }
  </style>
  <?php
  
$template = '{summary}
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
    <tr>
      <th scope="col"><input type="checkbox"></th>
      <th scope="col">ID del pedido</th>
      <th scope="col">Usuaria</th>
      <th scope="col">Fecha de Compra</th>
      <th scope="col">Looks</th>
      <th scope="col" title="Prendas Individuales">P. I.</th>
      <th scope="col" title="Prendas Totales">P. T.</th>
      <th scope="col">Monto ('.Yii::t('contentForm','currSym').')</th>
      <th scope="col">Método de pago</th>
      <th scope="col">Estado</th>
      <th scope="col">Estado LF</th>
      <th scope="col">Acciones</th>
    </tr>
    {items}
    </table>
    {pager}
	';
	
	$pagerParams=array(
            'header'=>'',
            'prevPageLabel' => Yii::t('contentForm','Previous'),
            'nextPageLabel' => Yii::t('contentForm','Next'),
            'firstPageLabel'=> Yii::t('contentForm','First'),
            'lastPageLabel'=> Yii::t('contentForm','Last'),
            'htmlOptions'=>array(
                'class'=>'pagination pagination-right'));
	
    
  $this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_datos',
	    'template'=>$template,
      'summaryText' => "Mostrando {start} - {end} de {count} Resultados",
      'sorterHeader'=>'Ordenar Por:',
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
						   cancelarOrden();
							} ",
		'pager'=>$pagerParams,					
	));
	
	?>

  <hr/>
  <div class="row">
<!--    <div class="span3">
      <select class="span3">
        <option>Acciones en lote</option>
        <option>Activar</option>
        <option>Inactivar</option> 
        <option>Borrar usuarios</option>
      </select> 
    </div> 
    <div class="span1"><a href="#" title="Procesar" class="btn btn-danger">Procesar</a></div>-->
    
    
    <div class="span2">
        <a href="<?php echo Yii::app()->baseUrl."/orden/adminxls"?>" title="Exportar a excel"
           class="btn btn-block btn-info">Exportar a excel</a>
    </div>    
    
    <div class="span2"> 
	<?php $this->widget('bootstrap.widgets.TbButton', array( 
	    'buttonType' => 'link',
	    'label'=>'Importar envíos masivos', 
	    'type'=>'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	    'size'=>'normal', // null, 'large', 'small' or 'mini'
	    'block'=>'true',
	    'url' => 'importarmasivo',
	)); ?>    	
    </div>
    
    <div class="span3">
        <a href="<?php echo Yii::app()->baseUrl."/orden/createexcel" ?>" title="Generar Guías Masivas para Zoom" class="btn btn-info">Generar Guías Masivas para Zoom</a>
    </div>
    
    <div class="span2">
        <a href="<?php echo Yii::app()->baseUrl."/orden/reporteDetallado"?>" title="Exportar a excel" 
           class="btn btn-danger">Reporte Detallado</a>
    </div>

  </div>
</div>
<input id="hiddenMensaje" type="hidden">
<!-- /container --> 
<script type="text/javascript">
    
/*Para cancelar una orden*/
function cancelarOrden(){   

$("a[id^='linkCancelar']").click(function (e){
    
    console.log("NELSON");

    e.preventDefault();
    var urlCancel = $(this).attr('href');        

    bootbox.dialog("Cuéntanos por qué deseas cancelar este pedido...  \n\
        <br><br><textarea id='mensajeCancel'  maxlength='255' style='resize:none; width: 520px;' rows='4' cols='400'> ",
        [{
            "label" : "Continuar",
            "class" : "btn-danger",
            "callback": function() {
                $("#hiddenMensaje").val($("#mensajeCancel").val().trim());
                 var vect = urlCancel.split("cancelar/");
                $.ajax({
                    type: 'GET',
                    url: 'cancelar',
                    dataType: 'JSON',
                    data: {id: vect[1], mensaje: $("#hiddenMensaje").val(), admin: 1},
                    success: function(data){
                        console.log(data);
                        bootbox.alert(data.message);
                        if(data.status === 'success'){
                           ajaxUpdateTimeout = setTimeout(function () {
                           $.fn.yiiListView.update(
                                'list-auth-items',
                                {
                                    type: 'POST',	
                                    url: '<?php echo CController::createUrl('orden/admin')?>',
                                    data: ajaxRequest
                                }

                           )
                           },
                           300);
                           
                        }else if(data.status === 'error'){
                          
                        }
                        
                    }
                });

            }
        }]);

}); 
}    

function resolverOutbound(idOutbound){   
    bootbox.dialog("Indica como fue resuelta la discrepancia...  \n\
        <br><br><textarea id='mensajeResolver'  maxlength='255' style='resize:none; width: 520px;' rows='4' cols='400'> ",
        [{
            "label" : "Continuar",
            "class" : "btn-danger",
            "callback": function() {
                var mensaje = $("#mensajeResolver").val().trim();
                 ajaxRequest = $('#query').serialize();
                 
                $.ajax({
                    type: 'POST',
                    url: 'resolverOutbound',
                    dataType: 'JSON',
                    data: {idOutbound: idOutbound, observacion: mensaje},
                    success: function(data){        
                                 
                        bootbox.alert(data.message); 
                        
                        if(data.status === 'success'){                           
                            
                           ajaxUpdateTimeout = setTimeout(function () {
                           $.fn.yiiListView.update(
                                'list-auth-items',
                                {
                                    type: 'POST',	
                                    url: '<?php echo CController::createUrl('orden/admin')?>',
                                    data: ajaxRequest
                                }

                           )
                           },
                           300);
                           
                        }else if(data.status === 'error'){
                          
                        }
                        
                    }
                });

            }
        }]);
}

$(document).ready(function(){
    cancelarOrden();
});

</script>

