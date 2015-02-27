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
    <div class="box_1" >
    	
    	<?php // echo $_SERVER['REMOTE_ADDR']; ?> 
        <h1>Ponte en contacto</h1>

    	<?php if(Yii::app()->user->hasFlash('contact')){?>
		    <div class="alert in alert-block fade alert-success text_align_center">
		        <?php echo Yii::app()->user->getFlash('contact'); ?>
		    </div>
		<?php } ?>
 
        <p class="margin_top_medium"><?php echo Yii::t('contentForm','Perhaps you want to ask is in our <a href="'.Yii::app()->getBaseUrl().'/site/preguntas_frecuentes" title="Preguntas frecuentes">FAQ section</a>. If you can not find it there, fill out the form below and we will contact you as soon as possible. <strong>Thank you!</strong>'); ?></p>
        <div class="form">
           
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'contact-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>


	<?php echo $form->errorSummary($model, 'Por favor rellena los Campos en Rojo'); ?>

    <?php echo $form->textFieldRow($model,'name'); ?>

    <?php echo $form->textFieldRow($model,'email'); ?>
	
	
		<?php echo $form->dropDownListRow($model, 'motivo', array(
			    'Solicitud de información'=>'Solicitud de información',
			    'Seguimiento del envío'=>'Seguimiento del envío',
			    'Información de pagos'=>'Información de pagos',
			    'Problemas con la mercancía'=>'Problemas con la mercancía',
			    'Devoluciones'=>'Devoluciones',
			    'Falla Técnica'=>'Falla Técnica',
			    'Asesoría de imagen' => 'Asesoría de imagen', 
			    'Otro'=>'Otro',
			), array(
			    'empty' => 'Seleccione' 
			));
		?>
	
    <?php echo $form->textFieldRow($model,'subject',array('size'=>60,'maxlength'=>128)); ?>

    <?php echo $form->textAreaRow($model,'body',array('rows'=>4, 'class'=>'span3')); ?>

			<?php if(CCaptcha::checkRequirements()): ?>
			<?php echo $form->textFieldRow($model,'verifyCode'); ?>
			
		
		
		<?php #echo $form->textField($model,'verifyCode'); ?>
		<div align="center">
			<?php $this->widget('CCaptcha', array('imageOptions' => array('id' => 'yw0'),'showRefreshButton' => true,'buttonLabel' => 'Refrescar', 'buttonOptions' => '', 'buttonType' => 'button')); ?>
			<div class="hint">Por favor, introduzca las letras como se muestra. 
        <br/>Las letras no distinguen entre mayusculas y minusculas.</div>
        
		<?php echo $form->error($model,'verifyCode'); ?>
			
		</div>
		
	
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
  
  
<script>  
 
 $(document).on('ready', function (){
 	
 	document.getElementById( 'yw0' ).style.display = 'none';
	$('#yw0_button').click(); 
	document.getElementById( 'yw0' ).style.display = 'inline';
   })
	
</script>
