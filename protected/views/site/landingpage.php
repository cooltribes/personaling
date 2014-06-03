<?php
//$this->pageTitle=Yii::app()->name . ' - Página de inicio';
if(isset($seo)){
	$this->pageTitle = $seo->title;
	Yii::app()->clientScript->registerMetaTag($seo->title, 'title', null, null, null);
	Yii::app()->clientScript->registerMetaTag($seo->description, 'description', null, null, null);
	Yii::app()->clientScript->registerMetaTag($seo->keywords, 'keywords', null, null, null);
}
?>
<div class="wrapper-landingpage">
	<div class="wrapper-inside-landingpage">
		<section class="content-landingpage">
			<figure class="logo-personaling ">
		    	<img src="<?php echo Yii::app()->theme->baseUrl.'/images/logocompleto.png' ?>" alt="Personaling - Tu Personal Shopper Online " width="320" height="325">
		    	<p class="lead margin_top_xsmall text_align_center slongan">Tu Personal Shopper Online</p>   
	
		    	<div class="dropdown width320 landingdrop">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-decoration: none">
						<div class="dropinput">
								<span id="precio_titulo">Elige tu País</span>
							<small> 
								<b class="caret"></b>
							</small>
						</div>
					</a>
					<ul class="dropdown-menu width320">
						
					<li><a class="precio" href="http://www.personaling.es" >España<span class="color12"></span></a></li>
					<li><a class="precio" href="http://www.personaling.com.ve">Venezuela<span class="color12"></span></a></li>
						 
					</ul>
				</div>
		  	
		      
			</figure>
		</section>
	</div>
</div>
<style>
	.navbar,
	#wrapper_footer{
		display: none;
	}
</style>
<script>
	$(document).ready(function(){
		var country = readCookie('country_value');
		if(country){
			window.location.replace(country);
		}
	});

	$('#paisselect').on('change', function(e){
		createCookie('country_value', this.options[this.selectedIndex].value, 7);
		window.location.replace(this.options[this.selectedIndex].value);
	});

	/*$('.arrow').on('change', function(e){
		createCookie('country_value', this.options[this.selectedIndex].value, 7);
		window.location.replace(this.options[this.selectedIndex].value);
	});*/

	function createCookie(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	}

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}

	function eraseCookie(name) {
		createCookie(name,"",-1);
	}
</script>