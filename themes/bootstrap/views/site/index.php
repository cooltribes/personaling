<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
</div>
</div>
<!-- /Hack para el layout del home  -->

<style>

.note_startupchile{
	position: absolute;
	top:5em;
	left:0;
	display:none;}

</style>

<div class="wrapper_home">
  <div class="container">
    <div class="row">
      <div class="span3 text_align_right margin_top">
        <div class="padding_bottom_small braker_bottom margin_bottom_small">
          <h1>Bienvenid@s</h1>
          <p>Personaling, es un personal shopper digital, un portal de moda y belleza en donde las usuarias se dan de alta, definen su perfil físico y sus preferencias de estilo para descubrir looks recomendados por expert@s en moda (personal shoppers, celebrities, estilistas, fashionistas), podrán comprar el look completo en un click y recibirlo en su domicilio</p>
        </div>
        <p class="CAPS"> Siguenos en:</p>
        <div class="clearfix"> <a href="https://www.facebook.com/Personaling" title="Personaling en facebook"><img width="40" height="40" src="images/icon_facebook.png" title="personaling en pinterest"></a> <a href="https://twitter.com/personaling" title="Personaling en Pinterest"> <img width="40" height="40" src="images/icon_twitter.png" title="personaling en pinterest"></a> <a href="https://pinterest.com/personaling/" title="pinterest"><img width="40" height="40" src="images/icon_pinterest.png" title="Personaling en Pinterest"></a> <a href="http://instagram.com/personaling" title="Personaling en Instagram"><img width="40" height="40" src="images/icon_instagram.png" title="Personaling en Pinterest"></a> </div>
      </div>
      <div class="span7 offset2">
        <div id="myCarousel" class="carousel slide">
          <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
          </ol>
          <!-- Carousel items -->
          <div class="carousel-inner">
            <div class="active item">
              <iframe width="670" height="390" src="http://www.youtube.com/embed/xNj80lfwpEs" frameborder="0" allowfullscreen></iframe>
            </div>
            <div class="item"><img src="http://placehold.it/670x390"/></div>
            <div class="item"><img src="http://placehold.it/670x390"/></div>
          </div>
          <!-- Carousel nav --> 
          <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a> <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a> </div>
      </div>
    </div>
  </div>
</div>
<div class="note_startupchile"> <a href="#startupchile" role="button" data-toggle="modal"><img src="images/note_startupchile.png" title="Startup Chile"></a></div>

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
          <li><strong>Password</strong>: 1234<br/> <br/></li>
        
        </ul>
      </li>
      <li> Personal Shopper User credentials:
        <ul>
          <li><strong>User</strong>: u@upsidecorp.ch</li>
          <li><strong>Password</strong>: 1234<br/> <br/></li>
        </ul>
        
      </li>
            <li><a href="docs/Personaling_features.pdf">Features in this realease (Test v.9) (PDF)</a> <br/> <br/></li>

            <li><a href="http://personaling.com/test9/user/login" title="Login page" class="btn btn-danger">Login Page</a></li>

    </ul>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
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
