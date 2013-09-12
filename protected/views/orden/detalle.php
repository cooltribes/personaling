<?php
/* @var $this OrdenController */

$this->breadcrumbs=array(
	'Pedidos'=>array('admin'),
	'Detalle',
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
    <h1>PEDIDO #<?php echo $orden->id; ?></h1> <input type="hidden" value="<?php echo $orden->id; ?>" id="orden_id" />
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table ">
    <tr>
      <th scope="col" colspan="4"> PEDIDO #<?php echo $orden->id; ?> - <span class="color1"><?php echo $usuario->profile->first_name." ".$usuario->profile->last_name; ?></span> </th>
      <th scope="col" colspan="2"><div class="text_align_right">
      	<?php
      	
      	if($orden->fecha!="")
   			echo date("d-m-Y H:i:s",strtotime($orden->fecha));
      	
      	?>
      </div></th>
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
	
	if($orden->estado == 8)
		echo "Orden Entregada";
	
	// agregar demas estados
?>
	</p>
        Estado actual</td>
      <td><p class="T_xlarge margin_top_xsmall"> 1 </p>
        Documentos</td>
      <td><p class="T_xlarge margin_top_xsmall"> 2</p>
        Mensajes<br/></td>
        
        <?php
      $ind_tot = 0;
	  $look_tot = 0;
      $compra = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id));
	
		foreach ($compra as $tot) {
			
			if($tot->look_id == 0)
			{
				$ind_tot++;
			}else{
				
				$lhp = LookHasProducto::model()->findAllByAttributes(array('look_id'=>$tot->look_id));
				foreach($lhp as $cada){
					$look_tot++;	
				}
			}
			
		}
      
      ?>
        
        
      <td><p class="T_xlarge margin_top_xsmall"><?php echo ($ind_tot + $look_tot); ?></p>
        Prendas</td>
      <td><p class="T_xlarge margin_top_xsmall"><?php
      
	if($orden->estado == 7)
	{
		$balance = Balance::model()->findByAttributes(array('user_id'=>$orden->user_id,'orden_id'=>$orden->id));
		if(isset($balance)){
			$a = $balance->total * -1;
			echo Yii::app()->numberFormatter->formatDecimal($a); 
		}
	}
	else{
				
		$balance = Balance::model()->findByAttributes(array('user_id'=>$usuario->id,'orden_id'=>$orden->id, 'tipo'=>0));
		
		if(isset($balance))
		{
			if($balance->total < 0){
				$a = $balance->total * -1;
				echo Yii::app()->numberFormatter->formatDecimal($a);
			}else {
				echo Yii::app()->numberFormatter->formatDecimal($orden->total);
			}
			
		}
		else
		{
			echo Yii::app()->numberFormatter->formatDecimal($orden->total);
		}
					
		
				
	}	
    //  echo Yii::app()->numberFormatter->formatDecimal($orden->total); ?></p>

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
    
        ?></td>
      <td><a onclick="window.print();" class="btn margin_top pull-right"><i class="icon-print"></i> Imprimir pedido</a></td>
    </tr>
  </table>
  <hr/>
  <div class="row">
    <div class="span7">
      <h3 class="braker_bottom margin_top"> Información del cliente</h3>
      <div class="row">
        <div class="span1">
        	<?php
        	echo CHtml::image($usuario->getAvatar(), '', array('width'=>'90', 'height'=>'90'));
        	?>
        </div>
        <div class="span6">
          <h2><?php echo $usuario->profile->first_name." ".$usuario->profile->last_name; ?><small> C.I. <?php echo $usuario->profile->cedula; ?></small></h2>
          <div class="row">
            <div class="span3">
              <ul class="no_bullets no_margin_left">
                <li><strong>eMail</strong>: <?php echo $usuario->email; ?></li>
                <li><strong>Telefono</strong>:<?php echo $usuario->profile->tlf_celular; ?> </li>
                <li><strong>Ciudad</strong>:<?php echo $usuario->profile->ciudad; ?> </li>
              </ul>
            </div>
            <div class="span3">
              <ul class="no_bullets no_margin_left">
                <li><strong>Cuenta registrada</strong>:<?php echo $usuario->create_at; ?></li>
                <li><strong>Pedidos validos realizados</strong>: 0</li>
                <li><strong>Total comprado desde su registro</strong>: 0,00 Bs. </li>
              </ul>
            </div>
          </div>
        </div>
      </div>      
        
          	<?php
          	
          	$detalles = Detalle::model()->findAllByAttributes(array('orden_id'=>$orden->id));
          	$pago = Pago::model()->findByAttributes(array('id'=>$orden->pago_id));
						
			if($orden->estado!=5 && $orden->estado!=1){ // no ha pagado o no la cancelaron
			
			echo("
	          	<div id='pago' class='well well-small margin_top well_personaling_small'>
	          	<h3 class='braker_bottom '> Método de Pago</h3>
	        		<table width='100%' border='0' cellspacing='0' cellpadding='0' class='table table-bordered table-hover table-striped'>
	          		<tr>
	            		<th scope='col'>Fecha</th>
	            		<th scope='col'>Método de pago</th>
	            		<th scope='col'>ID de Transaccion</th>
	            		<th scope='col'>Monto</th>
	            		<th scope='col'></th>
	          		</tr>
	          	");
			
				foreach($detalles as $detalle){
				
				echo("<tr>");
				
					if($detalle->estado == 1) // si fue aceptado
					{

						echo("<td>".date("d/m/Y",strtotime($detalle->fecha))."</td>");
						
						if($pago->tipo == 1)
							echo("<td>Deposito o Transferencia</td>");
						if($pago->tipo == 2)
							echo("<td>Tarjeta de credito</td>");
							//hacer los demas tipos
								
						echo("<td>".$detalle->nTransferencia."</td>");	
						echo("<td>".Yii::app()->numberFormatter->formatDecimal($detalle->monto)."</td>");
						echo("<td><a href='#' title='Ver'><i class='icon-eye-open'></i></a></td>");
	
						
					}
					else
					if($detalle->estado == 2) // rechazado
						{
		          	
		          		echo("<td>".date("d/m/Y",strtotime($detalle->fecha))."</td>");
						
						if($pago->tipo == 1)
							echo("<td>Deposito o Transferencia</td>");
							//hacer los demas tipos
								
						echo("<td> PAGO RECHAZADO </td>");	
						echo("<td>".Yii::app()->numberFormatter->formatDecimal($detalle->monto)." Bs.</td>");
						echo("<td><a href='#' title='Ver'><i class='icon-eye-open'></i></a></td>");
							
						}
					
					echo("</tr>");
					}//foreach
				
				echo("</table></div>");
				}
		  	?>    
     
     <?php
     	if($orden->estado == 4) // enviado
     	{
     ?>
     
      <div class="well well-small margin_top well_personaling_small">
        <h3 class="braker_bottom "> Transporte </h3>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
          <tr>
            <th scope="col">Fecha</th>
            <th scope="col">Tipo</th>
            <th scope="col">Transportista</th>
            <th scope="col">Peso</th>
            <th scope="col">Costo de envio</th>
            <th scope="col">Numero de seguimiento</th>
            <th scope="col"></th>
          </tr>
          <tr>
            <td>21/12/2012 - 12:21 PM</td>
            <td>Delivery</td>
            <td>Zoom</td>
            <td>0,00 Kg.</td>
            <td><?php echo $orden->envio; ?> Bs.</td>
            <td><?php echo $orden->tracking; ?></td>
            <td><a href="#" title="Editar"><i class="icon-edit"></i></a></td>
          </tr>
        </table>
      </div>      
      <?php
		} // envío
      
      ?>
      
      
      <div class="row-fluid">
        <div class="span12">
          <h3 class="braker_bottom margin_top">Dirección de envío</h3>
          <div class="vcard">
            <div class="adr">
            	<?php
            	$direccionEnvio = DireccionEnvio::model()->findByPk($orden->direccionEnvio_id);
				$ciudad_envio = Ciudad::model()->findByPk($direccionEnvio->ciudad_id);
				$provincia_envio = Provincia::model()->findByPk($direccionEnvio->provincia_id);
            	?>
              <div class="street-address"><i class="icon-map-marker"></i><?php echo $direccionEnvio->nombre." ".$direccionEnvio->apellido.". "; echo $direccionEnvio->dirUno.", ".$direccionEnvio->dirDos;  ?></div>
              <span class="locality"><?php echo $ciudad_envio->nombre ?>, <?php echo $provincia_envio->nombre; ?>.</span>
              <div class="country-name"><?php echo $direccionEnvio->pais; ?></div>
            </div>
            <div class="tel margin_top_small"> <span class="type"><strong>Telefono</strong>:</span><?php echo $direccionEnvio->telefono; ?></div>
            <div><strong>Email</strong>: <span class="email"><?php echo $usuario->email; ?></span> </div>
          </div>
          <!-- <a href="#" class="btn"><i class="icon-edit"></i></a> --> </div>
          
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
            <a href="#" class="btn"><i class="icon-edit"></i></a> </div>
        </div>
        -->
        
      </div>
    </div>
    <div class="span5">
      <div class="well well_personaling_big">
        <h3 class="braker_bottom"><strong>Acciones pendientes</strong></h3>
        
        	<?php
        	
        	$detalles = Detalle::model()->findAllByAttributes(array('orden_id'=>$orden->id));
			
			foreach($detalles as $detalle){
	        	if($detalle->estado == 0 && $detalle->nTransferencia!="") // si esta en default
				{
					echo("<div class='alert alert-block '>");
					echo(" <h4 class='alert-heading '>Confirmar Pago:</h4>");
					echo("<ul class='padding_bottom_small padding_top_small'>");
					echo("<li>Banco: ".$detalle->banco."</li>");
					echo("<li>Numero: ".$detalle->nTransferencia."</li>");
					echo("<li>Monto: ".Yii::app()->numberFormatter->formatDecimal($detalle->monto)." Bs.</li>");
					echo("<li>Fecha: ".date("d/m/Y",strtotime($detalle->fecha))."</li>");
				
					echo("
					
					</ul>
	          		<p> <a onclick='aceptar(".$detalle->id.")' class='btn' title='Aceptar pago'>
	          		<i class='icon-check'></i> Aceptar</a>
	          		<a onclick='rechazar(".$detalle->id.")' class='btn' title='Rechazar pago'>Rechazar</a> </p>
	        		</div>
	        		
					");
				
				}
			}
			
        	?>
		
		<?php 
			if($orden->estado == 3) // dinero confirmado
			{
		?>
		<div class="alert alert-block form-inline ">
        	<h4 class="alert-heading "> Enviar pedido:</h4>
          	<p>
            <input name="" id="tracking" type="text" placeholder="Numero de Tracking">
            <a onclick="enviarPedido(<?php echo $orden->id; ?>)" class="btn" title="Enviar pedido">Enviar</a> </p>
            Tipo de guía: 
            <?php
            switch ($orden->tipo_guia) {
                case 0:
                    echo '0,5 Kg.';
                    break;
                case 1:
                    echo '5 Kg.';
                    break;
				case 2:
                    echo '10 Kg.';
                    break;
                default:
                    break;
            }
            ?>
        </div>
        <?php
			}
        ?>
         <?php 
         if($orden->estado == 4)
         	echo"<div><a onclick='entregado(".$orden->id.")' class='btn margin_top margin_bottom pull-left'>Registrar Entrega</a></div>"; ?>
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
          <tr>
            <th scope="col">Estado</th>
            <th scope="col">Usuario</th>
            <th scope="col">Fecha</th>
            <th scope="col">&nbsp;</th>
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
				
				if($est->estado==4)
					echo("<td>Pedido enviado</td>");			 
				
				
				if($est->estado == 5)
					echo "<td>Orden Cancelada</td>";	
				
				if($est->estado==6)
					echo("<td>Pago Rechazado</td>");
				
				if($est->estado == 7)
					echo "<td>Pago Insuficiente</td>";
				
				if($est->estado == 8)
					echo "<td>Orden Entregada</td>";
				
				
				$usu = User::model()->findByPk($est->user_id);
				echo ("<td>".$usu->profile->first_name." ".$usu->profile->last_name."</td>");
				
				$fecha = date("d/m/Y",strtotime($est->fecha));
				echo("<td>".$fecha." </td>");
            	echo("<td><a tabindex='-1' href='#'><i class='icon-edit'></i></a></td>");		
            	echo("</tr>");
		  	}
		  
          ?>
          <tr>
            <td>Nuevo Pedido</td>
            <td><?php echo $usuario->profile->first_name." ".$usuario->profile->last_name; ?></td>
            <td><?php echo date("d/m/Y",strtotime($orden->fecha)); ?></td>
            <td><a tabindex="-1" href="#"><i class="icon-edit"></i></a></td>
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
	          	<?php
	          	echo CHtml::link('Factura', $this->createUrl('factura', array('id'=>$factura->id)), array('target'=>'_blank'));
	          	?>
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
    <div class="span12">
   <div class="well well-small margin_top well_personaling_small">   <h3 class="braker_bottom margin_top">Productos</h3>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped" align="center">
        <tr>
          <th scope="col">Referencia</th>
          <th scope="col">Nombre de la prenda</th>
          <th scope="col">Marca</th>
          <th scope="col">Color</th>
          <th scope="col">Talla</th>
          <th scope="col">Cant. en Existencia</th>
          <th scope="col">Cant. en Pedido</th>
          <th scope="col">Precio</th>
          <th scope="col">Accion</th>
        </tr>
        <?php
        	$row=0;
        	$productos = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id)); // productos de la orden
        	
			foreach ($productos as $prod) {
				
					if($prod->look_id != 0) // si es look
					{
						$ptc = Preciotallacolor::model()->findByAttributes(array('id'=>$prod->preciotallacolor_id)); // consigo existencia actual
						
						$lookpedido = Look::model()->findByPk($prod->look_id); // consigo nombre					
						$precio = $lookpedido->getPrecio(false);
						
							echo("<tr style='outline: 1px solid #5e516c; border: 1px solid #5e516c'>"); // Aplicar fondo de tr, eliminar borde**
							echo("<td></td>");
							echo("<td colspan='6'><strong>".$lookpedido->title."</strong></td>");// Referencia
							
							echo("<td>".number_format($prod->precio, 2, ',', '.')."</td>"); // precio 
							
								
							
							/*
							setlocale(LC_MONETARY, 've_VE');
							//$a = money_format('%i', $precio->precioVenta);
							//$c = money_format('%i', $precio->ahorro);
							//$des = money_format('%i', $precio->precioDescuento);
							$iva = $precio * 0.12;
							
							$b = $precio * $prod->cantidad;					
							echo("<td>".Yii::app()->numberFormatter->formatDecimal($b)."</td>"); // subtotal
							
							echo("<td> desc look </td>"); //descuento del look
							
							$e = $iva * $prod->cantidad;
							echo("<td>".Yii::app()->numberFormatter->formatDecimal($e)."</td>"); // impuesto
							*/
							
							echo("
							<td><div class='dropdown'> <a class='dropdown-toggle' id='dLabel' role='button' data-toggle='dropdown' data-target='#' href='/page.html'> <i class='icon-cog'></i></a> 
			              	<!-- Link or button to toggle dropdown -->
			              	<ul class='dropdown-menu' role='menu' aria-labelledby='dLabel'>
			                	<li><a tabindex='-1' href='#'><i class='icon-edit'></i> Editar</a></li>
			                	<li class='divider'></li>
			                	<li><a tabindex='-1' href='#'><i class='icon-trash'></i> Eliminar</a></li>
			              	</ul>
			            	</div></td>
							");
							
							echo("</tr>");	
							$prodslook= OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$prod->tbl_orden_id, 'look_id'=>$prod->look_id), array('order'=>'look_id ASC'));
							foreach($prodslook as $prodlook){
								$ptclk = Preciotallacolor::model()->findByAttributes(array('id'=>$prodlook->preciotallacolor_id));
								$prdlk = Producto::model()->findByPk($ptclk->producto_id);
								$marca=Marca::model()->findByPk($prdlk->marca_id);
								$talla=Talla::model()->findByPk($ptclk->talla_id);
								$color=Color::model()->findByPk($ptclk->color_id);
							
								echo("<tr>");
								echo("<td>".$prdlk->codigo."</td>"); // nombre
								echo("<td>".$prdlk->nombre."</td>"); // nombre
								echo("<td>".$marca->nombre."</td>");
								echo("<td>".$color->valor."</td>");
								echo("<td>".$talla->valor."</td>");
								echo("<td>".$ptclk->cantidad."</td>"); // cantidad en existencia
								echo("<td>".$prodlook->cantidad."</td>"); // cantidad en pedido
								echo("<td></td>");//.$prodlook->precio."</td>"); // precio 
								echo("<td></td></tr>");
							}
							
							
						
					}
					else // individual
					{
						if($row==0){
								echo("<tr style='outline: 1px solid #5e516c; border: 1px solid #5e516c'><td colspan='9'>PRENDAS INDIVIDUALES</td></tr>");
								$row=1;
						}	
						$ptc = Preciotallacolor::model()->findByAttributes(array('id'=>$prod->preciotallacolor_id)); // consigo existencia actual
						$indiv = Producto::model()->findByPk($ptc->producto_id); // consigo nombre
						$precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$ptc->producto_id)); // precios
						$marca=Marca::model()->findByPk($indiv->marca_id);
						$talla=Talla::model()->findByPk($ptc->talla_id);
						$color=Color::model()->findByPk($ptc->color_id);
						echo("<tr>");
						echo("<td>".$indiv->codigo."</td>");// Referencia
						echo("<td>".$indiv->nombre."</td>"); // nombre
						echo("<td>".$marca->nombre."</td>");
						echo("<td>".$color->valor."</td>");
						echo("<td>".$talla->valor."</td>");					
						echo("<td>".$ptc->cantidad."</td>"); // cantidad en existencia
						echo("<td>".$prod->cantidad."</td>"); // cantidad en pedido
						echo("<td>".number_format($prod->precio, 2, ',', '.')."</td>"); // precio
						/*
						setlocale(LC_MONETARY, 've_VE');
						$a = money_format('%i', $precio->precioVenta);
						$c = money_format('%i', $precio->ahorro);
						
						$iva = $precio->precioDescuento * 0.12;
						
						echo("<td>".Yii::app()->numberFormatter->formatDecimal($a)."</td>"); //precio individual sin descuento
						
						$b = $a * $prod->cantidad;					
						echo("<td>".Yii::app()->numberFormatter->formatDecimal($b)."</td>"); // subtotal
						
						$d = $c * $prod->cantidad;					
						echo("<td>".Yii::app()->numberFormatter->formatDecimal($d)."</td>"); //descuento total
						
						$e = $iva * $prod->cantidad;
						echo("<td>".Yii::app()->numberFormatter->formatDecimal($e)."</td>"); // impuesto total
						*/
						
						echo("
							<td><div class='dropdown'> <a class='dropdown-toggle' id='dLabel' role='button' data-toggle='dropdown' data-target='#' href='/page.html'> <i class='icon-cog'></i></a> 
			              	<!-- Link or button to toggle dropdown -->
			              	<ul class='dropdown-menu' role='menu' aria-labelledby='dLabel'>
			                	<li><a tabindex='-1' href='#'><i class='icon-edit'></i> Editar</a></li>
			                	<li class='divider'></li>
			                	<li><a tabindex='-1' href='#'><i class='icon-trash'></i> Eliminar</a></li>
			              	</ul>
			            	</div></td>
						");
						
						echo("</tr>");				
					}	
							
				
			}

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
        

        <!-- Comienzo del resumen del pedido -->
        

        
        
        
        
        <tr>
          <th colspan="9" ><div class="text_align_right"><strong>Resumen</strong></div></th>
        </tr>         
        <tr>
          <td colspan="8" ><div class="text_align_right"><strong>No. de Looks</strong></div></td>
          <td ><?php echo $looks; ?></td> 
        </tr>  
        <tr>
          <td colspan="8" ><div class="text_align_right"><strong>No. de Prendas Individuales</strong></div></td>
          <td ><?php echo $individuales; ?></td>
        </tr>
        <tr>
          <td colspan="8" ><div class="text_align_right"><strong>Subtotal</strong></div></td>
          <td >Bs. <?php echo number_format($orden->subtotal, 2, ',', '.'); ?></td>
        </tr>  
        <tr>
          <td colspan="8" ><div class="text_align_right"><strong>Envio y Transporte</strong></div></td>
          <td >Bs. <?php echo number_format($orden->envio+$factura->orden->seguro, 2, ',', '.'); ?></td>
        </tr>    
        <tr>
          <td colspan="8" ><div class="text_align_right"><strong>Descuento</strong></div></td>
          <td >Bs. <?php echo number_format($orden->descuento, 2, ',', '.'); ?></td>
        </tr>  
        <tr>
          <td colspan="8" ><div class="text_align_right"><strong>Impuesto</strong></div></td>
          <td >Bs. <?php echo number_format($orden->iva, 2, ',', '.'); ?></td>
        </tr>   
        <tr>
          <th colspan="8" ><div class="text_align_right"><strong>Total</strong></div></th>
          <th >Bs. <?php echo number_format($orden->total, 2, ',', '.'); ?></th>
        </tr>          
      </table>
  
      
     <a href="#" title="Añadir productos" class="btn btn-info"><i class="icon-plus icon-white"></i> Añadir productos</a></div> </div>
