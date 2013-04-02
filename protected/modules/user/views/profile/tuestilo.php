<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Mi cuenta")=>array('micuenta'),
	UserModule::t("Tu estilo"),
);
?>
<?php
	if (!(isset($estilo)))
		$estilo = 'coctel';
?>

<div class="container margin_top">
  <div class="row">
    <div class="span12">
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
<!-- FLASH OFF --> 
      <h1>Tu Estilo</h1>
<!-- Deberia quedar como este --><div class="row"><div class="span6 offset3"><section class="margin_top  margin_bottom_small ">
        <ul class="nav nav-pills">
          <li class="active"> <a href="#">Diario</a> </li>
          <li><a href="#">Fiesta</a></li>
          <li><a href="#">Vacaciones</a></li>
          <li><a href="#">Haciendo Deporte</a></li>
          <li><a href="#">Oficina</a></li>
        </ul>
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked personaling_form" enctype="multipart/form-data">
          <fieldset>
            <legend>Escoge tu estilo: </legend>
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
            </ul>
          </fieldset>
        </form>
      </section></div></div>
      <article class="margin_top  margin_bottom_small ">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'tuestilo-form',
	'htmlOptions'=>array('class'=>'personaling_form'),
    //'type'=>'stacked',
    'type'=>'inline',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
          
            
            
            
            
            <div class="control-group">
              <div class="controls row">
              	            <?php 
              	             
                $field = ProfileField::model()->findByAttributes(array('varname'=>'coctel'));
				$tabs[] = array(
            		'active'=>$estilo=='coctel'?true:false,
            		'label'=>$field->title,
            		//'content'=>$form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range)),
            		'content'=> '          <fieldset>
            <legend>Escoge tu estilo: </legend>
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
            </ul>
          </fieldset>',
        		);
                $field = ProfileField::model()->findByAttributes(array('varname'=>'fiesta'));
				$tabs[] = array(
            		'active'=>$estilo=='fiesta'?true:false,
            		'label'=>$field->title,
            		'content'=>$form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range)),
        		);        		
                $field = ProfileField::model()->findByAttributes(array('varname'=>'playa'));
				$tabs[] = array(
            		'active'=>$estilo=='playa'?true:false,
            		'label'=>$field->title,
            		'content'=>$form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range)),
        		);
                $field = ProfileField::model()->findByAttributes(array('varname'=>'sport'));
				$tabs[] = array(
            		'active'=>$estilo=='sport'?true:false,
            		'label'=>$field->title,
            		'content'=>$form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range)),
        		);
				$field = ProfileField::model()->findByAttributes(array('varname'=>'trabajo'));
				$tabs[] = array(
            		'active'=>$estilo=='trabajo'?true:false,
            		'label'=>$field->title,
            		'content'=>$form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range)),
        		);
				?>
				<?php $this->widget('bootstrap.widgets.TbTabs', array(
				'placement'=>'adove', // 'above', 'right', 'below' or 'left'
    				'tabs'=>$tabs,
    				'type'=>'pills'
				)); ?>
				<?php
				Yii::app()->clientScript->registerScript('change', "
					$('.tab-content :input').click(function(){
							div_id = $(this).closest('div').next().attr('id');
							if (div_id === undefined) {
								$('#tuestilo-form').submit();
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
         
        <?php $this->endWidget(); ?>
       
      </article>
    </div>
  </div>
</div>