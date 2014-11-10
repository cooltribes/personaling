<?php
Yii::app()->clientScript->registerLinkTag('stylesheet','text/css','https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700',null,null);

$this->setPageTitle(Yii::app()->name . " - " . Yii::t('contentForm', 'Tu Dirección'));

if (!Yii::app()->user->isGuest) { // que este logueado
    $userObject = User::model()->findByPk($user);
    
    $nombre = $userObject ? $userObject->profile->first_name." ".$userObject->profile->last_name:
                "";
    
?>
<script> var error=0;</script>
<div class="container margin_top">
    <div class="progreso_compra">
    <div class="clearfix margin_bottom">
      <div class="first-past"><?php echo Yii::t('contentForm','Authentication'); ?></div>
      <div class="middle-done dos">
        <?php echo Yii::t('contentForm','Shipping <br/>and billing<br/> address'); ?>
      </div>
      <div class="middle-not_done tres">
        <?php echo Yii::t('contentForm','Payment <br> method'); ?>
      </div>
      <div class="last-not_done">
        <?php echo Yii::t('contentForm','Confirm <br>purchase'); ?>
      </div>
    </div>
      
  </div>
 
  <div class="row">
    <div class="span8 offset2"> 
     
      <h1><?php echo  Yii::t('contentForm','Shipping and billing address'); ?>
          <br>
          <?php
          if(Yii::app()->getSession()->contains("bolsaUser")){
              echo "(Usuario: <b>{$nombre}</b>)"; 
          }
          ?>
      </h1>
      <p><?php echo Yii::t('contentForm','Choose a shipping address and billing of your purchase from your address book or enter a new one in the bottom section'); ?></p>
      <?php 
      
//     	$usuario = Yii::app()->user->id; 
     	$usuario = $user; 
        $direcciones = Direccion::model()->findAllByAttributes(array('user_id'=>$usuario));
     	
      ?>

	  <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
          <fieldset id="anteriores">
            
           <?php
            if(count( $direcciones ) > 0 ){?>
            	<legend ><?php echo Yii::t('contentForm','Addresses used above'); ?>: </legend>
	       	<?php	$this->renderPartial('_direcciones', array(
	       		'direcciones'=>$direcciones,'nueva'=>true) , 
	       		false);
	  		}
			else {
				echo "<legend>".Yii::t('contentForm','You don\'t have any saved address')."</legend>";					
			}
 	
     
		
	 ?>
      
       </fieldset>
      </form>
    </section>


      
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'direccion_nueva',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true, 
		'afterValidate'=>"js:function(form, data, hasError) {
				if(!hasError)
				{agregar(); }}"
		
	),
	'htmlOptions'=>array('class'=>'form-horizontal'),
)); 

