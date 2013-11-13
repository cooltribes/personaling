<!-- tipopago 1: transferencia
     tipopago 2: Tarjeta credito
     tipopago 3: puntos o tarjeta de regalo -->
<?php
Yii::app()->clientScript->registerLinkTag('stylesheet','text/css','https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700',null,null);
if (!Yii::app()->user->isGuest) { // que este logueado

?>
<?php $idDireccion = Yii::app()->getSession()->get('idDireccion'); ?>

<div class="container margin_top">
  <div class="progreso_compra">
    <div class="clearfix margin_bottom">
      <div class="first-past">Autenticación</div>
      <div class="middle-past">Dirección<br/>
        de envío <br/>
        y facturación</div>
      <div class="middle-done">Método <br/>
        de pago</div>
      <div class="last-not_done">Confirmar<br/>
        compra</div>
    </div>
  </div>
  <div class="row">
    <section class="span7">
      <!-- Forma de pago ON -->
      <div class="box_1 padding_small margin_bottom">
        <h4 class="braker_bottom margin_bottom_medium ">Elige el método de pago</h4>
<!--       <input type="radio" name="optionsRadios" id="mercadopago" value="option4" data-toggle="collapse" data-target="#mercadoPago">
        <button type="button" id="btn_mercadopago" class="btn btn-link" data-toggle="collapse" data-target="#mercadoPagoCol"> MercadoPago </button>
        <div class="padding_left margin_bottom_medium collapse" id="mercadoPagoCol">
          <div class="well well-small" >
            Haz click en "Siguiente" para continuar. <?php //echo 'Pago: '.Yii::app()->getSession()->get('tipoPago'); ?>
          </div>
        </div>-->
        <input type="radio" name="optionsRadios" id="deposito" value="option1" data-toggle="collapse" data-target="#pagoDeposito">
        <button type="button" id="btn_deposito" class="btn btn-link" data-toggle="collapse" data-target="#pagoDeposito"> Depósito o Transferencia </button>
        <div class="padding_left margin_bottom_medium collapse" id="pagoDeposito">
          <div class="well well-small" >
            <h4>Banco Banesco</h4>
            <ul>
              <li><strong>Cuenta Corriente Nº:</strong> 0134-0277-98-2771093092</li>
              <li><strong>Titular de la cuenta: </strong>PERSONALING C.A.</li>
              <li><strong>RIF:</strong> Nº J-40236088-6</li>
              <li><strong>Correo electrónico:</strong> ventas@personaling.com</li>
            </ul>
          </div>
        </div>
        <input type="radio" name="optionsRadios" id="tarjeta" value="option2" data-toggle="collapse" data-target="#pagoTarjeta">
        <button type="button" id="btn_tarjeta" class="btn btn-link" data-toggle="collapse" data-target="#pagoTarjeta"> Tarjeta de Crédito </button>
        <div class="collapse" id="pagoTarjeta">
        	 <div class="well well-small" >
            <!-- Haz click en "Completar compra" para continuar. <?php //echo 'Pago: '.Yii::app()->getSession()->get('tipoPago'); ?> -->
            <h5 class="braker_bottom">Datos de tu tarjeta de crédito</h5>            
      		
      	
			
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
				<div class="control-group"> 
             		<div class="controls">
             			<?php echo $form->textFieldRow($tarjeta,'nombre',array('class'=>'span5','placeholder'=>'Nombre impreso en la tarjeta')); 
              			?>
                	<div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              		</div>
            	</div>
			
				<div class="control-group"> 
             		<div class="controls">
             			<?php echo $form->textFieldRow($tarjeta,'numero',array('class'=>'span5','placeholder'=>'Número de la tarjeta')); 
              			?>
                	<div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              		</div>
            	</div>

				<div class="control-group"> 
             		<div class="controls">
             			<?php echo $form->textFieldRow($tarjeta,'codigo',array('class'=>'span2','placeholder'=>'Código de seguridad')); 
              			?>
                	<div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              		</div>
            	</div>
            				
				<div class="control-group">
					Vencimiento *
             		<div class="controls">
             	<?php echo $form->dropDownList($tarjeta,'month',array('0'=>'Mes','01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12'),array('class'=>'span1','placeholder'=>'Mes')); ?>
                <?php echo $form->dropDownList($tarjeta,'year',array('0'=>'Año','2013'=>'2013','2014'=>'2014','2015'=>'2015','2016'=>'2016','2017'=>'2017','2018'=>'2018','2019'=>'2019','2020'=>'2020'),array('class'=>'span1','placeholder'=>'Año')); ?>
                	<div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              		</div>
            	</div>

				<div class="control-group"> 
             		<div class="controls">
             			<?php echo $form->textFieldRow($tarjeta,'ci',array('class'=>'span5','placeholder'=>'Cedula de Identidad')); 
              			?>
                	<div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              		</div>
            	</div>

				<div class="control-group"> 
             		<div class="controls">
             			<?php echo $form->textFieldRow($tarjeta,'direccion',array('class'=>'span5','placeholder'=>'Dirección')); 
              			?>
                	<div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              		</div>
            	</div>            	

				<div class="control-group"> 
             		<div class="controls">
             			<?php echo $form->textFieldRow($tarjeta,'ciudad',array('class'=>'span5','placeholder'=>'Ciudad')); 
              			?>
                	<div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              		</div>
            	</div>			

				<div class="control-group"> 
             		<div class="controls">
             			<?php echo $form->textFieldRow($tarjeta,'estado',array('class'=>'span5','placeholder'=>'Estado')); 
              			?>
                	<div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              		</div>
            	</div>	
  
				<div class="control-group"> 
             		<div class="controls">
             			<?php echo $form->textFieldRow($tarjeta,'zip',array('class'=>'span2','placeholder'=>'Código Postal')); 
              			?>
                	<div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              		</div>
            	</div>		          					
				
				<?php echo CHtml::hiddenField('idDireccion',Yii::app()->getSession()->get('idDireccion') ); ?>
				
		<div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'warning',
            'size'=>'large',
            'label'=>'Siguiente',
        )); 
        //  <a href="Proceso_de_Compra_3.php" class="btn-large btn btn-danger">Usar esta dirección</a> 
        ?>
            </div>

    </section>
    <?php

