
  <?php /* @var $this Controller */ ?>
  <?php //date_default_timezone_set('America/Los_Angeles'); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<?php 

Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/css/style.css',null);
// Yii::app()->clientScript->registerLinkTag('stylesheet','text/css','http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700',null,null);
Yii::app()->clientScript->registerLinkTag('shortcut icon','image/x-icon',Yii::app()->getBaseUrl().'/favicon.ico',null,null);  
Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' );
?>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700' rel='stylesheet' type='text/css'>



<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.hoverIntent.minified.js"></script>
</head>

<body class="<?php echo $this->getBodyClasses(); ?>">
  <div class="barra-carga"></div>
  <div id="navegacion_principal">
<?php  

$total = 0; //variable para llevar el numero de notificaciones
$cont_productos = 0 ; //variable para llevar el numero de productos
$contadorMensaje = 0;
//<i class="icon-shopping-cart"></i> <span class="badge badge-important">2</span>


if (Yii::app()->user->id?UserModule::isAdmin():false){
$this->widget('bootstrap.widgets.TbNavbar',array(
	'type'=> 'inverse',
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
 
                //array('label'=>'Personaling', 'url'=>array('/site/index')),
                array('label'=>'Panel de Control', 'url'=>'#', 'items'=>array(
					array('label'=>'General', 'url'=>array('/controlpanel/index')),
					array('label'=>'Ventas', 'url'=>array('/controlpanel/ventas')), 
					array('label'=>'Usuarios', 'url'=>array('/controlpanel/usuarios')),
					array('label'=>'Catálogos', 'url'=>array('/controlpanel/looks')),
					array('label'=>'Acciones', 'url'=>array('/adorno/index')),
          array('label'=>'Activos Graficos', 'url'=>array('/site/activos_graficos')),
					)),
                array('label'=>'Usuarios', 'url'=>array('/user/admin')),
                array('label'=>'Looks', 'url'=>'#', 'items'=>array(
					array('label'=>'Looks', 'url'=>array('/look/admin')),
					array('label'=>'Elementos Gráficos', 'url'=>array('/adorno/index')),
					)),
                array('label'=>'Productos', 'url'=>'#', 'items'=>array(
                	array('label'=>'Productos', 'url'=>array('/producto/admin')),
					array('label'=>'Marcas', 'url'=>array('/marca/admin')),
					)
				),
                array('label'=>'Ventas', 'url'=>'#', 'items'=>array(array('label'=>'Órdenes Registradas', 'url'=>array('/orden/admin')),array('label'=>'Reporte de Ventas', 'url'=>Yii::app()->baseUrl.'/orden/reporte'))),
                array('label'=>'Sistema', 'url'=>'#', 'items'=>array(
                	array('label'=>'Categorías', 'url'=>array('/categoria/admin')),

					         array('label'=>'Campañas', 'url'=>array('/campana/index')),
                  array('label'=>'Gift Cards', 'url'=>array('/giftcard/index')),

					),
				),
               	//array('label'=>'Sistema', 'url'=>array('/site/logout')),
				array('label'=>'Tu Cuenta', 'url'=>'#', 'items'=>array(
                    array('label'=>'Tu Cuenta', 'url'=>array('/user/profile/micuenta')),
                    array('label'=>'Perfil', 'url'=>'#'),
                   
                    '---',
                    array('label'=>'Salir', 'url'=>array('/site/logout')),
                ),
               ),
            ),
        ),
    ),
)); 
} else {
	$cont_productos = 0;
	
		$sql = "select count( * ) as total from tbl_orden where user_id=".Yii::app()->user->id." and estado < 5";
		$total = Yii::app()->db->createCommand($sql)->queryScalar();

    //Consulta de mensajes
    $mensajes = Mensaje::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id,'visible'=>1,'admin'=>NULL));
    if(count($mensajes) > 0){
      foreach($mensajes as $msj)
      {
        if( $msj->estado == 0)
          $contadorMensaje++;
      }
    }
		
  // Buscar usuario para avatar en el menu
	if (Yii::app()->user->id){ 
		$profile = Profile::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));    
		$user = User::model()->findByPk(Yii::app()->user->id);
    $avatar ='';
    if($user){ 
      $file = explode('.',$user->getAvatar());
      $avatar = "<img  src='".$file[0]."_x30.".$file[1]."' class='img-circle avatar_menu' width='30' height='30' />   ";
    }
    
    $Arraynombre = explode(" ",$profile->first_name);
    if(strlen($Arraynombre[0]) > 0)
      $nombre = $Arraynombre[0];
    else
     $nombre = $profile->first_name;

		$bolsa = Bolsa::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));

		if(isset($bolsa))
			$cont_productos = count($bolsa->bolsahasproductos);
		
	} else {
		$nombre = 'N/A';
    $avatar = '';

	}

        $itemsUser = array(
                    array('label'=>'Tus Looks', 'url'=>array('/user/profile/looksencantan')),
                    array('label'=>'Tus Pedidos', 'url'=>array('/orden/listado')),
                    array('label'=>'Invita a tus Amig@s', 'url'=>array('/user/profile/invitaciones')),
                    array('label'=>'Comprar GiftCard', 'url'=>array('/giftcard/comprar')),
                    array('label'=>'Tu Cuenta', 'url'=>array('/user/profile/micuenta')),
                    // array('label'=>'Perfil', 'url'=>'#'),
                    array('label'=>'Ayuda', 'url'=>array('/site/preguntas_frecuentes')),                    
                    '---',
                    array('label'=>'¿Comprando para alguién más?'),
                    //array('label'=>'<a href="#" class="sub_perfil_item"><img width="30" height="30" class="img-circle avatar_menu" src="/develop/images/avatar_provisional_2_x30.jpg">Elise</a>',
//                    array('label'=>'<img width="30" height="30" class="img-circle avatar_menu" src="/develop/images/avatar_provisional_2_x30.jpg">Elise',
//                        'url'=>array(''), 'linkOptions' => array('class' => 'sub_perfil_item'),),                    
                    
                );

        $otrosPerfiles = Filter::model()->findAllByAttributes(array('type' => '0', 'user_id' => Yii::app()->user->id),array('order' => 'id_filter DESC'));

        $verMas = count($otrosPerfiles) > 2;       
        
        $cont = 0;
        
        foreach($otrosPerfiles as $perfil){
            $cont++;
            if(strlen($perfil->name) > 15){
                $perfil->name = substr_replace($perfil->name, " ...", 15);
            }
            
            $itemsUser[] = array('label'=>'<img width="30" height="30" class="img-circle avatar_menu" src="/develop/images/avatar_provisional_2_x30.jpg">'.$perfil->name,
                'url'=>'#',
                'linkOptions' => array('class' => 'sub_perfil_item', 'id' => $perfil->id_filter),
                //'itemOptions' => array('id' => $perfil->id_filter),
                );
            
            if($cont >= 2){
                break;
            }
        }
        $todos = count($otrosPerfiles);
        if($verMas){
           $itemsUser[] =  array('label'=>"Ver todos los perfiles ...",  
                                    'url'=>'#', 'linkOptions' => array('class' => 'sub_perfil_item ver_todos'), //array('/site/preguntas_frecuentes')
                                    );
        }
        

        array_push($itemsUser, array('label'=>'Añadir un nuevo perfil <i class="icon icon-plus"></i>',  
                                    'url'=>'#modalFiltroPerfil', 'linkOptions' => array('data-toggle' => 'modal', 'id' => 'agregar-perfil'), //array('/site/preguntas_frecuentes')
                                    ),                    
                                '---',
                                array('label'=>'Salir', 'url'=>array('//site/logout')));


