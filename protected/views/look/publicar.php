<?php
$this->breadcrumbs=array(
	'Looks'=>array('mislooks'),
	'Publicar',
);
$disabled = (($model->status == Look::STATUS_ENVIADO || $model->status == Look::STATUS_APROBADO) && !Yii::app()->user->isAdmin());
$all = array();
$all[0]['label'] = 'Todos';
$all[0]['url'] = '#todos';
$all[0]['htmlOptions'] = array('class'=>"select_todos");
$all[0]['active']=false;
?>

<script>
  $(function() {
    $( "#slider" ).slider({
      range: true,
      min: 10, 
      max: 85,
      <?php if(is_null($model->edadMin))
      			$model->edadMin=20;
			if(is_null($model->edadMax))
			 	$model->edadMax=45;
      
	  
      ?>
      values: [ parseInt(<?php echo $model->edadMin ?>) , parseInt(<?php echo $model->edadMax?>) ],
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
div.infoBanner {
    display: block;
    border: 1px solid #DDD;  
    padding: 9px 8px;
    font-size: 1.2em;
    text-align: center;
}

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
    <h1><?php echo Yii::t('contentForm','Publish Look'); ?></h1>
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
      <h4><?php echo Yii::t('contentForm','Products that make the Looks'); ?></h4>
      <table width="100%" class="table">
        <thead>
          <tr>
            <th colspan="2"><?php echo Yii::t('contentForm','Product'); ?></th>
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
		'afterValidate'=>"js:function(form, data, hasError) {
				
				}"
	),
)); ?>      	
        
        <legend class="lead"><?php echo Yii::t('contentForm','Last step'); ?></legend>
        <div class="infoBanner margin_bottom_small">
           Completa la información de tu look. <br>
           ¡Mientras más información contenga más fácil se venderá!
        </div>
        <section class="well">
          <h4><strong>1.</strong><?php echo Yii::t('contentForm','Complete the following fields:'); ?></h4>
          <!-- <p>LLena los siguientes campos:</p> -->
          <div class="control-group"> 
            <!--[if lte IE 7]>
              <label class="control-label required">Titulo del look <span class="required">*</span></label>
  <![endif]-->
  		<?php echo Yii::t('contentForm','What name would you give this Look?'); ?>
            <div class="controls">
               <?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>45,'disabled'=>$disabled)); ?>
               <?php echo $form->error($model,'title'); ?>
            </div>
          </div>
          <div class="control-group"> 
            <!--[if lte IE 7]>
              <label class="control-label required">Descripción del look <span class="required">*</span></label>
  <![endif]-->
      <?php echo Yii::t('contentForm','Type a description for this look'); ?>
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
      <?php echo Yii::t('contentForm','Write a friendly URL to this look.'); ?>
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
          <h4><strong>2.</strong> <?php echo Yii::t('contentForm','In which occasion you think this Look could be used?'); ?></h4>
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
          <h4><?php echo Yii::t('contentForm','What style suits this Look?'); ?></h4>
          
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
  			    <div style="display:none" id="radioError" class="help-block error">Debes elegir un estilo para este look</div>
            </div>
          </div>
          <hr/>
          
          
          <h4><?php echo Yii::t('contentForm','To what age girls should focus this clothes?'); ?></h4>
          
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
          <h4><?php echo Yii::t('contentForm','Select the type of user that favors'); ?></h4>
          <div class="control-group">
          	
          	<?php //echo CHtml::checkBox('contextura',false,array('class'=>'select_todos', 'disabled'=>$disabled));  ?>
            <label class="control-label required"><?php echo Yii::t('contentForm','What type of body you favors?'); ?></label>
            <div class="controls">
              	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'contextura'));  ?>
                  <?php
                if (isset(Yii::app()->params['multiLook']['bodyFavors']) && Yii::app()->params['multiLook']['bodyFavors']) $buttons = array_merge($all,Profile::rangeButtons($field->range,$model->tipo_cuerpo,$disabled));
                else $buttons = Profile::rangeButtons($field->range,$model->contextura,$disabled);
                $this->widget('bootstrap.widgets.TbButtonGroup', array(
  				    'size' => 'small',
              'type' => '',
                    'toggle' => (isset(Yii::app()->params['multiLook']['bodyFavors']) && Yii::app()->params['multiLook']['bodyFavors'])?'checkbox':'radio', // 'checkbox' or 'radio'
  				    'buttons' => $buttons,
  				)); ?>
  				<?php echo $form->hiddenField($model,'contextura'); ?>
  				<?php echo $form->error($model,'contextura'); ?>
            </div>
          </div>
          <div class="control-group">
          	<?php //echo CHtml::checkBox('pelo',false,array('class'=>'select_todos', 'disabled'=>$disabled));  ?>
            <label class="control-label required"><?php echo Yii::t('contentForm','What hair color would look better?');?></label>
            <div class="controls">
            		
              	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'pelo'));  ?>
                  <?php
                if (isset(Yii::app()->params['multiLook']['hairColor']) && Yii::app()->params['multiLook']['hairColor']) $buttons = array_merge($all,Profile::rangeButtons($field->range,$model->tipo_cuerpo,$disabled));
                else $buttons = Profile::rangeButtons($field->range,$model->pelo,$disabled);
                $this->widget('bootstrap.widgets.TbButtonGroup', array(
  				    'size' => 'small',
              'type' => '',
                    'toggle' => (isset(Yii::app()->params['multiLook']['hairColor']) && Yii::app()->params['multiLook']['hairColor'])?'checkbox':'radio', // 'checkbox' or 'radio'
  				    'buttons' => $buttons,
  				)); ?>
  				<?php echo $form->hiddenField($model,'pelo'); ?>
  				<?php echo $form->error($model,'pelo'); ?>
  				
            </div>
          </div>
          <div class="control-group">
          	<?php //echo CHtml::checkBox('altura',false,array('class'=>'select_todos', 'disabled'=>$disabled));  ?>
            <label class="control-label required"><?php echo Yii::t('contentForm','How much should measure the woman who wears this Look?');?></label>
            <div class="controls">
              	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'altura'));  ?>

                  <?php
                if (isset(Yii::app()->params['multiLook']['womanMeasure']) && Yii::app()->params['multiLook']['womanMeasure']) $buttons = array_merge($all,Profile::rangeButtons($field->range,$model->tipo_cuerpo,$disabled));
                else $buttons = Profile::rangeButtons($field->range,$model->altura,$disabled);
                $this->widget('bootstrap.widgets.TbButtonGroup', array(
  				    'size' => 'small',
              'type' => '',
                    'toggle' => (isset(Yii::app()->params['multiLook']['womanMeasure']) && Yii::app()->params['multiLook']['womanMeasure'])?'checkbox':'radio', // 'checkbox' or 'radio'
  				    'buttons' => $buttons,
  				)); ?>
  				<?php echo $form->hiddenField($model,'altura'); ?>
  				<?php echo $form->error($model,'altura'); ?>
            </div>
          </div>
          <div class="control-group">
          	<?php //echo CHtml::checkBox('ojos',false,array('class'=>'select_todos', 'disabled'=>$disabled));  ?>
            <label class="control-label required"><?php echo Yii::t('contentForm','What eye color is look better?');?></label>
            <div class="controls">
              	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'ojos'));  ?>
                  <?php
                if (isset(Yii::app()->params['multiLook']['eyesColor']) && Yii::app()->params['multiLook']['eyesColor']) $buttons = array_merge($all,Profile::rangeButtons($field->range,$model->tipo_cuerpo,$disabled));
                else $buttons = Profile::rangeButtons($field->range,$model->ojos,$disabled);
                $this->widget('bootstrap.widgets.TbButtonGroup', array(
  				    'size' => 'small',
              'type' => '',
                    'toggle' => (isset(Yii::app()->params['multiLook']['eyesColor']) && Yii::app()->params['multiLook']['eyesColor'])?'checkbox':'radio',
  				    'buttons' => $buttons,
  				)); ?>
  				<?php echo $form->hiddenField($model,'ojos'); ?>
  				<?php echo $form->error($model,'ojos'); ?>
            </div>
          </div>
          <div class="control-group">
          	<?php //echo CHtml::checkBox('tipo_cuerpo',false,array('class'=>'select_todos', 'disabled'=>$disabled));?>
            <label class="control-label required"><?php echo Yii::t('contentForm','What body type should I use?');?></label>
            <div class="controls">
              	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'tipo_cuerpo'));  ?>
                  <?php
                if (isset(Yii::app()->params['multiLook']['bodyType']) && Yii::app()->params['multiLook']['bodyType']) $buttons = array_merge($all,Profile::rangeButtons($field->range,$model->tipo_cuerpo,$disabled));
                else $buttons = Profile::rangeButtons($field->range,$model->tipo_cuerpo,$disabled);
                $this->widget('bootstrap.widgets.TbButtonGroup', array(
  				    'size' => 'small',
                    'type' => '',
  				    'toggle' => (isset(Yii::app()->params['multiLook']['bodyType']) && Yii::app()->params['multiLook']['bodyType'])?'checkbox':'radio', // 'checkbox' or 'radio'
                    'buttons' => $buttons,
  				)); ?>
  				<?php echo $form->hiddenField($model,'tipo_cuerpo'); ?>
  				<?php echo $form->error($model,'tipo_cuerpo'); ?>
            </div>
          </div>
              <?php
             /* $all = array();
              $all[0]['label'] = 'Todos';
              $all[0]['url'] = '#todos';
              $all[0]['htmlOptions'] = '';
              $all[0]['active']=true;

              print_r($all+Profile::rangeButtons($field->range,$model->tipo_cuerpo,$disabled));*/
              ?>
          <div class="control-group">
          	<?php //echo CHtml::checkBox('piel',false,array('class'=>'select_todos', 'disabled'=>$disabled));  ?>
            <label class="control-label required"><?php echo Yii::t('contentForm','What skin color is best suited to this Look?');?></label>
            <div class="controls">
              	<?php 	$field = ProfileField::model()->findByAttributes(array('varname'=>'piel'));  ?>
                  <?php
                if (isset(Yii::app()->params['multiLook']['bodyType']) && Yii::app()->params['multiLook']['skinColor']) $buttons = array_merge($all,Profile::rangeButtons($field->range,$model->tipo_cuerpo,$disabled));
                else $buttons = Profile::rangeButtons($field->range,$model->piel,$disabled);
                $this->widget('bootstrap.widgets.TbButtonGroup', array(
  				    'size' => 'small',
              'type' => '',

                    'toggle' => (isset(Yii::app()->params['multiLook']['skinColor']) && Yii::app()->params['multiLook']['skinColor'])?'checkbox':'radio', // 'checkbox' or 'radio'
                    'buttons' => $buttons
  				)); ?>
  				<?php echo $form->hiddenField($model,'piel'); ?>
  				<?php echo $form->error($model,'piel'); ?>
  				
          <?php //echo CHtml::hiddenField('save_draft','0', array('id'=>'save_draft')); ?>
            </div>
          </div>
          </div>
        
        </section >
        <section class="well">
              <?php if ($model->status == Look::STATUS_CREADO || Yii::app()->user->isAdmin()){ ?>
              	<h4><strong>3.</strong> <?php echo Yii::t('contentForm','Finished, just press send');?>  </h4>
                <div class="control-group">
                  <?php echo CHtml::checkBox('save_draft',false,array('class'=>'select_todos', 'id'=>'save_draft'));  ?> Guardar borrador sin enviar
                </div>
      
          <div class="row">
            <div class="pull-right"> 
            	<a href="#" title="Cancelar" data-dismiss="modal" class="btn btn-link"> <?php echo Yii::t('contentForm','Cancel');?> </a> 

              <?php /*$this->widget('bootstrap.widgets.TbButton', array(
                  'label'=>Yii::t('contentForm', 'Save draft'),
                 // 'type'=>'danger',
                  'type'=>'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'size'=>'large', // null, 'large', 'small' or 'mini'
                  'htmlOptions'=> array(
                     // 'data-toggle'=>'modal',
                  //  'data-target'=>'#dialogPublicar',
                        'id'=>'button_save',
                        //'onclick'=>"save_draft()"
                       ),     
              )); */?>
            	
            	<?php $this->widget('bootstrap.widgets.TbButton', array(
    				'buttonType'=>'submit',
    			    'label'=>Yii::app()->user->isAdmin()?Yii::t('contentForm','Approve'):Yii::t('contentForm','Send'),
    			    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    			    'size'=>'large', // null, 'large', 'small' or 'mini'
              'htmlOptions'=> array(
                     'id'=>'button_send',
              ),     
    			)); ?>
            </div> 
          </div>
        </section>
        
        <?php } ?>
         <?php if ($model->status == Look::STATUS_ENVIADO && !Yii::app()->user->isAdmin()){ ?>
         	<?php echo Yii::t('contentForm','Your phone is pending for passing, Thanks');?>
         	<script>$('#slider').hide();</script>
         <?php } ?>
        
     <?php $this->endWidget(); ?>

      
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
		//if ($(this).is(':checked')){

		if (!$(this).hasClass('active')){
			$(this).parent().find('.btn').not('.select_todos').addClass('active');
			 var ids = 0;
			$(this).parent().find('.btn').not('.select_todos').each(function(index){
					
				ids += parseInt($(this).attr('href').substring(1));
				
			});
			
			$(this).parent().find('.btn').parent().next('input').val(ids);

		}
		else {
			$(this).parent().find('.btn').not('.select_todos').removeClass('active');
			$(this).parent().find('.btn').not('.select_todos').parent().next('input').val(0);

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
		 if (!($(this).hasClass('select_todos'))){
			 var ids = 0;
			 $(this).siblings('.active').each(function(){
			 	ids += parseInt($(this).attr('href').substring(1));
			 });
			 if (!($(this).hasClass('active')))
			 	ids += parseInt($(this).attr('href').substring(1));
			 
			 $(this).parent().next('input').val(ids);
			 e.preventDefault();
		}
		 
	 });
";
?>
<?php Yii::app()->clientScript->registerScript('botones',$script); ?>
<script>
	$('#PublicarForm').submit(function(e) {
    		
    	
    		
    	if(!$('#Look_tipo_0').is(':checked')&&!$('#Look_tipo_1').is(':checked')){
	 			e.preventDefault();
	 			$('#radioError').show();	 			
	 	}
	 	if($('#Look_tipo_0').is(':checked')||$('#Look_tipo_1').is(':checked')){
	 		$('#PublicarForm').submit();
	 	}
    		
	 });
	 
	 $('#save_draft').on('click', function(e) {
    console.log('tal: '+$(this).is(':checked'));
    if($(this).is(':checked')){
      $('#button_send').html('Guardar borrador');
    }else{
      $('#button_send').html('Enviar');
    }
    
    
   });
	 
	 
</script>
