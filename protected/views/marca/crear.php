<?php

$this->breadcrumbs=array(
	'Marcas'=>array('admin'),
	'Crear Marca',
);
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'marca-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'type'=>'horizontal',
	'clientOptions'=>array(
		'validateOnSubmit'=>true, 
	),
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); 

?>

<?php echo $form->errorSummary($marca); ?>


<div class="container margin_top">
    <div class="page-header">
        <h1>Crear Marca</h1>
    </div>
    <div class="row">
        <div class="span9">
            <div class="bg_color3 margin_bottom_small padding_small box_1">
                <form class="form-stacked personaling_form padding_top_small" >
                    <fieldset>
                    		                                  	
                    	<div class="control-group">
                              <?php echo $form->labelEx($marca,'nombre', array('class' => 'control-label required')); ?>
				              <div class="controls">
				              	<?php echo $form->textField($marca,'nombre',array('class'=>'span6', 'placeholder' => 'Nombre de la marca')); ?>
				                <?php echo $form->error($marca,'nombre'); ?>
				              </div>
                        </div>

						<div class="control-group">
                              <?php echo $form->labelEx($marca,'descripcion', array('class' => 'control-label')); ?>
				              <div class="controls">
				              	<?php echo $form->textArea($marca,'descripcion',array('rows'=>'5','class'=>'span6', 'placeholder' => 'Descripcion de la marca')); ?>
				                <?php echo $form->error($marca,'descripcion'); ?>
				              </div>   
                        </div>
                        
                         <div class="control-group">
                        	<label class="control-label required"> Logotipo </label>
                            <div class="controls">
	                            <?php
	                            
					            	echo CHtml::activeFileField($marca, 'Urlimagen',array('name'=>'url'));
									echo $form->error($marca, 'Urlimagen'); 
									?>
                            </div>
                        </div>
                        
                        <div class="control-group">
                        	
                            <div class="controls">
	                            <?php
	                            $checked="";
	                            if($marca->is_100chic)
									$checked=' checked';
					            	echo "<input type='checkbox' name='chic' id='chic'".$checked.">100% Chic";
							
									?>
                            </div>
                        </div>
                        
                        <div class="control-group">
				              <div class="controls">
				              	<?php 
				              	if($marca->isNewRecord)
				              		echo '';
								else {
									echo CHtml::image(Yii::app()->request->baseUrl.'/images/marca/'.$marca->id.'_thumb.jpg',"image");
								} 
				              	?>
				              </div>
                        </div>
                        
                      <br>
                    </fieldset>
                
          <fieldset>
            <legend> <?php echo Yii::t('contentForm','Datos Adicionales'); ?>: </legend>
            <div class="control-group"> 
             
              <div class="controls">
              	<?php 
              	
              	
              	echo $form->textFieldRow($marca,'contacto',array('class'=>'span4','maxlength'=>70,'placeholder'=>Yii::t('contentForm','Name of the person to whom you send'))); 
              	// <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Nombre de la persona a la que envias" name="RegistrationForm[email]" class="span4">
              	?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            <div class="control-group"> 
             
              <div class="controls">
              	<?php echo $form->textFieldRow($marca,'cif',array('class'=>'span4','maxlength'=>20,'placeholder'=>Yii::t('contentForm','ID of the person to whom you send'))); 
              	//  <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Cedula de Identidad de la persona a la que envias" name="RegistrationForm[email]" class="span4">
              	?>
               
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
           
              <div class="controls">
              	<?php echo $form->textFieldRow($marca,'dirUno',array('class'=>'span4','maxlength'=>120,'placeholder'=>Yii::t('contentForm','Address Line 1: (Avenue, Street, complex, Residential, etc.).')));
				//<input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Direccion Linea 1: (Avenida, Calle, Urbanizacion, Conjunto Residencial, etc.)" name="RegistrationForm[email]" class="span4">
				 ?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
            
              <div class="controls">
              	<?php echo $form->textFieldRow($marca,'dirDos',array('class'=>'span4','maxlength'=>120,'placeholder'=>Yii::t('contentForm','Address Line 2: (Building, Floor, Number, apartment, etc.)')));
				// <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Direccion Linea 2: (Edificio, Piso, Numero, Apartamento, etc)" name="RegistrationForm[email]" class="span4">
				 ?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
            	
              <div class="controls">
              	<?php echo $form->textFieldRow($marca,'telefono',array('class'=>'span4','maxlength'=>45,'placeholder'=>Yii::t('contentForm','Phone number')));
				 ?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            <div class="control-group"> 
              
              <div class="controls">
              	<?php // echo $form->dropDownListRow($marca, 'pais', array('Seleccione el País', 'Venezuela', 'Colombia', 'Estados Unidos')); 
       
              		
						 echo $form->dropDownListRow(
						 	$marca,'pais', CHtml::listData(
						 		Pais::model()->findAll(),'id','nombre'
							), array(
								'empty' => Yii::t(
									'contentForm','Select a country')
								)
							);
					
              		
 	 			 ?>
              </div>
            </div>
            
            <div class="control-group"> 
              
              <div class="controls">
              	<?php 
              	
                	echo $form->dropDownListRow($marca,'provincia_id', array(), array('empty' => Yii::t('contentForm','Select a province') ));?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            
            
            <div class="control-group"> 
              <div class="controls">
              	<?php 
              	if($marca->provincia_id == ''){ 
              		echo $form->dropDownListRow($marca,'ciudad_id', array(), array('empty' => 'Seleccione una ciudad...'));
				}else{
						/*$criteria=new CDbCriteria;
						$criteria->addCondition('cod_zoom IS NULL'); 
						$criteria->addCondition('provincia_id ='.$marca->provincia_id); 
						*/
						//$criteria->order('nombre'); 
					//echo $form->dropDownListRow($marca,'ciudad_id', CHtml::listData(Ciudad::model()->findAllByAttributes(array(),"cod_zoom IS NOT NULL AND provincia_id =".$marca->provincia_id, array('order' => 'nombre')),'id','nombre'));
					echo $form->dropDownListRow($marca,'ciudad_id', CHtml::listData(Ciudad::model()->findAllBySql("SELECT * FROM tbl_ciudad WHERE provincia_id =".$marca->provincia_id." AND cod_zoom IS NOT NULL order by nombre ASC"),'id','nombre'));
					//echo $form->dropDownListRow($marca,'ciudad_id', CHtml::listData(Ciudad::model()->findAll($criteria),'id','nombre'));
				}
              	?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
        
            <div class="control-group"> 
              <div class="controls"> 
              	<?php 
              	if($marca->ciudad_id == ''){ 
              		echo $form->dropDownListRow($marca,'codigo_postal_id', array(), array('empty' => 'Seleccione una ciudad...'));
				}else{
						/*$criteria=new CDbCriteria;
						$criteria->addCondition('cod_zoom IS NULL'); 
						$criteria->addCondition('provincia_id ='.$marca->provincia_id); 
						*/
						//$criteria->order('nombre'); 
					//echo $form->dropDownListRow($marca,'ciudad_id', CHtml::listData(Ciudad::model()->findAllByAttributes(array(),"cod_zoom IS NOT NULL AND provincia_id =".$marca->provincia_id, array('order' => 'nombre')),'id','nombre'));
					echo $form->dropDownListRow($marca,'codigo_postal_id', CHtml::listData(CodigoPostal::model()->findAllBySql("SELECT * FROM tbl_codigo_postal WHERE ciudad_id =".$marca->provincia_id." order by codigo ASC"),'id','codigo'));
					//echo $form->dropDownListRow($marca,'ciudad_id', CHtml::listData(Ciudad::model()->findAll($criteria),'id','nombre'));
				}
              	?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            
            
            <div class="control-group"> 
            
              <div class="controls">
              	
              	 
 	 			 
 	 			
 	 		
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>

        

           
          </fieldset>
      </form>
            </div>
        </div>
        
        
        <div class="span3">
            <div class="padding_left"> 
            	
            	<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'danger',
					'size' => 'large',
					'block'=>'true',
					'label'=>$marca->isNewRecord ? 'Crear' : 'Guardar',
				)); ?>
            	
                <ul class="nav nav-stacked nav-tabs margin_top">
                   <li><a style="cursor: pointer" title="Restablecer" id="limpiar">Limpiar</a></li>
                   <?php  
                   if(!$marca->isNewRecord){
		          	  echo "<li>";
					  echo CHtml::link('<i class="icon-trash"> </i> Eliminar', CController::createUrl('marca/delete',array('id'=>$marca->id)), array('title'=>'Eliminar'));
					  echo "</li>";
		          }
                   ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /container -->

