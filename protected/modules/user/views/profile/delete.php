<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Mi cuenta")=>array('micuenta'),
	UserModule::t("Eliminar"),
);
?>
<div class="container margin_top"> 
  <!-- SUBMENU ON -->
   <?php $this->renderPartial("_menu"); ?>
  <!-- SUBMENU OFF -->
  <div class="row">
    <div class="span6 offset3">
      <h1>Eliminar Cuenta</h1>
      <article class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
       <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'delete-form',
	'htmlOptions'=>array('class'=>'personaling_form'),
    //'type'=>'stacked',
    'type'=>'stacked',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
          
          
          <fieldset>
            <legend >Al borrar tu Cuenta de Personaling,  estas aceptando los siguientes apartados:</legend>
            <ul>
            	
<li>Borrar tu Cuenta sera algo PERMANENTE.
</li><li>Toda la informacion almacenada en tu Cuenta se borrara inmediatamente </li>



            </ul>
            <label class="checkbox">
              <input type="checkbox" value="">
              <?php echo CHtml::checkBox('acepto',false); ?>
              Acepto los Terminos & Condiciones y acepto ELIMINAR mi Cuenta PERMANENTEMENTE. </label>
      		<?php 
      		Yii::app()->clientScript->registerScript('check_acepto',"
				  
				   $('#btn_borrar').click(function(){
				   		
				   		if ($('#acepto').is(':checked')) {
   							$('#delete-form').submit();
						} else {
    						alert('No puedes eliminar la cuenta sin aceptar los terminos y condiciones');
						} 
				   });
				   
				",CClientScript::POS_READY);
			?>
            
            <div class="form-actions"> <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label'=> 'Borrar Cuenta',
    		'buttonType' => 'button',
    		'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    		'size'=>'large', // null, 'large', 'small' or 'mini'
    		'htmlOptions' => array('id'=>'btn_borrar'),
)); ?> 
</div>
          </fieldset>
        <?php $this->endWidget(); ?>
      </article>
    </div>
  </div>
</div>
<!-- /container -->
