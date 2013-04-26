
<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Usuario</h1>
  </div>
  <!-- SUBMENU ON -->
  <?php $this->renderPartial('_menu', array('model'=>$model)); ?>
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked form-horizontal" enctype="multipart/form-data">
          <fieldset>
            <legend >Datos básicos: </legend>
            <div class="control-group">
              <label for="RegistrationForm_email" class="control-label ">Nombre de usuario </label>
              <div class="controls">
                <input type="text" placeholder="Nombre de usuario"  class="span5">
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Correo electrónico </label>
              <div class="controls">
                <input type="text" placeholder="Ej.: juanmiguel@email.com"  class="span5">
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Contraseña </label>
              <div class="controls">
                <input type="password" placeholder="Contraseña"  class="span5">
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Nombre</label>
              <div class="controls">
                <input type="text" placeholder="Nombre"  class="span5">
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Apellido</label>
              <div class="controls">
                <input type="text" placeholder="Apellido"  class="span5">
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label "> Fecha de nacimiento</label>
              <div class="controls controls-row">
                <select class="span1" type="text" >
                  <option>Dia</option>
                  <option>01</option>
                  <option>02</option>
                </select>
                <select class="span1" type="text" >
                  <option>Mes</option>
                  <option>01</option>
                  <option>02</option>
                </select>
                <select class="span1" type="text" >
                  <option>Año</option>
                  <option>01</option>
                  <option>02</option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Genero </label>
              <div class=""controls controls-row"">
                <label class="checkbox inline">
                  <input type="radio" id="inlineCheckbox1" name="optionsRadios" value="option1">
                  Mujer </label>
                <label class="checkbox inline">
                  <input type="radio" id="inlineCheckbox1" name="optionsRadios" value="option2">
                  Hombre </label>
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Cédula</label>
              <div class="controls">
                <input type="text" placeholder="Cédula"  class="span5">
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label "> País</label>
              <div class="controls">
                <select class="span5" type="text" >
                  <option>Venezuela</option>
                  <option>Colombia</option>
                  <option>USA</option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Ciudad</label>
              <div class="controls">
                <select class="span5" type="text" >
                  <option>San Cristóbal</option>
                  <option>item</option>
                  <option>item</option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Tipo de Usuario</label>
              <div class="controls">
                <select class="span5" type="text" >
                  <option>Usuario</option>
                  <option>item</option>
                  <option>item</option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Estado</label>
              <div class="controls">
                <select class="span5" type="text" >
                  <option>Invitado</option>
                  <option>item</option>
                  <option>item</option>
                </select>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
    <div class="span3">
      <div class="padding_left"> <a href="#" title="Guardar" class="btn btn-danger btn-large btn-block">Guardar</a>
        <ul class="nav nav-stacked nav-tabs margin_top">
          <li><a href="#" title="Restablecer"><i class="icon-repeat"></i> Restablecer</a></li>
          <li><a href="#" title="Guardar"><i class="icon-bell"></i> Crear / Enviar Intivacion</a></li>
          <li><a href="#" title="Guardar"><i class="icon-bell"></i> Reenviar Invitación</a></li>
          <li><a href="#" title="Desactivar"><i class="icon-off"></i> Desactivar</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- /container -->
