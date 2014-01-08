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
	<div class="margin_left_small margin_top">
		<p class="T_xlarge"><?php echo number_format($orden->total, 2, ',', '.');  ?></p>
		<span>Precio total del pedido</span>
	</div>

   <div> 
     <h3 class="braker_bottom">Productos</h3>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
        <tr>
        	<th scope="col"></th>
        	<th scope="col">Referencia</th>
			<th scope="col">Nombre</th>
			<th scope="col">Color</th>
			<th scope="col">Talla</th>
			<th scope="col">Precio</th>
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
                                        echo("<td colspan='2'> Bs. ".number_format($prod->precio, 2, ',', '.')."</td>"); // precio 

                                echo("</tr>");	

                                $prodslook= OrdenHasProductotallacolor::model()->findAllByAttributes(array(
                                        'tbl_orden_id'=>$prod->tbl_orden_id, 'look_id'=>$prod->look_id
                                        ), array('order'=>'look_id ASC')
                                        );

                                foreach($prodslook as $prodlook){
                                    $ptclk = Preciotallacolor::model()->findByAttributes(array('id'=>$prodlook->preciotallacolor_id));
                                    $prdlk = Producto::model()->findByPk($ptclk->producto_id);
                                    $precio= Precio::model()->findByAttributes(array('tbl_producto_id'=>$prdlk->id));

                                    //precio de venta


                                    $marca=Marca::model()->findByPk($prdlk->marca_id);
                                    $talla=Talla::model()->findByPk($ptclk->talla_id);
                                    $color=Color::model()->findByPk($ptclk->color_id);
                                    $ptclk->sku=str_replace('.', '-', $ptclk->sku);
                                    if($prodlook->devolucion_id != 0)	
                                    {
                                        echo("<tr class='error>'");
                                        echo("<input id='precio-".$ptclk->sku."' type='hidden' value='".$prodlook->precio."' />");
                                        echo("<input id='envio-".$ptclk->sku."' type='hidden' value='".$prodlook->precio."' />");
                                        echo("<td><input class='check' id='".$ptclk->sku."' type='checkbox' value=''></td>");
                                        echo("<td>".$ptclk->sku."</td>"); // nombre
                                        echo("<td>".$prdlk->nombre."</td>"); // nombre
                                        echo("<td>".$color->valor."</td>");
                                        echo("<td>".$talla->valor."</td>");
                                        echo("<td> Bs. ".number_format($prodlook->precio, 2, ',', '.')."</td>");
                                        echo('<td>Ya se devolvió</td>');
                                        echo("</tr>");
                                    }
                                    else
                                    {
                                        echo("<tr>");
                                        echo("<input id='precio-".$ptclk->sku."' type='hidden' value='".$prodlook->precio."' />");
                                        echo("<td><input class='check' id='".$ptclk->sku."' type='checkbox' value=''></td>");
                                        echo("<td>".$ptclk->sku."</td>"); // nombre
                                        echo("<td>".$prdlk->nombre."</td>"); // nombre
                                        echo("<td>".$color->valor."</td>");
                                        echo("<td>".$talla->valor."</td>");
                                        echo("<td> Bs. ".number_format($prodlook->precio, 2, ',', '.')."</td>");

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
                                    } 

                                }// foreach
                            } // in array
                    }
                    else // individual
                    {
                        if($row==0){
                            echo("<tr class='bg_color5'><td colspan='7'>Prendas Individuales</td></tr>");
                            $row=1;
                        }

                        $ptc = Preciotallacolor::model()->findByAttributes(array('id'=>$prod->preciotallacolor_id)); // consigo existencia actual
                        $indiv = Producto::model()->findByPk($ptc->producto_id); // consigo nombre
                        $precio= Precio::model()->findByAttributes(array('tbl_producto_id'=>$indiv->id));

                        $marca=Marca::model()->findByPk($indiv->marca_id);
                        $talla=Talla::model()->findByPk($ptc->talla_id);
                        $color=Color::model()->findByPk($ptc->color_id);

                        $op = OrdenHasProductotallacolor::model()->findByAttributes(array('preciotallacolor_id'=>$ptc->id));
                        $ptc->sku=str_replace('.', '-', $ptc->sku);
                        if($op->devolucion_id != 0)	
                        {
                                echo("<tr class='error>'");
                                echo("<input id='precio-".$ptc->sku."' type='hidden' value='".$prodlook->precio."' />");
                                echo("<td><input class='check' id='".$ptc->sku."' type='checkbox' value=''></td>");
                                echo("<td>".$ptc->sku."</td>"); // nombre
                                echo("<td>".$indiv->nombre."</td>"); // nombre
                                echo("<td>".$color->valor."</td>");
                                echo("<td>".$talla->valor."</td>");
                                echo("<td> Bs. ".number_format($prodlook->precio, 2, ',', '.')."</td>");
                                echo('<td>Ya se devolvió</td>');
                                echo("</tr>");
                        }
                        else
                        {
                                echo("<tr>");
                                echo("<input id='precio-".$ptc->sku."' type='hidden' value='".$prodlook->precio."' />");
                                echo("<td><input class='check' id='".$ptc->sku."' type='checkbox' value=''></td>");
                                echo("<td>".$ptc->sku."</td>");// Referencia
                                echo("<td>".$indiv->nombre."</td>"); // nombre
                                echo("<td>".$color->valor."</td>");
                                echo("<td>".$talla->valor."</td>");					
                                echo("<td> Bs. ".number_format($prodlook->precio, 2, ',', '.')."</td>");					
                                echo('
                                        <td class="span3">
                                                <select id="motivo-'.$ptc->sku.'" class="input-medium">
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

                }

      ?>

        <tr>
        	<th colspan="7"><div class="text_align_right"><strong>Resumen</strong></div></th>
        </tr>       
        <tr>
        	<td colspan="6"><div class="text_align_right"><strong>Monto a devolver Bs.:</strong></div></td>
        	<td class="text_align_right"><input type="text" readonly="readonly" id="monto" value="000,00" /> </td>
        </tr>
        <tr>
        	<td colspan="6"><div class="text_align_right"><strong>Monto por envío a devolver Bs.:</strong></div></td>
        	<td  class="text_align_right"><input type="text" readonly="readonly" id="montoenvio" value="000,00" /> </td>
        </tr>
        <tr>
        	<td colspan="6"><div class="text_align_right"><strong>Total Bs.:</strong></div></td>
        	<td  class="text_align_right"><input type="text" readonly="readonly" id="montoTotal" value="000,00" /></td>
        </tr>        
    	</table>
    	<div class="pull-right"><a onclick="devolver()" title="Devolver productos" style="cursor: pointer;" class="btn btn-warning btn-large">Hacer devolución</a>
    	</div>
	</div>

</div> 
<!-- /container --> 

<script type="text/javascript">
	
var monto = 0;        
var montoEnvio = 0;        
var montoTotal = 0;    

function actualizarTotal(){
    
    montoTotal = monto + montoEnvio;
    $('#montoTotal').val(Math.round(montoTotal * 100) / 100);
}        
        
function actualizarMonto(precio){
    
    monto = parseFloat(monto) + precio;			
//    $('#monto').val(monto.toString());
    $('#monto').val(Math.round(monto * 100) / 100);
    
    actualizarTotal();    
}

        /*Marcar / desmarcar*/
    $(".check").click(function() {
        if($(this).is(':checked')){
                //sumar
            var id = $(this).attr('id');
//            actualizarMonto(parseFloat($('#precio-'+id).attr('value')));			
//            console.log($('#precio-'+id).val());
                
            actualizarMonto(parseFloat($('#precio-'+id).val()));			

        }
        else
        {// restar
            var id = $(this).attr('id');            
            actualizarMonto(-parseFloat($('#precio-'+id).val()));			
            //monto = parseFloat(monto) - parseFloat($('#precio-'+id).attr('value'));            		
            $(".input-medium").prop('selectedIndex',0);		
        }

    });
	
	$(".input-medium").change(function() {
            var motivos = new Array();

            var checkValues = $(':checkbox:checked').map(function() {
                    motivos.push ( $('#motivo-'+this.id).attr('value') );

                    return this.id;
            }).get().join();

            if( motivos.indexOf("Devolución por prenda dañada") != -1 || motivos.indexOf("Devolución por pedido equivocado") != -1 )
            {

                var id = $('#orden_id').attr('value');
                var monto = $('#monto').attr('value');

                $.ajax({
                type: "post", 
                url: "<?php echo Yii::app()->baseUrl; ?>/orden/calcularenvio", // action 
                data: { 'orden':id, 'check':checkValues, 'motivos':motivos}, 
                success: function (data) {
                    
                    montoEnvio = data;
                    
                    

                }//success
                });	

                //Otros motivos
            }else{
            
                montoEnvio = 0.00;               
                
            }
            
            $('#montoenvio').val(montoEnvio);
            
            
	});

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
			
                    var id = $('#orden_id').attr('value');
                    var monto = $('#monto').attr('value');
                    var envio = $('#montoenvio').attr('value');

                    $.ajax({
                    type: "post", 
                    url: "orden/devoluciones", // action 
                    data: { 'orden':id, 'check':checkValues, 'monto':monto, 'motivos':motivos, 'envio':envio}, 
                    success: function (data) {

                        if(data=="ok")
                                window.location.reload();

                    }//success
                    });				
		
		}
	}
	
</script>