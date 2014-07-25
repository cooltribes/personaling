<tr style="display:table-row">	
    <td><?php 
    
        echo "<b>".$data->step.".-</b> ";
        switch ($data->step){
            case 0:
                echo "Viendo el carrito"; 
                break;
            case 1:
                echo "Autenticación";  
                break;
            case 2:
                echo "Escogiendo dirección"; 
                break;
            case 3:
                echo "Escogiendo método de pago"; 
                break;
            case 4: 
                echo "Confirmando la compra"; 
                break;
            case 5: 
                echo "Viendo resumen del pedido"; 
                break;
            case 101: 
                echo "Tienda de productos"; 
                break;
            default: //5 
                echo "No definido"; 
        }
    
    
    ?></td>
    <td><?php echo "<strong>".date("d/m/Y",strtotime($data->created_on)).
            "    </strong><br/>".date("H:i:s",strtotime($data->created_on))?></td>
    <?php if($data->REMOTE_ADDR==$data->HTTP_X_FORWARDED_FOR) { ?>
    	<td title="<?php echo $data->REMOTE_ADDR;?>"><?php echo $data->getShow('REMOTE_ADDR'); ?></td>
   <?php }else{ ?>
    		<td><b><span title="<?php echo $data->REMOTE_ADDR;?>"><?php echo $data->getShow('REMOTE_ADDR'); ?></span></b>
    			<span title="<?php echo $data->HTTP_X_FORWARDED_FOR;?>"><?php echo $data->getShow('HTTP_X_FORWARDED_FOR'); ?></span>
    		</td>
  <?php  }?>
    
    
    <td title="<?php echo $data->HTTP_REFERER;?>" width="100"><?php echo $data->getShow('HTTP_REFERER'); ?></td>
    <td title="<?php echo $data->HTTP_USER_AGENT;?>"><?php echo $data->getShow('HTTP_USER_AGENT'); ?></td>
    <td><?php echo ($data->data); ?></td>
</tr>