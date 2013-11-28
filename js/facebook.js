$(document).ready(function(){
    
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '323808071078482', // App ID secret c8987a5ca5c5a9febf1e6948a0de53e2
            channelUrl : 'http://personaling.com/site/user/login', // Channel File
            status     : true, // check login status
            cookie     : true, // enable cookies to allow the server to access the session
            xfbml      : true,  // parse XFBML
            oauth      : true
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

function check_fb(){
    FB.getLoginStatus(function(response) {
    	
        console.log("response: "+response.status);
        
        if (response.status === 'connected') {
            // En Facebook y App con permisos aprobados.
            
            var datos = "facebook";
            
            FB.api('/me', function(response) {
                $.ajax({
                  url: "login/loginfb",
                  data: {email : response.email, datos: datos},
                  type: 'POST',
                  dataType: 'html',
                  success: function(data) {
                      if(data == "existe"){
                          console.log('existe');
                       //   var Url = "<?php echo Yii::app()->baseUrl; ?>";
                          //window.location = "../site/personal";
                          /*Unificacion de la tienda de looks con tu personal shopper*/
                          window.location = "../tienda/look";
                      }else if(data=='no'){
                          console.log('no existe');
                      //    var Url = <?php echo Yii::app()->baseUrl; ?>+"";
                          window.location = "../user/registration";
                      }
                  } // success
                  
                });
            }, {scope: 'email,user_birthday'});            
        }// else if(response.status === 'not_authorized'){
        	//alert("Ud. aún no se encuentra registrado.");
        //	window.location = "/site/user/registration";	
     //  }
        else {
            FB.login(function(response) { // no hizo login a fb aun o no tiene permisos
                if (response.authResponse) {
                	
                    console.log('Welcome!  Fetching your information.... ');
                    
                    var datos = "facebook";
                    
                    FB.api('/me', function(response) {
	                $.ajax({
	                  url: "login/loginfb",
	                  data: {email : response.email, datos: datos},
	                  type: 'POST',
	                  dataType: 'html',
	                  success: function(data) {
	                      if(data == "existe"){
	                          console.log('existe');
	                         // var Url = <?php echo Yii::app()->baseUrl; ?>+"";
                                 
	                         // window.location = "../site/personal";
                                 /*Unificacion de la tienda de looks con tu personal shopper*/
	                          window.location = "../tienda/look";
	                      }else if(data=="no"){
	                          console.log('no existe');
	                          alert("Ud. no se encuentra registrado.");
	                        //  var Url = <?php echo Yii::app()->baseUrl; ?>+"";
	                          window.location = "../user/registration";
	                      }
	                  	} // success
	                  
	                	});
	            	});  
                    
                } else {
                    console.log('User cancelled login or did not fully authorize.');
                }
            }, {scope: 'email,user_birthday'});
        }
    });
}