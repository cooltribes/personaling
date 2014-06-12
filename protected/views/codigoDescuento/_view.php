<tr>            
    <td>
        <?php echo $data->id; ?>
    </td>
    <!--Creador-->
    <td>
        <h5 class="no_margin_bottom no_margin_top">
            <b><?php echo $data->userCreador->profile->getNombre();?></b>
        </h5>        
        <?php 
           echo $data->userCreador->email;
         ?>
        <br>
        <small>
            <?php
            if ($data->userCreador->superuser) {
                echo "Administrador";
            }
            ?>
        </small>

    </td>
    
    <!--Codigo-->
    <td>        
        <?php echo $data->codigo; ?>
    </td> 
    <!--estado-->
    <td>
        <?php
        echo $data->getEstado();
        ?> 
    </td>
    <!--descuento-->
    <td>
        <?php echo $data->getDescuento(); ?>
    </td>
    <!--validez-->
    <td>
        <?php echo date("d/m/Y", $data->getInicioVigencia()); ?>
    </td>
    <td>
        <?php echo date("d/m/Y", $data->getFinVigencia()); ?>
    </td>
       <!--acciones-->
    <td>
        <div class="dropdown"> 
            <a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="" title="acciones">
                <i class="icon-cog"></i> <b class='caret'></b>
            </a>              
            <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">
                <li>
                    <?php echo CHtml::link('<i class="icon-edit"></i> Editar', 
                            $this->createUrl('update',array('id'=>$data->id)), array(
                        
                    )); ?>            
                </li>
                
                    <?php if ($data->estado == 1) { ?>
                        <li>
                        <?php echo CHtml::link('<i class="icon-envelope">  </i>  Enviar', array("enviar", "id" => $data->id)); ?>
                        </li>
                    <?php }else if ($data->estado == 2) { ?>
                        <li>
                        <?php echo  CHtml::link("<i class='icon-ban-circle'></i> Desactivar",
                                        $this->createUrl('index',array('id'=>$data->id)),
                                        array(
                                        'id'=>'linkDesactivar-'.$data->id)
                                    ); ?>
                        </li>
                    <?php } ?>
                
                
                    
            </ul>
        </div>
    </td>
</tr>
