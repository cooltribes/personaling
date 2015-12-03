<?php
/**
     * This class helps you to config your Yii application
     * environment.
     * Any comments please post a message in the forum
     * Enjoy it!
     *
     * @name Environment
     * @author Fernando Torres | Marciano Studio
     * @version 1.0
     */
  
    class Environment {
 
        const DEVELOPMENT = 100;
        const TEST        = 200;
        const STAGE       = 300;
        const PRODUCTION  = 400;
 
        private $_mode = 0;
        private $_debug;
        private $_trace_level;
        private $_config;
        private $_country;
        private $_baseUrl;
 
 
        /**
         * Returns the debug mode
         * @return Bool
         */
        public function getDebug() {
            return $this->_debug;
        }
 
        /**
         * Returns the trace level for YII_TRACE_LEVEL
         * @return int
         */
        public function getTraceLevel() {
            return $this->_trace_level;
        }
 
        /**
         * Returns the configuration array depending on the mode
         * you choose
         * @return array
         */
        public function getConfig() {
            return $this->_config;
        }
 
 
        /**
         * Initilizes the Environment class with the given mode
         * @param constant $mode
         */
        function __construct($mode,$country,$baseUrl) {
            $this->_mode = $mode;
            $this->_country = $country;
            $this->_baseUrl = $baseUrl;
            $this->setConfig();
        }
 
        /**
         * Sets the configuration for the choosen environment
         * @param constant $mode
         */
        private function setConfig() {
            switch($this->_mode) {
                case self::DEVELOPMENT:
                    $this->_debug       = true;
                    $this->_trace_level = 3;
                    defined('YII_DEBUG') or define('YII_DEBUG',$this->_debug);
                    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', $this->_trace_level);
                    $this->_config      = CMap::mergeArray  ($this->_main(), $this->_development());
                    break;
                case self::TEST:
                    $this->_debug       = false;
                    $this->_trace_level = 0;
                    $this->_config      = CMap::mergeArray  ($this->_main(), $this->_test());
                    break;
                case self::STAGE:
                    $this->_debug       = true;
                    $this->_trace_level = 0;
                    $this->_config      = CMap::mergeArray  ($this->_main(), $this->_stage());
                    break;
                case self::PRODUCTION:
                    $this->_debug       = false;
                    $this->_trace_level = 0;
                    $this->_config      = CMap::mergeArray  ($this->_main(), $this->_production());
                    break;
                default:
                    $this->_debug       = true;
                    $this->_trace_level = 0;
                    $this->_config      = $this->_main();
                    break;
            }
        }
 
 
        /**
         * Main configuration
         * This is the general configuration that uses all environments
         */
        private function _main() {
            
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
                        'returnUrl' => array('/controlpanel/index'),

                        # page after logout
                        'returnLogoutUrl' => array('/user/login'),
                    ),  
                    'reportico'=>array(),   
                    
                ),

                // application components
                'components'=>array(
                    //'clientScript' => array(
                    //       'class' => 'application.vendors.yii-EClientScript.EClientScript',
                    //       'combineScriptFiles' => ! $this->_debug, // By default this is set to true, set this to true if you'd like to combine the script files
                    //       'combineCssFiles' => ! $this->_debug, // By default this is set to true, set this to true if you'd like to combine the css files
                    //       'optimizeScriptFiles' => ! $this->_debug, // @since: 1.1
                    //       'optimizeCssFiles' => ! $this->_debug, // @since: 1.1
                    //       'optimizeInlineScript' => false, // @since: 1.6, This may case response slower
                    //      'optimizeInlineCss' => false, // @since: 1.6, This may case response slower
                    //     ),
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
                        'baseUrl'=>$this->_baseUrl,

                        'rules'=>array(
                            array(
                                'class' => 'application.components.ShortenerUrlRule',
                                'connectionID' => 'db',
                            ),
/*
                            '<language:(de|tr|en)>/' => 'site/index',
                            '<language:(de|tr|en)>/productos/<alias:[a-zA-Z0-9_-]+>'=>'producto/detalle',
                            '<language:(de|tr|en)>/looks/<alias:[a-zA-Z0-9_-]+>'=>'look/view',
                            '<language:(de|tr|en)>/looks-personalizados'=>'tienda/look',
                            '<language:(de|tr|en)>/tienda-ropa-personalizada'=>'tienda/index',
                            '<language:(de|tr|en)>/outlet'=>'tienda/index/outlet/true',
                            '<language:(de|tr|en)>/formas-de-pago'=>'site/formas_de_pago',
                            '<language:(de|tr|en)>/envios'=>'site/condiciones_de_envios_y_encomiendas',
                            '<language:(de|tr|en)>/preguntas_frecuentes'=>'site/preguntas_frecuentes',
                            '<language:(de|tr|en)>/acerca-personaling'=>'site/acerca_de',
                            '<language:(de|tr|en)>/registro-personaling'=>'user/registration',
                            '<language:(de|tr|en)>/inicio-personaling'=>'user/login',
                            '<language:(de|tr|en)>/me-siento-poderosa'=>'site/poderosas',
                            '<language:(de|tr|en)>/reportico'=>'reportico',
                            '<language:(de|tr|en)>/tt'=>'site/tienda',
                            '<language:(de|tr|en)>/look/<id:\d+>/ps/<ps_id:\d+>'=>'look/view',
                            '<language:(de|tr|en)>/<controller:\w+>/<id:\d+>'=>'<controller>/view',
                            '<language:(de|tr|en)>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                            '<language:(de|tr|en)>/<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                            '<language:(de|tr|en)>/<alias:[a-zA-Z0-9_-]+>'=>'user/profile/perfil'
*/
                            //'/' => 'site/index',
                            '/productos/<alias:[a-zA-Z0-9_-]+>'=>'producto/detalle',
                            '/looks/<alias:[a-zA-Z0-9_-]+>'=>'look/view',
                            '/looks-personalizados'=>'tienda/look',
                            '/tienda-ropa-personalizada'=>'tienda/index',
                            '/outlet'=>'tienda/index/outlet/true',
                            '/formas-de-pago'=>'site/formas_de_pago',
                            '/envios'=>'site/condiciones_de_envios_y_encomiendas',
                            '/preguntas_frecuentes'=>'site/preguntas_frecuentes',
                            '/acerca-personaling'=>'site/acerca_de',
                            '/registro-personaling'=>'user/registration',
                            '/inicio-personaling'=>'user/login',
                            '/me-siento-poderosa'=>'site/poderosas',
                            '/reportico'=>'reportico',
                            '/tt'=>'site/tienda',
                            '/look/<id:\d+>/ps/<ps_id:\d+>'=>'look/view',
                            '/<controller:\w+>/<id:\d+>'=>'<controller>/view',
                            '/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                            '/<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                            '/<alias:[a-zA-Z0-9_-]+>'=>'user/profile/perfil'

                        ),
                    ),

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

                        array(
                                'class' => 'CDbLogRoute',
                                'connectionID' => 'db',
                                'autoCreateLogTable' => false,
                                'logTableName' => 'tbl_logger',
                                'levels' => 'trace,error,warning',
                                'categories' => 'registro,compra,tienda,admin,otro',

                        ),
                        array(
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
                        'prueba' => false,
                                                    
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
                    'clientService'=>array(
                        'es_es'=>'info@personaling.com',
                        'es_ve'=>'clientes@personaling.com.ve',
                        'de_ch'=>'info@personaling.com',
                        'en_us'=>'info@personaling.com'
                    ),
                    'registro' => true,   
                    'mostrarMarcas'=>true,
                    'mostrarChic'=>true,
                    'country'=>'Venezuela',
                    //'zohoToken'=>'1569fa0c328f9ec6fec9a148939b74fa', 
                    
                    'outlet'=>TRUE,
                    'zohoActive' => FALSE,
                    'id_look_switch' => 638,
                    'instapago_key' => array(
                        "KeyId"=> "EDC20F86-9C7E-4D2A-9603-6EF5612F5536",
                        "PublicKeyId"=>"5274e829763cd383270512b87a6c947e",
                    )
                ),
            );
        }
 
 
        /**
         * Development configuration
         * Usage:
         * - Local website
         * - Local DB
         * - Show all details on each error.
         * - Gii module enabled
         */
        private function _development () {
            if ($this->_country == 'es_ve')
                return array(
                    'timeZone' => 'America/Caracas',
                    'language' => 'es_ve',
                    'components'=>array(
                        'db'=>array(
                            'connectionString' => 'mysql:host=mysql-personaling.cu1sufeji6uk.us-west-2.rds.amazonaws.com;dbname=db_personalingDEV_VE',
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
                        'environment'=>'Develop Venezuela',
                        'currSym'=>'Bs',
                        'noShipping'=> '0', // 0: Cuando se debe cobrar envio, VALOR: cuando el envío es GRATIS a partir de un VALOR determinado
                        'IVA' => '0.12',
                        'registerGift'=>'0', // 0: Cuando no se obsequia saldo, VALOR: cuando por registrarse se obsequia  un VALOR determinado
                        'askId'=>false, //Para cuando se deba solicitar y mostrar la cedula/nif/rif segun el pais
                        'IVAtext' => '12%',
                        'registro' => false,    
                        'mostrarMarcas'=>true,
                        'chic'=>array('show'=>false,
                                      'brands'=>false),
                        'country'=>'Venezuela',
                        'codigoPostal'=>false,
                        'pais'=>'venezuela',
                        'clientName'=>'PERSONALING C.A.',
                        'clientIdentification'=>'J-40236088-6',
                        'clientAddress'=>'Avenida Bolívar, C.C CCM, Piso 2, Local 210, Porlamar, Nueva Esparta',
                        'clientCity'=>'Porlamar',
                        'clientZIP'=>'6031',
                        'clientPhone'=>'0295-2676317',
                        'clientEmail'=>'info@personaling.com',
                        '    ', 
                        'tweets'=>array(
                                '0'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> cuando los resultados de mi trabajo son satiscatorios. Ahora quiero ese <a href="https://twitter.com/hashtag/Makeover?src=hash">#Makeover</a> de <a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> para verme más bella</p>&mdash; Yudith Machado (@YudithMachado) <a href="https://twitter.com/YudithMachado/status/574581955284590592">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@YudithMachado', ),
                               '1'=> array( 'code'=>'<blockquote class="twitter-tweet" data-conversation="none" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> porque a pesar de no tener un maquillaje dia a dia en mi rostro mi sonrisa siempre brilla ante el mundo</p>&mdash; maryuli zabala (@maryu3278) <a href="https://twitter.com/maryu3278/status/574581990260916224">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@maryu3278', ),
                                '2'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> al ver que más mujeres confían más en su cerebro que en sus lolas</p>&mdash; Ilse Moros (@Ilsemo) <a href="https://twitter.com/Ilsemo/status/574588778494435328">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@Ilsemo', ),
                                '3'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> porque trabajamos estudiamos cocinamos nos ejercitamos hacemos mercado <a href="https://twitter.com/hashtag/FelizDiaDeLaMujer?src=hash">#FelizDiaDeLaMujer</a></p>&mdash; mahli (@inbili) <a href="https://twitter.com/inbili/status/574591413226184704">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@inbili', ),
                                '4'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> incluso en medio de hombres porque ellos no saben llevar vestidos pero yo si muy bien los pantalones!!👏</p>&mdash; zully E S Rocha (@zullyRocha) <a href="https://twitter.com/zullyRocha/status/574609384044650496">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@zullyRocha', ),
                                '5'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> cuando al ver a mis hijos grandes, sanos e inteligente se que he hecho un buen trabajo como mujer y madre <a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a></p>&mdash; Jacqueline Ƹ̴Ӂ̴Ʒ (@BJackyO) <a href="https://twitter.com/BJackyO/status/574590434195996672">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@BJackyO', ),
                                '6'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> corriendo 10K con <a href="https://twitter.com/SenosAyuda">@SenosAyuda</a> un domingo en la mañana <a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a></p>&mdash; Fabianna Mazzocca (@Fabs_MB) <a href="https://twitter.com/Fabs_MB/status/574626799306588160">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@Fabs_MB', ),
                                '7'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> cuando mi esposo <a href="https://twitter.com/elcarlosx">@elcarlosx</a> me dice que ya quisiera <a href="https://twitter.com/SaschaFitness">@SaschaFitness</a> verse como yo <a href="https://twitter.com/hashtag/lol?src=hash">#lol</a> <a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a></p>&mdash; Ana Cristina Romero (@AnaC_Romero) <a href="https://twitter.com/AnaC_Romero/status/574689206154432512">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@AnaC_Romero', ),
                                '8'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/mesientopoderosa?src=hash">#mesientopoderosa</a> cuando me veo al espejo y me gusta lo que veo, tal cual como soy♡</p>&mdash; Isabel Carlota (@IsaRamirez16) <a href="https://twitter.com/IsaRamirez16/status/574710428137308160">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@IsaRamirez16', ),
                                '9'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> cuando veo que no es necesario mostrarlo todo para llamar la atención de la gente, una buena :) y listo <a href="https://twitter.com/PersonalingVzla">@personalingVzla</a></p>&mdash; Melyda (@MelydaTimaure) <a href="https://twitter.com/MelydaTimaure/status/576039511987236864">marzo 12, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@MelydaTimaure', ),
                                '10'=>array( 'code'=>' <blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> al pensar que el FUTURO pertenece a quienes creemos en la belleza de nuestros SUEÑOS *.*</p>&mdash; Reina ツ (@adre0505) <a href="https://twitter.com/adre0505/status/576540408102125568">marzo 14, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@adre0505', ),   
                         ),
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
                        'zohoToken' => 'c9746b8f8834c0232c682768e55b02d7',
                        'zohoAccount'=>'cruiz@upsidecorp.ch',
                        'zohoActive' => TRUE,
                        'fb_appId' => '386830111475859',
                        ),
                );
            if ($this->_country == 'es_es')
                return array(
                    'language' => 'es_es',
                    'timeZone' => 'Europe/Madrid', 
                    'components'=>array(
                        'db'=>array(
                            'connectionString' => 'mysql:host=mysql-personaling.cu1sufeji6uk.us-west-2.rds.amazonaws.com;dbname=db_personalingDEV',
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
                        'environment'=>'Develop España',
                        'currSym'=>'E',
                        'noShipping'=> '0', // 0: Cuando se debe cobrar envio, VALOR: cuando el envío es GRATIS a partir de un VALOR determinado
                        'IVA' => '0.21',
                        'registerGift'=>'5', // 0: Cuando no se obsequia saldo, VALOR: cuando por registrarse se obsequia  un VALOR determinado
                        'askId'=>false, //Para cuando se deba solicitar y mostrar la cedula/nif/rif segun el pais
                        'IVAtext' => '21%', 
                        'registro' => false,    
                        'mostrarMarcas'=>true,
                        'codigoPostal'=>true,
                        'chic'=>array('show'=>true,
                                      'brands'=>false),
                        'country'=>'España',
                        'pais'=>'espana',
                        'clientName'=>'Personaling Enterprise S.L ',
                        'clientIdentification'=>'B66202383',
                        'clientAddress'=>'Sant Pere Mes Baix, Nº 63 Principal B ',
                        'clientCity'=>'Barcelona',
                        'clientZIP'=>'08003',
                        'clientPhone'=>'934 344 634',
                        'clientEmail'=>'info@personaling.com',
                        
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
                        'zohoToken'=>'645a319a2cfe40d183067f4a82259f0a',
                        'zohoAccount'=>'wmontilla@upsidecorp.ch', 

                        'zohoActive' => TRUE,
                        'fb_appId' => '323808071078482',
                    ),
                );
        }
 
 
        /**
         * Test configuration
         * Usage:
         * - Local website
         * - Local DB
         * - Standard production error pages (404,500, etc.)
         * @var array
         */
        private function _test() {
            if ($this->_country == 'de_ch')
                return array(
                    'language' => 'de_ch',
                    'timeZone' => 'Europe/Madrid', 
                    'components'=>array(
                        'db'=>array(
                            'connectionString' => 'mysql:host=mysql-personaling.cu1sufeji6uk.us-west-2.rds.amazonaws.com;dbname=db_personalingCH',
                            'emulatePrepare' => true,
                            'username' => 'personaling',
                            'password' => 'Perso123Naling',
                            'charset' => 'utf8',
                            'tablePrefix' => 'tbl_',
                        ),
                         'less'=>array(
                                      'class'=>'ext.less.components.Less',
                                      'mode'=>'client',
                                      'files'=>array(
                                        'less/style.less'=>'css/style.less',
                                      ),
                                          'options'=>array('watch'=>false),
                                    ),
                      
                    ),
                    'params'=>array(
                    // this is used in contact page
                        'adminEmail'=>'rpalma@upsidecorp.ch',
                        'PRONUNCIACION' => 'EspaÃ±ola',
                        'environment'=>false, 
                        'currSym'=>'E',
                        'noShipping'=> '0', // 0: Cuando se debe cobrar envio, VALOR: cuando el envÃ­o es GRATIS a partir de un VALOR determinado
                        'IVA' => '0.21',
                        'registerGift'=>'5', // 0: Cuando no se obsequia saldo, VALOR: cuando por registrarse se obsequia  un VALOR determinado
                        'askId'=>false, //Para cuando se deba solicitar y mostrar la cedula/nif/rif segun el pais
                        'IVAtext' => '21%', 
                        'registro' => false,    
                        'mostrarMarcas'=>true,
                        'codigoPostal'=>true,
                        'chic'=>array('show'=>true,
                                      'brands'=>false),
                        'country'=>'EspaÃ±a',
                        'pais'=>'espana',
                        'clientName'=>'Personaling Enterprise S.L ',
                        'clientIdentification'=>'B66202383',
                        'clientAddress'=>'Sant Pere Mes Baix, NÂº 63 Principal B ',
                        'clientCity'=>'Barcelona',
                        'clientZIP'=>'08003',
                        'clientPhone'=>'934 344 634',
                        'clientEmail'=>'info@personaling.com',
                        '    ',
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
                        'AzPayTerminal'=>'997',
                        'AzPaySecret'=> 'qwerty1234567890uiop',
                        'zohoToken'=>'8b75b742aec75310a4985ab07ca683d7',
                        'zohoAccount'=>'cmontanez@upsidecorp.ch',
                        'zohoActive' => TRUE,
                        'fb_appId' => '323808071078482',
                    ),
                );
            if ($this->_country == 'en_us')
                return array(
                    'language' => 'en_us',
                    'timeZone' => 'Europe/Madrid', 
                    'components'=>array(
                        'db'=>array(
                            'connectionString' => 'mysql:host=mysql-personaling.cu1sufeji6uk.us-west-2.rds.amazonaws.com;dbname=db_personalingUS',
                            'emulatePrepare' => true,
                            'username' => 'personaling',
                            'password' => 'Perso123Naling',
                            'charset' => 'utf8',
                            'tablePrefix' => 'tbl_',
                        ),
                         'less'=>array(
                                      'class'=>'ext.less.components.Less',
                                      'mode'=>'client',
                                      'files'=>array(
                                        'less/style.less'=>'css/style.less',
                                      ),
                                          'options'=>array('watch'=>false),
                                    ),
                      
                    ),
                    'params'=>array(
                    // this is used in contact page
                        'adminEmail'=>'rpalma@upsidecorp.ch',
                        'PRONUNCIACION' => 'EspaÃ±ola',
                        'environment'=>'Sitio de Pruebas US '.$this->_country, 
                        'currSym'=>'E',
                        'noShipping'=> '0', // 0: Cuando se debe cobrar envio, VALOR: cuando el envÃ­o es GRATIS a partir de un VALOR determinado
                        'IVA' => '0.21',
                        'registerGift'=>'5', // 0: Cuando no se obsequia saldo, VALOR: cuando por registrarse se obsequia  un VALOR determinado
                        'askId'=>false, //Para cuando se deba solicitar y mostrar la cedula/nif/rif segun el pais
                        'IVAtext' => '21%', 
                        'registro' => false,    
                        'mostrarMarcas'=>true,
                        'codigoPostal'=>true,
                        'chic'=>array('show'=>true,
                                      'brands'=>false),
                        'country'=>'EspaÃ±a',
                        'pais'=>'espana',
                        'clientName'=>'Personaling Enterprise S.L ',
                        'clientIdentification'=>'B66202383',
                        'clientAddress'=>'Sant Pere Mes Baix, NÂº 63 Principal B ',
                        'clientCity'=>'Barcelona',
                        'clientZIP'=>'08003',
                        'clientPhone'=>'934 344 634',
                        'clientEmail'=>'info@personaling.com',
                        '    ',
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
                        'AzPayTerminal'=>'997',
                        'AzPaySecret'=> 'qwerty1234567890uiop',
                        'zohoToken'=>'8b75b742aec75310a4985ab07ca683d7',
                        'zohoAccount'=>'cmontanez@upsidecorp.ch',
                        'zohoActive' => TRUE,
                        'fb_appId' => '323808071078482',
                    ),
                );
        }
 
        /**
         * Stage configuration
         * Usage:
         * - Online website
         * - Production DB
         * - All details on error
         */
        private function _stage() {
            if ($this->_country == 'es_ve')
                return array(
                    'timeZone' => 'America/Caracas',
                    'language' => 'es_ve',                    
                    'components'=>array(
                        'db'=>array(
                            'connectionString' => 'mysql:host=mysql-personaling.cu1sufeji6uk.us-west-2.rds.amazonaws.com;
                                                dbname=db_personalingNUEVA_VE',
                            'emulatePrepare' => true,
                            'username' => 'personaling',
                            'password' => 'Perso123Naling',
                            'charset' => 'utf8',
                            'tablePrefix' => 'tbl_',
                        ),
                         'less'=>array(
                                      'class'=>'ext.less.components.Less',
                                      'mode'=>'client',
                                      'files'=>array(
                                        'less/style.less'=>'css/style.less',
                                      ),
                                          'options'=>array('watch'=>false),
                                    ),
                       
                    ),
                    'params'=>array(
                    // this is used in contact page
                        'adminEmail'=>'rpalma@upsidecorp.ch',
                        'environment'=>'Stage Venezuela',
                        'PRONUNCIACION' => 'Venezolana',
                        'currSym'=>'Bs',
                        'noShipping'=> '0', // 0: Cuando se debe cobrar envio, VALOR: cuando el envío es GRATIS a partir de un VALOR determinado
                        'IVA' => '0.12',
                        'registerGift'=>'0', // 0: Cuando no se obsequia saldo, VALOR: cuando por registrarse se obsequia  un VALOR determinado
                        'askId'=>false, //Para cuando se deba solicitar y mostrar la cedula/nif/rif segun el pais
                        'IVAtext' => '12%',
                        'registro' => false,    
                        'mostrarMarcas'=>true,
                        'chic'=>array('show'=>false,
                                      'brands'=>false),
                        'country'=>'Venezuela',
                        'codigoPostal'=>false,
                        'pais'=>'venezuela',
                        'clientName'=>'PERSONALING C.A.',
                        'clientIdentification'=>'J-40236088-6',
                        'clientAddress'=>'Avenida Bolívar, C.C CCM, Piso 2, Local 210, Porlamar, Nueva Esparta',
                        'clientCity'=>'Porlamar',
                        'clientZIP'=>'6031',
                        'clientPhone'=>'0295-2676317',
                        
                        
                        'clientEmail'=>'info@personaling.com',
                        '    ',
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
                        'tweets'=>array(
                                '0'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> cuando los resultados de mi trabajo son satiscatorios. Ahora quiero ese <a href="https://twitter.com/hashtag/Makeover?src=hash">#Makeover</a> de <a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> para verme más bella</p>&mdash; Yudith Machado (@YudithMachado) <a href="https://twitter.com/YudithMachado/status/574581955284590592">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@YudithMachado', ),
                               '1'=> array( 'code'=>'<blockquote class="twitter-tweet" data-conversation="none" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> porque a pesar de no tener un maquillaje dia a dia en mi rostro mi sonrisa siempre brilla ante el mundo</p>&mdash; maryuli zabala (@maryu3278) <a href="https://twitter.com/maryu3278/status/574581990260916224">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@maryu3278', ),
                                '2'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> al ver que más mujeres confían más en su cerebro que en sus lolas</p>&mdash; Ilse Moros (@Ilsemo) <a href="https://twitter.com/Ilsemo/status/574588778494435328">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@Ilsemo', ),
                                '3'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> porque trabajamos estudiamos cocinamos nos ejercitamos hacemos mercado <a href="https://twitter.com/hashtag/FelizDiaDeLaMujer?src=hash">#FelizDiaDeLaMujer</a></p>&mdash; mahli (@inbili) <a href="https://twitter.com/inbili/status/574591413226184704">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@inbili', ),
                                '4'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> incluso en medio de hombres porque ellos no saben llevar vestidos pero yo si muy bien los pantalones!!👏</p>&mdash; zully E S Rocha (@zullyRocha) <a href="https://twitter.com/zullyRocha/status/574609384044650496">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@zullyRocha', ),
                                '5'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> cuando al ver a mis hijos grandes, sanos e inteligente se que he hecho un buen trabajo como mujer y madre <a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a></p>&mdash; Jacqueline Ƹ̴Ӂ̴Ʒ (@BJackyO) <a href="https://twitter.com/BJackyO/status/574590434195996672">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@BJackyO', ),
                                '6'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> corriendo 10K con <a href="https://twitter.com/SenosAyuda">@SenosAyuda</a> un domingo en la mañana <a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a></p>&mdash; Fabianna Mazzocca (@Fabs_MB) <a href="https://twitter.com/Fabs_MB/status/574626799306588160">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@Fabs_MB', ),
                                '7'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> cuando mi esposo <a href="https://twitter.com/elcarlosx">@elcarlosx</a> me dice que ya quisiera <a href="https://twitter.com/SaschaFitness">@SaschaFitness</a> verse como yo <a href="https://twitter.com/hashtag/lol?src=hash">#lol</a> <a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a></p>&mdash; Ana Cristina Romero (@AnaC_Romero) <a href="https://twitter.com/AnaC_Romero/status/574689206154432512">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@AnaC_Romero', ),
                                '8'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/mesientopoderosa?src=hash">#mesientopoderosa</a> cuando me veo al espejo y me gusta lo que veo, tal cual como soy♡</p>&mdash; Isabel Carlota (@IsaRamirez16) <a href="https://twitter.com/IsaRamirez16/status/574710428137308160">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@IsaRamirez16', ),
                                '9'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> cuando veo que no es necesario mostrarlo todo para llamar la atención de la gente, una buena :) y listo <a href="https://twitter.com/PersonalingVzla">@personalingVzla</a></p>&mdash; Melyda (@MelydaTimaure) <a href="https://twitter.com/MelydaTimaure/status/576039511987236864">marzo 12, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@MelydaTimaure', ),
                                '10'=>array( 'code'=>' <blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> al pensar que el FUTURO pertenece a quienes creemos en la belleza de nuestros SUEÑOS *.*</p>&mdash; Reina ツ (@adre0505) <a href="https://twitter.com/adre0505/status/576540408102125568">marzo 14, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@adre0505', ),  
                                ),
                        
                        'AzPayTerminal'=>'999',
                        'AzPaySecret'=> 'qwerty1234567890uiop',
                        'zohoToken' => '047e51a44ad91ed868192cd5a617fefd',
                        'zohoAccount'=>'dduque@upsidecorp.ch',
                        'zohoActive' => TRUE,
                        'id_look_switch' => 0,
                        'fb_appId' => '386830111475859',
                        ),
                );
            if ($this->_country == 'es_es')
                return array(
                    'language' => 'es_es',
                    'timeZone' => 'Europe/Madrid', 
                    'components'=>array(
                        'db'=>array(
                            'connectionString' => 'mysql:host=mysql-personaling.cu1sufeji6uk.us-west-2.rds.amazonaws.com;dbname=db_personalingTEST',
                            'emulatePrepare' => true,
                            'username' => 'personaling',
                            'password' => 'Perso123Naling',
                            'charset' => 'utf8',
                            'tablePrefix' => 'tbl_',
                        ),
                         'less'=>array(
                                      'class'=>'ext.less.components.Less',
                                      'mode'=>'client',
                                      'files'=>array(
                                        'less/style.less'=>'css/style.less',
                                      ),
                                          'options'=>array('watch'=>false),
                                    ),
                      
                    ),
                    'params'=>array(
                    // this is used in contact page
                        'adminEmail'=>'rpalma@upsidecorp.ch',
                        'PRONUNCIACION' => 'Española',
                        'environment'=>'Stage España', 
                        'currSym'=>'E',
                        'noShipping'=> '0', // 0: Cuando se debe cobrar envio, VALOR: cuando el envío es GRATIS a partir de un VALOR determinado
                        'IVA' => '0.21',
                        'registerGift'=>'5', // 0: Cuando no se obsequia saldo, VALOR: cuando por registrarse se obsequia  un VALOR determinado
                        'askId'=>false, //Para cuando se deba solicitar y mostrar la cedula/nif/rif segun el pais
                        'IVAtext' => '21%', 
                        'registro' => false,    
                        'mostrarMarcas'=>true,
                        'codigoPostal'=>true,
                        'chic'=>array('show'=>true,
                                      'brands'=>false),
                        'country'=>'España',
                        'pais'=>'espana',
                        'clientName'=>'Personaling Enterprise S.L ',
                        'clientIdentification'=>'B66202383',
                        'clientAddress'=>'Sant Pere Mes Baix, Nº 63 Principal B ',
                        'clientCity'=>'Barcelona',
                        'clientZIP'=>'08003',
                        'clientPhone'=>'934 344 634',
                        'clientEmail'=>'info@personaling.com',
                        '    ',
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
                        'AzPayTerminal'=>'997',
                        'AzPaySecret'=> 'qwerty1234567890uiop',
                        'zohoToken'=>'8b75b742aec75310a4985ab07ca683d7',
                        'zohoAccount'=>'cmontanez@upsidecorp.ch',
                        'zohoActive' => TRUE,
                        'fb_appId' => '323808071078482',
                    ),
                );
        }
 
        /**
         * Production configuration
         * Usage:
         * - online website
         * - Production DB
         * - Standard production error pages (404,500, etc.)
         */
        private function _production() {
            if ($this->_country == 'es_ve')
                return array(
                    'timeZone' => 'America/Caracas',
                    'language' => 'es_ve',

                    // Application components
                    'components' => array(
 
                            // Database
                            'db'=>array(
                                    'connectionString' => 'mysql:host=mysql-personaling.cu1sufeji6uk.us-west-2.rds.amazonaws.com;dbname=db_personalingSTAGE_VE',
                                    'emulatePrepare' => true,
                                    'username' => 'personaling',
                                    'password' => 'Perso123Naling',
                                    'charset' => 'utf8',
                                    'tablePrefix' => 'tbl_',
                            ),

                             'less'=>array(
                                          'class'=>'ext.less.components.Less',
                                          'mode'=>'client',
                                          'files'=>array(
                                            'less/style.less'=>'css/style.less',
                                          ),
                                              'options'=>array('watch'=>false),
                                        ),

 
                            // Application Log
                            'log'=>array(
                                    'class'=>'CLogRouter',
                                    'routes'=>array(
                                            array(
                                                    'class'=>'CFileLogRoute',
                                                    'levels'=>'error, warning',
                                            ),
 
                                            // Send errors via email to the system admin
                                            array(
                                                    'class'=>'CEmailLogRoute',
                                                    'levels'=>'error, warning',
                                                    'emails'=>'admin@example.com',
                                            ),
                                    ),
                            ),
                    ),
                    'params'=>array(
                        // this is used in contact page
                        'adminEmail'=>'rpalma@upsidecorp.ch',
                        'PRONUNCIACION' => 'Venezolana',
                        'environment'=>false,
                        'currSym'=>'Bs',
                        'noShipping'=> '0', // 0: Cuando se debe cobrar envio, VALOR: cuando el envÃ­o es GRATIS a partir de un VALOR determinado
                        'IVA' => '0.12',
                        'registerGift'=>'5', // 0: Cuando no se obsequia saldo, VALOR: cuando por registrarse se obsequia  un VALOR determinado
                        'askId'=>false, //Para cuando se deba solicitar y mostrar la cedula/nif/rif segun el pais
                        'IVAtext' => '12%',
                        'registro' => false,
                        'mostrarMarcas'=>true,
                        'chic'=>array('show'=>true,
                                      'brands'=>true),
                        'country'=>'Venezuela',
                        'codigoPostal'=>false,
                         'pais'=>'venezuela',
                        'clientName'=>'PERSONALING C.A.',
                        'clientIdentification'=>'J-40236088-6',
                        'clientAddress'=>'Avenida Bolívar, C.C CCM, Piso 2, Local 210, Porlamar, Nueva Esparta',
                        'clientCity'=>'Porlamar',
                        'clientZIP'=>'6031',
                        'clientPhone'=>'0295-2676317',
                        'clientEmail'=>'info@personaling.com',
                        '        ',
                        'metodosPago'=> array(
                                'bkCard' => false,
                                'paypal' => false,
                                'prueba' => false,
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
                            
                        'tweets'=>array(
                                '0'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> cuando los resultados de mi trabajo son satiscatorios. Ahora quiero ese <a href="https://twitter.com/hashtag/Makeover?src=hash">#Makeover</a> de <a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> para verme más bella</p>&mdash; Yudith Machado (@YudithMachado) <a href="https://twitter.com/YudithMachado/status/574581955284590592">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@YudithMachado', ),
                               '1'=> array( 'code'=>'<blockquote class="twitter-tweet" data-conversation="none" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> porque a pesar de no tener un maquillaje dia a dia en mi rostro mi sonrisa siempre brilla ante el mundo</p>&mdash; maryuli zabala (@maryu3278) <a href="https://twitter.com/maryu3278/status/574581990260916224">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@maryu3278', ),
                                '2'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> al ver que más mujeres confían más en su cerebro que en sus lolas</p>&mdash; Ilse Moros (@Ilsemo) <a href="https://twitter.com/Ilsemo/status/574588778494435328">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@Ilsemo', ),
                                '3'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> porque trabajamos estudiamos cocinamos nos ejercitamos hacemos mercado <a href="https://twitter.com/hashtag/FelizDiaDeLaMujer?src=hash">#FelizDiaDeLaMujer</a></p>&mdash; mahli (@inbili) <a href="https://twitter.com/inbili/status/574591413226184704">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@inbili', ),
                                '4'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> incluso en medio de hombres porque ellos no saben llevar vestidos pero yo si muy bien los pantalones!!👏</p>&mdash; zully E S Rocha (@zullyRocha) <a href="https://twitter.com/zullyRocha/status/574609384044650496">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@zullyRocha', ),
                                '5'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> cuando al ver a mis hijos grandes, sanos e inteligente se que he hecho un buen trabajo como mujer y madre <a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a></p>&mdash; Jacqueline Ƹ̴Ӂ̴Ʒ (@BJackyO) <a href="https://twitter.com/BJackyO/status/574590434195996672">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@BJackyO', ),
                                '6'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> corriendo 10K con <a href="https://twitter.com/SenosAyuda">@SenosAyuda</a> un domingo en la mañana <a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a></p>&mdash; Fabianna Mazzocca (@Fabs_MB) <a href="https://twitter.com/Fabs_MB/status/574626799306588160">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@Fabs_MB', ),
                                '7'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> cuando mi esposo <a href="https://twitter.com/elcarlosx">@elcarlosx</a> me dice que ya quisiera <a href="https://twitter.com/SaschaFitness">@SaschaFitness</a> verse como yo <a href="https://twitter.com/hashtag/lol?src=hash">#lol</a> <a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a></p>&mdash; Ana Cristina Romero (@AnaC_Romero) <a href="https://twitter.com/AnaC_Romero/status/574689206154432512">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@AnaC_Romero', ),
                                '8'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/mesientopoderosa?src=hash">#mesientopoderosa</a> cuando me veo al espejo y me gusta lo que veo, tal cual como soy♡</p>&mdash; Isabel Carlota (@IsaRamirez16) <a href="https://twitter.com/IsaRamirez16/status/574710428137308160">marzo 8, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@IsaRamirez16', ),
                                '9'=>array( 'code'=>'<blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> cuando veo que no es necesario mostrarlo todo para llamar la atención de la gente, una buena :) y listo <a href="https://twitter.com/PersonalingVzla">@personalingVzla</a></p>&mdash; Melyda (@MelydaTimaure) <a href="https://twitter.com/MelydaTimaure/status/576039511987236864">marzo 12, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@MelydaTimaure', ),
                                '10'=>array( 'code'=>' <blockquote class="twitter-tweet" lang="es"><p><a href="https://twitter.com/PersonalingVzla">@PersonalingVzla</a> <a href="https://twitter.com/hashtag/MeSientoPoderosa?src=hash">#MeSientoPoderosa</a> al pensar que el FUTURO pertenece a quienes creemos en la belleza de nuestros SUEÑOS *.*</p>&mdash; Reina ツ (@adre0505) <a href="https://twitter.com/adre0505/status/576540408102125568">marzo 14, 2015</a></blockquote>
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                                            'user'=>'@adre0505', ),  
                                ),
                        'AzPayTerminal'=>'999',
                        'AzPaySecret'=> 'qwerty1234567890uiop',
                        'zohoToken' => 'f298def0f5eae649aa473c7db3092dc3',
                        'zohoAccount'=>'',
                        'id_look_switch' => 0,
                        'fb_appId' => '386830111475859',
                        ),

                );
            if ($this->_country == 'es_es')
                return array(
                    'language' => 'es_es',
                    'timeZone' => 'Europe/Madrid',
                    'components'=>array(
                        'db'=>array(
                            'connectionString' => 'mysql:host=personaling.com.ve;
                               dbname=db_personalingSTAGE',
                            'emulatePrepare' => true,
                            'username' => 'personaling',
                            'password' => 'Perso123Naling',
                            'charset' => 'utf8',
                            'tablePrefix' => 'tbl_',
                        ),

                    
                        'log'=>array(
                            'class'=>'CLogRouter',
                            'routes'=>array(
                                array(
                                    'class'=>'CWebLogRoute',
                                    'levels'=>'trace,error,warning',
                                ),
                            ),
                        ),
                    ),
                    'params'=>array(
                        // this is used in contact page
                        'adminEmail'=>'rpalma@upsidecorp.ch',
                        'PRONUNCIACION' => 'EspaÃ±ola',
                        'environment'=>false,
                        'currSym'=>'E',
                        'noShipping'=> '1', // 0: Cuando se debe cobrar envio, VALOR: cuando el envÃ­o es GRATIS a partir de un VALOR determinado
                        'IVA' => '0.21',
                        'registerGift'=>'0', // 0: Cuando no se obsequia saldo, VALOR: cuando por registrarse se obsequia  un VALOR determinado
                        'askId'=>false, //Para cuando se deba solicitar y mostrar la cedula/nif/rif segun el pais
                        'IVAtext' => '21%',
                        'registro' => false,
                        'mostrarMarcas'=>true,
                        'chic'=>array('show'=>true,
                                      'brands'=>true),
                        'country'=>'EspaÃ±a',
                        'pais'=>'espana',
                        'clientName'=>'Personaling Enterprise S.L ',
                        'clientIdentification'=>'B66202383',
                        'clientAddress'=>'Sant Pere Mes Baix, NÂº 63 Principal B ',
                        'clientCity'=>'Barcelona',
                        'clientZIP'=>'08003',
                        'clientPhone'=>'934 344 634',
                        'clientEmail'=>'info@personaling.com',
                        '        ',
                        'metodosPago'=> array(
                                'bkCard' => true,
                                'paypal' => true,

                                ),
                        'multiLook'=> array(
                            'bodyType' => false,
                            'eyesColor' => true,
                            'hairColor' => true,
                            'womanMeasure' => true,
                            'bodyFavors' => true,
                            'skinColor' => true,
                        ),

                        'AzPayTerminal'=>'001',
                        'AzPaySecret'=> 'CA4AE93932ADF12EF0D2',
                        'fb_appId' => '323808071078482',
                        ),
                    );


        }
    }// END Environment Class

?>
