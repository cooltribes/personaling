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


<section class="wrapper_home">
    <div id="sliderHome" class="carousel slide">
        <ol class="carousel-indicators">
            <li data-target="#sliderHome" data-slide-to="0" class="active"></li>
            <li data-target="#sliderHome" data-slide-to="1" ></li>
            <li data-target="#sliderHome" data-slide-to="2" ></li>
        </ol>
        <!-- Carousel items ON -->
        <div class="carousel-inner">
            <div class="active item" >
                <div class="slider-home slide-1">
                    <div class="slide-content">
                        <div class="copy-left">
                            <div class="border-bottom">
                                <h2>&nbsp &nbsp  &nbsp &nbsp &nbsp ¿Estás buscando <br/> <strong>looks personalizados</strong> para ti?</h2>
                                <a href="#" class="btn-call2action">¡Regístrate!</a>
                            </div>
                            <div>
                                <figure class="logo-personaling">
                                    <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling.png' ?>" alt="Personaling">
                                </figure>

                                <p class="personaling-slogan text_align_center">Somos tu Personal Shopper Online</p>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="item" >
                <div class="slider-home slide-2">
                    <div class="slide-content">
                        
                    </div>                   
                </div>                
            </div>
            <div class="item" >
                <div class="slider-home slide-3">
                    <div class="slide-content">
                        
                    </div>                    
                </div>                
            </div>
        </div>
        <!-- Carousel items OFF -->
    </div>
</section>

<script type="text/javascript">
$('#sliderHome').carousel({
  interval: 20000
});
</script>