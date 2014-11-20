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

if(Yii::app()->language=='es_es'){
    $links=array(
        'banner'=>"http://www.personaling.es/develop/registro-personaling",
        'slider'=>"http://www.personaling.es/nightnonstop",
        'art1'=>"http://personaling.com/magazine/como-llevar-la-clasica-camisa-vaquera-segun-mi-tipo-de-cuerpo/",
        'art2'=>"http://www.personaling.es/outlet",
        'art3'=>"http://www.personaling.es/producto/detalle/5808",
        'art4'=>"http://www.personaling.es/look/998",
    );
    $copys=array(
        'banner'=>"",
        'slider'=>"",
        'art1'=>"¡Dejáte llevar por la moda vaquera!",
        'art2'=>"Compra prendas hasta con 50% de descuento en nuestro outlet ",
        'art3'=>"Compra los productos tendencia de esta temporada en nuestra tienda",
        'art4'=>"Compra looks especiales para ti",
    );
    
}else{
    $links=array(
        'banner'=>"http://www.personaling.es/develop/registro-personaling",
        'slider'=>"http://www.personaling.com.ve/looks-personalizados",
        'art1'=>"http://www.personaling.com.ve/producto/detalle/658",
        'art2'=>"http://www.personaling.com.ve/look/307",
        'art3'=>"http://www.personaling.com.ve/producto/detalle/571",
        'art4'=>"http://www.personaling.com.ve/look/264",
    );
    $copys=array(
        'banner'=>"",
        'slider'=>"",
        'art1'=>"¡Únete a la fiebre de las bandoleras",
        'art2'=>"Encuentra los mejores looks inspirados en las famosas",
        'art3'=>"¡Suéteres para todas!",
        'art4'=>"Compra looks especiales para ti",
    );
}


?>
<a href="<?php echo $links['banner'];?>">     
    <img src="<?php echo Yii::app()->theme->baseUrl.'/images/home/'.Yii::app()->language.'/banner.jpg';?>" width="100%">
</a>
<!--<div class="onBanner row-fluid">

     <!--
        <div class="span5 offset6 text_center_align">
            
         
                          
                            <figure class="logo-personaling">
                                <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_small.png' ?>" alt="Personaling" width="80"> <br/>
                                <img src="<?php echo Yii::app()->theme->baseUrl.'/images/logo_personaling_large.png' ?>" alt="Personaling" width="120"> 
                               
                            </figure>
                            <div class="margin_top margin_bottom">
                                <p class="personaling-slogan margin_top"><b>Imagínate, descúbrete y conquista.</b></p>
                                <h2>Tu Personal Shopper Online</h2>
                                <a href="http://www.personaling.es/develop/registro-personaling" 
                                   class="btn btn-danger margin_top margin_bottom_small Bold" styler="background-color:#000">REGISTRATE</a>
                            </div>
                                       
        </div>
        

</div>-->
<script>
    $('#page').removeClass('container');
    
