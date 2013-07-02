<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'producto-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>
<?php echo $form->errorSummary($model); ?>

<!-- SUBMENU OFF -->


<?php
	echo CHtml::hiddenField('accion','def', array('id' => 'accion'));
	//<input id="accion" type="hidden" value="" />	
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
                    <div class="control-group"> <?php echo $form->html5EditorRow($model, 'descripcion', array('class'=>'span5', 'rows'=>6, 'height'=>'200', 'options'=>array('color'=>true))); ?> <?php echo $form->error($model,'descripcion'); ?> </div>
                    <div class="control-group"> <?php echo $form->radioButtonListInlineRow($model, 'estado', array(0 => 'Activo', 1 => 'Inactivo',)); ?> <?php echo $form->error($model,'estado'); ?> </div>
                    <div class="control-group"> <?php echo $form->radioButtonListInlineRow($model, 'destacado', array(1 => 'Si', 0 => 'No',)); ?> <?php echo $form->error($model,'destacado'); ?> </div>
                    <div class="control-group">
                        <label for="" class="control-label required"> Calendario</label>
                        <div class="controls">
                            <?php 
              		if (($model->fInicio=="" && $model->fFin=="") || ($model->fInicio=="0000-00-00 00:00:00" && $model->fFin=="0000-00-00 00:00:00" && $model->nombre!=""))
					{
						echo("<label class='checkbox'>
                  <input type='checkbox''>
                  ¿Se publicará con fecha de Inicio y fin?</label>");
					}
					else if($model->fInicio!="0000-00-00 00:00:00" && $model->fFin!="0000-00-00 00:00:00")
					{
						echo CHtml::CheckBox('calendario','true', array (
                     						'checked'=>'checked',
                                        	'value'=>'on',
                                        )); 
						echo(" ¿Se publicará con fecha de Inicio y fin?");				
											
					}
					

				
              	?>
                        </div>
                    </div>
                    <div class="control-group">
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
                    </div>
                    <div class="control-group">
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
                    <li><a id="avanzar" style="cursor: pointer" title="Guardar y Siguiente">Guardar y avanzar</a></li>
                    <li><a id="nuevo" style="cursor: pointer" title="Guardar y crear nuevo producto">Guardar y crear nuevo producto</a></li>
                    <li><a style="cursor: pointer" title="Restablecer" id="limpiar">Limpiar</a></li>
                    <li><a href="#" title="Duplicar">Duplicar Producto</a></li>
                    <li><a href="#" title="Guardar"><i class="icon-trash"> </i> Borrar Producto</a></li>
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
		
		// submit del form
		$('#producto-form').submit();
		
		}
	);
	
	
	$('a#avanzar').on('click', function(event) {
		
		event.preventDefault();
		
		$("#accion").attr("value", "avanzar");
		//alert( $("#accion").attr("value") );
		
		// submit del form
		$('#producto-form').submit();
		
		}
	);
	
	
	$('a#nuevo').on('click', function(event) {
		
		event.preventDefault();
		
		$("#accion").attr("value", "nuevo");
		//alert( $("#accion").attr("value") );
		
		// submit del form
		$('#producto-form').submit();
		}
	);
	
	
</script>
<?php $this->endWidget(); ?>
