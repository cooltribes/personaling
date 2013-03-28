<?php

$usuario = Yii::app()->user->id;

//$bolsa = Bolsa::model()->findByAttributes(array('user_id'=>$usuario));


$sql = "select count( * ) as total from tbl_bolsa_has_productotallacolor where look_id != 0 and bolsa_id = ".$bolsa->id."";
$num = Yii::app()->db->createCommand($sql)->queryScalar();

// bolsa tiene pro-talla-color
$bptcolor = BolsaHasProductotallacolor::model()->findAllByAttributes(array('bolsa_id'=>$bolsa->id));

?>
<div class="container margin_top" id="carrito_compras">
  <div class="row margin_bottom_large">
    <div class="span12"> <img src="http://placehold.it/1200x100"/ class="margin_bottom">
      <div class="row">
        <article class="span7">
          <h1>Tu bolsa</h1>
          <?php 
          
          if($num!=0) // si hay looks
		  {
		  	//imprima looks
		  	
		  	/*
			 *  <!-- Look ON -->
          <h3 class="braker_bottom margin_top">Nombre del Look 1</h3>
          <div class="padding_left">
            <table class="table" width="100%" >
              <thead>
                <tr>
                  <th colspan="2">Producto</th>
                  <th>Precio por 
                    unidad </th>
                  <th colspan="2">Cantidad</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><img src="http://placehold.it/70x70"/ class="margin_bottom"></td>
                  <td><strong>Vestido Stradivarius</strong> <br/>
                    <strong>Color</strong>: azul<br/>
                    <strong>Talla</strong>: M</td>
                  <td >Bs. 3500</td>
                  <td width="8%"><input type="text" maxlength="2" placeholder="Cant." value="10" class="span1"/>
                    <a href="#" class="btn btn-mini" >Actualizar</a></td>
                  <td>&times;</td>
                </tr>
                <tr class="muted">
                  <td><img src="http://placehold.it/70x70"/ class="margin_bottom"></td>
                  <td><strong>Camisa The New Pornographers</strong> <br/>
                    <strong>Color</strong>: azul<br/>
                    <strong>Talla</strong>: M</td>
                  <td>Bs. 3500</td>
                  <td><input type="text" maxlength="2" placeholder="Cant." value="0" class="span1"/>
                    <a href="#" class="btn btn-mini" >Actualizar</a></td>
                  <td >&times;</td>
                </tr>
                <tr>
                  <td><img src="http://placehold.it/70x70"/ class="margin_bottom"></td>
                  <td><strong>Pantalón Ok Go</strong> <br/>
                    <strong>Color</strong>: azul<br/>
                    <strong>Talla</strong>: M</td>
                  <td>Bs. 3500</td>
                  <td><input type="text" maxlength="2" placeholder="Cant." value="5" class="span1"/>
                    <a href="#" class="btn btn-mini" >Actualizar</a></td>
                  <td >&times;</td>
                </tr>
              </tbody>
            </table>
            <hr/>
            <p class="muted"><i class="icon-user"></i> Creado por: <a href="#" title="ir al perfil">Nombre del personal shopper</a></p>
          </div>
          <!-- Look OFF --> 
			 * 
			 * */
		  }

