<?php
$this->breadcrumbs=array(
    'Top',
);
function str_lreplace($search, $replace, $subject)
{
    $pos = strrpos($subject, $search);

    if($pos !== false)
    {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }

    return $subject;
}
?>
<?php  
	$this->pageTitle=Yii::app()->name . ' - Lo más Top';  
	$baseUrl = Yii::app()->baseUrl; 
  //$cs = Yii::app()->getClientScript();
  //$cs->registerScriptFile($baseUrl.'/js/slider.js');
  //$cs->registerCssFile($baseUrl.'/css/yourcss.css');
?>

<div class="container margin_top">
    <div class="row margin_bottom_large">
        <div class="span12" id="lo_mas_top">
            <div class="tabbable"> <!-- Only required for left/right tabs -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">Looks más vendidos</a></li>
<!--                     <li><a href="#tab2" data-toggle="tab">Próxima Campaña</a></li>
 -->                    <li><a href="#tab3" data-toggle="tab">Looks en promoción</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1" >
                        <div class="items row ">
<?php
 foreach($dataProvider->getData() as $record) {
 	$look = Look::model()->findByPk($record['look_id']);
	if (isset($look)){
 ?>
                        <div class="span4">
                            <article class="item" >
                            	<?php echo CHtml::image('../images/loading.gif','Loading',array('id'=>"imgloading".$look->id)); ?>
                            	
                                <?php $image = CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id)), "Look", array("style"=>"display: none","id" => "imglook".$look->id,"width" => "370", "height" => "400", 'class'=>'')); ?>
                                <?php
                                //"style"=>"display: none",              	
                                    /*
                                    $script = "$('#"."imglook".$look->id."').load(function(){
  												//alert('cargo');
  												$('#imgloading".$look->id."').hide();
  												$(this).show();
  												//$('#loader_img').hide();
									});";
									 * 
									 */
									 $script = "
										var load_handler = function() {
										    $('#imgloading".$look->id."').hide();
										    $(this).show();
										}
										$('#"."imglook".$look->id."').filter(function() {
										    return this.complete;
										}).each(load_handler).end().load(load_handler);						 
									 ";									 
              						Yii::app()->clientScript->registerScript('img_script'.$look->id,$script);
              					?>   
                                <?php echo CHtml::link($image,$look->getUrl()); ?>
                                <div class="hidden-phone margin_top_small vcard row-fluid">
                                    <div class="span2 avatar ">
	                                    	<a href="<?php echo $look->user->profile->getUrl(); ?>">
	                                    	<?php echo CHtml::image($look->user->getAvatar(),'Avatar',array("width"=>"40", "class"=>"photo img-circle")); //,"height"=>"270" ?>
	                                    	</a>
	                                   </div> 
                                    <div class="span4"> <span class="muted">Look creado por: </span>
                                        <h5>
                                        	<?php echo CHtml::link('<span class="fn">'.$look->user->profile->getNombre().'</span>',$look->user->profile->getUrl()); ?>
                                        </h5>
                                    </div>
                                    <div class="span6"><span class="precio"><small>Bs.</small> <?php echo $look->getPrecio(); ?></span></div>
                                </div>
                                <div class="share_like">
                                    <button href="#" title="Me encanta" class="btn-link"><span class="entypo icon_personaling_big">&#9825;</span></button>
                                    
                                    <div class="btn-group">
                                        <button class="dropdown-toggle btn-link" data-toggle="dropdown"><span class="entypo icon_personaling_big">&#59157;</span></button>
                                        <ul class="dropdown-menu addthis_toolbox addthis_default_style ">
                                            <!-- AddThis Button BEGIN 
                                            
                                            <li><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> </li>
                                            <li><a class="addthis_button_tweet"></a></li>
                                            <li><a class="addthis_button_pinterest_pinit"></a></li>
                                        </ul>
                                        <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script> 
                                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=juanrules"></script> 
                                             AddThis Button END --> 
                                        
                                    </div>
                                </div>
                                <span class="label label-important">Promoción</span> </article>
                        </div>
                        <?php 
              }
} 
?>
                    </div>
                    </div>
