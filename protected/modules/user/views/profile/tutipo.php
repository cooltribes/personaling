<?php /*?><?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Mi cuenta")=>array('micuenta'),
	UserModule::t("Tu perfil corporal"),
);
?>
<?php */?>
<div class="container margin_top">
  <div class="row">
    <div class="span12">
<?php

$this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )
); 

?>
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
      <h1>Tu tipo <small> - Escoge las opciones que más se parezcan a ti:</small></h1>
   
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
            <legend>Características básicas: </legend>
            <div class="control-group">
              <div class="controls row">
                <div class="span2 offset1">
                  <?php 
                  	$field = ProfileField::model()->findByAttributes(array('varname'=>'altura'));
				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range), array('class'=>'span2'));
                  ?>
                </div> 
                <div class="span2">
                  <?php 
                  	$field = ProfileField::model()->findByAttributes(array('varname'=>'contextura'));
				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range), array('class'=>'span2'));
                  ?>
                </div>
                <div class="span2">
                  <?php 
                  	$field = ProfileField::model()->findByAttributes(array('varname'=>'pelo'));
				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range), array('class'=>'span2'));
                  ?>
                </div>
                <div class="span2">
                  <?php 
                  	$field = ProfileField::model()->findByAttributes(array('varname'=>'ojos'));
				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range), array('class'=>'span2'));
                  ?>
                </div>
                <div class="span2">
                  <?php 
                  	$field = ProfileField::model()->findByAttributes(array('varname'=>'piel'));
				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range), array('class'=>'span2'));
                  ?>
                </div>                
              </div>
            </div>
              <legend class="margin_top">Forma de tu cuerpo</legend>
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
			   echo $form->hiddenField($profile,$field->varname,Profile::range($field->range));
				?>
                <ul class="thumbnails">
                <li class="span3 active"> <a href="#" title="Elegir este tipo de cuerpo">
                  <div class="thumbnail"> <img alt="Tipo de cuerpo" style="width: 270px; height: 400px;" src="http://placehold.it/270x400">
                    <div class="caption text_align_center CAPS">
                      <p>Cras justoelit.</p>
                    </div>
                  </div>
                  </a> </li>
                <li class="span3"> <a href="#" title="Elegir este tipo de cuerpo">
                  <div class="thumbnail"> <img alt="Tipo de cuerpo" style="width: 270px; height: 400px;" src="http://placehold.it/270x400">
                    <div class="caption text_align_center CAPS">
                      <p>Cras justoelit.</p>
                    </div>
                  </div>
                  </a> </li>
                <li class="span3"> <a href="#" title="Elegir este tipo de cuerpo">
                  <div class="thumbnail"> <img alt="Tipo de cuerpo" style="width: 270px; height: 400px;" src="http://placehold.it/270x400">
                    <div class="caption text_align_center CAPS">
                      <p>Cras justoelit.</p>
                    </div>
                  </div>
                  </a> </li>
                <li class="span3"> <a href="#" title="Elegir este tipo de cuerpo">
                  <div class="thumbnail"> <img alt="Tipo de cuerpo" style="width: 270px; height: 400px;" src="http://placehold.it/270x400">
                    <div class="caption text_align_center CAPS">
                      <p>Cras justoelit.</p>
                    </div>
                  </div>
                  </a> </li>
              </ul>
                
                
              </div>
            </div>
            <div class="form-actions">             			
            	<?php $this->widget('bootstrap.widgets.TbButton', array(
            				'buttonType' => 'submit',
						    'label'=>isset($editar)?'Guardar':'Siguiente',
						    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						    'size'=>'large', // null, 'large', 'small' or 'mini'
							'htmlOptions' => array('class'=>'pull-right'), 
							
						)); ?> 
			</div>
          </fieldset>
       <?php $this->endWidget(); ?>
      </article>
    </div>
  </div>
</div>