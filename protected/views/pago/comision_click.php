<?php
/* @var $form TbActiveForm */
 $this->pageTitle = Yii::app()->name . ' - Personal Shoppers';
//$this->breadcrumbs=array(
//'Usuarios',
//);
?>

<style>
    h5 a.link-ps{
        text-decoration: underline;
    }
</style>
<div class="container margin_top">

    <?php
    $this->widget('bootstrap.widgets.TbAlert', array(
        'block' => true, // display a larger alert block?
        'fade' => true, // use transitions?
        'closeText' => '&times;', // close link text - if set to false, no close link is displayed
        'alerts' => array(// configurations per alert type
            'success' => array('block' => true, 'fade' => true, 'closeText' => '&times;'), // success, info, warning, error or danger
            'error' => array('block' => true, 'fade' => true, 'closeText' => '&times;'), // success, info, warning, error or danger
        ),
            )
    );

    $total = 0;

    $provider2=User::model()->findAllByAttributes(array("personal_shopper" =>'1'), array('order'=>'pago_click desc'));
	foreach($provider2 as $cadauno)
	{
		
		$amount = $cadauno->getPagoClick();
		 $arreglo = explode(" ",$amount);
		 #echo $this->_lastDate;
		 #echo $cadauno->getLookReferredViews()."////";
		$dos = $this->_lastDate ? $cadauno->getLookReferredViewsByDate($this->_lastDate, date("Y-m-d")) : $cadauno->getLookReferredViews();
#echo $this->_lastDate;
        $total += ($arreglo[0] * $dos);
		
	}
   
    /*foreach($dataProvider->getData() as $cadauno){
        $amount = $cadauno->getPagoClick();
        $arreglo = explode(" ",$amount);

        $dos = $this->_lastDate ? $cadauno->getLookReferredViewsByDate($this->_lastDate, date("Y-m-d")) : $cadauno->getLookReferredViews();

        $total += ($arreglo[0] * $dos);
    }*/

    ?> 

    <div class="page-header">
        <h1>Pago de comisiones por afiliación - Clicks</h1>
    </div>    
    
    <div class="row">
        <div class="span6">
           <fieldset>
               <legend>Datos del último pago realizado</legend>
               <?php if($lastPayment){ ?>
                <ul class="no_bullets no_margin_left">                    
                    <li><strong>Fecha y hora: </strong>
                        <?php echo date("d-m-Y h:m:i a", strtotime($lastPayment->created_at)); ?>
                    </li>
                   <!-- <li><strong>Monto pagado: </strong>
                        <?php echo $lastPayment->getAmount() . " " .
                        Yii::t('contentForm', 'currSym'); ?>
                    </li> -->                   
                </ul>
               <?php }else{ ?>
               <h4>No se ha hecho ningún pago hasta el momento</h4>
               <?php } ?>
            </fieldset>
        </div>
        <div class="span6">
             <fieldset>                
                <legend>Pagar por el periodo actual</legend>
                    <?php

                        $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                            'id'=>'pago-form',
                            "htmlOptions" => array(
                                "class" => "text_align_center"                                                                
                            )
                        ));     
                    ?>
                    <div class="margin_left_small"> 
                    <span class="pull-left">
                    <?php
                         echo "Total a pagar: ".$total." ".Yii::t('contentForm', 'currSym');
                    ?>
                    </span>

                    <?php 
                        echo CHtml::hiddenField("pagar","no",array('id'=>'pagar'));
                        echo TbHtml::submitbutton("Pagar", array(
                                "id" => "pay",
                                "color" => "warning",
                        ));   
                    ?>
                    </div>
                    <?php
                        $this->endWidget();
                    ?>
            </fieldset>
        </div>
    </div>
    
    <div class="span3">
        <?php // echo CHtml::dropDownList("Filtros", "", Chtml::listData(Filter::model()->findAll('type = 8'), "id_filter", "name"), array('empty' => '-- Búsquedas avanzadas --', 'id' => 'all_filters'))
        ?>
    </div>
    <!--<div class="span3 "><a href="#" class="btn  crear-filtro">Crear búsqueda avanzada</a></div>-->
    
</div>
<?php // $this->renderPartial("_filters"); ?>

<?php 
$template = '{summary}
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped table-condensed">
    <tr>      
      <th colspan="3" scope="col" height="40" >Personal Shopper</th>
      <th scope="col" style="text-align: center">Precio por Click</th>
      <th scope="col" style="text-align: center">Clicks totales</th>      
      <th scope="col" style="text-align: center">Monto a pagar ('.Yii::t('contentForm', 'currSym').')</th>
      <th scope="col" style="text-align: center">Acciones</th>            
    </tr>
    {items}
    </table>
    {pager}';
	 $pagerParams=array(
        'header'=>'',
        'prevPageLabel' => Yii::t('contentForm','Previous'),
        'nextPageLabel' => Yii::t('contentForm','Next'),
        'firstPageLabel'=> Yii::t('contentForm','First'),
        'lastPageLabel'=> Yii::t('contentForm','Last'),
        'htmlOptions'=>array(
            'class'=>'pagination pagination-right'));   

$this->widget('zii.widgets.CListView', array(
    'id' => 'list-auth-items',
    'dataProvider' => $dataProvider,
    'itemView' => '_view_ps_comision_click', 
    'template' => $template,
    'summaryText' => 'Mostrando {start} - {end} de {count} Resultados',                
    'afterAjaxUpdate'=>" function(id, data) {

        

      } ",
    'pager' =>$pagerParams, 
));


	Yii::app()->clientScript->registerScript('filtrar', "
        var ajaxUpdateTimeout;

        $('#filtrar').click(function(){
            	inicio = $('#first').attr('value');
				final = $('#second').attr('value');
					
				// alert(inicio+' '+final);	
            	datos = $('#first, #second').serialize();
            	
            	ajaxUpdateTimeout = setTimeout(
                    function () {
                		$.fn.yiiListView.update(
                        // this is the id of the CListView
                            'list-auth-items',
                            {data: datos}
                        )
					},
                    // this is the delay
                    300); 
                                 
        });"
	);


