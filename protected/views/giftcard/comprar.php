<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */

$this->breadcrumbs = array(
    'Comprar GiftCard',
);
?>
<div class="container">

    <!-- FLASH ON --> 
    <?php
    $this->widget('bootstrap.widgets.TbAlert', array(
        'block' => true, // display a larger alert block?
        'fade' => true, // use transitions?
        'closeText' => '&times;', // close link text - if set to false, no close link is displayed
        'alerts' => array(// configurations per alert type
            'success' => array('block' => true, 'fade' => true, 'closeText' => '&times;'), // success, info, warning, error or danger
            'error' => array('block' => true, 'fade' => true, 'closeText' => '&times;'), // success, info, warning, error or danger
        ),
            )
    );
    ?>	
    <!-- FLASH OFF --> 
    <h1>Gift Card</h1>
    <section class="bg_color3  span12 margin_bottom_small padding_medium box_1">
        <?php
        $form = $this->beginWidget("bootstrap.widgets.TbActiveForm", array(
            'id' => 'form-enviarGift',
            'type' => 'horizontal',
            'clientOptions' => array(
                'validateOnSubmit' => true,
            )
        ));
        ?>

        <fieldset>
            <legend>Comprar Gift Card</legend>

            <div>
                <p class="lead">1. Selecciona un diseño para la Gift Card</p>
                <ul class="thumbnails" id="plantillas">
                    <li class="active" id="GC-gift_card_one">
                        <a href="active">
                            <div class="thumbnail">
                                <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x200.jpg">
                            </div>
                        </a>
                    </li>		
                    <li id="GC-gift_card_one">
                        <a href="">
                            <div class="thumbnail">
                                <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x200.png">
                            </div>
                        </a>
                    </li>	
                    <li id="GC-navidad_2">
                        <a href="">
                            <div class="thumbnail">
                                <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/navidad_2_x200.png">
                            </div>
                        </a>
                    </li>	
                    <li id="GC-navidad_1">
                        <a href="">
                            <div class="thumbnail">
                                <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/navidad_1_x200.png">
                            </div>
                        </a>
                    </li>	
                <?php echo $form->hiddenField($model, 'plantilla_url'); ?>
                </ul>
            </div>	
            <div>
                <p class="lead">2. Selecciona el monto</p>
                <?php echo $form->errorSummary($model); ?>


                <?php
                echo $form->dropDownListRow($model, 'monto', array(
                    4 => 4,
                    100 => 100,
                    200 => 200,
                    300 => 300,
                    400 => 400,
                    500 => 500,
                    600 => 600,
                    700 => 700,
                    800 => 800,
                    900 => 900,
                        //1000 => 1000,
                        ), array('class' => 'span2'));
                ?>

            </div>	


            <div class="row margin_top">
                <div class="span6">	
                    <p class="lead">3. Personalízala</p>                                       


                    <?php
                    echo $form->textFieldRow($envio, 'nombre', array(
                        'placeholder' => 'A quién se la envías'
                    ));
                    ?>                                        

                    <?php 
                    echo $form->textAreaRow($envio, 'mensaje', array(
                        'placeholder' => 'Escribe un mensaje', 'maxlength' => '100'));
                    
                    $checkI = $checkE = "";
                    
                    if(!Yii::app()->getSession()->contains('entrega') || 
                            Yii::app()->getSession()->get('entrega') == 1){
                      
                        $checkI = 'checked="checked"';  
                        
                    }else if(Yii::app()->getSession()->get('entrega') == 2){
                        
                        $checkE = 'checked="checked"';  
                        
                    }
                    
                    ?>
                    <p class="lead">4. Escoge cómo quieres entregarla</p>
                    
                    <div class="accordion" id="accordionE">
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <label class="radio accordion-toggle margin_left_small"
                                        data-parent="#accordionE">
                                    <input type="radio" name="entrega" value="1" <?php echo $checkI; ?>> Impresa
                                </label>                                
                            </div>
                            <div id="collapseT" class="accordion-body collapse">
                            </div>
                            
                        </div>
                        <div class="accordion-group">
                            
                            <div class="accordion-heading">
                               <label class="radio accordion-toggle margin_left_small" 
                                      data-toggle="collapse" data-target="#collapseOne" data-parent="#accordionE">
                                    <input type="radio" name="entrega" value="2" <?php echo $checkE; ?>> Por correo electrónico
                               </label> 
                                
                            </div>
                            <div id="collapseOne" class="accordion-body collapse<?php echo $checkE ? " in":""; ?>">
                              <div class="accordion-inner">
                                <?php
                                    echo $form->textFieldRow($envio, 'email', array(
                                        'placeholder' => 'Email del destinatario'
                                    ));
                                ?>  
                              </div>
                            </div>
                        </div>
                        
                        
                        
                    </div>
                    
                    <div class="control-group margin_top_large text_align_center">
                        <?php
                        $this->widget('bootstrap.widgets.TbButton', array(
                            'buttonType' => 'submit',
                            'label' => 'Comprar',
                            'icon' => 'shopping-cart white',
                            'type' => 'warning',
                            'size' => 'large',
                                )
                        );
                        ?>   

                    </div>      
                                    
                                                                                
					   
				</div>	
				<div class="span5 box_shadow_personaling padding_medium">
                    <div class="contenedorPreviewGift" >
                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x470.jpg" width="470">
                        <div class="row-fluid margin_top">
                            <div class="span6 braker_right">
                                <div class=" T_xlarge color1" id="monto"><?php echo $model->monto; ?> Bs.</div>
                                
                                <div class="margin_top color4" id="codigo"><div class="color9">Código</div> <?php echo "XXXX-XXXX-XXXX-XXXX"; ?> </div>
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
            <div class="control-group row margin_top">
                <div class="controls pull-right"> 



                </div>
            </div>			
        </fieldset>

