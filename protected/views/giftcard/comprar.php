<?php
/* @var $this GiftcardController */
/* @var $model Giftcard */

$this->breadcrumbs = array(
    'Mis Giftcards'=>array('adminUser'),
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
    <h1><?php echo Yii::t('contentForm','Gift Card'); ?></h1>
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
            <legend><?php echo Yii::t('contentForm','Buy Gift Card'); ?></legend>

            <div>
                <p class="lead">1. <?php echo Yii::t('contentForm','Select a design for the Gift Card'); ?></p>
                <ul class="thumbnails" id="plantillas">
                    <li class="active" id="GC-gift_card_one">
                        <a href="active">
                            <div class="thumbnail">
                                <img src="<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x200.jpg">
                            </div>
                        </a>
                    </li>		
                    <?php echo $form->hiddenField($model, 'plantilla_url'); ?>
                </ul>
            </div>	
            <div>
                <p class="lead">2. <?php echo Yii::t('contentForm','Select the price'); ?></p>
                <?php echo $form->errorSummary($model); ?>

                <div class="control-group input-prepend">
                    <label class="control-label required" for="BolsaGC_monto"><?php echo Yii::t('contentForm','Amount'); ?> <span class="required">*</span></label>
                    <div class="controls">
                        <span class="add-on"><?php echo Yii::t('contentForm', 'currSym'); ?></span>
                        <?php echo CHtml::activeDropDownList($model, 'monto', Giftcard::getMontos(), array('class' => 'span1',)); ?>
                    </div>
                    
                </div>
               

            </div>	


            <div class="row margin_top">
                <div class="span6">	
                    <p class="lead">3. <?php echo Yii::t('contentForm','Customize it'); ?></p>                                       

                    <?php
                    echo $form->textFieldRow($envio, 'nombre', array(
                        'placeholder' => Yii::t('contentForm','Whom you send him')
                    ));
                    ?>                                        

                    <?php
                    echo $form->textAreaRow($envio, 'mensaje', array(
                        'placeholder' => Yii::t('contentForm','Write message'), 'maxlength' => '100'));

                    $checkI = $checkE = "";

                    if (!Yii::app()->getSession()->contains('entrega') ||
                            Yii::app()->getSession()->get('entrega') == 1) {

                        $checkI = 'checked="checked"';
                    } else if (Yii::app()->getSession()->get('entrega') == 2) {

                        $checkE = 'checked="checked"';
                    }
                    ?>
                    <p class="lead">4. <?php echo Yii::t('contentForm','¿A quién la envías?'); ?></p>



                         <input type="hidden" name="entrega" value="2" >

                        <?php
                        echo $form->textFieldRow($envio, 'email', array(
                            'placeholder' => 'Correo electrónico del destinatario'
                        ));
                        ?>  





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
                                <div class=" T_xlarge color4" id="monto"><?php echo $model->monto." ".Yii::t('contentForm','currSym'); ?> </div>

                                <div class="margin_top color4" id="codigo"><div class="color9"><?php echo Yii::t('contentForm','Code'); ?></div> <?php echo "XXXX-XXXX-XXXX-XXXX"; ?> </div>
                            </div>
                            <div class="span6">
                                <strong  id="forpara"><?php echo Yii::t('contentForm','To1'); ?>:</strong>&nbsp;<span id="para"></span>
                                <div>
                                    <strong  id="formensaje"><?php echo Yii::t('contentForm','Message'); ?>:</strong>&nbsp;<span class="" id="mensaje"></span>
                                </div>                        

                            </div>
                        </div>
                        <div class="text_center_align margin_bottom_minus margin_top_small">
                            <span class=" t_small" id="fecha">
                                <?php 
                                $now = date('Y-m-d', strtotime('now'));
                                echo Yii::t('contentForm','Valid from <strong>{start}</strong> until <strong>{end}</strong>',array('{start}'=>date("d/m/Y"),'{end}'=>date("d/m/Y", strtotime($now . " + 1 year")))) ?>
                                 </strong>
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

    $('#EnvioGiftcard_nombre').keyup(function() {
        $('#para').text($('#EnvioGiftcard_nombre').val());
    });

    $('#EnvioGiftcard_nombre').focusout(function() {
        $('#para').text($('#EnvioGiftcard_nombre').val());
    });

    $('#EnvioGiftcard_mensaje').keyup(function() {
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
        $('#monto').text($('#<?php echo CHtml::activeId($model, "monto") ?>').val() + " <?php echo Yii::t('contentForm', 'currSym'); ?>");
    });

    $('#plantillas li').click(function(e) {

        $("body").addClass("aplicacion-cargando");
        $(this).siblings().removeClass('active');
        $(this).addClass('active');

        var urlImg = $(this).attr('id');
        urlImg = urlImg.split("-");
        
        $('#<?php echo CHtml::activeId($model, "plantilla_url") ?>').val(urlImg[1]);

        $(".contenedorPreviewGift img").attr("src",
                "<?php echo Yii::app()->baseUrl; ?>/images/giftcards/" + urlImg[1] + "_x470.jpg");
                
        e.preventDefault();
        

    });
    
    $(".contenedorPreviewGift img").load(function(e){
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
