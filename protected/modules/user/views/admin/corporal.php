<?php 
  $this->breadcrumbs=array(
  'Usuarios'=>array('admin'),
  'Editar',);
?>
<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Usuario</small></h1>
  </div>
  <!-- SUBMENU ON -->
   <?php $this->renderPartial('_menu', array('model'=>$model, 'activo'=>2)); ?>
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        
       
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'tutipo-form',
	'htmlOptions'=>array('class'=>'form-stacked'),
    //'type'=>'stacked',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>        	
          <fieldset>
            <legend >Perfil Corporal: </legend>
            <div class="control-group">
             
              <div class="controls">
                <?php 
                  	$field = ProfileField::model()->findByAttributes(array('varname'=>'altura'));
				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range), array('class'=>'span5'));
                  ?>
              </div>
            </div>
            <div class="control-group">
              
              <div class="controls">
                  <?php 
                  	$field = ProfileField::model()->findByAttributes(array('varname'=>'contextura'));
				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range), array('class'=>'span5'));
                  ?>              </div>
            </div>
            <div class="control-group">
              
              <div class="controls">
                  <?php 
                  	$field = ProfileField::model()->findByAttributes(array('varname'=>'pelo'));
				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range), array('class'=>'span5'));
                  ?>
              </div>
            </div>
            <div class="control-group">
          
              <div class="controls">
                  <?php 
                  	$field = ProfileField::model()->findByAttributes(array('varname'=>'ojos'));
				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range), array('class'=>'span5'));
                  ?>
              </div>
            </div>
            <div class="control-group">
             
              <div class="controls">
                  <?php 
                  	$field = ProfileField::model()->findByAttributes(array('varname'=>'piel'));
				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range), array('class'=>'span5'));
                  ?>
              </div>
            </div>
            <div class="control-group">
             
              <div class="controls">
                  <?php 
                  	$field = ProfileField::model()->findByAttributes(array('varname'=>'tipo_cuerpo'));
				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range), array('class'=>'span5'));
                  ?>
              </div>
            </div>
          </fieldset>
           <?php $this->endWidget(); ?>
      </div>
    </div>
    <div class="span3">
      <div class="padding_left"> 

          <script> 
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
                    width: "240px"
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
        <div id="scroller">    
                              	 
                			<?php $this->widget('bootstrap.widgets.TbButton', array(
                				'buttonType'=>'button',
    						    'label'=>'Guardar',
    						    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    						    'size'=>'large', // null, 'large', 'small' or 'mini'
    						    'block'=>'true',
    						    'htmlOptions'=>array('onclick'=>'js:$("#tutipo-form").submit();')
    						)); ?>
    						
               
          	
            <ul class="nav nav-stacked nav-tabs margin_top">
              <li><a href="#" title="Limpiar Formulario" id="limpiar"><i class="icon-repeat"></i> Limpiar Formulario</a></li>
              <li><a href="#" title="Guardar"><i class="icon-envelope"></i> Enviar mensaje</a></li>
              <li><a href="#" title="Desactivar"><i class="icon-off"></i> Desactivar</a></li>
            </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $('#limpiar').on('click', function() {
      $('#tutipo-form').each (function(){
        this.reset();
      });
    });
    $(function() {
        moveScroller();
    });     

</script>
<!-- /container -->
