<?php
/* @var $this OrdenController */

$this->breadcrumbs=array(
	'Pedidos'=>array('admin'),
	'Detalle'=>array('detalles','id'=>$orden->id),
	'Devolucion',
);

?>
<style> .table td {vertical-align:middle;}</style>
<script type="text/javascript">
	var indices=Array();
	var montos=Array();
	var cantidades=Array();
	var looks=Array();
	var motivos=Array();
	var ptcs=Array();

</script>
	<div class="alert in alert-block fade alert-warning text_align_center">
	        Recibiste tu orden en <b><?php echo date('d/m/Y',strtotime($orden->getFechaEstado(8)));?></b>, por lo que preferiblemente tu devolución debería solicitarse <b>antes de  
	       <?php echo date('d/m/Y',strtotime ( '+2 day',strtotime($orden->getFechaEstado(8))));?></b> para que sea canalizada adecuadamente. 
	    </div>
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
	<h1> Solicitud de Devolución <small>(Pedido #<?php echo $orden->id;?>)</small> </h1>  
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
			<th scope="col">Marca</th>
			<th scope="col">Nombre</th>
			<th scope="col">Color</th>
			<th scope="col">Talla</th>
			<th scope="col">Cantidad a<br/>Devolver</th>
			<th scope="col">Precio</th>
			<th scope="col">Motivo</th>          
        </tr>
		
		<?php
		$indice=0;
		$row=0;
        	$productos = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$orden->id)); // productos de la orden
        	$lkids=OrdenHasProductotallacolor::model()->getLooks($orden->id);
			foreach ($lkids as  $lkid){
				
				$lookpedido = Look::model()->findByPk($lkid['look_id']);
				$precio = $lookpedido->getPrecio(false);
				echo("<tr class='bg_color5' >"); // Aplicar fondo de tr, eliminar borde**
							// echo("<td></td>");
				echo("<td colspan='9'><strong>".$lookpedido->title."</strong></td>");// Referencia
							
				//echo("<td>".number_format(OrdenHasProductotallacolor::model()->precioLook($orden->id, $lkid['look_id']), 2, ',', '.')."</td>"); // precio 	 
			
							
							echo("</tr>");
				$prodslook=OrdenHasProductotallacolor::model()->getByLook($orden->id, $lkid['look_id']);
				foreach($prodslook as $prodlook){
										$ptclk = Preciotallacolor::model()->findByAttributes(array('id'=>$prodlook['preciotallacolor_id']));
                                        $prdlk = Producto::model()->findByPk($ptclk->producto_id);
                                        $marca=Marca::model()->findByPk($prdlk->marca_id);
                                        $talla=Talla::model()->findByPk($ptclk->talla_id);
                                        $color=Color::model()->findByPk($ptclk->color_id);
                                        
                                        $imagen = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$prdlk->id,'color_id'=>$color->id), array('order'=>'orden'));
                                        $contador=0;
                                        $foto = "";
                                        $label = $color->valor;
                                if($prodlook['cantidadActualizada']>0){
                                        if(!is_null($ptclk->imagen))
											  $foto = CHtml::image(Yii::app()->baseUrl . 
                                                                        str_replace(".","_thumb.",$ptclk->imagen['url']), "Imagen ", 
                                                                        array("width" => "70", "height" => "70"));
										else {
											$foto="No hay foto</br>para el color";
										}
										

                                        echo("<tr>");
                                        //echo("<td>".$prdlk->codigo."</td>"); // nombre
                                        //echo("<td>".CHtml::link($prdlk->nombre, $this->createUrl('producto/detalle', array('id'=>$prdlk->id)), array('target'=>'_blank'))."</td>"); // nombre
                                        echo("<td style='text-align:center'>".$foto."<br><div>".$label."</div></td>");
                                        echo('<td style="vertical-align: middle">'.$prdlk->codigo.'</td>');
                                        echo("<td>".$marca->nombre."</td>");
                                        echo(   "<td>".$prdlk->nombre."</td>");
										
                                        
                                          
                                        
                                   
                                        echo("<td>".$color->valor."</td>");
                                        echo("<td>".$talla->valor."</td>");
                                		echo "<td><input type='number' id='".$ptclk->id."_".$lkid."' value='0' class='input-mini cant' max='".$prodlook['cantidadActualizada']."'  min='0' required='required' /></td>";
                                       	echo CHtml::hiddenField($ptclk->id."_".$lkid."hid",$prodlook['cantidad']); 
                                        echo("<td>".number_format($prodlook['precio'], 2, ',', '.')."</td><td>".
                                        CHtml::dropDownList($ptclk->id."_".$lkid."motivo",'',Devolucion::model()->reasons,array('empty'=>'Selecciona una opcion','disabled'=>'disabled','class'=>'motivos'))."</td></tr>");
                                        echo CHtml::hiddenField($ptclk->id."_".$lkid."indice",$indice); 
										echo CHtml::hiddenField($ptclk->id."_".$lkid."precio",$prodlook['precio']);
										
								
										echo"<script>indices.push('".$indice."');</script>";
										echo"<script>ptcs.push('".$ptclk->id."');</script>";
										echo"<script>montos.push('0');</script>";
										echo"<script>cantidades.push('0');</script>";
										echo"<script>looks.push('".$lookpedido->id."');</script>";
										echo"<script>motivos.push('-');</script>";
										$indice++;
										 
										
										
										
										
										
										
										
										
										
										
										
					}
					
				}				
				
			}
			//INDIVIDUALES
			
			if(count($lkids)>0)	
				echo("<tr class='bg_color5'><td colspan='9'>Prendas Individuales</td></tr>");
			$separados=OrdenHasProductotallacolor::model()->getIndividuales($orden->id);			
			foreach($separados as $prod){
				$ptc = Preciotallacolor::model()->findByAttributes(array('id'=>$prod['preciotallacolor_id'])); // consigo existencia actual
				$indiv = Producto::model()->findByPk($ptc->producto_id); // consigo nombre
				$precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$ptc->producto_id)); // precios
				$marca=Marca::model()->findByPk($indiv->marca_id);
				$talla=Talla::model()->findByPk($ptc->talla_id);
				$color=Color::model()->findByPk($ptc->color_id);
				if($prod['cantidadActualizada']>0){
                                $imagen = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$indiv->id,'color_id'=>$color->id),array('order'=>'orden'));
                                $contador=0;
                                $foto = "";
                                $label = $color->valor;
                                //$label = "No hay foto</br>para el color</br> ".$color->valor;
                                 if(!is_null($ptc->imagen))
                                  {
                                     $foto = CHtml::image(Yii::app()->baseUrl.str_replace(".","_thumb.",$ptc->imagen['url']), "Imagen ", array("width" => "70", "height" => "70"));

                                  }
                                    else {
                                        $foto="No hay foto</br>para el color";
                                    } 
                            
                                
				echo("<tr>");
