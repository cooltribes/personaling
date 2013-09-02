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
        <h1>Política de privacidad o privacidad de datos</h1>
      </div>
      <p class="lead">A continuación te indicamos los terminos y politicas de privacidad de   <a href="http://www.personaling.com">www.personaling.com</a>  las cuales rigen y son aceptadas automáticamente por nuestros usuarios, a partir de su registro y compra en nuestro portal, razón por la cual es sumamente importante te asegures de leerlas y entenderlas con antelación. En caso de algún cambio en las mismas, sea por razones legales o corporativas, cada uno de nuestros usuarios serán notificados vía correo electrónico.  </p>
      <ol>
        <li>La información que facilites a la hora del registro será debidamente guardada en un fichero de datos destinado solamente al uso de nuestra plataforma y no será facilitada a terceros sin tu previa autorización. </li>
        <li> Si haces conexión con alguna red social, es posible que tengamos acceso a alguna información como fotografías, fecha de nacimiento, teléfono, etc. Será tratada esta información de la misma manera que en el punto uno (1), es decir, para el uso exclusivo de nuestra página web y en caso de ser compartida será sólo bajo tu previa autorización.</li>
        <li>Tus compras serán cuantificadas para uso interno de elaboración de apartados como “Más vendidos” o “Más buscados” y serán utilizadas dentro de grandes muestras para nuestra promoción, sin publicar tu identidad a no ser que así lo autorices.  </li>
        <li><a href="http://www.personaling.com" title="Personaling, tu personal shopper digital">Personaling.com</a> cuenta con un sistema de protección de datos y seguridad en red que protegerá tus datos bancarios y personales.   </li>
      </ol>
    </div>
  </div>
   <!-- SIDEBAR ON -->
  <div class="span4"> <?php echo $this->renderPartial('_sidebar'); ?> </div>
  <!-- SIDEBAR ON --> 
</div>
