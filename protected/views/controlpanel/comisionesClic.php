<?php 

$this->pageTitle=Yii::app()->name . ' - Historial por clic'; 

//$this->breadcrumbs=array(
//	'Productos',
//);
$pagerParams = array(
    'header' => '',
    'prevPageLabel' => Yii::t('contentForm', 'Previous'),
    'nextPageLabel' => Yii::t('contentForm', 'Next'),
    'firstPageLabel' => Yii::t('contentForm', 'First'),
    'lastPageLabel' => Yii::t('contentForm', 'Last'),
    'htmlOptions' => array(
        'class' => 'pagination pagination-right'))
?>

<div class="container margin_top">
    <div class="page-header">
        <h1>Historial de comisiones por clic</h1>   
            
    </div>
    <div class="row">
        <div class="span12 box_shadow bg_color13">
            <div class="row"> 
                <!--Imagen-->
                <div class="span2">
                    <?php  
						echo CHtml::image($personalShopper->getAvatar(), 
                        'Foto', array("width" => "200", "height" => "200")); ?>

                </div>
                <!--Datos-->
                <div class="span5 padding_top_medium">
                    <h2>
                        <?php echo $personalShopper->profile->first_name .
                        " " . $personalShopper->profile->last_name;
                        ?>
                    </h2>
                    <h4 >Comisión por clic actual:
                        <strong id="comisionClick">
                            <?php echo $personalShopper->getPagoClick(); ?>                            
                        </strong>
                        <?php  echo '<a href="#" class="btn btn-mini btnProcesar margin_left_small" id="'.$personalShopper->id.'"><i class="icon-cog"></i>Cambiar</a></td>'; ?>
                    </h4>
                    <h4>Saldo en comisiones:
                        <strong>
                            <?php echo $personalShopper->getSaldoPorComisiones()." ".Yii::t('backEnd', 'currSym'); ?>                            
                        </strong>
                    </h4>
                    <label class="muted">
                        En espera de aprobación:                        
                        <strong>
                            <?php echo $personalShopper->getSaldoEnEspera()." ".Yii::t('backEnd', 'currSym'); ?>                                                        
                        </strong>
                    </label>
                </div>
                <!--Totales-->
                <div class="span5 padding_top_medium margin_top_medium text_align_center">                    
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">                        
                        <tr>
                            <td class="td-relative"><p class="T_xlarge margin_top_xsmall">
                                    <?php
                                    echo Balance::model()->countByAttributes(array('user_id'=>$personalShopper->id,'tipo'=>11));
                                    ?>
                                </p>
                                Total de pagos
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <hr/>
    <?php 
    $template = '{summary}
  <table id="table" width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
    <tr>
      <th scope="col">Fecha</th>
      <th scope="col">Comisión ('.Yii::t('backEnd', 'currSym').')</th>      
      <th scope="col">Total de Vistas</th>
      <th scope="col"># Pago Afiliado</th>
    </tr>
    {items}
    </table>
    {pager}
	';

    $this->widget('zii.widgets.CListView', array(
        'id' => 'list-auth-items',
        'dataProvider' => $dataProvider,
        'itemView' => '_viewComisionClic',
        'template' => $template,
        'summaryText' => "Mostrando {start} - {end} de {count} Resultados",
        'enableSorting' => 'true',
        'afterAjaxUpdate' => " function(id, data) {
						    	
							$('#todos').click(function() { 
				            	inputs = $('table').find('input').filter('[type=checkbox]');
				 
				 				if($(this).attr('checked')){
				                     inputs.attr('checked', true);
				               	}else {
				                     inputs.attr('checked', false);
				               	} 	
							});
						   
							} ",
        'pager' => $pagerParams,
    ));
    ?>

    <hr/>

    <div class="span2"><a href="<?php ECHO Yii::app()->baseUrl."/controlpanel/exportarClicCSV"; ?>" title="Exportar a excel" class="btn btn-info">Exportar a excel</a></div>

</div>
<?php

function compara_fechas($fecha1, $fecha2) {
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/", $fecha1))
        list($dia1, $mes1, $año1) = explode("/", $fecha1);
    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/", $fecha1))
        list($dia1, $mes1, $año1) = explode("-", $fecha1);
    if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/", $fecha2))
        list($dia2, $mes2, $año2) = explode("/", $fecha2);
    if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/", $fecha2))
        list($dia2, $mes2, $año2) = explode("-", $fecha2);
    $dif = mktime(0, 0, 0, $mes1, $dia1, $año1) - mktime(0, 0, 0, $mes2, $dia2, $año2);
    return ($dif);
}
?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'myModal', 'htmlOptions' => array('class' => 'modal hide fade', 'tabindex' => '-1', 'role' => 'dialog', 'aria-labelleby' => 'myModalLabel', 'aria-hidden' => 'true'))); ?>

<?php $this->endWidget(); ?>

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

<script type="text/javascript">

    $(document).ready(function() {

        $("#todos").click(function() {

            inputs = $('table').find('input').filter('[type=checkbox]');

            if ($(this).attr("checked")) {
                inputs.attr('checked', true);
            } else {
                inputs.attr('checked', false);
            }
        });

        var selected = new Array();
        
            $(".btnProcesar").click(function() {
            
            var id = $(this).attr("id");
           // alert(id);

            /* change hidden PS value */
            $("#ps").val(id);

            /* Show Modal */
            $('#modalPagoClick').modal();
   		 });
    });
    
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
    var variable= parametros.split('&');
     var valor= variable[0].split('=');
     var moneda="<?php echo Yii::t('backEnd', 'currSym');?>";
     
     
    $.ajax(
            "<?php echo CController::createUrl('pago/CambiarComisionClic'); ?>",
            {
                type: 'POST',
                dataType: 'json',
                data: parametros,
                beforeSend: function(){
                    
                },
                success: function(data){                  
                    
                    $('#modalPagoClick').modal("hide");
                    
                    document.getElementById('comisionClick').innerHTML = valor[1]+" "+moneda;
                },

                error: function( jqXHR, textStatus, errorThrown){
                    console.log("Error ejecutando el ajax");
                    console.log(jqXHR);
                }
            }
        );

}

</script>	