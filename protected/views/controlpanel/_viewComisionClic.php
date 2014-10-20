<?php  
/**
 * @var OrdenHasProductotallcolor $data
 */
?>
<tr>
    <!--DATOS-->
    <!--FECHA-->
    <td>
        <?php  
            echo date("d-m-Y H:i:s",strtotime($data->fecha));
        ?>        
    </td>
    <!-- COMISION -->
    <td>
        <?php
            echo $data->total;
        ?>
    </td>

    <!--VISTAS-->
    <td>
        <?php
            $payps = PayPersonalShopper::model()->findByAttributes(array('affiliatePay_id'=>$data->orden_id,'user_id'=>$data->user_id));
            echo $payps->total_views;
        ?>
    </td>    
    
    <!--PAGO AFILIADO -->
    <td>
        <?php
            echo $payps->affiliatePay_id; 
        ?>
    </td>    
</tr>