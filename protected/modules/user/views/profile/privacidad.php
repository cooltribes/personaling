<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Tu Cuenta")=>array('micuenta'),
	UserModule::t("Privacidad"),
);
?>
<div class="container margin_top">
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
  <!-- SUBMENU ON -->
  <?php $this->renderPartial("_menu"); ?>
  <!-- SUBMENU OFF -->
  <div class="row">
    <div class="span6 offset3">
      <h1>Privacidad</h1>
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
            <legend >Informacion de tu Cuenta </legend>
            <p>Los siguientes campos marcados estan publicamente abiertos:</p>
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
           
            
            <div class="form-actions"> <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label'=> 'Guardar',
    		'buttonType' => 'submit',
    		'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    		'size'=>'large', // null, 'large', 'small' or 'mini'
)); ?> </div>
          </fieldset>
          
          
       <?php $this->endWidget(); ?>
      </article>
    </div>
  </div>
</div>