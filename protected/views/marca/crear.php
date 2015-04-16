<?php

$this->breadcrumbs=array(
	'Marcas'=>array('admin'),
	'Crear Marca',
);
?>


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

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'marca-form',
	'enableAjaxValidation'=>true,
	'enableClientValidation'=>false,
	'type'=>'horizontal',
	'clientOptions'=>array(
		'validateOnSubmit'=>true, 
	),
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); 

?>

<?php echo $form->errorSummary($marca, "Por favor corrija los siguientes errores."); ?>


<div class="container margin_top">
    <div class="page-header">
        <h1>Crear Marca</h1>
    </div>
    <div class="row">
        <div class="span9">
            <div class="bg_color3 margin_bottom_small padding_small box_1">
                <form class="form-stacked personaling_form padding_top_small" id="formulario">
                    <fieldset>
                    <?php if(count($marca->hijos)<1){ $margin='';?>	                                  	
                    	<div class="control-group margin_top_medium">
                    		 <?php echo $form->labelEx($marca,'padreId', array('class' => 'control-label required')); ?>
				              <div class="controls">
				              	<?php echo CHtml::dropDownList('padreId',$marca->padreId,CHtml::listData(Marca::model()->findAllByAttributes(array('padreId'=>'0'),array('order'=>'nombre')),'id','nombre') ,array('empty'=>'Esta es una marca padre')); ?>
				                <?php echo $form->error($marca,'padreId'); ?>
				              </div>
                        </div> 
                    <?php }else{$margin="margin_top_medium";}?>
                    	
                    	<div class="control-group <?php echo $margin;?>">
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
									<span id="errorUrl" class="error margin_top_small_minus hide"><br/><small>El valor de imagen no puede ser vacio.</small></span>
                            </div>
                        </div>
                        
                        <div class="control-group">
                        	
                            <div class="controls">
	                            <?php
	                            $checked="";
	                            if($marca->is_100chic)
									$checked=' checked';
					            	echo "<input type='checkbox' name='chic' id='chic'".$checked.">080 Barcelona Fashion";
							
									?>
                            </div>
                        </div>
                        
                        <div class="control-group">
				              <div class="controls">
				              	<?php 
				              	if($marca->isNewRecord)
				              		echo '';
								else {
									echo CHtml::image(Yii::app()->request->baseUrl.'/images/'.Yii::app()->language.'/marca/'.$marca->id.'_thumb.jpg',"image");
								} 
				              	?>
				              </div>
                        </div>
                        
                      <br>
                    </fieldset>
                
          <fieldset>
            <legend> <?php echo Yii::t('contentForm','Datos Adicionales'); ?>: </legend>
            <p class="muted Italic"><?php echo Yii::t('contentForm','To save this information at least  type the name.') ?></p>
            <div class="control-group no_margin_bottom"> 
             <div class="controls">
              	<?php 
              	
              	
              	echo $form->textFieldRow($marca,'contacto',array('class'=>'span4 formu no_margin_bottom','id'=>'nombrePersona','maxlength'=>70,'placeholder'=>Yii::t('contentForm','Name of the contact person'))); 
              	// <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Nombre de la persona a la que envias" name="RegistrationForm[email]" class="span4">
              	?>
              	<span id="errorName" class="help-block error hide no_margin_bottom"><small>Para guardar los datos adicionales debe introducir el nombre.</small></span>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            <div class="control-group"> 
             
              <div class="controls">
              	<?php echo $form->textFieldRow($marca,'cif',array('class'=>'span4 formu','id'=>'fiscal','maxlength'=>20,'placeholder'=>Yii::t('contentForm','Tax information code'))); 
              	//  <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Cedula de Identidad de la persona a la que envias" name="RegistrationForm[email]" class="span4">
              	?>
               
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
           
              <div class="controls">
              	<?php echo $form->textFieldRow($marca,'dirUno',array('class'=>'span4 formu','id'=>'direccion','maxlength'=>120,'placeholder'=>Yii::t('contentForm','Address Line 1: (Avenue, Street, complex, Residential, etc.).')));
				//<input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Direccion Linea 1: (Avenida, Calle, Urbanizacion, Conjunto Residencial, etc.)" name="RegistrationForm[email]" class="span4">
				 ?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
            
              <div class="controls">
              	<?php echo $form->textFieldRow($marca,'dirDos',array('class'=>'span4 formu','id'=>'direccion2','maxlength'=>120,'placeholder'=>Yii::t('contentForm','Address Line 2: (Building, Floor, Number, apartment, etc.)')));
				// <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Direccion Linea 2: (Edificio, Piso, Numero, Apartamento, etc)" name="RegistrationForm[email]" class="span4">
				 ?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
            	
              <div class="controls">
              	<?php echo $form->textFieldRow($marca,'telefono',array('class'=>'span4 formu','id'=>'telefono','maxlength'=>45,'placeholder'=>Yii::t('contentForm','Phone number')));
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
								#'id'=>'pais',
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
              	
                	echo $form->dropDownListRow($marca,'provincia_id', array('empty' => Yii::t('contentForm','Select a province') ));?>
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
					'id'=>'botoncrear',
					'type'=>'danger',
					'size' => 'large',
					'block'=>'true',
					'label'=>$marca->isNewRecord ? 'Crear' : 'Guardar',
				)); ?>
				
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'id'=>'botonnuevo',
					'type'=>'danger',
					'size' => 'large',
					'block'=>'true',
					'label'=>$marca->isNewRecord ? 'Guardar y Crear Otro' : 'Guardar y Crear Otro',
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
$('#errorName').hide();
<?php 
if($marca->isNewRecord)
{
?>
	$('#botoncrear').attr('disabled',true);
	$('#botonnuevo').attr('disabled',true);
	$('#errorUrl').show();
	
	$("#url").change(function(){
		
	   if($("#url").val()=="")
	   {
	   		$('#botoncrear').attr('disabled',true);
	   		$('#botonnuevo').attr('disabled',true);
			$('#errorUrl').show();
	   }   		
	   else
	   {
	   		$('#botoncrear').attr('disabled',false);
	   		$('#botonnuevo').attr('disabled',false);
	   		$('#errorUrl').hide();
	   }
	   		
	});
<?php 
}
?>

 $('body').on('input','.formu', function() { 
 	if($("#nombrePersona").val()=="" && !( $("#fiscal").val()!="" && $("#direccion").val()!="" && $("#direccion2").val()!="" && $("#telefono").val()!=""))
	{
		$('#errorName').show();
		$('#botoncrear').attr('disabled',true);
	   	$('#botonnuevo').attr('disabled',true);
	   	var iScroll = $(window).scrollTop();
	   	iScroll = 500;
        $('html, body').animate({
            scrollTop: iScroll
        }, 1000);

	}
	if(($("#fiscal").val()=="" && $("#direccion").val()=="" && $("#direccion2").val()=="" && $("#telefono").val()=="") || $("#nomprePersona").val()=="")
	{
		$('#errorName').hide();
		$('#botoncrear').attr('disabled',false);
	   	$('#botonnuevo').attr('disabled',false);
	}
 });
	
	$('#botoncrear').focusin( function () {// boton viejo
			
			revisado=0;
			$.ajax({
			url: "<?php echo Yii::app()->createUrl('Marca/busqueda') ?>",
			type: 'GET',
			data:{
					revisado:revisado
				 },
			success: function(resp){
			} 
		 }); 
			
  	});	
  	
  	$('#botonnuevo').focusin( function () { //boton nuevo
			
			revisado=1;			
			$.ajax({
			url: "<?php echo Yii::app()->createUrl('Marca/busqueda') ?>",
			type: 'GET',
			data:{
					revisado:revisado
				 },
			success: function(resp){
			} 
		 }); 
  			//alert(revisado);
  	});
  	
	
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