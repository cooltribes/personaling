<div class="row">
  <!--<div class="span3 offset2"> <img src="<?php echo Yii::app()->baseUrl; ?>/images/404_torre_eiffel.jpg" width="216" height="386" alt="Torre Eiffel tipo personaling" /></div>-->
  <div class="span6 offset3">
   <div class="offset2"> <div class="color3 httpError-code">
    	<?php //echo $code; ?>404</div></div>
        <!-- <div class="error"> <strong>Detalles</strong>: <?php //echo CHtml::encode($message); ?> </div> -->
	
     <h2 class="color14 httpError-title">
    	<p><?php echo Yii::t('contentForm','Upss!'); ?></p></h2>
    	<h3 class="color14 httpError-text" style="width:auto"> <?php echo Yii::t('contentForm','Se nos rompió un tacón y no hemos llegado a tiempo a Personaling.com.ve <br/>Discúlpanos pero estaremos temporalmente fuera de servicio. <br/>¡Al volver lo avisaremos en nuestras redes sociales!'); ?>  </h3>
    	<div class="offset1 margin_bottom_large"> <img src="<?php echo Yii::app()->baseUrl; ?>/images/tacon300x48.png" height="48" alt="Tacon Roto"/>
  	</div>
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

<style>
	.navbar,
	#wrapper_footer{
		display: none;
	}
</style>
