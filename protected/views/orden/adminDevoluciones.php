<?php if(Yii::app()->user->hasFlash('success')){?>
	    <div class="alert in alert-block fade alert-success text_align_center margin_top_large">
	        <?php echo Yii::app()->user->getFlash('success'); ?>
	    </div>
	<?php } ?>
	<?php if(Yii::app()->user->hasFlash('error')){?>
	    <div class="alert in alert-block fade alert-error text_align_center margin_top_large">
	        <?php echo Yii::app()->user->getFlash('error'); ?>
	    </div>
	<?php } ?>
<div class="container margin_top">
	<h1> Devoluciones </h1>  
</div>

<?php

$template = '<br/><hr/>
				<div>
					<div class="row">
						<div  class="span3"> 
						{summary}
						</div>
						<div  class="span5 offset4"> 
						{sorter}
					</div>
				</div>
			 	 
			 	
			  <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered ta table-hover table-striped">
			  <thead>
			  <tr class="sorter"> 
				<th>ID</th>
				<th>Registrada Por</th>
				<th>N° Orden</th>
				<th>Fecha</th>
			     <th>Status</th>
			     <th>Ver</th>
                </tr>
			    </thead>
			    <tbody>
			    {items}
				</tbody>
			    </table>
			   
			    {pager}
				</div>
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
	    'sorterHeader'=>'Ordenar por:',
	    'itemView'=>'_datosDevoluciones',
	    'summaryText' => 'Mostrando {start} - {end} de {count} Resultados',    
	    'template'=>$template,
	    
	    //'enableSorting'=>true,

	 
        'pager'=>$pagerParams,	
	    
	    
	   
	 					
	));




?>
