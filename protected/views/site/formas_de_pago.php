<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Formas de Pago';
$this->breadcrumbs=array(
	'Formas de pago',
);
?>

<div class="row">
  <div class="span8">
    <div class="box_1 bg_mancha_1 ">
      <div class="padding_medium">
        <div class="page-header">
          <h1>Formas de Pago: Personaling</h1>
        </div>
        <p>Para facilitar tu compra ponemos a disposición tres (3) formas de pago: tarjeta de crédito, transferencia bancaria y depósito bancario. A continuación te indicamos cómo proceder según el medio que utilices. </p>
        <ol style="list-style:lower-latin"><br />
          <li><strong>Pagos con Tarjeta de Crédito: </strong><br />
            <p>Aceptamos VISA Y MASTERCARD de cualquier Banco. El sistema te solicitará  la información que es indispensable para efectos de una transacción regular y efectiva por Internet, y cualquier información adicional será solicitada bajo tu estricta autorización. Una vez confirmado el pago empezarán a correr los días hábiles para el envío de tu pedido.</p>
            <p>Es importante que tengas presente que <a href="http://www.personaling.com" >Personaling.com</a> cuenta con un sistema de protección de datos y seguridad en red donde los datos introducidos están debidamente protegidos. Tu compra con este medio de pago no implica cargo adicional.</p>
            
          </li><br />
          <li><strong>Pagos con Transferencia Bancaria:</strong><br />
            <p>Si eliges como método de pago &ldquo;transferencia bancaria&ldquo;, es importante que tengas presente que debes efectuarla dentro de las veinticuatro (24) horas siguientes de haber hecho tu pedido. De lo contrario no podremos garantizarte que la mercancía estará aún disponible. La transferencia debes realizarla desde la plataforma online de tu banco, a una de nuestras cuentas habilitadas, utilizando los datos siguientes:</p> <br />
            PERSONALING C.A  <br />
            RIF: J-40236088-6<br />
            BANESCO: <br />
            Número Cta corriente: 0134-0277-98-2771093092 <br /><br />
            <p>Deposita en cualquiera de nuestras cuentas habilitadas, utilizando los datos siguientes: Anota el  número de referencia una vez realizada la transacción;  ya que este número es el que deberás introducir en la casilla correspondiente al control de pago en tu compra. Una vez recibido y confirmado procesaremos tu pedido. Tu compra con este medio de pago no implica cargo adicional, excepto aquellas que te aplique tu entidad bancaria.  </p>
          </li><br />
          <li><strong>Pagos con depósito Bancario.</strong><br />
            <p>Hecha la selección de artículos a comprar, en la sección de pagar, elegirás como método de pago &ldquo;depósito bancario&ldquo;. En este caso haz el depósito por el monto total de tu compra, y conserva tu comprobante, ya que el número de depósito es el que deberás introducir en la casilla correspondiente al control del pago de tu compra.  A partir de completar este paso comenzaremos a procesar tu  pedido. 
            Tu compra por este medio de pago no implica cargo adicional, excepto aquellas que aplique tu entidad bancaria.</p>    
            Las cuentas a las cuales puedes depositar son: <br />
            
            <br/>
            PERSONALING C.A  <br/>
            RIF: J-40236088-6 <br/>
            BANESCO: <br/>
            Número Cta corriente: 0134-0277-98-2771093092 <br/> <br/>           

        </ol>
        <p>Te mantendremos al tanto del status de tu compra a través de tu dirección de correo electrónico o través de tu perfil en <a href="http://www.personaling.com" >Personaling.com</a>.</p>
      </div>
    </div>
  </div>
  <!-- SIDEBAR ON -->
  <div class="span4"> <?php echo $this->renderPartial('_sidebar'); ?> </div>
  <!-- SIDEBAR ON --> 
</div>