//				echo("<td>".$indiv->codigo."</td>");// Referencia
//				echo("<td>".CHtml::link($indiv->nombre, $this->createUrl('producto/detalle', array('id'=>$indiv->id)), array('target'=>'_blank'))."</td>"); // nombre
				/*Datos resumidos + foto*/
				echo("<td style='text-align:center'><div>".$foto."<br/>".$label."</div></td>");
                 
				echo('<td style="vertical-align: middle">'.$indiv->codigo.'</td>');
               echo("<td>".$marca->nombre."</td>");
               echo(   "<td>".$indiv->nombre."</td>");
                echo("<td>".$color->valor."</td>");                         
               
              
               echo("<td>".$talla->valor."</td>");
                                
               echo "<td><input type='number' id='".$ptc->id."_0' value='0' class='input-mini cant' max='".$prod['cantidadActualizada']."'  min='0' required='required' /></td>";
			  echo("<td>".number_format($prod['precio'], 2, ',', '.')."</td><td>".
			   CHtml::dropDownList($ptc->id."_0motivo",'',Devolucion::model()->reasons,array('empty'=>'Selecciona una opcion','disabled'=>'disabled','class'=>'motivos'))."</td>");
				echo CHtml::hiddenField($ptc->id."_0hid",$prod['cantidad']); 
				echo CHtml::hiddenField($ptc->id."_0precio",$prod['precio']);
				echo CHtml::hiddenField($ptc->id."_0indice",$indice);
				echo"<script>ptcs.push('".$ptc->id."');</script>";
				echo"<script>indices.push('".$indice."');</script>";
				echo"<script>montos.push('0');</script>"; 
				echo"<script>cantidades.push('0');</script>";
				echo"<script>looks.push('0');</script>";
				echo"<script>motivos.push('-');</script>";
				$indice++; 
				 echo "</tr>";
				 
			}
			
		}
		
			

	   
      ?>

          
        <tr>
        	<td colspan="8"><div class="text_align_right"><strong>Monto a devolver <?php Yii::t('contentForm','currSym');?>:</strong></div></td>
        	<td class="text_align_right"><input class="text_align_right" type="text" readonly="readonly" id="monto" value="000,00" /> </td>
        </tr>
       <!-- <tr>
        	<td colspan="6"><div class="text_align_right"><strong>Monto por envío a devolver <?php Yii::t('contentForm','currSym');?>:</strong></div></td>
        	<td  class="text_align_right"><input class="text_align_right" type="text" readonly="readonly" id="montoenvio" value="000,00" /> </td>
        </tr>
        <tr>
        	<td colspan="6"><div class="text_align_right"><strong>Total <?php Yii::t('contentForm','currSym');?>:</strong></div></td>
        	<td  class="text_align_right"><input class="text_align_right" type="text" readonly="readonly" id="montoTotal" value="000,00" /></td>
        </tr>       --> 
    	</table>
    	
    	<div class="pull-right"><a onclick="devolver()" title="Devolver productos" style="cursor: pointer;" class="btn btn-warning btn-large">Hacer devolución</a>
    	</div>
	</div>

