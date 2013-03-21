<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<?php //Yii::app()->bootstrap->register(); ?>
<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/botones.css" rel="stylesheet">
<?php Yii::app()->less->register(); ?>

<!-- Le FONTS -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300,600,700' rel='stylesheet' type='text/css'>
</head>

<body>
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
                array('label'=>'Panel de Control', 'url'=>array('/controlpanel/index')),
                array('label'=>'Usuarios', 'url'=>array('/user/admin')),
                array('label'=>'Looks', 'url'=>array('/look/admin')),
                array('label'=>'Productos', 'url'=>array('/producto/admin')),
                
                array('label'=>'Ventas', 'url'=>array('/user/login')),
               array('label'=>'Sistema', 'url'=>array('/site/logout')),
				array('label'=>'Tu Cuenta', 'url'=>'#', 'items'=>array(
                    array('label'=>'Tu Cuenta', 'url'=>array('/user/profile/micuenta')),
                    array('label'=>'Perfil', 'url'=>'#'),
                    array('label'=>'Configuracion', 'url'=>'#'),
                   
                    '---',
                    array('label'=>'Salir', 'url'=>array('/site/logout')),
                ),
               ),
            ),
        ),
    ),
)); 
} else {
	if (Yii::app()->user->id){
		$profile = Profile::model()->findByAttributes(array('user_id'=>Yii::app()->user->id));
		$nombre = $profile->first_name.' '.$profile->last_name;
	} else {
		$nombre = 'N/A';
	}
$this->widget('bootstrap.widgets.TbNavbar',array(
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
 
                //array('label'=>'Personaling', 'url'=>array('/site/index')),
                array('label'=>'Top', 'url'=>array('/site/top'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Tu personal Shopper', 'url'=>array('/site/personal'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Tienda', 'url'=>array('/tienda/index')),
                array('label'=>'Magazine', 'url'=>array('/site/contact')),
                array('label'=>'2','icon'=>'icon-shopping-cart', 'url'=>array('/site/contact'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Login', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
                //array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                 array('label'=>$nombre, 'url'=>'#','htmlOptions'=>array('tittle'=>'rafa'), 'items'=>array(
                    array('label'=>'Tu Cuenta', 'url'=>array('/user/profile/micuenta')),
                    array('label'=>'Perfil', 'url'=>array('/user/profile')),
                    array('label'=>'Configuracion', 'url'=>'#'),
                    
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
<!-- <div class="alert alert-error margin_top padding_top">Estas en el sitio de Pruebas T1</div> -->
<div class="container" id="page">
    <?php if(isset($this->breadcrumbs)):?>
    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?>
    <!-- breadcrumbs -->
    <?php endif?>
    <?php echo $content; ?>
    
</div>
<!-- page -->

<div id="wrapper_footer">
  <footer class="container">
    <div class="row">
      <div class="span3">
        <h3>Links rápidos</h3>
        <ul>
          <li> Lorem ipsum dolor </li>
          <li>Sit amet, consectetur  elit.</li>
          <li>Curabitur feugiat porta risus </li>
          <li>S elementum. Cras egestas</li>
          <li>Leo eget massa dap nis</li>
        </ul>
      </div>
      <div class="span5">
        <h3> Sobre Personaling </h3>
        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur feugiat porta risus a elementum. Cras egestas leo eget massa facilisis sit amet dap nis </p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur feugiat porta risus a elementum. Cras egestas leo eget massa facilisis sit amet dap nis </p>
      </div>
      <div class="span3 offset1">
        <h3>Siguenos! </h3>
        <div class="textwidget">  <a title="Personaling en facebook" href="https://www.facebook.com/Personaling"><img width="40" height="40" title="personaling en pinterest" src="<?php echo Yii::app()->baseUrl ?>/images/icon_facebook.png"></a>
       <a title="Personaling en Pinterest" href="https://twitter.com/personaling"> <img width="40" height="40" title="personaling en pinterest" src="<?php echo Yii::app()->baseUrl ?>/images/icon_twitter.png"></a>
  <a title="pinterest" href="https://pinterest.com/personaling/"><img width="40" height="40" title="Personaling en Pinterest" src="<?php echo Yii::app()->baseUrl ?>/images/icon_pinterest.png"></a>      
  <a title="Personaling en Instagram" href="http://instagram.com/personaling"><img width="40" height="40" title="Personaling en Pinterest" src="<?php echo Yii::app()->baseUrl ?>/images/icon_instagram.png"></a>        
      </div>
      </div>
</div>
      <hr/>
<div class="row">

      <div class="span12 text_align_center creditos">Personaling &reg; <?php echo date("Y"); ?> | Todos los derechos reservados
      <br/>Cooltribes.com
       </div>
    </div>
  </footer>
</div>
</body>
</html>
