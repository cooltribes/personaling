<?php

class SiteController extends Controller
{

	/**
	 * @return array action filters
	 */
	
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('productoimagen','index','top','error','contacto','login','logout',
                                    'acerca_de','activos_graficos','publicaciones_de_prensa',
                                    'condiciones_de_envios_y_encomiendas','formas_de_pago','politicas_y_privacidad',
                                    'terminos_de_servicio','politicas_de_devoluciones','politicas_de_cookies',
                                    'preguntas_frecuentes', 'equipo_personaling','captcha',
                                    'comofunciona', 'afterApply','sitemap','landingpage','ve',
                                    'tienda', 'conversion'), 
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('personal','update','notificaciones','mensaje'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				//'users'=>array('admin'),
				'expression' => 'UserModule::isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
	public function actionEquipo_personaling()
	{
		$this->render('equipo_personaling');
	}
	
	public function actionPoliticas_y_privacidad()
	{
		$this->render('politicas_y_privacidad');
	}
	
	public function actionTerminos_de_servicio()
	{
		$this->render('terminos_de_servicio');
	}

	public function actionPoliticas_de_devoluciones()
	{
		$this->render('politicas_de_devoluciones');
	}

	public function actionPoliticas_de_cookies()
	{
		$this->render('politicas_de_cookies');
	}

	public function actionPreguntas_frecuentes()
	{
		$seo = SeoStatic::model()->findByAttributes(array('name'=>'Preguntas Frecuentes'));
		$this->render('preguntas_frecuentes', array('seo'=>$seo));
	}	

	public function actionFormas_de_pago()
	{
		$seo = SeoStatic::model()->findByAttributes(array('name'=>'Formas de pago'));
		$this->render('formas_de_pago', array('seo'=>$seo));
	}

	public function actionCondiciones_De_Envios_y_Encomiendas()
	{
		$seo = SeoStatic::model()->findByAttributes(array('name'=>'Envíos'));
		$this->render('condiciones_de_envios_y_encomiendas', array('seo'=>$seo));
	}
	
	public function actionAcerca_De()
	{
		$seo = SeoStatic::model()->findByAttributes(array('name'=>'Acerca de Personaling'));
		$this->render('acerca_de', array('seo'=>$seo));
	}

	public function actionActivos_Graficos()
	{
		$this->render('activos_graficos');
	}

	public function actionPublicaciones_de_Prensa()
	{
		$this->render('publicaciones_de_prensa');
	}

	public function actionComofunciona()
	{
		$this->render('comofunciona');
	}
	public function actionLandingpage()
	{
		$seo = SeoStatic::model()->findByAttributes(array('name'=>'Landing'));
		$this->render('landingpage', array('seo'=>$seo));
	}
	public function actionVe()
	{
		$this->render('landingpage_ve');
	}        
    public function actionAfterApply()
	{
		$this->render('after_apply');
	}
    public function actionSitemap()
	{
		$this->render('sitemap');
	}
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		if (UserModule::isAdmin())
			$this->redirect(array('/controlpanel/index'));
		elseif (UserModule::isPersonalShopper()) 
			$this->redirect(array('site/top'));//$this->render('personal_shopper');
		elseif (Yii::app()->user->isGuest) 
			$this->render('index');
		else 
			//$this->redirect(array('site/personal'));//$this->render('personal_shopper');
                    /*Unificacion de la tienda de looks con tu personal shopper*/
			$this->redirect(array('site/top'));//$this->render('personal_shopper');
			
		
		
		
	}
	/**
	 * Esto es la pagina de tu personal shopper
	 */
	public function actionPersonal()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$user = User::model()->findByPk(Yii::app()->user->id);
		$looks = new Look;
		
