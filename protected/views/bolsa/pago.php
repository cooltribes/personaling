<!-- tipopago 1: transferencia
     tipopago 2: Tarjeta credito
     tipopago 3: puntos o tarjeta de regalo -->
<?php

if (!Yii::app()->user->isGuest) { // que este logueado

?>

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
        <input type="radio" name="optionsRadios" id="mercadopago" value="option4" data-toggle="collapse" data-target="#mercadoPago">
        <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#mercadoPago"> MercadoPago </button>
        <div class="padding_left margin_bottom_medium collapse" id="mercadoPago">
          <div class="well well-small" >
            Haz click en "Completar compra" para continuar. <?php //echo 'Pago: '.Yii::app()->getSession()->get('tipoPago'); ?>
          </div>
        </div>
        <input type="radio" name="optionsRadios" id="deposito" value="option1" data-toggle="collapse" data-target="#pagoDeposito" checked>
        <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#pagoDeposito"> Depósito o Transferencia </button>
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
        <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#pagoTarjeta"> Tarjeta de Crédito </button>
        <div class="collapse" id="pagoTarjeta">
        	 <div class="well well-small" >
            Haz click en "Completar compra" para continuar. <?php //echo 'Pago: '.Yii::app()->getSession()->get('tipoPago'); ?>
          </div>
        </div>
         <!-- <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">
            <tr>
              <th scope="col" colspan="4">&nbsp;</th>
              <th scope="col">Nombre en la Tarjeta</th>
              <th scope="col">Fecha de Vencimiento</th>
            </tr>
            <tr>
              <td><input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" ></td>
              <td><i class="icon-picture"></i></td>
              <td>Mastercard</td>
              <td>XXXX XXXX XXXX 6589</td>
              <td>JOHANN MARQUEZ</td>
              <td>12/2018</td>
            </tr>
            <tr>
              <td><input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" ></td>
              <td><i class="icon-picture"></i></td>
              <td>Visa</td>
              <td>XXXX XXXX XXXX 6589</td>
              <td>JOHANN MARQUEZ</td>
              <td>12/2018</td>
            </tr>
          </table>
          <button type="button" class="btn btn-info btn-small" data-toggle="collapse" data-target="#collapseOne"> Agregar una nueva tarjeta </button>

          <!-- Forma de pago ON -->

          <!-- <div class="collapse" id="collapseOne">
            <form class="personaling_form well well-small margin_top_medium">
              <h5 class="braker_bottom">Nueva tarjeta de crédito</h5>
              <div class="control-group">
                <!--[if lte IE 7]>
            <label class="control-label required">Nombre en la tarjeta <span class="required">*</span></label>
<![endif]-->
              <!--   <div class="controls">
                  <input type="text" maxlength="128"  placeholder="Nombre en la tarjeta"  class="span5">
                  <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                </div>
              </div>
              <div class="control-group">
                <!--[if lte IE 7]>
            <label class="control-label required">Nombre impreso en la tarjeta <span class="required">*</span></label>
<![endif]-->

             <!--    <div class="controls">
                  <input type="text" maxlength="128"  placeholder="Nombre impreso en la tarjeta"  class="span5">
                  <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                </div>
              </div>
              <div class="control-group">
                <!--[if lte IE 7]>
            <label class="control-label required">Fecha de Vencimiento <span class="required">*</span></label>
<![endif]-->
            <!--     <div class="controls">
                  <select>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                  <select>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                  </select>
                  <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                </div>
              </div>
              <div class="control-group">
                <!--[if lte IE 7]>
            <label class="control-label required">Codigo de Seguridad <span class="required">*</span></label>
<![endif]-->
         <!--        <div class="controls">
                  <input type="text" maxlength="128"  placeholder="Codigo de Seguridad"  class="span5">
                  <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                </div>
              </div>
              <div class="control-group">
                <!--[if lte IE 7]>
            <label class="control-label required">Cedula de Identidad <span class="required">*</span></label>
<![endif]-->
          <!--       <div class="controls">
                  <input type="text" maxlength="128"  placeholder="Cedula de Identidad"  class="span5">
                  <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                </div>
              </div>
              <div class="control-group">
                <!--[if lte IE 7]>
            <label class="control-label required">Numero de Telefono <span class="required">*</span></label>
<![endif]-->
       <!--          <div class="controls">
                  <input type="text" maxlength="128"  placeholder="Numero de Telefono"  class="span5">
                  <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                </div>
              </div>
              <div class="form-actions"> <a href="Crear_Perfil_Usuaria_Mi_Tipo.php" class="btn-large btn btn-danger">Anadir Tarjeta de Crédito</a> </div>
            </form>
          </div>
          <!-- Forma de pago OFF -->
<!-- 
        </div>
      </div> -->
      <?php /*?><div class="box_1 padding_small">
        <h3>Incluir nuevas opciones de pago</h3>
        <!-- Forma de pago ON -->
        <h4 class="braker_bottom">Tarjetas de crédito</h4>
        <div class="margin_bottom_large">
          <form class="personaling_form">
            <div class="control-group">
              <!--[if lte IE 7]>
            <label class="control-label required">Nombre en la tarjeta <span class="required">*</span></label>
<![endif]-->
              <div class="controls">
                <input type="text" maxlength="128"  placeholder="Nombre en la tarjeta"  class="span5">
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group">
              <!--[if lte IE 7]>
            <label class="control-label required">Nombre impreso en la tarjeta <span class="required">*</span></label>
<![endif]-->

              <div class="controls">
                <input type="text" maxlength="128"  placeholder="Nombre impreso en la tarjeta"  class="span5">
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group">
              <!--[if lte IE 7]>
            <label class="control-label required">Fecha de Vencimiento <span class="required">*</span></label>
<![endif]-->
              <div class="controls">
                <select>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
                <select>
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group">
              <!--[if lte IE 7]>
            <label class="control-label required">Codigo de Seguridad <span class="required">*</span></label>
<![endif]-->
              <div class="controls">
                <input type="text" maxlength="128"  placeholder="Codigo de Seguridad"  class="span5">
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group">
              <!--[if lte IE 7]>
            <label class="control-label required">Cedula de Identidad <span class="required">*</span></label>
<![endif]-->
              <div class="controls">
                <input type="text" maxlength="128"  placeholder="Cedula de Identidad"  class="span5">
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group">
              <!--[if lte IE 7]>
            <label class="control-label required">Numero de Telefono <span class="required">*</span></label>
<![endif]-->
              <div class="controls">
                <input type="text" maxlength="128"  placeholder="Numero de Telefono"  class="span5">
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="form-actions"> <a href="Crear_Perfil_Usuaria_Mi_Tipo.php" class="btn-large btn btn-danger">Anadir Tarjeta de Crédito</a> </div>
          </form>
        </div>
        <!-- Forma de pago OFF -->
        <!-- Forma de pago ON -->
        <h4 class="braker_bottom  padding_bottom_xsmall"> Anadir Tarjeta de Regalo a tu Balance</h4>
        <div class="margin_bottom_large">
          <form class="personaling_form">
            <div class="control-group">
              <!--[if lte IE 7]>
            <label class="control-label required">Numero de la tarjeta de Regalo <span class="required">*</span></label>
<![endif]-->
              <div class="controls">
                <input type="text" maxlength="128"  placeholder="Numero de la tarjeta de Regalo"  class="span5">
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
          </form>
          <a href="Crear_Perfil_Usuaria_Mi_Tipo.php" class="btn btn-large">Anadir Tarjeta de Crédito</a> </div>
      </div><?php */?>
    </section>
    <?php

//     echo CHtml::hiddenField('idDireccion',$idDireccion);
// echo CHtml::hiddenField('tipoPago','1');
?>
    <?php  Yii::app()->getSession()->add('idDireccion',$idDireccion); ?>
    <?php //Yii::app()->getSession()->add('tipoPago',1); ?>
    <div class="span5 margin_bottom padding_top_xsmall">
    	<form action="confirmar" method="POST">
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
						
						if($peso_total <= 0.5){
							$envio = 80.08;
						}else if($peso_total < 5){
							$peso_adicional = ceil($peso_total-0.5);
							$direccion = Direccion::model()->findByPk($idDireccion);
							$ciudad_destino = Ciudad::model()->findByPk($direccion->ciudad_id);
							$envio = 80.08 + ($peso_adicional*$ciudad_destino->ruta->precio);
							if($envio > 163.52){
								$envio = 163.52;
							}
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
            <!-- <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapse2"> Agregar Tarjeta de regalo </button> -->
            <!-- Forma de pago ON -->
            <div class="padding_left_small collapse" id="collapse2">
              
                <!--[if lte IE 7]>
            <label class="control-label required">Numero de la tarjeta de Regalo <span class="required">*</span></label>
<![endif]-->

                <input type="text" maxlength="128"  placeholder="Numero de la tarjeta de Regalo"  class="span3">
                <a href="Crear_Perfil_Usuaria_Mi_Tipo.php" class="btn btn-mini">Agregar Tarjeta de Regalo</a>
                <input type="hidden" id="tipo_pago" name="tipo_pago" value="1" />
                <input type="hidden" id="usar_balance_hidden" name="usar_balance_hidden" value="0" />
              
            </div>
            <!-- Forma de pago OFF -->

            <div class="form-actions">
              <?php $this->widget('bootstrap.widgets.TbButton', array(
	            'type'=>'warning',
	            'size'=>'large',
	            'label'=>'Completar compra',
	            //'url'=>'confirmar', // action
	            'icon'=>'lock white',
	            'buttonType'=>'submit',
	        ));
        // <a id="completar-compra" class="btn btn-danger"><i class="icon-shopping-cart icon-white"></i> Completar compra</a>
        ?>
            </div>
          </div>
        </div>
      </div>
      </form>
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

<!-- Modal Window -->

<div class="modal hide fade" id="myModal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4>Agregar Depósito o Transferencia bancaria ya realizada</h4>
  </div>
  <div class="modal-body">
    <form class="">
      <div class="control-group">
        <!--[if lte IE 7]>
            <label class="control-label required">Nombre del Depositante <span class="required">*</span></label>
<![endif]-->
        <div class="controls">
          <input type="text" maxlength="128"  placeholder="Nombre del Depositante"  class="span5">
          <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
        </div>
      </div>
      <div class="control-group">
        <!--[if lte IE 7]>
            <label class="control-label required">Número o Código del Depósito<span class="required">*</span></label>
<![endif]-->
        <div class="controls">
          <input type="text" maxlength="128"  placeholder="Número o Código del Depósito"  class="span5">
          <div style="display:none" class="help-inline"></div>
        </div>
      </div>
      <div class="controls controls-row">
        <!--[if lte IE 7]>
            <label class="control-label required">Fecha del depósito DD/MM/YYY<span class="required">*</span></label>
<![endif]-->
        <input class="span1" type="text" placeholder="Día">
        <input class="span1" type="text" placeholder="Mes">
        <input class="span2" type="text" placeholder="Año">
      </div>
      <div class="control-group">
        <!--[if lte IE 7]>
            <label class="control-label required">Comentarios (Opcional) <span class="required">*</span></label>
<![endif]-->
        <div class="controls">
          <textarea class="span5" rows="6" placeholder="Comentarios (Opcional)"></textarea>
          <div style="display:none" class="help-inline"></div>
        </div>
      </div>
      <div class="form-actions"> <a href="#" class="btn btn-danger">Añadir al Look</a> </div>
      <p class="well well-small"> <strong>Terminos y Condiciones de Recepcion de pagos por Deposito y/o Transferencia</strong><br/>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ul </p>
    </form>
  </div>
</div>

<!-- // Modal Window -->

<script>

    $(document).ready(function() {
        $("#deposito").click(function() {
            var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> Depósito o Transferencia Bancaria.</td>";
            $("#adentro").html(añadir);
            $("#tipo_pago").val('1');
        });
        
        $("#mercadopago").click(function() {
            var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> MercadoPago.</td>";
            $("#adentro").html(añadir);
            $("#tipo_pago").val('4');
        });
        
        $("#tarjeta").click(function() {
            var añadir = "<td valign='top'><i class='icon-exclamation-sign'></i> Tarjeta de Crédito.</td>";
            $("#adentro").html(añadir);
            $("#tipo_pago").val('2');
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
</script>