<?php
/* @var $this CampanaController */

$this->breadcrumbs=array(
	'Campañas'=>array('/campana'),
	'Selecciona Personal Shoppers',
);
?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'campana-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>
<div class="container margin_top">
  <div class="page-header">
    <h1>
    	<?php 
    	if(Yii::app()->controller->action->id == 'edit'){
    		echo 'Editar Campaña';
    	}else{
    		echo 'Crear Campaña';
    	}
    	?>
    	</h1>
  </div>
  <div class="row ">
    <div class="span9">
      
        <div class="bg_color3   margin_bottom_small padding_small box_1" >
          <fieldset>
            <legend >Acceso: </legend>
            <div class="control-group">
              <label for="" class="control-label required"> </label>
              <div class=""controls controls-row"">
                <label class="checkbox inline">
                  <input type="radio" id="ps_todos" name="personal_shopper" value="todos">
                  Invitar a todos los Personal Shoppers </label>
                <label class="checkbox inline">
                  <input type="radio" id="ps_seleccionar" name="personal_shopper" value="seleccionar" checked>
                  Elegir Personal Shoppers </label>
                <div style="display:none" id="_em_" class="help-inline">ayuda aqui </div>
              </div>
            </div>
          </fieldset>
        </div>
        <div class="bg_color3   margin_bottom_small padding_small box_1" id="ps_container">
          <fieldset>
            <legend >Personal Shoppers invitados: </legend>
            <div class="clearfix margin_top margin_bottom ">
              <div class="pull-right">
                <div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>
                  <input class="span3" id="buscarNombre" type="text" placeholder="Buscar">
                </div>
              </div>
            </div>
            
            <?php
                    Yii::app()->clientScript->registerScript('query',
                            "var ajaxUpdateTimeout;
                            var ajaxRequest; 

                            $('#buscarNombre').keypress(function(e) {
                                if(e.which == 13) {
                                // $('.crear-filtro').click();
                                    ajaxRequest = $('#buscarNombre').val();
                                            clearTimeout(ajaxUpdateTimeout);

                                            ajaxUpdateTimeout = setTimeout(function () {
                                                    $.fn.yiiListView.update(
                                                        'list-ps',
                                                        {
                                                            type: 'POST',	
                                                            url: '" . CController::createUrl('') . "',
                                                            data: {buscarNombre : ajaxRequest}
                                                        }
                                                    )
                                            },

                                    300);
                                    return false;
                                }
                            });",CClientScript::POS_READY
                    );

                ?> 
            
            <?php
			$template = '{summary}
			  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
			  <tbody>
			    <tr>
			      <th scope="col"><input name="Check" type="checkbox" id="checkbox_select_ps" value="Check"></th>
                  <th colspan="2" scope="col">Personal shoppers</th>
                  <th colspan="1" scope="col">E-mail</th>
                  <th colspan="1" scope="col">Looks vendidos</th>
			    </tr>
			    {items}
			    </table>
			    {pager}
				';
			
					$this->widget('zii.widgets.CListView', array(
				    'id'=>'list-ps',
				    'dataProvider'=>$dataProvider,
				    'itemView'=>'_view_ps',
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
            
            
            
            
          </fieldset>
        </div>
      
    </div>
    <div class="span3">
      <div class="padding_left"> 
		<script type="text/javascript"> 
		// Script para dejar el sidebar fijo Parte 1
		function moveScroller() {
		  var move = function() {
		    var st = $(window).scrollTop();
		    var ot = $("#scroller-anchor").offset().top;
		    var s = $("#scroller");
		    if(st > ot) {
		      s.css({
		        position: "fixed",
		        top: "70px"
		      });
		    } else {
		      if(st <= ot) {
		        s.css({
		          position: "relative",
		          top: "0"
		        });
		      }
		    }
		  };
		  $(window).scroll(move);
		  move();
		}
		</script>        	
      	<div id="scroller-anchor"></div>
		<div class="span3" id="scroller">
	      	<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'danger',
				'size' => 'large',
				'block'=>'true',
				'label'=>$campana->isNewRecord ? 'Crear' : 'Guardar',
			)); ?>
	        <ul class="nav nav-stacked nav-tabs margin_top">
	          <li><a style="cursor: pointer" title="Restablecer" id="limpiar">Limpiar</a></li>
	          <!-- <li><a href="#" title="Duplicar">Duplicar</a></li> -->
	          <li><a href="#" title="Guardar"><i class="icon-trash"> </i> Borrar</a></li>
	        </ul>
      	</div>
	    <script type="text/javascript"> 
	    // Script para dejar el sidebar fijo Parte 2
	      $(function() {
	        moveScroller();
	       });
	    </script>      	
