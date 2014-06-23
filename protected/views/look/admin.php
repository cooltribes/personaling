<?php

	$this->breadcrumbs=array(
		'Look',
	);	

?>
<?php if(Yii::app()->user->hasFlash('success')){?>
    <div class="alert in alert-block fade alert-success text_align_center">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php } ?>
<?php if(Yii::app()->user->hasFlash('error')){?>
    <div class="alert in alert-block fade alert-error text_align_center">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php } ?>
<div class="container margin_top">
    <div class="page-header">
        <h1>Administrar Looks</small></h1>
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table ">
        <tr>
            <th scope="col" colspan="6"> Totales </th>
        </tr>
        <tr>
            <td><p class="T_xlarge margin_top_xsmall"> <?php echo $look->getTotal(); ?> </p>
                Totales</td>
            <td><p class="T_xlarge margin_top_xsmall"> <?php echo $look->getAprovados(); ?> </p>
                Aprobados</td>
            <td><p class="T_xlarge margin_top_xsmall"> <?php echo $look->getPorAprovar(); ?> </p>
                Por Aprobar</td>
            <td><p class="T_xlarge margin_top_xsmall"> <?php echo $look->getPorEnviar(); ?></p>
                Por Enviar</td>
<!--             <td><p class="T_xlarge margin_top_xsmall"> <?php echo $look->getTotalxStatus(4); ?></p>
                Cancelados </td> -->
<!--             <td><p class="T_xlarge margin_top_xsmall"> <?php echo $look->getTotalxStatus(5); ?> </p>
                Devueltos</td> -->
        </tr>
    </table> 
    <hr/>
    <div class="row margin_top margin_bottom ">
        <div class="span4">
            <div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>
                <input class="span3" id="buscar_look" type="text" placeholder="Buscar">
            </div>
        </div>
  <?php
	Yii::app()->clientScript->registerScript('query',
		"var ajaxUpdateTimeout;
		var ajaxRequest; 
		
		$(document).keypress(function(e) {
		    if(e.which == 13) {
                    $('.crear-filtro').click();
		        ajaxRequest = $('#buscar_look').val();
				clearTimeout(ajaxUpdateTimeout);
				
				ajaxUpdateTimeout = setTimeout(function () {
					$.fn.yiiListView.update(
					'list-auth-items',
					{
					type: 'POST',	
					url: '" . CController::createUrl('look/admin') . "',
					data: {buscar_look:ajaxRequest}}
					
					)
					},
			
			300);
			return false;
		    }
		});",CClientScript::POS_READY
	);
	
?>        
        <div class="span3">
            <?php echo CHtml::dropDownList("Filtros", "", Chtml::listData(Filter::model()->findAll('type = 4'),
                "id_filter", "name"), array('empty' => '-- Búsquedas avanzadas --', 'id' => 'all_filters')) ?>
        </div>
        <div class="span3"><a href="#" class="btn crear-filtro">Crear búsqueda avanzada</a></div>
        <div class="span2">
        
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'link',
			'label'=>'Crear Look',
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
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
            <th scope="col"></th>
            <th colspan="2" scope="col">Look</th>
            <th scope="col">Precio ('.Yii::t('contentForm','currSym').')</th>
            <th scope="col">Vendidos</th>
            <th scope="col">Ventas ('.Yii::t('contentForm','currSym').')</th>
            <th scope="col">Estado</th>
            <th scope="col">Fecha de Carga</th>
            <th scope="col">Progreso de la campaña</th>
            <th scope="col">Acción</th>
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
	    'itemView'=>'_view_look',
	    'template'=>$template,
        'summaryText' => 'Mostrando {start} - {end} de {count} Resultados',        
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
            <a href="exportarExcel" title="Exportar a excel" class="btn btn-info">Exportar a excel</a>
        </div>
        
    </div>
</div>
<!-- /container --> 

<!------------------- MODAL WINDOW ON -----------------> 
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>
<?php $this->endWidget(); ?>

<!------------------- MODAL WINDOW OFF ----------------->

