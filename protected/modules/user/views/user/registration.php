<?php

if (isset($_SERVER['HTTP_REFERER'])) 
{
	
	echo Yii::app()->session['referencia']= $_SERVER['HTTP_REFERER'];
}
else
{
	Yii::app()->session['referencia']='';
}

if(isset($seo)){
	$this->pageTitle = $seo->title;
	Yii::app()->clientScript->registerMetaTag($seo->title, 'title', null, null, null);
	Yii::app()->clientScript->registerMetaTag($seo->description, 'description', null, null, null);
	Yii::app()->clientScript->registerMetaTag($seo->keywords, 'keywords', null, null, null);
}
?>
<?php 
//Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características.', 'description', null, null, null);
//Yii::app()->clientScript->registerMetaTag('Personaling, Mango, Timberland, personal shopper, Cortefiel, Suiteblanco, Accesorize, moda, ropa, accesorios', 'keywords', null, null, null);
//$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Regístrate");
Yii::app()->clientScript->registerMetaTag('Personaling.com - Regístrate', null, null, array('property' => 'og:title'), null); 
Yii::app()->clientScript->registerMetaTag('Portal de moda donde puedes comprar prendas y accesorios de marcas prestigiosas, personalizadas y combinadas a tu gusto, necesidades y características', null, null, array('property' => 'og:description'), null);
Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->request->url , null, null, array('property' => 'og:url'), null);
Yii::app()->clientScript->registerMetaTag('Personaling.com', null, null, array('property' => 'og:site_name'), null); 
Yii::app()->clientScript->registerMetaTag(Yii::app()->request->hostInfo.Yii::app()->baseUrl .'/images/icono_preview.jpg', null, null, array('property' => 'og:image'), null); 

//$this->breadcrumbs=array(
	//UserModule::t("Registration"),
//);
     function getMonthsArray()
    {
        
         $months['01'] = Yii::t('contentForm','January');
		 $months['02'] = Yii::t('contentForm','February');
		 $months['03'] = Yii::t('contentForm','March');
		 $months['04'] = Yii::t('contentForm','April');
		 $months['05'] = Yii::t('contentForm','May');
		 $months['06'] = Yii::t('contentForm','June');
		 $months['07'] = Yii::t('contentForm','July');
		 $months['08'] = Yii::t('contentForm','August');
		 $months['09'] = Yii::t('contentForm','September');
		 $months['10'] = Yii::t('contentForm','October');
		 $months['11'] = Yii::t('contentForm','November');
		 $months['12'] = Yii::t('contentForm','December');
    

        return array(0 => Yii::t('contentForm','Month')) + $months;
    }

     function getDaysArray()
    {
		$days['01'] = '01';
		$days['02'] = '02';
		$days['03'] = '03';
		$days['04'] = '04';
		$days['05'] = '05';
		$days['06'] = '06';
		$days['07'] = '07';
		$days['08'] = '08';
		$days['09'] = '09';
        for($dayNum = 10; $dayNum <= 31; $dayNum++){
            $days[$dayNum] = $dayNum;
        }

        return array(0 => Yii::t('contentForm','Day')) + $days;
    }

     function getYearsArray()
    {
        $thisYear = date('Y', time());

        for($yearNum = $thisYear; $yearNum >= 1920; $yearNum--){
            $years[$yearNum] = $yearNum;
        }

        return array(0 => Yii::t('contentForm','Year')) + $years;
    }
?>



