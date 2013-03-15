<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Personaling</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Personal shoppers">
<meta name="author" content="Cooltribes">

<!-- Le styles -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
body {
	padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
}
</style>
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">

<!-- Le LESS -->
<link rel="stylesheet/less" type="text/css" href="css/style.less" />
<script src="js/less-1.3.3.min.js" type="text/javascript"></script>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

<!-- Fav and touch icons -->
<link rel="shortcut icon" href="../assets/ico/favicon.png">
</head>

<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> <a class="brand" href="index.php">Personaling</a>
      <nav class="nav-collapse collapse pull-right">
        <ul class="nav">
          <li class="active"><a href="lo_mas_top.php" title="Lo más top">Top</a></li>
          <li><a href="Buscar_looks_Catalogo.php" title="Tu personal Shopper">Tu personal Shopper</a></li>
          <li><a href="tienda.php" title="tienda">Tienda</a></li>
          <li><a href="http://personaling.com/blog" target="_blank" title="blog">Magazine</a></li>
          <li><a href="bolsa_de_compras.php" title="tu carrito de compras"><i class="icon-shopping-cart"></i> <span class="badge badge-important">2</span></a></li>
          <li class="dropdown"> <a data-toggle="dropdown" class="dropdown-toggle" href="#">Tu cuenta <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li class="nav-header">Usuario</li>
              <li><a  href="tu_cuenta_usuario.php" title="tu perfil">Tu Cuenta</a></li>
              <li><a href="#" title="tu perfil">Perfil</a></li>
              <li><a href="#" title="configuración de tu cuenta">Configuracion</a></li>
              <li class="divider"></li>
              <li class="nav-header">Personal Shopper</li>
              <li><a  href="tu_cuenta_usuario_personal_shopper.php" title="tu perfil">Tu Cuenta </a></li>
              <li><a  href="crear_look.php" title="Crear Look">Crear Look</a></li>
              <li class="divider"></li>
              <li class="nav-header">Admin</li>
              <li><a href="panel_de_control.php" title="Panel de control">Panel de Control admin</a></li>
              <li class="divider"></li>
              <li><a href="#" title="salir de tu cuenta">Salir</a></li>
            </ul>
          </li>
        </ul>
      </nav>
      <!--/.nav-collapse --> 
    </div>
  </div>
</div>
<div class="container margin_top" id="carrito_compras">
  <div class="row margin_bottom_large">
    <div class="span12">
      <div class="row">
       <!-- Columna principal ON -->
        <article class="span8">
          <div class="row">
            <div class="span6">
              <h1>Nombre del producto <span class="label label-important"> ON SALE</span></h1>
            </div>
            <div class="span2">
              <div class="pull-right"><i class="icon-heart"></i> <i class="icon-share"></i> </div>
            </div>
          </div>
          <div class="row">
            <div class="span6"> 
            <!-- FOTO principal ON -->
            	<img src="http://placehold.it/770x640" />
            <!-- FOTO principal OFF -->
            </div>
            <div class="span2 margin_bottom"> 
            <!-- FOTOS Secundarias ON -->
            	<img src="http://placehold.it/170x145" class="margin_bottom_small"/>
                <img src="http://placehold.it/170x145" class="margin_bottom_small"/> 
                <img src="http://placehold.it/170x145" class="margin_bottom_small"/> 
            <!-- FOTOS Secundarias OFF -->
             </div>
          </div>
        </article>
		<!-- Columna principal OFF -->


		<!-- Columna Secundaria ON -->
        <div class="span4 margin_bottom margin_top padding_top">
          <div class="row">
            <div class="span2">
              <h4 >Precio: Bs. 3500</h4>
            </div>
            <div class="span2"> <a href="bolsa_de_compras.php" title="agregar a la bolsa" class="btn btn-warning pull-right"><i class="icon-shopping-cart icon-white"></i> Añadir a la bolsa</a> </div>
          </div>
          <div class="row">
            <div class="span2">
              <h5>Tallas</h5>
              <div class="clearfix"> <img class="pull-left margin_right_xsmall margin_bottom_xsmall" src="http://placehold.it/40x40"/> <img class="pull-left margin_right_xsmall margin_bottom_xsmall" src="http://placehold.it/40x40"/> <img class="pull-left margin_right_xsmall margin_bottom_xsmall" src="http://placehold.it/40x40"/><img class="pull-left margin_right_xsmall margin_bottom_xsmall" src="http://placehold.it/40x40"/> 
              </div>
            </div>
            <div class="span2">
              <h5>Colores</h5>
              <div class="clearfix"> <img class="pull-left margin_right_xsmall margin_bottom_xsmall" src="http://placehold.it/40x40"/> <img class="pull-left margin_right_xsmall margin_bottom_xsmall" src="http://placehold.it/40x40"/> <img class="pull-left margin_right_xsmall margin_bottom_xsmall" src="http://placehold.it/40x40"/><img class="pull-left margin_right_xsmall margin_bottom_xsmall" src="http://placehold.it/40x40"/> 
              </div>
            </div>
          </div>
          <div class="margin_top">
            <ul class="nav nav-tabs" id="myTab">
              <li class="active"><a href="#detalles">Detalles</a></li>
              <li><a href="#Recomendaciones">Recomendaciones para lucirlo</a></li>
              <li><a href="#Envio">Envio</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="detalles">
                <div class="clearfix">
                  <h4>Marca / Disenador</h4>
                  <img src="http://placehold.it/70x70" class="img-circle pull-right" />
                  <p><strong>Bio</strong>: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmoofficia deserunt mollit anim id</p>
                  <a href="#">Ver looks de esta marca</a> </div>
              </div>
              <div class="tab-pane" id="Recomendaciones">Recomendaciones</div>
              <div class="tab-pane" id="Envio">Envio</div>
            </div>
          </div>
          <hr/>
          <p><i class="icon-calendar"></i> Fecha estimada de entrega: 00/00/2013 - 00/00/2013 </p>
        </div>
		<!-- Columna Secundaria OFF -->
      </div>
    </div>
  </div>
  <hr/>
  <h3>Looks recomendados que incluyen este producto</h3>
  <div class="row">
    <div class="span4"><img src="http://placehold.it/370"/></div>
    <div class="span4"><img src="http://placehold.it/370"/></div>
    <div class="span4"><img src="http://placehold.it/370"/></div>
  </div>
</div>

<!-- /container -->

	<footer class="container">
        <div class="row">
           <div class="span12"><hr/> Personaling &reg; 2013  </div>
        </div>
    </footer>

  <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

<script>
$('.popover_actions').popover({ html : true });
</script>
  </body>
</html>
