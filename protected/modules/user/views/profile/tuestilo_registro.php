<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
//$this->breadcrumbs=array(
	//UserModule::t("Mi cuenta")=>array('micuenta'),
	//UserModule::t("Tu estilo"),
//);
    function getTabs($field,$profile){
            				$nombre_tmp = $field->varname;
			   	if (isset($profile->$nombre_tmp)) $valor = $profile->$nombre_tmp; else $valor = 0;  		
            $return = '<fieldset>';
            if($field->title == 'Diario')
                $return .='<legend>¿Con cuál estilo te identificas más para tu día a día? </legend>';
            if($field->title == 'Fiesta')
                $return .='<legend>¿Con cuál de estos looks te irias de fiesta? </legend>';
            if($field->title == 'Vacaciones')
                $return .='<legend>¿Cuales serían tus vacaciones ideales?</legend>';                            		
            if($field->title == 'Haciendo Deporte')
                $return .='<legend>¿Con cuál estilo te identificas más para hacer deporte? </legend>';            
            if($field->title == 'Oficina')
                $return .='<legend>¿Con cuál de estos looks írias a la oficina? </legend>';             
             $return .='<ul class="thumbnails">';
			//<img alt="'.$value.'" style="width: 270px; height: 400px;" src="http://placehold.it/270x400">
            foreach (Profile::range($field->range) as $key => $value){

            	//echo Yii::app()->baseUrl . '/images/'.$nombre_tmp.'_'.$key.'.jpg';
            	//if (file_exists(Yii::app()->baseUrl . '/images/'.$nombre_tmp.'_'.$key.'.jpg'))
                    $nombre_image = Yii::app()->baseUrl . '/images/estilos/'.Yii::app()->language.'/'.$nombre_tmp.'_'.$key.'.jpg';
				//else 
				//	$nombre_image = "http://placehold.it/270x400";
            $return .=  '<li class="span4 '.($key==$valor?'active':'').'" id="ocasion_'.$key.'"> <a href="#" title="Elige este estilo">
                <div class="thumbnail">
                <img width="370" height="370" src="'.$nombre_image.'" alt="Imagen "'.$value.'">
                <div class="caption text_align_center CAPS">
                    
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

<div class="container margin_top margin_top_medLarge_minus padding_top_small">

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
    <div class="page-header">
      <h1>Elige tu Estilo</h1>
  </div>
      
      
      
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'tuestilo-registro-form',
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
            		// 'label'=>$field->title,
            		'aditional'=>'tab_falta tab_1 tab',
            		//'content'=>$form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range)),
            		'content'=> getTabs($field,$profile).$form->hiddenField($profile,$field->varname),
        		);
                $field = ProfileField::model()->findByAttributes(array('varname'=>'fiesta'));
				$tabs[] = array(
            		'active'=>$estilo=='fiesta'?true:false,
            		// 'label'=>$field->title,
            		'aditional'=>'tab_falta  tab_2 tab',
            		'content'=> getTabs($field,$profile).$form->hiddenField($profile,$field->varname),
        		);        		
                $field = ProfileField::model()->findByAttributes(array('varname'=>'playa'));
				$tabs[] = array(
            		'active'=>$estilo=='playa'?true:false,
            		// 'label'=>$field->title,
            		'aditional'=>'tab_falta  tab_3 tab',
            		'content'=> getTabs($field,$profile).$form->hiddenField($profile,$field->varname),
        		);
                $field = ProfileField::model()->findByAttributes(array('varname'=>'sport'));
				$tabs[] = array(
            		'active'=>$estilo=='sport'?true:false,
            		// 'label'=>$field->title,
            		'aditional'=>'tab_falta  tab_4 tab',
            		'content'=> getTabs($field,$profile).$form->hiddenField($profile,$field->varname),
        		);
				$field = ProfileField::model()->findByAttributes(array('varname'=>'trabajo'));
				$tabs[] = array(
            		'active'=>$estilo=='trabajo'?true:false,
            		// 'label'=>$field->title,
            		'aditional'=>'tab_falta tab_5 tab',
            		'content'=> getTabs($field,$profile).$form->hiddenField($profile,$field->varname),
        		);
				?>
				<?php $this->widget('bootstrap.widgets.TbTabs', array(
				    'placement'=>'left', // 'above', 'right', 'below' or 'left'
                    'tabs'=>$tabs,
                    'type'=>'pills',                
				)); ?>
				<?php
				Yii::app()->clientScript->registerScript('change', "
					$('.tab-content :input').click(function(){
							div_id = $(this).closest('div').next().attr('id');
							if (div_id === undefined) {
								$('#tuestilo-registro-form').submit();
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
    <h4 class=""> Debes completar tu test de estilos para poder continuar </h4>
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
        console.log(div_id);
        if (div_id === undefined) {
            $('#tuestilo-registro-form').submit();
        } else {
            $('.nav-pills a[href=\"#'+div_id+'\"]').tab('show');
            $('.nav-pills a[href=\"#'+div_id_actual+'\"]').parent().removeClass('tab_falta');
            
        }        
        // e.preventDefault();

        $('#yw2 > li').each(function(key){

            if( contadorInteracciones >= key ) {
                console.log(key);
                $('.tab_'+( key+1 )+'.tab a ').click(function(){
                    $(this).tab('show');
                });   
                $('.tab_'+( key+1 )+'.tab a ').css({ cursor: 'pointer' });  
            }      
        });
        contadorInteracciones++;
	 });
	
	
";
?>
<?php Yii::app()->clientScript->registerScript('botones',$script); ?>
<script>
    $('.tab_falta a').css({ cursor: 'default' });
    $('.tab_falta').click(false);
    var contadorInteracciones = 1;
</script>