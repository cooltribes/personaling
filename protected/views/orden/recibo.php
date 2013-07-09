<?php
$profile = Profile::model()->findByAttributes(array('user_id'=>$factura->orden->user_id));
$direccion_fiscal = Direccion::model()->findByPk($factura->direccion_fiscal_id);
$direccion_envio = Direccion::model()->findByPk($factura->direccion_envio_id);
?>
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12 bg_color3">
      <section class="margin_bottom_small padding_small ">
        <h1>Recibo</h1>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
          <tr>
            <td width="50%"><strong> PERSONALING,  C.A</strong><br/>
              Avenida Santiago Mariño - Edificio Miramar. Torre A. Oficina 17.<br/>
              Isla de Margarita<br/>
              Venezuela 2001<br/>
              RIF J-XXXX </td>
            <td width="50%"><div class="text_align_right"> <img src="<?php echo Yii::app()->baseUrl; ?>/images/logo_personaling.png" width="284" height="36" alt="Personaling"><br/><strong> Número de recibo: <span style="color:#F00"><?php echo str_pad($factura->id, 4, '0', STR_PAD_LEFT); ?></span> </strong> <br/>
                <strong> Fecha de emisión:</strong> <?php echo date('d/m/Y', strtotime($factura->fecha)); ?> </div></td>
          </tr>
          <tr>
          <tr>
            <td><strong>Cliente / Razón Social:</strong> 
              <?php
			  //echo $profile->first_name.' '.$profile->last_name;
			  echo $direccion_fiscal->nombre.' '.$direccion_fiscal->apellido;
              ?><br/>
              <strong>Domicilio fiscal:</strong> <?php echo $direccion_fiscal->dirUno.' '.$direccion_fiscal->dirDos; ?><br/>
              <?php echo $direccion_fiscal->ciudad.' - '.$direccion_fiscal->estado.'. '.$direccion_fiscal->pais; ?><br/>
              <strong>RIF:</strong> <?php echo $direccion_fiscal->cedula; ?> </td>
            <td><p><strong>Enviar a: </strong><?php echo $direccion_envio->nombre.' '.$direccion_envio->apellido; ?><br/>
                <strong>Dirección de envio: </strong><?php echo $direccion_envio->dirUno.' '.$direccion_envio->dirDos.'. '.$direccion_envio->ciudad.' - '.$direccion_envio->estado.'. '.$direccion_envio->pais; ?></p></td>
          </tr>
          <tr>
            <td colspan="2"><strong>Estado</strong>: 
            	<?php
            	switch ($factura->estado) {
					case '1':
						echo 'Pendiente';
						break;
					case '2':
						echo 'Pagada';
						break;
					default:
						echo 'Desconocido';
						break;
				}
            	?>
            </td>
          </tr>
          <tr>
            <td colspan="2"><table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered table-hover table-striped">
                <tr>
                  <th scope="col">Código</th>
                  <th scope="col">Nombre del Producto</th>
                  <th scope="col">Cantidad</th>
                  <th scope="col">Precio Unitario</th>
                  <th scope="col">Total</th>
                </tr>
                <?php
                foreach ($factura->orden->productos as $ptc) {
                	$orden_ptc = OrdenHasProductotallacolor::model()->findByAttributes(array('preciotallacolor_id'=>$ptc->id, 'tbl_orden_id'=>$factura->orden->id));
					$producto = Producto::model()->findByPk($ptc->producto_id);
					$precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$producto->id));
					
                    ?>
                    <tr>
	                  <td><?php echo $ptc->sku; ?></td>
	                  <td><?php echo $producto->nombre; ?></td>
	                  <td><?php echo $orden_ptc->cantidad; ?></td>
	                  <td>Bs. <?php echo number_format($precio->precioVenta, 2, ',', '.'); ?></td>
	                  <td>Bs. <?php echo number_format($orden_ptc->cantidad*$precio->precioVenta, 2, ',', '.'); ?></td>
	                </tr>
					<?php
                }
                ?>
                <tr>
                  <td colspan="4"><div class="text_align_right"><strong>Subtotal</strong>:</div></td>
                  <td>Bs. <?php echo number_format($factura->orden->subtotal, 2, ',', '.'); ?></td>
                </tr>
                <tr>
                  <td colspan="4"><div class="text_align_right"><strong>I.V.A. sobre base imponible</strong></div></td>
                  <td>Bs. <?php echo number_format($factura->orden->iva, 2, ',', '.'); ?></td>
                </tr>
                <tr>
                  <td colspan="4"><div class="text_align_right"><strong>Envío</strong>:</div></td>
                  <td>Bs. <?php echo number_format($factura->orden->envio, 2, ',', '.'); ?></td>
                </tr>
                <tr>
                  <td colspan="4"><div class="text_align_right"><strong>Descuento</strong>:</div></td>
                  <td>Bs. <?php echo number_format($factura->orden->descuento, 2, ',', '.'); ?></td>
                </tr>
                <tr>
                  <th colspan="4"><div class="text_align_right">TOTAL</div></th>
                  <th>Bs. <?php echo number_format($factura->orden->total, 2, ',', '.'); ?></th>
                </tr>
              </table></td>
          </tr>
        </table>
        <hr/>
       <p>Solo el original da derecho a crédito fiscal
       	<?php 
       	if(Yii::app()->controller->action->id == 'recibo'){
       		echo CHtml::link('<i class="icon-print"></i> Imprimir', $this->createUrl('imprimir', array('id'=>$factura->id)), array('class'=>'btn margin_top pull-right', 'target'=>'_blank'));
		} 
       	?>
       </p>
      </section>
    </div>
  </div>
</div>