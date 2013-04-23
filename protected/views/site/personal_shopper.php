<?php
/* @var $this TiendaController */
//
//$this->breadcrumbs=array(
//	'Tu Personal Shopper',
//);
?>
<div class=" margin_top">
  <div class="row margin_bottom_large">
    <div class="">
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
         <a class="carousel-control left margin_top_small" href="#myCarousel" data-slide="prev">&lsaquo;</a> <a class="carousel-control right margin_top_small" href="#myCarousel" data-slide="next">&rsaquo;</a> 
      </div>
     </div>
    
  </div>
   <hr/>



</div>