<?php if(Yii::app()->user->hasFlash('registration')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('registration'); ?>
</div>
<?php else: ?>
	

<div class="container margin_top">
  <div class="row">
    <div class="span6 offset3">
      <h1 class="text_align_center"><?php echo Yii::t('contentForm','Register'); ?></h1>
      <div class="row-fluid margin_bottom margin_top text_align_center">
            <div id="boton_facebook" class="span6 offset3 margin_bottom"><a title="Registrate con facebook" class="transition_all" onclick="check_fb()" href="#"><?php echo Yii::t('contentForm','Register with Facebook'); ?></a></div>

        	<!-- <div id="boton_twitter" class="span5 offset2 margin_bottom"> <a id="registro_twitter" title="Registrate con Twitter" class="transition_all" href="<?php echo Yii::app()->request->baseUrl; ?>/user/registration/twitterStart">Regístrate con Twitter</a>  -->
          <!--                            <script type="IN/Login" data-onAuth="onLinkedInAuth"></script>--> 
        <!-- </div> -->
      </div>
      <section class="bg_color3 margin_top  margin_bottom_small padding_small box_1">

        <?php  $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'registration-form',
	'htmlOptions'=>array('class'=>'personaling_form'),
    //'type'=>'stacked',
    'type'=>'inline',
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
          <fieldset>
            <p class="text_align_center"> <a href="<?php echo Yii::app()->getBaseUrl();?>/user/login"><?php echo Yii::t('contentForm','If you are already registered, click here'); ?></a></p>
            <legend class="text_align_center" ><?php echo Yii::t('contentForm','Or fill in the fields below :'); ?> </legend>
	<?php echo $form->errorSummary(array($model,$profile),"Corrije los siguientes errores:"); ?>
	<?php
	if(isset($_GET['request_ids'])){
		//echo $_GET['request_ids'];
		$requests = explode(',', $_GET['request_ids']);
		
		echo CHtml::hiddenField('facebook_request',$requests[0]);
	}
	?>

<div class="control-group row-fluid">
	<div class="controls">
	<!--[if IE 9]> 
		<label>Correo:</label>
	<![endif]--> 
	<?php echo $form->textFieldRow($model,'email',array("class"=>"span12",'readonly'=>$referencia=='look'?true:false)); 
	echo $form->error($model,'email');
	echo CHtml::hiddenField('referencia', $referencia, array('id'=>'referencia', 'name'=>'referencia'));
	?>
	</div>
</div>

<div class="control-group row-fluid">
	<div class="controls">	
	<!--[if IE 9]> 
		<label>Contraseña:</label>
	<![endif]--> 
	<?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span12')); 
	echo $form->error($model,'password');
	?>
	</div>
</div>

	
<?php 
		$profileFields=$profile->getFields();
		if ($profileFields) {
			echo $form->hiddenField($profile,'ciudad');
				
			foreach($profileFields as $field) {
				
					
				//echo $field->varname;
			?>
<div class="control-group">
	<div class="controls row-fluid">
		<?php 
		if ($widgetEdit = $field->widgetEdit($profile)) {
			echo $widgetEdit;
		} elseif ($field->range) {
			if ($field->varname == 'sex')
				echo $form->radioButtonListInlineRow($profile,$field->varname,Profile::range($field->range));
			else
				echo $form->dropDownListRow($profile,$field->varname,Profile::range($field->range));
			//echo $form->error($profile,$field->varname);
			
		} elseif ($field->field_type=="TEXT") {

			echo$form->textArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
			echo $form->error($profile,$field->varname);
		} elseif ($field->field_type=="DATE") {	
			echo $form->labelEx($profile,$field->varname, array('class'=>'span3'));	
			echo ' ';			
			echo $form->DropDownList($profile,'day',getDaysArray(),array('class'=>'span3'));
			echo ' ';
			echo $form->DropDownList($profile,'month',getMonthsArray(),array('class'=>'span3'));
			echo ' ';
			echo $form->DropDownList($profile,'year',getYearsArray(),array('class'=>'span3'));

			echo $form->hiddenField($profile,$field->varname);
			echo CHtml::hiddenField('facebook_id', '', array('id'=>'facebook_id', 'name'=>'facebook_id'));
			echo CHtml::hiddenField('facebook_picture', '', array('id'=>'facebook_picture', 'name'=>'facebook_picture'));
			//echo $form->textFieldRow($profile,$field->varname,array('class'=>'span5','maxlength'=>(($field->field_size)?$field->field_size:255)));
			echo $form->error($profile,$field->varname);
				 
				
		} else {

			//------------- condicion para mostar label en IE9 ON ----------------//
			
			
			if( $field->varname == 'first_name' ){
				?>
				<!--[if IE 9]> 
					<label>Nombre:</label>
				<![endif]--> 
				<?php  
			}
			elseif ($field->varname == 'last_name') {
				?>
				<!--[if IE 9]> 
					<label>Apellido:</label>
				<![endif]--> 
				<?php  
			}
			//------------- condicion para mostar label en IE9 OFF ----------------//

			#echo $form->textFieldRow($profile,$field->varname,array('class'=>'span12 ','maxlength'=>(($field->field_size)?$field->field_size:255)));
			echo $form->textFieldRow($profile, $field->varname, array('class' => 'span12 '));  
			echo $form->error($profile,$field->varname);
		}
		
		 
				 ?>
	</div>
</div>
			<?php
			}
		}
?>
	<div class="control-group">
		<label class="checkbox">
	  		<input type="checkbox" value="suscribir" name="Profile[suscribir]" checked>
	  		<?php echo Yii::t('contentForm','Subscribe to the mailing list Personaling'); ?>
		</label>
	</div>
            <hr/>
            <?php echo Yii::t('contentForm','Clicking " Next" you are indicating that you have read and accepted the Terms and Conditions and Privacy Policy'); ?>
            <!--Al hacer clic en "Siguiente" estas indicando que has leído y aceptado los <a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/terminos_de_servicio" title="Términos y condiciones" target="_blank">Términos de Servicio</a> y la <a href="<?php echo Yii::app()->getBaseUrl(); ?>/site/politicas_y_privacidad" title="Politicas de Privacidad" target="_blank">Políticas de Privacidad</a>. 
	-->
	<div class="padding_top_medium "> 
		
			
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
		    'label'=>Yii::t('contentForm','Next'),
		    'type'=>'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		    'size'=>'large', // null, 'large', 'small' or 'mini'
		    'htmlOptions'=>array('class'=>'btn-block'),
		)); ?>

	</div>

