<?php
Yii::app()->clientScript->registerLinkTag('stylesheet','text/css','https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700',null,null);
Yii::import('application.components.*');
require_once "mercadopago-sdk/lib/mercadopago.php";

/*Aztive Pay Class*/
//Yii::import('application.ext.AzPayClass.php');

 
$mp = new MP ("8356724201817235", "vPwuyn89caZ5MAUy4s5vCVT78HYluaDk");
$mp->sandbox_mode(TRUE);
//$accessToken = $mp->get_access_token();
//var_dump($accessToken);
$cs=Yii::app()->clientScript;
$cs->registerScript('submit','
$(":submit").mouseup(function() {
        $(this).attr("disabled",true);
        $(this).parents("form").submit();
})',CClientScript::POS_READY);

if (!Yii::app()->user->isGuest) { // que este logueado
	$descuento = Yii::app()->getSession()->get('descuento');
	$total = Yii::app()->getSession()->get('total');
	if(Yii::app()->getSession()->get('usarBalance') == '1'){
		$balance = User::model()->findByPK($user)->saldo;
		$balance = floor($balance *100)/100; 
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
        
if($total == 0){
    Yii::app()->getSession()->add('tipoPago', 7); //pagar la orden totalmente con saldo
}
Yii::app()->getSession()->add('total_tarjeta',$total);	
	
?>

<div class="container margin_top">
  <div class="progreso_compra">
    <div class="clearfix margin_bottom">
      <div class="first-past"><?php echo Yii::t('contentForm','Authentication'); ?></div>
      <div class="middle-past dos">
        <?php echo Yii::t('contentForm','Shipping <br/>and billing<br/> address'); ?>
      </div>
      <div class="middle-past tres">
        <?php echo Yii::t('contentForm','Payment <br> method'); ?>
      </div>
      <div class="last-done">
        <?php echo Yii::t('contentForm','Confirm <br>purchase'); ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="span12">
      <h1><?php echo Yii::t('contentForm','Order confirmation'); ?>
          <br>
          <?php 
              $userObject = User::model()->findByPk($user);
              $nombre = $userObject ? $userObject->profile->first_name." ".$userObject->profile->last_name:
                        "";
               if($admin){
                  echo "(Usuario: <b>{$nombre}</b>)"; 
               }

          ?>
      
      </h1>
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
  <input type="hidden" id="peso" value="<?php echo(Yii::app()->getSession()->get('peso')); ?>" />
  <input type="hidden" id="tarjeta" value="<?php echo(Yii::app()->getSession()->get('idTarjeta')); ?>" />
  <!-- <input type="hidden" id="idCard" value="0" /> -->

  <div class="row margin_top_medium">
      <section class="span4">
      <div class="well ">
        <h4 class="braker_bottom"><?php echo Yii::t('contentForm','Order Details'); ?></h4>
        <form id="form_productos">          
          <!-- Look ON -->
          <!--<h3 class="braker_bottom">Productos Individuales</h3>-->
          <div>
            <table class="table" width="100%" >
              <thead>
                <tr>
                  <th><?php echo Yii::t('contentForm','Product'); ?></th>
                  <th><?php echo Yii::t('contentForm','Unit price'); ?></th>
                  <th><?php echo Yii::t('contentForm','Quantity'); ?></th>
                </tr>
              </thead>
              <tbody>
                <?php      
                            
		$bptcolor = BolsaHasProductotallacolor::model()->findAllByAttributes(array('bolsa_id'=>$bolsa->id));		  
	          foreach($bptcolor as $productoBolsa) // cada producto en la bolsa
                    {
                        $todo = Preciotallacolor::model()->findByPk($productoBolsa->preciotallacolor_id);

                        $producto = Producto::model()->findByPk($todo->producto_id);
                        $talla = Talla::model()->findByPk($todo->talla_id);
                        $color = Color::model()->findByPk($todo->color_id);

                        // $imagen = CHtml::image($producto->getImageUrl($todo->color_id), "Imagen", array("width" => "70", "height" => "70"));

                        echo "<tr>";
//                        $imagen = Imagen::model()->findAllByAttributes(array('tbl_producto_id'=>$producto->id,'color_id'=>$color->id));
//                        if($imagen){
//
//                            $con = 0;
//
//                            foreach($imagen as $ima){
//                                    if($con == 0){	
//                                            $con++;						  	
//                                            $aaa = CHtml::image(Yii::app()->baseUrl . str_replace(".","_x180.",$ima->url), "Imagen ", array("width" => "150", "height" => "150",'class'=>'margin_bottom'));
//                                            echo "<td>".$aaa."</td>";
//                                    }
//                            }
//                        }else
//                            echo"<td><img src='http://placehold.it/70x70'/ class='margin_bottom'></td>";

                        echo "
                        <td>"
                        .$producto->nombre." ".$producto->id."<br/>
                        <strong>Color</strong>: ".$color->valor."<br/>
                        <strong>Talla</strong>: ".$talla->valor."</td>
                        ";	

                        $pre="";
                        foreach ($producto->precios as $precio) {
                        $pre = Yii::app()->numberFormatter->formatDecimal($precio->precioDescuento);


                        }



                        echo "<td style='width:26%'>".Yii::t('contentForm','currSym')." ".$pre."</td>";
                    ?>

              <td width='8%' style="text-align: center">
                      <?php echo $productoBolsa->cantidad; ?>              
                    </td>
            
            </tr>

            <?php
                }// foreach							  
            ?>
              </tbody>
            </table>
          </div>
          <!-- Look OFF -->		
          
        </form>
      </div>
    </section>
    <section class="span4"> 
      <!-- Direcciones ON -->
      <div class="well">
             <h4><?php echo Yii::t('contentForm','Payment Method Selected'); ?></h4>
        <div class=""> 
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table">
            <?php             
              	if(Yii::app()->getSession()->get('tipoPago')==1)
                {
                    echo "<tr class='deptran'><td valign='top'><i class='icon-exclamation-sign'></i> ".Yii::t('contentForm','Deposit or Bank Transference').".</td></tr>";
                }else if(Yii::app()->getSession()->get('tipoPago')==4){
                    echo "<tr class='mp'><td valign='top'><i class='icon-exclamation-sign'></i> ".Yii::t('contentForm','MercadoPago').".</td></tr>";
                }else if(Yii::app()->getSession()->get('tipoPago')==2){
                    echo "<tr class='mp'><td valign='top'><i class='icon-exclamation-sign'></i> ".Yii::t('contentForm','Credit Card').".</td></tr>";

                    $tarjeta = TarjetaCredito::model()->findByPk($idTarjeta);

                    $rest = substr($tarjeta->numero, -4);

                    echo "</br>".Yii::t('contentForm','Name').": ".$tarjeta->nombre."
                    </br>".Yii::t('contentForm','Number').": XXXX XXXX XXXX ".$rest."
                    </br>".Yii::t('contentForm','Expiration').": ".$tarjeta->vencimiento;
                    
                    
                }else if(Yii::app()->getSession()->get('tipoPago') == 5){
                    
                    echo "<tr><td valign='top'><i class='icon-exclamation-sign'></i> ".
                            Yii::t('contentForm','Credit Card').".</td></tr>";
                
                    
                }else if(Yii::app()->getSession()->get('tipoPago') == 6){
                    
                    echo "<tr><td valign='top'><i class='icon-exclamation-sign'></i> ".
                            Yii::t('contentForm','PayPal').".</td></tr>";                    
                
                }else if(Yii::app()->getSession()->get('tipoPago') == 7){
                    
                    echo "<tr><td valign='top'><i class='icon-exclamation-sign'></i> ".
                            Yii::t('contentForm','Balance').".</td></tr>";
                    
                }
                
              ?>
          </table>
        </div>
      	
      	 	   <hr>white stripes
      	
        <h4 class="braker_bottom"> <?php echo Yii::t('contentForm','Shipping address'); ?></h4>        
        <?php 
        
        $direccion = Direccion::model()->findByPk(Yii::app()->getSession()->get('idDireccion'));
		
		$facturacion= Direccion::model()->findByPk(Yii::app()->getSession()->get('idFacturacion'));
		$ciudad = Ciudad::model()->findByPk($direccion->ciudad_id);
        ?>
        <p> <strong><?php echo($direccion->nombre." ".$direccion->apellido); ?></strong> <br/>
         <?php if(Yii::app()->params['askId']){ ?>    
         	<span class="muted small"> <?php echo Yii::t('contentForm','C.I.'); ?> <?php echo($direccion->cedula); ?></span></p> 
        <?php } ?>
        <p><strong><?php echo Yii::t('contentForm','Address'); ?>:</strong> <br/>
          <?php echo($direccion->dirUno.". ".$direccion->dirDos.", ".$ciudad->nombre.", ".$ciudad->provincia->nombre.". ".$direccion->pais); ?> </p>
        <p> <strong><?php echo Yii::t('contentForm','Phone'); ?></strong>: <?php echo($direccion->telefono); ?> <br/>
        </p>
         	   <hr>
        <h4 class="braker_bottom"> <?php echo Yii::t('contentForm','Billing address'); ?></h4>
        <?php //echo('tipo guia: '.Yii::app()->getSession()->get('tipo_guia')); ?>
        <?php 
     
        ?>
        <p> <strong><?php echo($facturacion->nombre." ".$facturacion->apellido); ?></strong> <br/>
         <?php if(Yii::app()->params['askId']){ ?>    <span class="muted small"> <?php echo Yii::t('contentForm','C.I.'); ?> <?php echo($facturacion->cedula); ?></span></p><?php }?>
        <p><strong><?php echo Yii::t('contentForm','Address'); ?>:</strong> <br/>
          <?php echo($facturacion->dirUno.". ".$facturacion->dirDos.", ".$facturacion->ciudad->nombre.", ".$facturacion->ciudad->provincia->nombre.". ".$facturacion->pais); ?> </p>
        <p> <strong><?php echo Yii::t('contentForm','Phone'); ?></strong>: <?php echo($facturacion->telefono); ?> <br/>
        </p>
        
        <!-- Direcciones OFF --> 
        
     
        
      </div>
    </section>
    
    <section class="span4"> 
      <!-- Resumen de Productos ON -->
      <div class="well well_personaling_big">
        <h5><?php echo Yii::t('contentForm','Selected looks').': '.Yii::app()->getSession()->get('totalLook'); ?><br/>
          <?php  
           	if(Yii::app()->getSession()->get('totalProductosLook') != 0){
           		echo Yii::app()->getSession()->get('totalProductosLook')." ".Yii::t('contentForm','Products that make the Looks')."<br/>";
           	}
			
			echo Yii::t('contentForm','Individual products').': '.Yii::app()->getSession()->get('totalIndiv');
            ?>
        </h5>
        
        <div class="margin_bottom">
            
         
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-condensed ">
            <tr>
              <th class="text_align_left"><?php echo Yii::t('contentForm','Subtotal') ?>:</th>
              <td><?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency(Yii::app()->getSession()->get('subtotal'), ''); ?></td>
            </tr>
            <tr>
              <th class="text_align_left"><?php echo Yii::t('contentForm','Shipping') ?>:</th>
              <td><?php 
              	if(Yii::app()->getSession()->get('envio')>0)
                	 echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency(Yii::app()->getSession()->get('envio'), ''); 
                else
                	echo "<b class='text-success'>GRATIS</b>"; ?></td>              
            </tr>
           <?php if(Yii::app()->getSession()->get('seguro')>0){ ?>
            <tr>
              <th class="text_align_left"><?php echo Yii::t('contentForm','Assurance') ?>:</th>
              <td><?php 
              	echo Yii::t('contentForm','currSym').' '.Yii::app()->getSession()->get('seguro'); ?>
                	 </td>              
            </tr>
            <?php }?>
            
            <?php if(!$direccion->ciudad->provincia->pais->exento)
			{?>
				<tr>
	              <th class="text_align_left"><?php echo Yii::t('contentForm','I.V.A'); ?>: (<?php echo Yii::app()->params['IVAtext'];?>):</th>
	              <td><?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency(Yii::app()->getSession()->get('iva'), ''); ?></td>
	            </tr>
			<?php }
			?>
            
            
            <?php if($descuento != 0){ // si no hay descuento ?> 
            <tr>
              <th class="text_align_left"><?php echo Yii::t('contentForm','Discount') ?>:</th>
              <td><?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency($descuento, ''); ?></td>
           	</tr>
           	<?php } ?>
            <tr>
              <th class="text_align_left"><h4><?php echo Yii::t('contentForm','Total') ?>:</h4></th>
              <td><h4><?php echo Yii::t('contentForm','currSym').' '.Yii::app()->numberFormatter->formatCurrency($total, ''); ?></h4></td>
            </tr>
          </table>
          <?php
              
          $tipo_pago = Yii::app()->getSession()->get('tipoPago');
              if($tipo_pago == 4){
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
          <a href="<?php echo $preferenceResult['response']['sandbox_init_point']; ?>" name="MP-Checkout" id="boton_mp" class="blue-L-Rn-VeAll" mp-mode="modal"><?php echo Yii::t('contentForm','Pay MercadoPago') ?></a>
          <?php 
          } else if($tipo_pago == 1  || $tipo_pago == 2){
          	
                  $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                        'id' => 'verticalForm',
                        'action' => Yii::app()->createUrl('bolsa/comprar'),
                        'htmlOptions' => array('class' => 'text_align_center'),
                    ));

                    echo CHtml::hiddenField('codigo_randon', rand());
                    $this->widget('bootstrap.widgets.TbButton', array(
                        'type' => 'warning',
            //                    'buttonType'=>'submit',
                        'buttonType' => 'button',
                        'size' => 'large',
                        'label' => $tipo_pago == 2 ? Yii::t('contentForm', 'Pay with credit card') : Yii::t('contentForm', 'Complete purchase'),
                        //'url'=>Yii::app()->createUrl('bolsa/comprar'), // action
                        'icon' => 'lock white',
                        'htmlOptions' => array(
            //                        'onclick'=>'js:enviar_pago();'
                            'id' => 'btn-Comprar',
                        )
                    ));

                    $this->endWidget();
                    
                  /*Si es en españa bankCard o Paypal*/  
		  }else if($tipo_pago == 5  || $tipo_pago == 6){ 
          	
                      if($tipo_pago == 5){
                          
                        $this->widget('ext.fancybox.EFancyBox', array(
                            'target'=>'#btn-ComprarEsp',
                            'config'=>array(
                                "type" => "iframe",                        
                                "height" => "100%",                        
                                "width" => "65%",                        
                                "autoScale" => false,                        
                                "transitionIn" => "none",                        
                                "transitionOut" => "none",                

                                ),
                            )
                        );
                      }                        
                        echo "<div class='well text_align_center'>";
                        $this->widget('bootstrap.widgets.TbButton', array(
                            'type'=>'warning',        
                            //'buttonType'=>'button',
                            'size'=>'large',
                            'label'=>$tipo_pago==5?Yii::t('contentForm','Pay with credit card') :Yii::t('contentForm','Pay with PayPal'),
                            'url'=> $urlAztive, // action
                            'icon'=>'lock white',
                            'htmlOptions'=>array(
        //                        'onclick'=>'js:enviar_pago();'
                                'id' => 'btn-ComprarEsp',
//                                'data-toggle' => "modal",
//                                'data-target' => "#modalPrueba",
                                )
                        )); 
                        
                        echo "</div>";
                        
		  }else if($tipo_pago == 7){
                      
                      $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                            'id' => 'verticalForm',
                            'action' => Yii::app()->createUrl('bolsa/comprar'),
                            'htmlOptions' => array('class' => 'text_align_center'),
                        ));

                        echo CHtml::hiddenField('codigo_randon', rand());
                        $this->widget('bootstrap.widgets.TbButton', array(
                            'type' => 'warning',
                            'buttonType'=>'submit',
//                            'buttonType' => 'button',
                            'size' => 'large',
                            'label' => Yii::t('contentForm', 'Complete purchase'),
                            //'url'=>Yii::app()->createUrl('bolsa/comprar'), // action
                            'icon' => 'lock white',
                            'htmlOptions' => array(
                //                        'onclick'=>'js:enviar_pago();'
                                'id' => 'btn-ComprarSaldo',
                            )
                        ));

                        $this->endWidget();
                  }
		  ?>
          
        </div>
          <script></script>
        <p><i class="icon-calendar"></i><?php echo Yii::t('contentForm','Date estimated delivery') ?>: <br/><?php echo date('d/m/Y', strtotime('+1 day'));?>  - <?php echo date('d/m/Y', strtotime('+1 week'));  ?> </p>
      </div>
      <p><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/politicas_de_devoluciones" title="Políticas de Envios y Devoluciones" target="_blank"><?php echo Yii::t('contentForm', 'See Shipping and Returns Policies'); ?></a></p>
      <p class="muted"><i class="icon-comment"></i> <?php echo Yii::t('contentForm', 'Contact an advisor for assistance Personaling: Monday to Friday 8:30 am to 5:00 pm'); ?></p>
      
      <!-- Resumen de Productos OFF --> 
      
    </section>
  </div>
