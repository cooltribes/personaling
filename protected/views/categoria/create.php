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
  
  <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true, 
	),
	'htmlOptions'=>array('class'=>'form-stacked form-horizontal'),
)); ?>

  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked form-horizontal" enctype="multipart/form-data">
          <fieldset>
          
          <div class="row">
              <div class="span2 offset2"><img src="http://placehold.it/150x150"/></div>
              <div class="span3 margin_top">
              	<?php echo CHtml::activeFileField($model,'urlImagen'); ?>
              </div>
            </div>
          <hr/>
            <legend >Categoría <?php //NOMBRE ?>: </legend>
            <div class="control-group">
            	<label  class="control-label ">Nombre </label>
            	<div class="controls">
              		<?php echo $form->textField($model,'nombre',array('class'=>'span5','maxlength'=>70,'placeholder'=>'Nombre')); 
              		// <input type="text" placeholder="Nombre"  class="span5">
              		?>
                <div style="display:none" class="help-inline"></div>
              </div>
            </div>
            <?php 
            $cat = Categoria::model()->findAllByAttributes(array('id'=>'1','padreId'=>'0'));
			$cats = array();
			
            ?>
            <div class="control-group">
              <label  class="control-label ">Categoría Padre</label>
              <div class="controls">
              	<select id="Categoria_padreId" name="Categoria[padreId]" class="span5" >
				<option>Seleccione...</option>
				<?php
				nodos($cat,$form,$model); 
	
				function nodos($items,$form,$model){
					foreach ($items as $item){
						
						echo("<option value='".$item->id."'>".$item->nombre."</option>");
						
						if ($item->hasChildren()){
							nodos($item->getChildren(),$form,$model);
						}
					}
					return 1;
				}
				
				?>
				</select>
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            
            <div class="control-group">
              <label  class="control-label ">Descripción</label>
              <div class="controls">
              	<?php echo $form->textArea($model,'descripcion',array('class'=>'span5','maxlength'=>200,'placeholder'=>'Ej.: pantalones de lana')); 
              		// <textarea placeholder="Ej.: pantalones de lana"  class="span5"></textarea>
              		?>   
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label ">Estado </label>
              <div class=""controls controls-row"">
              	<label class="checkbox inline">
              	<?php echo $form->radioButtonList($model, 'estado', array(0 => 'Activa', 1 => 'Inactiva',)); ?>
               </label>
               
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label ">Meta título</label>
              <div class="controls">
              	<?php echo $form->textField($model,'mTitulo',array('class'=>'span5','maxlength'=>70,'placeholder'=>'Meta título')); ?>
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
              <div class="control-group">
              <label  class="control-label ">Meta descripción</label>
              <div class="controls">
              	<?php echo $form->textArea($model,'mDescripcion',array('class'=>'span5','maxlength'=>200,'placeholder'=>'Meta descripción')); 
              		// <textarea placeholder="Meta descripción"  class="span5"></textarea>
              		?>
                
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            
            <div class="control-group">
              <label  class="control-label ">Palabras clave</label>
              <div class="controls">
              	<?php echo $form->textField($model,'pClaves',array('class'=>'span5','maxlength'=>70,'placeholder'=>'Ej.: pantalon, fashion, moda')); ?>
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            
                <div class="control-group">
              <label  class="control-label ">URL / Slug</label>
              <div class="controls">
              	<?php echo $form->textField($model,'urlSugerida',array('class'=>'span5','maxlength'=>70,'placeholder'=>'http://personaling/...')); ?>
                <div style="display:none" class="help-inline">ayuda aqui </div>
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
  
          <li><a href="#" title="Desactivar">Cancelar</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- /container -->

<?php $this->endWidget(); ?>
