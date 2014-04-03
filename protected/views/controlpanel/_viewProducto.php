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
        echo CHtml::image("http://placehold.it/70x70", 'Avatar', array("width" => "70", "height" => "70"));
        ?>        
    </td>


    <td>Referencia</td>

    <!--MARCA-->
    <td>Marca</td>
    
    <!--FECHA DE LA VENTA-->
    <td><?php echo date("d-m-Y", strtotime($data->myorden->fecha)); ?></td>
    
    <!--PRECIO--> 
    <td><?php echo Yii::app()->numberFormatter->formatDecimal($data->precio); ?></td>
    
    <!--TALLA-->    
    <td><?php echo $data->preciotallacolor->mytalla->valor; ?></td>
    
    <!--COLOR-->
    <td><?php echo $data->preciotallacolor->mycolor->valor; ?></td>
    
    <!--CANTIDAD-->
    <td><?php echo $data->cantidad; ?></td>
    
    <!--TOTAL-->
    <td>340,00</td>
    
    <!--COMISION APLICADA-->
    <td><?php
    
        echo $data->getComision();
        
    ?></td>
    
    <!--COMISION GANADA-->
    <td>34,89</td>
    
    <!--ACCIONES-->
    <td>Ver</td>
    
</tr>