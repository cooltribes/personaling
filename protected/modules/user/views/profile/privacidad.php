<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Edita tu Privacidad");
$this->breadcrumbs=array(
	UserModule::t("Tu Cuenta")=>array('micuenta'),
	UserModule::t("Privacidad"),
);
?>
<div class="container margin_top tu_perfil">
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
  <div class="row">
   <!-- SIDEBAR ON -->
  <aside class="span3"> <?php echo $this->renderPartial('_sidebar'); ?> </aside>
  <!-- SIDEBAR ON --> 
    <div class="span9">
      <h1>Edita tu Privacidad</h1>
      <article class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'privacidad-form',
	'htmlOptions'=>array('class'=>'personaling_form'),
    //'type'=>'stacked',
    'type'=>'stacked',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
          <fieldset>
            <legend >Información de tu Cuenta </legend>
            <p>Los siguientes campos marcados están públicamente abiertos:</p>
            <div class="margin_left_medium">
              <?php $select = array(
              User::PRIVACIDAD_DATOS_BASICOS=>(User::PRIVACIDAD_DATOS_BASICOS&$model->privacy),
              User::PRIVACIDAD_AVATAR=>(User::PRIVACIDAD_AVATAR & $model->privacy),
              User::PRIVACIDAD_LOOKS=>(User::PRIVACIDAD_LOOKS & $model->privacy),
              User::PRIVACIDAD_SHOPPERS=>(User::PRIVACIDAD_SHOPPERS & $model->privacy),
  			       ); 
  			//print_r($model);
  			//print_r($select); ?>
              <?php echo CHtml::checkBoxList('privacidad',$select,array(
  	            User::PRIVACIDAD_DATOS_BASICOS=>'Nombre y Apellidos',
  	            User::PRIVACIDAD_AVATAR=>'Imagen de tu Perfil',
  	            User::PRIVACIDAD_LOOKS=>'Looks que te encantan',
  	            User::PRIVACIDAD_SHOPPERS=>'Personal Shopper que sigues',
  				)
  			); ?>
             
              
            </div>
            <div class="form-actions">
                   <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label'=> 'Guardar',
                'buttonType' => 'submit',
                'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'size'=>'large', // null, 'large', 'small' or 'mini'
                )); ?>
          </div>
          </fieldset>
          
          
       <?php $this->endWidget(); ?>
      </article>
    </div>
  </div>
</div>