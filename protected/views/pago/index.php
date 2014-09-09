<?php
/* @var $this PagoController */
/* @var $model Pago */

$this->breadcrumbs=array(	
	Yii::t('contentForm' , 'My Payments'),
);

$this->setPageTitle(Yii::app()->name . " - " . Yii::t('contentForm', 'My Payments'));


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
        <h1><?php echo Yii::t('contentForm' , 'My Payments'); ?></h1>
    </div>
    <div class="row">
        <div class="span2 pull-right">
            <?php $this->widget("bootstrap.widgets.TbButton", array(
                'label' => 'Nueva solicitud',
                'type' => 'success',                                
                'url' => $this->createUrl("solicitar"),
            )) ?> 
        </div>
    </div>
    <hr>
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
                
                <th scope="col">'.Yii::t('contentForm' , 'No.').'</th>                
                <th scope="col">'.Yii::t('contentForm' , 'State').'</th>                
                <th scope="col">'.Yii::t('contentForm' , 'Payment Type').'</th>
                <th scope="col">'.Yii::t('contentForm' , 'Amount').'</th>
                <th scope="col">'.Yii::t('contentForm' , 'Request Date').'</th>
                <th scope="col">'.Yii::t('contentForm' , 'Response Date').'</th>                
            </tr>           
        {items}
        </table>
        {pager}
            ';

        $this->widget('zii.widgets.CListView', array(
            'id' => 'list-auth-items',
            'dataProvider' => $dataProvider,
            'itemView' => '_viewPs',
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

                            

                        } ",
            'pager'=>$pagerParams,  
        ));
        ?>
    
    
    
</div>
        
        
