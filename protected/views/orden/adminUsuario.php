<?php
$this->breadcrumbs=array(
  'Tus Pedidos',
);
?>
<div class="container margin_top">
  <div class="page-header">
    <h1>Tus Pedidos</h1>
      <hr/>
    <!-- Menu ON -->
   <form id="formu" class="no_margin_bottom form-search form-horizontal"> 
    <div class="navbar">
  <div class="navbar-inner margin_bottom margin_top_medium">
    <ul class="nav ">
    	
      <li class="active" id="hist"><a href="#" title="Tus pedidos activos" id="listado">Pedidos activos</a></li>
      <li id="list"><a href="#" title="tu avatar" id="historial">Historial de pedidos</a></li>
    </ul>
  </div>
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
	
</div>
</form>
    <!-- Menu OFF -->
    
  </div>
  
    <?php
  
$template = '{summary}
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
    <tr>
      <th scope="col">Número de Orden</th>
      <th scope="col">Fecha</th>
      <th scope="col">Monto (En Bs.)</th>
      <th scope="col">Por Pagar (En Bs.)</th>
      <th scope="col">Estado</th>
      <th scope="col">Acciones</th>
    </tr>
    {items}
    </table>
    {pager}
	';
    
  $this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_datosUsuario',
	    'template'=>$template,
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
		'pager'=>array(
			'header'=>'',
			'htmlOptions'=>array(
			'class'=>'pagination pagination-right',
		)
		),					
	));
	
	
       
	Yii::app()->clientScript->registerScript('historial',
		"var ajaxUpdateTimeout;
		$('#historial').click(function(){
				clearTimeout(ajaxUpdateTimeout);
			$('#list').addClass('active');
			 $('#hist').removeClass('active');
			 
			ajaxUpdateTimeout = setTimeout(function () {
				$.fn.yiiListView.update(
				'list-auth-items',
				{
				type: 'POST',	
				url: '" . CController::createUrl('orden/historial') . "',
				}
				
				)
				},
		
		300);
		return false;
		});",CClientScript::POS_READY
	);
	
	Yii::app()->clientScript->registerScript('listado',
		"var ajaxUpdateTimeout;
		$('#listado').click(function(){
			$('#list').removeClass('active');
			 $('#hist').addClass('active');
			clearTimeout(ajaxUpdateTimeout);
			
			ajaxUpdateTimeout = setTimeout(function () {
				$.fn.yiiListView.update(
				'list-auth-items',
				{
				type: 'POST',	
				url: '" . CController::createUrl('orden/listado') . "',
				}
				
				)
				},
		
		300);
		return false;
		});",CClientScript::POS_READY
	);
	
?>
  <hr/>
  <input id="hiddenMensaje" type="hidden">
<!-- /container -->

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal','htmlOptions'=>array('class'=>'modal hide fade','tabindex'=>'-1','role'=>'dialog','aria-labelleby'=>'myModalLabel','aria-hidden'=>'true'))); ?>

<?php $this->endWidget(); ?>

<script>
	
        
	function enviar()
	{	
		var idDetalle = $("#idDetalle").attr("value");
		var nombre= $("#nombre").attr("value");
		var numeroTrans = $("#numeroTrans").attr("value");
		var dia = $("#dia").attr("value");
		var mes = $("#mes").attr("value");
		var ano = $("#ano").attr("value");
		var comentario = $("#comentario").attr("value");
		var banco = $("#banco").attr("value");
		var cedula = $("#cedula").attr("value");
		var monto = $("#monto").attr("value");
		var idOrden = $("#idOrden").attr("value");
		
		
		if(nombre=="" || numeroTrans=="" || monto=="" || banco=="Seleccione")
		{
			alert("Por favor complete los datos.");
		}
		else
		{
			if(monto.indexOf(',')==(monto.length-2))
	        	monto+='0';
			if(monto.indexOf(',')==-1)
				monto+=',00';
				
	        var pattern = /^\d+(?:\,\d{0,2})$/ ;
	        
	        if (pattern.test(monto)) { 
	        	monto = monto.replace(',','.');  
	           
	           	$.ajax({
			        type: "post", 
			        url: "../bolsa/cpago", // action de controlador de bolsa cpago
			        data: { 'nombre':nombre, 'numeroTrans':numeroTrans, 'dia':dia, 'mes':mes, 'ano':ano, 'comentario':comentario, 'idOrden':idOrden, 'idDetalle':idDetalle, 'banco':banco, 'cedula':cedula, 'monto':monto}, 
			        success: function (data) {
						
						if(data=="ok")
						{
							window.location.reload();
							//alert("guardado"); 
							// redireccionar a donde se muestre que se ingreso el pago para luego cambiar de estado la orden 
						}
						else
						if(data=="no")
						{
							alert("Datos invalidos.");
						}
						
			       	}//success
			  	})
     
	        }else{
	        	alert("Formato de cantidad no válido. Separe solo los decimales con una coma (,)");
	        }
 		
 		}	
		
		
	} // enviar
        
        
        
        
        $("[id^='linkCancelar']").click(function (e){
            e.preventDefault();
            //console.log("click");
            var urlCancel = $(this).attr('href');
            //console.log(urlCancel);
            
            $("#mensajeCancel").focus();
            
            bootbox.dialog("Cuéntanos por qué deseas cancelar este pedido...  \n\
                <br><br><textarea id='mensajeCancel'  maxlength='255' style='resize:none; width: 520px;' rows='4' cols='400'> ",
//                [{
//                    "label" : "Cancelar",
//                    "class" : "btn-danger",
//                    "icon"  : "icon-trash",
//                    "callback": function() {
//
//                    }
//                }, 
                [{
                    "label" : "Continuar",
                    "class" : "btn-danger",
                    "callback": function() {
                       // console.log($("#mensajeCancel").val());
                        $("#hiddenMensaje").val($("#mensajeCancel").val().trim());
                        //window.location = urlCancel;
                        var vect = urlCancel.split("cancelar/");
                        //console.log(vect);
                        $.ajax({
                            type: 'GET',
                            url: 'cancelar',
                            data: {id: vect[1], mensaje: $("#hiddenMensaje").val()},
                            success: function(data){
                                
                               //window.location = "<?php echo CController::createUrl('orden/listado'); ?>"; 
                                console.log(data);
                            }
                        });
                        
                    }
                }]);
                
//                bootbox.setDefaults({
//                    closeButton:true,
//                });
            
        });
	
        
	
</script>