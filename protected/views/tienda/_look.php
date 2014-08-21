
<style>
    div.infinite_navigation{
        display:none;
    }
</style>

  <div class="row" id="looks">
  	
	<?php 
  $cont = 1;
  foreach($looks as $look): 
			// registrar impresión en google analytics
      Yii::app()->clientScript->registerScript('metrica_analytics_looks_'.$cont,"
        ga('ec:addImpression', {            // Provide product details in an impressionFieldObject.
          'id': '".$look->id."',                   // Product ID (string).
          'name': '".$look->title."', // Product name (string).
          'category': 'Looks',   // Product category (string).
          'brand': 'Personaling',                // Product brand (string).
          'list': 'Look impression',         // Product list (string).
          'position': ".$cont.",                    // Product position (number).
        });
        
        ga('send', 'pageview');              // Send product impressions with initial pageview.
      ", CClientScript::POS_END); 


      if(!$look->getIsVisible()){
          continue;
      }

                


		?>
		
		<?php  //echo $this->renderPartial('_look',array('look'=>$look),true,true); ?>
<div class="span4 look">
  <div class="json_product" style="display:none;">
    <?php
    // hidden div con json para la función que se ejecuta con el scroll infinito
    echo json_encode(array(
      'id' => $look->id,
      'name' => $look->title,
      'category' => 'Looks',
      'brand' => 'Personaling',
      'list' => 'Look impression',
      'position' => $cont
    ));
    ?>
  </div>
      <article > 
      	<?php
        $mod_time = '';
        if($look->modified_on){
            $mod_time = '?lastmod='.strtotime($look->modified_on);
        }
        ?>
      	<?php if($look->has_100chic){ ?>
		<!--	<div class="has_100chic"></div> -->
      	<?php }?>
      	<?php if ($pages->currentPage > 0){ ?>
      	<?php $image = CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id,'w'=>'368','h'=>'368')).$mod_time, "Personaling - ".$look->title, array("id" => "imglook".$look->id,"width" => "368", "height" => "368", 'class'=>'imglook')); ?>
      	<?php }else{ ?>
      	<?php echo CHtml::image(Yii::app()->baseUrl .'/images/loading.gif','Loading',array('class'=>'imgloading','id'=>"imgloading".$look->id)); ?>                            	
        <?php $image = CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id,'w'=>'368','h'=>'368')).$mod_time, "Personaling - ".$look->title, array("style"=>"display: none","id" => "imglook".$look->id,"width" => "368", "height" => "368", 'class'=>'imglook')); ?>
        <?php } ?>
        	         
                  	<?php echo CHtml::link($image,'', array('onclick'=>'event.preventDefault(); detalle_look('.json_encode(array(
                                                                'id' => $look->id,
                                                                'name' => $look->title,
                                                                'category' => 'Looks',
                                                                'brand' => 'Personaling',
                                                                'list' => 'Look clicks',
                                                                'position' => $cont,
                                                                'url' => $look->getUrl()
                                                              )).')',
                                                            'style'=>'cursor: pointer;'
                                                          )); ?>
                  	
                  	<?php
                    /*
                    //"style"=>"display: none",              	
                        $script = "$('#"."imglook".$look->id."').load(function(){
									//alert('cargo');
									$('#imgloading".$look->id."').hide();
									$(this).show();
									//$('#loader_img').hide();
						});";
  						Yii::app()->clientScript->registerScript('img_ps_script'.$look->id,$script);
					 * 
					 */
					 
					 /*
					 echo "<script>
					 $('#"."imglook".$look->id."').load(function(){
									$('#imgloading".$look->id."').hide();
									$(this).show();
						});
					 </script>";
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
						 	Yii::app()->clientScript->registerScript('img_ps_script'.$look->id,$script);			 
  					?>
        <div class="hidden-phone margin_top_small vcard row-fluid">
          <div class="span2 hidden-tablet">
            <div class="avatar">
            <a href="<?php echo $look->user->profile->getUrl(); ?>">
            	<?php echo CHtml::image($look->user->getAvatar(),'Avatar',array("width"=>"40", "class"=>"photo img-circle")); //,"height"=>"270" ?> </div>
          	</a>
          	</div>
          <div class="span4 namePs"> <span class="muted pseparadas"><?php echo Yii::t('contentForm','Look created by'); ?>: </span>
            <h5>
			<?php 
			
		
			
			echo CHtml::link('<span class="fn">'.$look->user->profile->getNombre().'</span>',$look->user->profile->getUrl()); ?>
			</h5>
          </div>
          <div class="span6">
            <div class="row-fluid">
            	 <?php
              if(!is_null($look->tipoDescuento) && $look->valorDescuento > 0){
                ?>
            	<div class="pseparadas span6 color9" >
            		<div class="tPrecioLight ">Piezas Separadas</div>
            		<div class="pDoble">
            			<?php echo Yii::t('contentForm', 'currSym').''.$look->getPrecioProductosDescuento(); ?>
            		</div>
            	</div>
            	<div class="span6 pcompleto">
            		<div  class="tPrecio">Look Completo</div>
            		<div class="pDoble">
            			<?php echo Yii::t('contentForm', 'currSym'); ?><?php echo $look->getPrecioDescuento(); ?>
            		</div>
            	</div>
            	<?php
              }else{
                ?>
            	<div class="span12" >
            		<div class="pUnico">
            			<?php echo Yii::t('contentForm', 'currSym').''.$look->getPrecioDescuento(); ?>
            		</div>
            	</div>
            	<?php 
              
                }
              ?>
            	
            	
            	
            </div> 
            
          </div>
        </div>
        <div class="row-fluid lookMobile" >
        	<div class="half line-height-20">
        		<small class="muted"><?php echo Yii::t('contentForm','Look created by'); ?>:<br/></small>
        		<?php echo CHtml::link('<span class="fn pscompleto"><b>'.$look->user->profile->getNombre().'</b></span>',$look->user->profile->getUrl()); ?>
        		<?php echo CHtml::link('<span class="fn psprimero"><b>'.$look->user->profile->first_name.'</b></span>',$look->user->profile->getUrl()); ?>
        	</div>
        	<div class="half line-height-40">
        		<span class="pUnico">
            			<?php echo Yii::t('contentForm', 'currSym').''.$look->getPrecioDescuento(); ?>
            		</span>
        	</div>
        </div>
        <div class="share_like">
         <?php if(!Yii::app()->user->isGuest){?>
          <button id="meEncanta<?php echo $look->id; ?>" onclick='encantar(<?php echo $look->id; ?>)' title="Me encanta" class="btn-link <?php echo $look->meEncanta()?"btn-link-active":""; ?>">
          	<span id="like<?php echo $look->id; ?>" class="entypo icon_personaling_big"><?php echo $look->meEncanta()?"♥":"♡"; ?></span>
          </button>
          <?php }?>
          <div class="btn-group">
            <button data-toggle="dropdown" class="dropdown-toggle btn-link"><span class="entypo icon_personaling_big"></span></button>
            <ul class="dropdown-menu addthis_toolbox addthis_default_style ">
            </ul>
            
            <!-- AddThis Button END --> 
            
          </div>
        </div>
        <span class="label label-important"><?php echo Yii::t('contentForm','Promotion'); ?></span> 
        </article>
    </div>		
	<?php 
    $cont++;
  endforeach; 
  ?>
	<script>
	$('.imglook').on("load",function(){
		//console.log('clicking');
		$(this).parent().prev("img").hide();
		$(this).show();
	});
	$(document).on('click','.imgloading', function(){
    console.log('clicking');
   // FB.Canvas.scrollTo(0,0);        
	});

  function detalle_look(look){
    ga('ec:addProduct', {
        'id': look.id,
        'name': look.name,
        'category': look.category,
        'brand': look.brand,
        'position': look.position
    });
    ga('ec:setAction', 'click', {list: 'Looks tienda'});

      // Send click with an event, then send user to product page.
    ga('send', 'event', 'UX', 'click', 'Looks Results', {
          'hitCallback': function() {
            //console.log('redirect');
            //document.location = product.url;
          }
    });
    document.location = look.url;
  }
</script>

	<?php $this->widget('ext.yiinfinite-scroll.YiinfiniteScroller', array(
	    'contentSelector' => '#looks',
	    'itemSelector' => 'div.look',
	    'loadingText' => 'Cargando Looks...',
	    'donetext' => ' ',
	  //  'afterAjaxUpdate' => 'alert("hola");',
	    'pages' => $pages,
	    //'debug' => true,
	)); ?> 
	</div>
  