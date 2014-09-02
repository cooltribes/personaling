<?php /*<style>

.cajadevideo{

    max-width 710px;
    margin:auto;

}
.video{

    height:0px;
    width:100%;
    max-width:710px;
    padding-top:56.25%;
    position:relative;

}

#preguntas_frecuentes{

    position:absolute;
    height:100%;
    width:100%;
    top:0px;
    left:0px;

}

</style>
 */?>

<?php
//$this->pageTitle=Yii::app()->name . ' - Página de inicio';
if(isset($seo)){
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

//$this->pageTitle=Yii::app()->name . ' - Preguntas Frecuentes';
$this->breadcrumbs=array(
	'FAQ',
);

// Open Graph
  Yii::app()->clientScript->registerMetaTag('Personaling.com - Preguntas Frecuentes', null, null, array('property' => 'og:title'), null); 
  Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características', null, null, array('property' => 'og:description'), null);
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
  Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->baseUrl .'/images/icono_preview.jpg', null, null, array('property' => 'og:image'), null); 

?>

<div class="row">
  <div class="span8">
    <div class="box_1">
      <div class="page-header">
        <h1>Preguntas Frecuentes</h1>
      </div>
      <?php echo Yii::t('contentForm','copy FAQ'); ?>
    </div>
  </div>
   <!-- SIDEBAR ON -->
  <div class="span4"> <?php echo $this->renderPartial('_sidebar'); ?> </div>
  <!-- SIDEBAR ON --> 
</div>
