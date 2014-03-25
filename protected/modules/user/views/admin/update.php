	<?php

$this->breadcrumbs=array(
	'Usuarios'=>array('admin'),
	'Editar',
);


function getMonthsArray()
    {
        
         $months['01'] = "Enero";
		 $months['02'] = "Febrero";
		 $months['03'] = "Marzo";
		 $months['04'] = "Abril";
		 $months['05'] = "Mayo";
		 $months['06'] = "Junio";
		 $months['07'] = "Julio";
		 $months['08'] = "Agosto";
		 $months['09'] = "Septiembre";
		 $months['10'] = "Octubre";
		 $months['11'] = "Noviembre";
		 $months['12'] = "Diciembre";
    

        return array(0 => 'Mes:') + $months;
    }

     function getDaysArray()
    {
		$days['01'] = '01';
		$days['02'] = '02';
		$days['03'] = '03';
		$days['04'] = '04';
		$days['05'] = '05';
		$days['06'] = '06';
		$days['07'] = '07';
		$days['08'] = '08';
		$days['09'] = '09';
        for($dayNum = 10; $dayNum <= 31; $dayNum++){
            $days[$dayNum] = $dayNum;
        }

        return array(0 => 'Dia:') + $days;
    }

     function getYearsArray()
    {
        $thisYear = date('Y', time());

        for($yearNum = $thisYear; $yearNum >= 1920; $yearNum--){
            $years[$yearNum] = $yearNum;
        }

        return array(0 => 'Año:') + $years;
    }
    $val=true;
	/*if($model->personal_shopper==0)
		$val=false;*/
	?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Editar Usuario</h1>
  </div>
  <!-- SUBMENU ON -->
  <?php $this->renderPartial('_menu', array('model'=>$model, 'activo'=>1)); ?>
  <!-- SUBMENU OFF -->
  <div class="row margin_top">
    <div class="span9">
      <div class="bg_color3   margin_bottom_small padding_small box_1">
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'registration-form',
	'htmlOptions'=>array('class'=>'form-horizontal','enctype'=>'multipart/form-data'),
    'type'=>'horizontal',
   // 'type'=>'inline',
	'enableClientValidation'=>$val,
	
	'clientOptions'=>array(
		'validateOnSubmit'=>$val,
	),
	
)); ?>
        <fieldset>
          <legend >Datos de Usuario: </legend>
          <?php echo $form->textFieldRow($model,'email',array('class'=>'span5',)); ?>
          <div class="control-group">
            <label for="" class="control-label ">Contraseña </label>
            <div class="controls">
              <input type="password" placeholder="Contraseña"  class="span5">
              <div style="display:none" class="help-inline">Ingrese una contraseña</div>
            </div>
          </div>
          <div class="control-group"> <?php echo $form->dropDownListRow($model,'superuser',array(0=>'No',1=>'Si'),array('class'=>'span2')); ?> </div>
          <div class="control-group"> <?php echo $form->dropDownListRow($model,'personal_shopper',array(0=>'No', 1=>'Si', 2 => "Aplicante"),array('class'=>'span2')); ?> 
              <?php if($model->personal_shopper == 1){ ?>
              <span class="label label-warning" 
                    style="margin-left: 180px;padding: 4px 10px;font-size: 12px;
                    <?php echo ($model->ps_destacado)? '':'display:none;'; ?>">
                  
                    Personal Shopper Destacado
                    
              </span>
              <?php } ?>
          </div>
          <div class="control-group">
            <label for="" class="control-label ">Estado: </label>  
            <div class="controls">  
                <?php echo CHtml::textField('Status', User::getStatus($model->status),
                        array('disabled'=>'disabled',
                              'id' => 'User_status',
                              'class' => 'span2'));
                //$form->textFieldRow($model,'status',array('class'=>'span5', 'value' => User::getStatus($model->status)));
                //$form->dropDownListRow($model,'status', User::getStatus(),array('class'=>'span2')); 
                                    ?> 
            </div></div>
          <legend >Datos básicos: </legend>
          <?php 
		$profileFields=$profile->getFields();
		if ($profileFields) {
			foreach($profileFields as $field) {
				//echo $field->varname;
			?>
          <?php 
		if ($widgetEdit = $field->widgetEdit($profile)) {
			echo $widgetEdit;
		} elseif ($field->range) {
			if ($field->varname == 'sex')
				echo $form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range));
			else
				echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range));
						
			//echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range));
			//echo $form->radioButtonListRow($profile,$field->varname,Profile::range($field->range));
		} elseif ($field->field_type=="TEXT") {
			echo $form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
		} elseif ($field->field_type=="DATE") {
			echo '<div class="control-group">';
			echo '<div class="controls">';

			echo $form->labelEx($profile,$field->varname);	
			echo $form->DropDownList($profile,'day',getDaysArray(),array('class'=>'span1'));
			echo ' ';
			echo $form->DropDownList($profile,'month',getMonthsArray(),array('class'=>'span2'));
			echo ' ';
			echo $form->DropDownList($profile,'year',getYearsArray(),array('class'=>'span1'));
			echo '</div></div> ';
			echo $form->hiddenField($profile,$field->varname);
			//echo $form->textFieldRow($profile,$field->varname,array('class'=>'span5','maxlength'=>(($field->field_size)?$field->field_size:255)));
			echo '';
				 
				
		} else {
			echo $form->textFieldRow($profile,$field->varname,array('class'=>'span5','maxlength'=>(($field->field_size)?$field->field_size:255)));
		}	
		 ?>
          <?php echo $form->error($profile,$field->varname); ?>
          <?php
			}
		}
