<div class="container margin_top">
  <div class="page-header">
    <h1>Panel de Productos</h1>
  </div>
     <!-- SUBMENU ON -->
  
  <div class="navbar margin_top">
  <div class="navbar-inner">
    <ul class="nav">
  	<li><a href="#" class="nav-header">CATALOGOS POR:</a></li>
      	<li><a title="Looks" href="<?php echo Yii::app()->baseUrl."/controlpanel/looks"; ?>">Looks</a></li>
      	<li class="active" ><a title="Productos" href="">Productos</a></li>
    </ul>
  </div>
</div>
 
<?php

$ventas = Orden::model()->count();
$enviados = Orden::model()->countByAttributes(array('estado'=>4)); // enviados

$sql = "select sum(cantidad) from tbl_orden a, tbl_orden_has_productotallacolor b where a.estado = 4 and a.id = b.tbl_orden_id ";
$productos_enviados = Yii::app()->db->createCommand($sql)->queryScalar();

	// el total de ordenes pagas o enviadas
	$totalpromedio = Orden::model()->countByAttributes(array(), 'estado = :valor1 or estado = :valor2 or estado = :valor3', array(':valor1'=>3,':valor2'=>4,':valor3'=>8));
	// cada una de esas ordenes
	$ordenes = Orden::model()->findAllByAttributes(array(), 'estado = :valor1 or estado = :valor2 or estado = :valor3', array(':valor1'=>3,':valor2'=>4,':valor3'=>8));
	$sumatoria = 0;
	$impuestos = 0;
	
	foreach($ordenes as $uno)
	{
		$sumatoria = $sumatoria + $uno->total;	
		$impuestos = $impuestos + $uno->iva;
	}

$a = substr($sumatoria,0,-1);
$b = substr($impuestos,0,-1);

/* forma anterior */	
$sql = "SELECT sum(total) as total FROM tbl_orden";
$dinero_ventas = Yii::app()->db->createCommand($sql)->queryScalar();

if($totalpromedio != 0)
	$promedio = $sumatoria / $totalpromedio;
else
	$promedio = 0;

$c = substr($promedio,0,-1);

	$pago_pendientes = 0;
	$pend = Orden::model()->findAllByAttributes(array('estado'=>1));
	$envios = 0;
	
	foreach($pend as $cada){
		$pago_pendientes = $pago_pendientes + $cada->total;
		$envios = $envios + $cada->envio + $cada->seguro;
	}

$d = substr($pago_pendientes,0,-1);

$pendiente = Orden::model()->countByAttributes(array('estado'=>1));

if($pendiente != 0)
	$e = $pago_pendientes / $pendiente;
else 
	$e = 0;

$f = substr($e,0,-1);
$g = substr($envios,0,-1);

$sql = "select sum(cantidad) from tbl_orden a, tbl_orden_has_productotallacolor b where a.estado = 1 and a.id = b.tbl_orden_id";
$productos_pendientes = Yii::app()->db->createCommand($sql)->queryScalar();

?>  
  
  <!-- SUBMENU OFF -->
  <div class="row">
    <div class="span12">
      
      
      <h2 class="braker_bottom margin_bottom_small">Productos</h2>
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab1">Número de visitas</a></li>
<!--        <li><a data-toggle="tab" href="#tab2">Status</a></li>-->
        
      </ul>
      <div class="tab-content">
      
        <div class="tab-pane active" id="tab1" >
            <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
              <tr>
                <th scope="col">Nombre del Producto</th>
                <th scope="col">Número de visitas</th>
                <th scope="col">Cantidad vendida</th>
                <th scope="col">Total de ventas</th>
              </tr>

          <?php
                 
          foreach($views->getData() as $record) {
                  if (isset($record)){
          ?>
                    <tr>
                        <td><a href="<?php echo $record->getUrl(); ?>" title="Ver Producto"><?php echo $record->nombre; ?></a></td>
                        <td><?php echo $record->view_counter; ?></td>
                        <td><?php echo $record->getCantVendidos(); ?></td>
                        <td>Bs. <?php //echo $record->getCantVendidos(); ?></td>
                    </tr>
          <?php
                  }
          }
          ?>  

          </table>
        </div>
              
    

       
      </div>
    </div>
  </div>
</div>
<!-- /container -->