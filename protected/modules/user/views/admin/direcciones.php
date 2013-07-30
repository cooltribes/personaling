
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
          <fieldset class="bg_color3   margin_bottom_small padding_small box_1">
            <legend >Direcciones de envio: </legend>
            
			
          <?php
          		$direcciones = Direccion::model()->findAllByAttributes(array('user_id'=>$model->id));
          		$contador = 1;
				
				if(count($direcciones)>1)
				{
					foreach($direcciones as $dir)
					{
						echo '<div class="well well-small clearfix">';
						echo '<div class="pull-right">';
				        echo '<a class="btn" href="#myModal" role="button" data-toggle="modal" >
				          		<i class="icon-edit"></i></a>
				          	<a href="#" title="borrar" class="btn btn-link">
				          		<i class="icon-remove"></i></a>
				          </div>';
						echo '<h4 class="braker_bottom padding_bottom_xsmall"> Dirección '.$contador.'</h4>';
				      
				        echo '<div class="vcard">';
				        echo '<div class="adr">';
						echo '<div class="street-address"><i class="icon-map-marker"></i>'.$dir->dirUno.'. '.$dir->dirDos.'</div>';
						echo '<span class="locality">'.$dir->ciudad.', '.$dir->estado.'</span>';
						echo '<div class="country-name">'.$dir->pais.'</div>';
				        echo "</div>";
				        
				        echo '<div class="tel margin_top_small"><span class="type"><strong>Telefono</strong>:</span> '.$dir->telefono.' </div>';
				      //  echo '<div><strong>Email</strong>: <span class="email">info@commerce.net</span> </div>';
				        echo '</div>';
						echo '</div>';
						
						$contador++;
						
					}
				}
				else
					{
						echo '<div class="well well-small clearfix"> No existen direcciones de envío asociadas a este usuario. </div>';
					}
          	?>
<!--
	<div class="well well-small clearfix">
                      <div class="pull-right"> <a class="btn" href="#myModal"  role="button" data-toggle="modal" ><i class="icon-edit"></i></a> <a href="#" title="borrar" class="btn btn-link"><i class="icon-remove"></i></a> </div> <h4 class="braker_bottom padding_bottom_xsmall">Dirección 2</h4>
          <div class="vcard">
            <div class="adr">
              <div class="street-address"><i class="icon-map-marker"></i> Av. 5ta. Edificio Los Mirtos  Piso 3. Oficina 3-3</div>
              <span class="locality">San Cristobal, Tachira 5001</span>
              <div class="country-name">Venezuela</div>
            </div>
            <div class="tel margin_top_small"> <span class="type"><strong>Telefono</strong>:</span> 0276-341.47.12 </div>
            <div class="tel"> <span class="type"><strong>Celular</strong>:</span> 0414-724.80.43 </div>
            <div><strong>Email</strong>: <span class="email">info@commerce.net</span> </div>
          </div>
</div>
-->            
   
          </fieldset>
   
          <!--
          <fieldset class="bg_color3   margin_bottom_small padding_small box_1">
            <legend >Direcciones de Facturación: </legend>
            
            <div class="well well-small clearfix">
                      <div class="pull-right"> <a class="btn" href="#myModal"  role="button" data-toggle="modal" ><i class="icon-edit"></i></a> <a href="#" title="borrar" class="btn btn-link"><i class="icon-remove"></i></a> </div> <h4 class="braker_bottom padding_bottom_xsmall">Dirección 4</h4>
          <div class="vcard">
            <div class="adr">
              <div class="street-address"><i class="icon-map-marker"></i> Av. 5ta. Edificio Los Mirtos  Piso 3. Oficina 3-3</div>
              <span class="locality">San Cristobal, Tachira 5001</span>
              <div class="country-name">Venezuela</div>
            </div>
            <div class="tel margin_top_small"> <span class="type"><strong>Telefono</strong>:</span> 0276-341.47.12 </div>
            <div class="tel"> <span class="type"><strong>Celular</strong>:</span> 0414-724.80.43 </div>
            <div><strong>Email</strong>: <span class="email">info@commerce.net</span> </div>
          </div>
</div>
<div class="well well-small clearfix">
                      <div class="pull-right"> <a class="btn" href="#myModal"  role="button" data-toggle="modal" ><i class="icon-edit"></i></a> <a href="#" title="borrar" class="btn btn-link"><i class="icon-remove"></i></a> </div> <h4 class="braker_bottom padding_bottom_xsmall">Dirección 5</h4>
          <div class="vcard">
            <div class="adr">
              <div class="street-address"><i class="icon-map-marker"></i> Av. 5ta. Edificio Los Mirtos  Piso 3. Oficina 3-3</div>
              <span class="locality">San Cristobal, Tachira 5001</span>
              <div class="country-name">Venezuela</div>
            </div>
            <div class="tel margin_top_small"> <span class="type"><strong>Telefono</strong>:</span> 0276-341.47.12 </div>
            <div class="tel"> <span class="type"><strong>Celular</strong>:</span> 0414-724.80.43 </div>
            <div><strong>Email</strong>: <span class="email">info@commerce.net</span> </div>
          </div>
</div>
<div class="well well-small clearfix">
                      <div class="pull-right"> <a class="btn" href="#myModal"  role="button" data-toggle="modal" ><i class="icon-edit"></i></a> <a href="#" title="borrar" class="btn btn-link"><i class="icon-remove"></i></a> </div> <h4 class="braker_bottom padding_bottom_xsmall">Dirección 6</h4>
          <div class="vcard">
            <div class="adr">
              <div class="street-address"><i class="icon-map-marker"></i> Av. 5ta. Edificio Los Mirtos  Piso 3. Oficina 3-3</div>
              <span class="locality">San Cristobal, Tachira 5001</span>
              <div class="country-name">Venezuela</div>
            </div>
            <div class="tel margin_top_small"> <span class="type"><strong>Telefono</strong>:</span> 0276-341.47.12 </div>
            <div class="tel"> <span class="type"><strong>Celular</strong>:</span> 0414-724.80.43 </div>
            <div><strong>Email</strong>: <span class="email">info@commerce.net</span> </div>
          </div>
</div>
            
            
          </fieldset>
          -->
        </form>
      </div>
    </div>
    <div class="span3">
      <div class="padding_left"> <a href="#" title="Guardar" class="btn btn-danger btn-large btn-block">Guardar</a>
        <ul class="nav nav-stacked nav-tabs margin_top">
          <li><a href="#" title="Restablecer"><i class="icon-repeat"></i> Restablecer</a></li>
          <li><a href="#" title="Guardar"><i class="icon-envelope"></i> Enviar mensaje</a></li>
          <li><a href="#" title="Desactivar"><i class="icon-off"></i> Desactivar</a></li>
        </ul>
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

