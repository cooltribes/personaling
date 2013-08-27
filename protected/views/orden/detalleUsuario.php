<?php

$this->breadcrumbs=array(
	'Pedidos'=>array('listado'),
	'Detalle del pedido',
);

$usuario = User::model()->findByPk($orden->user_id); 

?>
	<?php if(Yii::app()->user->hasFlash('success')){?>
	    <div class="alert in alert-block fade alert-success text_align_center">
	        <?php echo Yii::app()->user->getFlash('success'); ?>
	    </div>
	<?php } ?>
	<?php if(Yii::app()->user->hasFlash('error')){?>
	    <div class="alert in alert-block fade alert-error text_align_center">
	        <?php echo Yii::app()->user->getFlash('error'); ?>
	    </div>
	<?php } ?>
<div class="container margin_top">
  <div class="page-header">
    <h1>PEDIDO #<?php echo $orden->id; ?></h1>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table ">
    <tr>
      <th scope="col" colspan="4">Fecha del Pedido: 
      	<?php
      	
      	if($orden->fecha!="")
   			echo date("d/m/Y - h:i a",strtotime($orden->fecha)).".";
      	
      	?>
      	</th>
      <th scope="col" colspan="2"></th>
    </tr>
    <tr>
      <td><p class="T_xlarge margin_top_xsmall color1">
<?php
//----------------------Estado
	if($orden->estado == 1)
		echo "En espera de pago"; 
	
	if($orden->estado == 2)
		echo "Espera confirmación";
	
	if($orden->estado == 3)
		echo "Pago Confirmado";
	
	if($orden->estado == 4)
		echo "Pedido Enviado";	
			
	if($orden->estado == 5)
		echo "Orden Cancelada";
	
	if($orden->estado == 6)
		echo "Pago Rechazado";	
		
	if($orden->estado == 7)
		echo "Pago Insuficiente";
	
	// agregar demas estados
?>
      	</p>
        Estado actual</td>
      <td><p class="T_xlarge margin_top_xsmall"> 4 </p>
        Documentos</td>
      <td><p class="T_xlarge margin_top_xsmall"> 4</p>
        Prendas<br/></td>
      <td><p class="T_xlarge margin_top_xsmall"><?php 
      
	if($orden->estado == 7)
	{
		$balance = Balance::model()->findByAttributes(array('user_id'=>$usuario->id,'orden_id'=>$orden->id));
		$a = $balance->total * -1;
		echo Yii::app()->numberFormatter->formatDecimal($a); 
	}
	else
	{
		$balance = Balance::model()->findByAttributes(array('user_id'=>$usuario->id,'orden_id'=>$orden->id, 'tipo'=>0));
		
		if(isset($balance))
		{
			if($balance->total < 0){
				$a = $balance->total * -1;
				echo Yii::app()->numberFormatter->formatDecimal($a);
			}
			else {
				echo Yii::app()->numberFormatter->formatDecimal($orden->total);
			}
		}
		else {
				echo Yii::app()->numberFormatter->formatDecimal($orden->total);
			}
		
	}	
       ?></p>
        
        <?php
//----------------------Estado
	if($orden->estado == 1)
		echo "Bs. Pendientes por pagar"; 
	
	if($orden->estado == 2)
		echo "Bs. Pendientes por confirmar";
	
	if($orden->estado == 3)
		echo "Bs. ya pagados";

	if($orden->estado == 4)
		echo "Bs. ya pagados";				
	
	if($orden->estado == 5)
		echo "Orden Cancelada";
	
	if($orden->estado == 7)
		echo "Bs. que faltan.";
	
	// agregar demas estados
