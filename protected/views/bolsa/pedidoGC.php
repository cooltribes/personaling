<?php
$nf = new NumberFormatter("es_VE", NumberFormatter::CURRENCY);
if (!Yii::app()->user->isGuest) { // que este logueado
    $user = User::model()->findByPk(Yii::app()->user->id);
//$pago = Pago::model()->findByAttributes(array('id'=>$orden->pago_id));
//$tipo_pago = $orden->getTipoPago();
    $tipo_pago = 2; //tarjeta
//echo $orden->pago_id;
    ?>
    <?php //echo "xPagar".$orden->getxPagar()." SumxOrden".Detalle::model()->getSumxOrden($orden->id);  ?>
    <div class="container margin_top">
        <div class="row">
            <div class="span8 offset2">
                <?php
                if ($orden->estado == 3) { // Listo el pago
                    ?>   
                    <div class='alert alert-success margin_top_medium margin_bottom'>
                        <h1>Tu compra se ha realizado con éxito.</h1>
                        <p>Hemos recibido los datos de la compra así como los de tu pago con tarjeta de crédito.<br/>
                            Tu GiftCard está disponible para ser aplicada en cualquier momento.</p>
                    </div>
                    <?php
                }
                ?>
                <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
                    <h3>Resumen del pedido </h3>
                    <p class="well well-small"><strong>Número de confirmación:</strong> <?php echo $orden->id; ?></p>
                    
                    <hr/>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <th class="text_align_left">Subtotal:</th>
                            <td><?php echo 'Bs. ' . Yii::app()->numberFormatter->formatCurrency($orden->total, ''); ?></td>
                        </tr>           
                        <tr>
                            <th class="text_align_left"><h4>Total:</h4></th>
                        <td><h4><?php echo 'Bs. ' . Yii::app()->numberFormatter->formatCurrency($orden->total, ''); ?></h4></td>
                        </tr>
                    </table>
                    <hr/>
                    <p>Hemos enviado un resumen de la compra a tu correo electrónico: <strong><?php echo $user->email; ?></strong> </p>          
                    <h3 class="margin_top">Detalles del Pedido</h3>
                    <div>
                        <table class='table' width='100%' >
                            <thead>                                
                                <tr>
                                    <th colspan='2'>GiftCard</th>
                                    <th>Monto</th>
                                    <th>Imprimir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                ////            $aaa = CHtml::image(Yii::app()->baseUrl . str_replace(".","_thumb.",$img->url), "Imagen ", array("width" => "70", "height" => "70",'class'=>'margin_bottom'));
////            echo "<td>".$aaa."</td>";
//             echo"<td><img src='http://placehold.it/70x70/' class='margin_bottom'></td>";
//            echo "
//                <td>
//                <strong>".$producto->nombre."</strong> <br/>
//                <strong>Color</strong>: ".$color->valor."<br/>
//                <strong>Talla</strong>: ".$talla->valor."</td>
//                </td>
//                ";
//            echo "<td>Bs. ".$pre."</td>";
//                    echo "<td>".$individual->cantidad."</td>
//                    ";
                                
                                /*Por los momentos una sola giftcard por Compra*/
                                $giftcard = Giftcard::model()->findByAttributes(array("orden_id" => $orden->id));
                                ?>
                                <tr>
                                    <td>
                                        <!--<img src='<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x114.png' class='margin_bottom'>-->
                                        <img src='<?php echo 
                                        Yii::app()->baseUrl."/images/giftcards/{$giftcard->plantilla_url}_x114.png"; ?>' class='margin_bottom'>
                                    </td>
                                    <td>
                                        <strong>Monto:</strong> <?php echo $giftcard->monto; ?><br/>
                                        <strong>Código:</strong> <?php echo $giftcard->getMascaraCodigo(); ?><br/>
                                        <strong>Validez:</strong> <?php echo "Desde ... hasta ..."; ?>
                                    </td>
                                    <td>Bs. <?php echo $giftcard->monto; ?></td>
                                    <td>Boton</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
                <hr/>
                <a href="../../tienda/index" class="btn btn-danger" title="seguir comprando">Ir a la tienda</a> </div>
        </div>
    </div>

    <!-- /container -->
    <?php
}// si esta logueado
else {
    // redirecciona al login porque se murió la sesión
//	header('Location: /user/login');
    $url = CController::createUrl("/user/login");
    header('Location: ' . $url);
}
?>

<!-- Modal Window -->
<?php
$detPago = new Detalle;
$detPago->monto = 0;
?>
<div class="modal hide fade" id="myModal">
    <?php $this->renderPartial('//orden/_modal_pago', array('orden_id' => $orden->id)); ?>
</div>
<!-- <input type="hidden" id="idDetalle" value="<?php //echo($orden->detalle_id);  ?>" /> -->

<!-- // Modal Window --> 

<script>

    function enviar(id)
    {
        //var idDetalle = $("#idDetalle").attr("value");
        var nombre = $("#nombre").attr("value");
        var numeroTrans = $("#numeroTrans").attr("value");
        var dia = $("#dia").attr("value");
        var mes = $("#mes").attr("value");
        var ano = $("#ano").attr("value");
        var comentario = $("#comentario").attr("value");
        var banco = $("#banco").attr("value");
        var cedula = $("#cedula").attr("value");
        var monto = $("#monto").attr("value");

        if (nombre == "" || numeroTrans == "" || monto == "")
        {
            alert("Por favor complete los datos.");
        }
        else
        {

            $.ajax({
                type: "post",
                url: "<?php echo Yii::app()->createUrl('bolsa/cpago'); ?>", // action 
                data: {'nombre': nombre, 'numeroTrans': numeroTrans, 'dia': dia, 'mes': mes, 'ano': ano, 'comentario': comentario, 'banco': banco, 'cedula': cedula, 'monto': monto, 'idOrden': id},
                success: function(data) {

                    if (data == "ok")
                    {
                        window.location.reload();
                        //alert("guardado"); 
                        // redireccionar a donde se muestre que se ingreso el pago para luego cambiar de estado la orden 
                    }
                }//success
            })
        }


    }

</script>