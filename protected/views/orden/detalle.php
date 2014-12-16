<?php 
/* @var $this OrdenController */

$this->breadcrumbs=array(
	'Pedidos'=>array('admin'),
	'Detalle',
);
//if($orden->getFlete())
	//print_r($orden->getFlete());// REVISION ZOOM 
	//echo "<br/>";
//print_r($orden->calcularTarifa(17,1,0.4, 3290)); 
//echo $orden->direccionEnvio->myciudad->cod_zoom." - ".$orden->nproductos." - ".$orden->peso." - ".$orden->total."<br/>"."17 - 1 - 0.4 - 3290";
$tracking=$orden->trackingInfo;

$usuario = User::model()->findByPk($orden->user_id); 




?>

<div class="container margin_top">
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
    
    
    
			
  <div class="page-header">
    <h1>PEDIDO #<?php echo $orden->id; 
     ?></h1> <input type="hidden" value="<?php echo $orden->id; ?>" id="orden_id" />
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table ">
    <tr>
      <th scope="col" colspan="4"> PEDIDO #<?php echo $orden->id; ?> - <span class="color1"><?php echo $usuario->profile->first_name." ".$usuario->profile->last_name; ?></span> </th>
      <th scope="col" colspan="2"><div class="text_align_right">
      	<?php
      	
      	if($orden->fecha!="")
//   		echo date('d/m/Y - h:i a', strtotime($orden->fecha. ' + 3 days'));
   		echo date('d/m/Y - h:i a', strtotime($orden->fecha));
      	
      	?>
      </div></th>
    </tr>
    <tr>
   	<td><p class="T_large margin_top_xsmall color1">
<?php
//----------------------Estado
	echo $orden->textestado;
	
	// agregar demas estados
?>
	</p>
        Estado actual</td>
      <td><p class="T_xlarge margin_top_xsmall"> 2 </p>
        Documentos</td>
      <td><p class="T_xlarge margin_top_xsmall"> <?php echo count($orden->mensajes);?></p>
        Mensajes<br/></td>
        
        <?php
    $ind_tot = 0;
	$look_tot = 0;
    $compra = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id));
	
	$looks_en_orden = Array();
		
		foreach ($compra as $tot) {
			
			if($tot->look_id == 0)
			{
				$ind_tot++; 
			}else{
				
				// si es look se debe revisar cuantos productos tiene el look.
				
				if(!in_array($tot->look_id,$looks_en_orden)){	// no hace nada para que no se repita el valor			
					
					array_push($looks_en_orden,$tot->look_id); 
					$revisando = $tot->look_id;
					
					foreach($compra as $cadauno)
					{
						if($cadauno->look_id == $revisando)
							$look_tot++;
						
					}
					
					/*$lhp = LookHasProducto::model()->findAllByAttributes(array('look_id'=>$tot->look_id));
					
					foreach($lhp as $cada){
						$look_tot++;
					}					
					
					*/
				}
				
				
			}
			
		}
      
      ?>
        
        
      <td><p class="T_xlarge margin_top_xsmall"><?php echo ($ind_tot + $look_tot); ?></p>
        Prendas</td>
      <td><p class="T_xlarge margin_top_xsmall"><?php
      
		echo Yii::app()->numberFormatter->formatDecimal($orden->getMontoActivo());
    //  echo Yii::app()->numberFormatter->formatDecimal($orden->total); ?></p>

        <?php
