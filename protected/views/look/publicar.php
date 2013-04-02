<?php
$this->breadcrumbs=array(
	'Looks'=>array('admin'),
	'Publicar',
);

?>
<div class="container margin_top" id="crear_look">
  <div class="page-header">
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
    <h1>Publicar Look</h1>
  </div>
  <div class="row">
    <section class="span6">
    	 
    	<?php echo CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$model->id)), "Look", array("width" => "450", "height" => "226", 'class'=>'img_1')); ?>
      <?php if (Yii::app()->user->isAdmin()){ ?>
      <!-- Tabla  para el admin ON -->
      <hr/>
      <h4>Productos que componen el Look </h4>
      <table width="100%" class="table">
        <thead>
          <tr>
            <th colspan="2">Producto</th>
            <th>Cantidad</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><img class="margin_bottom" src="http://placehold.it/70x70"></td>
            <td><strong>Vestido Stradivarius</strong></td>
            <td width="8%"><input type="text" class="span1" value="10" placeholder="Cant." maxlength="2">
              <a class="btn btn-mini" href="#">Actualizar</a></td>
          </tr>
          <tr>
            <td><img class="margin_bottom" src="http://placehold.it/70x70"></td>
            <td><strong>Camisa The New Pornographers</strong></td>
            <td><input type="text" class="span1" value="0" placeholder="Cant." maxlength="2">
              <a class="btn btn-mini" href="#">Actualizar</a></td>
          </tr>
          <tr>
            <td><img class="margin_bottom" src="http://placehold.it/70x70"></td>
            <td><strong>Pantalón Ok Go</strong></td>
            <td><input type="text" class="span1" value="5" placeholder="Cant." maxlength="2">
              <a class="btn btn-mini" href="#">Actualizar</a></td>
          </tr>
        </tbody>
      </table>
      
      <!-- Tabla  para el admin OFF --> 
      <?php } ?>
    </section>
    <section class="span6 ">
      
<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'PublicarForm',
    //'type'=>'horizontal',
    'htmlOptions'=>array('class'=>'well personaling_form'),
    //'type'=>'stacked',
    'type'=>'inline',
    'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>      	
        <legend>Ultimo paso</legend>
        <p>LLena los siguientes campos:</p>
        <div class="control-group"> 
          <!--[if lte IE 7]>
            <label class="control-label required">Titulo del look <span class="required">*</span></label>
<![endif]-->
          <div class="controls">
             <?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>45)); ?>
             <?php echo $form->error($model,'title'); ?>
          </div>
        </div>
        <div class="control-group"> 
          <!--[if lte IE 7]>
            <label class="control-label required">Descripción del look <span class="required">*</span></label>
