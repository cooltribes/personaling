<?php 
echo "REPORTE";
$n=0;
foreach($dataProvider->getData() as $data){
	$n++;	
	foreach($data->ohptc as $ptc){
		echo $n." ".$ptc->preciotallacolor_id." ".$ptc->cantidad."<br/>";
	}
} ?>  
