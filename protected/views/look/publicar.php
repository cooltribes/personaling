<?php
$this->breadcrumbs=array(
	'Looks'=>array('admin'),
	'Publicar',
);

?>
<div class="container margin_top" id="crear_look">
  <div class="page-header">
    <h1>Publicar Look</h1>
  </div>
  <div class="row">
    <section class="span6"><img src="images/look_sample_grande_1.jpg" width="770" height="640"  class="img_1" alt="Look"> 
      
      <!-- Tabla  para el admin ON -->
      <hr/>
      <h4>Productos que componen el Look </h4>
      <table width="100%" class="table">
        <thead>
          <tr>
            <th colspan="2">Producto</th>
            <th>Cantidad</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><img class="margin_bottom" src="http://placehold.it/70x70"></td>
            <td><strong>Vestido Stradivarius</strong></td>
            <td width="8%"><input type="text" class="span1" value="10" placeholder="Cant." maxlength="2">
              <a class="btn btn-mini" href="#">Actualizar</a></td>
          </tr>
          <tr>
            <td><img class="margin_bottom" src="http://placehold.it/70x70"></td>
            <td><strong>Camisa The New Pornographers</strong></td>
            <td><input type="text" class="span1" value="0" placeholder="Cant." maxlength="2">
              <a class="btn btn-mini" href="#">Actualizar</a></td>
          </tr>
          <tr>
            <td><img class="margin_bottom" src="http://placehold.it/70x70"></td>
            <td><strong>Pantalón Ok Go</strong></td>
            <td><input type="text" class="span1" value="5" placeholder="Cant." maxlength="2">
              <a class="btn btn-mini" href="#">Actualizar</a></td>
          </tr>
        </tbody>
      </table>
      
      <!-- Tabla  para el admin OFF --> 
    </section>
    <section class="span6 ">
      <form class="well personaling_form">
        <legend>Ultimo paso</legend>
        <p>LLena los siguientes campos:</p>
        <div class="control-group"> 
          <!--[if lte IE 7]>
            <label class="control-label required">Titulo del look <span class="required">*</span></label>
<![endif]-->
          <div class="controls">
            <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Titulo del look, ej.: Look de Verano Europeo" name="RegistrationForm[email]" class="span4">
            <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
          </div>
        </div>
        <div class="control-group"> 
          <!--[if lte IE 7]>
            <label class="control-label required">Descripción del look <span class="required">*</span></label>
