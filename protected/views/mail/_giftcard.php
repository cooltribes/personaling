<table class="w640" width="640" cellpadding="0" cellspacing="0" border="0" >
  <tbody>
    <tr>
      <td class="w30" width="30"></td>
      <td class="w580" width="580"><repeater>
          <layout label="Text only">
            <table class="w580" width="580" cellpadding="0" cellspacing="0" border="0" >
              <tbody width="580">
                <tr>
                  <td class="w580" width="580"><p align="left" class="article-title">
                      <singleline label="Title"><?php //echo $subject; ?></singleline>
                    </p>
                    <div align="left" width="580" class="article-content w580" style=" word-wrap: break-word; width: 580px;">
                      <multiline label="Description" width="580">
                      <?php echo $body; ?>
                      </multiline>
                      <!-- DATOS GIFT CARD ON -->
                      <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageCardBlock">
                          <tbody class="mcnImageCardBlockOuter">
                              <tr>
                                  <td class="mcnImageCardBlockInner" valign="top" style="padding-top:9px; padding-right:18px; padding-bottom:9px; padding-left:18px;">

                                      <table align="right" border="0" cellpadding="0" cellspacing="0" class="mcnImageCardBottomContent" width="100%" style="border: 1px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255);">
                                          <tbody>
                                              <tr>
                                                  <td class="mcnImageCardBottomImageContent" align="left" valign="top" style="padding-top:18px; padding-right:18px; padding-bottom:0; padding-left:18px; font-family: Helvetica; text-align:center;">
                                                      <img alt="Giftcard" src="http://personaling.com/contenido_estatico/giftcards/<?php echo $model->plantilla_url ?>_x470.jpg" width="470" style="max-width:470px;" >


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
                                                                                      <span style="font-size:42px; color:#231f20;"><?php echo $model->monto.' '.Yii::t('contentForm', 'currSym'); ?> </span><br>
                                                                                      <br>
                                                                                      <span style="color:#9b9894;">Código:  </span><br>
                                                                                      <span style="font-size: 14px; color: #000;"><?php echo $model->getCodigo() ?></span>
                                                                                  </td>
                                                                                  <td valign="top" style="padding-top:9px; padding-right:9px; padding-bottom:9px; padding-left:9px;" width="263">
                                                                                      <br>
                                                                                      <strong>Para: </strong><span><?php echo " ".$envio->nombre ?></span>
                                                                                      <br>
                                                                                      <strong>Mensaje: </strong><span><?php echo " ".$envio->mensaje ?></span>
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
                                                      Válida desde <strong><?php echo date("d-m-Y", $model->getInicioVigencia()) ?></strong> hasta <strong><?php echo date("d-m-Y", $model->getFinVigencia()) ?></strong>
                                                  </td>
                                              </tr>                                                              
                                          </tbody>
                                      </table>


                                  </td>
                              </tr>
                          </tbody>
                      </table>
                      <!-- DATOS GIFT CARD OFF -->
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="w580" width="580" height="10"></td>
                </tr>
                <tr>
                  <td class="w580" width="580" height="10"></td>
                </tr>
                <tr>
                  <td class="w580" width="580" height="10"></td>
                </tr>                                                                
                <tr>
                  <td class="w580" width="580" height="10" style="text-align:center;">
                    <a title="¡Aplica tu gift card aquí!" href="http://<?php echo $_SERVER['HTTP_HOST'].Yii::app()->baseUrl ?>/giftcard/aplicar" style="text-align:center;text-decoration:none;color:#ffffff;word-wrap:break-word;background: #231f20; padding: 12px;" target="_blank">¡Aplica tu gift card aquí!
                    </a>
                  </td>
                </tr>
                <tr>
                  <td class="w580" width="580" height="10"></td>
                </tr>
                <tr>
                  <td class="w580" width="580" height="10"></td>
                </tr>                                  
              </tbody>
            </table>
          </layout>
        </repeater></td>
      <td class="w30" width="30"></td>
    </tr>
  </tbody>
</table>