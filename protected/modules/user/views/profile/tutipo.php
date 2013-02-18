<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>
<div class="container margin_top">
  <div class="row">
    <div class="span12">
	<?php if (isset($editar) && $editar){ ?>
     <!-- MENU ON -->
		<div class="navbar">
			<div class="navbar-inner margin_bottom">
				<ul class="nav ">
					<li class="active">
						<?php echo CHtml::link('Datos Personales',array('profile/edit'));
						?>
					</li>
					<li>
						<?php echo CHtml::link('Avatar',array('profile/avatar'));
						?>
					</li>
					<li>
						<?php echo CHtml::link('Tu Tipo',array('profile/edittutipo'));
						?>
					</li>
				</ul>
			</div>
		</div>
     <!-- MENU OFF -->
     <?php } ?>   
      <h1>Tu tipo</h1>
   
      <article class="margin_top  margin_bottom_small ">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'tutipo-form',
	'htmlOptions'=>array('class'=>'personaling_form'),
    //'type'=>'stacked',
    'type'=>'inline',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
          <fieldset>
            <legend class="text_align_center">Lorem ipsum: </legend>
            <div class="control-group">
              <div class="controls row">
                <div class="span3">
                  <?php 
                  	$field = ProfileField::model()->findByAttributes(array('varname'=>'altura'));
				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range));
                  ?>
                </div> 
                <div class="span3">
                  <?php 
                  	$field = ProfileField::model()->findByAttributes(array('varname'=>'contextura'));
				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range));
                  ?>
                </div>
                <div class="span3">
                  <?php 
                  	$field = ProfileField::model()->findByAttributes(array('varname'=>'pelo'));
				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range));
                  ?>
                </div>
                <div class="span3">
                  <?php 
                  	$field = ProfileField::model()->findByAttributes(array('varname'=>'ojos'));
				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range));
                  ?>
                </div>
              </div>
            </div>
            <legend class="text_align_center">Tu tipo es: </legend>
            <div class="control-group">
              <div class="controls row">
                <!--
                <div class="span3">
                  <label> <img src="http://placehold.it/270x400"/>
                    <input type="radio" id="inlineCheckbox1" name="optionsRadios" value="option2">
                    Triangulo</label>
                  </label>
                </div>
                <div class="span3">
                  <label> <img src="http://placehold.it/270x400"/>
                    <input type="radio" id="inlineCheckbox1" name="optionsRadios" value="option2">
                    Triangulo</label>
                  </label>
                </div>
                <div class="span3">
                  <label><img src="http://placehold.it/270x400"/>
                    <input type="radio" id="inlineCheckbox1" name="optionsRadios" value="option2">
                    Triangulo</label>
                  </label>
                </div>
                <div class="span3">
                  <label> <img src="http://placehold.it/270x400"/>
                    <input type="radio" id="inlineCheckbox1" name="optionsRadios" value="option2">
                    Triangulo</label>
                  </label>
                </div>
                -->
                <?php 
                $field = ProfileField::model()->findByAttributes(array('varname'=>'tipo_cuerpo'));
				echo $form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range));
				?>
              </div>
            </div>
            <div class="form-actions">             			
            	<?php $this->widget('bootstrap.widgets.TbButton', array(
            				'buttonType' => 'submit',
						    'label'=>isset($editar)?'Guardar':'Siguiente',
						    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						    'size'=>'large', // null, 'large', 'small' or 'mini'
						)); ?> 
			</div>
          </fieldset>
       <?php $this->endWidget(); ?>
      </article>
    </div>
  </div>
</div>