
<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Avatar</h1>
  </div>
  <!-- SUBMENU ON -->
  <?php $this->renderPartial('_menu', array('model'=>$model, 'activo'=>7)); ?>
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked personaling_form" enctype="multipart/form-data">
          <fieldset>
            <legend >Avatar: </legend>
            <div class="row">
              <div class="span2"><img src="http://placehold.it/150x150"/></div>
              <div class="span3 margin_top"><a href="#" class="btn">Aqui va el plugin del uploader</a></div>
            </div>
            <div class="form-actions"> <a href="Crear_Perfil_Usuaria_Mi_Tipo.php" class="btn-large btn btn-danger">Guardar</a> </div>
          </fieldset>
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
