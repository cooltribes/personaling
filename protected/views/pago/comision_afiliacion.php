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
        <h1>Pago de comisiones por afiliación a productos de terceros</h1>
    </div>    
    
    <div class="row">
        <div class="span6">
           <fieldset>
                
                <legend>Datos del último pago realizado</legend>
                <ul class="no_bullets no_margin_left">                    
                    <li><strong>Fecha y hora: </strong>
                        14/07/2014 11:30:46 pm                        </li>
                    <li><strong>Monto pagado: </strong>
                        24.000,9 <?php echo Yii::t('contentForm', 'currSym'); ?>
                    </li>                    
                </ul>

            </fieldset>
        </div>
        <div class="span6">
            
             <fieldset>                
                <legend>Ingresa el monto para el mes actual</legend>
                    <?php
                        $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                            'id'=>'pago-form',
                            "htmlOptions" => array(
                                "class" => "text_align_center"                                                                
                            )
                        ));     
                    ?>
                
                    <div class="control-group input-prepend margin_left_small">                        
                        <div class="controls">
                            <span class="add-on"><?php echo Yii::t('contentForm', 'currSym'); ?></span>                            
                            
                            <?php
                                echo TbHtml::numberField('monthlyEarning', 0, array(                                
                                    'step' => 'any',
                                    'min' => "1",
                                    'max' => 25000,                                
                                    'class' => "span2",                                
                                ));
                            
                                echo TbHtml::submitbutton("Pagar", array(
                                    "id" => "pay",
                                    "color" => "warning",
                                    "class" => "margin_left_small",
                                ));   
                               
                            ?>
                            
                        </div>
                    </div>
                    <?php
                        $this->endWidget();
                    ?>
            </fieldset>
        </div>
    </div>
    <div class="row margin_top margin_bottom ">
        <div class="span4">
            <?php
            
//            echo CHtml::beginForm(CHtml::normalizeUrl(array('index')), 'get', array('id' => 'search-form'))
//            . '<div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>'
//            . CHtml::textField('nombre', (isset($_GET['string'])) ? $_GET['string'] : '', array('id' => 'textbox_buscar', 'class' => 'span3', 'placeholder' => 'Buscar'))
//            . CHtml::endForm();
            ?>
        </div>
    </div>
    <div class="span3">
        <?php // echo CHtml::dropDownList("Filtros", "", Chtml::listData(Filter::model()->findAll('type = 8'), "id_filter", "name"), array('empty' => '-- Búsquedas avanzadas --', 'id' => 'all_filters'))
        ?>
    </div>
    <!--<div class="span3 "><a href="#" class="btn  crear-filtro">Crear búsqueda avanzada</a></div>-->
    
</div>

<?php // $this->renderPartial("_filters"); ?>
<!--<hr/>-->
<?php
$template = '{summary}
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped table-condensed">
    <tr>      
      <th colspan="3" rowspan="2" scope="col">Personal Shopper</th>
      <th colspan="2" scope="col" style="text-align: center">Visitas Generadas</th>
      <th rowspan="2" scope="col" style="text-align: center">Porcentaje<br>de<br>Comisión</th>
      
      <th rowspan="2" scope="col" style="text-align: center">Monto a pagar ('.Yii::t('contentForm', 'currSym').')</th>            
    </tr>
    <tr>
      <th scope="col">Totales</th>
      <th scope="col">Mes Actual</th>      
    </tr>
    {items}
    </table>
    {pager}';

$this->widget('zii.widgets.CListView', array(
    'id' => 'list-auth-items',
    'dataProvider' => $dataProvider,
    'itemView' => '_view_ps_comision',
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
	    $(document).keyup(function(e){
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
            "2" => "Cambiar validez de la bolsa"), array('prompt' => '-- Seleccione una acción --', 'id' => 'listaAcciones'))
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

<!-- /container -->
<script>

/* Funcion para cambiar los montos que le corresponden a cada PS de acuerdo al 
 * monto ingresado en el campo #monthlyEarning
 * */
function cambiarMontosEnTabla(e){
    
    console.log($(this).val()); 
    
}

/*Método para el botón pagar*/
function formSubmit(e){
    
    e.preventDefault();    
    bootbox.confirm("Se realizará el pago a todas las personal shoppers en\n\
        Personaling, ¿Deseas continuar?",
        function(result) {

            if(result){

                $('body').addClass("aplicacion-cargando");
                $('form#pago-form').submit();
                
            }
            
        }
    );
        
}


$(document).ready(function(){

    $('#monthlyEarning').change(cambiarMontosEnTabla);
    
    
//    $('button#pay').click(accionBotonPagar);
    $('form#pago-form').submit(formSubmit);
    
});    
</script>