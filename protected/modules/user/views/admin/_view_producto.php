<?php
$producto = Producto::model()->findByPk($data->producto_id);
?>
<tr>
	<td><?php echo CHtml::image($producto->getImageUrl(), $producto->nombre); ?></td>
	<td><strong><?php echo $producto->nombre; ?></strong>
	<br/>SKU: <?php echo $producto->codigo; ?></td>
	<td><?php echo $producto->categorias[0]->nombre; ?></td>
	<td><?php echo CHtml::link('<i class="icon-eye-open"></i>', Yii::app()->baseUrl.'/producto/detalle/'.$producto->id, array('title'=>'Ver', 'class'=>'btn', 'target'=>'_blank')); ?></td>
</tr>