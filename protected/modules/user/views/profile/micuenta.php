<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
//$this->breadcrumbs=array(
	//UserModule::t("Profile")=>array('profile'),
	//UserModule::t("Mi cuenta"),
//);
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
      		<li><?php echo Yii::app()->numberFormatter->formatDecimal($sum); ?> Bs. de Balance en tu Cuenta</li>
      	<?php
      	}
      	else
      	{
      	?>
      		<li><?php echo Yii::app()->numberFormatter->formatDecimal($sum); ?> Bs. que adeudas.</li>
      	<?php
      	}
      	?>
        <li>XX Puntos Ganados</li>
        
        <?php
        
        $total;
	
		$sql = "select count( * ) as total from tbl_orden where user_id=".Yii::app()->user->id." and estado < 5";
		$total = Yii::app()->db->createCommand($sql)->queryScalar();
      	?>
      	<li><?php echo $total; ?> Pedidos Activos</li>
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
    <h1>Panel de control</h1>
      <div class="well">
        <div class="row">
          <div class="span4">
            <h2 class="braker_bottom"> Tu Perfil</h2>
            <ul class="nav nav-stacked nav-tabs">
              <li> <?php echo CHtml::link('Tus datos personales',array('profile/edit'),array("title"=>"Edita tus datos personales")); ?></li>
              <li> <?php echo CHtml::link('Tu avatar',array('profile/avatar'),array("title"=>"Edita tu avatar")); ?></li>
              <li> <?php echo CHtml::link('Tu perfil corporal',array('profile/edittutipo'),array("title"=>"Edita tu perfil corporal")); ?></li>
              <li> <a href="#" title="Tu perfil público">Tu perfil público</a></li>
            </ul>
          </div>
          <div class="span4">
            <h2 class="braker_bottom"> Tus Pedidos </h2>
            <ul class="nav nav-stacked nav-tabs">
            	<li> <?php echo CHtml::link('Pedidos Activos',array('/orden/listado'),array("title"=>"Tus pedidos activos")); ?></li>
            	<li> <?php echo CHtml::link('Historial de Pedidos',array('/orden/listado'),array("title"=>"Tus pedidos nuevos y anteriores")); ?></li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="span4">
            <h2 class="braker_bottom"> Tu Estilo </h2>
            <ul class="nav nav-stacked nav-tabs">
              <li><?php echo CHtml::link('Coctel',array('profile/edittuestilo','id'=>'coctel'),array("title"=>"Edita tu estilo Coctel")); ?></li>
              <li><?php echo CHtml::link('Fiesta',array('profile/edittuestilo','id'=>'fiesta'),array("title"=>"Edita tu estilo Fiesta")); ?></li>
              <li><?php echo CHtml::link('Playa',array('profile/edittuestilo','id'=>'playa'),array("title"=>"Edita tu estilo Playa")); ?></li>
              <li><?php echo CHtml::link('Sport',array('profile/edittuestilo','id'=>'Sport'),array("title"=>"Edita tu estilo Sport")); ?></li>
              <li><?php echo CHtml::link('Trabajo',array('profile/edittuestilo','id'=>'trabajo'),array("title"=>"Edita tu estilo Trabajo")); ?></li>
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
              <li><a href="#" title="facebook">Facebook (LINK MUERTO)</a></li>
              <li><a href="#" title="Twitter">Twitter (LINK MUERTO)</a></li>
              <li><a href="#" title="Pinterest">Pinterest (LINK MUERTO)</a></li>
           
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
              <li><a href="#" title="Agregar una nueva dirección">Añadir nueva dirección (LINK MUERTO)</a></li>
            </ul>
          </div>
          <div class="span4">
            <h2 class="braker_bottom"> Notificaciones </h2>
            <ul class="nav nav-stacked nav-tabs">
              <li><?php echo CHtml::link('Gestionar correos de Personaling',array('notificaciones'),array("title"=>"Gestionar correos de Personaling")); ?></li>
              <li><a href="#" title="Desuscribirse de la lista de correos">Darte de baja de la lista correos (LINK MUERTO)</a></li>
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
