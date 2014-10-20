
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'direccion_nueva',
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true, 
    ),
    'htmlOptions'=>array('class'=>'form-horizontal'),
)); 

    
    echo CHtml::hiddenField('idDireccion',$dir->id);
?>
    
      

      <section class="bg_color3 padding_small box_1">
          <fieldset>          
            <legend ><?php echo Yii::t('contentForm','Edit shipping address'); ?>: </legend>
            <div style="max-height:400px; overflow-y:scroll;">
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
                <?php // echo $form->dropDownListRow($dir, 'pais', array('Seleccione el País', 'Venezuela', 'Colombia', 'Estados Unidos')); 
                    $pais=Pais::model()->findByAttributes(array('idioma'=>Yii::app()->getLanguage()));
                 if($pais->grupo==0)
                        echo ' <input name="Direccion[pais]" id="Direccion_pais" type="hidden" value="'.$pais->id.'" />';
                    else{
                        echo '<p>España Exenta de IVA: Ceuta, Melilla, Canarias y Andorra</p>';
                         echo $form->dropDownListRow(
                            $dir,'pais', CHtml::listData(
                                Pais::model()->findAllByAttributes(
                                    array(
                                        'grupo'=>$pais->grupo),
                                    array(
                                        'order' => 'nombre')
                                ),'id','nombre'
                            ), array(
                                'selected' => $pais->id
                                )
                            );
                    }
                    
                 ?>
              </div>
            </div>
            
            
            
            <div class="control-group"> 
              
              <div class="controls">
                <?php echo $form->dropDownListRow($dir,'provincia_id', 
                            CHtml::listData(Provincia::model()->findAllByAttributes(array('pais_id'=>$pais->id),array('order' => 'nombre')),'id','nombre')
                            , array('empty' => Yii::t('contentForm','Select a province')));?>
                
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
             <?php if($pais->idioma=='es_es')         {?>
            <div class="control-group"> 
              <div class="controls"> 
                <?php 
                if($dir->ciudad_id == ''){ 
                    echo $form->dropDownListRow($dir,'codigo_postal_id', array(), array('empty' => Yii::t('contentForm','Select a zip code')));
                }else{
                        /*$criteria=new CDbCriteria;
                        $criteria->addCondition('cod_zoom IS NULL'); 
                        $criteria->addCondition('provincia_id ='.$dir->provincia_id); 
                        */
                        //$criteria->order('nombre'); 
                    //echo $form->dropDownListRow($dir,'ciudad_id', CHtml::listData(Ciudad::model()->findAllByAttributes(array(),"cod_zoom IS NOT NULL AND provincia_id =".$dir->provincia_id, array('order' => 'nombre')),'id','nombre'));
                    echo $form->dropDownListRow($dir,'codigo_postal_id', CHtml::listData(CodigoPostal::model()->findAllBySql("SELECT * FROM tbl_codigo_postal WHERE ciudad_id =".$dir->ciudad_id." order by codigo ASC"),'id','codigo'));
                    //echo $form->dropDownListRow($dir,'ciudad_id', CHtml::listData(Ciudad::model()->findAll($criteria),'id','nombre'));
                }}
                ?>
            
      <div style="width:100%" class="margin_top">
        
            <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'danger',
            'size'=>'large',
            'label'=>Yii::t('contentForm','Save'),
        )); 

        ?>
        </div>
      </div>  

           
           </div>
          </fieldset>
        </form>
      </section>


<!-- /container -->

<?php 

$this->endWidget(); ?>

<script>

    $('#Direccion_pais').change(function(){
        if($(this).val() != ''){
            var path = location.pathname.split('/');
            $.ajax({
                  url: "<?php echo Yii::app()->createUrl('direccion/cargarProvincias'); ?>",
                  type: "post",
                  data: { pais_id : $(this).val() },
                  success: function(data){
                       $('#Direccion_provincia_id').html(data);
                       $("#Direccion_ciudad_id").html('');
                       $("#Direccion_codigo_postal_id").html('');
                       
                  },
            });
        }
    });
    
    $('#Direccion_provincia_id').change(function(){
        if($(this).val() != ''){
            var path = location.pathname.split('/');
            $.ajax({
                  url: "<?php echo Yii::app()->createUrl('direccion/cargarCiudades'); ?>",
                  type: "post",
                  data: { provincia_id : $(this).val() },
                  success: function(data){
                       $('#Direccion_ciudad_id').html(data);
                      $("#Direccion_codigo_postal_id").html('');
                  },
            });
        }
    });
    
    $('#Direccion_ciudad_id').change(function(){
        if($(this).val() != ''){
            var path = location.pathname.split('/');
            $.ajax({
                  url: "<?php echo Yii::app()->createUrl('direccion/cargarCodigos'); ?>",
                  type: "post",
                  data: { ciudad_id : $(this).val() },
                  success: function(data){
                       $('#Direccion_codigo_postal_id').html(data);
                  },
            });
        }
    });
    

    
    
    
</script>