?>
       </td>
 		<td><a href="#myModal" role="button" class="btn btn-info margin_top pull-right" data-toggle="modal" ><i class="icon-check icon-white"></i> Reportar Pago </td>
      	<td><a onclick="window.print();" class="btn margin_top pull-right"><i class="icon-print"></i> Imprimir pedido</a></td>
    </tr>
  </table>
  <hr/>
  <div class="row">
    <div class="span7">

      	<?php
      	
			$detalles = Detalle::model()->findAllByAttributes(array('orden_id'=>$orden->id));
          	$pago = Pago::model()->findByAttributes(array('id'=>$orden->pago_id));
			
			if($orden->estado != 1 && $orden->estado != 5){
			
			echo("
	          	<div id='pago' class='well well-small margin_top well_personaling_small'>
	          	<h3 class='braker_bottom '> Método de Pago</h3>
	        		<table width='100%' border='0' cellspacing='0' cellpadding='0' class='table table-bordered table-hover table-striped'>
	          		<tr>
	            		<th scope='col'>Fecha</th>
	            		<th scope='col'>Método de pago</th>
	            		<th scope='col'>ID de Transaccion</th>
	            		<th scope='col'>Monto</th>
	          		</tr>
	          	");	
			
			foreach($detalles as $detalle){
					
				echo("<tr>");
						
					if($detalle->estado == 0  && $detalle->nTransferencia!="") // stand by
					{
					
						echo("<td>".date("d/m/Y - h:i a",strtotime($detalle->fecha))."</td>");
						
						if($pago->tipo == 1)
							echo("<td>Deposito en espera de confirmacion</td>");
							//hacer los demas tipos
							
						echo("<td>".$detalle->nTransferencia."</td>");	
						echo("<td>".Yii::app()->numberFormatter->formatDecimal($detalle->monto)." Bs.</td>");
					}
					else			
						if($detalle->estado == 1) // si fue aceptado
						{
			          	
							echo("<td>".date("d/m/Y - h:i a",strtotime($detalle->fecha))."</td>");
							
							if($pago->tipo == 1)
								echo("<td>Deposito o Transferencia</td>");
							if($pago->tipo == 2)
								echo("<td>Tarjeta de credito</td>");
								//hacer los demas tipos
									
							echo("<td>".$detalle->nTransferencia."</td>");	
							echo("<td>".Yii::app()->numberFormatter->formatDecimal($detalle->monto)." Bs.</td>");

						}
					else if($detalle->estado == 2) // rechazado
						{
							
						echo("<td>".date("d/m/Y - h:i a",strtotime($detalle->fecha))."</td>");
						
						if($pago->tipo == 1)
							echo("<td>Deposito o Transferencia</td>");
							//hacer los demas tipos
								
						echo("<td> PAGO RECHAZADO </td>");	
						echo("<td>".Yii::app()->numberFormatter->formatDecimal($detalle->monto)." Bs.</td>");
							
						}
					
				echo("</tr>");
				}//foreach
				
				echo("</table></div>");
				}
		  	?>    
      
     <?
     	if($orden->estado == 4) // enviado
     	{
     ?>      
      	
      <div class="well well-small margin_top well_personaling_small">
        <h3 class="braker_bottom "> Envio </h3>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
          <tr>
            <th scope="col">Fecha estimada de entrega</th>
            <th scope="col">Tipo</th>
            <th scope="col">Transportista</th>
            <th scope="col">Peso</th>
            <th scope="col">Costo de envio</th>
            <th scope="col">Numero de seguimiento</th>
          </tr>
          <tr>
            <td>21/12/2012 - 12:21 PM</td>
            <td>Delivery</td>
            <td>Zoom</td>
            <td>0,00 Kg.</td>
            <td><?php echo $orden->envio; ?> Bs.</td>
            <td><?php echo $orden->tracking; ?></td>
          </tr>
        </table>
      </div>
      <?php
      
		}
      ?>
      
      <div class="row-fluid">
      	<div class="span12">
          <h3 class="braker_bottom margin_top">Dirección de envío</h3>
          <div class="vcard">
            <div class="adr">
            	<?php
            	$direccionEnvio = DireccionEnvio::model()->findByPk($orden->direccionEnvio_id);
            	$ciudad = Ciudad::model()->findByPk($direccionEnvio->ciudad_id);
				$provincia = Provincia::model()->findByPk($direccionEnvio->provincia_id);
            	?>
              <div class="street-address"><i class="icon-map-marker"></i><?php echo " ".$direccionEnvio->nombre." ".$direccionEnvio->apellido.". "; echo $direccionEnvio->dirUno.", ".$direccionEnvio->dirDos;  ?></div>
              <span class="locality"><?php echo $ciudad->nombre ?>, <?php echo $provincia->nombre; ?>.</span>
              <div class="country-name"><?php echo $direccionEnvio->pais; ?></div>
            </div>
            <div class="tel margin_top_small"> <span class="type"><strong>Telefono</strong>:</span><?php echo $direccionEnvio->telefono; ?></div>
            <div><strong>Email</strong>: <span class="email"><?php echo $usuario->email; ?></span> </div>
          </div></div>
		
		<!--
        <div class="span6">
          <h3 class="braker_bottom margin_top">Dirección de Facturación</h3>
          <div class="vcard">
            <div class="adr">
              <div class="street-address"><i class="icon-map-marker"></i> Av. 5ta. Edificio Los Mirtos  Piso 3. Oficina 3-3</div>
              <span class="locality">San Cristobal, Tachira 5001</span>
              <div class="country-name">Venezuela</div>
            </div>
            <div class="tel margin_top_small"> <span class="type"><strong>Telefono</strong>:</span> 0276-341.47.12 </div>
            <div class="tel"> <span class="type"><strong>Celular</strong>:</span> 0414-724.80.43 </div>
            <div><strong>Email</strong>: <span class="email">info@commerce.net</span> </div>
    	</div>
        </div>
       -->
       
      </div>
    </div>
    <div class="span5">
      <div class="well well_personaling_big">
        <h3 class="braker_bottom"><strong>Progreso del pedido</strong></h3>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
          <tr>
            <th scope="col">Estado</th>
            <th scope="col">Usuario</th>
            <th scope="col">Fecha</th>
          </tr>
          <?php
          
          $estados = Estado::model()->findAllByAttributes(array('orden_id'=>$orden->id),array('order'=>'id DESC'));
          
		  	foreach ($estados as $est)
		  	{
		  		echo("<tr>");
				
				if($est->estado==1)
					echo("<td>Pendiente de Pago</td>");
				
				if($est->estado==2)
					echo("<td>Pendiente por confirmar</td>");
				
				if($est->estado==3)
					echo("<td>Pago Confirmado</td>");
				
				if($est->estado == 4)
					echo("<td>Pedido Enviado</td>");
				
				if($est->estado==5)
					echo("<td>Orden Cancelada</td>");
				
				if($est->estado==6)
					echo("<td>Pago Rechazado</td>");
				
				if($est->estado == 7)
					echo "<td>Pago Insuficiente</td>";
				
				$usu = User::model()->findByPk($est->user_id);
				echo ("<td>".$usu->profile->first_name." ".$usu->profile->last_name."</td>");
				
				$fecha = date("d/m/Y",strtotime($est->fecha));
				echo("<td>".$fecha." </td>");
            	echo("</tr>");
		  	}
		  
          ?>
          <tr>
            <td>Nuevo Pedido</td>
            <td><?php echo $usuario->profile->first_name." ".$usuario->profile->last_name; ?></td>
            <td><?php echo date("d/m/Y",strtotime($orden->fecha)); ?></td>
          </tr>
        </table>
      </div>
      
  <div class="well well-small margin_top well_personaling_small">  <h3 class="braker_bottom margin_top"> Documentos</h3>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
          <th scope="col">Fecha</th>
          <th scope="col">Documento</th>
          <th scope="col">Número</th>
        </tr>
        <?php
        $factura = Factura::model()->findByAttributes(array('orden_id'=>$orden->id));
		if($factura){
	        ?>
	        <tr>
	          <td>
	          	<?php
	          	echo date('d/m/Y', strtotime($factura->fecha));
	          	?>
	          </td>
	          <td>
	          	Factura
	          </td>
	          <td>
	          	<?php
	          	echo str_pad($factura->id, 4, '0', STR_PAD_LEFT);
	          	?>
	          </td>
	        </tr>
	        <tr>
	          <td>
	          	<?php
	          	echo date('d/m/Y', strtotime($factura->fecha));
	          	?>
	          </td>
	          <td>
	          	<?php
	          	echo CHtml::link('Recibo de Pago', $this->createUrl('recibo', array('id'=>$factura->id)), array('target'=>'_blank'));
	          	?>
	          </td>
	          <td>
	          	<?php
	          	echo str_pad($factura->id, 4, '0', STR_PAD_LEFT);
	          	?>
	          </td>
	        </tr>
	        <?php
		}
        ?>

      </table></div>
    </div>
  </div>
  <hr/>
  <!-- INFORMACION DEL PEDIDO ON -->
  <div class="row">
    <div class="span7">
   <div class="well well-small margin_top well_personaling_small">   <h3 class="braker_bottom margin_top">Productos </h3> <p class="muted t_small CAPS"> (Precios expresados en Bs.)</p>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
          <th scope="col">Nombre de la prenda</th>
          <th scope="col">Cant.</th>
          <th scope="col">Total</th>
        </tr>
        
         <?php
        
        	$productos = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id)); // productos de la orden
        	
			foreach ($productos as $prod) {
				
				if($prod->look_id != 0) // si es look
				{

					$ptc = PrecioTallaColor::model()->findByAttributes(array('id'=>$prod->preciotallacolor_id)); // consigo existencia actual
					
					$lookpedido = Look::model()->findByPk($prod->look_id); // consigo nombre					
					$precio = $lookpedido->getPrecio(false);
						
						echo("<tr>");
						echo("<td>".$lookpedido->title."</td>"); // nombre
						echo("<td>".$prod->cantidad."</td>"); // cantidad en pedido
						echo("<td>".$prod->precio."</td>"); // precio 
						
						/*
						setlocale(LC_MONETARY, 've_VE');
						//$a = money_format('%i', $precio->precioVenta);
						//$c = money_format('%i', $precio->ahorro);
						//$des = money_format('%i', $precio->precioDescuento);
						$iva = $precio * 0.12;
						
						$b = $precio * $prod->cantidad;					
						echo("<td>".Yii::app()->numberFormatter->formatDecimal($b)."</td>"); // subtotal
						
						$e = $iva * $prod->cantidad;
						echo("<td>".Yii::app()->numberFormatter->formatDecimal($e)."</td>"); // impuesto
										
						echo("<td> desc look </td>"); //descuento del look
	
						$f = $b + $e;
						echo("<td>".Yii::app()->numberFormatter->formatDecimal($f)."</td>"); //total
						*/
						
						echo("</tr>");	

				}
				else // individual
				{
					$ptc = PrecioTallaColor::model()->findByAttributes(array('id'=>$prod->preciotallacolor_id)); // consigo existencia actual
					$indiv = Producto::model()->findByPk($ptc->producto_id); // consigo nombre
					$precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$ptc->producto_id)); // precios
					
					echo("<tr>");
					echo("<td>".$indiv->nombre."</td>"); // nombre
					echo("<td>".$prod->cantidad."</td>"); // cantidad en pedido
					echo("<td>".$prod->precio."</td>"); // precio
					/*
					
					setlocale(LC_MONETARY, 've_VE');
					$a = money_format('%i', $precio->precioVenta);
					$c = money_format('%i', $precio->ahorro);
					$des = money_format('%i', $precio->precioDescuento);
					$iva = $precio->precioDescuento * 0.12;
					
					$b = $a * $prod->cantidad;					
					echo("<td>".Yii::app()->numberFormatter->formatDecimal($b)."</td>"); // subtotal
					
					$e = $iva * $prod->cantidad;
					echo("<td>".Yii::app()->numberFormatter->formatDecimal($e)."</td>"); // impuesto
					
					$d = $c * $prod->cantidad;					
					echo("<td>".Yii::app()->numberFormatter->formatDecimal($d)."</td>"); //descuento

					$f = $des * $prod->cantidad;
					echo("<td>".Yii::app()->numberFormatter->formatDecimal($f)."</td>"); //total
					*/
					
					echo("</tr>");				
				}				
				
			}
        
        ?>
      </table></div></div>
      
      <?php
      $individuales=0;
	  $looks=0;
      $compra = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id));
	
		foreach ($compra as $tot) {
			
			if($tot->look_id == 0)
			{
				$individuales++;
			}else{
				$looks++;
			}
			
		}
      
      ?>
      
    <div class="span5">
      <div class="well well-small margin_top well_personaling_small"> <h3 class="braker_bottom margin_top"> Resumen del Pedido</h3>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
          <th scope="col">No de Looks</th>
          <th scope="col"><?php echo($looks); ?></th>
        </tr>
        <tr>
          <td>No de Prendas</td>
          <td><?php echo($individuales); ?></td>
        </tr>
        <tr>
          <td>SubTotal</td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->subtotal). " Bs."; ?></td>
        </tr>
        <tr>
          <td>Descuento</td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->descuento). " Bs."; ?></td>
        </tr>
        <tr>
          <td>Envio y Transporte</td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->envio). " Bs."; ?></td>
        </tr>
        <tr>
          <td>Impuesto</td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->iva). " Bs."; ?></td>
        </tr>
        <tr>
          <td>Total</td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->total). " Bs."; ?></td>
        </tr>
      </table></div>
    </div>
  </div>
  <!-- INFORMACION DEL PEDIDO OFF -->
  <hr/>
  
