<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Políticas de devoluciones';
$this->breadcrumbs=array(
	'Políticas de devoluciones',
);
// Open Graph
  Yii::app()->clientScript->registerMetaTag('Personaling.com - Políticas de devoluciones', null, null, array('property' => 'og:title'), null); 
  Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características', null, null, array('property' => 'og:description'), null);
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
  Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->baseUrl .'/images/icono_preview.jpg', null, null, array('property' => 'og:image'), null); 

?>

<div class="row">
  <div class="span8">
    <div class="box_1">
      <div class="page-header">
        <h1>Políticas de devoluciones</h1>
      </div>
      <p class="lead">A continuación te detallamos las políticas de  devoluciones de <a href="http://www.personaling.com">www.personaling.com</a> la cual rige a partir de tu registro o cuando compras en nuestra  plataforma, por lo que es muy importante que te asegures de leerlas y entenderlas con antelación. Cualquier cambio en su contenido o alcance, sea por requerimientos legislativos o corporativos, serán notificados a nuestros usuarios  mediante sus correos electrónicos. </p>
      <ol>
        <li> Solo  se aceptarán devoluciones bajo los siguientes términos. 
          <ol type="a">
            <br/><li >El plazo de devolución del artículo es de tres (3) días contados a partir de la recepción del envío del mismo. </li><br/>
            <li>Previo a la devolución, deberás enviar un correo  a <a href="mailto:devoluciones@personaling.com"><em>devoluciones@personaling.com</em></a> indicando la razón por la cual devuelves tu pedido y el número de seguimiento del mismo para el control de la empresa. Si el motivo de la devolución fuese daño a la prenda deberás anexar una foto explícita de la prenda dañada.  </li><br/>
            <li>El producto devuelto deberá estar en perfectas condiciones de venta con sus etiquetas y en su caja  sin haber sido usado, a menos que sea el caso del apartado “b”.  </li><br/>
            <li>El costo de re-envío corre por cuenta del cliente. Salvo que la devolución se deba a responsabilidad de <a href="http://www.personaling.com" title="Personaling, tu personal shopper digital">Personaling.com</a>, en cuyo caso la empresa correrá con dichos gastos y repondrá el artículo u ofrecerá un vale por el monto de la compra más el monto del envio, que podrás aplicar en posteriores compras. </li><br/>
            <li>El envío únicamente corre por cuenta de la compañía cuando se ha cometido un error en cuanto a la talla o si te enviamos el pedido equivocado.</li><br/>
            <li>Al momento de devolver el pedido debes cuidar enviarlo  en las mismas condiciones de empaque y embalaje en que fue recibido a fin de que esté protegido de daño.  </li>
          </ol>
        </li> <br/>
        <li>Personaling.com no realizará devoluciones de dinero bajo ningún concepto. A beneficio de nuestros clientes entregaremos un vale de consumo por el monto del pedido devuelto que tiene validez por un año a partir de la fecha de expedición.  </li><br/>
        <li>Personaling.com se compromete a la revisión detallada de cada uno de sus pedidos antes de la salida de su almacén; esforzándonos por un servicio certero y de calidad.</li><br/>
        <li>Otras condiciones aplican.</li>
      </ol>
    </div>
  </div>
  
  <!-- SIDEBAR ON -->
  <div class="span4"> <?php echo $this->renderPartial('_sidebar'); ?> </div>
  <!-- SIDEBAR ON --> 
  
</div>
