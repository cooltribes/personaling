<!DOCTYPE html>

 <?php
  /* @var $this TiendaController */
  $this->breadcrumbs=array(
  'Tienda'=>array('/tienda/index'),
  'Producto',
  );
?>  
 <!-- FLASH ON --> 
<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )
); ?>

<?php  
 $baseUrl = Yii::app()->baseUrl;
 $cs = Yii::app()->getClientScript();
 $cs->registerScriptFile($baseUrl.'/js/jquery.zoom.js');
  Yii::app()->clientScript->registerMetaTag($producto->descripcion, null, null, array('property' => 'og:description'), null);
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
  Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 

  //Metas de Twitter CARD ON

  Yii::app()->clientScript->registerMetaTag('product', 'twitter:card', null, null, null);
  Yii::app()->clientScript->registerMetaTag('@personaling', 'twitter:site', null, null, null);
  Yii::app()->clientScript->registerMetaTag($producto->nombre, 'twitter:title', null, null, null);
  Yii::app()->clientScript->registerMetaTag($producto->descripcion, 'twitter:description', null, null, null);
  Yii::app()->clientScript->registerMetaTag('Marca', 'twitter:label2', null, null, null);
  Yii::app()->clientScript->registerMetaTag('personaling.com', 'twitter:domain', null, null, null);

  //Metas de Twitter CARD OFF




?>
<!-- FLASH OFF -->







<div class="container margin_top" id="carrito_compras">
  <div class="row detalle_producto">
    <div class="span12">
      <div class="row"> 
        <!-- Columna principal ON -->
        <article class="span8">
          <div class="row">
            <div class="span6">
              <input id="producto" type="hidden" value="<?php echo $producto->id ?>" />
              <h1> <?php echo $producto->nombre; ?> <!-- <span class="label label-important"> ON SALE</span> --> <?php //echo $producto->getUrl(); ?> </h1>
            </div>
            <div class="span2 share_like hidden-phone">
              
              <?php
              $entro = 0;
        
        $like = UserEncantan::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'producto_id'=>$producto->id));
              
              if(isset($like)) // le ha dado like
        {
          //echo "p:".$like->producto_id." us:".$like->user_id;
          $entro=1;
          ?>
            <button id="meEncanta" onclick='encantar()' title="Me encanta" class="btn-link btn-link-active">
                   <span id="like" class="entypo icon_personaling_big">&hearts;</span>
            </button>
                  <?php 
          
        }
          
          if($entro==0)
          {
             echo "<button id='meEncanta' onclick='encantar()' title='Me encanta' class='btn-link'>
                 <span id='like' class='entypo icon_personaling_big'>&#9825;</span>
                 </button>";
          }

                ?>
                
