<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */
$admin = UserModule::isAdmin()? "Giftcards" : "Mis Giftcards";
$dir = UserModule::isAdmin()? "index" : "adminUser";

$this->breadcrumbs=array(
	$admin=>array($dir),
	'Enviar',
);
//$this->breadcrumbs=array(
//	'Giftcards'=>array('index'),
//	'Enviar',
//);

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
			
                        <div class="row margin_top">
                            <div class="span6"> 
                                <p class="lead">1. ¿A quién se la envías?</p>                                       

                                    <?php echo $form->errorSummary($envio); ?>

                                    <?php echo $form->textFieldRow($envio, 'email', array(
                                        'placeholder' => 'Email del destinatario')); ?>
                                <p class="lead">3. Personalízala</p>                                       

                                    <?php echo $form->textFieldRow($envio, 'nombre', array(
                                        'placeholder' => 'Nombre del destinatario'
                                    )); ?>                                        

                                    <?php echo $form->textAreaRow($envio, 'mensaje', array(
                                        'placeholder' => 'Escribe un mensaje','maxlength'=>'100')); ?>

                            </div> 
                              <div class="span5 box_shadow_personaling padding_medium">
                                <div class="contenedorPreviewGift" >
                                    <img src="<?php echo Yii::app()->baseUrl."/images/giftcards/{$model->plantilla_url}_x470.jpg"; ?>" width="470">
                                    <div class="row-fluid margin_top">
                                        <div class="span6 braker_right">
                                            <div class=" T_xlarge color1" id="monto"><?php echo $model->monto; ?> Bs.</div>

                                            <div class="margin_top color4" id="codigo"><div class="color9">Código</div> <?php echo $model->getMascaraCodigo(); ?> </div>
                                        </div>
                                        <div class="span6">
                                            <strong  id="forpara">Para:</strong>&nbsp;<span id="para"></span>
                                            <div>
                                                <strong  id="formensaje">Mensaje:</strong>&nbsp;<span class="" id="mensaje"></span>
                                            </div>                        

                                        </div>
                                    </div>
                                    <div class="text_center_align margin_bottom_minus margin_top_small">
                                        <span class=" t_small" id="fecha">
                                            Válida desde <strong><?php echo date("d/m/Y"); ?> </strong> hasta el <strong><?php 
                                            $now = date('Y-m-d', strtotime('now'));
                                            echo date("d/m/Y", strtotime($now." + 1 year")); ?> </strong>
                                        </span>                        
                                    </div>
                                </div>
                            </div>
                        </div>


			<div class="row margin_top">
                            <div class="span6">	
                                    


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

$('#EnvioGiftcard_nombre').focusout(function(){
    $('#para').text( $('#EnvioGiftcard_nombre').val() );
}); 

$('#EnvioGiftcard_mensaje').keypress(function(){
    $('#mensaje').text( $('#EnvioGiftcard_mensaje').val() );
});

$('#EnvioGiftcard_mensaje').focusout(function(){
    $('#mensaje').text( $('#EnvioGiftcard_mensaje').val() );
});    
</script>
<style>
    .contenedorPreviewGift{

        font-family: arial,sans-serif;
    }
</style>
