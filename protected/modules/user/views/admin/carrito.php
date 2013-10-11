<?php

if (!Yii::app()->user->isGuest) { // que este logueado

//$usuario = Yii::app()->user->id;

//$bolsa = Bolsa::model()->findByAttributes(array('user_id'=>$usuario));
$num = 0;
if($bolsa){
	$sql = "select count( * ) as total from tbl_bolsa_has_productotallacolor where look_id != 0 and bolsa_id = ".$bolsa->id."";
	$num = Yii::app()->db->createCommand($sql)->queryScalar();
	
	// bolsa tiene pro-talla-color
	$bptcolor = BolsaHasProductotallacolor::model()->findAllByAttributes(array('bolsa_id'=>$bolsa->id,'look_id'=> 0));
	                  $precios = array();
					  $descuentos = array();
					  $cantidades = array();
					  $total_look = 0;
					  $total_productos_look = 0;
				  
}
?>
<?php 
  $this->breadcrumbs=array(
  'Usuarios'=>array('admin'),
  'Editar',);
?>

<div class="container margin_top" id="carrito_compras">
<div class="page-header">
  <h1>Editar Carrito</h1>
</div>
<!-- SUBMENU ON -->
<?php $this->renderPartial('_menu', array('model'=>$model, 'activo'=>7)); ?>
<!-- SUBMENU OFF -->
<div class="row margin_top">
	<?php
	if($bolsa){
	?>
  <div class="span9">
    <div class="bg_color3   margin_bottom_small padding_small box_1">
      <form method="post" action="/aiesec/user/registration?template=1" id="registration-form"   class="form-stacked form-horizontal" enctype="multipart/form-data">
        <fieldset>
          <legend>Carrito</legend>
          <?php 
          
          if($num!=0) // si hay looks 
		  {
		  	//imprima looks
		  	foreach ($bolsa->looks() as $look_id){
		  		$bolsahasproductotallacolor = BolsaHasProductotallacolor::model()->findAllByAttributes(array('bolsa_id'=>$bolsa->id,'look_id' => $look_id));
				$look = Look::model()->findByPk($look_id);
				$total_look++;
				
				 
		  	?>
          <!-- Look ON -->
          <h3 class="braker_bottom margin_top_small"><?php echo $look->title; ?></h3>
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
              	<?php foreach($bolsahasproductotallacolor as $productotallacolor){ ?>
                <?php 
                	$total_productos_look++;
                	$color = Color::model()->findByPk($productotallacolor->preciotallacolor->color_id)->valor;
					$talla = Talla::model()->findByPk($productotallacolor->preciotallacolor->talla_id)->valor;
					$producto = Producto::model()->findByPk($productotallacolor->preciotallacolor->producto_id);
					$imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'orden'=>'1'));
                	//$test = PrecioTallaColor::model()->findByPK($productotallacolor->preciotallacolor->id);
					//if(isset($test)){
					//	echo $test->color_id;
						
					//	echo Color::model()->findByPk($test->color_id)->valor;
					//}
					$pre="";
					 	foreach ($producto->precios as $precio) {
				   		$pre = Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento);
						
						array_push($precios,$precio->precioDescuento);	
						array_push($descuentos,$precio->ahorro);		
						}
					 
					 	array_push($cantidades,$productotallacolor->cantidad);
                	?>
                <tr>
                  <?php
                  if($imagen){					  	
						$aaa = CHtml::image(Yii::app()->baseUrl . str_replace(".","_thumb.",$imagen->url), "Imagen ", array("width" => "150", "height" => "150",'class'=>'margin_bottom'));
						echo "<td>".$aaa."</td>";
					}else{
						echo"<td><img src='http://placehold.it/70x70'/ class='margin_bottom'></td>";
					}
					?>
                  <td><strong><?php echo $producto->nombre; ?></strong> <br/>
                    <strong>Color</strong>: <?php echo $color; ?><br/>
                    <strong>Talla</strong>: <?php echo $talla; ?></td>
                  <td >Bs. <?php echo $pre; ?></td>
                  <?php
                  echo"<td width='8%'><input type='text' id='cant".$productotallacolor->preciotallacolor_id."' maxlength='2' placeholder='Cant.' value='".$productotallacolor->cantidad."' class='span1'/>
	                    <a id=".$productotallacolor->preciotallacolor_id." onclick='actualizar(".$productotallacolor->preciotallacolor_id.")' class='btn btn-mini'>Actualizar</a></td>
	                  	<td style='cursor: pointer' onclick='eliminar(".$productotallacolor->preciotallacolor_id.")' id='elim".$productotallacolor->preciotallacolor_id."'>&times;</td>";
	              ?>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <hr/>
            <p class="muted"><i class="icon-user"></i> Creado por: <a href="#" title="ir al perfil"><?php echo $look->user->profile->first_name; ?></a></p>
          </div>
          <!-- Look OFF --> 
          <?php	 
			}
		  }