<!--                 <div class="btn-group hidden-phone">
                  <button class="dropdown-toggle btn-mini btn-success" data-toggle="dropdown"><span class="">&#59157; Compartir</span></button>
                  <ul class="dropdown-menu addthis_toolbox addthis_default_style ">
                    
                    <li><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> </li>
                    <li><a class="addthis_button_tweet"></a></li>
                    <li><a class="addthis_button_pinterest_pinit"></a></li>
                  </ul>
                  <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script> 
                  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=juanrules"></script> 
                  
                </div> -->
            </div>
          </div>
          <div class="row">
              
            <?php
              $iconoDescuento = '<div class="icono-descuento">10%<span>Descuento</span></div>';
              $colorPredet="";
              
              echo "<div class='span6' style=' position: relative; '>{$iconoDescuento}<div class='imagen_principal'> 
                  <!-- FOTO principal ON -->";
              
              $ima = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$producto->id),array('order'=>'orden ASC'));
  
      foreach ($ima as $img){

        Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.$img->getUrl(array('ext'=>'jpg')), null, null, array('property' => 'og:image'), null);  // Registro de <meta> para compartir en Facebook
        Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.$img->getUrl(array('ext'=>'jpg')), 'twitter:image:src', null, null, null);  // Registro de <meta> para compartir en Twitter        
        if($img->orden==1)
        { 
          $colorPredet = $img->color_id;
          
          echo CHtml::image($img->getUrl(array('ext'=>'jpg')), "producto", array('id'=>'principal','rel'=>'image_src'));
          echo "<!-- FOTO principal OFF -->";
		  
		   if($producto->mymarca->is_100chic){
	
				echo "<div class='text_align_center btn-block is_100chic'> <span>100% CHIC</span> </div>";
				
		  }
		  
                echo "</div>";  
                echo "</div>";  
          
          echo " <div class='span2'> 
                    <!-- FOTOS Secundarias ON -->
                    <div class='imagenes_secundarias'> 
                    ";
        
          //imprimiendo igual la primera en thumbnail
          $pri = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'orden'=>'1'));
          echo CHtml::image( str_replace(".","_x90.",$img->getUrl()) , "Imagen ", array("width" => "90", "height" => "90",'id'=>'thumb'.$pri->id,'class'=>'miniaturas_listado_click','style'=>'cursor: pointer'));          
              
        }
        
        if($img->orden!=1){
          if($colorPredet == $img->color_id)
          {
            //luego el resto para completar el scroll         
            
            echo CHtml::image( str_replace(".","_x90.",$img->getUrl()), "Imagen", array("width" => "90", "height" => "90", 'id'=>'thumb'.$img->id, 'class'=>'miniaturas_listado_click','style'=>'cursor: pointer'));
            
          }// color
        }// que no es la primera en el orden
      }
      
     
      
      
      
      echo "</div></div>";
            
      /*
            <!-- FOTOS Secundarias OFF -->
       * */
      
         
          
          
          ?>
            
            
            
            
          </div>
          
        </article>
        <!-- Columna principal OFF --> 
        
        <!-- Columna Secundaria ON -->
        <div class="span4 columna_secundaria margin_bottom margin_top padding_top">
          <div class="row call2action">
            <div class="span2">
          
                <?php   
              /*foreach ($producto->precios as $precio) {
                if($precio->precioDescuento < $precio->precioImpuesto){
                  $porcentaje = 100 - (($precio->precioDescuento * 100) / $precio->precioImpuesto);
                  //$precio = "<span class='preciostrike strikethrough'>".Yii::t('contentForm', 'currSym')." ".$data->precio."</del></span> | ".Yii::t('contentForm', 'currSym')." ".$data->precioDescuento;
                  echo '<span class="preciostrike strikethrough">'.Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatDecimal($precio->precioImpuesto).'</span> | '.''.Yii::t('contentForm', 'currSym')." ".$precio->precioDescuento.' Con '.round($porcentaje).'% de descuento';
                }else{
                  echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatDecimal($precio->precioImpuesto).'';
                }
                  //$datos=$datos.'<h4 class="precio"><span>Subtotal</span> '.Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatDecimal($precio->precioImpuesto).'</h4>';
              }*/

              $precio_producto = Precio::model()->findByAttributes(array('tbl_producto_id'=>$producto->id));
              if($precio_producto){
                if(!is_null($precio_producto->tipoDescuento) && $precio_producto->valorTipo > 0){
                  switch ($precio_producto->tipoDescuento) {
                    case 0:
                      $porcentaje = $precio_producto->valorTipo;
                      break;
                    case 1:
                      $porcentaje = ($precio_producto->valorTipo * 100) / $precio_producto->precioVenta;
                      break;
                    default:
                      # code...
                      break;
                  }
                  $precio_mostrar = $precio_producto->precioVenta + ($precio_producto->precioVenta * 0.21);
                  echo '<span class="preciostrike strikethrough T_mediumLarge color9" >'.Yii::app()->numberFormatter->format("#,##0.00",$precio_mostrar).
                  "</span><span class='T_large'>|</span><span class='T_large pDescuento' >
                  ".Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->format("#,##0.00",$precio_producto->precioImpuesto).'</span><br/><span class="conDescuento">Con '.round($porcentaje).'% de descuento</span>';
                }else{
                  echo "<span class='T_large pDescuento' >".Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->format("#,##0.00",$precio_producto->precioImpuesto).'</span>';
                }
              }
               
            //echo $producto->precio; // precio con IVA
              Yii::app()->clientScript->registerMetaTag($producto->precio.' '.Yii::t('contentForm', 'currSym').' ', 'twitter:data1', null, null, null); // registrar tag de precio de twitter
              Yii::app()->clientScript->registerMetaTag('Precio', 'twitter:label1', null, null, null); // registrar tag de precio de Twitter
                Yii::app()->clientScript->registerMetaTag('Personaling - '.$producto->nombre.' - '.$producto->precio.' '.Yii::t('contentForm', 'currSym'), null, null, array('property' => 'og:title'), null); // registro del meta para facebook

            
  
      ?>
            </div>
            <?php
            
                $valores = Array();
                $cantcolor = Array();
                $cont1 = 0;
                
        // revisando cuantos colores distintos hay
        foreach ($producto->preciotallacolor as $talCol){ 
          if($talCol->cantidad > 0)
          {
            $color = Color::model()->findByPk($talCol->color_id);
          
            if(in_array($color->id, $cantcolor)){ // no hace nada para que no se repita el valor      
            }
            else {
              array_push($cantcolor, $color->id);
              $cont1++;
            }
            
          }
        }
        
        
      $valores2 = Array();
        $canttallas= Array();
                $cont2 = 0;
                
        // revisando cuantas tallas distintas hay
        foreach ($producto->preciotallacolor as $talCol){ 
          if($talCol->cantidad > 0)
          {
            $talla = Talla::model()->findByPk($talCol->talla_id);
          
            if(in_array($talla->id, $canttallas)){  // no hace nada para que no se repita el valor      
            }
            else{
              array_push($canttallas, $talla->id);
              $cont2++;
            }
            
          }
        }
        
      
          ?>
            <div class="span2 hidden-phone">
                <?php if($producto->estado == 1){ ?>
                 <a title="Producto Inactivo" class="btn btn-warning btn-block" style="cursor: default" disabled><i class="icon-ban-circle icon-white"></i> <?php echo Yii::t('contentForm','Inactive'); ?> </a>                
                
              <?php
                }else if($cont1 > 0 && $cont2 > 0){
              ?>
                <a onclick="comprar()" id="agregar" title="agregar a la bolsa" class="btn btn-warning btn-block"><i class="icon-shopping-cart icon-white"></i> <?php echo Yii::t('contentForm','Buy'); ?> </a>
              
           
            <?php
           }else{
            ?>
            <a title="Producto agotado" class="btn btn-warning btn-block" style="cursor: default" disabled><i class="icon-ban-circle icon-white"></i> <?php echo Yii::t('contentForm','Sold out'); ?> </a>
            <?php
          }
                ?>
            </div>
          </div>
          
          <?php
          if($producto->mymarca->is_100chic){
          	echo CHtml::hiddenField('chic',1);
	       ?>
            <img src="<?php echo Yii::app()->baseUrl; ?>/images/bannerTitina.jpg" alt="Banner Titina Penzini" class="margin_top_medium_minus">
		  <?php
		  }
		  else
		  	echo CHtml::hiddenField('chic',0);   
          if($cont1 > 0 && $cont2 > 0){
          ?>
          
          <p class="muted t_small CAPS"> <?php echo Yii::t('contentForm','Select color and size'); ?></p>
          
          <div class="row-fluid">
              <div class="span6" id="tooltipColor">
              <h5><?php echo Yii::t('contentForm','Colors'); ?></h5>
              <div id="vCo" class="clearfix colores">
                <?php

                if( $cont1 == 1) // Si solo hay un color seleccionelo
                {
                  $color = Color::model()->findByPk($cantcolor[0]);             
                  echo "<div value='solo' id=".$color->id." style='cursor: pointer' class='coloress active' title='".$color->valor."'><img src='".Yii::app()->baseUrl."/images/colores/".$color->path_image."'></div>"; 

                }
                else{
                  
                  foreach ($producto->preciotallacolor as $talCol) {

                    if($talCol->cantidad > 0) // que haya disp
                    {
                      $color = Color::model()->findByPk($talCol->color_id);   

                      if(in_array($color->id, $valores)){ // no hace nada para que no se repita el valor      
                      }
                      else{
                        echo "<div id=".$color->id." style='cursor: pointer' class='coloress' title='".$color->valor."'><img src='".Yii::app()->baseUrl."/images/colores/".$color->path_image."'></div>"; 
                        array_push($valores, $color->id);
                      }
                    }
                  }

                } // else    
        
                ?>
              </div>
            </div>
            <div class="span6" id="tooltipTalla">
              <h5><?php echo Yii::t('contentForm','Sizes'); ?></h5>
              <div id="vTa" class="clearfix tallas">
                <?php
              
        
        	            
          foreach ($producto->tallasDisponibles as $talla) { 
                    
             
                echo "<div id=".$talla['id']." style='cursor: pointer' class='tallass' title='talla'>".$talla['valor']."</div>"; 
                array_push($valores2, $talla['id']);
             
            
            }
          
          // else
                ?>                
              </div>
               <div class="braker_top margin_top_small">
                <a href="#myModal" role="button" class="btn btn-mini btn-link color9" data-toggle="modal">Ver guia de tallas</a>
              </div><!--
 -->            </div>
           </div>
             
             <?php
             }
             ?>
             
             <div class="call2action visible-phone"><hr/>
                <a onclick="comprar()" id="agregar" title="agregar a la bolsa" class="btn btn-warning btn-block"><i class="icon-shopping-cart icon-white"></i> <?php echo Yii::t('contentForm','Buy'); ?> </a>
            </div>
         
            <?php  $marca = Marca::model()->findByPk($producto->marca_id);
                Yii::app()->clientScript->registerMetaTag($marca->nombre, 'twitter:data2', null, null, null);

             ?>
          <div class="margin_top">
            <ul class="nav nav-tabs" id="myTab">
              <li class="active"><a href="#descripcion" data-toggle="tab"><?php echo Yii::t('contentForm','Description'); ?></a></li>
              <li><a href="#detalles" data-toggle="tab"><?php echo Yii::t('contentForm','Details'); ?></a></li>
              <li><a href="#envio" data-toggle="tab"><?php echo Yii::t('contentForm','Delivery'); ?></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="descripcion">
                <div class="clearfix row-fluid">   
                  <div class="span4">
                  <p class="margin_left_small"><strong><?php echo (null!==$marca)?$marca->nombre:'N/D'; ?></strong></p>                    
                  <?php
                  if (null!==$marca)
                  echo CHtml::image(Yii::app()->baseUrl .'/images/marca/'. str_replace(".","_thumb.",$marca->urlImagen), "Marca",array("width" => "65","class" => "margin_left_small"));
                  ?>   
                  </div>
                  <div class="span6">
                    <p><strong><?php echo Yii::t('contentForm','Description'); ?></strong>: <?php echo $producto->descripcion; ?></p> 
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="detalles">
                <div class="clearfix">
                    <?php
          ?>

        <div class="row-fluid">
          <div class="span3">
          <?php
          if (null!==$marca)
                  echo CHtml::image(Yii::app()->baseUrl .'/images/marca/'. str_replace(".","_thumb.",$marca->urlImagen), "Marca",array("width" => "65"));
          ?>   
          </div>               
                    <div class="span9">
                    <p><strong><?php echo (null!==$marca)?$marca->nombre:'N/D'; ?></strong></p>
                      <p><strong><?php echo Yii::t('contentForm','Description'); ?></strong>: <?php echo (null!==$marca)?$marca->descripcion:'N/D'; ?></p> 
            <p><strong><?php echo Yii::t('contentForm','Weight'); ?></strong> <?php echo  $producto->peso; ?> </p>
                    </div>
        </div>
              </div>
              </div>
              <div class="tab-pane" id="envio">
              <div class="row">
                <div class="span3"><p class="padding_top_small"><?php echo Yii::t('contentForm','Our deliveries through'); ?>:</p></div>
              </div>
              <div class="row">
                <div class="span3"><img height="60px"  src="<?php echo Yii::app()->baseUrl.'/images/'.Yii::app()->language.'/logos_carriers.png'; ?>"/></div>
              </div>
            </div>
            </div>
          </div>
          <div class="braker_horz_top_1">
           <p> <span class="entypo icon_personaling_medium">&#128197;</span>
              <?php echo Yii::t('contentForm','Date estimated delivery'); ?>: <?php echo date('d/m/Y', strtotime('+1 day')); ?> - <?php echo date('d/m/Y', strtotime('+1 week'));  ?>  </p>    
          </div>
          <div class="braker_horz_top_1 addthis row-fluid padding_bottom_medium"> 
            
            <?php
              if(isset($like)) // le ha dado like 
        {
            ?>
            <div class="span6"><a class="btn btn-danger_modificado" id="btn-encanta" onclick="encantar()" style="cursor: pointer;"><span class="entypo icon_personaling_medium">&nbsp;</span> <?php echo Yii::t('contentForm','Like'); ?></a> &nbsp;
              <?php
        }
        else {
        ?>
       <div class="span6"><a class="btn" id="btn-encanta" onclick="encantar()" style="cursor: pointer;"><span class="entypo icon_personaling_medium"> 
      
      &nbsp; </span> <?php echo Yii::t('contentForm','Like'); ?></a> &nbsp;
        <?php
        }
        ?>
        <small id="total-likes" class="hidden-tablet hidden-phone">
        <?php 
              // total de likes 
                    $cuantos = UserEncantan::model()->countByAttributes(array('producto_id'=>$producto->id));   
          echo $cuantos;
              ?>
        </small>
            </div>
            <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
            <a class="addthis_button_facebook"></a>
            <a class="addthis_button_twitter" tw:via="personaling"></a>
            <a class="addthis_button_pinterest_share"></a>
            </div>
            <!-- AddThis Button END -->           
            <script type="text/javascript">       
              var addthis_config = {"data_track_addressbar":false,image_exclude: "at_exclude"};
              var addthis_share = {
                  templates : {
                      twitter : "{{title}} {{url}} #MiPersonaling via @personaling "
                  }
              }
            </script> 
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=juanrules"></script>
          </div>
          <hr />
        </div>
        <!-- Columna Secundaria OFF --> 
      </div>
    </div>
  </div>
    
