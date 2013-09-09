<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contacto';
$this->breadcrumbs=array(
	'Contacto',
);
?>

<div class="row">
<!-- PAGINA DE CONTACTO ON -->
<div class="span8 ">
    <div class="box_1 bg_mancha_1 " >
        <h1>Ponte en contacto</h1>

    	<?php if(Yii::app()->user->hasFlash('contact')){?>
		    <div class="alert in alert-block fade alert-success text_align_center">
		        <?php echo Yii::app()->user->getFlash('contact'); ?>
		    </div>
		<?php } ?>

        <p class="margin_top_medium">Es posible que lo que quieras preguntar esté en nuestro apartado de <a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/preguntas_frecuentes" title="Preguntas frecuentes">Preguntas frecuentes</a>.  Si no está allí lo que buscas, llena este formulario y te contactaremos lo más pronto posible. <strong>¡Gracias!</strong></p>
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
            'hint'=>'Por favor escriba las letras que se muestran aquí arriba. No importa si están en mayúscula o minúscula.',
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

 
  <!-- SIDEBAR ON -->
  <div class="span4"> <?php echo $this->renderPartial('_sidebar'); ?> </div>
  <!-- SIDEBAR ON --> </div>

