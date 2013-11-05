<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */

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
                'enableAjaxValidation' => true,
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
                                array(100, 150, 200, 250, 300),
                                array('class' => 'span2')); ?>
                        
                        
                        <?php echo $form->textFieldRow($model,'inicio_vigencia', array(
                            'append' => '<i class="icon-calendar"></i>',
                            'class' => 'span2'
                        )); ?>	
                        <?php echo $form->textFieldRow($model,'fin_vigencia', array(
                            'append' => '<i class="icon-calendar"></i>',
                            'class' => 'span2'
                        )); ?>	

			<div class="control-group row">
				<div class="controls pull-right">                                  
				  <button type="submit" class="btn btn-danger">Crear y enviar Gift Card</button>
				</div>
			</div>
		</fieldset>

            <?php $this->endWidget(); ?>
        </section>
</div>
<script type="text/javascript">
	$('#<?php echo CHtml::activeId($model, 'inicio_vigencia') ?>').datepicker({
            dateFormat: "dd-mm-yy"
        });
        
        $('#<?php echo CHtml::activeId($model, 'fin_vigencia') ?>').datepicker({
            dateFormat: "dd-mm-yy"
        });
	
</script>