<?php
$looksProducto = LookHasProducto::model()->findAllByAttributes(array('producto_id'=>$producto->id));

$count = count ($looksProducto);

$cont=0;
?>

<?php if($count > 0){  ?>

<div class="braker_horz_top_1 hidden-phone" id="tienda_looks">
    <h3><?php echo Yii::t('contentForm','Recommended Looks with this product'); ?></h3>
    <div id="myCarousel" class="carousel slide"> 
      <!-- Carousel items -->
      <div class="carousel-inner">
          <div class="row">
      <?php
      foreach($looksProducto as $cadauno){
        if($cont<3){
          if($cadauno->width != "" && $cadauno->height != ""){
          
          $lk = Look::model()->aprobados()->findByPk($cadauno->look_id);
          
            if(isset($lk)){
              echo('<div class="span4 look"><article class="">');
              echo("<a href='".$lk->getUrl()."' title='".$lk->title."'>");
              echo CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$cadauno->look_id)), "Look", array("width" => "370", "height" => "370", 'class'=>''));
              echo("</a>");
              ?>
              <div class="hidden-phone margin_top_small vcard row-fluid">
                <div class="span2 avatar ">

                    <?php echo CHtml::image($lk->user->getAvatar(),'Avatar',array("width"=>"40", "class"=>"photo img-circle")); //,"height"=>"270" ?>
                </div>
                <div class="span4"> <span class="muted"><?php echo Yii::t('contentForm' , 'Look created by'); ?>:  </span>
                  <h5><a class="url" title="profile" href="#"><span class="fn">
                    <?php //echo $look->title; ?>
                    <?php echo $lk->user->profile->first_name; ?> </span></a></h5>
                </div>
                <div class="span6"><span class="precio"> <small><?php echo Yii::t('contentForm' , 'currSym'); ?></small> <?php echo $lk->getPrecio(); ?></span></div>
              </div>
              </article>
            </div>
              <?php
  
              $cont++; // solo 3 veces
            }
          }
        }
      }// foreach
      
    } // count
  ?>

      </div>

  </div>
