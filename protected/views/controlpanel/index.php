<?php
/* @var $this ControlPanelController */

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
              <td>105.430 Bs.</td>
            </tr>
            <tr>
              <td><strong> Promedio de Ventas</strong>:</td>
              <td>350 Bs.</td>
            </tr>
            <tr>
              <td><strong>Numero de Usuarios registrados</strong>:</td>
              <td>870</td>
            </tr>
            <tr>
              <td><strong> Numero de Looks creados</strong>:</td>
              <td>150</td>
            </tr>
            <tr>
              <td><strong>Numero de Looks Activos</strong>:</td>
              <td>60</td>
            </tr>
            <tr>
              <td><strong> Numero de Productos Activos</strong>:</td>
              <td>1.490</td>
            </tr>
          </table>
          <h4 class="margin_top">ACCIONES PENDIENTES</h4>
          <table width="100%" border="0" class="table table-bordered table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <td><strong>Looks por aprobar</strong>:</td>
              <td>18</td>
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

