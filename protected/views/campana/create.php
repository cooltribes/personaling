<?php
/* @var $this CampanaController */

$this->breadcrumbs=array(
	'Campañas'=>array('/campana'),
	'Crear',
);
?>
<div class="container margin_top">

  <div class="page-header">
    <h1>Crear Campaña</h1>
  </div>
  <div class="row ">
    <div class="span9">
     
     	<?php echo $this->renderPartial('_form', array('model'=>$campana)); ?>
     
    </div>
    <div class="span3">
      <div class="padding_left"> <a href="admin_anadir_campana_2.php" title="Guardar" class="btn btn-danger btn-large btn-block">Siguiente / Guardar</a>
        <ul class="nav nav-stacked nav-tabs margin_top">
          <li><a href="#" title="Restablecer">Restablecer</a></li>
                      <li><a title="Pausar" href="admin_anadir_campana.php"> <i class="icon-pause"> </i> Pausar (solo debe salir Pausa o Play)</a></li>
            <li><a title="Play" href="admin_anadir_campana.php"> <i class="icon-play"> </i> Reanudar canpaña</a></li>

          <li><a href="#" title="Duplicar">Duplicar campaña</a></li>
          <li><a href="#" title="Guardar"><i class="icon-trash"></i> Borrar campaña</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<!-- /container -->