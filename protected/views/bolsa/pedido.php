<?php

if (!Yii::app()->user->isGuest) { // que este logueado

$user = User::model()->findByPk(Yii::app()->user->id);
$pago = Pago::model()->findByAttributes(array('id'=>$orden->pago_id));
//echo $orden->pago_id;

?>

<div class="container margin_top">
<div class="row">
  <div class="span8 offset2">
    <?php
      
      if($orden->estado==1) // pendiente de pago
	  {
	  	if($pago->tipo == 1){
	      ?>
    <div class="alert alert-success margin_top_medium margin_bottom">
      <h1>Tu Pedido ha sido recibido con éxito.</h1>
      <p> A continuación encontrarás las instrucciones para completar tu compra. (También las hemos enviado a tu correo electrónico: <?php echo $user->email; ?>)</p>
    </div>
    <section class="bg_color3 margin_bottom_small padding_small box_1">
      <h2>Siguiente paso</h2>
      <hr/>
      <p><strong>Para completar tu comprar debes:</strong></p>
      <ol>
        <li> <strong>Realizar el pago</strong>: de Bs. <?php echo Yii::app()->numberFormatter->formatCurrency($orden->total, ''); ?> via transferencia electrónica o depósito bancario antes del <?php echo date('d-m-Y H:i:s', strtotime($orden->fecha. ' + 3 days')); ?> en la siguiente cuenta bancaria: <br>
          <br>
          <ul class="margin_bottom_medium">
            <li><strong>Cuenta Corriente Nº:</strong> 0134-0277-98-2771093092</li>
            <li><strong>Titular de la cuenta: </strong>PERSONALING C.A.</li>
            <li><strong>RIF:</strong> Nº J-40236088-6</li>
            <li><strong>Correo electrónico:</strong> ventas@personaling.com</li>
          </ul>
        </li>
        <li class="margin_bottom_medium"><strong>Registra tu pago</strong>: a través del link enviado a tu correo ó ingresa a Tu Cuenta - > Tus Pedidos,  selecciona el pedido que deseas Pagar y la opción Registrar Pago.</li>
        <li class="margin_bottom_medium"><strong>Proceso de validación: </strong>usualmente toma de 1 y 5 días hábiles y consiste en validar tu transferencia o depósito con nuestro banco. Puedes consultar el status de tu compra en tu perfil.</li>
        <li><strong>Envio:</strong> Luego de validar el pago te enviaremos el producto :)</li>
      </ol>
      <hr/>
      <div class="clearfix">
        <div class="pull-left"><a onclick="window.print();" class="btn"><i class="icon-print"></i> Imprime estas instrucciones</a></div>
    <div class="pull-right"> Si ya has realizado el deposito <a href="#myModal" role="button" class="btn btn-mini" data-toggle="modal" >haz click aqui</a></div> 
      </div>
    </section>
    <?php
      	}else if($pago->tipo == 4){
      		?>
    <div class="alert alert-success margin_top_medium margin_bottom">
      <h1>Tu Pedido ha sido recibido con éxito.</h1>
      <p> A continuación encontrarás las instrucciones para completar tu compra. (También las hemos enviado a tu correo electrónico: <?php echo $user->email; ?>)</p>
    </div>
    <section class="bg_color3 margin_bottom_small padding_small box_1">
    <h2>Siguiente paso</h2>
    <hr/>
    <p><strong>Para completar tu comprar debes:</strong></p>
    <ol>
      <li> <strong>Realizar el pago</strong>: de Bs. <?php echo Yii::app()->numberFormatter->formatCurrency($orden->total, ''); ?> via MercadoPago. <br>
      </li>
      <li><strong>Registra tu pago</strong>: a través del sistema MercadoPago.</li>
      <li><strong>Proceso de validación: </strong>usualmente toma de 1 y 5 días hábiles y consiste en validar tu pago.</li>
      <li><strong>Envio:</strong> Luego de validar el pago te enviaremos el producto :)</li>
    </ol>
    <hr/>
    <div class="clearfix">
      <div class="pull-left"><a onclick="window.print();" class="btn"><i class="icon-print"></i> Imprime estas instrucciones</a></div>
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
          <h1>Pedido en proceso</h1>
          <p>Hemos recibido los datos de pedido asi como de tu pago con transferencia o depósito bancario</p>
        </div>
         
        <p>Estaremos verificando la transferencia o depósito en los próximos 2 a 3 días hábiles y te notificaremos cuándo haya sido aprobado</p>
	  	</section>
	  	";
		
	  }
	  
	  if($orden->estado==3) // Listo el pago
	  {
	  	echo "
	  	
	  	<div class='alert alert-success margin_top_medium margin_bottom'>
	      <h1>Tu Pedido ha sido recibido con éxito.</h1>
	     	<p>Hemos recibido los datos de pedido asi como los de tu pago con tarjeta de credito.<br/>
	     	Tu pedido será enviado en las próximas horas.</p>
	    </div>

	  	";
		
	  }
      
      ?>
        <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
          <h3>Resumen del pedido </h3>
          <p class="well well-small"><strong>Número de confirmación:</strong> <?php echo $orden->id; ?></p>
          <p> <strong>Fecha estimada de entrega</strong>: <?php echo date("d/m/Y",strtotime($orden->fecha)); ?> - <?php echo  date('d/m/Y', strtotime($orden->fecha.'+1 week')); ?></p>
          <hr/>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <th class="text_align_left">Subtotal:</th>
              <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($orden->subtotal, ''); ?></td>
            </tr>
            <?php if($orden->descuento != 0){ // si no hay descuento ?> 
            <tr>
              <th class="text_align_left">Descuento:</th>
              <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($orden->descuento, ''); ?></td>
            </tr>
            <?php } ?>            
            <tr>
              <th class="text_align_left">Envío:</th>
              <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($orden->envio + $orden->seguro, ''); ?></td>
            </tr>
            <tr>
              <th class="text_align_left">I.V.A. (12%):</th>
              <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($orden->iva, ''); ?></td>
            </tr>            
            <tr>
              <th class="text_align_left"><h4>Total:</h4></th>
              <td><h4><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($orden->total, ''); ?></h4></td>
            </tr>
          </table>
          <hr/>
          <p>Hemos enviado un resumen de la compra a tu correo electrónico: <strong><?php echo $user->email; ?></strong> </p>
          <?php
        
        $s1 = "select count( * ) as total from tbl_orden_has_productotallacolor where look_id != 0 and tbl_orden_id = ".$orden->id."";
		$look = Yii::app()->db->createCommand($s1)->queryScalar();
        
		$s2 = "select count( * ) as total from tbl_orden_has_productotallacolor where look_id = 0 and tbl_orden_id = ".$orden->id."";
		$ind = Yii::app()->db->createCommand($s2)->queryScalar();
			
        ?>
          <h3 class="margin_top">Detalles del Pedido</h3>
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
	                <th colspan="2">Producto</th>
	                <th>Precio por 
	                  unidad </th>
	                <th >Cantidad</th>
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
		                  		<strong>Color</strong>: '.$color->valor.'<br/>
		                  		<strong>Talla</strong>: '.$talla->valor.'</td>
		                  		</td>
		                <td>Bs. '.$pre.'</td>
		                <td>'.$cadauno->cantidad.'</td>
		              </tr>');		
						}
					}
				}


			echo '</tbody>
		          </table>
		          <hr/>
		          <p class="muted"><i class="icon-user"></i> Creado por: <a href="#" title="ir al perfil">'.$look->user->profile->first_name.'</a></p>
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
				                <th colspan='2'>Producto</th>
				                <th>Precio por 
				                  unidad </th>
				                <th >Cantidad</th>
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
					<strong>Color</strong>: ".$color->valor."<br/>
					<strong>Talla</strong>: ".$talla->valor."</td>
					</td>
					";	
				
				// precio
				foreach ($producto->precios as $precio) {
					$pre = Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento);
				}
						
					echo "<td>Bs. ".$pre."</td>";
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
        <a href="../../tienda/index" class="btn btn-danger" title="seguir comprando">Seguir comprando</a> </div>
    </div>
  </div>
