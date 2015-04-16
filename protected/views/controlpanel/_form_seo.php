<?php 
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
  'id'=>'seo-form',
  'enableAjaxValidation'=>false,
  'enableClientValidation'=>true,
  'type'=>'horizontal',
));

$disabled = '';
if(!$model->isNewRecord){
  $disabled = 'disabled';
}
?>


<!-- SUBMENU OFF -->

<div class="span9">
  <?php echo $form->errorSummary($model, Funciones::errorMsg()); ?>
  <div class="bg_color3   margin_bottom_small padding_small box_1">
    <fieldset>
      <div class="control-group">
        <?php echo $form->labelEx($model,'name', array('class' => 'control-label')); ?>
        <div class="controls">
          <?php echo $form->textField($model,'name',array('class'=>'span5','maxlength'=>50, 'placeholder' => 'Nombre', 'disabled' => $disabled)); ?>
          <?php echo $form->error($model,'name'); ?>
        </div>
      </div>
      <div class="control-group">
        <?php echo $form->labelEx($model,'title', array('class' => 'control-label')); ?>
        <div class="controls">
          <?php echo $form->textField($model,'title',array('class'=>'span5','maxlength'=>80, 'placeholder' => 'Titulo')); ?>
          <?php echo $form->error($model,'title'); ?>
        </div>
      </div>
      <div class="control-group">
        <?php echo $form->labelEx($model,'description', array('class' => 'control-label')); ?>
        <div class="controls">
          <?php echo $form->textArea($model,'description',array('class'=>'span5', 'placeholder' => 'Descripción')); ?>
          <?php echo $form->error($model,'description'); ?>
        </div>
      </div>
      <div class="control-group">
        <?php echo $form->labelEx($model,'keywords', array('class' => 'control-label')); ?>
        <div class="controls">
          <?php echo $form->textField($model,'keywords',array('class'=>'span5','maxlength'=>140, 'placeholder' => 'Palabras clave')); ?>
          <?php echo $form->error($model,'keywords'); ?>
        </div>
      </div>
      <div class="control-group">
        <?php echo $form->labelEx($model,'url', array('class' => 'control-label')); ?>
        <div class="controls">
          <?php echo $form->textField($model,'url',array('class'=>'span5','maxlength'=>180, 'placeholder' => 'Url')); ?>
          <?php echo $form->error($model,'url'); ?>
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

    </div>
    <script type="text/javascript"> 
      // Script para dejar el sidebar fijo Parte 2
      $(function() {
        moveScroller();
      });
    </script>
  </div>
</div>

<?php $this->endWidget(); ?>