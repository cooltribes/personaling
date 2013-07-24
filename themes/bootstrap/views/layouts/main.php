<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->getBaseUrl(); ?>/favicon.ico">

<?php //Yii::app()->bootstrap->register(); ?>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/botones.css" rel="stylesheet">


<?php Yii::app()->less->register(); ?>
<?php Yii::app()->getClientScript()->registerCoreScript( 'jquery.ui' ); ?>
<!-- Le FONTS -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700' rel='stylesheet' type='text/css'>
</head>

<body>
  <div id="navegacion_principal">
<?php  
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
	$total;
	
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
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'encodeLabel'=>false,
            //'encodeLabel'=>false,
            'items'=>array(
  
                //array('label'=>'Personaling', 'url'=>array('/site/index')),
                
                array('label'=>'Top', 'url'=>array('/site/top'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Tu personal Shopper', 'url'=>array('/site/personal'), 'visible'=>Yii::app()->user->isGuest?false:!UserModule::isPersonalShopper()),
                array('label'=>'Mis Looks', 'url'=>array('/look/mislooks'), 'visible'=>Yii::app()->user->isGuest?false:UserModule::isPersonalShopper()),
                array('label'=>'Crear Look', 'url'=>array('/look/create'), 'visible'=>Yii::app()->user->isGuest?false:UserModule::isPersonalShopper()),
                array('label'=>'Tienda', 'url'=>array('/tienda/index')),
                array('label'=>'Magazine', 'url'=>'http://personaling.com/magazine'),
				        array('label'=>$total,'icon'=>'icon-exclamation-sign', 'url'=>array('/orden/listado'), 'visible'=>!Yii::app()->user->isGuest&&$total>0),
                //array('label'=>$cont_productos,'icon'=>'icon-exclamation-sign', 'url'=>array('/orden/listado'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>$cont_productos,'icon'=>'icon-shopping-cart',   'url'=>array('/bolsa/index'), 'htmlOptions'=>array('class'=>'btn btn-danger') ,'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Ingresa', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
                //******* MODIFICACION EN TbBaseMenu.php PARA PODERLE COLOCAR CLASE AL BOTON *******//
                array('label'=>"Regístrate", 'url'=>array('/user/registration'), 'type'=>'danger', 'htmlOptions'=>array('class'=>'btn btn-danger'),'visible'=>Yii::app()->user->isGuest),
                //array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>$avatar.$nombre, 'url'=>'#','htmlOptions'=>array('tittle'=>'rafa'), 'items'=>array(
                    array('label'=>'Tus Looks', 'url'=>array('/user/profile/looksencantan')),
                     array('label'=>'Tus Pedidos', 'url'=>array('/orden/listado')),
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
?></div>

<script type="text/javascript">

</script>

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
    <div class="row">
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
      <div class="span5">
        <h3> Sobre Personaling </h3>
        <p class="lead">Personaling, es un personal shopper digital, un portal de moda y belleza en donde las usuarias se dan de alta, definen su perfil físico y sus preferencias de estilo para descubrir looks recomendados por expert@s en moda (personal shoppers, celebrities, estilistas, fashionistas), podrán comprar el look completo en un click y recibirlo en su domicilio</p>
      </div>
      <div class="span3 offset1">
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
