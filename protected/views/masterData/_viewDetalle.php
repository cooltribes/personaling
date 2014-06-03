<tr <?php echo $data->estado == 3 ? "class=\"error\"":""; ?>>        
    
     <!--Foto-->
    <td style="text-align:center">        
        <?php 
            $imagen = Imagen::model()->findByAttributes(array(
                        'tbl_producto_id'=>$data->producto->producto->id,
                        'color_id'=>$data->producto->color_id
                    ));
            
            if(!is_null($imagen))
            {
                $foto = CHtml::image(Yii::app()->baseUrl.
                        str_replace(".","_thumb.",$imagen->url), "Imagen ", array(
                            "width" => "70", "height" => "70",
                            "class" => "img-polaroid",
                            ));
            }
            else
            {
                $foto = CHtml::image("http://placehold.it/70", "Imagen ", array(
                            "width" => "70", "height" => "70",
                            "class" => "img-polaroid",
                            ));
                
            }
            echo $foto; 
        ?>
    </td>
    
    <!--SKU-->
    <td>
        <b>SKU:</b> <?php echo $data->producto->sku; ?>
        <br><b>Nombre de la Prenda:</b> <?php echo $data->producto->producto->nombre; ?>
    </td>
    
    <!--Status-->   
    <td>
        <?php echo $data->getEstado(); ?>
    </td>      
     
    <!--ACCIONES-->
    <td>
        <div class="dropdown text_align_center"> 
            <a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="" title="acciones">
                <i class="icon-cog"></i> <b class='caret'></b>
            </a> 
            <!-- Link or button to toggle dropdown -->
            <?php
                //Solo si esta en estado "Con discrepancias"
                if($data->estado == 3){
                    
            ?>    
            <ul class="dropdown-menu pull-right text_align_left" role="menu" aria-labelledby="dLabel">                
                
                <?php                                
                    echo "<li>";
                    echo CHtml::link('<i class="icon-ok"></i>  Marcar como corregido',
                            "#",
                            array(
                                "onclick" => "js:marcarCorregida($data->id)"
                            )
    //                            $this->createUrl("/inbound/corregirItem", array("id"=>$data->id))
                        ); 
                    echo "</li>";               
                ?>                              
                                               
            </ul>
            <?php             
                }
                ?> 
        </div>
    </td>
</tr>
