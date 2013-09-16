<?php 
	echo "<tr>";
	echo "<td>".CHtml::image(Producto::model()->getImageUrl($data['url']), "Imagen", array("width" => "70", "height" => "70"))."</td>";
	echo "<td>".$data['Nombre']."</td>";
	echo "<td>".$data['Marca']."</td>";
	echo "<td>".$data['Color']."</td>";
	echo "<td>".$data['Talla']."</td>";
	echo "<td>".$data['precioDescuento']."</td>";
	echo "<td>".$data['cantidad']."</td>";
	echo "<td><input type='number' id='".$data['ptcid']."' value='0' class='input-mini cant' max='999' min='0' required='required' /></td></th>";

	?>
