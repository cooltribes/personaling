<table class="w580" width="580" cellpadding="0" cellspacing="0" border="0">
    <tbody>
        <tr>
            <td class="w580" width="580"><!-- CONTENIDO ON -->

                <?php
                $user = User::model()->findByPk($devolucion->orden->user_id);

                // $pago = Pago::model()->findByAttributes(array('id'=>$orden->pago_id));
                //echo $orden->pago_id;
                ?>


                <h3 style="color:#999999;">RESUMEN DE TU SOLICITUD</h3>
                <table width="100%" border="0" cellspacing="3" style="margin-bottom:10px;" cellpadding="5">
                    <tr>
                        <td style=" background-color:#dff0d8; padding:6px;  color:#468847; margin-bottom:5px"><p class="well well-small"><strong>Número de confirmación:</strong> <?php echo $devolucion->id; ?></p></td>

                        <td style=" background-color:#dff0d8; color:#468847;"><p> <strong>Orden #</strong>: <?php echo $devolucion->orden_id; ?></p></td>
                    </tr>
                    <tr>
                        <td style=" background-color:#dff0d8; color:#468847;"><strong>Monto a devolver</strong>: <?php echo number_format($devolucion->montodevuelto, 2, ',', '.'); ?></td>
                        <td style=" background-color:#dff0d8; color:#468847;"><p> <strong>Fecha de solicitud</strong>: <?php echo date('d/m/Y', strtotime($devolucion->fecha)); ?></p></td>
                    </tr>
                </table>

                <hr/>
                <br/>
                <h3 style="color:#999999;">DETALLES DE LA SOLICITUD</h3>

                <!-- Look ON -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
                    <tr>
                        <th style=" background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center" scope="col"></th>

                        <th style="border:solid 1px #FFF; background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center" scope="col">Marca</th>
                        <th style="border:solid 1px #FFF;  background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center"  scope="col">Nombre</th>
                        <th style="border:solid 1px #FFF;  background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center"  scope="col">Color</th>
                        <th style="border:solid 1px #FFF;  background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center"  scope="col">Talla</th>
                        <th style="border:solid 1px #FFF;  background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center"  scope="col">Cant</th>
                        <th width="180" style="border:solid 1px #FFF;  background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center"  scope="col">Motivo</th>



                    </tr>

                    <?php
                    $separados = Devolucionhaspreciotallacolor::model()->getxDevolucion($devolucion->id);
                    foreach ($separados as $prod) {
                        $ptc = Preciotallacolor::model()->findByAttributes(array('id' => $prod['preciotallacolor_id'])); // consigo existencia actual
                        $indiv = Producto::model()->findByPk($ptc->producto_id); // consigo nombre
                        $precio = Precio::model()->findByAttributes(array('tbl_producto_id' => $ptc->producto_id)); // precios
                        $marca = Marca::model()->findByPk($indiv->marca_id);
                        $talla = Talla::model()->findByPk($ptc->talla_id);
                        $color = Color::model()->findByPk($ptc->color_id);

                        $imagen = Imagen::model()->findAllByAttributes(array('tbl_producto_id' => $indiv->id, 'color_id' => $color->id), array('order' => 'orden'));
                        $contador = 0;
                        $foto = "";
                        $label = $color->valor;
                        //$label = "No hay foto</br>para el color</br> ".$color->valor;
                        if (!is_null($ptc->imagen)) {
                            $foto = CHtml::image("http://www.personaling.es" . Yii::app()->baseUrl . str_replace(".", "_thumb.", $ptc->imagen['url']), "Imagen ", array("width" => "40", "height" => "40"));
                        } else {
                            $foto = "No hay foto</br>para el color";
                        }


                        echo("<tr>");

                        echo("<td style='vertical-align: middle; text-align: center'><div>" . $foto . "<br/>" . $label . "</div></td>");

                        echo("<td style='vertical-align: middle; text-align: center'>" . $marca->nombre . "</td>");
                        echo( "<td style='vertical-align: middle; text-align: center'>" . $indiv->nombre . "</td>");
                        echo("<td style='vertical-align: middle; text-align: center'>" . $color->valor . "</td>");


                        echo("<td style='vertical-align: middle; text-align: center'>" . $talla->valor . "</td>");

                        echo "<td style='vertical-align: middle; text-align: center'>" . $prod['cantidad'] . "</td>";

                        echo("<td style='vertical-align: middle; text-align: center'>" . $prod['motivo'] . "</td>");
                    }
                    ?>


                </table>
                <hr/><br/><br/>
                <h3 style="font-weight: normal; text-align: justify; ">
                    <?php echo $comments; ?>

                </h3>

                <!-- CONTENIDO OFF --></td>
        </tr>       
    </tbody>
</table>