<![endif]-->
          <div class="controls">
			<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
			<?php echo $form->error($model,'description'); ?>
          </div>
        </div>
        <?php if (Yii::app()->user->isAdmin()){ ?>
        <!-- Para el admin ON -->
        
        <div class="control-group ">
          <div class="controls">
            <label class="checkbox">
              <input type="checkbox" value="option1">
              Se publicara con fecha de Inicio y fin </label>
          </div>
        </div>
        <div class="control-group margin_top">
          <div class="controls controls-row">
            <div class="span1">Inicio </div>
            <select placeholder=".span4" type="text" class="span1">
              <option>Dia</option>
              <option>01</option>
              <option>02</option>
            </select>
            <select placeholder=".span4" type="text" class="span1">
              <option>Mes</option>
              <option>01</option>
              <option>02</option>
            </select>
            <select placeholder=".span4" type="text" class="span1">
              <option>Año</option>
              <option>01</option>
              <option>02</option>
            </select>
          </div>
        </div>
        <div class="control-group">
          <div class="controls controls-row">
            <div class="span1">Fin </div>
            <select placeholder=".span4" type="text" class="span1">
              <option>Dia</option>
              <option>01</option>
              <option>02</option>
            </select>
            <select placeholder=".span4" type="text" class="span1">
              <option>Mes</option>
              <option>01</option>
              <option>02</option>
            </select>
            <select placeholder=".span4" type="text" class="span1">
              <option>Año</option>
              <option>01</option>
              <option>02</option>
            </select>
          </div>
        </div>
        <!-- Para el admin OFF -->
        <?php  } ?>
        <hr/>
        <div id="div_ocasiones">
        <h4>¿En que ocasión se puede usar este look?</h4>
        <?php $categorias = Categoria::model()->findAllByAttributes(array('padreId'=>'2')); ?>
        <?php 
        
        if(count($categorias))
				foreach($categorias as $categoria){
					
		?>
        <div class="control-group">
          <label class="control-label required"><?php echo $categoria->nombre; ?>:</label>
          <div class="controls">
            <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'size' => 'small',
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => $categoria->childrenButtons($model->getCategorias()),
				)); ?>
				
          </div>
        </div>
        <?php
				}
        ?>
        <?php echo CHtml::hiddenField('categorias'); ?>
        </div>
        <hr/>
        <h4> ¿Que estilo se adapta a este look: atrevido/ conservador?</h4>
        
        <div class="control-group">
          <div class="controls">
            <!--
            <label class="checkbox inline">
              <input type="checkbox" value="option1">
              Atrevido </label>
            <label class="checkbox inline">
              <input type="checkbox" value="option2">
              Conservador </label>
            <div class=" muted" style="display:none">Ayuda</div>
            -->
             <?php echo $form->radioButtonListInlineRow($model, 'tipo', array(
			        1=>'Atrevida',
			        2=>'Conservador',
			    )); ?> 
          </div>
        </div>
        <hr/>
        <div id="div_tipo">
        <h4>Escoge al tipo de usuaria que favorece</h4>
        <div class="control-group">
          <label class="control-label required">Condición Física:</label>
          <div class="controls">
            	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'contextura'));  ?>
                <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'size' => 'small',
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => Profile::rangeButtons($field->range,$model->contextura),
				)); ?>
				<?php echo $form->hiddenField($model,'contextura'); ?>
				<?php echo $form->error($model,'contextura'); ?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label required">Color de Cabello:</label>
          <div class="controls">
          		
            	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'pelo'));  ?>
                <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'size' => 'small',
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => Profile::rangeButtons($field->range,$model->pelo),
				)); ?>
				<?php echo $form->hiddenField($model,'pelo'); ?>
				<?php echo $form->error($model,'pelo'); ?>
				
          </div>
        </div>
        <div class="control-group">
          <label class="control-label required">Altura:</label>
          <div class="controls">
            	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'altura'));  ?>
                <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'size' => 'small',
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => Profile::rangeButtons($field->range,$model->altura),
				)); ?>
				<?php echo $form->hiddenField($model,'altura'); ?>
				<?php echo $form->error($model,'altura'); ?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label required">Color de Ojos:</label>
          <div class="controls">
            	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'ojos'));  ?>
                <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'size' => 'small',
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => Profile::rangeButtons($field->range,$model->ojos),
				)); ?>
				<?php echo $form->hiddenField($model,'ojos'); ?>
				<?php echo $form->error($model,'ojos'); ?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label required">Forma de Cuerpo :</label>
          <div class="controls">
            	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'tipo_cuerpo'));  ?>
                <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'size' => 'small',
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => Profile::rangeButtons($field->range,$model->tipo_cuerpo),
				)); ?>
				<?php echo $form->hiddenField($model,'tipo_cuerpo'); ?>
				<?php echo $form->error($model,'tipo_cuerpo'); ?>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label required">Color de Piel:</label>
          <div class="controls">
            	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'piel'));  ?>
                <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
				    'size' => 'small',
				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
				    'buttons' => Profile::rangeButtons($field->range,$model->piel),
				)); ?>
				<?php echo $form->hiddenField($model,'piel'); ?>
				<?php echo $form->error($model,'piel'); ?>
				
          </div>
        </div>
        </div>
        <div class="form-actions"> 
        	<a href="#" title="Cancelar" data-dismiss="modal" class="btn btn-link"> Cancelar</a> 
        	
        	<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
			    'label'=>'Publicar Look',
			    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			    'size'=>'large', // null, 'large', 'small' or 'mini'
			)); ?>
        </div>
     <?php $this->endWidget(); ?>
      <!------------------- MODAL WINDOW OFF -----------------> 
      
    </section>
  </div>
</div>
<?php 
$script = "
	$('#div_ocasiones').on('click', 'a', function(e) {
		 
		 var ids = '';
		 var selected = $(this).attr('href');
		 $('#div_ocasiones .active').each(function(){
		 	if (selected != $(this).attr('href'))
		 		ids += $(this).attr('href');
			
		 });
		// alert($(this).hasClass('active'));
		// alert(ids);
		 if (!($(this).hasClass('active')))
		 	ids += $(this).attr('href');
		// alert(ids);
		 $('#categorias').val(ids.substring(1));
		 //return false;
		 e.preventDefault();
	 });
	$('#div_tipo .btn-group').on('click', 'a', function(e) {
		 //alert($(this).attr('href'));
		 var ids = 0;
		 $(this).siblings('.active').each(function(){
		 	//alert($(this).attr('href').substring(1));
		 	ids += parseInt($(this).attr('href').substring(1));
			
		 });
		 if (!($(this).hasClass('active')))
		 	ids += parseInt($(this).attr('href').substring(1));
		
		 $(this).parent().next('input').val(ids);
		 //return false;
		 e.preventDefault();
	 });
";
?>
<?php Yii::app()->clientScript->registerScript('botones',$script); ?>

