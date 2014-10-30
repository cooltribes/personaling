<?php
/* @var $this ShoppingMetricController */
/* @var $model ShoppingMetric */

$this->breadcrumbs=array(
	'Shopping Metrics',
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
   <div class="page-header">
    <h1>Shopping Metrics</small></h1>
  </div>

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
  
  <?php #$this->renderPartial('_filters'); ?>
  <hr/>

<?php /*$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'shopping-metric-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'user_id',
		'step',
		'created_on',
		'tipo_compra',
		'HTTP_USER_AGENT',

		array(
			'class'=>'CButtonColumn',
		),
	),
)); */

$template = '{summary}
  <table id="table" width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
    <tr>
      
      <th rowspan="2" scope="col">Look</th>
      <th rowspan="2" scope="col">Noombre del Look</th>
      <th rowspan="2" scope="col">id  de Referido</th>
      <th rowspan="2" scope="col">Nombre del Referido</th>
     <th rowspan="2" scope="col">Nasdasdasd</th>
      <th rowspan="2" scope="col">Ventas '.Yii::t('contentForm','currSym').'</th>
      <th rowspan="2" scope="col">Estado</th>
      <th rowspan="2" scope="col">Fecha de Carga</th>
      <th rowspan="2" scope="col">Progreso de la campaña</th>
      <th rowspan="2" scope="col">Acción</th>
      <th rowspan="2" scope="col">Acción</th>
      <th rowspan="2" scope="col">Acción</th>
    </tr>
    <tr>
      
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
	    'emptyText'=>Yii::t('contentForm','There are not any results to show'),

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
