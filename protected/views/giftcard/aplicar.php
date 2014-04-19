<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */

$this->breadcrumbs=array(
	'Mis Giftcards'=>array('adminUser'),
	'Aplicar',
);

?>
<div class="container">
	<h1><?php echo Yii::t('contentForm','Gift Card'); ?></h1>
	<section class="bg_color3  margin_bottom_small padding_medium box_1">
            <?php $form = $this->beginWidget("bootstrap.widgets.TbActiveForm", array(
                    'id' => 'form-enviarGift',
                    'type' => 'inline',
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'htmlOptions' => array('class' => 'personaling_form')
                )); ?>
		
		<fieldset>
			<legend><?php echo Yii::t('contentForm','Apply Gift Card'); ?></legend>
            <p class="lead"><?php echo Yii::t('contentForm','Search the code of your Gift Card'); ?></p>
                        <!-- FLASH ON --> 
                        <?php $this->widget('bootstrap.widgets.TbAlert', array(
                                'block'=>true, // display a larger alert block?
                                'fade'=>true, // use transitions?
                                'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
                                'alerts'=>array( // configurations per alert type
                                    'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
                                    'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
                                    'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
                                ),
                            )
                        ); ?>	
                        <!-- FLASH OFF --> 
			<div class="margin_bottom text_align_center">
                <div class="contenedorgiftcard bg_color5 padding_small box_shadow">
				    <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x470_desf.jpg" width="470">
                </div>
			</div>				
			<div class="row margin_top text_align_center">
				<div class="span4 offset4">
                                    <?php /* ?>
                                     * 
                                     * <?php echo $form->textFieldRow($model, "campo1"); ?> <span>-</span>
                                      <?php echo $form->textFieldRow($model, "campo2"); ?> <span>-</span>
                                       <?php echo $form->textFieldRow($model, "campo3"); ?> <span>-</span>
                                        <?php echo $form->textFieldRow($model, "campo4"); ?> <span>-</span>
                                     * 
                                    <?php */ ?>
                                        
                                    <?php 
                                        $classError = "";
                                        if($model->hasErrors()){
                                            $classError = "error";                                            
                                        }
                                    ?>
                                    
                                   <div class="control-group <?php echo $classError; ?>">						
                                        <div class="controls">
                                            <?php echo CHtml::activeLabel($model, "campo1"); ?> <br>
                                            
                                            <?php echo CHtml::activeTextField($model, "campo1", array('class' => 'inputGiftcard',
                                                'maxlength'=>'4')); ?> <span>-</span>                                                        
                                            <?php echo CHtml::activeTextField($model, "campo2", array('class' => 'inputGiftcard',
                                                'maxlength'=>'4')); ?> <span>-</span>                                                        
                                            <?php echo CHtml::activeTextField($model, "campo3", array('class' => 'inputGiftcard',
                                                'maxlength'=>'4')); ?> <span>-</span>                                                        
                                            <?php echo CHtml::activeTextField($model, "campo4", array('class' => 'inputGiftcard',
                                                'maxlength'=>'4')); ?>

                                        </div>						
                                   </div> 
                                        
<!--					<div class="control-group">
						<label class="control-label" for="inputGiftcard">Ingresa el código de tu Gift Card</label>
						<div class="controls ">
                                                   
                                                        <input class="input-mini" type="text" id="inputGiftcard" placeholder="XXXX"> <span>-</span>
                                                        <input class="input-mini" type="text" id="inputGiftcard" placeholder="XXXX"> <span>-</span>
                                                        <input class="input-mini" type="text" id="inputGiftcard" placeholder="XXXX">
						</div>
					</div>			  -->
				</div>	
			</div>
                        <?php echo $form->errorSummary($model, "Corrije los siguientes errores:"); ?>
			<div class="control-group row margin_top">
				<div class="controls pull-right">
				  <button type="submit" class="btn btn-large btn-warning"><i class=" icon-gift icon-white"></i> <?php echo Yii::t('contentForm','Apply Gift Card'); ?></button>
				</div>
			</div>			
		</fieldset>
		
            <?php $this->endWidget(); ?>


	</section>
</div>
<script>
    $('#AplicarGC_campo1').keypress(function(){
         if($('#AplicarGC_campo1').val().length > 2 ){
            $('#AplicarGC_campo2').focus();
         }
    });
    $('#AplicarGC_campo2').keypress(function(){
         if($('#AplicarGC_campo2').val().length > 2 ){
            $('#AplicarGC_campo3').focus();
         }
    });  
    $('#AplicarGC_campo3').keypress(function(){
         if($('#AplicarGC_campo3').val().length > 2 ){
            $('#AplicarGC_campo4').focus();
         }
    });       
</script>
<style>
    
    .inputGiftcard{
        width: 45px;
    }
    .contenedorgiftcard{
        width: 470px;
        margin: auto;
    }

</style>
