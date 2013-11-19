<div class="container margin_top">
  <div class="page-header">
    <h1>Reporte de Productos Vendidos</small></h1>
  </div>
<div class="span11">
<?php 
	$list= CHtml::listData(Marca::model()->findAll(), 'id', 'nombre');
	$list[0]="Todas";

	echo CHtml::dropDownList('marcas', 'Todas', $list, array('empty' => 'Filtrar por marca', 'class'=>'pull-right'));
	$template = '<br/><br/>
				<div style="width:100%">
					<div  style="width:auto; float:left;"> 
					{summary}
					</div>
					<div  style="width:50%; float:right"> 
					{sorter}
					</div>
			 	 
			 	
			  <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered ta table-hover table-striped">
			  <thead>
			  <tr> 

			      <th>Marca</th>
                    <th>Nombre</th>
                    <th>SKU</th>
                    <th>Color</th>
                    <th>Talla</th>
                    <th>Cantidad</th>
                    <th>Costo (Bs)</th>
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
	    'itemView'=>'_authitem',
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
				data: ajaxRequest}
				
				)
				},
		
		300);
		return false;
		});",CClientScript::POS_READY
	);
	

?>
<div class="margin_top pull-left"><a href="<?php echo Yii::app()->baseUrl."/orden/reportexls" ?>" title="Exportar a Excel" class="btn btn-info">Exportar a Excel</a></div>
</div>
</div>