$sql = "select count( * ) as total from tbl_bolsa_has_productotallacolor where look_id = 0 and bolsa_id = ".$bolsa->id."";
$pr = Yii::app()->db->createCommand($sql)->queryScalar();

		if($pr!=0) // si hay productos individuales
		{
		?>
          <!-- Look ON -->
          <h3 class="braker_bottom margin_top">Productos Adicionales</h3>
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

				  if(isset($bptcolor)) // si hay productos en la bolsa del usuario
				  {
				  
	                  foreach($bptcolor as $detalles) // cada producto en la bolsa
					  {
					  	$todo = Preciotallacolor::model()->findByPk($detalles->preciotallacolor_id);
						
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
				  	}// foreach
				}//if isset    

				  
                  ?>
              </tbody>
            </table>
          </div>
          <!-- Look OFF -->
          <?php
          
			}// if de productos individuales
			else
			{ 
			 
			 echo "<h4 class='braker_bottom margin_top'>No hay ningun producto individual en la bolsa.</h4>";
				
			}
		?>
          
        </fieldset>
      </form>
    </div>
  </div>
  <?php
        //if($pr!=0 || $num!=0) // si hay productos individuales o bien si hay looks (aqui se puede poner la comparacion de si hay looks)
		//{
		?>
  <div class="span3">
    <div class="well">
    	<?php 
            	

            	//$sql = "select count( * ) as total from tbl_bolsa_has_productotallacolor where look_id != 0 and bolsa_id = ".$bolsa->id."";
				//$look = Yii::app()->db->createCommand($sql)->queryScalar();	

            	
				$sql = "select count( * ) as total from tbl_bolsa_has_productotallacolor where look_id = 0 and bolsa_id = ".$bolsa->id."";
				$indiv = Yii::app()->db->createCommand($sql)->queryScalar();
				
            	?>
      <h5>Looks seleccionados: <?php echo $total_look; ?><br>
      	<?php 
              	
              	if($total_look!=0)

				{ 
					echo "Productos que componen los Looks: ". $total_productos_look ."<br/>";
				}				
              	?>
                  <?php 
              	//variables de sesion
              	Yii::app()->getSession()->add('totalLook',$total_look); 
              	Yii::app()->getSession()->add('totalProductosLook',$total_productos_look);
              	Yii::app()->getSession()->add('totalIndiv',$indiv);
              	
              	?>
        Productos individuales: <?php echo $indiv; ?> </h5>
      <hr>
      <div class="margin_bottom">
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <tbody>
            <tr>
              <th class="text_align_left">Subtotal: </th>
              <td>
              	<?php
                      	$totalPr=0;
                      	$totalDe=0;
						$envio = 0;
						if($pr!=0 || $num!=0){
                      		$envio = 100;
						}
						$i=0;
						
						if (empty($precios)) // si no esta vacio
						{}
						else{
							
							foreach($precios as $x){
	                      		$totalPr = $totalPr + ($x * $cantidades[$i]);
								$i++;
	                      	}
						}
					/*	foreach($descuentos as $y)
                      	{
                      		$totalDe = $totalDe + $y;
                      	}*/
						
						$iva = (($totalPr - $totalDe)*0.12); 
						
						$t = $totalPr - $totalDe + (($totalPr - $totalDe)*0.12) + $envio; 
						
						$seguro = $t*0.013;
						
						$t += $seguro;
			 			
						// variables de sesion
						Yii::app()->getSession()->add('subtotal',$totalPr);
						Yii::app()->getSession()->add('descuento',$totalDe);
						Yii::app()->getSession()->add('envio',$envio);
						Yii::app()->getSession()->add('iva',$iva);
						Yii::app()->getSession()->add('total',$t);
						Yii::app()->getSession()->add('seguro',$seguro);
						
						echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($totalPr, '');
                      	?>
              </td>
            </tr>
            <tr>
              <th class="text_align_left">Descuento:</th>
              <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($totalDe, ''); ?></td>
            </tr>
            <tr>
              <th class="text_align_left">Envío:</th>
              <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($envio, ''); ?></td>
            </tr>
            <tr>
              <th class="text_align_left">I.V.A. (12%):</th>
              <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($iva, ''); ?></td>
            </tr>
            <tr>
              <th class="text_align_left">Seguro:</th>
              <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($seguro, ''); ?></td>
            </tr>
            <tr>
              <th class="text_align_left"><h4>Total:</h4></th>
              <td><h4><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($t, ''); ?></h4></td>
            </tr>
          </tbody>
        </table><hr/>
        <p><i class="icon-calendar"></i> Fecha estimada de entrega: <?php echo date("d/m/Y"); ?> - <?php echo date('d/m/Y', strtotime('+1 week'));  ?> </p>
      </div>
    </div>
  </div>
  <?php }else{ //fin if bolsa ?>
  	<div class="span12">
    <div class="bg_color3   margin_bottom_small padding_small box_1">
    	El usuario no tiene productos en el carrito de compra.
    </div></div>
  	<?php } ?>
</div>
</div>
<!-- /container -->
<?php
}else
	{
		// redirecciona al login porque se murió la sesión
	header('Location: /site/user/login');	
	}
?>

<script>
	
	
	function actualizar(id)
	{
		
	var cantidad = $("#cant"+id+".span1").attr("value");
	
	if(cantidad<0)
	{
		alert("Ingrese una cantidad mayor a 1.");
	}else
	{
	// llamada ajax para el controlador de bolsa	   
     	$.ajax({
	        type: "post",
	        url: "../../../../bolsa/actualizar", // action de actualizar
	        data: { 'prtc':id, 'cantidad':cantidad}, 
	        success: function (data) {
				
				if(data=="ok")
				{
					//alert("cantidad actualizada"); 
					window.location.reload()
				}
				
				if(data=="NO")
				{
					alert("Lo sentimos, no es posible actualizar la cantidad. La Cantidad es mayor a la existencia en inventario."); 
					
				}
				
					
	       	}//success
	       })
	}
	
	}
	
	function eliminar(id)
	{
		
	var td = $(this);
	
	//alert(cantidad);
	
	// llamada ajax para el controlador de bolsa	   
     	$.ajax({
	        type: "post",
	        url: "../../../../bolsa/eliminar", // action de actualizar
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