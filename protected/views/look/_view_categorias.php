<ul class="thumbnails">
              <?php
              foreach($categorias as $categoria){
              ?>
              <li class="span2" > 
              	<div class=" column" draggable="true">
              		
              		
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
						    'data' => array( 'padreId' => $categoria->id, 'val2' => '2' )
						  ),
						  array( //htmlOptions
						    'href' => Yii::app()->createUrl( 'look/categorias' ),
						    'class' => 'thumbnail'
						  )
						);
					?>
                	<div class="caption">
                  		<p><?php echo $categoria->mTitulo; ?></p>
	                </div>
              	</div>
              	
              </li>
              <?php } ?>
</ul>              