<?php
//$this->pageTitle=Yii::app()->name . ' - Página de inicio';
if($seo){
  $this->pageTitle = $seo->title;
  Yii::app()->clientScript->registerMetaTag($seo->title, 'title', null, null, null);
  Yii::app()->clientScript->registerMetaTag($seo->description, 'description', null, null, null);
  Yii::app()->clientScript->registerMetaTag($seo->keywords, 'keywords', null, null, null);
}
?>
<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */



$this->breadcrumbs=array(
	'Formas de pago',
);

// Open Graph
  Yii::app()->clientScript->registerMetaTag('Formas de Pago: Personaling', null, null, array('property' => 'og:title'), null); 
  Yii::app()->clientScript->registerMetaTag('Para facilitar tu compra ponemos a disposición tres (3) formas de pago: tarjeta de crédito, transferencia bancaria y depósito bancario. A continuación te indicamos cómo proceder según el medio que utilices.', null, null, array('property' => 'og:description'), null);
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
  Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->baseUrl .'/images/icono_preview.jpg', null, null, array('property' => 'og:image'), null); 

?>

<div class="row">
  <div class="span8">
    <div class="box_1">
      <div class="padding_medium">
          <?php echo Yii::t('contentForm','Copy Formas de Pago'); ?>
      </div>
    </div>
  </div>
  <!-- SIDEBAR ON -->
  <div class="span4"> <?php echo $this->renderPartial('_sidebar'); ?> </div>
  <!-- SIDEBAR ON --> 
</div>




