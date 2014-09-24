<?php 
if(!Yii::app()->user->isGuest){
	$this->breadcrumbs=array(
	    'Top',
	);
}
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
	
	if(!isset($seo))
		$this->pageTitle=Yii::app()->name . ' - Lo más Top';  
	
	
	$baseUrl = Yii::app()->baseUrl; 
  //$cs = Yii::app()->getClientScript();
  //$cs->registerScriptFile($baseUrl.'/js/slider.js');
  //$cs->registerCssFile($baseUrl.'/css/yourcss.css');
?>
<div class="container margin_top">
    <div class="row margin_bottom">
        <div class="span12" >

<h2 class="text_align_center"><?php echo Yii::t('contentForm','Outstanding Looks'); ?></h2>
                     <div class="margin_top" >
                        <div class="items row " id="perfil_looks">
<?php
	//foreach($dataProvider_destacados->getData() as $record) {
	//$look = Look::model()->findByPk($record['look_id']);
        $pagination = $dataProvider_destacados->pagination->pageSize;
        //
	$iterator = new CDataProviderIterator($dataProvider_destacados);
        $count = 0;
	foreach($iterator as $look) {
		if (isset($look)){
			if($look->activo=="1" && $look->status=="2" && $look->available=="1") // show all the looks availables and previous send it and active
			{
                    $count++;
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
                                    <div class="span4"> <span class="muted"><?php echo Yii::t('contentForm','Look created by'); ?>: </span>
                                        <h5><?php echo CHtml::link('<span class="fn">'.$look->user->profile->getNombre().'</span>',$look->user->profile->getUrl()); ?></h5>
                                    </div>
                                    <div class="span6"><span class="precio"><small><?php echo Yii::t('contentForm', 'currSym').' ';?></small> <?php echo $look->getPrecio(); ?></span></div>
                                </div>
                                <div class="share_like">
                                    <button href="#" title="Me encanta" onclick="encantar(<?php echo $look->id;?>)" class="btn-link">
                                 
                                    	<span id="like<?php echo $look->id; ?>" class="entypo icon_personaling_big"><?php echo $look->meEncanta()?"♥":"♡"; ?></span>	
                                    </button>
                                    	
										
                                </div>
                                <span class="label label-important">><?php echo Yii::t('contentForm','Promotion'); ?></span> </article>
                        </div>
<?php 
                        if ($count >= 6 )
                             break;
	}
	}
} ?>
                </div>
            </div>
            
            
        </div>
    </div>
    <div class=" margin_bottom_large braker_horz_top_less_space personal_shoppers_list">
        <h2 class="margin_bottom text_align_center"><?php echo Yii::t('contentForm','Personal Shoppers outstanding'); ?></h2>
        <ul class="thumbnails ">
            <?php if(count($psDestacados)){ ?>
                <?php foreach($psDestacados as $ps){ ?>
                    <li class="span3 personal_shoppers_li">
                        <a  href="<?php echo $ps->profile->getUrl(); ?>"> 
                            <img alt="<?php echo $ps->profile->first_name . " " . $ps->profile->last_name; ?>" class="img-circle"   src="<?php echo $ps->getAvatar(); ?>" width="250"> 
                        </a>
                        <h3>
                            <a href="<?php echo $ps->profile->getUrl(); ?>" title="<?php echo $ps->profile->first_name . " " . $ps->profile->last_name; ?>">
                                <?php echo $ps->profile->first_name . " " . $ps->profile->last_name; ?>
                            </a>
                        </h3>
                        <p><?php echo $ps->profile->bio; ?></p>
                    </li>            
                <?php } ?>                        
            <?php } ?>
            
            
