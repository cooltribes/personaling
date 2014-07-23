
<style>
    div.infinite_navigation{
        display:none;
    }
</style>

  <div class="row" id="looks">
  	
	<?php foreach($looks as $look): 
			
                if(!$look->getIsVisible()){
                    continue;
                }
		?>
		
		<?php  //echo $this->renderPartial('_look',array('look'=>$look),true,true); ?>
<div class="span4 look">
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
      	<?php $image = CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id,'w'=>'368','h'=>'368')).$mod_time, "Look", array("id" => "imglook".$look->id,"width" => "368", "height" => "368", 'class'=>'imglook')); ?>
      	<?php }else{ ?>
      	<?php echo CHtml::image(Yii::app()->baseUrl .'/images/loading.gif','Loading',array('class'=>'imgloading','id'=>"imgloading".$look->id)); ?>                            	
        <?php $image = CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id,'w'=>'368','h'=>'368')).$mod_time, "Look", array("style"=>"display: none","id" => "imglook".$look->id,"width" => "368", "height" => "368", 'class'=>'imglook')); ?>
        <?php } ?>
        	         
                  	<?php echo CHtml::link($image,$look->getUrl()); ?>
                  	
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
          <div class="span12 hidden-tablet">
            <div class="mis_looks">
              <div class="mis_looks_titulo"><?php echo $look->title; ?></div>
              <div class="mis_looks_descripcion"><?php echo $look->description; ?></div>
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
	<?php endforeach; ?>
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
  