<ul class="thumbnails">
              <?php
              foreach($categorias as $categoria){
              ?>
              <li class="span1" > 
              		<?php
              		$image = CHtml::image("http://placehold.it/140");

					//echo CHtml::link($image, array('items/viewslug', 'slug'=>$data->slug));
					echo CHtml::ajaxLink(
						  $image,
						  Yii::app()->createUrl( 'tienda/categorias'),
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
						                    if(data==2)
						                    {}	
						                    else	
						                    	$('#uno').html(data);
						                  }",
						    'data' => array( 'padreId' => $categoria->id, 'val2' => '2' )
						  ),
						  array( //htmlOptions
						    'href' => Yii::app()->createUrl( 'tienda/categorias' ),
						    //'class' => 'span1',
						    'id' => 'categoria'.$categoria->id,
						  )
						);
					?>
                	<div class="caption">
                  		<p><?php echo $categoria->mTitulo; ?></p>
	                </div>

              </li>
              <?php } ?>
</ul>     
         