<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Tu Perfil");
//$this->breadcrumbs=array(
	//UserModule::t("Profile")=>array('profile'),
	//UserModule::t("Mi cuenta"),
//);


  //Metas de Twitter CARD ON
  Yii::app()->clientScript->registerMetaTag('product', 'twitter:card', null, null, null);
  Yii::app()->clientScript->registerMetaTag('@personaling', 'twitter:site', null, null, null);
  Yii::app()->clientScript->registerMetaTag("Sugerir Personaling", 'twitter:title', null, null, null);
  Yii::app()->clientScript->registerMetaTag("description", 'twitter:description', null, null, null);
  #Yii::app()->clientScript->registerMetaTag(Yii::app()->getBaseUrl(true)."/look/getImage/".$model->id, 'twitter:image', null, null, null); //IMAGEN DE TWITTER CARD, QUITAR EN CASO DE QUE NO FUNCIONE EN PRODUCCION
 # Yii::app()->clientScript->registerMetaTag($model->getPrecio().' '.Yii::t('contentForm', 'currSym'), 'twitter:data1', null, null, null);
  Yii::app()->clientScript->registerMetaTag('Subtotal', 'twitter:label1', null, null, null);
  #Yii::app()->clientScript->registerMetaTag($model->user->profile->first_name.' '.$model->user->profile->last_name, 'twitter:data2', null, null, null);  
  Yii::app()->clientScript->registerMetaTag('Creado por', 'twitter:label2', null, null, null);
  Yii::app()->clientScript->registerMetaTag('personaling.com', 'twitter:domain', null, null, null);

  //Metas de Twitter CARD OFF


