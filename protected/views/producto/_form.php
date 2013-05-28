<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'producto-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
)); ?>
	<?php echo $form->errorSummary($model); ?>

  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form" class="form-horizontal" enctype="multipart/form-data">
          <fieldset>
            <legend >Nombre/Titulo: </legend>
            <div class="control-group">
              <?php echo $form->labelEx($model,'nombre', array('class' => 'control-label')); ?>
              <div class="controls">
              	<?php echo $form->textField($model,'nombre',array('class'=>'span5','maxlength'=>50, 'placeholder' => 'Nombre/Titulo')); ?>
                <?php echo $form->error($model,'nombre'); ?>
              </div>
            </div>
            <div class="control-group">
               <?php echo $form->labelEx($model,'codigo', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo $form->textField($model,'codigo',array('class'=>'span5','maxlength'=>25, 'placeholder'=>'SKU / Código')); ?>
                <?php echo $form->error($model,'codigo'); ?>
              </div>
            </div>
          <div class="control-group">
              <?php echo $form->labelEx($model,'marca_id', array('class' => 'control-label')); ?>
              <div class="controls controls-row">
                <?php
                
                $models = Marca::model()->findAll(array('order' => 'id'));
				$list = CHtml::listData($models,'id', 'nombre');
				
				echo CHtml::dropDownList('marcas', $model->marca_id, $list, array('empty' => 'Seleccione...'));
                
                //echo $form->dropDownList($model, 'proveedor', array('Seleccione...', Producto::aldo, Producto::desigual, Producto::accessorize, Producto::suite, Producto::mango, Producto::helly, Producto::secret, Producto::bimba ,'Otra')); ?>
                <?php echo $form->error($model,'marca_id'); ?>
              </div>
          </div>
            <div class="control-group">
                <?php echo $form->html5EditorRow($model, 'descripcion', array('class'=>'span5', 'rows'=>6, 'height'=>'200', 'options'=>array('color'=>true))); ?>
                <?php echo $form->error($model,'descripcion'); ?>
            </div>
            <div class="control-group">
                	<?php echo $form->radioButtonListInlineRow($model, 'estado', array(0 => 'Activo', 1 => 'Inactivo',)); ?>
                 	<?php echo $form->error($model,'estado'); ?>
            </div>
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
      	
      	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'danger',
			'size' => 'large',
			'block'=>'true',
			'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
		)); ?>

        <ul class="nav nav-stacked nav-tabs margin_top">
          <li><a style="cursor: pointer" title="Restablecer" id="limpiar">Limpiar</a></li>
          <li><a href="#" title="Duplicar">Duplicar</a></li>
          <li><a href="#" title="Guardar"><i class="icon-trash"> </i> Borrar</a></li>
        </ul>
      </div>
    </div>
  </div>

<script>

		$('#limpiar').on('click', function() {
			
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
			
			
           $("#producto-form input[type=text]").val('');
           $("#producto-form input[type=text]").value('');
           
           $("#producto-form textarea").val("");
           $("#producto-form textarea").value("");
            
           $("#producto-form select").val('-1');
           $("#producto-form select").value('-1');
           
           $("#producto-form input[type=radio]").val('0');
             $("#producto-form input[type=radio]").value('0');
           
           $("#producto-form input[type=checkbox]").val('false');
           $("#producto-form input[type=checkbox]").value('false');
           
           $("#producto-form")[0].reset();
           $("#producto-form")[3].reset();
           

           
       });
	
</script>

<?php $this->endWidget(); ?>


