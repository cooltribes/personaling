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
                    )
                )); ?>
		
		<fieldset>
			<legend>Envío masivo de Gift Cards</legend>
			
			<div>
				<p class="lead">1. Selecciona un diseño para las Gift Card</p>
				<ul class="thumbnails">
					<li> <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x200.png"> </li>	
				</ul>


			</div>	
			<div>
				<p class="lead">2. Selecciona un monto y un período de vigencia</p>
				
                                    
                        

                                <?php echo $form->dropDownListRow($giftcard,'monto',
                                        array(100 => 100, 200 => 200, 300 => 300),
                                        array('class' => 'span2')); ?>


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

            

			<div class="row margin_top">
				<div class="span6">	
					<p class="lead">3. Personalízala</p>                                       
                                        
                                        <?php echo $form->textAreaRow($envio, 'mensaje', array(
                                            'placeholder' => 'Escribe un mensaje','maxlength'=>'140', 'rows' => 4)); ?>
                                         
                                        <?php echo $form->errorSummary(array($giftcard, $envio)); ?>
					   
				</div>	
				<div class="span5 bg_color5 box_shadow_personaling padding_medium">
                                    <div class="contenedorPreviewGift" >
                                        <span class=" T_xlarge" id="monto"><?php echo "X"//$model->monto; ?> Bs. </span>
                                        <span  id="forpara">Para:</span><p id="para">
                                            <b><?php echo count(Yii::app()->session["users"]); ?></b> Usuario<?php echo count(Yii::app()->session["users"]) > 1? "s":"" ?> Personaling
                                        </p>                        
                                        <span  id="formensaje">Mensaje:</span><p class="" id="mensaje"></p>
                                        <span class=" T_large color4" id="codigo"> <?php echo "XXXX-XXXX-XXXX-XXXX";//$model->getMascaraCodigo(); ?> </span>
                                        <span class=" t_small" id="fecha">Válida desde <?php echo "fecha";//echo date("d/m/Y", $model->getInicioVigencia()); ?> hasta el 
                                            <?php //echo date("d/m/Y", $model->getFinVigencia()); ?> </span>
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
