<tr>
    <td><input name="check" type="checkbox" value="" id=<?php echo $data->id; ?>></td>    
    <td  width="20%">
        <strong> <span class="CAPS link-look"><?php        
        
            echo CHtml::link($data->title,
            $this->createUrl('look/detalle',array('id'=>$data->id)),
            array(// for htmlOptions
              'onclick'=>' {'.CHtml::ajax( array(
              'url'=>CController::createUrl('look/detalle',array('id'=>$data->id)),
                  // 'beforeSend'=>'js:function(){if(confirm("Are you sure you want to delete?"))return true;else return false;}',
                   'success'=>"js:function(data){

                         $('#myModal').html(data);
                        $('#myModal').modal(); }"
              )
              ).
                 'return false;}',// returning false prevents the default navigation to another url on a new page 
               // 'class'=>'delete-icon',
                'id'=>'link'.$data->id)
            );	
            ?></span>
        </strong><br/>
        <strong><?php echo Yii::t('contentForm', 'ID'); ?></strong>: <?php echo $data->id; ?><br/>
        <strong><?php echo Yii::t('contentForm', 'Nro. Items'); ?></strong>: <?php echo $data->countItems(); ?>
    </td>
    <td>
        <strong><?php echo Yii::t('contentForm', 'P.S'); ?></strong>: <?php echo $data->user->profile->first_name; ?><br/>
        <strong><?php echo Yii::t('contentForm', 'Brands'); ?></strong>: <?php
        $ids = $data->getMarcas();
        $c = 0;
        foreach ($ids as $id) {
            echo " " . $id->nombre;
            if ($c < count($ids) - 1)
                echo ", ";
            else
                echo ".";$c++;
        }
        ?>
    </td>
    <td><?php echo $data->getPrecio(); ?></td>
    <td><?php echo $data->getLookxStatus(3); ?></td>
    <td><?php echo $data->getMontoVentas(); ?></td>
     <td><?php echo $data->getStatus();echo "\n"; if($data->activo=="1")echo "Activo";else echo "Inactivo"; echo "\n"; if($data->destacado=="1")echo "Destacado";else echo "No Destacado";?></td>
            <td><?php echo $data->created_on; ?></td>
    <td> <?php $camp = Campana::model()->findByPk($data->campana_id);
        echo $camp->daysLeft(); ?>
        <div class="progress margin_top_small  progress-danger">
            <div class="bar" style="width: <?php echo $camp->getProgress(); ?>%"></div>
        </div></td>
    <td>

         <div class="dropdown"> 
            <a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="" title="acciones">
                <i class="icon-cog"></i> <b class='caret'></b>
            </a> 
            <!-- Link or button to toggle dropdown -->
            <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">
                <li>
                    <?php echo CHtml::link('<i class="icon-list-alt"></i>  Ver detalles',
                            $this->createUrl('look/informacion',array('id'=>$data->id)), array(
                                                
                    )); ?>            
                </li>
                <li>
                    <?php
                    if($data->activo==1)
                    {
                            echo CHtml::link('<i class="icon-pencil"></i>  Inactivar',
                            $this->createUrl('look/enabledLook',array('id'=>$data->id)), array(
                                ));
                    }
                    else
                    {
                            echo CHtml::link('<i class="icon-pencil"></i>  Activar',
                            $this->createUrl('look/enabledLook',array('id'=>$data->id)), array(
                                ));
                    }

					
                    ?>
                </li>
                <li>
                    <?php echo CHtml::link('<i class="icon-eye-open"></i>  Ver en tienda',
                            Yii::app()->baseUrl.'/look/'.$data->id, array(
//                        
                    )); ?>            
                </li>
                <li>
                    <?php echo CHtml::link('<i class="icon-edit"></i>  Editar', 
                            $this->createUrl('look/edit',array('id'=>$data->id)), array(

                    )); ?>            
                </li>
                <li>
                    <?php echo CHtml::link('<i class="icon-minus-sign"></i>  Aplicar descuento',
                            $this->createUrl('look/descuento',array('id'=>$data->id)), array(

                    )); ?>            
                </li>
                <li>
                    <?php echo CHtml::link('<i class="icon-trash"></i>  Eliminar', 
                            $this->createUrl('look/softDelete',array('id'=>$data->id)), array(

                    )); ?>            
                </li>
                    
            </ul>
        </div>
    </td>
</tr> 