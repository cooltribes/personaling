<?php

function getMonthsArray()
    {
        
         $months['01'] = "Enero";
		 $months['02'] = "Febrero";
		 $months['03'] = "Marzo";
		 $months['04'] = "Abril";
		 $months['05'] = "Mayo";
		 $months['06'] = "Junio";
		 $months['07'] = "Julio";
		 $months['08'] = "Agosto";
		 $months['09'] = "Septiembre";
		 $months['10'] = "Octubre";
		 $months['11'] = "Noviembre";
		 $months['12'] = "Diciembre";
    

        return array(0 => 'Mes:') + $months;
    }

     function getDaysArray()
    {
		$days['01'] = '01';
		$days['02'] = '02';
		$days['03'] = '03';
		$days['04'] = '04';
		$days['05'] = '05';
		$days['06'] = '06';
		$days['07'] = '07';
		$days['08'] = '08';
		$days['09'] = '09';
        for($dayNum = 10; $dayNum <= 31; $dayNum++){
            $days[$dayNum] = $dayNum;
        }

        return array(0 => 'Dia:') + $days;
    }

     function getYearsArray()
    {
        $thisYear = date('Y', time());

        for($yearNum = $thisYear; $yearNum >= 1920; $yearNum--){
            $years[$yearNum] = $yearNum;
        }

        return array(0 => 'Año:') + $years;
    }
    
	?>
<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Usuario</h1>
  </div>
  <!-- SUBMENU ON -->
  <?php $this->renderPartial('_menu', array('model'=>$model)); ?>
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'registration-form',
	'htmlOptions'=>array('class'=>'form-stacked','enctype'=>'multipart/form-data'),
    'type'=>'horizontal ',
   // 'type'=>'inline',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	
)); ?>        	
          <fieldset>
             	   <legend >Datos de Usuario: </legend>
            <div class="control-group">
<?php echo $form->textFieldRow($model,'email',array('class'=>'span5',)); ?>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Contraseña </label>
              <div class="controls">
                <input type="password" placeholder="Contraseña"  class="span5">
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <div class="control-group">
				<?php echo $form->dropDownListRow($model,'personal_shopper',array(0=>'No',1=>'Si'),array('class'=>'span2')); ?>
            </div>             	   
             	   <legend >Datos básicos: </legend>


<?php 
		$profileFields=$profile->getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
				//echo $field->varname;
			?>
<div class="control-group">
	<div class="controls">
		<?php 
		if ($widgetEdit = $field->widgetEdit($profile)) {
			echo $widgetEdit;
		} elseif ($field->range) {
			if ($field->varname == 'sex')
				echo $form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range));
			else
				echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range));
						
			//echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range));
			//echo $form->radioButtonListRow($profile,$field->varname,Profile::range($field->range));
		} elseif ($field->field_type=="TEXT") {
			echo $form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
		} elseif ($field->field_type=="DATE") {
				
			echo $form->labelEx($profile,$field->varname);	
			
			echo $form->DropDownList($profile,'day',getDaysArray(),array('class'=>'span1'));
			echo ' ';
			echo $form->DropDownList($profile,'month',getMonthsArray(),array('class'=>'span2'));
			echo ' ';
			echo $form->DropDownList($profile,'year',getYearsArray(),array('class'=>'span1'));
			echo ' ';
			echo $form->hiddenField($profile,$field->varname);
			//echo $form->textFieldRow($profile,$field->varname,array('class'=>'span5','maxlength'=>(($field->field_size)?$field->field_size:255)));
			
				 
				
		} else {
			echo $form->textFieldRow($profile,$field->varname,array('class'=>'span5','maxlength'=>(($field->field_size)?$field->field_size:255)));
		}
		 ?>
		 <?php echo $form->error($profile,$field->varname); ?>
	</div>
</div>
			<?php
			}
		}
?>		          
            
           
          </fieldset>
        <?php $this->endWidget(); ?>       
        <!-- 
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form2"   class="form-stacked form-horizontal" enctype="multipart/form-data">
          <fieldset>
            <legend >Datos básicos: </legend>
            <div class="control-group">
              <label for="RegistrationForm_email" class="control-label ">Nombre de usuario </label>
              <div class="controls">
                <input type="text" placeholder="Nombre de usuario"  class="span5">
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Correo electrónico </label>
              <div class="controls">
                <input type="text" placeholder="Ej.: juanmiguel@email.com"  class="span5">
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Contraseña </label>
              <div class="controls">
                <input type="password" placeholder="Contraseña"  class="span5">
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Nombre</label>
              <div class="controls">
                <input type="text" placeholder="Nombre"  class="span5">
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Apellido</label>
              <div class="controls">
                <input type="text" placeholder="Apellido"  class="span5">
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label "> Fecha de nacimiento</label>
              <div class="controls controls-row">
                <select class="span1" type="text" >
                  <option>Dia</option>
                  <option>01</option>
                  <option>02</option>
                </select>
                <select class="span1" type="text" >
                  <option>Mes</option>
                  <option>01</option>
                  <option>02</option>
                </select>
                <select class="span1" type="text" >
                  <option>Año</option>
                  <option>01</option>
                  <option>02</option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Genero </label>
              <div class=""controls controls-row"">
                <label class="checkbox inline">
                  <input type="radio" id="inlineCheckbox1" name="optionsRadios" value="option1">
                  Mujer </label>
                <label class="checkbox inline">
                  <input type="radio" id="inlineCheckbox1" name="optionsRadios" value="option2">
                  Hombre </label>
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Cédula</label>
              <div class="controls">
                <input type="text" placeholder="Cédula"  class="span5">
                <div style="display:none" class="help-inline">ayuda aqui </div>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label "> País</label>
              <div class="controls">
                <select class="span5" type="text" >
                  <option>Venezuela</option>
                  <option>Colombia</option>
                  <option>USA</option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Ciudad</label>
              <div class="controls">
                <select class="span5" type="text" >
                  <option>San Cristóbal</option>
                  <option>item</option>
                  <option>item</option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Tipo de Usuario</label>
              <div class="controls">
                <select class="span5" type="text" >
                  <option>Usuario</option>
                  <option>item</option>
                  <option>item</option>
                </select>
              </div>
            </div>
            <div class="control-group">
              <label for="" class="control-label ">Estado</label>
              <div class="controls">
                <select class="span5" type="text" >
                  <option>Invitado</option>
                  <option>item</option>
                  <option>item</option>
                </select>
              </div>
            </div>
          </fieldset>
        </form>
        -->
      </div>
    </div>
   
    <div class="span3">
      <div class="padding_left"> 
      	  
            	 
            			<?php $this->widget('bootstrap.widgets.TbButton', array(
            				'buttonType'=>'button',
						    'label'=>'Guardar',
						    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						    'size'=>'large', // null, 'large', 'small' or 'mini'
						    'block'=>'true',
						    'htmlOptions'=>array('onclick'=>'js:$("#registration-form").submit();')
						)); ?>
						
           
      	
        <ul class="nav nav-stacked nav-tabs margin_top">
          <li><a href="#" title="Restablecer"><i class="icon-repeat"></i> Restablecer</a></li>
          <li><a href="#" title="Guardar"><i class="icon-bell"></i> Crear / Enviar Intivacion</a></li>
          <li><a href="#" title="Guardar"><i class="icon-bell"></i> Reenviar Invitación</a></li>
          <li><a href="#" title="Desactivar"><i class="icon-off"></i> Desactivar</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- /container -->
