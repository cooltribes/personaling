<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Condiciones de Envíos y Encomiendas';
$this->breadcrumbs=array(
	'Condiciones de Envíos y Encomiendas',
);
?>

<div class="row">
  <div class="span8">
    <div class="box_1 bg_mancha_1 ">
      <div class="padding_medium">
        <div class="page-header">
          <h1>Condiciones de Envíos y Encomiendas</h1>
        </div>
        <p>Al registrarte o realizar una compra  en nuestra tienda <a href="http://www.personaling.com" title="Personaling, tu personal shopper digital">www.personaling.com</a>, aceptas  automáticamente cada uno de los términos y condiciones que rigen nuestros  envíos y encomiendas. Por ello es muy importante que te asegures de leerlos y entenderlos con antelación.  A continuación te los detallamos: </p>
        <ol>
          <li>Los envíos de Personaling.com se harán solamente dentro del  territorio venezolano, con excepción del Estado Nueva Esparta,  y se entregarán en un plazo máximo de 7 días hábiles. Solo aplican restricciones indicadas en el punto 7. </li>
          <li> El comprador tiene una única opción de envío, es decir sólo puede elegir una dirección para su envío.  </li>
          <li> El costo del envio corre por cuenta del comprador, y el mismo depende del destino y del contenido o volumen del envío mismo. En todo caso, el monto del costo del envío se calculará automáticamente en el sistema, previo al pago, en el momento de realizar el pedido. De esta manera podrás conocerlo  antes de tomar la decisión final de compra o cierre de la transacción. </li>
          <li> El envió se llevará a cabo a través de un operador que gestionará su entrega por medio de Personaling.com </li>
          <li>Puedes elegir entre dos tipo de entregas:
            <ol class="margin_left_medium" style="list-style-type: none">
              <li >5.1 &nbsp;  Puerta: Cuando tu dirección es de fácil acceso, podremos llevar tu pedido hasta la puerta de tu domicilio u oficina.  </li>
              <li >5.2 &nbsp;  Local: Si por el contrario, es una dirección de difícil acceso podrás elegir la opción recogida en la oficina del operador más cercana, donde deberás buscar tu pedido cuando te notifiquemos que ha llegado. </li>
            </ol>
          </li>
          <li>Para recibir tu pedido en cualquiera de las modalidades debes presentar tu cédula de identidad y firmar el acuse de recibo.  </li>
          <li>Personaling.com se hace responsable de empaquetar correctamente tu compra y gestionar la entrega dentro de los plazos correspondientes. En caso de retraso en los plazos, el cliente recibirá un cupón con el 10% de descuento para su próxima compra.</li>
        </ol>
        <p>&nbsp;</p>
      </div>
    </div>
  </div>
  
  <!-- SIDEBAR ON -->
  <div class="span4"> <?php echo $this->renderPartial('_sidebar'); ?> </div>
  <!-- SIDEBAR ON --> 
</div>