</div> </div>

<!-- /container -->

<!-- Modal Guia Talla -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Guía de tallas Personaling</h3>
  </div>
  <div class="modal-body">
    <div id="size-guide">
      <article id="main" role="main">
        <header>
<!--           <h4 class="braker_bottom"><strong>Talla de Pantalones</strong> <span>- Medidas</span></h4>
          <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec pulvinar est et feugiat sodales. Proin egestas, neque nec varius condimentum, nunc eros placerat tellus, ac accu. </p> -->
      <em>
        <p>¿Cómo se cuál es mi talla?</p>
         <p>Primero necesitarás tener a la mano:  </p>
      </em>
      <ul class="unstyled">
        <li><p><strong>Una cinta métrica.</strong> </p></li>
        <li><p><strong>Mucha honestidad</strong></p></li>
      </ul>
      <p><em>Ahora, debes tomarte las medidas de la siguiente forma: </em></p>
        <div class="row-fluid margin_top_medium margin_bottom_medium">
          <div class="span4 offset1 modelo">
            <!--<img src="<?php echo  $baseUrl ?>/images/model_guiadetallas.jpg"  alt="Modelo de Guia de Tallas" />-->      
            <img src="<?php echo  $baseUrl ?>/images/cuerpo_2.jpg"  alt="Modelo de Guia de Tallas" />      
          </div>
            
        <div class="span7">
                <p><strong>Busto:</strong> Debes rodearte con la cinta métrica por encima de la parte más voluminosa del pecho y pasando justo por la parte baja de las axilas.</p>

                <p><strong>Cintura:</strong> Debes buscar la forma natural de tu cuerpo y descubrir donde queda tu cintura; luego de eso rodéala con la cinta métrica. </p>

                <p><strong>Caderas:</strong> Debes pasar la cinta métrica por la parte más saliente de tu trasero. </p>
        </div>
     
     </div>

      <em><p>
        ¿Qué hago con esas medidas?</p> </em>

      <em><p>Aquí te dejamos una tabla con una conversión  aproximada basada en las medidas europeas.</p> </em>   
                
        </header>
        <section>
          <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-condensed table-bordered table-hover table-striped">
            <thead>
              <tr>
                <th>Talla Europea</th>
                <th >Busto</th>
                <th >Cintura</th>
                <th >Caderas</th>
              </tr>
              <tr>
                <th></th>
                <th>Centímetros (cm)</th>
                <th>Centímetros (cm)</th>
                <th>Centímetros (cm)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><strong>EU 34</strong></td>
                <td>76</td>
                <td>58</td>
                <td>83,5</td>
              </tr>
              <tr>
                <td><strong>EU 36</strong></td>
                <td>78,5</td>
                <td>60,5</td>
                <td>86</td>
              </tr>
              <tr>
                <td><strong>EU 38</strong></td>
                <td>81</td>
                <td>63</td>
                <td>88.5</td>
              </tr>
              <tr>
                <td><strong>EU 40</strong></td>
                <td>86</td>
                <td>68</td>
                <td>93,5</td>
              </tr>
              <tr>
                <td><strong>EU 42</strong></td>
                <td>91</td>
                <td>73</td>
                <td>98,5</td>
              </tr>
              <tr>
                <td><strong>EU 44</strong></td>
                <td>96</td>
                <td>78</td>
                <td>103,5</td>
              </tr>
              <tr>
                <td><strong>EU 46</strong></td>
                <td>101</td>
                <td>83</td>
                <td>108,5</td>
              </tr>
            </tbody>
          </table>
         
        </section>
      </article>
      <aside>
        
            <h4 class="braker_bottom margin_top"><strong>Guía de Tallas</strong></h4>
        
          <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-condensed table-bordered table-hover table-striped">
            <tbody>
              <tr>
                <th>Europa</th>
                <td>PT</td>
                <td>XS</td>
                <td>S</td>
                <td>M</td>
                <td>L</td>
                <td>XL</td>
                <td>XXL</td>
              </tr>
              <tr>
                <th>Alemania</th>
                <td>PT</td>
                <td>XS</td>
                <td>S</td>
                <td>M</td>
                <td>L</td>
                <td>XL</td>
                <td>XXL</td>
              </tr>
              <tr>
                <th>Canada</th>
                <td>PT</td>
                <td>SS/2</td>
                <td>XS/4</td>
                <td>S/6</td>
                <td>M/8</td>
                <td>L/10</td>
                <td>XL/12</td>
              </tr>
              <tr>
                <th>México</th>
                <td>PT</td>
                <td>ECH</td>
                <td>CH</td>
                <td>M</td>
                <td>G</td>
                <td>EG</td>
                <td>EEG</td>
              </tr>
              <tr>
                <th>Reino Unido</th>
                <td>PT</td>
                <td>XS/6</td>
                <td>S/8</td>
                <td>M/10</td>
                <td>L/12</td>
                <td>XL/14</td>
                <td>XXL/16</td>
              </tr>    
              <tr>
                <th>U.S.A.</th>
                <td>PT</td>
                <td>XXS/2</td>
                <td>XS/4</td>
                <td>S/6</td>
                <td>M/8</td>
                <td>L/10</td>
                <td>XL/12</td>
              </tr>                          
            </tbody>
          </table>

          <h4 class="braker_bottom margin_top"><strong>Pantalones:</strong></h4>
        
          <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-condensed table-bordered table-hover table-striped">
            <tbody>
              <tr>
                <th>Europa</th>
                <td>32</td>
                <td>34</td>
                <td>36</td>
                <td>37</td>
                <td>38</td>
                <td>39</td>
                <td>40</td>
                <td>42</td>
                <td>44</td>
                <td>46</td>
              </tr>
              <tr>
                <th>Alemania</th>
                <td>32</td>
                <td>34</td>
                <td>36</td>
                <td>37</td>
                <td>38</td>
                <td>39</td>
                <td>40</td>
                <td>42</td>
                <td>44</td>
                <td>46</td>
              </tr>
              <tr>
                <th>México</th>
                <td>0</td>
                <td>1</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
                <td>9</td>
                <td>11</td>
                <td>13</td>
              </tr>
              <tr>
                <th>Reino Unido</th>
                <td>4</td>
                <td>6</td>
                <td>8</td>
                <td>9</td>
                <td>10</td>
                <td>11</td>
                <td>12</td>
                <td>14</td>
                <td>16</td>
                <td>18</td>
              </tr>  
              <tr>
                <th>U.S.A.</th>
                <td>1</td>
                <td>2</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
                <td>8</td>
                <td>10</td>
                <td>12</td>
                <td>14</td>
              </tr>                                        
            </tbody>
          </table>   

          <h4 class="braker_bottom margin_top"><strong>Zapatos:</strong></h4>
        
          <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-condensed table-bordered table-hover table-striped">
            <tbody>
              <tr>
                <th>Europa</th>
                <td>35</td>
                <td>36</td>
                <td>37</td>
                <td>38</td>
                <td>39</td>
                <td>40</td>
                <td>41</td>
                <td>42</td>
                <td>43</td>
                <td>44</td>
              </tr>
              <tr>
                <th>México</th>
                <td>2</td>
                <td>3/</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>6/</td>
                <td>7</td>
                <td>8</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <th>Reino Unido</th>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
                <td>8</td>
                <td>9</td>
                <td></td>
                <td></td>
              </tr>  
              <tr>
                <th>U.S.A.</th>
                <td>5</td>
                <td>6</td>
                <td>6/</td>
                <td>7/</td>
                <td>8/</td>
                <td>9</td>
                <td>9/</td>
                <td>10</td>
                <td></td>
                <td></td>
              </tr>                                        
            </tbody>
          </table>                   
      </aside>
    </div>
  </div>
  <div class="modal-footer">  <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
