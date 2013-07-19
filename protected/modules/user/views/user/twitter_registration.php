<?php
$full_name = explode(' ', $twitter_user->name);
//$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Registration");
//$this->breadcrumbs=array(
	//UserModule::t("Registration"),
//);
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



<?php if(Yii::app()->user->hasFlash('registration')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('registration'); ?>
</div>
<?php else: ?>


<div class="container margin_top">
  <div class="row">
    <div class="span6 offset3">
      <h1>Completa el registro</h1>
      <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">

        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'registration-form',
	'action'=>'registration',
	'htmlOptions'=>array('class'=>'personaling_form'),
    //'type'=>'stacked',
    'type'=>'inline',
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
          <fieldset>
	<?php echo $form->errorSummary(array($model,$profile)); ?>
	
<div class="control-group row-fluid">
	<div class="controls">
	<?php echo $form->textFieldRow($model,'email',array("class"=>"span12")); 
	echo $form->error($model,'email');
	?>
	</div>
</div>
<div class="control-group row-fluid">
	<div class="controls">	
	<?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span12')); 
	echo $form->error($model,'password');
	?>
	</div>
</div>
<?php echo  CHtml::hiddenField('twitter_id', $twitter_user->id, array('id'=>'twitter_id')); 
	?>

	
<?php 
		$profileFields=$profile->getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
				//echo $field->varname;
			?>
<div class="control-group row-fluid">
	<div class="controls controls-row">
		<?php 
		if ($widgetEdit = $field->widgetEdit($profile)) {
			echo $widgetEdit;
		} elseif ($field->range) {
			if ($field->varname == 'sex')
				echo $form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range));
			else
				echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range));
			//echo $form->error($profile,$field->varname);
			
		} elseif ($field->field_type=="TEXT") {
			echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
			echo $form->error($profile,$field->varname);
		} elseif ($field->field_type=="DATE") {
				
			echo $form->labelEx($profile,$field->varname, array('class'=>'span1'));	
			
			echo $form->DropDownList($profile,'day',getDaysArray(),array('class'=>'span1'));
			echo ' ';
			echo $form->DropDownList($profile,'month',getMonthsArray(),array('class'=>'span2'));
			echo ' ';
			echo $form->DropDownList($profile,'year',getYearsArray(),array('class'=>'span1'));
			echo ' ';
			echo $form->hiddenField($profile,$field->varname);
			//echo $form->textFieldRow($profile,$field->varname,array('class'=>'span5','maxlength'=>(($field->field_size)?$field->field_size:255)));
			echo $form->error($profile,$field->varname);
				 
				
		} else {
			if($field->varname == 'first_name'){
				echo $form->textFieldRow($profile,$field->varname,array('class'=>'span12','maxlength'=>(($field->field_size)?$field->field_size:255), 'value'=>$full_name[0]));
			}else if($field->varname == 'last_name'){
				echo $form->textFieldRow($profile,$field->varname,array('class'=>'span12','maxlength'=>(($field->field_size)?$field->field_size:255), 'value'=>$full_name[1]));
			}else{
				echo $form->textFieldRow($profile,$field->varname,array('class'=>'span12','maxlength'=>(($field->field_size)?$field->field_size:255)));
			}
			
			echo $form->error($profile,$field->varname);
		}
		
		 
				 ?>
	</div>
</div12
			<?php
			}
		}
?>
            <hr/>
            <label class="checkbox"> <input type="checkbox"> Al hacer clic en "Crear Cuenta" estas indicando que has leido y aceptado los <a href="#" title="terminos y condiciones">Terminos de Servicio</a> y la <a href="#" title="Politicas de Privacidad">Politica de Privacidad</a>. </label>

	<div class="form-actions"> 
		
			
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
		    'label'=>'Siguiente',
		    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		    'size'=>'large', // null, 'large', 'small' or 'mini'
		)); ?>
	</div>

</fieldset>
<?php $this->endWidget(); ?>
      </section>
    </div>
  </div>
</div>
<?php endif; ?>