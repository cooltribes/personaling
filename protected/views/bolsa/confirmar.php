<?php

if (!Yii::app()->user->isGuest) { // que este logueado

?>
<div class="container margin_top">
  <div class="row">
    <div class="span12">
      <div class="clearfix margin_bottom margin_top margin_left">
        <div class="first-done"></div>
        <div class="middle-done "></div>
        <div class="middle-done "></div>
        <div class="last-not_done"></div>
      </div>
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
  
  <div class="row margin_top_medium">
    <section class="span4"> 
      <!-- Direcciones ON -->
      <div class="well">
        <h4 class="braker_bottom"> Direccion de Envio</h4>
        <?php 
        // direccion de envio
        
        $direccion = Direccion::model()->findByPk(Yii::app()->getSession()->get('idDireccion'));
        ?>
        <p> <strong><?php echo($direccion->nombre." ".$direccion->apellido); ?></strong> <br/>
          <span class="muted small"> C.I. <?php echo($direccion->cedula); ?></span></p>
        <p><strong>Dirección:</strong> <br/>
          <?php echo($direccion->dirUno.". ".$direccion->dirDos.", ".$direccion->ciudad.", ".$direccion->estado.". ".$direccion->pais); ?>
        </p>
        <p> <strong>Telefono</strong>: 0276-341.47.12 <br/>
          <strong>Celular</strong>:   0414-724.80.43 </p>
        <!--  
        <h4 class="braker_bottom margin_top"> Direccion de Facturación de Forma de Pago</h4>
        <p> <strong>Johann Marquez</strong> <br/>
          <span class="muted small"> C.I. 14.941.873</span></p>
        <p> <strong>Telefono</strong>: 0276-341.47.12 <br/>
          <strong>Celular</strong>:   0414-724.80.43 </p>
        <p><strong>Dirección:</strong> <br/>
          Urbanizacion Las Acacias.
          Carrera 2. N 1-76
          San Cristobal, Tachira 5001
          Venezuela </p>
        -->
        <!-- Direcciones OFF --> 
        
      </div>
    </section>
    <section class="span4">
        <div class="well ">
          <h4>Metodo de Pago Seleccionado</h4>
          <div class=" margin_bottom">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
              <?php 
              	if(Yii::app()->getSession()->get('tipoPago')==1)
				{
					echo "<tr class='deptran'><td valign='top'><i class='icon-exclamation-sign'></i></td><td> Depósito o Transferencia Bancaria.</td></tr>";
				}
              ?>
            </table>
          </div>
        </div>
    </section>
    <section class="span4"> 
      <!-- Resumen de Productos ON -->
        <div class="well">
          <h5><?php //echo Yii::app()->getSession()->get('totalLook'); ?> Look seleccionado<br/>
           	<?php  
           	//if(Yii::app()->getSession()->get('totalLook') != 0){
           	//	echo "6 productos que componen los Looks<br/>";
           	//}
			
			echo Yii::app()->getSession()->get('totalIndiv')." Productos individuales " 
			?> 
		</h5>
          
          <hr/>
          <div class="row margin_bottom">
            <div class="span1">
			<?php  
          // 	if(Yii::app()->getSession()->get('totalLook') != 0){
			//	echo "Con la compra del Look completo Ahorras 184 Bs."; 
			//}
			?>
              </div>
            <div class="span2">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <th class="text_align_left">Subtotal:</th>
                  <td><?php echo Yii::app()->getSession()->get('subtotal'); ?> Bs.</td>
                </tr>
                <tr>
                  <th class="text_align_left">Descuento:</th>
                  <td><?php echo Yii::app()->getSession()->get('descuento'); ?> Bs.</td>
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
                  <th class="text_align_left"><h4>Total:</h4></th>
                  <td><h4><?php echo Yii::app()->getSession()->get('total'); ?>  Bs.</h4></td>
                </tr>
              </table>
              <?php 
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
			<a onclick="enviar()" class="btn btn-danger"><i class="icon-shopping-cart icon-white"></i> Pago Trans/Dep</a>
              <hr/>
               <?php
               	//<a href="pago_por_verificar.php" class="btn btn-danger"><i class="icon-shopping-cart icon-white"></i> Si ya hizo la Trans/Dep</a>
				//<hr/>
				?>
              <div class="alert">
              <!-- <strong>Ojo</strong>: a efectos del prototipo funcional será 1 sólo boton. Los 3 botones que estan aqui arriba llevan a paginas diferentes dependiendo del metodo de pago que haya elegido el usuario.
              -->
              </div>
              </div>
          </div>
          <p><i class="icon-calendar"></i> Fecha estimada de entrega: 00/00/2013 - 00/00/2013 </p>
        </div>
        <p><a href="#">Ver Politicas de Envios y Devoluciones</a></p>
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

 		$.ajax({
	        type: "post",
	        dataType: 'json',
	        url: "comprar", // action 
	        data: { 'idDireccion':idDireccion, 'tipoPago':tipoPago, 'subtotal':subtotal, 'descuento':descuento, 'envio':envio, 'iva':iva, 'total':total}, 
	        success: function (data) {
				
				if(data.status=="ok")
				{
					window.location="pedido/"+data.orden+"";
				}
	       	}//success
	       })
 			
	}
	
</script>
