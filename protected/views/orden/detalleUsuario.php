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
    <h1> <?php echo Yii::t('contentForm', 'Order').' #'.$orden->id; ?></h1>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table ">
    <tr>
      <th scope="col" colspan="4">  
          <?php
          if($orden->fecha!="")
               echo Yii::t('contentForm','Order Date').' '.date("d/m/Y - h:i a",strtotime($orden->fecha)).".";

          ?>
          </th>
      <th scope="col" colspan="2"></th>
    </tr>
    <tr>
      <td><p class="T_xlarge margin_top_xsmall color1">
<?php
//----------------------Estado

   echo $orden->textestado;


    // agregar demas estados
?>
          </p>
       <?php  echo Yii::t('contentForm','Current state'); ?></td>
      <td><p class="T_xlarge margin_top_xsmall"> 2 </p>
        <?php  echo Yii::t('contentForm','Documents'); ?></td>

     <?php
      $ind_tot = 0;
      $look_tot = 0;
      $compra = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id, 'devolucion_id'=>0));

     

      ?>


      <td><p class="T_xlarge margin_top_xsmall"><?php   echo count($compra); ?></p>
        <?php echo Yii::t('contentForm','Items'); ?><br/></td>
      <td><p class="T_xlarge margin_top_xsmall"><?php

   echo Yii::app()->numberFormatter->formatDecimal($orden->getMontoActivo());
       ?></p>

        <?php
//----------------------Estado

    if($orden->estado == 1 || ($orden->estado == 7 && isset($balance)))
        echo Yii::t('contentForm', 'currSym').' '."Pendientes por pagar";

    if($orden->estado == 2)
        echo Yii::t('contentForm', 'currSym').' '."Pendientes por confirmar";

    if($orden->estado == 3 || $orden->estado == 8 || $orden->estado == 4)
        echo Yii::t('contentForm', 'currSym').' '."ya pagados";

    if($orden->estado == 5)
        echo Yii::t('contentForm','currSym').'. '.Yii::t('contentForm','Order Cancelled');

    if($orden->estado == 7 && isset($balance))
        echo Yii::t('contentForm','currSym').'. '.Yii::t('contentForm','Missing');


    // agregar demas estados