<!--     <div class="span5">
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
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->subtotal); ?></td>
        </tr>
        <tr>
          <td>Envio y Transporte</td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->envio); ?></td>
        </tr>
        <tr>
          <td>Descuento</td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->descuento); ?></td>
        </tr>
        
          <tr>
          <td>Impuesto</td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->iva); ?></td>
        </tr>
        <tr>
          <td>Total</td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->total); ?></td>
        </tr>
        
        
      
      </table></div>
    </div> -->
  </div>
  <!-- INFORMACION DEL PEDIDO OFF -->
  <hr/>
  
  <!-- MENSAJES ON -->
  
  <div class="row">
    <div class="span7">
      <h3 class="braker_bottom margin_top">MENSAJES</h3>
      <form>
        <div class="control-group">
          <select>
            <option>Elija un mensaje estandar</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
          </select>
        </div>
        <div class="control-group">
        	<input type="text" id="asunto" placeholder="Asunto Del Mensaje" />
          	<textarea id="cuerpo" name="cuerpo" cols="" class="span7" rows="4" placeholder="Mensaje"></textarea>
        </div>
        <div class="control-group">
          <label class="checkbox">
          	<input type="checkbox" value="" id="notificar" > Notificar al Cliente por eMail </label>
          <label class="checkbox">
            <input type="checkbox" value="" id="visible" > Hacer visible en el Frontend</label>
        </div>
        <div class="form-actions "><a onclick="mensaje(<?php echo $orden->user_id; ?>)" title="Enviar" class="btn btn-info"><i class="icon-envelope icon-white"></i>  Enviar comentario</a> </div>
      </form>
    </div>
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
    
    <!-- MENSAJES OFF --> 
    
  </div>
