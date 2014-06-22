<tr>	
    <!--CAMPO-->
    <td><?php echo $data->getCampo(); ?>
    </td>
    
    <!--ANTERIOR-->
    <td>
        <?php echo $data->valor_anterior;?>
    </td>
    <!--NUEVO-->
    <td>
        <?php echo $data->valor_nuevo;?>       
    </td>
    <!--FECHA-->
    <td>
        <?php echo date("d/m/Y H:i:s",strtotime($data->fecha));?>
    </td>
    <!--Usuario-->
    <td>
        <?php echo $data->user->profile->getNombre();?>
        <br>
        <small><?php echo $data->user->email?></small>
    </td>
</tr>