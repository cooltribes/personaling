<div class="container margin_top">
  <div class="page-header">
    <h1>Tus Notificaciones</h1>
    
    <div class="">
  <div class=" margin_bottom margin_top_medium">
    <ul class="nav  nav-tabs">
      <li class="active"><a href="#" title="Tus pedidos activos">Mensajes</a></li>
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
  

  <section class= "row-fluid well">
  	<!-- Lista de Mensajes  -->
  	<div class="span4 sidebar_list_mensajes bg_color3">
			<a  href="#">	
		  		<article class="row-fluid padding_xsmall">
					<img src=" http://placehold.it/90x90" alt="" class="img-circle span2" />
		  		 	<div class="span8">
				  		<span> <strong>De:</strong> Hodor </span>
			  		  	<p> <strong>Mensaje:</strong> Hodor hodor, hordor hodor... </p>
		  		  	</div>
		  		  	<span class="entypo icon_personaling_medium span1">&#59230;</span>
		   		</article>  
	 		</a>
	  		 <hr/>
	  		<a  href="#">	
		  		<article class="row-fluid padding_xsmall">
					<img src=" http://placehold.it/90x90" alt="" class="img-circle span2" />		  			
		  			<div class="span8">
			  			<span> <strong>De:</strong> Administrador </span>
			  			<p> <strong>Mensaje: </strong> Tu pedido ha sido rechazado... </p>
		  			</div>
		  			<span class="entypo icon_personaling_medium span1">&#59230;</span>
		  		</article>
	  		</a>
	  		<hr/>
	  		<a  href="#">	
		  		<article class="row-fluid padding_xsmall">
					<img src=" http://placehold.it/90x90" alt="" class="img-circle span2" />		  			
		  			<div class="span8">
		  				<span> <strong>De:</strong> Chuck Norris </span>
		  				<p> <strong>Mensaje:</strong> Tu pedido ha sido bautizado...  </p> 
		  			</div>
		  			<span class="entypo icon_personaling_medium span1"> &#59230; </span>
	  			</article>  
	  		</a>
	  		<hr/>
	  		<a href="">
		  		<article class="row-fluid padding_xsmall">
					<img src=" http://placehold.it/90x90" alt="" class="img-circle span2" />		  			
		  			<div class="span8">
			  			<span> <strong>De:</strong> Administrador </span>
			  			<p> <strong>Mensaje:</strong> Tu pedido ha sido actualizado...</p>
		  			</div>
		  			<span class="entypo icon_personaling_medium span1">&#59230;</span>	
		  		</article>
	  		</a>
	  		<hr/>
	  		<a  href="#">	
		  		<article class="row-fluid padding_xsmall">
					<img src=" http://placehold.it/90x90" alt="" class="img-circle span2" />		  			
		  			<div class="span8">
			  			<span> <strong>De:</strong> Administrador </span>
			  			<p> <strong>Mensaje:</strong> Tu pedido ha sido explotado... </p>
		  			</div>
		  			<span class="entypo icon_personaling_medium span1">&#59230;</span>
		  		</article>
	  		</a>
	  		<hr/>
	  		<a  href="#">	
		  		<article class="row-fluid padding_xsmall">
					<img src=" http://placehold.it/90x90" alt="" class="img-circle span2" />		  			
		  			<div class="span8">
			  			<span> <strong>De:</strong> Yondri </span>
			  			<p> <strong>Mensaje:</strong> Tu pedido ha sido bautizado... </p>
		  			</div>
		  			<span class="entypo icon_personaling_medium span1">&#59230;</span>
		  		</article>  		  		  		
	  		</a>
  	</div>

  	<!-- Cuerpo del mensaje -->
  	<div class="span8 ">
	  	<div class="padding_medium bg_color3 ">
			<p><strong>De:</strong> Jon Snow</p>
	  		<p> <strong>Asunto:</strong> You know nothing Jon Snow</p>
	  		<p> <strong>Fecha:</strong> 23 de Septiembre de 2013</p>
	  		<p>
	  			If you have five dollars and Chuck Norris has five dollars, Chuck Norris has more money than you.
	 			The Great Wall of China was originally created to keep Chuck Norris out. It failed misserably.
	 			Chuck Norris ordered a Big Mac at Burger King, and got one.
	  		</p>
	  		<form class=" margin_top_medium ">
		  		<textarea class="span12 nmargin_top_medium" rows="3" placeholder="Escribe tu mensaje..."	></textarea>
		  		<button class="btn btn-danger"> <span class="entypo color3 icon_personaling_medium" >&#10150;</span> Enviar </button>
	  		</form>
	  	</div>
  	</div>
  </section>



    <?php
  
// $template = '{summary}
// 	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
//     <tr>
//       <th scope="col">Número de Orden</th>
//       <th scope="col">Fecha</th>
//       <th scope="col">Monto (En Bs.)</th>
//       <th scope="col">Estado</th>
//       <th scope="col">Acciones</th>
//     </tr>
//     {items}
//     </table>
//     {pager}
// 	';
    
//   $this->widget('zii.widgets.CListView', array(
// 	    'id'=>'list-auth-items',
// 	    'dataProvider'=>$dataProvider,
// 	    'itemView'=>'_datosUsuario',
// 	    'template'=>$template,
// 	    'enableSorting'=>'true',
// 	    'afterAjaxUpdate'=>" function(id, data) {
						    	
// 							$('#todos').click(function() { 
// 				            	inputs = $('table').find('input').filter('[type=checkbox]');
				 
// 				 				if($(this).attr('checked')){
// 				                     inputs.attr('checked', true);
// 				               	}else {
// 				                     inputs.attr('checked', false);
// 				               	} 	
// 							});
						   
// 							} ",
// 		'pager'=>array(
// 			'header'=>'',
// 			'htmlOptions'=>array(
// 			'class'=>'pagination pagination-right',
// 		)
// 		),					
// 	));
	
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