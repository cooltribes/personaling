<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'PublicarForm',
    //'type'=>'horizontal',
    'htmlOptions'=>array(
    	'class'=>'personaling_form',
		'enctype' => 'multipart/form-data',
	),
    //'type'=>'stacked',
    'type'=>'inline',
)); ?>
 <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 id="myModalLabel">Agregar nuevo color</h3>
  </div>
  <div class="modal-body">
  	<!--
    <p class="alert alert-info">Puedes usar cualquier de las opciones a continuaciÃ³n:</p>
    <h4>1. Usar el Color-picker</h4>
    <input type="text" placeholder="Haz click para escoger un color" >
    <hr/>
    <h4>2. O Sube una imagen</h4>
    <p>La imagen sera redimensionada y cortada a 70 x 70 pixeles</p>
    <label>Elige una imagen:</label>
    <div class="input-append">
      <input class="span3"  type="text">
      <span class="add-on"><i class="icon-search"></i></span> </div>
    -->
    <h4>Colocale un nombre</h4>
    <input type="text" placeholder="Nombre" >
    <?php echo $form->textFieldRow($model, 'valor', array('class'=>'span3')); ?>
    <h4>Sube una imagen</h4>
    <p>La imagen sera redimensionada y cortada a 70 x 70 pixeles</p>
    <label>Elige una imagen:</label>
    <div class="well well-large">
    <?php //input-append
            	$this->widget('CMultiFileUpload', array(
                'name' => 'url',
                'model'=>$model,
     			'attribute'=>'path_image',
                'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
                'duplicate' => 'El archivo está duplicado.', // useful, i think
                'denied' => 'Tipo de archivo invalido.', // useful, i think
            ));
	?>
    </div>
    
  </div>
  <div class="modal-footer"> 
  	<a data-dismiss='modal' href="#" title="eliminar">Cancelar</a> 
  		<?php $this->widget('bootstrap.widgets.TbButton', array(
	'type'=>'info',
	'buttonType'=> 'ajaxButton',
	'label'=>'Guardar', 
	'url'=>'#',
	 'ajaxOptions'=>array( 
	 				'beforeSend' => "function( request, opts )
	 				{
	 						alert('asf');
	 					alert($('#Color_path_image').val());
	 						if ($('#Color_path_image').val()==''){
	 							alert('Disculpe, Tiene que subir una imagen');
	 						 	request.abort();
	 						 }
	 					
	 				} 				
	 				"
                       // 'update' => '#yw5_tab_2',
                ),
)); ?>
	
  </div>
 <?php $this->endWidget(); ?> 