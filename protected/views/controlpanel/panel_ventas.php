<div class="container margin_top">
  <div class="page-header">
    <h1>Panel de Ventas</h1>
  </div>
     <!-- SUBMENU ON -->
  
  <div class="navbar margin_top">
  <div class="navbar-inner">
    <ul class="nav">
  		<li><a href="#"  class="nav-header">Estadisticas:</a></li>
      	<li class="active" ><a title="Transacciones" href="#">Transacciones</a></li>
      	<li><a title="Pedidos" href="#">Pedidos</a></li>
    </ul>
  </div>
</div>
 
<?php

$ventas = Orden::model()->count();
$enviados = Orden::model()->countByAttributes(array('estado'=>4)); // enviados

$sql = "select sum(cantidad) from tbl_orden a, tbl_orden_has_productotallacolor b where a.estado = 4 and a.id = b.tbl_orden_id ";
$productos_enviados = Yii::app()->db->createCommand($sql)->queryScalar();


	$ordenes = Orden::model()->findAllByAttributes(array(), 'estado = :valor1 or estado = :valor2', array(':valor1'=>3,':valor2'=>4));
	$sumatoria = 0;
	
	foreach($ordenes as $uno)
	{
		$sumatoria = $sumatoria + $uno->total;	
	}

/* forma anterior */	
$sql = "SELECT sum(total) as total FROM tbl_orden";
$dinero_ventas = Yii::app()->db->createCommand($sql)->queryScalar();

if($ventas != 0)
	$promedio = $sumatoria / $ventas;
else
	$promedio = 0;
?>  
  
  <!-- SUBMENU OFF -->
  <div class="row">
    <div class="span12">
    	<div class="bg_color3 margin_bottom_small padding_small box_1"> 
			<img src="<?php echo Yii::app()->baseUrl; ?>/images/stats_sample.png" alt="estadisticas"/>
		</div>
      <div class="row margin_top">
        <div class="span6 ">
          <h4 class="CAPS braker_bottom margin_bottom_small">Estadisticas</h4>
          <table width="100%" border="0" class="table table-bordered  table-striped table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <td><strong>Ventas Totales</strong>:</td>
              <td><?php echo Yii::app()->numberFormatter->formatDecimal($sumatoria); ?> Bs.</td>
            </tr>
            <tr>
              <td><strong>Promedio de Ventas</strong>:</td>
              <td><?php echo Yii::app()->numberFormatter->formatDecimal($promedio); ?> Bs.</td>
            </tr>
            <tr>
              <td><strong>Impuestos</strong>:</td>
              <td>870</td>
            </tr>
            <tr>
              <td><strong>Envíos</strong>:</td>
              <td><?php echo $enviados; ?></td>
            </tr>
            <tr>
              <td><strong>Numero de Productos envíos</strong>:</td>
              <td><?php echo $productos_enviados; ?></td>
            </tr>
          </table>
        </div>
        <div class="span6">
          <h4 class="CAPS braker_bottom margin_bottom_small">VENTAS PENDIENTES</h4>
          <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <td><strong>Total Pagos Pendientes:</strong></td>
              <td> 10.430 Bs.</td>
            </tr>
            <tr>
              <td><strong>Promedio en Pagos Pendientes:</strong></td>
              <td>450 Bs.</td>
            </tr>
            <tr>
              <td><strong>Impuestos:</strong></td>
              <td>870 Bs.</td>
            </tr>
            <tr>
              <td><strong>Envios:</strong></td>
              <td>150 Bs.</td>
            </tr>
            <tr>
              <td><strong>Numero de Productos Pendientes:</strong></td>
              <td>150 Bs.</td>
            </tr>
          </table>
        </div>
      </div>
      
      
      
      
      <h2 class="braker_bottom margin_bottom_small">Mejores Ventas</h2>
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab1">Looks más vendidos</a></li>
        <li><a data-toggle="tab" href="#tab2">Productos mas vendidos</a></li>
        <li><a data-toggle="tab" href="#tab3">Marcas mas vendidas</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab1">
          <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <th scope="col">Nombre del Look</th>
              <th scope="col">Precio (Bs.)</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Total Vendidos (Bs.)</th>
            </tr>
            <tr>
              <td><a href="#" title="Ver Look">Look claro de verano</a></td>
              <td>4.000,00</td>
              <td>5</td>
              <td>Bs. 20.000,00</td>
            </tr>
            <tr>
              <td><a href="#" title="Ver Look">Look claro de verano</a></td>
              <td>4.000,00</td>
              <td>5</td>
              <td>Bs. 20.000,00</td>
            </tr>
            <tr>
              <td><a href="#" title="Ver Look">Look claro de verano</a></td>
              <td>4.000,00</td>
              <td>5</td>
              <td>Bs. 20.000,00</td>
            </tr>
          </table>
        </div>
        <div class="tab-pane" id="tab2">
        <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <th scope="col">Nombre del Producto</th>
              <th scope="col">Precio (Bs.)</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Total Vendidos (Bs.)</th>
            </tr>
            <tr>
              <td><a href="#" title="Ver producto">Blusa X</a></td>
              <td>4.000,00</td>
              <td>5</td>
              <td>Bs. 20.000,00</td>
            </tr>
            <tr>
              <td><a href="#" title="Ver producto">Blusa X</a></td>
              <td>4.000,00</td>
              <td>5</td>
              <td>Bs. 20.000,00</td>
            </tr>
            <tr>
              <td><a href="#" title="Ver producto">Blusa X</a></td>
              <td>4.000,00</td>
              <td>5</td>
              <td>Bs. 20.000,00</td>
            </tr>
          </table>
        </div>
        <div class="tab-pane" id="tab3">
        <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <th scope="col">Nombre de la marca</th>
              <th scope="col">Items vendidos</th>
              <th scope="col">Total Vendidos (Bs.)</th>
            </tr>
            <tr>
              <td>ALDO</td>
              <td>5</td>
              <td>Bs. 20.000,00</td>
            </tr>
            <tr>
              <td>MNG</td>
              <td>5</td>
              <td>Bs. 20.000,00</td>
            </tr>
            <tr>
              <td>Accesorize</td>
              <td>5</td>
              <td>Bs. 20.000,00</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /container -->