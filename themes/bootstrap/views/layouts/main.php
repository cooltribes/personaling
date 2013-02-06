<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
<<<<<<< HEAD
	 <?php Yii::app()->less->register(); ?>
=======
>>>>>>> 039564f4da4ac6d637ee71a91aea8afb795ee0f9
</head>

<body>

<?php $this->widget('bootstrap.widgets.TbNavbar',array(
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
<<<<<<< HEAD
                array('label'=>'Personaling', 'url'=>array('/site/index')),
                array('label'=>'Top', 'url'=>array('/site/page', 'view'=>'about')),
                array('label'=>'Tu personal Shopper', 'url'=>array('/site/contact')),
                array('label'=>'Tienda', 'url'=>array('/site/contact')),
                array('label'=>'Magazine', 'url'=>array('/site/contact')),
               // array('label'=>'<i class="icon-shopping-cart"></i> <span class="badge badge-important">2</span>', 'url'=>array('/site/contact')),
=======
                array('label'=>'Home', 'url'=>array('/site/index')),
                array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                array('label'=>'Contact', 'url'=>array('/site/contact')),
>>>>>>> 039564f4da4ac6d637ee71a91aea8afb795ee0f9
                array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
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

<<<<<<< HEAD
	<footer class="container">
        <div class="row">
           <div class="span12"><hr/> Personaling &reg; <?php echo date("Y"); ?>  </div>
        </div>
    </footer>
=======
	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->
>>>>>>> 039564f4da4ac6d637ee71a91aea8afb795ee0f9

</div><!-- page -->

</body>
</html>