<!--         <ul class="nav nav-stacked nav-tabs margin_top">
          <li><a href="#" title="Restablecer">Restablecer</a></li>
                      <li><a title="Pausar" href="admin_anadir_campana.php"> <i class="icon-pause"> </i> Pausar (solo debe salir Pausa o Play)</a></li>
            <li><a title="Play" href="admin_anadir_campana.php"> <i class="icon-play"> </i> Reanudar campaña</a></li>

          <li><a href="#" title="Duplicar">Duplicar campaña</a></li>
          <li><a href="#" title="Guardar"><i class="icon-trash"></i> Borrar campaña</a></li>
        </ul> -->
      </div>
    </div>
  </div>
</div>
<!-- /container -->

<!------------------- MODAL WINDOW ON -----------------> 

<!-- Modal 1 -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Campaña publicada/guardada</h3>
  </div>
  <div class="modal-body">

	<p class="lead">La campaña: "<strong>Nombre de la campana</strong>" ha sido publicada con éxito</p>
 
 <p>A continuación el resumen de la campaña</p>
 

            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
  <tr>
    <th scope="col">Descripción</th>
    <th scope="col">Detalle</th>
  </tr>
  <tr>
    <td>Recepción de los looks:</td>
    <td>del 17/10/1985 al 17/10/2013</td>
  </tr>
  <tr>
    <td>Actividad de la campaña:</td>
    <td>del 17/10/1985 al 17/10/2013</td>
  </tr>
  <tr>
    <td>Personal shopper invitados:</td>
    <td>500</td>
  </tr>
</table>
  </div>
  <div class="modal-footer">  <a href="admin_anadir_campana.php" title="editar" class="btn"><i class="icon-edit"></i> Editar</a> <a href="admin_campanas.php" title="Salir" class="btn" target="_blank"> Salir al listado de campañas</a> </div>
</div>
<!------------------- MODAL WINDOW OFF ----------------->
<?php $this->endWidget(); ?>

<script>
	$(document).ready(function(){
		if (!$('input.check_ps[type=checkbox]:not(:checked)').length){
		 	$('#checkbox_select_ps').attr('checked','checked');
		}else{
			$('#checkbox_select_ps').removeAttr('checked');
		}
	});

	$('.check_ps').click(function(e){
		var path = location.pathname.split('/');
		if($(this).is(':checked')){
			$.ajax({
		      url: "/"+path[1]+"/campana/invite",
		      type: "post",
		      data: { id : $(this).val() },
		      success: function(){
		           $(e.target).closest('tr').addClass('success');
		      },
		    });
	   	}else{
	   		$.ajax({
		      url: "/"+path[1]+"/campana/uninvite",
		      type: "post",
		      data: { id : $(this).val() },
		      success: function(){
		          $(e.target).closest('tr').removeClass('success');
		      },
		    });
	   	}
	   	if (!$('input.check_ps[type=checkbox]:not(:checked)').length){
		 	$('#checkbox_select_ps').attr('checked','checked');
		}else{
			$('#checkbox_select_ps').removeAttr('checked');
		}
	});
	
	$('#checkbox_select_ps').click(function(e){
		var path = location.pathname.split('/');
		if($(this).is(':checked')){
			$.ajax({
		      url: "/"+path[1]+"/campana/inviteAll",
		      type: "post",
		      data: { id : $(this).val() },
		      success: function(){
		           $('tr').addClass('success');
		           $('.check_ps').attr('checked','checked');
		      },
		    });
	   	}else{
	   		$.ajax({
		      url: "/"+path[1]+"/campana/uninviteAll",
		      type: "post",
		      data: { id : $(this).val() },
		      success: function(){
		          $('tr').removeClass('success');
		          $('.check_ps').removeAttr('checked');
		      },
		    });
	   	}
	});
	
	$('#ps_todos').click(function(){
		$('#ps_container').hide('slow');
		console.log('all');
	});
	
	$('#ps_seleccionar').click(function(){
		console.log('select');
		$('#ps_container').show();
	});
</script>