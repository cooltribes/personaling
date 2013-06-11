<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Formas de pago',
);
?>

<div class="row">
  <div class="span8">
    <div class="box_1 bg_mancha_1 ">
      <div class="padding_medium">
        <div class="page-header">
          <h1>Formas de Pago</h1>
        </div>
        <p>Estas son las formas de pago de <a href="http://www.personaling.com">www.personaling.com</a> al dar de alta su registro y comprar en nuestra plataforma está aceptando automáticamente que conoce cada una de las plataformas de pago que ofrecemos como únicas para llevar a cabo sus compras. </p>
        <p class="alert alter-warning"> Si eliminamos alguna de ellas o agregamos pasarelas de pago, cada uno de nuestros usuarios serán notificados vía correo electrónico.</p>
        <p>Personaling.com ofrece tres (3) distintas opciones de pago: tarjeta de crédito, transferencia bancaria,  y/o depósito bancario. </p>
        <p>Siempre garantizando una plataforma segura y confiable al momento de efectuar sus pagos, utilizando un sistema confiable y renovando cada día nuestra plataforma para hacerla un sitio donde pagar de forma online sea muy seguro. </p>
        <p>Nosotros le mantendremos al tanto del status de su orden a través de su dirección de correo electrónico o través de su perfil en Personaling.com. Al momento de confirmar su carrito de compra podrá elegir la forma de pago de su preferencia y a partir de allí el sistema le guiara para completar la transacción. </p>
        <ol style="list-style:lower-latin">
          <li><strong>Pagos con Tarjeta de Crédito: </strong><br />
            Aceptamos únicamente VISA Y MASTERCARD. Personaling.com cuenta con un sistema de protección de datos y seguridad en red donde los datos introducidos están totalmente protegidos. Se solicita la información que es indispensable para efectos de una transacción regular por Internet, y cualquier información adicional será solicitada bajo su estricta autorización.  Una vez confirmado el pago empezarán a correr los días hábiles para el envío de su pedido. No se realiza ningún cargo adicional por el uso de esta pasarela de pago. <br />
            <br />
          </li>
          <li><strong>Pagos con Transferencia Bancaria:</strong><br />
            Una vez realizada la selección de artículos a comprar en la sección de pagar usted elegirá como método de pago &ldquo;transferencia bancaria&rdquo; la cual deberá efectuar dentro de las próximas veinticuatro (24) horas luego de solicitado su pedido. Para utilizar esta modalidad solo debe entrar en la pagina web de su banco y realizar la transferencia a los datos siguientes: <br />
            PERSONALING C.A  RIF … N` DE CUENTA XXXXXXXXXXXXXX<br />
            Recuerde apuntar  el  número de referencia una vez realizada la transacción; ya que este número es el que deberá introducir en la casilla correspondiente al control del pago en su compra, una vez recibido y confirmado comenzaremos a procesar su pedido.  Esta pasarela de pago no tienen ningún tipo de comisión excepto aquellas que apliquen las entidades bancarias en cada caso.  <br />
            <br />
          </li>
          <li><strong>Pagos con depósito Bancario.</strong><br />
            Una vez realizada la selección de artículos a comprar en la sección de pagar usted elegirá como método de pago &ldquo;depósito bancario&rdquo;; debe dirigirse al banco realizar el depósito en la cuenta: <br />
            PERSONALING C.A  RIF … N` DE CUENTA XXXXXXXXXXXXXX</li>
        </ol>
        <p>Debe guardar el comprobante, ya que el número de depósito es el que deberá introducir en la casilla correspondiente al control del pago en su compra, una vez recibido y confirmado comenzaremos a procesar su pedido. <br/>
          Esta pasarela de pago no tienen ningún tipo de comisión excepto aquellas que apliquen las entidades bancarias en cada caso. </p>
      </div>
    </div>
  </div>
  <!-- SIDEBAR ON -->
  <div class="span4"> <?php echo $this->renderPartial('_sidebar'); ?> </div>
  <!-- SIDEBAR ON --> 
</div>
