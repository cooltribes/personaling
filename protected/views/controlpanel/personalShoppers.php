<?php
/* @var $form TbActiveForm */
 $this->pageTitle = Yii::app()->name . ' - Personal Shoppers';
//$this->breadcrumbs=array(
//'Usuarios',
//);
?>
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
    ?> 

    <div class="page-header">
        <h1>Remuneración - Personal Shoppers</h1>
    </div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
        <tr>
            <th scope="col" colspan="7"> Totales </th>
        </tr>
        <tr>
            <td><p class="T_xlarge margin_top_xsmall"><?php echo $ventasGeneraronComision; ?></p>
                Ventas con comisión</td>
            <!--<td class="text-error"><p class="T_xlarge margin_top_xsmall"><?php echo $ventasNoGeneraronComision; ?></p>
                Ventas sin comisión</td>
            -->
            <td><p class="T_xlarge margin_top_xsmall"><?php echo $ventasNoGeneraronComision; ?></p>
                Ventas sin comisión</td>
            <td><p class="T_xlarge margin_top_xsmall"><?php echo $totalGeneradoComisiones . " " . Yii::t('contentForm', 'currSym'); ?></p>
                Total generado<br>en comsiones</td>
            <td><p class="T_xlarge margin_top_xsmall"><?php echo $prodsVendidosComision; ?></p>
                Productos vendidos<br>(con comisión)</td>
            <td><p class="T_xlarge margin_top_xsmall"><?php echo 34; ?></p>
                Looks vendidos<br>(con comisión)</td>
            <td><p class="T_xlarge margin_top_xsmall"><?php echo $psConVentas; ?></p>
                PS con ventas</td>
            <td><p class="T_xlarge margin_top_xsmall"><?php echo 56; ?> </p>
                PS sin ventas</td>
        </tr>
    </table>
    <hr/>
    <div class="row margin_top margin_bottom ">
        <div class="span4">
            <?php
            echo CHtml::beginForm(CHtml::normalizeUrl(array('index')), 'get', array('id' => 'search-form'))
            . '<div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>'
            . CHtml::textField('nombre', (isset($_GET['string'])) ? $_GET['string'] : '', array('id' => 'textbox_buscar', 'class' => 'span3', 'placeholder' => 'Buscar'))
            . CHtml::endForm();
            ?>
        </div>
    </div>
    <div class="span3">
        <?php echo CHtml::dropDownList("Filtros", "", Chtml::listData(Filter::model()->findAll('type = 8'), "id_filter", "name"), array('empty' => '-- Búsquedas avanzadas --', 'id' => 'all_filters'))
        ?>
    </div>
    <div class="span3 "><a href="#" class="btn  crear-filtro">Crear búsqueda avanzada</a></div>
    
</div>

<?php $this->renderPartial("_filters"); ?>
<hr/>
<?php
$template = '{summary}
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped table-condensed">
    <tr>      
      <th colspan="3" rowspan="2" scope="col">Usuario</th>
      <th colspan="2" scope="col" style="text-align: center">Ventas</th>
      <th rowspan="2" scope="col" style="text-align: center">Comisión<br>Actual</th>
      <th rowspan="2" scope="col" style="text-align: center">Pago por<br>Click</th>
      <th rowspan="2" scope="col" style="text-align: center">Validez<br>Bolsa</th>
      <th colspan="2" scope="col" style="text-align: center">Saldo ('.Yii::t('contentForm', 'currSym').')</th>
      <th rowspan="2" scope="col">Fecha de Registro</th>
      <th rowspan="2" scope="col">Detalle</th>
    </tr> 
        <tr>
      <th scope="col">Looks</th>
      <th scope="col">Productos</th>
      <th scope="col">Comisiones</th>
      <th scope="col">Total</th>
    </tr>
    {items}
    </table>
    {pager}';

$this->widget('zii.widgets.CListView', array(
    'id' => 'list-auth-items',
    'dataProvider' => $dataProvider,
    'itemView' => '_viewPs',
    'template' => $template,
    'summaryText' => 'Mostrando {start} - {end} de {count} Resultados',                
    'afterAjaxUpdate'=>" function(id, data) {

        actualizarNroUsuarios(id, data);

      } ",
    'pager' => array(
        'header' => '',
        'htmlOptions' => array(
            'class' => 'pagination pagination-right',
        )
    ),
));


Yii::app()->clientScript->registerScript('search', "
            var ajaxUpdateTimeout;
	    var ajaxRequest;
	    $('#textbox_buscar').keyup(function(e){
                if(e.which == 13) { 
                    $('.crear-filtro').click();
                    ajaxRequest = $('#textbox_buscar').serialize();
                    clearTimeout(ajaxUpdateTimeout);
                    
                    ajaxUpdateTimeout = setTimeout(
                    function () {
                        $.fn.yiiListView.update(
                        // this is the id of the CListView
                            'list-auth-items',
                            {data: ajaxRequest}
                        )
                    },
                    // this is the delay
                    300);		        
                }		        
	    });"
);
?> 