$this->widget('bootstrap.widgets.TbNavbar',array(
    'collapse' => true,
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'encodeLabel'=>false,
            'items'=>array(
  
                //array('label'=>'Personaling', 'url'=>array('/site/index')),
                
                array('label'=>'Top', 'url'=>array('//site/top'),'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Tu personal Shopper', 'url'=>array('/tienda/look'),'visible'=>Yii::app()->user->isGuest?false:!UserModule::isPersonalShopper()),
                //array('label'=>'Tu personal Shopper', 'url'=>array('/site/personal'),'visible'=>Yii::app()->user->isGuest?false:!UserModule::isPersonalShopper()),
                array('label'=>'Mis Looks', 'url'=>array('/look/mislooks'), 'visible'=>Yii::app()->user->isGuest?false:UserModule::isPersonalShopper()),
                array('label'=>'Crear Look', 'url'=>array('/look/create'), 'visible'=>Yii::app()->user->isGuest?false:UserModule::isPersonalShopper()),
                array('label'=>'¿Cómo funciona?', 'url'=>array('/site/comofunciona')),
                array('label'=>'Tienda', 'url'=>array('/tienda/index')),
                array('label'=>'Magazine', 'url'=>'http://personaling.com/magazine','itemOptions'=>array('id'=>'magazine'),'linkOptions'=>array('target'=>'_blank')),
                array('label'=>'','icon'=>'icon-gift', 'url'=>array('/giftcard/comprar'), 'itemOptions'=>array('class'=>'hidden-phone'), 'visible'=>!Yii::app()->user->isGuest),                 
				array('label'=>$contadorMensaje,'icon'=>'icon-exclamation-sign', 'url'=>array('/site/notificaciones'), 'itemOptions'=>array('id'=>'btn-notifications','class'=>'hidden-phone'), 'visible'=>!Yii::app()->user->isGuest&&$total>0),
                //array('label'=>$cont_productos,'icon'=>'icon-exclamation-sign', 'url'=>array('/orden/listado'), 'visible'=>!Yii::app()->user->isGuest),
                	array('label'=>$cont_productos,'icon'=>'icon-shopping-cart', 'itemOptions'=>array('id'=>'btn-shoppingcart','class'=>'hidden-phone') ,'url'=>array('/bolsa/index') ,'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Ingresa', 'url'=>array('/user/login'), 'itemOptions'=>array('id'=>'ingresa'),'visible'=>Yii::app()->user->isGuest),
                //******* MODIFICACION EN TbBaseMenu.php PARA PODERLE COLOCAR CLASE AL BOTON *******//
                array('label'=>"Regístrate", 'url'=>array('/user/registration'), 'type'=>'danger', 'htmlOptions'=>array('class'=>'btn btn-danger'),'visible'=>Yii::app()->user->isGuest),
                //array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                //array('label'=>$avatar.$nombre, 'url'=>'#','itemOptions'=>array('id'=>'dropdownUser'), 'items'=> $itemsUser,
                array('label'=>$avatar."<span id='userName'>{$nombre}</span>", 'url'=>'#','itemOptions'=>array('id'=>'dropdownUser'), 'items'=> $itemsUser,
                'visible'=>!Yii::app()->user->isGuest,
				),
            ),
        ), 

    ),
));


}

