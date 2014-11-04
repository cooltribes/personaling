<?php
return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
    //'timeZone' => 'CEST',
   	 'language' => 'es_es',
   	 'preload' => array('log'),
   	 'timeZone' => 'Europe/Madrid', 
	// 'sourceLanguage'=>'es_ES',
        'components'=>array(
			'db'=>array(
				'connectionString' => 'mysql:host=mysql-personaling.cu1sufeji6uk.us-west-2.rds.amazonaws.com;
                                    dbname=db_personalingDEV',
				'emulatePrepare' => true,
				'username' => 'personaling',
				'password' => 'Perso123Naling',
				'charset' => 'utf8',
				'tablePrefix' => 'tbl_',
			),
			 'log' => array(
                                   'class' => 'CLogRouter',
                                   'routes' => array(
                                       'class' => 'ext.phpconsole.PhpConsoleLogRoute',
                                       /* Default options:
                                       'isEnabled' => true,
                                       'handleErrors' => true,
                                       'handleExceptions' => true,
                                       'sourcesBasePath' => $_SERVER['DOCUMENT_ROOT'],
                                       'phpConsolePathAlias' => 'application.vendors.PhpConsole.src.PhpConsole',
                                       'registerHelper' => true,
                                       'serverEncoding' => null,
                                       'headersLimit' => null,
                                       'password' => null,
                                       'enableSslOnlyMode' => false,
                                       'ipMasks' => array(),
                                       'dumperLevelLimit' => 5,
                                       'dumperItemsCountLimit' => 100,
                                       'dumperItemSizeLimit' => 5000,
                                       'dumperDumpSizeLimit' => 500000,
                                       'dumperDetectCallbacks' => true,
                                       'detectDumpTraceAndSource' => true,
                                       'isEvalEnabled' => false,
                                       */
                                   )
                               )
        ),
        'params'=>array(
		// this is used in contact page
                'adminEmail'=>'rpalma@upsidecorp.ch',
                'PRONUNCIACION' => 'Española', 

                'currSym'=>'E',
                'noShipping'=> '0', // 0: Cuando se debe cobrar envio, VALOR: cuando el envío es GRATIS a partir de un VALOR determinado
                'IVA' => '0.21',
                'registerGift'=>'5', // 0: Cuando no se obsequia saldo, VALOR: cuando por registrarse se obsequia  un VALOR determinado
                'askId'=>false, //Para cuando se deba solicitar y mostrar la cedula/nif/rif segun el pais
                'IVAtext' => '21%',	
                'registro' => false,	
                'mostrarMarcas'=>true,
                'codigoPostal'=>true,
                'mostrarChic'=>true, 
                'country'=>'España',
                'pais'=>'espana',
                'clientName'=>'Personaling Enterprise S.L ',
                'clientIdentification'=>'B66202383',
                'clientAddress'=>'Sant Pere Mes Baix, Nº 63 Principal B ',
                'clientCity'=>'Barcelona',
                'clientZIP'=>'08003',
                'clientPhone'=>'934 344 634',
                'clientEmail'=>'info@personaling.com',
                '	 ',
                'pagoPS'=> array(           
                        'paypal' => true,
                        'banco' => true,
                        'saldo' => true,
                    ),
                'metodosPago'=> array(
                    'bkCard' => true,
                    'paypal' => true, 
                    'prueba' => true,
                ),
                'multiLook'=> array(
                    'bodyType' => false,
                    'eyesColor' => false,
                    'hairColor' => false,
                    'womanMeasure' => false,
                    'bodyFavors' => false,
                    'skinColor' => false,
                ),
                'AzPayTerminal'=>'999',
                'AzPaySecret'=> 'qwerty1234567890uiop',
                'zohoToken'=>'1569fa0c328f9ec6fec9a148939b74fa', 


		),
    )
);
