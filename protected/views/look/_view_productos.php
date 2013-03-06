<ul class="thumbnails">
              <?php
              foreach($productos as $producto){
              ?>
              <li class="span2" > 
              	<div class=" column" draggable="true" id="div_producto<?php echo $producto->id; ?>">
              		
              		
              		<?php
              		$image = CHtml::image("http://placehold.it/180");

					//echo CHtml::link($image, array('items/viewslug', 'slug'=>$data->slug));
					echo CHtml::ajaxLink(
						  $image,
						  Yii::app()->createUrl( 'look/categorias'),
						  array( // ajaxOptions
						    'type' => 'POST',
						    'beforeSend' => "function( request )
						                     {
						                       // Set up any pre-sending stuff like initializing progress indicators
						                     }",
						    'success' => "function( data )
						                  {
						                    // handle return data
						                    //alert( data );
						                    $('#div_categorias').html(data);
						                  }",
						    'data' => array( 'padreId' => $producto->id, 'val2' => '2' )
						  ),
						  array( //htmlOptions
						    'href' => Yii::app()->createUrl( 'look/categorias' ),
						    'class' => 'thumbnail',
						    'id' => 'producto'.$producto->id,
						  )
						);
					?>
                	<div class="caption">
                  		<p><?php echo $producto->nombre; ?></p>
	                </div>
              	</div>
              	<?php
              	$script = "element = document.querySelector('#div_producto".$producto->id."');
              	  element.addEventListener('dragstart', handleDragStart, false);
  					element.addEventListener('dragover', handleDragOver, false);
				  element.addEventListener('dragend', handleDragEnd, false); ";
              	Yii::app()->clientScript->registerScript('drag'.$producto->id,$script);
              	?>              	
              </li>
              <?php } ?>
</ul>              