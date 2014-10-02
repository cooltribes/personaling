<?php
/* @var $this TiendaExternaController */
/* @var $tienda Tienda */

$this->breadcrumbs=array(
	'Tiendas'=>array('index'),
	'Create',
);

?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tienda-form',
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

<?php echo $form->errorSummary($tienda); ?>


<div class="container margin_top">
    <div class="page-header">
        <h1>Crear Tienda</h1>
    </div>
    <div class="row">
        <div class="span9">
            <div class="bg_color3 margin_bottom_small padding_small box_1">
                <form class="form-stacked personaling_form padding_top_small" >
                    <fieldset>
                    	<div class="control-group margin_top_medium">
							<?php echo $form->labelEx($tienda,'name', array('class' => 'control-label')); ?>
							<div class="controls">
							<?php echo $form->textField($tienda,'name',array('size'=>60,'maxlength'=>100,'class'=>'span6')); ?>
							<?php echo $form->error($tienda,'name'); ?>
							</div>
						</div>
                    	
						<div class="control-group">
							<?php echo $form->labelEx($tienda,'description', array('class' => 'control-label')); ?>
							<div class="controls">
							<?php echo $form->textArea($tienda,'description',array('rows'=>6, 'cols'=>50,'class'=>'span6')); ?>
							<?php echo $form->error($tienda,'description'); ?>
							</div>
						</div>
                        
                        <div class="control-group">
							<?php echo $form->labelEx($tienda,'logo', array('class' => 'control-label')); ?>
							<div class="controls">
							<?php echo CHtml::activeFileField($tienda, 'logo',array('name'=>'logo')); ?>
							<?php echo $form->error($tienda,'logo'); ?>
							</div>
						</div>
						
					<div class="control-group">
							<?php echo $form->labelEx($tienda,'url', array('class' => 'control-label')); ?>
							<div class="controls">
							<?php echo $form->textField($tienda,'url',array('size'=>60,'maxlength'=>100,'class'=>'span6')); ?>
							<?php echo $form->error($tienda,'url'); ?>
							</div>
						</div>
                                         
                                                 
                        <div class="control-group">
                        	
                            <div class="controls">
	                            <?php
	                            $checked="";
	                            if($tienda->type){
	                            	echo CHtml::hiddenField('multi','1');
									$checked=' checked';
								}else{
									echo CHtml::hiddenField('multi','0');
								}
					            	echo "<input type='checkbox' name='monomarca' id='multimarca'".$checked.">¿Es tienda Multimarca?";
								
									?>
                            </div>
                        </div>
                        
                        <div class="control-group">
				              <div class="controls">
				              	<?php 
				              	if($tienda->isNewRecord)
				              		echo '';
								else {
									echo "<img src=".Yii::app()->request->baseUrl.'/images/'.Yii::app()->language.'/tienda/'.$tienda->id.'_thumb.jpg'."?" . time() . ">";	
									#echo CHtml::image(Yii::app()->request->baseUrl.'/images/'.Yii::app()->language.'/tienda/'.$tienda->id.'_thumb.jpg',"image");
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
					'label'=>$tienda->isNewRecord ? 'Crear' : 'Guardar',
				)); ?>
            	
                <ul class="nav nav-stacked nav-tabs margin_top">
                   <li><a style="cursor: pointer" title="Restablecer" id="limpiar">Limpiar</a></li>
                   <?php  
                   if(!$tienda->isNewRecord){
		          	  echo "<li>";
					  echo CHtml::link('<i class="icon-trash"> </i> Eliminar', CController::createUrl('tienda/delete',array('id'=>$tienda->id)), array('title'=>'Eliminar'));
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
			
			$('#tienda-form').each (function(){
			  this.reset();
			});
        
  	});	
  	
  	$('#multimarca').on('click', function() {
		 if($('#multimarca').is(':checked'))
		 	$('#multi').val('1');
		 else
		 	$('#multi').val('0');
				        
  	});	
  	
</script>