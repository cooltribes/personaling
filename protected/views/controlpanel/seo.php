<?php
$this->breadcrumbs=array(
	'SEO',
);

$pagerParams=array(
			'header'=>'',
			'prevPageLabel' => Yii::t('contentForm','Previous'),
			'nextPageLabel' => Yii::t('contentForm','Next'),
			'firstPageLabel'=> Yii::t('contentForm','First'),
			'lastPageLabel'=> Yii::t('contentForm','Last'),
			'htmlOptions'=>array(
				'class'=>'pagination pagination-right'))
?>

<div class="container margin_top">
	<div class="page-header">
		<h1>Administrar SEO</small></h1>
	</div>

	<?php 
	if(Yii::app()->user->hasFlash('success')){
		?>
		<div class="alert alert-success text_align_center">
			<?php echo Yii::app()->user->getFlash('success'); ?>
		</div>
		<?php 
	} 
	?>

	<?php 
	if(Yii::app()->user->hasFlash('error')){
		?>
		<div class="alert alert-error text_align_center">
			<?php echo Yii::app()->user->getFlash('error'); ?>
		</div>
		<?php 
	} 
	?>

	<div class="row margin_top margin_bottom ">
		<div class="span3">
			<form class="no_margin_bottom form-search">
				<div class="input-append">
					<input type="text" name="query" id="query" class="span2">
					<a class="btn" id="btn_search_event">Buscar</a>
				</div>
			</form>

			<?php
			Yii::app()->clientScript->registerScript('query1',
				"var ajaxUpdateTimeout;
				var ajaxRequest;
				$('#btn_search_event').click(function(){
				
					ajaxRequest = $('#query').serialize();
					clearTimeout(ajaxUpdateTimeout);

					ajaxUpdateTimeout = setTimeout(function () {
						$.fn.yiiListView.update(
							'list-auth-items',
							{
								type: 'POST',	
								url: '" . CController::createUrl('controlpanel/seo') . "',
								data: ajaxRequest
							}

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
								'list-auth-items',
								{
									type: 'POST',	
									url: '" . CController::createUrl('controlpanel/seo') . "',
									data: ajaxRequest
								}

							)
						},
						300);

						return false;
					}
				});",CClientScript::POS_READY
			);	

			?>	

		</div>
		
		
		<div class="span2">
			<?php 
			$this->widget('bootstrap.widgets.TbButton', array(
				'buttonType' => 'link',
				'label'=>'Añadir elemento',
				'type'=>'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
				'size'=>'normal', // null, 'large', 'small' or 'mini'
				'url' => 'createSeo',
			)); 
			?>
		</div>

	</div>
</div>

<hr/>

<?php
$template = '{summary}
	<table id="table" width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
		<tr>
			<th scope="col">Nombre</th>
			<th scope="col">Título</th>
			<th scope="col">Descripción</th>
			<th scope="col">Palabras clave</th>
			<th scope="col">Url</th>
			<th scope="col">Acciones</th>
		</tr>
		{items}
	</table>
	{pager}
	';

$this->widget('zii.widgets.CListView', array(
	'id'=>'list-auth-items',
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_seo',
	'template'=>$template,
	'summaryText' => "Mostrando {start} - {end} de {count} Resultados",

	'enableSorting'=>'true',
	'afterAjaxUpdate'=>" function(id, data) {

	} ",
	'pager'=>$pagerParams,					
));    
?>

<hr/>
  

</div>