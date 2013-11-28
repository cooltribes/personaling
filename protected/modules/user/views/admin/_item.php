<?php 
	echo "<tr>";
	//echo "<td>".CHtml::image(Producto::model()->getImageUrl($data['url']), "Imagen", array("width" => "70", "height" => "70"))."</td>";
	//echo "<td>".$data['url']."</td>";
	$ima = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$data['id']),array('order'=>'orden ASC'));
	if(sizeof($ima)==0)
		echo "<td align='center'>".CHtml::image('http://placehold.it/50x50', "producto", array('id'=>'principal','rel'=>'image_src','width'=>'50px'))."</td>";
	else
		echo "<td align='center'>".CHtml::image($ima[0]->getUrl(array('ext'=>'png')), "producto", array('id'=>'principal','rel'=>'image_src','width'=>'50px'))."</td>";
	
	echo "<td>".$data['Nombre']."</td>";
	echo "<td>".$data['Marca']."</td>";
	echo "<td>".$data['Color']."</td>";
	echo "<td>".$data['Talla']."</td>";
	echo "<td>".$data['precioDescuento']."</td>";
	echo "<td>".$data['cantidad']."</td>";
	echo "<td><input type='number' id='".$data['ptcid']."' value='0' class='input-mini cant' max='".$data['cantidad']."'  min='0' required='required' /></td></th>";

	?>
