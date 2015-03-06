<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Términos y Condiciones para Personal Shoppers';
$this->breadcrumbs=array(
	'Términos de servicio',
);
// Open Graph
  Yii::app()->clientScript->registerMetaTag('Personaling.com -Términos y Condiciones para Personal Shoppers', null, null, array('property' => 'og:title'), null); 
  Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características', null, null, array('property' => 'og:description'), null);
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
  Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->baseUrl .'/images/icono_preview.jpg', null, null, array('property' => 'og:image'), null); 
?>

<div class="row">
  <div class="span8">
    <div class="box_1">
      <div class="page-header">
        <h1>Términos y Condiciones para Personal Shoppers</h1>
      </div>
      <p align="justify">¡Estamos encantadas de tenerte en el Team Personaling!</p>
      <p align="justify">Lee estos términos y condiciones que ayudarán a esclarecer algunas dudas.</p>
      <?php if(Yii::app()->language=='es_es'): ?>
      <ol>
        <li align="justify">Cada look que se crea debe tener al menos 4 prendas y debe enviarse una vez completada toda la información: Nombre del look, descripción y clasificación.</li>
        <li align="justify">Una vez enviado el look, se somete a aprobación por parte del equipo Personaling, el cual tiene la potestad de editarlo si lo considera conveniente, para adecuarlo a los parámetros apropiados.</li>
        <li align="justify">Los looks creados pueden quedar inactivos en caso de agotarse o inactivarse 3 o más productos que lo compongan.</li>
        <li align="justify">Personaling tiene un sistema de remuneración a Personal Shoppers basado en la medición del tráfico que impulsen a la plataforma, a través de la difusión de URL únicas por cada look.  El importe por link generado variará en función del volumen de tráfico. Se informará a cada Personal Shopper los resultados al cierre de cada mes y se le abonará el pago en un período de máximo 60 días, a modo de saldo en la cuenta de la plataforma. El Personal Shopper podrá solicitar la transferencia de ese saldo a una cuenta de Paypal cuando el mismo supere los 50€.</li>
        <li align="justify">Personaling garantiza la privacidad y confidencialidad de los datos y transacciones que se generen.</li>
      </ol>
      <?php else: ?>
      <ol>
        <li align="justify">Cada look que se crea debe tener al menos 4 prendas y debe enviarse una vez completada toda la información: Nombre del look, descripción y clasificación.</li>
        <li align="justify">Una vez enviado el look, se somete a aprobación por parte del equipo Personaling, el cual tiene la potestad de editarlo si lo considera conveniente, para adecuarlo a los parámetros apropiados.</li>
        <li align="justify">Los looks creados pueden quedar inactivos en caso de agotarse o inactivarse 3 o más productos que lo compongan.</li>
        <li align="justify">Personaling Venezuela tiene un sistema de remuneración a Personal Shoppers basado en un porcentaje de comisión por la venta de uno o varios productos que componga el look generado. El porcentaje es variable y se acuerda individualmente. Se informará a cada Personal Shopper los resultados al cierre de cada mes y se le abonará el pago en un período de máximo 60 días, a modo de saldo en la cuenta de la plataforma.</li>
        <li align="justify">Personaling garantiza la privacidad y confidencialidad de los datos y transacciones que se generen.</li>
      </ol>
      <?php endif; ?>    
    </div>
  </div>
  <!-- SIDEBAR ON -->
  <div class="span4"> <?php echo $this->renderPartial('_sidebar'); ?> </div>
  <!-- SIDEBAR ON --> 
</div>
