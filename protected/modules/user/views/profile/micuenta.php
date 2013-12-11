<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	UserModule::t("Mi cuenta"),
);
$look = new Look;
$looks_encantan = LookEncantan::model()->countByAttributes(array('user_id'=>$model->id));
$productos_encantan = UserEncantan::model()->countByAttributes(array('user_id'=>$model->id));
$looks_recomendados = $look->match($model);
?>



<div class="container margin_top tu_perfil">
    
    <?php
    $this->widget('bootstrap.widgets.TbAlert', array(
        'block' => true, // display a larger alert block?
        'fade' => true, // use transitions?
        'closeText' => '&times;', // close link text - if set to false, no close link is displayed
        'alerts' => array(// configurations per alert type
            'success' => array('block' => true, 'fade' => true, 'closeText' => '&times;'), // success, info, warning, error or danger
            'error' => array('block' => true, 'fade' => true, 'closeText' => '&times;'), // success, info, warning, error or danger
        ),
            )
    );
    ?> 
    
  <div class="row">
  	<div id="confirmacion_facebook" class="alert alert-success text_center_align" style="display: none;">Amigos invitados</div>
    <aside class="span3">
      <div class="card">
      	
      	
        <?php echo CHtml::image($model->getAvatar(),'Avatar',array("width"=>"270", "height"=>"270")); ?>
        <div class="card_content vcard">
          <h4 class="fn"><?php echo $profile->first_name." ".$profile->last_name; ?></h4>
          <p class="muted">Miembro desde: <?php echo Yii::app()->dateFormatter->format("d MMM y",strtotime($model->create_at)); ?></p>
        </div>
      </div>
      <hr/>
      <h5>Tu actividad</h5>
      <div class="card">
        <div class="card_numbers clearfix"> <span class="T_xlarge margin_top_xsmall"><?php echo $looks_encantan; ?></span>
          <p>Looks que te Encantan</p>
        </div>
        <div class="card_numbers clearfix"> <span class="T_xlarge margin_top_xsmall"><?php echo $productos_encantan; ?></span>
          <p>Productos que te Encantan</p>
        </div>
        <div class="card_numbers clearfix"> <span class="T_xlarge margin_top_xsmall"><?php echo $looks_recomendados->totalItemCount; ?></span>
          <p>Looks recomendados para ti</p>
        </div>
      </div>
      <hr/>
      <h5>Tus Compras</h5>
      <ul class="nav nav-stacked text_align_center" >
      	 
      	<?php
      	
      	$sum = Yii::app()->db->createCommand(" SELECT SUM(total) as total FROM tbl_balance WHERE user_id=".Yii::app()->user->id." GROUP BY user_id ")->queryScalar();
      
      	if($sum >= 0){
      	?>
      		<li><?php echo Yii::app()->numberFormatter->formatCurrency($sum, ''); ?> Bs. de Balance en tu Cuenta</li>
      	<?php
      	}
      	else
      	{
      	?>
      		<li><?php echo Yii::app()->numberFormatter->formatCurrency($sum, ''); ?> Bs. que adeudas.</li>
      	<?php
      	}
      	?>
        
        
        <?php
        
        $total;
	
		$sql = "select count( * ) as total from tbl_orden where user_id=".Yii::app()->user->id." and estado < 5";
		$total = Yii::app()->db->createCommand($sql)->queryScalar();
      	?>
      	<li><?php echo $total; ?> Pedidos Activos</li>
         <?php
        
        $total;
	
		$sql = "select count( * ) as total from tbl_orden where user_id=".Yii::app()->user->id." and (estado = 10 OR estado = 9)";
		$total = Yii::app()->db->createCommand($sql)->queryScalar();
      	?>
        <li><?php echo $total; ?> Devoluciones</li>
      </ul>
      <hr/>
      <h5>Invita a tus amig@s</h5>
      <div id="boton_facebook" style="cursor: pointer;" onclick="invite_friends()"><a>Facebook</a></div>
      
    </aside>
    <div class="span9 configuracion_perfil">
    <h1>Panel de control</h1>
      <div class="well">
        <div class="row">
          <div class="span4">
            <h2 class="braker_bottom"> Tu Perfil</h2>
            <ul class="nav nav-stacked nav-tabs">
              <li> <?php echo CHtml::link('Tus datos personales',array('profile/edit'),array("title"=>"Edita tus datos personales")); ?></li>
              <li> <?php echo CHtml::link('Tu avatar',array('profile/avatar'),array("title"=>"Edita tu avatar")); ?></li>
              <li> <?php echo CHtml::link('Tu perfil corporal',array('profile/edittutipo'),array("title"=>"Edita tu perfil corporal")); ?></li>
              <li><?php echo CHtml::link('Tu perfil público',array('profile/perfil'),array("title"=>"Ve tu perfil público")); ?> </li>
              <li><?php echo CHtml::link('Otros perfiles',array('profile/tusPerfiles'),array("title"=>"Ve los perfiles que has creado")); ?> </li>
            </ul>
          </div>
          <div class="span4">
            <h2 class="braker_bottom"> Tus Pedidos </h2>
            <ul class="nav nav-stacked nav-tabs">
            	<li> <?php echo CHtml::link('Pedidos Activos',array('/orden/listado'),array("title"=>"Tus pedidos activos")); ?></li>
            	<li> <?php echo CHtml::link('Historial de Pedidos',array('/orden/listado'),array("title"=>"Tus pedidos nuevos y anteriores")); ?></li>
                <li> <?php echo CHtml::link('Aplicar GiftCard',array('/giftcard/aplicar'),array("title"=>"Aplica una Gift Card")); ?></li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="span4">
            <h2 class="braker_bottom"> Tu Estilo </h2>
            <ul class="nav nav-stacked nav-tabs">
              <li><?php echo CHtml::link('Diario',array('profile/edittuestilo','id'=>'coctel'),array("title"=>"Edita tu estilo Diario")); ?></li>
              <li><?php echo CHtml::link('Fiesta',array('profile/edittuestilo','id'=>'fiesta'),array("title"=>"Edita tu estilo Fiesta")); ?></li>
              <li><?php echo CHtml::link('Vacaciones',array('profile/edittuestilo','id'=>'playa'),array("title"=>"Edita tu estilo Vacaciones")); ?></li>
              <li><?php echo CHtml::link('Haciendo Deporte',array('profile/edittuestilo','id'=>'sport'),array("title"=>"Edita tu estilo Haciendo Deporte")); ?></li>
              <li><?php echo CHtml::link('Oficina',array('profile/edittuestilo','id'=>'trabajo'),array("title"=>"Edita tu estilo Oficina")); ?></li>
            </ul>
          </div>
          <div class="span4">
            <h2 class="braker_bottom"> Tus Encantos/Favoritos </h2>
            <ul class="nav nav-stacked nav-tabs">
              <li><?php echo CHtml::link('Looks',array('profile/looksencantan'),array("title"=>"Looks que te encantan")); ?></a></li>
              <li><?php echo CHtml::link('Productos',array('profile/encantan'),array("title"=>"Productos que te encantan")); ?></a></li>
            </ul>
            <h2 class="braker_bottom"> Conecta tus Redes Sociales </h2>
            <ul class="nav nav-stacked nav-tabs">