<?php $this->endWidget(); ?>

<script>
	
	$('#limpiar').on('click', function() {
			
			$('#marca-form').each (function(){
			  this.reset();
			});
        
  	});	
  	
  	$('#Marca_provincia_id').change(function(){
		if($(this).val() != ''){
			var path = location.pathname.split('/');
			$.ajax({
			      url: "<?php echo Yii::app()->createUrl('direccion/cargarCiudades'); ?>",
			      type: "post",
			      data: { provincia_id : $(this).val() },
			      success: function(data){
			           $('#Marca_ciudad_id').html(data);
			      },
			});
		}
	});
	
	$('#Marca_ciudad_id').change(function(){
		if($(this).val() != ''){
			var path = location.pathname.split('/');
			$.ajax({
			      url: "<?php echo Yii::app()->createUrl('direccion/cargarCodigos'); ?>",
			      type: "post",
			      data: { ciudad_id : $(this).val() },
			      success: function(data){
			           $('#Marca_codigo_postal_id').html(data);
			      },
			});
		}
	});
	
	$('#Marca_pais').change(function(){
		if($(this).val() != ''){
			var path = location.pathname.split('/');
			$.ajax({
			      url: "<?php echo Yii::app()->createUrl('direccion/cargarProvincias'); ?>",
			      type: "post",
			      data: { pais_id : $(this).val() },
			      success: function(data){
			           $('#Marca_provincia_id').html(data);
			      },
			});
		}
	});
  	
</script>