?>
</div>
<?php
if(!Yii::app()->user->isGuest){
	$user = User::model()->findByPk(Yii::app()->user->id);
	
	if($user->status == 0){
		?>
		<div id="notificacion_validar" class="alert-block alert-error text_align_center">
			Tu cuenta no ha sido validada. 
			<?php
			echo CHtml::ajaxLink(
				'Reenviar correo de validación.', 
				$this->createUrl('user/registration/sendValidationEmail'), 
				array('success'=>'function(data){
					$("#notificacion_validar").html(data);
					$("#notificacion_validar").removeClass();
					$("#notificacion_validar").addClass("alert alert-success margin_top padding_top text_align_center");
				}'), 
				array()
			);
			?>
		</div>
    <div style="height: 48px"></div>
		<?php
	}
}
?>

<!-- Popovers ON -->

 <?php   
    if(!Yii::app()->user->isGuest){
        $bolsa = Bolsa::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));

        if (!is_null($bolsa)){
	        // Consulta si hay Looks
	        $sql = "select count( *   ) as total from tbl_bolsa_has_productotallacolor where look_id != 0 and bolsa_id = ".$bolsa->id."";
	        $cantidadLooks = Yii::app()->db->createCommand($sql)->queryScalar();
	 
	        //Consulta si hay productos individuales
	        $sql = "select count( * ) as total from tbl_bolsa_has_productotallacolor where look_id = 0 and bolsa_id = ".$bolsa->id."";
	        $cantidadProductosIndiv = Yii::app()->db->createCommand($sql)->queryScalar();        
	
	        $bptcolor = BolsaHasProductotallacolor::model()->findAllByAttributes(array('bolsa_id'=>$bolsa->id,'look_id'=> 0));
        } else {
        	$cantidadLooks = 0;
        	$cantidadProductosIndiv = 0;
        }

    }
  ?> 
 


