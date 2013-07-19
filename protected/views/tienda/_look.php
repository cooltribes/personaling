
  <div class="row" id="looks">
	<?php foreach($looks as $look): ?>
		<?php //echo $this->renderPartial('_look',array('look'=>$look),true,true); ?>
<div class="span4 look">
      <article > 
      	<?php if ($pages->currentPage > 0){ ?>
      	<?php $image = CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id,'w'=>'368','h'=>'368')), "Look", array("id" => "imglook".$look->id,"width" => "368", "height" => "368", 'class'=>'imglook')); ?>
      	<?php }else{ ?>
      	<?php echo CHtml::image('../images/loading.gif','Loading',array('class'=>'imgloading','id'=>"imgloading".$look->id)); ?>                            	
        <?php $image = CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id,'w'=>'368','h'=>'368')), "Look", array("style"=>"display: none","id" => "imglook".$look->id,"width" => "368", "height" => "368", 'class'=>'imglook')); ?>
        <?php } ?>
        	         
                  	<?php echo CHtml::link($image,array('look/view', 'id'=>$look->id)); ?>
                  	
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
  					?>
        <div class="hidden-phone margin_top_small vcard row-fluid">
          <div class="span2  ">
            <div class="avatar"> <?php echo CHtml::image($look->user->getAvatar(),'Avatar',array("width"=>"40", "class"=>"photo img-circle")); //,"height"=>"270" ?> </div>
          </div>
          <div class="span6"> <span class="muted">Look creado por: </span>
            <h5><a href="#" title="profile" class="url"><span class="fn"> <?php echo $look->user->profile->first_name; ?> </span></a></h5>
          </div>
          <div class="span4"><span class="precio"><small>Bs.</small><?php echo $look->getPrecio(); ?></span></div>
        </div>
        <div class="share_like">
          <button class="btn-link" title="Me encanta" href="#"><span class="entypo icon_personaling_big">♡</span></button>
          <div class="btn-group">
            <button data-toggle="dropdown" class="dropdown-toggle btn-link"><span class="entypo icon_personaling_big"></span></button>
            <ul class="dropdown-menu addthis_toolbox addthis_default_style ">
            </ul>
            
            <!-- AddThis Button END --> 
            
          </div>
        </div>
        <span class="label label-important">Promoción</span> 
        </article>
    </div>		
	<?php endforeach; ?>
	<script>
	$('.imglook').on("load",function(){
		console.log('clicking');
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
	    'loadingText' => 'Loading...',
	    'donetext' => 'This is the end... my only friend, the end',
	  //  'afterAjaxUpdate' => 'alert("hola");',
	    'pages' => $pages,
	)); ?> 
	</div>
  