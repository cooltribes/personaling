
  <div class="row" id="pshoppers">
	<?php foreach($profs as $prof):
		$thuser=User::model()->findByPk($prof->user_id);?>
		<?php //echo $this->renderPartial('_look',array('look'=>$look),true,true); ?>
<div class="span4 pshopper">
      <article > 
      	<?php if ($pages->currentPage > 0){ 
      		
      		echo $thuser->getAvatar(); ?>
      	<?php $image = CHtml::image($thuser->getAvatar(), "PS", array("id" => "imglook".$prof->user_id,"width" => "368", "height" => "368", 'class'=>'ps_avatar')); ?>
      	<?php }else{ ?>
      	<?php echo CHtml::image('../../images/loading.gif','Loading',array('class'=>'imgloading','id'=>"imgloading".$prof->user_id)); ?>                            	
        <?php $image = CHtml::image($thuser->getAvatar(), "Look", array("style"=>"display: none","id" => "imglook".$prof->user_id,"width" => "368", "height" => "368", 'class'=>'ps_avatar')); ?>
        <?php } ?>
        	         
                  	<?php echo CHtml::link($image,$prof->getUrl()); ?>
                  	
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
							    $('#imgloading".$prof->user_id."').hide();
							    $(this).show();
							}
							$('#"."ps_avatar".$prof->user_id."').filter(function() {
							    return this.complete;
							}).each(load_handler).end().load(load_handler);						 
						 ";					 
  					?>
        
   
        
        </article>
    </div>		
	<?php endforeach; ?>
	<script>
	$('.ps_avatar').on("load",function(){
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
	    'contentSelector' => '#pshoppers',
	    'itemSelector' => 'div.pshopper',
	    'loadingText' => 'Loading...',
	    'donetext' => 'This is the end... my only friend, the end',
	  //  'afterAjaxUpdate' => 'alert("hola");',
	    'pages' => $pages,
	)); ?> 
	</div>
  