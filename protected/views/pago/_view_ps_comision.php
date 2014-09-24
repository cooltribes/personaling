<?php if ($data->status == 0) { ?>
    <tr class="warning">
<?php } else { ?>
    <tr class=" <?php echo ($data->personal_shopper == 2) ? 'info' : ''; ?> ">
<?php } ?>
    
    
    <!--IMAGEN-->    
    <td>
        <?php
        // <img src="images/kitten.png" width="70" height="70" alt="avatar">
        echo CHtml::image($data->getAvatar(), 'Avatar', array("width" => "70", "height" => "70"));
        ?>
    </td>
    
    <!--DATOS PERSONALES-->    
    <td>
        <h5 class="no_margin_bottom"> <?php echo $data->profile->first_name . ' '
                . $data->profile->last_name; ?></h5>
        <small><strong>ID</strong>: <?php echo $data->id; ?><br/>
            <?php
            if ($data->personal_shopper == 1) {
                if ($data->ps_destacado == 1) {
                    ?>
                    <span class="label label-warning">Personal Shopper Destacado</span>
                    <?php
                } else {
                    echo 'Personal Shopper';
                }
            } else if ($data->personal_shopper == 2) {
                echo '<span class="label label-info"> Aplicante Personal Shopper</span>';
            } else {
                echo '';
            }
            ?> </small>
    </td>
    
    <!--TELF - EMAIL - CIUDAD-->
    <td>
        <small><?php echo $data->email; ?><br/>
            <strong>Telf.</strong>: <?php echo $data->profile->tlf_celular; ?> <br/>
            <strong>Ciudad</strong>: <?php echo $data->profile->ciudad; ?> <br/>
            <?php if ($data->status == User::STATUS_NOACTIVE) { ?>
                <strong class="text-warning text-center">Cuenta no validada</strong>
            <?php } else if ($data->status == User::STATUS_BANNED) { ?>          
                <strong class="text-error text-center">Cuenta bloqueada</strong>
            <?php } ?>   
        </small>
    </td>
    
    <!--Visitas TOTALES-->
    <td>
        <?php
            echo $data->getLooksVendidos();
        ?>
    </td>
    
    <!--VISITAS MES ACTUAL-->
    <td>
        <?php 
            echo $data->getProductosVendidos();

        ?>
    </td>
    
    <!--PORCENTAJE COMISION-->
    <td>
        <?php 
            echo $this->_totallooksviews."2 %";
        ?>
    </td>
    
    <!--MONTO A PAGAR-->
    <td style="text-align: center;">
       <?php 
       
       echo CHtml::textField("amountPay", 0, array(
           "readonly" => true,
           "class" => "span1",
           "id" => "amount-$data->id",
           
       ));
       //aqui va el porcentaje de comision
       echo CHtml::hiddenField("percentage-$data->id", 2, array(           
           "id" => "amount-$data->id",
           
       ));
       
       ?>                    
    </td>    
</tr>