<!--            Elise:Emprendedora de nacimiento,  CEO y Fundadora de Personaling.com. Amante del buen gusto y la moda. Siempre he pensado que tu mejor look es una buena actitud.
<li class="span3 personal_shoppers_li"> <a  href="#"><img alt="Nombre del personal shopper foto" class="img-circle"   src="../images/rosa.jpg" width="250"> </a>
                <h3><a href="#" title="Nombre del Personal Shopper">Rosa Virginia</a></h3>
                <p>Modelo, Abogada, amante de la moda y adicta al shopping. Se lo que te favorece, porque se de moda real. RRPP de Personaling.com</p>
            </li>
            <li class="span3 personal_shoppers_li"> <a  href="#"> <img alt="Nombre del personal shopper foto" class="img-circle"   src="../images/elise.jpg" width="250"> </a>
                <h3><a href="#" title="Nombre del Personal Shopper">Elise Vigouroux</a></h3>
                <p>Una gran parte de mi vida me la paso escribiendo, otra parte leyendo, la otra trabajando para la moda y la que queda paseando a mi pug. Directora de Contenido de Personaling.com </p>
            </li>
            <li class="span3 personal_shoppers_li"> <a  href="#"><img alt="Nombre del personal shopper foto" class="img-circle"   src="../images/Ariana.jpg" width="250"> </a>
                <h3><a href="#" title="Nombre del Personal Shopper">Ariana Basciani</a></h3>
                <p>Creo que el buen gusto está íntimamente relacionado con el sentido común y el estado de ánimo. Soy parte del equipo de contenidos y marketing on line de Personaling.com y, mientras no estoy trabajando, me encanta leer libros para cosechar el intelecto. </p>
            </li>-->
        </ul>
        <?php   
            $pagination = $dataProvider_productos->pagination->pageSize;
            $iterator = new CDataProviderIterator($dataProvider_productos);
            $count = 0;
            //echo "count: ".$iterator->getTotalItemCount();
            if($iterator->getTotalItemCount()){
        ?>
        <div class=" margin_bottom_large braker_horz_top_1">
            <div class="row">
                <div class="span12">
                	<?php
                	//	var_dump(Yii::app()->params['metodosPago']);
                	?>
                    <h3 class="margin_bottom_small text_align_center"><?php echo Yii::t('contentForm','Best selling items'); ?></h3>
                    <div class="thumbnails">
                            <?php
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
            <?php } ?>
    </div>
    <div class=" margin_bottom_large braker_horz_top_1 ">
       <!-- <h3 class="margin_bottom_small"><?php echo Yii::t('contentForm','From Our Magazine'); ?></h3>-->
        <div class="row posts_list">
            <div class="span12">
                <div class="thumbnails" align="center">
                	<a href="http://www.personaling.com/magazine"><?php  echo CHtml::image(Yii::app()->getBaseUrl()."/images/magazine_banner.gif", "Imagen", array()); ?></a>
               <!-- 	
                	
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
                          
                        </div>
                    </li>
                    <?php 
		}
		if ($count >= 4) 
			break;
	}
?> -->
                </div>
            </div>
        </div>
    </div>
    <div class="braker_horz_top_1">
        <div class="row">
            <div class="offset3 span6">
                <div  class="">
                	 <a class="btn btn-danger btn-block btn-large color3" href="<?php echo Yii::app()->getBaseUrl(); ?>/tienda/look" ><?php echo Yii::t('contentForm','See all looks'); ?> </a>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /container --> 
<script>
	
	function encantar(idLook)
    {
        //var idLook = $("#idLook").attr("value");
        //alert("id:"+idLook);

        $.ajax({
            type: "post",
            dataType: 'json',
            url: "<?php echo $this->createUrl("look/encantar"); ?>", // action Tallas de look
            data: {'idLook': idLook},
            success: function(data) {

                if (data.mensaje == "ok")
                {
                    var a = "♥";

                    //$("#meEncanta").removeClass("btn-link");
                    $("#meEncanta" + idLook).addClass("btn-link-active");
                    $("span#like" + idLook).text(a);

                }

                if (data.mensaje == "no")
                {
                    alert("Debe primero ingresar como usuario");
                    //window.location="../../user/login";
                }

                if (data.mensaje == "borrado")
                {
                    var a = "♡";

                    //alert("borrando");

                    $("#meEncanta" + idLook).removeClass("btn-link-active");
                    $("span#like" + idLook).text(a);

                }

            }//success
        })

    }
	
	
</script>