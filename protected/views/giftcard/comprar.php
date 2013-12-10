<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */

$this->breadcrumbs=array(
	'Giftcards'=>array('index'),
	'Enviar',
);

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
                    )
                )); ?>
		
		<fieldset>
			<legend>Comprar Gift Card</legend>
			
			<div>
                            <p class="lead">1. Selecciona un diseño para la Gift Card</p>
                            <ul class="thumbnails">
                                    <li> <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x200.png"> </li>	
                                    <li> <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x200.png"> </li>	
                                    <li> <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x200.png"> </li>	
                                    <li> <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x200.png"> </li>	
                                    <li> <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x200.png"> </li>	
                            </ul>
			</div>	
			<div>
                            <p class="lead">1. Selecciona el monto</p>
				<?php echo $form->errorSummary($model); ?>
                        
			
                                <?php echo $form->dropDownListRow($model,'monto',
                                    array(100 => 100,
                                        200 => 200,
                                        300 => 300,
                                        400 => 400,
                                        500 => 500,
                                        600 => 600,
                                        700 => 700,
                                        800 => 800,
                                        900 => 900,
                                        //1000 => 1000,
                                        ),
                                    array('class' => 'span2')); ?>

			</div>	


			<div class="row margin_top">
				<div class="span6">	
					<p class="lead">3. Personalízala</p>                                       
                                                                                                                    

                                        <?php echo $form->textFieldRow($envio, 'nombre', array(
                                            'placeholder' => 'Nombre del destinatario'
                                        )); ?>                                        
                                        
                                        <?php echo $form->textAreaRow($envio, 'mensaje', array(
                                            'placeholder' => 'Escribe un mensaje','maxlength'=>'100')); ?>
                                        
                                    <div class="control-group margin_top_large text_align_center">
                                        <?php $this->widget('bootstrap.widgets.TbButton', array(
                                                'buttonType' => 'submit',
                                                'label' => 'Comprar',
                                                'icon' => 'shopping-cart white',
                                                'type' => 'warning',
                                                'size' => 'large',
                                            )
                                        ); ?>   
                                        
                                    </div>    
                                    
                                                                                
					   
				</div>	
				<div class="span5 box_shadow_personaling padding_medium">
                    <div class="" >
                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x470.png" width="470">
                        <div class="row-fluid margin_top">
                            <div class="span6 braker_right">
                                <div class=" T_xlarge color1" id="monto"><?php echo $model->monto; ?> Bs.</div>
                                
                                <div class="margin_top color4" id="codigo"><div class="color9">Código</div> <?php echo "XXXX-XXXX-XXXX-XXXX"; ?> </div>
                            </div>
                            <div class="span6 braker_left">
                                <span  id="forpara">Para:</span><p id="para"></p>                        
                                <span  id="formensaje">Mensaje:</span><p class="" id="mensaje"></p>

                            </div>
                        </div>
                        <div class="text_center_align">
                            <span class=" t_small" id="fecha">
                                Válida desde <?php echo date("d/m/Y"); ?> hasta el <?php 
                                $now = date('Y-m-d', strtotime('now'));
                                echo date("d/m/Y", strtotime($now." + 1 year")); ?>
                            </span>                        
                        </div>
                    </div>
				</div>
			</div>
			<div class="control-group row margin_top">
				<div class="controls pull-right"> 
                                   
                                    
                                    
				</div>
			</div>			
		</fieldset>
		
                <?php $this->endWidget(); ?>

	</section>
</div>
<script>

$('#EnvioGiftcard_nombre').keypress(function(){
    $('#para').text( $('#EnvioGiftcard_nombre').val() );
}); 

$('#EnvioGiftcard_nombre').focusout(function(){
    $('#para').text( $('#EnvioGiftcard_nombre').val() );
}); 

$('#EnvioGiftcard_mensaje').keypress(function(){
    $('#mensaje').text( $('#EnvioGiftcard_mensaje').val() );
});

$('#EnvioGiftcard_mensaje').focusout(function(){
    $('#mensaje').text( $('#EnvioGiftcard_mensaje').val() );
});    
$('#EnvioGiftcard_mensaje').change(function(){
    $('#mensaje').text( $('#EnvioGiftcard_mensaje').val() );
});    

/*Para actualizar el monto al cambiar el dropdown*/
$('#<?php echo CHtml::activeId($model, "monto") ?>').change(function(){
    $('#monto').text( $('#<?php echo CHtml::activeId($model, "monto") ?>').val() + " Bs.");
});

</script>
<style>
    .contenedorPreviewGift{

        font-family: arial,sans-serif;
    }
</style>
