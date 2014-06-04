<?php
if (isset($categoria_padre) ){
	echo CHtml::ajaxLink(
		'Atrás',
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
			'class' => 'thumbnail btn btn-block',
			'id' => 'categoria'.$categoria_padre,
			'draggable'=>"false",
		)
	);
}
?>	
<div class="row-fluid"><ul class="thumbnails">
	<?php
	foreach($productos as $producto){
		/*
		$tallacolores=Preciotallacolor::model()->findAll(array(
		'condition'=>'producto_id=:producto_id AND cantidad >= :cantidad',
		'params'=>array(':cantidad'=>1, ':producto_id'=>$producto->id),
		));
		* 
		*/

		if ($producto->getPrecio(false)!=0 && $producto->mainimage){
			if(isset($color) && $color != ''){
				$tallacolores=Preciotallacolor::model()->findAllBySql(
					'SELECT * FROM tbl_precioTallaColor WHERE producto_id=:producto_id AND cantidad >= :cantidad AND color_id=:color_id GROUP BY color_id',
					array(':cantidad'=>1, ':producto_id'=>$producto->id, ':color_id'=>$color)
				);
			}else{
				$tallacolores=Preciotallacolor::model()->findAllBySql(
					'SELECT * FROM tbl_precioTallaColor WHERE producto_id=:producto_id AND cantidad >= :cantidad GROUP BY color_id',
					array(':cantidad'=>1, ':producto_id'=>$producto->id)
				);
			}
			foreach($tallacolores as $tallacolor){
				$imagecolor = $producto->colorimage( array('condition'=>'color_id=:color_id','params' => array(':color_id'=>$tallacolor->color_id) ) ); 
				if(isset($imagecolor)){
					if ( $producto->getImageUrl($tallacolor->color_id)!="http://placehold.it/180"){
						?>
						<li class="span6" > 
							<div class=" column" draggable="true" id="div_producto<?php echo $producto->id."_".$tallacolor->color_id; ?>">
								<div class="new" id="div<?php echo $producto->id."_".$tallacolor->color_id; ?>">

									<?php
									/*
									echo $tallacolor->color_id;
									$imagecolor = $producto->colorimage( array('condition'=>'color_id=:color_id','params' => array(':color_id'=>$tallacolor->color_id) ) ); 
									//print_r($imagencolor);
									//foreach ($producto->colorimage as $colorimage){
									//	echo $colorimage->url;
									//}
									if ( isset( $imagecolor) )
									$image = CHtml::image(Yii::app()->baseUrl . $imagecolor->url, "Imagen", array("width" => "180", "height" => "180"));
									elseif ($producto->mainimage) 
									$image = CHtml::image(Yii::app()->baseUrl . $producto->mainimage->url, "Imagen", array("width" => "180", "height" => "180"));
									else
									$image = CHtml::image("http://placehold.it/180");
									* */

									//echo $image;
									
									
									echo CHtml::image($producto->getImageUrl($tallacolor->color_id), "Imagen", array("width" => "180", "height" => "180"));
									//echo CHtml::image(Yii::app()->createUrl('site/productoImagen',array('producto'=>$producto->id,'color'=>$tallacolor->color_id,'h'=>180,'w'=>180)), "Imagen", array("width" => "180", "height" => "180"));
									
									
									//echo $tallacolor->color_id;
									//echo $producto->id;
									//echo CHtml::link($image, array('items/viewslug', 'slug'=>$data->slug));
									/*
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
									'id' => 'producto'.$producto->id."_".$tallacolor->color_id,
									)
									);
									*/
									?> 


									<input type="hidden" name="producto_id" value="<?php echo $producto->id; ?>">
									<input type="hidden" name="color_id" value="<?php echo $tallacolor->color_id; ?>">
								</div>
							</div>
							<?php
							$script = "element = document.querySelector('#div_producto".$producto->id."_".$tallacolor->color_id."');
										element.addEventListener('dragstart', handleDragStart, false);
										element.addEventListener('dragover', handleDragOver, false);


										element.addEventListener('dragend', handleDragEnd, false);
							";
							Yii::app()->clientScript->registerScript('drag'.$producto->id."_".$tallacolor->color_id,$script);
							?>              	
						</li>
						<?php 
					} // if
				} // if isset image color (no mostrar color si no tiene imagen)
			} //foreach
		} // if
	} // foreach
	?>
	</ul>              
</div>