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

<div class="no-backgrounds">
    
</div>

<section class="wrapper_home">
    <div id="sliderHome" class="carousel slide">
        <ol class="carousel-indicators">
            <li data-target="#sliderHome" data-slide-to="0" class="active"></li>
            <li data-target="#sliderHome" data-slide-to="1" ></li>
            <li data-target="#sliderHome" data-slide-to="2" ></li>
        </ol>
        <!-- Carousel items ON -->
        <div class="carousel-inner text_align_center">
            <div class="item active" >
                <div class="slider-home slide-1">
                    <div class="slide-content">
                        <div class="copy-right">
                            <div class="border-bottom">
                                <figure class="logo-personaling ">
                                    <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_small.png' ?>" alt="Personaling" width="95"  heigth="95"> 
                                    <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_large.png' ?>" alt="Personaling" width="260"> 
                                </figure>
                                <h2>La primera <br><strong>shopping experience</strong><br>única y…repetible.</h2>
                            </div>
                            <a href="<?php echo Yii::app()->baseUrl; ?>/user/registration" class="btn-call2action">¡Regístrate!</a>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="item" >
                <div class="slider-home slide-2">
                    <div class="slide-content">
                        <div class="copy-right">
                            <div class="border-bottom">
                                <h2 class="">Solamente tú, <br/> eres <strong>irrepetible.</strong></h2>

                                <figure class="logo-personaling ">
                                    <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_small.png' ?>" alt="Personaling" width="135"  heigth="135">                                    
                                </figure>
                            </div>
                            <div>
                                <p class="personaling-slogan  margin_top_medium">La primera <strong>shopping experience</strong> única y…repetible</p>
                            </div>
                        </div>
                        
                    </div>                   
                </div>                
            </div>
            <div class="item" >
                <div class="slider-home slide-3">
                    <div class="slide-content">
                        <div class="copy-right">
                            <div class="border-bottom">
                                <h2>Si algo puede mejorar el <br> carácter de <strong>la moda</strong>,<br>sin duda, es <strong>tu personalidad.</strong></h2>
                                <figure class="logo-personaling ">
                                    <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_small.png' ?>" alt="Personaling">                                                                    
                                </figure>
                            </div>
                            <div>
                                <p class="personaling-slogan ">La primera <strong>shopping experience</strong> única y…repetible</p>
                            </div>
                        </div>                            
                        
                    </div>                    
                </div>                
            </div>
        </div>
        <!-- Carousel items OFF -->
    </div>
</section>


<script type="text/javascript">
$('#sliderHome').carousel({
  interval: 6000
});
</script>