<!--                     <div class="tab-pane" id="tab2">
                        <p>Howdy, I'm in Section 2.</p>
                    </div> -->
                     <div class="tab-pane" id="tab3">
                        <div class="items row ">
<?php
	//foreach($dataProvider_destacados->getData() as $record) {
	//$look = Look::model()->findByPk($record['look_id']);
	$iterator = new CDataProviderIterator($dataProvider_destacados);
	foreach($iterator as $look) {
		if (isset($look)){
?>
                        <div class="span4">
                            <article class="item" >
                            	<?php echo CHtml::image('../images/loading.gif','Loading',array('id'=>"d_imgloading".$look->id)); ?>
                            	
                                <?php $image = CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id)), "Look", array("style"=>"display: none","id" => "d_imglook".$look->id,"width" => "370", "height" => "400", 'class'=>'')); ?>
                                <?php
                                //"style"=>"display: none",              	

									 $script = "
										var load_handler = function() {
										    $('#d_imgloading".$look->id."').hide();
										    $(this).show();
										}
										$('#"."d_imglook".$look->id."').filter(function() {
										    return this.complete;
										}).each(load_handler).end().load(load_handler);						 
									 ";									
              						Yii::app()->clientScript->registerScript('d_img_script'.$look->id,$script);
              					?>   
                                <?php echo CHtml::link($image,$look->getUrl()); ?>
                                <div class="hidden-phone margin_top_small vcard row-fluid">
                                    <div class="span2 avatar "> <?php echo CHtml::image($look->user->getAvatar(),'Avatar',array("width"=>"40", "class"=>"photo img-circle")); //,"height"=>"270" ?> </div>
                                    <div class="span5"> <span class="muted">Look creado por: </span>
                                        <h5><?php echo CHtml::link('<span class="fn">'.$look->user->profile->getNombre().'</span>',$look->user->profile->getUrl()); ?></h5>
                                    </div>
                                    <div class="span5"><span class="precio"><small>Bs.</small> <?php echo $look->getPrecio(); ?></span></div>
                                </div>
                                <div class="share_like">
                                    <button href="#" title="Me encanta" class="btn-link"><span class="entypo icon_personaling_big">&#9825;</span></button>
                                    
                                    <div class="btn-group">
                                        <button class="dropdown-toggle btn-link" data-toggle="dropdown"><span class="entypo icon_personaling_big">&#59157;</span></button>
                                        <ul class="dropdown-menu addthis_toolbox addthis_default_style ">
                                            <!-- AddThis Button BEGIN 
                                            
                                            <li><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> </li>
                                            <li><a class="addthis_button_tweet"></a></li>
                                            <li><a class="addthis_button_pinterest_pinit"></a></li>
                                        </ul>
                                        <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script> 
                                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=juanrules"></script> 
                                             AddThis Button END --> 
                                        
                                    </div>
                                </div>
                                <span class="label label-important">Promoción</span> </article>
                        </div>
