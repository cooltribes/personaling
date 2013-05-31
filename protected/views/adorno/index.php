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
    <div class="row margin_top margin_bottom ">
        <div class="span4">
            <div class="input-prepend"> <span class="add-on"><i class="icon-search"></i></span>
                <input class="span3" id="prependedInput" type="text" placeholder="Buscar">
            </div>
        </div>
        <div class="pull-right"><a class="btn btn-success" href="#myModal" role="button"  data-toggle="modal">Subir nueva imagen</a></div>
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
						    	
							alert('After ajax update');
						   
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
<!------------------- MODAL WINDOW ON -----------------> 

<!-- Modal 1 -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Agregar elemento gráfico</h3>
    </div>
    <div class="modal-body">
      <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'adorno-form',
			'enableAjaxValidation'=>false,
			'type'=>'horizontal',
		)); ?>
			<?php echo $form->errorSummary($model); ?>
                    <fieldset>
                        <div class="control-group">
                              <?php echo $form->labelEx($model,'nombre', array('class' => 'control-label')); ?>
				              <div class="controls">
				              	<?php echo $form->textField($model,'nombre',array('class'=>'span4','maxlength'=>50, 'placeholder' => 'Nombre/Titulo')); ?>
				                <?php echo $form->error($model,'nombre'); ?>
				              </div>
                        </div>
                        
                        <div class="control-group">
                            <div class="span2"><img src="http://placehold.it/130"></div>
                            <div class="controls">
	                            <?php
					            	$this->widget('CMultiFileUpload', array(
						                'name' => 'path_image',
						                'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
						                'duplicate' => 'El archivo está duplicado.', // useful, i think
						                'denied' => 'Tipo de archivo invalido.', // useful, i think
						                'htmlOptions' => array(),
						            ));
									
									?>
									 <?php echo $form->error($model, 'path_image'); ?>
                            </div>
                        </div>
                    </fieldset>
         <?php $this->endWidget(); ?>
        
    </div>
    <div class="modal-footer"> <a href="#" title="eliminar" class="btn"><i class="icon-trash"></i> Eliminar</a>   <a href="" title="Guardar" class="btn btn-danger">Guardar</a> </div>
</div>
<!------------------- MODAL WINDOW OFF ----------------->