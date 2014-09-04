<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Personaling',
	'timeZone' => 'America/Caracas', 
	'language' => 'es_ve',
	'sourceLanguage'=>'es_VE',
	// preloading 'log' component
	'preload'=>array('log','bootstrap'),
	'theme'=>'bootstrap',
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.widgets.ctree.*',
		'application.components.*',
		'application.modules.user.*',
                'application.modules.user.models.*',
                'application.modules.user.components.*',
                'application.helpers.*',
                'application.extensions.validators.age.*',
                'ext.yii-mail.YiiMailMessage',
                'ext.fancybox',
                'ext.AzPay',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1234',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('*'),
        	
            	'generatorPaths'=>array(
                	'bootstrap.gii',
                ),
            	
		),
 		'user'=>array(
            # encrypting method (php hash function)
            'hash' => 'md5',

            # send activation email
            'sendActivationMail' => true,

            # allow access for non-activated users
            'loginNotActiv' => true,

            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => false,

            # automatically login from registration
            'autoLogin' => true,

            # registration path
            'registrationUrl' => array('/user/registration'),

            # recovery password path
            'recoveryUrl' => array('/user/recovery'),

            # login form path
            'loginUrl' => array('/user/login'),

            # page after login
//            'returnUrl' => array('/user/profile'),
            'returnUrl' => array('/controlpanel/index'),

            # page after logout
            'returnLogoutUrl' => array('/user/login'),
        ),	
        'reportico'=>array(),	
		
	),

	// application components
	'components'=>array(
	'assetManager' => array(
            //'linkAssets' => true,
           // 'forceCopy'=> false,
        ),
    	'curl' => array(
            'class' => 'ext.Curl',
            'options' => array(), 
        ),	
		'twitter' => array(
                'class' => 'ext.yiitwitteroauth.YiiTwitter',
                'consumer_key' => 'oLqFHegtKHu8SvXtICuEuA',
                'consumer_secret' => 'Bf9nlFPrcb1CNIqFAMjiCUG3qSOKefIoswDqlVawx8',
                'callback' => 'http://personaling.com/site/user/registration/twitter',
            ), 
        'mail' => array(
                'class' => 'ext.yii-mail.YiiMail',
                'transportType'=>'php',
                'viewPath' => 'application.views.mail',             
        ),
		'image'=>array(
		          'class'=>'application.extensions.image.CImageComponent',
		            // GD or ImageMagick
		            'driver'=>'GD',
		            // ImageMagick setup path
		            'params'=>array('directory'=>'/opt/local/bin'),
		        ),	
		'user'=>array(
			// enable cookie-based authentication
			'class' => 'WebUser',
			'allowAutoLogin'=>true,
			'loginUrl'=>array('/user/login'),
		),
		/*
	    'less'=>array(
	      'class'=>'ext.less.components.Less',
	      'mode'=>'server',
	      'files'=>array(
	        'less/style.less'=>'css/style.css',
	      ),
	      'options'=>array(
                'nodePath'=>'/usr/local/lib/node_modules/npm/bin/npm-cli.js',
                'compilerPath'=>'/usr/local/lib/node_modules/less/bin/lessc',
                 'basePath'=>'/home/personaling/public_html/site/',
               // 'strictImports'=>true,
                'forceCompile'=>true,
        ),
	    ),
		 * */
		 'yexcel' => array(
		    'class' => 'ext.yexcel.Yexcel'
		),
	    
	    'less'=>array(
	      'class'=>'ext.less.components.Less',
	      'mode'=>'client',
	      'files'=>array(
	        'less/style.less'=>'css/style.less',
	      ),
		  'options'=>array('watch'=>false),
	    ),	
		 	
		 'bootstrap'=>array(
            'class'=>'ext.bootstrap.components.Bootstrap',
            'responsiveCss' => true,
        ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			 'showScriptName'=>false,
     			//'caseSensitive'=>false, 
     			'baseUrl'=>'/develop',  
			'rules'=>array(
				'productos/<alias:[a-zA-Z0-9_-]+>'=>'producto/detalle',
				'looks/<alias:[a-zA-Z0-9_-]+>'=>'look/view',
				'looks-personalizados'=>'tienda/look',
				'tienda-ropa-personalizada'=>'tienda/index',
				'outlet'=>'tienda/index/outlet/true',
				'formas-de-pago'=>'site/formas_de_pago',
				'envios'=>'site/condiciones_de_envios_y_encomiendas',
				'preguntas_frecuentes'=>'site/preguntas_frecuentes',
				'acerca-personaling'=>'site/acerca_de',
				'registro-personaling'=>'user/registration',
				'inicio-personaling'=>'user/login',
				'reportico'=>'reportico',
				'tt'=>'site/tienda',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<alias:[a-zA-Z0-9_-]+>'=>'user/profile/perfil'
			),
		),
		
				/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		 * */
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=mysql-personaling.cu1sufeji6uk.us-west-2.rds.amazonaws.com;dbname=db_personalingDEV',
			'emulatePrepare' => true,
			'username' => 'personaling',
			'password' => 'Perso123Naling',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
		),
        'user'=>array(
            // enable cookie-based authentication
            'class' => 'WebUser',
            'loginUrl'=>array('/user/login'),
            'allowAutoLogin' => true,
        ),		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/* 
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			array(
                    'class' => 'CDbLogRoute',
                    'connectionID' => 'db',
                    'autoCreateLogTable' => false,
                    'logTableName' => 'tbl_logger',
                    'levels' => 'trace',
                    'categories' => 'registro,compra,tienda,admin,otro',

			),
			),
		),
		'ePdf' => array(
                'class'         => 'ext.yii-pdf.EYiiPdf',
                'params'        => array(
                    'mpdf'     => array(
                        'librarySourcePath' => 'application.vendors.mpdf.*',
                        'constants'         => array(
                            '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                        ),
                        'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
                        /*'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                            'mode'              => '', //  This parameter specifies the mode of the new document.
                            'format'            => 'A4', // format A4, A5, ...
                            'default_font_size' => 0, // Sets the default document font size in points (pt)
                            'default_font'      => '', // Sets the default font-family for the new document.
                            'mgl'               => 15, // margin_left. Sets the page margins for the new document.
                            'mgr'               => 15, // margin_right
                            'mgt'               => 16, // margin_top
                            'mgb'               => 16, // margin_bottom
                            'mgh'               => 9, // margin_header
                            'mgf'               => 9, // margin_footer
                            'orientation'       => 'P', // landscape or portrait orientation
                        )*/
                    ),
                    'HTML2PDF' => array(
                        'librarySourcePath' => 'application.vendors.html2pdf.*',
                        'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
                        /*'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                            'orientation' => 'P', // landscape or portrait orientation
                            'format'      => 'A4', // format A4, A5, ...
                            'language'    => 'en', // language: fr, en, it ...
                            'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
                            'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
                            'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
                        )*/
                    )
                ),
            ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
                'metodosPago'=> array(
                    'bkCard' => true,
                    'paypal' => true,
                    'depositoTransferencia' => false,
                    'instapago' => false,
                    'mercadopago' => false,
				                        
                    ),
                    'clientName'=>'Personaling Enterprise S.L ',
			'clientIdentification'=>'B66202383',
			'clientAddress'=>'Sant Pere Mes Baix, Nº 63 Principal B ',
			'clientCity'=>'Barcelona',
			'clientZIP'=>'08003',
			'clientPhone'=>'934 344 634',
			'clientEmail'=>'info@personaling.com', 
		
					
                  'PRONUNCIACION' => 'Venezolana', 
				    'currSym'=>'Bs',
				     'registerGift'=>'5', // 0: Cuando no se obsequia saldo, VALOR: cuando por registrarse se obsequia  un VALOR determinado
				    'noShipping'=> '0', // 0: Cuando se debe cobrar envio, VALOR: cuando el envío es GRATIS a partir de un VALOR determinado
				    'askId'=>true, //Para cuando se deba solicitar y mostrar la cedula/nif/rif segun el pais
				    'IVA' => '0.12',
				    'IVAtext' => '12%',	
				    'registro' => true,	  
				    'mostrarMarcas'=>true,
				    'mostrarChic'=>true,
				    'country'=>'Venezuela',
				    'zohoToken'=>'07c608e96b409f76ee5a47c383576418',
		
	),
);