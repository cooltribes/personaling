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
        <?php
        if($data->cant_recibida){
            echo $data->cant_recibida;             
        }else{
            echo "---";
        }
        ?>
    </td>      
    <td>
        <div class="dropdown text_align_center"> 
            <a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="" title="acciones">
                <i class="icon-cog"></i> <b class='caret'></b>
            </a> 
            <!-- Link or button to toggle dropdown -->
            <ul class="dropdown-menu pull-right text_align_left" role="menu" aria-labelledby="dLabel">
                <li>
                    <?php echo CHtml::link('<i class="icon-ok"></i>  Marcar como corregido',
                            "#",
                            array(
                                "onclick" => "js:marcarCorregida($data->id)"
                            )
//                            $this->createUrl("/inbound/corregirItem", array("id"=>$data->id))
                    ); ?>                                
                </li>                                 
            </ul>
        </div>
    </td>
</tr>
