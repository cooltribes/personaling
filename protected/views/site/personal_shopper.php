<?php
/* @var $this TiendaController */
//
//$this->breadcrumbs=array(
//	'Tu Personal Shopper',
//);
?>
<?php  
  $baseUrl = Yii::app()->baseUrl; 
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile($baseUrl.'/js/slider.js');
  //$cs->registerCssFile($baseUrl.'/css/yourcss.css');
?>
<div class=" margin_top">
  <div class="row margin_bottom_large">
    <div class="">
      <h1>Looks recomendados para ti</h1>
      
      <!-- Carousel items -->
      <div id="carousel_looks_recomendados" class="carousel slide margin_top ">
        <div class="carousel-inner">

  <?php          	
        /*    	
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
	));    */
	?>

<div id="list-auth-items" class="list-view">
<div id="b" class="items">
<?php
 foreach($dataProvider->getData() as $record) {
 ?>
 <?php	
	$look = Look::model()->findByPk($record['id']);
	if($look->matchOcaciones(User::model()->findByPk(Yii::app()->user->id))){
?>
              <div class="item">
            <div class="row"> 
              <article class="span4"> 
              	<?php $image = CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id)), "Look", array("width" => "370", "height" => "400", 'class'=>'img_1')); ?>
              	<?php echo CHtml::link($image,array('look/view', 'id'=>$look->id)); ?>
              	<!--
              	<a href="Look_seleccionado.php" title="look"> 
              	<img src="http://placehold.it/370x400"/>
              	
              </a>
              -->
                <div class="margin_top_small"><!-- <img class="pull-right" src="http://placehold.it/50x50"/> -->
                  <p class="pull-right margin_top_small margin_right_small"><?php echo $look->title; ?> Recomendado por: <?php echo $look->user->profile->first_name; ?></p>
                </div>
              </article>
            </div></div>
<?php } ?>
<?php	
}
	?>  
	</div></div>	 
        </div>
        <!-- Carousel nav --> 
         <a class="carousel-control left margin_top_small bx-prev" href="#myCarousel" data-slide="prev">&lsaquo;</a> 
         <a class="carousel-control right margin_top_small bx-next" href="#myCarousel" data-slide="next">&rsaquo;</a> 
      </div>
     </div>
    
  </div>
   <hr/>



</div>