<?php /*?> 
Para una futura iteración
<!-- MENSAJES ON -->
   	<div class="row">
    <div class="span7">
      <h3 class="braker_bottom margin_top">MENSAJES</h3>
      <form>
        <div class="control-group">
          <select>
            <option>Elija un mensaje estandar</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
          </select>
        </div>
        <div class="control-group">
          <textarea name="Mensaje" cols="" class="span7" rows="4"></textarea>
        </div>
        <div class="control-group">
          <label class="checkbox">
            <input type="checkbox" value="">
            Notificar al Cliente por eMail </label>
          <label class="checkbox">
            <input type="checkbox" value="">
            Hacer visible en el Frontend</label>
        </div>
        <div class="form-actions"><a href="#" title="Enviar" class="btn btn-inverse">Enviar comentario</a> </div>
      </form>
    </div>
 * 
 * */
 ?>
  <div class="span5">
      <h3 class="braker_bottom margin_top">Historial de Mensajes</h3>
      
  <?php
      
      	$mensajes = Mensaje::model()->findAllByAttributes(array('orden_id'=>$orden->id,'user_id'=>$orden->user_id));
      	
		if(count($mensajes) > 0)
		{
			?>	
			<ul class="media-list">
			<?php
				foreach($mensajes as $msj)
				{
					echo '<li class="media braker_bottom">
          					<div class="media-body">';
					echo '<h4 class="color4"><i class=" icon-comment"></i> Asunto: '.$msj->asunto.'</h4>';	
					echo '<p class="muted"><strong>'.date('d/m/Y', strtotime($msj->fecha)).'</strong> '.date('h:i A', strtotime($msj->fecha)).'<strong>| Recibido | Cliente: Notificado</strong></p>';
					echo '<p>'.$msj->cuerpo.'</p>';					
				}
			?>
			</ul>
			<?php
		}
		else {
			echo '<h4 class="color4">No se han enviado mensajes.</h4>';	
		}
      
      ?>
 
 	</div>
  <!--
    <div class="span5">
      <h3 class="braker_bottom margin_top">Historial de Mensajes</h3>
      <ul class="media-list">
        <li class="media braker_bottom">
          <div class="media-body">
            <h4 class="color4"><i class=" icon-comment"></i> Asunto: XXX YYY ZZZ</h4>
            <p class="muted"> <strong>23/03/2013</strong> 12:35 PM <strong>| Recibido | Cliente: <strong>Notificado</strong> </strong></p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate </p>
            <!-- Nested media object --> 
    <!--         
          </div>
        </li>
        <li class="media braker_bottom">
          <div class="media-body">
            <h4 class="color4"><i class=" icon-comment"></i> Asunto: XXX YYY ZZZ</h4>
            <p class="muted"> <strong>23/03/2013</strong> 12:35 PM <strong>| Recibido | Cliente: <strong>Notificado</strong> </strong></p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate </p>
            <!-- Nested media object --> 
    <!--         
          </div>
        </li>
        <li class="media braker_bottom">
          <div class="media-body">
            <h4 class="color4"><i class=" icon-comment"></i> Asunto: XXX YYY ZZZ</h4>
            <p class="muted"> <strong>23/03/2013</strong> 12:35 PM <strong>| Recibido | Cliente: <strong>Notificado</strong> </strong></p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate </p>
            <!-- Nested media object --> 
            
          </div>
        </li>
      </ul>
    </div>
    
    
 <!-- </div> 
 <!-- MENSAJES OFF --> 

