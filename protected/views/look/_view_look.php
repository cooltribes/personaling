        <tr>
            <td><input name="check" type="checkbox" value=""></td>
            <td width="20%"><strong> <span class="CAPS"><?php echo $data->title; ?></span></strong><br/>
                <strong>ID</strong>: <?php echo $data->id; ?><br/>
                <strong>Nro. Items</strong>: <?php echo $data->countItems(); ?></td>
            <td><strong>P.S.</strong>: <?php echo $data->user->profile->first_name; ?><br/>
                <strong>Marcas</strong>: <?php
          			$ids=$data->getMarcas();
					$c=0;
					foreach($ids as $id){
						echo " ".$id->nombre;						
						if($c<count($ids)-1)
							echo ", ";
						else echo ".";$c++;
					}
		         ?>
                </td>
            <td><?php echo $data->getPrecio(); ?></td>
            <td><?php echo $data->getLookxStatus(3); ?></td>
            <td><?php echo $data->getMontoVentas(); ?></td>
            <td><?php echo $data->getStatus(); ?></td>
            <td><?php echo $data->created_on; ?></td>
            <td> <?php $camp=Campana::model()->findByPk($data->campana_id); echo $camp->daysLeft();?>
                <div class="progress margin_top_small  progress-danger">
                    <div class="bar" style="width: <?php echo $camp->getProgress(); ?>%"></div>
                </div></td>
            <td>
            
<?php
            	echo CHtml::link("<i class='icon-eye-open'></i>",
    $this->createUrl('look/detalle',array('id'=>$data->id)),
    array(// for htmlOptions
      'onclick'=>' {'.CHtml::ajax( array(
      'url'=>CController::createUrl('look/detalle',array('id'=>$data->id)),
          // 'beforeSend'=>'js:function(){if(confirm("Are you sure you want to delete?"))return true;else return false;}',
           'success'=>"js:function(data){
           		
           	 $('#myModal').html(data);
					$('#myModal').modal(); }")).
         'return false;}',// returning false prevents the default navigation to another url on a new page 
   // 'class'=>'delete-icon',
    'id'=>'link'.$data->id)
);	
?>
            </td>
        </tr> 