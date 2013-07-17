<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'adorno-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>true,
	'type'=>'horizontal',
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>
	<?php echo $form->errorSummary($model); ?>

  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        
          <fieldset>
            			<div class="control-group">
                              <?php echo $form->labelEx($model,'nombre', array('class' => 'control-label')); ?>
				              <div class="controls">
				              	<?php echo $form->textField($model,'nombre',array('class'=>'span4','maxlength'=>50, 'placeholder' => 'Nombre/Titulo')); ?>
				                <?php echo $form->error($model,'nombre'); ?>
				              </div>
                        </div>
                        
                        <div class="control-group">
                        	<?php echo $form->label($model,'path_image', array('class' => 'control-label')); ?>
                            <div class="controls">
	                            <?php
					            	echo CHtml::activeFileField($model, 'path_image');
									
									echo $form->error($model, 'path_image'); 
									?>
                            </div>
                        </div>
                        <div class="control-group">
				              <div class="controls">
				              	<?php 
				              	if($model->isNewRecord)
				              		echo '';
								else {
									echo CHtml::image(Yii::app()->request->baseUrl.'/images/adorno/'.$model->id.'_thumb.jpg',"image");
								} 
				              	?>
				              </div>
                        </div>
          </fieldset>       
        
      </div>
    </div>
    <div class="span3">
      <div class="padding_left">
      	
      	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'danger',
			'size' => 'large',
			'block'=>'true',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
		)); ?>

        <ul class="nav nav-stacked nav-tabs margin_top">
          <?php
          echo '<li>'.CHtml::link('<i class="icon-remove"> </i> Cancelar', CController::createUrl('adorno/index'), array('title'=>'Cancelar')).'</li>';
          if(!$model->isNewRecord){
          	  echo "<li>";
			  echo CHtml::link('<i class="icon-trash"> </i> Eliminar', CController::createUrl('adorno/delete',array('id'=>$model->id)), array('title'=>'Eliminar'));
			  echo "</li>";
          }
          ?>
        </ul>
      </div>
    </div>
  </div>
<?php $this->endWidget(); ?>