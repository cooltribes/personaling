<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */

$this->pageTitle=Yii::app()->name . ' - Equipo';
//$this->breadcrumbs=array(
	//'Equipo',
//);
?>


<!-- PAGINA DE CONTACTO ON -->
<div class="span6 offset3">
    <div class="box_1" style="display:none">
        <h1>Ponte en contacto</h1>
        <?php if(Yii::app()->user->hasFlash('contact')): ?>
        <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'alerts'=>array('contact'),
    )); ?>
        <?php else: ?>
        <p class="margin_top_medium"> Si tienes alguna duda, propuesta de negocio o quieres reportar alguna falla por favor contáctanos a través del siguiente formulario:</p>
        <div class="form">
           
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'contact-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>


	<?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model,'name'); ?>

    <?php echo $form->textFieldRow($model,'email'); ?>

    <?php echo $form->textFieldRow($model,'subject',array('size'=>60,'maxlength'=>128)); ?>

    <?php echo $form->textAreaRow($model,'body',array('rows'=>4, 'class'=>'span3')); ?>

	<?php if(CCaptcha::checkRequirements()): ?>
		<?php echo $form->captchaRow($model,'verifyCode',array(
            'hint'=>'Por favor escriba las letras que se muestran aqui arriba. No importa si estan en mayúscula o minúscula.',
        )); ?>
	<?php endif; ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton',array(
            'buttonType'=>'submit',
            'type'=>'danger',
            'label'=>'Enviar',
        )); ?>
	</div>

<?php $this->endWidget(); ?>
        </div>
        <!-- form --></div>
</div>
<!-- PAGINA DE CONTACTO OFF -->

<?php endif; ?>
