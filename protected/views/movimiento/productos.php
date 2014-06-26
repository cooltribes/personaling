<?php
/* $this->breadcrumbs=array(
	'Compra',
);
*/
?> 

<script type="text/javascript">
	var arr=Array();
	var arr2=Array();
	var init=Array();
	var init2=Array();
</script>
<div class="container margin_top">
  <div class="page-header">
    <h1>Selecciona los productos</h1>
  </div>

  
    <div class="row margin_top margin_bottom ">
	    <div class="span12">
	   
		    <form class="no_margin_bottom form-search">
			    <div class="span4">
			    	<input type="text" name="query" id="query" class="span3" placeholder="SKU, nombre, marca o referencia">
			   		<a class="btn" id="btn_search_event">Buscar</a>
			   	</div>
			</form>
			<div class="span4">
		    	<a class="btn span2" id="ver_orden">Resumen</a>
			</div>
			<div class="span2">
				<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
									'id'=>'productos',
									'action'=>'confirmar',
								
									
								));
									
					            echo CHtml::hiddenField('ptcs','nothing');	    
					            echo CHtml::hiddenField('vals','nothing');
				
				$this->widget('bootstrap.widgets.TbButton', array(
			            'buttonType'=>'submit',
			            'type'=>'info',
			            'id'=>'continuar',
			            'label'=>'Continuar',
			            'htmlOptions'=>array('name'=>'continuar')
			        )); 
				
				$this->endWidget();	
				?>
			</div>
		
		
			
			<?php
			
			$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
								'id'=>'productos',
								'enableAjaxValidation'=>false,
								'enableClientValidation'=>true,
								'clientOptions'=>array(
									'validateOnSubmit'=>true, 
								),
								
							));
								
				            echo CHtml::hiddenField('ptcs','direccionVieja');	    
				            echo CHtml::hiddenField('vals','direccionVieja');
			
			$this->endWidget();
			
			
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
						data: ajaxRequest,
						}
						
						)
						},
				
				300);
				return false;
				});",CClientScript::POS_READY
			);
			 
			
			$template = '<br/><br/>
						<div style="width:100%">
							<div  style="width:auto; float:left;"> 
							{summary}
							</div>
							<div  stylexf="width:50%; float:right"> 
							{sorter}
							</div>
						</div>
					 	 
					 	
					  <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered ta table-hover table-striped">
					  	<thead>
					  	<tr>
					      
					      	<th>Imagen</th>
		                    <th>Nombre</th>
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
						
			$pagerParams=array(
            'header'=>'',
            'prevPageLabel' => Yii::t('contentForm','Previous'),
            'nextPageLabel' => Yii::t('contentForm','Next'),
            'firstPageLabel'=> Yii::t('contentForm','First'),
            'lastPageLabel'=> Yii::t('contentForm','Last'),
            'htmlOptions'=>array(
                'class'=>'pagination pagination-right'));			
				
			Yii::app()->clientScript->registerScript('handle_ajax_function', "
					function setValues()
					{
						
						for(var i=0; i<arr.length;i++){
							$('#'+arr[i]).val(arr2[i]);
						}
					}
					");



				$this->widget('zii.widgets.CListView', array(
			    'id'=>'list-auth-items',
			    'dataProvider'=>$dataProvider,
			    'itemView'=>'_item',
			    'template'=>$template,
			    'enableSorting'=>true,
			    'afterAjaxUpdate'=>'setValues',
			    'pager'=>$pagerParams,
			    'sorterHeader'=>'Ordenar Por:',
			      'summaryText' => "Mostrando {start} - {end} de {count} Resultados",
			    
			    'sortableAttributes'=>array(
		                'Nombre', 'Marca', 'Talla', 'Color' 
		   	),
			 					
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
</div>
</div>

        
        <!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Resumen de Compra</h3>
	</div>
	<div class="modal-body" id="modal-body">
	</div>
	<div class="modal-footer">
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
	  
	    
	    	$("#ver_orden").click(function() { 
            	if(arr.toString().length>0)
            		modal();
            	else
            		alert("Aun no se ha agregado ningún producto");

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


 $('body').on('input','.cant', function() { 
     // get the current value of the input field.
     	
	    var a =  parseInt($(this).val());
	    if(isNaN(a)){
	    	$(this).val('0'); 
	   		a=0;
	   }
	   var index=arr.indexOf($(this).attr('id'));
	   if(index!=-1){
	   		arr.splice(index, 1);
	   		arr2.splice(index, 1);
	   }
	       
	   if(a>0){	
	   		arr.push($(this).attr('id'));
	   		arr2.push($(this).val());
	   		$('#ptcs').val(arr.toString());
	   		$('#vals').val(arr2.toString());
	   	}
 });
 
 function modal(id){

	$.ajax({
		type: "post",
		'url' :'<?php echo  CController::createUrl('movimiento/pormover');?>',
		data: { 'ids':arr.toString(), 'cants':arr2.toString()}, 
		'success': function(data){
			$('#modal-body').html(data);
			$('#myModal').modal(); 
		},
		'cache' :false});

}





 
 
</script>	