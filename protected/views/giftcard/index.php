<?php
/* @var $this GiftcardController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Giftcards',
);
?>

<div class="container">
    <div class="page-header">
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
        <h1><?php echo Yii::t('contentForm' , 'Manage Gift Card'); ?></h1>
    </div>
    <style>
        input.input-search{
            height: 18px;
        }
    </style>
    <div class="row">
  <!--       <div class="span3">
          <div class="input-append">
           <form class="no_margin_bottom form-search">
                <input type="text" name="query" id="query" class="span2 input-search">
                <a class="btn" id="btn_search_event"><i class="icon-search"></i> Buscar</a>
            </form>
            <?php
            /*Codigo para hacer una búsqueda haciendo click en el boton*/
           /* Yii::app()->clientScript->registerScript('query1',
                    "var ajaxUpdateTimeout;
                    var ajaxRequest;
                    $('#btn_search_event').click(function(){
                        $('.crear-filtro').click();
                        ajaxRequest = $('#query').serialize();
                        clearTimeout(ajaxUpdateTimeout);

                        ajaxUpdateTimeout = setTimeout(function () {
                        $.fn.yiiListView.update(
                        'list-auth-items',
                        {
                        type: 'POST',	
                        url: '" . CController::createUrl('producto/admin') . "',
                        data: ajaxRequest}

                        )
                        },

                    300);
                    return false;
                    });",CClientScript::POS_READY
            );

            // Codigo para actualizar el list view cuando presionen ENTER

            Yii::app()->clientScript->registerScript('query',
                    "var ajaxUpdateTimeout;
                    var ajaxRequest; 

                    $(document).keypress(function(e) {
                        if(e.which == 13) {
                        $('.crear-filtro').click();
                            ajaxRequest = $('#query').serialize();
                                    clearTimeout(ajaxUpdateTimeout);

                                    ajaxUpdateTimeout = setTimeout(function () {
                                            $.fn.yiiListView.update(
                                            'list-auth-items',
                                            {
                                            type: 'POST',	
                                            url: '" . CController::createUrl('producto/admin') . "',
                                            data: ajaxRequest}

                                            )
                                            },

                            300);
                            return false;
                        }
                    });",CClientScript::POS_READY
            );	
            
            */
            ?>	

        </div>
        </div>-->
    <div class="span3 offset1">   
        
        <?php echo CHtml::dropDownList("Filtros", "", Chtml::listData(Filter::model()->findAll('type = 7'),
                "id_filter", "name"), array('empty' => '-- Búsqueda avanzada --', 'id' => 'all_filters')) ?>

    </div>
        <div class="span3"><a href="#" class="btn crear-filtro">Crear búsqueda avanzada</a></div>
        <div class="span2">
            <a href="create" class="btn btn-success"><?php echo Yii::t('contentForm' , 'Create Gift Card'); ?></a>
        </div>
        <div class="span2">
            <a href="createMasivo" class="btn btn-success"><?php echo Yii::t('contentForm' , 'Massive Export'); ?></a>
        </div>        
    </div>
    <hr/>
        <?php $this->renderPartial('_filters'); ?>
    <hr/>
    <style>
        .table th{
            vertical-align: middle;
            text-align: center;
        }
    </style>
    
    <?php
    $pagerParams=array(
        'header'=>'',
        'prevPageLabel' => Yii::t('contentForm','Previous'),
        'nextPageLabel' => Yii::t('contentForm','Next'),
        'firstPageLabel'=> Yii::t('contentForm','First'),
        'lastPageLabel'=> Yii::t('contentForm','Last'),
        'htmlOptions'=>array(
            'class'=>'pagination pagination-right'));    
    
    
    $template = '{summary}
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
            
            <th rowspan="2" scope="col">'.Yii::t('contentForm' , 'ID').'</th>
            <th rowspan="2" scope="col">'.Yii::t('contentForm' , 'Buyer').'</th>
            <th rowspan="2" scope="col">'.Yii::t('contentForm' , 'State').'</th>
            <th rowspan="2" scope="col">'.Yii::t('contentForm' , 'Amount').' '.Yii::t('contentForm', 'currSym').'</th>
            <th colspan="2" scope="col">'.Yii::t('contentForm' , 'Validity').'</th>
            <th rowspan="2" scope="col">'.Yii::t('contentForm' , 'Date of Application <br> User who applied it').'</th>
            <th rowspan="2" scope="col">'.Yii::t('contentForm' , 'Actions').'</th>
        </tr>
        <tr>
            <th scope="col">'.Yii::t('contentForm' , 'From1').'</th>
            <th scope="col">'.Yii::t('contentForm' , 'Until').'</th>
        </tr>
    {items}
    </table>
    {pager}
	';

    $this->widget('zii.widgets.CListView', array(
        'id' => 'list-auth-items',
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
        'summaryText' => 'Mostrando {start} - {end} de {count} Resultados',  
        'template' => $template,
        'afterAjaxUpdate' => " function(id, data) {						    	
                        $('#todos').click(function() { 
                            inputs = $('table').find('input').filter('[type=checkbox]');

                                            if($(this).attr('checked')){
                                 inputs.attr('checked', true);
                            }else {
                                 inputs.attr('checked', false);
                            } 	
                        });
                        
                        desactivarGC();
                        actualizarNroGC(data);

                    } ",
        'pager'=>$pagerParams,  
    ));
    ?>
  
    <hr/>
    
    <?php //$this->render ?>
