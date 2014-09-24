<!-- 
     tipopago 1: transferencia
     tipopago 2: Tarjeta credito
     tipopago 3: puntos o tarjeta de regalo 
     tipopago 4: MercadoPago
     tipopago 5: Tarjeta Aztive
     tipopago 6: PayPal
     tipopago 7: Saldo
-->
<?php
Yii::app()->clientScript->registerLinkTag('stylesheet','text/css','https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700',null,null);

$this->setPageTitle(Yii::app()->name . " - " . Yii::t('contentForm', 'Payment method'));

if (!Yii::app()->user->isGuest) { // que este logueado

?>
<?php $idDireccion = Yii::app()->getSession()->get('idDireccion'); ?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
                                        'id'=>'tarjeta-form',
                                        'enableAjaxValidation'=>false,
                                        'enableClientValidation'=>true,
                                        'clientOptions'=>array(
                                                'validateOnSubmit'=>true, 
                                        ),
                                        'htmlOptions'=>array('class'=>''),
                                )); 
                                ?>
<style>
    .siguiente{
        text-align: center;
        margin-bottom: 0;
        padding-bottom: 0;
        margin-top: 0px;
        
    }
</style>
<div class="container margin_top">
  <div class="progreso_compra">
    <div class="clearfix margin_bottom">
      <div class="first-past"><?php echo Yii::t('contentForm','Authentication'); ?></div>
      <div class="middle-past dos">
        <?php echo Yii::t('contentForm','Shipping <br/>and billing<br/> address'); ?>
    </div>
      <div class="middle-done tres">
        <?php echo Yii::t('contentForm','Payment <br> method'); ?>
    </div>
      <div class="last-not_done">
        <?php echo Yii::t('contentForm','Confirm <br>purchase'); ?>
    </div>
    </div>
  </div>
  <div class="row">
    <section class="span7">
    	

      <!-- Forma de pago ON -->

        <div class="box_1 padding_small margin_bottom">
                <h4 class="braker_bottom margin_bottom_medium "><?php echo Yii::t('contentForm','Choose the payment method'); ?>
                    <br>
                    <?php
                        $userObject = User::model()->findByPk($user);
                        $nombre = $user ? $userObject->profile->first_name." ".$userObject->profile->last_name:"";
                        echo $admin? "(".Yii::t('contentForm','Order for the user')." <strong>{$nombre}</strong>)":"";
                    ?>
                </h4>
       <!--
       <input type="radio" name="optionsRadios" id="mercadopago" value="option4" data-toggle="collapse" data-target="#mercadoPago">
        <button type="button" id="btn_mercadopago" class="btn btn-link" data-toggle="collapse" data-target="#mercadoPagoCol"> MercadoPago </button>
       -->
            <div class="accordion" id="accordion2">
                <?php 
                if(Yii::app()->params['metodosPago']['mercadopago']){                
                ?>
                    <div class="accordion-group">
                            <div class="accordion-heading">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" id="btn_mercadopago">
                                            <label class="radio">
                                                    <input type="radio" name="optionsRadios" id="mercadopago" value="option4"> MercadoPago
                                                    </label>
                                            </a>
                                    </div>
                            <div class="padding_left margin_bottom_medium collapse" id="collapseOne">
                                    <div class="well well-small" >
                                    Haz click en "Completar compra" para continuar. <?php //echo 'Pago: '.Yii::app()->getSession()->get('tipoPago'); ?>
                                    </div>

                            </div>
                    </div>
                <?php                 
                } ?>

                <?php 
                //DEPOSITO O TRANSFERENCIA
                if(Yii::app()->params['metodosPago']['depositoTransferencia']){                
                ?>
                <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" id="btn_deposito">
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="deposito" value="option1"> 
                                    <?php echo Yii::t('contentForm', 'Deposit or Transference'); ?>
                                </label>
                            </a>
                        </div>
                        <div class="padding_left margin_bottom_medium collapse" id="collapseTwo">
                            <div class="well well-small" >
                                <?php echo Yii::t('contentForm', 'Bank information'); ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                 
                <?php 
                //INSTAPAGO
                if(Yii::app()->params['metodosPago']['instapago']){                
                ?>
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTree" id="btn_tarjeta">
                                <label class="radio">
                                    <input type="radio" name="optionsRadios" id="tarjeta" value="option2"> 
                                    <?php echo Yii::t('contentForm', 'Credit Card'); ?>

                                </label>
                            </a>
                        </div>
                        <div class="collapse" id="collapseTree">
                            <div class="well well-small" >
                                <!-- Haz click en "Completar compra" para continuar. <?php //echo 'Pago: '.Yii::app()->getSession()->get('tipoPago');  ?> -->
                                <h5 class="braker_bottom"><?php echo Yii::t('contentForm', 'Details of your credit card'); ?></h5>            
                                <div class="control-group"> 
                                    <div class="controls">
                                        <?php echo $form->textFieldRow($tarjeta, 'nombre', array('class' => 'span5', 'placeholder' => Yii::t('contentForm', 'Name printed on the credit card')));
                                        ?>
                                        <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                                    </div>
                                </div>

                                <div class="control-group"> 
                                    <div class="controls">
                                        <?php echo $form->textFieldRow($tarjeta, 'numero', array('class' => 'span5', 'placeholder' => Yii::t('contentForm', 'Card numbers')));
                                        ?>
                                        <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                                    </div>
                                </div>

                                <div class="control-group"> 
                                    <div class="controls">
                                        <?php echo $form->textFieldRow($tarjeta, 'codigo', array('class' => 'span2', 'placeholder' => Yii::t('contentForm', 'Security Code')));
                                        ?>
                                        <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <?php echo Yii::t('contentForm', 'Expiration'); ?> *
                                    <div class="controls">
                                        <?php echo $form->dropDownList($tarjeta, 'month', array('0' => 'Mes', '01' => '01', '02' => '02', '03' => '03', '04' => '04', '05' => '05', '06' => '06', '07' => '07', '08' => '08', '09' => '09', '10' => '10', '11' => '11', '12' => '12'), array('class' => 'span1', 'placeholder' => Yii::t('contentForm', 'Month'))); ?>
                                        <?php echo $form->dropDownList($tarjeta, 'year', array('0' => 'Año', '2013' => '2013', '2014' => '2014', '2015' => '2015', '2016' => '2016', '2017' => '2017', '2018' => '2018', '2019' => '2019', '2020' => '2020'), array('class' => 'span1', 'placeholder' => Yii::t('contentForm', 'Year'))); ?>
                                        <?php echo $form->hiddenField($tarjeta, 'vencimiento'); ?>
                                        <?php echo $form->error($tarjeta, 'vencimiento'); ?>

                                    </div>
                                </div>

                                <div class="control-group"> 
                                    <div class="controls">
                                        <?php echo $form->textFieldRow($tarjeta, 'ci', array('class' => 'span5', 'placeholder' => Yii::t('contentForm', 'Identity card')));
                                        ?>
                                        <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                                    </div>
                                </div>

                                <div class="control-group"> 
                                    <div class="controls">
                                        <?php echo $form->textFieldRow($tarjeta, 'direccion', array('class' => 'span5', 'placeholder' => Yii::t('contentForm', 'Address')));
                                        ?>

                                    </div>
                                </div>            	

                                <div class="control-group"> 
                                    <div class="controls">
                                        <?php echo $form->textFieldRow($tarjeta, 'ciudad', array('class' => 'span5', 'placeholder' => Yii::t('contentForm', 'City')));
                                        ?>

                                    </div>
                                </div>			

                                <div class="control-group"> 
                                    <div class="controls">
                                        <?php echo $form->textFieldRow($tarjeta, 'estado', array('class' => 'span5', 'placeholder' => Yii::t('contentForm', 'Province')));
                                        ?>
                                        <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                                    </div>
                                </div>	

                                <div class="control-group"> 
                                    <div class="controls">
                                        <?php echo $form->textFieldRow($tarjeta, 'zip', array('class' => 'span2', 'placeholder' => Yii::t('contentForm', 'Zip code')));
                                        ?>
                                        <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                                    </div>
                                </div>		          					

                                <?php echo CHtml::hiddenField('idDireccion', Yii::app()->getSession()->get('idDireccion'));
                                $direccion = Direccion::model()->findByPk(Yii::app()->getSession()->get('idDireccion'));
                                ?>
                                <div class="text_center_align">
                                    <p><?php echo Yii::t('contentForm', 'This transaction will be processed securely through the platform:'); ?>:</p>	
                                    <img src="<?php echo Yii::app()->baseUrl ?>/images/Instapago-logo.png" width="77">
                                    <img src="<?php echo Yii::app()->baseUrl ?>/images/Banesco-logo.png" width="77">
                                </div>								
                                <div class="form-actions">
                                    <?php
                                    $this->widget('bootstrap.widgets.TbButton', array(
                                        'buttonType' => 'submit',
                                        'type' => 'warning',
                                        'size' => 'large',
                                        'label' => Yii::t('contentForm', 'Next'),
                                    ));
                                    //  <a href="Proceso_de_Compra_3.php" class="btn-large btn btn-danger">Usar esta dirección</a> 
                                    ?>
                                </div>


                            </div>	
                        </div>
                    </div>
                <?php }
				echo Yii::app()->params['metodosPago']['bkCard']."<br>";
				echo Yii::app()->params['metodosPago']['instapago']."<br>";
				echo Yii::app()->params['metodosPago']['depositoTransferencia'];				
				?>
                
                <?php 
                //Banking Card Aztive
                if(Yii::app()->params['metodosPago']['bkCard']){ 
                ?>                
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <label class="radio accordion-toggle margin_left_small" data-parent="#accordion2">
                            <input type="radio" name="optionsRadios" id="bankCard" checked="true" value="5"> 
                            <?php echo Yii::t('contentForm', 'Credit Card'); ?>
                        </label>                       
                       
                    </div>
                    
                </div>
                <?php } ?>
                
                <?php 
                //Paypal Aztive
                if(Yii::app()->params['metodosPago']['paypal']){ 
                ?>                
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <label class="radio accordion-toggle margin_left_small"
                           data-parent="#accordion2">
                            <input type="radio" name="optionsRadios" id="payPal" value="6"> 
                            <?php echo Yii::t('contentForm', 'PayPal'); ?>
                        </label>                        
                    </div>
                    <div id="collapseT" class="accordion-body collapse">
                    </div>
                    
                </div>
                <?php } ?>
                <?php 
                //Aztive de prueba
                if(isset(Yii::app()->params['metodosPago']['prueba'])){ 
                ?>                
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <label class="radio accordion-toggle margin_left_small"
                           data-parent="#accordion2">
                            <input type="radio" name="optionsRadios" id="prueba" value="8"> 
                            <?php echo Yii::t('contentForm', 'Para probar las compras'); ?>
                        </label>                        
                    </div>
                    <div id="collapseT" class="accordion-body collapse">
                    </div>
                    
                </div>
<!--                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse"
                           data-parent="#accordion2" href="#collapseFive" id="btn_payPal">
                            <label class="radio">
                                <input type="radio" name="optionsRadios" id="payPal" value="option6"> 
                                <?php echo Yii::t('contentForm', 'PayPal'); ?>
                            </label>
                        </a>
                    </div>
                    
                </div>-->
                <?php } ?>
                

            </div>
            </div>
 
    </section>
    <style>
        td.text_align_right{
            text-align: right;
        }
    </style>
    <div class="span5 margin_bottom">
    	
      <div class="margin_left">
        <div id="resumen" class="well well_personaling_big ">
          <h4><?php echo Yii::t('contentForm','Summary of the purchase'); ?></h4>
          <div class="">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
              <tr id="adentro">                
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed " id="tabla_resumen">
              <tr>
                <th class="text_align_left"><?php echo Yii::t('contentForm','Subtotal'); ?>:</th>
                <td class="text_align_right"><?php
                  $envio = 0;
                  $peso_total = 0;
                  $tipo_guia = 0;
                  $bolsa = Bolsa::model()->findByAttributes(array('user_id'=>$user,'admin'=>$admin));


                  //busco productos individuales en la bolsa
                  $bptcolor = BolsaHasProductotallacolor::model()->findAllByAttributes(array('bolsa_id'=>$bolsa->id,'look_id'=> 0));
                  foreach($bptcolor as $productotallacolor){
                                $producto = Producto::model()->findByPk($productotallacolor->preciotallacolor->producto_id);
                                $peso_total += ($producto->peso*$productotallacolor->cantidad); 
                  }

                  // busco looks en la bolsa
                  $sql = "select count( * ) as total from tbl_bolsa_has_productotallacolor where look_id != 0 and bolsa_id = ".$bolsa->id."";
                  $num = Yii::app()->db->createCommand($sql)->queryScalar();
                  $nproductos=0;
                  if($num!=0){
                        foreach ($bolsa->looks() as $look_id){
                                $bolsahasproductotallacolor = BolsaHasProductotallacolor::model()->findAllByAttributes(array('bolsa_id'=>$bolsa->id,'look_id' => $look_id));
                                //$look = Look::model()->findByPk($look_id);
                                foreach($bolsahasproductotallacolor as $productotallacolor){
                                        $producto = Producto::model()->findByPk($productotallacolor->preciotallacolor->producto_id);
                                        $peso_total += ($producto->peso*$productotallacolor->cantidad); 
                                        $nproductos=$nproductos+$productotallacolor->cantidad;
                                }
                        }
                  }

                $direccion = Direccion::model()->findByPk($idDireccion);
                $ciudad_destino = Ciudad::model()->findByPk($direccion->ciudad_id); 


//                    if (!empty($precio))
//                        foreach ($precios as $i => $x)
//                            $totalPr+=$x*$cantidades[$i];
			
                //$i=0;
                $seguro=0;
                //subtotal sin iva
                $totalPr = Yii::app()->getSession()->get('subtotal');                
                
                /*Calcular iva segun la ciudad de envio */
                $exento = $direccion->ciudad->provincia->pais->exento;
                if($exento)
                {
                    Yii::app()->getSession()->add("iva", 0); //no hay iva                        
                }

                $IVA = Yii::app()->getSession()->get('iva');

                //Sumar todo mas IVA
                $totalConIVA = $totalPr + $IVA;
                
                /****OJO - recalcularlo para productos sin iva*****/
                $totalDe = Yii::app()->getSession()->get('descuento');
                
                //Restarle los descuentos                        
                $total = $totalConIVA - $totalDe;  

                /*Calcular si hay envio o no*/
                $shipping=true;

                if(Yii::app()->params['noShipping']==0)
                {
                    $shipping=true;
                }
                else{

                    if($total>Yii::app()->params['noShipping']){
                            $shipping=false;
                    }

                }

                if($ciudad_destino->ruta_id==9)
                        $shipping=true;

                    if($shipping){
                            if(!is_null($ciudad_destino->cod_zoom)&&$ciudad_destino->cod_zoom!=0)
                            {	
                                            $flete=Orden::model()->calcularTarifa($ciudad_destino->cod_zoom,count($bolsa->bolsahasproductos),$peso_total,$total);

                                            if(!is_null($flete)){


                                                    $envio=$flete->total-$flete->seguro;
                                                    $seguro=str_replace(',','.',$flete->seguro);


                                            }else{
                                                    $envio =Tarifa::model()->calcularEnvio($peso_total,$ciudad_destino->ruta_id);
                                                    $seguro=$envio*0.13;
                                            }


                                            $tipo_guia = 1;
                                   
                            }
                            else{
                                    $seur=Tarifa::model()->envioSeur($ciudad_destino->nombre, $direccion->codigopostal->codigo, $peso_total);
                                    if(!is_null($seur)){

                                            $envio =floatval($seur['porte'])+floatval($seur['iva'])+floatval($seur['combustible']);

                                            $seguro=0;
                                    }
                                    else {
                                            $envio =Tarifa::model()->calcularEnvio($peso_total,$ciudad_destino->ruta_id);
                                            $seguro=0;
                                    } 



                            }
                    }
                    else{
                            $envio=0;
                            $seguro=0;
                    }			
                        
                //Sumar el ENVIO
                $total += $envio;
                
                // Agregar las variables de sesion
                //Yii::app()->getSession()->add('subtotal',$totalPr);
                //Yii::app()->getSession()->add('descuento',$totalDe);
                Yii::app()->getSession()->add('envio',$envio);
                Yii::app()->getSession()->add('totalConIva', $totalConIVA);
                //Yii::app()->getSession()->add('iva',$iva); YA esta
                Yii::app()->getSession()->add('total',$total);
                Yii::app()->getSession()->add('seguro',$seguro);
                Yii::app()->getSession()->add('tipo_guia',$tipo_guia);
                Yii::app()->getSession()->add('peso',$peso_total);

						
                echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($totalPr, '');
              ?>
               </td>  
              </tr>          
            
              <?php 
              /*if(!$direccion->ciudad->provincia->pais->exento){
              ?>
                <tr>
                  <th class="text_align_left"><?php echo Yii::t('contentForm','I.V.A'); ?>: (<?php echo Yii::app()->params['IVAtext'];?>):</th>
                  <td><?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency($iva, ''); ?></td>
                </tr>
                    <?php }
                    else{
                            $t=$t-$iva;
                            $iva=0;	


              }*/
              ?>
              
              <tr>
                  <th class="text_align_left"><?php echo Yii::t('contentForm','I.V.A'); ?>: (<?php echo Yii::app()->params['IVAtext'];?>):</th>
                  <td class="text_align_right"><?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency($IVA, ''); ?></td>
              </tr>
              
              <?php if($totalDe != 0){ // si HAY descuento ?> 
              <tr>
                <th class="text_align_left"><?php echo Yii::t('contentForm','Discount'); ?>:</th>
                <td class="text_align_right" id="descuento"><?php echo "- ".Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($totalDe, ''); ?></td>
              </tr>
              <?php } ?>
              
              
              <tr>
                <th class="text_align_left"><?php echo Yii::t('contentForm','Shipping');
				
				?>:</th>
                <td class="text_align_right"><?php 
                if($shipping)
                	echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($envio, ''); 
                else
                	echo "<b class='text-success'>GRATIS</b>"; ?></td>
              </tr>
              <tr>
                <th class="text_align_left"><?php echo Yii::t('contentForm','Used Balance:'); ?></th>
                <td class="text_align_right" id="descuentoBalance"><?php echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency(0, ''); ?></td>
              </tr>
              <tr>
                <th class="text_align_left"><h4><?php echo Yii::t('contentForm','Total'); ?>:</h4></th>
                <td class="text_align_right"><h4 id="precio_total"><?php echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($total, ''); ?></h4></td>
              </tr>
            </table>

            <div id="precio_total_hidden" style="display: none;"><?php echo $total; ?></div>
            <?php            
			
                $balance=Profile::getSaldo($user);
                $balance = floor($balance *100)/100;
                $class = "";		

                if($balance <= 0){
                    $class = " hidden";
                }
	    ?>
            <div class="promociones">
                <!-- FLASH ON --> 
                <?php $this->widget('bootstrap.widgets.TbAlert', array(
                        'block'=>true, // display a larger alert block?
                        'fade'=>true, // use transitions?
                        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
                        'alerts'=>array( // configurations per alert type
                            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
                            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
                        ),
                    )
                ); ?>	
                <!-- FLASH OFF -->
                
                <?php if(true || $balance > 0){ ?>  
                <label class="radio<?php echo $class ?>" id="opt-balance">
                      <input type="radio" name="opcionSaldo" id="radio-Saldo" value="1" onclick="usarBalance(<?php echo $total; ?>)">
                      <?php
                        if($admin){
                            echo Yii::t('contentForm', 'Use Balance.'); ?><br>
                            <?php echo Yii::t ('contentForm', 'Avaliable for {user}:', 
                                    array("{user}"=>$nombre)) ?>
                            <strong> <?php echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($balance, ''); ?></strong>
                        <?php                 
                        }else{
                            echo Yii::t('contentForm', 'Use Balance available:'); ?> <strong><?php echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($balance, ''); ?></strong>                    
                        <?php } ?>
                    </label>
                <?php } ?>
                <label class="radio" id="opt-codigo">
                  <input type="radio" name="opcionSaldo" id="radio-Cupon" value="2" onclick="usarCupon()">
                    <?php
                        echo Yii::t('contentForm', 'Tengo un código de descuento!'); 
                    ?>
                </label>
                <div class="padding_left_small margin_top_medium row-fluid" style="display:none" id="collapse-cupon">
                    <?php echo CHtml::label("Ingresa tu código aquí: ", "textoCodigo"); ?>    
                    <?php echo CHtml::textField("textoCodigo"); ?>
                </div>
                
                <?php if(false){ ?>

                <label class="checkbox<?php echo $class; ?>">
                <input type="checkbox" name="usar_balance" id="usar_balance" value="1" onclick="calcular_total(<?php echo $total; ?>, <?php echo $balance; ?>)" />
                <?php
                if($admin){
                    echo Yii::t('contentForm', 'Use Balance.'); ?><br>
                    <?php echo Yii::t ('contentForm', 'Avaliable for {user}:', 
                            array("{user}"=>$nombre)) ?>
                    <strong> <?php echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($balance, ''); ?></strong>
                <?php                 
                }else{
                    echo Yii::t('contentForm', 'Use Balance available:'); ?> <strong><?php echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($balance, ''); ?></strong>                    
                <?php } ?>
                
              </label>
                <?php } ?>
            </div>
	    
            <?php 
            /*Si es admin no mostrar el boton de agregar giftcard*/
            if(!$admin){
            ?>
             <button type="button" class="btn btn-success margin_top_medium" 
                     data-toggle="collapse" data-target="#collapse2">
                 <i class = "icon-gift icon-white"></i> <?php echo Yii::t('contentForm','Redeem Gift Card'); ?></button> 
            
           
            <!-- Aplicar Gifcard ON -->
            <div class="padding_left_small margin_top_medium collapse row-fluid" id="collapse2">
              
                <!--[if lte IE 7]>
                    <label class="control-label required">Numero de la tarjeta de Regalo <span class="required">*</span></label>
                <![endif]-->
                
               <div id="giftCard">
               <div class="control-group" id="camposGC">						
                    <div class="controls">
                        <?php echo CHtml::activeLabel($model, "campo1"); ?>

                        <?php echo CHtml::activeTextField($model, "campo1", array('class' => 'input-mini margin_left_small',
                            'maxlength'=>'4')); ?> <span>-</span>                                                        
                        <?php echo CHtml::activeTextField($model, "campo2", array('class' => 'input-mini',
                            'maxlength'=>'4')); ?> <span>-</span>                                                        
                        <?php echo CHtml::activeTextField($model, "campo3", array('class' => 'input-mini',
                            'maxlength'=>'4')); ?> <span>-</span>                                                        
                        <?php echo CHtml::activeTextField($model, "campo4", array('class' => 'input-mini',
                            'maxlength'=>'4')); ?>

                    </div>						
               </div>
                
                    <div class="span11 alert in" id="alert-msg" style="display: none">
                      <button type="button" class="close" >&times;</button> 
                      <!--data-dismiss="alert"-->
                      <div class="msg"></div>
                    </div>
                
               <input type="hidden" id="aplicarAjax" name="aplicarAjax" /> 
<!--               <input type="submit" name="aplicarGC" class="btn btn-mini">Aplicar Gift Card</input>-->
               <button type="button" id="aplicarGC" class="btn btn-mini btn-danger"><?php echo Yii::t('contentForm','Apply Gift Card'); ?></button>
               <?php // $this->endWidget(); // formulario ?>      
               </div>     
<!--                <div class="span12">
                    
                </div>
                <div class="span12">

                </div>
                <input type="text" maxlength="128"  placeholder="Numero de la tarjeta de Regalo"  class="span3">
                <a href="Crear_Perfil_Usuaria_Mi_Tipo.php" class="btn btn-mini">Aplicar</a>-->
              
            </div>
            <!-- Aplicar Gifcard OFF -->
            <?php } ?>
            <input type="hidden" id="tipo_pago" name="tipo_pago" value="5" />
            <input type="hidden" id="usar_balance_hidden" name="usar_balance_hidden" value="0" />
            <input type="hidden" id="conSeguro" name="conSeguro" value="0" />
            <div class="form-actions siguiente">
              <?php $this->widget('bootstrap.widgets.TbButton', array(
	            'type'=>'warning',
	            'size'=>'large',
	            'label'=>Yii::t('contentForm','Next'),
	            //'url'=>'confirmar', // action
	            'icon'=>'lock white',
	            'buttonType'=>'submit',
	           // 'htmlOptions'=>array('onclick'=>'tarjetas()',),
	        ));
        // <a id="completar-compra" class="btn btn-danger"><i class="icon-shopping-cart icon-white"></i> Completar compra</a>
        ?>
            </div>

          </div>
        </div>
      </div>
      		      
      
      
    </div>
  </div>
</div>
<!-- /container -->
 <?php $this->endWidget(); // formulario ?> 
<?php

}// si esta logueado
else
{
    // redirecciona al login porque se murió la sesión
    header('Location: /user/login');
}
?>

