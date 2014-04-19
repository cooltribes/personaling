<?php
/* @var $this GiftcardController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Mis Giftcards',
);

$this->pageTitle = Yii::app()->name . ' - Mis GiftCards';

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
        <h1><?php echo Yii::t('contentForm','My Gift Cards'); ?></h1>
    </div>
    <div class="row">
        <div class="span2 offset7">
            <a href="comprar" class="btn btn-warning"><i class="icon-shopping-cart icon-white"></i> <?php echo Yii::t('contentForm','Buy Gift Card'); ?></a>
        </div>
        <div class="span3">
            <a href="aplicar" class="btn btn-danger"><i class="icon-gift icon-white"></i> <?php echo Yii::t('contentForm','Apply Gift Card'); ?></a>
        </div>        
    </div>
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
            <!--
            <th rowspan="2" scope="col"></th>
            <th rowspan="2" scope="col">Comprador</th>
            -->
            <th rowspan="2" scope="col">'.Yii::t('contentForm','ID').'</th>
            <th rowspan="2" scope="col">'.Yii::t('contentForm','State').'</th>
            <th rowspan="2" scope="col">'.Yii::t('contentForm','Amount in').' '.Yii::t('contentForm', 'currSym').'</th>
            <th colspan="2" scope="col">'.Yii::t('contentForm','Validity').'</th>
            <th rowspan="2" scope="col">'.Yii::t('contentForm','Date of Application <br> User who applied it').'</th>
            <th rowspan="2" scope="col">'.Yii::t('contentForm','Actions').'</th>
        </tr>
        <tr>
            <th scope="col">'.Yii::t('contentForm','From1').'</th>
            <th scope="col">'.Yii::t('contentForm','Until').'</th>
        </tr>
    {items}
    </table>
    {pager}
	';

    $this->widget('zii.widgets.CListView', array(
        'id' => 'list-auth-items',
        'dataProvider' => $model->giftcardsUser(),
        'itemView' => '_viewAdminUser',
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
    <a href="" data-dismiss="modal" class="btn">Cerrar</a>    
     <?php 
        $this->widget("bootstrap.widgets.TbButton", array(
           'buttonType' => "link" ,
           'type' => "info" ,
           'icon' => "print white" ,
           'label' => Yii::t('contentForm','Print') ,
           'url' => "javascript:printElem('#divImprimir')" ,
        ));

    ?>

</div>

<?php $this->endWidget(); ?>
<!------------------- MODAL WINDOW OFF ----------------->


<script type="text/javascript">
/*<![CDATA[*/

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

/*Imprimir un div*/
function printElem(elem)
{
    popup($(elem).html());
}

function popup(data) 
{        

    var h = 600;
    var w = 800;
    var left = (screen.width - w)/2;
    var top = (screen.height - h)/2 - 30;
    var mywindow = window.open('', 'GiftCard Personaling', 'height='+h+',width='+w+', left='+left+', top='+top);
    mywindow.document.write('<html><head><title>GiftCard</title>');
    /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
    mywindow.document.write('</head><body >');
    mywindow.document.write(data);
    mywindow.document.write('</ body></html>');

    mywindow.print();
    mywindow.close();

    return true;
}
/*]]>*/

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