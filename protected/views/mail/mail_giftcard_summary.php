<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

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
              <td class="w640" width="640"><table id="top-bar" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#231f20">
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
                          <preferences lang="es-ES"></preferences>
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
                              <td valign="middle"><a title="Personaling en facebook" href="https://www.facebook.com/Personaling"><img width="30" height="30" title="personaling en pinterest" src="http://personaling.com/contenido_estatico/icon_personaling_facebook_v2.png"></a></td>
                              <td width="3"><a title="Personaling en Pinterest" href="https://twitter.com/personaling"> <img width="30" height="30" title="personaling en pinterest" src="http://personaling.com/contenido_estatico/icon_personaling_twitter_v2.png"></a></td>
                              <td valign="middle"><a title="pinterest" href="https://pinterest.com/personaling/"><img width="30" height="30" title="Personaling en Pinterest" src="http://personaling.com/contenido_estatico/icon_personaling_pinterest_v2.png"></a></td>
                              <td class="w10" width="10"><a title="Personaling en Instagram" href="http://instagram.com/personaling"><img width="30" height="30" title="Personaling en Pinterest" src="http://personaling.com/contenido_estatico/icon_personaling_instagram_v2.png"></a></td>
                              <td class="w10" width="10"><a title="Personaling en Youtube" href="http://www.youtube.com/channel/UCe8aijeIv0WvrZS-G-YI3rQ"><img width="30" height="30" title="Personaling en youtube" src="http://personaling.com/contenido_estatico/icon_personaling_youtube_v2.png"></a></td>                              
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
              <td id="header" class="w640" width="640" align="center" bgcolor="#FFFFFF"><div align="center" style="text-align: center"> <a href="http://personaling.com/"> <img id="customHeaderImage" label="Header Image" editable="true" width="600" src="http://personaling.com/contenido_estatico/header_personaling_email_v2.png" class="w640" border="0" align="top" style="display: inline"> </a> </div></td>
            </tr>
            <tr>
              <td class="w640" width="640" height="30" bgcolor="#ffffff"></td>
            </tr>
            <tr id="simple-content-row">
              <td class="w640" width="640" bgcolor="#ffffff"><table class="w640" width="640" cellpadding="0" cellspacing="0" border="0" >
                  <tbody>
                    <tr>
                      <td class="w30" width="30"></td>
                      <td class="w580" width="580"><repeater>
                          <layout label="Text only">
                            <table class="w580" width="580" cellpadding="0" cellspacing="0" border="0" >
                              <tbody width="580">
                                <tr>
                                  <td class="w580" width="580"><p align="left" class="article-title">
                                      <singleline label="Title"><?php //echo $subject; ?></singleline>
                                    </p>
                                    <div align="left" width="580" class="article-content w580" style=" word-wrap: break-word; width: 580px;">
                                      <multiline label="Description" width="580">
                                      <?php echo $body; ?>
                                      </multiline>
                                       <p class="well well-small"><strong>Número de confirmación:</strong> <?php echo $orden->id; ?></p>
                                     
                                       
                                      <table border="0" cellspacing="3" cellpadding="5" class="table table-bordered table-hover table-striped" width="100%">
                                      	<thead>
	                                      	<th style="border:solid 1px #FFF; background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center" scope="col">Via</th>
	                                      	<th style="border:solid 1px #FFF; background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center" scope="col">Destinatario</th>
	                                      	<th style="border:solid 1px #FFF; background-color:#000; color:#FFF; text-transform:uppercase; vertical-align: middle; text-align: center" scope="col">Monto</th>
	                                       	</thead>
                                      	<tbody>
                                      		<?php echo $resumen ?>
                                      	</tbody>
                                      </table>
                                      
                                      
                                      
                                      
                                      
                                      
                                    </div>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="w580" width="580" height="10"></td>
                                </tr>
                                <tr>
                                  <td class="w580" width="580" height="10"></td>
                                </tr>
                                <tr>
                                  <td class="w580" width="580" height="10"></td>
                                </tr>                                                                
                                <tr>
                                  <td class="w580" width="580" height="10"></td>
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
              <td class="w640" width="640"><table id="footer" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#231f20">
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
                      <td class="w580" width="360" valign="top">
                       <span class="hide">
                                                <p id="permission-reminder" align="left" class="footer-content-left" style="color:#FFFFFF">
                                                   
                                                </p>
                                                </span>
                       </td>
                      <td class="hide w0" width="60"></td>
                      <td class="hide w0" width="180" valign="top">
                      <p id="street-address" align="right" class="footer-content-right" style="color:#FFFFFF"><span><a href="http://personaling.com/" title="personaling" style="color:#FFFFFF">Tu Personal Shopper Digital</a></span></p>
                      </td>
                      <td class="w30" width="30"></td>
                    </tr>
                    <tr>
                        <td class="w30" width="30"></td>
                        <td class="w580" width="360" valign="top">
                        <span class="hide">
                            <p id="permission-reminder" align="left" class="footer-content-left" style="color:#FFFFFF"><span><?php echo Yii::t('contentForm', 'Personaling C.A RIF: J-40236088-6'); ?></span></p>
                            </span>
                            </td>
                        <td class="hide w0" width="60"></td>
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
</html>