<![endif]-->
          <div class="controls">
            <textarea class="span5" rows="6" placeholder="Descripción del look"></textarea>
            <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
          </div>
        </div>
        
        <!-- Para el admin ON -->
        <div class="control-group ">
          <div class="controls">
            <label class="checkbox">
              <input type="checkbox" value="option1">
              Se publicara con fecha de Inicio y fin </label>
          </div>
        </div>
        <div class="control-group margin_top">
          <div class="controls controls-row">
            <div class="span1">Inicio </div>
            <select placeholder=".span4" type="text" class="span1">
              <option>Dia</option>
              <option>01</option>
              <option>02</option>
            </select>
            <select placeholder=".span4" type="text" class="span1">
              <option>Mes</option>
              <option>01</option>
              <option>02</option>
            </select>
            <select placeholder=".span4" type="text" class="span1">
              <option>Año</option>
              <option>01</option>
              <option>02</option>
            </select>
          </div>
        </div>
        <div class="control-group">
          <div class="controls controls-row">
            <div class="span1">Fin </div>
            <select placeholder=".span4" type="text" class="span1">
              <option>Dia</option>
              <option>01</option>
              <option>02</option>
            </select>
            <select placeholder=".span4" type="text" class="span1">
              <option>Mes</option>
              <option>01</option>
              <option>02</option>
            </select>
            <select placeholder=".span4" type="text" class="span1">
              <option>Año</option>
              <option>01</option>
              <option>02</option>
            </select>
          </div>
        </div>
        <!-- Para el admin OFF -->
        
        <hr/>
        <h4>¿En que ocasión se puede usar este look?</h4>
        <div class="control-group">
          <label class="control-label required">Fiesta:</label>
          <div class="controls">
            <div data-toggle="buttons-checkbox" class="btn-group">
              <button class="btn btn-small" type="button">Reunión Familiar</button>
              <button class="btn btn-small" type="button">Graduación</button>
              <button class="btn btn-small" type="button">Cita Romántica</button>
              <button class="btn btn-small" type="button">Boda</button>
              <button class="btn btn-small" type="button">Plan de amigas</button>
              <button class="btn btn-small" type="button">Cóctel</button>
            </div>
            <div class=" muted" style="display:none">Ayuda</div>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label required">Oficina:</label>
          <div class="controls">
            <div data-toggle="buttons-checkbox" class="btn-group">
              <button class="btn btn-small" type="button">Diario</button>
              <button class="btn btn-small" type="button">Evento Especial</button>
              <button class="btn btn-small" type="button">Sexy</button>
            </div>
            <div class=" muted" style="display:none">Ayuda</div>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label required">Vacaciones:</label>
          <div class="controls">
            <div data-toggle="buttons-checkbox" class="btn-group">
              <button class="btn btn-small" type="button">Playa</button>
              <button class="btn btn-small" type="button">Montaña</button>
            </div>
            <div class=" muted" style="display:none">Ayuda</div>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label required">Haciendo Deporte:</label>
          <div class="controls">
            <div data-toggle="buttons-checkbox" class="btn-group">
              <button class="btn btn-small" type="button">Gym</button>
              <button class="btn btn-small" type="button">Aire libre</button>
            </div>
            <div class=" muted" style="display:none">Ayuda</div>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label required">Diario:</label>
          <div class="controls">
            <div data-toggle="buttons-checkbox" class="btn-group">
              <button class="btn btn-small" type="button">Elegante</button>
              <button class="btn btn-small" type="button">Casual</button>
              <button class="btn btn-small" type="button">Cómodo</button>
              <button class="btn btn-small" type="button">En clases</button>
              <button class="btn btn-small" type="button"> Los must de tu armario</button>
            </div>
            <div class=" muted" style="display:none">Ayuda</div>
          </div>
        </div>
        <hr/>
        <h4> ¿Que estilo se adapta a este look: atrevido/ conservador?</h4>
        <div class="control-group">
          <div class="controls">
            <label class="checkbox inline">
              <input type="checkbox" value="option1">
              Atrevido </label>
            <label class="checkbox inline">
              <input type="checkbox" value="option2">
              Conservador </label>
            <div class=" muted" style="display:none">Ayuda</div>
          </div>
        </div>
        <hr/>
        <h4>Escoge al tipo de usuaria que favorece</h4>
        <div class="control-group">
          <label class="control-label required">Condición Física:</label>
          <div class="controls">
            <div data-toggle="buttons-checkbox" class="btn-group">
              <button class="btn btn-small" type="button">Delgada</button>
              <button class="btn btn-small" type="button">Media</button>
              <button class="btn btn-small" type="button">Gruesa</button>
              <button class="btn btn-small" type="button">Muy Gruesa</button>
            </div>
            <div class=" muted" style="display:none">Ayuda</div>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label required">Color de Cabello:</label>
          <div class="controls">
            <div data-toggle="buttons-checkbox" class="btn-group">
              <button class="btn btn-small" type="button">Rubio</button>
              <button class="btn btn-small" type="button">Castaño Claro</button>
              <button class="btn btn-small" type="button">Castaño Oscuro</button>
              <button class="btn btn-small" type="button">Negro</button>
              <button class="btn btn-small" type="button">Rojo</button>
              <button class="btn btn-small" type="button">Blanco</button>
            </div>
            <div class=" muted" style="display:none">Ayuda</div>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label required">Altura:</label>
          <div class="controls">
            <div data-toggle="buttons-checkbox" class="btn-group">
              <button class="btn btn-small" type="button">-1.55 a 1.65</button>
              <button class="btn btn-small" type="button">1.66 a 1.75</button>
              <button class="btn btn-small" type="button">1.76 a 1.85</button>
              <button class="btn btn-small" type="button">1.86 a 1.95</button>
            </div>
            <div class=" muted" style="display:none">Ayuda</div>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label required">Color de Ojos:</label>
          <div class="controls">
            <div data-toggle="buttons-checkbox" class="btn-group">
              <button class="btn btn-small" type="button">Verde</button>
              <button class="btn btn-small" type="button">Azul</button>
              <button class="btn btn-small" type="button">Ambar</button>
              <button class="btn btn-small" type="button">Marrón</button>
              <button class="btn btn-small" type="button">Gris</button>
              <button class="btn btn-small" type="button">Negro</button>
            </div>
            <div class=" muted" style="display:none">Ayuda</div>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label required">Forma de Cuerpo :</label>
          <div class="controls">
            <div data-toggle="buttons-checkbox" class="btn-group">
              <button class="btn btn-small" type="button">Rectangular</button>
              <button class="btn btn-small" type="button">Curvilíneo</button>
              <button class="btn btn-small" type="button">Triángulo</button>
              <button class="btn btn-small" type="button">Triángulo Invertido</button>
            </div>
            <div class=" muted" style="display:none">Ayuda</div>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label required">Color de Piel:</label>
          <div class="controls">
            <div data-toggle="buttons-checkbox" class="btn-group">
              <button class="btn btn-small" type="button">Blanca</button>
              <button class="btn btn-small" type="button">Morena</button>
              <button class="btn btn-small" type="button">Rosada</button>
              <button class="btn btn-small" type="button">Amarilla</button>
            </div>
            <div class=" muted" style="display:none">Ayuda</div>
          </div>
        </div>
        <div class="form-actions"> <a href="#" title="Cancelar" data-dismiss="modal" class="btn btn-link"> Cancelar</a> <a href="Look_seleccionado.php" title="Publicar" class="btn btn-danger btn-large" >Publicar Look</a> </div>
      </form>
      <!------------------- MODAL WINDOW OFF -----------------> 
      
    </section>
  </div>
</div>