$look = new Look;
$looks_encantan = LookEncantan::model()->countByAttributes(array('user_id'=>$model->id));
$productos_encantan = UserEncantan::model()->countByAttributes(array('user_id'=>$model->id));
$looks_recomendados = $look->match($model);
?> 
<div class="container margin_top tu_perfil">
  <div class="row">
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
      		<li><?php echo Yii::app()->numberFormatter->formatCurrency($sum, '')." ".Yii::t('contentForm','currSym'); ?> de Balance en tu Cuenta</li>
      	<?php
      	}
      	else
      	{
      	?>
      		<li><?php echo Yii::app()->numberFormatter->formatCurrency($sum, '')." ".Yii::t('contentForm','currSym'); ?> que adeudas.</li>
      	<?php
      	}
      	?>
        <!-- <li>XX Puntos Ganados</li> -->
        
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
       <!-- <h5>Invita a tus amig@s</h5>-->
        <!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style addthis_32x32_style text_align_center">
         <!-- <a class="addthis_button_preferred_1"></a>
          <a class="addthis_button_preferred_2"></a>
          <a class="addthis_button_preferred_3"></a>
          <a class="addthis_counter addthis_bubble_style"></a>-->
           
           <?php $this->widget('bootstrap.widgets.TbButton', array(
					    'label'=>'Invita a tus amig@s',
					    'type'=>'danger',
					    'htmlOptions'=>array('class'=>'btn-block btn-large'),
						'url'=>array('invitaciones')	,    
					)); ?> 
			
        </div>
        <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};
              var addthis_config = {"data_track_addressbar":false,image_exclude: "at_exclude"};
              var addthis_share = {

                  url: '<?php echo Yii::app()->request->hostInfo.Yii::app()->request->baseUrl."/".$profile->url; ?>',
                  title: '<?php echo $profile->first_name." ".$profile->last_name; ?> mi perfil en Personaling.com ?>',
                  description: '<?php echo $profile->bio; ?>',
                  templates : {
                      twitter : "<?php echo $profile->first_name." ".$profile->last_name; ?> mi perfil en Personaling.com <?php echo Yii::app()->request->hostInfo.Yii::app()->request->baseUrl.'/'.$profile->url; ?>  via @personaling "
                  }

              }   
              console.log('<?php echo Yii::app()->request->hostInfo.Yii::app()->request->baseUrl."/".$profile->url; ?>');      
        </script>
        <?php 
           //Metas de Facebook CARD ON
          Yii::app()->clientScript->registerMetaTag($profile->first_name." ".$profile->last_name." - Perfil", null, null, array('property' => 'og:title'), null);
          Yii::app()->clientScript->registerMetaTag($profile->bio, null, null, array('property' => 'og:description'), null);
          Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
          Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 
          Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.$model->getAvatar(), 'og:image', null, null, null);

          //Metas de Facebook CARD OFF

        ?>        
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=juanrules"></script> 
        <!-- AddThis Button END --> 
    </aside>
    <div class="span9 configuracion_perfil">
      <div class="well">
        <div class="row">
          <div class="span4">
            <h2 class="braker_bottom">  Tu Perfil Corporal  </h2>
           <ul class="nav nav-stacked nav-tabs">
              <li> <?php echo CHtml::link('Tus datos personales',array('profile/edit'),array("title"=>"Edita tus datos personales")); ?></li>
              <li> <?php echo CHtml::link('Tu foto',array('profile/avatar'),array("title"=>"Edita tu foto")); ?></li>
              <li> <?php echo CHtml::link('Tu Banner',array('profile/banner'),array("title"=>"Edita tu Banner"));?> </li>                         
              <li> <?php echo CHtml::link('Tu perfil corporal',array('profile/edittutipo'),array("title"=>"Edita tu perfil corporal")); ?></li>
              <li> <a href="<?php echo Yii::app()->baseUrl."/user/profile/perfil/id/".$profile->user_id; ?>" title="Tu perfil publico">Tu perfil publico</a></li>
              

            </ul>
           
          </div>
          <div class="span4">
          
          <h2 class="braker_bottom"> Tus Pedidos </h2>
            <ul class="nav nav-stacked nav-tabs">
              <li><?php echo CHtml::link('Pedidos Activos',array('/orden/listado'),array("title"=>"Tus pedidos activos")); ?></li>
              <li><?php echo CHtml::link('Historial de Pedidos',array('/orden/listado'),array("title"=>"Tus pedidos nuevos y anteriores")); ?></li>
              <li> <?php echo CHtml::link('Aplicar Gift Card',array('/giftcard/aplicar'),array("title"=>"Aplica una Gift Card")); ?></li>
              <li> <?php echo CHtml::link('Tus Ventas',array('/controlpanel/misventas/'.Yii::app()->user->id.''),array("title"=>"Tus Ventas")); ?></li>
              
            </ul>
             
          </div>
        </div>
        
        <div class="row">
        <div class="span4">
         <h2 class="braker_bottom">  Tu Estilo </h2>
           <ul class="nav nav-stacked nav-tabs">
                <li><?php echo CHtml::link('Diario',array('profile/edittuestilo','id'=>'coctel'),array("title"=>"Edita tu estilo Diario")); ?></li>
	              <li><?php echo CHtml::link('Fiesta',array('profile/edittuestilo','id'=>'fiesta'),array("title"=>"Edita tu estilo Fiesta")); ?></li>
	              <li><?php echo CHtml::link('Vacaciones',array('profile/edittuestilo','id'=>'playa'),array("title"=>"Edita tu estilo Vacaciones")); ?></li>
	              <li><?php echo CHtml::link('Haciendo Deporte',array('profile/edittuestilo','id'=>'Sport'),array("title"=>"Edita tu estilo Haciendo Deporte")); ?></li>
	              <li><?php echo CHtml::link('Oficina',array('profile/edittuestilo','id'=>'trabajo'),array("title"=>"Edita tu estilo Oficina")); ?></li>
            </ul>
        <?php $ruta_twitter='https://twitter.com/intent/tweet?url='.Yii::app()->getBaseUrl(true).'&text=&lang=es&via=Personaling'; ?>
                            
        </div>
        <div class="span4">
        	<h2 class="braker_bottom">Mis Favoritos</h2>
           <ul class="nav nav-stacked nav-tabs">
              <li><?php echo CHtml::link('Looks',array('profile/looksencantan'),array("title"=>"Looks que te encantan")); ?></a></li>
              <li><?php echo CHtml::link('Productos',array('profile/encantan'),array("title"=>"Productos que te encantan")); ?></a></li>
            </ul>
            <h2 class="braker_bottom">  Conecta tus Redes Sociales </h2>
             <script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>
           <ul class="nav nav-stacked nav-tabs">
               <li><div onclick="invite_friends()" style="cursor: pointer;" id="boton_facebook" class="text_align_center"><a>Invítalos usando Facebook</a></div></li>
              	<p>
               <li><div style="cursor: pointer;" id="boton_twitter" class="text_align_center"><a href=<?php echo $ruta_twitter;?> >Invítalos usando Twitter</a></div></li>
              
            </ul>
        
        </div>
        
        </div>
        
        
      </div>
      <div class="well">
        <div class="row">
          <div class="span4">
             <h2 class="braker_bottom">Tus Looks</h2>
           <ul class="nav nav-stacked nav-tabs">
              <!-- <li><a href="#" title="Tus Looks Publicados">Tus Looks Publicados</a></li> -->
              <!-- <li><a href="#" title="Tus Looks Pendientes por aprobació">Tus Looks Pendientes por aprobación</a></li> -->
              <li><a href="<?php echo Yii::app()->request->baseUrl."/look/listarLooks";?>" title="Tus Looks Pendientes por aprobació">Ver Looks creados</a></li>
              
              <li><a href="<?php echo Yii::app()->request->baseUrl ?>/docs/manual_CreaciondeLooks.pdf" title="Crear look">Manual para crear un Look</a></li>
              
              <li><a href="<?php echo Yii::app()->request->baseUrl."/look/mislooks";?>" title="Administrar Looks">Administrar Looks</a></li>
            </ul>
          
          </div>
          <div class="span4 padding_top_xsmall">
          <div class="well  margin_top_large">
           <?php $this->widget('bootstrap.widgets.TbButton', array(
					    'label'=>'Crear nuevo look',
					    'type'=>'danger',
					    'htmlOptions'=>array('class'=>'btn-block btn-large'),
						'url'=>array('//look/create')	,    
					)); ?> </div>
          </div>
          
        </div>
      </div>
      <?php /*?>
	  // Para Fase numero II
	  <div class="well">
        <div class="row">
          <div class="span4">
             <h2 class="braker_bottom">Tus Pedidos </h5>
           <ul class="nav nav-stacked nav-tabs">
              <li>Pedidos Activos</li>
              <li>Historial de Pedidos</li>
            </ul>
             <h2 class="braker_bottom">Tus Preferencias de Pago </h5>
           <ul class="nav nav-stacked nav-tabs">
              <li>Verificar Pagos</li>
              <li>Solicitar afiliacion de Pagos</li>
            </ul>
             <h2 class="braker_bottom">Tus Tarjetas de Regalo </h5>
           <ul class="nav nav-stacked nav-tabs">
              <li> Ver Balance de Tarjetas de Regalo</li>
              <li> Aplicar tarjeta de Regalo a tu Cuenta</li>
              <li> Comprar Tarjeta de Regalo</li>
            </ul>
          </div>
          <div class="span4">
             <h2 class="braker_bottom">Tus Devoluciones </h5>
           <ul class="nav nav-stacked nav-tabs">
              <li>Devoluciones Activas</li>
              Historial de devoluciones
            </ul>
             <h2 class="braker_bottom">Tus Testimonios </h5>
           <ul class="nav nav-stacked nav-tabs">
              <li> Testimonios sobre compras</li>
              <li> Testimonios sobre Personal Shoppers</li>
            </ul>
             <h2 class="braker_bottom">Tus Puntos </h5>
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
             <h2 class="braker_bottom">Correo electrónico y contraseña </h2>
           <ul class="nav nav-stacked nav-tabs">
              <li><?php echo CHtml::link('Cambiar correo electrónico',array('changeemail'),array("title"=>"Cambia tu correo electrónico")); ?></li>
              <li><?php echo CHtml::link('Cambiar Contraseña',array('changepassword'),array("title"=>"Cambia tu contraseña")); ?></a></li>
            </ul>
             <h2 class="braker_bottom">Libreta de Direcciones </h2>
           <ul class="nav nav-stacked nav-tabs"> 
              <li><?php echo CHtml::link('Gestionar direcciones de Envíos y Pagos.',array('direcciones'),array("title"=>"Gestiona tus direcciones")); ?></li>
            
              <!-- <li><a href="<?php echo Yii::app()->request->baseUrl ?>/user/profile/direcciones" title="Gestionar direcciones de Envios y Pagos">Gestionar direcciones de Envios y Pagos</a></li> -->
              <li><a href="<?php echo Yii::app()->request->baseUrl ?>/user/profile/crearDireccion" title="Agregar una nueva dirección">Añadir nueva dirección</a></li>
            </ul>
          </div> 
          <div class="span4">
             <h2 class="braker_bottom">Notificaciones </h2>
           <ul class="nav nav-stacked nav-tabs">
              <li><?php echo CHtml::link('Gestionar correos de Personaling',array('notificaciones'),array("title"=>"Gestionar correos de Personaling")); ?></li>
              <!-- <li><a href="Desuscribir_de_la_lista_correos.php" title="Desuscribir de la lista correos">Desuscribir de la lista correos</a></li> -->
            </ul>
             <h2 class="braker_bottom">Privacidad </h2>
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
<!-- /container -->


<?php 
if(Yii::app()->language=="es_es")
{
	
	$appId=323808071078482; //para facebook espana	
}
else 
{
	$appId=386830111475859; //para facebook venezuela
}
?>
<script>
	$(document).ready(function(){
		var appId=<?php echo $appId;?>;
	    //alert('http://'+window.location.host+'<?php //echo Yii::app()->baseUrl; ?>'+'/user/registration');
	    window.fbAsyncInit = function() {
	        FB.init({
	            appId      : appId, // App ID secret c8987a5ca5c5a9febf1e6948a0de53e2
	            channelUrl : 'http://'+window.location.host+'<?php echo Yii::app()->baseUrl; ?>'+'/user/registration', // Channel File
	            status     : true, // check login status
	            cookie     : true, // enable cookies to allow the server to access the session
	            xfbml      : true,  // parse XFBML
	            oauth      : true,
	            frictionlessRequests : true
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
			      message: '¡Te invito a probar Personaling, Tu Personal Shopper Online!',
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
					      message: '¡Te invito a probar Personaling, Tu Personal Shopper Online!',
					    }, fbCallback);
	                } else {
	                    //console.log('User cancelled login or did not fully authorize.');
	                }
	            }, {scope: 'email,user_birthday'});
	        }
	    });
	}
	
	function fbCallback(response){
		if(response != null){
			/*var user_ids = response.to.split(",");*/
			for(var i = 0; i < response.to.length; i++){
				//console.log('id: '+response.to[i]);
				var id_actual = response.to[i];
				var id_request = response.request;
				//console.log('request: '+id_request);
				FB.api('/'+id_actual, function(user) {
					//console.log('ID: '+user.id);
					$.ajax({
						type: "post",
						dataType: 'html',
						url: "saveInvite", // action 
						data: { 'request': id_request, 'to': user.id, 'nombre': user.name }, 
						success: function (data) {
							//console.log('invite saved: '+data);
							$('#confirmacion_facebook').show('slow');
							//location.reload();
							//window.location="micuenta";
						}//success
					});
				});
			}
		}
		/*if(response != null){
			FB.api('/'+response.to, function(user) {
				console.log('Nombre: ' + response.name + '.\nE-mail: ' + response.email);
				$.ajax({
				type: "post",
				dataType: 'html',
				url: "saveInvite", // action 
				data: { 'request': response.request, 'to': response.to, 'nombre': user.name }, 
				success: function () {
					console.log('invite saved');
					$('#confirmacion_facebook').show('slow');
					//location.reload();
					//window.location="micuenta";
				}//success
			});
			});
		}*/
	}
</script>
