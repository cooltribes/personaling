<?php
$producto = Producto::model()->findByPk($data->producto_id);
?>
<tr>
	<td><?php echo CHtml::image($producto->getImageUrl(), $producto->nombre); ?></td>
	<td><strong><?php echo $producto->nombre; ?></strong>
	<br/>SKU: <?php echo $producto->codigo; ?></td>
	<td><?php foreach($producto->categorias as $una){
			echo $una->nombre.", ";
	} ?></td>
	<td><?php echo CHtml::link('<i class="icon-eye-open"></i>', $producto->getUrl(), array('title'=>'Ver', 'class'=>'btn', 'target'=>'_blank')); ?></td>
</tr>