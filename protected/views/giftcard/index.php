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
    <div class="row">
        <div class="span2">
            <a href="create" class="btn btn-success">Crear Gift Card</a>
        </div>
        <div class="span3">
            <a href="createMasivo" class="btn btn-success">Crear Gift Card Masivo</a>
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
            <th rowspan="2" scope="col"></th>
            <th rowspan="2" scope="col">Id</th>
            <th rowspan="2" scope="col">Comprador</th>
            <th rowspan="2" scope="col">Estado</th>
            <th rowspan="2" scope="col">Monto Bs.</th>
            <th colspan="2" scope="col">Vigencia</th>
            <th rowspan="2" scope="col">Fecha de Aplicacion</th>
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
<script type="text/javascript">
    
    
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
                        
                       bootbox.alert("¡La Gift Card se ha desactivado éxito!");
                       
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