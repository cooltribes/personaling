<div class="wrapper-landingpage">
	<div class="wrapper-inside-landingpage">
		<section class="content-landingpage">
			<figure class="logo-personaling ">
		    	<img src="<?php echo Yii::app()->theme->baseUrl.'/images/logocompleto.png' ?>" alt="Personaling - Tu Personal Shopper Online " width="320" height="325">
		    	<p class="lead margin_top_xsmall text_align_center slongan">Tu Personal Shopper Online</p>   
		    	<div class="box-select">
			    	<select class="select-pais" name="paisselect" id="paisselect">
			    		<option value="-1" default> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspelige tu país</option>
			    		<option value="http://www.personaling.es">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspEspaña</option>
			    		<option value="http://www.personaling.com.ve">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspVenezuela</option>
			    	</select>  
			    	<span class="arrow" style="cursor:pointer;"></span>
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