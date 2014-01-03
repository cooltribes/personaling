<?php

$this->breadcrumbs=array(
	'Marcas'=>array('admin'),
	'Crear Marca',
);
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'marca-form',
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

<?php echo $form->errorSummary($marca); ?>


<div class="container margin_top">
    <div class="page-header">
        <h1>Crear Marca</h1>
    </div>
    <div class="row">
        <div class="span9">
            <div class="bg_color3 margin_bottom_small padding_small box_1">
                <form class="form-stacked personaling_form padding_top_small" >
                    <fieldset>
                    	<div class="control-group">
				              <div class="controls">
				                <select name="" id="" class="margin_top">
				                  <option value="">Generales</option>
				                  <option value="">100% Chic</option>
				                </select>  
				              </div>
                        </div>		                                  	
                    	<div class="control-group">
                              <?php echo $form->labelEx($marca,'nombre', array('class' => 'control-label required')); ?>
				              <div class="controls">
				              	<?php echo $form->textField($marca,'nombre',array('class'=>'span6', 'placeholder' => 'Nombre de la marca')); ?>
				                <?php echo $form->error($marca,'nombre'); ?>
				              </div>
                        </div>

						<div class="control-group">
                              <?php echo $form->labelEx($marca,'descripcion', array('class' => 'control-label')); ?>
				              <div class="controls">
				              	<?php echo $form->textArea($marca,'descripcion',array('rows'=>'5','class'=>'span6', 'placeholder' => 'Descripcion de la marca')); ?>
				                <?php echo $form->error($marca,'descripcion'); ?>
				              </div>   
                        </div>
                        
                         <div class="control-group">
                        	<label class="control-label required"> Logotipo </label>
                            <div class="controls">
	                            <?php
	                            
					            	echo CHtml::activeFileField($marca, 'Urlimagen',array('name'=>'url'));
									echo $form->error($marca, 'Urlimagen'); 
									?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                        	
                            <div class="controls">
	                            <?php
	                            
					            	echo "<input type='checkbox' name='chic' id='chic'>100% Chic";
							
									?>
                            </div>
                        </div>
                        
                        <div class="control-group">
				              <div class="controls">
				              	<?php 
				              	if($marca->isNewRecord)
				              		echo '';
								else {
									echo CHtml::image(Yii::app()->request->baseUrl.'/images/marca/'.$marca->id.'_thumb.jpg',"image");
								} 
				              	?>
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
					'buttonType'=>'submit',
					'type'=>'danger',
					'size' => 'large',
					'block'=>'true',
					'label'=>$marca->isNewRecord ? 'Crear' : 'Guardar',
				)); ?>
            	
                <ul class="nav nav-stacked nav-tabs margin_top">
                   <li><a style="cursor: pointer" title="Restablecer" id="limpiar">Limpiar</a></li>
                   <?php  
                   if(!$marca->isNewRecord){
		          	  echo "<li>";
					  echo CHtml::link('<i class="icon-trash"> </i> Eliminar', CController::createUrl('marca/delete',array('id'=>$marca->id)), array('title'=>'Eliminar'));
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
	
	$('#limpiar').on('click', function() {
			
			$('#marca-form').each (function(){
			  this.reset();
			});
        
  	});	
</script>