?>
       </td>
         <td><?php if ($orden->estado==1||$orden->estado==6||$orden->estado==7){?><a href="#myModal" role="button" class="btn btn-info margin_top pull-right" data-toggle="modal" ><i class="icon-check icon-white">
         		

         </i> <?php echo Yii::t('contentForm','Payment report'); ?>

         	<?php } if($orden->estado == 4)
         	echo"<div><a onclick='entregado(".$orden->id.")' class='btn btn-info margin_top margin_bottom pull-left'>Notificar Entrega</a></div>"; ?>
        </td>
         	
          <td>
          	<?php if($orden->estado == 8) // recibido
	{
      		
      		$url = Yii::app()->baseUrl."/orden/devoluciones/".$orden->id;
      		
      		$this->widget('bootstrap.widgets.TbButton', array(
			    'label'=>'Solicitar devolución',
			    'buttonType'=>'link',
			    'url'=>$url,
			    'type'=>'warning', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
			    'htmlOptions'=>array('class'=>'span2 pull-right margin_top_xsmall')
			)); ?>
	
	<?php 	} 	?>	<br/>
          	
          	
          	
          	<a onclick="window.print();" class="span2 btn margin_top_xsmall pull-right"><i class="icon-print"></i> <?php echo Yii::t('contentForm','Print order'); ?></a></td>
    </tr>
  </table>
  <hr/>
  <div class="row">
    <div class="span7">

          <?php

            $detalleDePago = Detalle::model()->findAllByAttributes(array('orden_id'=>$orden->id));

            if($orden->estado != 1 && $orden->estado != 5){

            echo("
                  <div id='pago' class='well well-small margin_top well_personaling_small'>
                  <h3 class='braker_bottom '> Método de Pago</h3>
                    <table width='100%' border='0' cellspacing='0' cellpadding='0' class='table table-bordered table-hover table-striped'>
                      <tr>
                        <th scope='col'>".Yii::t('contentForm','Date')."</th>
                        <th scope='col'>".Yii::t('contentForm','Payment method')."</th>
                        <th scope='col'>".Yii::t('contentForm','ID Transaction')."</th>
                        <th scope='col'>".Yii::t('contentForm','Amount')."</th>
                      </tr>
                  ");

            foreach($detalleDePago as $detalle){

                echo("<tr>");

                    if($detalle->estado == 0  && $detalle->nTransferencia!="") // stand by
                    {

                        echo("<td>".date("d/m/Y - h:i a",strtotime($detalle->fecha))."</td>");

                        if($detalle->tipo_pago == 1)
                            echo("<td>".Yii::t('contentForm','Awaiting confirmation deposit')."</td>");
                            //hacer los demas tipos

                        echo("<td>".$detalle->nTransferencia."</td>");
                        echo("<td>".Yii::app()->numberFormatter->formatDecimal($detalle->monto)." ".Yii::t('contentForm','currSym').".</td>");
                    }
                    else
                        if($detalle->estado == 1) // si fue aceptado
                        {

//                            echo("<td>".date("d/m/Y - h:i a",strtotime($detalle->fecha))."</td>");
//
//                            if($detalle->tipo_pago == 1)
//                                echo("<td>".Yii::t('contentForm','Deposit or Transference')."</td>");
//                            if($detalle->tipo_pago == 2)
//                                echo("<td>".Yii::t('contentForm','Credit Card')."</td>");
// 						if($detalle->tipo_pago == 3)
//							echo("<td>".Yii::t('contentForm','Balance')."</td>");						
//						if($detalle->tipo_pago == 4)
//							echo("<td>".Yii::t('contentForm','MercadoPago')."</td>");	                               //hacer los demas tipos
//
//                            echo("<td>".$detalle->nTransferencia."</td>");
//                            echo("<td>".Yii::app()->numberFormatter->formatDecimal($detalle->monto)." ".Yii::t('contentForm','currSym')."</td>");
                            
                             echo("<td>".date("d/m/Y",strtotime($detalle->fecha))."</td>");
                            echo("<td>".$detalle->getTipoPago()."</td>");

                            echo("<td>".$detalle->nTransferencia."</td>");	
                            echo("<td>".Yii::app()->numberFormatter->formatDecimal($detalle->monto)."</td>");
                            

                        }
                    else if($detalle->estado == 2) // rechazado
                        {

                        echo("<td>".date("d/m/Y - h:i a",strtotime($detalle->fecha))."</td>");

                        if($detalle->tipo_pago == 1)
                            echo("<td>".Yii::t('contentForm','Deposit or Transference')."</td>");
                            //hacer los demas tipos

                        echo("<td>".Yii::t('contentForm','Payment declined')."</td>");
                        echo("<td>".Yii::app()->numberFormatter->formatDecimal($detalle->monto)." ".Yii::t('contentForm','currSym')."</td>");

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
        <h3 class="braker_bottom "> <?php echo Yii::t('contentForm','Shipping'); ?> </h3>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
          <tr>
            <th scope="col"><?php echo Yii::t('contentForm','Date estimated delivery'); ?></th>
            <th scope="col"><?php echo Yii::t('contentForm','Type'); ?></th>
            <th scope="col"><?php echo Yii::t('contentForm','Courier delivery'); ?></th>
            <th scope="col"><?php echo Yii::t('contentForm','Weigth'); ?></th>
            <th scope="col"><?php echo Yii::t('contentForm','Shipping cost'); ?></th>
            <th scope="col"><?php echo Yii::t('contentForm','Tracking'); ?></th>
          </tr>
          <tr>
            <td>21/12/2012 - 12:21 PM</td>
            <td>Delivery</td>
            <td><?php

            
            echo $orden->shipCarrier;
            ?>
            
            </td>
            <td>0,00 Kg.</td>

            <td><?php echo $orden->envio+$orden->seguro.' '.Yii::t('contentForm', 'currSym'); ?></td>
        <!--  <td><?php echo $orden->envio.' '.Yii::t('contentForm','currSym'); ?> .</td>
-->
            <td><?php echo $orden->tracking; ?></td>
          </tr>
        </table>
      </div>
      <?php

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
            	<div class="span3"> <span class="type"><strong><?php echo Yii::t("contentForm","C.I.");?></strong>:</span><?php echo $direccionEnvio->cedula; ?></div>
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
            <div class="span3"> <span class="type"><strong>Cédula</strong>:</span><?php echo $orden->direccionFacturacion->cedula; ?></div>
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
        <h3 class="braker_bottom"><strong><?php echo Yii::t('contentForm','Progress order');  ?></strong></h3>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
          <tr>
            <th scope="col"><?php echo Yii::t('contentForm','State');  ?></th>
            <th scope="col"><?php echo Yii::t('contentForm','User');  ?></th>
            <th scope="col"><?php echo Yii::t('contentForm','Date');  ?></th>
          </tr> 
          <?php

          $estados = Estado::model()->findAllByAttributes(array('orden_id'=>$orden->id),array('order'=>'id DESC'));

              foreach ($estados as $est)
              {
                  echo("<tr>");

                echo"<td>".$orden->getTextEstado($est->estado)."</td>";

                $usu = User::model()->findByPk($est->user_id);
                echo ("<td>".$usu->profile->first_name." ".$usu->profile->last_name."</td>");

                $fecha = date("d/m/Y",strtotime($est->fecha));
                echo("<td>".$fecha." </td>");
                echo("</tr>");
              }

          ?>
          <tr>
            <td><?php echo Yii::t('contentForm','New order');  ?></td>
            <td><?php echo $usuario->profile->first_name." ".$usuario->profile->last_name; ?></td>
            <td><?php echo date("d/m/Y",strtotime($orden->fecha)); ?></td>
          </tr>
        </table>
      </div>

  <div class="well well-small margin_top well_personaling_small">  <h3 class="braker_bottom margin_top"> <?php echo Yii::t('contentForm','Documents');  ?></h3>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
          <th scope="col"><?php echo Yii::t('contentForm','Date');  ?></th>
          <th scope="col"><?php echo Yii::t('contentForm','Document');  ?></th>
          <th scope="col"><?php echo Yii::t('contentForm','Number');  ?></th>
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
   <div class="well well-small margin_top well_personaling_small">   <h3 class="braker_bottom margin_top">Productos</h3>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped" align="center">
        <tr>
          <th scope="col"><?php echo Yii::t('contentForm','Name of items');  ?></th>
          <th scope="col"><?php echo Yii::t('contentForm','Brand');  ?></th>
          <th scope="col"><?php echo Yii::t('contentForm','Color');  ?></th>
          <th scope="col"><?php echo Yii::t('contentForm','Size');  ?></th>

          <th scope="col"><?php echo Yii::t('contentForm','Quantity');  ?></th>

          <th scope="col"><?php echo Yii::t('contentForm','Price');  ?></th>

        </tr>
        <?php
         $individuales=OrdenHasProductotallacolor::model()->countIndividuales($orden->id);
          $looks=OrdenHasProductotallacolor::model()->countLooks($orden->id);
          $compra = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id));
            $row=0;
            $productos = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id)); // productos de la orden
            $lkids=OrdenHasProductotallacolor::model()->getLooks($orden->id);
            foreach ($lkids as  $lkid){

                $lookpedido = Look::model()->findByPk($lkid['look_id']);
                $precio = $lookpedido->getPrecio(false);
                echo("<tr class='bg_color5' >"); // Aplicar fondo de tr, eliminar borde**
                            // echo("<td></td>");
                echo("<td colspan='5'><strong>".$lookpedido->title."</strong></td>");// Referencia

                echo("<td>".number_format(OrdenHasProductotallacolor::model()->precioLook($orden->id, $lkid['look_id']), 2, ',', '.')."</td>"); // precio

                $prodslook=OrdenHasProductotallacolor::model()->findAllByAttributes(array("tbl_orden_id"=>$orden->id, "look_id"=>$lkid['look_id']));
                foreach($prodslook as $prodlook){
                    $ptclk = Preciotallacolor::model()->findByAttributes(array('id'=>$prodlook->preciotallacolor_id));
                                $prdlk = Producto::model()->findByPk($ptclk->producto_id);
                                $marca=Marca::model()->findByPk($prdlk->marca_id);
                                $talla=Talla::model()->findByPk($ptclk->talla_id);
                                $color=Color::model()->findByPk($ptclk->color_id);


                                echo("<tr>");
                                 // nombre
                                echo("<td>".$prdlk->nombre."</td>"); // nombre
                                echo("<td>".$marca->nombre."</td>");
                                echo("<td>".$color->valor."</td>");
                                echo("<td>".$talla->valor."</td>");
                                // cantidad en existencia
                                echo("<td>".$prodlook->cantidad."</td>"); // cantidad en pedido


                                //echo("<td>oid".$prod->tbl_orden_id."lid ".$prod->look_id." ptcid".$ptclk->id."</td>");//.$prodlook->precio."</td>"); // precio
                                echo("<td>".number_format($prodlook->precio, 2, ',', '.')."</td></tr>");
                }

            }
            //INDIVIDUALES

            if($individuales>0)
            echo("<tr><td colspan='6' class='bg_color5'><strong>".Yii::t('contentForm','Individual items')."</strong></td></tr>");
           // $separados=OrdenHasProductotallacolor::model()->getIndividuales($orden->id);
              $separados = OrdenHasProductotallacolor::model()->findAllByAttributes(array("tbl_orden_id"=>$orden->id, "look_id"=>0));
            foreach($separados as $prod){
                $ptc = Preciotallacolor::model()->findByAttributes(array('id'=>$prod->preciotallacolor_id)); // consigo existencia actual
                $indiv = Producto::model()->findByPk($ptc->producto_id); // consigo nombre
                $precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$ptc->producto_id)); // precios
                $marca=Marca::model()->findByPk($indiv->marca_id);
                $talla=Talla::model()->findByPk($ptc->talla_id);
                $color=Color::model()->findByPk($ptc->color_id);

                echo("<tr>");

                echo("<td>".$indiv->nombre."</td>"); // nombre
                echo("<td>".$marca->nombre."</td>");
                echo("<td>".$color->valor."</td>");
                echo("<td>".$talla->valor."</td>");

                echo("<td>".$prod->cantidad."</td>"); // cantidad en pedido

                echo("<td>".number_format($prod->precio, 2, ',', '.')."</td>"); // precio


                        echo("</tr>");
            }







      ?>


        <!-- Comienzo del resumen del pedido -->





      </table>


  </div>
  <!-- INFORMACION DEL PEDIDO OFF -->




  </div>
    <div class="span5">
      <div class="well well-small margin_top well_personaling_small"> <h3 class="braker_bottom margin_top"> <?php echo Yii::t('contentForm','Order Summary');  ?></h3>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
          <th scope="col"><?php echo Yii::t('contentForm','Nro. looks');  ?></th>
          <th scope="col"><?php echo($looks); ?></th>
        </tr>
        <tr>
          <td><?php echo Yii::t('contentForm','Nro. items');  ?></td>
          <td><?php echo($individuales); ?></td>
        </tr>
        <tr>
