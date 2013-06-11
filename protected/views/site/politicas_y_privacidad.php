<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Políticas de privacidad';
$this->breadcrumbs=array(
	'Políticas de privacidad',
);
?>

<div class="row">
  <div class="span8">
    <div class="box_1 bg_mancha_1 ">
      <div class="page-header">
        <h1>Políticas de privacidad</h1>
      </div>
      <p class="lead">Esta es la política de privacidad de nuestra página <a href="http://www.personaling.com">www.personaling.com</a> al dar de alta su registro está aceptando automáticamente cada uno de sus apartados. </p><p>Si por las legislaciones actuales necesitamos hacer algún cambio, cada uno de nuestros usuarios serán notificados vía correo electrónico. </p>
      <ol>
        <li>La información que facilite a la hora de registro será debidamente guardada en un fichero de datos destinado solamente al uso de nuestra plataforma y no será facilitada a terceros sin su previa autorización. </li>
        <li>Si hace conexión con alguna red social, es posible que tengamos acceso a alguna información como fotografías, fecha de nacimiento, teléfono, etc. Será tratada esta información de la misma manera que en el punto uno (1)</li>
        <li>Sus compras serán cuantificadas para uso interno de elaboración de apartados como &ldquo;Más vendidos&rdquo; o &ldquo;Más buscados&rdquo; y serán utilizadas dentro de grandes muestras para nuestra promoción. </li>
        <li>Personaling.com cuenta con un sistema de protección de datos y seguridad en red que protegerá sus datos bancarios y personales.  </li>
      </ol>
    </div>
  </div>
   <!-- SIDEBAR ON -->
  <div class="span4"> <?php echo $this->renderPartial('_sidebar'); ?> </div>
  <!-- SIDEBAR ON --> 
</div>
