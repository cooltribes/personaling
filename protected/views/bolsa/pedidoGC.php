<?php
$nf = new NumberFormatter("es_VE", NumberFormatter::CURRENCY);
$this->setPageTitle(Yii::app()->name . " - " . Yii::t('contentForm', 'Order Summary'));
if (!Yii::app()->user->isGuest) { // que este logueado
    $user = User::model()->findByPk(Yii::app()->user->id);
//$pago = Pago::model()->findByAttributes(array('id'=>$orden->pago_id));
//$tipo_pago = $orden->getTipoPago();
    $tipo_pago = 2; //tarjeta
//echo $orden->pago_id;
    ?>
    <?php //echo "xPagar".$orden->getxPagar()." SumxOrden".Detalle::model()->getSumxOrden($orden->id);  ?>
    <style>
    	#voucher div table{
    		border: solid 25px #FFF;
			margin: 0 auto;
			outline: solid 1px;
    	}
    </style>
    <div class="container margin_top">
        <div class="row">
            <div class="span8 offset2">
                <?php
                    

                    if ($orden->estado == 3) { // Listo el pago
                    ?>   
                    <div class='alert alert-success margin_top_medium margin_bottom'>
                        <h1><?php echo Yii::t('contentForm','Your order has been successfully completed.'); ?></h1>
                        <p<?php echo Yii::t('contentForm','We received the data of purchase as well as your credit card payment.'); ?><br/>
                          <?php  echo Yii::t('contentForm','Your Gift Card is available to be applied at any time.'); ?></p>
                    </div>
                    <?php
                }
                ?>
                <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
                    <h3><?php  echo Yii::t('contentForm','Order Summary'); ?> </h3>
                    <p class="well well-small"><strong><?php  echo Yii::t('contentForm','Confirmation number'); ?>:</strong> <?php echo $orden->id; ?></p>
                    
                    <hr/>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <th class="text_align_left"><?php  echo Yii::t('contentForm','Subtotal'); ?>:</th>
                            <td><?php echo Yii::t('contentForm','currSym').'. ' . Yii::app()->numberFormatter->formatCurrency($orden->total, ''); ?></td>
                        </tr>           
                        <tr>
                            <th class="text_align_left"><h4><?php  echo Yii::t('contentForm','Total'); ?>:</h4></th>
                        <td><h4><?php echo Yii::t('contentForm','currSym').'. ' . Yii::app()->numberFormatter->formatCurrency($orden->total, ''); ?></h4></td>
                        </tr>
                    </table>
                    <hr/> 
                    <p><?php echo Yii::t('contentForm','We have sent a summary of the purchase to your inbox');  ?>: <strong><?php echo $user->email; ?></strong> </p>          
                   	<?php if($tipoPago == 2){ ?>
	                    <p><?php echo Yii::t('contentForm','Reference').": ".$referencia; ?></p>	
	                    <div style="margin: 0 auto; " id="voucher"><?php echo CHtml::decode($voucher); ?>
	                    </div>
                    <?php } ?>
                    <h3 class="margin_top"><?php echo Yii::t('contentForm','Order Details');  ?></h3>
                    <div>
                        <table class='table' width='100%' >
                            <thead>                                
                                <tr>
                                    <th colspan='2'><?php echo Yii::t('contentForm','Gift Card');  ?></th>
                                    <th><?php echo Yii::t('contentForm','Amount');  ?></th>
                                    <th></th>
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
                                        Yii::app()->baseUrl."/images/giftcards/{$giftcard->plantilla_url}_x114.jpg"; ?>' class='margin_bottom'>
                                    </td>
                                    <td>
                                        <strong><?php echo Yii::t('contentForm','Code');  ?>:</strong> <?php echo $giftcard->getMascaraCodigo(); ?><br/>
                                        <strong><?php echo Yii::t('contentForm','Validity');  ?>:</strong> <?php echo Yii::t('contentForm','From1')." <i>".date("d-m-Y", $giftcard->getInicioVigencia()).
                                                "</i>".Yii::t('contentForm','To')." <i>".date("d-m-Y", $giftcard->getFinVigencia())."</i>"; ?><br/>
                                        <?php 
                                        //si hay para y mensaje
                                        if($entrega == 2){ ?>
                                        <strong><?php echo Yii::t('contentForm','Sent to:');  ?></strong> <?php echo $envio->email; ?><br/>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo Yii::t('contentForm','currSym').' '.$giftcard->monto; ?></td>
                                    <td>
                                    <?php 
                                    //si era para imprimir
                                    if($entrega == 1){
                                        $this->widget("bootstrap.widgets.TbButton", array(
                                           'buttonType' => "link" ,
                                           'type' => "danger" ,
                                           'icon' => "print white" ,
                                           'label' => Yii::t('contentForm','Print'),
                                           'url' => "javascript:printElem('#divImprimir')" ,
                                        ));
                                    }
                                    //si era para enviar
                                    if($entrega == 2){
                                        echo "<i>".Yii::t('contentForm','Sent by email')."</i>";
                                    } 
                                    ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
                <hr/>
                <a href="../../tienda/index" class="btn btn-danger" title="seguir comprando"><?php echo Yii::t('contentForm','Go to Store'); ?></a> </div>
        </div>
    </div>

    <!-- /container -->
<div class="hide" id="divImprimir">
    
<div style="width: 350px">
    
<table class="table table-condensed" border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageCardBlock">
  <tbody class="mcnImageCardBlockOuter">
      <tr>
          <td class="mcnImageCardBlockInner" valign="top" style="padding-top:9px; padding-right:18px; padding-bottom:9px; padding-left:18px;">

              <table align="right" border="0" cellpadding="0" cellspacing="0" class="mcnImageCardBottomContent" width="100%" style="border: 1px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255);">
                  <tbody>
                      <tr>
                          <td class="mcnImageCardBottomImageContent" align="left" valign="top" style="padding-top:18px; padding-right:18px; padding-bottom:0; padding-left:18px; font-family: Helvetica; text-align:center;">
                              <img alt="" src="<?php echo 
                                        Yii::app()->baseUrl."/images/giftcards/{$giftcard->plantilla_url}_x531.jpg"; ?>" width="470" style="max-width:470px;" class="mcnImage blockDropTarget" id="mojo_neapolitan_preview_ImageUploader_281" widgetid="mojo_neapolitan_preview_ImageUploader_281">

                          </td>
                      </tr>
                      <tr>
                          <td class="mcnTextContent" valign="top" style="padding-top:9px; padding-right:9px; padding-bottom:9px; padding-left:9px;">
                              <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageCardBlock">
                                  <tbody class="mcnImageCardBlockOuter">
                                      <tr>
                                          <td class="mcnImageCardBlockInner" valign="" >

                                              <table align="right" border="0" cellpadding="0" cellspacing="0" class="mcnImageCardBottomContent" width="100%">
                                                  <tbody>
                                                      <tr>
                                                          <td class="mcnTextContent" valign="top" style="padding-top:9px; padding-right:9px; padding-bottom:9px; padding-left:24px; border-right: 1px solid #ddd;" width="213">
                                                              <span style="font-size:42px; color:#6d2d56;"><?php echo $giftcard->monto.' '.Yii::t('contentForm','currSym');?>.</span><br>
                                                              <br>
                                                              <span style="color:#9b9894;"><?php echo Yii::t('contentForm','Code'); ?>:  </span><br>
                                                              <span style="font-size: 14px; color: #000;"><?php echo $giftcard->getCodigo() ?></span>
                                                          </td>
                                                          <td valign="top" style="padding-top:9px; padding-right:9px; padding-bottom:9px; padding-left:9px;" width="263">
                                                              <br>
                                                              <strong><?php echo Yii::t('contentForm','To1'); ?>: </strong><span> <?php echo  $envio->nombre ?></span>
                                                              <br>
                                                              <strong><?php echo Yii::t('contentForm','Message'); ?>:</strong><span><?php echo $envio->mensaje ?></span>
                                                          </td>
                                                      </tr>
                                                  </tbody>
                                              </table>
                                          </td>
                                      </tr>
                                  </tbody>
                              </table>   
                          </td>                         
                      </tr>
                      <tr>
                          <td style="text-align:center; font-size: 11px; margin-top:20px; padding-bottom:10px; padding-top:10px; font-size: 11px;">
                              <?php echo Yii::t('contentForm','Valid from <strong>{start}</strong> until <strong>{end}</strong>',array('{start}'=>date("d-m-Y", $giftcard->getInicioVigencia()),'{end}'=>date("d-m-Y", $giftcard->getFinVigencia()))); ?>
                          </td>
                      </tr>                                                              
                  </tbody>
              </table>


          </td>
      </tr>
  </tbody>
</table>

    
</div>
    
</div>
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
        var mywindow = window.open('', 'GiftCard Personaling', 'height='+h+',width='+w+', left='+left+', top='+top);
        mywindow.document.write('<html><head><title>GiftCard</title>');
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