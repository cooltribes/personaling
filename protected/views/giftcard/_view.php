<tr>
    <td>
        <input name="check" type="checkbox" value="">
    </td>
    <td>
        <?php echo $data->id; ?>
    </td>
    <td>
       <h5 class="no_margin_bottom no_margin_top"> <?php echo $data->UserComprador->profile->first_name.
                ' '.$data->UserComprador->profile->last_name; ?></h5>
        <small>
            <?php if($data->UserComprador->superuser){
                echo "Administrador";
            } ?>
        </small>
       
    </td>
    <td>
        <?php  
            if($data->estado == 1){
                echo "Inactiva"; 
            }else if($data->estado == 1){
                echo "Activa"; 
            }else if($data->estado == 1){
                echo "Aplicada"; 
            }
            
            
        ?> 
    </td>
    <td>
        <?php echo $data->monto; ?>
    </td>
    <td>
        <?php echo date("d/m/Y", $data->getInicioVigencia()); ?>
    </td>
    <td>
        <?php echo date("d/m/Y", $data->getFinVigencia()); ?>
    </td>
    <td>
        <?php echo $data->fecha_uso ? date("d/m/Y", $data->getFechaUso()) : "No Aplicada"; ?>
    </td>    
    <td>

        <i class = "icon-eye-open"></i>
        <?php
        
//        echo CHtml::link("<i class='icon-eye-open'></i>", $this->createUrl('#', array('id' => $data->id)), array(// for htmlOptions
//            'onclick' => ' {' . CHtml::ajax(array(
//                'url' => CController::createUrl('look/detalle', array('id' => $data->id)),
//                // 'beforeSend'=>'js:function(){if(confirm("Are you sure you want to delete?"))return true;else return false;}',
//                'success' => "js:function(data){
//           		
//           	 $('#myModal').html(data);
//					$('#myModal').modal(); }")) .
//            'return false;}', // returning false prevents the default navigation to another url on a new page 
//            // 'class'=>'delete-icon',
//            'id' => 'link' . $data->id
//            )
//        );
//        ?>
    </td>
</tr> 