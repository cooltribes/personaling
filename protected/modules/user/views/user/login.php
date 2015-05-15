<style type="text/css">
  #entrar{
    color: #0B0B3B }
  </style>

<script>
	$('#ingresa').addClass('active');
	
</script>
<?php
if(isset($seo)){
  $this->pageTitle = $seo->title;
  Yii::app()->clientScript->registerMetaTag($seo->title, 'title', null, null, null);
  Yii::app()->clientScript->registerMetaTag($seo->description, 'description', null, null, null);
  Yii::app()->clientScript->registerMetaTag($seo->keywords, 'keywords', null, null, null);
}
?>
<?php /*?><?php
$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Login");
$this->breadcrumbs=array(
	UserModule::t("Login"),
);
?><?php */
//Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características.', 'description', null, null, null);
//Yii::app()->clientScript->registerMetaTag('Personaling, Mango, Timberland, personal shopper, Cortefiel, Suiteblanco, Accesorize, moda, ropa, accesorios', 'keywords', null, null, null);
// Open Graph
  Yii::app()->clientScript->registerMetaTag('Personaling.com - Login', null, null, array('property' => 'og:title'), null); 
  Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características', null, null, array('property' => 'og:description'), null);
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
  Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 
  Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->baseUrl .'/images/icono_preview.jpg', null, null, array('property' => 'og:image'), null); 
?>

<?php if(Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="success">
	<?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>
<div class="container margin_top">
  <div class="row">
    <div class="span6 offset3">
      <h1 class="text_align_center"><?php echo UserModule::t('Login'); ?></h1>
      <h4 class="text_align_center"><?php echo UserModule::t('To log on Personaling you can:'); ?></h4>
      <div  class="row-fluid  margin_top">
              <div id="boton_facebook" class="span6  text_align_center offset3 margin_bottom "><a title="<?php echo UserModule::t('Login with Facebook'); ?>" class="transition_all" onclick="check_fb()" href="#"><?php echo UserModule::t('Login with Facebook'); ?></a></div>

              <!-- <div id="boton_twitter" class="span5 offset2 margin_bottom "><a id="registro_twitter" title="Inicia sesión con Twitter" class="transition_all" href="<?php echo Yii::app()->request->baseUrl; ?>/user/registration/twitterStart">Inicia sesión con Twitter</a>  -->
              <!--                            <script type="IN/Login" data-onAuth="onLinkedInAuth"></script>--> 
        <!-- </div> -->
      </div>
      <?php if(Yii::app()->user->hasFlash('error')){?>
        <div class="alert in alert-block fade alert-error text_align_center">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
    <?php } ?>
      <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
			'id'=>'login-form',
			'htmlOptions'=>array('class'=>'personaling_form'),
		    //'type'=>'stacked',
		    'type'=>'inline',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>
          <fieldset>
            <legend  class="text_align_center"><?php echo UserModule::t('Or use your credentials personaling'); ?> </legend>
            
            <div class="control-group row-fluid">
            	 <div class="controls"> 
            		<?php echo $form->textFieldRow($model,'username',array("class"=>"span12","placeholder"=>"correoelectronico@cuenta.com")); ?>
            		<?php echo $form->error($model,'username'); ?>
            	</div>  
            </div>
             <div class="control-group row-fluid"> 
             	<div class="controls">
            		<?php echo $form->passwordFieldRow($model,'password',array(
            			'class'=>'span12',
        				'hint'=>'Hint: You may login with <kbd>demo</kbd>/<kbd>demo</kbd> or <kbd>admin</kbd>/<kbd>admin</kbd>',
    				)); ?>
                     <span class="help-block muted text_align_right padding_right"><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/recovery" class="muted" title="Recuperar contraseña"><?php echo UserModule::t('Lost Password?'); ?></a></span>
    				<?php echo $form->error($model,'password'); ?>
                                <?php echo $form->error($model,'status'); ?>
                </div>
    		</div>
            <?php echo $form->checkBoxRow($model,'rememberMe'); ?>
            
            
            	<div class="padding_top_medium padding_bottom_medium">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'danger',
            'size'=>'large',
            'label'=>UserModule::t('Enter'),
            'htmlOptions'=>array('class'=>'btn-block'),
        )); ?>
        </div>
         <span class="color8"> <?php echo UserModule::t('If you don\'t have an account'); ?>, <u><a id="entrar" href="<?php echo Yii::app()->request->baseUrl; ?>/user/registration" title="Registrate"><?php echo UserModule::t('Sign up here'); ?> </a> </u></span>
          </fieldset>
        <?php $this->endWidget(); ?>
      </section>
    </div>
  </div>
</div>

<?php  
 $baseUrl = Yii::app(true)->baseUrl;
 Yii::app()->session['ruta']=$baseUrl."/tienda/index";
 /*$cs = Yii::app()->getClientScript();
 $cs->registerScriptFile($baseUrl.'/js/facebook.js');*/

 
?>

<script>
$(document).ready(function(){
    var fb_id = '323808071078482';
    var url = window.location.href;
    if(url.indexOf("personaling.com.ve") > -1){
      fb_id = '386830111475859';
    }
    window.fbAsyncInit = function() {
        FB.init({
            appId      : fb_id, // App ID secret c8987a5ca5c5a9febf1e6948a0de53e2
            channelUrl : '<?php echo Yii::app()->baseUrl."/registro-personaling"; ?>', // Channel File
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
    	
        console.log("response: "+response);
        
        if (response.status === 'connected') {
            // En Facebook y App con permisos aprobados.
            
            var datos = "facebook";
            
            FB.api('/me', function(response) {
              var ciudad = '';
              if(typeof response.location != 'undefined'){
            	 ciudad=response.location.name;
      					ciudad=ciudad.split(",");
      					ciudad=ciudad[0];
              }
                $.ajax({
                  url: "user/login/loginfb",
                  data: {email : response.email, datos: datos, ciudad:ciudad},
                  type: 'POST',
                  dataType: 'html',
                  success: function(data) {
                      if(data == "existe"){
                          console.log('existe');
                       //   var Url = "<?php echo Yii::app()->baseUrl; ?>";
                          //window.location = "../site/personal";
                          /*Unificacion de la tienda de looks con tu personal shopper*/
                          window.location = '<?php echo Yii::app()->session['ruta']; ?>';
                      }else if(data=='no'){
                          console.log('no existe');
                      //    var Url = <?php echo Yii::app()->baseUrl; ?>+"";
                          window.location = "../user/registration";
                      }
                  } // success
                  
                });
            }, {scope: 'email,user_birthday,location'});            
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
                    	var ciudad = '';
                      if(typeof response.location != 'undefined'){
                       ciudad=response.location.name;
                        ciudad=ciudad.split(",");
                        ciudad=ciudad[0];
                      }
                      $.ajax({
	                  url: "user/login/loginfb",
	                  data: {email: response.email, datos: datos, ciudad: ciudad},
	                  type: 'POST',
	                  dataType: 'html',
	                  success: function(data) {
	                      if(data == "existe"){
	                          console.log('existe');
	                         // var Url = <?php echo Yii::app()->baseUrl; ?>+"";
                            //window.location = "http://www.personaling.com.ve/develop/tienda/look";     
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
            }, {scope: 'email,user_birthday,location'});
        }
    });
}
</script>