<!--    <div class="row">
      <div class="span3">
        <select class="span3">
          <option>Acciones en lote </option>
          <option>Borrar</option>
          <option>Pausar</option>
        </select>
      </div>
      <div class="span1"><a href="#" title="procesar" class="btn btn-danger">Procesar</a></div>
      <div class="span2"><a href="#" title="Exportar a excel" class="btn btn-info">Exportar a excel</a></div>
    </div>-->


<h3>Acciones Masivas</h3>
<hr/>
<div class="row">
    <div class="span3">       
        <?php
        echo CHtml::dropDownList("Acciones", "", array(
            "1" => "Cambiar Validez",
           ),
            array('prompt' => '-- Seleccione una acción --', 'id' => 'listaAcciones'))
        ?>
    </div>
    <div class="span1">
        <a id="btnProcesar" title="Procesar" class="btn btn-danger">Procesar</a>
    </div>
</div>


</div>
<style>
    #modalGiftCard .modal-body{
        min-height: 300px;
        max-height: 1000px;
    }
</style>


<!--MODAL CAMBIO FECHAS ON-->
<?php
$this->beginWidget('bootstrap.widgets.TbModal', array(
    'id' => 'modalFechas',
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
    <h3>Cambiar fecha de expiración</h3>
</div>

<div class="modal-body">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'formCambiarComision',
        'action' => $this->createUrl("giftcard/cambiarFechas"),
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
        'type' => 'horizontal',
        'enableAjaxValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <fieldset>       
<!--        <div class="control-group">
            <label class="control-label">Válida desde</label>
            <div class="controls">
                <div class="input-append"  data-date-format="dd-mm-yyyy">
                    <input type="text" class="span2" id="fechaInicial" >
                    <?php
                    $this->widget("bootstrap.widgets.TbDatePicker", array(
                        'name' => "fechaInicial",                    
                        'htmlOptions' => array(
                            'class' => "span2"
                        ),
                        'options' => array(
                            'format' => 'dd-mm-yyyy',
                            'language' => 'es',
                        ),
                    ));
                    ?>
                
                    <span class="add-on"><icon class="icon-calendar"></icon></span>
                </div>
            </div>
        </div>-->
        <div class="control-group margin_top_medium">
            <label class="control-label">Fecha de expiración:</label>
            <div class="controls">
                <div class="input-append" data-date-format="dd-mm-yyyy">
                    <!--<input type="text" class="span2" value="" id="fechaFinal">-->
                   <?php
                    $this->widget("bootstrap.widgets.TbDatePicker", array(
                        'name' => "fechaFinal",
                        'htmlOptions' => array(
                            'class' => "span2"
                        ),
                        'options' => array(
                            'format' => 'dd-mm-yyyy',
                            'language' => 'es',
                            
                        )
                    ));
                    ?>                     
                    <span class="add-on"><icon class="icon-calendar"></icon></span>
                </div>
            </div>
        </div> 
        <div class="control-group">            
            <div class="controls">
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'type' => 'danger',
                    'buttonType' => 'submit',
                    'label' => "Guardar cambios",
                    'htmlOptions' => array(
                        'id' => 'btnFechas',
                        'name' => 'btnFechas',
                    )
                ));
                ?>
            </div>
        </div>            
        <?php echo CHtml::hiddenField("action", 1); ?>
    </fieldset>

