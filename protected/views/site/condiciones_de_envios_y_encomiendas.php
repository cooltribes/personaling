<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Condiciones de Envíos y Encomiendas';
$this->breadcrumbs=array(
	'Condiciones de Envíos y Encomiendas',
);
// Open Graph
  Yii::app()->clientScript->registerMetaTag('Condiciones de Envíos y Encomiendas: Personaling', null, null, array('property' => 'og:title'), null); 
  Yii::app()->clientScript->registerMetaTag('Al registrarte o realizar una compra en nuestra tienda www.personaling.com, aceptas automáticamente cada uno de los términos y condiciones que rigen nuestros envíos y encomiendas. Por ello es muy importante que te asegures de leerlos y entenderlos con antelación.', null, null, array('property' => 'og:description'), null);
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
  Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->baseUrl .'/images/icono_preview.jpg', null, null, array('property' => 'og:image'), null); 

?>

<div class="row">
  <div class="span8">
    <div class="box_1">
      <div class="padding_medium">
        <?php echo Yii::t('contentForm','Copy Envios y Encomiendas'); ?>
      </div>
    </div>
  </div>
  
  <!-- SIDEBAR ON -->
  <div class="span4"> <?php echo $this->renderPartial('_sidebar'); ?> </div>
  <!-- SIDEBAR ON --> 
</div>