?>
        </fieldset>
        <?php $this->endWidget(); ?>
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
							top: "70px",
						});
					} else {
						if(st <= ot) {
							s.css({
								position: "relative",
								top: "0",
							});
						}
					}
				};
				$(window).scroll(move);
				move();
			}
		</script>
        <div>
          <div id="scroller-anchor"></div>
          <div id="scroller">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
            				'buttonType'=>'button',
						    'label'=>'Guardar Cambios',
						    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
						    'size'=>'large', // null, 'large', 'small' or 'mini'
						    'block'=>'true',
						    'htmlOptions'=>array('onclick'=>'js:$("#registration-form").submit();')
						)); ?>
            <ul class="nav nav-stacked nav-tabs margin_top">
              <li><a href="#" title="Limpiar Formulario" id="limpiar"><i class="icon-repeat"></i> Limpiar Formulario</a></li>
              <li>
              	<?php
              	
				echo CHtml::ajaxLink(
					  "<i class='icon-user'></i> Hacer Administrador",
					  Yii::app()->createUrl( 'user/admin/toggle_admin' ,array('id'=>$model->id)),
					  array( // ajaxOptions
					    'type' => 'POST',
					    'dataType'=>'json',
					    'beforeSend' => "function( request )
					                     {
					                       // Set up any pre-sending stuff like initializing progress indicators
					                     }",
					    'success' => "function( data )
					                  {
					                    // handle return data
					                   // alert( data.status );
					                   // alert(data.admin);
					                    if (data.status == 'success')
					                    	$('#User_superuser').val(data.admin);
					                  }",
					  //  'data' => array( 'val1' => '1', 'val2' => '2' )
					  ),
					  array( //htmlOptions
					    'href' => Yii::app()->createUrl( 'user/admin/toggle_admin' ),
					    //'class' => $class
					  )
					);
