<?php
/* @var $this BugController */
/* @var $model Bug */

$this->breadcrumbs=array(
	'Falla Tecnica',
);
  
?>


<div class="container margin_top">
	
    <div class="page-header">
        <h1>Administrar Fallas Tecnicas</h1>
    </div>

 <div class="row margin_top margin_bottom ">
         <div class="pull-right">
        <?php
        	echo CHtml::link('Crear nueva Falla Tecnica', $this->createUrl('create'), array('class'=>'btn btn-success', 'role'=>'button'));
        ?>
		</div>
 </div>

<?php 
$template = '{summary}
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Descripcion</th>
            <th scope="col">Url</th>
            <th scope="col">Estado</th>
            <th scope="col">Fecha</th>
            <th scope="col">Detalles</th>
        </tr>
    {items}
    </table>
    {pager}
	';

		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-marcas',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_view',
	    'template'=>$template,
	    'enableSorting'=>'true',
	     'summaryText' => "Mostrando {start} - {end} de {count} Resultados",
	    'emptyText'=>Yii::t('contentForm','There are not any results to show'),
	    'afterAjaxUpdate'=>" function(id, data) {
						   
							} ",
		'pager'=>array(
			'header'=>'',
			'htmlOptions'=>array(
			'class'=>'pagination pagination-right',
		)
		),					
	));  

/* $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'bug-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'description',
		'image',
		'url',
		'estado',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); */


?>

</div>
