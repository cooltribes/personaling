<?php
Yii::app()->clientScript->registerCssFile('/css/joyride-2.1.css',null);
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
if((isset($editar) && $editar)){
  $this->breadcrumbs=array(
  	UserModule::t("Mi cuenta")=>array('micuenta'),
  	UserModule::t("Tu perfil corporal"),
  );
}
?>
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
    <?php if ( !(isset($editar) && $editar) ){ ?>
          
          <h2 class=""> Debes completar tu test de estilos para poder continuar </h2>

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
          <div id="numero1">

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
                  <div class="thumbnail" style="height:523px"> <?php echo  CHtml::image(Yii::app()->baseUrl . '/images/'.replace_accents($tipo).'.jpg', "Imagen " . $tipo, array("width" => "270", "height" => "400")); ?>
                    <div class="caption text_align_center CAPS">
                      <p ><?php echo $tipo; ?></p>
                    </div>
                    <caption>
                      <p class="  color6 text_align_center ">                  
                      <?php if($key == 1) 
                          echo "Tu cuerpo es rectangular o cuadrado, si tus hombros y caderas están casi alineados y tu cintura no es tan definida";
                        if($key == 2) 
                          echo "Tu cuerpo es reloj de arena porque además de tener tus hombros y caderas alineados debes tener una cintura muy definida"; 
                        if($key == 4)         
                          echo "Tu cuerpo es triángulo si tienes hombros y cintura pequeñita con unas caderas pronunciadas";
                        if($key == 8)         
                          echo "Tu cuerpo es triángulo invertido si eres proporcionalmente de hombros anchos y caderas pequeñitas";                        
                        ?>
                       </p>
                    </caption>                    
                  </div>
                  </a> 

                </li>

                <?php } ?>
              </ul>
            </div>
          </div>


          <div  class="form-actions row" >
            <div id="numero3" class="span3 offset9 ">
              <?php $this->widget('bootstrap.widgets.TbButton', array(
              				'buttonType' => 'submit',
  						    'label'=>isset($editar)?'Guardar':'Siguiente',
  						    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
  						    'size'=>'large', // null, 'large', 'small' or 'mini'
  							'htmlOptions' => array('class'=>'margin_left_large'), 
  							
  						)); ?>
            </div>
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
<ol id="joyRideTipContent" data-joyride>
  <li data-id="numero1" data-button="Siguiente" data-options="tipAnimation:fade" >
  <p class="lead"><strong>Escoge las características de tu cuerpo</strong></p>
    <p class="muted">Estas ayudarán a nuestros Personal Shoppers a hacer mejor su trabajo</p>  
  </li>
  <li data-id="numero2" data-button="Siguiente" data-options="tipLocation:left;tipAnimation:fade" >
    <p class="lead"><strong>Escoge la forma de tu cuerpo</strong></p>
    <p class="muted" >¡Queremos recomendarte ropa que te favorezca y haga ver espectacular! </p>
  </li>
  
  <li id="numero3" data-id="yw1" data-button="Terminar" data-options="tipLocation:top;tipAnimation:fade">
    <p class="lead"><strong>Escoge tu estilo</strong></p>
    <p class="muted">Haz click en siguiente y elige entre las imágenes tu estilo </p>
  </li>
</ol>
<?php Yii::app()->clientScript->registerScriptFile('/js/jquery.joyride-2.1.js',null,null); ?>
<!--<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.joyride-2.1.js"></script>-->
    <script>
      $(window).load(function() {
        $('#joyRideTipContent').joyride({      
          autoStart : <?php echo !((isset($editar) && $editar)) ? 'true' : 'false' ?>,
          modal: true,
          expose: true,
          scroll: false,
        // 'tipLocation': 'bottom',         // 'top' or 'bottom' in relation to parent
        // 'nubPosition': 'auto',           // override on a per tooltip bases
        // 'scrollSpeed': false,              // Page scrolling speed in ms
        // 'timer': 0,                   // 0 = off, all other numbers = time(ms) 
        // 'startTimerOnClick': false,       // true/false to start timer on first click
        // 'nextButton': true,              // true/false for next button visibility
        // 'tipAnimation': 'fade',           // 'pop' or 'fade' in each tip
        // 'pauseAfter': [],                // array of indexes where to pause the tour after
        // 'tipAnimationFadeSpeed': 300,    // if 'fade'- speed in ms of transition
        // 'cookieMonster': true,           // true/false for whether cookies are used
        // 'cookieName': 'JoyRide',         // choose your own cookie name
        // 'cookieDomain': false,           // set to false or yoursite.com

      });
  });
</script>

