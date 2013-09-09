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
  <li data-id="numero1" data-button="Next" >
  <h3>Escoge las caracteristicas</h3>
    <p>Escoge tus caracteristicas de cuerpo</p>  
  </li>
  <li data-id="numero2" data-options="tipLocation:left;tipAnimation:fade">
    <h3>Escoge la forma</h3>
    <p>Selecciona tu forma de cuerpo  </p>
  </li>
  
  <li data-id="yw1" data-options="tipLocation:top;tipAnimation:fade" data-button="none">
    <h3>Presiona</h3>
    <p>Ahora vamos a escoger tu estilo  </p>
  </li>
</ol>

<style type="text/css">
/* Artfully masterminded by ZURB */
body {
  position: relative;
}

#joyRideTipContent { display: none; }

.joyRideTipContent { display: none; }

/* Default styles for the container */
.joyride-tip-guide {
  position: absolute;
  background: #FFF;
  background: rgba(255,255,255,0.8);
  display: none;
  color: black;
  width: 250px;
  z-index: 101;
  top: 0; /* keeps the page from scrolling when calculating position */
  left: 0;
  height: 250px;
  font-family: inherit;
  font-weight: normal;
     -moz-border-radius: 135px;
  -webkit-border-radius: 135px;
          border-radius: 135px;
}

.joyride-content-wrapper {
  padding: 10px 10px 15px 15px;
  text-align: center;
}

/* Mobile */
@media only screen and (max-width: 767px) {
  .joyride-tip-guide {
    width: 95% !important;
    -moz-border-radius: 0;
    -webkit-border-radius: 0;
    border-radius: 0;
    left: 2.5% !important;
  }
  .joyride-tip-guide-wrapper {
    width: 100%;
  }
}


/* Add a little css triangle pip, older browser just miss out on the fanciness of it */
.joyride-tip-guide span.joyride-nub {
  display: block;
  position: absolute;
  left: 111px;
  width: 0;
  height: 0;
  border: solid 14px;
  border: solid 14px;
}

.joyride-tip-guide span.joyride-nub.top {
  /*
  IE7/IE8 Don't support rgba so we set the fallback
  border color here. However, IE7/IE8 are also buggy
  in that the fallback color doesn't work for
  border-bottom-color so here we set the border-color
  and override the top,left,right colors below.
  */
  border-color: #000;
  border-color: rgba(0,0,0,0.8);
  border-top-color: transparent !important;
  border-left-color: transparent !important;
  border-right-color: transparent !important;
  top: -28px;
  bottom: none;
}

.joyride-tip-guide span.joyride-nub.bottom {
  /*
  IE7/IE8 Don't support rgba so we set the fallback
  border color here. However, IE7/IE8 are also buggy
  in that the fallback color doesn't work for
  border-top-color so here we set the border-color
  and override the bottom,left,right colors below.
  */
  border-color: #000;
  border-color: rgba(0,0,0,0.8) !important;
  border-bottom-color: transparent !important;
  border-left-color: transparent !important;
  border-right-color: transparent !important;
  bottom: -28px;
  bottom: none;
}

.joyride-tip-guide span.joyride-nub.right {
  border-color: #000;
  border-color: rgba(0,0,0,0.8) !important;
  border-top-color: transparent !important;
  border-right-color: transparent !important;
  border-bottom-color: transparent !important;
  top: 111px;
  bottom: none;
  left: auto;
  right: -28px;
}

.joyride-tip-guide span.joyride-nub.left {
  border-color: #000;
  border-color: rgba(0,0,0,0.8) !important;
  border-top-color: transparent !important;
  border-left-color: transparent !important;
  border-bottom-color: transparent !important;
  top: 22px;
  left: -28px;
  right: auto;
  bottom: none;
}

.joyride-tip-guide span.joyride-nub.top-right {
  border-color: #000;
  border-color: rgba(0,0,0,0.8);
  border-top-color: transparent !important;
  border-left-color: transparent !important;
  border-right-color: transparent !important;
  top: -28px;
  bottom: none;
  left: auto;
  right: 28px;
}

/* Typography */
/*.joyride-tip-guide h1,.joyride-tip-guide h2,.joyride-tip-guide h3,.joyride-tip-guide h4,.joyride-tip-guide h5,.joyride-tip-guide h6 {
  line-height: 1.25;
  margin: 0;
  font-weight: bold;
  color: #fff;
}*/
.joyride-tip-guide h1 { font-size: 30px; }
.joyride-tip-guide h2 { font-size: 26px; }
.joyride-tip-guide h3 { font-size: 22px; }
.joyride-tip-guide h4 { font-size: 18px; }
.joyride-tip-guide h5 { font-size: 16px; }
.joyride-tip-guide h6 { font-size: 14px; }
.joyride-tip-guide p {
  margin: 0 0 18px 0;
  font-size: 14px;
  line-height: 18px;
}
.joyride-tip-guide a {
  color: rgb(255,255,255);
  text-decoration: none;
  border-bottom: dotted 1px rgba(255,255,255,0.6);
}
.joyride-tip-guide a:hover {
  color: rgba(255,255,255,0.8);
  border-bottom: none;
}

/* Button Style */
.joyride-tip-guide .joyride-next-tip {
  width: auto;
  padding: 6px 18px 4px;
  font-size: 13px;
  text-decoration: none;
  color: rgb(255,255,255);
  background: #6D2D56;
}

.joyride-next-tip:hover {
  color: rgb(255,255,255) !important;
}

.joyride-timer-indicator-wrap {
  width: 50px;
  height: 3px;
  border: solid 1px rgba(255,255,255,0.1);
  position: absolute;
  right: 17px;
  bottom: 16px;
}
.joyride-timer-indicator {
  display: block;
  width: 0;
  height: inherit;
  background: rgba(255,255,255,0.25);
}

.joyride-close-tip {
  position: absolute;
  right: 10px;
  top: 10px;
  color: rgba(255,255,255,0.4) !important;
  text-decoration: none;
  font-family: Verdana, sans-serif;
  font-size: 10px;
  font-weight: bold;
  border-bottom: none !important;
}

.joyride-close-tip:hover {
  color: rgba(255,255,255,0.9) !important;
}

.joyride-modal-bg {
  position: fixed;
  height: 100%;
  width: 100%;
  background: rgb(0,0,0);
  background: transparent;
  background: rgba(0,0,0, 0.5);
  -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
  filter: alpha(opacity=50);
  opacity: 0.5;
  z-index: 100;
  display: none;
  top: 0;
  left: 0;
  cursor: pointer;
}

.joyride-expose-wrapper {
    background-color: #ffffff;
    position: absolute;
    z-index: 102;
    -moz-box-shadow: 0px 0px 30px #ffffff;
    -webkit-box-shadow: 0px 0px 30px #ffffff;
    box-shadow: 0px 0px 30px #ffffff;
}

.joyride-expose-cover {
    background: transparent;
    position: absolute;
    z-index: 10000;
    top: 0px;
    left: 0px;
}

</style>

<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.joyride-2.1.js"></script>
    <script>
      $(window).load(function() {
        $('#joyRideTipContent').joyride({
          autoStart : true,
          modal:true,
          expose: true,
        });
      });
</script>