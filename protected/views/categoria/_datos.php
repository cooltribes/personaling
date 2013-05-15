<?php
	
	echo("<tr>");
	
	echo("<td>".$data->nombre."</td>");
	
	if($data->padreId!=0){
		$cate = Categoria::model()->findByPk($data->padreId);
		echo("<td>".$cate->nombre."</td>"); // Categoria Padre
	}
	else {
			echo("<td> </td>"); // Categoria Padre	
	}
	
	if($data->estado == 0)
		echo("<td> Activa </td>");
	else if($data->estado == 1)
		echo("<td> Inactiva </td>");
	
	echo("<td>".$data->descripcion."</td>"); // cambiar a descripcion cuando se acomode la BD
	
	echo("<td><a title='editar' href='create/".$data->id."' class='btn'><i class='icon-edit'></i>Editar</a></td>");
	
	echo("</tr>");
?> 