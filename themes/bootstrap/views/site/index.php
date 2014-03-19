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
<style>
.note_startupchile {
	position: absolute;
	top:5em;
	left:0;
	display:none;
}
</style>



<div class="wrapper_home">


  <div id="myCarousel" class="carousel slide">

    <!-- Carousel items -->
    <div class="carousel-inner">
      <div class="active item">  <img src="http://personaling.com<?php echo Yii::app()->theme->baseUrl; ?>/images/bg_personal_shoppers_home_4.jpg">
      </div>
            <div class="item"><img src="http://personaling.com<?php echo Yii::app()->theme->baseUrl; ?>/images/bg_personal_shoppers_home.jpg"></div>
            <div class="item"><img src="http://personaling.com<?php echo Yii::app()->theme->baseUrl; ?>/images/slide_version_20131015_brands.jpg"></div>


    </div>




  </div>

    <div class="box_20130928 margin_bottom_small">
        <h1>Obtén recomendaciones <span>personalizadas adaptadas a ti</span></h1>
        <p>
          <span>1.</span> Ingresa tu correo electrónico
          <span>2.</span> Indica la forma de tu cuerpo y medidas
          <span>3.</span> Elige tu estilo
          <br><span>4.</span> Compra Looks de las mejores marcas recomendados a tu medida
        </p>
        <a href="<?php echo Yii::app()->getBaseUrl(); ?>/user/registration" title="Registrate" class="btn btn-danger margin_top_small btn-large">Comienza aquí</a> </div>

  </div>

<!--   <div class="container menciones ">
    <div class="row"><div class="span3">
      <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo_onda.png" alt="Onda estación">
      <blockquote>"Diseño, tecnología, web y moda" </blockquote>                     

    </div>
    <div class="span3">
      <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo_ojo.png" alt="Revista Ojo">

      <blockquote>"Asesoría de moda en la web venezolana"   </blockquote>                   

    </div>
    <div class="span3">
      <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo_globovision.png" alt="Globovision">

      <blockquote>"Wayra acelerará este 2013 tres nuevos proyectos emprendedores" </blockquote></div>
      <div class="span3">
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo_universal.png" alt="El Universal">

        <blockquote>"Proyectos emprendedores de Wayra"</blockquote></div></div>


      </div> -->
<?php /*?><div class="note_startupchile"> <a href="#wayra" role="button" data-toggle="modal"><img src="images/note_wayra.png" title="Notas para Wayra"></a></div>

<!-- Modal -->
<div id="startupchile" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Notes for Startup Chile Board Members</h3>
  </div>
  <div class="modal-body">
    <p> Hi and welcome to Personaling, your Digital Personal Shopper.</p>
    <p> Here are some resources you may find useful in order to test our Web Application: </p>
    <ul class="no_bullets">
      <li>Regular User credentials:
        <ul>
          <li><strong>User</strong>: cm@upsidecorp.ch </li>
          <li><strong>Password</strong>: 1234<br/>
            <br/>
          </li>
        </ul>
      </li>
      <li> Personal Shopper User credentials:
        <ul>
          <li><strong>User</strong>: u@upsidecorp.ch</li>
          <li><strong>Password</strong>: 1234<br/>
            <br/>
          </li>
        </ul>
      </li>
      <li><a href="docs/Personaling_features.pdf">Features in this realease (Test v.9) (PDF)</a> <br/>
        <br/>
      </li>
      <li><a href="http://personaling.com/test9/user/login" title="Login page" class="btn btn-danger">Login Page</a></li>
    </ul>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
<div id="wayra" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Notas para el Jurado de Wayra 2013</h3>
  </div>
  <div class="modal-body">
    <p> Hola y Bienvenidos a Personaling, tu Personal Shopper Digital..</p>
    <p> A continuación un par de recursos útiles para probar nuestra web: </p>
    <ul class="no_bullets">
      <li>Credenciales de un Usuario regular:
        <ul>
          <li><strong>Usuario</strong>: cm@upsidecorp.ch </li>
          <li><strong>Password</strong>: 1234<br/>
            <br/>
          </li>
        </ul>
      </li>
      <li>Credenciales de un Personal Shopper:
        <ul>
          <li><strong>Usuario</strong>: u@upsidecorp.ch</li>
          <li><strong>Password</strong>: 1234<br/>
            <br/>
          </li>
        </ul>
      </li>
      <li>Links útiles:
        <ul>
          <li><a href="docs/Personaling_features.pdf">Funcionalidades en este versión (Test v.15) (PDF)</a></li>
          <li><a href="http://www.youtube.com/watch?v=xNj80lfwpEs" target="_blank" title="Video Personaling">Video explicativo</a></li>
          <li><a href="http://prezi.com/aw80fg4hohva/presentacion-e-show-2013-esade-personalingcom/?auth_key=c9f14f42a3a3ac0d5af176070333aa77f2c4d1e5" target="_blank" title="Presentacion de personaling">Presentación del negocio (PREZI)</a><br />
            <br/>
          </li>
        </ul>
      </li>
      <li><a href="http://personaling.com/test15/user/login" title="Login page" class="btn btn-danger">Página para iniciar sesión</a></li>
    </ul>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
</div>
<div class="bg_color3 braker_top padding_top ">
  <div class="container">
    <div class="row">
      <div class="pull-right"> 
        <!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style  "> <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a> <a class="addthis_counter addthis_pill_style"></a> </div>
        <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script> 
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=juanrules"></script> 
        <!-- AddThis Button END --> 
        
      </div>
      <div class="pull-right text_align_right padding_right_small"> <span class="color1"> Compártenos en tus redes sociales!</span> </div>
    </div>
  </div>
</div><?php */?>

<!-- Modal ON -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Video Promocional de Personaling.com</h3>
  </div>
  <div class="modal-body">
    <iframe width="100%" height="400" src="//www.youtube.com/embed/oAKyeeTng1U" frameborder="0" allowfullscreen></iframe>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
</div>
<!-- Modal OFF --> 

<script type="text/javascript">
$('.carousel').carousel({
  interval: 5000
})
</script>