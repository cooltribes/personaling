<?php
$look = Look::model()->findByPk($data->look_id);
?>
<tr>
	<td>
		<?php echo CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$look->id)), "Look", array("width" => "70", "height" => "70", 'class'=>'img-polaroid')); ?>
	</td>
	<td><strong> <span class="CAPS"><?php echo $look->title; ?></span></strong><br>
		<strong>ID</strong>: <?php echo $look->id; ?></td>
	<td><strong>P.S.</strong>: <?php echo $look->user->profile->first_name; ?><br>
		<strong>Nro. Items</strong>: <?php echo $look->countItems(); ?><br>
		<strong>Marcas</strong>: Mango, Suite Blanco, Aldo, Accessorize y Desigual </td>
	<td>
		<?php 
		//echo CHtml::link('<i class="icon-eye-open"></i>', CController::createUrl('/look/detalles',array('id'=>$look->id)), array('title'=>'Ver', 'class'=>'btn', 'target'=>'_blank'));
		echo CHtml::link("<i class='icon-eye-open'></i>",
		    $this->createUrl('/look/detalle',array('id'=>$look->id)),
		    array(// for htmlOptions
		      'onclick'=>' {'.CHtml::ajax( array(
		      'url'=>CController::createUrl('/look/detalle',array('id'=>$look->id)),
		          // 'beforeSend'=>'js:function(){if(confirm("Are you sure you want to delete?"))return true;else return false;}',
		           'success'=>"js:function(data){
		           		
		           	 $('#myModal').html(data);
							$('#myModal').modal(); }")).
		         'return false;}',// returning false prevents the default navigation to another url on a new page 
		   // 'class'=>'delete-icon',
		    'id'=>'link'.$look->id)
		);	
		?>
	</td>
</tr>