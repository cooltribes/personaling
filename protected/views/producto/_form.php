<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'producto-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'type'=>'horizontal',
)); ?>
<?php echo $form->errorSummary($model); ?>

<!-- SUBMENU OFF -->


<?php
	echo CHtml::hiddenField('accion','def', array('id' => 'accion'));
	//<input id="accion" type="hidden" value="" />	
	echo CHtml::hiddenField('id_sig',$model->next($model->id), array('id' => 'id_sig'));
?>


<div class="row margin_top">
    <div class="span9">
        <div class="bg_color3   margin_bottom_small padding_small box_1">
            <form method="post" action="/aiesec/user/registration?template=1" id="registration-form" class="form-horizontal" enctype="multipart/form-data">
                <fieldset>
                    <legend >Nombre/Titulo: </legend>
                    <div class="control-group"> <?php echo $form->labelEx($model,'nombre', array('class' => 'control-label')); ?>
                        <div class="controls"> <?php echo $form->textField($model,'nombre',array('class'=>'span5','maxlength'=>50, 'placeholder' => 'Nombre/Titulo')); ?> <?php echo $form->error($model,'nombre'); ?> </div>
                    </div>
                    <div class="control-group"> <?php echo $form->labelEx($model,'codigo', array('class' => 'control-label')); ?>
                        <div class="controls"> <?php echo $form->textField($model,'codigo',array('class'=>'span5','maxlength'=>25, 'placeholder'=>'Referencia')); ?> <?php echo $form->error($model,'codigo'); ?> </div>
                    </div>
                    <div class="control-group"> <?php echo $form->labelEx($model,'marca_id', array('class' => 'control-label')); ?>
                        <div class="controls controls-row">
                            <?php
                
                $models = Marca::model()->findAll(array('order' => 'id'));
				$list = CHtml::listData($models,'id', 'nombre');
				
				echo CHtml::dropDownList('marcas', $model->marca_id, $list, array('empty' => 'Seleccione...'));
                
                //echo $form->dropDownList($model, 'proveedor', array('Seleccione...', Producto::aldo, Producto::desigual, Producto::accessorize, Producto::suite, Producto::mango, Producto::helly, Producto::secret, Producto::bimba ,'Otra')); ?>
                            <?php echo $form->error($model,'marca_id'); ?> </div>
                    </div>
                    <div class="control-group"> <?php echo $form->labelEx($model,'peso', array('class' => 'control-label')); ?>
                        <div class="controls"> <?php echo $form->textField($model,'peso',array('class'=>'span5','maxlength'=>10, 'placeholder' => 'Ej.: 1.5')); ?> <?php echo $form->error($model,'peso'); ?> </div>
                    </div>
                    <div class="control-group"> <?php echo $form->labelEx($model,'almacen', array('class' => 'control-label')); ?> 
                        <div class="controls"> <?php echo $form->textField($model,'almacen',array('class'=>'span5','maxlength'=>10, 'placeholder' => 'Ej.: A4')); ?>
                        <?php echo $form->error($model,'almacen'); ?> </div>
                    </div>
                    <div class="control-group"> <?php echo $form->html5EditorRow($model, 'descripcion', array('class'=>'span5', 'rows'=>6, 'height'=>'200', 'options'=>array('color'=>true))); ?> <?php //echo $form->error($model,'descripcion'); ?> </div>
                    <div class="control-group"> <?php echo $form->radioButtonListInlineRow($model, 'estado', array(0 => 'Activo', 1 => 'Inactivo',)); ?> <?php echo $form->error($model,'estado'); ?> </div>
                    <div class="control-group"> <?php echo $form->radioButtonListInlineRow($model, 'destacado', array(1 => 'Si', 0 => 'No',)); ?> <?php echo $form->error($model,'destacado'); ?> </div>
                    <div class="control-group">
                        <label for="" class="control-label required"> Calendario</label>
                        <div class="controls">
                            <?php 
              		if (($model->fInicio=="" && $model->fFin=="") || ($model->fInicio=="0000-00-00 00:00:00" && $model->fFin=="0000-00-00 00:00:00" && $model->nombre!=""))
					{
						echo("<label class='checkbox'>
                  <input type='checkbox' id='abrirFechas'>
                  ¿Se publicará con fecha de Inicio y fin?</label>");
					}
					else if($model->fInicio!="0000-00-00 00:00:00" && $model->fFin!="0000-00-00 00:00:00")
					{
						echo CHtml::CheckBox('calendario','true', array (
                     						'checked'=>'checked',
                                        	'value'=>'on',
                                        	'id'=>'abrirFechas',
                                        )); 
						echo(" ¿Se publicará con fecha de Inicio y fin?");	
						
						echo("				
						<script type='text/javascript'>	
							$('#fechas').ready(function(){
									
								if($('#fechas').css('display') == 'none') 
									$('#fechas').show('slow'); 
								
							});						
						</script>
						");			
											
					}
					

				
              	?>
                        </div>
                    </div>
                    <div class="control-group">
                    	<div style="display: none" id="fechas">
                        <?php 
                
               	if($model->fInicio=="0000-00-00 00:00:00")
			   	{
               		echo $form->datepickerRow($model, 'fInicio',
        				array('hint'=>'Haz clic dentro del campo para desplegar el calendario.',
							'prepend'=>'<i class="icon-calendar"></i>','value'=>'')); 	
											
					echo $form->timepickerRow($model, 'horaInicio', array('append'=>'<i class="icon-time" style="cursor:pointer"></i>','value'=>''));							
            	}
            	else // si tiene fecha de inicio
            	{
            		echo $form->datepickerRow($model, 'fInicio',
        				array('hint'=>'Haz clic dentro del campo para desplegar el calendario.',
							'prepend'=>'<i class="icon-calendar"></i>')); 	
											
					echo $form->timepickerRow($model, 'horaInicio', array('append'=>'<i class="icon-time" style="cursor:pointer"></i>'));
            	}
            ?>

                        <?php 
            	if($model->fFin=="0000-00-00 00:00:00")
			   	{
            	
            	echo $form->datepickerRow($model, 'fFin',
        			array('hint'=>'Haz clic dentro del campo para desplegar el calendario.',
							'prepend'=>'<i class="icon-calendar"></i>','value'=>'')); 
							
				 echo $form->timepickerRow($model, 'horaFin', array('append'=>'<i class="icon-time" style="cursor:pointer"></i>','value'=>''));	
				}
				else
				{
					echo $form->datepickerRow($model, 'fFin',
        			array('hint'=>'Haz clic dentro del campo para desplegar el calendario.',
							'prepend'=>'<i class="icon-calendar"></i>')); 
							
				 	echo $form->timepickerRow($model, 'horaFin', array('append'=>'<i class="icon-time" style="cursor:pointer"></i>'));	
				}

            ?>
                    </div>
				</div>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="span3">
        <div class="padding_left"> 
            <!-- SIDEBAR OFF --> 
            <script > 
			// Script para dejar el sidebar fijo Parte 1
			function moveScroller() {
				var move = function() {
					var st = $(window).scrollTop();
					var ot = $("#scroller-anchor").offset().top;
					var s = $("#scroller");
					if(st > ot) {
						s.css({
							position: "fixed",
							top: "70px"
						});
					} else {
						if(st <= ot) {
							s.css({
								position: "relative",
								top: "0"
							});
						}
					}
				};
				$(window).scroll(move);
				move();
			}
		</script>
            <div id="scroller-anchor"></div>
            <div id="scroller">
                <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'danger',
			'size' => 'large',
			'block'=>'true',
			'htmlOptions' => array('id'=>'normal'),
			'label'=>$model->isNewRecord ? 'Crear producto' : 'Guardar cambios',
		)); ?>
                <ul class="nav nav-stacked nav-tabs margin_top">
                    <li><a id="avanzar" style="cursor: pointer" title="Guardar y avanzar">Guardar y avanzar</a></li>
                    <?php
		       		if($model->next($model->id) != NULL)
					{
		       		?>
		       		<li><a id="siguiente" style="cursor: pointer" title="Guardar y Siguiente">Guardar y siguiente producto</a></li>
		       		<?php
					}
		       		?>
                   <!-- <li><a id="nuevo" style="cursor: pointer" title="Guardar y crear nuevo producto">Guardar y crear nuevo producto</a></li> -->
                    <li><a style="cursor: pointer" title="Restablecer" id="limpiar">Limpiar Formulario</a></li>
                    <!-- <li><a href="#" title="Duplicar">Duplicar Producto</a></li> -->
                    <!-- <li><a href="#" title="Guardar"><i class="icon-trash"> </i> Borrar Producto</a></li> -->
                </ul>
                
            </div>
           
            
        </div>
          <script type="text/javascript"> 
		// Script para dejar el sidebar fijo Parte 2
			$(function() {
				moveScroller();
			 });
		</script>
            <!-- SIDEBAR OFF --> 
       
    </div>