?>
              	              	
              </li>
              <li>
              	<?php
                    
                    if($model->personal_shopper == 1){
                        $titulo = 'Quitar Personal Shopper';
                    }else if($model->personal_shopper == 2){
                        $titulo = 'Aprobar como Personal Shopper';
                    }else{
                        $titulo = 'Hacer Personal Shopper';
                    }
				echo CHtml::ajaxLink(
					  "<i class='icon-user'></i> {$titulo}",
					  Yii::app()->createUrl( 'user/admin/toggle_ps' ,array('id'=>$model->id)),
					  array( // ajaxOptions
					    'type' => 'POST',
					    'dataType'=>'json',
					    'beforeSend' => "function( request )
					                     {
					                       // Set up any pre-sending stuff like initializing progress indicators
					                     }",
					    'success' => "function( data )
					                  {
					                    // handle return data
					                   // alert( data.status );
					                   // alert(data.personal_shopper);
					                    if (data.status == 'success'){
					                    	$('#User_personal_shopper').val(data.personal_shopper);
                                                                if(data.apply){
                                                                    bootbox.alert(\"¡Se ha aprobado la solicitud para Personal Shopper!\");
                                                                }
                                                                       
                                                                var text = data.personal_shopper == 1? 'Quitar Personal Shopper':'Hacer Personal Shopper';
                                                                
                                                                var child = $('#ps_link').children(); 
                                                                $('#ps_link').html(child).append(' '+text);
                                                                }
					                  }",
					  //  'data' => array( 'val1' => '1', 'val2' => '2' )
					  ),
					  array( //htmlOptions
					    'href' => Yii::app()->createUrl( 'user/admin/toggle_ps' ),
					    'id' => "ps_link",
					  )
					);
?>
              	              	
              </li>
              <?php if($model->personal_shopper == 1){ ?>
              <li>
              <?php 
                    if($model->ps_destacado){
                        $titulo = 'Quitar PS destacado';
                        $icon = 'down';
                    }else{
                        $titulo = 'Destacar Personal Shopper';
                        $icon = 'up';
                    }
                    echo CHtml::ajaxLink(
                              "<i class='icon-thumbs-{$icon}'></i> {$titulo}",
                              Yii::app()->createUrl( 'user/admin/toggleDestacado' ,array('id'=>$model->id)),
                              array( // ajaxOptions
                                'type' => 'POST',
                                'dataType'=>'json',
                                'success' => "function( data )
                                              {
                                                // handle return data
                                               // alert( data.status );
                                               // alert(data.personal_shopper);
                                                if (data.status == 'success'){
                                                    //$('#User_personal_shopper').val(data.personal_shopper);

                                                    //bootbox.alert(\"¡Se ha aprobado la solicitud para Personal Shopper!\");
                                                    var text = data.personal_shopper == 1? 'Quitar PS destacado':'Destacar Personal Shopper';
                                                    console.log(data);
                                                    var child = $('#psDestacado_link').children(); 
                                                    $('#psDestacado_link').html(child).append(' '+text);
                                                    $('#psDestacado_link').children('i').toggleClass('icon-thumbs-down');
                                                    $('#psDestacado_link').children('i').toggleClass('icon-thumbs-up');
                                                    $('span.label-warning').toggle();                                                   

                                                 }
                                              }",
                              //  'data' => array( 'val1' => '1', 'val2' => '2' )
                              ),
                              array( //htmlOptions
                                'href' => Yii::app()->createUrl( 'user/admin/toggleDestacado' ),
                                'id' => "psDestacado_link",
                              )
                            );
                ?> 
                  </li>
              <?php }//Fin si es personalshopper ?>
              <li><a href="#" title="Guardar"><i class="icon-bell"></i> Reenviar Invitación</a></li>
              
              <li>
                  
                  <?php
                  $text = ($model->status == User::STATUS_BANNED)? 'Desbloquear':'Bloquear';
                  echo CHtml::ajaxLink(
                      "<i class='icon-off'></i> {$text}",
                      Yii::app()->createUrl('user/admin/toggle_banned', array('id' => $model->id)), 
                      array(// ajaxOptions
                      'type' => 'POST',
                      'dataType' => 'json',
                      'beforeSend' => "function( request )
                                     {
                                       // Set up any pre-sending stuff like initializing progress indicators
                                     }",
                      'success' => "function( data )
                                  {     
                                    
                                    if (data.status == 'success'){
                                        $('#User_status').val(data.user_status);
                                        
                                        var text = data.user_status == 'Bloqueado'? 'Desbloquear':'Bloquear';
                                        var child = $('#ban_link').children();                                      
                                        
                                        $('#ban_link').html(child).append(' '+text);                                        
                                    }
                                    else if(data.status == 'error')
                                    {
                                        console.log(data.error);
                                    }
                                  }",
                         
                          ), 
                          array(//htmlOptions
                                'href' => Yii::app()->createUrl('user/admin/toggle_banned'),
                                 'id' => 'ban_link'
                          )
                  );
                  ?>
              </li>
              
              
            </ul>
          </div>
        </div>
        <script type="text/javascript"> 
		// Script para dejar el sidebar fijo Parte 2
			$(function() {
				moveScroller();
			 });

		$('a#limpiar').on('click', function() {
			
			$('#registration-form').each (function(){
			  this.reset();
			});
			
			 $('#registration-form').find(':input').each(function() {
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
       
       
       
       
		</script> 
        <!-- SIDEBAR OFF --> 
        
      </div>
    </div>
  </div>
</div>
<!-- /container --> 
