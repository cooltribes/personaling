<?php
/* @var $this GiftcardController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Inventario',
    'MasterData - '.$id => array("masterData/admin"),
    'Detalle',
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
        <h1><?php echo Yii::t('contentForm' , 'MasterData details') . " - <strong>ID: {$id}</strong>"; ?></h1>
    </div>
    <style>
        th.totales{
            width: 14%;
        }
        th.acciones{
            width: 8%;
        }
    </style>
        <?php 
//        $this->renderPartial('_filters'); 
        ?>
    
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
            'class'=>'pagination pagination-right')
        );   
    
    $template = '{summary}
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>            
            <th classrowspan="2" scope="col">'.Yii::t('contentForm' , 'SKU').'</th>
            <th rowspan="2" scope="col">'.Yii::t('contentForm' , 'Status').'</th>
            <th class="acciones" rowspan="2" scope="col">'.Yii::t('contentForm' , 'Actions').'</th>            
        </tr>
        <tr>
            
        </tr>
    {items}
    </table>
    {pager}
	';

    $this->widget('zii.widgets.CListView', array(
        'id' => 'list-auth-items',
        'dataProvider' => $dataProvider,
        'itemView' => '_viewDetalle',
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
                        
                        //desactivarGC();

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

<script type="text/javascript">

function marcarCorregida(idItem){

    $.ajax({
        type: 'GET',
        url: '<?php echo CController::createUrl('inbound/corregirItem')?>',
        dataType: 'JSON',
        data: {id: idItem},
        success: function(data){
//            console.log(data);
            bootbox.alert(data.status);
            if(data.status === 'success'){
               ajaxUpdateTimeout = setTimeout(function () {
               $.fn.yiiListView.update(
                    'list-auth-items',
                    {
                        type: 'POST',	
                        url: '<?php echo CController::createUrl('inbound/detalle')?>',
                        data: ajaxRequest
                    }

               )
               },
               300);

            }else if(data.status === 'error'){

            }

        }
    });

}

    

</script>
</div>
    