<?php
$this->breadcrumbs=array(
  UserModule::t("Mi cuenta") => array('micuenta'),
  UserModule::t("Nuevo dirección"),
);
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
            <legend><?php 	if($model->isNewRecord)
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
              
              <div class="controls">
              	<?php // echo $form->dropDownListRow($model, 'pais', array('Seleccione el País', 'Venezuela', 'Colombia', 'Estados Unidos')); 
              		$pais=Pais::model()->findByAttributes(array('idioma'=>Yii::app()->getLanguage()));
              		if($pais->grupo==0)
              			echo ' <input name="Direccion[pais]" id="Direccion_pais" type="hidden" value="'.$pais->nombre.'" />';
					else{
						 echo $form->dropDownListRow(
						 	$model,'pais', CHtml::listData(
						 		Pais::model()->findAllByAttributes(
						 			array(
						 				'grupo'=>$pais->grupo),
						 			array(
						 				'order' => 'nombre')
								),'id','nombre'
							), array(
								'empty' => Yii::t(
									'contentForm','Select a country')
								)
							);
					}
              		
 	 			 ?>
              </div>
            </div>
            
            <div class="control-group"> 
              
              <div class="controls">
              	<?php 
              	if($pais->grupo==0)
              		echo $form->dropDownListRow($model,'provincia_id', CHtml::listData(Provincia::model()->findAllByAttributes(array('pais_id'=>$pais->id),array('order' => 'nombre')),'id','nombre'), array('empty' => Yii::t('contentForm','Select a province')));
                else
                	echo $form->dropDownListRow($model,'provincia_id', array(), array('empty' => Yii::t('contentForm','Select a province') ));?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            
            
            <div class="control-group"> 
              <div class="controls">
              	<?php 

              	if($model->provincia_id == ''){ 
              		echo $form->dropDownListRow($model,'ciudad_id', array(), array('empty' => 'Seleccione una ciudad'));
				}else{
						/*$criteria=new CDbCriteria;
						$criteria->addCondition('cod_zoom IS NULL'); 
						$criteria->addCondition('provincia_id ='.$model->provincia_id); 
						*/
						//$criteria->order('nombre'); 
					//echo $form->dropDownListRow($model,'ciudad_id', CHtml::listData(Ciudad::model()->findAllByAttributes(array(),"cod_zoom IS NOT NULL AND provincia_id =".$model->provincia_id, array('order' => 'nombre')),'id','nombre'));
					echo $form->dropDownListRow($model,'ciudad_id', CHtml::listData(Ciudad::model()->findAllBySql("SELECT * FROM tbl_ciudad WHERE provincia_id =".$model->provincia_id." AND cod_zoom IS NOT NULL order by nombre ASC"),'id','nombre'),array('empty' => 'Seleccione una ciudad'));
					//echo $form->dropDownListRow($model,'ciudad_id', CHtml::listData(Ciudad::model()->findAll($criteria),'id','nombre'));
				}

              	?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
             <?php if($pais->idioma=='es_es')         {?> 
            <div class="control-group"> 
              <div class="controls"> 
              	<?php 
              	if($model->ciudad_id == ''){ 
              		echo $form->dropDownListRow($model,'codigo_postal_id', array(), array('empty' => 'Seleccione un codigo postal...'));
				}else{
						/*$criteria=new CDbCriteria;
						$criteria->addCondition('cod_zoom IS NULL'); 
						$criteria->addCondition('provincia_id ='.$model->provincia_id); 
						*/
						//$criteria->order('nombre'); 
					//echo $form->dropDownListRow($model,'ciudad_id', CHtml::listData(Ciudad::model()->findAllByAttributes(array(),"cod_zoom IS NOT NULL AND provincia_id =".$model->provincia_id, array('order' => 'nombre')),'id','nombre'));
					echo $form->dropDownListRow($model,'codigo_postal_id', CHtml::listData(CodigoPostal::model()->findAllBySql("SELECT * FROM tbl_codigo_postal WHERE ciudad_id =".$model->provincia_id." order by codigo ASC"),'id','codigo'), array('empty' => 'Seleccione un codigo postal...'));
					//echo $form->dropDownListRow($model,'ciudad_id', CHtml::listData(Ciudad::model()->findAll($criteria),'id','nombre'));
				}}
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
<script>

	


	$('#Direccion_provincia_id').change(function(){
		if($(this).val() != ''){
			var path = location.pathname.split('/');
			$.ajax({
			      url: "<?php echo $this->createUrl("/direccion/cargarCiudades"); ?>",
			      type: "post",
			      data: { provincia_id : $(this).val() },
			      success: function(data){
			           $('#Direccion_ciudad_id').html(data);
			      },
			});
		}
	});
	
	$('#Direccion_ciudad_id').change(function(){
		if($(this).val() != ''){
			var path = location.pathname.split('/');
			$.ajax({
			      url: "<?php echo Yii::app()->createUrl('direccion/cargarCodigos'); ?>",
			      type: "post",
			      data: { ciudad_id : $(this).val() },
			      success: function(data){
			           $('#Direccion_codigo_postal_id').html(data);
			      },
			});
		}
	});
	
	$('#Direccion_pais').change(function(){
		if($(this).val() != ''){
			var path = location.pathname.split('/');
			$.ajax({
			      url: "<?php echo Yii::app()->createUrl('direccion/cargarProvincias'); ?>",
			      type: "post",
			      data: { pais_id : $(this).val() },
			      success: function(data){
			           $('#Direccion_provincia_id').html(data);
			      },
			});
		}
	});
	 
	
</script>