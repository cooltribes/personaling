<?php
/* @var $this SiteController */
// Open Graph
Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:title'), null); 
Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características', null, null, array('property' => 'og:description'), null);
Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 
Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url .'images/icono_preview.jpg', null, null, array('property' => 'og:image'), null); 


$this->pageTitle=Yii::app()->name . ' - Página de inicio';
Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características.', 'description', null, null, null);
Yii::app()->clientScript->registerMetaTag('Personaling, Mango, Timberland, personal shopper, Cortefiel, Suiteblanco, Accesorize, moda, ropa, accesorios', 'keywords', null, null, null);
?>
</div>
</div>
<!-- /Hack para el layout del home  -->


<div class="wrapper_home">
    <div id="myCarousel" class="carousel slide">

        <ol class="carousel-indicators">
            <a href="#"><li data-target="#myCarousel" data-slide-to="0" class="active"></li></a>
            <a href="#"><li data-target="#myCarousel" data-slide-to="1"></li></a>
            <a href="#"><li data-target="#myCarousel" data-slide-to="2"></li></a>
        </ol>

        <!-- Carousel items ON -->
        <div class="carousel-inner">
            <div class="active item">
                <img src="http://personaling.com<?php echo Yii::app()->theme->baseUrl; ?>/images/bg_personal_shoppers_home_4.jpg">
            </div>
            <div class="item">
                <img src="http://personaling.com<?php echo Yii::app()->theme->baseUrl; ?>/images/bg_personal_shoppers_home.jpg">
            </div>
            <div class="item">
                <img src="http://personaling.com<?php echo Yii::app()->theme->baseUrl; ?>/images/slide_version_20131015_brands.jpg">
            </div>
        </div>
        <!-- Carousel items OFF -->

    </div>
</div>

<script type="text/javascript">
$('#myCarousel').carousel({
  interval: 6000
})
</script>