<?php

if (!Yii::app()->user->isGuest) { // que este logueado

?>

<div class="container margin_top">
  <div class="row">
    <div class="span8 offset2"> 
      <div class="clearfix margin_bottom margin_top margin_left">
        <div class="first-done"></div>
        <div class="middle-not_done "></div>
        <div class="middle-not_done "></div>
        <div class="last-not_done"></div>
      </div>
      <h1>Dirección de envío</h1>
      <p>Elige una dirección para el envio de tu compra desde tu libreta de direcciones o ingresa una nueva en la seccion inferior:</p>
      <?php 
      
     	$usuario = Yii::app()->user->id;
      
      /* 
	   * lo de la libreta
	   * 
	   * <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked personaling_form" enctype="multipart/form-data">
          <fieldset>
            <legend >Direcciones utilizadas anteriormente: </legend>
            <div class="row">
              <div class="span2">
                <p> <strong>Johann Marquez</strong> <br/>
                  <span class="muted small"> C.I. 14.941.873</span></p>
                <p> <strong>Telefono</strong>: 0276-341.47.12 <br/>
                  <strong>Celular</strong>:   0414-724.80.43 </p>
              </div>
              <div class="span3">
                <p><strong>Dirección:</strong> <br/>
                  Urbanizacion Las Acacias.
                  Carrera 2. N 1-76
                  San Cristobal, Tachira 5001
                  Venezuela </p>
              </div>
              <div class="span2 margin_top_medium">
                <p><a href="Proceso_de_Compra_3.php" class="btn btn-danger">Usar esta dirección</a><br/>
                  <a href="#" title="editar">Editar</a> <br/>
                  <a href="#" title="eliminar">Eliminar</a></p>
              </div>
            </div>
            <hr/>
            <div class="row">
              <div class="span2">
                <p> <strong>Johann Marquez</strong> <br/>
                  <span class="muted small"> C.I. 14.941.873</span></p>
                <p> <strong>Telefono</strong>: 0276-341.47.12 <br/>
                  <strong>Celular</strong>:   0414-724.80.43 </p>
              </div>
              <div class="span3">
                <p><strong>Dirección:</strong> <br/>
                  Urbanizacion Las Acacias.
                  Carrera 2. N 1-76
                  San Cristobal, Tachira 5001
                  Venezuela </p>
              </div>
              <div class="span2 margin_top_medium">
                <p><a href="Proceso_de_Compra_3.php" class="btn btn-danger">Usar esta dirección</a><br/>
                  <a href="#" title="editar">Editar</a> <br/>
                  <a href="#" title="eliminar">Eliminar</a></p>
              </div>
            </div>
            <hr/>
          </fieldset>
        </form>
      </section>
	   * 
	   * */	  
      ?>
      
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'direccion_nueva',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>'form-stacked personaling_form'),
)); ?>
      
      <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
        <form method="post" action="/aiesec/user/registration?template=1" id="registration-form" class="form-stacked personaling_form" enctype="multipart/form-data">
          <fieldset>
            <legend >Incluir una nueva dirección de envío: </legend>
            <div class="control-group"> 
              <!--[if lte IE 7]>
            <label for="RegistrationForm_email" class="control-label required">Nombre de la persona a la que envias <span class="required">*</span></label>
<![endif]-->
              <div class="controls">
              	<?php echo $form->textField($dir,'nombre',array('class'=>'span5','maxlength'=>70,'placeholder'=>'Nombre de la persona a la que envias')); 
              	// <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Nombre de la persona a la que envias" name="RegistrationForm[email]" class="span5">
              	?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
              <!--[if lte IE 7]>
            <label for="RegistrationForm_email" class="control-label required">Apellido de la persona a la que envias tu compra<span class="required">*</span></label>
<![endif]-->
              <div class="controls">
              	<?php echo $form->textField($dir,'apellido',array('class'=>'span5','maxlength'=>70,'placeholder'=>'Apellido de la persona a la que envias tu compra')); 
              	//  <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Apellido de la persona a la que envias tu compra" name="RegistrationForm[email]" class="span5">
              	?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
              <!--[if lte IE 7]>
            <label for="RegistrationForm_email" class="control-label required">Cedula de Identidad de la persona a la que envias<span class="required">*</span></label>
<![endif]-->
              <div class="controls">
              	<?php echo $form->textField($dir,'cedula',array('class'=>'span5','maxlength'=>20,'placeholder'=>'Cedula de Identidad de la persona a la que envias')); 
              	//  <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Cedula de Identidad de la persona a la que envias" name="RegistrationForm[email]" class="span5">
              	?>
               
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
              <!--[if lte IE 7]>
            <label for="RegistrationForm_email" class="control-label required">Direccion Linea 1: (Avenida, Calle, Urbanizacion, Conjunto Residencial, etc.) <span class="required">*</span></label>
<![endif]-->
              <div class="controls">
              	<?php echo $form->textField($dir,'dirUno',array('class'=>'span5','maxlength'=>120,'placeholder'=>'Direccion Linea 1: (Avenida, Calle, Urbanizacion, Conjunto Residencial, etc.)'));
				//<input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Direccion Linea 1: (Avenida, Calle, Urbanizacion, Conjunto Residencial, etc.)" name="RegistrationForm[email]" class="span5">
				 ?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
              <!--[if lte IE 7]>
            <label for="RegistrationForm_email" class="control-label required">Direccion Linea 2: (Edificio, Piso, Numero, Apartamento, etc) </label>
<![endif]-->
              <div class="controls">
              	<?php echo $form->textField($dir,'dirDos',array('class'=>'span5','maxlength'=>120,'placeholder'=>'Direccion Linea 2: (Edificio, Piso, Numero, Apartamento, etc)'));
				// <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Direccion Linea 2: (Edificio, Piso, Numero, Apartamento, etc)" name="RegistrationForm[email]" class="span5">
				 ?>
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
              <!--[if lte IE 7]>
            <label for="RegistrationForm_email" class="control-label required">Ciudad <span class="required">*</span></label>
<![endif]-->
              <div class="controls">
              	<?php echo $form->textField($dir,'ciudad',array('class'=>'span5','maxlength'=>45,'placeholder'=>'Ciudad'));
				// <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Ciudad" name="RegistrationForm[email]" class="span5">
				 ?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
              <!--[if lte IE 7]>
            <label for="RegistrationForm_email" class="control-label required">Estado <span class="required">*</span></label>
<![endif]-->
              <div class="controls">
              	<?php echo $form->textField($dir,'estado',array('class'=>'span5','maxlength'=>45,'placeholder'=>'Estado'));
              	// <input type="text" maxlength="128" id="RegistrationForm_email" placeholder="Estado" name="RegistrationForm[email]" class="span5">
              	?>
                
                <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
              </div>
            </div>
            <div class="control-group"> 
              <!--[if lte IE 7]>
            <label for="RegistrationForm_email" class="control-label required">País <span class="required">*</span></label>
<![endif]-->
              <div class="controls">
              	
              	 <?php echo $form->dropDownList($dir, 'pais', array('Seleccione el País', 'Venezuela', 'Colombia', 'Estados Unidos')); 
              	 /*
				  * <select>
                  <option>Venezuela</option>
                  <option>Colombia</option>
                  <option>USA</option>
                </select>
				  * */
              	 ?>
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
	header('Location: /site/user/login');	
}


?>
