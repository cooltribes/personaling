<?php 
$this->pageTitle="Cómo funciona Personaling";
Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características.', 'description', null, null, null);
Yii::app()->clientScript->registerMetaTag('Personaling, Mango, Timberland, personal shopper, Cortefiel, Suiteblanco, Accesorize, moda, ropa, accesorios', 'keywords', null, null, null);
// Open Graph
  Yii::app()->clientScript->registerMetaTag('Personaling.com ¿Cómo funciona?', null, null, array('property' => 'og:title'), null); 
  Yii::app()->clientScript->registerMetaTag('Serás asesorado por actrices, animadoras, celebridades y fashion bloggers. Todos ellos crearán looks adaptados a tus condiciones físicas y gustos para que siempre vayas vestida a la última moda', null, null, array('property' => 'og:description'), null);
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
  Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->getBaseUrl() .'/images/icono_preview.jpg', null, null, array('property' => 'og:image'), null); 


?>
</div>
</div>
<?php
$pais=Pais::model()->findByAttributes(array('idioma'=>Yii::app()->getLanguage()));
 if($pais->idioma=='es_es')         { ?>
	<section class="container margin_top_large margin_bottom_xlarge padding_top_large padding_bottom_large" >
		<article class="row">
			<div class="offset1 span10">
				<p class="lead"><b>Personaling</b> es el primer portal de moda en España donde podrás adquirir las mejores marcas de ropa y accesorios, a partir de looks personalizados por expertos en moda (celebrities, fashion bloggers y personal shoppers) quienes tendrán en cuenta tus gustos, preferencias y características físicas; permitiéndote adquirir los productos en un solo clic y recibirlos en la comodidad de tu casa u oficina.
				<br><br>¿Quieres vivir la primera shopping experience única y repetible?
				<br><br> <a href="<?php echo Yii::app()->baseUrl; ?>/user/registration" >¡Regístrate ya!</a>   ...y comienza a disfrutar de <b>Personaling.</b></p>
			</div>
		</article>
	</section>
<?php } elseif($pais->idioma=='es_ve') { ?>

<article class="como_funciona"> 
	<div class="seccion1">
		<div class="container"><div class="row-fluid">
			<div class="span6 "><div class="padding_large"><h1>Una nueva manera de<br/> hacer shopping</h1>
				<p class="lead">
					Personaling es una tienda online donde podrás conseguir las mejores marcas de moda, con las que expertos te asesorarán para comprar looks adaptados a tu tipo de cuerpo y estilo en un solo click, directo a tu casa u oficina. En Personaling queremos que te inspires, descubras y conquistes, comprando las prendas que te hagan realzar tu figura, estar cómoda y sentirte poderosa. Por eso somos tu Personal Shopper Online.
				</p>
				</div>
			</div>

			<div class="span6"><iframe width="100%" height="370" src="//www.youtube.com/embed/oAKyeeTng1U" frameborder="0" allowfullscreen></iframe></div>
		</div></div>
<!-- 		<div style=" z-index: -99; width: 100%; height: 100%">
		  <iframe frameborder="0" height="100%" width="100%" 
		    src="https://youtube.com/embed/oAKyeeTng1U?autoplay=1&controls=0&showinfo=0&autohide=1">
		  </iframe>
		</div>	 -->	
	</div>
	<section class="seccion2">
		<div class="container"><h1>MARCAS RECONOCIDAS</h1>
			<p>¡Tus marcas preferidas en un solo lugar! ¡Con tan solo un click en tu casa u oficina!</p>
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/como_brands.png" alt="Bimba y lola, Mango, Accesorize , Cortefiel, HellyHansen, Women'secret, SuiteBlanco, Melao, Jessus Zambrano">

		</div>
	</section>
	<section class="seccion3">
		<div class="container"><div class="row-fluid">
			<div class="span5"><h1 id="personal-shoppers">PERSONAL SHOPPERS</h1>
				<p>Serás asesorado por actrices, animadoras, celebridades y fashion bloggers. Todos ellos crearán looks adaptados a tus condiciones físicas y gustos para que siempre vayas vestida a la última moda.</p></div>
			</div></div>
		</section>
		<section class="seccion4">
			<div class="container"><div class="row-fluid">
				<div class="span5 offset6 margin_bottom padding_bottom"><h1 id="personalig-pto">PERSONALING es el punto de encuentro</h1>
					<p>Hemos logrado que la tecnología nos permita democratizar y masificar el servicio de Personal Shopper que hasta ahora solo había estado al alcance de celebrities y personas de alto standing. Aquí se unen estilistas, celebridades y bloggers para trabajar en función del estilo de la mujer venezolana. </p></div>
					<div class="span10 offset1 como_safari">
						<div class="row"> <div class="span7 offset4">
							<div class="bg_color3 padding_medium border_1"><h2>¡Comienza ya!</h2>
								<p>Regístrate, disfruta de la experiencia Personaling y siéntete siempre estupenda.</p>
							</div>
						</div>
					</div>


							</div>
						</div></div>
					</section>
<!-- 					<section class="seccion5">
						<div class="container">
							<h1 id="resultado">Resultado</h1>
							<div class="row-fluid margin_top padding_top CAPS text_align_center">
								<div class="span4 image1">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/como_circulo_marcas.jpg" alt="marcas">
									Compras un <br/>
									Look completo



								</div>
								<div class="span4 image2">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/como_circulo_ps.jpg" alt="marcas">
									Recomendado por tu<br/>
									Personal Shopper preferido 
								</div>
								<div class="span4 image3">
									<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/como_circulo_rosa.jpg" alt="marcas">
									Para vestir perfecta <br/>
									en tu ocasion especial
								</div>

							</div>
						</div>

					</section> -->
				</article>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.superscrollorama.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/TweenMax.min.js"></script>
<script>
	
	$(document).on('ready',handlerReady);

	function handlerReady () {
		var controller = $.superscrollorama(
		{
			triggerAtCenter: top,
			// reverse: false,
		}
		);
	
		controller.addTween('.seccion3', TweenMax.fromTo( $('.seccion3'), .4, {css:{'opacity':'0','margin-right':'-1000px'}, immediateRender:true, ease:Quad.easeInOut}, {css:{'opacity':'1','margin-right':'0'}, ease:Quad.easeInOut}), 0, 100);

		controller.addTween(
			'.seccion4', // etiqueta trigger
		  	(new TimelineLite())
		    .append([
		      	TweenMax.fromTo($('.seccion4'), 1, 
		        {css:{'margin-left':'-300px'}, immediateRender:true}, 
		        {css:{'margin-left':'0px'}}),
		    ]),
			700// pixeles de comienzo
		); 

		controller.addTween('.seccion4', TweenMax.fromTo( $('.como_safari'), .4, {css:{'opacity':'0'}, immediateRender:true, ease:Quad.easeInOut}, {css:{'opacity':'1'}, ease:Quad.easeInOut}), 0, 300);
		// controller.addTween('#resultado', TweenMax.fromTo( $('#resultado'), 0.7, {css:{'margin-left':'-300px'}, immediateRender:true, ease:Quad.easeInOut}, {css:{'margin-left':'0px'}, ease:Quad.easeInOut}), 0, 20);												
		// controller.addTween('.seccion5', TweenMax.fromTo( $('.image1'), 1, {css:{'opacity':'0'}, immediateRender:true, ease:Quad.easeInOut}, {css:{'opacity':'1'}, ease:Quad.easeInOut}), 0, 100);	
		// controller.addTween('.seccion5', TweenMax.fromTo( $('.image2'), 1, {css:{'opacity':'0'}, immediateRender:true, ease:Quad.easeInOut}, {css:{'opacity':'1'}, ease:Quad.easeInOut}), 0, 120);	
		// controller.addTween('.seccion5', TweenMax.fromTo( $('.image3'), 1, {css:{'opacity':'0'}, immediateRender:true, ease:Quad.easeInOut}, {css:{'opacity':'1'}, ease:Quad.easeInOut}), 0, 140);
	}
</script>

<?php }?>				
