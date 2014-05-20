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

<!-- Mensaje Cookies ON -->
<div style="margin-top: 12px; padding: .8em; text-align: center; background: #D6D6D6; display: none;" id="cookies_notification">
    Esta web utiliza <strong>cookies</strong> para mejorar tu experiencia de usuario y para recopilar información estadística sobre tu navegación. Si continúas navegando, consideramos que aceptas su uso. <a href="<?php echo Yii::app()->baseUrl; ?>/site/politicas_de_cookies" style="color: #0000FF">Más información</a> | <a id="accept_cookies" href="#" style="color: #0000FF">No mostrar de nuevo</a>
    <button id="buttomCookies" type="button" class="close" aria-hidden="true">&times;</button>
</div>
<!-- Mensaje Cookies OFF -->
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
                                    <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_small.png' ?>" alt="Personaling" width="73"  heigth="73"> 
                                    <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_large.png' ?>" alt="Personaling" width="215"> 
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
                                    <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_small.png' ?>" alt="Personaling" width="102"  heigth="102">                                    
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
                                    <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_small.png' ?>" alt="Personaling" width="110"  heigth="110">                                                                    
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
  interval: 6000,
});
$('#buttomCookies').on('click',function(){
    $('.message-cookies').css({display:'none',});
});
</script>

<script>
$(document).ready(function(){
        var accepted = readCookie('accept_cookies');
        if(!accepted){
            $('#cookies_notification').show();
        }
    });

    $('#buttomCookies').on('click', function(e){
        createCookie('accept_cookies', 'true', 365);
        $('#cookies_notification').hide();
        //window.location.replace(this.options[this.selectedIndex].value);
    });

    $('#accept_cookies').on('click', function(e){
        createCookie('accept_cookies', 'true', 365);
        $('#cookies_notification').hide();
        //window.location.replace(this.options[this.selectedIndex].value);
    });

    /*$('.arrow').on('change', function(e){
        createCookie('country_value', this.options[this.selectedIndex].value, 7);
        window.location.replace(this.options[this.selectedIndex].value);
    });*/

    function createCookie(name,value,days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            var expires = "; expires="+date.toGMTString();
        }
        else var expires = "";
        document.cookie = name+"="+value+expires+"; path=/";
    }

    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    function eraseCookie(name) {
        createCookie(name,"",-1);
    }
</script>