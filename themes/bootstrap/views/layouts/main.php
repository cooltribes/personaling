<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->getBaseUrl(); ?>/favicon.ico">

<?php //Yii::app()->bootstrap->register(); ?>
<!-- Le STYLES -->
<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.css" /> -->


<?php Yii::app()->less->register(); ?>
<?php Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' ); ?>
<!-- Le FONTS -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700' rel='stylesheet' type='text/css'>



<script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.hoverIntent.minified.js"></script>
</head>

<body class="<?php echo $this->getBodyClasses(); ?>">
  <div id="navegacion_principal">
<?php  

$total = 0; //variable para llevar el numero de notificaciones
$cont_productos = 0 ; //variable para llevar el numero de productos
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
					array('label'=>'Ventas', 'url'=>array('/adorno/index')),
					array('label'=>'Usuarios', 'url'=>array('/adorno/index')),
					array('label'=>'Catálogos', 'url'=>array('/adorno/index')),
					array('label'=>'Acciones', 'url'=>array('/adorno/index')),
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
                array('label'=>'Ventas', 'url'=>array('/orden/admin')),
                array('label'=>'Sistema', 'url'=>'#', 'items'=>array(
                	array('label'=>'Categorías', 'url'=>array('/categoria/admin')),
					array('label'=>'Campañas', 'url'=>array('/campana')),
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
		
	if (Yii::app()->user->id){ 
		$profile = Profile::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));    
		$user = User::model()->findByPk(Yii::app()->user->id);
    $avatar ='';
    if($user){ 
      $avatar = "<img  src='".$user->getAvatar()."' class='img-circle avatar_menu' width='30' height='30' />   ";
    }
    $nombre = $profile->first_name.' '.$profile->last_name;
		$bolsa = Bolsa::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));

		if(isset($bolsa))
			$cont_productos = count($bolsa->bolsahasproductos);
		
	} else {
		$nombre = 'N/A';
    $avatar = '';

	}


