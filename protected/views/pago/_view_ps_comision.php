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
                array("controlpanel/misventas", "id" => $data->id)
            );
    ?>
    </td>
    
    <!--DATOS PERSONALES-->    
    <td>
        <h5 class="no_margin_bottom">

             <?php 
             echo TbHtml::link(
                    $data->profile->getNombre(),
                    array("controlpanel/misventas", "id" => $data->id),
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
    
    <!--Visitas TOTALES-->
    <td>
        <?php
            echo $data->getLookReferredViews();
        ?>
    </td>
    
    <!--VISITAS MES ACTUAL-->
    <td>
        <?php 
        // if there is at least one payment in the table
        if($this->filter == TRUE){
        	echo $data->getLookReferredViewsByDate($this->_first,$this->_last);
        }
		else {
			echo $this->_lastDate ? $data->getLookReferredViewsByDate(
                    $this->_lastDate, date("Y-m-d")) : $data->getLookReferredViews();
		}
        ?>
    </td>
    
    <!--PORCENTAJE COMISION-->
    <td>
        <?php 
            echo $this->_lastDate ? $data->getLookViewsPercentageByDate($this->_lastDate,
                    date("Y-m-d"), $this->_totallooksviews) : 
                $data->getLookViewsPercentage($this->_totallooksviews);
        ?>
    </td>
    
    <!--MONTO A PAGAR-->
    <td style="text-align: center;">
       <?php 
       
       echo CHtml::textField("amount-$data->id", 0, array(
           "readonly" => true,
           "class" => "span1",
           "id" => $data->id,
       ));
       //aqui va el porcentaje de comision
       echo CHtml::hiddenField("percentage-$data->id", $this->_lastDate ?
               $data->getLookViewsPercentageByDate($this->_totallooksviews,
                       date("Y-m-d"), $this->_totallooksviews, false)
               : $data->getLookViewsPercentage($this->_totallooksviews, false));
       
       ?>                    
    </td>    
</tr>

