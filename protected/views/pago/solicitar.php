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
            )); ?>            
    

            <fieldset>
                <legend><h3>Tu balance actual: <strong><?php echo Yii::t('contentForm', 'currSym').
                        " " . $user->getSaldoPorComisiones(); ?></strong></h3></legend>

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
                            'min' => Pago::MONTO_MIN,
                            'max' => Pago::MONTO_MAX,
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
                <?php
                /*
                echo $form->textFieldRow($model, 'inicio_vigencia', array(
                    'append' => '<i class="icon-calendar"></i>',
                    'class' => 'span2',
                    'value' => $model->inicio_vigencia != null ?
                            date("d-m-Y", strtotime($model->inicio_vigencia)) : ''
                ));
                ?>	
                <?php
                echo $form->textFieldRow($model, 'fin_vigencia', array(
                    'append' => '<i class="icon-calendar"></i>',
                    'class' => 'span2',
                    'value' => $model->fin_vigencia != null ?
                            date("d-m-Y", strtotime($model->fin_vigencia)) : ''
                ));
                 
                 */
                ?>	

                <div class="control-group row">
                    <div class="controls pull-right">                          
                        <button type="submit" name="Enviar" class="btn btn-danger">
                            <i class="icon-envelope icon-white"></i> Enviar Solicitud
                        </button>
                    </div>
                </div>


            </fieldset>

            <?php $this->endWidget(); ?>
        </section>
</div>

