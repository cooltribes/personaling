<?php
/**
 * Yii-User module
 * 
 * @author Mikhail Mangushev <mishamx@gmail.com> 
 * @link http://yii-user.2mx.org/
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @version $Id: UserModule.php 132 2011-10-30 10:45:01Z mishamx $
 */

class UserModule extends CWebModule
{
		  
	/**
	 * @var int
	 * @desc items on page
	 */
	public $user_page_size = 10;
	
	/**
	 * @var int
	 * @desc items on page
	 */
	public $fields_page_size = 10;
	
	/**
	 * @var string
	 * @desc hash method (md5,sha1 or algo hash function http://www.php.net/manual/en/function.hash.php)
	 */
	public $hash='md5';
	
	/**
	 * @var boolean
	 * @desc use email for activation user account
	 */
	public $sendActivationMail=true;
	
	/**
	 * @var boolean
	 * @desc allow auth for is not active user
	 */
	public $loginNotActiv=true;
	 
	/**
	 * @var boolean
	 * @desc activate user on registration (only $sendActivationMail = false)
	 */
	public $activeAfterRegister=false;
	
	/**
	 * @var boolean
	 * @desc login after registration (need loginNotActiv or activeAfterRegister = true)
	 */
	public $autoLogin=true;
	
	public $registrationUrl = array("/user/registration");
	public $recoveryUrl = array("/user/recovery/recovery");
	public $loginUrl = array("/user/login");
	public $logoutUrl = array("/user/logout");
	public $profileUrl = array("/user/profile");
	public $returnUrl = array("/user/profile");
	public $returnLogoutUrl = array("/user/login");
	
	
	/**
	 * @var int
	 * @desc Remember Me Time (seconds), defalt = 2592000 (30 days)
	 */
	public $rememberMeTime = 2592000; // 30 days
	
	public $fieldsMessage = '';
	
	/**
	 * @var array
	 * @desc User model relation from other models
	 * @see http://www.yiiframework.com/doc/guide/database.arr
	 */
	public $relations = array(
		
	);
	
	/**
	 * @var array
	 * @desc Profile model relation from other models
	 */
	public $profileRelations = array();
	
	/**
	 * @var boolean
	 */
	public $captcha = array('registration'=>true);
	
	/**
	 * @var boolean
	 */
	//public $cacheEnable = false;
	
	public $tableUsers = '{{users}}';
	public $tableProfiles = '{{profiles}}';
	public $tableProfileFields = '{{profiles_fields}}';

    public $defaultScope = array(
            'with'=>array('profile'),
    );
	
	static private $_user;
	static private $_users=array();
	static private $_userByName=array();
	static private $_admin;
	static private $_personal_shopper;
	static private $_admins;
	
