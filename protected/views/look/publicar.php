<?php
$this->breadcrumbs=array(
	'Looks'=>array('admin'),
	'Publicar',
);
$disabled = (($model->status == Look::STATUS_ENVIADO || $model->status == Look::STATUS_APROBADO) && !Yii::app()->user->isAdmin())
?>

<script>
  $(function() {
    $( "#slider" ).slider({
      range: true,
      min: 10, 
      max: 85,
      <?php if(is_null($model->edadMin)){
      		$model->edadMin=20;
			 $model->edadMax=45;
      }
      ?>
      values: [ parseInt(<?php echo $model->edadMin ?>) , parseInt(<?php echo $model->edadMax;?>) ],
      slide: function( event, ui ) {
        $( "#edad" ).html( "De " + ui.values[ 0 ] + " a " + ui.values[ 1 ]+" Años" );
        $('#Look_edadMin').val(ui.values[ 0 ]); 
        $('#Look_edadMax').val(ui.values[ 1 ]);  
        
      
        
      }
    });
    $( "#edad" ).html( "De " + $( "#slider" ).slider( "values", 0 ) +
      " a " + $( "#slider" ).slider( "values", 1 )+" Años" );
  });
 </script> 
 <style>
 	 #slider .ui-slider-range { background: #6d2d56; }
 </style>
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
    <?php echo CHtml::image(Yii::app()->baseUrl .'/images/loading.gif','Loading',array('class'=>'imgloading','id'=>"imgloading".$model->id)); ?>	 
    <?php echo CHtml::image(Yii::app()->createUrl('look/getImage',array('id'=>$model->id)), "Look", array("style"=>"display: none","id" => "imglook".$model->id,"width" => "450", "height" => "226", 'class'=>'img_1')); ?>
  <?php
  $script = "
							var load_handler = function() {
							    $('#imgloading".$model->id."').hide();
							    $(this).show();
							}
							$('#"."imglook".$model->id."').filter(function() {
							    return this.complete;
							}).each(load_handler).end().load(load_handler);						 
						 ";		
						 	Yii::app()->clientScript->registerScript('img_ps_script'.$model->id,$script);   