</div>
<script>

		$('a#limpiar').on('click', function() {
			
			$('#producto-form').each (function(){
			  this.reset();
			});
			
			 $('#producto-form').find(':input').each(function() {
            switch(this.type) {
                case 'password':
                case 'select-multiple':
                case 'select-one':
                case 'text':
                case 'textarea':
                    $(this).val('');
                    break;
                case 'checkbox':
                case 'radio':
                    this.checked = false;
            }
        });
           
       });
	
	
	$('#normal').on('click', function(event) {
		event.preventDefault();
		
		// cambio el valor
		$("#accion").attr("value", "normal");
		
		//verificar peso
		if($('#Producto_peso').val() > 0 && $('#Producto_peso').val().length != 0){
			$('#Producto_peso_em_').hide();
			// submit del form
			$('#producto-form').submit();
		}else{
			$('#Producto_peso_em_').html('Debes ingresar un peso mayor a 0');
			$('#Producto_peso_em_').show();
		}
	});
	
	
	$('a#avanzar').on('click', function(event) {
		
		event.preventDefault();
		
		$("#accion").attr("value", "avanzar");
		//alert( $("#accion").attr("value") );
		
		//verificar peso
		if($('#Producto_peso').val() > 0 && $('#Producto_peso').val() != ''){
			$('#Producto_peso_em_').hide();
			// submit del form
			$('#producto-form').submit();
		}else{
			$('#Producto_peso_em_').html('Debes ingresar un peso mayor a 0');
			$('#Producto_peso_em_').show();
		}
		// submit del form
		//$('#producto-form').submit();
		}
	);
	
	$('a#siguiente').on('click', function(event) {
		
//                console.log($("#id_sig").attr("value"));
//                return;
                event.preventDefault();
		
		$("#accion").attr("value", "siguiente");
		var uno = $("#id_sig").attr("value");
		
		if(uno != ""){
			//alert(uno);

			// submit del form
			$('#producto-form').submit();
		}
	}	
	);	
		
	
	/*
	$('a#nuevo').on('click', function(event) {
		
		event.preventDefault();
		
		$("#accion").attr("value", "nuevo");
		//alert( $("#accion").attr("value") );
		
		//verificar peso
		if($('#Producto_peso').val() > 0){
			$('#Producto_peso_em_').hide();
			// submit del form
			$('#producto-form').submit();
		}else{
			$('#Producto_peso_em_').val('Debes ingresar un peso mayor a 0');
			$('#Producto_peso_em_').show();
		}
		// submit del form
		//$('#producto-form').submit();
		}
	);
	*/
	
$("#abrirFechas").click(function () {
  $("#fechas").toggle("slow");
});

</script>

<?php $this->endWidget(); ?>
