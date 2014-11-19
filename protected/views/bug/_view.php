<?php

$ima ='';

echo"<tr>";
	
   	echo "<td>".$data->name."</td>";
	echo "<td>".$data->description."</td>";
	echo "<td>".$data->url."</td>";
	if($data->estado==0)
	{
		echo "<td>No solucionado</td>";
	}
	else 
	{
		if($data->estado==1)
		{
			echo "<td>solucionado</td>";
		}
		
	}
	
	
	
	echo "<td>".$data->date."</td>";
	echo "<td> detalles</td>";
	/*echo "<td>".$data->title."</td>";
	echo "<td>".$data->description."</td>";
	echo "<td>".$data->keywords."</td>";
	echo "<td>".$data->url."</td>";
	
	echo '<td>
		<a href="create/'.$data->id.'" class="btn btn-mini" ><i class="icon-cog"></i></a>
		<a href="delete/'.$data->id.'" class="btn btn-mini" ><i class="icon-trash"></i></a>
	</td>';*/
	
echo"</tr>";

?>