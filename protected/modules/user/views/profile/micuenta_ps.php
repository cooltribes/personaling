<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	//UserModule::t("Profile")=>array('profile'),
	UserModule::t("Mi cuenta"),
);
?> 
<div class="container margin_top">
  <div class="row">
    <div class="span3">
      <div class="shadow_1"> <img src="http://placehold.it/270x200"/>
        <h4><?php echo $profile->first_name." ".$profile->last_name; ?></h4>
        <p class="muted">Miembro desde: <?php echo $model->create_at; ?></p>
        <hr/>
         <div class="alert alert-block"><ul>
          <li>XX Looks Pulicados</li>
          <li>XX Looks pendientes por aprobación</li>
          <li>XX Looks recomendados para ti</li>
        </ul></div>
        <hr/>
         <ul>
          <li>XX Looks que te Encantan</li>
          <li>XX Productos que te Encantan</li>
          <li>XX Looks recomendados para ti</li>
        </ul>
        <hr/>
        <h4>Tus Compras</h4>
        <ul>
          <li>XX Bs. de Balance en tu Cuenta</li>
          <li>XX Puntos Ganados</li>
          <li>XX Pedidos Activos</li>
          <li>XX Devoluciones Pendientes</li>
        </ul>
        <hr/>
       
        <h4>Invita a tus amig@s</h4>
        <div class="row">
          <div class="span1"><img src="http://placehold.it/90"/></div>
          <div class="span1"><img src="http://placehold.it/90"/></div>
          <div class="span1"><img src="http://placehold.it/90"/></div>
        </div>
      </div>
    </div>
    <div class="span9 configuracion_perfil">
      <div class="well">
        <div class="row">
          <div class="span4">
            <h5 class="braker_bottom padding_bottom_xsmall margin_top_small"> Tu Perfil </h5>
            <ul>
              <li> <a href="Tu_Perfil_Tus_datos_Personales_Usuaria.php" title="Datos personales">Tus datos personales </a></li>
              <li> <a href="Tu_Perfil_Avatar_Usuaria.php" title="Avatar">Tu Avatar</a></li>
              <li> <a href="Tu_Perfil_Perfil_Corporal_Usuaria.php" title="Tu perfil corporal">Tu perfil corporal</a></li>
              <li> <a href="#" title="Tu perfil publico">Tu perfil publico</a></li>
              <li> <a href="Editar_Perfil_Usuaria_Mi_Tipo.php" title="Tu Tipo">Tu Tipo</a></li>

            </ul>
            <h5 class="braker_bottom padding_bottom_xsmall margin_top_small"> Tu Estilo </h5>
            <ul>
                 <li><a href="Tu_Personaling_Tu Estilo_Casual_Usuaria.php" title="Casual">Casual</a></li>
    <li><a href="Tu_Personaling_Tu Estilo_Casual_Usuaria.php" title="Coctel">Coctel</a></li>
    <li><a href="Tu_Personaling_Tu Estilo_Casual_Usuaria.php" title="Fiesta">Fiesta</a></li>
    <li><a href="Tu_Personaling_Tu Estilo_Casual_Usuaria.php" title="Playa">Playa</a></li>
    <li><a href="Tu_Personaling_Tu Estilo_Casual_Usuaria.php" title="Sport">Sport</a></li>
    <li><a href="Tu_Personaling_Tu Estilo_Casual_Usuaria.php" title="Trabajo">Trabajo</a></li>
            </ul>
          </div>
          <div class="span4">
            <h5 class="braker_bottom padding_bottom_xsmall margin_top_small">Tus Encantos/Favoritos </h5>
            <ul>
              <li><a href="Tu_Personaling_Tus_EncantosFavoritos_Looks.php" title="Tus Looks favoritos">Looks</a></li>
              <li><a href="Tu_Personaling_Tus_EncantosFavoritos_productos.php" title="Tus productos favoritos">Productos</a></li>
            </ul>
            <h5 class="braker_bottom padding_bottom_xsmall margin_top_small"> Conecta tus Redes Sociales </h5>
            <ul>
              <li>Facebook</li>
              <li>Twitter</li>
              <li>Pinterest</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="well">
        <div class="row">
          <div class="span4">
            <h5 class="braker_bottom padding_bottom_xsmall margin_top_small">Tus Looks</h5>
            <ul>
              <li><a href="#" title="Tus Looks Publicados">Tus Looks Publicados</a></li>
              <li><a href="#" title="Tus Looks Pendientes por aprobació">Tus Looks Pendientes por aprobación</a></li>
              <li><a href="crear_look.php" title="Crear look" class="btn btn-danger">Crear Look</a></li>
              <li><a href="#" title="Crear look">Manual para crear un Look</a></li>
            </ul>
           
          </div>
          
        </div>
      </div>
      <?php /*?>
	  // Para Fase numero II
	  <div class="well">
        <div class="row">
          <div class="span4">
            <h5 class="braker_bottom padding_bottom_xsmall margin_top_small">Tus Pedidos </h5>
            <ul>
              <li>Pedidos Activos</li>
              <li>Historial de Pedidos</li>
            </ul>
            <h5 class="braker_bottom padding_bottom_xsmall margin_top_small">Tus Preferencias de Pago </h5>
            <ul>
              <li>Verificar Pagos</li>
              <li>Solicitar afiliacion de Pagos</li>
            </ul>
            <h5 class="braker_bottom padding_bottom_xsmall margin_top_small">Tus Tarjetas de Regalo </h5>
            <ul>
              <li> Ver Balance de Tarjetas de Regalo</li>
              <li> Aplicar tarjeta de Regalo a tu Cuenta</li>
              <li> Comprar Tarjeta de Regalo</li>
            </ul>
          </div>
          <div class="span4">
            <h5 class="braker_bottom padding_bottom_xsmall margin_top_small">Tus Devoluciones </h5>
            <ul>
              <li>Devoluciones Activas</li>
              Historial de devoluciones
            </ul>
            <h5 class="braker_bottom padding_bottom_xsmall margin_top_small">Tus Testimonios </h5>
            <ul>
              <li> Testimonios sobre compras</li>
              <li> Testimonios sobre Personal Shoppers</li>
            </ul>
            <h5 class="braker_bottom padding_bottom_xsmall margin_top_small">Tus Puntos </h5>
            <ul>
              <li>Testimonios sobre Personaling</li>
              <li> Testimonios sobre compras</li>
            </ul>
          </div>
        </div>
      </div><?php */?>
      <div class="well">
        <div class="row">
          <div class="span4">
            <h5 class="braker_bottom padding_bottom_xsmall margin_top_small">Correo Electronico y Contrasena </h5>
            <ul>
              <li><a href="cambiar_Correo_electronico.php" title="cambiar corre electronico">Cambiar correo electronico</a></li>
              <li> <a href="cambiar_Contrasena.php" title="cambiar contrasena">Cambiar contraseña</a></li>
            </ul>
            <h5 class="braker_bottom padding_bottom_xsmall margin_top_small">Libreta de Direcciones </h5>
            <ul>
              <li>Gestionar direcciones de Envios y Pagos.</li>
              <li>Anadir nueva direccion</li>
            </ul>
          </div>
          <div class="span4">
            <h5 class="braker_bottom padding_bottom_xsmall margin_top_small">Notificaciones </h5>
            <ul>
              <li><a href="Configuracion_de_Tu_Cuenta_Notificaciones.php" title="Notificaciones">Gestionar correos de Personaling</a></li>
              <li><a href="Desuscribir_de_la_lista_correos.php" title="Desuscribir de la lista correos">Desuscribir de la lista correos</a></li>
            </ul>
            <h5 class="braker_bottom padding_bottom_xsmall margin_top_small">Privacidad </h5>
            <ul>
              <li><a href="Configuracion_de_Tu_Cuenta_Privacidad.php" title="Informacion publica"> Informacion publica</a></li>
              <li><a href="Configuracion_de_Tu_Cuenta_Eliminar_Cuenta.php" title="Eliminar cuenta">Eliminar Cuenta</a> </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /container -->

