<?php

$this->breadcrumbs=array(
	'Colores'=>array('admin'),
	'Crear Color',
);

?>



<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'color-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'type'=>'horizontal',
	'clientOptions'=>array(
		'validateOnSubmit'=>true, 
	),
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); 

?>

<?php echo $form->errorSummary($model, Funciones::errorMsg()); ?>


<div class="container margin_top">
    <div class="page-header">
        <h1>Crear Color</h1>
    </div>
    <div class="row">
        <div class="span9">
            <div class="bg_color3 margin_bottom_small padding_small box_1">
                <form class="form-stacked personaling_form padding_top_small" >
                    <fieldset>
                    		                                  	
                    	<div class="control-group">
                              <?php echo $form->labelEx($model,'valor', array('class' => 'control-label required')); ?>
				              <div class="controls">
				              	<?php echo $form->textField($model,'valor',array('class'=>'span6', 'placeholder' => 'Valor')); ?>
				                <?php echo $form->error($model,'valor'); ?>
				              </div>
                        </div>

                        <div class="control-group">
                              <?php echo $form->labelEx($model,'rgb', array('class' => 'control-label required')); ?>
				              <div class="controls">
				              	<?php echo $form->textField($model,'rgb',array('class'=>'span6', 'placeholder' => 'Código RGB')); ?>
				                <?php echo $form->error($model,'rgb'); ?>
				              </div>
                        </div>

                        <div class="control-group">
                        	<label class="control-label required"> Imagen </label>
                            <div class="controls">
                            	
	                            <?php
					            	echo CHtml::activeFileField($model, 'path_image',array('name'=>'path_image', 'value'=>'asd'));
									echo $form->error($model, 'path_image'); ?>
									<span id="errorUrl" class="error margin_top_small_minus hide"><br/><small>El valor de imagen no puede ser vacio.</small></span>
									<?php
									if(!$model->isNewRecord){
										$ruta=Yii::app()->request->baseUrl.'/images/'.Yii::app()->language.'/colores/'.$model->path_image;
										echo '<div>'.CHtml::image($ruta,"image", array('width'=>50)).'</div>';
									} 
									?>
                            </div>
                        </div>

                        <div class="control-group"> 
			              	<div class="controls">
				              	<?php 
								echo $form->dropDownListRow(
								 	$model,'padreID', CHtml::listData(
								 		Color::model()->findAllByAttributes(array('padreID'=>0)),'id','valor'
									), array(
										'empty' => Yii::t(
											'contentForm','Seleccione un color')
										)
									);
				 	 			?>
			              	</div>
			            </div>

						<div class="control-group">
                              <?php echo $form->labelEx($model,'title', array('class' => 'control-label required')); ?>
				              <div class="controls">
				              	<?php echo $form->textField($model,'title',array('class'=>'span6', 'placeholder' => 'Título H1')); ?>
				                <?php echo $form->error($model,'title'); ?>
				              </div>
                        </div>
                        
                        <div class="control-group">
                              <?php echo $form->labelEx($model,'description', array('class' => 'control-label')); ?>
				              <div class="controls">
				              	<?php echo $form->textArea($model,'description',array('rows'=>'5','class'=>'span6', 'placeholder' => 'Descripcion SEO')); ?>
				                <?php echo $form->error($model,'description'); ?>
				              </div>   
                        </div>
                        
                        <div class="control-group">
                              <?php echo $form->labelEx($model,'keywords', array('class' => 'control-label required')); ?>
				              <div class="controls">
				              	<?php echo $form->textField($model,'keywords',array('class'=>'span6', 'placeholder' => 'Palabras clave')); ?>
				                <?php echo $form->error($model,'keywords'); ?>
				              </div>
                        </div>

                        <div class="control-group">
                              <?php echo $form->labelEx($model,'url', array('class' => 'control-label required')); ?>
				              <div class="controls">
				              	<?php echo $form->textField($model,'url',array('class'=>'span6', 'placeholder' => 'URL amigable')); ?>
				                <?php echo $form->error($model,'url'); ?>
				              </div>
                        </div>
                        
                      <br>
                    </fieldset>
      			</form>
            </div>
        </div>
        
        
        <div class="span3">
            <div class="padding_left"> 
            	
            	<?php $this->widget('bootstrap.widgets.TbButton', array(
            		'id'=>'botone',
					'buttonType'=>'submit',
					'type'=>'danger',
					'size' => 'large',
					'block'=>'true',
					'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
				)); ?>
            	
                <ul class="nav nav-stacked nav-tabs margin_top">
                   <li><a style="cursor: pointer" title="Restablecer" id="limpiar">Limpiar</a></li>
                   <?php  
                   if(!$model->isNewRecord){
		          	  echo "<li>";
					  echo CHtml::link('<i class="icon-trash"> </i> Eliminar', CController::createUrl('color/delete',array('id'=>$model->id)), array('title'=>'Eliminar'));
					  echo "</li>";
		          }
                   ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /container -->

<?php $this->endWidget(); ?>

<script>
$('#botone').attr('disabled',true);
$('#errorUrl').show();

$("#path_image").change(function(){
	
   if($("#path_image").val()=="")
   {
   		$('#botone').attr('disabled',true);
		$('#errorUrl').show();
   }   		
   else
   {
   		$('#botone').attr('disabled',false);
   		$('#errorUrl').hide();
   }
   		
});
	
	$('#limpiar').on('click', function() {
			
			$('#color-form').each (function(){
			  this.reset();
			});
        
  	});	
  	
</script>