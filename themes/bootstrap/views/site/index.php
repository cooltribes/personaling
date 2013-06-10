<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
</div>
</div>
<!-- /Hack para el layout del home  -->
<style>
.note_startupchile {
	position: absolute;
	top:5em;
	left:0;
}
</style>

<div class="wrapper_home">
  <div class="container">
    <div class="row">
      <div class="span11 text_align_center margin_top">
        <div class="box_home  margin_bottom_small">
          <h1>¡Bienvenid@s!</h1>
          <p>Recomendaciones personalizadas adaptadas a ti. Una nueva manera de renovar tu clóset. </p>
          <a href="<?php echo Yii::app()->getBaseUrl(); ?>/user/registration" title="Registrate" class="btn btn-danger margin_top_small btn-large">¡Regístrate YA!</a> </div>
        <div class="box_home_2 hidden-phone"> ¡Tu <span>Personal <br/>
          Shopper</span> Digital! </div>
        <div class="box_home_3 hidden-phone"> Registro <br/>
          <span>¡Gratis!</span></div>
        <div class="box_home_4 hidden-phone"> <a  href="#myModal" role="button" data-toggle="modal"><strong>Video</strong> explicativo</a></div>
      </div>
    </div>
  </div>
</div>
<div class="note_startupchile"> <a href="#wayra" role="button" data-toggle="modal"><img src="images/note_wayra.png" title="Notas para Wayra"></a></div>

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
</div>

<!-- Modal ON -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Video Explicativo sobre personaling.com</h3>
  </div>
  <div class="modal-body">
    <iframe width="100%" height="400" src="http://www.youtube.com/embed/xNj80lfwpEs" frameborder="0" allowfullscreen></iframe>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
</div>
<!-- Modal OFF --> 