?>  
      <?php if (Yii::app()->user->isAdmin()){ ?>
      <!-- Tabla  para el admin ON -->
      <hr/>
      <h4>Productos que componen el Look </h4>
      <table width="100%" class="table">
        <thead>
          <tr>
            <th colspan="2">Producto</th>
           <!-- <th>Cantidad</th> -->
          </tr>
        </thead>
        <tbody>
        	<?php
 			if (count($model->lookhasproducto)):
        		foreach($model->lookhasproducto as $hasproducto):
              		$producto = $hasproducto->producto;     
			?>   	
          <tr>
            <td>
            	 
            	<?php
					/*
					if ($producto->mainimage)
					$image = CHtml::image(Yii::app()->baseUrl . $producto->mainimage->url, "Imagen", array("width" => 70, "height" => 70));
					else 
					$image = CHtml::image("http://placehold.it/180");	
					echo $image;
					*/
					echo CHtml::image($producto->getImageUrl($hasproducto->color_id), "Imagen", array("width" => "70", "height" => "70"));
				?>
            	
            </td>
            <td><strong><?php echo $producto->nombre; ?></strong></td>
            <!--
            <td width="8%"><input type="text" class="span1" value="10" placeholder="Cant." maxlength="2">
              <a class="btn btn-mini" href="#">Actualizar</a></td>
             -->
          </tr>
          <?php
          		endforeach;
			endif;
          ?>
          
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
    'htmlOptions'=>array('class'=>' personaling_form'),
    //'type'=>'stacked',
    'type'=>'inline',
    'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>      	
        <legend class="lead">Ultimo paso</legend>
        <section class="well">
          <h4><strong>1.</strong> Completa los siguientes campos:</h4>
          <!-- <p>LLena los siguientes campos:</p> -->
          <div class="control-group"> 
            <!--[if lte IE 7]>
              <label class="control-label required">Titulo del look <span class="required">*</span></label>
  <![endif]-->
  		¿Qué nombre le pondrías a este look? 
            <div class="controls">
               <?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>45,'disabled'=>$disabled)); ?>
               <?php echo $form->error($model,'title'); ?>
            </div>
          </div>
          <div class="control-group"> 
            <!--[if lte IE 7]>
              <label class="control-label required">Descripción del look <span class="required">*</span></label>
  <![endif]-->
           Escribe una descripción para este look
            <div class="controls">
  			<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50,'class'=>'span5','disabled'=>$disabled)); ?>
  			<?php echo $form->error($model,'description'); ?>
            </div>
          </div>
          <?php if (Yii::app()->user->isAdmin()){ ?>
          <div class="control-group ">
            <div class="controls">
               <?php echo $form->checkBoxRow($model, 'destacado'); ?>
               <?php echo $form->error($model,'destacado'); ?>
            </div>
          </div>
          
           <div class="control-group ">
           	Escribe una url amigable para este look. 
            <div class="controls">
               <?php echo $form->textFieldRow($model, 'url_amigable'); ?>
               <?php echo $form->error($model, 'url_amigable'); ?>
            </div>
          </div>  
                  
          <!-- Para el admin ON 
          

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
          
           Para el admin OFF -->
          <?php  } ?>
          

        </section>

        <section class="well">
          <h4><strong>2.</strong> ¿En que ocasión se puede usar este look?</h4>
          <div id="div_ocasiones">
          <?php $categorias = Categoria::model()->findAllByAttributes(array('padreId'=>'2')); ?>
          <?php echo $form->hiddenField($model,'has_ocasiones'); ?>
          <?php echo $form->error($model, 'has_ocasiones'); ?>
          <?php 
          
          if(count($categorias))
  				foreach($categorias as $categoria){
  					
  		?>
          <div class="control-group">
          	
          	<?php echo CHtml::checkBox($categoria->nombre,false,array('class'=>'select_todos_ocasiones', 'disabled'=>$disabled));  ?>
            <label class="control-label required"><?php echo $categoria->nombre; ?>:</label>
            <div class="controls">
              <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
  				    'size' => 'small',
              		'type' => '',
  				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
  				    'buttons' => $categoria->childrenButtons($model->getCategorias(),$disabled),
  				)); ?>
  				
            </div>
          </div>
          <?php
  				}
          ?>
          <?php echo CHtml::hiddenField('categorias',$model->has_ocasiones); ?>
          </div>
          <hr/>
          <h4> ¿Que estilo se adapta a este look?</h4>
          
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
  			    ),array('disabled'=>$disabled)); ?> 
            </div>
          </div>
          <hr/>
          
          
          <h4> ¿A chicas de que edad va dirigido este look?</h4>
          
          <div class="control-group">
            <div class="controls">
              	<p>
				  <div id="edad" style="border:0; font-weight:bold; background:none;"></div>
				</p>
				<?php
					echo $form->hiddenField($model,'edadMin'); 
					echo $form->hiddenField($model,'edadMax'); 
				?>
              	<div id="slider"></div>
            </div>
          </div>
          <hr/>
          
          
          <div id="div_tipo">
          <h4>Escoge al tipo de usuaria que favorece</h4>
          <div class="control-group">
          	
          	<?php echo CHtml::checkBox('contextura',false,array('class'=>'select_todos', 'disabled'=>$disabled));  ?>
            <label class="control-label required">¿A qué tipo de cuerpo le favorece más?</label>
            <div class="controls">
              	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'contextura'));  ?>
                  <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
  				    'size' => 'small',
              'type' => '',
  				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
  				    'buttons' => Profile::rangeButtons($field->range,$model->contextura,$disabled),
  				)); ?>
  				<?php echo $form->hiddenField($model,'contextura'); ?>
  				<?php echo $form->error($model,'contextura'); ?>
            </div>
          </div>
          <div class="control-group">
          	<?php echo CHtml::checkBox('pelo',false,array('class'=>'select_todos', 'disabled'=>$disabled));  ?>
            <label class="control-label required">¿Con qué color de cabello quedaría mejor?</label>
            <div class="controls">
            		
              	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'pelo'));  ?>
                  <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
  				    'size' => 'small',
              'type' => '',
  				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
  				    'buttons' => Profile::rangeButtons($field->range,$model->pelo,$disabled),
  				)); ?>
  				<?php echo $form->hiddenField($model,'pelo'); ?>
  				<?php echo $form->error($model,'pelo'); ?>
  				
            </div>
          </div>
          <div class="control-group">
          	<?php echo CHtml::checkBox('altura',false,array('class'=>'select_todos', 'disabled'=>$disabled));  ?>
            <label class="control-label required">¿Cuánto debe medir la mujer que use este look?</label>
            <div class="controls">
              	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'altura'));  ?>
                  <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
  				    'size' => 'small',
              'type' => '',
  				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
  				    'buttons' => Profile::rangeButtons($field->range,$model->altura,$disabled),
  				)); ?>
  				<?php echo $form->hiddenField($model,'altura'); ?>
  				<?php echo $form->error($model,'altura'); ?>
            </div>
          </div>
          <div class="control-group">
          	<?php echo CHtml::checkBox('ojos',false,array('class'=>'select_todos', 'disabled'=>$disabled));  ?>
            <label class="control-label required">¿Con qué color de ojos queda mejor?</label>
            <div class="controls">
              	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'ojos'));  ?>
                  <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
  				    'size' => 'small',
              'type' => '',
  				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
  				    'buttons' => Profile::rangeButtons($field->range,$model->ojos,$disabled),
  				)); ?>
  				<?php echo $form->hiddenField($model,'ojos'); ?>
  				<?php echo $form->error($model,'ojos'); ?>
            </div>
          </div>
          <div class="control-group">
          	<?php echo CHtml::checkBox('tipo_cuerpo',false,array('class'=>'select_todos', 'disabled'=>$disabled));  ?>
            <label class="control-label required">¿Qué tipo de cuerpo debería usarlo?</label>
            <div class="controls">
              	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'tipo_cuerpo'));  ?>
                  <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
  				    'size' => 'small',
              'type' => '',
  				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
  				    'buttons' => Profile::rangeButtons($field->range,$model->tipo_cuerpo,$disabled),
  				)); ?>
  				<?php echo $form->hiddenField($model,'tipo_cuerpo'); ?>
  				<?php echo $form->error($model,'tipo_cuerpo'); ?>
            </div>
          </div>
          <div class="control-group">
          	<?php echo CHtml::checkBox('piel',false,array('class'=>'select_todos', 'disabled'=>$disabled));  ?>
            <label class="control-label required">¿Qué color de piel se adapta mejor a este look?</label>
            <div class="controls">
              	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'piel'));  ?>
                  <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
  				    'size' => 'small',
              'type' => '',
  				    'toggle' => 'checkbox', // 'checkbox' or 'radio'
  				    'buttons' => Profile::rangeButtons($field->range,$model->piel,$disabled),
  				)); ?>
  				<?php echo $form->hiddenField($model,'piel'); ?>
  				<?php echo $form->error($model,'piel'); ?>
  				
            </div>
          </div>
          </div>
        
        </section >
        <section class="well">
              <?php if ($model->status == Look::STATUS_CREADO || Yii::app()->user->isAdmin()){ ?>
              	<h4><strong>3.</strong> Terminaste, solo presiona enviar  </h4>
      
          <div class="row">
            <div class="pull-right"> 
            	<a href="#" title="Cancelar" data-dismiss="modal" class="btn btn-link"> Cancelar</a> 
            	
            	<?php $this->widget('bootstrap.widgets.TbButton', array(
    				'buttonType'=>'submit',
    			    'label'=>Yii::app()->user->isAdmin()?'Aprobar':'Enviar',
    			    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    			    'size'=>'large', // null, 'large', 'small' or 'mini'
    			)); ?>
            </div> 
          </div>
        </section>
        
        <?php } ?>
         <?php if ($model->status == Look::STATUS_ENVIADO && !Yii::app()->user->isAdmin()){ ?>
         	Tu look esta pendiente por aprobar, Gracias
         	<script>$('#slider').hide();</script>
         <?php } ?>
        
     <?php $this->endWidget(); ?>
      <!------------------- MODAL WINDOW OFF -----------------> 
      
    </section>
  </div>
