<?php /*?><?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Mi cuenta")=>array('micuenta'),
	UserModule::t("Tu perfil corporal"),
);
?>
<?php */?>

<div class="container margin_top tu_perfil">
  <div class="row">
    <?php if (isset($editar) && $editar){ ?>
    <!-- SIDEBAR ON -->
    <aside class="span3"> <?php echo $this->renderPartial('_sidebar'); ?> </aside>
    <!-- SIDEBAR ON -->
    <?php } ?>
    <div class="<?php echo (isset($editar) && $editar)?'span9':'span12'; ?>">
      <?php
function replace_accents($string) 
{ 
  return str_replace( array(' ','à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array('','a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $string); 
} 
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
          <div id="numero1">
            <legend>Características básicas: </legend>
            <div class="control-group" >
              <div class="controls row-fluid" id="caracteristicas">
                <?php $clase = (isset($editar) && $editar)?'span2':'span2'; ?>
                <?php $clase2 = (isset($editar) && $editar)?'span10':'span8'; ?>
                <div class="<?php echo $clase; ?>">
                  <?php 
                    	$field = ProfileField::model()->findByAttributes(array('varname'=>'altura'));
  				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range), array('class'=>$clase2));
                    ?>
                </div>
                <div class="<?php echo $clase; ?>">
                  <?php 
                    	$field = ProfileField::model()->findByAttributes(array('varname'=>'contextura'));
  				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range), array('class'=>$clase2));
                    ?>
                </div>
                <div class="<?php echo $clase; ?>">
                  <?php 
                    	$field = ProfileField::model()->findByAttributes(array('varname'=>'pelo'));
  				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range), array('class'=>$clase2));
                    ?>
                </div>
                <div class="<?php echo $clase; ?>">
                  <?php 
                    	$field = ProfileField::model()->findByAttributes(array('varname'=>'ojos'));
  				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range), array('class'=>$clase2));
                    ?>
                </div>
                <div class="<?php echo $clase; ?>">
                  <?php 
                    	$field = ProfileField::model()->findByAttributes(array('varname'=>'piel'));
  				  	echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range), array('class'=>$clase2));
                    ?>
                </div>
              </div>
          </div>
          </div>
          <legend class="margin_top">Forma de tu cuerpo</legend>
          <div class="control-group" id="numero2">
            <div class="controls row-fluid">
              <?php 
                $field = ProfileField::model()->findByAttributes(array('varname'=>'tipo_cuerpo'));
			   echo $form->hiddenField($profile,$field->varname);
			   $nombre_tmp = $field->varname;
			   if (isset($profile->$nombre_tmp)) $valor_tmp = $profile->$nombre_tmp; else $valor_tmp = 0;
				?>
              <ul class="thumbnails" id="tipo_cuerpo">
                <?php foreach (Profile::range($field->range) as $key => $tipo){ ?>
                <li class="span3 <?php if ($valor_tmp == $key) echo 'active'; ?>" id="tipo_<?php echo $key; ?>"> <a href="#" title="Elegir este tipo de cuerpo">
                  <div class="thumbnail"> <?php echo  CHtml::image(Yii::app()->baseUrl . '/images/'.replace_accents($tipo).'.jpg', "Imagen " . $tipo, array("width" => "270", "height" => "400")); ?>
                    <div class="caption text_align_center CAPS">
                      <p><?php echo $tipo; ?></p>
                    </div>
                  </div>
                  </a> </li>
                <?php } ?>
              </ul>
            </div>
          </div>
          <div class="form-actions" >
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
<?php 
$script = "
	$('#tipo_cuerpo').on('click', 'li', function(e) {
		 
		 var ids = '';
		 $(this).siblings().removeClass('active');
		 $(this).addClass('active');
		 
		// var selected = $(this).attr('href');
		// $('#tipo_cuerpo .active').each(function(){
		// 	if (selected != $(this).attr('id'))
		// 		ids += $(this).attr('id');
			
		// });
		// alert($(this).hasClass('active'));
		// alert(ids);
		 //if (!($(this).hasClass('active')))
		 //	ids += $(this).attr('id');
		// alert(ids);
		// alert(ids.substring(1));
		 $('#Profile_tipo_cuerpo').val($(this).attr('id').substring(5));
		 //return false;
		 e.preventDefault();
	 });
	
	
";
?>
<?php Yii::app()->clientScript->registerScript('botones',$script); ?>

<!-- contenido -->
<ol id="joyRideTipContent">
  <li data-id="numero1" data-button="Siguiente" >
  <h3>Escoge las caracteristicas</h3>
    <p>Escoge tus caracteristicas de cuerpo</p>  
  </li>
  <li data-id="tipo_cuerpo" data-options="tipLocation:left"  data-button="Siguiente">
    <h3>Escoge la forma</h3>
    <p>Selecciona tu forma de cuerpo  </p>
  </li>
  
  <li data-id="yw1" data-options="tipLocation:top;tipAnimation:fade" data-button="Siguiente">
    <h3>Presiona</h3>
    <p>Ahora vamos a escoger tu estilo  </p>
  </li>
</ol>


<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/joyride-2.1.css">
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.joyride-2.1.js"></script>
    <script>
      $(window).load(function() {
        $('#joyRideTipContent').joyride({
          autoStart : true,
          modal:true,
          expose: true
        });
      });
</script>