</div>
<!-- /container --> 

<!------------------- MODAL WINDOW ON -----------------> 

<!-- Modal 1 -->
<div id="myModal-prueba" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Desea aceptar este pago?</h3>
  </div>
  <div class="modal-body">
    <p><strong>Detalles</strong></p>
    <ul>
      <li><strong>Usuaria</strong>: Maria Perez</li>
      <li><strong>Fecha de compra</strong>: 18/10/1985</li>
      <li><strong>Monto</strong>: Bs. 6.500</li>
    </ul>
  </div>
  <div class="modal-footer"><a href="" title="ver" class="btn-link" target="_blank">Cancelar </a> <a href="#" title="Confirmar" class="btn btn-success">Aceptar el pago</a> </div>
</div>
<!------------------- MODAL WINDOW OFF ----------------->

<!-- Modal Window -->
<?php 

if($orden->estado == 7){
	$detPago = new Detalle;
	?>
	<input type="hidden" id="idDetalle" value="0" />
	<input type="hidden" id="idOrden" value="<?php echo $orden->id; ?>" />
	<?php
}
else{
	$detPago = Detalle::model()->findByPk($orden->detalle_id);
	?>
	<input type="hidden" id="idDetalle" value="<?php echo($orden->detalle_id); ?>" />
	<input type="hidden" id="idOrden" value="<?php echo $orden->id; ?>" />
	<?php
}
?>
<div class="modal hide fade" id="myModal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4>Agregar Depósito o Transferencia bancaria ya realizada</h4>
  </div>
  <div class="modal-body">
    <form class="">
      <div class="control-group"> 
        <!--[if lte IE 7]>
            <label class="control-label required">Nombre del Depositante <span class="required">*</span></label>
