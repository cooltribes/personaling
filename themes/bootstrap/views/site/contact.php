<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contacto';
$this->breadcrumbs=array(
	'Contacto',
);

// Open Graph
  Yii::app()->clientScript->registerMetaTag('Personaling.com - Contacto', null, null, array('property' => 'og:title'), null); 
  Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características', null, null, array('property' => 'og:description'), null);
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
  Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->baseUrl .'/images/icono_preview.jpg', null, null, array('property' => 'og:image'), null); 
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
 
        <p class="margin_top_medium">Es posible que lo que quieras preguntar esté en nuestro apartado de <a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/preguntas_frecuentes" title="Preguntas frecuentes">Preguntas frecuentes</a>. Si no está allí lo que buscas, llena este formulario y te contactaremos lo más pronto posible. O LLama al  (212) 7202089. <strong>¡Gracias!</strong></p>
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

