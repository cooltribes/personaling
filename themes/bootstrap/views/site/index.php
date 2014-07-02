<?php
/* @var $this SiteController */
// Open Graph
Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:title'), null); 
Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características', null, null, array('property' => 'og:description'), null);
Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 
Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url .'images/icono_preview.jpg', null, null, array('property' => 'og:image'), null); 


//$this->pageTitle=Yii::app()->name . ' - Página de inicio';
//Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características.', 'description', null, null, null);
//Yii::app()->clientScript->registerMetaTag('Personaling, Mango, Timberland, personal shopper, Cortefiel, Suiteblanco, Accesorize, moda, ropa, accesorios', 'keywords', null, null, null);

$seo = SeoStatic::model()->findByAttributes(array('name'=>'Home España'));
if(isset($seo)){
    $this->pageTitle = $seo->title;
    Yii::app()->clientScript->registerMetaTag($seo->title, 'title', null, null, null);
    Yii::app()->clientScript->registerMetaTag($seo->description, 'description', null, null, null);
    Yii::app()->clientScript->registerMetaTag($seo->keywords, 'keywords', null, null, null);
}

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
                          
                                <figure class="logo-personaling ">
                                    <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_small.png' ?>" alt="Personaling" width="130"  heigth="130"> 
                                    <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_large.png' ?>" alt="Personaling" width="175"> 
                                </figure>
                                <div class="margin_top_small">
                                <h2 >Las únicas<strong> rebajas<br/>personalizadas</strong><br></h2>
                            	<a href="<?php echo Yii::app()->baseUrl; ?>/user/registration" class="btn btn-danger margin_top_small Bold">¡Regístrate!</a>
                            	</div>
                            	<div class="margintop65">
                            		<p class="personaling-slogan">La primera<b> shopping</b> experience <b>única </b>y... <b>repetible</b></p>
                            	</div>
                            
                            
                        </div>
                    </div>
                </div>                
            </div>
            <div class="item" >
                <div class="slider-home slide-2">
                    <div class="slide-content">
                        <div class="copy-right">
                            <div>
                                
                                <figure class="logo-personaling ">
                                    <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_small.png' ?>" alt="Personaling" width="102"  heigth="102">                                    
                               		 <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_large.png' ?>" alt="Personaling" width="146"> 
                                </figure>
                            </div>
                            <a href="<?php echo Yii::app()->baseUrl; ?>/tienda/index" class="btn btn-danger margin_top_xlarge Bold goStore">¡Ir a la Tienda!</a>
                            <div class="margintop80">
                                <p class="personaling-slogan  margin_top_large">La primera <strong>shopping experience</strong> única y…repetible</p>
                            </div>
                        </div>
                        
                    </div>                   
                </div>                
            </div>
            <div class="item" >
                <div class="slider-home slide-3">
                    <div class="slide-content">
                        <div class="copy-right">
                            <div>
                                <figure class="logo-personaling ">
                                    <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_small.png' ?>" alt="Personaling" width="102"  heigth="102">                                    
                               		 <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_large.png' ?>" alt="Personaling" width="146"> 
                                </figure>
                                <h2>¿Un <b>look completo</b> por <b><?php echo Yii::t('contentForm','currSym');?> 49,00?</b></h2>
                                <div class="separator90"></div>
                                 <h2>¡Consígue uno hecho<br/><b>especialmente para ti</b>!</h2>
                            </div>
                            <a href="<?php echo Yii::app()->baseUrl; ?>/tienda/look" class="btn btn-danger margin_top_small Bold">¡Cómpralo Ya!</a>
                            <div class="margintop50">
                                <p class="personaling-slogan ">Las únicas <b>rebajas personalizadas</b></p>
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
  interval: 6000,
});
$('#buttomCookies').on('click',function(){
    $('.message-cookies').css({display:'none',});
});
</script>