<![endif]-->
        <div class="controls">
          <?php echo CHtml::activeTextField($detPago,'nombre',array('id'=>'nombre','class'=>'span5','placeholder'=>'Nombre del Depositante')); ?>
          <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
        </div>
      </div>
      <div class="control-group"> 
        <!--[if lte IE 7]>
            <label class="control-label required">Número o Código del Depósito<span class="required">*</span></label>
<![endif]-->
        <div class="controls">
        	<?php echo CHtml::activeTextField($detPago,'nTransferencia',array('id'=>'numeroTrans','class'=>'span5','placeholder'=>'Número o Código del Depósito')); ?>
          <div style="display:none" class="help-inline"></div>
        </div>
      </div>
		<div class="control-group"> 
        <!--[if lte IE 7]>
            <label class="control-label required">Nombre del Depositante <span class="required">*</span></label>
<![endif]-->
        <div class="controls">
        	<?php echo CHtml::activeDropDownList($detPago,'banco',array('Seleccione'=>'Seleccione','Banesco'=>'Banesco. Cuenta: 0134 0277 98 2771093092'),array('id'=>'banco','class'=>'span5')); ?>
          	<?php //echo CHtml::activeTextField($detPago,'banco',array('id'=>'banco','class'=>'span5','placeholder'=>'Banco donde se realizó el deposito')); ?>
          <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
        </div>
      </div>
      <div class="control-group"> 
        <!--[if lte IE 7]>
            <label class="control-label required">Nombre del Depositante <span class="required">*</span></label>
