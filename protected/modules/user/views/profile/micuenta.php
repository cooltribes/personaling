
<div class="container margin_top">
  <div class="row">
    <div class="span3">
      <div class="shadow_1"> <img src="http://placehold.it/270x200"/>
        <h4><?php echo $profile->first_name." ".$profile->last_name; ?></h4>
        <p class="muted">Miembro desde: <?php echo $model->create_at; ?></p>
        <hr/>
        <h4>Tus Compras</h4>
        <ul>
          <li>XX Bs. de Balance en tu Cuenta</li>
          <li>XX Puntos Ganados</li>
          <li>XX Pedidos Activos</li>
          <li>XX Devoluciones Pendientes</li>
        </ul>
        <hr/>
        <ul>
          <li>XX Looks que te Encantan</li>
          <li>XX Productos que te Encantan</li>
          <li>XX Looks recomendados para ti</li>
        </ul>
        <hr/>
        Invita a tus amig@s
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
              <li> <?php echo CHtml::link('Tus datos personales',array('profile/edit'),array("title"=>"Edita tus datos personales")); ?></li>
              <li> <?php echo CHtml::link('avatar',array('profile/avatar'),array("title"=>"Edita tu avatar")); ?></li>
              <li> <?php echo CHtml::link('Tu perfil corporal',array('profile/edittutipo'),array("title"=>"Edita tu perfil corporal")); ?></li>
              <li> <a href="#" title="Tu perfil publico">Tu perfil publico</a></li>
            </ul>
            <h5 class="braker_bottom padding_bottom_xsmall margin_top_small"> Tu Estilo </h5>
            <ul>
                 <li><?php echo CHtml::link('Casual',array('profile/edittuestilo'),array("title"=>"Edita tu estilo Casual")); ?></li>
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
      <?php /*?>
	  // Fase numero II
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
              <li> <?php echo CHtml::link('Cambiar Contraseña',array('changepassword'),array("title"=>"Cambia tu contraseña")); ?></a></li>
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
              <li>Gestionar correos de Personaling</li>
              <li>Desuscribir de la lista correos</li>
            </ul>
            <h5 class="braker_bottom padding_bottom_xsmall margin_top_small">Privacidad </h5>
            <ul>
              <li> Informacion publica</li>
              <li>Eliminar Cuenta </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

