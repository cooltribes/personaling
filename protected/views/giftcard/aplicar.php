<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */

//$this->breadcrumbs=array(
//	'Giftcards'=>array('index'),
//	'Aplicar',
//);

?>
<div class="container">
	<h1>Gift Card</h1>
	<section class="bg_color3  margin_bottom_small padding_medium box_1">
            <?php $form = $this->beginWidget("bootstrap.widgets.TbActiveForm", array(
                    'id' => 'form-enviarGift',
                    'type' => 'horizontal',
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                    'htmlOptions' => array('class' => 'personaling_form')
                )); ?>
		
		<fieldset>
			<legend>Aplicar Gift Card</legend>
			<div class="margin_bottom text_align_center">
				<img src="http://placehold.it/450x250">
			</div>				
			<div class="row margin_top text_align_center">
				<div class="span7">					
					<div class="control-group">
						<label class="control-label" for="inputGiftcard">Ingresa el código de tu Gift Card</label>
						<div class="controls ">
                                                    <?php echo CHtml::activeTextField($model, "campo1"); ?> <span>-</span>
                                                        <input class="input-mini" type="text" id="inputGiftcard" placeholder="XXXX"> <span>-</span>
                                                        <input class="input-mini" type="text" id="inputGiftcard" placeholder="XXXX"> <span>-</span>
                                                        <input class="input-mini" type="text" id="inputGiftcard" placeholder="XXXX">
						</div>
					</div>			  
				</div>	
			</div>
                        <?php echo $form->errorSummary($model); ?>
			<div class="control-group row margin_top">
				<div class="controls pull-right">
				  <button type="submit" class="btn btn-medium btn-warning">Aplicar Gift Card</button>
				</div>
			</div>			
		</fieldset>
		
            <?php $this->endWidget(); ?>


	</section>
</div>
