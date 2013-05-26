<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */

$this->pageTitle=Yii::app()->name . ' - Equipo';
//$this->breadcrumbs=array(
	//'Equipo',
//);
?>
<!-- SECCION DE EL TEAM ON -->

<div class=" margin_bottom_large  team_list">
    <div class="page-header">
        <h1 class="margin_top">Equipo Personaling</h1>
    </div>
    <ul class="thumbnails ">
        <li class="span3">  <img alt="Heidi García" class="img-circle" src="../images/heidi.jpg" width="250"> <h3><a href="https://twitter.com/heidiadragna"target="_blank"  title="Heidi García">Heidi García</a></h3>
            <p>Emprendedora de nacimiento,  CEO y Fundadora de Personaling.com. Amante del buen gusto y la moda. Siempre he pensado que tu mejor look es una buena actitud. </p>
        </li>
        <li class="span3"> <img alt="Rosa Virginia" class="img-circle" src="../images/rosa.jpg" width="250"> <h3>Rosa Virginia</h3>
            <p>Modelo, Abogada, amante de la moda y adicta al shopping. Se lo que te favorece, porque se de moda real. RRPP de Personaling.com</p>
        </li>
        <li class="span3">  <img alt="Elise" class="img-circle" src="../images/elise.jpg" width="250"> <h3><a href="https://twitter.com/elisevigouroux"target="_blank"  title="Elise">Elise Vigouroux</a></h3>
            <p>Una gran parte de mi vida me la paso escribiendo, otra parte leyendo, la otra trabajando para la moda y la que queda paseando a mi pug. Directora de Contenido de Personaling.com </p>
        </li>
        <li class="span3"> <img alt="Ariana" class="img-circle" src="../images/Ariana.jpg" width="250"> <h3><a href="https://twitter.com/masaria"target="_blank"  title="Ariana">Ariana Basciani</a></h3>
            <p>Soy parte del equipo de contenido de Personaling.com. Amante de la literatura. Voy cazando tendencias cada día. Mi trabajo es hacer del mundo un lugar con gente mejor vestida. </p>
        </li>
        <li class="span3"> <img alt="Johann" class="img-circle" src="../images/avatar_johann.jpg" width="250"> <h3><a href="https://twitter.com/johannmgz"target="_blank"  title="Johann">Johann Marquez</a></h3>
            <p>Director de Innovación y Mercadeo - Apasionado por los negocios, tiendo a convertirme en un volcán de ideas. Me gusta buscar, investigar y darle la vuelta a todo para convertirlo en oportunidades. </p>
        </li>
        <li class="span3"> <img alt="Carlos" class="img-circle" src="../images/avatar_carlos.jpg" width="250"> <h3><a href="https://twitter.com/marquezgcarlos"target="_blank"  title="Carlos">Carlos Marquez</a></h3>
            <p>Director Intermacional - Apasionado de la combinacion adecuada entre negocios y tecnologia. Mi meta siempre ha sido que las dos areas funcionen alineadas  y no como areas  separadas en una empresa. </p>
        </li>
        <li class="span3"> <img alt="Juan" class="img-circle" src="../images/avatar_juan.jpg" width="250"> <h3><a href="https://twitter.com/juanrules"target="_blank"  title="Juan">Juan Pernia</a></h3>
            <p>Director de Diseño - Tomo las ideas de los clientes (luego de que Carlos y Johann las traduzcan en requerimientos) y las transformo en diseños frescos y funcionales. </p>
        </li>
        <li class="span3"> <img alt="Rafael" class="img-circle" src="../images/avatar_rafael.jpg" width="250"> <h3><a href="https://twitter.com/ranpaco"target="_blank"  title="Rafael">Rafael Palma</a></h3>
            <p>Director de Programación - Soy ingeniero en informática, siempre me a gustado la computación y la tecnología está presente en casi todos los aspectos de mi vida o por lo menos intento que así sea. </p>
        </li>
        <li class="span3"> <img alt="Cristal" class="img-circle" src="../images/avatar_cristal.jpg" width="250"> <h3>Cristal Montañez</h3>
            <p>Scrum Master - Facilitar el proceso de desarrollo del proyecto. Planificar la ruta de desarrollo, y las vías alternas para alcanzar las metas. Velar por el equipo de desarrollo tenga los insumos en el momento que los necesita. </p>
        </li>
        <li class="span3"> <img alt="Yondri" class="img-circle" src="../images/avatar_yondri.jpg" width="250"> <h3><a href="https://twitter.com/yondri"target="_blank"  title="Yondri">Yondri Roa</a></h3>
            <p>Desarrollador Web - Desarrollo aplicaciones web bajo PHP con el framework Yii. Brindo soporte para los clientes existentes según sus requerimientos y necesidades, y participo en la implementación de nuevas propuestas para clientes potenciales. </p>
        </li>
        <li class="span3"> <img alt="Daniel" class="img-circle" src="../images/avatar_daniel.jpg" width="250"> <h3><a href="https://twitter.com/nashfx"target="_blank"  title="Daniel">Daniel Duque</a></h3>
            <p>Desarrollador Web - Realizo el desarrollo en ambiente web de las funcionalidades y requerimientos detectados en la fase de análisis haciendo uso de los diseños desarrollados por Juan </p>
        </li>
        <li class="span3"> <img alt="Gaby" class="img-circle" src="../images/avatar_gaby.jpg" width="250"> <h3><a href="https://twitter.com/_gabyta_by"target="_blank"  title="Gaby">Gaby Torres</a></h3>
            <p>Diseñadora Gráfica - Soy diseñadora gráfica y me apasiona lo que hago, en la empresa me dedico exclusivamente a diseñar y a correr con un patín de un extremo a otro por las diferencias gráficas entre Carlos y Johann, pero feliz pues. </p>
        </li>
        <li class="span3"> <img alt="Andreas" class="img-circle" src="../images/avatar_andreas.jpg" width="250"> <h3>Andreas Miloda</h3>
            <p>Record client requirements on site then create and work out solutions with the engineers. Contact person for the development and quality control during the implementation of projects </p>
        </li>
    </ul>
