<?php
$this->breadcrumbs=array(
	'Productos'=>array('admin'),
	'Inventario',
);

?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Producto - Inventario</small></h1>
  </div>
  <!-- SUBMENU ON -->

<?php echo $this->renderPartial('menu_agregar_producto', array('model'=>$model,'opcion'=>7)); ?>
  
  <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'producto-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>

	<?php echo $form->errorSummary($model, Funciones::errorMsg()); ?>

  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked form-horizontal" enctype="multipart/form-data">
          <fieldset>            <legend >Inventario: </legend>

          
            <div class="control-group">
                <?php echo $form->labelEx($inventario,'cantidad', array('class' => 'control-label required')); ?>
              <div class="controls">
                <?php echo $form->textField($inventario,'cantidad',array('class'=>'span5')); ?>
                <?php echo $form->error($inventario,'cantidad'); ?>
              </div>
            </div>
			<div class="control-group">
                <?php echo $form->labelEx($inventario,'tope', array('class' => 'control-label required')); ?>
              <div class="controls">
                <?php echo $form->textField($inventario,'tope',array('class'=>'span5')); ?>
                <?php echo $form->error($inventario,'tope'); ?>
              </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($inventario,'minimaCompra', array('class' => 'control-label required')); ?>
              <div class="controls">
                <?php echo $form->textField($inventario,'minimaCompra',array('class'=>'span5','value'=>'1')); ?>
                 <div class=" muted">La cantidad mínima para pedir este producto<br/> (definir 1 para desactivar esta aplicación)</div>
                <?php echo $form->error($inventario,'minimaCompra'); ?>
              </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($inventario,'maximaCompra', array('class' => 'control-label required')); ?>
              <div class="controls">
                <?php echo $form->textField($inventario,'maximaCompra',array('class'=>'span5')); ?>
                <?php echo $form->error($inventario,'maximaCompra'); ?>
              </div>
            </div>
			<div class="control-group">
                <?php echo $form->labelEx($inventario,'disponibilidad', array('class' => 'control-label required')); ?>
              <div class="controls">
                <?php echo $form->textField($inventario,'disponibilidad',array('class'=>'span5')); ?>
                <?php echo $form->error($inventario,'disponibilidad'); ?>
              </div>
            </div>
            
          </fieldset>
        </form>
      </div>
    </div>
    <div class="span3">
      <div class="padding_left">           
      	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'danger',
			'size' => 'large',
			'block'=>'true',
			'label'=>'Guardar',
		)); ?>
        <ul class="nav nav-stacked nav-tabs margin_top">
          <li><a style="cursor: pointer" title="Restablecer" id="limpiar">Limpiar</a></li>
          <li><a href="#" title="Duplicar">Duplicar</a></li>
          <li><a href="#" title="Guardar"><i class="icon-trash"> </i>Borrar</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- /container -->
<?php $this->endWidget(); ?>

<script type="text/javascript">
	
		$('#limpiar').on('click', function() {
           $("#producto-form input[type=text]").val('');
           $("#producto-form input[type=text]").value('');
           
           $("#producto-form textarea").val("");
           $("#producto-form textarea").value("");
            
           $("#producto-form select").val('-1');
           $("#producto-form select").value('-1');
           
           $("#producto-form input[type=radio]").val('0');
             $("#producto-form input[type=radio]").value('0');
           
           $("#producto-form input[type=checkbox]").val('false');
           $("#producto-form input[type=checkbox]").value('false');
           
           $("#producto-form")[0].reset();
           $("#producto-form")[3].reset();
       });
	
	
</script>
</script>