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
    <form class="form-stacked personaling_form padding_top_small" >
          <fieldset>
                                                  
            <div class="control-group">
                    <?php echo $form->labelEx($model,'valor', array('class' => 'control-label required')); ?>
            <div class="controls">
              <?php echo $form->textField($model,'valor',array('class'=>'span3', 'placeholder' => 'Valor')); ?>
              <?php echo $form->error($model,'valor'); ?>
            </div>
              </div>

              <div class="control-group">
                    <?php echo $form->labelEx($model,'rgb', array('class' => 'control-label required')); ?>
            <div class="controls">
              <?php echo $form->textField($model,'rgb',array('class'=>'span3', 'placeholder' => 'Código RGB')); ?>
              <?php echo $form->error($model,'rgb'); ?>
            </div>
              </div>

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
<?php $this->widget('ext.EAjaxUpload.EAjaxUpload',
array(
        'id'=>'uploadFile',
        'config'=>array( 
               'action'=>Yii::app()->createUrl('color/upload'),
               'allowedExtensions'=>array("jpg"),//array("jpg","jpeg","gif","exe","mov" and etc...
               'sizeLimit'=>10*1024*1024,// maximum file size in bytes
               'minSizeLimit'=>1024,// minimum file size in bytes
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

              <div class="control-group"> 
            <div class="controls">
              <?php 
      echo $form->dropDownListRow(
        $model,'padreID', CHtml::listData(
          Color::model()->findAllByAttributes(array('padreID'=>0)),'id','valor'
        ), array(
          'empty' => Yii::t(
            'contentForm','Seleccione un color')
          )
        );
      ?>
            </div>
        </div>

    <div class="control-group">
                    <?php echo $form->labelEx($model,'title', array('class' => 'control-label required')); ?>
            <div class="controls">
              <?php echo $form->textField($model,'title',array('class'=>'span3', 'placeholder' => 'Título H1')); ?>
              <?php echo $form->error($model,'title'); ?>
            </div>
              </div>
              
              <div class="control-group">
                    <?php echo $form->labelEx($model,'description', array('class' => 'control-label')); ?>
            <div class="controls">
              <?php echo $form->textArea($model,'description',array('rows'=>'5','class'=>'span3', 'placeholder' => 'Descripcion SEO')); ?>
              <?php echo $form->error($model,'description'); ?>
            </div>   
              </div>
              
              <div class="control-group">
                    <?php echo $form->labelEx($model,'keywords', array('class' => 'control-label required')); ?>
            <div class="controls">
              <?php echo $form->textField($model,'keywords',array('class'=>'span3', 'placeholder' => 'Palabras clave')); ?>
              <?php echo $form->error($model,'keywords'); ?>
            </div>
              </div>

              <div class="control-group">
                    <?php echo $form->labelEx($model,'url', array('class' => 'control-label required')); ?>
            <div class="controls">
              <?php echo $form->textField($model,'url',array('class'=>'span3', 'placeholder' => 'URL amigable')); ?>
              <?php echo $form->error($model,'url'); ?>
            </div>
              </div>
              
            <br>
          </fieldset>
    </form>
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
   
    
  </div>
  <div class="modal-footer"> 
  	<a data-dismiss='modal' href="#" title="eliminar">Cancelar</a> 
  		<?php $this->widget('bootstrap.widgets.TbButton', array(
	'type'=>'info',
	//'buttonType'=> 'ajaxSubmit',
	'buttonType'=> 'submit',
	'buttonType'=> 'button',
	'label'=>'Guardar',
	'htmlOptions'=>array(
		'onclick'=>"validar()"
	),
	//'url'=>array('color/create'),

)); ?>
	
  </div>
  <script>
  	function validar(){
  		//alert($('#Color_valor').val());
	 					//alert($('#Color_path_image').val());
	 						if ($('#Color_path_image').val()==''){
	 							alert('Disculpe, Tiene que subir una imagen');
	 						 	
	 						 } else {
	 						 	$('#PublicarForm').submit();
	 						 }
  	}
  </script>
 <?php $this->endWidget(); ?> 