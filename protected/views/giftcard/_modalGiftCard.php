<?php $model = Giftcard::model()->findByPk($id); ?>
<style>
    .margin_zero{
        margin: 0px;
    }
</style>
<!--<div class="span5 box_shadow_personaling padding_medium margin_zero">-->
   

    <div class="contenedorPreviewGift text_align_center" >
        <img src="<?php echo Yii::app()->baseUrl."/images/giftcards/{$model->plantilla_url}_x470.jpg"; ?>" width="470">
        <div class="row-fluid margin_top">
            <div class="span6 braker_right">
                <div class=" T_xlarge color1" id="monto"><?php echo $model->monto; ?> Bs.</div>

                <div class="margin_top color4" id="codigo"><div class="color9">Código</div> <?php echo $model->getCodigo(); ?> </div>
            </div>
            <div class="span6">
<!--                <strong  id="forpara">Para:</strong>&nbsp;<span id="para"></span>
                <div>
                    <strong  id="formensaje">Mensaje:</strong>&nbsp;<span class="" id="mensaje"></span>
                </div>                        -->
                <div class="span6">
                    <?php 

                    $this->widget("bootstrap.widgets.TbButton", array(
                       'buttonType' => "link" ,
                       'type' => "danger" ,
                       'icon' => "print white" ,
                       'label' => "Imprimir" ,
                       'url' => "javascript:printElem('#divImprimir')" ,
                    ));

                    ?>
                </div>
                <div class="span6">
                    
                </div>

            </div>
        </div>
        <div class="text_center_align margin_bottom_minus margin_top_small">
            <span class=" t_small" id="fecha">
                Válida desde <strong><?php echo date("d/m/Y", $model->getInicioVigencia()); ?> </strong> hasta el 
                <strong><?php echo date("d/m/Y", $model->getFinVigencia()); ?> </strong>
            </span>                        
        </div>
    </div>
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
                              <img alt="" src="<?php echo Yii::app()->baseUrl."/images/giftcards/{$giftcard->plantilla_url}_x531.jpg"; ?>" width="470" style="max-width:470px;" class="mcnImage blockDropTarget" id="mojo_neapolitan_preview_ImageUploader_281" widgetid="mojo_neapolitan_preview_ImageUploader_281">

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
                                                              <span style="font-size:42px; color:#6d2d56;"><?php echo $giftcard->monto ?> Bs</span><br>
                                                              <br>
                                                              <span style="color:#9b9894;">Código:  </span><br>
                                                              <span style="font-size: 14px; color: #000;"><?php echo $giftcard->getCodigo() ?></span>
                                                          </td>
                                                          <td valign="top" style="padding-top:9px; padding-right:9px; padding-bottom:9px; padding-left:9px;" width="263">
                                                              <br>
                                                              <strong>Para: </strong><span> <?php echo  $envio->nombre ?></span>
                                                              <br>
                                                              <strong>Mensaje:</strong><span><?php echo $envio->mensaje ?></span>
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
                              Válida desde <strong><?php echo date("d-m-Y", $giftcard->getInicioVigencia()) ?></strong> hasta <strong><?php echo date("d-m-Y", $giftcard->getFinVigencia()) ?></strong>
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
<!--</div>-->