<?php $this->endWidget(); ?>

    </section>
</div>
<script>

    $('#EnvioGiftcard_nombre').keypress(function() {
        $('#para').text($('#EnvioGiftcard_nombre').val());
    });

    $('#EnvioGiftcard_nombre').focusout(function() {
        $('#para').text($('#EnvioGiftcard_nombre').val());
    });

    $('#EnvioGiftcard_mensaje').keypress(function() {
        $('#mensaje').text($('#EnvioGiftcard_mensaje').val());
    });

    $('#EnvioGiftcard_mensaje').focusout(function() {
        $('#mensaje').text($('#EnvioGiftcard_mensaje').val());
    });
    $('#EnvioGiftcard_mensaje').change(function() {
        $('#mensaje').text($('#EnvioGiftcard_mensaje').val());
    });

    /*Para actualizar el monto al cambiar el dropdown*/
    $('#<?php echo CHtml::activeId($model, "monto") ?>').change(function() {
        $('#monto').text($('#<?php echo CHtml::activeId($model, "monto") ?>').val() + " Bs.");
    });

    $('#plantillas li').click(function(e) {
        
        $("body").addClass("aplicacion-cargando");
        $(this).siblings().removeClass('active');
        $(this).addClass('active');

        var urlImg = $(this).attr('id');
        urlImg = urlImg.split("-");
//    urlImg = urlImg[urlImg.length - 1].split("x");
//    urlImg = urlImg.slice(0, -1);
//    console.log(urlImg);
        $('#<?php echo CHtml::activeId($model, "plantilla_url") ?>').val(urlImg[1]);

        $(".contenedorPreviewGift img").attr("src",
                "<?php echo Yii::app()->baseUrl; ?>/images/giftcards/" + urlImg[1] + "_x470.png");


        e.preventDefault();
        $("body").removeClass("aplicacion-cargando");
        
    });


</script>
<style>
    .contenedorPreviewGift{

        font-family: arial,sans-serif;
    }
    #plantillas li.active{
        /*border: solid 2px blue;*/
    }
</style>
