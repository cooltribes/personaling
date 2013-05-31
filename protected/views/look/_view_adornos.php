<ul class="thumbnails">
              <?php
              foreach($productos as $producto){

				

					
              ?>
              <li class="span2" > 
              	<div class=" column" draggable="true" id="div_adorno<?php echo $producto->id; ?>">
              		<div class="new" id="adorno<?php echo $producto->id; ?>">
              		
              		<?php

					echo CHtml::image($producto->getImageUrl(), "Imagen", array("width" => "180", "height" => "180"));

					?> 

 	                
	                <input type="hidden" name="adorno_id" value="<?php echo $producto->id; ?>">
	               
	               </div>
              	</div>
              	<?php
              	$script = "element = document.querySelector('#div_adorno".$producto->id."');
              	  element.addEventListener('dragstart', handleDragStart, false);
  					element.addEventListener('dragover', handleDragOver, false);
				  element.addEventListener('dragend', handleDragEnd, false); ";
              	Yii::app()->clientScript->registerScript('drag_adorno'.$producto->id,$script);
              	?>              	
              </li>
              <?php } 
				
				
			
				?>
</ul>              