</div>
<!-- /container -->

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal','htmlOptions'=>array('class'=>'modal_grande hide fade','tabindex'=>'-1','role'=>'dialog','aria-labelleby'=>'myModalLabel','aria-hidden'=>'true'))); ?>

<?php $this->endWidget(); ?>

<div class="wrapper_home hide">
            
    <div class="box_20130928 margin_bottom_small">
            <h1>
                <span><?php echo Yii::t('contentForm', 'Your payment is being processed'); ?></span>
                <?php echo CHtml::image(Yii::app()->baseUrl."/images/ajax-loader.gif"); ?>            
            </h1>
            
            <p>
              <?php echo Yii::t('contentForm', 'Please <span>don\'t press</span> the buttons: <b>Update</b>, <b>Stop</b> or <b>Back</b> on your browser'); ?>
                <br>
                <?php echo Yii::t('contentForm', 'Your purchase will be completed in seconds!'); ?>                
            </p>
            
    </div>
</div>


<?php 

}// si esta logueado
else
{
	// redirecciona al login porque se murió la sesión
	header('Location: /site/user/login');	
}


?>


<script>
    
$(document).ready(function(){
    $("#btn-Comprar").click(function(e){
	$(this).attr("disabled", true);
        $(this).html('<i class="icon-lock icon-white"></i> Procesando pago...');
        $("body").addClass("aplicacion-cargando");
        $(".wrapper_home").removeClass("hide").find("div").hide().fadeIn();
        $("#verticalForm").submit();
    });
    
//    $("#btn-ComprarEsp").click(function(e){
//	$(this).attr("disabled", true);
//        $(this).html('<i class="icon-lock icon-white"></i> Procesando pago...');
//        $("body").addClass("aplicacion-cargando");
//        $(".wrapper_home").removeClass("hide").find("div").hide().fadeIn();
//        
//    });

    
});
    
    
    
	function enviar_pago(){
		$(this).html("Procesando el Pago...");
		$(this).attr("disabled", true);
		
	}
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
		var peso = $("#peso").attr("value");
		
 		$.ajax({
	        type: "post",
	        dataType: 'json',
	        url: "comprar", // action 
	        data: { 'idDireccion':idDireccion, 'tipoPago':tipoPago, 'subtotal':subtotal, 'descuento':descuento, 'envio':envio, 'iva':iva, 'total':total, 'usar_balance':usar_balance,
	        		'seguro':seguro, 'tipo_guia':tipo_guia, 'peso':peso }, 
	        success: function (data) {
				//console.log('Total: '+data.total+' - Descuento: '+data.descuento);
				if(data.status=="ok")
				{
					
					window.location=data.url;
				}else if(data.status=='error'){
					//console.log(data.error);
				}
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
		var peso = $("#peso").attr("value");
		var tarjeta = $("#tarjeta").attr("value");
		var total_cobrar = "<?php echo $total; ?>";
		/* lo de la tarjeta */
		/*
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
		*/
		if(tarjeta!="0") // el id de la tarjeta de credito que esta temporal en la pagina anterior
		{
			/*if(nom=="" || num=="" || cod=="" || mes=="Mes" || ano=="Ano")
			{
				alert("Por favor complete los datos.");
			}
			else
			{*/
			
			//alert("idCard: "+idCard+" nombre: "+nom+", numero"+num+", cod:"+cod+", mes y año "+mes+"-"+ano+", dir "+dir+", ciudad "+ciud+", estado "+est+", zip"+zip);
			
				$.ajax({
		        type: "post",
		        dataType: 'json',
		        url: "credito", // action 
		       /* data: { 'tipoPago':tipoPago, 'total':total, 'idCard':idCard,'nom':nom,'num':num,'cod':cod,
		        		'mes':mes,'ano':ano,'dir':dir,'ciud':ciud, 'est':est,'zip':zip
		        		}, */
		        data: { 'tipoPago':tipoPago, 'total':total_cobrar, 'tarjeta':tarjeta
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
					        		'usar_balance':usar_balance, 'idDetalle':data.idDetalle,'seguro':seguro,'tipo_guia':tipo_guia, 'peso':peso
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
							if(data.mensaje=="CVC Number Invalid"){
								//alert('El número de tarjeta que introdujó no es un número válido.');
								window.location="error/6";
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
			
			//}
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
					        		'usar_balance':usar_balance, 'idDetalle':data.idDetalle,'seguro':seguro,'tipo_guia':tipo_guia, 'peso':peso
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
	
	function enviar_mp(json)
	{
		$('#boton_mp').attr("disabled", true);
		//alert("return");
   		var idDireccion = $("#idDireccion").attr("value");
		var tipoPago = $("#tipoPago").attr("value");
		var subtotal = $("#subtotal").attr("value");
		var descuento = $("#descuento").attr("value");
		var envio = $("#envio").attr("value");
		var iva = $("#iva").attr("value");
		var total = $("#total").attr("value");
		var seguro = $("#seguro").attr("value");
		var tipo_guia = $("#tipo_guia").attr("value");
		var peso = $("#peso").attr("value");

 		 if (json.collection_status=='approved'){
    alert ('Pago acreditado');
  } else if(json.collection_status=='pending'){
    alert ('El usuario no completó el pago');
    $.ajax({
	        type: "post",
	        dataType: 'json',
	        url: "comprar", // action 
	        data: { 'idDireccion':idDireccion, 'tipoPago':tipoPago, 'subtotal':subtotal, 'descuento':descuento, 'envio':envio, 'iva':iva, 'total':total, 'id_transaccion':json.collection_id,'seguro':seguro,'tipo_guia':tipo_guia, 'peso':peso}, 
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
