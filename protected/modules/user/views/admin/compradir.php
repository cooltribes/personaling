<?php
Yii::app()->clientScript->registerLinkTag('stylesheet','text/css','https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700',null,null);
if ((!Yii::app()->user->isGuest)&&isset(Yii::app()->session['usercompra'])) { // que este logueado como admin


                      	$ptcs = explode(',',Yii::app()->session['ptcs']);
						$vals= explode(',',Yii::app()->session['vals']);
						$totalPr=0;
						$i=0;
                      	foreach ($ptcs as $ptc) {
							$obj=Preciotallacolor::model()->findByPk($ptc);
							$totalPr+=(Precio::model()->getPrecioDescuento($obj->producto_id)*$vals[$i]);
							$i++;
								//echo $totalPr;
						 }
						
                      	
                      	$totalDe=0;
                      	$envio = 0;
						$i=0;
						
						if (empty($precios)) // si no esta vacio
						{}
						else{
							
							foreach($precios as $x){
	                      		$totalPr = $totalPr + ($x * $cantidades[$i]);
								$i++;
	                      	}
						}
					/*	foreach($descuentos as $y)
                      	{
                      		$totalDe = $totalDe + $y;
                      	}*/
						
						$iva = (($totalPr - $totalDe)*0.12); 
						
						$t = $totalPr - $totalDe + (($totalPr - $totalDe)*0.12) + $envio; 
						
						$seguro = $t*0.013;
						
						//$t += $seguro;
			 			
						// variables de sesion
						Yii::app()->getSession()->add('subtotal',$totalPr);
						Yii::app()->getSession()->add('descuento',$totalDe);
						Yii::app()->getSession()->add('envio',$envio);
						Yii::app()->getSession()->add('iva',$iva);
						Yii::app()->getSession()->add('total',$t);
						Yii::app()->getSession()->add('seguro',$seguro);  
						
						//echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($totalPr, '');
                      	?>


<div class="container margin_top">
    <div class="progreso_compra">
      <div class="clearfix margin_bottom">
 
        <div class="first-done">Dirección<br/>de envío <br/>y facturación</div>
        <div class="middle-not_done">Método <br/>de pago</div>
        <div class="last-not_done">Confirmar<br/>compra</div>
      </div>
      
  </div>

  <div class="row">
    <div class="span8 offset2"> 
     
      <h1>Dirección de envío</h1>
      <p>Elige una dirección para el envio de la compra desde la libreta de direcciones o ingresa una nueva en la seccion inferior:</p>
      <?php 
      $dir= new Direccion;
      
     	$usuario = Yii::app()->session['usercompra']; 
      
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
						'htmlOptions'=>array('class'=>'form-horizontal  direccion'.$cadauna->id ),
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
		                  <a style='cursor: pointer;' onclick='eliminar(".$cadauna->id.")' title='eliminar' data-loading-text='Eliminando...' id='eliminar".$cadauna->id."'>Eliminar</a></p>
		              </div>
		            </div>
			  		<div class='mensaje".$cadauna->id."' ></div>
		            <hr/>";
			  		
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
	
		window.location="editardireccion/id/"+id;
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