<?php 
	}
} ?>
                    </div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
    <div class=" margin_bottom_large braker_horz_top_1 personal_shoppers_list">
        <h2 class="margin_bottom">Personal shoppers destacados</h2>
        <ul class="thumbnails ">
            <li class="span3"> <a  href="#"> <img alt="Nombre del personal shopper foto" class="img-circle"   src="../images/heidi.jpg" width="250"> </a>
                <h3><a href="#" title="Nombre del Personal Shopper">Heidi García</a></h3>
                <p>Emprendedora de nacimiento,  CEO y Fundadora de Personaling.com. Amante del buen gusto y la moda. Siempre he pensado que tu mejor look es una buena actitud. </p>
            </li>
            <li class="span3"> <a  href="#"><img alt="Nombre del personal shopper foto" class="img-circle"   src="../images/rosa.jpg" width="250"> </a>
                <h3><a href="#" title="Nombre del Personal Shopper">Rosa Virginia</a></h3>
                <p>Modelo, Abogada, amante de la moda y adicta al shopping. Se lo que te favorece, porque se de moda real. RRPP de Personaling.com</p>
            </li>
            <li class="span3"> <a  href="#"> <img alt="Nombre del personal shopper foto" class="img-circle"   src="../images/elise.jpg" width="250"> </a>
                <h3><a href="#" title="Nombre del Personal Shopper">Elise Vigouroux</a></h3>
                <p>Una gran parte de mi vida me la paso escribiendo, otra parte leyendo, la otra trabajando para la moda y la que queda paseando a mi pug. Directora de Contenido de Personaling.com </p>
            </li>
            <li class="span3"> <a  href="#"><img alt="Nombre del personal shopper foto" class="img-circle"   src="../images/Ariana.jpg" width="250"> </a>
                <h3><a href="#" title="Nombre del Personal Shopper">Ariana Basciani</a></h3>
                <p>Soy parte del equipo de contenido de Personaling.com. Amante de la literatura. Voy cazando tendencias cada día. Mi trabajo es hacer del mundo un lugar con gente mejor vestida. </p>
            </li>
        </ul>
        <div class=" margin_bottom_large braker_horz_top_1 personal_shoppers_list">
            <div class="row">
                <div class="span12">
                    <h3 class="margin_bottom_small">Prendas más vendidas</h3>
                    <div class="thumbnails">

<?php   
$pagination = $dataProvider_productos->pagination->pageSize;
$iterator = new CDataProviderIterator($dataProvider_productos);
$count = 0;
foreach($iterator as $record) {
	$producto = Producto::model()->findByPk($record['producto_id']);
	if (isset($producto)){
		if($producto->getCantidad() > 0){
			$count++;
?>
                    <li class="span2"> 
                        <?php $image = CHtml::image($producto->getImageUrl(), "Imagen", array("width" => "180", "height" => "180"));	?>
                        <?php echo CHtml::link($image, $producto->getUrl() ); ?>  
                    </li>
<?php 			
			
			if ($count >= $pagination)
				break;	
		}
	}	
   
}
	
     ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" margin_bottom_large braker_horz_top_1 ">
        <h3 class="margin_bottom_small">Desde Nuestra Magazine</h3>
        <div class="row posts_list">
            <div class="span12">
                <div class="thumbnails">
                    <?php

$posts_parent = WpPosts::model()->findAllByAttributes(array('post_type'=>'post','post_status'=>'publish'),array('order'=>'post_date DESC'));
$count = 0;
foreach($posts_parent as $posts_parent){
	$posts_attachment = WpPosts::model()->findByAttributes(array('post_parent'=>$posts_parent->ID));
	if(isset($posts_attachment)){
		$count++;
			//echo 'a';
		?>
                    <li class="span3">
                        <div class="post">
                            <?php
              	$imagen_url = str_lreplace(".","-494x700.", $posts_attachment->guid);
				//$imagen_url = substr_replace(".","-494x700.", strrpos(".", $posts_attachment->guid), strlen($posts_attachment->guid));
              	$imghtml=CHtml::image($imagen_url, $posts_attachment->post_title,array("width" => "270", 'class'=>'show_modal_post'));
				echo CHtml::link($imghtml, $posts_parent->guid);
              	?>
                            <h3 > <?php echo CHtml::link($posts_parent->post_title, $posts_parent->guid,array('class'=>"show_modal_post" )); ?> </h3>
                            <!-- /.row --> 
                        </div>
                    </li>
                    <?php 
		}
		if ($count >= 4) 
			break;
	}
?>
                </div>
            </div>
        </div>
    </div>
    <div class="braker_horz_top_1">
        <div class="row">
            <div class="span6"> <img src="<?php echo Yii::app()->getBaseUrl(); ?>/images/banner_blanco.jpg" width="571" height="75" alt="Banner blanco" /> </div>
            <div class="span6">
                <div  class="">
                	 <a class="btn btn-danger btn-block btn-morado-tiffany color3" href="<?php echo Yii::app()->getBaseUrl(); ?>/tienda/look" >Ver todos los looks <i class="icon-chevron-right icon-white"></i> </a>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /container --> 