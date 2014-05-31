<tr <?php echo $data->estado == 3 ? "class=\"error\"":""; ?>>        
    <td>
        <?php echo $data->id; ?>
    </td>
    
    <!--User-->
    <td>
        <?php
        echo CHtml::image($data->user->getAvatar(), 'Avatar', array("width" => "70", "height" => "70"));
        ?>
    </td>
    <td class="nombreUsuario">
        <h5 class="no_margin_bottom no_margin_top"> <?php echo $data->user->profile->getNombre();?></h5>
        <small>
            <?php
               echo $data->user->email;
            ?>
        </small>
    </td>

    <!--Status-->   
    <td>
        <?php echo $data->getEstado(); ?>
    </td>      
    <!--Fecha de carga-->   
    <td>
        <?php echo date("d/m/Y - h:m:i a", $data->getFecha()); ?>
    </td>      
    
    <td>
        <?php echo $data->total_productos; ?>
    </td>      
    <td>
        <?php echo $data->total_cantidad; ?>
    </td>      
    
    <td>
        <?php echo "---"; ?>
    </td>      
    <td>
        <div class="dropdown text_align_center"> 
            <a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="" title="acciones">
                <i class="icon-cog"></i> <b class='caret'></b>
            </a> 
            <!-- Link or button to toggle dropdown -->
            <ul class="dropdown-menu pull-right text_align_left" role="menu" aria-labelledby="dLabel">
                <li>
                    <?php echo CHtml::link('<i class="icon-eye-open"></i>  Ver Detalle',
                            $this->createUrl("/inbound/detalle", array("id"=>$data->id))
                    ); ?>                                
                </li>
                <li>
                    <?php echo CHtml::link('<i class="icon-list-alt"></i>  Descargar Excel',
                            $this->createUrl("/inbound/descargarExcel", array("id"=>$data->id))
                    ); ?>                                
                </li>
                <li>          
                    <?php echo CHtml::link('<i class="icon-align-center"></i>  Descargar XML',
                            $this->createUrl("/inbound/descargarXml", array("id"=>$data->id))
                    ); ?>            
                </li>                    
            </ul>
        </div>
    </td>
</tr>
