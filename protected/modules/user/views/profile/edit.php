<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	"Tu Cuenta"=>array('micuenta'),
	UserModule::t("Tus datos personales"),
);     
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

<!-- SIDEBAR ON -->
  <aside class="span3"> <?php echo $this->renderPartial('_sidebar'); ?> </aside>
  <!-- SIDEBAR ON --> 
  
<!-- FLASH OFF -->   
    <div class="span9">
      <article class="bg_color3 margin_top  margin_bottom_small padding_small box_1" style="width: 86%; margin: 0 auto;">
        
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'profile-form',
	'htmlOptions'=>array('class'=>'personaling_form','enctype'=>'multipart/form-data'),
    //'type'=>'stacked',
    'type'=>'inline',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	
)); ?>        	
          <fieldset>
             	   <h1>Tu perfil</h1>


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
			else{
				if($field->varname=='tipo_comision')
				{
					if(UserModule::isAdmin()){
						echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range));
					}else{
						if(User::model()->is_personalshopper(Yii::app()->user->id)){
							echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range),array('disabled'=>'disabled'));
						}
						
					}
				}
			
				elseif($field->varname == 'pais')
					echo $form->hiddenField($profile,$field->varname,array("value"=>"1"));
			}
			
				
						
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
			if($field->varname=='comision'||$field->varname=='tiempo_validez'){
				if(UserModule::isAdmin()){
					echo $form->textFieldRow($profile,$field->varname,array('class'=>'span5','maxlength'=>(($field->field_size)?$field->field_size:255)));
				}else{
					if(User::model()->is_personalshopper(Yii::app()->user->id)){
						echo $form->textFieldRow($profile,$field->varname,array('disabled'=>'disabled','class'=>'span5','maxlength'=>(($field->field_size)?$field->field_size:255)));
					}
					
				}
			}
			else{
				echo $form->textFieldRow($profile,$field->varname,array('class'=>'span5','maxlength'=>(($field->field_size)?$field->field_size:255)));
			}
		}
			
		 ?>
		 <?php echo $form->error($profile,$field->varname); ?>
	</div>
</div>
			<?php
			}
		}
?>		          
            
            <div class="form-actions"> 
            	 
            			<?php $this->widget('bootstrap.widgets.TbButton', array(
            				'buttonType'=>'submit',
						    'label'=>'Guardar',
						    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						    'size'=>'large', // null, 'large', 'small' or 'mini'
						)); ?>
						<?php //echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save')); ?>
            </div>
          </fieldset>
        <?php $this->endWidget(); ?>
      </article>
    </div>
  </div>
</div>