</fieldset>
<?php $this->endWidget(); ?>
      </section>
    </div>
  </div>
</div>
<?php endif; 

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
    window.fbAsyncInit = function() {
        FB.init({
            appId      : appId, // App ID secret c8987a5ca5c5a9febf1e6948a0de53e2
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
    FB.getLoginStatus(function(response){
        console.log("response: "+response.status);
        if (response.status === 'connected') {
        	// está conectado a facebook y además ya tiene permiso de usar la aplicacion personaling
				
			//console.log('Welcome!  Fetching your information.... ');

			FB.api('/me/picture?type=large', function(response) {
                //console.log('Nombre: ' + response.id + '.\nE-mail: ' + response.email);
                //console.log(response);
                if(response.data.is_silhouette != 'false'){
                	$('#facebook_picture').val(response.data.url);
                }
            });
                    
            FB.api('/me', function(response) {
            	//console.log(response);
                //console.log('Nombre: ' + response.id + '.\nE-mail: ' + response.email);
                
                
          	//	$("#registration-form").fadeOut(100,function(){
          			var ciudad = "";
          			if(typeof response.location != 'undefined'){
          				ciudad=response.location.name;
	 					ciudad=ciudad.split(",");
	 					ciudad=ciudad[0];
          			}
 					
 					$('#facebook_id').val(response.id);
 					$('#RegistrationForm_password').val('1234');
 					$('#RegistrationForm_email').val(response.email); 
                    $('#Profile_first_name').val(response.first_name);
                    $('#Profile_last_name').val(response.last_name);
                    $('#Profile_ciudad').val(ciudad);

                    
                   // console.log(response.email);
                    var fecha = response.birthday;
                    var n = fecha.split("/"); // 0 mes, 1 dia, 2 año
                    
                    $('#Profile_day').val(n[1]);
                    $('#Profile_month').val(n[0]);
                    $('#Profile_year').val(n[2]);
                    
                    if(response.gender == 'male')
                    {
                    	$('#Profile_sex_1').attr('checked',true);
                    }
                    
                    if(response.gender == 'female')
                    {
                    	$('#Profile_sex_0').attr('checked',true);
                    }

                    $('#registration-form').submit();
            }, {scope: 'email,user_birthday,user_interests'});
        } else {
            FB.login(function(response) {
                if (response.authResponse) {
                	//user is already logged in and connected (using information)
                    //console.log('Welcome!  Fetching your information.... ');

                    FB.api('/me/picture?type=large', function(response) {
		                if(response.data.is_silhouette != 'false'){
		                	$('#facebook_picture').val(response.data.url);
		                }
		            });
                    
                    FB.api('/me', function(response) {
                        //console.log('Nombre: ' + response.id + '.\nE-mail: ' + response.email);
						//console.log(response.user_birthday);
						
						//$("#registration-form").fadeOut(100,function(){
	     				var ciudad = "";
	          			if(typeof response.location != 'undefined'){
	          				ciudad=response.location.name;
		 					ciudad=ciudad.split(",");
		 					ciudad=ciudad[0];
	          			}
 		
                    		$('#Profile_ciudad').val(ciudad);
	     					$('#facebook_id').val(response.id);
	     					$('#RegistrationForm_password').val('1234');
	     					$('#RegistrationForm_email').val(response.email); 
	                        $('#Profile_first_name').val(response.first_name);
	                        $('#Profile_last_name').val(response.last_name);
	                        
	                        var fecha = response.birthday;
	                        var n = fecha.split("/"); // 0 mes, 1 dia, 2 año
	                        
	                        $('#Profile_day').val(n[1]);
	                        $('#Profile_month').val(n[0]);
	                        $('#Profile_year').val(n[2]);
	                        
	                        if(response.gender == 'male')
	                        {
	                        	$('#Profile_sex_1').attr('checked',true);
	                        }
	                        
	                        if(response.gender == 'female')
	                        {
	                        	$('#Profile_sex_0').attr('checked',true);
	                        }
	     	
	     				$('#registration-form').submit();
	     					
	     			//	});
	
	    			//	$("#registration-form").fadeIn(100,function(){});
						
						/*
						var pass=12345;

                        $.ajax({
                          url: '', // accion
                          data: {email : response.email, birthday : response.birthday, gender : response.gender, first: response.first_name, last: response.last_name, password: pass},
                          type: 'POST',
                          dataType: 'html',
                          success: function(data) {
                              console.log(data);
                              alert("registró");
                              //window.location = "http://careerdays.ch/aiesec/user/profile/create";
                          }
                        });*/
                        
                    });
                } else {
                    console.log('User cancelled login or did not fully authorize.');
                }
            }, {scope: 'email,user_birthday,user_interests'});
        }
    });
}
	
function check_twitter(){
	console.log("Twitter");
}

$('#Profile_day').on('change', validarFecha);
$('#Profile_month').on('change', validarFecha);
$('#Profile_year').on('change', validarFecha);

function validarFecha(){
        var day = $('#Profile_day').val();
        var month = $('#Profile_month').val();
        var year = $('#Profile_anio').val();
        
        if(day != '-1' && month != '-1' && year != '-1'){
                if(validarAnio(day, month, year)){
                        $('#Campana_ventas_fin').val(year+'-'+month+'-'+day+' 23:59:59');
                }else{
                        $('#Profile_day').val('-1'); 
                        $('#Profile_month').val('-1');
                        $('#Profile_year').val('-1');
                }
        }
}

function validarAnio(dia, mes, anio){
    var numDias = 31;
    //console.log('Dia: '+dia+' - Mes: '+mes+' - Año: '+anio);

    if(mes == 4 || mes == 6 || mes == 9 || mes == 11){
        numDias = 30;
    }

    if(mes == 2){
        if(comprobarSiBisisesto(anio)){
            numDias = 29;
        }else{
            numDias = 28;
        }
    }

    if(dia > numDias){
        return false;
    }
    return true;
}

function comprobarSiBisisesto(anio){
    if ( ( anio % 100 != 0) && ((anio % 4 == 0) || (anio % 400 == 0))) {
        return true;
    }
    else {
        return false;
    }
}
</script>
