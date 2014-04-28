<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */

$this->breadcrumbs=array(
	'Giftcards'=>array('index'),
	'Enviar',
);
$this->pageTitle=Yii::app()->name . ' - Enviar Gift Cards Masivo';
?>
<div class="container">
    
    <!-- FLASH ON --> 
    <?php $this->widget('bootstrap.widgets.TbAlert', array(
            'block'=>true, // display a larger alert block?
            'fade'=>true, // use transitions?
            'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
            'alerts'=>array( // configurations per alert type
                'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
                'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            ),
        )
    ); ?>	
    <!-- FLASH OFF --> 
	<h1>Gift Card</h1>
	<section class="bg_color3  span12 margin_bottom_small padding_medium box_1">
                <?php $form = $this->beginWidget("bootstrap.widgets.TbActiveForm", array(
                    'id' => 'form-enviarGift',
                    'type' => 'horizontal',
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
//                    'enableAjaxValidation'=>true,
//                    'enableClientValidation'=>true,
                )); ?>
		
		<fieldset>
			<legend>Exportación masiva de Gift Cards</legend>
			
			<div>
				<p class="lead">1. Indica la cantidad de Gift Cards a generar</p>
                                
                                <div class="control-group ">
                                    <label class="control-label required" for="Giftcard_monto">Cantidad <span class="required">*</span></label>
                                    <div class="controls">
                                        <input type="number" name="cantidadGC" id="cantidadGC" step="1" min="1" value="1" class="span1">
                                    </div>
                                </div>
                                


			</div>	

			<div class="row margin_top">
				<div class="span6">	
					<p class="lead">2. Selecciona un monto y un período de vigencia</p>                                       
                                        
                                        <div class="control-group input-prepend">
                                            <label class="control-label required" for="Giftcard_monto">
                                                <?php echo Yii::t('contentForm','Amount'); ?> <span class="required">*</span>
                                            </label>
                                            <div class="controls">
                                                <span class="add-on"><?php echo Yii::t('contentForm', 'currSym'); ?></span>
                                                <?php echo CHtml::activeDropDownList($giftcard, 'monto', 
                                                        Giftcard::getMontos(), array('class' => 'span1')); ?>
                                            </div>
                                        </div>

                                <?php echo $form->textFieldRow($giftcard,'inicio_vigencia', array(
                                    'append' => '<i class="icon-calendar"></i>',
                                    'class' => 'span2',
                                    'value' =>  $giftcard->inicio_vigencia != null ? 
                                        date("d-m-Y", strtotime($giftcard->inicio_vigencia)) : ''
                                )); ?>	
                                
                                <?php echo $form->textFieldRow($giftcard,'fin_vigencia', array(
                                    'append' => '<i class="icon-calendar"></i>',
                                    'class' => 'span2',
                                    'value' =>  $giftcard->fin_vigencia != null ? 
                                        date("d-m-Y", strtotime($giftcard->fin_vigencia)) : ''
                                )); ?>
					   
				</div>	
				
			</div>
			<div class="control-group row margin_top">
				<div class="controls">                                   
                                    <button type="button" id="btnExportar"  class="btn btn-danger"><i class="icon-download icon-white"></i> Exportar</button>                                  
                                    <input type="hidden" name="Exportar" >
				</div>
			</div>			
		</fieldset>
		
                <?php $this->endWidget(); ?>

	</section>
</div>

<script type="text/javascript">
    
    //Click para el calendario
$('#<?php echo CHtml::activeId($giftcard, "inicio_vigencia") ?>').change(function(){
    $('#monto').text( $('#<?php echo CHtml::activeId($giftcard, "monto") ?>').val() + " Bs.");
});

$('#<?php echo CHtml::activeId($giftcard, "monto") ?>').change(function(){
    $('#monto').text( $('#<?php echo CHtml::activeId($giftcard, "monto") ?>').val() + " Bs.");
});


$('#EnvioGiftcard_mensaje').keypress(function(){
    $('#mensaje').text( $('#EnvioGiftcard_mensaje').val() );
});

$('#EnvioGiftcard_mensaje').focusout(function(){
    $('#mensaje').text( $('#EnvioGiftcard_mensaje').val() );
});    

    
    //var click = false;
    $('#btnExportar').click(function(e){
        $(this).attr("disabled",true);
        
        $("input[name='Exportar']").val("1");
        $("#form-enviarGift").submit();
        
        
    });    


        $('#<?php echo CHtml::activeId($giftcard, 'inicio_vigencia') ?>').datepicker({
            dateFormat: "dd-mm-yy",
            minDate: 0,            
            onSelect: function(selected) {
                        $("#<?php echo CHtml::activeId($giftcard, 'fin_vigencia') ?>").datepicker(
                                "option","minDate", selected);
                        }
        });
        
        //$('#<?php echo CHtml::activeId($giftcard, 'inicio_vigencia') ?>').datepicker("setDate", "0");
        var inicio = $('#<?php echo CHtml::activeId($giftcard, 'inicio_vigencia') ?>').datepicker("getDate");
        //console.log(inicio);        
        
        $('#<?php echo CHtml::activeId($giftcard, 'fin_vigencia') ?>').datepicker({
            dateFormat: "dd-mm-yy",
            minDate: 0,
        });
        
        if(inicio != null){
           $("#<?php echo CHtml::activeId($giftcard, 'fin_vigencia') ?>").datepicker(
                                "option","minDate", inicio);
                        
        }
</script>
<style>
    .contenedorPreviewGift{

        font-family: arial,sans-serif;
    }
</style>
