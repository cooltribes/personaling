<?php
$nf = new NumberFormatter("es_VE", NumberFormatter::CURRENCY);
if (!Yii::app()->user->isGuest) { // que este logueado

$user = User::model()->findByPk($user);
//$pago = Pago::model()->findByAttributes(array('id'=>$orden->pago_id));
$tipo_pago = $orden->getTipoPago();
//echo $orden->pago_id;

?>
<?php //echo "xPagar".$orden->getxPagar()." SumxOrden".Detalle::model()->getSumxOrden($orden->id);?>
<div class="container margin_top">
<div class="row">
  <div class="span8 offset2">
    <?php
      
      if($orden->estado==1||$orden->estado==7) // pendiente de pago o pago insuficiente
	  {
	  	if($tipo_pago == 1 || $tipo_pago == 3){
	      ?>
    <div class="alert alert-success margin_top_medium margin_bottom">
      <?php if($admin){ ?>
                  <h1><?php echo Yii::t('contentForm','The order to <b>{name}</b> has successfully completed',array('{name}'=>$user->profile->first_name)); ?>  </h1>
                  <?php }else{ ?>
                      <h1> <?php echo Yii::t('contentForm','Your order has been successfully received.'); ?></h1>                  
                  <?php } ?>
      <?php if($admin){ ?>      
          <p> <?php echo Yii::t('contentForm','Instructions have been sent and email summary: {email}',array('{email}'=>$user->email)) ?></p>
      <?php }else{ ?>
          <p> <?php echo Yii::t('contentForm','Here are the instructions to complete your purchase. (Also we have sent to your email: <strong class="alert-success">{email}</strong>)',array('{email}'=>$user->email)); ?></p>
      <?php } ?>
    </div>
    <section class="bg_color3 margin_bottom_small padding_small box_1">
      <h2><?php echo Yii::t('contentForm', 'Next step'); ?></h2>
      <hr/>
      <p><strong><?php echo Yii::t('contentForm','To complete your purchase you must:'); ?></strong></p>
      <ol>
        <li> <?php echo Yii::t('contentForm','<strong>Make payment:</strong> {monto} via wire transfer or bank deposit before {date} in the following bank account:',array('{monto}' => Yii::app()->numberFormatter->formatCurrency( $orden->getxPagar(), Yii::t('contentForm', 'currSym').' '),'{date}' =>date('d-m-Y H:i:s', strtotime($orden->fecha. ' + 3 days') ))); ?>  
        	<br>
          	<br>
          <ul class="margin_bottom_medium">
            <li><strong><?php echo Yii::t('contentForm','Account Number:'); ?></strong> 0134-0277-98-2771093092</li>
            <li><strong><?php echo Yii::t('contentForm','Account holder:'); ?></strong>PERSONALING C.A.</li>
            <li><strong><?php echo Yii::t('contentForm','RIF:'); ?>:</strong> Nº J-40236088-6</li>
            <li><strong><?php echo Yii::t('contentForm','Email:'); ?>:</strong> ventas@personaling.com</li>
          </ul>
        </li>
        <li class="margin_bottom_medium">
        	<?php echo Yii::t('contentForm','<strong>Add your payment:</strong> through the link sent to your email or login to Your Account -> Your Orders, select the order you want to pay and Save Pay option.'); ?>
        </li>
        <li class="margin_bottom_medium">
        	<?php echo Yii::t('contentForm','<strong>Process Validation:</strong> usually takes 1 to 5 business days and is to validate your transfer or deposit with our bank. You can check the status of your purchase in your profile.'); ?>
        </li>
        <li><?php echo Yii::t('contentForm','<strong>Shipping:</strong> After confirm payment we will send the product :)'); ?></li>
      </ol>
      <hr/>
      <div class="clearfix">
        <div class="pull-left"><a onclick="window.print();" class="btn"><i class="icon-print"></i> <?php echo Yii::t('contentForm','Print these instructions'); ?></a></div>
    <div class="pull-right"> <?php echo Yii::t('contentForm','If you\'ve made ​​your deposit'); ?> <a href="#myModal" role="button" class="btn btn-mini" data-toggle="modal" ><?php echo Yii::t('contentForm','click here'); ?></a></div> 
      </div>
    </section>
    <?php
      	}else if($tipo_pago == 4){
      		?>
    <div class="alert alert-success margin_top_medium margin_bottom">
      <?php if($admin){ ?>
                  <h1><?php echo Yii::t('contentForm','The order to <b>{name}</b> has successfully completed',array('{name}'=>$user->profile->first_name)); ?></h1>
                  <?php }else{ ?>
                      <h1><?php echo Yii::t('contentForm','Your order has been successfully received.'); ?></h1>                  
                  <?php } ?>
     <?php if($admin){ ?>      
          <p>  <?php echo Yii::t('contentForm','Instructions have been sent and email summary: {email}',array('{email}'=>$user->email)) ?>)</p>
      <?php }else{ ?>
          <p> <?php echo Yii::t('contentForm','Here are the instructions to complete your purchase. (Also we have sent to your email: <strong class="alert-success">{email}</strong>)',array('{email}'=>$user->email)); ?></p>
      <?php } ?>
    </div>
    <section class="bg_color3 margin_bottom_small padding_small box_1">
    <h2><?php echo Yii::t('contentForm', 'Next step'); ?></h2>
    <hr/>
    <p><strong><?php echo Yii::t('contentForm','To complete your purchase you must:'); ?>:</strong></p>
    <ol>
      <li> <strong>Realizar el pago</strong>: de <?php echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($orden->getxPagar(), ''); ?> via MercadoPago. <br>
      </li>
      <li><?php echo Yii::t('contentForm', '<strong>Add your payment:</strong> through MercadoPago system.'); ?></li>
      <li><?php echo Yii::t('contentForm', '<strong>Process Validation:</strong> usually takes 1 to 5 business days of validating your payment.'); ?></li>
      <li><?php echo Yii::t('contentForm','<strong>Shipping:</strong> After confirm payment we will send the product :)'); ?></li>
    </ol>
    <hr/>
    <div class="clearfix">
      <div class="pull-left"><a onclick="window.print();" class="btn"><i class="icon-print"></i><?php echo Yii::t('contentForm','Print these instructions'); ?></a></div>
      <div class="pull-right">
        </section>
        <?php
      	}
      }// caso 1
      
      if($orden->estado==2) // pendiente por confirmar
	  {
	  	echo "
	  	<section class='bg_color3 margin_top  margin_bottom_small padding_small box_1'>
        <div class='alert'>
          <h1>".Yii::t('contentForm', 'Order is process')."</h1>
          <p>".Yii::t('contentForm', 'We received the order data as well as your payment transfer or bank deposit')."</p>
        </div>
         
        <p>".Yii::t('contentForm', 'We will verify the transfer or deposit in the next 2-3 business days and will notify you when it has been approved')."</p>
	  	</section>
	  	";
		
	  }
	  
	  if($orden->estado==3) // Listo el pago
	  {
              ?>
	  	
	  	
              <div class='alert alert-success margin_top_medium margin_bottom'>
                  <?php if($admin){ ?>
                  <h1><?php echo Yii::t('contentForm','The order to <b>{name}</b> has successfully completed',array('{name}'=>$user->profile->first_name)); ?></h1>
                  <?php }else{ ?>
                      <h1><?php echo Yii::t('contentForm','Your order has been successfully received.');  ?></h1>                  
                  <?php } ?>
                      
                  <p><?php echo Yii::t('contentForm','We received the order data as well as your credit card payment. <br/> Your order will be shipped in the coming hours.');  ?></p>
              </div>

	  	
		
	 <?php 
                }
      
      ?>
        <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
          <h3><?php echo Yii::t('contentForm','Order Summary'); ?> </h3>
          <p class="well well-small"><strong><?php echo Yii::t('contentForm','Confirmation number'); ?>:</strong> <?php echo $orden->id; ?></p>
          <p> <strong><?php echo Yii::t('contentForm','Date estimated delivery'); ?>:</strong> <?php echo date("d/m/Y",strtotime($orden->fecha)); ?> - <?php echo  date('d/m/Y', strtotime($orden->fecha.'+1 week')); ?></p>
          <hr/>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <th class="text_align_left"><?php echo Yii::t('contentForm','Subtotal'); ?>:</th>
              <td><?php echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($orden->subtotal, ''); ?></td>
            </tr>
            <?php if($orden->descuento != 0){ // si no hay descuento ?> 
            <tr>
              <th class="text_align_left"><?php echo Yii::t('contentForm','Discount'); ?>:</th>
              <td><?php echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($orden->descuento, ''); ?></td>
            </tr>
            <?php } ?>            
            <tr>
              <th class="text_align_left"><?php echo Yii::t('contentForm','Shipping'); ?>:</th>
              <td><?php echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($orden->envio + $orden->seguro, ''); ?></td>
            </tr>
            <tr>
              <th class="text_align_left">I.V.A. (<?php echo Yii::t('contentForm', 'IVAtext');?>):</th>
              <td><?php echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($orden->iva, ''); ?></td>
            </tr>            
            <tr>
              <th class="text_align_left"><h4><?php echo Yii::t('contentForm','Total'); ?>:</h4></th>
              <td><h4><?php echo Yii::t('contentForm', 'currSym').' '.Yii::app()->numberFormatter->formatCurrency($orden->total, ''); ?></h4></td>
            </tr>
          </table>
          <hr/>
          <?php if($admin){ ?>                    
              <p><?php echo Yii::t('contentForm', 'We have sent a summary of the purchase to email'); ?>: <strong><?php echo $user->email; ?></strong> </p>
          <?php }else{ ?>              
              <p><?php echo Yii::t('contentForm', 'We have sent a summary of the purchase to your inbox'); ?>: <strong><?php echo $user->email; ?></strong> </p>
          <?php } ?>
          <?php
        
        $s1 = "select count( * ) as total from tbl_orden_has_productotallacolor where look_id != 0 and tbl_orden_id = ".$orden->id."";
		$look = Yii::app()->db->createCommand($s1)->queryScalar();
        
		$s2 = "select count( * ) as total from tbl_orden_has_productotallacolor where look_id = 0 and tbl_orden_id = ".$orden->id."";
		$ind = Yii::app()->db->createCommand($s2)->queryScalar();
			
        ?>
          <h3 class="margin_top"><?php echo Yii::t('contentForm', 'Order Details'); ?></h3>
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
					
					if(isset($look))
						array_push($todos,$look->id);
				}
			}
			
			foreach($todos as $cadalook)
			{
				$look = Look::model()->findByPk($cadalook);

			
			if(!in_array($cadalook,$vacio)){
						
			echo('
			<h4 class="braker_bottom">'.$look->title.'</h4>
	        <div class="padding_left">
	          <table class="table" width="100%" >
	            <thead>
	              <tr>
	                <th colspan="2">'.Yii::t('contentForm', 'Producto').'</th>
	                <th>'.Yii::t('contentForm', 'Unit price').'</th>
	                <th >'.Yii::t('contentForm', 'Quantity').'</th>
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
						//	$imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'orden'=>'1'));
							
							$imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'color_id'=>$color->id));
									
							$pre="";
						 	foreach ($producto->precios as $precio) {
					   			$pre = Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento);
							}
							
							echo('<tr>');
							
							if($imagen){					  	
								$aaa = CHtml::image(Yii::app()->baseUrl . str_replace(".","_thumb.",$imagen->url), "Imagen ", array("width" => "150", "height" => "150",'class'=>'margin_bottom'));
								echo "<td>".$aaa."</td>";
							}else{
								echo"<td><img src='http://placehold.it/70x70'/ class='margin_bottom'></td>";
							}
	
							echo('<td><strong>'.$producto->nombre.'</strong> <br/>
		                  		<strong>'.Yii::t('contentForm', 'Color').'</strong>: '.$color->valor.'<br/>
		                  		<strong>'.Yii::t('contentForm', 'Size').'</strong>: '.$talla->valor.'</td>
		                  		</td>
		                <td>'.Yii::t('contentForm', 'currSym').' '.$pre.'</td>
		                <td>'.$cadauno->cantidad.'</td>
		              </tr>');		
						}
					}
				}


			echo '</tbody>
		          </table>
		          <hr/>
		          <p class="muted"><i class="icon-user"></i> '.Yii::t('contentForm', 'Created for').': <a href="#" title="ir al perfil">'.$look->user->profile->first_name.'</a></p>
		          </div>';	

			}
				
			}
			
			
		/*	
			 <h4 class="braker_bottom">Nombre del Look 1</h4>
        <div class="padding_left">
          <table class="table" width="100%" >
            <thead>
              <tr>
                <th colspan="2">Producto</th>
                <th>Precio por 
                  unidad </th>
                <th >Cantidad</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><img src="http://placehold.it/70x70"/ class="margin_bottom"></td>
                <td><strong>Vestido Stradivarius</strong> <br/>
                  <strong>Color</strong>: azul<br/>
                  <strong>Talla</strong>: M</td>
                  </td>
                <td >Bs. 3500</td>
                <td> 1</td>
              </tr>
              <tr>
                <td><img src="http://placehold.it/70x70"/ class="margin_bottom"></td>
                <td><strong>Vestido Stradivarius</strong> <br/>
                  <strong>Color</strong>: azul<br/>
                  <strong>Talla</strong>: M</td>
                  </td>
                <td >Bs. 3500</td>
                <td> 1</td>
              </tr>
            </tbody>
          </table>
          <hr/>
          <p class="muted"><i class="icon-user"></i> Creado por: <a href="#" title="ir al perfil">Nombre del personal shopper</a></p>
        </div>
        <!-- Look OFF --> 
        
			*/
		}
        
		if($ind!=0) // si hay individuales
		{
			echo "<h4 class='braker_bottom margin_top'></h4>
				        <div class='padding_left'>
				          <table class='table' width='100%' >
				            <thead>
				              <tr>
				                <th colspan='2'>".Yii::t('contentForm', 'Product')."</th>
				                <th>".Yii::t('contentForm', 'Unit price')."</th>
				                <th>".Yii::t('contentForm', 'Quantity')."</th>
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
							
				$imagen = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$producto->id,'color_id'=>$color->id));
				$contador=0;
								
				echo "<tr>";		
							
				if(isset($imagen)){
					foreach($imagen as $img) {
						if($contador==0){		 
							$aaa = CHtml::image(Yii::app()->baseUrl . str_replace(".","_thumb.",$img->url), "Imagen ", array("width" => "70", "height" => "70",'class'=>'margin_bottom'));
							echo "<td>".$aaa."</td>";
							$contador++;
						}
					}					  	
						
				
				}else
					echo"<td><img src='http://placehold.it/70x70'/ class='margin_bottom'></td>";

				echo "
					<td>
					<strong>".$producto->nombre."</strong> <br/>
					<strong>".Yii::t('contentForm', 'Color')."</strong>: ".$color->valor."<br/>
					<strong>".Yii::t('contentForm', 'Size')."</strong>: ".$talla->valor."</td>
					</td>
					";	
				
				// precio
				foreach ($producto->precios as $precio) {
					$pre = Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento);
				}
						
					echo "<td>".Yii::t('contentForm', 'currSym').' '.$pre."</td>";
					echo "<td>".$individual->cantidad."</td>
					</tr>";

			}
				
			}// foreach de productos		
		}// si hay indiv
		
        ?>
          </tbody>
          </table>
        </section>
        <hr/>
        <a href="../../tienda/index" class="btn btn-danger" title="Seguir Comprando"><?php echo Yii::t('contentForm', 'Keep buying'); ?></a> </div>
    </div>
  </div>
