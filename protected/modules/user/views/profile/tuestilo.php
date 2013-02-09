<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>
<div class="container margin_top">
  <div class="row">
    <div class="span12">
      <h1>Tu Estilo</h1>
     <?php if (isset($editar) && $editar){ ?>
     <!-- MENU ON -->
     <ul class="nav nav-pills margin_top">
        <li class="active"> 
        	<?php echo CHtml::link('Datos Personales',array('user/profile/edit')); ?>
        </li>
        <li>
        	<?php echo CHtml::link('Avatar',array('user/profile/avatar')); ?>
        	
        </li>
        <li>
        	<?php echo CHtml::link('Avatar',array('user/profile/edittuestilo')); ?>
        	
        </li>
      </ul>
     <!-- MENU OFF -->
     <?php } ?>
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
				$tabs[] = array(
            		'active'=>true,
            		'label'=>$field->title,
            		'content'=>$form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range)),
        		);
                $field = ProfileField::model()->findByAttributes(array('varname'=>'fiesta'));
				$tabs[] = array(
            		'active'=>false,
            		'label'=>$field->title,
            		'content'=>$form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range)),
        		);        		
                $field = ProfileField::model()->findByAttributes(array('varname'=>'playa'));
				$tabs[] = array(
            		'active'=>false,
            		'label'=>$field->title,
            		'content'=>$form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range)),
        		);
                $field = ProfileField::model()->findByAttributes(array('varname'=>'sport'));
				$tabs[] = array(
            		'active'=>false,
            		'label'=>$field->title,
            		'content'=>$form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range)),
        		);
				$field = ProfileField::model()->findByAttributes(array('varname'=>'trabajo'));
				$tabs[] = array(
            		'active'=>false,
            		'label'=>$field->title,
            		'content'=>$form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range)),
        		);
				?>
				<?php $this->widget('bootstrap.widgets.TbTabs', array(
				'placement'=>'left', // 'above', 'right', 'below' or 'left'
    				'tabs'=>$tabs,
				)); ?>
				<?php
				Yii::app()->clientScript->registerScript('change', "
					$('.tab-content :input').click(function(){
							div_id = $(this).closest('div').next().attr('id');
							if (div_id === undefined) {
								$('#tutipo-form').submit();
							} else {
								$('.nav-tabs a[href=\"#'+div_id+'\"]').tab('show');
							}
						
					});
					
					
					");
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