<div class="container margin_top">
  <div class="page-header">
    <h1>Panel de Ventas</h1>
  </div>
     <!-- SUBMENU ON -->
  
  <div class="navbar margin_top">
  <div class="navbar-inner">
    <ul class="nav">
  		<li><a href="#" class="nav-header">Estadisticas:</a></li>
      	<li class="active" ><a title="Transacciones" href="">Transacciones</a></li>
      	<li><a title="Pedidos" href="<?php echo Yii::app()->baseUrl."/controlpanel/pedidos"; ?>">Pedidos</a></li>
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

if($ventas != 0)
	$promedio = $sumatoria / $ventas;
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
$e = $pago_pendientes / $pendiente;

$f = substr($e,0,-1);
$g = substr($envios,0,-1);

$sql = "select sum(cantidad) from tbl_orden a, tbl_orden_has_productotallacolor b where a.estado = 1 and a.id = b.tbl_orden_id";
$productos_pendientes = Yii::app()->db->createCommand($sql)->queryScalar();

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
              <td><?php echo Yii::app()->numberFormatter->format("#,##0.00",$a); ?> Bs.</td>
            </tr>
            <tr>
              <td><strong>Promedio de Ventas</strong>:</td>
              <td><?php echo Yii::app()->numberFormatter->format("#,##0.00",$c); ?> Bs.</td>
            </tr>
            <tr>
              <td><strong>Impuestos</strong>:</td>
              <td><?php echo $b; ?> Bs.</td>
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
              <td><?php echo Yii::app()->numberFormatter->format("#,##0.00",$d); ?> Bs.</td>
            </tr>
            <tr>
              <td><strong>Promedio en Pagos Pendientes:</strong></td>
              <td><?php echo Yii::app()->numberFormatter->formatDecimal($f); ?> Bs.</td>
            </tr>
            <tr>
              <td><strong>Impuestos:</strong></td>
              <td>870 Bs.</td>
            </tr>
            <tr>
              <td><strong>Envios:</strong></td>
              <td><?php echo Yii::app()->numberFormatter->format("#,##0.00",$g); ?> Bs.</td>
            </tr>
            <tr>
              <td><strong>Numero de Productos Pendientes:</strong></td>
              <td><?php echo $productos_pendientes; ?></td>
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
      
      <div class="tab-pane active" id="tab1" >
          <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <th scope="col">Nombre del Look</th>
              <th scope="col">Precio (Bs.)</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Total Vendidos (Bs.)</th>
            </tr>
            		
      	<?php
      		$x = new Look;
			$looksmas = $x->masvendidos(5);
			

	foreach($looksmas->getData() as $record) {
			
		$lk = Look::model()->findByPk($record['look_id']);
		
		$pre = (float) $lk->getPrecio(false); 
		$tt = (int) $record['looks'];
		
		$ppp = $pre * $tt;
		
		if (isset($lk)){
		
      	?>
        	<tr>
              <td><a href="<?php echo Yii::app()->baseUrl."/look/".$lk->id; ?>" title="Ver Look"><?php echo $lk->title; ?></a></td>
              <td>Bs. <?php echo $lk->getPrecio(); ?></td>
              <td><?php echo $record['looks']; ?></td>
              <td>Bs. <?php echo $ppp; ?></td>
          	</tr>
	<?php
		}
	}
	?>  
	
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
      	<?php
      		$x = new Producto;
			$prodmas = $x->masvendidos(5);
			
	
		foreach($prodmas->getData() as $record) {
				
			$pro = Producto::model()->findByPk($record['producto_id']);
			
			$pre = Precio::model()->findByAttributes(array('tbl_producto_id'=>$pro->id));
			$tt = (int) $record['productos'];
			
			$ppp = $pre->precioDescuento * $tt;
			
			if (isset($pro)){
      	?>      
            
            <tr>
              <td><a href="<?php echo Yii::app()->baseUrl."/producto/detalle/".$pro->id; ?>" title="Ver producto"><?php echo $pro->nombre; ?></a></td>
              <td>Bs. <?php echo $pre->precioDescuento; ?></td>
              <td><?php echo $record['productos']; ?></td>
              <td>Bs. <?php echo $ppp; ?></td>
            </tr>
       <?php      
			}
		}
       ?>     
          </table>
        </div>
        
        <div class="tab-pane" id="tab3">
        <table width="100%" border="0" class="table table-bordered table-striped table-condensed"  cellspacing="0" cellpadding="0">
            <tr>
              <th scope="col">Nombre de la marca</th>
              <th scope="col">Items vendidos</th>
              <th scope="col">Total Vendidos (Bs.)</th>
            </tr>
      <?php
      		$x = new Marca;
			$marcasmas = $x->masvendidos(5);

		foreach($marcasmas->getData() as $record) {
				
			$indiv = Marca::model()->findByPk($record['marca']);
			
			
			
$sql = "SELECT SUM(tbl_orden_has_productotallacolor.cantidad) as productos,producto_id, tbl_precio.precioDescuento FROM tbl_orden_has_productotallacolor
		left join tbl_precioTallaColor on tbl_orden_has_productotallacolor.preciotallacolor_id = tbl_precioTallaColor.id
		left join tbl_imagen on tbl_precioTallaColor.producto_id = tbl_imagen.tbl_producto_id
		left join tbl_producto on tbl_producto.id = tbl_precioTallaColor.producto_id
		left join tbl_marca on tbl_marca.id = tbl_producto.marca_id
		left join tbl_precio on tbl_precio.tbl_producto_id = tbl_producto.id
		where tbl_imagen.orden = 1 and tbl_producto.status = 1 and tbl_producto.estado = 0 and marca_id =".$indiv->id." GROUP BY producto_id ORDER by productos DESC";
		
		$count = 50; 	
		
		$data = new CSqlDataProvider($sql, array(
		    'totalItemCount'=>$count,		    

		));  	
		
		$totalp = 0;
		
		foreach($data->getData() as $cadauno)
		{
			$precio = $cadauno['precioDescuento'];
			$cantidad = $cadauno['productos'];
			
			$totalp = $totalp + ($precio * $cantidad);
		}	
			
			if (isset($marcasmas)){
      	?>        
            <tr>
              <td><?php echo $indiv->nombre; ?></td>
              <td><?php echo $record['uno']; ?></td>
              <td>Bs. <?php echo Yii::app()->numberFormatter->format("#,##0.00",$totalp); ?></td>
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