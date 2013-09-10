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
         
                <?php
    	echo CHtml::beginForm(CHtml::normalizeUrl(array('index')), 'get', array('id'=>'search-form'))
			. '<div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>'
		    . CHtml::textField('nombre', (isset($_GET['string'])) ? $_GET['string'] : '', array('id'=>'textbox_buscar', 'class'=>'span3', 'placeholder'=>'Buscar'))
		    . CHtml::endForm();
		?>
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
	
	
		Yii::app()->clientScript->registerScript('search',
	    "var ajaxUpdateTimeout;
	    var ajaxRequest;
	    $('#textbox_buscar').keyup(function(e){
	    	
			
			if(e.which != 13) {
				
				ajaxRequest = $(this).serialize();
	        clearTimeout(ajaxUpdateTimeout);
	        ajaxUpdateTimeout = setTimeout(function () {
	            $.fn.yiiListView.update(
	// this is the id of the CListView
	                'list-auth-adornos',
	                {data: ajaxRequest}
	            )
	        },
	// this is the delay
	        300);
		        
		    }
	        	/*else{
	        		
	        		window.location.href = document.URL;
	        	}*/
				
				
				
	        
	    });"
	);
	
	
	
	
	
	    
	?>
</div>
<!-- /container -->