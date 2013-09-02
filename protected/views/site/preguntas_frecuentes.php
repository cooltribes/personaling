<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Preguntas Frecuentes';
$this->breadcrumbs=array(
	'FAQ',
);
?>

<div class="row">
  <div class="span8">
    <div class="box_1 bg_mancha_1 ">
      <div class="page-header">
        <h1>Preguntas Frecuentes</h1>
      </div>
      <h3>¿Cómo funciona Personaling.com?  </h3>
      <p>Como sabemos que las imágenes valen más que mil palabras, te dejamos nuestro video de presentación.  </p>
      <iframe width="560" height="315" src="//www.youtube.com/embed/oAKyeeTng1U" frameborder="0" allowfullscreen></iframe>      
      <hr/>
      <h3>¿Debo pagar por mi envío?</h3>
      <p>Si, Personaling.com hace sus envíos a través de operadores de envios  y cada envío la cancela el cliente al momento de la cancelación de su compra. Las tarifas cambiarán dependiendo del destino final del envío.  </p>
      <p>Quiero devolver mi compra ¿Debo hacerlo a través del mismo operador?    </p>
      <p>Para asegurar un mejor servicio es necesario  hacer la devolución a través del mismo operador que lo recibió.  </p>
      <hr/>
      <h3>¿Debo pagar la devolución?</h3>
      <p>Si, debes pagar por la devolución de tu compra a menos que sea Personaling.com el responsable del deterioro de una de tus prendas o de un mal embalaje que dañara tu compra.  </p>
      <hr/>
      <h3>¿Tiene Personaling.com tienda física?</h3>
      <p>Por el momento no, y ¿Por qué? Nada más fácil que comprar tus marcas favoritas desde la comodidad de tu casa. </p>
      <hr/>
      <h3>¿Puedo elaborar looks?  </h3>
      <p>En Personaling.com estamos abiertos a cualquier opción y creemos que todos podemos agudizar nuestro buen gusto, así que si eres muy activo en nuestras redes sociales podemos considerarte un personal shopper honorario.  </p>
      <hr/>
      <h3>¿Si quiero cambiar algo puedo acercarme a la tienda de las marca directamente?  </h3>
      <p>Oh! No, lamentablemente tenemos súper buenos precios porque tenemos artículos exclusivos, así que si compras por aquí, debes hacer el cambio por aquí.    </p>
      <hr/>
      <h3>¿Si tengo una queja o sugerencia, a cuál correo electrónico puedo escribir?  </h3>
      <p>Puedes comunicarte con nosotros por cualquiera de nuestras redes sociales o a través de  <a href="mailto:servicioalcliente@personaling.com">servicioalcliente@personaling.com</a></p>
    </div>
  </div>
   <!-- SIDEBAR ON -->
  <div class="span4"> <?php echo $this->renderPartial('_sidebar'); ?> </div>
  <!-- SIDEBAR ON --> 
</div>
