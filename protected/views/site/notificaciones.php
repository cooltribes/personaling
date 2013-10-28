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
  		
  		<?php
  			
  			$mensajes = Mensaje::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id,'visible'=>1)); // buscaria todos los mensajes que estén como visibles del usuario para listarlos
  			if(count($mensajes) > 0){
  				$mensajes_Reverse = array_reverse($mensajes);
				foreach( $mensajes_Reverse as $msj)
				{
					if(is_null($msj->admin)){

  		?>
			<a onclick="buscarmensaje(<?php echo $msj->id; ?>)" style="cursor: pointer;">	
				<?php if($msj->estado == 0){ ?>
		  			<article class="mensaje<?php echo $msj->id; ?> row-fluid bg_color10 padding_xsmall">
				<?php } else{ ?>
					<article class="mensaje<?php echo $msj->id; ?>  row-fluid padding_xsmall">
						<?php } ?>
					
		  		 	<div class="span8">
				  		<span> <strong>De:</strong> Admin</span>
			  		  	<p> <strong>Asunto: </strong> <?php echo $msj->asunto; ?></p>
		  		  	</div>
		  		  	<span class="entypo icon_personaling_medium span1">&#59230;</span>
		   		</article>  
	 		</a>
	 		<hr/>
	 		<?php
				}
				}
			}
	 		?>	  		
  	</div>

  	<!-- Cuerpo del mensaje -->
  	<div class="span8" id="mensajeActual">
  		<div>
		  	<div class="padding_medium bg_color3 ">
		  	
		  	<p> <strong> Haz click en uno de tus mensajes para visualizar su contenido. </strong> </p>
		  	
		  	
		  	</div>
	  	</div>
  	</div>
  </section>


  <hr/>
</div>
<!-- /container -->

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal','htmlOptions'=>array('class'=>'modal hide fade','tabindex'=>'-1','role'=>'dialog','aria-labelleby'=>'myModalLabel','aria-hidden'=>'true'))); ?>

<?php $this->endWidget(); ?>

<script>
	
	function buscarmensaje(id)
	{	

 		$.ajax({
	        type: "post", 
	        url: "mensaje", // action 
	        data: { 'msj_id':id}, 
	        success: function (data) {
				
				$("#mensajeActual").fadeOut(100,function(){
			     	$("#mensajeActual").html(data); // cambiando el div
			     	$('.mensaje'+id).removeClass('bg_color10');
			     	console.log(id);
			     });
					

			    $("#mensajeActual").fadeIn(20,function(){});

	       	}//success
	       })
	       
 	}	

</script>