?>
      
      <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form" enctype="multipart/form-data">
          <fieldset>
            <legend> <?php echo Yii::t('contentForm','Add a new shipping address'); ?>: </legend>
            <div class="control-group"> 
             
              <div class="controls">
              	<?php 
              	
              	
              	echo $form->textFieldRow($dir,'nombre',array('class'=>'span4','maxlength'=>70,'placeholder'=>Yii::t('contentForm','Name of the person to whom you send'))); 
              	// <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Nombre de la persona a la que envias" name="RegistrationForm[email]" class="span4">
              	?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
             
              <div class="controls">
              	<?php echo $form->textFieldRow($dir,'apellido',array('class'=>'span4','maxlength'=>70,'placeholder'=>Yii::t('contentForm','Last name of the person to whom you send'))); 
              	//  <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Apellido de la persona a la que envias tu compra" name="RegistrationForm[email]" class="span4">
              	?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
         <?php if(Yii::app()->params['askId']){ ?>  
              <div class="controls">
              	<?php echo $form->textFieldRow($dir,'cedula',array('class'=>'span4','maxlength'=>20,'placeholder'=>Yii::t('contentForm','ID of the person to whom you send'))); 
              	//  <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Cedula de Identidad de la persona a la que envias" name="RegistrationForm[email]" class="span4">
              	?>
               
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
         </div><?php }?>
            <div class="control-group"> 
           
              <div class="controls">
              	<?php echo $form->textFieldRow($dir,'dirUno',array('class'=>'span4','maxlength'=>120,'placeholder'=>Yii::t('contentForm','Address Line 1: (Avenue, Street, complex, Residential, etc.).')));
				//<input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Direccion Linea 1: (Avenida, Calle, Urbanizacion, Conjunto Residencial, etc.)" name="RegistrationForm[email]" class="span4">
				 ?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
            
              <div class="controls">
              	<?php echo $form->textFieldRow($dir,'dirDos',array('class'=>'span4','maxlength'=>120,'placeholder'=>Yii::t('contentForm','Address Line 2: (Building, Floor, Number, apartment, etc.)')));
				// <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Direccion Linea 2: (Edificio, Piso, Numero, Apartamento, etc)" name="RegistrationForm[email]" class="span4">
				 ?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
            	
              <div class="controls">
              	<?php echo $form->textFieldRow($dir,'telefono',array('class'=>'span4','maxlength'=>45,'placeholder'=>Yii::t('contentForm','Phone number')));
				 ?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            <div class="control-group"> 
              
              <div class="controls">
              	<?php // echo $form->dropDownListRow($dir, 'pais', array('Seleccione el País', 'Venezuela', 'Colombia', 'Estados Unidos')); 
              		$pais=Pais::model()->findByAttributes(array('idioma'=>Yii::app()->getLanguage()));
              		if($pais->grupo==0)
              			echo ' <input name="Direccion[pais]" id="Direccion_pais" type="hidden" value="'.$pais->nombre.'" />';
					else{
						echo '<p>España Exenta de IVA: Ceuta, Melilla, Canarias y Andorra</p>';
						 echo $form->dropDownListRow(
						 	$dir,'pais', CHtml::listData(
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
              		echo $form->dropDownListRow($dir,'provincia_id', CHtml::listData(Provincia::model()->findAllByAttributes(array('pais_id'=>$pais->id),array('order' => 'nombre')),'id','nombre'), array('empty' => Yii::t('contentForm','Select a province')));
                else
                	echo $form->dropDownListRow($dir,'provincia_id', array(), array('empty' => Yii::t('contentForm','Select a province') ));?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            
            
            
            <div class="control-group"> 
              <div class="controls">
              	<?php 

              	if($dir->provincia_id == ''){ 
              		echo $form->dropDownListRow($dir,'ciudad_id', array(), array('empty' => Yii::t('contentForm','Select a city')));
				}else{
						/*$criteria=new CDbCriteria;
						$criteria->addCondition('cod_zoom IS NULL'); 
						$criteria->addCondition('provincia_id ='.$dir->provincia_id); 
						*/
						//$criteria->order('nombre'); 
					//echo $form->dropDownListRow($dir,'ciudad_id', CHtml::listData(Ciudad::model()->findAllByAttributes(array(),"cod_zoom IS NOT NULL AND provincia_id =".$dir->provincia_id, array('order' => 'nombre')),'id','nombre'));
					echo $form->dropDownListRow($dir,'ciudad_id', CHtml::listData(Ciudad::model()->findAllBySql("SELECT * FROM tbl_ciudad WHERE provincia_id =".$dir->provincia_id." AND cod_zoom IS NOT NULL order by nombre ASC"),'id','nombre'),array('empty' => Yii::t('contentForm','Select a city')));
					//echo $form->dropDownListRow($dir,'ciudad_id', CHtml::listData(Ciudad::model()->findAll($criteria),'id','nombre'));
				}

              	?>
                 
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
             <?php if($pais->idioma=='es_es')         {?>
            <div class="control-group"> 
              <div class="controls"> 
              	<?php 
              	if($dir->ciudad_id == ''){ 
              		echo $form->dropDownListRow($dir,'codigo_postal_id', array(), array('empty' => Yii::t('contentForm','Select a zip code')));
				}else{
						/*$criteria=new CDbCriteria;
						$criteria->addCondition('cod_zoom IS NULL'); 
						$criteria->addCondition('provincia_id ='.$dir->provincia_id); 
						*/
						//$criteria->order('nombre'); 
					//echo $form->dropDownListRow($dir,'ciudad_id', CHtml::listData(Ciudad::model()->findAllByAttributes(array(),"cod_zoom IS NOT NULL AND provincia_id =".$dir->provincia_id, array('order' => 'nombre')),'id','nombre'));
					echo $form->dropDownListRow($dir,'codigo_postal_id', CHtml::listData(CodigoPostal::model()->findAllBySql("SELECT * FROM tbl_codigo_postal WHERE ciudad_id =".$dir->ciudad_id." order by codigo ASC"),'id','codigo'));
					//echo $form->dropDownListRow($dir,'ciudad_id', CHtml::listData(Ciudad::model()->findAll($criteria),'id','nombre'));
				}}
              	?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
                 <div class="margin_top_large">                             
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'submit',
                    'type'=>'danger',
                    'size'=>'large',
                    'label'=>'Guardar en mis direcciones',
                    'id'=>'agregar',
                    'htmlOptions'=>array('class'=>'controls'),
                 
                    ));                 
                    ?> 
               </div>
              </div>
            </div>
            
            
           
        

           
          </fieldset>
        </form>
      </section>
    </div>
  </div>
</div>

<div id="alertBillingAddress" class="modal hide" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" >
 <div class="modal-header">
    <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true">×</button>
     <h3 ><?php echo Yii::t('contentForm','Remember');?></h3>
 
  </div>
  <div class="modal-body">
 		 <h4><?php echo Yii::t('contentForm','You should select a Billing Address.');?></h4>
 		 
  </div>
  <!--<div class="modal-footer">   
 		<button class="btn closeModal" data-dismiss="modal" aria-hidden="true">Aceptar</button>
  </div>-->
</div>
<!-- /container -->

<?php 
    /*Campos para compra desde admin*/
   

?>
<?php $this->endWidget(); ?>

<?php 

}// si esta logueado
else
{
	// redirecciona al login porque se murió la sesión
	header('Location: /user/login');	
}


