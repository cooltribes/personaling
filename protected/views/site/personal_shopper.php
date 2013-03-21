<?php
/* @var $this TiendaController */

$this->breadcrumbs=array(
	'Tu Personal Shopper',
);
?>
<div class="container margin_top">
  <div class="row margin_bottom_large">
    <div class="span12">
      <h1>Looks recomendados para ti</h1>
      
      <!-- Carousel items -->
      <div id="myCarousel" class="carousel slide margin_top ">
        <div class="carousel-inner">

  <?php          	
            	
		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_view_look',


		'pager'=>array(
			'header'=>'',
			'htmlOptions'=>array(
			'class'=>'pagination pagination-right',
		)
		),					
	));     
	?>   
	        <!--
	          <div class="active item">
            <div class="row">     	
              <article class="span4"> <a href="Look_seleccionado.php" title="look"><img src="http://placehold.it/370x400"/></a>
                <div class="margin_top_small"><img class="pull-right" src="http://placehold.it/50x50"/>
                  <p class="pull-right margin_top_small margin_right_small"> Recomendado por </p>
                </div>
              </article>
              <article class="span4"> <a href="Look_seleccionado.php" title="look"><img src="http://placehold.it/370x400"/></a>
                <div class="margin_top_small"><img class="pull-right" src="http://placehold.it/50x50"/>
                  <p class="pull-right margin_top_small margin_right_small"> Recomendado por </p>
                </div>
              </article>
              <article class="span4"> <a href="Look_seleccionado.php" title="look"><img src="http://placehold.it/370x400"/></a>
                <div class="margin_top_small"><img class="pull-right" src="http://placehold.it/50x50"/>
                  <p class="pull-right margin_top_small margin_right_small"> Recomendado por </p>
                </div>
              </article>
            </div>
          </div>
          <div class="item">
            <div class="row">
              <article class="span4"> <a href="Look_seleccionado.php" title="look"><img src="http://placehold.it/370x400"/></a>
                <div class="margin_top_small"><img class="pull-right" src="http://placehold.it/50x50"/>
                  <p class="pull-right margin_top_small margin_right_small"> Recomendado por </p>
                </div>
              </article>
              <article class="span4"> <a href="Look_seleccionado.php" title="look"><img src="http://placehold.it/370x400"/></a>
                <div class="margin_top_small"><img class="pull-right" src="http://placehold.it/50x50"/>
                  <p class="pull-right margin_top_small margin_right_small"> Recomendado por </p>
                </div>
              </article>
              <article class="span4"> <a href="Look_seleccionado.php" title="look"><img src="http://placehold.it/370x400"/></a>
                <div class="margin_top_small"><img class="pull-right" src="http://placehold.it/50x50"/>
                  <p class="pull-right margin_top_small margin_right_small"> Recomendado por </p>
                </div>
              </article>
            </div>
          </div>
          <div class="item">
            <div class="row">
              <article class="span4"> <a href="Look_seleccionado.php" title="look"><img src="http://placehold.it/370x400"/></a>
                <div class="margin_top_small"><img class="pull-right" src="http://placehold.it/50x50"/>
                  <p class="pull-right margin_top_small margin_right_small"> Recomendado por </p>
                </div>
              </article>
              <article class="span4"> <a href="Look_seleccionado.php" title="look"><img src="http://placehold.it/370x400"/></a>
                <div class="margin_top_small"><img class="pull-right" src="http://placehold.it/50x50"/>
                  <p class="pull-right margin_top_small margin_right_small"> Recomendado por </p>
                </div>
              </article>
              <article class="span4"> <a href="Look_seleccionado.php" title="look"><img src="http://placehold.it/370x400"/></a>
                <div class="margin_top_small"><img class="pull-right" src="http://placehold.it/50x50"/>
                  <p class="pull-right margin_top_small margin_right_small"> Recomendado por </p>
                </div>
              </article>
            </div>
          </div>
         -->
        </div>
        <!-- Carousel nav --> 
      </div>
      <a class="carousel-control left margin_top_small" href="#myCarousel" data-slide="prev">&lsaquo;</a> <a class="carousel-control right margin_top_small" href="#myCarousel" data-slide="next">&rsaquo;</a> </div>
    
  </div>
   <hr/>
<aside class="row margin_top_large">
  <div class="span4">
    <h3>Como funciona</h3>
  </div>
  <div class="span4">
    <h3>Todos los Looks</h3>
  </div>
  <div class="span4">
    <h3>Compartelo con tus Amig@s y gana puntos para tus proximas compras</h3>
  </div>
</aside>


</div>