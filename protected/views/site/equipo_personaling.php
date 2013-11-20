<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form TbActiveForm */

$this->pageTitle=Yii::app()->name . ' - Equipo';
$this->breadcrumbs=array(
	'Equipo',
);

// Open Graph
  Yii::app()->clientScript->registerMetaTag('Personaling.com - Equipo', null, null, array('property' => 'og:title'), null); 
  Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características', null, null, array('property' => 'og:description'), null);
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
  Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->baseUrl .'/images/icono_preview.jpg', null, null, array('property' => 'og:image'), null); 
?>

<!-- SECCION DE EL TEAM ON -->

<div class=" margin_bottom_large  team_list">
    <div class="page-header">
        <h1 class="margin_top">Equipo Personaling</h1>
    </div>
    <ul class="thumbnails ">
        <li class="span3">  <img alt="Heidi García" class="img-circle" src="../images/heidi.jpg" width="250"> <h3><a href="https://twitter.com/heidiadragna"target="_blank"  title="Heidi García">Heidi García</a></h3>
            <p>Emprendedora de nacimiento, CEO y Fundadora de Personaling.com. Amante del buen gusto y la moda. Siempre he pensado que tu mejor look es una buena actitud.</p>
        </li>
               <li class="span3">  <img alt="Nelly Oliveros Russian" class="img-circle" src="../images/nelly.jpg" width="250"> <h3><a href="https://twitter.com/heidiadragna"target="_blank"  title="Nelly Oliveros Russian">Nelly Oliveros Russian</a></h3>
            <p>La experiencia es la primera garantía de la casa. Abogada (Master en Gestión Comercial), me he dedicado más de 20 años al sector del retail y a asesorar a los principales inversionistas del país en temas inmobiliarios.</p>
        </li>
        
                
        <li class="span3"> <img alt="Rosa Virginia" class="img-circle" src="../images/rosa.jpg" width="250"> <h3>Rosa Virginia</h3>
            <p>Modelo, Abogada, amante de la moda y adicta al shopping. Se lo que te favorece, porque se de moda real. Directora de Relaciones Publicas de Personaling.com</p>
        </li>
        <li class="span3">  <img alt="Elise" class="img-circle" src="../images/elise.jpg" width="250"> <h3><a href="https://twitter.com/elisevigouroux"target="_blank"  title="Elise">Elise Vigouroux</a></h3>
            <p>Una gran parte de mi vida me la paso escribiendo, otra parte leyendo, la otra trabajando para la moda y la que queda paseando a mi pug. Directora de Contenido de Personaling.com</p>
        </li>
        <li class="span3"> <img alt="Ariana" class="img-circle" src="../images/Ariana.jpg" width="250"> <h3><a href="https://twitter.com/masaria"target="_blank"  title="Ariana">Ariana Basciani</a></h3>
            <p>Creo que el buen gusto está íntimamente relacionado con el sentido común y el estado de ánimo. Soy parte del equipo de contenidos y marketing on line de Personaling.com y, mientras no estoy trabajando, me encanta leer libros para cosechar el intelecto. </p>
        </li>
        <li class="span3"> <img alt="Johann" class="img-circle" src="../images/johann.jpg" width="250"> <h3><a href="https://twitter.com/johannmgz"target="_blank"  title="Johann">Johann Marquez</a></h3>
            <p>Soy un apasionado de los negocios, me convierto en un volcán de ideas cuando me vuelco en un proyecto. Donde la gente ve retos yo definitivamente veo oportunidades. Me encanta el proceso creativo que conlleva el materializar una idea.  </p>
        </li>
        <li class="span3"> <img alt="Carlos" class="img-circle" src="../images/avatar_carlos.jpg" width="250"> <h3><a href="https://twitter.com/marquezgcarlos"target="_blank"  title="Carlos">Carlos Marquez</a></h3>
            <p>Siempre he creído firmemente que la tecnología y los negocios son áreas que se complementan. Busco desarrollar proyectos que demuestren esta premisa y sean exitosos tanto en el aspecto de desarrollo tecnológico como a nivel de negocio. </p>
        </li>
        <li class="span3"> <img alt="Juan" class="img-circle" src="../images/avatar_juan.jpg" width="250"> <h3><a href="https://twitter.com/juanrules"target="_blank"  title="Juan">Juan Pernia</a></h3>
            <p>El diseño no se basa solo en una estética, se basa en un gran porcentaje en su funcionalidad para el negocio. Busco el equilibrio entre ambas cosas, diseñar para satisfacer no solamente al cliente, también al usuario y crear una atmosfera idónea donde la línea sea tan delgada que se convierta en imperceptible. </p>
        </li>
        <li class="span3"> <img alt="Rafael" class="img-circle" src="../images/avatar_rafael.jpg" width="250"> <h3><a href="https://twitter.com/ranpaco"target="_blank"  title="Rafael">Rafael Palma</a></h3>
            <p>Soy amante de la informática y de todo lo que tenga que ver con avances tecnológicos. Incluyo la tecnología en cada aspecto de mi vida, desde las cosas más sencillas hasta las más complejas. Para mi definitivamente, es el futuro.</p>
        </li>
        <li class="span3"> <img alt="Cristal" class="img-circle" src="../images/avatar_cristal.jpg" width="250"> <h3>Cristal Montañez</h3>
            <p>Si alguien necesita algo dentro del proyecto, yo soy la encargada de proveerlo. Desarrollo el camino a  seguir dentro de la producción y elaboración de proyectos online, buscando estrategias que nos ayuden a economizar tiempo y lograr nuestro objetivo de la mejor manera posible.  </p>
        </li>
        <li class="span3"> <img alt="Yondri" class="img-circle" src="../images/avatar_yondri.jpg" width="250"> <h3><a href="https://twitter.com/yondri"target="_blank"  title="Yondri">Yondri Roa</a></h3>
            <p>Mi trabajo es desarrollar aplicaciones web bajo PHP con el framework Yii. Siempre intento crear la atmósfera necesaria para lograr unir lo que quiere el cliente con una excelente experiencia del usuario. Trabajo en el área creativa a la hora de presentar a clientes nuevos proyectos.  </p>
        </li>
        <li class="span3"> <img alt="Daniel" class="img-circle" src="../images/avatar_daniel.jpg" width="250"> <h3><a href="https://twitter.com/nashfx"target="_blank"  title="Daniel">Daniel Duque</a></h3>
            <p>Mi trabajo se basa en hacer realidad –dentro de la web- lo que se diseña. Utilizo herramientas para crear sensaciones y experiencias basadas en un análisis previo. Adoro mi trabajo y me apasiona ver terminados proyectos que alguna vez observe en simples ideas. </p>
        </li>
        <li class="span3"> <img alt="Gaby" class="img-circle" src="../images/avatar_gaby.jpg" width="250"> <h3><a href="https://twitter.com/_gabyta_by"target="_blank"  title="Gaby">Gaby Torres</a></h3>
            <p>Cuando no estoy de un lado a otro en mi patín, estoy diseñando.  Adoro el proceso creativo por el que pasa mi cabeza al desarrollar un proyecto nuevo. Nunca podré describir la satisfacción de imaginar algo y verlo luego "vivo", sea en el formato que sea.  </p>
        </li>
        <li class="span3"> <img alt="Andreas" class="img-circle" src="../images/andreas.jpg" width="250"> <h3>Andreas Miloda</h3>
            <p>Todo producto debe tener un control de calidad, hasta aquellos que están online. Me encargo de lograr que el equipo trabaje de manera homogénea para cumplir las expectativas del cliente durante el desarrollo del proyecto. </p>
        </li>
    </ul>
    
            <h2 class="margin_top">Board Members <small>(Asesores)</small></h2>
            <hr/>
 <ul class="thumbnails ">
        <li class="span3">  <img alt="Javier Busquets" class="img-circle" src="../images/javier.jpg" width="250"> <h3><a href="http://www.linkedin.com/profile/view?authToken=WYW3&goback=&id=9169480&trk=prof-sb-net_ovw-people-company-name-link&authType=name"target="_blank"  title="Javier Busquets">Javier Busquets</a></h3>
            <p>Especializado en la gestión de Executive Education y con una gran experiencia no solamente dentro del mundo de TI sino también como profesor especializado y investigador, Javier Busquets es una de las referencias no solamente en España, si no en gran parte de Europa al hablar de tecnologías emergentes  y estrategias de desarrollo digital y social. </p>
        </li>
        
        <li class="span3">  <img alt="Luis Vives" class="img-circle" src="../images/luis.jpg" width="250"> <h3><a href="http://www.linkedin.com/profile/view?id=292441&authType=name&authToken=UYTi&goback=&trk=prof-sb-net_ovw-people-company-name-link"target="_blank"  title="Luis Vives">Luis Vives</a></h3>
            <p>Encargado no solo de la elaboración de planes para grandes empresas dentro del rango de Executive Education , también un académico apasionado por transmitir sus conocimientos, realizar consultorías y editar contenido para publicaciones tan importantes como Harvard Deusto Business Review.</p>
        </li>
        
                <li class="span3">  <img alt="Eduardo de Balle" class="img-circle" src="../images/eduardo.jpg" width="250"> <h3><a href="http://www.linkedin.com/profile/view?id=91087628&authType=NAME_SEARCH&authToken=9yCm&locale=es_ES&srchid=99c94b93-b8e0-4aa2-a455-fcf0cea57f85-0&srchindex=1&srchtotal=1&goback=.fps_PBCK_Eduardo+de+Balle_*1_*1_*1_*1_*1_*1_*2_*1_Y_*1_*1_*1_false_1_R_*1_*51_*1_*51_true_*2_*2_*2_*2_*2_*2_*2_*2_*2_*2_*2_*2_*2_*2_*2_*2_*2_*2_*2_*2_*2&pvs=ps&trk=pp_profile_name_link"target="_blank"  title="Eduardo de Balle">Eduardo de Balle</a></h3>
            <p>Su pasión es crear estrategias que potencien plataformas, ideas y proyectos. Desarrollando las estrategias no solamente de manera convencional, si no utilizando novedosas herramientas que unidas a sus años de experiencia lo convierten en uno de los mejores consultores que puede tener un proyecto en desarrollo. </p>
        </li>
         <li class="span3">  <img alt="Hugo Pereira" class="img-circle" src="../images/hugo.jpg" width="250"> <h3><a href="http://www.linkedin.com/profile/view?id=19922307&locale=en_US&trk=tyah" target="_blank"  title="Hugo Pereira">Hugo Pereira</a></h3>
            <p>Su pasión es crear estrategias que potencien plataformas, ideas y proyectos. Desarrollando las estrategias no solamente de manera convencional, si no utilizando novedosas herramientas que unidas a sus años de experiencia lo convierten en uno de los mejores consultores que puede tener un proyecto en desarrollo. </p>
        </li>
        
        
        </ul>
    
</div>

<!-- SECCION DEL TEAM OFF --> 