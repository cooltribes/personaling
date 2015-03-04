<?php

echo"<tr>";

	$validacion=false;
	#echo "<td><input name='check' type='checkbox' id='".$data->id."' /></td>";
	$decode = json_decode($data->data, true);
	
	if($decode = json_decode($data->data, true))
	{
		$look_id=$decode['look_id'];
		$referenciado_id=$decode['ps_id'];
		$validacion=true;
	}
	else
	{
		$validacion2=false;
	}
	

	if($validacion==true && $look_id!=0) 
	{
		$model=Look::model()->findByPk($look_id);

	
	$navegador=$data->getBrowser($data->HTTP_USER_AGENT);
	
	#echo "<td>".$data->id."</td>";  //id del look
	echo "<td>".$look_id."</td>";  //id del look
	echo "<td>".$model->title."</td>"; // nombre del look	

	
	
	if($referenciado_id!="0")
	{
		#$referenciado_id=(string)(int)$referenciado_id;	
		echo "<td>".$referenciado_id."</td>"; // id del referenciado
		$modelado=Profile::model()->findByAttributes( array('user_id'=>$referenciado_id));
		echo "<td>".$modelado->first_name." ".$modelado->last_name."</td>"; //nombre del referenciado
	}
		
	else 
	{
		echo "<td>No fue referenciado</td>";	// no fue referenciado
		echo "<td>No fue referenciado</td>"; // no fue referenciado
	}
	
	if($data->user_id==0)
	{
		echo "<td>Usuario No Registrado</td>";	// no fue referenciado
		echo "<td>Usuario No Registrado</td>"; // no fue referenciado
	}
	else
	{
		echo "<td>".$data->user_id."</td>";
		$visitor=Profile::model()->findByAttributes( array('user_id'=>$data->user_id));
		echo "<td>".$visitor->first_name." ".$visitor->last_name."</td>"; //nombre del referenciado
	}
	
	
	echo "<td>".$data->REMOTE_ADDR."</td>"; //direccion IP
	echo "<td>".$navegador."</td>"; //navegador
	echo "<td>".$data->created_on."</td>"; //navegador
	if($data->HTTP_REFERER=="AJAX")
	{
		echo "<td>Provino desde Pagina no localizada</td>"; 
	}
	else 
	{
		echo "<td>".$data->HTTP_REFERER."</td>";
	}
	}

	

/*echo"<tr>";

	#echo "<td><input name='check' type='checkbox' id='".$data->id."' /></td>";
	$decode = json_decode($data->data, true);
	
	$look_id=$decode['look_id'];
	$referenciado_id=$decode['ps_id'];

	
	$model=Look::model()->findByPk($look_id);
	
	$navegador=ShoppingMetric::getBrowser($data->HTTP_USER_AGENT);
	
	
   	echo "<td>".$look_id."</td>";  //id del look
	echo "<td>".$model->title."</td>"; // nombre del look
	if($referenciado_id!="0")
	{
		#$referenciado_id=(string)(int)$referenciado_id;	
		echo "<td>".$referenciado_id."</td>"; // id del referenciado
		$modelado=Profile::model()->findByAttributes( array('user_id'=>$referenciado_id));
		echo "<td>".$modelado->first_name." ".$modelado->last_name."</td>"; //nombre del referenciado
	}
		
	else 
	{
		echo "<td>No fue referenciado</td>";	// no fue referenciado
		echo "<td>No fue referenciado</td>"; // no fue referenciado
	}
	
	if($data->user_id==0)
	{
		echo "<td>Usuario No Registrado</td>";	// no fue referenciado
		echo "<td>Usuario No Registrado</td>"; // no fue referenciado
	}
	else
	{
		echo "<td>".$data->user_id."</td>";
		$visitor=Profile::model()->findByAttributes( array('user_id'=>$data->user_id));
		echo "<td>".$visitor->first_name." ".$visitor->last_name."</td>"; //nombre del referenciado
	}
	
	
	echo "<td>".$data->REMOTE_ADDR."</td>"; //direccion IP
	echo "<td>".$navegador."</td>"; //navegador
	echo "<td>".$data->created_on."</td>"; //navegador
	if($data->HTTP_REFERER=="AJAX")
	{
		echo "<td>Provino desde Pagina no localizada</td>"; 
	}
	else 
	{
		echo "<td>".$data->HTTP_REFERER."</td>";
	}*/
	
