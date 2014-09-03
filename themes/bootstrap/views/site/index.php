<?php 
/* @var $this SiteController */
// Open Graph

//$this->pageTitle=Yii::app()->name . ' - Página de inicio';
//Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características.', 'description', null, null, null);
//Yii::app()->clientScript->registerMetaTag('Personaling, Mango, Timberland, personal shopper, Cortefiel, Suiteblanco, Accesorize, moda, ropa, accesorios', 'keywords', null, null, null);

$seo = SeoStatic::model()->findByAttributes(array('name'=>'Home España'));
if(isset($seo)){
    $this->pageTitle = $seo->title;
    Yii::app()->clientScript->registerMetaTag($seo->title, 'title', null, null, null);
    Yii::app()->clientScript->registerMetaTag($seo->description, 'description', null, null, null);
    Yii::app()->clientScript->registerMetaTag($seo->keywords, 'keywords', null, null, null);
	
	Yii::app()->clientScript->registerMetaTag($seo->title, null, null, array('property' => 'og:title'), null); 
	Yii::app()->clientScript->registerMetaTag($seo->description, null, null, array('property' => 'og:description'), null);
	 
}
else{
	Yii::app()->clientScript->registerMetaTag($_SERVER['HTTP_HOST'], null, null, array('property' => 'og:title'), null); 
	Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características', null, null, array('property' => 'og:description'), null);
}
Yii::app()->clientScript->registerMetaTag($_SERVER['HTTP_HOST'] , null, null, array('property' => 'og:url'), null);
Yii::app()->clientScript->registerMetaTag($_SERVER['HTTP_HOST'], null, null, array('property' => 'og:site_name'), null); 
Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url .'images/icono_preview.jpg', null, null, array('property' => 'og:image'), null);


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
        <div class="carousel-inner text_align_center" alt="afuera">
            <div class="item active" >
                <div class="slider-home slide-1">
                    <div class="slide-content" alt="Personaling - Tu Personal Shopper Online">
                        <div class="copy-right">
                          
                            <figure class="logo-personaling">
                                <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_small.png' ?>" alt="Personaling" width="80"> 
                                <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_large.png' ?>" alt="Personaling" width="120"> 
                                <img src="<?php echo Yii::app()->theme->baseUrl.
                                        '/images/logo_personaling_adorno.png' ?>" 
                                        alt="Personaling" width="120" class="adorno"> 
                            </figure>
                            <div class="margin_top margin_bottom">
                                <h2>¡Descubre qué<strong> tipo de <br/>cuerpo </strong>eres!<br></h2>
                                <a href="http://personaling.com/magazine/descubre-tu-tipo-de-cuerpo-y-dejate-asesorar-por-personaling" 
                                   class="btn btn-danger margin_top margin_bottom_small Bold">¡Clica aquí!</a>
                            </div>
                            <div class="margin_top">
                                    <p class="personaling-slogan margin_top"><b>Imagínate, descúbrete y conquista.</b></p>
                            </div>                            
                            
                        </div>
                    </div>
                </div>                
            </div>
            <div class="item" >
                <div class="slider-home slide-2">
                    <div class="slide-content" alt="Personaling - Tu Personal Shopper Online">
                        <div class="copy-right">
                                
                            <figure class="logo-personaling ">
                                <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_small.png' ?>" alt="Personaling" width="80">                                    
                                 <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_large.png' ?>" alt="Personaling" width="120"> 
                                 <img src="<?php echo Yii::app()->theme->baseUrl.
                                        '/images/logo_personaling_adorno.png' ?>" 
                                        alt="Personaling" width="120" class="adorno">
                            </figure>
                            
                            <div class="margin_top margin_bottom">
                                <h2><strong>Imagina</strong> la<strong> mejor<br/>
                                        versión </strong>de ti misma<br></h2>
                                <a href="http://personaling.com/magazine" 
                                   class="btn btn-danger margin_top_xlarge Bold margin_top_small">Magazine</a>                                  
                            </div>
                            
                            <div class="margin_top_large">
                                <p class="personaling-slogan  margin_top_large">
                                    <strong>¡Tu Personal Shopper Online!</strong>
                                </p>
                            </div>
                        </div>
                        
                    </div>                   
                </div>                
            </div>
            <div class="item" >
                <div class="slider-home slide-3">
                    <div class="slide-content" alt="Personaling - Tu Personal Shopper Online">
                        <div class="copy-right">
                            <figure class="logo-personaling ">
                                <img src="<?php echo Yii::app()->theme->baseUrl.
                                        '/images/logo_personaling_small.png' ?>"
                                        alt="Personaling" width="80" >                                    
                                <img src="<?php echo Yii::app()->theme->baseUrl.
                                        '/images/logo_personaling_large.png' ?>"
                                        alt="Personaling" width="120"> 
                                <h3 class="margin_top_small">Nueva Temporada</h3>
                                <img src="<?php echo Yii::app()->theme->baseUrl.
                                    '/images/logo_personaling_adorno.png' ?>" 
                                    alt="Personaling" width="120" class="adorno">
                            </figure>
                            <div>
                                <h2>OTOÑO-INVIERNO<br/>2015</h2>
                            </div>
                            <a href="<?php echo Yii::app()->baseUrl; ?>/registro-personaling"
                               class="btn btn-danger margin_top_small Bold">¡Regístrate!</a>
                            <div class="margintop50">
                                <p class="personaling-slogan "><b>
                                        Imagínate, descúbrete y conquista.
                                </b></p>
                            </div>
                        </div>                            
                        
                    </div>                    
                </div>                
            </div>
        </div>
        <!-- Carousel items OFF -->
    </div>
</section>

<?php
	
	
	if(Yii::app()->user->isGuest){
		echo'<div class="margin_top_large"></div><div class="braker_horz_top_less_space no_margin_bottom"></div>';
		
		
		$user = User::model()->findByPk(Yii::app()->user->id);
		$looks = new Look;
		$productos = new Producto;
		$psDestacados = new User;
                
                
                $psDestacados = User::model()->findAllByAttributes(array('ps_destacado' => '1'), new CDbCriteria(array(
                    'limit' => 4,
                    'order' => 'fecha_destacado DESC'
                )));
                
		$this->renderPartial('/site/top',array(
					'dataProvider' => $looks->masvendidos(3),
					'dataProvider_productos' => $productos->masvendidos(6),
					'dataProvider_destacados' => $looks->lookDestacados(3),
					'user'=>$user,
                                        'psDestacados' => $psDestacados,
                                        'seo'=>$seo//->getPsDestacados(4),
				));	
		
		
	}
?>

<script type="text/javascript">
$('#sliderHome').carousel({
  interval: 6000,
});
$('#buttomCookies').on('click',function(){
    $('.message-cookies').css({display:'none',});
});
</script>