<h3>Acciones Masivas</h3>
<hr/>
<div class="row">
    <div class="span3">       
        <?php
        echo CHtml::dropDownList("Filtros", "", array("1" => "Cambiar comisión",
            "2" => "Cambiar validez de la bolsa","3" => "Cambiar pago por click"), array('prompt' => '-- Seleccione una acción --', 'id' => 'listaAcciones'))
        ?>
    </div>
    <div class="span1">
        <a id="btnProcesar" title="Procesar" class="btn btn-danger">Procesar</a>
    </div>
</div>
</div>

<!--MODAL CAMBIO COMISION ON-->
<?php
$this->beginWidget('bootstrap.widgets.TbModal', array(
    'id' => 'modalComision',
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
    <h3 id="myModalLabel">Cambiar comisión de ventas para los Personal Shoppers</h3>
</div>
<div class="modal-body">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'formCambiarComision',
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
            <label class="control-label">Tipo de Comisión:</label>
            <div class="controls">
                <?php
                echo TbHtml::dropDownList("cambiarTpComision", 1, array(1 => "Porcentaje (%)",
                    2 => "Fijo (" . Yii::t('backEnd', 'currSym') . ")"), array("span" => 2));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Valor de la Comisión:</label>
            <div class="controls">
                <?php echo TbHtml::textField("cambiarVlComision", 0, array("append" => "%", "span" => "1"));
                ?>
            </div>
        </div> 
        <div class="control-group">            
            <div class="controls">
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'type' => 'danger',
                    'buttonType' => 'button',
                    'label' => "Guardar cambios",
                    'htmlOptions' => array(
                        'id' => 'btnComision',
                    )
                ));
                ?>
            </div>
        </div>    
        <div class="hidden" id="cambioMoneda"><?php echo Yii::t('backEnd', 'currSym'); ?></div>
        <?php echo CHtml::hiddenField("action", 1); ?>
    </fieldset>

<?php $this->endWidget(); ?>

    <div class="row-fluid">
        <div class="span12 ">
            <strong class="nroAfectados"><?php echo $dataProvider->getTotalItemCount(); ?></strong>
            Personal Shoppers serán afectados <i class="icon-user"></i>
        </div>
    </div>

</div>
<div class="modal-footer text_align_left">
    <h5 style="margin-top: 0">Descripción:</h5>
    Cambiarás el valor de la comisión y el tipo de comisión para todos los Personal Shopper seleccionados.
    Este nuevo valor se aplicará en las próximas ventas
</div>                    

<?php $this->endWidget() ?>
<!--MODAL CAMBIO COMISION OFF-->


<!--MODAL CAMBIO TIEMPO EN BOLSA ON-->
<?php
$this->beginWidget('bootstrap.widgets.TbModal', array(
    'id' => 'modalTiempo',
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
    <h3 id="myModalLabel">Cambiar tiempo de validez para los Personal Shoppers</h3>
</div>
<div class="modal-body">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'formCambiarTiempo',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'type' => 'horizontal',
        // 'type'=>'inline',
        //'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <fieldset>       
        <div class="control-group">
            <label class="control-label">Tipo de Comisión:</label>
            <div class="controls">
                <?php
                echo TbHtml::dropDownList("cambiarLmTiempo", 1, array(15 => "15 Días",
                    30 => "1 Mes", 90 => "3 Meses", 180 => "6 Meses", 360 => "1 Año"),
                        array("span" => 2));
                ?>
            </div> 
        </div>   
        <div class="control-group">            
            <div class="controls">
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'type' => 'danger',
                    'buttonType' => 'button',
                    'label' => "Guardar cambios",
                    'htmlOptions' => array(
                        'id' => 'btnTiempo',
                    )
                ));
                ?>
            </div>
        </div>    
        <?php echo CHtml::hiddenField("action", 2); ?>
    </fieldset>

<?php $this->endWidget(); ?>

    <div class="row-fluid">
        <div class="span12 ">
            <strong class="nroAfectados"><?php echo $dataProvider->getTotalItemCount(); ?></strong>
            Personal Shoppers serán afectados <i class="icon-user"></i></div>
    </div>

</div>
<div class="modal-footer text_align_left">
    <h5 style="margin-top: 0">Descripción:</h5>
    Cambiarás el tiempo máximo que pueden durar los productos en la bolsa para que las venta genere comisión a un Personal Shopper, afectará a todos los Personal Shopper seleccionados.
    Este nuevo valor se aplicará en las próximas ventas.
</div>                    

