
<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'PublicarForm',
    //'type'=>'horizontal',
    'htmlOptions'=>array('class'=>'personaling_form'),
    //'type'=>'stacked',
    'type'=>'inline',
)); ?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3><?php echo Yii::t('contentForm','Publish Look'); ?></h3>
  </div>
  
      <div class="modal-body">
        <div class="control-group"> 
            <!--[if lte IE 7]>
            <label class="control-label required">Titulo del look <span class="required">*</span></label>
<![endif]-->
            <div class="controls">
                <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Titulo del look, ej.: Look de Verano Europeo" name="RegistrationForm[email]" class="span5">
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                <?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>45)); ?>
                <?php echo $form->error($model,'title'); ?>
            </div>
        </div>
        <div class="control-group"> 
            <!--[if lte IE 7]>
            <label class="control-label required">DescripciÃ³n del look <span class="required">*</span></label>
<![endif]-->
            <div class="controls">
            	
			<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($profile,'description'); ?>
            </div>
        </div>
        <hr/>
        <h4><?php echo Yii::t('contentForm','Select the type of user that favors'); ?></h4>
        <div class="control-group">
            <label class="control-label required">Condición Física:</label>
            <div class="controls">
            	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'contextura'));  ?>
                <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'size' => 'small',
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => Profile::rangeButtons($field->range),
				)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label required"><?php echo Yii::t('contentForm','Hair Color'); ?>:</label>
            <div class="controls">
            	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'pelo'));  ?>
                <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'size' => 'small',
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => Profile::rangeButtons($field->range),
				)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label required"><?php echo Yii::t('contentForm','Height'); ?>:</label>
            <div class="controls">
            	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'altura'));  ?>
                <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'size' => 'small',
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => Profile::rangeButtons($field->range),
				)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label required"><?php echo Yii::t('contentForm','Eye Color'); ?>:</label>
            <div class="controls">
            	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'ojos'));  ?>
                <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'size' => 'small',
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => Profile::rangeButtons($field->range),
				)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label required"><?php echo Yii::t('contentForm','Body Shape'); ?>:</label>
            <div class="controls">
            	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'tipo_cuerpo'));  ?>
                <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'size' => 'small',
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => Profile::rangeButtons($field->range),
				)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label required"><?php echo Yii::t('contentForm','Skin Color'); ?>:</label>
            <div class="controls">
            	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'piel'));  ?>
                <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'size' => 'small',
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => Profile::rangeButtons($field->range),
				)); ?>
            </div>
        </div>
        <hr/>
        <div class="control-group">
            <div class="controls">
                <?php echo $form->radioButtonListInlineRow($model, 'tipo', array(
        'Atrevida',
        'Conservador',
    )); ?>
                <div class=" muted" style="display:none"><?php echo Yii::t('contentForm','Help'); ?></div>
            </div>
        </div>
    </div>
  <div class="modal-footer"> <a href="#" title="Cancelar" data-dismiss="modal" class="btn btn-link"> <?php echo Yii::t('contentForm','Cancel'); ?></a> <a href="Look_seleccionado.php" title="Publicar" class="btn btn-danger" ><?php echo Yii::t('contentForm','Publish'); ?></a> </div>
  <?php $this->endWidget(); ?>