<!--               <li><a href="#" title="facebook">Facebook (LINK MUERTO)</a></li>
              <li><a href="#" title="Twitter">Twitter (LINK MUERTO)</a></li>
              <li><a href="#" title="Pinterest">Pinterest (LINK MUERTO)</a></li> -->
           	  <li><?php echo CHtml::link('Invita a tus amig@s',array('invitaciones'),array("title"=>"Invita a tus amig@s")); ?></li>
            </ul>
          </div>
        </div>
      </div>
      <?php /*?>
	  // Fase numero II
	  <div class="well">
        <div class="row">
          <div class="span4">
            <h2 class="braker_bottom"> Tus Pedidos </h2>
            <ul class="nav nav-stacked nav-tabs">

              <li>Pedidos Activos</li>
              <li>Historial de Pedidos</li>
            </ul>
            <h2 class="braker_bottom"> Tus Preferencias de Pago </h2>
            <ul class="nav nav-stacked nav-tabs">

              <li>Verificar Pagos</li>
              <li>Solicitar afiliacion de Pagos</li>
            </ul>
            <h2 class="braker_bottom"> Tus Tarjetas de Regalo </h2>
            <ul class="nav nav-stacked nav-tabs">

              <li> Ver Balance de Tarjetas de Regalo</li>
              <li> Aplicar tarjeta de Regalo a tu Cuenta</li>
              <li> Comprar Tarjeta de Regalo</li>
            </ul>
          </div>
          <div class="span4">
            <h2 class="braker_bottom"> Tus Devoluciones </h2>
            <ul class="nav nav-stacked nav-tabs">

              <li>Devoluciones Activas</li>
              Historial de devoluciones
            </ul>
            <h2 class="braker_bottom"> Tus Testimonios </h2>
            <ul class="nav nav-stacked nav-tabs">

              <li> Testimonios sobre compras</li>
              <li> Testimonios sobre Personal Shoppers</li>
            </ul>
            <h2 class="braker_bottom"> Tus Puntos </h2>
            <ul class="nav nav-stacked nav-tabs">

              <li>Testimonios sobre Personaling</li>
              <li> Testimonios sobre compras</li>
            </ul>
          </div>
        </div>
      </div><?php */?>
      <div class="well">
        <div class="row">
          <div class="span4">
            <h2 class="braker_bottom"> Correo electrónico y contraseña </h2>
            <ul class="nav nav-stacked nav-tabs">
              <li><?php echo CHtml::link('Cambiar correo electrónico',array('changeemail'),array("title"=>"Cambia tu correo electrónico")); ?></li>
              <li><?php echo CHtml::link('Cambiar Contraseña',array('changepassword'),array("title"=>"Cambia tu contraseña")); ?></a></li>
            </ul>
            <h2 class="braker_bottom"> Libreta de Direcciones </h2>
            <ul class="nav nav-stacked nav-tabs">
              <li><?php echo CHtml::link('Gestionar direcciones de Envíos y Pagos.',array('direcciones'),array("title"=>"Gestiona tus direcciones")); ?></li>
              <li><a href="<?php echo Yii::app()->request->baseUrl ?>/user/profile/crearDireccion" title="Agregar una nueva dirección">Añadir nueva dirección</a></li>
            </ul>
          </div>
          <div class="span4">
            <h2 class="braker_bottom"> Notificaciones </h2>
            <ul class="nav nav-stacked nav-tabs">
              <li><?php echo CHtml::link('Gestionar correos de Personaling',array('notificaciones'),array("title"=>"Gestionar correos de Personaling")); ?></li>
              <!-- <li><a href="#" title="Desuscribirse de la lista de correos">Darte de baja de la lista correos (LINK MUERTO)</a></li> -->
            </ul>
            <h2 class="braker_bottom"> Privacidad </h2>
            <ul class="nav nav-stacked nav-tabs">
              <li><?php echo CHtml::link('Información Pública',array('privacidad'),array("title"=>"Cambia tu información pública")); ?></li>
              <li><?php echo CHtml::link('Eliminar Cuenta',array('delete'),array("title"=>"Eliminar Cuenta")); ?> </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
	$(document).ready(function(){
	    
	    window.fbAsyncInit = function() {
	        FB.init({
	            appId      : '323808071078482', // App ID secret c8987a5ca5c5a9febf1e6948a0de53e2
	            channelUrl : 'http://personaling.com/site/user/registration', // Channel File
	            status     : true, // check login status
	            cookie     : true, // enable cookies to allow the server to access the session
	            xfbml      : true,  // parse XFBML
	            oauth      : true
	        });
	
	    };
	    
	    (function(d){
	        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	        if (d.getElementById(id)) {return;}
	        js = d.createElement('script');js.id = id;js.async = true;
	        js.src = "//connect.facebook.net/en_US/all.js";
	        ref.parentNode.insertBefore(js, ref);
	    }(document));
	});

	function invite_friends(){
		FB.getLoginStatus(function(response){
	        //console.log("response: "+response.status);
	        if (response.status === 'connected') {
	        	// está conectado a facebook y además ya tiene permiso de usar la aplicacion personaling
					
				console.log('Welcome!  Fetching your information.... ');
	                    
	                    FB.api('/me', function(response) {
	                        //console.log('Nombre: ' + response.id + '.\nE-mail: ' + response.email);
	                        $.ajax({
								type: "get",
								dataType: 'html',
								url: "checkFbUser", // action 
								data: { 'fb_id': response.id	}, 
								success: function () {
									//console.log('saved');
								}//success
							});
	                    }, {scope: 'email,user_birthday'});
	                    
	          	FB.ui({method: 'apprequests',
			      title: 'Personaling',
			      message: 'Tu personal shopper digital.',
			    }, fbCallback);
	        } else {
	            FB.login(function(response) {
	                if (response.authResponse) {
	                	//user is already logged in and connected (using information)
	                    console.log('Welcome!  Fetching your information.... ');
	                    
	                    FB.api('/me', function(response) {
	                        //console.log('Nombre: ' + response.id + '.\nE-mail: ' + response.email);
	                         $.ajax({
								type: "get",
								dataType: 'html',
								url: "checkFbUser", // action 
								data: { 'fb_id': response.id	}, 
								success: function () {
									//console.log('saved');
								}//success
							});
	                    });
	                    
	                    FB.ui({method: 'apprequests',
					      title: 'Personaling',
					      message: 'Tu personal shopper digital.',
					    }, fbCallback);
	                } else {
	                    //console.log('User cancelled login or did not fully authorize.');
	                }
	            }, {scope: 'email,user_birthday'});
	        }
	    });
	}
	
	function fbCallback(response){
		//console.log(response);
		if(response != null){
			$.ajax({
				type: "post",
				dataType: 'html',
				url: "saveInvite", // action 
				data: { 'request': response.request, 'to': response.to }, 
				success: function () {
					console.log('invite saved');
					$('#confirmacion_facebook').show('slow');
					//location.reload();
					//window.location="micuenta";
				}//success
			});
		}
	}
</script>