</div>
<!-- /container -->
<?php 

}// si esta logueado
else
{
	// redirecciona al login porque se murió la sesión
	header('Location: /site/user/login');	
}

?>

<!-- Modal Window -->
<?php 
$detPago = Detalle::model()->findByPk($orden->detalle_id);
?>
<div class="modal hide fade" id="myModal">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4>Agregar Depósito o Transferencia bancaria ya realizada</h4>
  </div>
  <div class="modal-body">
    <form class="">
      <div class="control-group"> 
        <!--[if lte IE 7]>
            <label class="control-label required">Nombre del Depositante <span class="required">*</span></label>
<![endif]-->
        <div class="controls"> <?php echo CHtml::activeTextField($detPago,'nombre',array('id'=>'nombre','class'=>'span5','placeholder'=>'Nombre del Depositante')); ?>
          <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
        </div>
      </div>
      <div class="control-group"> 
        <!--[if lte IE 7]>
            <label class="control-label required">Número o Código del Depósito<span class="required">*</span></label>
<![endif]-->
        <div class="controls"> <?php echo CHtml::activeTextField($detPago,'nTransferencia',array('id'=>'numeroTrans','class'=>'span5','placeholder'=>'Número o Código del Depósito')); ?>
          <div style="display:none" class="help-inline"></div>
        </div>
      </div>
      <div class="control-group"> 
        <!--[if lte IE 7]>
            <label class="control-label required">Nombre del Depositante <span class="required">*</span></label>
