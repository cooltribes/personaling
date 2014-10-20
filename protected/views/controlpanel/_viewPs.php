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
    
    <!--LOOKS COMPLETOS-->
    <td class="error">
        <?php
            echo $data->getLooksVendidos();
        ?>
    </td>
    
    <!--PRODUCTOS VENDIDOS-->
    <td>
        <?php 
            echo $data->getProductosVendidos();

        ?>
    </td>
    
    <!--COMISION ACTUAL-->
    <td>
        <?php 
            echo $data->getComision();
        ?>
    </td>

    <!--PAGO POR CLICK-->
    <td>
        <?php 
            echo $data->getPagoClick();
        ?>
    </td>
    
    <!--VALIDEZ EN BOLSA-->
    <td>
        <?php 
            echo $data->getValidezBolsa();
        ?>
    </td>
    
    <!--SALDO EN COMISIONES-->
    <td><?php echo $data->getSaldoPorComisiones();echo " ".Yii::t('backEnd', 'currSym'); ?></td>
    
    <!--SALDO TOTAL-->
    <td>
        <?php $saldo = Profile::model()->getSaldo($data->id);
        echo Yii::app()->numberFormatter->formatDecimal($saldo)." ".Yii::t('backEnd', 'currSym'); ?>
    </td>
    
    <!--FECHA DE REGISTRO-->
    <td>
        <?php if ($data->getCreatetime()) echo date("d/m/Y", $data->getCreatetime());
            else echo 'N/D'; ?>
    </td>
    
    <!--VER DETALLES-->
    <td style="text-align: center">
        <div class="dropdown"> <a class="dropdown-toggle btn btn-block" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#" title="Acciones"> <i class="icon-cog"></i></a> 
            <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">
            <li>
                <?php echo CHtml::link('<i class="icon-eye-open"></i> Mis Ventas',array("controlpanel/misventas", "id" => $data->id)); ?>            
            </li> 
            <li>
                <?php echo CHtml::link('<i class="icon-edit"></i> Comisión por Afiliación',array("admin/update","id"=>$data->id)); ?>
            </li>
            <li>
                <?php echo CHtml::link('<i class="icon-eye-open"></i> Comisión por Clic',array("controlpanel/comisionesClic", "id" => $data->id)); ?>
            <li>
                <?php echo CHtml::link('<i class="icon-refresh"></i> Historial de pagos',array("pago/index")); ?>
            </li>
          </ul>
        </div>

    </td>
</tr>