</div><!-- Modal Guia Talla OFF -->

<?php 

//$cs = Yii::app()->getClientScript();
//$cs->registerScript("unodos","$('.imagen_principal').zoom()",CClientScript::POS_READY);

?>
 
<script>
var comprando = true;

$(document).ready(function(){

$('#tooltipColor').tooltip({
    title:"Selecciona el color para poder añadir a la bolsa",
    trigger:"manual",
    placement:"left"
    
});
$('#tooltipTalla').tooltip({
    title:"Selecciona la talla para poder añadir a la bolsa",
    trigger:"manual",
//    placement:"left"
    
});



var source = $('#principal').attr("src");
var imgZ = source.replace(".","_orig.");
imgZ = imgZ.replace("png", "jpg");

$('.imagen_principal').zoom({url: imgZ});


  $(".imagen_principal").hover(function(){
    var source = $('#principal').attr("src");
    var imgZ = source.replace(".","_orig.");
    
    imgZ = imgZ.replace("png", "jpg");
    
    $('.imagen_principal').zoom({url: imgZ});    
  
  });
  
   $(".miniaturas_listado_click").click(function(){
      var image = $("#principal");
      var thumbnail = $(this).attr("src");
      
      var cambio = thumbnail.replace("_x90.",".");
      
      // primero cargo la imagen del zoom y aseguro que al momento de hacer el cambio de imagen principal esté listo el zoom
      var source = cambio;
    var imgZ = source.replace(".","_orig.");
      imgZ = imgZ.replace("png", "jpg");
      $('.imagen_principal').zoom({url: imgZ});
      
          
        // cambio de la principal   
      $("#principal").fadeOut("slow",function(){
        $("#principal").attr("src", cambio);
      });

        $("#principal").fadeIn("slow",function(){});

   });

    $(".coloress").click(function(ev){ // Click en alguno de los colores -> cambia las tallas disponibles para el color
      ev.preventDefault();
      //alert($(this).attr("id"));
      $('#tooltipColor').tooltip('hide');  
      var prueba = $("#vCo div.tallass.active").attr('value');

    /* 
     * Si hay una sola talla dira solo, pero no haria mas nada 
     */
    if(prueba == 'solo')
      {
        $(this).addClass('coloress active'); // añado la clase active al seleccionado
        $("#vTa div.tallass.active").attr('value','0');
      }
      else{
      
      // para quitar el active en caso de que ya alguno estuviera seleccionado
      $("#vCo").find("div").siblings().removeClass('active');
      
      var dataString = $(this).attr("id");
      var prod = $("#producto").attr("value");

      $(this).removeClass('coloress');
      $(this).addClass('coloress active'); // añado la clase active al seleccionado
         
      $.ajax({
          type: "post",
          url: '<?php echo Yii::app()->baseUrl; ?>/producto/tallas', // action Tallas de Producto
          data: { 'idTalla':dataString , 'idProd':prod}, 
          dataType:"json",
          success: function (data) {
            
            if(data.status == 'ok')
            {
            	if(data.imagenes.length>0){
            	
              //alert(data.datos);
          var cont="";
          $.each(data.datos,function(clave,valor) {
              //0 -> id, 1 -> valor
              cont = cont + "<div onclick='a("+valor[0]+")' id='"+valor[0]+"' style='cursor: pointer' class='tallass' title='talla'>"+valor[1]+"</div>";
              
          });
          //alert(cont); 
          
          $("#vTa").fadeOut(100,function(){
              $("#vTa").html(cont); // cambiando el div
            });
      
              $("#vTa").fadeIn(20,function(){});
                 
          
          // ahora cambiar las imagenes a las del color 
          
            var zona="";
            var thumbs="";
            var contador=0;
            
          // luego muestro  
            $.each(data.imagenes,function(clave,valor) {
                //0 -> url | 1 -> orden | 2 -> id imagen
                
                // conseguir cual es el menor en el orden para determinar el color  
                if( contador == 0) {
                  var Url = "<?php echo Yii::app()->baseUrl; ?>" + valor[0];
                  
                var n = Url.split(".");
                //alert(n[0]); path           
                //alert(n[1]); extension            
                  
                  if(n[1] == 'png')
                  {
                    Url = n[0] + ".jpg";
                  }
                  
                  zona="<img id='principal' src='"+Url+"' alt'producto'>";
                  contador++;
                }
                var base = "<?php echo Yii::app()->baseUrl; ?>";    
                var thumb = valor[0].split('.');            
                thumbs = thumbs + "<img onclick='minis("+valor[2]+")' width='90' height='90' id='thumb"+valor[2]+"' class='miniaturas_listado_click' src='"+base + thumb[0] +'_x90.'+thumb[1]+"' alt='Imagen' style='cursor: pointer' >";
                
                objImage = new Image();
                var source = ''+base +valor[0];
                var imgZ = source.replace(".","_orig.");
              //  alert(imgZ);    
                imgZ = imgZ.replace("png", "jpg");  
              objImage.src = imgZ;
              
                        
            });
            
            //alert(thumbs);       
            
            // cambiando la imagen principal :@
            $(".imagen_principal").fadeOut("10",function(){
            	if($('#chic').val()==1){
            		zona=zona+"<div class='text_align_center btn-block is_100chic'> <span>100% CHIC</span> </div>";
            	}
            	
              $(".imagen_principal").html(zona);
              
                var source = $('#principal').attr("src");
                var imgZ = source.replace(".","_orig.");
                  imgZ = imgZ.replace("png", "jpg");
                    imgZ = imgZ.replace("png", "jpg");
                $('.imagen_principal').zoom();
              
            });
                
            $(".imagen_principal").fadeIn("10",function(){});
            
            
            // cambiando los thumbnails
            $(".imagenes_secundarias").fadeOut("slow",function(){ 
              $(".imagenes_secundarias").html(thumbs); 
            });
                
            $(".imagenes_secundarias").fadeIn("slow",function(){});
            
            
                        
            }
			}
          }//success
         })
         
       } // else
      
    });   
   

    $(".tallass").click(function(ev){ // click en tallas -> recarga los colores para esa talla
      ev.preventDefault();
      $('#tooltipTalla').tooltip('hide');  
      
      var prueba = $("#vTa div.coloress.active").attr('value');
      
      if(prueba == 'solo')
      {
        $(this).addClass('tallass active'); // añado la clase active al seleccionado
        $("#vCo div.coloress.active").attr('value','0');
      }
      else{
      
      // para quitar el active en caso de que ya alguno estuviera seleccionado
      $("#vTa").find("div").siblings().removeClass('active');
      
      var dataString = $(this).attr("id");
      var prod = $("#producto").attr("value");
     
      $(this).removeClass('tallass');
      $(this).addClass('tallass active'); // añado la clase active al seleccionado
     
      $.ajax({
          type: "post",
          url: "../colores", // action Colores de Producto
          data: { 'idColor':dataString , 'idProd':prod}, 
          dataType:"json",
          success: function (data) {
            
            if(data.status == 'ok')
            {
              var base = "<?php echo Yii::app()->baseUrl; ?>";    
              //alert(data.datos);
          var cont="";
          $.each(data.datos,function(clave,valor) {
              //0 -> id, 1 -> valor
              cont = cont + "<div onclick='b("+valor[0]+")' id='"+valor[0]+"' style='cursor: pointer' class='coloress' title='"+valor[1]+"'><img src='"+ base +"/images/colores/"+valor[2]+"'></div>";
              
          });
          //alert(cont); 
          
          $("#vCo").fadeOut(100,function(){
              $("#vCo").html(cont); // cambiando el div
            });
      
              $("#vCo").fadeIn(20,function(){});
          
          //$("#vTa").html(cont);
                        
            }
          }//success
         })
         
      }//else
      
    }); // tallas
     
      
}); // ready

  $(".imagen_principal").hover(function(){
    var source = $('#principal').attr("src");
    var imgZ = source.replace(".","_orig.");
      imgZ = imgZ.replace("png", "jpg");
    $('.imagen_principal').zoom({url: imgZ});     
  });
  
  /*  
  $(".imagen_principal").live({
    hover: function() {
        var source = $('#principal').attr("src");
      var imgZ = source.replace(".","_orig.");
      $('.imagen_principal').zoom({url: imgZ});     
    }
  });
  */
  
  function minis(idImagen){   
    var thumbnail = $('#thumb'+idImagen).attr("src");
      
      var cambio = thumbnail.replace("_x90.",".");

      // primero cargo la imagen del zoom y aseguro que al momento de hacer el cambio de imagen principal esté listo el zoom
      var source = cambio;
      
      var n = source.split(".");
    //alert(n[0]);            
    //alert(n[1]);            
                  
    if(n[1] == 'png')
    {
      source = n[0] + ".jpg";
    }
      
    var imgZ = source.replace(".","_orig.");
      $('.imagen_principal').zoom({url: imgZ});

     // cambio de la principal     
       $("#principal").fadeOut("slow",function(){
        $("#principal").attr("src", cambio);
       });
  
       $("#principal").fadeIn("slow",function(){});
  }
   
   function a(id){ // seleccion de talla

      $("#vTa").find("div").siblings().removeClass('active');
      
      $("#vTa").find("div#"+id+".tallass").removeClass("tallass");
      $("#vTa").find("div#"+id).addClass("tallass active");
      $('#tooltipTalla').tooltip('hide');  

   }
   
   function b(id){ // seleccion de color
    
       $("#vCo").find("div").siblings().removeClass('active'); 
      
       $("#vCo").find("div#"+id+".coloress").removeClass("coloress");
       $("#vCo").find("div#"+id).addClass("coloress active");      
      
       $('#tooltipColor').tooltip('hide');  

   }
   
   function comprar(){ // comprobar quienes están seleccionados
      
      if (comprando == true){
        var talla = $("#vTa").find(".tallass.active").attr("id");
        var color = $("#vCo").find(".coloress.active").attr("id");
        var producto = $("#producto").attr("value");
        
        
      if(color==undefined) // falta color
      {
          $('#tooltipColor').tooltip('show');  
      }   
      if(talla==undefined) // falta color
      {
          $('#tooltipTalla').tooltip('show');  
      }   
        
//      if(talla==undefined && color==undefined) // ninguno
//      {
//        bootbox.alert("Seleccione talla y color para poder añadir.");
//      }
//      if(talla==undefined && color==undefined) // ninguno
//      {
//        bootbox.alert("Seleccione talla y color para poder añadir.");
//      }
//      
//      if(talla==undefined && color!=undefined) // falta talla
//      {
//        bootbox.alert("Seleccione la talla para poder añadir a la bolsa.");
//      }   
         //LLamada ajax
      if(talla!=undefined && color!=undefined)
      {
        //$('#agregar').click(false);
        $('#agregar').attr("disabled", true);
        comprando = false;
        $.ajax({
            type: "post",
            url: "<?php echo Yii::app()->createUrl('bolsa/agregar'); ?>", // action Tallas de Producto
            data: { 'producto':producto, 'talla':talla, 'color':color}, 
            success: function (data) {
              comprando = true;
          
              if(data=="ok")
              {
                //alert("redireccionar mañana");
                window.location="<?php echo Yii::app()->createUrl('bolsa/index'); ?>";
              }

              if(data=="no es usuario")
              {
                bootbox.alert("Debes primero ingresar con tu cuenta de usuario o registrarte");
              }

            }//success
         })
        
        
      }// cerro   
    }


   }
   
    function encantar()
    {
      var idProd = $("#producto").attr("value");
      //alert("id:"+idProd);    
      
      $.ajax({
          type: "post",
          dataType:"json",
          url: "../encantar", // action Tallas de Producto
          data: { 'idProd':idProd}, 
          success: function (data) {
            
          //  alert(data); 
        
        if(data.mensaje=="ok") 
        {         
          var a = "♥";
          
          //$("#meEncanta").removeClass("btn-link");
          $("#meEncanta").addClass("btn-link-active");
          $("span#like").text(a);
          
          $("#total-likes").text(data.total); 
          $("#btn-encanta").addClass("btn-danger_modificado");
        }
        
        if(data.mensaje=="no")
        {
          bootbox.alert("Debes ingresar con tu cuenta de usuario o registrarte antes de dar 'Me Encanta' a un producto");
          //window.location="../../user/login";
        }
        
        if(data.mensaje=="borrado")
        {
          var a = "♡";
          
          //alert("borrando");
          $("#btn-encanta").removeClass("btn-danger_modificado");
          $("#meEncanta").removeClass("btn-link-active");
          $("span#like").text(a);
          
          $("#total-likes").text(data.total);         
        }
          
          }//success
         })
      
      
    }
   
   
</script>
