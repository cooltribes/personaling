<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->breadcrumbs=array(
	//UserModule::t("Profile")=>array('profile'),
	UserModule::t("Mi cuenta"),
);
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
          <div class="card_numbers clearfix"> <span class="T_xlarge margin_top_xsmall">01</span>
            <p>Looks que te Encantan</p>
          </div>
          <div class="card_numbers clearfix"> <span class="T_xlarge margin_top_xsmall">23</span>
            <p>Productos que te Encantan</p>
          </div>
          <div class="card_numbers clearfix"> <span class="T_xlarge margin_top_xsmall">18</span>
            <p>Looks recomendados para ti</p>
          </div>
        </div>
        <hr/>
        <h5>Tus Compras</h5>
        <ul class="nav nav-stacked text_align_center" >
          <li>XX Bs. de Balance en tu Cuenta</li>
          <li>XX Puntos Ganados</li>
          <li>XX Pedidos Activos</li>
          <li>XX Devoluciones Pendientes</li>
        </ul>
        <hr/>
        <h5>Invita a tus amig@s</h5>
        <!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style addthis_32x32_style text_align_center"> <a class="addthis_button_preferred_1"></a> <a class="addthis_button_preferred_2"></a> <a class="addthis_button_preferred_3"></a> <a class="addthis_button_preferred_4"></a> <a class="addthis_button_compact"></a> <a class="addthis_counter addthis_bubble_style"></a> </div>
        <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script> 
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=juanrules"></script> 
        <!-- AddThis Button END --> 
    </aside>
    <div class="span9 configuracion_perfil">
      <div class="well">
        <div class="row">
          <div class="span4">
            <h2 class="braker_bottom">  Tu Perfil </h2>
           <ul class="nav nav-stacked nav-tabs">
              <li> <a href="Tu_Perfil_Tus_datos_Personales_Usuaria.php" title="Datos personales">Tus datos personales </a></li>
              <li> <a href="Tu_Perfil_Avatar_Usuaria.php" title="Avatar">Tu Avatar</a></li>
              <li> <a href="Tu_Perfil_Perfil_Corporal_Usuaria.php" title="Tu perfil corporal">Tu perfil corporal</a></li>
              <li> <a href="#" title="Tu perfil publico">Tu perfil publico</a></li>
              <li> <a href="Editar_Perfil_Usuaria_Mi_Tipo.php" title="Tu Tipo">Tu Tipo</a></li>

            </ul>
           
          </div>
          <div class="span4">
          
          <h2 class="braker_bottom"> Tus Pedidos </h2>
            <ul class="nav nav-stacked nav-tabs">
              <li><a href="#" title="Pedidos por pagar o por recibir">Pedidos Activos (falta por enlazar y quitar este texto)</a></li>
              <li><a href="/orden/listado" title="Tus pedidos nuevos y anteriores">Historial de Pedidos</a></li>
            </ul>
             
          </div>
        </div>
        
        <div class="row">
        <div class="span4">
         <h2 class="braker_bottom">  Tu Estilo </h2>
           <ul class="nav nav-stacked nav-tabs">
                 <li><a href="Tu_Personaling_Tu Estilo_Casual_Usuaria.php" title="Casual">Casual</a></li>
    <li><a href="Tu_Personaling_Tu Estilo_Casual_Usuaria.php" title="Coctel">Coctel</a></li>
    <li><a href="Tu_Personaling_Tu Estilo_Casual_Usuaria.php" title="Fiesta">Fiesta</a></li>
    <li><a href="Tu_Personaling_Tu Estilo_Casual_Usuaria.php" title="Playa">Playa</a></li>
    <li><a href="Tu_Personaling_Tu Estilo_Casual_Usuaria.php" title="Sport">Sport</a></li>
    <li><a href="Tu_Personaling_Tu Estilo_Casual_Usuaria.php" title="Trabajo">Trabajo</a></li>
            </ul>
        
        </div>
        <div class="span4">
        	<h2 class="braker_bottom">Tus Encantos/Favoritos </h2>
           <ul class="nav nav-stacked nav-tabs">
              <li><a href="Tu_Personaling_Tus_EncantosFavoritos_Looks.php" title="Tus Looks favoritos">Looks</a></li>
              <li><a href="Tu_Personaling_Tus_EncantosFavoritos_productos.php" title="Tus productos favoritos">Productos</a></li>
            </ul>
            <h2 class="braker_bottom">  Conecta tus Redes Sociales </h2>
           <ul class="nav nav-stacked nav-tabs">
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
             <h2 class="braker_bottom">Tus Looks</h2>
           <ul class="nav nav-stacked nav-tabs">
              <li><a href="#" title="Tus Looks Publicados">Tus Looks Publicados</a></li>
              <li><a href="#" title="Tus Looks Pendientes por aprobació">Tus Looks Pendientes por aprobación</a></li>
              <li>
              		<?php $this->widget('bootstrap.widgets.TbButton', array(
					    'label'=>'Crear Look',
					    'type'=>'danger',
						'url'=>array('//look/create')	,    
					)); ?> 
              	
              </li>
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
              <li><a href="cambiar_Correo_electronico.php" title="cambiar corre electronico">Cambiar correo electrónico</a></li>
              <li> <a href="cambiar_Contrasena.php" title="cambiar contrasena">Cambiar contraseña</a></li>
            </ul>
             <h2 class="braker_bottom">Libreta de Direcciones </h2>
           <ul class="nav nav-stacked nav-tabs"> 
              <li>Gestionar direcciones de Envios y Pagos.</li>
              <li>Anadir nueva direccion</li>
            </ul>
          </div> 
          <div class="span4">
             <h2 class="braker_bottom">Notificaciones </h2>
           <ul class="nav nav-stacked nav-tabs">
              <li><a href="Configuracion_de_Tu_Cuenta_Notificaciones.php" title="Notificaciones">Gestionar correos de Personaling</a></li>
              <li><a href="Desuscribir_de_la_lista_correos.php" title="Desuscribir de la lista correos">Desuscribir de la lista correos</a></li>
            </ul>
             <h2 class="braker_bottom">Privacidad </h2>
           <ul class="nav nav-stacked nav-tabs">
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

