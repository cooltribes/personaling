
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'direccion_nueva',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true, 
	),
	'htmlOptions'=>array('class'=>'form-horizontal'),
)); 

	if(isset($dir))
	{
		
	echo CHtml::hiddenField('idDireccion',$dir->id);
?>
    
      
    <div class="row">
    <div class="span8 offset2"> 
    </br>
    
      <h1><?php echo Yii::t('contentForm','Edit shipping address'); ?></h1>
      
      <section class="bg_color3 margin_top margin_bottom_small padding_small box_1">
          <fieldset>          
            <legend ><?php echo Yii::t('contentForm','Include a new shipping address'); ?>: </legend>
            <div class="control-group"> 
             
              <div class="controls">
              	<?php echo $form->textFieldRow($dir,'nombre',array('class'=>'span4','maxlength'=>70,'placeholder'=>Yii::t('contentForm','Name of the person to whom you send'))); 
              	// <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Nombre de la persona a la que envias" name="RegistrationForm[email]" class="span4">
              	?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
             
              <div class="controls">
              	<?php echo $form->textFieldRow($dir,'apellido',array('class'=>'span4','maxlength'=>70,'placeholder'=>Yii::t('contentForm','Last name of the person to whom you send'))); 
              	//  <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Apellido de la persona a la que envias tu compra" name="RegistrationForm[email]" class="span4">
              	?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
             
              <div class="controls">
              	<?php echo $form->textFieldRow($dir,'cedula',array('class'=>'span4','maxlength'=>20,'placeholder'=>Yii::t('contentForm','ID of the person to whom you send'))); 
              	//  <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Cedula de Identidad de la persona a la que envias" name="RegistrationForm[email]" class="span4">
              	?>
               
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
           
              <div class="controls">
              	<?php echo $form->textFieldRow($dir,'dirUno',array('class'=>'span4','maxlength'=>120,'placeholder'=>Yii::t('contentForm','Address Line 1: (Avenue, Street, complex, Residential, etc.).')));
				//<input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Direccion Linea 1: (Avenida, Calle, Urbanizacion, Conjunto Residencial, etc.)" name="RegistrationForm[email]" class="span4">
				 ?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
            
              <div class="controls">
              	<?php echo $form->textFieldRow($dir,'dirDos',array('class'=>'span4','maxlength'=>120,'placeholder'=>Yii::t('contentForm','Address Line 2: (Building, Floor, Number, apartment, etc.)')));
				// <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Direccion Linea 2: (Edificio, Piso, Numero, Apartamento, etc)" name="RegistrationForm[email]" class="span4">
				 ?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
            
              <div class="controls">
              	<?php echo $form->textFieldRow($dir,'telefono',array('class'=>'span4','maxlength'=>45,'placeholder'=>Yii::t('contentForm','Phone number')));
				 ?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
              
              <div class="controls">
              	<?php echo $form->dropDownListRow($dir,'provincia_id', CHtml::listData(Provincia::model()->findAll(array('order' => 'nombre')),'id','nombre'), array('empty' => Yii::t('contentForm','Select a province')));?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
              <div class="controls">
              	<?php //echo $form->dropDownListRow($dir,'ciudad_id', CHtml::listData(Ciudad::model()->findAll(array('order' => 'nombre')),'id','nombre'), array('empty' => 'Seleccione una ciudad...'));?>
                <?php 
              	if($dir->provincia_id == ''){ 
              		echo $form->dropDownListRow($dir,'ciudad_id', array(), array('empty' => Yii::t('contentForm','Select a city')));
				}else{
					echo $form->dropDownListRow($dir,'ciudad_id', CHtml::listData(Ciudad::model()->findAllByAttributes(array('provincia_id'=>$dir->provincia_id), array('order' => 'nombre')),'id','nombre'));
				}
              	?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
            
              <div class="controls">
              	
              	 <?php 
              	 /*
              	 if($dir->pais=="Venezuela"){
              	 	echo $form->dropDownListRow($dir, 'pais', array('Seleccione el País','Venezuela','Colombia','Estados Unidos'),
              	 		array('options' => array(1 => array('selected'=>true))));
              	 }
				 
				 if($dir->pais=="Colombia"){
              	 	echo $form->dropDownListRow($dir, 'pais', array('Seleccione el País','Venezuela','Colombia','Estados Unidos'),
              	 		array('options' => array(2 => array('selected'=>true))));
              	 }
              	 
              	 if($dir->pais=="Estados Unidos"){
              	 	echo $form->dropDownListRow($dir, 'pais', array('Seleccione el País','Venezuela','Colombia','Estados Unidos'),
              	 		array('options' => array(3 => array('selected'=>true))));
              	 }
	 	
              	 */
              	 ?>
              	 
              	  <input name="Direccion[pais]" id="Direccion_pais" type="hidden" value="Venezuela" />
              	 
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'danger',
            'size'=>'large',
            'label'=>Yii::t('contentForm','Save'),
        )); 

        ?>
        
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'link',
            'type'=>'info',
            'size'=>'large',
            'label'=>Yii::t('contentForm','Cancel'),
            'url' => '../direcciones',
        )); 

        ?>
            </div>
           
          </fieldset>
        </form>
      </section>
    </div>
  </div>

<!-- /container -->

<?php 
} // if
else
	{
	// redirecciona al login porque se murió la sesión
	header('Location: /site/site/error');	
	}
$this->endWidget(); ?>

<script>
	$('#Direccion_provincia_id').change(function(){
		if($(this).val() != ''){
			var path = location.pathname.split('/');
			$.ajax({
			      url: "<?php echo Yii::app()->createUrl('direccion/cargarCiudades'); ?>",
			      type: "post",
			      data: { provincia_id : $(this).val() },
			      success: function(data){
			           $('#Direccion_ciudad_id').html(data);
			      },
			});
		}
	});
</script>