</div>

<!-- SECCION DEL TEAM OFF --> 

<!-- PAGINA DE CONTACTO ON -->
<div class="span6 offset3">
    <div class="box_1" style="display:none">
        <h1>Ponte en contacto</h1>
        <?php if(Yii::app()->user->hasFlash('contact')): ?>
        <?php $this->widget('bootstrap.widgets.TbAlert', array(
        'alerts'=>array('contact'),
    )); ?>
        <?php else: ?>
        <p class="margin_top_medium"> Si tienes alguna duda, propuesta de negocio o quieres reportar alguna falla por favor contáctanos a través del siguiente formulario:</p>
        <div class="form">
            <?php /*?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'contact-form',
    'type'=>'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>


	<?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model,'name'); ?>

    <?php echo $form->textFieldRow($model,'email'); ?>

    <?php echo $form->textFieldRow($model,'subject',array('size'=>60,'maxlength'=>128)); ?>

    <?php echo $form->textAreaRow($model,'body',array('rows'=>4, 'class'=>'span3')); ?>

	<?php if(CCaptcha::checkRequirements()): ?>
		<?php echo $form->captchaRow($model,'verifyCode',array(
            'hint'=>'Por favor escriba las letras que se muestran aqui arriba. No importa si estan en mayúscula o minúscula.',
        )); ?>
	<?php endif; ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton',array(
            'buttonType'=>'submit',
            'type'=>'danger',
            'label'=>'Enviar',
        )); ?>
	</div>

<?php $this->endWidget(); ?><?php */?>
        </div>
        <!-- form --></div>
</div>
<!-- PAGINA DE CONTACTO OFF -->

<?php endif; ?>
