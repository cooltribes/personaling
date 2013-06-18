<?php
/* @var $this AdornoController */

$this->breadcrumbs=array(
	'Elementos Gráficos',
);
?>
<div class="container margin_top">
    <div class="page-header">
        <h1>Administrar Elementos Gráficos</h1>
        <p>Estos elementos graficos sirven para complementar los looks.</p>
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
            <div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>
                <input class="span3" id="prependedInput" type="text" placeholder="Buscar">
            </div>
        </div>
        <div class="pull-right">
        	<?php
        	echo CHtml::link('Subir nueva imagen', $this->createUrl('create'), array('class'=>'btn btn-success', 'role'=>'button'));
        	?>
        </div>
    </div>
    <hr/>
    <?php
$template = '{summary}
  <table id="table" width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
    <tr>
      <th scope="col">Imagen</th>
      <th scope="col">Nombre</th>
      <th scope="col">Acción</th>
    </tr>
    {items}
    </table>
    {pager}
	';

		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-adornos',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_view',
	    'template'=>$template,
	    'enableSorting'=>'true',
	    'afterAjaxUpdate'=>" function(id, data) {
						    	
							//alert('After ajax update');
						   
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