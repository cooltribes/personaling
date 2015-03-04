<?php  

// This code is supposed to be in the controller, or maybe in the model, but it's 
// needed to be writen here because there is no other way to send

?>


<?php if ($data->status == 0) { ?> 
    <tr class="warning">
<?php } else { ?>
    <tr class=" <?php echo ($data->personal_shopper == 2) ? 'info' : ''; ?> ">
<?php } ?>
    
    
    <!--IMAGEN-->    
    <td>
    <?php
        echo TbHtml::link(
                CHtml::image($data->getAvatar(), 'Avatar', array("width" => "70", "height" => "70")),
                array("controlpanel/comisionesclic", "id" => $data->id)
            );
    ?>
    </td>
    
    <!--DATOS PERSONALES-->    
    <td>
        <h5 class="no_margin_bottom">

             <?php 
             echo TbHtml::link(
                    $data->profile->getNombre(),
                    array("controlpanel/comisionesclic", "id" => $data->id),
                     array("class" => "link-ps")
                );
             ?>
        </h5>
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
    
    <!--PRECIOPOR CLICK-->
    <td>
        <?php 
            $uno = $data->getPagoClick();
        	echo $uno;
        ?>
    </td>
   
    <!--CLICK TOTALES-->
<td>
        <?php 
        // if there is at least one payment in the table
			$dos = $this->_lastDate ? $data->getLookReferredViewsByDate(
                    $this->_lastDate, date("Y-m-d")) : $data->getLookReferredViews();
        	echo $dos;
        ?>
    </td>
    
    <!--MONTO A PAGAR-->
    <td style="text-align: center;">
       <?php 
       
       echo CHtml::textField("amount-$data->id", $uno*$dos, array(
           "readonly" => true,
           "class" => "span1",
           "id" => $data->id,
       ));
       
       ?>                    
    </td>     

    <td>
    <?php
        echo '<a href="#" class="btn btn-mini btnProcesar" id="'.$data->id.'"><i class="icon-cog"></i>Cambiar comisión</a></td>';
    ?>
    </td>
    
</tr>