$this->widget('bootstrap.widgets.TbNavbar',array(
    'collapse' => true,
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'encodeLabel'=>false,
            'items'=>array(
  
                //array('label'=>'Personaling', 'url'=>array('/site/index')),
                
                array('label'=>'Top', 'url'=>array('/site/top'),'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Tu personal Shopper', 'url'=>array('/site/personal'),'visible'=>Yii::app()->user->isGuest?false:!UserModule::isPersonalShopper()),
                array('label'=>'Mis Looks', 'url'=>array('/look/mislooks'), 'visible'=>Yii::app()->user->isGuest?false:UserModule::isPersonalShopper()),
                array('label'=>'Crear Look', 'url'=>array('/look/create'), 'visible'=>Yii::app()->user->isGuest?false:UserModule::isPersonalShopper()),
                array('label'=>'Tienda', 'url'=>array('/tienda/index')),
                array('label'=>'Magazine', 'url'=>'http://personaling.com/magazine','itemOptions'=>array('id'=>'magazine')),
				        array('label'=>$total,'icon'=>'icon-exclamation-sign', 'url'=>array('/site/notificaciones'), 'itemOptions'=>array('id'=>'btn-notifications','class'=>'hidden-phone'), 'visible'=>!Yii::app()->user->isGuest&&$total>0),
                //array('label'=>$cont_productos,'icon'=>'icon-exclamation-sign', 'url'=>array('/orden/listado'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>$cont_productos,'icon'=>'icon-shopping-cart', 'itemOptions'=>array('id'=>'btn-shoppingcart','class'=>'hidden-phone') ,'url'=>array('/bolsa/index') ,'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Ingresa', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
                //******* MODIFICACION EN TbBaseMenu.php PARA PODERLE COLOCAR CLASE AL BOTON *******//
                array('label'=>"Regístrate", 'url'=>array('/user/registration'), 'type'=>'danger', 'htmlOptions'=>array('class'=>'btn btn-danger'),'visible'=>Yii::app()->user->isGuest),
                //array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>$avatar.$nombre, 'url'=>'#','itemOptions'=>array('id'=>'dropdownUser'), 'items'=>array(
                    array('label'=>'Tus Looks', 'url'=>array('/user/profile/looksencantan')),
                    array('label'=>'Tus Pedidos', 'url'=>array('/orden/listado')),
                    array('label'=>'Invita a tus Amig@s', 'url'=>array('/')),
                    array('label'=>'Tu Cuenta', 'url'=>array('/user/profile/micuenta')),
                    // array('label'=>'Perfil', 'url'=>'#'),
                    array('label'=>'Ayuda', 'url'=>array('/site/preguntas_frecuentes')),                    
                    '---',
                    array('label'=>'Salir', 'url'=>array('/site/logout')),
                ),
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
		<div id="notificacion_validar" class="alert alert-error text_align_center">
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
 
<script type="text/javascript">
  
  $(document).on('ready',HandlerReady);

  function HandlerReady () {
    // //Boton Notificaciones
    $('#btn-notifications').popover(
    {
      title: '<strong>Notificaciones ('+ <?php echo $total ?>+')</strong>',
      content: '<a href="<?php echo Yii::app()->baseUrl; ?>/site/notificaciones"  class="btn btn-block btn-small btn-warning">Ver notificaciones</a>',
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

        $('#magazine').hover(function(){
          $('#btn-notifications').popover('hide');          
          $('#btn-notifications').removeClass('bg_color10');

        },function(){});

        $('#btn-shoppingcart').hover(function(){
          $('#btn-notifications').popover('hide');          
          $('#btn-notifications').removeClass('bg_color10');          
        },function(){});

      });

    
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
              echo '<li>';
              echo '<a class="btn-link" href="'.Yii::app()->baseUrl .'/look/'.$look_id.'" >'.$look->title.'</a>';
              echo '<div class="row-fluid">';

              //invertir array para mostrar en orden cronológico de compras

              foreach ($bolsahasproductotallacolor as $productotallacolor) {
                  $color = Color::model()->findByPk($productotallacolor->preciotallacolor->color_id)->valor;
                  $talla = Talla::model()->findByPk($productotallacolor->preciotallacolor->talla_id)->valor;
                  $producto = Producto::model()->findByPk($productotallacolor->preciotallacolor->producto_id);
                  $imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'orden'=>'1'));
                  if($imagen){
                      $htmlimage = CHtml::image(Yii::app()->baseUrl . str_replace(".","_thumb.",$imagen->url), "Imagen ", array("width" => "40", "height" => "40"));
                      echo '<div class="span2">'.$htmlimage.'</div>';
                  }
              }
              echo '</div>';
              echo "</li>";
              $contadorItems ++;
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

                $todo = PrecioTallaColor::model()->findByPk($detalles->preciotallacolor_id);                
                $producto = Producto::model()->findByPk($todo->producto_id);
                $talla = Talla::model()->findByPk($todo->talla_id);
                $color = Color::model()->findByPk($todo->color_id);                  
                $imagen = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$producto->id,'orden'=>'1'));
                echo "<li>";
                echo '<a class="btn-link" href="'.Yii::app()->baseUrl .'/producto/detalle/'.$todo->producto_id.'" >'.$producto->nombre.'</a>';
                echo '<div class="row-fluid">';
                
                if($imagen){
                    $htmlimage = CHtml::image(Yii::app()->baseUrl . str_replace(".","_thumb.",$imagen->url), "Imagen ", array("width" => "40", "height" => "40"));
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

    textShoppingCart = '<a href="<?php echo Yii::app()->baseUrl; ?>/bolsa/index" class="btn btn-block btn-small btn-warning">Ver carrito</a>';

    if( listaCarrito != "" ){
        textShoppingCart = listaCarrito + textShoppingCart;
    }  
    if(<?php echo $cont_productos ?> == 0){
      textShoppingCart = '<p><strong>Tu carrito todavía esta vacío</strong>, ¿Qué esperas? Looks y prendas increíbles esperan por ti.</p>';
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

        $('#btn-notifications').hover(function(){
          $('#btn-shoppingcart').popover('hide');  
          $('#btn-shoppingcart').removeClass('bg_color10');                  
        },function(){});

        $('#dropdownUser').hover(function(){
          $('#btn-shoppingcart').popover('hide');      
          $('#btn-shoppingcart').removeClass('bg_color10');              
        },function(){});

      });

    $('#dropdownUser').hoverIntent(function(){
        if( !($(this).attr('class') =='dropdown open') ){          
          $(this).addClass('open');
        }
    },function(){
        $(this).removeClass('open');
    });

    $('#dropdownUser').on('click',function(){
        $(this).removeClass('open');      
    });

  }



