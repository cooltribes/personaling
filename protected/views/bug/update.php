<?php
/* @var $this BugController */
/* @var $model Bug */

$this->breadcrumbs=array(
	'Falla Tecnica'=>array('admin'),
	'Ver Falla Tecnica',
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

<?php echo $form->errorSummary($model, Funciones::errorMsg()); ?>


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
				              	<?php echo $form->textField($model,'name',array('class'=>'span6', 'placeholder' => 'Nombre', 'disabled'=>'disabled')); ?>
				                <?php echo $form->error($model,'name'); ?>
				              </div>
                        </div>
                        
					   <div class="control-group">
                              <?php echo $form->labelEx($model,'description', array('class' => 'control-label')); ?>
				              <div class="controls">
				              	<?php echo $form->textArea($model,'description',array('rows'=>'5','class'=>'span6', 'placeholder' => 'Descripcion', 'disabled'=>'disabled')); ?>
				                <?php echo $form->error($model,'description'); ?>
				              </div>   
                        </div>

                        <div class="control-group">
                        	<label class="control-label required"> Imagen </label>
                            <div class="controls">
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
				              	<?php echo $form->textField($model,'url',array('class'=>'span6', 'placeholder' => 'Url', 'disabled'=>'disabled')); ?>
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
					'type'=>'danger',
					'size' => 'large',
					'block'=>'true',
					'label'=>$model->isNewRecord ? 'Crear' : 'Actualizar',
				)); ?>
            	
               
            </div>
        </div>
    </div>
</div>
<!-- /container -->

<?php $this->endWidget(); ?>
