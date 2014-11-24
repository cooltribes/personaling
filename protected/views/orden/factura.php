<?php
$profile = Profile::model()->findByAttributes(array('user_id' => $factura->orden->user_id));
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
                <h1><?php echo Yii::t('backEnd', 'Receipt'); ?></h1>
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
                        <td width="50%">
                            <div class="text_align_right">
                            	 <img src="<?php echo Yii::app()->baseUrl; ?>/themes/bootstrap/images/logo_personaling.png" width="284" height="36" alt="Personaling"><br/>
                            	<strong><?php echo Yii::t('backEnd', 'Receipt number:'); ?><span style="color:#F00"><?php echo str_pad($factura->id, 4, '0', STR_PAD_LEFT); ?></span> </strong>
                                <br/><strong><?php echo Yii::t('backEnd', 'Date of issue:'); ?></strong> <?php echo date('d/m/Y', strtotime($factura->fecha)); ?>
                            </div>
                        </td>
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
                            	<strong><?php echo Yii::t('contentForm', 'C.I.'); ?></strong> <?php echo $direccion_fiscal->cedula; ?></td>
                        	<?php } ?>
                        <td><p><strong><?php echo Yii::t('backEnd', 'Send to:'); ?></strong> <?php echo $direccion_envio->nombre . ' ' . $direccion_envio->apellido; ?><br/>
                                <strong><?php echo Yii::t('backEnd', 'Shipping Address:'); ?></strong> <?php echo $direccion_envio->dirUno . ' ' . $direccion_envio->dirDos . '. ' . $ciudad_envio->nombre . ' - ' . $provincia_envio->nombre . '. ' . $direccion_envio->pais; ?></p></td>
                    </tr>
                    <tr>
                        <td colspan="2"><!--<strong><?php echo Yii::t('backEnd', 'State'); ?>:</strong> 
                            <?php
                            switch ($factura->estado) {
                                case '1':
                                    echo Yii::t('backEnd', 'Pending');
                                    break;
                                case '2':
                                    echo Yii::t('backEnd', 'Paid');
                                    break;
                                default:
                                    echo Yii::t('backEnd', 'Unknown');
                                    break;
                            }
                            ?>-->
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><table width="100%" cellspacing="0" cellpadding="0" border="0" class="table table-bordered table-hover table-striped">
                                <tr>
                                    <th scope="col"><?php echo Yii::t('backEnd', 'Code'); ?></th>
                                    <th scope="col"><?php echo Yii::t('backEnd', 'Product Name'); ?></th>
                                    <th scope="col"><?php echo Yii::t('backEnd', 'Quantity'); ?></th>
                                    <th scope="col"><?php echo Yii::t('backEnd', 'Unit Price'); ?></th>
                                    <th scope="col"><?php echo Yii::t('backEnd', 'Total'); ?></th>
                                </tr>
                                <?php
                                foreach ($factura->orden->ohptc as $ordenhasproducto) {
                                    ?>
                                    <tr>
                                        <td><?php echo $ordenhasproducto->preciotallacolor->sku; ?></td>
                                        <td><?php echo $ordenhasproducto->preciotallacolor->producto->nombre; ?></td>
                                        <td><?php echo $ordenhasproducto->cantidad; ?></td>
                                        <td><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($ordenhasproducto->precio, 2, ',', '.'); ?></td>
                                        <td><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($ordenhasproducto->cantidad * $ordenhasproducto->precio, 2, ',', '.'); ?></td>
                                    </tr>       
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="4"><div class="text_align_right"><strong><?php echo Yii::t('backEnd', 'Subtotal'); ?></strong>:</div></td>
                                    <td><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($factura->orden->subtotal, 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4"><div class="text_align_right"><strong><?php echo Yii::t('backEnd', 'Shipping'); ?></strong>:</div></td>
                                    <td><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($factura->orden->envio + $factura->orden->seguro, 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4"><div class="text_align_right"><strong><?php echo Yii::t('backEnd', 'Discount'); ?></strong>:</div></td>
                                    <td><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($factura->orden->descuento, 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4"><div class="text_align_right"><strong><?php echo Yii::t('backEnd', 'Used balance'); ?></strong>:</div></td>
                                    <td><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($factura->orden->descuentoRegalo, 2, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4"><div class="text_align_right"><strong><?php echo Yii::t('backEnd', 'VAT on taxable'); ?></strong></div></td>
                                    <td><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($factura->orden->iva, 2, ',', '.'); ?></td>
                                </tr>

                                <tr>
                                    <th colspan="4"><div class="text_align_right"><?php echo Yii::t('backEnd', 'Total'); ?></div></th>
                                <th><?php echo Yii::t('contentForm', 'currSym'); ?> <?php echo number_format($factura->orden->total, 2, ',', '.'); ?></th>
                    </tr>
                </table></td>
                </tr>
                <!--<tr>
                    <td colspan="2"><span style="color:#F00;border-top: none;"><?php echo Yii::t('backEnd', 'No right to tax credit'); ?></span></td>
                </tr>-->
                </table>
                <hr/>
            </section>
            <?php
            if (Yii::app()->controller->action->id == 'factura') {
                echo CHtml::link('<i class="icon-print"></i> '.  Yii::t('backEnd', 'Print'), $this->createUrl('imprimir', array('id' => $factura->id, 'documento' => 'factura')), array('class' => 'btn margin_top pull-right', 'target' => '_blank'));
            }
            ?>
        </div>
    </div>
</div>
<!-- /container -->