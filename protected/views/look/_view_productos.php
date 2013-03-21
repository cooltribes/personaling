<ul class="thumbnails">
              <?php
              foreach($productos as $producto){
              	/*
				$tallacolores=Preciotallacolor::model()->findAll(array(
				    'condition'=>'producto_id=:producto_id AND cantidad >= :cantidad',
				    'params'=>array(':cantidad'=>1, ':producto_id'=>$producto->id),
				));
				 * 
				 */
				$tallacolores=Preciotallacolor::model()->findAllBySql(
				'SELECT * FROM tbl_precioTallaColor WHERE producto_id=:producto_id AND cantidad >= :cantidad GROUP BY color_id',
				array(':cantidad'=>1, ':producto_id'=>$producto->id)
				);
				foreach($tallacolores as $tallacolor){
              ?>
              <li class="span2" > 
              	<div class=" column" draggable="true" id="div_producto<?php echo $producto->id; ?>">
              		
              		
              		<?php
              		
					if ($producto->mainimage)
					$image = CHtml::image(Yii::app()->baseUrl . $producto->mainimage->url, "Imagen", array("width" => "180", "height" => "180"));
					else 
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

 	                
	                <input type="hidden" name="producto_id" value="<?php echo $producto->id; ?>">
	                <input type="hidden" name="color_id" value="<?php echo $tallacolor->color_id; ?>">
              	</div>
              	<?php
              	$script = "element = document.querySelector('#div_producto".$producto->id."');
              	  element.addEventListener('dragstart', handleDragStart, false);
  					element.addEventListener('dragover', handleDragOver, false);
				  element.addEventListener('dragend', handleDragEnd, false); ";
              	Yii::app()->clientScript->registerScript('drag'.$producto->id,$script);
              	?>              	
              </li>
              <?php }
				} 
				?>
</ul>              