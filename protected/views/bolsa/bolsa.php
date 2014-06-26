<?php
/* @var $this BolsaController */
$this->breadcrumbs=array(
	Yii::t('contentForm','Bag'),
);
if (!Yii::app()->user->isGuest) { // que este logueado

//$usuario = Yii::app()->user->id;

//$bolsa = Bolsa::model()->findByAttributes(array('user_id'=>$usuario));

$sql = "select count( * ) as total from tbl_bolsa_has_productotallacolor where look_id != 0 and bolsa_id = ".$bolsa->id."";
$num = Yii::app()->db->createCommand($sql)->queryScalar();

// bolsa tiene pro-talla-color
$bptcolor = BolsaHasProductotallacolor::model()->findAllByAttributes(array('bolsa_id'=>$bolsa->id,'look_id'=> 0));
                  $precios = array();
				  $descuentos = array();
				  $cantidades = array();
				  $total_look = 0;
				  $total_productos_look = 0;
?>

<div class="container margin_top" id="carrito_compras">
  <div class="row margin_bottom_large">
	
    <div class="span12"> 
   
    	
      <div class="row">
        <article class="span7">            
          <h1>
          <?php echo $bolsa->admin ? "Bolsa de <strong>{$bolsa->user->profile->first_name}
                        {$bolsa->user->profile->last_name}</strong>"
                      : Yii::t('contentForm','Your bag');  ?>
          </h1>
          
          
          <!-- FLASH ON --> 
            <?php $this->widget('bootstrap.widgets.TbAlert', array(
                    'block'=>true, // display a larger alert block?
                    'fade'=>true, // use transitions?
                    'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
                    'alerts'=>array( // configurations per alert type
                        'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
                        'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
                    ),
                )
            ); ?>	
            <!-- FLASH OFF --> 
          <form id="form_productos">
          <?php 
          
          if($num!=0) // si hay looks 
		  {
		  	//imprima looks
		  	foreach ($bolsa->looks() as $look_id){
		  		$bolsahasproductotallacolor = BolsaHasProductotallacolor::model()->findAllByAttributes(array('bolsa_id'=>$bolsa->id,'look_id' => $look_id));
				$look = Look::model()->findByPk($look_id);
				if(isset($look)){
				$total_look++;
				
				 
		  	?>
          <!-- Look ON -->
          <h3 class="braker_bottom margin_top"><?php echo $look->title; ?></h3>
          <div class="padding_left">
            <table class="table" width="100%" >
              <thead>
                <tr>
                  <th colspan="2"><?php echo  Yii::t('contentForm', 'Product');  ?></th>
                  <th><?php echo  Yii::t('contentForm', 'Unit price');  ?></th>
                  <th colspan="2"><?php echo  Yii::t('contentForm', 'Quantity');  ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($bolsahasproductotallacolor as $productotallacolor){ ?>
                <?php 
                	$total_productos_look++;
                	$color = Color::model()->findByPk($productotallacolor->preciotallacolor->color_id)->valor;
					$talla = Talla::model()->findByPk($productotallacolor->preciotallacolor->talla_id)->valor;
					$producto = Producto::model()->findByPk($productotallacolor->preciotallacolor->producto_id);
					//$imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'orden'=>'1'));
					//$doblimg= CHtml::image( str_replace(".","_x90.",$producto->getImageUrl($productotallacolor->preciotallacolor->color_id)) , "Imagen", array("width" => "70", "height" => "70"));
					if(!is_null($productotallacolor->preciotallacolor->imagen)){
						$doblimg=CHtml::image(Yii::app()->baseUrl.str_replace(".","_x90.",$productotallacolor->preciotallacolor->imagen['url']), "Imagen ", array("width" => "70", "height" => "70",'class'=>'margin_bottom'));
					}else{
						$doblimg= "No hay foto</br>para el color";
					} 
					
                	//$test = PrecioTallaColor::model()->findByPK($productotallacolor->preciotallacolor->id);
					//if(isset($test)){
					//	echo $test->color_id;
						
					//	echo Color::model()->findByPk($test->color_id)->valor;
					//}
					$pre="";
					$precio_descuento = "";
					/* 	foreach ($producto->precios as $precio) {
				   		$pre = Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento);
						
						array_push($precios,$precio->precioDescuento);	
						array_push($descuentos,$precio->ahorro);		
						}
					 */
					 	array_push($cantidades,$productotallacolor->cantidad);
					 	$pre = $producto->getPrecioVenta2(false);
					 	$precio_descuento = $producto->getPrecioDescuento(false);
						array_push($precios,floatval($pre));	
						array_push($descuentos,$producto->getAhorro(false));
                	?>
                <tr>
                  <?php
               				  	
						//$aaa = CHtml::image(Yii::app()->baseUrl . str_replace(".","_thumb.",$imagen->url), "Imagen ", array("width" => "150", "height" => "150",'class'=>'margin_bottom'));
						echo "<td>".$doblimg."</td>";
					
					?>
                  <td><strong><?php echo $producto->nombre; ?></strong> <br/>
                    <strong>Color</strong>: <?php echo $color; //isset($productotallacolor->preciotallacolor->color->valor)?$productotallacolor->preciotallacolor->color->valor:"N/A"; ?> <br/>
                    <strong>Talla</strong>: <?php echo $talla; //isset($productotallacolor->preciotallacolor->talla->valor)?$productotallacolor->preciotallacolor->talla->valor:"N/A"; ?> 
                    <?php                      
//                        $hoy = new DateTime();
//                        $agregado = new DateTime($productotallacolor->added_on);
//                        $diferencia = $hoy->diff($agregado)
//                                          ->days; //Dias desde que se agrego
//                        
//                        $lookActual = Look::model()->findByPk($productotallacolor->look_id);
//                        $personalShopper = $lookActual->user->profile;
//                        
//                        $prorden = new OrdenHasProductotallacolor;
//                        
//
//                        echo "Agregado<pre>";
//                        print_r($hoy->format("Y-m-d"));
//                        echo "</pre>";
//                        echo "Agregado<pre>";
//                        print_r($agregado->format("Y-m-d"));
//                        echo "</pre>";
//                        echo "Agregado<pre>";
//                        print_r($diferencia);
//                        echo "</pre>";
//                        
//                        //si lleva mas tiempo del permitido, no agregar a la orden
//                        if($diferencia <= $personalShopper->tiempo_validez){
//                            $prorden->comision = $personalShopper->comision;
//                            $prorden->tipo_comision = $personalShopper->tipo_comision;
//                            $prorden->status_comision = OrdenHasProductotallacolor::STATUS_PENDIENTE;
//                            echo "<br>SI";
//                        }else{
//                            echo "<br>NO";
//                        }
//                        
//                        echo "<br>$personalShopper->first_name<br>ORden<pre>";
//                        print_r($prorden->attributes);
//                        echo "</pre>";
                    ?>
                  
                  </td>
                    
                  
                  <td>
                  	<?php 
                  	if(floatval($precio_descuento) < floatval($pre)){
                  		echo '<del>'.Yii::t('contentForm', 'currSym').' '.$pre.'</del><br/>'.Yii::t('contentForm', 'currSym').' '.$precio_descuento;
                  	}else{
                  		echo Yii::t('contentForm', 'currSym').' '.$pre;
                  	}
                  	?>
                  </td>
                  
				<td width='8%'>
					<input type="hidden" value="<?php echo $productotallacolor->cantidad; ?>" />
					<input type='text' name="cant[<?php echo $productotallacolor->preciotallacolor_id; ?>][<?php echo $look->id; ?>]" maxlength='2' placeholder='Cant.' value='<?php echo $productotallacolor->cantidad; ?>' class='span1 cantidades'/>
	            	<a id="<?php echo $productotallacolor->preciotallacolor_id; ?>" onclick='actualizar(this)' style="display:none"  class='btn btn-mini'>Actualizar</a>
	            	
	            </td>
	            <td style='cursor: pointer' onclick='eliminar(<?php echo $productotallacolor->preciotallacolor_id; ?>)' id='elim<?php echo $productotallacolor->preciotallacolor_id; ?>'>&times;</td>
				
                </tr>
	                <?php 
	            } 

	            // revisar si el look tiene descuento
			 	if(!is_null($look->tipoDescuento)){
			 		// revisar si está comprando el look completo para aplicar descuento
				 	if($bolsa->getLookProducts($look_id) == $look->countItems()){
				 		//echo 'Precio: '.$look->getPrecio(false).' - Precio desc: '.$look->getPrecioDescuento(false);
				 		$descuento_look = $look->getPrecio(false) - $look->getPrecioDescuento(false);
				 		array_push($descuentos,$descuento_look);
				 	}
			 	}


	            ?>
              </tbody>
            </table>
            <hr/>
            <p class="muted"><i class="icon-user"></i> <?php echo Yii::t('contentForm','Created for') ?>: <a href="#" title="ir al perfil"><?php echo $look->user->profile->first_name; ?></a></p>
          </div>
          <!-- Look OFF -->
          <?php
          }	  
			}
		  }

$sql = "select count( * ) as total from tbl_bolsa_has_productotallacolor where look_id = 0 and bolsa_id = ".$bolsa->id."";
$pr = Yii::app()->db->createCommand($sql)->queryScalar();

		if($pr!=0) // si hay productos individuales
		{
		?>
          <h3 class="braker_bottom margin_top"><?php echo Yii::t('contentForm','Individual products'); ?></h3>
          <div class="padding_left">
            <table class="table" width="100%" >
              <thead>
                <tr>
                  <th colspan="2"><?php echo Yii::t('contentForm','Product'); ?></th>
                  <th><?php echo Yii::t('contentForm','Unit price'); ?> </th>
                  <th colspan="2"><?php echo Yii::t('contentForm','Quantity'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  

                  
				  if(isset($bptcolor)) // si hay productos en la bolsa del usuario
				  {
				  
	                  foreach($bptcolor as $productoBolsa) // cada producto en la bolsa
					  {
					  	$todo = Preciotallacolor::model()->findByPk($productoBolsa->preciotallacolor_id);
						
							$producto = Producto::model()->findByPk($todo->producto_id);
					  		$talla = Talla::model()->findByPk($todo->talla_id);
					  		$color = Color::model()->findByPk($todo->color_id);
							
							// $imagen = CHtml::image($producto->getImageUrl($todo->color_id), "Imagen", array("width" => "70", "height" => "70"));
							$imagen = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$producto->id,'color_id'=>$color->id));
					
							echo "<tr><td>";		
							
					/*if($imagen){
						
						$con = 0;
						
						foreach($imagen as $ima){
							if($con == 0){	
								$con++;						  	
								$aaa = CHtml::image(Yii::app()->baseUrl . str_replace(".","_x180.",$ima->url), "Imagen ", array("width" => "150", "height" => "150",'class'=>'margin_bottom'));
								echo "<td>".$aaa."</td>";
							}
						}
					}else
                                echo"<td><img src='http://placehold.it/70x70'/ class='margin_bottom'></td>";*/
                                
                                if(!is_null($todo->imagen))
											  {echo CHtml::image(Yii::app()->baseUrl.str_replace(".","_x180.",$todo->imagen['url']), "Imagen ", array("width" => "150", "height" => "150",'class'=>'margin_bottom'));
												 
											  }
								else {
											echo "No hay foto</br>para el color";
								} 
                                
                                
                                

                                echo "</td>
                                <td>
                                <strong>".$producto->nombre."</strong> <br/>
                                <strong>".Yii::t('contentForm','Color')."</strong>: ".$color->valor."<br/>";
                                echo "<strong>".Yii::t('contentForm','Size')."</strong>: ".$talla->valor;	
                                
                                echo "</td>";
                                        

                                $pre="";
                                $precio_descuento = "";
                                /*foreach ($producto->precios as $precio) {
                                $pre = Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento);

                                array_push($precios,$precio->precioDescuento);	
                                array_push($descuentos,$precio->ahorro);		
                                }*/
                                //$pre = $producto->precioVenta;

								$pre = $producto->getPrecioVenta2(false);
					 			$precio_descuento = $producto->getPrecioDescuento(false);
                                array_push($precios,floatval($pre));	
                                array_push($descuentos,$producto->getAhorro(false));

                                array_push($cantidades,$productoBolsa->cantidad);

                                echo "<td>";
				                  	if(floatval($precio_descuento) < floatval($pre)){
				                  		echo '<del>'.Yii::t('contentForm', 'currSym').' '.$pre.'</del><br/>'.Yii::t('contentForm', 'currSym').' '.$precio_descuento;
				                  	}else{
				                  		echo Yii::t('contentForm', 'currSym').' '.$pre;
				                  	}
                  				echo "<td>";

                                //echo "<td>".Yii::t('contentForm', 'currSym').' '.$pre."</td>";
                                ?>

                                <td width='8%'>
                                        <input type="hidden" value="<?php echo $productoBolsa->cantidad; ?>" />
                                        <input type='text' name="cant[<?php echo $productoBolsa->preciotallacolor_id; ?>][0]" maxlength='2' placeholder='Cant.' value='<?php echo $productoBolsa->cantidad; ?>' class='span1 cantidades'/>
                                <a id="<?php echo $productoBolsa->preciotallacolor_id; ?>" onclick='actualizar(this)' style="display:none"  class='btn btn-mini'>Actualizar</a>
	                    	
	                    </td>
	                  	<td style='cursor: pointer' onclick='eliminar(<?php echo $productoBolsa->preciotallacolor_id; ?>)' id='elim<?php echo $productoBolsa->preciotallacolor_id; ?>'>&times;</td>
	                	</tr>
	                	
	                	<?php
				  	}// foreach
				}//if isset    
				else {
							
				}
				  
                  ?>
              </tbody>
            </table>
          </div>
          <!-- Look OFF -->
          
          <?php
			}// if de productos individuales
			else
			{ 
                             $mensaje = $bolsa->admin ? Yii::t('contentForm', 'The bag is empty')
                              :  Yii::t('contentForm', 'What are you waiting for? Looks amazing clothes and waiting for you');   
			 
                         echo "<h4 class='braker_bottom margin_top'>{$mensaje}</h4>";
                         
                         if($bolsa->admin){
                             
                             echo CHtml::link('<i class="icon-shopping-cart icon-white"> 
                             </i>  Registrar Orden',array("/user/admin/compra", "id"=>$bolsa->user->id),
                                 array(
                                     "class" => "btn btn-danger"
                                 ));
                             
                         }
			 	
			}
			
		?>
		
          <?php
        if($pr!=0 || $num!=0) // si hay productos individuales o bien si hay looks (aqui se puede poner la comparacion de si hay looks)
		{
		?>
		</form>
        </article>
        <div class="span5 margin_bottom margin_top_large padding_top_xsmall"> 
         <div class="margin_left">
             
          <!-- SIDEBAR ON --> 
          <script > 
			// Script para dejar el sidebar fijo Parte 1
			function moveScroller() {
				var move = function() {
					var st = $(window).scrollTop();
					var ot = $("#scroller-anchor").offset().top;
					var s = $("#scroller");
					if( (st + 600) <= ($(document).height() -  $('#wrapper_footer footer').height()) ){
						console.log()
						if(st > ot ) {
							s.css({
								position: "fixed",
								top: "70px"
							});
						} else {
							if(st <= ot ) {
								s.css({
									position: "relative",
									top: "0"
								});
							}
						}
					}
					else{
						console.log("chao");	
						var Hcotenido = ( ($(document).height() -  $('#wrapper_footer footer').height()) - 792 ).toString() + "px";
						s.css({
							position: "relative",
							top: Hcotenido
						});							
					}
				};
				
				$(window).scroll(move);

			}
		</script>
          <div id="scroller-anchor"></div>
          <div id="scroller">
            <div class="well margin_top_large well_personaling_big">
                <?php 
            	

            	//$sql = "select count( * ) as total from tbl_bolsa_has_productotallacolor where look_id != 0 and bolsa_id = ".$bolsa->id."";
				//$look = Yii::app()->db->createCommand($sql)->queryScalar();	

            	
				$sql = "select count( * ) as total from tbl_bolsa_has_productotallacolor where look_id = 0 and bolsa_id = ".$bolsa->id."";
				$indiv = Yii::app()->db->createCommand($sql)->queryScalar();
				
            	?>
                <h5><?php echo Yii::t('contentForm', 'Selected looks').': '.  $total_look; ?><br/>
                  <?php 
              	
              	if($total_look!=0)

				{ 
					echo Yii::t('contentForm', 'Products that make the Looks').": ". $total_productos_look ."<br/>";
				}
				$balance=Profile::getSaldo(Yii::app()->user->id);
								
              	?>
                  <?php 
              	//variables de sesion
              	Yii::app()->getSession()->add('totalLook',$total_look); 
              	Yii::app()->getSession()->add('totalProductosLook',$total_productos_look);
              	Yii::app()->getSession()->add('totalIndiv',$indiv);
              	
              	?>
                 <?php echo Yii::t('contentForm', 'Individual products').': '.$indiv; 
                 if($balance>0)

				{ 
					echo "<br/><br/>".Yii::t('contentForm', 'Available Balance:').' <strong>'.Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($balance, '').'</strong> '; 
				}?>
                 </h5>
                <hr/>
<!--                 <label class='checkbox'>
                  <input type='checkbox'>
                  Envolver y enviar como regalo (9Bs. Adicionales) </label>
                <hr/> -->
                <div class='margin_bottom'>
                  <div class='tabla_resumen_bolsa'>
                    <table width='100%' border='0' cellspacing='0' cellpadding='0' class='table table-condensed '>
                      <?php
                      	$totalPr=0;
                      	$totalDe=0;
                      	$envio = 0;
						$i=0;
						
						if (empty($precios)) // si no esta vacio
						{}
						else{
							foreach($precios as $x){
	                      		$totalPr = $totalPr + ($x * $cantidades[$i]);
								$i++;
	                      	}
						}
						foreach($descuentos as $y)
                      	{
                      		$totalDe = $totalDe + $y;
                      	}
						
						//$iva = (($totalPr - $totalDe)*Yii::t('contentForm', 'IVA')); 
						$iva = (($totalPr)*Yii::t('contentForm', 'IVA')); 
						
						//$t = $totalPr - $totalDe + (($totalPr - $totalDe)*Yii::t('contentForm', 'IVA')) + $envio; 
						$t = $totalPr - $totalDe + (($totalPr)*Yii::t('contentForm', 'IVA')) + $envio; 
						
						$seguro = $t*0.013;
						
						//$t += $seguro;
			 			
						// variables de sesion
						Yii::app()->getSession()->add('subtotal',$totalPr);
						Yii::app()->getSession()->add('descuento',$totalDe);
					
						Yii::app()->getSession()->add('iva',$iva);
						Yii::app()->getSession()->add('total',$t);
						/*
						Yii::app()->getSession()->add('envio',$envio);
						Yii::app()->getSession()->add('seguro',$seguro);  
						
						*/
						
						//echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($totalPr, '');
                      	?>
                      <tr>

                        <th class="text_align_left"><?php echo Yii::t('contentForm', 'Products'); ?>:</th>
                        <td class="text_align_right"><?php echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($totalPr, ''); ?></td>
                      </tr>
                      <tr>
                        <th class="text_align_left">I.V.A. (<?php echo Yii::app()->params['IVAtext'];?>):</th>
                        <td class="text_align_right"><?php echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($iva, ''); ?></td>
                      </tr>
                      <?php if($totalDe != 0){ // si no hay descuento ?> 
                      <tr>
                        <th class="text_align_left"><?php echo Yii::t('contentForm', 'Discount'); ?>:</th>
                        <td class="text_align_right"><?php echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($totalDe, ''); ?></td>
                      </tr>
                      <?php } ?>
                      <tr>
                        <th class="text_align_left"><h4><?php echo Yii::t('contentForm', 'Subtotal'); ?>:</h4></th>
                        <td class="text_align_right"><h4><?php echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($t, ''); ?></h4></td>
                      </tr>
                    </table>
                    
                    <?php
                       /*Si es una compra del admin para el usuario*/
//                       $params = $bolsa->admin ? array("admin" => 1, "user" => $bolsa->user->id) : array();                    
                       $params = array();                    
                       $this->widget('bootstrap.widgets.TbButton', array(
				    'label'=>Yii::t('contentForm', 'Complete purchase'),
				    'type'=>'warning', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
				    'size'=>'normal', // null, 'large', 'small' or 'mini'
				    'url'=> $this->createAbsoluteUrl('bolsa/compra',$params,'https'), // action ir 
				    'icon'=>'lock white',
				)); 
				 
				//<a href="Proceso_de_Compra_1.php" class="btn btn-danger"><i class="icon-shopping-cart icon-white"></i> Completar compra</a>
				?>
                    <?php
                	
     //            	if($total_look!=0)
					// {
					// 	echo '<div class="alert alert-info margin_top_small">';
					// 	echo "Con la compra  del Look completo estas ahorrando 184 Bs.";
					// 	echo '</div>';

					// }
                	
                	?>
                	<a  onclick='actualizartodos()' class='btn btn-mini'><?php echo Yii::t('contentForm', 'Update all'); ?></a>
                  </div>
                </div>
                <p><i class="icon-calendar"></i> <?php echo Yii::t('contentForm', 'Date estimated delivery'); ?>: <?php echo date('d/m/Y', strtotime('+1 day'));?> - <?php echo date('d/m/Y', strtotime('+1 week'));  ?> </p>
              </div>  
          
          
          
          </div>
            <script type="text/javascript"> 
		// Script para dejar el sidebar fijo Parte 2
			$(function() {
				if ($(window).scrollTop() < 430) {
					moveScroller();
				}
			 });
		</script> 
          <!-- SIDEBAR OFF --> 
          
          
              <p><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/politicas_de_devoluciones" target="_blank"><?php echo Yii::t('contentForm', 'See Shipping and Returns Policies'); ?></a></p>
              <p class="muted"><i class="icon-comment"></i> <?php echo Yii::t('contentForm', 'Contact an advisor for assistance Personaling: Monday to Friday 8:30 am to 5:00 pm'); ?></p>
              <hr/>
              <p class="muted"><a style="cursor: pointer" onclick="limpiar(<?php echo($bolsa->id); ?>)" title="vaciar la bolsa de compras"><?php echo  Yii::t('contentForm', 'Empty shopping bag');  ?></a> | <a href="../tienda/index" title="seguir comprando"><?php echo  Yii::t('contentForm', 'Keep buying');  ?></a></p>
            </div>
            
          
        
        </div>
      </div>
    </div>
  </div>
  <hr/>
  <?php
  }// si hay productos
  
  ?>