<!--
          <td>SubTotal</td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->subtotal).' '.Yii::t('contentForm', 'currSym'); ?></td>
        </tr>
        <tr>
          <td>Descuento</td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->descuento).' '.Yii::t('contentForm', 'currSym');?></td>
        </tr>
        <tr>
          <td>Envio y Transporte</td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->envio).' '.Yii::t('contentForm', 'currSym'); ?></td>
        </tr>
        <tr>
          <td>Impuesto</td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->iva).' '.Yii::t('contentForm', 'currSym'); ?></td>
        </tr>
        <tr>
          <td>Total</td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->total).' '.Yii::t('contentForm', 'currSym'); ?></td>
-->
          <td><?php echo Yii::t('contentForm','Subtotal');  ?></td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->subtotal). " ".Yii::t('contentForm','currSym')."."; ?></td>
        </tr>
        <tr>
          <td><?php echo Yii::t('contentForm','Discount');  ?></td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->descuento). " ".Yii::t('contentForm','currSym')."."; ?></td>
        </tr>
        <tr>
          <td><?php echo Yii::t('contentForm','Used balance');  ?></td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->descuentoRegalo). " ".Yii::t('contentForm','currSym')."."; ?></td>
        </tr>
        <tr>
          <td><?php echo Yii::t('contentForm','Shipping and Transport');  ?></td>
          <td><?php 
          	if($orden->envio>0)
          		echo Yii::app()->numberFormatter->formatDecimal($orden->envio+$orden->seguro). " ".Yii::t('contentForm','currSym')."."; 
        	else
        		echo "<b class='text-success'>GRATIS</b>";  ?></td>
        </tr>
       <?php if($orden->iva>0){?>
		<tr>
          <td><?php echo Yii::t('contentForm','Tax');  ?></td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->iva). " ".Yii::t('contentForm','currSym')."."; ?></td>
        </tr>
        <?php }?>
        <?php if($orden->cupon){ //si utiliza cupon?> 
            <tr>
              <td><?php echo Yii::t('contentForm','Cupón de Descuento').
                      " (".$orden->cupon->cupon->getDescuento()."):";
                      ?></td>
              <td><?php echo Yii::t('contentForm', 'currSym').' '.
                      Yii::app()->numberFormatter->formatCurrency($orden->cupon->descuento, ''); ?></td>
            </tr>
            <?php } ?> 
        <tr>
          <td><?php echo Yii::t('contentForm','Total');  ?></td>
          <td><?php echo Yii::app()->numberFormatter->formatDecimal($orden->total). " ".Yii::t('contentForm','currSym')."."; ?></td>

        </tr>
      </table></div>
    </div>



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
</div>
 
  
     
     <!-- MENSAJES ON -->
  
  <div class="row" id="mensajes">
    <div class="span7">
      <h3 class="braker_bottom margin_top"><?php echo Yii::t('contentForm','Messages'); ?></h3>
      <form>
        <!--<div class="control-group">
          <select>
            <option>Elija un mensaje estandar</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
          </select>
        </div>-->
        <div class="control-group">
        	<input type="text" id="asunto" placeholder="<?php echo Yii::t('contentForm','Subject'); ?>" />
          	<textarea id="cuerpo" name="cuerpo" cols="" class="span7" rows="4" placeholder="Mensaje"></textarea>
        </div>
       <!-- <div class="control-group">
          <label class="checkbox">
          	<input type="checkbox" value="" id="notificar" > Notificar al Cliente por eMail </label>
            <input type="checkbox" value="" id="visible" > Hacer visible en el Frontend</label>
        </div>-->
          <label class="checkbox">
        <div class="form-actions "><a onclick="mensaje(<?php echo $orden->user_id.",".$orden->id; ?>)" title="Enviar" class="btn btn-info"><i class="icon-envelope icon-white"></i>  Enviar comentario</a> </div>
      </label>
      </form>
    </div>
    <div class="span5">
      <h3 class="braker_bottom margin_top"><?php echo Yii::t('contentForm','Message history'); ?></h3>
      <?php
      
      	$mensajes = Mensaje::model()->findAllByAttributes(array('orden_id'=>$orden->id,'user_id'=>$orden->user_id));
      	
		if(count($mensajes) > 0)
		{
			?>	
			<ul class="media-list">
			<?php
				$from=$class="";
				foreach($mensajes as $msj)
				{
					if(is_null($msj->admin))
						{	$class='style="background-color:#F5F5F5"';
							$from='<i class="icon-circle-arrow-right"></i> <strong>'.Yii::t('contentForm','Input').' | </strong> '.Yii::t('contentForm','From').': <strong>Admin | </strong> ';
						}
					else
						$from='<i class="icon-circle-arrow-left"></i> <strong>'.Yii::t('contentForm','Output').' | </strong> Status: <strong>Enviado | </strong> ';
					echo '<li class="media braker_bottom">
          					<div class="media-body" '.$class.'>';
					echo '<h4 class="color4"><i class=" icon-comment"></i> '.Yii::t('contentForm','Subject').': '.$msj->asunto.'</h4>';	
					echo '<p>'.$msj->cuerpo.'</p>';	
					echo '<p class="muted">'.$from.'<strong>'.date('d/m/Y', strtotime($msj->fecha)).'</strong> '.date('h:i A', strtotime($msj->fecha)).'</p>';
					$class="";				
				}
			?>
			</ul>
			<?php
		}
		else {
			echo '<h4 class="color4">'.Yii::t('contentForm','No messages have been posted').'</h4>';	
		}
      
      ?>
      
    </div>

    
    <!-- MENSAJES OFF -->
     
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