//----------------------Estado
	if($orden->estado == 1)
		echo Yii::t('contentForm','currSym')." Pendientes por pagar"; 
	
	if($orden->estado == 2)
		echo Yii::t('contentForm','currSym')." Pendientes por confirmar";
	
	if($orden->estado == 3 || $orden->estado == 8)
		echo Yii::t('contentForm','currSym')." ya pagados";

	if($orden->estado == 4)
		echo Yii::t('contentForm','currSym')." ya pagados";
	
	if($orden->estado == 5)
		echo "Orden Cancelada";	
	
	if($orden->estado == 7)
		echo Yii::t('contentForm','currSym')." que faltan.";
	
		
	// agregar demas estados
     
        ?></td>
      <td>
	<?php
	
	if($orden->estado == 8) // recibido
	{
		
	?>	
      	<div class="row margin_top_small">
      		<?php
      		
      		$url = Yii::app()->baseUrl."/orden/devoluciones/".$orden->id;
      		
      		$this->widget('bootstrap.widgets.TbButton', array(
			    'label'=>'Hacer devolución',
			    'buttonType'=>'link',
			    'url'=>$url,
			    'type'=>'warning', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			    'htmlOptions'=>array('class'=>'span2 pull-right margin_bottom_xsmall')
			)); ?>
		</div>
	<?php
	}else
		{
			echo '<div class="row margin_top_small"></div>';
		}
	?>	
			
		<div  class="row">
      		<a onclick="window.print();" class="btn span2  pull-right"><i class="icon-print"></i> Imprimir pedido</a>
      	</div>		
      </td>
    </tr>
  </table>
  <hr/>
  <div class="row">
    <div class="span7">
      <h3 class="braker_bottom margin_top_small"> Información del cliente</h3>
      <div class="row">
        <div class="span1">
        	<?php
        	echo CHtml::image($usuario->getAvatar(), '', array('width'=>'90', 'height'=>'90'));
        	?>
        </div>
        <div class="span6">
          <h2><?php echo $usuario->profile->first_name." ".$usuario->profile->last_name; ?><small> <?php if(Yii::app()->params['askId']) echo Yii::t('contentForm','C.I.')." ".$usuario->profile->cedula; ?></small></h2>
          <div class="row">
            <div class="span3">
              <ul class="no_bullets no_margin_left">
                <li><strong>Correo electrónico</strong>: <?php echo $usuario->email; ?></li> 
                <li><strong>Telefono</strong>:<?php echo $usuario->profile->tlf_celular; ?> </li>
                <li><strong>Ciudad</strong>:<?php echo $usuario->profile->ciudad; ?> </li>
              </ul>
            </div>
            <div class="span3">
              <ul class="no_bullets no_margin_left">
                <li><strong>Cuenta registrada</strong>:<?php echo date('d/m/Y h:i A', strtotime($usuario->create_at)); ?></li>
                <li><strong>Pedidos validos realizados</strong>: <?php echo Orden::model()->countByAttributes(array('user_id'=>$orden->user_id,'estado'=>8)); ?></li>
                <li><strong>Total comprado desde su registro</strong>: <?php echo number_format($orden->getTotalByUser($orden->user_id), 2, ',', '.')." ".Yii::t('contentForm','currSym'); ?> </li>
              </ul>
            </div>
          </div>
        </div>
      </div>      
      <div id='pago' class='well well-small margin_top well_personaling_small'>
        <h3 class='braker_bottom '> Método de Pago</h3>
            <table width='100%' border='0' cellspacing='0' cellpadding='0' class='table table-bordered table-hover table-striped'>
            <tr>
            <th scope='col'>Fecha</th>
            <th scope='col'>Método de pago</th>
            <th scope='col'>ID de Transaccion </th>
            <th scope='col'>Monto</th>
            <th scope='col'></th>
            </tr> 
            
            <?php
          	
          	$detalleDePago = Detalle::model()->findAllByAttributes(array('orden_id'=>$orden->id));
          
                if($orden->estado!=5 && $orden->estado!=1){ // no ha pagado o no la cancelaron						

                    foreach($detalleDePago as $detalle){
                        echo("<tr>");

                                if($detalle->estado == 1) // si fue aceptado
                                {
                                    $transaccion = $detalle->nTransferencia != ""?$detalle->nTransferencia:"-";
                                        echo("<td>".date("d/m/Y",strtotime($detalle->fecha))."</td>");
                                        echo("<td>".$detalle->getTipoPago()."</td>");

                                        echo("<td>".$transaccion."</td>");	
                                        echo("<td>".Yii::app()->numberFormatter->formatDecimal($detalle->monto)."</td>");
                                        echo("<td><a href='#' title='Ver'><i class='icon-eye-open'></i></a></td>");


                                }
                                else
                                if($detalle->estado == 2) // rechazado
                                        {

                                echo("<td>".date("d/m/Y",strtotime($detalle->fecha))."</td>");

                                        if($detalle->tipo_pago == 1)
                                                echo("<td>Deposito o Transferencia</td>");
                                                //hacer los demas tipos

                                        echo("<td> PAGO RECHAZADO </td>");	
                                        echo("<td>".Yii::app()->numberFormatter->formatDecimal($detalle->monto)." ".Yii::t('contentForm','currSym')."</td>");
                                        echo("<td><a href='#' title='Ver'><i class='icon-eye-open'></i></a></td>");

                                        }

                                echo("</tr>");
                                }//foreach

                        echo("");
                        }
            ?>  
            
            
       </table>
      </div>
          	  
     
     <?php
     	if($orden->estado==4||$orden->estado==8||$orden->estado==9||$orden->estado==10){
     ?>
     
      <div class="well well-small margin_top_small well_personaling_small">
        <h3 class="braker_bottom "> Transporte </h3>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
          <tr>
            <th scope="col">Fecha</th>
           <!--  <th scope="col">Tipo</th>-->
            <th scope="col">Transportista</th>
            <th scope="col">Peso</th>
            <th scope="col">Costo de envio</th>
            <th scope="col">Numero de seguimiento</th>
            <th scope="col"></th>
          </tr>
          <tr>
            <td><?php 
            echo date("d/m/Y",strtotime(Estado::model()->getDate($orden->id, $orden->estado)));?>
            </td>
           <!-- <td>Delivery</td>-->
            <td> 
            <?php
            
           echo $orden->shipCarrier;
            ?></td>
            <td><?php echo $orden->peso ?> Kg.</td>
            <td><?php echo number_format($orden->envio+$orden->seguro, 2, ',', '.')." ".Yii::t('contentForm','currSym'); ?></td>
            <td><?php echo $orden->tracking; ?></td>
            <td><a href="#" title="Editar"><i class="icon-edit"></i></a></td>
          </tr>
        </table>
        
        <?php 
     
        if(is_array($tracking))
        { ?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
          <tr>
            <th scope="col">Fecha</th>
           <!--  <th scope="col">Tipo</th>-->
            <th scope="col">Estatus</th>
            </tr>
         	<?php foreach ($tracking as $track){
         echo "<tr>
        	<td>".$track->fecha."</td><td>".$track->descripcion_estatus."</td>        
          </tr>";
         }?>
        </table>
        <?php } ?>
      </div>      
      <?php
		 // envío
		 }
      ?>
      
      
      <div class="row-fluid">
        <div class="span12">
          <h3 class="braker_bottom margin_top_small">Dirección de envío</h3>
          <div class="vcard">
            <div class="adr">
            	<?php
            	$direccionEnvio = DireccionEnvio::model()->findByPk($orden->direccionEnvio_id);
				$ciudad_envio = Ciudad::model()->findByPk($direccionEnvio->ciudad_id);
				$provincia_envio = Provincia::model()->findByPk($direccionEnvio->provincia_id);
            	?>
              <div class="street-address"><i class="icon-map-marker"></i><?php echo $direccionEnvio->nombre." ".$direccionEnvio->apellido.". ";  ?></div>
              
              <span class="locality"><?php echo $direccionEnvio->dirUno.", ".$direccionEnvio->dirDos; ?>.</span>
              <span class="locality"><?php echo $ciudad_envio->nombre ?>, <?php echo $provincia_envio->nombre; ?>.</span>
              <div class="country-name"><?php echo $direccionEnvio->pais; ?></div>
          <?php    if(isset($direccionEnvio->codigoPostal)){?> 
              <div><strong>Código Postal: </strong><?php echo $direccionEnvio->codigoPostal->codigo; ?></div>
           <?php }?>
            </div>
           <div class="row-fluid tel pull_left">
            <?php if(Yii::app()->params['askId']){ ?> 
            	<div class="span4"> <span class="type"><strong><?php echo Yii::t("contentForm","C.I.");?> </strong>:</span><?php echo $direccionEnvio->cedula; ?></div>
            <?php } ?>
            <div class="span4"><strong>Telefono</strong>: <span class="email"><?php echo $direccionEnvio->telefono; ?></span> </div>
            <div class="span4"><strong>Correo electrónico</strong>: <span class="email"><?php echo $usuario->email; ?></span> </div>
          </div>
          </div>
   <?php
            	if(isset($orden->direccionFacturacion)){
            		
            	?>
           <h3 class="braker_bottom margin_top_small">Dirección de facturación</h3>
          <div class="vcard">
            <div class="adr">
            	
              <div class="street-address"><i class="icon-map-marker"></i><?php echo $orden->direccionFacturacion->nombre." ".$orden->direccionFacturacion->apellido.". ";  ?></div>
              
              <span class="locality"><?php echo $orden->direccionFacturacion->dirUno.", ".$orden->direccionFacturacion->dirDos; ?>.</span>
              <span class="locality"><?php echo $orden->direccionFacturacion->ciudad->nombre ?>, <?php echo $orden->direccionFacturacion->provincia->nombre; ?>.</span>
              <div class="country-name"><?php echo $orden->direccionFacturacion->pais; ?></div>
            </div>
           <div class="row-fluid tel pull_left">
            <?php if(Yii::app()->params['askId']){ ?> 
            	<div class="span3"> <span class="type"><strong><?php echo Yii::t("contentForm","C.I.");?> </strong>:</span><?php echo $orden->direccionFacturacion->cedula; ?></div>
             <?php } ?>
            <div class="span4"><strong>Telefono</strong>: <span class="email"><?php echo $orden->direccionFacturacion->telefono; ?></span> </div>
            <div class="span4"><strong>Correo electrónico</strong>: <span class="email"><?php echo $usuario->email; ?></span> </div>
          </div>
          </div>
          <?php } ?>
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
        	
        	$productoBolsa = Detalle::model()->findAllByAttributes(array('orden_id'=>$orden->id));
			
			foreach($productoBolsa as $detalle){
	        	if($detalle->estado == 0 && $detalle->nTransferencia!="") // si esta en default
				{
					echo("<div class='alert alert-block '>");
					echo(" <h4 class='alert-heading '>Confirmar Pago:</h4>");
					echo("<ul class='padding_bottom_small padding_top_small'>");
					echo("<li>Banco: ".$detalle->banco."</li>");
					echo("<li>Numero: ".$detalle->nTransferencia."</li>");
					echo("<li>Monto: ".Yii::app()->numberFormatter->formatDecimal($detalle->monto)." ".Yii::t('contentForm','currSym')."</li>");
					echo("<li>Fecha: ".date("d/m/Y",strtotime($detalle->fecha))."</li>");
				
					echo("
					
					</ul>
	          		<p> <a onclick='aceptar(".$detalle->id.")' class='btn btn-info' title='Aceptar pago'>
	          		<i class='icon-check icon-white'></i> Aceptar</a>
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
            echo $orden->shipCarrier;
            /*switch ($orden->tipo_guia) {
                case 0:
                    echo 'Zoom hasta 0,5 Kg.';
                    break;
                case 1:
                    echo 'Zoom entre 0,5 y 5 Kg.';
                    break;
				case 2:
                    echo 'DHL mayor a 5 Kg.';
                    break;
                default:
                    break;
            }*/
            ?>
        </div>
        <?php
			}
        ?>
         <?php 
         if($orden->estado == 4)
         	echo"<div><a onclick='entregado(".$orden->id.")' class='btn btn-info margin_top margin_bottom pull-left'>Registrar Entrega</a></div>"; ?>
        
        <?php if($orden->estado == 1 || $orden->estado == 6
                || $orden->estado == 7){ ?>
            <a href="#modalDeposito" role="button" class="btn btn-info margin_top margin_bottom pull-left" data-toggle="modal"><i class="icon-check icon-white"></i> Registrar Pago</a>
                <?php } ?>
        
        
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
          <tr>
            <th scope="col">Estado</th>
            <th scope="col">Usuario</th>
            <th scope="col">Fecha</th>
<!--            <th scope="col">&nbsp;</th>-->
          </tr>

          <?php
          
          $estados = Estado::model()->findAllByAttributes(array('orden_id'=>$orden->id),array('order'=>'id DESC'));
          
		  	foreach ($estados as $est)
		  	{
		  		echo("<tr>");
				
				
					echo "<td>".$orden->getTextEstado($est->estado)."</td>";
				
				
				
				$usu = User::model()->findByPk($est->user_id);
				if (isset($usu))                                    
					echo ("<td>".$usu->profile->first_name." ".$usu->profile->last_name."</td>");
				else if($est->user_id == 0) //si fue el sistema
                                        echo ("<td>Sistema</td>");
                                else 
                                        echo ("<td>Admin</td>");
				
				
				$fecha = date("d/m/Y",strtotime($est->fecha));
				echo("<td>".$fecha." </td>");
            	//echo("<td><a tabindex='-1' href='#'><i class='icon-edit'></i></a></td>");		
            	echo("</tr>");
		  	}
		  
          ?>
          <tr>
            <td>Nuevo Pedido</td>
            <td><?php 
            		if(!is_null($orden->admin_id)){
						$comprador=User::model()->findByPk($orden->admin_id);
						echo $comprador->username;
					}else{
						echo $usuario->profile->first_name." ".$usuario->profile->last_name; 	
					} ?></td>
            <td><?php echo date("d/m/Y",strtotime($orden->fecha)); ?></td>
            <!-- <td><a tabindex="-1" href="#"><i class="icon-edit"></i></a></td> -->
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
	          	echo CHtml::link('Factura Electrónica', $this->createUrl('factura', array('id'=>$factura->id)), array('target'=>'_blank'));
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
          <th rowspan="2" scope="col" colspan="2">Datos de la Prenda</th>
          <th rowspan="2" scope="col">Marca</th>
          <th rowspan="2" scope="col">Color</th>
          <th rowspan="2" scope="col">Talla</th>
          <th rowspan="2" scope="col">Peso</th>
          <th scope="col" colspan="3">Cantidad</th>           
          <th rowspan="2" scope="col">Almacen</th>
          <th rowspan="2" scope="col">Precio</th>
        </tr>
        <tr>          
          <th scope="col">Existencia</th>
          <th scope="col">Pedido</th>
          <th scope="col">Enviado LF</th>
          
        </tr>
        <?php
        	$row=0;
        	$productos = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id)); // productos de la orden
        	$lkids=OrdenHasProductotallacolor::model()->getLooks($orden->id);
                
                //PRENDAS POR LOOKS                
                    foreach ($lkids as  $lkid){
				
                        $lookpedido = Look::model()->findByPk($lkid['look_id']);
                        $precio = $lookpedido->getPrecio(false);
                        echo("<tr class='bg_color5' >"); // Aplicar fondo de tr, eliminar borde**
                        echo("<td colspan='10'><strong>".$lookpedido->title."</strong></td>");// Referencia

                        echo("<td>".number_format(OrdenHasProductotallacolor::model()->precioLook($orden->id, $lkid['look_id']), 2, ',', '.')."</td>"); // precio 	 
				
                        echo("</tr>");
							
                        $prodslook=OrdenHasProductotallacolor::model()->getByLook($orden->id, $lkid['look_id']);
                        foreach($prodslook as $prodlook){
                                $ptclk = Preciotallacolor::model()->findByAttributes(array('id'=>$prodlook['preciotallacolor_id']));
                                $prdlk = Producto::model()->findByPk($ptclk->producto_id);
                                $marca=Marca::model()->findByPk($prdlk->marca_id);
                                $talla=Talla::model()->findByPk($ptclk->talla_id);
                                $color=Color::model()->findByPk($ptclk->color_id);

                                $imagen = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$prdlk->id,'color_id'=>$color->id), array('order'=>'orden'));
                                $contador=0;
                                $foto = "";
                                $label = $color->valor;
                                
                                if(!is_null($ptclk->imagen))
                                    $foto = CHtml::image(Yii::app()->baseUrl .'/images/'.Yii::app()->language.'/producto/'.
                                    str_replace(".","_thumb.",$ptclk->imagen['url']), "Imagen ", 
                                    array("width" => "70", "height" => "70"));
                                else {
                                    $foto="No hay foto</br>para el color";
                                }


                                echo("<tr>");
                                echo("<td style='text-align:center'>".$foto."<br><div>".$label."</div></td>");
                                echo('<td style="vertical-align: middle">
                                    <b>Referencia:</b> '.$prdlk->codigo.
                                    "</pre><br><b>Nombre de la Prenda:</b> ".
                                    $prdlk->nombre
                                    ."</td>");

                                echo("<td>".$marca->nombre."</td>");
                                echo("<td>".$color->valor."</td>");
                                echo("<td>".$talla->valor."</td>");
                                echo("<td>".$prdlk->peso." Kg.</td>");	
                                echo("<td>".$ptclk->cantidad."</td>"); // cantidad en existencia
                                echo("<td>".$prodlook['cantidad']."</td>"); // cantidad en pedido
                                echo("<td>".$prodlook['cantidadLF']."</td>"); // cantidad enviada por LF
                                
                                
                                echo("<td>".$prdlk->almacen."</td>"); 

                                echo("<td>".number_format($prodlook['precio'], 2, ',', '.')."</td></tr>");
                            }				
				
			}
                        
                        
			//INDIVIDUALES
			echo("<tr class='bg_color5'><td colspan='11'>Prendas Individuales</td></tr>");
			$separados=OrdenHasProductotallacolor::model()->getIndividuales($orden->id);			
			foreach($separados as $prod){
                            
                            $ptc = Preciotallacolor::model()->findByAttributes(array('id'=>$prod['preciotallacolor_id'])); // consigo existencia actual
                            $indiv = Producto::model()->findByPk($ptc->producto_id); // consigo nombre
                            $precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$ptc->producto_id)); // precios
                            $marca=Marca::model()->findByPk($indiv->marca_id);
                            $talla=Talla::model()->findByPk($ptc->talla_id);
                            $color=Color::model()->findByPk($ptc->color_id);

                            $imagen = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$indiv->id,'color_id'=>$color->id),array('order'=>'orden'));
                            $contador=0;
                            $foto = "";
                            $label = $color->valor;
                             if(!is_null($ptc->imagen))
                              {
                                 $foto = CHtml::image(Yii::app()->baseUrl.'/images/'.Yii::app()->language.'/producto/'.str_replace(".","_thumb.",$ptc->imagen['url']), "Imagen ", array("width" => "70", "height" => "70"));

                              }
                                else {
                                    $foto="No hay foto</br>para el color";
                                } 

                            $class = $prod['estadoLF'] == 2 ? " class='error'":
                                    $prod['estadoLF'] == 3 ?" class='text-success'":"";
                            
                            
                            echo("<tr$class>");
                            /*Datos resumidos + foto*/
                            echo("<td style='text-align:center'><div>".$foto."<br/>".$label."</div></td>");
                            echo('<td style="vertical-align: middle">
                                    <b>Referencia:</b> '.$indiv->codigo.
                                    "</pre><br><b>Nombre de la Prenda:</b> ".
                                    $indiv->nombre
                                    ."</td>");
                            echo("<td>".$marca->nombre."</td>");
                            echo("<td>".$color->valor."</td>");
                            echo("<td>".$talla->valor."</td>");	
                            echo("<td>".$indiv->peso." Kg.</td>");					
                            echo("<td>".$ptc->cantidad."</td>"); // cantidad en existencia
                            echo("<td>".$prod['cantidad']."</td>"); // cantidad en pedido
                            
                            
                            
                            echo("<td>".$prod['cantidadLF']."</td>"); // cantidad enviada por LF
                            echo("<td>".$indiv->almacen."</td>"); 
                            echo("<td>".number_format($prod['precio'], 2, ',', '.')."</td>"); // precio
                            echo("</tr>");
				
			}

          $individuales=OrdenHasProductotallacolor::model()->countIndividuales($orden->id);
              $looks=OrdenHasProductotallacolor::model()->countLooks($orden->id);
          $compra = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id));
	   
      ?>
        

        <!-- Comienzo del resumen del pedido -->
        <tr>
          <th colspan="11" ><div class="text_align_right"><strong>Resumen</strong></div></th>
        </tr>         
        <tr>
          <td colspan="10" ><div class="text_align_right"><strong>No. de Looks</strong></div></td>
          <td ><?php echo($looks); ?></td> 
        </tr>  
        <tr>
          <td colspan="10" ><div class="text_align_right"><strong>No. de Prendas Individuales</strong></div></td>
          <td ><?php echo ($individuales); ?></td>
        </tr>
        <tr>
          <td colspan="10" ><div class="text_align_right"><strong>Subtotal</strong></div></td>
          <td ><?php echo Yii::t('contentForm','currSym'); ?>  <?php echo number_format($orden->subtotal, 2, ',', '.'); ?></td>
        </tr>  
        <tr>
          <td colspan="10" ><div class="text_align_right"><strong>Envio y Transporte</strong></div></td>
          <td ><?php 
          	if($orden->envio>0)
          		echo Yii::app()->numberFormatter->formatDecimal($orden->envio+$orden->seguro). " ".Yii::t('contentForm','currSym')."."; 
        	else
        		echo "<b class='text-success'>GRATIS</b>";  ?></td>
        </tr>    
        <tr>
          <td colspan="10" ><div class="text_align_right"><strong>Descuento</strong></div></td>
          <td ><?php echo Yii::t('contentForm','currSym'); ?>  <?php echo number_format($orden->descuento, 2, ',', '.'); ?></td>
        </tr>  
        <tr>
          <td colspan="10" ><div class="text_align_right"><strong>Balance utilizado</strong></div></td>
          <td ><?php echo Yii::t('contentForm','currSym'); ?>  <?php echo number_format($orden->descuentoRegalo, 2, ',', '.'); ?></td>
        </tr> 
        <?php if($orden->iva>0){?>
        <tr>
          <td colspan="10" ><div class="text_align_right"><strong><?php echo Yii::t('contentForm','Tax'); ?></strong></div></td>
          <td ><?php echo Yii::t('contentForm','currSym'); ?> <?php echo number_format($orden->iva, 2, ',', '.'); ?></td>
        </tr>
        <?php }?>  
        <?php if($orden->cupon){ //si utiliza cupon?> 
            <tr >
              <td colspan="10"><div class="text_align_right"><strong><?php echo Yii::t('contentForm','Cupón de Descuento').
                      " (".$orden->cupon->cupon->getDescuento()."):";
                      ?></strong></div></td>
              <td><?php echo Yii::t('contentForm', 'currSym').' '.
                      Yii::app()->numberFormatter->formatCurrency($orden->cupon->descuento, ''); ?></td>
            </tr>
        <?php } ?>
        <tr>
          <th colspan="10" ><div class="text_align_right"><strong>Total</strong></div></th>
          <th ><?php echo Yii::t('contentForm','currSym'); ?>  <?php echo number_format($orden->total, 2, ',', '.'); ?></th>
        </tr>
        <tr>
          <td colspan="10" ><div class="text_align_right"><strong>Peso total del pedido</strong></div></td>
          <td ><?php echo $orden->peso." Kg."; ?></td>
        </tr>           
      </table>
  
      
     <!-- <a href="#" title="Añadir productos" class="btn btn-info"><i class="icon-plus icon-white"></i> Añadir productos</a></div> </div> -->
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
  
  <div class="row" id="mensajes">
  	
  	

	
	<?php
Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".mensajes").animate({opacity: 1.0}, 3000).fadeOut("slow");',
   CClientScript::POS_READY
);
?>
  
  	
    <div class="span7">
      <h3 class="braker_bottom margin_top">MENSAJES</h3>
      <form>

        <div class="control-group">
        	<input type="text" id="asunto" placeholder="Asunto Del Mensaje" />
          	<textarea id="cuerpo" name="cuerpo" cols="" class="span7" rows="4" placeholder="Mensaje"></textarea>
        </div>
        <div class="control-group">
          <label class="checkbox">
          	<input type="checkbox" value="" id="notificar" > Notificar al Cliente por correo electrónico </label>
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
				$class=$status="";
				foreach($mensajes as $msj)
				{
					if(!is_null($msj->admin))
						{	$class='style="background-color:#F5F5F5"';
							$status='<p class="muted"><i class="icon-circle-arrow-right"></i> <strong>Entrada | </strong> De: <strong> Cliente | </strong><strong>'.date('d/m/Y', strtotime($msj->fecha)).'</strong> '.date('h:i A', strtotime($msj->fecha)).$status.'</p>';
							$icon='';
						}
					else {
							$status='<p class="muted"><i class="icon-circle-arrow-left"></i> <strong>Salida| </strong>Cliente Notificado <strong>| '.date('d/m/Y', strtotime($msj->fecha)).'</strong> '.date('h:i A', strtotime($msj->fecha)).'</p>';
							$icon='';
					}
	
						
					echo '<li class="media braker_bottom">
          					<div class="media-body" '.$class.'>';
					echo '<h4 class="color4"><i class=" icon-comment"></i> Asunto: '.$msj->asunto.'</h4>';	
					echo '<p>'.$msj->cuerpo.'</p>';
					echo $status;				
					$class=$status="";
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

<!------------------- MODAL REGISTRAR DEPOSITO -----------------> 
<div class="modal hide fade" id="modalDeposito">
 <?php $this->renderPartial('//orden/_modal_pago',array('orden_id'=>$orden->id)); ?>
</div>

<!------------------- MODAL WINDOW O 
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
      <li><strong>Monto</strong>: <?php echo Yii::t('contentForm','currSym'); ?> 6.500</li>
    </ul>
  </div>
  <div class="modal-footer"><a href="" title="ver" class="btn-link" target="_blank">Cancelar </a> <a href="#" title="Confirmar" class="btn btn-success">Aceptar el pago</a> </div>
</div>
<!------------------- MODAL WINDOW OFF ----------------->

<script>
	
 function enviar(id)
    {
        //var idDetalle = $("#idDetalle").attr("value");
        var nombre= $("#nombre").attr("value");
        var numeroTrans = $("#numeroTrans").attr("value");
        var dia = $("#dia").attr("value");
        var mes = $("#mes").attr("value");
        var ano = $("#ano").attr("value");
        var comentario = $("#comentario").attr("value");
        var banco = $("#banco").attr("value");
        var cedula = $("#cedula").attr("value");
        var monto = $("#monto").attr("value"); 
        var idOrden = id;

        if(nombre=="" || numeroTrans=="" || monto=="" || banco=="Seleccione")
        {
            alert("Por favor complete los datos.");
        }
        else
        {
        	//if(monto.indexOf(',')==(monto.length-2))
	      //  	monto+='0';
			//if(monto.indexOf(',')==-1)
			//	monto+=',00';
				
	      //  var pattern = /^\d+(?:\,\d{0,2})$/ ;
	        
	      //  if (pattern.test(monto)) { 
	      //  	monto = monto.replace(',','.'); 

	         $.ajax({
	            type: "post",
	            url: "<?php echo Yii::app()->createUrl('bolsa/cpago'); ?>",//"../../bolsa/cpago", // action de controlador de bolsa cpago
	            data: { 'nombre':nombre, 'numeroTrans':numeroTrans, 'dia':dia, 'mes':mes, 'ano':ano, 'comentario':comentario, 'idOrden':idOrden, 'banco':banco, 'cedula':cedula, 'monto':monto},
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
           
         //  }else{
	     //   	alert("Formato de cantidad no válido. Separe solo los decimales con una coma (,)");
	     //  }
           
        }// else grande


    }        
        
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
					window.location.reload(true);	
				}
	       	}//success
	       }) 
				
	}
	
	
	function aceptar(id){

		var uno = 'aceptar';
		
 		$.ajax({
	        type: "post", 
	        url: "<?php echo CController::createUrl('orden/validar'); ?>",
	        dataType: 'json', 
	        data: { 'accion':uno, 'id':id}, 
	        success: function (data) {
				if(data.status=="ok")
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
	        dataType: 'json', 
	        data: { 'accion':uno, 'id':id}, 
	        success: function (data) {
				if(data.status=="ok")
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
	        dataType: 'json',
	        data: { 'guia':guia, 'id':id}, 	        
	        success: function (data) {
				if(data.status=="ok")
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