<![endif]-->
        <div class="controls">
          <?php echo CHtml::activeTextField($detPago,'cedula',array('id'=>'cedula','class'=>'span5','placeholder'=>'Cedula del Depositante')); ?>
          <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
        </div>
      </div>
      <div class="control-group"> 
        <!--[if lte IE 7]>
            <label class="control-label required">Nombre del Depositante <span class="required">*</span></label>
<![endif]-->
        <div class="controls">
          <?php echo CHtml::activeTextField($detPago,'monto',array('id'=>'monto','class'=>'span5','placeholder'=>'Monto')); ?>
          <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
        </div>
      </div>
      <div class="controls controls-row"> 
        <!--[if lte IE 7]>
            <label class="control-label required">Fecha del depósito DD/MM/YYY<span class="required">*</span></label>
<![endif]-->
<?php echo CHtml::TextField('dia','',array('id'=>'dia','class'=>'span1','placeholder'=>'Día')); ?>
<?php echo CHtml::TextField('mes','',array('id'=>'mes','class'=>'span1','placeholder'=>'Mes')); ?>
<?php echo CHtml::TextField('ano','',array('id'=>'ano','class'=>'span2','placeholder'=>'Año')); ?>
      </div>
      <div class="control-group"> 
        <!--[if lte IE 7]>
            <label class="control-label required">Comentarios (Opcional) <span class="required">*</span></label>
