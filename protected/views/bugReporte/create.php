<?php
/* @var $this BugReporteController */
/* @var $model BugReporte */

$this->breadcrumbs=array(
	'Falla Tecnica'=>array('bug/admin'),
	'Actualizar Falla Tecnica',
);
?>

 <?php Yii::app()->session['bug_id']= $_GET["id"];?>
 
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bug-reporte-form',
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
        <h1>Actualizar Falla Tecnica</h1>
    </div>
    <div class="row">
        <div class="span9">
            <div class="bg_color3 margin_bottom_small padding_small box_1">
                <form class="form-stacked personaling_form padding_top_small" >
                    <fieldset>
                    		                                  	
                       
					   <div class="control-group">
                              <?php echo $form->labelEx($model,'descripcion', array('class' => 'control-label')); ?>
				              <div class="controls">
				              	<?php echo $form->textArea($model,'descripcion',array('rows'=>'5','class'=>'span6', 'placeholder' => 'Descripcion')); ?>
				                <?php echo $form->error($model,'descripcion'); ?>
				              </div>   
                        </div>

                          <div class="control-group"> 
                          	<?php echo $form->labelEx($model,'Estado', array('class' => 'control-label')); ?>
			              	<div class="controls">
				              	<?php  
				              	
								echo $form->dropDownList($model,'estado', $model->searchEstados(), array(
										'empty' => 'Seleccione un Estado',
										)
									);
									
									#echo CHtml::dropDownListRow('mySelect', '12', $options);
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

<hr> </hr>  <!-- linea que divide  -->

<?php
$modelado=bugReporte::model()->findAllByAttributes(array('bug_id'=>Yii::app()->session['bug_id']), array('order'=>'fecha DESC'));

 echo $this->renderPartial('_view', array('model'=>$modelado)); ?>

<script>
	
	$('#limpiar').on('click', function() {
			
			$('#bug-reporte-form').each (function(){
			  this.reset();
			});
        
  	});	
  	
</script>


