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
                            <div class="span4">
                                <article class="item" >
                                    <?php $image = CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id)), "Look", array("width" => "370", "height" => "400", 'class'=>'')); ?>
                                    <?php echo CHtml::link($image,array('look/view', 'id'=>$look->id)); ?>
                                    <div class="hidden-phone margin_top_small vcard row-fluid">
                                        <div class="span2 avatar "><img src="../images/avatar_sample1.jpg" class="photo  img-circle" width="40"></div>
                                        <div class="span5"> <span class="muted">Look creado por: </span>
                                            <h5><a class="url" title="profile" href="#"><span class="fn">
                                                <?php //echo $look->title; ?>
                                                <?php echo $look->user->profile->first_name; ?> </span></a></h5>
                                        </div>
                                        <div class="span5"><span class="precio">Bs. 10.000</span></div>
                                    </div>
                                    <div class="share_like">
                                        <button href="#" title="Me encanta" class="btn-link"><span class="entypo icon_personaling_big">&#9825;</span></button>
                                        <div class="btn-group">
                                            <button class="dropdown-toggle btn-link" data-toggle="dropdown"><span class="entypo icon_personaling_big">&#59157;</span></button>
                                            <ul class="dropdown-menu addthis_toolbox addthis_default_style ">
                                                <!-- AddThis Button BEGIN -->
                                                
                                                <li><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> </li>
                                                <li><a class="addthis_button_tweet"></a></li>
                                                <li><a class="addthis_button_pinterest_pinit"></a></li>
                                            </ul>
                                            <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script> 
                                            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=juanrules"></script> 
                                            <!-- AddThis Button END --> 
                                            
                                        </div>
                                    </div>
                                    <span class="label label-important">Promoción</span> </article>
                            </div>
                            <?php } ?>
                            <?php	?>
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
                                </div>
                            </div>
                            <?php } ?>
                         
                        </div>
                    </div>
                </div>
            </div>
            <div class="braker_horz_top_1">
                <div class="row">
                    <div class="span6">
                        <div  class="banner_1"> Aqui va un Banner </div>
                    </div>
                    <div class="span6">
                        <div  class="banner_1"> <a href="#"> Ver todos los looks</a>
                            <div class="pull-right"><a href="#"> <span class="entypo icon_personaling_big color11">&#59146;</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel nav --> 
        <a class="carousel-control left margin_top_small bx-prev" href="#myCarousel" data-slide="prev">&lsaquo;</a> <a class="carousel-control right margin_top_small bx-next" href="#myCarousel" data-slide="next">&rsaquo;</a> </div>
</div>
</div>
<hr/>
</div>