<!-- <div class="alert alert-error margin_top padding_top">Estas en el sitio de Pruebas T1</div> -->
<div class="container" id="page">
  <?php if(isset($this->breadcrumbs)):?>
  <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?>
  <!-- breadcrumbs -->
  <?php endif?>
  <?php echo $content; ?> </div>
<!-- page -->
<div id="modalAjax"></div>
<div id="wrapper_footer">
  <footer class="container">
    <div class="row hidden-phone">
      <div class="span3">
        <h3>Links rápidos</h3>
        <ul>
          <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/formas_de_pago" title="Formas de Pago">Formas de Pago</a></li>
          <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/condiciones_de_envios_y_encomiendas" title="Envíos y Encomiendas">Envíos y Encomiendas</a></li>
          <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/politicas_de_devoluciones" title="Políticas de Devoluciones">Políticas de Devoluciones</a></li>
          <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/politicas_y_privacidad" title="Políticas de Privacidad">Políticas de Privacidad</a></li>
          <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/preguntas_frecuentes" title="Preguntas Frecuentes">Preguntas Frecuentes</a></li>
          <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/terminos_de_servicio" title="Términos de Servicio">Términos de Servicio</a></li>
          <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/acerca_de" title="Acerca de">Acerca de Personaling</a></li>
          <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/contacto" title="Contacto">Contáctanos</a></li>
          <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/equipo_personaling" title="El Equipo Personaling">El Equipo Personaling</a></li>
          <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/sitemap" title="Site Map">Site map</a></li>          
          <!-- <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/user/registration/aplicarPS" title="Aplicar para Personal Shopper">Aplicar para Personal Shopper</a></li> -->
          
        </ul>
      </div>
      <div class="span5 ">
        <h3> Sobre Personaling </h3>
        <p class="lead">Personaling, es un portal de moda y belleza en donde tendrás la oportunidad de adquirir prendas y accesorios de un portafolio de marcas prestigiosas, personalizadas y combinadas conforme a tu gusto, preferencias, necesidades y características personales sin que te muevas de tu casa u oficina.</p>
        <div class="row-fluid"><div class="span8"><img class="margin_top_medium_minus at_exclude" src=" <?php echo Yii::app()->getBaseUrl(); ?>/images/logos_seguridad.png" alt="Logos de Seguridad">
                        </div><div class="span4"><script type="text/JavaScript">
                                //<![CDATA[
                                var sealServer=document.location.protocol+"//seals.websiteprotection.com/sealws/525d3892-d158-46f3-aacd-5777cbdd56cb.gif";var certServer=document.location.protocol+"//certs.websiteprotection.com/sealws/?sealId=525d3892-d158-46f3-aacd-5777cbdd56cb";var hostName="personaling.com";document.write(unescape('<div style="text-align:center;margin:0 auto;"><a target="_blank" href="'+certServer+'&pop=true" style="display:inline-block;"><img src="'+sealServer+'" alt="Website Protection&#153; Site Scanner protects this website from security threats." title="This Website Protection site seal is issued to '+ hostName +'. Copyright &copy; 2013, all rights reserved."oncontextmenu="alert(\'Copying Prohibited by Law\'); return false;" border="0" /></a><div id="bannerLink"><a href="https://www.godaddy.com/" target="_blank">Go Daddy</a></div></div>'));
                                //]]>
                                </script></div></div>
      </div>
      <div class="span3 offset1 ">
        <h3>¡Síguenos! </h3>
        <div class="textwidget"> <a title="Personaling en Facebook" href="https://www.facebook.com/Personaling" target="_blank"><img width="40" height="40" title="Personaling en Facebook" src="<?php echo Yii::app()->baseUrl ?>/images/icon_facebook.png"></a> <a title="Personaling en Twitter" href="https://twitter.com/personaling" target="_blank"> <img width="40" height="40" title="Personaling en Twitter" src="<?php echo Yii::app()->baseUrl ?>/images/icon_twitter.png"></a> <a title="Pinterest" href="https://pinterest.com/personaling/" target="_blank"><img width="40" height="40" title="Personaling en Pinterest" src="<?php echo Yii::app()->baseUrl ?>/images/icon_pinterest.png"></a> <a title="Personaling en Instagram" href="http://instagram.com/personaling" target="_blank"><img width="40" height="40" title="Personaling en Instagram" src="<?php echo Yii::app()->baseUrl ?>/images/icon_instagram.png"></a>
        <a title="Personaling en Youtube" href="http://www.youtube.com/channel/UCe8aijeIv0WvrZS-G-YI3rQ" target="_blank"><img width="40" height="40" title="Personaling en Youtube" src="<?php echo Yii::app()->baseUrl ?>/images/icon_youtube.png"></a>
          </div>
        <hr/>
        <p>Nos Avalan</p>
        <a href="http://ve.wayra.org/es/startup/personaling" target="_blank"><img  src="<?php echo Yii::app()->getBaseUrl(); ?>/images/logo_wayra.png" alt="Wayra" title="Wayra"></a>
        <a href="http://wiki.ideas.org.ve/index.php/Portal_e-commerce_Personaling_gana_Concurso_Ideas_2013" target="_blank"><img  src="<?php echo Yii::app()->getBaseUrl(); ?>/images/logo_ideas.png" alt="Ideas" title="Concurso Ideas"></a>
        <p class="margin_top_small">Afiliados a</p>
        <img class="margin_top_small_minus" src="<?php echo Yii::app()->getBaseUrl(); ?>/images/logos_partners.png" alt="Logos de Partners">
      </div>
    </div>
    <hr/>
    <div class="row">
      <div class="span12 text_align_center creditos">Personaling C.A &reg; <?php echo date("Y"); ?> RIF: J-40236088-6 | Todos los derechos reservados<br/>
       Programado en Venezuela por <a href="http://cooltribes.com" title="Connecting true fans" target="_blank">Cooltribes.com</a> </div>
    </div>
  </footer>
