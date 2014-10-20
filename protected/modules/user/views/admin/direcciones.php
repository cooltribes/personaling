<?php 
  $this->breadcrumbs=array(
  'Usuarios'=>array('admin'),
  'Editar',);
?>
<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Direcciones</h1>
  </div>
  <!-- SUBMENU ON -->
  <?php $this->renderPartial('_menu', array('model'=>$model, 'activo'=>5)); ?>
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="">
        <form method="post" id="registration-form"   class="form-stacked personaling_form" enctype="multipart/form-data">
          
            <legend >Direcciones de envio: </legend>
            
			
          <?php
          		$direcciones = Direccion::model()->findAllByAttributes(array('user_id'=>$model->id));
          		 
					foreach($direcciones as $key=>$dir)
					{
					$ciudad = Ciudad::model()->findByPk($dir->ciudad_id);
					$provincia = Provincia::model()->findByPk($dir->provincia_id);
					
						echo '<div class="well well-small clearfix">';
						echo '<div class="pull-right">';
                        echo CHtml::link("<i class='icon-edit'></i>",
                            $this->createUrl('editAddress',array('id'=>$dir->id)),
                            array(// for htmlOptions
                              'onclick'=>' '.CHtml::ajax( array(
                              'url'=>CController::createUrl('editAddress',array('id'=>$dir->id)),
                                   'success'=>"js:function(data){ $('#myModal').html(data);
                                            $('#myModal').modal(); }")).
                                 'return false;',
                            'class'=>'btn',
                            'id'=>'prodencanta')
                        );
                        
                        
                        
				        echo '<a href="#" title="borrar" class="btn btn-link">
				          		<i class="icon-remove"></i></a>
				          </div>';
						echo '<h4 class="braker_bottom padding_bottom_xsmall"> Dirección '.($key+1)." ".$dir->id.'</h4>';
				      
				        echo '<div class="vcard">';
				        echo '<div class="adr">';
						echo '<div class="street-address"><i class="icon-map-marker"></i>'.$dir->dirUno.'. '.$dir->dirDos.'</div>';
						echo '<span class="locality">'.$ciudad->nombre.', '.$provincia->nombre.'</span>';
						echo '<div class="country-name">'.$dir->pais.'</div>';
				        echo "</div>";
				        
				        echo '<div class="tel margin_top_small"><span class="type"><strong>Telefono</strong>:</span> '.$dir->telefono.' </div>';
				      //  echo '<div><strong>Email</strong>: <span class="email">info@commerce.net</span> </div>';
				        echo '</div>';
						echo '</div>';
						
			
						
					}
				
          	?>

        </form>
      </div>
    </div>
    <script > 
      // Script para dejar el sidebar fijo Parte 1
      function moveScroller() {
        var move = function() {
          var st = $(window).scrollTop();
          var ot = $("#scroller-anchor").offset().top;
          var s = $("#scroller");
          if(st > ot) {
            s.css({
              position: "fixed",
              top: "70px",
              width: "239px"
            });
          } else {
            if(st <= ot) {
              s.css({
                position: "relative",
                top: "0",
              });
            }
          }
        };
        $(window).scroll(move);
        move();
      }
    </script>    
    <div class="span3">
      <div class="padding_left">
      <div id="scroller-anchor"></div>
      <div id="scroller">
       <a href="#" title="Guardar" class="btn btn-danger btn-large btn-block">Guardar</a>
        <ul class="nav nav-stacked nav-tabs margin_top">
          <li><a href="#" title="Restablecer"><i class="icon-repeat"></i> Restablecer</a></li>
          <li><a href="#" title="Guardar"><i class="icon-envelope"></i> Enviar mensaje</a></li>
          <li><a href="#" title="Desactivar"><i class="icon-off"></i> Desactivar</a></li>
        </ul>
      </div>
      </div>
    </div>
  </div>
</div>
 <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal','htmlOptions'=>array('class'=>'modal_grande hide fade','tabindex'=>'-1','role'=>'dialog','aria-labelleby'=>'myModalLabel','aria-hidden'=>'true'))); ?>
 
    <?php $this->endWidget(); ?>
<!-- /container -->

<script>
  $(function() {
    moveScroller();
  });  
</script>