?> 

</div>

<!--MODAL CAMBIO CLICK ON-->
<?php
    $this->beginWidget('bootstrap.widgets.TbModal', array(
        'id' => 'modalPagoClick',
            ), array(
                'class' => 'modal fade hide',
                'tabindex' => "-1",
                'role' => "dialog",
                'aria-labelledby' => "myModalLabel",
                'aria-hidden' => "true",
            //'style' => "display: none;",
            ))
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Cambiar monto de comisión por click</h3>
</div>
<div class="modal-body">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'formCambiarComisionClick',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'type' => 'horizontal',
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <fieldset>       
        <div class="control-group">
            <label class="control-label">Total por click:</label>
            <div class="controls">
                <?php echo TbHtml::textField("totalClick", 0, array("append" => Yii::t('backEnd', 'currSym'), "span" => "1"));
                ?>
            </div>
        </div> 
        <div class="control-group">            
            <div class="controls">
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'type' => 'danger',
                    'buttonType' => 'button',
                    'label' => "Guardar",
                    'htmlOptions' => array(
                        'id' => 'btnClick',
                    )
                ));
                ?>
            </div>
        </div>    
        <?php echo CHtml::hiddenField("ps"); ?> 
    </fieldset>

<?php $this->endWidget(); ?>

    <div class="row-fluid">
        <div class="span12 ">
            <strong class="nroAfectados">1</strong>
            Personal Shopper será afectado <i class="icon-user"></i>
        </div>
    </div>

</div>
<div class="modal-footer text_align_left">
    <h5 style="margin-top: 0">Descripción:</h5>
    Cambiarás el valor de la comisión por click para el Personal Shopper seleccionado.
    Este nuevo valor se aplicará en las próximas ventas.
</div>                    

<?php $this->endWidget() ?>
<!--MODAL CAMBIO COMISION OFF-->

<!-- /container -->
<script>

var validSubmit = false;
var total=0;

$(document).ready(function() {
    
    /*Boton de acciones masivas, para cambiar comision y tiempo*/
    $(".btnProcesar").click(function() {
            
            var id = $(this).attr("id");
           // alert(id);

            /* change hidden PS value */
            $("#ps").val(id);

            /* Show Modal */
            $('#modalPagoClick').modal();
    });
  
});

/* Funcion para cambiar los montos que le corresponden a cada PS de acuerdo al 
 * monto ingresado en el campo #monthlyEarning
 * */
function cambiarMontosEnTabla(e){
    
    
    var monthlyEarning = $("#monthlyEarning").val();
    
    $("input[name ^= 'amount']").each(function(index, element){

        var id = $(element).attr("id");
        var percentage = $("#percentage-"+id).val();
        /* Asign corresponding amount to each PS*/
        $(element).val(monthlyEarning * percentage);

    });    
    
}

function filtrarFechas(){
    
//	inicio = $("#first").attr("value");
//	final = $("#second").attr("value");
	
	alert("Va el otro alert");
}

/*Action when the form pago-form is submitted*/
function formSubmit(e){
    
    if(!validSubmit){
        
        e.preventDefault();   
        $("#pagar").val("si");
        
        bootbox.confirm("Se realizará el pago a todas las personal shoppers en\n\
            Personaling, ¿Deseas continuar?",
            function(result) {

                if(result){
                    validSubmit = true;
                    //disable the button, start the loading animation
                    //and submit the form
                    
                    $('#pay').attr("disabled", true);
                    $('body').addClass("aplicacion-cargando");
                    $('form#pago-form').submit();

                }

            }
        );
    }
        
}

    /*Change click rate*/
    //$("#btnClick").click(function (e){
    $("body").on('click','#btnClick', function(e) {
        e.preventDefault();
        var porClick = $("#totalClick").val();     
        
        var res = confirm('¿Estás seguro de establecer '+porClick+' como comisión por click');
        
        if(res){
            var args = $("#formCambiarComisionClick").serialize();
            accionMasiva(args); 
        }
    });

function accionMasiva(parametros){
    $.ajax(
            "<?php echo CController::createUrl('CambiarComisionClic'); ?>",
            {
                type: 'POST',
                dataType: 'json',
                data: parametros,
                beforeSend: function(){
                    
                },
                success: function(data){                  
                    
                    $('#modalPagoClick').modal("hide");
                    
                    //showAlert(data.status, data.message);
                    
                    $('html,body').animate({
                        scrollTop: $(".page-header").first().next().offset().top
                    }); 
                    
                   // $.fn.yiiListView.update('list-auth-items'); 
                },

                error: function( jqXHR, textStatus, errorThrown){
                    console.log("Error ejecutando el ajax");
                    console.log(jqXHR);
                }
            }
        );
        location.reload();
//$.fn.yiiListView.update('list-auth-items');
//alert('asd');
//location.reload();
//$.fn.yiiListView.update('list-auth-items', { data:ajaxRequest });
// $.fn.yiiListView.update('list-auth-items', {data:ajaxRequest});
}



$(document).ready(function(){

    $('#monthlyEarning').change(cambiarMontosEnTabla).keypress(cambiarMontosEnTabla);            
//    $('button#pay').click(accionBotonPagar);
    $('form#pago-form').submit(formSubmit);
    
    
});    
</script>