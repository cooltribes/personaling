<tr>
	<td>John Snow</td>
	<td>17/10/1985</td>
	<td>Aceptado</td>
	<td>+3</td>
	<?php
	echo CHtml::hiddenField('fb_id_invitado', $data->fb_id_invitado, array('id'=>'fb_id_invitado'));
	?>
</tr>

<script>
	$(document).ready(function(){
	    
	    window.fbAsyncInit = function() {
	        FB.init({
	            appId      : '323808071078482', // App ID secret c8987a5ca5c5a9febf1e6948a0de53e2
	            channelUrl : 'http://personaling.com/site/user/registration', // Channel File
	            status     : true, // check login status
	            cookie     : true, // enable cookies to allow the server to access the session
	            xfbml      : true,  // parse XFBML
	            oauth      : true,
	            frictionlessRequests : true
	        });
	
	    };
	    
	    (function(d){
	        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	        if (d.getElementById(id)) {return;}
	        js = d.createElement('script');js.id = id;js.async = true;
	        js.src = "//connect.facebook.net/en_US/all.js";
	        ref.parentNode.insertBefore(js, ref);
	    }(document));
	    
	    
	});
	
	$(document).load(function(){
		FB.getLoginStatus(function(response){
	        console.log("response: "+response.status);
	        if (response.status === 'connected') {
	        	// está conectado a facebook y además ya tiene permiso de usar la aplicacion personaling
					
				//console.log('Welcome!  Fetching your information.... ');
	                    
	                    FB.api('/'+$('#fb_id_invitado').val(), function(response) {
	                        console.log('Nombre: ' + response.id + '.\nE-mail: ' + response.email);
	                        
	                    }, {scope: 'email,user_birthday'});
	                    
	          	
	        } else {
	            FB.login(function(response) {
	                if (response.authResponse) {
	                	//user is already logged in and connected (using information)
	                    console.log('Welcome!  Fetching your information.... ');
	                    
	                    FB.api('/'+$('#fb_id_invitado').val(), function(response) {
	                        console.log('Nombre: ' + response.id + '.\nE-mail: ' + response.email);
	                    });
	                } else {
	                    //console.log('User cancelled login or did not fully authorize.');
	                }
	            }, {scope: 'email,user_birthday'});
	        }
	    });
	});
</script>