<script>$(document).ready(function() {
  // Handler for .ready() called.
  
	var imag;
	var original;
	var segunda;
	var val;
	
	
	/*$('.ctgr').click(function(){
			
			//val=$('input#idact').val()+'#'+$(this).attr('id');
			
			
			$('input#idact').val($(this).attr('id'));
			alert($('input#idact').val());	
		
			
			
		
	
		});*/});
	</script> 
<form id="form1" name="form1">
  <input type="hidden" id="idact" >       
</form> 

<ul class="thumbnails">
              <?php foreach($categorias as $categoria){ ?>
              <li class="span1 seleccionable" > 
              		<?php
              		
              		$a = $categoria->getImage($categoria->id);
              		
              		if($a!="no")// tiene img
              			$image = CHtml::image(Yii::app()->baseUrl . $a, "categoria", array('id'=>'img-categoria'));
					else
              			$image = CHtml::image("http://placehold.it/140");

					//echo CHtml::link($image, array('items/viewslug', 'slug'=>$data->slug));
					echo CHtml::ajaxLink(
						  $image,
						  Yii::app()->createUrl('tienda/categorias2'),
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
						                   		
						                   	
						                   		ajaxRequest = $('#idact').val();
						                   
						                   	
												$.fn.yiiListView.update(
													'list-auth-items',
													{
													type: 'POST',	
													url: '" . CController::createUrl('tienda/colores2') . "',
													data: {'idact':ajaxRequest}
													}													
												)	                   	
						                   								                   	
						                   }else if(data.accion == 'hijo')
						                   {
						                   			
						                   	
						                   		ajaxRequest = $('#idact').val();
						                   	
												$.fn.yiiListView.update(
													'list-auth-items',
													{
													type: 'POST',	
													url: '" . CController::createUrl('tienda/colores2') . "',
													data: {'idact':ajaxRequest}
													}													
												)	                   	
											
						                   }	
						                  }",
						    'data' => array( 'padreId' => $categoria->id, 'val2' => '2' )
						  ),
						  array( //htmlOptions
						    'href' => Yii::app()->createUrl( 'tienda/categorias2' ),
						    'class' => 'ctgr',
						    'id' => 'categoria'.$categoria->id,
						  )
						);
					?>
                	<div class="caption">
                  		<p><?php echo $categoria->nombre; ?></p>
	                </div>

              </li>
              <?php } ?>
</ul>    
<script >
$('.seleccionable').click(function(){		
	if(!$(this).hasClass('selected')){			
		$(this).addClass('selected');
		$(this).css({'outline': '2px groove #6d2d56'});
	}
	else{
		$(this).css({'outline': 0});
		$(this).removeClass('selected');
	} 		
	$('.seleccionable').click(false);
});
</script>


                