		$this->render('personal_shopper',array(
					'dataProvider' => $looks->match($user),
					'user'=>$user,	
				));
	}
	/**
	 * Esto es la pagina de top
	 */
	public function actionTop()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$user = User::model()->findByPk(Yii::app()->user->id);
		$looks = new Look;
		$productos = new Producto;
		$psDestacados = new User;
                
                
                $psDestacados = User::model()->findAllByAttributes(array('ps_destacado' => '1'), new CDbCriteria(array(
                    'limit' => 4,
                    'order' => 'fecha_destacado DESC'
                )));
                
		$this->render('top',array(
					'dataProvider' => $looks->masvendidos(3),
					'dataProvider_productos' => $productos->masvendidos(6),
					'dataProvider_destacados' => $looks->lookDestacados(3),
					'user'=>$user,
                                        'psDestacados' => $psDestacados,//->getPsDestacados(4),
				));
	}	

	// Esta es la pagina de Notificaciones/Mensajes
	public function actionNotificaciones(){

		$this->render('notificaciones');
	}		
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		
		
		if($error=Yii::app()->errorHandler->error)
		{	
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	public function actionProductoImagen(){
		
		/*
		ALTER TABLE `db_personaling`.`tbl_imagen` 
ADD INDEX `index_producto` (`tbl_producto_id` ASC, `color_id` ASC);
		*/
//at the beginning
//$start_time = microtime(1);		
//$cpu_time = microtime(1) - $start_time;
//echo $cpu_time."<br>";
			   
		//$list= Yii::app()->db->createCommand('select url from tbl_imagen where tbl_producto_id=:tbl_producto_id and color_id=:color_id order by orden limit 0,1')->bindValue('tbl_producto_id',$_GET['producto'])->bindValue('color_id',$_GET['color'])->queryAll();
		$image = Imagen::model()->findByAttributes(array('tbl_producto_id'=>$_GET['producto'],'color_id'=>$_GET['color']),array('order'=>'orden','limit'=>1,'offset'=>0));
//$cpu_time = microtime(1) - $start_time;
//echo $cpu_time."<br>";
		//$image_url = Yii::app()->baseUrl.str_replace(".","_thumb.",$list[0]["url"]);
		
		//$image_url = str_replace(".","_thumb.",$list[0]["url"]);
		$image_url = str_replace(".","_thumb.",$image->url);
		$filename = Yii::getPathOfAlias('webroot').$image_url;
//$cpu_time = microtime(1) - $start_time;
//echo $cpu_time."<br>";			
		$image = Yii::app()->image->load($filename);
//$cpu_time = microtime(1) - $start_time;
//echo $cpu_time."<br>";		
		$image->resize($_GET['h'],$_GET['w']);
		$image->render();
//$cpu_time = microtime(1) - $start_time;
//echo $cpu_time."<br>";	

	}	

	/**
	 * Displays the contact page
	 */
	public function actionContacto()
	{
		$model=new ContactForm;
		
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail('info@personaling.com',$subject,"Este mensaje ha sido enviado desde el formulario de contacto de personaling: ".$model->body,$headers);
				Yii::app()->user->setFlash('contact','Gracias por contactarnos. Te estaremos respondiendo a la brevedad.');
				
				/* Creando el caso */ 
				
				$usuario = User::model()->findByAttributes(array('email'=>$_POST['ContactForm']['email']));
									
				$zohoCase = new ZohoCases;
				$zohoCase->Subject = "Formulario Contáctanos - ".$_POST['ContactForm']['email']." - ".date("d-m-Y");
				$zohoCase->Priority = "High";
				$zohoCase->Email = $_POST['ContactForm']['email'];
				$zohoCase->Description = "A través del formulario. Asunto: ".$_POST['ContactForm']['subject'].". Mensaje: ".$_POST['ContactForm']['body'];
				$zohoCase->internal = "Sin revisar";
				$zohoCase->Origin = "Web";
				$zohoCase->Status = "New";
				$zohoCase->type = "Problem"; 
				$zohoCase->reason = $_POST['ContactForm']['motivo']; 
				 
				if(isset($usuario)){ 
					if($usuario->tipo_zoho == 0){ 
						$zohoCase->posible = $usuario->profile->first_name." ".$usuario->profile->last_name;
						$zohoCase->posible_id = $usuario->zoho_id;
					}
					else if($usuario->tipo_zoho == 1){
						$zohoCase->related = $usuario->profile->first_name." ".$usuario->profile->last_name;
						$zohoCase->related_id = $usuario->zoho_id; 
					}
				}
									
				$respuesta = $zohoCase->save_potential(); 
				
				$model=new ContactForm; 
				$this->render('contact',array('model'=>$model));
				
			}
		}
		
		$this->render('contact',array('model'=>$model));
	}


	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	
	/**
	 * Arma el cuerpo del mensaje que se va a mostrar y lo devuelve como texto para colocarlo en el frontend
	 */
	public function actionMensaje()
	{
		
		$mensaje = Mensaje::model()->findByPk($_POST['msj_id']);
		
		if($mensaje->estado == 0) // no se ha leido
		{
			$mensaje->estado = 1;
			$mensaje->save(); 
		}
		
		$div = "";
		
		$div = $div.'<div class="padding_medium bg_color3 ">';
		$div = $div."<p><strong>De:</strong> Admin <span class='pull-right'><strong> ".date('d/m/Y', strtotime($mensaje->fecha))."</strong> ".date('h:i A', strtotime($mensaje->fecha))."</span></p>";
		$div = $div."<p> <strong>Asunto:</strong> ".$mensaje->asunto."</p>";
		$div = $div."<p> ".$mensaje->cuerpo." </p>";
	/*	$div = $div.'<form class=" margin_top_medium ">
				  		<textarea class="span12 nmargin_top_medium" rows="3" placeholder="Escribe tu mensaje..."	></textarea>
				  		<button class="btn btn-danger"> <span class="entypo color3 icon_personaling_medium" >&#10150;</span> Enviar </button>
			  		</form>'; */
		$div = $div.'<p><a class="btn btn-danger pull-right" href="'.Yii::app()->getBaseUrl().'/orden/detallepedido/'.$mensaje->orden_id.'#mensajes" target="_blank"> Responder </a></p>
			  		';	  		
		
		$div = $div."<br/></div>";
		
		echo $div;
		
	}
	
        /*Para la pagina de redireccion de TradeTracking*/
        public function actionTienda()
	{           
            //http://www.personaling.es/develop/tt/?tt=15920_0_17272_
            //! Tradetracker Redirect-Page.

            // Set domain name on which the redirect-page runs, WITHOUT "www.".
            $domainName = 'personaling.es' . Yii::app()->baseUrl;
            
            // Set the P3P compact policy.
            header('P3P: CP="ALL PUR DSP CUR ADMi DEVi CONi OUR COR IND"');

            // Define parameters.
            $canRedirect = true;

            // Set parameters.
            if (isset($_GET['campaignID']))
            {
                    $campaignID = $_GET['campaignID'];
                    $materialID = isset($_GET['materialID']) ? $_GET['materialID'] : '';
                    $affiliateID = isset($_GET['affiliateID']) ? $_GET['affiliateID'] : '';
                    $redirectURL = isset($_GET['redirectURL']) ? $_GET['redirectURL'] : '';
                    $reference = '';
            }
            else if (isset($_GET['tt']))
            {
                    $trackingData = explode('_', $_GET['tt']);

                    $campaignID = isset($trackingData[0]) ? $trackingData[0] : '';
                    $materialID = isset($trackingData[1]) ? $trackingData[1] : '';
                    $affiliateID = isset($trackingData[2]) ? $trackingData[2] : '';
                    $reference = isset($trackingData[3]) ? $trackingData[3] : '';

                    $redirectURL = isset($_GET['r']) ? $_GET['r'] : '';
            }
            else
                    $canRedirect = false;

            if ($canRedirect)
            {
                    // Calculate MD5 checksum.
                    $checkSum = md5('CHK_' . $campaignID . '::' . $materialID . '::' . $affiliateID . '::' . $reference);

                    // Set session/cookie arguments.
                    $cookieName = 'TT2_' . $campaignID;
                    $cookieValue = $materialID . '::' . $affiliateID . '::' . $reference . '::' . $checkSum . '::' . time();

                    // Create tracking cookie.
                    setcookie($cookieName, $cookieValue, (time() + 31536000), '/', !empty($domainName) ? '.' . $domainName : null);

                    // Create tracking session.
                    //session_start();

                    // Set session data.
                    $_SESSION[$cookieName] = $cookieValue;

                    // Set track-back URL.
                    $trackBackURL = 'http://tc.tradetracker.net/?c=' . $campaignID . '&m=' . $materialID . '&a=' . $affiliateID . '&r=' . urlencode($reference) . '&u=' . urlencode($redirectURL);

                    // Redirect to TradeTracker.
                    header('Location: ' . $trackBackURL, true, 301);
            }
	}
        
        public function actionConversion()
        {  
           
            //! TradeTracker Conversion-Tag.
	
            // Create session.
            //session_start();

            // Define parameters.
            $campaignID = isset($_GET['campaignID']) ? $_GET['campaignID'] : '';
            $productID = isset($_GET['productID']) ? $_GET['productID'] : '';
            $conversionType = isset($_GET['conversionType']) ? $_GET['conversionType'] : '';
            $useHttps = isset($_GET['https']) && $_GET['https'] === '1';

            // Get tracking data from the session created on the redirect-page.
            $trackingData = isset($_SESSION['TT2_' . $campaignID]) ? $_SESSION['TT2_' . $campaignID] : '';
            $trackingType = '1';

            // If tracking data is empty.
            if (empty($trackingData))
            {
                    // Get tracking data from the cookie created on the redirect-page.
                    $trackingData = isset($_COOKIE['TT2_' . $campaignID]) ? $_COOKIE['TT2_' . $campaignID] : '';
                    $trackingType = '2';
            }

            // Set transaction information.
            $transactionID = isset($_GET['transactionID']) ? $_GET['transactionID'] : ''; // Transaction identifier.
            $transactionAmount = isset($_GET['transactionAmount']) ? $_GET['transactionAmount'] : ''; // Transaction amount.
            $quantity = isset($_GET['quantity']) ? $_GET['quantity'] : ''; // Quantity (optional).
            $email = isset($_GET['email']) ? $_GET['email'] : ''; // Customer e-mail address if available (optional).
            $descriptionMerchant = isset($_GET['descrMerchant']) ? $_GET['descrMerchant'] : ''; // Transaction details for merchants (optional).
            $descriptionAffiliate = isset($_GET['descrAffiliate']) ? $_GET['descrAffiliate'] : ''; // Transaction details for affiliates (optional).

            // Set track-back URL.
            $trackBackURL = ($useHttps ? 'https' : 'http') . '://' . ($conversionType === 'lead' ? 'tl' : 'ts') . '.tradetracker.net/?cid=' . $campaignID . '&pid=' . $productID . '&data=' . urlencode($trackingData) . '&type=' . $trackingType . '&tid=' . urlencode($transactionID) . '&tam=' . urlencode($transactionAmount) . '&qty=' . urlencode($quantity) . '&eml=' . urlencode($email) . '&descrMerchant=' . urlencode($descriptionMerchant) . '&descrAffiliate=' . urlencode($descriptionAffiliate);

            // Register transaction.
            header('Location: ' . $trackBackURL);
        }
        
}