?>

<script>

	
	$('#direccion_nueva').submit(function(e) {
    		e.preventDefault();    		
	 });
	 
	$('.closeModal').click(function(event) {
			$('#alertBillingAddress').hide();
		});
	
	
	function agregar(){
				$('body').addClass('aplicacion-cargando');
				var nom=$('#Direccion_nombre').val();
				var ap=$('#Direccion_apellido').val();
				var ced=$('#Direccion_cedula').val();
				
				var d1 =$('#Direccion_dirUno').val();
				var d2=$('#Direccion_dirDos').val();
				var tel=$('#Direccion_telefono').val();
				var prov=$('#Direccion_provincia_id').val();
				var ciu=$('#Direccion_ciudad_id').val();
				var pa=$('#Direccion_pais').val();
				var codigopostal=$('#Direccion_codigo_postal_id').val();
				var us=<?php echo $usuario; ?>
				
			
	    		$.ajax({
				      url: "<?php echo Yii::app()->createUrl('direccion/addDireccion',array('user'=>$user)); ?>",
				      type: "post",
				      data: {
				      	nombre:nom,
				      	apellido:ap,
				      	cedula:ced,
				      	dirUno:d1,
				      	dirDos:d2,
				      	telefono:tel,
				      	provincia_id:prov,
				      	ciudad_id:ciu,
				      	pais:pa,
				      	user_id:us,
				      	codigo_postal_id:codigopostal
				      	
				      	 },
				      success: function(data){
				           $('#anteriores').html(data);
				           $('#direccion_nueva').each(function(){
                				this.reset();   //Here form fields will be cleared.
           					 });
							$("#Direccion_ciudad_id option[value='']").attr('selected', true);
							$("#Direccion_codigo_postal_id option[value='']").attr('selected', true);
		                    $('html, body').animate({
		                        scrollTop: ($('#scrollNueva').offset().top - 150)
		                    }, 500);
							$('body').removeClass('aplicacion-cargando');
							$('#scrollNueva').removeClass('alert-success');	
							$('#controlBill').val('0');
																	           
				      },
				      error:function(){
				  
				      }
				});
			
		
	}
	
	
	
	
	
	
	function eliminar(id)
	{
		
	var idDireccion = id;
	$("#eliminar"+id).button('loading'); // lanza mensaje de estado del boton eliminando
	// llamada ajax para el controlador de bolsa	   
     	$.ajax({
	        type: "post",
	        url: "eliminardireccion", 
	        data: { 'idDir':idDireccion }, 
	        success: function (data) {
				if(data=="ok")
				{
					//Dirección eliminada exitosamente
					$('.direccion'+id).replaceWith('<div class="alert alert-succes">Dirección eliminada exitosamente<a class="close" href="#" data-dismiss="alert">&times;</a></div>');						
				}
				if(data=="bad")
				{
					//La dirección seleccionada no se puede eliminar
					$(".mensaje"+id).addClass("alert alert-error");	
					$(".mensaje"+id).text('Ésta dirección no se puede eliminar');
				}
				if(data=="wrong")
				{
					//La dirección no pudo ser eliminada
					$(".mensaje"+id).addClass("alert alert-error");
					$(".mensaje"+id).text('La dirección no pudo ser eliminada');	
				}								
	        	$("#eliminar"+id).button('reset');					
	       	}//success
	       })

	}
	
	
	/*
	 Funcion para editar una direccion
	 * */
	function editar(id)
	{	
		var idDireccion = id;
		window.location="editardireccion/"+id+"";
	}
	
	$('#Direccion_provincia_id').change(function(){
		if($(this).val() != ''){
			var path = location.pathname.split('/');
			$.ajax({
			      url: "<?php echo Yii::app()->createUrl('direccion/cargarCiudades'); ?>",
			      type: "post",
			      data: { provincia_id : $(this).val() },
			      success: function(data){
			           $('#Direccion_ciudad_id').html(data);
			           $("#Direccion_codigo_postal_id").html('');
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
			      	if(data=='')
			      		alert("DONDE?");
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
			           $("#Direccion_ciudad_id").html('');
			           $("#Direccion_codigo_postal_id").html('');
			      },
			});
		}
	});
	
	
	

	
	
</script>
