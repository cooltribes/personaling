<?php

$this->breadcrumbs=array(
	'Colores',
);
?>

		<?php
			$sql = "select count( * ) as total from tbl_color";
			$num = Yii::app()->db->createCommand($sql)->queryScalar();
		?>

<div class="container margin_top">
    <div class="page-header">
        <h1>Administrar Colores<small> (<?php echo $num; ?> colores registrados)</small></h1>
    </div>

	<?php if(Yii::app()->user->hasFlash('success')){?>
	    <div class="alert in alert-block fade alert-success text_align_center">
	        <?php echo Yii::app()->user->getFlash('success'); ?>
	    </div>
	<?php } ?>
	<?php if(Yii::app()->user->hasFlash('error')){?>
	    <div class="alert in alert-block fade alert-error text_align_center">
	        <?php echo Yii::app()->user->getFlash('error'); ?>
	    </div>
	<?php } ?>

    <div class="row margin_top margin_bottom ">
        <div class="span4">
            <form class="no_margin_bottom form-search">
            <div class="input-append"> <span class="add-on"><i class="icon-search"></i></span>
            		<input class="span3" id="query" name="query" type="text" placeholder="Buscar">
                	<a href="#" class="btn" id="btn_search_event">Buscar</a>
           		</form>
           	</div>

		
	<?php
	Yii::app()->clientScript->registerScript('query1',
		"var ajaxUpdateTimeout;
		var ajaxRequest; 
		$('#btn_search_event').click(function(){
			ajaxRequest = $('#query').serialize();
			clearTimeout(ajaxUpdateTimeout);
			
			ajaxUpdateTimeout = setTimeout(function () {
				$.fn.yiiListView.update(
				'list-auth-marcas',
				{
				type: 'POST',	
				url: '" . CController::createUrl('color/admin') . "',
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
		        ajaxRequest = $('#query').serialize();
				clearTimeout(ajaxUpdateTimeout);
				
				ajaxUpdateTimeout = setTimeout(function () {
					$.fn.yiiListView.update(
					'list-auth-marcas',
					{
					type: 'POST',	
					url: '" . CController::createUrl('color/admin') . "',
					data: ajaxRequest}
					
					)
					},
			
			300);
			return false;
		    }
		});",CClientScript::POS_READY
	);	
	
	
	
	?>	
            
            
            
        </div>
        <div class="pull-right">
        <?php
        	echo CHtml::link('Crear Color', $this->createUrl('create'), array('class'=>'btn btn-success', 'role'=>'button'));
        ?>
		</div>
    </div>
    <hr/>

<?php
$template = '{summary}
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
            <th scope="col">Imagen</th>
            <th scope="col">Padre</th>
            <th scope="col">Valor</th>
            <th scope="col">Título</th>
            <th scope="col">Descripción</th>
            <th scope="col">Palabras clave</th>
            <th scope="col">Url</th>
            <th scope="col">Acción</th>
        </tr>
    {items}
    </table>
    {pager}
	';

		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-marcas',
	    'dataProvider'=>$model->search(),
	    'itemView'=>'_view',
	    'template'=>$template,
	    'enableSorting'=>'true',
	    'afterAjaxUpdate'=>" function(id, data) {
						   
							} ",
		'pager'=>array(
			'header'=>'',
			'htmlOptions'=>array(
			'class'=>'pagination pagination-right',
		)
		),					
	));  
	
	?>

</div>
<!-- /container -->