<?php

//var_dump($accessToken);

if (!Yii::app()->user->isGuest) { // que este logueado
	$descuento = Yii::app()->getSession()->get('descuento');
	$total = Yii::app()->getSession()->get('total');
	if(Yii::app()->getSession()->get('usarBalance') == '1'){
		$balance = Yii::app()->db->createCommand(" SELECT SUM(total) as total FROM tbl_balance WHERE user_id=".Yii::app()->user->id." GROUP BY user_id ")->queryScalar();
		if($balance > 0){
			if($balance >= $total){
				$descuento = $total;
				$total = 0;
			}else{
				$descuento = $balance;
				$total = $total - $balance;
			}
		}
	}
	//echo 'Total: '.$total.' - Descuento: '.$descuento;
?>

<div class="container margin_top">
  <div class="progreso_compra">
    <div class="clearfix margin_bottom">

      <div class="first-past">Dirección<br/>
        de envío <br/>
        y facturación</div>
      <div class="middle-past">Método <br/>
        de pago</div>
      <div class="last-done">Confirmar<br/>
        compra</div>
    </div>
  </div>
  <div class="row">
    <div class="span12">
      <h1>Confirmación del Pedido</h1>
    </div>
  </div>
  <input type="hidden" id="idDireccion" value="<?php echo(Yii::app()->getSession()->get('idDireccion')); ?>" />
  <input type="hidden" id="tipoPago" value="<?php echo(Yii::app()->getSession()->get('tipoPago')); ?>" />
  <input type="hidden" id="subtotal" value="<?php echo(Yii::app()->getSession()->get('subtotal')); ?>" />
  <input type="hidden" id="descuento" value="<?php echo(Yii::app()->getSession()->get('descuento')); ?>" />
  <input type="hidden" id="envio" value="<?php echo(Yii::app()->getSession()->get('envio')); ?>" />
  <input type="hidden" id="iva" value="<?php echo(Yii::app()->getSession()->get('iva')); ?>" />
  <input type="hidden" id="total" value="<?php echo(Yii::app()->getSession()->get('total')); ?>" />
  <input type="hidden" id="usar_balance" value="<?php echo(Yii::app()->getSession()->get('usarBalance')); ?>" />
  <input type="hidden" id="seguro" value="<?php echo(Yii::app()->getSession()->get('seguro')); ?>" />
  <input type="hidden" id="tipo_guia" value="<?php echo(Yii::app()->getSession()->get('tipo_guia')); ?>" />
  <!-- <input type="hidden" id="idCard" value="0" /> -->

  <div class="row margin_top_medium">
    <section class="span4"> 
      <!-- Direcciones ON -->
      <div class="well">
        <h4 class="braker_bottom"> Dirección de Envio</h4>
        <?php //echo('tipo guia: '.Yii::app()->getSession()->get('tipo_guia')); ?>
        <?php 
        // direccion de envio 
        if(isset($tipoPago)){
        	//echo 'Tipo pago: '.$tipoPago;
		}
       
        $direccion = Direccion::model()->findByPk(Yii::app()->getSession()->get('idDireccion'));
		
		$ciudad = Ciudad::model()->findByPk($direccion->ciudad_id);
        ?>
        <p> <strong><?php echo($direccion->nombre." ".$direccion->apellido); ?></strong> <br/>
          <span class="muted small"> C.I. <?php echo($direccion->cedula); ?></span></p>
        <p><strong>Dirección:</strong> <br/>
          <?php echo($direccion->dirUno.". ".$direccion->dirDos.", ".$ciudad->nombre.", ".$ciudad->provincia->nombre.". ".$direccion->pais); ?> </p>
        <p> <strong>Telefono</strong>: <?php echo($direccion->telefono); ?> <br/>
        </p>
        
        <!-- Direcciones OFF --> 
        
      </div>
    </section>
    <section class="span4">
      <div class="well ">
        <h4>Método de Pago Seleccionado</h4>
        <div class=" margin_bottom">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
            <?php 
              	if(Yii::app()->getSession()->get('tipoPago')==1)
				{
					echo "<tr class='deptran'><td valign='top'><i class='icon-exclamation-sign'></i> Depósito o Transferencia Bancaria.</td></tr>";
				}else if(Yii::app()->getSession()->get('tipoPago')==4){
					echo "<tr class='mp'><td valign='top'><i class='icon-exclamation-sign'></i> Mercadopago.</td></tr>";
				}else if(Yii::app()->getSession()->get('tipoPago')==2){
					echo "<tr class='mp'><td valign='top'><i class='icon-exclamation-sign'></i> Tarjeta de Crédito.</td></tr>";
				}
              ?>
          </table>
          <?php
          		$ptcs = explode(',',Yii::app()->session['ptcs']);
						$vals= explode(',',Yii::app()->session['vals']);
						$totalPr=0;
						$i=0;
                      	foreach ($ptcs as $ptc) {
							$obj=Preciotallacolor::model()->findByPk($ptc);
							$art=Producto::model()->findByPk($obj->producto_id);
							echo $art->nombre."<br/>";
								//echo $totalPr;
						 }
          ?>
        </div>
      </div>
    </section>
    <section class="span4"> 
      <!-- Resumen de Productos ON -->
      <div class="well well_personaling_big">
        <h5>Look seleccionado(s): <?php echo Yii::app()->getSession()->get('totalLook'); ?><br/>
          <?php  
           	if(Yii::app()->getSession()->get('totalProductosLook') != 0){
           		echo Yii::app()->getSession()->get('totalProductosLook')." productos que componen los Looks<br/>";
           	}
			
			echo 'Productos individuales: '.Yii::app()->getSession()->get('totalIndiv');
			?>
        </h5>
        <hr/>
        <div class="margin_bottom">
          <?php  
          // 	if(Yii::app()->getSession()->get('totalLook') != 0){
			//	echo "Con la compra del Look completo Ahorras 184 Bs."; 
			//}
			?>
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed ">
            <tr>
              <th class="text_align_left">Subtotal:</th>
              <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency(Yii::app()->getSession()->get('subtotal'), ''); ?></td>
            </tr>
            <tr>
              <th class="text_align_left">Envío:</th>
              <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency(Yii::app()->getSession()->get('envio')+Yii::app()->getSession()->get('seguro'), ''); ?></td>
            </tr>
            <tr>
              <th class="text_align_left">I.V.A. (12%):</th>
              <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency(Yii::app()->getSession()->get('iva'), ''); ?></td>
            </tr>
            <?php if($descuento != 0){ // si no hay descuento ?> 
            <tr>
              <th class="text_align_left">Descuento:</th>
              <td><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($descuento, ''); ?></td>
           	</tr>
           	<?php } ?>
            <tr>
              <th class="text_align_left"><h4>Total:</h4></th>
              <td><h4><?php echo 'Bs. '.Yii::app()->numberFormatter->formatCurrency($total, ''); ?></h4></td>
            </tr>
          </table>
        
         
          <?php
               if(Yii::app()->getSession()->get('tipoPago') == 2){ // tarjeta
              			
					 echo CHtml::link("<i class='icon-locked icon-white'></i> Pagar con tarjeta de crédito",
					    $this->createUrl('modal',array('id'=>'pago')),
					    array(// for htmlOptions
					      'onclick'=>' { $("#pago").attr("disabled", true); '.CHtml::ajax( array(
					      'url'=>CController::createUrl('modal',array('tipo'=>"2")),
					           'success'=>"js:function(data){ $('#myModal').html(data);
										$('#myModal').modal(); }")).
					         'return false;}',
					    'class'=>'btn btn-warning',
					    'id'=>'pago')
					);	

				}
				else {
              	?>
          			<a id="boton_completar" onclick="enviar()" class="btn btn-warning"><i class="icon-locked icon-white"></i> Completar compra</a>
          			<hr/>
          		<?php
              	}
              //<a href="confirmacion_compra.php" class="btn btn-danger"><i class="icon-shopping-cart icon-white"></i> Realizar Pago (TDC)</a> 
              //<hr/>
			  ?>
          <?php /*$this->widget('bootstrap.widgets.TbButton', array(
            'type'=>'danger',
            'size'=>'large',
            'label'=>'Pagar',
            'url'=>'comprar', // action
            'icon'=>'shopping-cart white',
        )); 
        // <a href="Instrucciones_Deposito_Transferencia.php" class="btn btn-danger"><i class="icon-shopping-cart icon-white"></i> Pago Trans/Dep</a>
		   * */
		   
        ?>
          <?php
               	//<a href="pago_por_verificar.php" class="btn btn-danger"><i class="icon-shopping-cart icon-white"></i> Si ya hizo la Trans/Dep</a>
				//<hr/>
				?>
        </div>
        <p><i class="icon-calendar"></i> Fecha estimada de entrega: <br/><?php echo date("d/m/Y"); ?> - <?php echo date('d/m/Y', strtotime('+1 week'));  ?> </p>
      </div>
      <p><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/politicas_de_devoluciones" title="Políticas de Envios y Devoluciones" target="_blank">Ver Políticas de Envíos y Devoluciones</a></p>
      <p class="muted"><i class="icon-comment"></i> Contacta con un Asesor de Personaling para recibir ayuda: De Lunes a Viernes de 8:30 am a 5:00 pm</p>
      
      <!-- Resumen de Productos OFF --> 
      
    </section>
  </div>
</div>
<!-- /container -->

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal','htmlOptions'=>array('class'=>'modal_grande hide fade','tabindex'=>'-1','role'=>'dialog','aria-labelleby'=>'myModalLabel','aria-hidden'=>'true'))); ?>

<?php $this->endWidget(); ?>

<?php 

}// si esta logueado
else
{
	// redirecciona al login porque se murió la sesión
	header('Location: /site/user/login');	
}


?>
<script>
	
	function enviar()
	{
		$('#boton_completar').attr("disabled", true);
   		var idDireccion = $("#idDireccion").attr("value");
		var tipoPago = $("#tipoPago").attr("value");
		var subtotal = $("#subtotal").attr("value");
		var descuento = $("#descuento").attr("value");
		var envio = $("#envio").attr("value");
		var iva = $("#iva").attr("value");
		var total = $("#total").attr("value");
		var usar_balance = $("#usar_balance").attr("value");
		var seguro = $("#seguro").attr("value");
		var tipo_guia = $("#tipo_guia").attr("value");

 		$.ajax({
	        type: "post",
	        dataType: 'json',
	        url: "comprafin", // action 
	        data: { 'idDireccion':idDireccion, 'tipoPago':tipoPago, 'subtotal':subtotal, 'descuento':descuento, 'envio':envio, 'iva':iva, 'total':total, 'usar_balance':usar_balance, 'seguro':seguro, 'tipo_guia':tipo_guia}, 
	        success: function (data) {
				//console.log('Total: '+data.total+' - Descuento: '+data.descuento);
				if(data.status=="ok")
				{	window.location="<?php echo $this->createUrl('../orden/detalles') ?>/"+data.orden+"";
				}else if(data.status=='error'){
					//console.log(data.error);
				}else{}
	       	}//success
	       })
 			
	}
	
	function enviarTarjeta()
	{
		$('#boton_pago_tarjeta').attr("disabled", true);
		
   		var idDireccion = $("#idDireccion").attr("value");
		var tipoPago = $("#tipoPago").attr("value");
		var subtotal = $("#subtotal").attr("value");
		var descuento = $("#descuento").attr("value");
		var envio = $("#envio").attr("value");
		var iva = $("#iva").attr("value");
		var total = $("#total").attr("value");
		var seguro = $("#seguro").attr("value");
		var usar_balance = $("#usar_balance").attr("value");
		var tipo_guia = $("#tipo_guia").attr("value");
		
		/* lo de la tarjeta */
		
		var idCard = $("#idTarjeta").attr("value"); // por ahora siempre 0, luego deberia ser el id del escogido
		var nom = $("#nombre").attr("value");
		var num = $("#numero").attr("value");
		var cod = $("#codigo").attr("value");
		var mes = $("#mes").attr("value");
		var ano = $("#ano").attr("value");
		var dir = $("#direccion").attr("value");
		var ciud = $("#ciudad").attr("value");
		var est = $("#estado").attr("value");
		var zip = $("#zip").attr("value");
		
		if(idCard=="0") // si no se eligió tarjeta sino que escribio los datos de una nueva tarjeta
		{
			if(nom=="" || num=="" || cod=="" || mes=="Mes" || ano=="Ano")
			{
				alert("Por favor complete los datos.");
			}
			else
			{
			
			//alert("idCard: "+idCard+" nombre: "+nom+", numero"+num+", cod:"+cod+", mes y año "+mes+"-"+ano+", dir "+dir+", ciudad "+ciud+", estado "+est+", zip"+zip);
			
				$.ajax({
		        type: "post",
		        dataType: 'json',
		        url: "credito", // action 
		        data: { 'tipoPago':tipoPago, 'total':total, 'idCard':idCard,'nom':nom,'num':num,'cod':cod,
		        		'mes':mes,'ano':ano,'dir':dir,'ciud':ciud, 'est':est,'zip':zip
		        		}, 
		        success: function (data) {
					
					if(data.status==201) // pago aprobado
					{
						
						$.ajax({
					        type: "post",
					        dataType: 'json',
					        url: "comprar", // action 
					        data: { 'idDireccion':idDireccion, 'tipoPago':tipoPago, 'subtotal':subtotal,
					        		'descuento':descuento, 'envio':envio, 'iva':iva, 'total':total,
					        		'usar_balance':usar_balance, 'idDetalle':data.idDetalle,'seguro':seguro,'tipo_guia':tipo_guia
					        		}, 
					        success: function (data) {
								if(data.status=="ok")
								{
									window.location="pedido/"+data.orden+"";
								}
					       	}//success
					      })
					}
					else
					{
						// no pasó la tarjeta
						
						if(data.status==400)
						{
							if(data.mensaje=="Credit card has Already Expired"){
								//alert('La tarjeta que intentó usar ya expiró.');
								window.location="error/1";
							}

							if(data.mensaje=="The CardNumber field is not a valid credit card number."){
								//alert('El número de tarjeta que introdujó no es un número válido.');
								window.location="error/2";
							}
						}
						
						if(data.status==401)
						{
							//alert('error de autenticacion');
							window.location="error/3";
						}
						
						if(data.status==403)
						{
							//alert('No pudimos completar su operación: '+data.mensaje);
							window.location="error/5";
						}
						
						if(data.status==503)
						{
							//alert('error interno');
							window.location="error/4";
						}
					}
					
		       	}//success
		       })
			
			}
		}
		else
		{
			
			$.ajax({
		        type: "post",
		        dataType: 'json',
		        url: "credito", // action 
		        data: { 'tipoPago':tipoPago, 'total':total, 'idCard':idCard }, 
		        success: function (data) {
					
					if(data.status==201) // pago aprobado
					{
						
						$.ajax({
					        type: "post",
					        dataType: 'json',
					        url: "comprar", // action 
					        data: { 'idDireccion':idDireccion, 'tipoPago':tipoPago, 'subtotal':subtotal,
					        		'descuento':descuento, 'envio':envio, 'iva':iva, 'total':total,
					        		'usar_balance':usar_balance, 'idDetalle':data.idDetalle,'seguro':seguro,'tipo_guia':tipo_guia
					        		}, 
					        success: function (data) {
								if(data.status=="ok")
								{
									window.location="pedido/"+data.orden+"";
								
								}
					       	}//success
					      })
					}
					else
					{
						// no pasó la tarjeta			
						if(data.status==400){
							
							if(data.mensaje=="Credit card has Already Expired"){
								//alert('La tarjeta que intentó usar ya expiró.');
								window.location="error/1";
							}

							if(data.mensaje=="The CardNumber field is not a valid credit card number."){
								//alert('El número de tarjeta que introdujó no es un número válido.');
								window.location="error/2";
							}
						}
						
						if(data.status==401){
							//alert('error de autenticacion');
							window.location="error/3";
						}
						
						if(data.status==403){
							//alert('No pudimos completar su operación: '+data.mensaje);
							window.location="error/5";
						}
						
						if(data.status==503){
							//alert('error interno');
							window.location="error/4";
						}
					}
					
		       	}//success
		       })
				
		}
	
	}
	
</script> 

