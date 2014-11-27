<h3 style="color:#999999;">RESUMEN DEL PEDIDO</h3> 
<table width="100%" border="0" cellspacing="3" style="margin-bottom:10px;" cellpadding="5">
    <tr>
        <td style=" background-color:#dff0d8; padding:6px;  color:#468847; margin-bottom:5px">
            <p class="well well-small"><strong>Número de confirmación:</strong> <?php echo $orden->id; ?></p>
        </td>
        <td style=" background-color:#dff0d8; color:#468847;">
            <p> <strong>Fecha estimada de entrega</strong>: 
                <?php echo  date('d/m/Y', strtotime($orden->fecha.'+1 week')); ?></p>
        </td>
    </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td  style="text-align:left"><b>Subtotal:</b></th>
        <td><?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency($orden->subtotal, ''); ?></td>
    </tr>
    <?php if($orden->descuento != 0){ // si no hay descuento ?> 
    <tr>
        <td style="text-align:left"><b>Descuento:</b></th>
        <td><?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency($orden->descuento, ''); ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td style="text-align:left"><b>Envío:</b></th>
        <td><?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency($orden->envio+$orden->seguro, ''); ?></td>
    </tr>
    <tr>
        <td style="text-align:left"><b>I.V.A. (<?php echo Yii::t('contentForm','IVAtext'); ?>):</b></th>
        <td><?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency($orden->iva, ''); ?></td>
    </tr>

    <tr>
        <td style="text-align:left"><h4 class="color1">TOTAL:</h4></th>
        <td><h4 class="color1"><?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency($orden->total, ''); ?></h4></td>
    </tr>
</table>

<hr/>
<?php
    $s1 = "select count( * ) as total from tbl_orden_has_productotallacolor 
        where look_id != 0 and tbl_orden_id = " . $orden->id . "";
    $look = Yii::app()->db->createCommand($s1)->queryScalar();

    $s2 = "select count( * ) as total from tbl_orden_has_productotallacolor 
        where look_id = 0 and tbl_orden_id = " . $orden->id . "";
    $ind = Yii::app()->db->createCommand($s2)->queryScalar();
?>

<h3 style="color:#999999;">DETALLES DEL PEDIDO</h3>
<!-- Look ON -->
<?php   
    if($look!=0) // hay looks
    {
        $todos = array();
        $vacio = array();
        $ordenproducto = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id' => $orden->id));

        foreach ($ordenproducto as $cadauno) {
            if ($cadauno->look_id != 0) {
                $look = Look::model()->findByPk($cadauno->look_id);
                array_push($todos, $look->id);
            }
        }
			
        foreach($todos as $cadalook)
        {
                $look = Look::model()->findByPk($cadalook);


        if(!in_array($cadalook,$vacio)){

        echo('<p> <strong>Nombre del look:</strong> '.$look->title.' | Creado por: <a href="#" title="Ir al perfil">'.$look->user->profile->first_name.'</a></p>
            <div>
              <table class="table" width="100%" >
                <thead>
                  <tr>
                    <th  style="text-align:left; color:#999999; border-bottom:1px solid #dddddd;" colspan="2">Producto</th>
                    <th style="text-align:left; color:#999999; border-bottom:1px solid #dddddd;">Precio por unidad </th>
                    <th style="text-align:left; color:#999999; border-bottom:1px solid #dddddd;" >Cantidad</th>
                  </tr>
                </thead>
                <tbody>');	

            foreach ($ordenproducto as $cadauno) {
                if($cadauno->look_id!=0){
                    if($cadauno->look_id == $cadalook)
                    {
                        array_push($vacio,$cadalook);

                        $tod = Preciotallacolor::model()->findByPk($cadauno->preciotallacolor_id);
                        $talla = Talla::model()->findByPk($tod->talla_id);
                        $color = Color::model()->findByPk($tod->color_id);

                        $producto = Producto::model()->findByPk($tod->producto_id);
                        $imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'orden'=>'1'));

                        $pre="";
                        foreach ($producto->precios as $precio) {
                                //$pre = Yii::app()->numberFormatter->formatDecimal($precio->precioImpuesto);
                                $pre = Yii::app()->numberFormatter->format("#,##0.00",$precio->precioImpuesto);
                        }

                        echo('<tr>');

                        if($imagen)
                        {
	                        if(Yii::app()->language=="es_es")
							{
								$aaa = CHtml::image('http://personaling.es/'.$producto->getImageUrl($color->id), "Imagen ", array("width" => "70", "height" => "70",'class'=>'margin_bottom'));
							}
							else 
							{
								$aaa = CHtml::image('http://personaling.com.ve/'.$producto->getImageUrl($color->id), "Imagen ", array("width" => "70", "height" => "70",'class'=>'margin_bottom'));
							}						  	
	                        
	                        if($producto->getImageUrl($color->id)=='http://placehold.it/180')
							{
								 if(Yii::app()->language=="es_es")	
								 {
								 		$aaa = CHtml::image("http://www.personaling.es".Yii::app()->getBaseUrl(true) . str_replace(".","_thumb.",$imagen->url), "Imagen ", array("width" => "70", "height" => "70",'class'=>'margin_bottom'));
								 }
								 else
								 {
								 	$aaa = CHtml::image("http://www.personaling.com.ve".Yii::app()->getBaseUrl(true) . str_replace(".","_thumb.",$imagen->url), "Imagen ", array("width" => "70", "height" => "70",'class'=>'margin_bottom'));
								 }
							}
	                               
	                        echo "<td style='border-bottom:1px solid #ddzdddd;'>".$aaa."</td>";
                        }else{
                                echo"<td><img src='http://placehold.it/70x70'/ class='margin_bottom'></td>";
                        }

                        echo('<td style="border-bottom:1px solid #dddddd;"><strong>'.$producto->nombre.'</strong> <br/>
                            <strong>Color</strong>: '.$color->valor.'<br/>
                            <strong>Talla</strong>: '.$talla->valor.'<br/>
                            </td>
                            <td style="border-bottom:1px solid #dddddd;">'.Yii::t('contentForm','currSym').' '.$pre.'</td>
                            <td style="border-bottom:1px solid #dddddd;">'.$cadauno->cantidad.'</td>
                          </tr>');		
                    }
                }
            }

            echo '</tbody>
              </table>
              </div>';


        }

    }



    }
        
    if($ind!=0) // si hay individuales
    {
        echo "<h4>Productos Individuales</h4>
                        <div class='padding_left'>
                          <table class='table' width='100%' >
                            <thead>
                              <tr>
                                <th colspan='2' style='text-align:left; color:#999999; border-bottom:1px solid #dddddd;'>Producto</th>
                                <th style='text-align:left;  color:#999999; border-bottom:1px solid #dddddd;'>Precio por 
                                  unidad </th>
                                <th style='text-align:left; color:#999999'; border-bottom:1px solid #dddddd;>Cantidad</th>
                              </tr>
                            </thead>
                            <tbody>
                            ";

        $ordenprod =  OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id));

        foreach ($ordenprod as $individual) {

                if($individual->look_id==0){

                $todo = Preciotallacolor::model()->findByPk($individual->preciotallacolor_id);

                $producto = Producto::model()->findByPk($todo->producto_id);
                $talla = Talla::model()->findByPk($todo->talla_id);
                $color = Color::model()->findByPk($todo->color_id);

                $imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id),array('order'=>'orden'));

                echo "<tr>";		

                if($imagen)
                {
                        	 if(Yii::app()->language=="es_es")
							{
								$aaa = CHtml::image('http://personaling.es/'.$producto->getImageUrl($color->id), "Imagen ", array("width" => "70", "height" => "70",'class'=>'margin_bottom'));
							}
							else 
							{
								$aaa = CHtml::image('http://personaling.com.ve/'.$producto->getImageUrl($color->id), "Imagen ", array("width" => "70", "height" => "70",'class'=>'margin_bottom'));
							}						  	
	                        
	                        if($producto->getImageUrl($color->id)=='http://placehold.it/180')
							{
								 if(Yii::app()->language=="es_es")	
								 {
								 		$aaa = CHtml::image("http://www.personaling.es".Yii::app()->getBaseUrl(true) . str_replace(".","_thumb.",$imagen->url), "Imagen ", array("width" => "70", "height" => "70",'class'=>'margin_bottom'));
								 }
								 else
								 {
								 	$aaa = CHtml::image("http://www.personaling.com.ve".Yii::app()->getBaseUrl(true) . str_replace(".","_thumb.",$imagen->url), "Imagen ", array("width" => "70", "height" => "70",'class'=>'margin_bottom'));
								 }
							}

                        echo "<td style='border-bottom:1px solid #dddddd;'>".$aaa."</td>";
                }else
                        echo"<td style='border-bottom:1px solid #dddddd;'><img src='http://placehold.it/70x70'/ class='margin_bottom'></td>";

                echo "
                        <td style='border-bottom:1px solid #dddddd;'>
                        <strong>".$producto->nombre."</strong> <br/>
                        <strong>Color</strong>: ".$color->valor."<br/>
                        <strong>Talla</strong>: ".$talla->valor."<br/>
                        </td>
                        ";	

                // precio
                foreach ($producto->precios as $precio) {
                        //$pre = Yii::app()->numberFormatter->formatDecimal($precio->precioImpuesto);
                        $pre = Yii::app()->numberFormatter->format("#,##0.00",$precio->precioImpuesto);
                }

                echo "<td style='border-bottom:1px solid #dddddd;'>".Yii::t('contentForm','currSym')." ".$pre."</td>";
                echo "<td style='border-bottom:1px solid #dddddd;'>".$individual->cantidad."</td>";
                echo "</tr>";

            }

            }// foreach de productos	
            
        echo '</tbody>
              </table>
              </div>';  
    }// si hay indiv
?>
		