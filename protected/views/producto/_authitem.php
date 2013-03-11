<?php

   	$r="";

echo"<tr>";
	echo "<td><input name='check' type='checkbox' id='".$data->id."' /></td>";
   	echo "<td>".$data->nombre."</td>";
   	echo "<td>".$data->codigo."</td>";
	
	foreach ($data->categorias as $categ) {
		
			$cat = Categoria::model()->findByPk($categ->id);
		
   	echo "<td>".$cat->nombre."</td>"; // categoria
	$r=1;
	}
	
	if($r!=1)
   		echo "<td></td>"; // categoria

   	
   	foreach ($data->precios as $precio) {
   	echo "<td>".$precio->precioDescuento."</td>"; // precio
	$r=1;
	}
	
	if($r!=1)
		echo "<td></td>"; // precio
	
	//$inv = Inventario::model()->findByAttributes(array('tbl_producto_id' => $data->id));

	if($data->inventario)
	{
		echo "<td>".$data->inventario->cantidad."</td>"; // total
		echo "<td>".$data->inventario->disponibilidad."</td>"; // disp
	}
	else {
		echo "<td></td>"; // total
		echo "<td></td>"; // disp
	}

   	echo "<td></td>"; // vendido
   	echo "<td></td>"; // ventas bs
   	
   if($data->estado==0)
		echo "<td> Activo </td>";
   else {
      	echo "<td> Inactivo </td>";
   }	
	echo "<td>".date("d/m/Y",strtotime($data->fecha))."</td>";
	
	$a = $data->fFin;
	$b = date("d/m/Y",strtotime($a));
	$c = $data->fInicio;
	$d = date("d/m/Y",strtotime($c));
	$e = date("d/m/Y"); // hoy

	if($a!='0000-00-00 00:00:00' && $c!='0000-00-00 00:00:00')
	{
	
		$trans = compara_fechas($e, $d);
		$falt = compara_fechas($b, $e);
		$total = compara_fechas($b, $d);
			
		if($falt <= 0)
		{
			echo "      <td> Finaliza en: ".$b." ";
			$this->widget('bootstrap.widgets.TbProgress', array(
			    'type'=>'danger', // 'info', 'success' or 'danger'
			    'percent'=>100,
			));
			echo "</td>";
		}
		else 
		{
			if($total ==0)
				$total = 1;
				
			$porc = ($trans * 100) / $total;
	
			echo "      <td> Finaliza en: ".$b." ";
			$this->widget('bootstrap.widgets.TbProgress', array(
			    'type'=>'danger', // 'info', 'success' or 'danger'
			    'percent'=>$porc,
			));
			echo "</td>";
		}
	}else
		{
			echo "<td> Sin rango de fechas.</td>";
		}	

	echo "<td>";

	/*
	echo CHtml::ajaxLink("<i class='icon-eye-open'></i>","detalles/".$data->id,array(
	"success"=>"function(data)
				{
					console.log(data);
					
					$('#myModal').html(data);
					$('#myModal').modal();
					
				}"));
	 * */
	 
echo CHtml::link("<i class='icon-eye-open'></i>",
    $this->createUrl('producto/detalles',array('id'=>$data->id)),
    array(// for htmlOptions
      'onclick'=>' {'.CHtml::ajax( array(
      'url'=>CController::createUrl('producto/detalles',array('id'=>$data->id)),
          // 'beforeSend'=>'js:function(){if(confirm("Are you sure you want to delete?"))return true;else return false;}',
           'success'=>"js:function(data){ $('#myModal').html(data);
					$('#myModal').modal(); }")).
         'return false;}',// returning false prevents the default navigation to another url on a new page 
   // 'class'=>'delete-icon',
    'id'=>'link'.$data->id)
);		

	echo "</td>";
  // 	echo "<td><a href='#myModal' role='button' class='btn btn-mini' data-toggle='modal'><i class='icon-eye-open'></i></a></td>";
	
echo"</tr>";


?>