<tr>        
    <td>
        <?php echo $data->id; ?>
    </td>
    <!--User-->
    <td>
        <h5 class="no_margin_bottom no_margin_top"> <?php echo $data->user->profile->getNombre();?></h5>
        <small>
            <?php
               echo $data->user->email;
            ?>
        </small>

    </td>
    
    <!--Fecha de carga-->   
    <td>
        <?php echo date("d/m/Y - h:m:i a", $data->getFecha()); ?>
    </td>      
    
    <td>
        <?php echo $data->prod_nuevos; ?>
    </td>      
    
    <td>
        <?php echo $data->prod_actualizados; ?>
    </td>      
    <td>
        <div class="dropdown"> 
            <a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="" title="acciones">
                <i class="icon-cog"></i> <b class='caret'></b>
            </a> 
            <!-- Link or button to toggle dropdown -->
            <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">
                 <li>
                    <?php echo CHtml::link('<i class="icon-eye-open"></i>  Ver Detalle',
                            $this->createUrl("/masterData/detalle", array("id"=>$data->id))
                    ); ?>                                
                </li>
                <li>
                    <?php echo CHtml::link('<i class="icon-list-alt"></i>  Descargar Excel',
                                $this->createUrl("/masterData/descargarExcel", array("id"=>$data->id))
                            ); ?>                                
                </li>
                <li>          
                    <?php echo CHtml::link('<i class="icon-align-center"></i>  Descargar XML',
                                $this->createUrl("/masterData/descargarXml", array("id"=>$data->id))
                            ); ?>            
                </li>                    
            </ul>
        </div>
    </td>
</tr>
