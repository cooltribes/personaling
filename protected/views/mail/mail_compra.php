<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<!--[if gte mso 9]>
<style _tmplitem="499" >
.article-content ol, .article-content ul {
   margin: 0 0 0 24px;
   padding: 0;
   list-style-position: inside;
}
</style>
<![endif]-->
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0" border="0" id="background-table">
    <tbody>
        <tr>
            <td align="center" bgcolor="#ececec"><table class="w640" style="margin:0 10px;" width="640" cellpadding="0" cellspacing="0" border="0">
                    <tbody>
                        <tr>
                            <td class="w640" width="640" height="20"></td>
                        </tr>
                        <tr>
                            <td class="w640" width="640"><table id="top-bar" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#a25f7f">
                                    <tbody>
                                        <tr>
                                            <td class="w15" width="15"></td>
                                            <td class="w325" width="350" valign="middle" align="left"><table class="w325" width="350" cellpadding="0" cellspacing="0" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w325" width="350" height="8"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div class="header-content"><span class="hide" style="color:#FFFFFF; padding-left:5px">
                                                    <preferences lang="es-ES" ><?php echo $subject; ?></preferences>
                                                    </span></div>
                                                <table class="w325" width="350" cellpadding="0" cellspacing="0" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w325" width="350" height="8"></td>
                                                        </tr>
                                                    </tbody>
                                                </table></td>
                                            <td class="w30" width="30"></td>
                                            <td class="w255" width="255" valign="middle" align="right"><table class="w255" width="255" cellpadding="0" cellspacing="0" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w255" width="255" height="8"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table cellpadding="0" cellspacing="0" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td valign="middle"><a title="Personaling en facebook" href="https://www.facebook.com/Personaling"><img width="30" height="30" title="personaling en pinterest" src="http://personaling.com/contenido_estatico/icon_personaling_facebook.png"></a></td>
                                                            <td width="3"><a title="Personaling en Pinterest" href="https://twitter.com/personaling"> <img width="30" height="30" title="personaling en pinterest" src="http://personaling.com/contenido_estatico/icon_personaling_twitter.png"></a></td>
                                                            <td valign="middle"><a title="pinterest" href="https://pinterest.com/personaling/"><img width="30" height="30" title="Personaling en Pinterest" src="http://personaling.com/contenido_estatico/icon_personaling_pinterest.png"></a></td>
                                                            <td class="w10" width="10"><a title="Personaling en Instagram" href="http://instagram.com/personaling"><img width="30" height="30" title="Personaling en Pinterest" src="http://personaling.com/contenido_estatico/icon_personaling_instagram.png"></a></td>
                                                            <td class="w10" width="10"><a title="Personaling en Youtube" href="http://www.youtube.com/channel/UCe8aijeIv0WvrZS-G-YI3rQ"><img width="30" height="30" title="Personaling en youtube" src="http://personaling.com/contenido_estatico/icon_personaling_youtube.png"></a></td>                                                            
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table class="w255" width="255" cellpadding="0" cellspacing="0" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w255" width="255" height="8"></td>
                                                        </tr>
                                                    </tbody>
                                                </table></td>
                                            <td class="w15" width="15"></td>
                                        </tr>
                                    </tbody>
                                </table></td>
                        </tr>
                        <tr>
                            <td id="header" class="w640" width="640" align="center" bgcolor="#FFFFFF"><div align="center" style="text-align: center"> <a href="http://personaling.com/"> <img id="customHeaderImage" label="Header Image" editable="true" width="600" src="http://personaling.com/contenido_estatico/header_personaling_email.png" class="w640" border="0" align="top" style="display: inline"> </a> </div></td>
                        </tr>
                        <tr>
                            <td class="w640" width="640" height="30" bgcolor="#ffffff"></td>
                        </tr>
                        <tr id="simple-content-row">
                            <td class="w640" width="640" bgcolor="#ffffff"><table class="w640" width="640" cellpadding="0" cellspacing="0" border="0">
                                    <tbody>
                                        <tr>
                                            <td class="w30" width="30" style="width:30px"></td>
                                            <td class="w580" width="580"><table class="w580" width="580" cellpadding="0" cellspacing="0" border="0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w580" width="580"><!-- CONTENIDO ON -->
                                                                
                                                                <?php
                                                                    $user = User::model()->findByPk(Yii::app()->user->id);
                                                                    $pago = Pago::model()->findByAttributes(array('id'=>$orden->pago_id));
                                                                    //echo $orden->pago_id;
                                                                ?>
                                                                <?php
      
                                                                if($orden->estado==1) // pendiente de pago
                                                        	    {
                                                        	  	  if($pago->tipo == 1){
                                                        	   ?>
                                                                <div class="alert alert-success margin_top_medium margin_bottom">
                                                                        <h1 class="h1">Tu Pedido ha sido recibido con éxito.</h1>
                                                                </div>
                                                                <div class="bg_color3 margin_bottom_small padding_small box_1">
                                                                    <h2 class="h2">Siguiente paso</h2>
                                                                    <p><strong>Para completar tu comprar debes:</strong></p>
                                                                    <ol>
                                                                        <li> <strong>Realizar el pago</strong>: de Bs. <?php echo Yii::app()->numberFormatter->formatCurrency($orden->total, ''); ?>
                                                                        			via transferencia electrónica o depósito bancario antes del <?php  echo date('d/m/Y - h:i a', strtotime($orden->fecha. ' + 3 days')); ?>
                                                                        			en la siguientes cuenta bancaria: <br>
                                                                            <br/>
                                                                            <ul>
                                                                                <li><strong>Banesco</strong><br/>
                                                                                    <strong>Cuenta Corriente Nº</strong> 0134 0277 98 2771093092<br/>
                                                                                    <strong>A nombre de</strong>: PERSONALING C.A<br/>
                                                                                    <strong>RIF</strong>: J-40236088-6<br/>
                                                                                    <strong>Correo electrónico:</strong> ventas@personaling.com<br/>
                                                                                    <br>
                                                                                </li>
                                                                            </ul>
                                                                        </li>
                                                                        <li><strong>Registra tu pago</strong>: <?php echo CHtml::link('Aquí', $this->createAbsoluteUrl('orden/detallepedido',array('id'=>$orden->id))); ?> ó ingresa a Tu Cuenta - > Tus Pedidos,  selecciona el pedido que deseas Pagar y la opción Registrar Pago.</li>
                                                                        <li><strong>Proceso de validación: </strong>usualmente toma de 1 y 5 días hábiles y consiste en validar tu transferencia o depósito con nuestro banco. Puedes consultar el status de tu compra en tu perfil.</li>
                                                                        <li><strong>Envio:</strong> Luego de validar el pago te enviaremos el producto :)</li>
                                                                    </ol>
                                                                    <hr/>
                                                                </div>
                                                                <?php
      	}else if($pago->tipo == 4){
      		?>
                                                                <div class="alert alert-success margin_top_medium margin_bottom">
                                                                    <h1>Tu Pedido ha sido recibido con éxito.</h1>
                                                                                                                  </div>
                                                                <div>
                                                                    <h2>Siguiente paso</h2>
                                                                    <p><strong>Para completar tu comprar debes:</strong></p>
                                                                    <ol>
                                                                        <li> <strong>Realizar el pago</strong>: de Bs. <?php echo $orden->total; ?> via MercadoPago. <br>
                                                                        </li>
                                                                        <li><strong>Registra tu pago</strong>: a través del sistema MercadoPago.</li>
                                                                        <li><strong>Proceso de validación: </strong>usualmente toma de 1 y 5 días hábiles y consiste en validar tu pago.</li>
                                                                        <li><strong>Envio:</strong> Luego de validar el pago te enviaremos el producto :)</li>
                                                                    </ol>
                                                                    <hr/>
                                                                </div>
                                                                <?php
      	}
      }// caso 1
      ?>
                                                                <h3 style="color:#999999;">RESUMEN DEL PEDIDO</h3>
                                                                <table width="100%" border="0" cellspacing="3" style="margin-bottom:10px;" cellpadding="5">
    <tr>
        <td style=" background-color:#dff0d8; padding:6px;  color:#468847; margin-bottom:5px"><p class="well well-small"><strong>Número de confirmación:</strong> <?php echo $orden->id; ?></p></td>
        <td style=" background-color:#dff0d8; color:#468847;"><p> <strong>Fecha estimada de entrega</strong>: 01/01/2013</p></td>
    </tr>
