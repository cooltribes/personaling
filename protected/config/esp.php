<?php
return CMap::mergeArray(
    require(dirname(__FILE__).'/main.php'),
    array(
    //'timeZone' => 'CEST',
   	 'language' => 'es_es',
   	 'timeZone' => 'Europe/Madrid', 
	// 'sourceLanguage'=>'es_ES',
        'components'=>array(
			'db'=>array(
				'connectionString' => 'mysql:host=mysql-personaling.cu1sufeji6uk.us-west-2.rds.amazonaws.com;dbname=db_personaling',
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
		    'PRONUNCIACION' => 'Española',
		    'currSym'=>'E',
		    'noShipping'=> '30', // 0: Cuando se debe cobrar envio, VALOR: cuando el envío es GRATIS a partir de un VALOR determinado
		    'IVA' => '0.21',
		    'IVAtext' => '21%',	
		    'registro' => false,	
		    'mostrarMarcas'=>false,
		    'mostrarChic'=>false,
		    'country'=>'España',
			'pais'=>'espana',
                        'metodosPago'=> array(
                                'bkCard' => true,
                                'paypal' => true,
                                ),
		),
    )
);
