<form id="form1" name="form1">
  <input type="hidden" id="idact" >       
</form> 

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
						    'dataType'=>'json',
						    'beforeSend' => "function( request )
						                     {
						                       // Set up any pre-sending stuff like initializing progress indicators
						                     }",
						    'success' => "function( data )
						                  {

						                   if(data.accion == 'padre')
						                   {
						                   		$('#uno').html(data.div);
						                   		$('input#idact').val(data.id);	
						                   	
						                   		ajaxRequest = $('#idact').val();
						                   	
												$.fn.yiiListView.update(
													'list-auth-items',
													{
													type: 'POST',	
													url: '" . CController::createUrl('tienda/filtrar') . "',
													data: {'idact':ajaxRequest}
													}													
												)	                   	
						                   								                   	
						                   }else if(data.accion == 'hijo')
						                   {
						                   		$('input#idact').val(data.id);	
						                   	
						                   		ajaxRequest = $('#idact').val();
						                   	
												$.fn.yiiListView.update(
													'list-auth-items',
													{
													type: 'POST',	
													url: '" . CController::createUrl('tienda/filtrar') . "',
													data: {'idact':ajaxRequest}
													}													
												)	                   	
											
						                   }	
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
                