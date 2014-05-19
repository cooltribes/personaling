<?php 
    // Open Graph
  Yii::app()->clientScript->registerMetaTag('Personaling.com - Contacto', null, null, array('property' => 'og:title'), null); 
  Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características', null, null, array('property' => 'og:description'), null);
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
  Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->baseUrl .'/images/icono_preview.jpg', null, null, array('property' => 'og:image'), null); 

?>

<section class="container margin_top">
  <h1 class="braker_bottom">Site Map</h1>
  <div class="span3">
    <ul class=" margin_top_xsmall unstyled">
        <li class="padding_xsmall braker_left" ><?php echo CHtml::link('Home', Yii::app()->request->hostInfo.Yii::app()->baseUrl); ?></li>

        <li class="padding_xsmall braker_left" ><?php echo CHtml::link('Como Funciona', Yii::app()->request->hostInfo.Yii::app()->baseUrl . '/site/comofunciona'); ?></li>

        <li class="padding_xsmall braker_left " ><?php echo CHtml::link('Tienda', Yii::app()->request->hostInfo.Yii::app()->baseUrl . '/tienda/index'); ?></li>

        <li class="padding_xsmall braker_left " ><?php echo CHtml::link('Magazine', Yii::app()->request->hostInfo . '/'.'magazine/', array('class'=>'padding_small_bottom')); ?>
            <ul class=" padding_left_xsmall padding_top_xsmall unstyled margin_left">
                <li class="padding_xsmall margin_left_medium braker_left"><?php echo CHtml::link('Magazine', Yii::app()->request->hostInfo . '/'.'magazine/', array('class'=>'padding_small_bottom')); ?></li>
                <li class="padding_xsmall margin_left_medium braker_left"><a href="http://www.youtube.com/channel/UCe8aijeIv0WvrZS-G-YI3rQ">Personaling TV</a></li>
                <li class="padding_xsmall margin_left_medium braker_left"><?php echo CHtml::link('Moda', Yii::app()->request->hostInfo . '/'.'magazine/category/moda/'); ?></li>
                <li class="padding_xsmall margin_left_medium braker_left"><?php echo CHtml::link('Belleza', Yii::app()->request->hostInfo . '/'.'magazine/category/belleza/'); ?></li>
            </ul>
        </li>

        <li class="padding_left_xsmall padding_bottom_xsmall braker_left" ><?php echo CHtml::link('Ingresa', Yii::app()->request->hostInfo.Yii::app()->baseUrl . '/user/login'); ?></li>

        <li class="padding_xsmall braker_left" ><?php echo CHtml::link('Regístrate', Yii::app()->request->hostInfo.Yii::app()->baseUrl . '/user/registration'); ?></li>

        <li class="padding_xsmall braker_left" ><?php echo CHtml::link('Formas de Pago', Yii::app()->request->hostInfo.Yii::app()->baseUrl . '/site/formas_de_pago'); ?></li>

        <li class="padding_xsmall braker_left" ><?php echo CHtml::link('Envios y Encomiendas', Yii::app()->request->hostInfo.Yii::app()->baseUrl . '/site/condiciones_de_envios_y_encomiendas'); ?></li>

        <li class="padding_xsmall braker_left" ><?php echo CHtml::link('Políticas de Devoluciones', Yii::app()->request->hostInfo.Yii::app()->baseUrl . '/site/politicas_de_devoluciones'); ?></li>

        <li class="padding_xsmall braker_left" ><?php echo CHtml::link('Políticas y Privacidad', Yii::app()->request->hostInfo.Yii::app()->baseUrl . '/site/politicas_y_privacidad'); ?></li>

        <li class="padding_xsmall braker_left" ><?php echo CHtml::link('Preguntas Frecuentes', Yii::app()->request->hostInfo.Yii::app()->baseUrl . '/site/preguntas_frecuentes'); ?></li>

        <li class="padding_xsmall braker_left" ><?php echo CHtml::link('Términos de Servicio', Yii::app()->request->hostInfo.Yii::app()->baseUrl . '/site/terminos_de_servicio'); ?></li>

        <li class="padding_xsmall braker_left" ><?php echo CHtml::link('Acerca de Personaling', Yii::app()->request->hostInfo.Yii::app()->baseUrl . '/site/acerca_de'); ?></li>

        <li class="padding_xsmall braker_left" ><?php echo CHtml::link('Contáctanos', Yii::app()->request->hostInfo.Yii::app()->baseUrl . '/site/contacto'); ?></li>

        <li class="padding_xsmall braker_left" ><?php echo CHtml::link('El Equipo de Personaling', Yii::app()->request->hostInfo.Yii::app()->baseUrl . '/site/equipo_personaling'); ?></li>

    </ul>
  </div>
</section>