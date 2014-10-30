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
	<div class="wrapper-inside-landingpage" align="center">

		
		    	<img class="margin_top_medium" src="<?php echo Yii::app()->theme->baseUrl.'/images/logocompleto.png' ?>" alt="Personaling - Tu Personal Shopper Online " width="320" height="325">
		    	<p class="lead margin_top_xsmall text_align_center slongan">Tu Personal Shopper Online</p>
		    	<div id="excuses" class="hide text_center_align margin_medium" style="width:80%">
		    		Próximamente volveremos a estar Online.<br/>Siguenos en nuestras redes y te mantendremos informado.
		    	</div>
	
		
			<div align="center">
					<a class="btn btn-danger margin_bottom_medium margin_top_medium" style="width:90px" href="http://www.personaling.es" value="http://www.personaling.es" >España<span class="color12"></span></a>
					<a class="btn btn-danger disabled margin_bottom_medium margin_top_medium" style="width:90px" value="http://www.personaling.com.ve"  onclick="$('#excuses').show()">Venezuela<span class="color12"></span></a>
			</div>
					
			 
					
				
		  	
		      
	
	
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
		/*if(country){
			window.location.replace(country);
		}*/
	});
	$('#cookies_notification').css('margin-top','0px');
	$('#cookies_notification').css('position','absolute');
	$('#cookies_notification').css('z-index','45');
	$('#cookies_notification').css('left','0');
	$('#cookies_notification').css('opacity','0.7');
	$("#cookies_notification").mouseenter(function() {
    $(this).css("opacity", "1");
}).mouseleave(function() {
     $(this).css("opacity", "0.6");
});


	$('.pais').on('click', function(e){
		createCookie('country_value', $(this).attr('value'), 7);
		//window.location.replace(this.options[this.selectedIndex].value);
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