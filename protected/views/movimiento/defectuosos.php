<div class="row margin_top">
  <div class="page-header">
    <h1>Inventario de Productos Defectuosos</h1>
  </div>
<div>            
	<div class="row">
	<!--<div class="span1"><p>Filtrar:</p></div>-->
<?php 
	$list= CHtml::listData(Marca::model()->findAll(), 'id', 'nombre');
	$list[0]="Todas";
	
	
	  $pagerParams=array(
        'header'=>'',
        'prevPageLabel' => Yii::t('contentForm','Previous'),
        'nextPageLabel' => Yii::t('contentForm','Next'),
        'firstPageLabel'=> Yii::t('contentForm','First'),
        'lastPageLabel'=> Yii::t('contentForm','Last'),
        'htmlOptions'=>array(
            'class'=>'pagination pagination-right'));
	 
	echo '<div class="span2">'.CHtml::dropDownList('marcas', 'Todas', $list, array('empty' => 'Filtrar por marca', 'class'=>'')).'</div></div>';
	
	/*$template = '<br/><hr/>
				<div>
					<div class="row">
						<div  class="span3"> 
						{summary}
						</div>
						<div  class="span6 offset3"> 
						
					</div>
				</div>';*/
				
				
		$template = '<br/><hr/>
				<div>
					<div class="row">
						<div class="span3"> 
						{summary}
						</div>
						<div  class="span6 offset3"> 
						{sorter}
					</div>
				</div>
			 	 
			 	
			  <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered ta table-hover table-striped">
			  <thead>
			  <tr class="sorter"> 
					
			        <th><b>SKU<b/><br/>Referencia</th>
			        <!--
				 	<th><a class="color3 underline" href="'.Yii::app()->baseUrl.'/movimiento/defectuosos?data_sort=Marca">Marca</a></th>
                    <th><a class="color3 underline" href="'.Yii::app()->baseUrl.'/movimiento/defectuosos?data_sort=Nombre">Nombre</a></th>
                
                    <th><a class="color3 underline" href="'.Yii::app()->baseUrl.'/movimiento/defectuosos?data_sort=Color">Color</a></th>
                    <th><a class="color3 underline" href="'.Yii::app()->baseUrl.'/movimiento/defectuosos?data_sort=Talla">Talla</a></th>
                    <th><a class="color3 underline" href="'.Yii::app()->baseUrl.'/movimiento/defectuosos?data_sort=Costo">Costo ('.Yii::t('contentForm','currSym').')</a></th>
					<th><a class="color3 underline" href="'.Yii::app()->baseUrl.'/movimiento/defectuosos?data_sort=Cantidad">Cantidad</a></th>   
					<th><a class="color3 underline" href="'.Yii::app()->baseUrl.'/movimiento/defectuosos?data_sort=Usuario">Registrado por</a></th>  
					<th><a class="color3 underline" href="'.Yii::app()->baseUrl.'/movimiento/defectuosos?data_sort=Fecha">Fecha</a></th>
					<th><a class="color3 underline" href="'.Yii::app()->baseUrl.'/movimiento/defectuosos?data_sort=Procedencia">Procedencia</a></th>                       
                   -->
                   
                   <th>Marca</a></th>
                    <th>Nombre</a></th>
                
                    <th>Color</th>
                    <th>Talla</th>
                    <th>Costo ('.Yii::t('contentForm','currSym').')</th>
					<th>Cantidad</th>   
					<th>Registrado por</th>  
					<th>Fecha</th>
					<th>Procedencia</th>    

               
                </tr>
			    </thead>
			    <tbody>
			    {items}
				</tbody>
			    </table>
			   
			    {pager}
				</div>
				';
				
				
		
	Yii::app()->clientScript->registerScript('handle_ajax_function', "
			function porMarca()
			{
				
				
			}
			");



		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_datosDefectuosos',
	    'sorterHeader'=>'Ordenar por:',
	    'summaryText' => 'Mostrando {start} - {end} de {count} Resultados',
	    'template'=>$template,
	    'pager'=>$pagerParams,
	    //'enableSorting'=>true,
	    'afterAjaxUpdate'=>'porMarca',
	      'sortableAttributes'=>array(
                'Marca', 'Nombre', 'Color', 'Talla',  'Costo','Cantidad','Usuario','Procedencia'
   	),
	    
	    
	   
	 					
	));

	Yii::app()->clientScript->registerScript('marca',
		"var ajaxUpdateTimeout;
		var ajaxRequest;
	
		$('#marcas').change(function(){
			ajaxRequest = $('#marcas').serialize();
			marcaId = $('#marcas').val();
			clearTimeout(ajaxUpdateTimeout);
			
			
			ajaxUpdateTimeout = setTimeout(function () {
				$.fn.yiiListView.update(
				'list-auth-items',
				{
				type: 'POST',	
				url: '" . CController::createUrl('movimiento/defectuosos') . "',
				data: {ajaxRequest:ajaxRequest, marcaId:marcaId}}
				
				)
				},
		
		300);
		return false;
		});",CClientScript::POS_READY
	);
	
	

?>
<!-- <div class="margin_top pull-left"><a href="<?php echo Yii::app()->baseUrl."/movimiento/defectuososxls" ?>" title="Exportar a Excel" class="btn btn-info">Exportar a Excel</a></div>-->
</div>
</div>


<script>


	   
	   

      
	
	
</script>