//     echo CHtml::hiddenField('idDireccion',$idDireccion);
// echo CHtml::hiddenField('tipoPago','1');
?>
    <?php // Yii::app()->getSession()->add('idDireccion',$idDireccion); ?>
    <?php //Yii::app()->getSession()->add('tipoPago',1); ?>
    <div class="span5 margin_bottom padding_top_xsmall">
    	
      <div class="margin_left">
        <div id="resumen" class="well well_personaling_big ">
          <h4>Resumen de la compra</h4>
          <div class=" margin_bottom">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
              <tr id="adentro">
                <?php
              /*
                <td valign="top"><i class="icon-picture"></i></td>
                <td>MaterCard<br/>
                  XXXX XXXX XXXX 6589<br/>
                  Vence: 12/2018<br/>
                  JOHANN MARUQEZ </td>
              </tr>
              <tr>
                <td valign="top"><i class="icon-tag"></i></td>
                <td>Balance de Tarjetas <br/>
                  de Regalo <strong>250 Bs.</strong></td>
              </tr>
              <tr>
                <td valign="top"><i class="icon-certificate"></i></td>
                <td>Balance de Puntos <br/>
                  Ganados <strong>250 Bs.</strong></td>
              */
              ?>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed " id="tabla_resumen">
              <tr>
                <th class="text_align_left">Subtotal:</th>
                <td><?php
                          $totalPr=Yii::app()->getSession()->get('subtotal');
                          $totalDe=Yii::app()->getSession()->get('descuento');
                          //$envio = Yii::app()->getSession()->get('envio');
                          $envio = 0;
						  $peso_total = 0;
						  $tipo_guia = 0;
						  $bolsa = Bolsa::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
						  
						  //busco productos individuales en la bolsa
						  $bptcolor = BolsaHasProductotallacolor::model()->findAllByAttributes(array('bolsa_id'=>$bolsa->id,'look_id'=> 0));
						  foreach($bptcolor as $productotallacolor){
								$producto = Producto::model()->findByPk($productotallacolor->preciotallacolor->producto_id);
								$peso_total += ($producto->peso*$productotallacolor->cantidad); 
						  }
						  
						  // busco looks en la bolsa
						  $sql = "select count( * ) as total from tbl_bolsa_has_productotallacolor where look_id != 0 and bolsa_id = ".$bolsa->id."";
						  $num = Yii::app()->db->createCommand($sql)->queryScalar();
						  
						  if($num!=0){
						  	foreach ($bolsa->looks() as $look_id){
						  		$bolsahasproductotallacolor = BolsaHasProductotallacolor::model()->findAllByAttributes(array('bolsa_id'=>$bolsa->id,'look_id' => $look_id));
								$look = Look::model()->findByPk($look_id);
								foreach($bolsahasproductotallacolor as $productotallacolor){
									$producto = Producto::model()->findByPk($productotallacolor->preciotallacolor->producto_id);
									$peso_total += ($producto->peso*$productotallacolor->cantidad); 
								}
							}
						  }
						
						 if($peso_total < 5){
							
							$direccion = Direccion::model()->findByPk($idDireccion);
							$ciudad_destino = Ciudad::model()->findByPk($direccion->ciudad_id);
							$envio =Tarifa::model()->calcularEnvio($peso_total,$ciudad_destino->ruta_id);
						
							$tipo_guia = 1;
						}else{
							$peso_adicional = ceil($peso_total-5);
							$direccion = Direccion::model()->findByPk($idDireccion);
							$ciudad_destino = Ciudad::model()->findByPk($direccion->ciudad_id);
							$envio = 163.52 + ($peso_adicional*$ciudad_destino->ruta->precio);
							if($envio > 327.04){
								$envio = 327.04;
							}
							$tipo_guia = 2;
						}
						  
                        $i=0;

                        if (empty($precios)) // si no esta vacio
                        {}
                        else{

                            foreach($precios as $x){
                                  $totalPr = $totalPr + ($x * $cantidades[$i]);
                                $i++;
                              }
                        }
                    /*    foreach($descuentos as $y)
                          {
                              $totalDe = $totalDe + $y;
                          }*/

                        $iva = (($totalPr - $totalDe)*0.12);

                        $t = $totalPr - $totalDe + (($totalPr - $totalDe)*0.12) + $envio;
                        
						$seguro = $t*0.013;
						
						$t += $seguro;

                        // variables de sesion
                        Yii::app()->getSession()->add('subtotal',$totalPr);
                        Yii::app()->getSession()->add('descuento',$totalDe);
                        Yii::app()->getSession()->add('envio',$envio);
                        Yii::app()->getSession()->add('iva',$iva);
                        Yii::app()->getSession()->add('total',$t);
						Yii::app()->getSession()->add('seguro',$seguro);
						Yii::app()->getSession()->add('tipo_guia',$tipo_guia);
						Yii::app()->getSession()->add('peso',$peso_total);
						
                        echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($totalPr, '');
                          ?>
                  </td>
              </tr>          
              <tr>
                <th class="text_align_left">Envío:</th>
                <td class="text_align_right"><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($envio+$seguro, ''); ?></td>
              </tr>
              <tr>
                <th class="text_align_left">I.V.A. (12%):</th>
                <td class="text_align_right"><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($iva, ''); ?></td>
              </tr>
              <?php if($totalDe != 0){ // si no hay descuento ?> 
              <tr>
                <th class="text_align_left">Descuento:</th>
                <td class="text_align_right" id="descuento"><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($totalDe, ''); ?></td>
              </tr>
              <?php } ?>
              <tr>
                <th class="text_align_left"><h4>Total:</h4></th>
                <td class="text_align_right"><h4 id="precio_total"><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($t, ''); ?></h4></td>
              </tr>
            </table>
            <div id="precio_total_hidden" style="display: none;"><?php echo $t; ?></div>
            <?php
            $balance = Yii::app()->db->createCommand(" SELECT SUM(total) as total FROM tbl_balance WHERE user_id=".Yii::app()->user->id." GROUP BY user_id ")->queryScalar();
			if($balance > 0){
	            ?>
	            <div>
	              <label class="checkbox">
	                <input type="checkbox" name="usar_balance" id="usar_balance" value="1" onclick="calcular_total(<?php echo $t; ?>, <?php echo $balance; ?>)" />
	                Usar Balance disponible: <strong><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($balance, ''); ?></strong> </label>
	            </div>
	            <?php
			}
            ?>
             <button type="button" class="btn btn-success margin_top_medium" data-toggle="collapse" data-target="#collapse2"><i class = "icon-gift icon-white"></i> Agregar Gift Card</button> 
           
            <!-- Forma de pago ON -->
            <div class="padding_left_small margin_top_medium collapse row-fluid" id="collapse2">
              
                <!--[if lte IE 7]>
                    <label class="control-label required">Numero de la tarjeta de Regalo <span class="required">*</span></label>
                <![endif]-->
                
                
                <?php 
                    $classError = "";
                    if($model->hasErrors()){
                        $classError = "error";
                        $cReq = 0;
                        $cLen = 0;
                        foreach($model->errors as $att => $error){
                            $cReq += in_array("req", $error) ? 1:0;
                            $cLen += in_array("len", $error) ? 1:0;
                        }
                        $model->clearErrors();

                        if($cReq){
                           $model->addError("campo1", "Debes escribir el código de tu Gift Card completo"); 
                        }
                        if($cLen){
                           $model->addError("campo1", "Los campos deben ser de 4 caracteres cada uno."); 
                        }
                    }
                ?>
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
                
                    <div class="span11 alert fade in" id="alert-msg" style="display: none">
                      <button type="button" class="close" >&times;</button> 
                      <!--data-dismiss="alert"-->
                      <div class="msg"></div>
                    </div>
                
               <input type="hidden" id="aplicarAjax" name="aplicarAjax" /> 
