<?php
$this->breadcrumbs=array(
	UserModule::t("Mi cuenta") => array('micuenta'),
	UserModule::t("Invitaciones"),
);
/** @var $form bootstrap.widgets.TbActiveForm */

$create_time = strtotime($model->create_at);
$create_date = date('j M Y', $create_time);
?>
<div class="container margin_top tu_perfil">
    <div class="row">
    	<div id="confirmacion_facebook" class="alert alert-success text_center_align" style="display: none;">Invitaciones enviadas</div>
        <aside class="span3">
            <div class="card margin_bottom_medium"> <img width="270" height="270" alt="Avatar" src="<?php echo $model->getAvatar(); ?>">
                <div class="card_content vcard">
                    <h4 class="fn"><?php echo $profile->first_name.' '.$profile->last_name; ?></h4>
                    <p class="muted">Miembro desde: <?php echo $create_date; ?></p>
                </div>
            </div> 
            <div>
                <ul class="nav nav-tabs nav-stacked">
                    <li class="nav-header">Opciones de edición</li>
                    <li class="dropdown-submenu"> <a href="#" tabindex="-1">Tu perfil</a>
                        <ul class="dropdown-menu">
                            <li> <a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/edit"><?php echo Yii::t('contentForm', 'Personal data');?></a> </li>
                            <li> <a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/avatar"><?php echo Yii::t('contentForm', 'Your photo');?></a> </li>
                            <li> <a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/edittutipo"><?php echo Yii::t('contentForm', 'Your body profile');?></a> </li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu"> <a href="#" tabindex="-1"><?php echo Yii::t('contentForm', 'Your orders');?> </a>
                        <ul class="dropdown-menu">
                            <li> <a href="<?php echo Yii::app()->baseUrl; ?>/orden/listado" title="<?php echo Yii::t('contentForm', 'Your active orders');?>"><?php echo Yii::t('contentForm', 'Your active orders');?></a></li>
                            <li> <a href="<?php echo Yii::app()->baseUrl; ?>/orden/listado" title="<?php echo Yii::t('contentForm', 'Your old and past orders');?>"><?php echo Yii::t('contentForm', 'Order history');?></a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu"> <a href="#" tabindex="-1"><?php echo Yii::t('contentForm', 'Your Style');?> </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/edittuestilo/id/coctel" title="Edita tu estilo Coctel"><?php echo Yii::t('contentForm', 'Cocktail');?></a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/edittuestilo/id/fiesta" title="Edita tu estilo Fiesta"><?php echo Yii::t('contentForm', 'Party');?></a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/edittuestilo/id/playa" title="Edita tu estilo Playa"><?php echo Yii::t('contentForm', 'Beach');?></a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/edittuestilo/id/Sport" title="Edita tu estilo Sport"><?php echo Yii::t('contentForm', 'Sport');?></a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/edittuestilo/id/trabajo" title="Edita tu estilo Trabajo"><?php echo Yii::t('contentForm', 'Work');?></a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu"> <a href="#" tabindex="-1"> <?php echo Yii::t('contentForm', 'Your favorites');?></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/looksencantan" title="Looks que te encantan"><?php echo Yii::t('contentForm', 'Looks');?></a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/encantan" title="Productos que te encantan"><?php echo Yii::t('contentForm', 'Products');?></a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu"> <a href="#" tabindex="-1"> <?php echo Yii::t('contentForm', 'Email and Password');?> </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/changeemail" title="<?php echo Yii::t('contentForm', 'Change email');?>"><?php echo Yii::t('contentForm', 'Change email');?></a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/changepassword" title="<?php echo Yii::t('contentForm', 'Change password');?>"><?php echo Yii::t('contentForm', 'Change password');?></a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu"> <a href="<?php echo Yii::app()->baseUrl; ?>/site/notificaciones" tabindex="-1"> <?php echo Yii::t('contentForm', 'Notifications');?> </a>
                       <!-- <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/direcciones" title="Gestiona tus direcciones">Gestionar direcciones de Envíos y Pagos.</a></li>
                       </ul> -->
                    </li>
                    <li class="dropdown-submenu"> <a href="#" tabindex="-1"> <?php echo Yii::t('contentForm', 'Address book');?> </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/direcciones" title="Gestiona tus direcciones"><?php echo Yii::t('contentForm', 'Manage addresses Shipping and Payments.');?></a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu"> <a href="#" tabindex="-1"> <?php echo Yii::t('contentForm', 'Privacy');?></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/privacidad" title="Cambia tu Informaciósn pública"><?php echo Yii::t('contentForm', 'Public information');?></a></li>
                            <li><a href="<?php echo Yii::app()->baseUrl; ?>/user/profile/delete" title="Eliminar Cuenta"><?php echo Yii::t('contentForm', 'Delete account');?></a> </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </aside>
        <div class="span9 ">
            <div class=" box_1">
                <div class="page-header">
                    <h1><?php echo Yii::t('contentForm', 'Invite your friends by email');?></h1>
                </div>
                            
            	<div class="span8 padding_bottom_small text_align_center">
            		<p> <?php echo Yii::t("contentForm","Welcome! Already part of Personaling.com; from now within the distance of a click the best brands and fashion consulting by experts.");?></p>
            		<?php if($model->personal_shopper==0){
            			
            		?>
            		<p><?php echo Yii::t('contentForm', 'Privacy');?></p>
            	<?php }?>
            	</div>
                <?php $ruta_twitter='https://twitter.com/intent/tweet?url='.Yii::app()->getBaseUrl(true).'&text=&lang=es&via=Personaling'; ?>
                <script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>
                <div class="row-fluid margin_bottom margin_top padding_top">
                    <div class="span6 offset3">
                        <div onclick="invite_friends()" style="cursor: pointer;" id="boton_facebook" class="text_align_center"><a> <?php echo Yii::t('contentForm', 'Invite them using Facebook');?></a></div>
                    	<p>
                    	<div style="cursor: pointer;" id="boton_twitter" class="text_align_center"><a href=<?php echo $ruta_twitter;?> ><?php echo Yii::t('contentForm', 'Invite them using Twitter');?></a></div>
                  <script src="https://apis.google.com/js/plusone.js" async defer>
                   {lang: 'es'}    	
              
                  </script>
                  <p>
					<div class="g-plus" data-action="share" data-annotation="none" data-href='<?php echo Yii::app()->getBaseUrl(true);?>' data-height="24" hl="es" ... ></div>
					
					
					
                    </div>