<![endif]-->
        <div class="controls">
        	<?php echo CHtml::activeTextArea($detPago,'comentario',array('id'=>'comentario','class'=>'span5','rows'=>'6','placeholder'=>'Comentarios (Opcional)')); ?>
          <div style="display:none" class="help-inline"></div>
        </div>
      </div>
      <div class="form-actions"> <a onclick="enviar()" class="btn btn-danger">Confirmar Deposito</a> </div>
      <p class='text_align_center'><a title='Formas de Pago' href='".Yii::app()->baseUrl."/site/formas_de_pago'> Terminos y Condiciones de Recepcion de pagos por Deposito y/o Transferencia</a><br/></p>
    </form>
  </div>
</div>



<!-- // Modal Window -->

<script>
	
	function enviar()
	{	
		var idDetalle = $("#idDetalle").attr("value");
		var nombre= $("#nombre").attr("value");
		var numeroTrans = $("#numeroTrans").attr("value");
		var dia = $("#dia").attr("value");
		var mes = $("#mes").attr("value");
		var ano = $("#ano").attr("value");
		var comentario = $("#comentario").attr("value");
		var banco = $("#banco").attr("value");
		var cedula = $("#cedula").attr("value");
		var monto = $("#monto").attr("value");
		var idOrden = $("#idOrden").attr("value");

		if(nombre=="" || numeroTrans=="" || monto=="" || banco=="Seleccione")
		{
			alert("Por favor complete los datos.");
		}
		else
		{

 		$.ajax({
	        type: "post", 
	        url: "../../bolsa/cpago", // action de controlador de bolsa cpago
	        data: { 'nombre':nombre, 'numeroTrans':numeroTrans, 'dia':dia, 'mes':mes, 'ano':ano, 'comentario':comentario, 'idOrden':idOrden, 'idDetalle':idDetalle, 'banco':banco, 'cedula':cedula, 'monto':monto}, 
	        success: function (data) {
				
				if(data=="ok")
				{
					window.location.reload();
					//alert("guardado"); 
					// redireccionar a donde se muestre que se ingreso el pago para luego cambiar de estado la orden 
				}
				else
				if(data=="no")
				{
					alert("Datos invalidos.");
				}
				
	       	}//success
	       })
 		}	
		
		
	}
	
</script>