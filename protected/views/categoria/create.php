<?php
$this->breadcrumbs=array(
	'Categorias'=>array('index'),
	'Crear',
);

?>
<div class="container margin_top">
  <div class="page-header">
    <h1>Crear Categoría</h1>
  </div>

  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked form-horizontal" enctype="multipart/form-data">
          <fieldset>
          
          <div class="row">
              <div class="span2 offset2"><img src="http://placehold.it/150x150"/></div>
              <div class="span3 margin_top"><a href="#" class="btn">Aqui va el plugin del uploader</a></div>
            </div>
          <hr/>
            <legend >Categoría XXYYZZ: </legend>
            <div class="control-group">
              <label  class="control-label ">Nombre </label>
              <div class="controls">
                <input type="text" placeholder="Nombre"  class="span5">
                <div style="display:none"  class="help-inline"></div>
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label ">Descripción</label>
              <div class="controls">
                <textarea placeholder="Ej.: pantalones de lana"  class="span5"></textarea>
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
           
            
            <div class="control-group">
              <label  class="control-label ">Estado </label>
              <div class=""controls controls-row"">
                <label class="checkbox inline">
                  <input type="radio"  name="optionsRadios" value="option1">
                  Activa </label>
                <label class="checkbox inline">
                  <input type="radio"  name="optionsRadios" value="option2">
                  Inactiva </label>
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label ">Meta título</label>
              <div class="controls">
                <input type="text" placeholder="Meta título"  class="span5">
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
              <div class="control-group">
              <label  class="control-label ">Meta descripción</label>
              <div class="controls">
                <textarea placeholder="Meta descripción"  class="span5"></textarea>
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            
            <div class="control-group">
              <label  class="control-label ">Palabras clave</label>
              <div class="controls">
                <input type="text" placeholder="Ej.: pantalon, fashion, moda"  class="span5">
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            
                <div class="control-group">
              <label  class="control-label ">URL / Slug</label>
              <div class="controls">
                <input type="text" placeholder="http://personaling/..."  class="span5">
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            
            
          </fieldset>
        </form>
      </div>
    </div>
    <div class="span3">
      <div class="padding_left"> <a href="#" title="Guardar" class="btn btn-danger btn-large btn-block">Guardar</a>
        <ul class="nav nav-stacked nav-tabs margin_top">
  
          <li><a href="#" title="Desactivar">Cancelar</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- /container -->