</script>
<!-- Popovers OFF -->

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

<div id="wrapper_footer">
  <footer class="container">
    <div class="row hidden-phone">
      <div class="span3">
        <h3>Links rápidos</h3>
        <ul>
          <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/formas_de_pago" title="Formas de Pago">Formas de Pago</a></li>
          <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/condiciones_de_envios_y_encomiendas" title="Envíos y Encomiendas">Envíos y Encomiendas</a></li>
          <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/politicas_de_devoluciones" title="Politicas de Devoluciones">Politicas de Devoluciones</a></li>
          <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/politicas_y_privacidad" title="politicas y privacidad">Politicas y Privacidad</a></li>
          <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/preguntas_frecuentes" title="Preguntas frecuentes">Preguntas frecuentes</a></li>
          <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/terminos_de_servicio" title="Terminos de Servicio">Terminos de Servicio</a></li>
          
        </ul>
      </div>
      <div class="span5 ">
        <h3> Sobre Personaling </h3>
        <p class="lead">Personaling, es un personal shopper digital, un portal de moda y belleza en donde las usuarias se dan de alta, definen su perfil físico y sus preferencias de estilo para descubrir looks recomendados por expert@s en moda (personal shoppers, celebrities, estilistas, fashionistas), podrán comprar el look completo en un click y recibirlo en su domicilio</p>
      </div>
      <div class="span3 offset1 ">
        <h3>¡Síguenos! </h3>
        <div class="textwidget"> <a title="Personaling en facebook" href="https://www.facebook.com/Personaling"><img width="40" height="40" title="personaling en pinterest" src="<?php echo Yii::app()->baseUrl ?>/images/icon_facebook.png"></a> <a title="Personaling en Pinterest" href="https://twitter.com/personaling"> <img width="40" height="40" title="personaling en pinterest" src="<?php echo Yii::app()->baseUrl ?>/images/icon_twitter.png"></a> <a title="pinterest" href="https://pinterest.com/personaling/"><img width="40" height="40" title="Personaling en Pinterest" src="<?php echo Yii::app()->baseUrl ?>/images/icon_pinterest.png"></a> <a title="Personaling en Instagram" href="http://instagram.com/personaling"><img width="40" height="40" title="Personaling en Pinterest" src="<?php echo Yii::app()->baseUrl ?>/images/icon_instagram.png"></a> </div>
        <hr/>
       <ul>
                 <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/acerca_de" title="Acerca de">Acerca de Personaling</a></li>

 <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/contacto" title="Contacto">Ponte en  contacto</a></li>
        <li><a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/equipo_personaling" title="El Equipo Personaling">El Equipo Personaling</a></li>
</ul>
        
      </div>
    </div>
    <hr/>
    <div class="row">
      <div class="span12 text_align_center creditos">Personaling &reg; <?php echo date("Y"); ?> | Todos los derechos reservados<br/>
       Programado en Venezuela por <a href="http://cooltribes.com" title="Connecting true fans" target="_blank">Cooltribes.com</a> </div>
    </div>
  </footer>
</div>

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