</div>
<!-- /container --> 

<!------------------- MODAL WINDOW ON -----------------> 

<!-- Modal 1 -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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

<script>
	
	function mensaje(user_id){
		
		var asunto = $('#asunto').attr('value');
		var cuerpo = $('#cuerpo').attr('value');
		
		var orden_id = $('#orden_id').attr('value');
		
		if($('#notificar').attr('checked') == "checked")
			var notificar = 1; // $('#notificar').attr('checked');
		else
			var notificar = 0;
		
		if($('#visible').attr('checked') == "checked")	
			var visible = 1; // $('#visible').attr('checked');
		else
			var visible = 0;
		
		// alert("a: "+asunto+" , c:"+cuerpo+" , n:"+notificar+" ,v:"+visible+ " ,id:"+user_id);
		
		$.ajax({
	        type: "post", 
	        url: "<?php echo Yii::app()->baseUrl; ?>/orden/mensajes", // action 
	        data: { 'asunto':asunto, 'cuerpo':cuerpo, 'notificar':notificar, 'visible':visible, 'user_id':user_id, 'orden_id':orden_id}, 
	        success: function (data) {
				if(data=="ok")
				{
					window.location.reload();	
				}
	       	}//success
	       }) 
				
	}
	
	
	function aceptar(id){

		var uno = 'aceptar';
		
 		$.ajax({
	        type: "post", 
	        url: "../validar", // action 
	        data: { 'accion':uno, 'id':id}, 
	        success: function (data) {
				if(data=="ok")
				{
					window.location.reload();
					//alert("guardado"); 
					// redireccionar a donde se muestre que se ingreso el pago para luego cambiar de estado la orden 
				}
	       	}//success
	       }) 			

	}
	
	function rechazar(id){
		
		var uno = 'rechazar';
		
 		$.ajax({
	        type: "post", 
	        url: "../validar", // action 
	        data: { 'accion':uno, 'id':id}, 
	        success: function (data) {
				if(data=="ok")
				{
					window.location.reload();
					//alert("guardado"); 
					// redireccionar a donde se muestre que se ingreso el pago para luego cambiar de estado la orden 
				}
	       	}//success
	       })		
		
	}
	
	function enviarPedido(id){
		
		var guia = $('#tracking').attr('value');
		
		$.ajax({
	        type: "post", 
	        url: "../enviar", // action 
	        data: { 'guia':guia, 'id':id}, 
	        success: function (data) {
				if(data=="ok")
				{
					window.location.reload();
				}
	       	}//success
	       })	
	      
	   //  alert(guia);	
		
	}
	
	function entregado(id){
		
	
		
		$.ajax({
	        type: "post", 
	        url: "../entregar", // action 
	        data: { 'id':id}, 
	        success: function (data) {
				if(data=="ok")
				{
					window.location.reload();
				}
	       	}//success
	       })	
	      
	   //  alert(guia);	
		
	}
	
	
	
	
		
</script>