<![endif]-->
    <div class="controls">   <!--  <?php echo CHtml::activeTextField($detPago,'banco',array('id'=>'banco','class'=>'span5','placeholder'=>'Banco donde se realizó el deposito')); ?>-->
       	 <?php echo CHtml::activeDropDownList($detPago,'banco',array('Seleccione'=>'Seleccione','Banesco'=>'Banesco. Cuenta: 0134 0277 98 2771093092'),array('id'=>'banco','class'=>'span5')); ?>
          <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
        </div>
      </div>
      <div class="control-group"> 
        <!--[if lte IE 7]>
            <label class="control-label required">Nombre del Depositante <span class="required">*</span></label>
<![endif]-->
        <div class="controls"> <?php echo CHtml::activeTextField($detPago,'cedula',array('id'=>'cedula','class'=>'span5','placeholder'=>'Cedula del Depositante')); ?>
          <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
        </div>
      </div>
      <div class="control-group"> 
        <!--[if lte IE 7]>
            <label class="control-label required">Nombre del Depositante <span class="required">*</span></label>
<![endif]-->
        <div class="controls"> <?php echo CHtml::activeTextField($detPago,'monto',array('id'=>'monto','class'=>'span5','placeholder'=>'Monto')); ?>
          <div style="display:none" id="RegistrationForm_email_em_" class="help-inline"></div>
        </div>
      </div>
      <div class="controls controls-row"> 
        <!--[if lte IE 7]>
            <label class="control-label required">Fecha del depósito DD/MM/YYY<span class="required">*</span></label>
<![endif]--> 
        <?php echo CHtml::TextField('dia','',array('id'=>'dia','class'=>'span1','placeholder'=>'Día')); ?> <?php echo CHtml::TextField('mes','',array('id'=>'mes','class'=>'span1','placeholder'=>'Mes')); ?> <?php echo CHtml::TextField('ano','',array('id'=>'ano','class'=>'span2','placeholder'=>'Año')); ?> </div>
      <div class="control-group"> 
        <!--[if lte IE 7]>
            <label class="control-label required">Comentarios (Opcional) <span class="required">*</span></label>
<![endif]-->
        <div class="controls"> <?php echo CHtml::activeTextArea($detPago,'comentario',array('id'=>'comentario','class'=>'span5','rows'=>'6','placeholder'=>'Comentarios (Opcional)')); ?>
          <div style="display:none" class="help-inline"></div>
        </div>
      </div>
      <div class="form-actions"> <a onclick="enviar(<?php echo $orden->id ?>)" class="btn btn-danger">Confirmar Deposito</a> </div>
      <p class="well well-small"> <p class='text_align_center'><a title='Formas de Pago' href='<?php echo Yii::app()->baseUrl."/site/formas_de_pago";?>'> Terminos y Condiciones de Recepcion de pagos por Deposito y/o Transferencia</a><br/></p>
      </p>
    </form>
  </div>
</div>
<input type="hidden" id="idDetalle" value="<?php echo($orden->detalle_id); ?>" />

<!-- // Modal Window --> 

<script>
	
	function enviar(id)
	{	
		var idDetalle = $("#idDetalle").attr("value");
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
	        url: "../cpago", // action 
	        data: { 'nombre':nombre, 'numeroTrans':numeroTrans, 'dia':dia, 'mes':mes, 'ano':ano, 'comentario':comentario, 'idDetalle':idDetalle, 'banco':banco, 'cedula':cedula, 'monto':monto, 'idOrden':id}, 
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