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


/*

if(Yii::app()->language=='es_es'){
    $links=array(
        'banner'=>Yii::app()->baseUrl."/registro-personaling",
        'slider'=>"http://www.personaling.es/tienda-ropa-personalizada",
        'art1'=>"http://personaling.com/magazine/lista-de-regalos-para-no-fallar-estas-navidades/",
        'art2'=>"http://www.personaling.es/nightnonstop",
        'art3'=>"http://www.personaling.es/producto/detalle/5990",
        'art4'=>"http://www.personaling.es/outlet",
    );
    $copys=array(
        'banner'=>"",
        'slider'=>"",
        'art1'=>"Sé una experta en moda con nuestro glosario fashion",
        'art2'=>"¡Déjate asesorar por nuestros Personal Shoppers! ",
        'art3'=>"Los mejores precios para Navidad",
        'art4'=>"¡Compra Custo Barcelona en Personaling!",
    );
    
}else{
    $links=array(
        'banner'=>Yii::app()->baseUrl."/registro-personaling",
        'slider'=>"http://www.personaling.com.ve/tienda-ropa-personalizada",
        'art1'=>"http://www.personaling.com.ve/tienda-ropa-personalizada",
        'art2'=>"http://www.personaling.com.ve/HarryLevy",
        'art3'=>"http://www.personaling.com.ve/producto/detalle/486",
        'art4'=>"http://www.personaling.com.ve/producto/detalle/635",
    );
    $copys=array(
        'banner'=>"",
        'slider'=>"",
        'art1'=>"¡Tus must de Navidad!",
        'art2'=>"¡Déjate asesorar por nuestros Personal Shoppers!",
        'art3'=>"Consigue un vestido especial para ti",
        'art4'=>"¿Ya tienes tu pijama para Diciembre?",
    );
}

*/
?>
<?php echo $elements['banner'];?>    

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
                    <?php echo $elements['slider'];?>        
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
                                    <?php if(Yii::app()->language=='es_es'): ?>
                                    <div class="span4 no_margin_left price">
                                        <?php echo "<small>".Yii::t('contentForm', 'currSym').'</small>'.$look->getPrecioDescuento(); ?>
                                    </div>
                                    <?php else: ?>
                                    <div class="span4 no_margin_left no_margin_top text_right_align">
                                        <small class="muted"><?php echo Yii::t('contentForm','currSym'); ?></small><?php echo $look->getPrecioDescuento(); ?>
                                    </div>
                                    <?php endif; ?>
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
             
               
                    <div class="articleRight no_margin_top">
                     <?php echo $elements['art1'];?>    
                    </div>
                
               
                    <div class="articleRight">
                        <?php echo $elements['art2'];?> 
                    </div>
              
               
                    <div class="articleRight">
                      <?php echo $elements['art3'];?> 
                   
                    </div>
               
   
                    <div class="articleRight">
                     <?php echo $elements['art4'];?>    
                    </div>
             
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
                     <a title="Facebook" href="https://www.facebook.com/Personaling" target="_blank">                                   
                        <img alt="Facebook" src="<?php echo Yii::app()->theme->baseUrl.'/images/home/social/fb.jpg';?>" class="span1 socialHome"/>
                     </a>
                     <a title="Instagram" href="http://instagram.com/personaling" target="_blank"> 
                        <img alt="Instagram" src="<?php echo Yii::app()->theme->baseUrl.'/images/home/social/ig.jpg';?>" class="span1 socialHome"/>
                     </a>
                     <a title="Twitter" href="https://twitter.com/personaling" target="_blank"> 
                        <img alt="Twitter" src="<?php echo Yii::app()->theme->baseUrl.'/images/home/social/tw.jpg';?>" class="span1 socialHome"/>
                     </a>
                     <a title="Pinterest" href="https://pinterest.com/personaling/" target="_blank">   
                        <img alt="Pinterest" src="<?php echo Yii::app()->theme->baseUrl.'/images/home/social/pt.jpg';?>" class="span1 socialHome"/>
                     </a>
                     <a title="Youtube" href="http://www.youtube.com/channel/UCe8aijeIv0WvrZS-G-YI3rQ" target="_blank"   
                        <img alt="Youtube" src="<?php echo Yii::app()->theme->baseUrl.'/images/home/social/yt.jpg';?>" class="span1 socialHome"/>
                     </a> 
                     <div class="span3"></div>
                
            </div>
        
           
            <div class="row" style="margin-top:30px">
                    
                     <div class="span4">
                         <h3 class="no_margin_top socialText">
                             Sé el primero en recibir noticias y promociones suscribiéndote a nuestro NewsLetter.
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
                                    <?php echo $elements['magazine1'];?> 
                                    <?php echo $elements['magazine2'];?> 
                                    <?php echo $elements['magazine3'];?> 
                                    <?php echo $elements['magazine4'];?> 
                                    <?php echo $elements['magazine5'];?> 
                                    <?php echo $elements['magazine6'];?> 

                                    
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
<?php if($result): ?>
<div id="confirmLook" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" >
 <div class="modal-header">
    <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true" onclick="$('#confirmLook').hide();">×</button>
     <h3 >¡Felicidades!</h3>
 
  </div>
  <div class="modal-body">
         <h4>Te has suscrito a nuestro newsletter, recibirás en tu correo electrónico todas nuestras noticias y promociones</h4>
         
  </div>  
</div>
<?php endif;?>
<script type="text/javascript">
$('#sliderHome').carousel({
  interval: 6000,
});
$('#buttomCookies').on('click',function(){
    $('.message-cookies').css({display:'none',});
});
</script>