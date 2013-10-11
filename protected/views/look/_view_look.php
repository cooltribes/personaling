        <tr>
            <td><input name="check" type="checkbox" value=""></td>
            <td width="20%"><strong> <span class="CAPS"><?php echo $data->title; ?></span></strong><br/>
                <strong>ID</strong>: <?php echo $data->id; ?><br/>
                <strong>Nro. Items</strong>: <?php echo $data->countItems(); ?></td>
            <td><strong>P.S.</strong>: <?php echo $data->user->profile->first_name; ?><br/>
                <strong>Marcas</strong>: <?php
          		
					$ids=Yii::app()->db->createCommand('select distinct(marca_id) from tbl_producto where id IN (select producto_id from tbl_look_has_producto where look_id ='.$data->id.' )')->queryColumn();
					$c=0;
					foreach($ids as $id){
						echo " ".Marca::model()->getMarca($id);
						
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
            <td> Finaliza en: 
                <div class="progress margin_top_small  progress-danger">
                    <div class="bar" style="width: 78%"></div>
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