<!--                     <div class="span2 text_align_center T_large">- o -</div>
                    <div class="span5">
                        <div onclick="invite_friends_twitter()" style="cursor: pointer;" id="boton_twitter" class="text_align_center"><a>Invítalos usando Twitter</a></div>
                    </div> -->
                </div>
                <?php 
                      $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                          'id'=>'emailInvite-form',
                          'action' => $this->createUrl('sendEmailInvs'),
                          'htmlOptions'=>array('class'=>'form-stacked braker_horz_top_1 no_margin_bottom'),
                      ));
                ?>
<!--                <form  class="form-stacked braker_horz_top_1 no_margin_bottom">-->
                    <fieldset>
                        <legend ><?php echo Yii::t('contentForm', 'Or Invite them using email');?></legend>
                        <div class="row">
	                        <div class="offset2 span5">                            
	                            <div class="control-group">
	                                <label class="control-label required"><?php echo Yii::t('contentForm', 'Write your email\'s friends');?> </label>
	                                <div class="controls">
	                                    <?php
	                                    $this->widget('application.extensions.BulkMail.BulkMail',
	                                            array(
	                                                'model' => $model,
	                                                'field' => 'emailList',
	                                                'form' => $form,
	                                                'cssInputNew' => ''
	                                                

	                                            )
	                                    );
	                                    ?>
	                                    <span class="help-block error" id="User_emails_em_" style="display: none;"> <?php echo Yii::t('contentForm', 'You must enter at least one email address');?> </span>
	                                </div>
	                            </div>
	                            <div class="control-group">
	                                <label class="control-label required"><?php echo Yii::t('contentForm', 'Write a personal message');?> </label>
	                                <div class="controls">
	                                    <?php 
	                                   echo CHtml::textArea('invite-message',
	                                   Yii::t('contentForm','I\'ve created great looks on my profile, go and take a look'),
	                                   array('class' => 'span5', 'rows' => '4'));
	                                   ?>
	                                   <span class="help-block error" id="invite_mess_em_" style="display: none;"> <?php echo Yii::t('contentForm', 'You must to write a message');?> </span>
	                                </div>    
	                            </div>                            
	                        </div>
                    	</div>
                        <div class="form-actions"> 
                            <a id="enviarInvitaciones" class="btn-large btn btn-danger offset5"><?php echo Yii::t('contentForm', 'Send Invitations');?></a> 
                            <?php /*$this->widget('bootstrap.widgets.TbButton', array(
                                                'buttonType'=>'submit',
                                                'label'=>'Enviar invitaciones',
                                                'htmlOptions' => array(
                                                    'class' => 'btn-large btn-danger'
                                                ),
                                                ));*/ ?>
                        </div>
                    </fieldset>