</div> 
<!-- /container --> 

<script type="text/javascript">
	
var monto = 0;        
	$( ".motivos" ).change(function() {
  		var hidden = $(this).attr('id').replace('motivo','indice');
  		var indice = parseInt($('#'+hidden).val());

  		if($(this).val()=='')
  			motivos[indice]='-';
  		else
  			motivos[indice]= $(this).val();  			
	}); 



 $('body').on('input','.cant', function(){
 	var a =  parseInt($(this).val());
 	var b = parseInt($('#'+$(this).attr('id')+'hid').val());
 	if(isNaN(a)){
	    	$(this).val('0'); 
	    	actualizarArrays(parseInt($('#'+$(this).attr('id')+'indice').val()),a,0);
	    	$(this).val('0'); $('#'+$(this).attr('id')+'motivo').val('');  $('#'+$(this).attr('id')+'motivo').prop('disabled', 'disabled'); 
	   		
	}
	else {
		if(a>b){
			$(this).val('0'); 
			actualizarArrays(parseInt($('#'+$(this).attr('id')+'indice').val()),0,0);			
	   	}
		if(a<1&&a>0){
			$(this).val('0'); $('#'+$(this).attr('id')+'motivo').val('');  $('#'+$(this).attr('id')+'motivo').prop('disabled', 'disabled'); 
			actualizarArrays(parseInt($('#'+$(this).attr('id')+'indice').val()),0,0);	
		}
		if(a<=b&&a>0){
			$('#'+$(this).attr('id')+'motivo').val('');  $('#'+$(this).attr('id')+'motivo').prop('disabled', false); 
			actualizarArrays(parseInt($('#'+$(this).attr('id')+'indice').val()),a,parseFloat($('#'+$(this).attr('id')+'precio').val()));
			
		}
		if(a==0){
			$('#'+$(this).attr('id')+'motivo').val('');  $('#'+$(this).attr('id')+'motivo').prop('disabled', 'disabled'); 
			actualizarArrays(parseInt($('#'+$(this).attr('id')+'indice').val()),0,0); 			
	   	}		
	}
	
	 calcularDevolucion();
  
});


function calcularDevolucion(){
	var i=0;
	var acum=0;
	for(i=0; i<montos.length;i++){
		acum=acum+parseFloat(montos[i]);
	}
	$('#monto').val(parseFloat(acum).toFixed(2));
}

$( document ).ready(function() {
  console.log(montos.toString()+" "+indices.toString()+" "+cantidades.toString());
});

function actualizarArrays(indice,cantidad,monto ){
	montos[indice]=parseFloat(cantidad)*parseFloat(monto);
	cantidades[indice]=parseFloat(cantidad);
	if(cantidad==0)
		motivos[indice]='-';
	console.log(montos.toString()+" - "+cantidades.toString()+" - "+ptcs.toString());
}

function devolver()
	{
				
				var ct=0;
				var mt=0;
				for(var i =0; i<indices.length; i++){
					if(parseInt(cantidades[i])>0)
						ct++;
					if(motivos[i]!='-')
						mt++;
				}
				if(ct==mt){
				    var id = $('#orden_id').attr('value');
                    var monto = $('#monto').attr('value');
                    	var inds=indices.toString();
						var monts=montos.toString();
						var cants=cantidades.toString();
						var lks=looks.toString();
						var mots=motivos.toString();
						var prtcs=ptcs.toString();
                 
                     
                    
                    $.ajax({
                        type: "post", 
                        url: "../devolver", // action 
                        data: { 'orden':id, 'monto':monto,'indices':inds, 'montos':monts, 'motivos':mots, 'ptcs':prtcs, 'looks':lks,'cantidades':cants}, 
                        success: function (data) {

                            if(data=="ok")
                                    window.location.replace("<?php echo Yii::app()->baseUrl;?>/orden/detallePedido/"+id);
                            if(data=="error")
                                    location.reload();
                            if(data=='no')
                            	location.reload();       
                         }
                    });		
                }
                else{
                	alert('Para cada prenda que desees devolver debes especificar el motivo de la devolción');
                }		
		
		}
	
</script>