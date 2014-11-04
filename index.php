<?php
/*
// change the following paths if necessary
$yii=dirname(__FILE__).'/../../yii-1.1.13.e9e4a0/framework/yii.php';

//	if (strstr($_SERVER['HTTP_HOST'],"personaling.es")) 
//		$config=dirname(__FILE__).'/protected/config/esp.php';
//	else if  (strstr($_SERVER['HTTP_HOST'],"personaling.com.ve"))
//	    $config=dirname(__FILE__).'/protected/config/ve.php';
//	else
//	    $config=dirname(__FILE__).'/protected/config/main.php';

$config=dirname(__FILE__).'/protected/config/ve.php';
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);

Yii::createWebApplication($config)->run();
*/
//RAFA
// Change the following paths if necessary
	if (strstr($_SERVER['HTTP_HOST'],"personaling.es")) 
		$country='es_es';
	else if  (strstr($_SERVER['HTTP_HOST'],"personaling.com.ve"))
	    $country='es_ve';
	else
	    $country='es_es'; 
	
    if (isset($_SERVER['HTTP_APPLICATION_LANG']))
	   $country = $_SERVER['HTTP_APPLICATION_LANG']; //htaccess SetEnv HTTP_APPLICATION_LANG "es_ve"
    
    $yii = dirname(__FILE__).'/../../yii-1.1.13.e9e4a0/framework/yiilite.php';
    require_once($yii);
    require_once(dirname(__FILE__).'/protected/config/environment.php');
    Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/protected/extensions/bootstrap');
    
    if (isset($_SERVER["HTTP_APPLICATION_ENV"])&&$_SERVER["HTTP_APPLICATION_ENV"]=="production") //htaccess SetEnv HTTP_APPLICATION_ENV "production"
        $environment = new Environment(Environment::PRODUCTION,$country,'');
    elseif (strstr($_SERVER["REQUEST_URI"],"test62"))
    	$environment = new Environment(Environment::STAGE,$country,'/test62');
    elseif (strstr($_SERVER["REQUEST_URI"],"rpalma"))
    	$environment = new Environment(Environment::DEVELOPMENT,$country,'/rpalma/sandbox/personaling');
    elseif (strstr($_SERVER["REQUEST_URI"],"yroa"))

        $environment = new Environment(Environment::DEVELOPMENT,$country,'/yroa/sites/personaling');
    elseif (strstr($_SERVER["REQUEST_URI"],"cruiz"))
        $environment = new Environment(Environment::DEVELOPMENT,$country,'/cruiz/sites/personaling');
        
//$environment = new Environment(Environment::DEVELOPMENT,$country,'/rpalma/sandbox/personaling');
    defined('YII_DEBUG') or define('YII_DEBUG',$environment->getDebug());
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', $environment->getTraceLevel());
    Yii::createWebApplication($environment->getConfig())->run();


