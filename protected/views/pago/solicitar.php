<?php
/* @var $this PagoController */
/* @var $model Pago */

$this->breadcrumbs=array(
	'Pagos'=>array('index'),
	'Solicitar pago',
);

?>

<div class="container">
	<h1>Solicitud de Pago</h1>
	<section class="bg_color3  span9 offset1 margin_bottom_small padding_small box_1">
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id'=>'giftcard-form',
                //'enableAjaxValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions' => array(
                 // 'class' => 'form-horizontal',
                ),
                'type' => 'horizontal',
            ));            
                        
            ?>            
    

            <fieldset>
                <legend><h3>Tu balance actual en comisiones: <strong><?php echo Yii::t('contentForm', 'currSym').
                        " " . $balance; ?></strong></h3></legend>

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
                
                
                <?php if($balance > 0){ ?>               
                
                <?php  echo $form->errorSummary($model, ""); ?>
                <div class="control-group input-prepend<?php echo $model->hasErrors("monto") ? " error" : ""; ?>">
                    <label class="control-label required">
                        <?php echo Yii::t('contentForm', 'Amount'); ?> <span class="required">*</span>
                    </label>
                    <div class="controls">
                        <span class="add-on"><?php echo Yii::t('contentForm', 'currSym'); ?></span>
                        <?php echo CHtml::activeNumberField($model, 'monto', array(
                            'class' => 'span1 text_align_right',
                            'step' => 'any',
                            'min' => $model->tipo == 1 ? Pago::MONTO_MIN_BANCO : Pago::MONTO_MIN_PAYPAL,
                            'max' => Pago::MONTO_MAX,
                            //'max' => $balance,
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group<?php echo $model->hasErrors("tipo") ? " error" : ""; ?>">
                    <label class="control-label required">
                        <?php echo Yii::t('contentForm', 'Pay through'); ?> <span class="required">*</span>
                    </label>
                    <div class="controls">                        
                        <?php echo TbHtml::activeDropDownList($model, 'tipo',Pago::getTiposPago(),
                                array('class' => 'span2',
                                      'prompt' => '-Seleccionar-',
                                      'required' => true,
                                    )); ?>
                    </div>
                </div>

                <!--BANCO-->
                <?php                
                echo $form->textFieldRow($model, 'entidad', array(
                    'class' => 'span2',
                    'hint' => 'En caso de seleccionar pago mediante Cuenta Bancaria',
//                    'required' => true,
                ));
                ?>	
                <!--Cuenta-->
                <?php                
                echo $form->textFieldRow($model, 'cuenta', array(
                    'class' => 'span3',
                    'hint' => 'Cuenta PayPal o Nro. de cuenta bancaria',
                    'required' => true,
                ));
                ?>	
                <div class="control-group row">
                    <div class="controls pull-right">                          
                        <button type="submit" name="Enviar" class="btn btn-danger">
                            <i class="icon-envelope icon-white"></i> Enviar Solicitud
                        </button>
                    </div>
                </div>
                                
                <?php } ?>


            </fieldset>

            <?php $this->endWidget(); ?>
        </section>
</div>

<script type="text/javascript">
    
    var minP = "<?php echo Pago::MONTO_MIN_PAYPAL; ?>";
    var minB = "<?php echo Pago::MONTO_MIN_BANCO; ?>";
    var idTipo = <?php echo '"'.TbHtml::activeId($model, "tipo").'"'; ?>;
    var idMonto = <?php echo '"'.TbHtml::activeId($model, "monto").'"'; ?>;
    
    $("#" + idTipo).change(function(e){
        var tipo = $(this).val();
        console.log(tipo);
        $("#" + idMonto).attr("min", tipo == 0 ? minP : minB);
        
    });
    
    
    
</script>

