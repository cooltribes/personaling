<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<div class="row">
  <div class="span3 offset2"> <img src="<?php echo Yii::app()->baseUrl; ?>/images/404_torre_eiffel.jpg" width="216" height="386" alt="Torre Eiffel tipo personaling" /></div>
  <div class="span6">
    <h1 class="T_superlarge"><?php echo $code; ?></h1>
         <div class="error"> <strong>Detalles</strong>: <?php echo CHtml::encode($message); ?> </div>

    <h2 class="bg_color4 color3 padding_left_xsmall"><?php echo Yii::t('contentForm','¡Upss! To all of us has broken a heel ever, refreshes the screen tu try more later.'); ?>  </h2>
     <?php /*?><p class="lead">
     Aqui te dejamos un par de links que pueden ayudarte con lo que buscas
     </p>
     <ul>
     <li><a href="<?php echo Yii::app()->baseUrl; ?>">Página de inicio</a></li>
     <li><a href="<?php echo Yii::app()->baseUrl; ?>/tienda/">Tienda</a></li>
     <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/login/">Iniciar sesión</a></li>
     
     </ul><?php */?>
  </div>
 
</div>
