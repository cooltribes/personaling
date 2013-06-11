<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Términos de servicio';
$this->breadcrumbs=array(
	'Términos de servicio',
);
?>

<div class="row">
  <div class="span8">
    <div class="box_1 bg_mancha_1 ">
      <div class="page-header">
        <h1>Términos de servicio</h1>
      </div>
      <p>Estos son los términos de servicio de nuestra página <a href="http://www.personaling.com" title="Personaling, tu personal shopper digital">www.personaling.com</a> al dar de alta su registro está aceptando automáticamente cada uno de sus apartados. Si por las legislaciones actuales necesitamos hacer algún cambio, cada uno de nuestros usuarios serán notificados vía correo electrónico. </p>
      <ol>
        <li>Para estar registrado y comprar en personaling.com debe ser usted mayor de  dieciocho (18) años. </li>
        <li>Personaling.com enviará a nuestros usuarios un número indeterminado de comunicaciones periódicas -que nuestro equipo considere necesarias- sobre productos, promociones e información general referente a nosotros o a empresas afiliadas a nuestra plataforma siempre con su consentimiento previo. </li>
        <li>La marca, contenido y logotipo son propiedad de Personaling.com, el registro en la página no le da derecho ninguno sobre alguno de los elementos antes citados ni su distribución en ningún medio sin previa autorización de nuestro equipo. </li>
        <li>Personaling.com podrá dar de baja cualquier perfil que considere viole o infrinja nuestros términos de servicio o considere fraudulento, sin previa notificación al usuario.  </li>
      </ol>
    </div>
  </div>
  <!-- SIDEBAR ON -->
  <div class="span4"> <?php echo $this->renderPartial('_sidebar'); ?> </div>
  <!-- SIDEBAR ON --> 
</div>
