<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>
<div class="container margin_top">
  <div class="row">
    <div class="span6 offset3">
     <!-- MENU ON -->
     <ul class="nav nav-pills margin_top">
        <li class="active"> 
        	<?php echo CHtml::link('Datos Personales',array('user/profile/edit')); ?>
        </li>
        <li>
        	<?php echo CHtml::link('Avatar',array('user/profile/avatar')); ?>
        	
        </li>
        <li>
        	<?php echo CHtml::link('Avatar',array('user/profile/edittutipo')); ?>
        	
        </li>
      </ul>
     <!-- MENU OFF -->
      <h1>Tu personaling | Tu perfil</h1>

      <article class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
        
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'avatar-form',
			'htmlOptions'=>array('class'=>'personaling_form','enctype'=>"multipart/form-data"),
		    //'type'=>'stacked',
		    'type'=>'inline',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>        	
          <fieldset>
            <legend >Avatar: </legend>
            
            <div class="row">
            <div class="span2"><img src="http://placehold.it/150x150"/></div>
            <div class="span3 margin_top"><a href="#" class="btn">Aqui va el plugin del uploader</a></div>
            
            </div>
            
            
            
            
            
            <div class="form-actions"> 
            	 <?php $this->widget('bootstrap.widgets.TbButton', array(
            				'buttonType' => 'submit',
						    'label'=>'Guardar',
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