$sql = "select count( * ) as total from tbl_bolsa_has_productotallacolor where look_id = 0 and bolsa_id = ".$bolsa->id."";
$pr = Yii::app()->db->createCommand($sql)->queryScalar();

		if($pr!=0) // si hay productos individuales
		{
		?>
		  <!-- Look ON -->
          <h3 class="braker_bottom margin_top">Productos Individuales</h3>
          <div class="padding_left">
            <table class="table" width="100%" >
              <thead>
                <tr>
                  <th colspan="2">Producto</th>
                  <th>Precio por 
                    unidad </th>
                  <th colspan="2">Cantidad</th>
                </tr>
              </thead>
              <tbody>
                
                  <?php
                  
                  $precios = array();
				  $descuentos = array();
				  $cantidades = array();
                  
                  foreach($bptcolor as $detalles) // cada producto en la bolsa
				  {
				  	$todo = PrecioTallaColor::model()->findByPk($detalles->preciotallacolor_id);
					
				  		$producto = Producto::model()->findByPk($todo->producto_id);
				  		$talla = Talla::model()->findByPk($todo->talla_id);
				  		$color = Color::model()->findByPk($todo->color_id);
						
						$imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'orden'=>'1'));
				
				echo "<tr>";		
						
				if($imagen){					  	
					$aaa = CHtml::image(Yii::app()->baseUrl . str_replace(".","_thumb.",$imagen->url), "Imagen ", array("width" => "150", "height" => "150",'class'=>'margin_bottom'));
					echo "<td>".$aaa."</td>";
				}else
					echo"<td><img src='http://placehold.it/70x70'/ class='margin_bottom'></td>";
						
					echo "
					<td>
					<strong>".$producto->nombre."</strong> <br/>
					<strong>Color</strong>: ".$color->valor."<br/>
					<strong>Talla</strong>: ".$talla->valor."</td>
					";	
				 	
				 	$pre="";
				 	foreach ($producto->precios as $precio) {
			   		$pre = Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento);
					
					array_push($precios,$precio->precioDescuento);	
					array_push($descuentos,$precio->ahorro);		
					}
				 
				 	array_push($cantidades,$detalles->cantidad);
					
				 	echo "<td>Bs. ".$pre."</td>";
				 	echo"<td width='8%'><input type='text' id='cant".$detalles->preciotallacolor_id."' maxlength='2' placeholder='Cant.' value='".$detalles->cantidad."' class='span1'/>
                    <a id=".$detalles->preciotallacolor_id." onclick='actualizar(".$detalles->preciotallacolor_id.")' class='btn btn-mini'>Actualizar</a></td>
                  	<td style='cursor: pointer' onclick='eliminar(".$detalles->preciotallacolor_id.")' id='elim".$detalles->preciotallacolor_id."'>&times;</td>
                	</tr>";
				  }
				     
				
				  
                  ?>
                  <!--
                  <td><strong>Collar LAI</strong> <br/>
                    <strong>Color</strong>: azul<br/>
                    <strong>Talla</strong>: M</td>
                  <td>Bs. 3500</td>
                  <td width="8%"><input type="text" maxlength="2" placeholder="Cant." value="10" class="span1"/>
                    <a href="#" class="btn btn-mini" >Actualizar</a></td>
                  <td >&times;</td>
                </tr>
                <tr>
                  <td><img src="http://placehold.it/70x70"/ class="margin_bottom"></td>
                  <td><strong>Reloj La Rochelle</strong> <br/>
                    <strong>Color</strong>: azul<br/>
                    <strong>Talla</strong>: M</td>
                  <td>Bs. 3500</td>
                  <td><input type="text" maxlength="2" placeholder="Cant." value="4" class="span1"/>
                    <a href="#" class="btn btn-mini" >Actualizar</a></td>
                  <td >&times;</td>
                </tr> -->
              </tbody>
            </table>
          </div>
          <!-- Look OFF --> 
          
		  <?php
		  }
          ?>
          
        </article>
        <div class="span5 margin_bottom margin_top_large padding_top_xsmall">
          <div class="margin_left">
            <div class="well margin_top_large">
            	<?php 
            	
            	$sql = "select count( * ) as total from tbl_bolsa_has_productotallacolor where look_id != 0 and bolsa_id = ".$bolsa->id."";
				$look = Yii::app()->db->createCommand($sql)->queryScalar();	
            	
				$sql = "select count( * ) as total from tbl_bolsa_has_productotallacolor where look_id = 0 and bolsa_id = ".$bolsa->id."";
				$indiv = Yii::app()->db->createCommand($sql)->queryScalar();
				
            	?>
            	
              <h5><?php echo $look; ?> Look seleccionado<br/>
              	<?php 
              	
              	if($look!=0)
				{
					echo "6 productos que componen los Looks<br/>";
				}				
              	?><?php 
              	//variables de sesion
              	Yii::app()->getSession()->add('totalLook',$look);
              	Yii::app()->getSession()->add('totalIndiv',$indiv);
              	
              	?>
                <?php echo $indiv; ?> Productos individuales </h5>
              <hr/>
              <label class="checkbox">
                <input type="checkbox">
                Envolver y enviar como regalo (9Bs. Adicionales) </label>
              <hr/>
              <div class="row margin_bottom">
                <div class="span2"> 
                	<?php
                	
                	if($look!=0)
					{
						echo "Con la compra  del Look completo ahorras 184 Bs.";
					}
                	
                	?>
                	 </div>
                <div class="span2">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th class="text_align_left">Subtotal:</th>
                      <td>
                      	<?php
                      	$totalPr=0;
                      	$totalDe=0;
                      	$envio = 100;
						$i=0;
						
                      	foreach($precios as $x)
                      	{
                      		$totalPr = $totalPr + ($x * $cantidades[$i]);
							$i++;
                      	}
                      	
					/*	foreach($descuentos as $y)
                      	{
                      		$totalDe = $totalDe + $y;
                      	}*/
						
						$iva = (($totalPr - $totalDe)*0.12); 
						
						$t = $totalPr - $totalDe + (($totalPr - $totalDe)*0.12) + $envio; 
						
						// variables de sesion
						Yii::app()->getSession()->add('subtotal',$totalPr);
						Yii::app()->getSession()->add('descuento',$totalDe);
						Yii::app()->getSession()->add('envio',$envio);
						Yii::app()->getSession()->add('iva',$iva);
						Yii::app()->getSession()->add('total',$t); 
						
						echo $totalPr;
                      	?>                      	
                      	Bs.</td>
                    </tr>
                    <tr>
                      <th class="text_align_left">Descuento:</th>
                      <td><?php echo $totalDe; ?> Bs.</td>
                    </tr>
                    <tr>
                      <th class="text_align_left">Envío:</th>
                      <td><?php echo $envio; ?> Bs.</td>
                    </tr>
                    <tr>
                      <th class="text_align_left">I.V.A. (12%):</th>
                      <td><?php echo $iva; ?> Bs.</td>
                    </tr>
                    <tr>
                      <th class="text_align_left"><h4>Total:</h4></th>
                      <td><h4><?php echo $t; ?> Bs.</h4></td>
                    </tr>
                  </table>
                  
                  <?php $this->widget('bootstrap.widgets.TbButton', array(
				    'label'=>'Completar compra',
				    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
				    'size'=>'normal', // null, 'large', 'small' or 'mini'
				    'url'=>'compra', // action ir 
				    'icon'=>'shopping-cart white',
				)); 
				 
				//<a href="Proceso_de_Compra_1.php" class="btn btn-danger"><i class="icon-shopping-cart icon-white"></i> Completar compra</a>
				?>
                  
                   </div>
              </div>
              <p><i class="icon-calendar"></i> Fecha estimada de entrega: 00/00/2013 - 00/00/2013 </p>
            </div>
            <p><a href="#">Ver Politicas de Envios y Devoluciones</a></p>
            <p class="muted"><i class="icon-comment"></i> Contacta con un Asesor de Personaling para recibir ayuda: De Lunes a Viernes de 8:30 am a 5:00 pm</p>
            <hr/>
            <p class="muted"><a href="#" title="vaciar la bolsa de compras">Vaciar la Bolsa de Compras</a> | <a href="../tienda/index" title="seguir comprando">Seguir comprando</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr/>
</div>

<!-- /container -->

<script>
	
	
	function actualizar(id)
	{
		
	var cantidad = $("#cant"+id+".span1").attr("value");
	
	//alert(cantidad);
	
	// llamada ajax para el controlador de bolsa	   
     	$.ajax({
	        type: "post",
	        url: "actualizar", // action de actualizar
	        data: { 'prtc':id, 'cantidad':cantidad}, 
	        success: function (data) {
				
				if(data=="ok")
				{
					//alert("cantidad actualizada");
					window.location.reload()
				}
					
	       	}//success
	       })

	}
	
	function eliminar(id)
	{
		
	var td = $(this);
	
	//alert(cantidad);
	
	// llamada ajax para el controlador de bolsa	   
     	$.ajax({
	        type: "post",
	        url: "eliminar", // action de actualizar
	        data: { 'prtc':id }, 
	        success: function (data) {
				
				if(data=="ok")
				{
					window.location.reload()
				}
					
	       	}//success
	       })

	}
	
	
</script>