	/**
	 * @var array
	 * @desc Behaviors for models
	 */
	public $componentBehaviors=array();
	
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'user.models.*',
			'user.components.*',
		));
	}
	
	public function getBehaviorsFor($componentName){
        if (isset($this->componentBehaviors[$componentName])) {
            return $this->componentBehaviors[$componentName];
        } else {
            return array();
        }
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	/**
	 * @param $str
	 * @param $params
	 * @param $dic
	 * @return string
	 */
	public static function t($str='',$params=array(),$dic='user') {
		if (Yii::t("UserModule", $str)==$str)
		    return Yii::t("UserModule.".$dic, $str, $params);
        else
            return Yii::t("UserModule", $str, $params);
	}
	
	/**
	 * @return hash string.
	 */
	public static function encrypting($string="") {
		$hash = Yii::app()->getModule('user')->hash;
		if ($hash=="md5")
			return md5($string);
		if ($hash=="sha1")
			return sha1($string);
		else
			return hash($hash,$string);
	}
	
	/**
	 * @param $place
	 * @return boolean 
	 */
	public static function doCaptcha($place = '') {
		if(!extension_loaded('gd'))
			return false;
		if (in_array($place, Yii::app()->getModule('user')->captcha))
			return Yii::app()->getModule('user')->captcha[$place];
		return false;
	}
	
	/**
	 * Return admin status.
	 * @return boolean
	 */
	public static function isAdmin() {
		if(Yii::app()->user->isGuest)
			return false;
		else {
			if (!isset(self::$_admin)) {
				if(self::user()->superuser)
					self::$_admin = true;
				else
					self::$_admin = false;	
			}
			return self::$_admin;
		}
	}

	/**
	 * Return personal shopper status.
	 * @return boolean
	 */
	public static function isPersonalShopper() {
		if(Yii::app()->user->isGuest)
			return false;
		else {
			if (!isset(self::$_personal_shopper)) {
				if(self::user()->personal_shopper)
					self::$_personal_shopper = true;
				else
					self::$_personal_shopper = false;	
			}
			return self::$_personal_shopper;
		}
	}
	
	/**
	 * Return admins.
	 * @return array syperusers names
	 */	
	public static function getAdmins() {
		if (!self::$_admins) {
			$admins = User::model()->active()->superuser()->findAll();
			$return_name = array();
			foreach ($admins as $admin)
				array_push($return_name,$admin->username);
			self::$_admins = ($return_name)?$return_name:array('');
		}
		return self::$_admins;
	}
	
	/**
	 * Send mail method
	 */
	public static function sendMail($email,$subject,$message) {
    	$adminEmail = Yii::app()->params['adminEmail'];
	    $headers = "MIME-Version: 1.0\r\nFrom: $adminEmail\r\nReply-To: $adminEmail\r\nContent-Type: text/html; charset=utf-8";
	    $message = wordwrap($message, 70);
	    $message = str_replace("\n.", "\n..", $message);
	    return mail($email,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
	}
	
	public static function sendRegistrationMail($user_id, $activation_url) {
		// HTML del correo desde el inicio hasta "Subject o Espacio para texto introductorio (favor actualizar)"
	$message_1 = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
/* Mobile-specific Styles */
@media only screen and (max-device-width: 480px) {
table[class=w0], td[class=w0] {
width: 0 !important;
}
table[class=w10], td[class=w10], img[class=w10] {
width:10px !important;
}
table[class=w15], td[class=w15], img[class=w15] {
width:5px !important;
}
table[class=w30], td[class=w30], img[class=w30] {
width:10px !important;
}
table[class=w60], td[class=w60], img[class=w60] {
width:10px !important;
}
table[class=w125], td[class=w125], img[class=w125] {
width:80px !important;
}
table[class=w130], td[class=w130], img[class=w130] {
width:55px !important;
}
table[class=w140], td[class=w140], img[class=w140] {
width:90px !important;
}
table[class=w160], td[class=w160], img[class=w160] {
width:180px !important;
}
table[class=w170], td[class=w170], img[class=w170] {
width:100px !important;
}
table[class=w180], td[class=w180], img[class=w180] {
width:80px !important;
}
table[class=w195], td[class=w195], img[class=w195] {
width:80px !important;
}
table[class=w220], td[class=w220], img[class=w220] {
width:80px !important;
}
table[class=w240], td[class=w240], img[class=w240] {
width:180px !important;
}
table[class=w255], td[class=w255], img[class=w255] {
width:185px !important;
}
table[class=w275], td[class=w275], img[class=w275] {
width:135px !important;
}
table[class=w280], td[class=w280], img[class=w280] {
width:135px !important;
}
table[class=w300], td[class=w300], img[class=w300] {
width:140px !important;
}
table[class=w325], td[class=w325], img[class=w325] {
width:95px !important;
}
table[class=w360], td[class=w360], img[class=w360] {
width:140px !important;
}
table[class=w410], td[class=w410], img[class=w410] {
width:180px !important;
}
table[class=w470], td[class=w470], img[class=w470] {
width:200px !important;
}
table[class=w580], td[class=w580], img[class=w580] {
width:280px !important;
}
table[class=w640], td[class=w640], img[class=w640] {
width:300px !important;
}
table[class*=hide], td[class*=hide], img[class*=hide], p[class*=hide], span[class*=hide] {
display:none !important;
}
table[class=h0], td[class=h0] {
height: 0 !important;
}
p[class=footer-content-left] {
text-align: center !important;
}
#headline p {
font-size: 30px !important;
}
.article-content, #left-sidebar {
-webkit-text-size-adjust: 90% !important;
-ms-text-size-adjust: 90% !important;
}
.header-content, .footer-content-left {
-webkit-text-size-adjust: 80% !important;
-ms-text-size-adjust: 80% !important;
}
img {
height: auto;
line-height: 100%;
}
}
/* Client-specific Styles */
#outlook a {
	padding: 0;
}	/* Force Outlook to provide a "view in browser" button. */
body {
	width: 100% !important;
}
.ReadMsgBody {
	width: 100%;
}
.ExternalClass {
	width: 100%;
	display:block !important;
} /* Force Hotmail to display emails at full width */
/* Reset Styles */