</div>
<?php 
$script = "
	$('.select_todos_ocasiones').on('click',function(e){
		if ($(this).is(':checked')){
			$(this).parent().find('.btn').addClass('active');
		}
		else {
			$(this).parent().find('.btn').removeClass('active');
		}
		var ids = '';
		$('#div_ocasiones .active').each(function(){
			ids += $(this).attr('href');
		});
		//alert(ids);
		$('#categorias').val(ids.substring(1));
		$('#Look_has_ocasiones').val(ids.substring(1));			
	});
	
	$('.select_todos').on('click',function(e){
		if ($(this).is(':checked')){
			$(this).parent().find('.btn').addClass('active');
			 var ids = 0;
			$(this).parent().find('.btn').each(function(index){
				ids += parseInt($(this).attr('href').substring(1));
			});
			$(this).parent().find('.btn').parent().next('input').val(ids);
			
		}
		else {
			$(this).parent().find('.btn').removeClass('active');
			$(this).parent().find('.btn').parent().next('input').val(0);
			
		}
	});
	
	$('#div_ocasiones').on('click', 'a', function(e) {
		 
		 var ids = '';
		 var selected = $(this).attr('href');
		 $('#div_ocasiones .active').each(function(){
		 	if (selected != $(this).attr('href'))
		 		ids += $(this).attr('href');
		 });
		 if (!($(this).hasClass('active')))
		 	ids += $(this).attr('href');
		 $('#categorias').val(ids.substring(1));
		 $('#Look_has_ocasiones').val(ids.substring(1));
		 e.preventDefault();
	 });
	 
	$('#div_tipo .btn-group').on('click', 'a', function(e) {
		 var ids = 0;
		 $(this).siblings('.active').each(function(){
		 	ids += parseInt($(this).attr('href').substring(1));
		 });
		 if (!($(this).hasClass('active')))
		 	ids += parseInt($(this).attr('href').substring(1));
		 $(this).parent().next('input').val(ids);
		 e.preventDefault();
	 });
";
?>
<?php Yii::app()->clientScript->registerScript('botones',$script); ?>

