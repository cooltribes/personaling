
<div class="container margin_top">
  <div class="page-header">
    <h1>Editar estilos</h1>
  </div>
  <!-- SUBMENU ON -->
  <?php $this->renderPartial('_menu', array('model'=>$model)); ?>
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'tuestilo-form',
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
            <div class="controls controls-row">
              <?php $field = ProfileField::model()->findByAttributes(array('varname'=>'coctel')); ?>
              <?php echo $form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range)); ?> </div>
          </div>
          <div class="control-group">
            <div class="control-group">
              <div class="controls controls-row">
                <?php $field = ProfileField::model()->findByAttributes(array('varname'=>'fiesta')); ?>
                <?php echo $form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range)); ?> </div>
            </div>
          </div>
          <div class="control-group">
            <div class="controls controls-row">
              <?php $field = ProfileField::model()->findByAttributes(array('varname'=>'playa')); ?>
              <?php echo $form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range)); ?> </div>
          </div>
          <div class="control-group">
            <div class="controls controls-row">
              <?php $field = ProfileField::model()->findByAttributes(array('varname'=>'sport')); ?>
              <?php echo $form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range)); ?> </div>
          </div>
          <div class="control-group">
            <div class="controls controls-row">
              <?php $field = ProfileField::model()->findByAttributes(array('varname'=>'trabajo')); ?>
              <?php echo $form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range)); ?> </div>
          </div>
        </fieldset>
        <?php $this->endWidget(); ?>
      </div>
    </div>
    <div class="span3">
      <div class="padding_left"> 
        <!-- SIDEBAR OFF --> 
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
        <div>
          <div id="scroller-anchor"></div>
          <div id="scroller">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
            				'buttonType'=>'button',
						    'label'=>'Guardar',
						    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						    'size'=>'large', // null, 'large', 'small' or 'mini'
						    'block'=>'true',
						    'htmlOptions'=>array('onclick'=>'js:$("#tuestilo-form").submit();')
						)); ?>
            <ul class="nav nav-stacked nav-tabs margin_top">
              <li><a href="#" title="Restablecer"><i class="icon-repeat"></i> Restablecer</a></li>
              <li><a href="#" title="Guardar"><i class="icon-envelope"></i> Enviar mensaje</a></li>
              <li><a href="#" title="Desactivar"><i class="icon-off"></i> Desactivar</a></li>
            </ul>
          </div>
        </div>
        <script type="text/javascript"> 
		// Script para dejar el sidebar fijo Parte 2
			$(function() {
				moveScroller();
			 });
		</script> 
        <!-- SIDEBAR OFF --> 
        
      </div>
    </div>
  </div>
</div>
<!-- /container --> 

