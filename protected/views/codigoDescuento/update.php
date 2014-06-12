<?php
$this->breadcrumbs=array(
	'Codigo Descuentos'=>array('index'),
	'Editar',
);
?>

<div class="container">
	<h1>Código de Descuento</h1>
	<section class="bg_color3  span9 offset1 margin_bottom_small padding_small box_1">
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id'=>'codigo-form',
                //'enableAjaxValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions' => array(
                 // 'class' => 'form-horizontal',
                ),
                'type' => 'horizontal',
            )); ?>
    

		<fieldset>
                    <legend>Editando Código de Descuento: <small><?php echo $model->id ?> - <?php echo $model->codigo; ?></small></legend>
                        
                         <?php echo $form->errorSummary($model, "Por favor corrige los siguientes errores:"); ?>
                        
                        <!--Codigo-->
			<div class="control-group<?php echo $model->hasErrors("codigo")?" error":""; ?>">
                            <label class="control-label required" for="CodigoDescuento_codigo">
                                <?php echo Yii::t('contentForm','Code'); ?> <span class="required">*</span>
                            </label>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($model, 'codigo', 
                                       array('class' => 'span3')); ?>
                            </div>
                        </div>
                        
                        <!--tipo de descuento-->
			<div class="control-group">
                            <label class="control-label required" for="CodigoDescuento_tipo_descuento">
                                <?php echo Yii::t('contentForm','Type of discount'); ?> <span class="required">*</span>
                            </label>
                            <div class="controls">                                
                                <?php echo CHtml::activeDropDownList($model, 'tipo_descuento', 
                                        CodigoDescuento::getTiposDescuento(), array('class' => 'span2')); ?>
                            </div>
                        </div>
                        
                        <!--descuento-->
			<div class="control-group input-append<?php echo $model->hasErrors("descuento")?" error":""; ?>">
                            <label class="control-label required" for="CodigoDescuento_descuento">
                                <?php echo Yii::t('contentForm','Discount'); ?> <span class="required">*</span>
                            </label>
                            <div class="controls">
                                <?php echo CHtml::activeNumberField($model, 'descuento', 
//                                        Giftcard::getMontos(), 
                                        array('class' => 'span1', 'step' => '0.1',
                                            'min' => '0')); ?>
                                <span class="add-on"><?php echo $model->tipo_descuento == 1?
                                        Yii::t('backEnd', 'currSym'):"%"; ?></span>
                            </div>
                        </div>                        
                        <!--vigencia-->
                        <?php echo $form->textFieldRow($model,'inicio_vigencia', array(
                            'append' => '<i class="icon-calendar"></i>',
                            'class' => 'span2',
                            'value' =>  $model->inicio_vigencia != null ? 
                                date("d-m-Y", strtotime($model->inicio_vigencia)) : ''
                        )); ?>	
                        <?php echo $form->textFieldRow($model,'fin_vigencia', array(
                            'append' => '<i class="icon-calendar"></i>',
                            'class' => 'span2',
                            'value' =>  $model->fin_vigencia != null ? 
                                date("d-m-Y", strtotime($model->fin_vigencia)) : ''
                        )); ?>	
                        
                        <!--Estado -->
			<div class="control-group">
                            <label class="control-label required" for="CodigoDescuento_estado">
                                <?php echo Yii::t('contentForm','Estado'); ?> <span class="required">*</span>
                            </label>
                            <div class="controls">                                
                                <?php echo CHtml::activeDropDownList($model, 'estado', 
                                        CodigoDescuento::getEstados(), array('class' => 'span2')); ?>
                            </div>
                        </div>
                        

			<div class="control-group row">
                            <div class="controls pull-right">  
                                <button type="submit" name="Guardar" class="btn btn-danger margin_right_medium">Guardar</button>
                            </div>
			</div>
		</fieldset>

            <?php $this->endWidget(); ?>
        </section>
        <div class="hidden" id="cambioMoneda"><?php echo Yii::t('backEnd', 'currSym'); ?></div>
</div>
<script type="text/javascript">
    
    //Cambiar símbolo Tipo de descuento
    $("#CodigoDescuento_tipo_descuento").change(function (e){        
        var htmlC = ($(this).val() == 0) ? "%" : $("#cambioMoneda").html();                
        $("#CodigoDescuento_descuento").next().html(htmlC);
    }); 
        
    $('#<?php echo CHtml::activeId($model, 'inicio_vigencia') ?>').datepicker({
        dateFormat: "dd-mm-yy",
        minDate: 0,            
        onSelect: function(selected) {
            $("#<?php echo CHtml::activeId($model, 'fin_vigencia') ?>").datepicker(
                    "option","minDate", selected);
            }
    });

    var inicio = $('#<?php echo CHtml::activeId($model, 'inicio_vigencia') ?>').datepicker("getDate");        

    $('#<?php echo CHtml::activeId($model, 'fin_vigencia') ?>').datepicker({
        dateFormat: "dd-mm-yy",
        minDate: 0,
    });

    if(inicio != null){
       $("#<?php echo CHtml::activeId($model, 'fin_vigencia') ?>").datepicker(
                            "option","minDate", inicio);                        
    }
        
        
	
</script>

<?php // echo $this->renderPartial('_form', array('model'=>$model)); ?>