<!--               <input type="submit" name="aplicarGC" class="btn btn-mini">Aplicar Gift Card</input>-->
               <button id="aplicarGC" class="btn btn-mini btn-danger">Aplicar Gift Card</button>
               <?php // $this->endWidget(); // formulario ?>      
               </div>     
<!--                <div class="span12">
                    
                </div>
                <div class="span12">

                </div>
                <input type="text" maxlength="128"  placeholder="Numero de la tarjeta de Regalo"  class="span3">
                <a href="Crear_Perfil_Usuaria_Mi_Tipo.php" class="btn btn-mini">Aplicar</a>-->
                
                <input type="hidden" id="tipo_pago" name="tipo_pago" value="1" />
                <input type="hidden" id="usar_balance_hidden" name="usar_balance_hidden" value="0" />
              
            </div>
            <!-- Forma de pago OFF -->

            <div class="form-actions">
              <?php $this->widget('bootstrap.widgets.TbButton', array(
	            'type'=>'warning',
	            'size'=>'large',
	            'label'=>'Siguiente',
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
      		      
      <?php $this->endWidget(); // formulario ?> 
      
    </div>
  </div>
</div>
<!-- /container -->

<?php

}// si esta logueado
else
{
    // redirecciona al login porque se murió la sesión
    header('Location: /user/login');
}
?>

<script>

    $("#aplicarGC").click(function(e){
            $("#aplicarAjax").val("1");
                        
            var datos = $("#giftCard").find("input").serialize();
            
            $.ajax({
                type: 'POST',
                url: '<?php echo CController::createUrl("/giftcard/aplicar"); ?>',
                dataType: 'JSON',
                data: datos,
                success: function(data){
                    console.log(data);
                    showAlert("success", "FFFF");
                    return;
                    
                    if(data.status == 'success'){



                    }else if(data == 'error'){

                    }
                }
            });    
            
            
            
        });

        //Mostrar alert
        function showAlert(type, message){
           $('#alert-msg').removeClass('alert-success alert-error') ;
           $('#alert-msg').addClass("alert-"+type);
           $('#alert-msg').children(".msg").html(message);
           $('#alert-msg').show();
           //$("html, body").animate({ scrollTop: 0 }, "slow");
        }

        $(".alert").alert();
        $(".alert .close").click(function(){
            $(".alert").fadeOut('slow');
        });
        
        
    $(document).ready(function() {
        $("#deposito").click(function() {
            var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> Depósito o Transferencia Bancaria.</td>";
            $("#adentro").html(añadir);
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
            
        });
        
        $("#mercadopago").click(function() {
            var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> MercadoPago.</td>";
            $("#adentro").html(añadir);
            $("#tipo_pago").val('4');
            
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
            
        });
        
        $("#tarjeta").click(function() {
            var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> Tarjeta de Crédito.</td>";
            $("#adentro").html(añadir);
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
            
        });
        
        $("#btn_mercadopago").click(function() {
            var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> MercadoPago.</td>";
            $("#adentro").html(añadir);
            $("#tipo_pago").val('4');
            $("#mercadopago").attr('checked', 'checked');
        });
        $("#btn_deposito").click(function() {
        	var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> Depósito o Transferencia Bancaria.</td>";
            $("#adentro").html(añadir);
        	$("#deposito").attr('checked', 'checked');
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
        });
        
        $("#btn_tarjeta").click(function() {
        	 var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> Tarjeta de Crédito.</td>";
            $("#adentro").html(añadir);
        	$("#tarjeta").attr('checked', 'checked');
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
        	
        });

    $("#completar-compra").click(function(ev){
           ev.preventDefault();
           alert("pasar al sig");

           var idDir = $("#id-direccion").attr("value");
         var tipoPago = 1; // en este caso siempre es transferencia pero hay que pensarlo para los distintos tipos

         $.ajax({
            type: "post",
            url: "pagos", // action pagos
            data: { 'idDir':idDir, 'tipoPago':tipoPago},
           // success: function (data) {
             //   if(data == 'ok')
               // {
                //    alert("entró");
                //    window.location="../confirmar";
                //}
           //    }//success
           })

       }); // tallas


    });

	function calcular_total(total, balance){
		if(balance > 0){
			//console.log('Total: '+total+' - Balance: '+balance);
			if($('#usar_balance').is(':checked')){
				$('#usar_balance_hidden').val('1');
				//console.log('checked');
				if(balance >= total){
					$('#descuento').html('Bs. '+total);
					$('#precio_total').html('Bs. 0');
				}else{
					$('#descuento').html('Bs. '+balance.toFixed(2));
					$('#precio_total').html('Bs. '+(total-balance).toFixed(2));
				}
			}else{
				$('#usar_balance_hidden').val('0');
				//console.log('not checked');
				$('#descuento').html('Bs. 0');
				$('#precio_total').html('Bs. '+total.toFixed(2));
			}
		}
		//$('#tabla_resumen').append('<tr><td>Balance usado: </td><td>0 Bs.</td></tr>');
	}
	
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