</div>
<?php
// si esta logueado
} else{
		// redirecciona al login porque se murió la sesión
	header('Location: /user/login');	
}
?>
<!-- /container --> 

<script>
	$('.cantidades').live('keyup',function(e){
		
		var code = e.which; // recommended to use e.which, it's normalized across browsers
    	if(code==13){
    		actualizar($(this).next("a"));	
    	} else {
			if ($(this).val()!=$(this).prev().val())
				$(this).next("a").show();
			else
				$(this).next("a").hide(); 
		}
	});
	function actualizartodos()
	{

	
	//var data = $("input.cantidades").serializeArray();
	var data = $('input.cantidades').serialize();
	console.log(data);
	
	
	
	// llamada ajax para el controlador de bolsa	   
     	$.ajax({
	        type: "post",
	        url: "actualizar", // action de actualizar
	        //data: { 'prtc':id, 'cantidad':cantidad},
	        //data: { cantidades:data}, 
	        data : $('input.cantidades').serialize()+'&bolsa_id=<?php echo $bolsa->id; ?>',
	        success: function (data) {
				console.log(data);
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
	function actualizar(boton)
	{
	//console.log($(boton).prev("input").val());
	var cantidad = $(boton).prev("input").val();
	console.log($(boton).prev("input").attr('name'));
	temporal = $(boton).prev("input").attr('name').split('[');
	var id = temporal[1].slice(0,-1);
	var look_id = temporal[2].slice(0,-1);
	console.log("look_id: "+look_id+" id: "+id+" cantidad: "+cantidad);
	//var cantidad = $("#cant"+id+".span1").attr("value");


	
	if(cantidad<0)
	{
		alert("Ingrese una cantidad mayor a 1.");
	}else
	{
	// llamada ajax para el controlador de bolsa	   
     	$.ajax({
	        type: "post",
	        url: "actualizar", // action de actualizar
	        data: { 'look_id':look_id,'prtc':id, 'cantidad':cantidad,bolsa_id:<?php echo $bolsa->id; ?>},
	       
	       
	        success: function (data) {
				console.log(data);
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
	
	
	function limpiar(idBolsa)
	{
		//alert(idBolsa);	
	
	// llamada ajax 
     	$.ajax({
	        type: "post",
	        url: "limpiar", // action
	        data: { 'idBolsa':idBolsa }, 
	        success: function (data) {
				
				if(data=="ok")
				{
					window.location.reload()
				}
					
	       	}//success
	       })

	}
	
</script> 