<!--           </div>



        </li>
      </ul> -->





 <!-- </div>
 <!-- MENSAJES OFF -->


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
<div class="modal hide fade" id="myModal">
 <?php $this->renderPartial('//orden/_modal_pago',array('orden_id'=>$orden->id)); ?>
</div>


<!-- // Modal Window -->

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
	       // 	monto+='0';
			//if(monto.indexOf(',')==-1)
			//	monto+=',00';
				
	      //  var pattern = /^\d+(?:\,\d{0,2})$/ ;
	        
	      //  if (pattern.test(monto)) { 
	      //  	monto = monto.replace(',','.'); 

	         $.ajax({
	            type: "post",
	            url: "<?php echo Yii::app()->createUrl('bolsa/cpago'); ?>", // action de controlador de bolsa cpago
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
           
          // }else{
	      //  	alert("Formato de cantidad no válido. Separe solo los decimales con una coma (,)");
	      // }
           
        }// else grande


    }

function mensaje(user_id,orden_id){
		
		var asunto = $('#asunto').attr('value');
		var cuerpo = $('#cuerpo').attr('value');
		
		//var orden_id = $('#orden_id').attr('value');
		
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
	        data: { 'asunto':asunto, 'cuerpo':cuerpo,'user_id':user_id, 'orden_id':orden_id, 'admin':1}, 
	        success: function (data) {
				if(data=="ok")
				{
					window.location.reload(true);	
				}
	       	}//success
	       }) 
				
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