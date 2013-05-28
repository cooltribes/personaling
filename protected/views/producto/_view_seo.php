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
          	<legend >Precios: </legend>

          <div class="control-group">
                    <?php  echo $form->textFieldRow($seo, 'mTitulo', array('class'=>'span5')); ?>
                <div class="controls">    
                <div class=" muted">Título para la página del navegador al ver el producto</div>
                </div>
            </div>
            <div class="control-group">
              		<?php echo $form->textFieldRow($seo, 'mDescripcion', array('class'=>'span5')); ?>
                <div class="controls">
                <div class=" muted">Descripcion del producto para mostrar a los buscadores web</div>
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
		
</script>
