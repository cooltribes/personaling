<?php 


	$list= CHtml::listData(Marca::model()->findAll(), 'id', 'nombre');
	echo CHtml::dropDownList('marcas', '', $list, array('empty' => 'Filtrar por Marca'));
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
                    <th>Costo</th>
                    <th>Precio sin IVA</th>
                    <th>Precio con IVA</th>
                </tr>
			    </thead>
			    <tbody>
			    {items}
				</tbody>
			    </table>
			   
			    {pager}
				';
				
				
		
	Yii::app()->clientScript->registerScript('handle_ajax_function', "
			function porMarca()
			{
				
				alert(marcaId);
			}
			");



		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_authitem',
	    'template'=>$template,
	    //'enableSorting'=>true,
	    'afterAjaxUpdate'=>'porMarca',
	    
	    
	   
	 					
	));

	Yii::app()->clientScript->registerScript('marca1',
		"var ajaxUpdateTimeout;
		var ajaxRequest; 
		$('#marcas').change(function(){
			marcaId = $('#marcas').val();
			clearTimeout(ajaxUpdateTimeout);
			
			ajaxUpdateTimeout = setTimeout(function () {
				$.fn.yiiListView.update(
				'list-auth-items',
				{
				type: 'POST',	
				url: '" . CController::createUrl('orden/reporte') . "',
				data: marcaId}
				
				)
				},
		
		300);
		return false;
		});",CClientScript::POS_READY
	);
















?>  
