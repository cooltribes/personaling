
  <div class="row" id="pshoppers">
	<?php foreach($profs as $prof):
		$thuser=User::model()->findByPk($prof->user_id);?>
		<?php //echo $this->renderPartial('_look',array('look'=>$look),true,true); ?>
<div class="span3 pshopper" align="center">
      <article > 
      	<?php if ($pages->currentPage > 0){ 
      		
      		echo $thuser->getAvatar(); ?>
      	<?php $image = CHtml::image($thuser->getAvatar(), "PS", array("id" => "imglook".$prof->user_id,"width" => "250", "height" => "250", 'class'=>'ps_avatar img-circle', 'alt'=>$prof->first_name)); ?>
      	<?php }else{ ?>
      	<?php echo CHtml::image('../../images/loading.gif','Loading',array('class'=>'imgloading','id'=>"imgloading".$prof->user_id)); ?>                            	
        <?php $image = CHtml::image($thuser->getAvatar(), "Look", array("style"=>"display: none","id" => "imglook".$prof->user_id,"width" => "250", "height" => "250", 'class'=>'ps_avatar img-circle')); ?>
        <?php } ?>
        	         
                  	<?php echo CHtml::link($image,$prof->getUrl(),array('title'=>$prof->first_name)); ?>
                  	
                  	<?php
                  	echo "<h3>".CHtml::link($prof->first_name,$prof->getUrl())."</h3>";
                  	echo "<p>".$prof->bio."</p>";
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
	    'loadingText' => 'Ubicando Personal Shoppers',
	    'donetext' => 'Somos '.User::model()->totalPS.' Personal Shoppers comprometidas con tu look.',
	  //  'afterAjaxUpdate' => 'alert("hola");',
	    'pages' => $pages,
	)); ?>

	</div>
  