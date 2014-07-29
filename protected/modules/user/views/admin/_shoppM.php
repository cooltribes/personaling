<tr style="display:table-row">	
    <td>
        <?php 
        echo "<b>".$data->step.".-</b> ";
        echo $data->getDescripcion();
        ?>
    </td>
    <td>
        <?php echo "<strong>".date("d/m/Y",strtotime($data->created_on)).
            "</strong><br/>".date("H:i:s",strtotime($data->created_on))?>
    </td>
    <?php if($data->REMOTE_ADDR==$data->HTTP_X_FORWARDED_FOR) { ?>
    	<td title="<?php echo $data->REMOTE_ADDR;?>">
            <?php echo $data->getShow('REMOTE_ADDR'); ?>
        </td>
   <?php }else{ ?>
            <td>
                <b><span title="<?php echo $data->REMOTE_ADDR;?>">
                    <?php echo $data->getShow('REMOTE_ADDR'); ?>
                </span></b>
                <span title="<?php echo $data->HTTP_X_FORWARDED_FOR;?>">
                    <?php echo $data->getShow('HTTP_X_FORWARDED_FOR'); ?>
                </span>
            </td>
  <?php  }?>
    <td title="<?php echo $data->HTTP_REFERER;?>" width="100"><?php echo $data->getReferred(); ?></td>
    
    <td title="<?php echo $data->HTTP_USER_AGENT;?>"><?php echo $data->getShow('HTTP_USER_AGENT'); ?></td>
    <td><?php echo $data->getData(); ?></td>
</tr>