<?php $this->endWidget() ?>
<!--MODAL CAMBIO TIEMPO EN BOLSA OFF-->


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
        <?php echo CHtml::hiddenField("action", 3); ?> 
    </fieldset>

<?php $this->endWidget(); ?>

    <div class="row-fluid">
        <div class="span12 ">
            <strong class="nroAfectados"><?php echo $dataProvider->getTotalItemCount(); ?></strong>
            Personal Shoppers serán afectados <i class="icon-user"></i>
        </div>
    </div>

</div>
<div class="modal-footer text_align_left">
    <h5 style="margin-top: 0">Descripción:</h5>
    Cambiarás el valor de la comisión por click para cada Personal Shopper para todos los Personal Shopper seleccionados.
    Este nuevo valor se aplicará en las próximas ventas.
</div>                    

<?php $this->endWidget() ?>
<!--MODAL CAMBIO COMISION OFF-->


<!-- /container -->
<script >

function accionMasiva(parametros){
    $.ajax(
            "<?php echo CController::createUrl(""); ?>",
            {
                type: 'POST',
                dataType: 'json',
                data: parametros,
                beforeSend: function(){
                    
                },
                success: function(data){                  
                    
                    $('#modalComision').modal("hide");
                    $('#modalTiempo').modal("hide");
                    $('#modalPagoClick').modal("hide");
                    
                    if(!$('#filters-view').is(":visible")){
                        $('#filters-view').show();
                    }
                    showAlert(data.status, data.message);
                    
                    $('html,body').animate({
                        scrollTop: $(".page-header").first().next().offset().top
                    });
                    
                    $.fn.yiiListView.update('list-auth-items'); 
                    
                   /* function () {
                        $.fn.yiiListView.update(
                        // this is the id of the CListView
                            'list-auth-items',
                            {}
                        )
                    }*/
                    
                },
                error: function( jqXHR, textStatus, errorThrown){
                    console.log("Error ejecutando el ajax");
                    console.log(jqXHR);
                }
            }
        );
}
//Numero de personal shoppers afectados con el cambio    
function actualizarNroUsuarios(id, data){

    $("strong.nroAfectados").text($("strong.nroAfectados", data).first().text());    
    
}


$(document).ready(function(){

    /*Boton de acciones masivas, para cambiar comision y tiempo*/
    $("#btnProcesar").click(function() {
        var accion = $("#listaAcciones").val();

        if (accion < 1) {
            bootbox.alert("Debes seleccionar una acción para aplicar!");
            return;
        }

        //Si es para cambiar comisión
        if (accion == 1) {

            $('#modalComision').modal();
            //Si es para cambiar tiempo limite     
        } else if (accion == 2) {
            
            $('#modalTiempo').modal();            
        } else if (accion == 3){
        	//alert ("Colocar pagos distintos para cada click del toor");
        	 $('#modalPagoClick').modal();
            //cambiar click
        }

    });

    $('#search-form').attr('action', '');
    $('#search-form').submit(function() {
        return false;
    });
    
    /*Acciones dentro de los modals*/
    /*Cambiar comisión*/
    $("#btnComision").click(function (e){
        
        var tipo = $("#cambiarVlComision").next().text();
        
        var comision = $("#cambiarVlComision").val();
        var usuarios = $("strong.nroAfectados").first().text();        
        
        var res = confirm('¿Estás seguro de establecer "'+comision+' '+tipo+'" como comisión '+
            'para "'+usuarios+'" Personal Shoppers?');
        
        if(res){
            var args = $("#formCambiarComision").serialize();
            accionMasiva(args);
        }
    });
    
    //Cambiar símbolo Tipo de Comision
    $("#cambiarTpComision").change(function (e){        
        var htmlC = ($(this).val() == 1) ? "%" : $("#cambioMoneda").html();                
        $("#cambiarVlComision").next().html(htmlC);
    });
        
    $("#btnTiempo").click(function (e){      
        
        var tiempo = $("#cambiarLmTiempo option:selected").text();
        var usuarios = $("strong.nroAfectados").first().text();
        
        var res = confirm('¿Estás seguro de establecer el límite de tiempo en'+
                            '"'+tiempo+'" para "'+usuarios+'" Personal Shoppers?');
        if(res){
            var args = $("#formCambiarTiempo").serialize();
            accionMasiva(args);
        }
        
    });
    
    /*Change click rate*/
    $("#btnClick").click(function (e){
        
        var porClick = $("#totalClick").val();
        var usuarios = $("strong.nroAfectados").first().text();        
        
        var res = confirm('¿Estás seguro de establecer '+porClick+' como comisión por click '+
            'para "'+usuarios+'" Personal Shopper(s)?');
        
        if(res){
            var args = $("#formCambiarComisionClick").serialize();
            accionMasiva(args); 
        }
    });
    
});    
</script>