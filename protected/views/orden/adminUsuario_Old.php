<div class="container margin_top">
  <div class="page-header">
    <h1>Tus Pedidos</h1>
      <hr/>
    <!-- Menu ON -->
    
    <div class="navbar">
  <div class="navbar-inner margin_bottom margin_top_medium">
    <ul class="nav ">
      <li class="active"><a href="#" title="Tus pedidos activos">Pedidos activos</a></li>
      <li><a href="#" title="tu avatar">Historial de pedidos</a></li>
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
    <!-- Menu OFF -->
    
  </div>
  
    <?php
  
$template = '{summary}
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
    <tr>
      <th scope="col">Número de Orden</th>
      <th scope="col">Fecha</th>
      <th scope="col">Monto (En Bs.)</th>
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
	
	?>
  

  <hr/>
</div>
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
 		}	
		
		
	}
	
	
</script>