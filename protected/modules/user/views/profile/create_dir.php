<?php

$look = new Look;
$looks_encantan = LookEncantan::model()->countByAttributes(array('user_id'=>$usuario->id));
$productos_encantan = UserEncantan::model()->countByAttributes(array('user_id'=>$usuario->id));
$looks_recomendados = $look->match($usuario);
?>

<div class="container margin_top tu_perfil">
    <div class="page-header">
        <h1>Tu perfil de usuario</h1>
        
    </div>

    <div class="row">
        <aside class="span3">
            <div>
                <div class="card">
                	<?php echo CHtml::image($usuario->getAvatar(),'Avatar',array("width"=>"270", "height"=>"270")); ?>
                	
                    <div class="card_content vcard">
                        <h4 class="fn"><?php echo $profile->first_name." ".$profile->last_name; ?></h4>
                        <p class="muted">Miembro desde: <?php echo Yii::app()->dateFormatter->format("d MMM y",strtotime($usuario->create_at)); ?></p>
                    </div>
                </div>
                <hr/>
                <h5>Tu actividad</h5>
                <aside class="card">
                    <div class="card_numbers clearfix"> <span class="T_xlarge margin_top_xsmall"><?php echo $looks_encantan; ?></span>
                        <p>Looks que te Encantan</p>
                    </div>
                    <div class="card_numbers clearfix"> <span class="T_xlarge margin_top_xsmall"><?php echo $productos_encantan; ?></span>
                        <p>Productos que te Encantan</p>
                    </div>
                    <div class="card_numbers clearfix"> <span class="T_xlarge margin_top_xsmall"><?php echo $looks_recomendados->totalItemCount; ?></span>
                        <p>Looks recomendados para ti</p>
                    </div>
                </aside>
                <hr/>
                <h5>Tus Compras</h5>
                <ul class="nav nav-stacked text_align_center" >
                	<?php
      	
			      	$sum = Yii::app()->db->createCommand(" SELECT SUM(total) as total FROM tbl_balance WHERE user_id=".Yii::app()->user->id." GROUP BY user_id ")->queryScalar();
			      
			      	if($sum >= 0){
			      	?>
			      		<li><?php echo Yii::app()->numberFormatter->formatDecimal($sum); ?> Bs. de Balance en tu Cuenta</li>
			      	<?php
			      	}
			      	else
			      	{
			      	?>
			      		<li><?php echo Yii::app()->numberFormatter->formatDecimal($sum); ?> Bs. que adeudas.</li>
			      	<?php
			      	}
			      	?>
			        <li>XX Puntos Ganados</li>
			        
			        <?php
			        $total;
				
					$sql = "select count( * ) as total from tbl_orden where user_id=".Yii::app()->user->id." and estado < 5";
					$total = Yii::app()->db->createCommand($sql)->queryScalar();
			      	?>
			      	<li><?php echo $total; ?> Pedidos Activos</li>
			        <li>XX Devoluciones Pendientes</li>
                </ul>
            </div>
        </aside>
        
        <div class="span9 ">
            <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
				'id'=>'direccion_nueva',
				'enableAjaxValidation'=>false,
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true, 
				),
				'htmlOptions'=>array('class'=>'form-horizontal personaling_form'),
			)); 
			
			?>
      
      <section class="bg_color3 margin_bottom_small padding_small box_1">

          <fieldset>
            <legend><? 	if($model->isNewRecord)
            				echo 'Crear nueva dirección';
						else
							echo 'Editar dirección';
						?> :			
			</legend>
            <div class="control-group"> 
 				<?php echo $form->labelEx($model,'nombre', array('class' => 'control-label')); ?>
              <div class="controls">
              	<?php echo $form->textField($model,'nombre',array('class'=>'span5','maxlength'=>128,'placeholder'=>'Nombre de la persona que está en esa dirección')); ?>
              	<?php echo $form->error($model,'nombre'); ?>
              	
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            <div class="control-group"> 
             	<?php echo $form->labelEx($model,'apellido', array('class' => 'control-label')); ?>
              <div class="controls">
              	<?php echo $form->textField($model,'apellido',array('class'=>'span5','maxlength'=>70,'placeholder'=>'Apellido de la persona que está en esa dirección')); 
              	echo $form->error($model,'apellido');
              	?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            <div class="control-group"> 
             <?php echo $form->labelEx($model,'cedula', array('class' => 'control-label')); ?>
              <div class="controls">
              	<?php echo $form->textField($model,'cedula',array('class'=>'span5','maxlength'=>20,'placeholder'=>'Cedula de Identidad de la persona en esa direccións')); 
				echo $form->error($model,'cedula');              	
				?>
               
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            <div class="control-group"> 
	           <?php echo $form->labelEx($model,'dirUno', array('class' => 'control-label')); ?>
              <div class="controls">
              	<?php echo $form->textField($model,'dirUno',array('class'=>'span5','maxlength'=>120,'placeholder'=>'(Avenida, Calle, Urbanizacion, Conjunto Residencial, etc.)'));
				echo $form->error($model,'dirUno');
				?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            <div class="control-group"> 
            <?php echo $form->labelEx($model,'dirDos', array('class' => 'control-label')); ?>
              <div class="controls">
              	<?php echo $form->textField($model,'dirDos',array('class'=>'span5','maxlength'=>120,'placeholder'=>'(Edificio, Piso, Numero, Apartamento, etc)'));
				echo $form->error($model,'dirDos');
				?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            <div class="control-group"> 
            	<?php echo $form->labelEx($model,'telefono', array('class' => 'control-label')); ?>
              <div class="controls">
              	<?php echo $form->textField($model,'telefono',array('class'=>'span5','maxlength'=>45,'placeholder'=>'Numero de Telefono'));
				echo $form->error($model,'telefono');
				?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            <div class="control-group"> 
              <?php echo $form->labelEx($model,'provincia_id', array('class' => 'control-label')); ?>
              <div class="controls">
              	<?php echo $form->dropDownList($model,'provincia_id', CHtml::listData(Provincia::model()->findAll(array('order' => 'nombre')),'id','nombre'), array('empty' => 'Seleccione un estado...'));?>
              	<?php
              	echo $form->error($model,'provincia_id');
              	?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            <div class="control-group"> 
           	<?php echo $form->labelEx($model,'ciudad_id', array('class' => 'control-label')); ?>
              <div class="controls">
              	<?php echo $form->dropDownList($model,'ciudad_id', CHtml::listData(Ciudad::model()->findAll(array('order' => 'nombre')),'id','nombre'), array('empty' => 'Seleccione una ciudad...'));?>
              	<?php echo $form->error($model,'ciudad_id'); ?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            <div class="control-group"> 
            <?php echo $form->labelEx($model,'pais', array('class' => 'control-label')); ?>
              <div class="controls">
              		
              	<?php 
              	 
              	 if($model->pais=="Venezuela"){
              	 	echo $form->dropDownList($model, 'pais', array('Seleccione el País','Venezuela','Colombia','Estados Unidos'),
              	 		array('options' => array(1 => array('selected'=>true))));
              	 }
				 else
				 if($model->pais=="Colombia"){
              	 	echo $form->dropDownList($model, 'pais', array('Seleccione el País','Venezuela','Colombia','Estados Unidos'),
              	 		array('options' => array(2 => array('selected'=>true))));
              	 }
				 else
              	 if($model->pais=="Estados Unidos"){
              	 	echo $form->dropDownList($model, 'pais', array('Seleccione el País','Venezuela','Colombia','Estados Unidos'),
              	 		array('options' => array(3 => array('selected'=>true))));
              	 }
				 else
              	 	echo $form->dropDownList($model, 'pais', array('Seleccione el País','Venezuela','Colombia','Estados Unidos'));
              	 
              	 echo $form->error($model,'pais');
              	 
              	 ?>

                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'danger',
            'size'=>'large',
            'label'=>$model->isNewRecord ? 'Crear' : 'Guardar',
        )); 

        ?>
            </div>
           
          </fieldset>
        </form>
      </section>

<?php $this->endWidget(); ?> 

        </div>
        
    </div>
</div>
<!-- /container -->