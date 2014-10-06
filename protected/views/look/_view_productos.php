<?php
if ($page==1){
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
<div class="row-fluid">
    <ul class="thumbnails" id="ul_productos">
<?php } ?>
	<?php
    $space = isset($space)?$space:0;
	foreach($productos as $producto){
		if ($producto->getPrecio(false)!=0 && $producto->mainimage){
			if(isset($color) && $color != ''){
				//condicion base, el color seleccionado
				$condition = 'color_id='.$color;
				// busco si tiene colores hijos para incluirlos en la búsqueda
				$colores_hijos = Color::model()->findAllByAttributes(array('padreID'=>$color));
				if(sizeof($colores_hijos) > 0){
					foreach ($colores_hijos as $hijo) {
						$condition .= ' OR color_id='.$hijo->id;
					}
				}
				$tallacolores=Preciotallacolor::model()->findAllBySql(
					'SELECT * FROM tbl_precioTallaColor WHERE producto_id=:producto_id AND cantidad >= :cantidad AND '.$condition.' GROUP BY color_id',
					array(':cantidad'=>1, ':producto_id'=>$producto->id)
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
							if($space%3==0 && $space!=0)
			              		echo '<li class="span4 no_margin_left"  >';
			              	else
								echo '<li class="span4" > ';
						?>
							<div class=" column" draggable="true" id="div_producto<?php echo $producto->id."_".$tallacolor->color_id; ?>">
								<div class="new" id="pro<?php echo $producto->id."_".$tallacolor->color_id; ?>">
									<?php echo CHtml::image($producto->getThumbUrl($tallacolor->color_id,"png"), "Personaling - ".$producto->nombre, array("width" => "180", "height" => "180")); ?>
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
							Yii::app()->clientScript->registerScript('drag_list'.$producto->id."_".$tallacolor->color_id,$script);
							?>              	
						</li>
						<?php 
						$space++;
					} // if
				} // if isset image color (no mostrar color si no tiene imagen)
			} //foreach
		} // if
	} // foreach
	?>
<?php if ($page==1){   ?>
	</ul>              
</div>
<?php }


if (isset($categoria) && $page<=$pages){
    echo "<script>";
    echo CHtml::ajax(array(
    'id'=>'load_pages'.$page,
    'type'=>'POST',
    'url'=>Yii::app()->createUrl( 'look/categorias'),
    'success' => "function( data )
          {
            $('#ul_productos').append(data);
          }",
        'data' => array( 'padreId' => $categoria, 'page'=>$page+1,'marcas'=>$marcas,'colores'=>$colores,'space'=>$space ),

    ));
echo "</script>";
}
?>

