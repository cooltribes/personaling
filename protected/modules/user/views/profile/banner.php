<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>
<div class="container margin_top tu_perfil">
  <div class="row">
  	<!-- FLASH ON --> 
<?php $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )
); ?>	
<!-- FLASH OFF --> 
<!-- SIDEBAR ON -->
  <aside class="span3"> <?php echo $this->renderPartial('_sidebar'); ?> </aside>
  <!-- SIDEBAR ON --> 

    <div class="span9">
           

      <article class="bg_color3  margin_bottom_small padding_small box_1">
        
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'avatar-form',
			'htmlOptions'=>array('class'=>'personaling_form','enctype'=>"multipart/form-data"),
		    //'type'=>'stacked',
		    'type'=>'inline',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>  
    <fieldset>
                  <h1>Tu Banner</h1>
<p>Puedes editar o cambiar tu banner usando las opciones a continuación:</p>
    	<div id="container" class="text_align_center margin_bottom margin_top" >
    		<?php if( $user->banner_url != null ){ ?>
        <img src="<?php echo Yii::app()->baseUrl.$user->banner_url; ?>">
        <?php } ?>
        </div> <div class="text_align_center">
<!--     		<div id="boton_original" class="btn">original</div> 
    		<div id="boton_mas" class="btn">+</div> 
    		<div id="boton_menos" class="btn">-</div>  -->
    		</div>
            	

    	 <div class="braker_horz_top_1 ">
      <label for="fileToUpload">Elige la imagen que deseas subir</label><br />
           <!--
      <input type="file" name="filesToUpload[]" id="filesToUpload" multiple="multiple" />
      -->
      <input type="file" name="filesToUpload" id="filesToUpload" class="well well-small"/>
      <?php echo CHtml::hiddenField('valido','1'); ?>
      <?php echo CHtml::hiddenField('avatar_x','0'); ?>
      <?php echo CHtml::hiddenField('avatar_y','0'); ?>
<?php /*?>      <div id="dropTarget">O arrasta la imagen hasta aqui</div><?php */?>
      <output id="filesInfo"></output>
      
         <div class="form-actions"> <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'danger',
			'label'=>'Haz click aqui para subir la imagen',
		)); ?>
      </div>
      </div>
    
    
  
    
    </fieldset>
<?php $this->endWidget(); ?>
	
      </article>
    </div>
    
    
  
    
  </div>
</div>