</table>
                                                                                                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td  style="text-align:left"><b>Subtotal:</b></th>
                                                                        <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($orden->subtotal, ''); ?></td>
                                                                    </tr>
                                                                    <?php if($orden->descuento != 0){ // si no hay descuento ?> 
                                                                    <tr>
                                                                        <td style="text-align:left"><b>Descuento:</b></th>
                                                                        <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($orden->descuento, ''); ?></td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                    <tr>
                                                                        <td style="text-align:left"><b>Envío:</b></th>
                                                                        <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($orden->envio, ''); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="text-align:left"><b>I.V.A. (12%):</b></th>
                                                                        <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($orden->iva, ''); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="text-align:left"><b>Seguro:</b></th>
                                                                        <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($orden->seguro, ''); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="text-align:left"><h4 class="color1">TOTAL:</h4></th>
                                                                        <td><h4 class="color1"><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($orden->total, ''); ?></h4></td>
                                                                    </tr>
                                                                </table>
                                                                <hr/>
                                                                <?php
        
        $s1 = "select count( * ) as total from tbl_orden_has_productotallacolor where look_id != 0 and tbl_orden_id = ".$orden->id."";
		$look = Yii::app()->db->createCommand($s1)->queryScalar();
        
		$s2 = "select count( * ) as total from tbl_orden_has_productotallacolor where look_id = 0 and tbl_orden_id = ".$orden->id."";
		$ind = Yii::app()->db->createCommand($s2)->queryScalar();
			
        ?>
                                                             <h3 style="color:#999999;">DETALLES DEL PEDIDO</h3>
                                                                
                                                                <!-- Look ON -->
                                                                
                                                                <?php
        
        if($look!=0) // hay looks
		{
			$todos = array();
			$vacio = array();
			$ordenproducto =  OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id));
			
			foreach ($ordenproducto as $cadauno) {
				if($cadauno->look_id!=0){
					$look = Look::model()->findByPk($cadauno->look_id);
					array_push($todos,$look->id);
				}
			}
			
			foreach($todos as $cadalook)
			{
				$look = Look::model()->findByPk($cadalook);

			
			if(!in_array($cadalook,$vacio)){
						
			echo('
			<p> <strong>Nombre del look:</strong> '.$look->title.' | Creado por: <a href="#" title="ir al perfil">'.$look->user->profile->first_name.'</a></p>
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
					   			$pre = Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento);
							}
							
							echo('<tr>');
							
							if($imagen){					  	
								$aaa = CHtml::image(Yii::app()->getBaseUrl(true) . str_replace(".","_thumb.",$imagen->url), "Imagen ", array("width" => "150", "height" => "150",'class'=>'margin_bottom'));
								echo "<td style='border-bottom:1px solid #dddddd;'>".$aaa."</td>";
							}else{
								echo"<td><img src='http://placehold.it/70x70'/ class='margin_bottom'></td>";
							}
	
							echo('<td style="border-bottom:1px solid #dddddd;"><strong>'.$producto->nombre.'</strong> <br/>
		                  		<strong>Color</strong>: '.$color->valor.'<br/>
		                  		<strong>Talla</strong>: '.$talla->valor.'<br/>
		                  		</td>
		                <td style="border-bottom:1px solid #dddddd;">Bs. '.Yii::app()->numberFormatter->formatCurrency($pre, '').'</td>
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
							
				$imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'orden'=>'1'));
								
				echo "<tr>";		
							
				if($imagen){					  	
					$aaa = CHtml::image(Yii::app()->getBaseUrl(true) . str_replace(".","_thumb.",$imagen->url), "Imagen ", array("width" => "70", "height" => "70",'class'=>'margin_bottom'));
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
					$pre = Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento);
				}
						
				echo "<td style='border-bottom:1px solid #dddddd;'>Bs. ".Yii::app()->numberFormatter->formatCurrency($pre, '')."</td>";
				echo "<td style='border-bottom:1px solid #dddddd;'>".$individual->cantidad."</td>";
				echo "</tr>";

			}
				
			}// foreach de productos	
            echo '</tbody>
                  </table>
                  
                  
                  </div>';  
		}// si hay indiv
		
        ?>
                                                                
                                                                <!-- CONTENIDO OFF --></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="w580" width="580" height="10"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                </layout></td>
                                            <td class="w30" width="30"></td>
                                        </tr>
                                    </tbody>
                                </table></td>
                        </tr>
                        <tr>
                            <td class="w640" width="640" height="15" bgcolor="#ffffff"></td>
                        </tr>
                        <tr >
                            <td class="w640" width="640"><table id="footer" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#6E1346">
                                    <tbody >
                                        <tr>
                                            <td class="w30" width="30"></td>
                                            <td class="w580 h0" width="360" height="30"></td>
                                            <td class="w0" width="60"></td>
                                            <td class="w0" width="160"></td>
                                            <td class="w30" width="30"></td>
                                        </tr>
                                        <tr>
                                            <td class="w30" width="30"></td>
                                            <td class="w580" width="360" valign="top">
                                            <span class="hide">
                                                <p id="permission-reminder" align="left" class="footer-content-left" style="color:#FFFFFF"><span>Recibes este correo porque compraste en Personaling.com </span></p>
                                                </span>
                                                </td>
                                            <td class="hide w0" width="60"></td>
                                            <td class="hide w0" width="160" valign="top"><p id="street-address" align="right" class="footer-content-right" style="color:#FFFFFF"><span><a href="http://personaling.com/" title="personaling" style="color:#FFFFFF">Personaling.com</a></span></p></td>
                                            <td class="w30" width="30"></td>
                                        </tr>
                                        <tr>
                                            <td class="w30" width="30"></td>
                                            <td class="w580 h0" width="360" height="15"></td>
                                            <td class="w0" width="60"></td>
                                            <td class="w0" width="160"></td>
                                            <td class="w30" width="30"></td>
                                        </tr>
                                    </tbody>
                                </table></td>
                        </tr>
                        <tr>
                            <td class="w640" width="640" height="60"></td>
                        </tr>
                    </tbody>
                </table></td>
        </tr>
    </tbody>
</table>
</body>
</html>
