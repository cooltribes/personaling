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
        <div class="span3">
            <a href="create" class="btn btn-success">Crear Gift Card</a>
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
