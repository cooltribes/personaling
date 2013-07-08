<?php
$this->breadcrumbs=array(
	'Productos'=>array('admin'),
	'SEO',
);

?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Producto - SEO</small></h1>
  </div>
  
<?php echo $this->renderPartial('menu_agregar_producto', array('model'=>$model,'opcion'=>7)); ?>
  
  <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'producto-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<?php echo $form->errorSummary($model); ?>
  
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked form-horizontal" enctype="multipart/form-data">
          <fieldset>
          	<legend >SEO: </legend>

          <div class="control-group">
                    <?php  echo $form->textFieldRow($seo, 'mTitulo', array('class'=>'span5')); ?>
                <div class="controls">    
                <div class=" muted">Título para la página del navegador al ver el producto</div>
                </div>
            </div>
            <div class="control-group">
              		<?php echo $form->textFieldRow($seo, 'mDescripcion', array('class'=>'span5')); ?>
                <div class="controls">
                <div class=" muted">Descripción del producto para mostrar a los buscadores web</div>
                </div>
             </div>
            <div class="control-group">
                 	<?php echo $form->textFieldRow($seo, 'pClave', array('class'=>'span5')); ?>
                 <div class="controls">
                <div class=" muted">Lista de palabras clave relacionadas con el producto, separadas por coma (,)</div>
                </div>
            </div>
            <div class="control-group">
                 	<?php echo $form->textFieldRow($seo, 'urlAmigable', array('class'=>'span5')); ?>
                 <div class="controls">
                <div class=" muted">Dirección URL del producto</div>
                </div>
            </div>
          </fieldset>
        </form>
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
        <div id="scroller-anchor"></div>
        <div id="scroller">
         <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'danger',
			'size' => 'large',
			'block'=>'true',
			'label'=>'Guardar',
		)); ?>
          <ul class="nav nav-stacked nav-tabs margin_top">
			 <li><a style="cursor: pointer" title="Restablecer" id="limpiar">Limpiar Formulario</a></li>
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
<?php $this->endWidget(); ?>

<script type="text/javascript">
		
		$('a#limpiar').on('click', function() {
			
			$('#producto-form').each (function(){
			  this.reset();
			});

       });
		
		
</script>