<script>
	
    var balanceUsuario = <?php echo $balance; ?>;
	
        $("#aplicarGC").click(function(e){
            $("#aplicarAjax").val("1");
                        
            var datos = $("#giftCard").find("input").serialize();
            //("#giftCard").find(".controls input").prop("disabled", true);
            $("body").addClass("aplicacion-cargando");
           
            $.ajax({
                type: 'POST',
                url: '<?php echo CController::createUrl("/giftcard/aplicar"); ?>',
                dataType: 'JSON',
                data: datos,
                success: function(data){                    
                    //si son dos errores agregar ul
                    if(data.length > 1){
                        
                        var contenido = "<ul>";
                        
                        $.each(data, function(i, dato){
                            contenido += "<li>" + (dato.message) + "</li>";
                         });
                         
                        contenido += "</ul>";
                         
                        showAlert("error", contenido);
                        
                    }else{
                        
                        if(data[0].type == 'success'){ //si fue success la aplicacion de GC
                            
                            var radioB = $("#radio-Saldo");
                            
                            var element = radioB.next();

                            element.parent().removeClass("hidden");
                            element.animate({                                  
                              opacity: 0,
                            }, {
                                duration: 1000,
                                complete: function(){                                   
                                    //Agregar el saldo por si selecciona usar saldo
                                    balanceUsuario = data[0].amount;
                                    element.text("<?php  echo Yii::t('backEnd', 'currSym'); ?> " + data[0].amount);
                                    showAlert(data[0].type, data[0].message);
                                }
                            } );                                

                            element.animate({                                  
                              opacity: 1,
                              //color : "#468847",
                            }, 1000 );

                        }else{
                            showAlert(data[0].type, data[0].message);  
                        }
                        
                    }
                    
                    $("body").removeClass("aplicacion-cargando");                   
                    
                }
            });    
            
            
            
        });

    //Mostrar alert
    function showAlert(type, message){
       $('#alert-msg').removeClass('alert-success alert-error alert-warning') ;
       $('#alert-msg').addClass("alert-"+type);
       $('#alert-msg').children(".msg").html(message);
       $('#alert-msg').show();

       $("#camposGC").removeClass('success error warning');
       $('#camposGC').addClass(type);

    }

    $(".alert").alert();
    $(".alert .close").click(function(){
        $(".alert").fadeOut('slow');
    });
        
        
    $(document).ready(function() {

////***** RAFA ******///////
$('#TarjetaCredito_month').change(function(){
	if (($('#TarjetaCredito_year').val()!=0) && ($('#TarjetaCredito_month').val()!=0))
		//alert('hola');
		//alert($('#TarjetaCredito_month').val()+'/'+ $('#TarjetaCredito_year').val())
		$('#TarjetaCredito_vencimiento').val( $('#TarjetaCredito_month').val()+'/'+ $('#TarjetaCredito_year').val() );
	
});
$('#TarjetaCredito_year').change(function(){
	if (($('#TarjetaCredito_year').val()!=0) && ($('#TarjetaCredito_month').val()!=0))
		//alert('hola');
		//alert($('#TarjetaCredito_month').val()+'/'+ $('#TarjetaCredito_year').val())
		$('#TarjetaCredito_vencimiento').val($('#TarjetaCredito_month').val()+'/'+$('#TarjetaCredito_year').val());
	
});
///******** FIN RAFA **********//////
        $("#deposito").click(function() {
        	
            var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> Depósito o Transferencia Bancaria.</td>";
            $("#adentro").html(añadir);
            $("#tipo_pago").val('1');
            $("#deposito").prop("checked", true);
            // haciendo que no valide
	        disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'nombre');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'numero');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'codigo');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ci');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'direccion');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ciudad');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'estado');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'zip');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'month');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'year');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'vencimiento');
            
        });
        
        $("#mercadopago").click(function() {
            var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> MercadoPago.</td>";
            $("#adentro").html(añadir);
            $("#tipo_pago").val('4');
             $("#mercadopago").attr('checked', true);
            // haciendo que no valide
	        disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'nombre');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'numero');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'codigo');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ci');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'direccion');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ciudad');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'estado');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'zip');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'month');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'year');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'vencimiento');
            
        });
        
        $("#tarjeta").click(function() {
            var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> Tarjeta de Crédito.</td>";
            $("#adentro").html(añadir);
            $("#tipo_pago").val('2');
            $("#tarjeta").attr('checked', true);

            enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'nombre');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'numero');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'codigo');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ci');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'direccion');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ciudad');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'estado');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'zip');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'month');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'year');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'vencimiento');
            
        });
        
        $("#btn_mercadopago").click(function() {
            var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> MercadoPago.</td>";
            $("#adentro").html(añadir);
            $("#tipo_pago").val('4');
            $("#mercadopago").prop("checked", true);
        });
        
        $("#btn_deposito").click(function() {
        	var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> Depósito o Transferencia Bancaria.</td>";
            $("#adentro").html(añadir);
        	//$("#deposito").attr('checked', 'checked');
        	$("#deposito").prop("checked", true);
        	$("#tipo_pago").val('1');
        	 
        	// haciendo que no valide
	        disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'nombre');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'numero');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'codigo');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ci');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'direccion');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ciudad');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'estado');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'zip');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'month');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'year');
        	disableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'vencimiento');
        });
        
        $("#btn_tarjeta").click(function() {
        	 var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> Tarjeta de Crédito.</td>";
            $("#adentro").html(añadir);
        	$("#tarjeta").prop("checked", true);
        	$("#tipo_pago").val('2');
        	
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'nombre');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'numero');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'codigo');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ci');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'direccion');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'ciudad');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'estado');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'zip');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'month');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'year');
        	enableFieldsValidation($('#tarjeta-form'), 'TarjetaCredito', 'vencimiento');
        	
        });
        
        $("input[name='optionsRadios']").change(function(e){
            
            if($(this).is(":checked"))
            {
                var tipoPago = "<td valign='top'><i class='icon-exclamation-sign'></i> ";
                //si es bankCard
                if($(this).val() == 5){
                    
                    tipoPago += "<?php echo 
                    Yii::t('contentForm', 'Credit Card'); ?> </td>";
                    
                }else if($(this).val() == 6){ //si es paypal
                    
                    tipoPago += "<?php echo 
                    Yii::t('contentForm', 'PayPal'); ?> </td>";
                }
                
                $("#adentro").html(tipoPago);        	
                $("#tipo_pago").val($(this).val());            
            
            }
         
        });

    });

	$("#asegurado").change(function(e){
		
		calcular_total(<?php echo $total; ?>, <?php echo $balance; ?>)
		
	});
	
        
	function calcular_total(total, balance){
		 
		if($("#asegurado").is(':checked')){
			total=total+parseFloat($("#asegurado").val());
			$("#conSeguro").val('1');
		}else{
			$("#conSeguro").val('0');
		}
                
		if(balance > 0){
                    
                    if($('#usar_balance').is(':checked')){
                    
                        $('#usar_balance_hidden').val('1');
				
                        if(balance >= total){
                    
                            $('#descuentoBalance').html('<?php echo Yii::t('contentForm','currSym'); ?> '
                            +'<?php echo Yii::app()->numberFormatter->formatCurrency($total, "")?>');                        
                            
                            $('#precio_total').html('<?php echo Yii::t('contentForm','currSym'); ?>'
                                    +'<?php echo Yii::app()->numberFormatter->formatCurrency(0, "")?>');
                            
                        }else{                            
                            $('#descuentoBalance').html('<?php echo Yii::t('contentForm','currSym') . 
                                    " " . Yii::app()->numberFormatter->formatCurrency($balance, "")?>');
                    
                            $('#precio_total').html('<?php echo Yii::t('contentForm','currSym'); ?> '
                                    +'<?php echo Yii::app()->numberFormatter->formatCurrency($total-$balance, "")?>');
                        }
                    }else{
                    
                        $('#usar_balance_hidden').val('0');
                        
                        $('#descuentoBalance').html('<?php echo Yii::t('contentForm','currSym'); ?> '
                            +'<?php echo Yii::app()->numberFormatter->formatCurrency(0, "")?>');
                        
                        $('#precio_total').html('<?php echo Yii::t('contentForm','currSym'); ?> '
                            +'<?php echo Yii::app()->numberFormatter->formatCurrency($total, "")?>');
                    }
		}
		//$('#tabla_resumen').append('<tr><td>Balance usado: </td><td>0 Bs.</td></tr>');
	}
        
        /*NELSON*/        
	function usarCupon(){
		var balance = balanceUsuario;
		if(balance > 0){
                    
                     $('#usar_balance_hidden').val('0');
                        
                     $('#descuentoBalance').html('<?php echo Yii::t('contentForm','currSym'); ?> '
                            +'<?php echo Yii::app()->numberFormatter->formatCurrency(0, "")?>');
                        
                     $('#precio_total').html('<?php echo Yii::t('contentForm','currSym'); ?> '
                            +'<?php echo Yii::app()->numberFormatter->formatCurrency($total, "")?>');
		}
		//$('#tabla_resumen').append('<tr><td>Balance usado: </td><td>0 Bs.</td></tr>');
	}

        function usarBalance(total){
		
                var balance = balanceUsuario;
		if(balance > 0){
                    
                    if(balance >= total){
                    
                            $('#descuentoBalance').html('<?php echo Yii::t('contentForm','currSym'); ?> '
                            +'<?php echo Yii::app()->numberFormatter->formatCurrency($total, "")?>');                        
                            
                            $('#precio_total').html('<?php echo Yii::t('contentForm','currSym'); ?>'
                                    +'<?php echo Yii::app()->numberFormatter->formatCurrency(0, "")?>');
                            
                        }else{                            
                            $('#descuentoBalance').html('<?php echo Yii::t('contentForm','currSym') . 
                                    " " . Yii::app()->numberFormatter->formatCurrency($balance, "")?>');
                    
                            $('#precio_total').html('<?php echo Yii::t('contentForm','currSym'); ?> '
                                    +'<?php echo Yii::app()->numberFormatter->formatCurrency($total-$balance, "")?>');
                        }
		}
	}

        $("#opt-balance").click(function(e){
            $("#collapse-cupon").slideUp();
        });
        $("#opt-codigo").click(function(e){
            $("#collapse-cupon").slideDown();
        });

	function tarjetas()
	{
		//alert("Entró");
		/* lo de la tarjeta */
		//alert($("#tipo_pago").attr("value"));
		
		if($("#tipo_pago").attr("value") == 2){ // tarjeta
			
			var nom = $("#nombre").attr("value");
			var num = $("#numero").attr("value");
			var cod = $("#codigo").attr("value");
			var ci = $("#ci").attr("value");
			var mes = $("#mes").attr("value");
			var ano = $("#ano").attr("value");
			var dir = $("#direccion").attr("value");
			var ciud = $("#ciudad").attr("value");
			var est = $("#estado").attr("value");
			var zip = $("#zip").attr("value");
			
			if(nom=="" || num=="" || cod=="" || mes=="Mes" || ano=="Ano" || ci=="" || dir=="" || ciud=="" || est=="" || zip==""){
				alert("Por favor complete los datos de la tarjeta.");
			}
			else{
				// alert(" nombre: "+nom+", numero"+num+", cod:"+cod+", mes y año "+mes+"-"+ano+", dir "+dir+", ciudad "+ciud+", estado "+est+", zip"+zip);
				$("#datos_tarjeta").submit();
			}
	
		}
		else
		{
			$("#datos_tarjeta").submit();
		}
		
	}
	
	$('#YourCheckbox').click(function() {
	
	    if ($(this).is(':checked'))
	    {
	        enableFieldsValidation($('#my-form'), 'YourModel', 'FirstName');
	        //enableFieldsValidation($('#my-form'), 'YourModel', 'LastName');
	    }
	    else
	    {
	        disableFieldsValidation($('#my-form'), 'YourModel', 'FirstName');
	        //disableFieldsValidation($('#my-form'), 'YourModel', 'LastName');
	    }
	});
	
	function enableFieldsValidation(form, model, fieldName) {

	    // Restore validation for model attributes
	    $.each(form.data('settings').attributes, function (i, attribute) {
	
	        if (attribute.model == model && attribute.id == (model + '_' + fieldName))
	        {
	            if (attribute.hasOwnProperty('disabledClientValidation')) {
	
	                // Restore validation function
	                attribute.clientValidation = attribute.disabledClientValidation;
	                delete attribute.disabledClientValidation;
	
	                // Restore sucess css class
	                attribute.successCssClass = attribute.disabledSuccessCssClass;
	                delete attribute.disabledSuccessCssClass;
	            }
	        }
	    });
	}
	
	function disableFieldsValidation(form, model, fieldName) {
	
	    $.each(form.data('settings').attributes, function (i, attribute) {
	
	        if (attribute.model == model && attribute.id == (model + '_' + fieldName))
	        {
	            if (!attribute.hasOwnProperty('disabledClientValidation')) {
	
	                // Remove validation function
	                attribute.disabledClientValidation = attribute.clientValidation;
	                delete attribute.clientValidation;
	
	                // Reset style of elements
	                $.fn.yiiactiveform.getInputContainer(attribute, form).removeClass(
	                    attribute.validatingCssClass + ' ' +
	                    attribute.errorCssClass + ' ' +
	                    attribute.successCssClass
	                );
	
	                // Reset validation status
	                attribute.status = 2;
	
	                // Hide error messages
	                form.find('#' + attribute.errorID).toggle(false);
	
	                // Dont make it 'green' when validation is called
	                attribute.disabledSuccessCssClass = attribute.successCssClass;
	                attribute.successCssClass = '';
	            }
	        }
	    });
	}
	
</script>