</div>

<script >
  
  $(document).on('ready',HandlerReady);

  <?php 

        $htmlMensaje = '';
         echo 'var contenidoMensajes = ""; ';
        // Si el usuario no es administrador buscar mensajes para mostrar
        if(! (Yii::app()->user->id?UserModule::isAdmin():false) ){
          if(count($mensajes) > 0){
            $mensajes_Reverse = array_reverse( $mensajes ); // volveo el array para mostrar en orden cronologico
            array_splice( $mensajes_Reverse ,4);
            $htmlMensaje='<ul>';
            foreach( $mensajes_Reverse  as $msj)
            {
              if ($msj->estado == 0)
                $htmlMensaje=$htmlMensaje." <li class='bg_color10' >De: <strong>Admin</strong> <br/><strong>Asunto:</strong>  ".$msj->asunto.'</li> ';
              else
                $htmlMensaje=$htmlMensaje.' <li >De: <strong>Admin</strong> <br/><strong>Asunto:</strong> '.$msj->asunto.'</li> ';                
            }
            $htmlMensaje=$htmlMensaje.'</ul>';
          }

          echo 'contenidoMensajes = "'.$htmlMensaje.'";';

        }


  ?>


  function HandlerReady () {
    // //Boton Notificaciones

    contenidoMensajes = contenidoMensajes + '<div class="padding_right_xsmall padding_left_xsmall padding_bottom_xsmall"><a href="<?php echo Yii::app()->baseUrl; ?>/site/notificaciones"  class="btn btn-block btn-small btn-warning">Ver notificaciones</a></div>';

    $('#btn-notifications').popover(
    {
      title: '<strong>Notificaciones ('+ <?php echo $contadorMensaje ?>+')</strong>',
      content: contenidoMensajes,
      placement: 'bottom',
      trigger: 'manual',
      html: true,
    });

    $('#btn-notifications').hoverIntent(function(){
        $(this).popover('show');
        $(this).addClass('bg_color10');
        $('.popover').addClass('active_two');
      },
      function(){
        $('.active_two').hover(function(){},function(){
          $('#btn-notifications').popover('hide');
          $('#btn-notifications').removeClass('bg_color10');
        });   

      });
        $('.active_two').hover(function(){},function(){
          $('#btn-notifications').popover('hide');
          $('#btn-notifications').removeClass('bg_color10');
          });  

        $('#magazine').hover(function(){
          $('#btn-notifications').popover('hide');          
          $('#btn-notifications').removeClass('bg_color10');

        },function(){});

        $('#btn-shoppingcart').hover(function(){
          $('#btn-notifications').popover('hide');          
          $('#btn-notifications').removeClass('bg_color10');          
        },function(){});

    
    var listaCarrito;

    //------------Generar html para poner en Popover ON---------------//
    <?php if(!Yii::app()->user->isGuest){

      $contadorItems = 0 ;

      //Si hay Looks en la bolsa del usuario
      if($cantidadLooks!=0){

          $clases = '" unstyled clearfix"';
          echo "listaCarrito = '<ul class=".$clases." >";
          $bolsa_Reverse = array_reverse($bolsa->looks());
          
          foreach ($bolsa_Reverse as $look_id) {

              if($contadorItems > 5){
                break;
              }

              $bolsahasproductotallacolor = BolsaHasProductotallacolor::model()->findAllByAttributes(array('bolsa_id'=>$bolsa->id,'look_id' => $look_id));
              $look = Look::model()->findByPk($look_id);
        if (isset($look)){
                echo '<li>';
                echo '<a class="btn-link" href="'.$look->getUrl().'" >'.$look->title.'</a>';
                echo '<div class="row-fluid">';
  
                //invertir array para mostrar en orden cronológico de compras
  
                foreach ($bolsahasproductotallacolor as $productotallacolor) {
                    $color = Color::model()->findByPk($productotallacolor->preciotallacolor->color_id)->valor;
                    $talla = Talla::model()->findByPk($productotallacolor->preciotallacolor->talla_id)->valor;
                    $producto = Producto::model()->findByPk($productotallacolor->preciotallacolor->producto_id);
                    $imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'orden'=>'1'));
                    if($imagen){
                        $htmlimage = CHtml::image(Yii::app()->baseUrl . str_replace(".","_x30.",$imagen->url), "Imagen ", array("width" => "30", "height" => "30"));
                        echo '<div class="span2">'.$htmlimage.'</div>';
                    }
                }
                echo '</div>';
                echo "</li>";
                $contadorItems ++;
              }
          }
          if($cantidadProductosIndiv!=0){
              echo "';";
          }
      }
      elseif($cantidadProductosIndiv!=0){
          echo "listaCarrito = '<ul>';";
      }

      //Si hay producto individuales en la bolsa del usuario
      if( $cantidadProductosIndiv != 0 ){
          if(isset($bptcolor)){ 
            echo "\n    listaCarrito = listaCarrito + '";

            $bptcolor_Rev = array_reverse($bptcolor);

            foreach($bptcolor_Rev as $detalles){ // cada producto en la bolsa

              if($contadorItems >= 5){
                break;
              }

                $todo = Preciotallacolor::model()->findByPk($detalles->preciotallacolor_id);                
                $producto = Producto::model()->findByPk($todo->producto_id);
                $talla = Talla::model()->findByPk($todo->talla_id);
                $color = Color::model()->findByPk($todo->color_id);                  
                $imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'orden'=>'1'));
                echo "<li>";
                echo '<a class="btn-link" href="'.$producto->getUrl().'" >'.$producto->nombre.'</a>';
                echo '<div class="row-fluid">';
                 
                if($imagen){
                    $htmlimage = CHtml::image(Yii::app()->baseUrl . str_replace(".","_x30.",$imagen->url), "Imagen ", array("width" => "30", "height" => "30"));
                    echo '<div class="span2">'.$htmlimage.'</div>';
                }                
                echo '</div>';                
                echo "</li>";
                $contadorItems ++;

            }
            echo "</ul>';";    
          }  
      }
      elseif( $cantidadLooks != 0 ){
          echo "</ul>';";
      }


    }
    ?>

    //------------Generar html para poner en Popover OFF---------------//

    textShoppingCart = '<div class="padding_right_xsmall padding_left_xsmall padding_bottom_xsmall"><a href="<?php echo Yii::app()->baseUrl; ?>/bolsa/index" class="btn btn-block btn-small btn-warning">Ver carrito</a></div>';

    if( listaCarrito != "" ){
        textShoppingCart = listaCarrito + textShoppingCart;
    }  
    if(<?php echo $cont_productos ?> == 0){
      textShoppingCart = '<p class="padding_small"><strong>Tu carrito todavía esta vacío</strong>, ¿Qué esperas? Looks y prendas increíbles esperan por ti.</p>';
    }
 
    //Boton Shopping Cart
    $('#btn-shoppingcart').popover(
    {
      html: true,
      title: '<strong>Tu Carrito ('+ <?php echo $cont_productos  ?>+')</strong>',
      content: textShoppingCart,
      placement: 'bottom',
      trigger: 'manual',
      offset: 10
    });


    $('#btn-shoppingcart').hoverIntent(
      function(){

        $(this).popover('show');
        $(this).addClass('bg_color10');
        $('.popover').addClass('active_one');        

      },
      function(){

        $('.active_one').hover(function(){},function(){
          $('#btn-shoppingcart').popover('hide');
          $('#btn-shoppingcart').removeClass('bg_color10');
        });        

      });

    $('#dropdownUser, #btn-notifications,#magazine').hover(function(){
      $('#btn-shoppingcart').popover('hide');      
      $('#btn-shoppingcart').removeClass('bg_color10');              
    },function(){});
    
    $('#dropdownUser').hoverIntent(function(){
        if( !($(this).attr('class') =='dropdown open') ){          
          $(this).addClass('open');
        }
    },function(){
      // $('#dropdownUser').removeClass('open');
      $('#page').hover(function(){
        $('#dropdownUser').removeClass('open');
      },function(){});        
    });

    $('#btn-shoppingcart, #btn-notifications').hover(function(){
      $('#dropdownUser').removeClass('open');
    },function(){});        

    $('#dropdownUser').on('click',function(){
        $(this).removeClass('open');      
    });
 
 
     //Elemento li del menu de usuario para agregar un nuevo filtro
    $('#agregar-perfil').click(function(e){
                
        var urlActual = "<?php echo CController::createUrl(""); ?>";
        var tiendaLooks = "<?php echo CController::createUrl("/tienda/look"); ?>";        
        var redirect = "<?php echo CController::createUrl("/tienda/redirect"); ?>";        
        //si esta en tienda de looks
        if(urlActual === tiendaLooks){
            clickAgregar();
        }else{
        
        //Llevar a tienda de looks
            
            $.ajax({
                type: 'POST',
                url: redirect,
                dataType: 'JSON',
                data: {agregar : 1},
                success: function(data){

                    if(data.status == 'success'){

                      window.location = tiendaLooks;  

                    }else if(data.status == 'error'){
                        

                    }
                }
            });
        }
        
    });
    
    //Click para seleccionar un peril de la lista que esta en el dropdown User
    $("#dropdownUser a.sub_perfil_item:not(.ver_todos), #modalPerfilesOcultos li a").click(function(e){
        e.preventDefault();
        var urlActual = "<?php echo CController::createUrl(""); ?>";
        var tiendaLooks = "<?php echo CController::createUrl("/tienda/look"); ?>";        
        var redirect = "<?php echo CController::createUrl("/tienda/redirect"); ?>";        
        //si esta en tienda de looks
        if(urlActual === tiendaLooks){
            clickPerfil($(this).prop("id"));
        }else{
        
        //Llevar a tienda de looks
            var datos = $(this).prop("id");
            $.ajax({
                type: 'POST',
                url: redirect,
                dataType: 'JSON',
                data: {perfil : datos},
                success: function(data){

                    if(data.status == 'success'){

                      window.location = tiendaLooks;  

                    }else if(data.status == 'error'){
                        

                    }
                }
            });
        }
       
    });
    
    //Click en el elemento del dropdown para ver todos los perfiles ocultos
    $("#dropdownUser .ver_todos").click(function(e){
        e.preventDefault();
        
//        $("#modalPerfilesOcultos").modal("show");
//        
//        return;
        //Llevar a tienda de looks
            var urlModal = "<?php echo CController::createUrl("/tienda/modalAjax"); ?>";  
            
            
            $.ajax({
                type: 'POST',
                url: urlModal,
                dataType: 'JSON',
                data: {modal : "perfiles"},
                success: function(data){
                    $("#modalAjax").empty();
                    $("#modalAjax").html(data.data);
                    $("#modalPerfilesOcultos").modal("show");
                    
                }
            });
        
       
    });
 
 
  }



</script>

<!-- Popovers OFF -->

<!-- Google Analytics -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-1015357-44']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>


</body>
</html>
