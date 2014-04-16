<?php Yii::app()->clientScript->registerLinkTag('stylesheet','text/css','https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700',null,null);
 ?>
<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>
<div class="container margin_top">
	<?php if(Yii::app()->user->hasFlash('error')): ?>

<div class="alert alert-error text_align_center">
	<?php echo Yii::app()->user->getFlash('error'); ?>
</div>

<?php endif; ?>

<div class="progreso_compra">
      <div class="clearfix margin_bottom">
        <div class="first-done"><?php echo Yii::t('contentForm','Authentication'); ?></div>
        <div class="middle-not_done"><?php echo Yii::t('contentForm','Shipping <br/>and billing<br/> address'); ?></div>
        <div class="middle-not_done"><?php echo Yii::t('contentForm','Payment <br> method'); ?></div>
        <div class="last-not_done"><?php echo Yii::t('contentForm','Confirm <br>purchase'); ?></div>
      </div>
  </div>


	
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
    <div class="span6 offset3">

      <article class="bg_color3 margin_top text_align_center margin_bottom_small padding_small box_1">
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'login-form',
			'htmlOptions'=>array('class'=>'personaling_form'),
		    //'type'=>'stacked',
		    'type'=>'inline',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true, 
			),
		)); ?>
          <fieldset>
            <legend > <?php echo Yii::t('contentForm','Confirm your credentials'); ?>: </legend>
            
            <div class="control-group">
            	 <div class="controls"> 
            		<?php echo $form->textFieldRow($model,'username',array("class"=>"span5","value"=>Yii::app()->user->name,'readonly'=>true)); ?>
            		<?php echo $form->error($model,'username'); ?>
            	</div>  
            </div>
             <div class="control-group"> 
             	<div class="controls">
            		<?php echo $form->passwordFieldRow($model,'password',array(
            			'class'=>'span5',
            			'value'=>'',
        				'hint'=>'Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>',
    				)); ?>
    				<?php echo $form->error($model,'password'); ?>
    			</div>
    		</div>
            <?php //echo $form->checkBoxRow($model,'rememberMe'); ?>
            
            
        <div class="">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'danger',
            'size'=>'large',
            'label'=>Yii::t('contentForm','Next'),
            'htmlOptions'=>array('class'=>'span5'),
        )); ?>
	</div>
          </fieldset>
        <?php $this->endWidget(); ?>
      </article>
    </div>
  </div>
</div>
