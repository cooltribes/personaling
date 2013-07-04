<?php
/* @var $this ControlPanelController */


$usuarios_totales = User::model()->count();
$looks_totales = Look::model()->count();
$productos_activos = Producto::model()->countByAttributes(array('status'=>1,'estado'=>0));
$ventas = Orden::model()->count();
$looks_aprobar = Look::model()->countByAttributes(array('status'=>1)); // por aprobar

	$ordenes = Orden::model()->findAll();
	$sumatoria = 0;
	
	foreach($ordenes as $uno)
	{
		if($uno->estado != 5)
			$sumatoria = $sumatoria + $uno->total;	
	}

/* forma anterior */	
$sql = "SELECT sum(total) as total FROM tbl_orden";
$dinero_ventas = Yii::app()->db->createCommand($sql)->queryScalar();

$promedio = $sumatoria / $ventas;

?>

<div class="container margin_top">
  <div class="page-header">
    <h1>Panel de Control</h1>
  </div>
  <div class="row">
    <div class="span12">
      <div class="bg_color3 margin_bottom_small padding_small box_1"> <img src="<?php echo Yii::app()->baseUrl; ?>/images/stats_sample.png" alt="estadisticas"/> </div>
      <div class="row">
        <div class="span6 margin_top">
         <div class="well well_personaling_big"> 
                   <h4 class="margin_top CAPS">Estadisticas</h4>

         
         <table width="100%" border="0" class="table table-bordered table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <td><strong>Ventas Totales</strong>:</td>
              <td><?php echo Yii::app()->numberFormatter->formatDecimal($sumatoria); ?> Bs.</td>
            </tr>
            <tr>
              <td><strong> Promedio de Ventas</strong>:</td>
              <td><?php echo Yii::app()->numberFormatter->formatDecimal($promedio); ?> Bs / Venta.</td>
            </tr>
            <tr>
              <td><strong>Numero de Usuarios registrados</strong>:</td>
              <td><?php echo $usuarios_totales; ?></td>
            </tr>
            <tr>
              <td><strong> Numero de Looks creados</strong>:</td>
              <td><?php echo $looks_totales; ?></td>
            </tr>
            <tr>
              <td><strong>Numero de Looks Activos</strong>:</td>
              <td>24</td>
            </tr>
            <tr>
              <td><strong> Numero de Productos Activos</strong>:</td>
              <td><?php echo $productos_activos; ?></td>
            </tr>
          </table>
          <h4 class="margin_top">ACCIONES PENDIENTES</h4>
          <table width="100%" border="0" class="table table-bordered table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <td><strong>Looks por aprobar</strong>:</td>
              <td><?php echo $looks_aprobar; ?></td>
            </tr>
            <tr>
              <td><strong> Looks por publicar</strong>:</td>
              <td>35</td>
            </tr>
            <tr>
              <td><strong>Mensajes por leer</strong>:</td>
              <td>8</td>
            </tr>
          </table>
</div>        </div>
        <div class="span5 offset1 margin_top">
          <h4 class="margin_bottom_small">FUENTE DE REGISTROS</h4>
          <img src="<?php echo Yii::app()->baseUrl; ?>/images/stats2.png" alt="estadisticas "> </div>
      </div>
    </div>
  </div>
</div>
<!-- /container -->

