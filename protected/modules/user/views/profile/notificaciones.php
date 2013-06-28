<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Mi cuenta")=>array('micuenta'),
	UserModule::t("Notificaciones"),
);
?>
<div class="container margin_top tu_perfil"> 
 
  <div class="row">
  
   <!-- SIDEBAR ON -->
  <aside class="span3"> <?php echo $this->renderPartial('_sidebar'); ?> </aside>
  <!-- SIDEBAR ON --> 
    <div class="span9">
      <h1>Notificaciones</h1>
      <article class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
        <form method="post" action="" id="registration-form"   class="form-stacked personaling_form" enctype="multipart/form-data">
          <fieldset>
            <legend >Enviar notificaciones por correo para: </legend>
            <label class="checkbox">
              <input type="checkbox" value="">
              Recibir invitaciones a eventos de Personaling </label>
            <label class="checkbox">
              <input type="checkbox" value="">
              Recibir boletines de noticias de Personaling </label>
            <label class="checkbox">
              <input type="checkbox" value="">
              Participar en promociones de Personlaing </label>
            <label class="checkbox">
              <input type="checkbox" value="">
              Personaling puede usar mi imagen en campañas de redes sociales y testimonios del sitio. </label>
            <div class="clearfix">
              <label class="radio inline">
                <input type="radio" id="inlineCheckbox1" value="option1">
                Menusal </label>
              <label class="radio inline">
                <input type="radio" id="inlineCheckbox2" value="option2">
                Semanal </label>
              <label class="radio inline">
                <input type="radio" id="inlineCheckbox3" value="option3">
                Diario </label>
              <label class="radio inline">
                <input type="radio" id="inlineCheckbox3" value="option3">
                Instantáneo </label>
            </div>
            <div class="form-actions"> <a href="#" title="Guardar cambios" class="btn-large btn btn-danger">Guargar Cambios</a> </div>
          </fieldset>
        </form>
      </article>
    </div>
  </div>
</div>
<!-- /container -->
