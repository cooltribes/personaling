
</div>
</div>
<article class="como_funciona"> 
	<div class="seccion1">
		<div class="container"><div class="row-fluid">
			<div class="span6 "><div class="padding_large"><h1>Una nueva manera de<br/> hacer shopping</h1>
				<p class="lead">
					Recomendaciones personalizadas adaptadas a tu cuerpo, tus gustos y por supuesto a las tendencias. </p>
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
			<p>Tus marcas preferidas en un solo lugar! con tan solo un clic en tu casa u oficina!</p>
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/como_brands.png" alt="Bimba y lola, Mango, Accesorize ">

		</div>
	</section>
	<section class="seccion3">
		<div class="container"><div class="row-fluid">
			<div class="span5"><h1 id="personal-shoppers">PERSONAL SHOPPERS</h1>
				<p>Tus Fashion bloggers, actrices, animadoras, web influencers preferidos, que con su estilo propio y definido; compartirán a sus networks o comunidades looks nacidos de su inspiración.!</p></div>
			</div></div>
		</section>
		<section class="seccion4">
			<div class="container"><div class="row-fluid">
				<div class="span5 offset6 margin_bottom padding_bottom"><h1 id="personalig-pto">PERSONALING es el punto de encuentro</h1>
					<p>Donde los looks ideados por los Personal Shoppers y los perfiles creados por todas las usuarias se unen creando una recomendación personalizada para que con tan solo un click y directo a tu casa u oficina luzcas estupenda de acuerdo a cada ocasión.!  </p></div>
					<div class="span10 offset1 como_safari">
						<div class="row"> <div class="span7 offset4">
							<div class="bg_color3 padding_medium border_1"><h2>COMIENZA LA CAMPAÑA</h2>
								<p>Los looks recomendados de los expertos Personal Shoppers de acuerdo a tu perfil,  están listos para que puedas comprarlos! Personaling te hace sentir Estupenda!</p></div></div></div>


							</div>
						</div></div>
					</section>
					<section class="seccion5">
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

					</section>
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
		        {css:{'margin-left':'-200px'}, immediateRender:true}, 
		        {css:{'margin-left':'0px'}}),
		    ]),
			900// pixeles de comienzo
		); 

		controller.addTween('#resultado', TweenMax.fromTo( $('#resultado'), 0.7, {css:{'margin-left':'-300px'}, immediateRender:true, ease:Quad.easeInOut}, {css:{'margin-left':'0px'}, ease:Quad.easeInOut}), 0, 20);												
		controller.addTween('.seccion5', TweenMax.fromTo( $('.image1'), 1, {css:{'opacity':'0'}, immediateRender:true, ease:Quad.easeInOut}, {css:{'opacity':'1'}, ease:Quad.easeInOut}), 0, 100);	
		controller.addTween('.seccion5', TweenMax.fromTo( $('.image2'), 1, {css:{'opacity':'0'}, immediateRender:true, ease:Quad.easeInOut}, {css:{'opacity':'1'}, ease:Quad.easeInOut}), 0, 120);	
		controller.addTween('.seccion5', TweenMax.fromTo( $('.image3'), 1, {css:{'opacity':'0'}, immediateRender:true, ease:Quad.easeInOut}, {css:{'opacity':'1'}, ease:Quad.easeInOut}), 0, 140);
	}
</script>

