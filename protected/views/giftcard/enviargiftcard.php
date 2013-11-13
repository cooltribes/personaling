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
			<legend>Enviar Gift Card</legend>
			<aside class="muted padding_small">
                            <span class="margin_right_medium ">
                                Monto: <strong><?php echo $model->monto . " Bs."; ?></strong>
                            </span>
                            <span class="margin_right_medium ">
                                Válida Desde: <strong><?php echo date("d/m/Y", $model->getInicioVigencia()); ?></strong>
                            </span>
                            <span class="margin_right_medium ">
                                Válida Hasta: <strong><?php echo date("d/m/Y", $model->getFinVigencia()); ?> </strong>
                            </span>
			</aside>
			<div>
				<p class="lead">1. Selecciona una Gift Card</p>
				<ul class="thumbnails">
					<li> <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x200.png"> </li>	
				</ul>


			</div>	
			<div class="row margin_top">
				<div class="span6">	
					<p class="lead">2. Personalízala</p>                                       
                                        
                                        
                                        <?php echo $form->errorSummary($envio); ?>
                                       
                                        <?php echo $form->textFieldRow($envio, 'email', array(
                                            'placeholder' => 'Email del destinatario')); ?>

                                        <?php echo $form->textFieldRow($envio, 'nombre', array(
                                            'placeholder' => 'Nombre del destinatario'
                                        )); ?>                                        
                                        
                                        <?php echo $form->textAreaRow($envio, 'mensaje', array(
                                            'placeholder' => 'Escribe un mensaje','maxlength'=>'100')); ?>
                                                                                
					   
				</div>	
				<div class="span5 bg_color5 box_shadow_personaling padding_medium">
                    <div class="contenedorPreviewGift" >
                        <span class="lead T_xlarge" id="monto">Bs. <?php echo $model->monto; ?> </span>
                        <strong class="lead" id="forpara">Para:</strong><p class="lead" id="para"></p>                        
                        <strong class="lead"  id="formensaje">Mensaje:</strong><p class="lead" id="mensaje"></p>
                        <strong class="lead T_large" id="codigo"> <?php echo $model->getMascaraCodigo(); ?> </strong>
                        <span class="lead t_small" id="fecha">Valida desde <?php echo date("d/m/Y", $model->getInicioVigencia()); ?> hasta el <?php echo date("d/m/Y", $model->getFinVigencia()); ?> </span>
                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x470.png" width="470">

                    </div>
				</div>
			</div>
			<div class="control-group row margin_top">
				<div class="controls pull-right">                                   
                                    <button type="submit" name="Enviar" class="btn btn-danger"><i class="icon-envelope icon-white"></i> Enviar</button>                                  
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

$('#EnvioGiftcard_mensaje').keypress(function(){
    $('#mensaje').text( $('#EnvioGiftcard_mensaje').val() );
});
    
</script>
