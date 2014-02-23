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
        <h1>Administrar Gift cards</h1>
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
                "id_filter", "name"), array('empty' => '-- Filtros Preestablecidos --', 'id' => 'all_filters')) ?>

    </div>
        <div class="span2"><a href="#" class="btn crear-filtro">Crear nuevo filtro</a></div>
        <div class="span2 offset2">
            <a href="create" class="btn btn-success">Crear GiftCard</a>
        </div>
        <div class="span2">
            <a href="createMasivo" class="btn btn-success">Exportación Masiva</a>
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
    $template = '{summary}
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
            <th rowspan="2" scope="col"></th>
            <th rowspan="2" scope="col">Id</th>
            <th rowspan="2" scope="col">Comprador</th>
            <th rowspan="2" scope="col">Estado</th>
            <th rowspan="2" scope="col">Monto en '.Yii::t('contentForm', 'currSym').'</th>
            <th colspan="2" scope="col">Vigencia</th>
            <th rowspan="2" scope="col">Fecha de Aplicación<br>Usuario que la aplicó</th>
            <th rowspan="2" scope="col">Acciones</th>
        </tr>
        <tr>
            <th scope="col">Desde</th>
            <th scope="col">Hasta</th>
        </tr>
    {items}
    </table>
    {pager}
	';

    $this->widget('zii.widgets.CListView', array(
        'id' => 'list-auth-items',
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
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

                    } ",
        'pager' => array(
            'header' => '',
            'htmlOptions' => array(
                'class' => 'pagination pagination-right',
            )
        ),
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

</div>
<style>
    #modalGiftCard .modal-body{
        min-height: 300px;
        max-height: 1000px;
    }
</style>
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
<?php 
//if(isset(Yii::app()->session["documentoExcel"])){
//        
//        $document = Yii::app()->session["documentoExcel"];
//        unset(Yii::app()->session["documentoExcel"]);
//           
//            Yii::import('ext.phpexcel.XPHPExcel');    
//            // Redirect output to a clientâ€™s web browser (Excel5)
//            header('Content-Type: application/vnd.ms-excel');
//            header('Content-Disposition: attachment;filename="GiftCards.xls"');
//            header('Cache-Control: max-age=0');
//            // If you're serving to IE 9, then the following may be needed
//            header('Cache-Control: max-age=1');
//
//            // If you're serving to IE over SSL, then the following may be needed
//            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
//            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
//            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//            header ('Pragma: public'); // HTTP/1.0
//
//            //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//            $objWriter = PHPExcel_IOFactory::createWriter($document, 'Excel5');
//            $objWriter->save('php://output');
//            Yii::app()->end();
////            $objWriter->save(Yii::getPathOfAlias("webroot")."/docs/giftcards/GiftCards.xls");
//            //$objWriter->save("GiftCards.xls");
//               
//             
//        
//        
//    } 
    ?>