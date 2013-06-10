<?php

$this->breadcrumbs=array(
	'Marcas',
);
?>

		<?php
			$sql = "select count( * ) as total from tbl_marca";
			$num = Yii::app()->db->createCommand($sql)->queryScalar();
		?>

<div class="container margin_top">
    <div class="page-header">
        <h1>Administrar Marcas<small> (<?php echo $num; ?> marcas registradas)</small></h1>
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
        	echo CHtml::link('Crear Marca', $this->createUrl('crear'), array('class'=>'btn btn-success', 'role'=>'button'));
        ?>
		</div>
    </div>
    <hr/>

<?php
$template = '{summary}
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
            <th scope="col">Logo</th>
            <th scope="col">Nombre</th>
            <th scope="col" width="50%">Descripción</th>
            <th scope="col">Acción</th>
        </tr>
    {items}
    </table>
    {pager}
	';

		$this->widget('zii.widgets.CListView', array(
	    'id'=>'list-auth-marcas',
	    'dataProvider'=>$dataProvider,
	    'itemView'=>'_datos',
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