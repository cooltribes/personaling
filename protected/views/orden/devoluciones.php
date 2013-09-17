<?php
/* @var $this OrdenController */

$this->breadcrumbs=array(
	'Pedidos'=>array('admin'),
	'Detalle'=>array('detalles','id'=>$orden->id),
	'Devoluciones',
);

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
	<h1> Devoluciones </h1>  
	<input type="hidden" id="orden_id" value="<?php echo $orden->id; ?>" />
	<hr/>
   <div> 
     <h3 class="braker_bottom margin_top">Productos</h3>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
        	<th scope="col"></th>
        	<th scope="col">Referencia</th>
			<th scope="col">Nombre</th>
			<th scope="col">Color</th>
			<th scope="col">Talla</th>
			<th scope="col">Motivo</th>          
        </tr>
		<?php
        	$row=0;
			$looksarray = Array(); 
        	$productos = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id)); // productos de la orden
        	
				foreach ($productos as $prod) {
				
					if($prod->look_id != 0) // si es look
					{
						if(!in_array($prod->look_id,$looksarray))
						{		
							array_push($looksarray,$prod->look_id);
					
							$ptc = Preciotallacolor::model()->findByAttributes(array('id'=>$prod->preciotallacolor_id)); // consigo existencia actual
							
							$lookpedido = Look::model()->findByPk($prod->look_id); // consigo nombre					
							$precio = $lookpedido->getPrecio(false);
							
								echo("<tr class='bg_color5' >"); // Aplicar fondo de tr, eliminar borde**
								echo("<td colspan='5'><strong>".$lookpedido->title."</strong></td>");// Referencia
								echo("<td> Bs. ".number_format($prod->precio, 2, ',', '.')."</td>"); // precio 
								
							echo("</tr>");	
								
							$prodslook= OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$prod->tbl_orden_id, 'look_id'=>$prod->look_id), array('order'=>'look_id ASC'));
							
							foreach($prodslook as $prodlook){
								$ptclk = Preciotallacolor::model()->findByAttributes(array('id'=>$prodlook->preciotallacolor_id));
								$prdlk = Producto::model()->findByPk($ptclk->producto_id);
								
								$marca=Marca::model()->findByPk($prdlk->marca_id);
								$talla=Talla::model()->findByPk($ptclk->talla_id);
								$color=Color::model()->findByPk($ptclk->color_id);
									
								echo("<tr>");
								echo("<td><input id='".$ptclk->sku."' type='checkbox' value=''></td>");
								echo("<td>".$ptclk->sku."</td>"); // nombre
								echo("<td>".$prdlk->nombre."</td>"); // nombre
								echo("<td>".$color->valor."</td>");
								echo("<td>".$talla->valor."</td>");
								echo('
									<td class="span3">
										<select id="motivo-'.$ptclk->sku.'" class="input-medium">
										  <option>-- Seleccione --</option>
										  <option>Cambio de talla</option>
										  <option>Cambio por otro articulo</option>
										  <option>Devolución por prenda dañada</option>
										  <option>Devolución por insatisfacción</option>
										  <option>Devolución por pedido equivocado</option>
										</select>        		
						        	</td>
								');
								echo("</tr>");
								}// foreach
						} // in array
					}
					else // individual
					{
						if($row==0){
								echo("<tr class='bg_color5'><td colspan='9'>Prendas Individuales</td></tr>");
								$row=1;
						}
							
						$ptc = Preciotallacolor::model()->findByAttributes(array('id'=>$prod->preciotallacolor_id)); // consigo existencia actual
						$indiv = Producto::model()->findByPk($ptc->producto_id); // consigo nombre
						
						$marca=Marca::model()->findByPk($indiv->marca_id);
						$talla=Talla::model()->findByPk($ptc->talla_id);
						$color=Color::model()->findByPk($ptc->color_id);
						
						echo("<tr>");
						echo("<td><input id='".$ptc->sku."' type='checkbox' value=''></td>");
						echo("<td>".$ptc->sku."</td>");// Referencia
						echo("<td>".$indiv->nombre."</td>"); // nombre
						echo("<td>".$color->valor."</td>");
						echo("<td>".$talla->valor."</td>");					
						echo('
								<td class="span3">
									<select class="input-medium">
									  <option>-- Seleccione --</option>
									  <option>Cambio de talla</option>
									  <option>Cambio por otro articulo</option>
									  <option>Devolución por prenda dañada</option>
									  <option>Devolución por insatisfacción</option>
									  <option>Devolución por pedido equivocado</option>
									</select>        		
					        	</td>
							');
						echo("</tr>");				
					}	
							
				
			}
      
      ?>

        <tr>
        	<th colspan="6"><div class="text_align_right"><strong>Resumen</strong></div></th>
        </tr>       
        <tr>
        	<td colspan="5"><div class="text_align_right"><strong>Monto a devolver:</strong></div></td>
        	<td  class="text_align_right">000,00 Bs</td>
        </tr>
        <tr>
        	<td colspan="5"><div class="text_align_right"><strong>Monto por envio a devolver:</strong></div></td>
        	<td  class="text_align_right">000,00 Bs</td>
        </tr>
    	</table>
    	<div class="pull-right"><a onclick="devolver()" title="Añadir productos" style="cursor: pointer;" class="btn btn-warning">Hacer devolucion</a>
    	</div>
	</div>

</div> 
<!-- /container --> 

<script>
	function devolver()
	{
		var motivos = new Array();
		
		var checkValues = $(':checkbox:checked').map(function() {
			motivos.push ( $('#motivo-'+this.id).attr('value') );
				
			return this.id;
		}).get().join();
		
		if(checkValues=="" || motivos.indexOf("-- Seleccione --") != -1)
			alert("Prenda no seleccionada o Motivo de devolución no seleccionado para la prenda.");			
		else
		{
			alert('check='+checkValues+" ,"+motivos[0]);
			
			var id = $('#orden_id').attr('value');
		
			$.ajax({
		        type: "post", 
		        url: "orden/devoluciones", // action 
		        data: { 'orden':id, 'check':checkValues, 'motivos':motivos}, 
		        success: function (data) {
					if(data=="ok")
						
		       	}//success
			})	
		
		}
	}
	
</script>