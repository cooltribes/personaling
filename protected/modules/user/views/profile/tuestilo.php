<div class="container margin_top">
  <div class="row">
    <div class="span12">
      <h1>Tu Estilo</h1>
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
            <legend class="text_align_center">Escoge tu estilo: </legend>
            <div class="control-group">
              <div class="controls row">
              	            <?php 
                $field = ProfileField::model()->findByAttributes(array('varname'=>'coctel'));
				echo $form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range));
				?>
              <!-- 
                <div class="span4 offset2">
               <label><a href="Buscar_looks_Catalogo.php" title="catalogo"><img src="http://placehold.it/370x400"/> </a>
               
               <input type="radio" id="inlineCheckbox1" name="optionsRadios" value="option2"> Atrevido</label>
               </label>
                </div>
                <div class="span4">
                	
                	
                  <label><img src="http://placehold.it/370x400"/> 
            
               <input type="radio" id="inlineCheckbox1" name="optionsRadios" value="option2">Conservador</label>
               </label>
              
  
                </div>
              -->
              </div>
            </div>
          </fieldset>
        <?php $this->endWidget(); ?>
       
      </article>
    </div>
  </div>
</div>