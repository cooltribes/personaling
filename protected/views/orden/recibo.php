<?php


$profile = Profile::model()->findByAttributes(array('user_id'=>$factura->orden->user_id));
$direccion_fiscal = DireccionFacturacion::model()->findByPk($factura->direccion_fiscal_id);
if(is_null($direccion_fiscal)){
    $direccion_fiscal = DireccionEnvio::model()->findByPk($factura->direccion_envio_id);
}
$ciudad_fiscal = Ciudad::model()->findByPk($direccion_fiscal->ciudad_id);
$provincia_fiscal = Provincia::model()->findByPk($direccion_fiscal->provincia_id);

$direccion_envio = DireccionEnvio::model()->findByPk($factura->direccion_envio_id);
$ciudad_envio = Ciudad::model()->findByPk($direccion_envio->ciudad_id);
$provincia_envio = Provincia::model()->findByPk($direccion_envio->provincia_id);
?>
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span12 bg_color3">
      <section class="margin_bottom_small padding_small ">
        <h1>Recibo</h1>
        <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered">
          <tr>
            <td width="50%">
            				<strong>Nombre de Empresa:</strong> <?php echo Yii::app()->params['clientName'];?><br/>
							<?php if(Yii::app()->language=="es_ve")
							{
								?><strong>RIF:</strong>
								 <?php 
							}else
							{
								?><strong>NIF:</strong>
								 <?php 
							} 
							echo Yii::app()->params['clientIdentification'];?> <br/> 
			   		
							<strong>Dirección Fiscal:</strong> <?php echo Yii::app()->params['clientAddress'];?> <br/>
								<?php echo Yii::app()->params['clientCity']." - ".Yii::app()->params['clientZIP']; ?><br/>
							<strong>Teléfono:</strong> <?php echo Yii::app()->params['clientPhone'];?><br/>
							<strong>Email:</strong> <?php echo Yii::app()->params['clientEmail'];?>
            
              </td>
            <td width="50%"><div class="text_align_right"> <img src="<?php echo Yii::app()->baseUrl; ?>/themes/bootstrap/images/logo_personaling.png" width="284" height="36" alt="Personaling"><br/><strong> Número de recibo: <span style="color:#F00"><?php echo str_pad($factura->id, 4, '0', STR_PAD_LEFT); ?></span> </strong> <br/>
                <strong> Fecha de emisión:</strong> <?php echo date('d/m/Y', strtotime($factura->fecha)); ?> </div></td>
          </tr>
          <tr>
          <tr>
            <td><strong><?php echo Yii::t('backEnd', 'Client / Company Name:'); ?></strong> 
                            <?php
                            echo $direccion_fiscal->nombre . ' ' . $direccion_fiscal->apellido;
                            ?>
                            <br/>
                            <strong><?php echo Yii::t('backEnd', 'Official Address:'); ?></strong> <?php echo $direccion_fiscal->dirUno . ' ' . $direccion_fiscal->dirDos; ?><br/>
                            <?php echo $ciudad_fiscal->nombre . ' - ' . $provincia_fiscal->nombre . '. ' . $direccion_fiscal->pais; ?><br/>
                            <?php if(Yii::app()->params['askId']){ ?>  
                            	<strong><?php echo Yii::t('contentForm', 'C.I.'); ?></strong> <?php echo $direccion_fiscal->cedula; ?> </td>
          						<?php } ?>
            <td><p><strong>Enviar a: </strong><?php echo $direccion_envio->nombre.' '.$direccion_envio->apellido; ?><br/>
                <strong>Dirección de envio: </strong><?php echo $direccion_envio->dirUno.' '.$direccion_envio->dirDos.'. '.$ciudad_envio->nombre.' - '.$provincia_envio->nombre.'. '.$direccion_envio->pais; ?></p></td>
          </tr>
          <tr>
            <td colspan="2">
            	<!--<strong>Estado</strong>: 
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
            	?>-->
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
	                  <td><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($precio->precioVenta, 2, ',', '.'); ?></td>
	                  <td><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($orden_ptc->cantidad*$orden_ptc->precio, 2, ',', '.'); ?></td>
	                </tr>
					<?php
                }
                ?>
                <tr>
                  <td colspan="4"><div class="text_align_right"><strong>Subtotal</strong>:</div></td>
                  <td><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($factura->orden->subtotal, 2, ',', '.'); ?></td>
                </tr>
                <tr>
                  <td colspan="4"><div class="text_align_right"><strong>Envío</strong>:</div></td>
                  <td><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($factura->orden->envio+$factura->orden->seguro, 2, ',', '.'); ?></td>
                </tr>
                <?php if(isset($factura->orden->descuento_look))
				{ ?>
					 <tr>
                 		 <td colspan="4"><div class="text_align_right"><strong>Descuento por Look</strong>:</div></td>
                 		 <td><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($factura->orden->descuento_look, 2, ',', '.'); ?></td>
                	</tr>
				<?php } ?>
                  <tr>
                  <td colspan="4"><div class="text_align_right"><strong>Descuento</strong>:</div></td>
                  <td><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($factura->orden->descuento, 2, ',', '.'); ?></td>
                </tr>

                </tr>
                  <tr>
                  <td colspan="4"><div class="text_align_right"><strong>Balance utilizado</strong>:</div></td>
                  <td><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($factura->orden->descuentoRegalo, 2, ',', '.'); ?></td>
                </tr>
                
                <tr>
                  <td colspan="4"><div class="text_align_right"><strong>I.V.A. sobre base imponible</strong></div></td>
                  <td><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($factura->orden->iva, 2, ',', '.'); ?></td>
                </tr>
                
               <!-- <tr>
                  <td colspan="4"><div class="text_align_right"><strong>Seguro</strong>:</div></td>
                  <td><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($factura->orden->seguro, 2, ',', '.'); ?></td>
               </tr>-->   
              
                <tr>
                  <th colspan="4"><div class="text_align_right">TOTAL</div></th>
                  <th><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($factura->orden->total, 2, ',', '.'); ?></th>
                </tr>
              </table></td>
          </tr>
        </table>
        <hr/>
       <p>
       	<?php 
       	if(Yii::app()->controller->action->id == 'recibo'){
       		echo CHtml::link('<i class="icon-print"></i> Imprimir', $this->createUrl('imprimir', array('id'=>$factura->id, 'documento' => 'recibo')), array('class'=>'btn margin_top pull-right', 'target'=>'_blank'));
		} 
       	?>
       </p>
      </section>
    </div>
  </div>
</div>