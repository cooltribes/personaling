<div class="row-fluid">
<?php
					if ($categoria_padre > 0)
					echo CHtml::ajaxLink(
						  'Atras ', 
						  Yii::app()->createUrl( 'look/categorias'),
						  array( // ajaxOptions
						    'type' => 'POST',
						    'beforeSend' => "function( request )
						                     {
						                       // Set up any pre-sending stuff like initializing progress indicators
						                        $('body').addClass('aplicacion-cargando');
						                     }",
						    'success' => "function( data )
						                  {
						                    // handle return data
						                    //alert( data );
						                    $('#div_categorias').html(data);
						                    $('body').removeClass('aplicacion-cargando');
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
             
              foreach($categorias as $space=>$categoria){
              	if($space%3==0 && $space!=0)
              		echo '<li class="span4" style="margin-left:0px" draggable="false" >';
              	else
					echo '<li class="span4" draggable="false" > ';	 
              ?>
              
    
              	<div>
              		
              		
              		<?php
              		$a = $categoria->getImage($categoria->id);
              		
              		if($a!="no")// tiene img
              			$image = CHtml::image(Yii::app()->baseUrl . $a,"Personaling - ".$categoria->nombre, array('id'=>'img-categoria'));
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
						                       $('body').addClass('aplicacion-cargando');
						                       //alert('white url(".$gif_url.") center center no-repeat');
						                     }",
						    'success' => "function( data )
						                  {
						                    // handle return data
						                    //alert( data );
						                    $('#div_categorias').html(data);
						                    setTimeout(function() {
											    $('#div_categorias').css('background','white');
												$('body').removeClass('aplicacion-cargando');
											}, 100);
						                     
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
         