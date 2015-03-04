<?php
/* @var $this PagoController */
/* @var $model Pago */

$this->breadcrumbs=array(
	'Pagos'=>array('index'),
	'Tus Pagos',
);

?>

<div class="container">
	<h1>Tus Pagos</h1>
	<section class="bg_color3  span9 offset1 margin_bottom_small padding_small box_1">
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                'id'=>'solicitud-form',
                //'enableAjaxValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'htmlOptions' => array(
                 // 'class' => 'form-horizontal',
                ),
                'type' => 'horizontal',
            ));            
                        
            ?>            
    

            <fieldset>
                <legend>
                    <h3>Tu balance actual en comisiones: <strong><?php echo Yii::t('contentForm', 'currSym').
                        " " . $balance; ?></strong>                      
                     <small class="margin_top_small pull-right">En espera de aprobación: 
                         <strong>
                             <?php echo Yii::t('backEnd', 'currSym')." ".
                                $forApproval; ?>                             
                         </strong>
                     </small>
                    </h3>
                </legend>

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
                
                
                <?php if($balance > 0){ ?>               
                
                <?php  echo $form->errorSummary($model, ""); ?>
                <div class="control-group input-prepend<?php echo $model->hasErrors("monto") ? " error" : ""; ?>">
                    <label class="control-label required">
                        <?php echo Yii::t('contentForm', 'Amount'); ?> <span class="required">*</span>
                    </label>
                    <div class="controls">
                        <span class="add-on"><?php echo Yii::t('contentForm', 'currSym'); ?></span>
                        <?php echo CHtml::activeNumberField($model, 'monto', array(
                            'class' => 'span1 text_align_right',
                            'step' => 'any',
                            'min' => $model->tipo == 1 ? Pago::MONTO_MIN_BANCO : Pago::MONTO_MIN_PAYPAL,
                            'max' => Pago::MONTO_MAX,
                            //'max' => $balance,
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group<?php echo $model->hasErrors("tipo") ? " error" : ""; ?>">
                    <label class="control-label required">
                        <?php echo Yii::t('contentForm', 'Pay through'); ?> <span class="required">*</span>
                    </label>
                    <div class="controls">                        
                        <?php echo TbHtml::activeDropDownList($model, 'tipo',Pago::getTiposPago(),
                                array('class' => 'span2',
                                      'prompt' => '-Seleccionar-',
                                      'required' => true,
                                    )); ?>
                    </div>
                </div>

                <!--BANCO-->
                <?php                
                echo $form->textFieldRow($model, 'entidad', array(
                    'class' => 'span2',
                    'hint' => 'En caso de seleccionar pago mediante Cuenta Bancaria',
//                    'required' => true,
                ));
                ?>	
                <!--Cuenta-->
                <?php                
                echo $form->textFieldRow($model, 'cuenta', array(
                    'class' => 'span3',
                    'hint' => 'Cuenta PayPal o Nro. de cuenta bancaria',
                    'required' => true,
                ));
                if(Yii::app()->language=='es_ve'){
                ?> 
               <div id="venezuela" class="hide">   
               <div class="control-group<?php echo $model->hasErrors("accountType") ? " error" : ""; ?>">
                    <label class="control-label required">
                        <?php echo Yii::t('contentForm', 'Account Type'); ?> <span class="required">*</span>
                    </label>
                    <div class="controls">                        
                        <?php echo TbHtml::activeDropDownList($model, 'accountType',Pago::getTiposCuenta(),
                                array('class' => 'span2',
                                      'prompt' => '-Seleccionar-',
                     
                                    )); ?>
                    </div>
                </div>
       <?php 
                echo $form->textFieldRow($model, 'recipient', array(
                    'class' => 'span3',
                    'value' => $user->profile->first_name." ".$user->profile->last_name,
                    //'hint' => 'Cuenta PayPal o Nro. de cuenta bancaria',
                   // 'required' => true,
                   'placeholder'=>'Escribe el nombre del titular de la cuenta'
                ));
                echo $form->textFieldRow($model, 'identification', array(
                    'class' => 'span3',
                   // 'hint' => 'Cuenta PayPal o Nro. de cuenta bancaria',
                   // 'required' => true,
                   'placeholder'=>'Escribe el RIF o cédula del titular'
                ));
                echo $form->textFieldRow($model, 'email', array(
                    'class' => 'span3',
                    'value' => $user->email,
                    'placeholder'=>'Escribe el correo electrónico del titular'
                  //  'hint' => 'Cuenta PayPal o Nro. de cuenta bancaria',
                  //  'required' => true,
                )); ?>
                </div>     
                      
            <?php    }
                
                ?>	
                <div class="control-group row">
                    <div class="controls pull-right">                          
                        <button type="submit" name="Enviar" id="Enviar" class="btn btn-danger">
                            <i class="icon-envelope icon-white"></i> Enviar Solicitud
                        </button>
                    </div>
                </div>
                          
                <?php } ?>


            </fieldset>

            <?php $this->endWidget(); ?>
        </section>
</div>

<script type="text/javascript">
    
    var minP = "<?php echo Pago::MONTO_MIN_PAYPAL; ?>";
    var minB = "<?php echo Pago::MONTO_MIN_BANCO; ?>";
    var minBal = "<?php echo Pago::MONTO_MIN_BALANCE; ?>";
    var idMonto = <?php echo '"'.TbHtml::activeId($model, "monto").'"'; ?>;
    var idTipo = <?php echo '"'.TbHtml::activeId($model, "tipo").'"'; ?>;
    var idEntidad = <?php echo '"'.TbHtml::activeId($model, "entidad").'"'; ?>;    
    var idCuenta = <?php echo '"'.TbHtml::activeId($model, "cuenta").'"'; ?>;    
    
    /*Cuando cambia el dropdown "Pagar mediante" */
    $("#" + idTipo).change(function(e){
        
        var tipo = $(this).val();        
        /*tipo: 0 - Paypal, 1 - Banco, 2 - balance*/        
        
        //Validar el monto minimo para realizar la solicitud
        $("#" + idMonto).attr("min", tipo == 0 ? minP : 
                tipo == 1 ? minB : minBal);
        
        //Ocultar el campo para el nombre del banco si el tipo es distinto
        //a cuenta bancaria
        var controlGrpElem = $("#" + idEntidad).parent().parent();
        var controlGrpElemCuenta = $("#" + idCuenta).parent().parent();
        
        //ocultar NombreBanco si no es bancaria
        if(tipo != 1){
            controlGrpElem.slideUp("fast");     
            $("#" + idEntidad).removeAttr("required");
            
            //si es Paypal, mostrar el campo cuenta
            if(tipo == 0){
                controlGrpElemCuenta.slideDown("fast");
                $("#" + idCuenta).attr("required", "required");                   
                
            }else{ //Si es agregar al balance, ocultar campo cuenta
                controlGrpElemCuenta.slideUp("fast");                
                $("#" + idCuenta).removeAttr("required");                
            }
            
        }else{ //Si es banco, mostrar el NombreBanco
            controlGrpElem.slideDown("fast");                        
            $("#" + idEntidad).attr("required", "required");
            
            //Mostrar la cuenta
            controlGrpElemCuenta.slideDown("fast");
            $("#" + idCuenta).attr("required", "required");            
            
        }

        
        
    });
    
    
    
</script>
<?php   if(Yii::app()->language=='es_ve'){  ?> 
    <script>
   
   tooltips();
   
           
            
    if( $('#Pago_tipo').val()==1)
            $('#venezuela').show();
    $('#Pago_cuenta').attr('placeholder','Veinte digitos numéricos');

    $('body').on('input','#Pago_cuenta', function() { 
    
         var reg=/^[0-9]*$/;
         if(reg.test($(this).val())){
             $('#Pago_cuenta').tooltip('hide');
             $('#Enviar').attr('disabled',false);
         }
         else{
             $('#Pago_cuenta').tooltip('show'); 
             $('#Enviar').attr('disabled',true);
             if(!reg.test($(this).val().substring($(this).val().length-2,$(this).val().length-1)))
                $(this).val($(this).val().substring(0, $(this).val().length- 1));
         }
        if($(this).val().length>20)
            $(this).val($(this).val().substring(0, $(this).val().length- 1));    
        
     });
     
    $('#Pago_tipo').change(function() {
 
        if($(this).val()==1)
            $('#venezuela').show();
        else
            $('#venezuela').hide();
    });
    $( "#solicitud-form" ).submit(function( event ) {
          
          if(!validateVEN()){
              $(".venError").show();
              event.preventDefault();
          }
                
        });
    
  
    function validateVEN(){
        var val=true;
        var email = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  
        if($('#Pago_tipo').val()==1){
            if($('#Pago_accountType').val()==''){
                val=false;
                $('#Pago_accountType').tooltip('show');
            }
                
            if($('#Pago_recipient').val().length<5){
                val=false;
                $('#Pago_recipient').tooltip('show');
            }
                
            if($('#Pago_identification').val().length<7){
                val=false;
                $('#Pago_identification').tooltip('show');
            }
                
            if(!email.test($('#Pago_email').val())){
                val=false;
                $('#Pago_email').tooltip('show');
            }
                
            if($('#Pago_cuenta').val().length!=20){
                $('#Pago_cuenta').tooltip('show'); 
                val=false;
            }
               
        }
        
        return val;
               
        
    }
    function tooltips(){
        $('#Pago_cuenta').tooltip({
                title:"Introduce 20 dígitos numéricos",
                trigger:"manual",
                placement:"right"
                
            });
    $('#Pago_recipient').tooltip({
                title:"Introduce el nombre del titular de la cuenta",
                trigger:"manual",
                placement:"right"
                
            });
    
    $('#Pago_identification').tooltip({
                title:"Introduce RIF o cedula del titular de la cuenta",
                trigger:"manual",
                placement:"right"
                
            });
    $('#Pago_email').tooltip({
                title:"Introduce el correo electrónico del titular de la cuenta",
                trigger:"manual",
                placement:"right"
                
            });
     $('#Pago_accountType').tooltip({
                title:"Selecciona un tipo de cuenta",
                trigger:"manual",
                placement:"right"
                
            });
    }

    </script>
<?php } ?>