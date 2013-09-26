
<?php  
  $baseUrl = Yii::app()->baseUrl; 
  $cs = Yii::app()->getClientScript();
  $cs->registerScriptFile($baseUrl.'/js/slider.js');
  //$cs->registerCssFile($baseUrl.'/css/yourcss.css');

	$cantidad = LookEncantan::model()->countByAttributes(array('user_id'=>Yii::app()->user->id));

	if($cantidad > 3) {
	
?>

<div class=" margin_top">
  <div class="row margin_bottom_large">
    <div class="span12">
      <h1>Looks que te encantan</h1>
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
        
			foreach($looks as $uno) {

			$look = Look::model()->findByPk($uno->look_id);

		?>
              <div class="span4">
                <article class="item" >
                  <?php $image = CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id)), "Look", array("width" => "370", "height" => "400", 'class'=>'')); ?>
                  <?php echo CHtml::link($image,$look->getUrl()); ?>
                  <div class="hidden-phone margin_top_small vcard row-fluid">
                    <div class="span2 avatar "><img src="../../images/avatar_sample1.jpg" class="photo  img-circle" width="40"></div>
                    <div class="span5"> <span class="muted">Look creado por: </span>
                      <h5><a class="url" title="profile" href="#"><span class="fn">
                        <?php //echo $look->title; ?>
                        <?php echo $look->user->profile->first_name; ?> </span></a></h5>
                    </div>
                    <div class="span5"><span class="precio">Bs. <?php echo $look->getPrecio(); ?></span></div>
                  </div>
                  <div class="share_like">
                   
                    <?php
	            	$entro = 0;
					
					$like = LookEncantan::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'look_id'=>$look->id));
	            	
	            	if(isset($like)) // le ha dado like al look
					{
						$entro=1;
						?>
							<button id="meEncanta<?php echo $look->id; ?>" onclick='encantar(<?php echo $look->id; ?>)' title="Me encanta" class="btn-link btn-link-active">
								<span id="like<?php echo $look->id; ?>" class="entypo icon_personaling_big">&hearts;</span>
							</button>
	               		<?php	
						
					}
						
						if($entro==0) // no le ha dado like
						{
							echo "<button id='meEncanta".$look->id."' onclick='encantar(".$look->id.")' title='Me encanta' class='btn-link'>
	               			<span id='like".$look->id."' class='entypo icon_personaling_big'>&#9825;</span>
	               			</button>";
						}
	
	               	?>
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
                  <!-- <span class="label label-important">Promoción</span>  --></article>
              </div>
              <?php	?>
            <!--     <div class="item">
                <div class="row">
                  <article class="span4">
                    <?php $image = CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id)), "Look", array("width" => "370", "height" => "400", 'class'=>'img_1')); ?>
                    <?php echo CHtml::link($image,array('look/view', 'id'=>$look->id)); ?> 
                  
              	<a href="Look_seleccionado.php" title="look"> 
              	<img src="http://placehold.it/370x400"/>
              	
              </a>
             
                    <div class="margin_top_small">
                      <p class="pull-right margin_top_small margin_right_small"><?php echo $look->title; ?> Recomendado por: <?php echo $look->user->profile->first_name; ?></p>
                    </div>
                  </article>
                </div>
              </div> -->
              <?php
				}		
			 ?>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- Carousel nav --> 
    <a class="carousel-control left margin_top_small bx-prev" href="#myCarousel" data-slide="prev">&lsaquo;</a> <a class="carousel-control right margin_top_small bx-next" href="#myCarousel" data-slide="next">&rsaquo;</a> </div>
</div>
<?php

	} // si tiene mas de 3 haga el carrusel
	else
	{
	?>
	
	<div class=" margin_top">
  		<div class="row margin_bottom_large">
    		<div class="span12">
      			<h1>Looks que te encantan</h1>
      
      			<div id="carousel_looks_recomendados" class="carousel slide margin_top ">
        			<div class="row">
        				
        				<?php
        				if($cantidad==2)
							echo '<div class="offset2">';
						
						if($cantidad==1)
							echo '<div class="offset4">';
						
        				?>
        				
						
								
				        <?php
							foreach($looks as $uno) {
								$look = Look::model()->findByPk($uno->look_id);
						?>
						
              	<div class="span4">
                <article class="item" >
		            <?php $image = CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id)), "Look", array("width" => "370", "height" => "400", 'class'=>'')); ?>
		          	<?php echo CHtml::link($image,$look->getUrl()); ?>
		                <div class="hidden-phone margin_top_small vcard row-fluid">
		                  	<div class="span2 avatar "><img src="../../images/avatar_sample1.jpg" class="photo  img-circle" width="40"></div>
		                    <div class="span5"> <span class="muted">Look creado por: </span>
		                    	<h5><a class="url" title="profile" href="#"><span class="fn">
		                        	<?php //echo $look->title; ?>
		                        	<?php echo $look->user->profile->first_name; ?> </span></a></h5>
		                    </div>
		                    <div class="span5"><span class="precio">Bs. <?php echo $look->getPrecio(); ?></span></div>
		                </div>
		                  
		       		<div class="share_like">
                   
	                    <?php
		            	$entro = 0;
						
						$like = LookEncantan::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'look_id'=>$look->id));
		            	
		            	if(isset($like)) // le ha dado like al look
						{
							$entro=1;
							?>
								<button id="meEncanta<?php echo $look->id; ?>" onclick='encantar(<?php echo $look->id; ?>)' title="Me encanta" class="btn-link btn-link-active">
									<span id="like<?php echo $look->id; ?>" class="entypo icon_personaling_big">&hearts;</span>
								</button>
		               		<?php	
							
						}
							
							if($entro==0) // no le ha dado like
							{
								echo "<button id='meEncanta".$look->id."' onclick='encantar(".$look->id.")' title='Me encanta' class='btn-link'>
		               			<span id='like".$look->id."' class='entypo icon_personaling_big'>&#9825;</span>
		               			</button>";
							}
		
		               	?>
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
              <?php
				}		
			 ?>
						
							
							
						</div>	
					</div>	
				</div>
			</div>
		</div>
	</div>			
	<?php	
	}

?>
</div>
<hr/>
</div>

<script>
	
   	function encantar(id)
   	{
   		var idLook = id;
   		//alert("id:"+idLook);		
   		
   		$.ajax({
	        type: "post",
	        url: "<?php echo Yii::app()->baseUrl;?>/look/encantar", // action encantar de looks 
	        data: { 'idLook':idLook}, 
	        success: function (data) {
				
				if(data=="ok")
				{					
					var a = "♥";
					
					//$("#meEncanta").removeClass("btn-link");
					$("#meEncanta"+id).addClass("btn-link-active");
					$("span#like"+id).text(a);
							
				}
				
				if(data=="no")
				{
					alert("Debe primero ingresar como usuario");
					//window.location="../../user/login";
				}
				
				if(data=="borrado")
				{
					var a = "♡";
					
					//alert("borrando");
					
					$("#meEncanta"+id).removeClass("btn-link-active");
					$("span#like"+id).text(a);
					
				}
					
	       	}//success
	       })
   		
   		
   	}
	
	
</script>
