<?php
Yii::app()->clientScript->registerLinkTag('stylesheet','text/css','https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700',null,null);
if (!Yii::app()->user->isGuest) { // que este logueado
    $userObject = User::model()->findByPk($user);
    
    $nombre = $userObject ? $userObject->profile->first_name." ".$userObject->profile->last_name:
                "";
?>

<div class="container margin_top">
    <div class="progreso_compra">
    <div class="clearfix margin_bottom">
      <div class="first-past"><?php echo Yii::t('contentForm','Authentication'); ?></div>
      <div class="middle-past">
        <?php echo Yii::t('contentForm','Shipping <br/>and billing<br/> address'); ?>
      </div>
      <div class="middle-past">
        <?php echo Yii::t('contentForm','Payment <br> method'); ?>
      </div>
      <div class="last-done">
        <?php echo Yii::t('contentForm','Confirm <br>purchase'); ?>
      </div>
    </div>
      
  </div>

  <div class="row">
    <div class="span8 offset2"> 
     
      <h1><?php echo Yii::t('contentForm','Shipping address'); ?>
          <br>
          <?php
          if($admin){
              echo "(Usuario: <b>{$nombre}</b>)"; 
          }
          ?>
      </h1>
      <p><?php echo Yii::t('contentForm','Choose an address for shipment of your purchase from your address book or enter a new one in the lower section'); ?></p>
      <?php 
      
//     	$usuario = Yii::app()->user->id; 
     	$usuario = $user; 
        $direcciones = Direccion::model()->findAllByAttributes(array('user_id'=>$usuario));
      
      ?>
	  <?php if( count( $direcciones ) > 0 ){ ?>
	  <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
          <fieldset>
            <legend ><?php echo Yii::t('contentForm','Addresses used above'); ?>: </legend>
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
		            echo CHtml::hiddenField('admin',$admin);
		            echo CHtml::hiddenField('user',$user);
					
		            echo "
		            <div class='row'>
		            
		              <div class='span2'>
		                <p><strong>".$cadauna->nombre." ".$cadauna->apellido."</strong><br/>
		                  <span class='muted small'> ".Yii::t('contentForm','C.I')." ".$cadauna->cedula."</span></p>
		                <p> <strong>".Yii::t('contentForm','Phone')."</strong>: ".$cadauna->telefono."</p>
		              </div>
		              <div class='span3'>
		                <p><strong>".Yii::t('contentForm','Address').":</strong> <br/>
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
			            'label'=>Yii::t('contentForm','Use this address'),
			        )); 
					
					echo"
		                <br/>
		                  <a style='cursor: pointer;' onclick='editar(".$cadauna->id.")' title='editar'>".Yii::t('contentForm','Edit')."</a> <br/>
		                  <a style='cursor: pointer;' onclick='eliminar(".$cadauna->id.")' title='eliminar' data-loading-text='Eliminando...' id='eliminar".$cadauna->id."'>".Yii::t('contentForm','Delete')."</a></p>
		              </div>
		            </div>
			  		<div class='mensaje".$cadauna->id."' ></div>
		            <hr/>";
			  		
			  		$this->endWidget();

			  	}
	  		}
			else {
				echo "<legend>".Yii::t('contentForm','You don\'t have any saved address')."</legend>";					
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
            <legend> <?php echo Yii::t('contentForm','Add a new shipping address'); ?>: </legend>
            <div class="control-group"> 
             
              <div class="controls">
              	<?php 
              	
              	echo CHtml::hiddenField('admin',$admin);
    			echo CHtml::hiddenField('user',$user);
              	echo $form->textFieldRow($dir,'nombre',array('class'=>'span4','maxlength'=>70,'placeholder'=>'Nombre de la persona a la que envias')); 
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
              	<?php echo $form->textFieldRow($dir,'telefono',array('class'=>'span4','maxlength'=>45,'placeholder'=>'Numero de Teléfono'));
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
						/*$criteria=new CDbCriteria;
						$criteria->addCondition('cod_zoom IS NULL'); 
						$criteria->addCondition('provincia_id ='.$dir->provincia_id); 
						*/
						//$criteria->order('nombre'); 
					//echo $form->dropDownListRow($dir,'ciudad_id', CHtml::listData(Ciudad::model()->findAllByAttributes(array(),"cod_zoom IS NOT NULL AND provincia_id =".$dir->provincia_id, array('order' => 'nombre')),'id','nombre'));
					echo $form->dropDownListRow($dir,'ciudad_id', CHtml::listData(Ciudad::model()->findAllBySql("SELECT * FROM tbl_ciudad WHERE provincia_id =".$dir->provincia_id." AND cod_zoom IS NOT NULL order by nombre ASC"),'id','nombre'));
					//echo $form->dropDownListRow($dir,'ciudad_id', CHtml::listData(Ciudad::model()->findAll($criteria),'id','nombre'));
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
			      },
			});
		}
	});
</script>
