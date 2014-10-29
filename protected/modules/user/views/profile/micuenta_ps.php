<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Tu Perfil");
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
        <h5>Invita a tus amig@s</h5>
        <!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style addthis_32x32_style text_align_center">
          <a class="addthis_button_preferred_1"></a>
          <a class="addthis_button_preferred_2"></a>
          <a class="addthis_button_preferred_3"></a>
          <a class="addthis_counter addthis_bubble_style"></a>
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
        
        </div>
        <div class="span4">
        	<h2 class="braker_bottom">Mis Favoritos</h2>
           <ul class="nav nav-stacked nav-tabs">
              <li><?php echo CHtml::link('Looks',array('profile/looksencantan'),array("title"=>"Looks que te encantan")); ?></a></li>
              <li><?php echo CHtml::link('Productos',array('profile/encantan'),array("title"=>"Productos que te encantan")); ?></a></li>
            </ul>
            <h2 class="braker_bottom">  Conecta tus Redes Sociales </h2>
           <ul class="nav nav-stacked nav-tabs">
<!--                <li><a href="#" title="facebook">Facebook (LINK MUERTO)</a></li>
              <li><a href="#" title="Twitter">Twitter (LINK MUERTO)</a></li>
              <li><a href="#" title="Pinterest">Pinterest (LINK MUERTO)</a></li> -->
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

