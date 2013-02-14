<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Personaling',

	// preloading 'log' component
	'preload'=>array('log','bootstrap'),
	'theme'=>'bootstrap',
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.user.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',		
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
            'returnUrl' => array('/user/profile'),

            # page after logout
            'returnLogoutUrl' => array('/user/login'),
        ),		
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
	    'less'=>array(
	      'class'=>'ext.less.components.Less',
	      'mode'=>'client',
	      'files'=>array(
	        'less/style.less'=>'css/style.less',
	      ),
	    ),		
		 'bootstrap'=>array(
            'class'=>'ext.bootstrap.components.Bootstrap',
            'responsiveCss' => true,
        ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
				/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		 * */
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=db_personaling',
			'emulatePrepare' => true,
			'username' => 'db_personaling',
			'password' => 'Perso123Naling',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
		),
        'user'=>array(
            // enable cookie-based authentication
            'class' => 'WebUser',
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
                    'categories' => 'registro',

			),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);