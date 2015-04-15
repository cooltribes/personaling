<?php
/* @var $this BugController */
/* @var $model Bug */

$this->breadcrumbs=array(
	'Falla Tecnica'=>array('admin'),
	'Crear Falla Tecnica',
);

?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bug-form',
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

<?php echo $form->errorSummary($model); ?>


<div class="container margin_top">
    <div class="page-header">
        <h1>Crear Falla Tecnica</h1>
    </div>
    <div class="row">
        <div class="span9">
            <div class="bg_color3 margin_bottom_small padding_small box_1">
                <form class="form-stacked personaling_form padding_top_small" >
                    <fieldset>
                    		                                  	
                    	<div class="control-group">
                              <?php echo $form->labelEx($model,'name', array('class' => 'control-label required')); ?>
				              <div class="controls">
				              	<?php echo $form->textField($model,'name',array('class'=>'span6', 'placeholder' => 'Nombre')); ?>
				                <?php echo $form->error($model,'name'); ?>
				              </div>
                        </div>
                        
					   <div class="control-group">
                              <?php echo $form->labelEx($model,'description', array('class' => 'control-label')); ?>
				              <div class="controls">
				              	<?php echo $form->textArea($model,'description',array('rows'=>'5','class'=>'span6', 'placeholder' => 'Descripcion')); ?>
				                <?php echo $form->error($model,'description'); ?>
				              </div>   
                        </div>

                        <div class="control-group">
                        	<label class="control-label required"> Imagen </label>
                            <div class="controls">
	                            <?php
					            	echo CHtml::activeFileField($model, 'image',array('name'=>'image'));
									echo $form->error($model, 'image'); ?>
									<span id="errorUrl" class="error margin_top_small_minus hide"><br/><small>El valor de imagen no puede ser vacio.</small></span>
									
									<?php
									if(!$model->isNewRecord){
										$ruta=Yii::app()->request->baseUrl.'/images/'.Yii::app()->language.'/bug/'.$model->image;
										echo '<div>'.CHtml::image($ruta,"image", array('width'=>50)).'</div>';
									} 
									?>
                            </div>
                        </div>
                        
                      <div class="control-group">
                              <?php echo $form->labelEx($model,'url', array('class' => 'control-label required')); ?>
				              <div class="controls">
				              	<?php echo $form->textField($model,'url',array('class'=>'span6', 'placeholder' => 'Url')); ?>
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
					'buttonType'=>'submit',
					 'id'=>'botone',
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
					  echo CHtml::link('<i class="icon-trash"> </i> Eliminar', CController::createUrl('bug/delete',array('id'=>$model->id)), array('title'=>'Eliminar'));
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

$("#image").change(function(){
	
   if($("#image").val()=="")
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
			
			$('#bug-form').each (function(){
			  this.reset();
			});
        
  	});	
  	
</script>


