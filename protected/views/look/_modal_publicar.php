
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
    <h3>Publicar look</h3>
  </div>
  
      <div class="modal-body">
        <div class="control-group"> 
            <!--[if lte IE 7]>
            <label class="control-label required">Titulo del look <span class="required">*</span></label>
<![endif]-->
            <div class="controls">
                <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Titulo del look, ej.: Look de Verano Europeo" name="RegistrationForm[email]" class="span5">
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
            </div>
        </div>
        <div class="control-group"> 
            <!--[if lte IE 7]>
            <label class="control-label required">DescripciÃ³n del look <span class="required">*</span></label>
<![endif]-->
            <div class="controls">
                <textarea class="span5" placeholder="DescripciÃ³n del look"></textarea>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
            </div>
        </div>
        <hr/>
        <h4>Escoge al tipo de usuaria que favorece</h4>
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
            <label class="control-label required">Color de Cabello:</label>
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
            <label class="control-label required">Altura:</label>
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
            <label class="control-label required">Color de Ojos:</label>
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
            <label class="control-label required">Forma de Cuerpo :</label>
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
            <label class="control-label required">Color de Piel:</label>
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
                <div class=" muted" style="display:none">Ayuda</div>
            </div>
        </div>
    </div>
  <div class="modal-footer"> <a href="#" title="Cancelar" data-dismiss="modal" class="btn btn-link"> Cancelar</a> <a href="Look_seleccionado.php" title="Publicar" class="btn btn-danger" >Publicar</a> </div>
  <?php $this->endWidget(); ?>
