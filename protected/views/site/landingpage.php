<?php
//$this->pageTitle=Yii::app()->name . ' - Página de inicio';
if(isset($seo)){
	$this->pageTitle = $seo->title;
	Yii::app()->clientScript->registerMetaTag($seo->title, 'title', null, null, null);
	Yii::app()->clientScript->registerMetaTag($seo->description, 'description', null, null, null);
	Yii::app()->clientScript->registerMetaTag($seo->keywords, 'keywords', null, null, null);
}

if(Yii::app()->session['pais']!="")
{
	Yii::app()->session['pais']="";	

?>

	 <div id="confirmLook" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" >
	 <div class="modal-header">
	       <button type="button" class="close closeModal" data-dismiss="modal" aria-hidden="true" onclick="$('#confirmLook').hide();">×</button>
	     <h3 ><?php echo "Registro";?></h3>
	 
	  </div>
	  <div class="modal-body">
	         <h4><?php echo "Tu correo ha sido registrado con exito";?></h4>
	         
	  </div>
	 
	</div>
<?php 
}
?>	


	
	
	
<div class="wrapper-landingpage">
	<div class="wrapper-inside-landingpage" align="center">

		
		    	<img class="margin_top_medium" src="<?php echo Yii::app()->theme->baseUrl.'/images/logocompleto.png' ?>" alt="Personaling - Tu Personal Shopper Online " width="320" height="325">
		    	<p class="lead margin_top_xsmall text_align_center slongan">Tu Personal Shopper Online</p>
		    	<div id="excuses" class="hide text_center_align margin_medium" style="width:80%">
		    	Faltan pocos días para nuestro regreso a Venezuela, ingresa tu correo electrónico <br/> y serás una de las primeras en recibir nuestras noticias.<br/>
				Tu Personal Shopper Online
				Imagínate, descúbrete y conquista. <br/><br/>
				<?php #echo CHtml::label('Introduzca Correo Electronico' ,''); 
				 echo CHtml::textField('email', '', array('placeholder'=>'Introduzca Correo Electronico')); 
				echo CHtml::button('Entrar', array('style'=>'margin-top: -10px;','id'=>'botone', 'submit'=>array('site/landing'))); ?>
		    	</div>
	
		
			<div align="center">
					<a class="btn btn-danger margin_bottom_medium margin_top_medium pais" style="width:90px" href="http://www.personaling.es" value="http://www.personaling.es" >España<span class="color12"></span></a>
					<a class="btn btn-danger margin_bottom_medium margin_top_medium pais" style="width:90px" href="http://www.personaling.com.ve">Venezuela<span class="color12"></span></a>
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

$('#botone').click(function () {
	 var email=$('#email').val();
	 var pais="es";	
		 $.ajax({
					url: "<?php echo Yii::app()->createUrl('site/revi') ?>",
					type: 'POST',
					data:{
						email:email, pais:pais,
						 },
					success: function(resp)
						{
					//alert(resp);
						} 
					 });
		});
	$(document).ready(function(){
		var country = readCookie('country_value');
		if(country){
			window.location.replace(country);
		}
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