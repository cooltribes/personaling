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
        <div class="middle-past">Dirección<br/>de envío <br/>y facturación</div>
        <div class="middle-done">Método <br/>de pago</div>
        <div class="last-not_done">Confirmar<br/>compra</div>
      </div>
      
  </div>

    
  <div class="row">
    <section class="span7"> 
      <!-- Forma de pago ON -->
      <div class="box_1 padding_small margin_bottom">
        <h4 class="braker_bottom padding_bottom_xsmall ">Pagar con Depósito o  Transferencia Bancaria</h4>
        <input type="checkbox" name="optionsRadios" id="deposito" value="option1" data-toggle="collapse" data-target="#pagoDeposito">
        <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#pagoDeposito"> Usar éste método de pago (click para ver las cuentas) </button>
         
        </label>
        <div class="padding_left margin_bottom_medium collapse" id="pagoDeposito">
          <div class="well well-small" >
            <h4>Banesco</h4>
            <ul>
              <li>Cuenta Corriente Nº XXXXX-YYY-ZZZ</li>
              <li>PERSONALING C.A</li>
              <li> RIF Nº J-RRRRR</li>
            </ul>
            <h4>Mercantil</h4>
            <ul>
              <li>Cuenta Corriente Nº XXXXX-YYY-ZZZ</li>
              <li>PERSONALING C.A</li>
              <li> RIF Nº J-RRRRR</li>
            </ul>
            <h4>Provincial</h4>
            <ul>
              <li>Cuenta Corriente Nº XXXXX-YYY-ZZZ</li>
              <li>PERSONALING C.A</li>
              <li> RIF Nº J-RRRRR</li>
            </ul>
          </div>
        </div>
        Si ya has realizado el deposito <a href="#myModal" role="button" class="btn btn-mini btn-info" data-toggle="modal">haz click aqui</a> </div>
      <div class="box_1 padding_small margin_bottom"> 
        <!-- Forma de pago OFF --> 
        <!-- Forma de pago ON -->
        <h4 class="margin_top">Pagar con tarjetas de crédito</h4>
        <div class="margin_bottom_large">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed">
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
          
          <div class="collapse" id="collapseOne">
            <form class="personaling_form well well-small margin_top_medium">
              <h5 class="braker_bottom">Nueva tarjeta de crédito</h5>
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
          
        </div>
        <!-- Forma de pago OFF --> 
      </div>
      <div class="box_1 padding_small margin_bottom"> 
        <!-- Forma de pago ON -->
        <h4 class="braker_bottom  padding_bottom_xsmall">Pagar con Tu saldo disponible en Personaling</h4>
        <div class="padding_left margin_bottom_small">
          <label class="checkbox">
            <input type="checkbox" name="optionsRadios" id="optionsRadios1" value="option1" >
            Usar Balance de Tarjetas de Regalo <strong>(Bs.255)</strong> </label>
          <label class="checkbox">
            <input type="checkbox" name="optionsRadios" id="optionsRadios2" value="option2">
            Usar Balance de Puntos Ganados <strong>(Bs.356)</strong></label>
        </div>
        <button type="button" class="btn btn-info btn-small" data-toggle="collapse" data-target="#collapse2"> Agregar Tarjeta de regalo </button>
        <!-- Forma de pago ON -->
        <div class="margin_bottom_large collapse" id="collapse2">
          <form class="personaling_form well well-small margin_top_medium">
            <h4 class="braker_bottom  padding_bottom_xsmall"> Agregar Tarjeta de Regalo a tu Balance</h4>
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
          <a href="Crear_Perfil_Usuaria_Mi_Tipo.php" class="btn btn-large">Agregar Tarjeta de Regalo</a> </div>
        <!-- Forma de pago OFF --> 
        
      </div>
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
  <?php Yii::app()->getSession()->add('tipoPago',1); ?>
    
	<div class="span5 margin_bottom padding_top_xsmall">
      <div class="margin_left">
        <div id="resumen" class="well ">
          <h4>Metodo de Pago Seleccionado</h4>
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
            <div class="form-actions">
            	
          <?php $this->widget('bootstrap.widgets.TbButton', array(
            'type'=>'danger',
            'size'=>'large',
            'label'=>'Completar compra',
            'url'=>'confirmar', // action
            'icon'=>'shopping-cart white',
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

<?php 

}// si esta logueado
else
{
	// redirecciona al login porque se murió la sesión
	header('Location: /site/user/login');	
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
			
			var añadir = "<tr class='deptran'><td valign='top'><i class='icon-exclamation-sign'></i></td><td> Depósito o Transferencia Bancaria.</td></tr>";
			
			if( $(this).is(':checked') ) // si activa el check
			{
				$("#adentro").append(añadir);
			}else
			{
				$("tr.deptran").remove();
			}	
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
		        //	alert("entró");
	        	//	window.location="../confirmar";
		        //}
	       //	}//success
	       })
   		
   	}); // tallas
		
	
	});
	
	
</script>