<!--                </form>-->
                <?php $this->endWidget(); ?>
              
                
            </div>
            <?php
            if($dataProvider->getItemCount() > 0){ 
	            ?>
	            <div class="box_1 margin_top_medium"> <h2 class=" color2 braker_bottom">Historial de invitaciones</h2><p>En la siguiente lista podrás ver el status de las invitaciones que has enviado y los puntos acumulados por cada una: </p>
	            <?php
				$template = '{summary}
				  <table width="100%" class="table table-bordered table-hover table-striped" border="0" cellspacing="0" cellpadding="0">
				    <tr>
				      	<th>Nombre de usuario</th>
	                    <th>Fecha de invitación</th>
	                    <th>Estado</th>
	                    <th>Puntos</th>
				    </tr>
				    {items}
				    </table>
				    {pager}
					';
					
					 $pagerParams=array(
			        'header'=>'',
			        'prevPageLabel' => Yii::t('contentForm','Previous'),
			        'nextPageLabel' => Yii::t('contentForm','Next'),
			        'firstPageLabel'=> Yii::t('contentForm','First'),
			        'lastPageLabel'=> Yii::t('contentForm','Last'),
			        'htmlOptions'=>array(
			            'class'=>'pagination pagination-right'));   
				
						$this->widget('zii.widgets.CListView', array(
					    'id'=>'list-invitaciones',
					    'dataProvider'=>$dataProvider,
					    'itemView'=>'_view_invitacion',
					    'template'=>$template,
					        'summaryText' => 'Mostrando {start} - {end} de {count} Resultados',  
					    'enableSorting'=>'false',
					    'emptyText'=> Yii::t('contentForm','No elements to show'),
						'pager' =>$pagerParams, 				
					));    
					?>
	            </div>
	            <?php
            }
            ?>
            
        </div>
    </div>
