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
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked personaling_form" enctype="multipart/form-data">
          
            <legend >Direcciones de envio: </legend>
            
			
          <?php
          		$direcciones = Direccion::model()->findAllByAttributes(array('user_id'=>$model->id));
          		 
					foreach($direcciones as $key=>$dir)
					{
					$ciudad = Ciudad::model()->findByPk($dir->ciudad_id);
					$provincia = Provincia::model()->findByPk($dir->provincia_id);
					
						echo '<div class="well well-small clearfix">';
						echo '<div class="pull-right">';
				        echo '<a class="btn" href="#myModal" role="button" data-toggle="modal" >
				          		<i class="icon-edit"></i></a>
				          	<a href="#" title="borrar" class="btn btn-link">
				          		<i class="icon-remove"></i></a>
				          </div>';
						echo '<h4 class="braker_bottom padding_bottom_xsmall"> Dirección '.($key+1).'</h4>';
				      
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
<!-- /container -->

<script>
  $(function() {
    moveScroller();
  });  
</script>

<!------------------- MODAL WINDOW ON -----------------> 

<!-- Modal 1 -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Editar dirección</h3>
  </div>
  <div class="modal-body">
   
   <fieldset>
            <div class="control-group"> 
              <!--[if lte IE 7]>
            <label for="RegistrationForm_email" class="control-label required">Nombre de la persona a la que envias <span class="required">*</span></label>
<![endif]-->
              <div class="controls">
                <input type="text" class="span5" name="RegistrationForm[email]" placeholder="Nombre de la persona a la que envias" id="RegistrationForm_email" maxlength="128">
                <div class="help-inline" id="RegistrationForm_email_em_" style="display:none"></div>
              </div>
            </div>
            <div class="control-group"> 
              <!--[if lte IE 7]>
            <label for="RegistrationForm_email" class="control-label required">Apellido de la persona a la que envias tu compra<span class="required">*</span></label>
<![endif]-->
              <div class="controls">
                <input type="text" class="span5" name="RegistrationForm[email]" placeholder="Apellido de la persona a la que envias tu compra" id="RegistrationForm_email" maxlength="128">
                <div class="help-inline" id="RegistrationForm_email_em_" style="display:none"></div>
              </div>
            </div>
            <div class="control-group"> 
              <!--[if lte IE 7]>
            <label for="RegistrationForm_email" class="control-label required">Cedula de Identidad de la persona a la que envias<span class="required">*</span></label>
<![endif]-->
              <div class="controls">
                <input type="text" class="span5" name="RegistrationForm[email]" placeholder="Cedula de Identidad de la persona a la que envias" id="RegistrationForm_email" maxlength="128">
                <div class="help-inline" id="RegistrationForm_email_em_" style="display:none"></div>
              </div>
            </div>
            <div class="control-group"> 
              <!--[if lte IE 7]>
            <label for="RegistrationForm_email" class="control-label required">Direccion Linea 1: (Avenida, Calle, Urbanizacion, Conjunto Residencial, etc.) <span class="required">*</span></label>
<![endif]-->
              <div class="controls">
                <input type="text" class="span5" name="RegistrationForm[email]" placeholder="Direccion Linea 1: (Avenida, Calle, Urbanizacion, Conjunto Residencial, etc.)" id="RegistrationForm_email" maxlength="128">
                <div class="help-inline" id="RegistrationForm_email_em_" style="display:none"></div>
              </div>
            </div>
            <div class="control-group"> 
              <!--[if lte IE 7]>
            <label for="RegistrationForm_email" class="control-label required">Direccion Linea 2: (Edificio, Piso, Numero, Apartamento, etc) </label>
<![endif]-->
              <div class="controls">
                <input type="text" class="span5" name="RegistrationForm[email]" placeholder="Direccion Linea 2: (Edificio, Piso, Numero, Apartamento, etc)" id="RegistrationForm_email" maxlength="128">
                <div class="help-inline" id="RegistrationForm_email_em_" style="display:none"></div>
              </div>
            </div>
            <div class="control-group"> 
              <!--[if lte IE 7]>
            <label for="RegistrationForm_email" class="control-label required">Ciudad <span class="required">*</span></label>
<![endif]-->
              <div class="controls">
                <input type="text" class="span5" name="RegistrationForm[email]" placeholder="Ciudad" id="RegistrationForm_email" maxlength="128">
                <div class="help-inline" id="RegistrationForm_email_em_" style="display:none"></div>
              </div>
            </div>
            <div class="control-group"> 
              <!--[if lte IE 7]>
            <label for="RegistrationForm_email" class="control-label required">Estado <span class="required">*</span></label>
<![endif]-->
              <div class="controls">
                <input type="text" class="span5" name="RegistrationForm[email]" placeholder="Estado" id="RegistrationForm_email" maxlength="128">
                <div class="help-inline" id="RegistrationForm_email_em_" style="display:none"></div>
              </div>
            </div>
            <div class="control-group"> 
              <!--[if lte IE 7]>
            <label for="RegistrationForm_email" class="control-label required">País <span class="required">*</span></label>
<![endif]-->
              <div class="controls">
                <select>
                  <option>Venezuela</option>
                  <option>Colombia</option>
                  <option>USA</option>
                </select>
                <div class="help-inline" id="RegistrationForm_email_em_" style="display:none"></div>
              </div>
            </div>
          </fieldset>
   
  </div>
  <div class="modal-footer"> <a href="#" title="eliminar">Cancelar</a> <a href="" title="ver" class="btn btn-danger">Guardar</a> </div>
</div>
<!------------------- MODAL WINDOW OFF ----------------->

