<tr <?php echo $data->estado == 3 ? "class=\"error\"":""; ?>>        
    
    <!--SKU-->
    <td>
        <?php echo $data->producto->sku; ?>
    </td>
    
    <!--Status-->   
    <td>
        <?php echo $data->getEstado(); ?>
    </td>      
    
    
    <!--Cantidad Enviada-->
    <td>
        <?php echo $data->cant_enviada; ?>
    </td>      
    
    <!--Cantidad Recibida-->
    <td>
        <?php echo $data->cant_recibida; ?>
    </td>      
    <td>
        <?php echo $this->widget("bootstrap.widgets.TbButton", array(
            "icon" => "ban-circle",
            "disabled" => true,
        )); ?>
    </td>
</tr>
