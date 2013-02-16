<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Mi cuenta")=>array('micuenta'),
	UserModule::t("Eliminar"),
);
?>
<div class="container margin_top"> 
  <!-- SUBMENU ON -->
   <?php $this->renderPartial("_menu"); ?>
  <!-- SUBMENU OFF -->
  <div class="row">
    <div class="span6 offset3">
      <h1>Eliminar Cuenta</h1>
      <article class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
        <form method="post" action="" id="registration-form"   class="form-stacked personaling_form" enctype="multipart/form-data">
          
          
          <fieldset>
            <legend >Al borrar tu Cuenta de Personaling,  estas aceptando los siguientes apartados:</legend>
            <ul>
            	
<li>Borrar tu Cuenta sera algo PERMANENTE.
</li><li>Toda la informacion almacenada en tu Cuenta se borrara inmediatamente </li>



            </ul>
            <label class="checkbox">
              <input type="checkbox" value="">
              Acepto los Terminos & Condiciones y acepto ELIMINAR mi Cuenta PERMANENTEMENTE. </label>
      
            
            <div class="form-actions"> <a href="#" title="Guardar cambios" class="btn btn-danger">Borrar cuenta</a> </div>
          </fieldset>
        </form>
      </article>
    </div>
  </div>
</div>
<!-- /container -->