</div>
<!-- /container -->
<?php 

}// si esta logueado
else
{
	// redirecciona al login porque se murió la sesión
	header('Location: /user/login');	
}

?>

<!-- Modal Window -->
<?php 
$detPago = new Detalle;
$detPago->monto=0;
?>
<div class="modal hide fade" id="myModal">
  <?php $this->renderPartial('//orden/_modal_pago',array('orden_id'=>$orden->id)); ?>
</div>
<!-- <input type="hidden" id="idDetalle" value="<?php //echo($orden->detalle_id); ?>" /> -->

<!-- // Modal Window --> 

<script>
	
	function enviar(id)
	{	
		//var idDetalle = $("#idDetalle").attr("value");
		var nombre= $("#nombre").attr("value");
		var numeroTrans = $("#numeroTrans").attr("value");
		var dia = $("#dia").attr("value");
		var mes = $("#mes").attr("value");
		var ano = $("#ano").attr("value");
		var comentario = $("#comentario").attr("value");
		var banco = $("#banco").attr("value");
		var cedula = $("#cedula").attr("value");
		var monto = $("#monto").attr("value");

		if(nombre=="" || numeroTrans=="" || monto=="")
		{
			alert("Por favor complete los datos.");
		}
		else
		{

 		$.ajax({
	        type: "post", 
	        url: "<?php echo Yii::app()->createUrl('bolsa/cpago'); ?>", // action 
	        data: { 'nombre':nombre, 'numeroTrans':numeroTrans, 'dia':dia, 'mes':mes, 'ano':ano, 'comentario':comentario, 'banco':banco, 'cedula':cedula, 'monto':monto, 'idOrden':id}, 
	        success: function (data) {
				
				if(data=="ok")
				{
					window.location.reload();
					//alert("guardado"); 
					// redireccionar a donde se muestre que se ingreso el pago para luego cambiar de estado la orden 
				}
	       	}//success
	       })
 		}	
		
		
	}
	
</script>