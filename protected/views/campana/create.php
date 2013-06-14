<?php
/* @var $this CampanaController */

$this->breadcrumbs=array(
	'Campañas'=>array('/campana'),
	'Crear',
);
?>
<div class="container margin_top">

  <div class="page-header">
    <h1>Crear/Editar Campaña</h1>
  </div>
  <div class="row ">
    <div class="span9">
     
        <form class="form-stacked form-horizontal" enctype="multipart/form-data">
         
          <div class="bg_color3   margin_bottom_small padding_small box_1">
           <fieldset>
                                   <legend >Datos básicos: </legend>

            <div class="control-group margin_top personaling_form">
              <label for="RegistrationForm_email" class="control-label required  margin_top_xsmall">Nombre de la campaña </label>
              <div class="controls">
                <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Nombre/Titulo" name="RegistrationForm[email]" class="span5">
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            </fieldset>
            </div>
             <div class="bg_color3   margin_bottom_small padding_small box_1">
            <fieldset>
                        <legend >Recepción de los Looks: </legend>

           
            <div class="control-group">
                          <label for="" class="control-label required"> Inicio</label>

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
                          <label for="" class="control-label required"> Hasta</label>

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
             
             
             </fieldset>
              <fieldset>
                        <legend >Ventas: </legend>

             
                <div class="control-group">
                          <label for="" class="control-label required"> Inicio de la Campaña</label>

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
                          <label for="" class="control-label required"> Fin de la Campaña</label>

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
              <label for="" class="control-label required">Estado </label>
              <div class=""controls controls-row"">
                <label class="checkbox inline">
                  <input type="radio" id="inlineCheckbox1" name="optionsRadios" value="option1">
                  Invitar a todos los Personal Shoppers </label>
                <label class="checkbox inline">
                  <input type="radio" id="inlineCheckbox1" name="optionsRadios" value="option2">
                  Elegir Personal Shoppers </label>
                <div style="display:none" id="_em_" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            
          </fieldset>
          
           </div>
        </form>
     
    </div>
    <div class="span3">
      <div class="padding_left"> <a href="admin_anadir_campana_2.php" title="Guardar" class="btn btn-danger btn-large btn-block">Siguiente / Guardar</a>
        <ul class="nav nav-stacked nav-tabs margin_top">
          <li><a href="#" title="Restablecer">Restablecer</a></li>
                      <li><a title="Pausar" href="admin_anadir_campana.php"> <i class="icon-pause"> </i> Pausar (solo debe salir Pausa o Play)</a></li>
            <li><a title="Play" href="admin_anadir_campana.php"> <i class="icon-play"> </i> Reanudar canpaña</a></li>

          <li><a href="#" title="Duplicar">Duplicar campaña</a></li>
          <li><a href="#" title="Guardar"><i class="icon-trash"></i> Borrar campaña</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- /container -->