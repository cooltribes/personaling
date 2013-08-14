<?php

if (!Yii::app()->user->isGuest) { // que este logueado

?>

<div class="container margin_top">
    <div class="progreso_compra">
      <div class="clearfix margin_bottom">
        <div class="first-past">Autenticación</div>
        <div class="middle-done">Dirección<br/>de envío <br/>y facturación</div>
        <div class="middle-not_done">Método <br/>de pago</div>
        <div class="last-not_done">Confirmar<br/>compra</div>
      </div>
      
  </div>

  <div class="row">
    <div class="span8 offset2"> 
     
      <h1>Dirección de envío</h1>
      <p>Elige una dirección para el envio de tu compra desde tu libreta de direcciones o ingresa una nueva en la seccion inferior:</p>
      <?php 
      
     	$usuario = Yii::app()->user->id; 
      
	  	$direcciones = Direccion::model()->findAllByAttributes(array('user_id'=>$usuario));
	  ?>
	  <?php if( count( $direcciones ) > 0 ){ ?>
	  <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
          <fieldset>
            <legend >Direcciones utilizadas anteriormente: </legend>
            <?php
            }
            if(isset($direcciones)){
	       		foreach($direcciones as $cadauna){
	       			$ciudad = Ciudad::model()->findByPk($cadauna->ciudad_id);
					$provincia = Provincia::model()->findByPk($cadauna->provincia_id);

			       $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
						'id'=>'direccionUsada',
						'enableAjaxValidation'=>false,
						'enableClientValidation'=>true,
						'clientOptions'=>array(
							'validateOnSubmit'=>true, 
						),
						'htmlOptions'=>array('class'=>'form-horizontal'),
					));
						
		            echo $form->hiddenField($cadauna, 'id', array('value'=>$cadauna->id,'type'=>'hidden'));	 	    
		            echo CHtml::hiddenField('tipo','direccionVieja');
					
		            echo "
		            <div class='row'>
		            
		              <div class='span2'>
		                <p><strong>".$cadauna->nombre." ".$cadauna->apellido."</strong><br/>
		                  <span class='muted small'> C.I. ".$cadauna->cedula."</span></p>
		                <p> <strong>Telefono</strong>: ".$cadauna->telefono."</p>
		              </div>
		              <div class='span3'>
		                <p><strong>Dirección:</strong> <br/>
		                  ".$cadauna->dirUno." </br>
		                  ".$cadauna->dirDos.". 
		                  ".$ciudad->nombre.", ".$provincia->nombre.". </br>
		                  ".$cadauna->pais." </p>
		              </div>
		              <div class='span2 margin_top_medium'>
		                <p>
					";
					
					$this->widget('bootstrap.widgets.TbButton', array(
			            'buttonType'=>'submit',
			            'type'=>'danger',
			            'size'=>'normal',
			            'label'=>'Usar esta dirección',
			        )); 
					
					echo"
		                <br/>
		                  <a style='cursor: pointer;' onclick='editar(".$cadauna->id.")' title='editar'>Editar</a> <br/>
		                  <a style='cursor: pointer;' onclick='eliminar(".$cadauna->id.")' title='eliminar'>Eliminar</a></p>
		              </div>
		            </div>
		            <hr/>
			  		";
			  		
			  	$this->endWidget();
			  		
			  	}
	  		}
			else {
			echo "<legend>No tiene direcciones registradas</legend>";					
			}
 	
      ?>
 	<?php if( count( $direcciones ) > 0 ){ ?>	      
       </fieldset>
      </form>
    </section>
    <?php } ?>

      
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'direccion_nueva',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true, 
	),
	'htmlOptions'=>array('class'=>'form-horizontal'),
)); 

