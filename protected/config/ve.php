<?php
return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
    //'timeZone' => 'CEST',
        'timeZone' => 'America/Caracas',
        'language' => 'es_ve',
	// 'sourceLanguage'=>'es_ES',
        'components'=>array(
			'db'=>array(
				'connectionString' => 'mysql:host=mysql-personaling.cu1sufeji6uk.us-west-2.rds.amazonaws.com;
                                    dbname=db_personalingDEV_VE',
				'emulatePrepare' => true,
				'username' => 'personaling',
				'password' => 'Perso123Naling',
				'charset' => 'utf8',
				'tablePrefix' => 'tbl_',
			),
        ),
        'params'=>array(
		// this is used in contact page
                'adminEmail'=>'rpalma@upsidecorp.ch',
                'PRONUNCIACION' => 'Venezolana',

                'currSym'=>'Bs',
                'noShipping'=> '0', // 0: Cuando se debe cobrar envio, VALOR: cuando el envío es GRATIS a partir de un VALOR determinado
                'IVA' => '0.12',
                'registerGift'=>'5', // 0: Cuando no se obsequia saldo, VALOR: cuando por registrarse se obsequia  un VALOR determinado
                'askId'=>false, //Para cuando se deba solicitar y mostrar la cedula/nif/rif segun el pais
                'IVAtext' => '12%',
                'registro' => false,	
                'mostrarMarcas'=>true,
                'mostrarChic'=>false,
                'country'=>'Venezuela',
                'codigoPostal'=>false,
                'pais'=>'espana',
                'clientName'=>'PERSONALING C.A.',
                'clientIdentification'=>'J-40236088-6',
                'clientAddress'=>'Sant Pere Mes Baix, Nº 63 Principal B ',
                'clientCity'=>'Barcelona',
                'clientZIP'=>'08003',
                'clientPhone'=>'934 344 634',
                'clientEmail'=>'info@personaling.com',
                '	 ',
                'metodosPago'=> array(
                        'bkCard' => false,
                        'paypal' => false, 
                        'prueba' => true,
                    	'depositoTransferencia' => true,
                    	'instapago' => true,
					),
				'pagoPS'=> array(
           
                        'paypal' => false,
                        'banco' => true,
                        'saldo' => true,
                    ),	
                 
                'multiLook'=> array(
                    'bodyType' => true,
                    'eyesColor' => true,
                    'hairColor' => true,
                    'womanMeasure' => true,
                    'bodyFavors' => true,
                    'skinColor' => true,
                ),
                'AzPayTerminal'=>'999',
                'AzPaySecret'=> 'qwerty1234567890uiop',
                'zohoToken' => 'a029ff6d9be39da6bddbd54f89ed15a1',


		),
    )
);
