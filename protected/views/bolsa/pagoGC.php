<!-- tipopago 1: transferencia
     tipopago 2: Tarjeta credito
     tipopago 3: puntos o tarjeta de regalo -->
<?php
Yii::app()->clientScript->registerLinkTag('stylesheet','text/css','https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700',null,null);
if (!Yii::app()->user->isGuest) { // que este logueado

?>


<style>
        .progreso_compra_giftcard {
            width: 268px;
        }
        .progreso_compra_giftcard .last-not_done {
            text-align: center;
        }
    </style>
<div class="container margin_top">
  <div class="progreso_compra progreso_compra_giftcard">
    <div class="clearfix margin_bottom">
      <div class="first-past"><?php echo Yii::t('contentForm','Authentication'); ?></div>
      <div class="middle-done">
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
            <h4 class="braker_bottom margin_bottom_medium "><?php echo Yii::t('contentForm','Choose the payment method'); ?></h4>

       <!--
       <input type="radio" name="optionsRadios" id="mercadopago" value="option4" data-toggle="collapse" data-target="#mercadoPago">
        <button type="button" id="btn_mercadopago" class="btn btn-link" data-toggle="collapse" data-target="#mercadoPagoCol"> MercadoPago </button>
       -->
       <div class="accordion" id="accordion2">	
             <?php 
            //Banking Card Aztive
            if(Yii::app()->params['metodosPago']['bkCard']){ 
            ?>                
            <div class="accordion-group">
                <div class="accordion-heading">
                    <label class="radio accordion-toggle margin_left_small" data-parent="#accordion2">
                        <input type="radio" name="optionsRadios" id="bankCard" value="5"> 
                        <?php echo Yii::t('contentForm', 'Credit Card'); ?>
                    </label>                       

                </div>

            </div>
            <?php } ?>
           </div>
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
          <h4><?php echo Yii::t('contentForm','Summary of the purchase'); ?></h4>
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
                <th class="text_align_left"><?php echo Yii::t('contentForm','Subtotal'); ?>:</th>
                <td>
                    <?php
//                        Yii::app()->getSession()->add('seguro',$seguro);
//                        Yii::app()->getSession()->add('tipo_guia',$tipo_guia);
//                        Yii::app()->getSession()->add('peso',$peso_total);
						
                        
                        echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency($total, '');
                          ?>
                  </td>
              </tr> 
              <tr>
                <th class="text_align_left"><h4><?php echo Yii::t('contentForm','Total'); ?>:</h4></th>
                <td class="text_align_right">
                    <h4 id="precio_total">
                    <?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency($total, ''); ?>
                    </h4>
                </td>
              </tr>
            </table>            
            
            <div class="form-actions">
              <?php $this->widget('bootstrap.widgets.TbButton', array(
	            'type'=>'warning',
	            'size'=>'large',
	            'label'=>Yii::t('contentForm','Next'),
	            //'url'=>'confirmar', // action
	            'icon'=>'lock white',
	            'buttonType'=>'submit',
	            'htmlOptions'=>array('id'=>'btn-siguiente',),
	        ));
        
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
    //header('Location: /user/login');
    $url = CController::createUrl("/user/login");
    header('Location: '.$url);
}
?>

<script>  

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
        	
        });

    });
	
    //Boton siguiente - General para todos los metodos de pago        
    $("#btn-siguiente").click(function(e){
        $("#tarjeta-form").submit();
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
