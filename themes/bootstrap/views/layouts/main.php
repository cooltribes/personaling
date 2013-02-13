<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>

	 <?php Yii::app()->less->register(); ?>

</head>

<body>

<?php $this->widget('bootstrap.widgets.TbNavbar',array(
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(

                //array('label'=>'Personaling', 'url'=>array('/site/index')),
                array('label'=>'Top', 'url'=>array('/site/page', 'view'=>'about')),
                array('label'=>'Tu personal Shopper', 'url'=>array('/site/personal')),
                array('label'=>'Tienda', 'url'=>array('/tienda')),
                array('label'=>'Magazine', 'url'=>array('/site/contact')),
               // array('label'=>'<i class="icon-shopping-cart"></i> <span class="badge badge-important">2</span>', 'url'=>array('/site/contact')),
                array('label'=>'Login', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
                //array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                 array('label'=>'Tu Cuenta', 'url'=>'#', 'items'=>array(
                    array('label'=>'Tu Cuenta', 'url'=>array('/user/profile/micuenta')),
                    array('label'=>'Perfil', 'url'=>'#'),
                    array('label'=>'Configuracion', 'url'=>'#'),
                    array('label'=>'Admin','url'=>array('/user/admin'),'visible'=>Yii::app()->user->id?UserModule::isAdmin():false),
                    '---',
                    array('label'=>'Salir', 'url'=>array('/site/logout')),
                ),
                'visible'=>!Yii::app()->user->isGuest,
				),
            ),
        ),
    ),
)); ?>

<div class="container" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>


	<footer class="container">
        <div class="row">
           <div class="span12"><hr/> Personaling &reg; <?php echo date("Y"); ?>  </div>
        </div>
    </footer>


</div><!-- page -->

</body>
</html>
