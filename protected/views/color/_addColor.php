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
    
    <?php echo $form->textFieldRow($model, 'valor', array('class'=>'span3')); ?>
    <h4>Sube una imagen</h4>
    <p>La imagen sera redimensionada y cortada a 70 x 70 pixeles</p>
    <label>Elige una imagen:</label>
    <div class="well well-large">
    <?php //input-append
    /*
            	$this->widget('CMultiFileUpload', array(
                'name' => 'url',
                'model'=>$model,
     			'attribute'=>'path_image',
                'accept' => 'jpeg|jpg|gif|png', // useful for verifying files
                'duplicate' => 'El archivo está duplicado.', // useful, i think
                'denied' => 'Tipo de archivo invalido.', // useful, i think
            ));
	 * 
	 */
	?>
<? $this->widget('ext.EAjaxUpload.EAjaxUpload',
array(
        'id'=>'uploadFile',
        'config'=>array( 
               'action'=>Yii::app()->createUrl('color/upload'),
               'allowedExtensions'=>array("jpg"),//array("jpg","jpeg","gif","exe","mov" and etc...
               'sizeLimit'=>10*1024*1024,// maximum file size in bytes
               'minSizeLimit'=>10*1024,// minimum file size in bytes
               'onComplete'=>"js:function(id, fileName, responseJSON){ $('#Color_path_image').val(fileName); }",
               //'messages'=>array(
               //                  'typeError'=>"{file} has invalid extension. Only {extensions} are allowed.",
               //                  'sizeError'=>"{file} is too large, maximum file size is {sizeLimit}.",
               //                  'minSizeError'=>"{file} is too small, minimum file size is {minSizeLimit}.",
               //                  'emptyError'=>"{file} is empty, please select files again without it.",
               //                  'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
               //                 ),
               //'showMessage'=>"js:function(message){ alert(message); }"
              )
)); ?>	

<?php echo $form->hiddenField($model,'path_image'); ?>

    </div>
    
  </div>
  <div class="modal-footer"> 
  	<a data-dismiss='modal' href="#" title="eliminar">Cancelar</a> 
  		<?php $this->widget('bootstrap.widgets.TbButton', array(
	'type'=>'info',
	//'buttonType'=> 'ajaxSubmit',
	'buttonType'=> 'submit',
	'label'=>'guardar',
	//'url'=>array('color/create'),

)); ?>
	
  </div>
 <?php $this->endWidget(); ?> 