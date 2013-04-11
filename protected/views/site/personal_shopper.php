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
      <div id="carousel_looks_recomendados" class="carousel slide margin_top ">
        <div class="carousel-inner">

  <?php          	
            	
		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_view_look', 
'template'=>"{items}",

		'pager'=>array(
			'header'=>'',
			'htmlOptions'=>array( 
			'class'=>'pagination pagination-right',
		)
		),					
	));     
	?>   
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