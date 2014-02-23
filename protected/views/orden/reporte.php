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
	
	  echo "<div class='span2 input-prepend'>".CHtml::textField('inicio','', array(
                            'placeholder' => 'Desde',
                            'class' => 'span2 ui-datepicker-trigger',
                            
                        ))."<span class='add-on'><i class='icon-calendar'></i></span></div>"; 
	echo "<div class='span3 input-prepend'>".CHtml::textField('fin','', array(
                            'placeholder' => 'Hasta',
                            'class' => 'span2 ui-datepicker-trigger',
                            
                        ))."<span class='add-on'><i class='icon-calendar'></i></span></div>"; 
	echo '<div class="span2"><a class="btn margin_bottom_small btn btn-danger" id="fechas" href="#">Buscar</a></div>';
	
	
	
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
                    <th><a href="'.Yii::app()->baseUrl.'/orden/reporte?data_sort=Fecha">Vendido</a></th>
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
                'Nombre', 'Marca', 'Talla', 'Color', 'Costo', 'Fecha'
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
			if($('#inicio').val()=='')
				inicio='2010-01-01';
			else
				inicio=$('#inicio').val();
			if($('#fin').val()=='')
				fin='3500-01-01';
			else
				fin=$('#fin').val();				
			
			
			ajaxUpdateTimeout = setTimeout(function () {
				$.fn.yiiListView.update(
				'list-auth-items',
				{
				type: 'POST',	
				url: '" . CController::createUrl('orden/reporte') . "',
				data: {ajaxRequest:ajaxRequest, desde:inicio, hasta:fin, marcas:marcaId }}
				
				)
				},
		
		300);
		return false;
		});",CClientScript::POS_READY
	);
	
	Yii::app()->clientScript->registerScript('fecha',
		"var ajaxUpdateTimeout;
		var ajaxRequest; 
		$('#fechas').click(function() { 
			marcaId = $('#marcas').val();
			clearTimeout(ajaxUpdateTimeout);
			
			ajaxUpdateTimeout = setTimeout(function () {
				$.fn.yiiListView.update(
				'list-auth-items',
				{
				type: 'POST',	
				url: '" . CController::createUrl('orden/reporte') . "',
				data: {ajaxRequest: ajaxRequest, desde:$('#inicio').val(), hasta:$('#fin').val(), marcas:marcaId}}
				
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


<script>


	   
	   
	   $('#inicio').datepicker({
            dateFormat: "dd-mm-yy",
            defaultDate: '-1m',
            buttonImageOnly: false,

            onSelect: function(selected) {
                        $("#fin").datepicker(
                                "option","minDate", selected);
                        }
        });
        
           
        $('#fin').datepicker({
           dateFormat: "dd-mm-yy",
            maxDate: 0,

        });
      
	
	
</script>