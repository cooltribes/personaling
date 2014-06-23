<?php
/* @var $this GiftcardController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Inventario',
    'Inbound',
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
        <h1><?php echo Yii::t('contentForm' , 'Manage') . " Archivos <strong>Inbound</strong>"; ?></h1>
    </div>
    <style>
        th.albaran{
            width: 6%;
        }
        th.totales{
            width: 9%;
        }
        th.acciones{
            width: 8%;
        }
        
        td.nombreUsuario{
            width: 23%;
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
            <th class="albaran" rowspan="2" scope="col">'.Yii::t('contentForm' , 'Albaran<br>(ID)').'</th>
            <th colspan="2" scope="col">'.Yii::t('contentForm' , 'User').'</th>
            <th rowspan="2" scope="col">'.Yii::t('contentForm' , 'Status').'</th>
            <th rowspan="2" scope="col">'.Yii::t('contentForm' , 'Upload date').'</th>
            <th class="totales" rowspan="2" scope="col">'.Yii::t('contentForm' , 'No. of SKU').'</th>
            <th class="totales" rowspan="2" scope="col">'.Yii::t('contentForm' , 'Total sent amount').'</th>
            <th class="totales" rowspan="2" scope="col">'.Yii::t('contentForm' , 'Total acknowledged amount').'</th>
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

</div>