</div>
</div>
<!-- /container -->
<?php 
if(Yii::app()->language=="es_es")
{
	
	$appId=323808071078482; //para facebook espana	
}
else 
{
	$appId=386830111475859; //para facebook venezuela
}
?>
<script>
	$(document).ready(function(){
		var appId=<?php echo $appId;?>;
	    //alert('http://'+window.location.host+'<?php //echo Yii::app()->baseUrl; ?>'+'/user/registration');
	    window.fbAsyncInit = function() {
	        FB.init({
	            appId      : appId, // App ID secret c8987a5ca5c5a9febf1e6948a0de53e2
	            channelUrl : 'http://'+window.location.host+'<?php echo Yii::app()->baseUrl; ?>'+'/user/registration', // Channel File
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

	function invite_friends(){
		
		FB.getLoginStatus(function(response){
			
	        //console.log("response: "+response.status);
	        if (response.status === 'connected') {
	        	// está conectado a facebook y además ya tiene permiso de usar la aplicacion personaling
					
				console.log('Welcome!  Fetching your information.... ');
	                    
	                    FB.api('/me', function(response) {
	                        //console.log('Nombre: ' + response.id + '.\nE-mail: ' + response.email);
	                        $.ajax({
								type: "get",
								dataType: 'html',
								url: "checkFbUser", // action 
								data: { 'fb_id': response.id	}, 
								success: function () {
									//console.log('saved');
								}//success
							});
	                    }, {scope: 'email,user_birthday'});
	                    
	          	FB.ui({method: 'apprequests',
			      title: 'Personaling',
			      message: '¡Te invito a probar Personaling, Tu Personal Shopper Online!',
			    }, fbCallback);
	        } else {
	            FB.login(function(response) {
	                if (response.authResponse) {
	                	//user is already logged in and connected (using information)
	                    console.log('Welcome!  Fetching your information.... ');
	                    
	                    FB.api('/me', function(response) {
	                        //console.log('Nombre: ' + response.id + '.\nE-mail: ' + response.email);
	                         $.ajax({
								type: "get",
								dataType: 'html',
								url: "checkFbUser", // action 
								data: { 'fb_id': response.id	}, 
								success: function () {
									//console.log('saved');
								}//success
							});
	                    });
	                    
	                    FB.ui({method: 'apprequests',
					      title: 'Personaling',
					      message: '¡Te invito a probar Personaling, Tu Personal Shopper Online!',
					    }, fbCallback);
	                } else {
	                    //console.log('User cancelled login or did not fully authorize.');
	                }
	            }, {scope: 'email,user_birthday'});
	        }
	    });
	}
	
	function fbCallback(response){
		if(response != null){
			/*var user_ids = response.to.split(",");*/
			for(var i = 0; i < response.to.length; i++){
				//console.log('id: '+response.to[i]);
				var id_actual = response.to[i];
				var id_request = response.request;
				//console.log('request: '+id_request);
				FB.api('/'+id_actual, function(user) {
					//console.log('ID: '+user.id);
					$.ajax({
						type: "post",
						dataType: 'html',
						url: "saveInvite", // action 
						data: { 'request': id_request, 'to': user.id, 'nombre': user.name }, 
						success: function (data) {
							//console.log('invite saved: '+data);
							$('#confirmacion_facebook').show('slow');
							//location.reload();
							//window.location="micuenta";
						}//success
					});
				});
			}
		}
		/*if(response != null){
			FB.api('/'+response.to, function(user) {
				console.log('Nombre: ' + response.name + '.\nE-mail: ' + response.email);
				$.ajax({
				type: "post",
				dataType: 'html',
				url: "saveInvite", // action 
				data: { 'request': response.request, 'to': response.to, 'nombre': user.name }, 
				success: function () {
					console.log('invite saved');
					$('#confirmacion_facebook').show('slow');
					//location.reload();
					//window.location="micuenta";
				}//success
			});
			});
		}*/
	}
</script>
<script type="text/javascript">
/*<![CDATA[*/
    $('#enviarInvitaciones').click(function(ev){
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('sendEmailInvs') ?>',
            dataType: 'json',
            data: $('#emailInvite-form').serialize(),
            success: function(data){
                console.log(data);
                if(data.status === "success"){                    
                    window.location = data.redirect;
                }
                
            },
            beforeSend: function(){                
                var result = true;
                
                var emails = $('input[type=hidden]').filter('[name*="emailList"]');                
                //si no hay emails
                if(!emails.size()){
                    $('#emailInvite-form_bulkEmailList').parent().parent().addClass('error');
                    $('#User_emails_em_').show();               
                    
                 result = false;   
                }else{
                   $('#emailInvite-form_bulkEmailList').parent().parent().removeClass('error');
                   $('#User_emails_em_').hide();  
                    
                }
                    
                
                //Si no hay mensaje
//                var message = $('#invite-message');
//                if(message.val() === ""){
//                    message.parent().parent().addClass('error');
//                    $('#invite_mess_em_').show();               
//                    result = false;   
//                }
                
                return result;               
            },
            error: function(jqXHR, textStatus, error){
                console.log("Error: \n");
                console.log(jqXHR.responseText);
            }
            });
    });
/*]]>*/
</script>

<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
    