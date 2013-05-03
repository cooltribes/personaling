<?php

	$colores = Color::model()->findAll();		
	
	foreach ($colores as $color ) {			
		echo CHtml::image(Yii::app()->baseUrl ."/images/colores/". $color->path_image, "".$color->valor,
		array('class'=>'color','id'=>$color->id,'name'=>'color','style'=>'cursor:pointer'));

	}
 ?>