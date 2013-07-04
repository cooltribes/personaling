<?php
Yii::import('application.components.*');
require_once "mercadopago-sdk/lib/mercadopago.php";
$mp = new MP ("8356724201817235", "vPwuyn89caZ5MAUy4s5vCVT78HYluaDk");
$mp->sandbox_mode(TRUE);
$accessToken = $mp->get_access_token();
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
	echo 'Total: '.$total.' - Descuento: '.$descuento;
?>

<div class="container margin_top">
  <div class="progreso_compra">
    <div class="clearfix margin_bottom">
      <div class="first-past">Autenticación</div>
      <div class="middle-past">Dirección<br/>
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
  <div class="row margin_top_medium">
    <section class="span4"> 
      <!-- Direcciones ON -->
      <div class="well">
        <h4 class="braker_bottom"> Dirección de Envio</h4>
        <?php 
        // direccion de envio 
        if(isset($tipoPago)){
        	echo 'Tipo pago: '.$tipoPago;
		}
        $direccion = Direccion::model()->findByPk(Yii::app()->getSession()->get('idDireccion'));
        ?>
        <p> <strong><?php echo($direccion->nombre." ".$direccion->apellido); ?></strong> <br/>
          <span class="muted small"> C.I. <?php echo($direccion->cedula); ?></span></p>
        <p><strong>Dirección:</strong> <br/>
          <?php echo($direccion->dirUno.". ".$direccion->dirDos.", ".$direccion->ciudad.", ".$direccion->estado.". ".$direccion->pais); ?> </p>
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
        </div>
      </div>
    </section>
    <section class="span4"> 
      <!-- Resumen de Productos ON -->
      <div class="well well_personaling_big">
        <h5><?php echo Yii::app()->getSession()->get('totalLook'); ?> Look seleccionado<br/>
          <?php  
           	if(Yii::app()->getSession()->get('totalProductosLook') != 0){
           		echo Yii::app()->getSession()->get('totalProductosLook')." productos que componen los Looks<br/>";
           	}
			
			echo Yii::app()->getSession()->get('totalIndiv')." Productos individuales " 
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
              <td><?php echo Yii::app()->getSession()->get('subtotal'); ?> Bs.</td>
            </tr>
            <tr>
              <th class="text_align_left">Envío:</th>
              <td><?php echo Yii::app()->getSession()->get('envio'); ?> Bs.</td>
            </tr>
            <tr>
              <th class="text_align_left">I.V.A. (12%):</th>
              <td><?php echo Yii::app()->getSession()->get('iva'); ?> Bs.</td>
            </tr>
            <tr>
              <th class="text_align_left">Descuento:</th>
              <td><?php echo Yii::app()->numberFormatter->formatDecimal($descuento);; ?> Bs.</td>
            </tr>
            <tr>
              <th class="text_align_left"><h4>Total:</h4></th>
              <td><h4><?php echo Yii::app()->numberFormatter->formatDecimal($total);; ?> Bs.</h4></td>
            </tr>
          </table>
          <?php
              if(Yii::app()->getSession()->get('tipoPago') == 4){
              	$user = User::model()->findByPk(Yii::app()->user->id);
				$profile = Profile::model()->findByPk(Yii::app()->user->id);
              	$preference = array (
				    "items" => array (
				        array (
				            "title" => "Look seleccionado + productos individuales",
				            "quantity" => 1,
				            "currency_id" => "VEF",
				            "unit_price" => $total
				            //"unit_price" => 23
				        )
				    ),
				    "payer" => array(
						"name" => $profile->first_name,
						"surname" => $profile->last_name,
						"email" => $user->email
					),
					"back_urls" => array(
						"success" => 'http://personaling.com'.Yii::app()->baseUrl.'/bolsa/successMP',
						"failure" => 'http://personaling.com'.Yii::app()->baseUrl.'/bolsa/successMP',
						"pending" => 'http://personaling.com'.Yii::app()->baseUrl.'/bolsa/successMP'
					),
				);
				$preferenceResult = $mp->create_preference($preference);
				?>
          <a href="<?php echo $preferenceResult['response']['sandbox_init_point']; ?>" name="MP-Checkout" class="blue-L-Rn-VeAll" mp-mode="modal">Pagar con MercadoPago</a>
          <?php
              }else{
              	?>
          <a onclick="enviar()" class="btn btn-warning"><i class="icon-locked icon-white"></i> Pago Trans/Dep</a>
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
   		var idDireccion = $("#idDireccion").attr("value");
		var tipoPago = $("#tipoPago").attr("value");
		var subtotal = $("#subtotal").attr("value");
		var descuento = $("#descuento").attr("value");
		var envio = $("#envio").attr("value");
		var iva = $("#iva").attr("value");
		var total = $("#total").attr("value");
		var usar_balance = $("#usar_balance").attr("value");

 		$.ajax({
	        type: "post",
	        dataType: 'json',
	        url: "comprar", // action 
	        data: { 'idDireccion':idDireccion, 'tipoPago':tipoPago, 'subtotal':subtotal, 'descuento':descuento, 'envio':envio, 'iva':iva, 'total':total, 'usar_balance':usar_balance}, 
	        success: function (data) {
				//console.log('Total: '+data.total+' - Descuento: '+data.descuento);
				if(data.status=="ok")
				{
					window.location="pedido/"+data.orden+"";
				}
	       	}//success
	       })
 			
	}
	
	function enviar_mp(json)
	{
		alert("return");
   		var idDireccion = $("#idDireccion").attr("value");
		var tipoPago = $("#tipoPago").attr("value");
		var subtotal = $("#subtotal").attr("value");
		var descuento = $("#descuento").attr("value");
		var envio = $("#envio").attr("value");
		var iva = $("#iva").attr("value");
		var total = $("#total").attr("value");

 		 if (json.collection_status=='approved'){
    alert ('Pago acreditado');
  } else if(json.collection_status=='pending'){
    alert ('El usuario no completó el pago');
    $.ajax({
	        type: "post",
	        dataType: 'json',
	        url: "comprar", // action 
	        data: { 'idDireccion':idDireccion, 'tipoPago':tipoPago, 'subtotal':subtotal, 'descuento':descuento, 'envio':envio, 'iva':iva, 'total':total, 'id_transaccion':json.collection_id}, 
	        success: function (data) {
				
				if(data.status=="ok")
				{
					window.location="pedido/"+data.orden+"";
				}
	       	}//success
	       })
  } else if(json.collection_status=='in_process'){    
    alert ('El pago está siendo revisado');    
    
  } else if(json.collection_status=='rejected'){
    alert ('El pago fué rechazado, el usuario puede intentar nuevamente el pago');
  } else if(json.collection_status==null){
    alert ('El usuario no completó el proceso de pago, no se ha generado ningún pago');
  }
 			
	}
	
</script> 
<script type="text/javascript">
	(function(){function $MPBR_load(){window.$MPBR_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;
	s.src = ("https:"==document.location.protocol?"https://www.mercadopago.com/org-img/jsapi/mptools/buttons/":"http://mp-tools.mlstatic.com/buttons/")+"render.js";
	var x = document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);window.$MPBR_loaded = true;})();}
	window.$MPBR_loaded !== true ? (window.attachEvent ? window.attachEvent('onload', $MPBR_load) : window.addEventListener('load', $MPBR_load, false)) : null;})();
</script> 
