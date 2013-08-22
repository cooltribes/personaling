<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
//$this->breadcrumbs=array(
	//UserModule::t("Mi cuenta")=>array('micuenta'),
	//UserModule::t("Tu estilo"),
//);
    function getTabs($field,$profile){
            				$nombre_tmp = $field->varname;
			   	if (isset($profile->$nombre_tmp)) $valor = $profile->$nombre_tmp; else $valor = 0;  		
			$return = '<fieldset>
            <legend>Escoge un estilo que defina tu forma de vestir. </legend>
		
           
            <ul class="thumbnails">';
			//<img alt="'.$value.'" style="width: 270px; height: 400px;" src="http://placehold.it/270x400">
            foreach (Profile::range($field->range) as $key => $value){

            	//echo Yii::app()->baseUrl . '/images/'.$nombre_tmp.'_'.$key.'.jpg';
            	//if (file_exists(Yii::app()->baseUrl . '/images/'.$nombre_tmp.'_'.$key.'.jpg'))
					$nombre_image = Yii::app()->baseUrl . '/images/'.$nombre_tmp.'_'.$key.'.jpg';
				//else 
				//	$nombre_image = "http://placehold.it/270x400";
            $return .=  '<li class="span4 '.($key==$valor?'active':'').'" id="ocasion_'.$key.'"> <a href="#" title="Elige este estilo">
                <div class="thumbnail">'.
                CHtml::image($nombre_image, "Imagen ".$value, array("width" => "370", "height" => "370"))
                .'<div class="caption text_align_center CAPS">
                    
                  </div>
                </div>
                </a> </li>';
                }
            $return .= '</ul> 
          </fieldset>';      
		  return $return;  		
     }   
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
    <div class="page-header">  <h1>Elige tu Estilo</h1></div>
      
      
      
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
          
            
            
            
            
           <div class="row"><div class="span8 offset2">
              	            <?php 
          
                $field = ProfileField::model()->findByAttributes(array('varname'=>'coctel'));

				$tabs[] = array(
            		'active'=>$estilo=='coctel'?true:false,
            		'label'=>$field->title,
            		'aditional'=>'tab_falta',
            		//'content'=>$form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range)),
            		'content'=> getTabs($field,$profile).$form->hiddenField($profile,$field->varname),
        		);
                $field = ProfileField::model()->findByAttributes(array('varname'=>'fiesta'));
				$tabs[] = array(
            		'active'=>$estilo=='fiesta'?true:false,
            		'label'=>$field->title,
            		'aditional'=>'tab_falta',
            		'content'=> getTabs($field,$profile).$form->hiddenField($profile,$field->varname),
        		);        		
                $field = ProfileField::model()->findByAttributes(array('varname'=>'playa'));
				$tabs[] = array(
            		'active'=>$estilo=='playa'?true:false,
            		'label'=>$field->title,
            		'aditional'=>'tab_falta',
            		'content'=> getTabs($field,$profile).$form->hiddenField($profile,$field->varname),
        		);
                $field = ProfileField::model()->findByAttributes(array('varname'=>'sport'));
				$tabs[] = array(
            		'active'=>$estilo=='sport'?true:false,
            		'label'=>$field->title,
            		'aditional'=>'tab_falta',
            		'content'=> getTabs($field,$profile).$form->hiddenField($profile,$field->varname),
        		);
				$field = ProfileField::model()->findByAttributes(array('varname'=>'trabajo'));
				$tabs[] = array(
            		'active'=>$estilo=='trabajo'?true:false,
            		'label'=>$field->title,
            		'aditional'=>'tab_falta',
            		'content'=> getTabs($field,$profile).$form->hiddenField($profile,$field->varname),
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
              
              </div>
            </div>
         
        <?php $this->endWidget(); ?>
       
      
    </div>
  </div>
</div>
<?php 
$script = "
	$('.tab-content').on('click', 'li', function(e) {
		 
		 var ids = '';
		 $(this).siblings().removeClass('active');
		 $(this).addClass('active');
		 
		$(this).parents('fieldset').next('input').val($(this).attr('id').substring(8));
		 //$('#Profile_tipo_cuerpo').val($(this).attr('id').substring(5));
		div_id = $(this).parents('div.tab-pane').next().attr('id');
		div_id_actual = $(this).parents('div.tab-pane').attr('id');
		
		if (div_id === undefined) {
			$('#tuestilo-form').submit();
		} else {
			$('.nav-pills a[href=\"#'+div_id+'\"]').tab('show');
			$('.nav-pills a[href=\"#'+div_id_actual+'\"]').parent().removeClass('tab_falta');
			
		}		 
		// e.preventDefault();
	 });
	
	
";
?>
<?php Yii::app()->clientScript->registerScript('botones',$script); ?>