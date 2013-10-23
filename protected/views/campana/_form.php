<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'campana-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'type'=>'horizontal',
)); ?>
	

  <!-- SUBMENU OFF -->
  
    <div class="span9">
    	<?php echo $form->errorSummary($model); ?>
    	<div class="bg_color3   margin_bottom_small padding_small box_1">
           <fieldset>
            <legend >Datos básicos: </legend>
			<div class="control-group">
              <?php echo $form->labelEx($model,'nombre', array('class' => 'control-label')); ?>
              <div class="controls">
              	<?php echo $form->textField($model,'nombre',array('class'=>'span5','maxlength'=>50, 'placeholder' => 'Nombre/Titulo')); ?>
                <?php echo $form->error($model,'nombre'); ?>
              </div>
            </div>
			
            </fieldset>
            </div>
             <div class="bg_color3   margin_bottom_small padding_small box_1">
            <fieldset>
                        <legend >Recepción de los Looks: </legend>

           
            <div class="control-group">
              <?php echo $form->labelEx($model,'recepcion_inicio', array('class' => 'control-label')); ?>

              <div class="controls controls-row">
              
                <select class="span1" type="text" id="recepcion_inicio_day">
                  <option value="-1">Día</option>
                  <option value="01">01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option>
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option>
                  <option value="31">31</option>
                </select>
                <select class="span1" type="text" id="recepcion_inicio_month">
                  <option value="-1">Mes</option>
                  <option value="01">01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select>
                <select class="span1" type="text" id="recepcion_inicio_year">
                  <option value="-1">Año</option>
                  <option value="2013">2013</option>
                  <option value="2014">2014</option>
                  <option value="2015">2015</option>
                  <option value="2016">2016</option>
                  <option value="2017">2017</option>
                </select>
                <?php echo $form->hiddenField($model,'recepcion_inicio'); ?>
                <?php echo $form->error($model,'recepcion_inicio'); ?>
                
              </div>
            </div>
            <div class="control-group">
              <?php echo $form->labelEx($model,'recepcion_fin', array('class' => 'control-label')); ?>

              <div class="controls controls-row">
              
                <select class="span1" type="text" id="recepcion_fin_day">
                  <option value="-1">Día</option>
                  <option value="01">01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option>
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option>
                  <option value="31">31</option>
                </select>
                <select class="span1" type="text" id="recepcion_fin_month">
                  <option value="-1">Mes</option>
                  <option value="01">01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select>
                <select class="span1" type="text" id="recepcion_fin_year">
                  <option value="-1">Año</option>
                  <option value="2013">2013</option>
                  <option value="2014">2014</option>
                  <option value="2015">2015</option>
                  <option value="2016">2016</option>
                  <option value="2017">2017</option>
                </select>
                
                <?php echo $form->hiddenField($model,'recepcion_fin'); ?>
                <?php echo $form->error($model,'recepcion_fin'); ?>
        
              </div>
            </div>
             
             
             </fieldset>
              <fieldset>
                        <legend >Ventas: </legend>

             
                <div class="control-group">
                 <?php echo $form->labelEx($model,'ventas_inicio', array('class' => 'control-label')); ?>

              <div class="controls controls-row">
              
                <select class="span1" type="text" id="ventas_inicio_day">
                  <option value="-1">Día</option>
                  <option value="01">01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option>
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option>
                  <option value="31">31</option>
                </select>
                <select class="span1" type="text" id="ventas_inicio_month">
                  <option value="-1">Mes</option>
                  <option value="01">01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select>
                <select class="span1" type="text" id="ventas_inicio_year">
                  <option value="-1">Año</option>
                  <option value="2013">2013</option>
                  <option value="2014">2014</option>
                  <option value="2015">2015</option>
                  <option value="2016">2016</option>
                  <option value="2017">2017</option>
                </select>
                
                <?php echo $form->hiddenField($model,'ventas_inicio'); ?>
                <?php echo $form->error($model,'ventas_inicio'); ?>
          
              </div>
            </div>
            <div class="control-group">
              <?php echo $form->labelEx($model,'ventas_fin', array('class' => 'control-label')); ?>

              <div class="controls controls-row">
              
                <select class="span1" type="text" id="ventas_fin_day">
                  <option value="-1">Día</option>
                  <option value="01">01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option>
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option>
                  <option value="31">31</option>
                </select>
                <select class="span1" type="text" id="ventas_fin_month">
                  <option value="-1">Mes</option>
                  <option value="01">01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select>
                <select class="span1" type="text" id="ventas_fin_year">
                  <option value="-1">Año</option>
                  <option value="2013">2013</option>
                  <option value="2014">2014</option>
                  <option value="2015">2015</option>
                  <option value="2016">2016</option>
                  <option value="2017">2017</option>
                </select>
                
                <?php echo $form->hiddenField($model,'ventas_fin'); ?>
                <?php echo $form->error($model,'ventas_fin'); ?>
                
              </div>
            </div>
             
             
            <div class="control-group">
              <label for="" class="control-label required"> </label>
              <div class="controls controls-row">
                <label class="checkbox inline">
                  <input type="radio" id="ps_todos" name="personal_shopper" value="todos" checked>
                  Invitar a todos los Personal Shoppers </label>
                <label class="checkbox inline">
                  <input type="radio" id="ps_seleccionar" name="personal_shopper" value="seleccionar">
                  Elegir Personal Shoppers </label>
                <div style="display:none" id="_em_" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            
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
        		'id'=>'boton_guardar',
  			'buttonType'=>'submit',
  			'type'=>'danger',
  			'size' => 'large',
  			'block'=>'true',
  			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
  		)); ?>

        <ul class="nav nav-stacked nav-tabs margin_top">
          <li><a style="cursor: pointer" title="Restablecer" id="limpiar">Limpiar Formulario</a></li>
        
      <!--  <li><a title="Pausar" href="admin_anadir_campana.php"> <i class="icon-pause"> </i> Pausar (solo debe salir Pausa o Play)</a></li>
            <li><a title="Play" href="admin_anadir_campana.php"> <i class="icon-play"> </i> Reanudar campaña</a></li>
 -->
          <li><a href="#" title="Borrar"><i class="icon-trash"></i>Borrar campaña</a></li>
        </ul>

      </div>
    <script type="text/javascript"> 
    // Script para dejar el sidebar fijo Parte 2
      $(function() {
        moveScroller();
       });
    </script>
    </div>
    

    
    

<?php $this->endWidget(); ?>