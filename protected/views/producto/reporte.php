<div class="row margin_top">
  <div class="page-header">
    <h1>Reporte de Productos Vendidos</small></h1>
  </div>
<div>            
	<div class="row">
	<div class="span1"><p>Filtrar:</p></div>
<?php 
	$list= CHtml::listData(Marca::model()->findAll(), 'id', 'nombre');
	$list[0]="Todas";
	
	 
	echo '<div class="span2">'.CHtml::dropDownList('marcas', 'Todas', $list, array('empty' => 'Filtrar por marca', 'class'=>'')).'</div></div>';
	$template = '<br/><hr/>
				<div>
					<div class="row">
						<div  class="span3"> 
						{summary}
						</div>
						<div  class="span4 offset5"> 
						{sorter}
					</div>
				</div>
			 	 
			 	
			  <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered ta table-hover table-striped">
			  <thead>
			  <tr class="sorter"> 

			      <th><a href="'.Yii::app()->baseUrl.'/orden/reporte?data_sort=Marca">Marca</a></th>
                    <th><a href="'.Yii::app()->baseUrl.'/orden/reporte?data_sort=Nombre">Nombre</a></th>
                    <th>SKU</th>
                    <th><a href="'.Yii::app()->baseUrl.'/orden/reporte?data_sort=Color">Color</a></th>
                    <th><a href="'.Yii::app()->baseUrl.'/orden/reporte?data_sort=Talla">Talla</a></th>
                    <th>Cantidad</th>
                    <th><a href="'.Yii::app()->baseUrl.'/orden/reporte?data_sort=Costo">Costo (Bs)</a></th>
                    <th>Precio sin IVA (Bs)</th>
                    <th>Precio con IVA (Bs)</th>
               
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
	    'itemView'=>'_datosProductos',
	    'template'=>$template,
	    //'enableSorting'=>true,
	    'afterAjaxUpdate'=>'porMarca',
	      'sortableAttributes'=>array(
                'Nombre', 'Marca', 'Talla', 'Color', 'Costo'
   	),
	    
	    
	   
	 					
	));

	Yii::app()->clientScript->registerScript('marca',
		"var ajaxUpdateTimeout;
		var ajaxRequest;
		var inicio;
		var fin;
		$('#marcas').change(function(){
			ajaxRequest = $('#marcas').serialize();
			marcaId = $('#marcas').val();
			clearTimeout(ajaxUpdateTimeout);
			
			
			ajaxUpdateTimeout = setTimeout(function () {
				$.fn.yiiListView.update(
				'list-auth-items',
				{
				type: 'POST',	
				url: '" . CController::createUrl('orden/reporte') . "',
				data: {ajaxRequest:ajaxRequest}}
				
				)
				},
		
		300);
		return false;
		});",CClientScript::POS_READY
	);
	
	

?>
<div class="margin_top pull-left"><a href="<?php echo Yii::app()->baseUrl."/producto/reportexls" ?>" title="Exportar a Excel" class="btn btn-info">Exportar a Excel</a></div>
</div>
</div>


<script>


	   
	   

      
	
	
</script>