body {
	background-color: #ececec;
	margin: 0;
	padding: 0;
}
img {
	outline: none;
	text-decoration: none;
	display: block;
}
br, strong br, b br, em br, i br {
	line-height:100%;
}
h1, h2, h3, h4, h5, h6 {
	line-height: 100% !important;
	-webkit-font-smoothing: antialiased;
}
h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
	color: blue !important;
}
h1 a:active, h2 a:active, h3 a:active, h4 a:active, h5 a:active, h6 a:active {
	color: red !important;
}
/* Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. */
h1 a:visited, h2 a:visited, h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
	color: purple !important;
}
/* Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. */  
table td, table tr {
	border-collapse: collapse;
}
.yshortcuts, .yshortcuts a, .yshortcuts a:link, .yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span {
	color: black;
	text-decoration: none !important;
	border-bottom: none !important;
	background: none !important;
}

code {
	white-space: normal;
	word-break: break-all;
}
#background-table {
	background-color: #ececec;
}
/* Webkit Elements */
#top-bar {
	border-radius:6px 6px 0px 0px;
	-moz-border-radius: 6px 6px 0px 0px;
	-webkit-border-radius:6px 6px 0px 0px;
	-webkit-font-smoothing: antialiased;
	background-color: #a25f7f;
	color: #ffffff;
}
#top-bar a {
	font-weight: bold;
	color: #ffffff;
	text-decoration: none;
}
#footer {
	border-radius:0px 0px 6px 6px;
	-moz-border-radius: 0px 0px 6px 6px;
	-webkit-border-radius:0px 0px 6px 6px;
	-webkit-font-smoothing: antialiased;
}
/* Fonts and Content */
body, td {
	font-family: "Helvetica Neue", Arial, Helvetica, Geneva, sans-serif;
}
.header-content, .footer-content-left, .footer-content-right {
	-webkit-text-size-adjust: none;
	-ms-text-size-adjust: none;
}
/* Prevent Webkit and Windows Mobile platforms from changing default font sizes on header and footer. */
.header-content {
	font-size: 12px;
	color: #ffffff;
}
.header-content a {
	font-weight: bold;
	color: #ffffff;
	text-decoration: none;
}
#headline p {
	color: #d9fffd;
	font-family: "Helvetica Neue", Arial, Helvetica, Geneva, sans-serif;
	font-size: 36px;
	text-align: center;
	margin-top:0px;
	margin-bottom:30px;
}
#headline p a {
	color: #d9fffd;
	text-decoration: none;
}
.article-title {
	font-size: 18px;
	line-height:24px;
	color: #6e1346;
	font-weight:bold;
	margin-top:0px;
	margin-bottom:18px;
	font-family: "Helvetica Neue", Arial, Helvetica, Geneva, sans-serif;
}
.article-title a {
	color: #6e1346;
	text-decoration: none;
}
.article-title.with-meta {
	margin-bottom: 0;
}
.article-meta {
	font-size: 13px;
	line-height: 20px;
	color: #ccc;
	font-weight: bold;
	margin-top: 0;
}
.article-content {
	font-size: 13px;
	line-height: 18px;
	color: #666666;
	margin-top: 0px;
	margin-bottom: 18px;
	font-family: "Helvetica Neue", Arial, Helvetica, Geneva, sans-serif;
}
.article-content a {
	color: #a25f7f;
	font-weight:bold;
	text-decoration:none;
}
.article-content img {
	max-width: 100%
}
.article-content ol, .article-content ul {
	margin-top:0px;
	margin-bottom:18px;
	margin-left:19px;
	padding:0;
}
.article-content li {
	font-size: 13px;
	line-height: 18px;
	color: #666666;
}
.article-content li a {
	color: #a25f7f;
	text-decoration:underline;
}
.article-content p {
	margin-bottom: 15px;
}
.footer-content-left {
	font-size: 12px;
	line-height: 15px;
	color: #666666;
	margin-top: 0px;
	margin-bottom: 15px;
}
.footer-content-left a {
	color: #666666;
	font-weight: bold;
	text-decoration: none;
}
.footer-content-right {
	font-size: 11px;
	line-height: 16px;
	color: #666666;
	margin-top: 0px;
	margin-bottom: 15px;
}
.footer-content-right a {
	color: #666666;
	font-weight: bold;
	text-decoration: none;
}
#footer {
	background-color: #dddddd;
	color: #666666;
}
#footer a {
	color: #666666;
	text-decoration: none;
	font-weight: bold;
}
#permission-reminder {
	white-space: normal;
}
#street-address {
	color: #666666;
	white-space: normal;
}
</style>
<!--[if gte mso 9]>
<style _tmplitem="499" >
.article-content ol, .article-content ul {
   margin: 0 0 0 24px;
   padding: 0;
   list-style-position: inside;
}
</style>
<![endif]-->
</head>
<body>
<table width="100%" cellpadding="0" cellspacing="0" border="0" id="background-table">
  <tbody>
    <tr>
      <td align="center" bgcolor="#ececec"><table class="w640" style="margin:0 10px;" width="640" cellpadding="0" cellspacing="0" border="0">
          <tbody>
            <tr>
              <td class="w640" width="640" height="20"></td>
            </tr>
            <tr>
              <td class="w640" width="640"><table id="top-bar" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#a25f7f">
                  <tbody>
                    <tr>
                      <td class="w15" width="15"></td>
                      <td class="w325" width="350" valign="middle" align="left"><table class="w325" width="350" cellpadding="0" cellspacing="0" border="0">
                          <tbody>
                            <tr>
                              <td class="w325" width="350" height="8"></td>
                            </tr>
                          </tbody>
                        </table>
                        <div class="header-content"><span class="hide">
                          <preferences lang="es-ES">';
	
	// HTML del correo desde "Subject o Espacio para texto introductorio (favor actualizar)" hasta "Título del correo"
	$message_2 = '</preferences>
                          </span></div>
                        <table class="w325" width="350" cellpadding="0" cellspacing="0" border="0">
                          <tbody>
                            <tr>
                              <td class="w325" width="350" height="8"></td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td class="w30" width="30"></td>
                      <td class="w255" width="255" valign="middle" align="right"><table class="w255" width="255" cellpadding="0" cellspacing="0" border="0">
                          <tbody>
                            <tr>
                              <td class="w255" width="255" height="8"></td>
                            </tr>
                          </tbody>
                        </table>
                        <table cellpadding="0" cellspacing="0" border="0">
                          <tbody>
                            <tr>
                              <td valign="middle"><a title="Personaling en facebook" href="https://www.facebook.com/Personaling"><img width="30" height="30" title="personaling en pinterest" src="http://personaling.com/contenido_estatico/icon_personaling_facebook.png"></a></td>
                              <td width="3"><a title="Personaling en Pinterest" href="https://twitter.com/personaling"> <img width="30" height="30" title="personaling en pinterest" src="http://personaling.com/contenido_estatico/icon_personaling_twitter.png"></a></td>
                              <td valign="middle"><a title="pinterest" href="https://pinterest.com/personaling/"><img width="30" height="30" title="Personaling en Pinterest" src="http://personaling.com/contenido_estatico/icon_personaling_pinterest.png"></a></td>
                              <td class="w10" width="10"><a title="Personaling en Instagram" href="http://instagram.com/personaling"><img width="30" height="30" title="Personaling en Pinterest" src="http://personaling.com/contenido_estatico/icon_personaling_instagram.png"></a></td>
                            </tr>
                          </tbody>
                        </table>
                        <table class="w255" width="255" cellpadding="0" cellspacing="0" border="0">
                          <tbody>
                            <tr>
                              <td class="w255" width="255" height="8"></td>
                            </tr>
                          </tbody>
                        </table></td>
                      <td class="w15" width="15"></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            <tr>
              <td id="header" class="w640" width="640" align="center" bgcolor="#FFFFFF"><div align="center" style="text-align: center"> <a href="http://personaling.com/"> <img id="customHeaderImage" label="Header Image" editable="true" width="600" src="http://personaling.com/contenido_estatico/header_personaling_email.png" class="w640" border="0" align="top" style="display: inline"> </a> </div></td>
            </tr>
            <tr>
              <td class="w640" width="640" height="30" bgcolor="#ffffff"></td>
            </tr>
            <tr id="simple-content-row">
              <td class="w640" width="640" bgcolor="#ffffff"><table class="w640" width="640" cellpadding="0" cellspacing="0" border="0">
                  <tbody>
                    <tr>
                      <td class="w30" width="30"></td>
                      <td class="w580" width="580"><repeater>
                          <layout label="Text only">
                            <table class="w580" width="580" cellpadding="0" cellspacing="0" border="0">
                              <tbody>
                                <tr>
                                  <td class="w580" width="580"><p align="left" class="article-title">
                                      ';
	
	// HTML del correo desde "Título del correo" hasta el cuerpo
	$message_3 = '
                                    </p>
                                    <div align="left" class="article-content">
                                      <multiline label="Description">
                                      <p>';
	// HTML del correo desde el cuerpo hasta el footer
	$message_4 = '</p></multiline>
                                    </div></td>
                                </tr>
                                <tr>
                                  <td class="w580" width="580" height="10"></td>
                                </tr>
                              </tbody>
                            </table>
                          </layout>
                        </repeater></td>
                      <td class="w30" width="30"></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            <tr>
              <td class="w640" width="640" height="15" bgcolor="#ffffff"></td>
            </tr>
            <tr>
              <td class="w640" width="640"><table id="footer" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#dddddd">
                  <tbody>
                    <tr>
                      <td class="w30" width="30"></td>
                      <td class="w580 h0" width="360" height="30"></td>
                      <td class="w0" width="60"></td>
                      <td class="w0" width="160"></td>
                      <td class="w30" width="30"></td>
                    </tr>
                    <tr>
                      <td class="w30" width="30"></td>
                      <td class="w580" width="360" valign="top"><span class="hide">
                        <p id="permission-reminder" align="left" class="footer-content-left"><span>Recibes este correo porque estas suscrito a nuestra lista de correos o compraste en Personaling.com</span></p>
                        </span>
                        <p align="left" class="footer-content-left">
                          <preferences lang="es-ES">Modificar tu subscripcion</preferences>
                          |
                          <unsubscribe>Desuscribirse</unsubscribe>
                        </p></td>
                      <td class="hide w0" width="60"></td>
                      <td class="hide w0" width="160" valign="top"><p id="street-address" align="right" class="footer-content-right"><span>Direcci&oacute;n Fisica de Personaling.com</span></p></td>
                      <td class="w30" width="30"></td>
                    </tr>
                    <tr>
                      <td class="w30" width="30"></td>
                      <td class="w580 h0" width="360" height="15"></td>
                      <td class="w0" width="60"></td>
                      <td class="w0" width="160"></td>
                      <td class="w30" width="30"></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            <tr>
              <td class="w640" width="640" height="60"></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
  </tbody>
