<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */

//Yii::app()->getClientScript()->registerScriptFile('http://jquery-ui.googlecode.com/svn/tags/latest/ui/minified/i18n/jquery-ui-i18n.min.js', 
//        null, array("charset"=>"UTF-8"));

$this->breadcrumbs=array(
	'Giftcards'=>array('index'),
	'Generar',
);

?>
<div class="container">
	<h1>Gift Card</h1>
	<section class="bg_color3  span9 offset1 margin_bottom_small padding_small box_1">
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id'=>'giftcard-form',
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
			<legend>Generar Gift Card</legend>
                        
                         <?php echo $form->errorSummary($model); ?>
                        
			
                        <?php echo $form->dropDownListRow($model,'monto',
                                array(100 => 100, 200 => 200, 300 => 300),
                                array('class' => 'span2')); ?>
                        
                        
                        
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

			<div class="control-group row">
				<div class="controls pull-right">  
                                    
                                    <button type="submit" name="Guardar" class="btn margin_right_medium">Guardar Gift Card</button>
                                  <button type="submit" name="Enviar" class="btn btn-danger">
                                      <i class="icon-gift icon-white"></i> Enviar Gift Card
                                  </button>
				</div>
			</div>
		</fieldset>

            <?php $this->endWidget(); ?>
        </section>
</div>
<script type="text/javascript">
	
//        $.datepicker.setDefaults({
//            dayNamesShort: $.datepicker.regional[ "fr" ].dayNamesShort,
//            dayNames: $.datepicker.regional[ "fr" ].dayNames,
//            monthNamesShort: $.datepicker.regional[ "fr" ].monthNamesShort,
//            monthNames: $.datepicker.regional[ "es" ].monthNames
//        });
    
        //$.datepicker.setDefaults( $.datepicker.regional[ "" ] );
        
        
        
        $('#<?php echo CHtml::activeId($model, 'inicio_vigencia') ?>').datepicker({
            dateFormat: "dd-mm-yy",
            minDate: 0,            
            onSelect: function(selected) {
                        $("#<?php echo CHtml::activeId($model, 'fin_vigencia') ?>").datepicker(
                                "option","minDate", selected);
                        }
        });
        
        //$('#<?php echo CHtml::activeId($model, 'inicio_vigencia') ?>').datepicker("setDate", "0");
        var inicio = $('#<?php echo CHtml::activeId($model, 'inicio_vigencia') ?>').datepicker("getDate");
        //console.log(inicio);        
        
        $('#<?php echo CHtml::activeId($model, 'fin_vigencia') ?>').datepicker({
            dateFormat: "dd-mm-yy",
            minDate: 0,
        });
        
        if(inicio != null){
           $("#<?php echo CHtml::activeId($model, 'fin_vigencia') ?>").datepicker(
                                "option","minDate", inicio);
                        
        }
        
        
	
</script>
