<div class="row-fluid">
<?php
					echo CHtml::ajaxLink(
						  'Atras',
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
						    'data' => array( 'padreId' => $categoria_padre, 'val2' => '2' )
						  ),
						  array( //htmlOptions
						    'href' => Yii::app()->createUrl( 'look/categorias' ),
						    'class' => 'thumbnail',
						    'id' => 'categoria'.$categoria_padre,
						    'draggable'=>"false",
						  )
						);
					?>	
	<ul class="thumbnails">
              <?php
              foreach($categorias as $categoria){
              ?>
              <li class="span6" draggable="false" > 
              	<div>
              		
              		
              		<?php
              		$a = $categoria->getImage($categoria->id);
              		
              		if($a!="no")// tiene img
              			$image = CHtml::image(Yii::app()->baseUrl . $a, "categoria", array('id'=>'img-categoria'));
					else
              			$image = CHtml::image("http://placehold.it/140");

					//echo CHtml::link($image, array('items/viewslug', 'slug'=>$data->slug));
					$gif_url = '"'.Yii::app()->baseUrl.'/images/loading.gif"';
					echo CHtml::ajaxLink(
						  $image,
						  Yii::app()->createUrl( 'look/categorias'),
						  array( // ajaxOptions
						    'type' => 'POST',
						    'beforeSend' => "function( request )
						                     {
						                       // Set up any pre-sending stuff like initializing progress indicators
						                       $('#div_categorias').css('background','white url(".$gif_url.") center center no-repeat');
						                       //alert('white url(".$gif_url.") center center no-repeat');
						                     }",
						    'success' => "function( data )
						                  {
						                    // handle return data
						                    //alert( data );
						                    $('#div_categorias').html(data);
						                    setTimeout(function() {
											    $('#div_categorias').css('background','white');
											}, 1);
						                     
						                  }",
						    'data' => array( 'padreId' => $categoria->id, 'val2' => '2' )
						  ),
						  array( //htmlOptions
						    'href' => Yii::app()->createUrl( 'look/categorias' ),
						    'class' => 'thumbnail',
						    'id' => 'categoria'.$categoria->id,
						    'draggable'=>"false",
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
</div>     
         