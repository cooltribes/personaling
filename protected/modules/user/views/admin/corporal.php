
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
                  	 
            			<?php $this->widget('bootstrap.widgets.TbButton', array(
            				'buttonType'=>'button',
						    'label'=>'Guardar',
						    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						    'size'=>'large', // null, 'large', 'small' or 'mini'
						    'block'=>'true',
						    'htmlOptions'=>array('onclick'=>'js:$("#tutipo-form").submit();')
						)); ?>
						
           
      	
        <ul class="nav nav-stacked nav-tabs margin_top">
         <li><a href="#" title="Restablecer"><i class="icon-repeat"></i> Restablecer</a></li>
          <li><a href="#" title="Guardar"><i class="icon-envelope"></i> Enviar mensaje</a></li>
          <li><a href="#" title="Desactivar"><i class="icon-off"></i> Desactivar</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- /container -->
