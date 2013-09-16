<?php
/* $this->breadcrumbs=array(
	'Compra',
);
*/
?> 

<div class="container margin_top">
  <div class="page-header">
    <h1>Generar Orden de Compra</small></h1>
  </div>

  
    <div class="row margin_top margin_bottom ">
    <div class="span12">
   
    <form class="no_margin_bottom form-search">
    <div class="span4">
    	<input type="text" name="query" id="query" class="span3">
   		<a class="btn" id="btn_search_event">Buscar</a>
   	</div>
	<div class="span4">
    	<a class="btn span2" id="ver_orden">Ver Orden</a>
	</div>
	<div class="span2">
    	<a class="btn btn-info" id="continuar">Continuar</a>
	</div>
	</form>
		
	<?php
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
				data: ajaxRequest}
				
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
					<div  style="width:50%; float:right"> 
					{sorter}
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


		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_item',
	    'template'=>$template,
	    'enableSorting'=>true,
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

var arr=Array();
var arr2=Array();

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
	   		alert(arr.toString()+"\n"+arr2.toString());
	   		   
	   		
	   }


$(document).ready(function(){
	  
	    
	    	
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

  
</script>	