</script>
<!-- /Hack para el layout del home  -->

 
<div class="container">
    <div class="content">
        <div class="row" style="margin-top: 80px">
            <div class="span9">
                <div>
                    <a href="<?php echo $links['slider'];?>">
                    
                        <img src="<?php echo Yii::app()->theme->baseUrl.'/images/home/'.Yii::app()->language.'/slide1.jpg';?>" />
                    </a>    
                </div>
                <section>
                <div class="sectionTitle">
                    <div class="braker"></div>
                    <div class="text" ><h2>Looks Destacados</h2></div>
                    <div class="braker"></div>                
                </div>
                
                <div class="row-fluid">
               <?php foreach(Look::model()->destacadosHome(3) as $look): ?>
                   <div class="span4 lookHome"> 
                        <a href="<?php echo $look->getUrl(); ?>">
                        <?php echo CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id)), "Look", array("width" => "100%", "height" => "400", 'class'=>''));?>                       
                        </a>
                        <div class="hidden-phone hidden-tablet vcard" >
                            <a href="<?php echo $look->user->profile->getUrl(); ?>">
                                <div class="row-fluid">
                                    <div class="span2" style="margin-top:5px">                                        
                                        <?php echo CHtml::image($look->user->getAvatar(),'Avatar',array("width"=>"100%", "class"=>"photo img-circle")); ?>
                                        
                                    </div>
                                    <div class="span6" style="margin-left:10px">
                                      <span class="muted">                                         
                                                <?php echo Yii::t('contentForm','By'); ?>:                                         
                                      </span>
                                        <h5>
                                        <?php echo CHtml::link('<span class="fn">'.$look->user->profile->getNombre().'</span>',$look->user->profile->getUrl()); ?>
                                        </h5>
                                    </div>
                                    <div class="span4 no_margin_left price">
                                        <?php echo Yii::t('contentForm', 'currSym').''.$look->getPrecioDescuento(); ?>
                                    </div>
                                    
                                </div>
                                
                            </a>
                        </div>
                    
                    </div>
                 <?php endforeach; ?>               
                    
                    
                 </div>   
                 <div class="row-fluid">
                    <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/looks-personalizados">
                        <div class="span4 offset4 sectionButton text_center_align" >
                            Ver todos los Looks
                        </div>
                    </a>
                 </div>
                 </section>
                 <section>
                 
                    <div class="sectionTitle">
                        <div class="braker"></div>
                        <div class="text" ><h2>Personal Shoppers Destacados</h2></div>
                        <div class="braker"></div>                
                    </div>
                <div class="row-fluid">
                <?php foreach (User::model()->psDestacados(4) as $ps1): ?>
                    <div class="span3 pShopper">
                    <a href="<?php echo $ps1->profile->getUrl(); ?>">                        
                        <div>
                            <img alt="<?php echo $ps1->profile->first_name . " " . $ps1->profile->last_name; ?>" src="<?php echo $ps1->getAvatar(); ?>" width="100%"/>                        
                        </div>
                     </a>   
                        <div class="bio">
                              <a href="<?php echo $ps1->profile->getUrl(); ?>">   
                                  <h4 class="text_center_align">
                                      <?php echo $ps1->profile->getNombre(); ?>
                                  </h4>
                             </a>
                           <!--  <small> <?php //echo $ps1->profile->bio ?> </small>  -->                     
                        </div>
                    </div>
                    
                <?php endforeach; ?>
                </div>
                <div class="row-fluid">
                    <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/user/profile/listado">
                        <div class="span4 offset4 sectionButton text_center_align">
                            Ver todos los Personal Shoppers
                        </div>
                    </a>
                 </div>
                 </section>
            </div>
            <div class="span3">
                <section>
                <a href="<?php echo $links['art1'];?>">
               
                    <div class="articleRight no_margin_top">
                        <img src="<?php echo Yii::app()->theme->baseUrl.'/images/home/'.Yii::app()->language.'/articles/art1.jpg';?>" width="100%" />
                       <div class="articleLegend text_center_align">
                           <?php echo $copys['art1'];?>
                       </div> 
                    </div>
                </a>
                <a href="<?php echo $links['art2'];?>">
                    <div class="articleRight">
                        <img src="<?php echo Yii::app()->theme->baseUrl.'/images/home/'.Yii::app()->language.'/articles/art2.jpg';?>" width="100%" />
                       <div class="articleLegend">
                           <?php echo $copys['art2'];?>
                       </div> 
                    </div>
                </a>
                <a href="<?php echo $links['art3'];?>">
                    <div class="articleRight">
                        <img src="<?php echo Yii::app()->theme->baseUrl.'/images/home/'.Yii::app()->language.'/articles/art3.jpg';?>" width="100%" />
                       <div class="articleLegend">
                           <?php echo $copys['art3'];?>
                       </div> 
                    </div>
                </a>
                <a href="<?php echo $links['art4'];?>">
                    <div class="articleRight">
                        <img src="<?php echo Yii::app()->theme->baseUrl.'/images/home/'.Yii::app()->language.'/articles/art4.jpg';?>" width="100%" />
                       <div class="articleLegend margin_top_medium">
                           <?php echo $copys['art4'];?>
                       </div> 
                    </div>
                </a>
      <!--          <div style="background-color: #6F6F6F; margin-top: 80px; width:100%; height:207px; position: relative; overflow-y: hidden;">
                  
                   <div style="width:100%; height:45px; position:absolute; top:25%; font-size: 25px; line-height: 27px; text-align: center; color:#000 ">
                       ¡Descubre qué <b>tipo de cuerpo</b> eres!
                        <div style="margin-top: 25px; font-size: 14px; margin-left:25%; width:50%; height:30px; line-height:30px; background-color: #000; color: #FFF; text-align: center">
                            ¡Clica aquí!
                        </div>
                   
                   </div> 
                   
                </div> --> 
                
                   
                </div>
                </section>
                
            </div>
            <section>
             <div class="span12 no_margin_left sectionTitle">
                        <div class="braker"></div>
                        <div class="text" ><h2>Productos Destacados</h2></div>
                        <div class="braker"></div>
             </div>
           
             
             
             
             <div class="row">
                
               <?php    foreach(Producto::model()->destacados(6) as $producto): ?>
                   <article><?php
                            $image = CHtml::image($producto->getImageUrl(), "Imagen", array("class" => "span2"));                            
                            echo CHtml::link($image, $producto->getUrl() );
                            ?>
                   </article>
               <?php endforeach; ?>  
               
                                
             </div>
             </section>
             <section>
             <div class="span12 no_margin_left sectionTitle">
                        <div class="braker"></div>
                        <div class="text" ><h2>Redes sociales y newsletter</h2></div>
                        <div class="braker"></div>
             </div>

             
         
            <div class="row" style="margin-top:30px">
            
                     <div class="span4">
                         <h3 class="no_margin_top socialText" >
                             ¡Sígue nuestras redes sociales para enterarte de lo último en moda y tendencias!
                         </h3>
                     </div>
                     <a title="Facebook" href="https://www.facebook.com/Personaling">                                   
                        <img alt="Facebook" src="<?php echo Yii::app()->theme->baseUrl.'/images/home/social/fb.jpg';?>" class="span1"/>
                     </a>
                     <a title="Instagram" href="http://instagram.com/personaling"> 
                        <img alt="Instagram" src="<?php echo Yii::app()->theme->baseUrl.'/images/home/social/ig.jpg';?>" class="span1"/>
                     </a>
                     <a title="Twitter" href="https://twitter.com/personaling"> 
                        <img alt="Twitter" src="<?php echo Yii::app()->theme->baseUrl.'/images/home/social/tw.jpg';?>" class="span1"/>
                     </a>
                     <a title="Pinterest" href="https://pinterest.com/personaling/">   
                        <img alt="Pinterest" src="<?php echo Yii::app()->theme->baseUrl.'/images/home/social/pt.jpg';?>" class="span1"/>
                     </a>
                     <a title="Youtube" href="http://www.youtube.com/channel/UCe8aijeIv0WvrZS-G-YI3rQ">   
                        <img alt="Youtube" src="<?php echo Yii::app()->theme->baseUrl.'/images/home/social/yt.jpg';?>" class="span1"/>
                     </a> 
                     <div class="span3"></div>
                
            </div>
        
           
            <div class="row" style="margin-top:30px">
                    
                     <div class="span4">
                         <h3 class="no_margin_top socialText">
                             Se el primero en recibir noticias y promociones suscribiéndote a nuestro NewsLetter.
                         </h3>
                     </div>
                     <form method="post" id="suscribe">                                 
                         <div class="span6">
                             <input placeholder="e-mail" type="email" id="email" name='email' required="required" class="email"/>
                         </div>
                         <div class="span2">
                            <input type="submit" class="button text_center_align" value="Enviar">
                         </div>
                     </form>                           
                          
             </div>
             </section>
             <section>
             <div class="span12 no_margin_left sectionTitle">
                        <div class="braker"></div>
                        <div class="text" ><h2>Aquí hablan de tu Personal Shopper</h2></div>
                        <div class="braker"></div>
             </div>
            <div class="row">
                <ul class="no_list_style">     
                     
                     <div class="span8 no_margin_left">
                        <h4>En los medios</h4>
                        <div class="row-fluid">
                            <div class="span11">
                                <div class="row-fluid">
                                    <a title="Agente K" class="span2" href="http://www.agente-k.com/personaling-es-de-compras-con-tu-personal-shopper-sin-salir-de-casa/">
                                        <img src="<?php echo Yii::app()->theme->baseUrl.'/images/home/magazines/agk.jpg';?>" alt="Agente K" height="70px" />
                                    </a>
                                    <a title="Cosmopolitan" class="span2" href="https://www.facebook.com/Cosmopolitan.es/photos/a.114689081490.110515.55254956490/10152496043136491/?type=1&permPage=1">
                                        <img src="<?php echo Yii::app()->theme->baseUrl.'/images/home/magazines/cosmo.jpg';?>" alt="Cosmopolitan" height="70px" />
                                    </a>
                                    
                                    <a title="Marie Claire" class="span2" href="http://www.marie-claire.es/moda/tendencias/articulo/personalizar-esta-de-moda-541415705858">
                                        <img src="<?php echo Yii::app()->theme->baseUrl.'/images/home/magazines/mc.jpg';?>" alt="Marie Claire" height="70px" />
                                    </a>
                                    <a title="Movistar" class="span2" href="http://www.masquenegocio.com/2014/05/05/heidi-garcia-adragna-personaling-moda-personal-shopper/">
                                        <img src="<?php echo Yii::app()->theme->baseUrl.'/images/home/magazines/mstar.jpg';?>" alt="Movistar" height="70px" />
                                    </a>                                    
                                    <a title="Woman" class="span2" href="http://www.woman.es/moda/novedades/lo-ultimo-en-venta-on-line-personaling">
                                        <img src="<?php echo Yii::app()->theme->baseUrl.'/images/home/magazines/woman.jpg';?>" alt="Woman" height="70px" />
                                    </a>
                                    <a title="S Moda" class="span2" href="http://smoda.elpais.com/articulos/moda-e-internet-un-binomio-ganador/5121">
                                        <img src="<?php echo Yii::app()->theme->baseUrl.'/images/home/magazines/smoda.jpg';?>" alt="S Moda" height="70px" />
                                    </a>
                                    
                                </div>
                            </div>
                        </div>    
                     </div>
                     <div class="span4 no_margin_left">
                        <h4>Nos avalan</h4>
                        <div class="row-fluid">
                            <a title="Wayra" href="http://ve.wayra.org/es/startup/personaling" class="span3">
                                <img alt="Wayra" src="<?php echo Yii::app()->theme->baseUrl.'/images/home/logos/wayra.jpg';?>" height="25px"/>
                            </a>
                            <a title="StartUp Chile" href="http://www.startupchile.org/congrats-welcome-to-start-up-chiles-9th-gen/"  class="span5">
                                <img alt="StartUp Chile" src="<?php echo Yii::app()->theme->baseUrl.'/images/home/logos/sc.jpg';?>" height="25px"/>
                            </a>
                            <a title="Concurso Ideas" href="http://wiki.ideas.org.ve/index.php/Portal_e-commerce_Personaling_gana_Concurso_Ideas_2013"  class="span3">
                                 <img alt="Concurso Ideas" src="<?php echo Yii::app()->theme->baseUrl.'/images/home/logos/ideas.jpg';?>" height="25px"/>
                            </a>
                        </div>    
                     </div>
                    
                                                      
                     
                </ul>           
             </div> 
             </section>
            
        </div>
        
    </div>
    
</div>

<?php
    /* $this->renderPartial(Yii::app()->language);
	
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
					'destacados' => $productos->destacados(6),
					'dataProvider_destacados' => $looks->lookDestacados(3),
					'user'=>$user,
                                        'psDestacados' => $psDestacados,
                                        'seo'=>$seo//->getPsDestacados(4),
				));	
		
		
	}*/
?>

<script type="text/javascript">
$('#sliderHome').carousel({
  interval: 6000,
});
$('#buttomCookies').on('click',function(){
    $('.message-cookies').css({display:'none',});
});
</script>