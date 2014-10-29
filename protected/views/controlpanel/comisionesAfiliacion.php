<?php 

$this->pageTitle=Yii::app()->name . ' - Historial por afiliación'; 

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
        <h1>Historial de pagos de comisiones por afiliación</h1>       
    </div>
    <div class="row">
        <div class="span12 box_shadow bg_color13">
            <div class="row"> 
                <!--Imagen-->
                <div class="span2">
                    <?php echo CHtml::image($personalShopper->getAvatar(), 
                        'Foto', array("width" => "200", "height" => "200")); ?>

                </div>
                <!--Datos-->
                <div class="span3 padding_top_medium">
                    <h2>
                        <?php echo $personalShopper->profile->first_name .
                        " " . $personalShopper->profile->last_name;
                        ?>
                    </h2>
                    <h4>Comisión por clic actual:
                        <strong>
                            <?php echo $personalShopper->getComision(); ?>                            
                        </strong>
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
                <div class="span7 padding_top_medium margin_top_medium text_align_center">                    
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
        'itemView' => '_viewComisionAfiliacion', 
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

    <div class="span2"><a href="<?php echo Yii::app()->baseUrl."/controlpanel/exportarAfiliacionCSV"; ?>" title="Exportar a excel" class="btn btn-info">Exportar a excel</a></div>

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
    });

</script>	