<?php $this->endWidget(); ?>

    <div class="row-fluid">
        <div class="span12 ">
            <strong class="nroAfectados"><?php echo $dataProvider->getTotalItemCount(); ?></strong>
            Gift Cards serán cambiadas
        </div>
    </div>

</div>
<div class="modal-footer text_align_left">
    <h5 style="margin-top: 0">Descripción:</h5>
    Cambiarás el tiempo de validez de todas las Gift Cards que se muestran en el listado.
</div>                    

<?php $this->endWidget() ?>
<!--MODAL CAMBIO DE FECHAS OFF-->




<!------------------- MODAL WINDOW ON ----------------->
<?php $this->beginWidget("bootstrap.widgets.TbModal", array(
   'id' => "modalGiftCard", 
)); ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>GiftCard</h3>
</div>

<div class="modal-body">
    
</div>

<div class="modal-footer">
    <a href="" data-dismiss="modal" class="btn btn-danger">Cerrar</a>    
</div>

<?php $this->endWidget(); ?>
<!------------------- MODAL WINDOW OFF ----------------->


<script type="text/javascript">
 $('#modalFechas').modal();
//Nro de GC q seran actualizadas despues de cada busqueda
function actualizarNroGC(data){

    $("strong.nroAfectados").text($("strong.nroAfectados", data).text());    
    
}

/*Boton de acciones masivas, para cambiar comision y tiempo*/
    $("#btnProcesar").click(function() {
        var accion = $("#listaAcciones").val();

        if (accion < 1) {
            bootbox.alert("Debes seleccionar una acción para aplicar!");
            return;
        }

        //Si es para cambiar validez
        if (accion == 1) {

            $('#modalFechas').modal();
                
        } 

    });    
    
    
/*Para la seleccion de fechas*/    
  
    
    
    
    
    
function desactivarGC(){       
    /*Desactivar giftcard*/
    $("[id^='linkDesactivar']").click(function (e){
            e.preventDefault();
            //console.log("click");
            var idString = $(this).attr('id');    
            var vect = idString.split("-");
            var ajaxRequest;
            $.ajax({
                type: 'POST',
                url: 'desactivar',
                dataType: 'JSON',
                data: {id: vect[1]},
                success: function(data){
                
                    if(data.status == 'success'){
                        
                       bootbox.alert("¡La Gift Card se ha desactivado con éxito!");
                       
                       ajaxUpdateTimeout = setTimeout(function () {
                       $.fn.yiiListView.update(
                            'list-auth-items',
                            {
                                type: 'POST',	
                                url: '<?php echo CController::createUrl('index')?>',
                                data: ajaxRequest
                            }

                       )
                       },
                       300);
                       
                    }else if(data == 'error'){
                       bootbox.alert("Error desactivando la Gift Card");
                    }
                }
            });
            
        });
}

/*Ver modal con datos de la giftcard*/
function ver(id){
    
    var urlModal = "<?php echo CController::createUrl("/tienda/modalAjax"); ?>";  
    $("#modalGiftCard .modal-body").empty();        
    $.ajax({
        type: 'POST',
        url: urlModal,
        dataType: 'JSON',
        data: {modal : "giftcard", id : id},
        success: function(data){
            
            $("#modalGiftCard .modal-body").html(data.data);
            //$("#modalPerfilesOcultos").modal("show");

        }
    });

}


function changeFilter(e){
   var column = $(this);
   
   //si es fecha
   if(column.val() === 'inicio_vigencia' || column.val() === 'fin_vigencia') //Fechas
   {
       dateFilter(column);
    
   }else if(column.val() === 'estado') //Estado del usuario, tipo usuario, fuenteRegistro
   {       
       
       listFilter(column, column.val());
        

   }else if(column.val() === 'comprador' || column.val() === 'beneficiario') 
   {
       textFilter(column);       
        
   }else //campo normal (numérico)
   {      
      valueFilter(column);       
      
   }
    
}

</script>
