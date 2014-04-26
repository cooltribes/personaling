<?php  
/**
 * @var OrdenHasProductotallcolor $data
 */

?>

<tr>
    <td><input name='check' type='checkbox' id='<?php //echo $data->id; ?>' /></td>

    <!--DATOS-->
    <td>
        <!--IMAGEN-->
        <?php  
        $imagen = Imagen::model()->findAllByAttributes(
                array('tbl_producto_id'=>$data->preciotallacolor->producto_id,
                    'color_id'=>$data->preciotallacolor->color_id));
        $imagen = Imagen::model()->findByAttributes(
                array('tbl_producto_id'=>$data->preciotallacolor->producto_id,
                    'color_id'=>$data->preciotallacolor->color_id));
        
        $source = "http://placehold.it/70x70";        
        
//        if(isset($imagen)){
//            foreach($imagen as $img) {
//                $source = Yii::app()->baseUrl . str_replace(".","_thumb.",$img->url);
//                break;
//            }	
//
//        }
        
        if(isset($imagen)){
            
            $source = Yii::app()->baseUrl . str_replace(".","_thumb.",$imagen->url);
            
        }        
        echo CHtml::image($source, 'Imagen ', array("width" => "70", "height" => "70"));
        
        ?>        
    </td>


    <td>
        <b>Nombre:</b> <?php echo $data->preciotallacolor->producto->nombre;?>
        <br>
        <b>Referencia:</b> <?php echo $data->preciotallacolor->producto->codigo;?>
        <br>
        <br>
        <b>Marca:</b> <?php echo $data->preciotallacolor->producto->mymarca->nombre;?>
    </td>

    <!--LOOK-->
    <td><?php echo $data->look->title; ?></td>    
    
    <!--FECHA DE LA VENTA-->
    <td><?php echo date("d-m-Y", strtotime($data->myorden->fecha)); ?></td>
    
    <!--PRECIO--> 
    <td><?php echo Yii::app()->numberFormatter->formatDecimal($data->precio); ?></td>
    
    <!--TALLA-->    
    <td><?php //echo $data->preciotallacolor->mytalla->valor; 
        echo $data->preciotallacolor->talla; 
    
    ?></td>
    
    <!--COLOR-->
    <td><?php echo $data->preciotallacolor->color; ?></td>
    
    <!--CANTIDAD-->
    <td><?php echo $data->cantidad; ?></td>
    
    <!--TOTAL-->    
    <td><?php echo $data->getMontoTotal(); ?></td>
    
    <!--COMISION APLICADA-->
    <td><?php
    
        echo $data->getComision();
        
    ?></td>
    
    <!--COMISION GANADA-->
    <td><?php echo $data->getGanancia(); ?></td>
    
    <!--ACCIONES-->
    <!--<td>Ver</td>-->
    
</tr>