?>
      
      <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form" enctype="multipart/form-data">
          <fieldset>
            <legend >Incluir una nueva dirección de envío: </legend>
            <div class="control-group"> 
             
              <div class="controls">
              	<?php echo $form->textFieldRow($dir,'nombre',array('class'=>'span4','maxlength'=>70,'placeholder'=>'Nombre de la persona a la que envias')); 
              	// <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Nombre de la persona a la que envias" name="RegistrationForm[email]" class="span4">
              	?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
             
              <div class="controls">
              	<?php echo $form->textFieldRow($dir,'apellido',array('class'=>'span4','maxlength'=>70,'placeholder'=>'Apellido de la persona a la que envias tu compra')); 
              	//  <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Apellido de la persona a la que envias tu compra" name="RegistrationForm[email]" class="span4">
              	?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
             
              <div class="controls">
              	<?php echo $form->textFieldRow($dir,'cedula',array('class'=>'span4','maxlength'=>20,'placeholder'=>'Cedula de Identidad de la persona a la que envias')); 
              	//  <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Cedula de Identidad de la persona a la que envias" name="RegistrationForm[email]" class="span4">
              	?>
               
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
           
              <div class="controls">
              	<?php echo $form->textFieldRow($dir,'dirUno',array('class'=>'span4','maxlength'=>120,'placeholder'=>'Direccion Linea 1: (Avenida, Calle, Urbanizacion, Conjunto Residencial, etc.)'));
				//<input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Direccion Linea 1: (Avenida, Calle, Urbanizacion, Conjunto Residencial, etc.)" name="RegistrationForm[email]" class="span4">
				 ?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
            
              <div class="controls">
              	<?php echo $form->textFieldRow($dir,'dirDos',array('class'=>'span4','maxlength'=>120,'placeholder'=>'Direccion Linea 2: (Edificio, Piso, Numero, Apartamento, etc)'));
				// <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Direccion Linea 2: (Edificio, Piso, Numero, Apartamento, etc)" name="RegistrationForm[email]" class="span4">
				 ?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
            
              <div class="controls">
              	<?php echo $form->textFieldRow($dir,'telefono',array('class'=>'span4','maxlength'=>45,'placeholder'=>'Numero de Telefono'));
				 ?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
              
              <div class="controls">
              	<?php echo $form->dropDownListRow($dir,'provincia_id', CHtml::listData(Provincia::model()->findAll(array('order' => 'nombre')),'id','nombre'), array('empty' => 'Seleccione un estado...'));?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
              <div class="controls">
              	<?php 
              	if($dir->provincia_id == ''){ 
              		echo $form->dropDownListRow($dir,'ciudad_id', array(), array('empty' => 'Seleccione una ciudad...'));
				}else{
					echo $form->dropDownListRow($dir,'ciudad_id', CHtml::listData(Ciudad::model()->findAllByAttributes(array('provincia_id'=>$dir->provincia_id), array('order' => 'nombre')),'id','nombre'));
				}
              	?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
            
              <div class="controls">
              	
              	 <?php // echo $form->dropDownListRow($dir, 'pais', array('Seleccione el País', 'Venezuela', 'Colombia', 'Estados Unidos')); 
              	
 	 			 ?>
 	 			 
 	 			 <input name="Direccion[pais]" id="Direccion_pais" type="hidden" value="Venezuela" />
 	 			 
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'danger',
            'size'=>'large',
            'label'=>'Usar esta dirección',
        )); 
        //  <a href="Proceso_de_Compra_3.php" class="btn-large btn btn-danger">Usar esta dirección</a> 
        ?>
            </div>
           
          </fieldset>
        </form>
      </section>
    </div>
  </div>
</div>
<!-- /container -->

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
	
	function eliminar(id)
	{
		
	var idDireccion = id;

	// llamada ajax para el controlador de bolsa	   
     	$.ajax({
	        type: "post",
	        url: "eliminardireccion", 
	        data: { 'idDir':idDireccion }, 
	        success: function (data) {
	        	
				if(data=="ok")
				{
					window.location.reload()
				}
					
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
			      url: "/"+path[1]+"/direccion/cargarCiudades",
			      type: "post",
			      data: { provincia_id : $(this).val() },
			      success: function(data){
			           $('#Direccion_ciudad_id').html(data);
			      },
			});
		}
	});
</script>