</table>
</body>
</html>';				
		$user = User::model()->findByPk($user_id);
    	$adminEmail = 'info@personaling.com';
		$headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: Tu Personal Shopper Digital <'.$adminEmail.'>' . "\r\n";
	    //$headers = "MIME-Version: 1.0\r\nFrom: $adminEmail\r\nReply-To: $adminEmail\r\nContent-Type: text/html; charset=utf-8";
	    $subject = 'Registro Personaling';
	    $message = $message_1.'Te damos la bienvenida a Personaling'.$message_2.'Te damos la bienvenida a Personaling'.$message_3.'Recibes este correo porque se ha registrado tu dirección en Personaling. Por favor valida tu cuenta haciendo click en el enlace que aparece a continuación:<br/><a href="'.$activation_url.'">Activar cuenta</a>'.$message_4;
	    //$message = wordwrap($message, 70);
	    //$message = str_replace("\n.", "\n..", $message);
	    return mail($user->email,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
	}
	
	/**
	 * Return safe user data.
	 * @param user id not required
	 * @return user object or false
	 */
	public static function user($id=0,$clearCache=false) {
        if (!$id&&!Yii::app()->user->isGuest)
            $id = Yii::app()->user->id;
		if ($id) {
            if (!isset(self::$_users[$id])||$clearCache)
                self::$_users[$id] = User::model()->with(array('profile'))->findbyPk($id);
			return self::$_users[$id];
        } else return false;
	}
	
	/**
	 * Return safe user data.
	 * @param user name
	 * @return user object or false
	 */
	public static function getUserByName($username) {
		if (!isset(self::$_userByName[$username])) {
			$_userByName[$username] = User::model()->findByAttributes(array('username'=>$username));
		}
		return $_userByName[$username];
	}
	
	/**
	 * Return safe user data.
	 * @param user id not required
	 * @return user object or false
	 */
	public function users() {
		return User;
	}
}
