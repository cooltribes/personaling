<div class="container margin_top">
  <div class="row">
    <div class="span12">
      <h1>Tu tipo</h1>
      <article class="margin_top  margin_bottom_small ">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'registration-form',
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
              </div>
            </div>
            <div class="form-actions"> <a href="Crear_Perfil_Usuaria_Mi_Estilo.php" class="btn-large btn btn-danger">Siguiente</a> </div>
          </fieldset>
       <?php $this->endWidget(); ?>
      </article>
    </div>
  </div>
</div>