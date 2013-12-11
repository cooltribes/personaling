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
                                $entrega = Yii::app()->getSession()->get('entrega');
                                $envio = new EnvioGiftcard();
                                $envio->attributes = Yii::app()->getSession()->get('envio');
                                ?>
                                <tr>
                                    <td>
                                        <!--<img src='<?php echo Yii::app()->baseUrl; ?>/images/giftcards/gift_card_one_x114.png' class='margin_bottom'>-->
                                        <img src='<?php echo 
                                        Yii::app()->baseUrl."/images/giftcards/{$giftcard->plantilla_url}_x114.png"; ?>' class='margin_bottom'>
                                    </td>
                                    <td>
                                        <strong>Código:</strong> <?php echo $giftcard->getMascaraCodigo(); ?><br/>
                                        <strong>Validez:</strong> <?php echo "Desde <i>".date("d-m-Y", $giftcard->getInicioVigencia()).
                                                "</i> hasta <i>".date("d-m-Y", $giftcard->getFinVigencia())."</i>"; ?><br/>
                                        <?php 
                                        //si hay para y mensaje
                                        if($entrega == 2){ ?>
                                        <strong>Enviada a:</strong> <?php echo $envio->email; ?><br/>
                                        <?php } ?>
                                    </td>
                                    <td>Bs. <?php echo $giftcard->monto; ?></td>
                                    <td>
                                    <?php 
                                    //si era para imprimir
                                    if($entrega == 1){
                                        $this->widget("bootstrap.widgets.TbButton", array(
                                           'buttonType' => "link" ,
                                           'type' => "danger" ,
                                           'icon' => "print white" ,
                                           'label' => "Imprimir" ,
                                           'url' => "javascript:printElem('#divImprimir')" ,
                                        ));
                                    }
                                    //si era para enviar
                                    if($entrega == 2){
                                        echo "<i>Enviada por email</i>";
                                    } 
                                    ?>
                                    </td>
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
<div class="hide" id="divImprimir">
    Nelson
</div>
<!-- <input type="hidden" id="idDetalle" value="<?php //echo($orden->detalle_id);  ?>" /> -->

<!-- // Modal Window --> 

<script type="text/javascript">
/*<![CDATA[*/
    function printElem(elem)
    {
        popup($(elem).html());
    }

    function popup(data) 
    {        
        
        var h = 600;
        var w = 800;
        var left = (screen.width - w)/2;
        var top = (screen.height - h)/2 - 30;
        var mywindow = window.open('', 'my div', 'height='+h+',width='+w+', left='+left+', top='+top);
        mywindow.document.write('<html><head><title>my div</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</ body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }
/*]]>*/
</script>