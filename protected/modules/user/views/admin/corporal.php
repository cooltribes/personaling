
<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Usuario</small></h1>
  </div>
  <!-- SUBMENU ON -->
   <?php $this->renderPartial('_menu', array('model'=>$model)); ?>
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked form-horizontal" enctype="multipart/form-data">
          <fieldset>
            <legend >Perfil Corporal: </legend>
            <div class="control-group">
              <label for="" class="control-label ">Altura</label>
              <div class="controls">
                <select class="span5" type="text" >
                  <option>1,55 - 1,65</option>
                  <option> 1,66-1,75</option>
                  <option>1,76-1,85 </option>
                  <option>1,86-1,95 </option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Condición Física</label>
              <div class="controls">
                <select class="span5" type="text" >
                  <option>Delgada</option>
                  <option>Media</option>
                  <option>Gruesa</option>
                  <option>Muy Gruesa</option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Forma de Cuerpo</label>
              <div class="controls">
                <select class="span5" type="text" >
                  <option>Rectangular</option>
                  <option>Curvilíneo</option>
                  <option>Triángulo</option>
                  <option>Triángulo Invertido</option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Color de ojos</label>
              <div class="controls">
                <select class="span5" type="text" >
                  <option>Verde</option>
                  <option>Azul</option>
                  <option>Ámbar</option>
                  <option>Marrón</option>
                  <option>Negro</option>
                  <option>Gris</option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Color de Piel</label>
              <div class="controls">
                <select class="span5" type="text" >
                  <option>Blanca </option>
                  <option>Morena</option>
                  <option>Mulata</option>
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
          <li><a href="#" title="Guardar"><i class="icon-envelope"></i> Enviar mensaje</a></li>
          <li><a href="#" title="Desactivar"><i class="icon-off"></i> Desactivar</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- /container -->
