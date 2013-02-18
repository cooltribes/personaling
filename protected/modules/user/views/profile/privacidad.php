<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Profile")=>array('profile'),
	UserModule::t("Privacidad"),
);
?>
<div class="container margin_top"> 
  <!-- SUBMENU ON -->
  <?php $this->renderPartial("_menu"); ?>
  <!-- SUBMENU OFF -->
  <div class="row">
    <div class="span6 offset3">
      <h1>Privacidad</h1>
      <article class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
        <form method="post" action="" id="registration-form"   class="form-stacked personaling_form" enctype="multipart/form-data">
          <fieldset>
            <legend >Informacion de tu Cuenta </legend>
            <p>Los siguientes campos marcados estan publicamente abiertos:</p>
            
            <label class="checkbox">
              <input type="checkbox" value="">
              Nombre y Apellido</label>
            <label class="checkbox">
              <input type="checkbox" value="">
             Imagen de tu Perfil</label>
            <label class="checkbox">
              <input type="checkbox" value="">
             Looks que te Encantan </label>
            <label class="checkbox">
              <input type="checkbox" value="">
             Personal Shoppers sigues </label>
            
            <div class="form-actions"> <a href="#" title="Guardar cambios" class="btn-large btn btn-danger">Guargar Cambios</a> </div>
          </fieldset>
          
          
        </form>
      </article>
    </div>
  </div>
</div>