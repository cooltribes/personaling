<?php
	$this->breadcrumbs=array(
		'Mis Looks',
	);

?>
<div class="container margin_top">
    <div class="page-header">
        <h1><?php echo Yii::t('contentForm','Manage my Looks'); ?></small></h1>
    </div>
    <table width="60%" border="0" cellspacing="0" cellpadding="0" class="table ">
        <tr>
            <th scope="col" colspan="6"> <?php echo Yii::t('contentForm','Totals'); ?> </th>
        </tr> 
        <tr>
            <td><p class="T_xlarge margin_top_xsmall"> <?php echo $look->getTotalbyUser(); ?> </p>
                <?php echo Yii::t('contentForm','Totals'); ?></td>
            <td><p class="T_xlarge margin_top_xsmall"> <?php echo $look->getxStatusbyUser(2); ?> </p>
                <?php echo Yii::t('contentForm','Approved'); ?></td>
            <td><p class="T_xlarge margin_top_xsmall"> <?php echo $look->getxStatusbyUser(1); ?> </p>
                <?php echo Yii::t('contentForm','To approve'); ?></td>
            <td><p class="T_xlarge margin_top_xsmall"> <?php echo $look->getxStatusbyUser(0); ?></p>
                <?php echo Yii::t('contentForm','To send'); ?></td>
            <!--<td><p class="T_xlarge margin_top_xsmall"> <?php echo $look->getTotalxStatus(4); ?></p>
                Cancelados </td>
            <td><p class="T_xlarge margin_top_xsmall"> <?php echo $look->getTotalxStatus(5); ?> </p>
                Devueltos</td>-->
        </tr>
    </table>
    <hr/>
    <div class="row margin_top margin_bottom ">
        <div class="span4">
            <div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>
                <input class="span3" id="buscar_look" type="text" placeholder="<?php echo Yii::t('contentForm','Search'); ?>">
            </div>
        </div>
  <?php
	Yii::app()->clientScript->registerScript('query',
		"var ajaxUpdateTimeout;
		var ajaxRequest; 
		
		$(document).keypress(function(e) {
		    if(e.which == 13) {
		        ajaxRequest = $('#buscar_look').val();
				clearTimeout(ajaxUpdateTimeout);
				
				ajaxUpdateTimeout = setTimeout(function () {
					$.fn.yiiListView.update(
					'list-auth-items',
					{
					type: 'POST',	
					url: '" . CController::createUrl('look/mislooks') . "',
					data: {buscar_look:ajaxRequest}}
					
					)
					},
			
			300);
			return false;
		    }
		});",CClientScript::POS_READY
	);
	
?>           
        <div class="span3">
            <?php echo CHtml::dropDownList("Filtros", "", 
                    Chtml::listData(Filter::model()->findAllByAttributes(array('type' => '5', 'user_id' => Yii::app()->user->id)),
                "id_filter", "name"), array('empty' => '-- '.Yii::t('contentForm','Preset filters').' --', 'id' => 'all_filters')) ?>
        </div>
        <div class="span3"><a href="#" class="btn crear-filtro"><?php echo Yii::t('contentForm','Create new filter'); ?></a></div>
        <div class="span2">
        
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'link',
			'label'=>Yii::t('contentForm','Create Look'),
			'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			'size'=>'normal', // null, 'large', 'small' or 'mini'
			'url' => 'create',
		)); ?>        	
        </div>
    </div>
    <hr/>
        <?php $this->renderPartial('_filtersMisLooks'); ?>
    <hr/>
<?php
$template = '{summary}
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
            <th scope="col"></th>
            <th colspan="2" scope="col">'.Yii::t('contentForm','Look').'</th>
            <th scope="col">'.Yii::t('contentForm', 'Price in').' '.Yii::t('contentForm', 'currSym').'</th>
            <th scope="col">'.Yii::t('contentForm', 'Sold').'</th>
            <th scope="col">'.Yii::t('contentForm', 'Sales in').' '.Yii::t('contentForm', 'currSym').'.</th>
            <th scope="col">'.Yii::t('contentForm', 'State').'</th>
            <th scope="col">'.Yii::t('contentForm', 'Update date').'</th>
            <th scope="col">'.Yii::t('contentForm', 'Campaign progress').'</th>
            <th scope="col">'.Yii::t('contentForm', 'Action').'</th>
        </tr>
    {items}
    </table>
    {pager}
	';

        $pagerParams=array(
            'header'=>'',
            'prevPageLabel' => Yii::t('contentForm','Previous'),
            'nextPageLabel' => Yii::t('contentForm','Next'),
            'firstPageLabel'=> Yii::t('contentForm','First'),
            'lastPageLabel'=> Yii::t('contentForm','Last'),
        	
            'htmlOptions'=>array(
                'class'=>'pagination pagination-right'));

		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-items',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_view_ps',
	    'template'=>$template,
	    'emptyText'=> Yii::t('contentForm','No elements to show'),
        'summaryText' => 'Mostrando {start} - {end} de {count} Resultados',   
	    'afterAjaxUpdate'=>" function(id, data) {
						    	
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

    <hr/>
<!--     <div class="row">
        <div class="span3">
            <select class="span3">
                <option>Seleccionar opción</option>
                <option>Lorem</option>
                <option>Ipsum 2</option>
                <option>Lorem</option>
            </select>
        </div>
        <div class="span1"><a href="#" title="procesar" class="btn btn-danger">Procesar</a></div>
        <div class="span2"><a href="#" title="Exportar a excel" class="btn btn-info">Exportar a excel</a></div>
    </div> -->
</div>
<!-- /container --> 

<!------------------- MODAL WINDOW ON -----------------> 
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal')); ?>
<?php $this->endWidget(); ?>

<!------------------- MODAL WINDOW OFF ----------------->

