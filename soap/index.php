<?php
try{
  $sClient = new SoapClient('https://api.affili.net/V2.0/Logon.svc?wsdl');

  //var_dump($sClient->__getFunctions());
  //var_dump($sClient->__getTypes());
  $params = array('Username' => '731031',
'Password' => 'xr76oVBcYcN9QUkFOBCn',
'WebServiceType' => 'Publisher');
//  $response = $sClient->Logon($params);
//  var_dump($response);

  $sLogon = new SoapClient('http://product-api.affili.net/Authentication/Logon.svc?wsdl');

  $params = array('Username' => '731031',
				'Password' => '3MbLL4BKfXhl4ewvm6X1',
				'WebServiceType' => 'Product'
			);
  $CredentialToken = $sLogon->Logon($params);

  //var_dump($response);
  echo $CredentialToken;

  $sProduct = new SoapClient('http://product-api.affili.net/V3/WSDLFactory/Product_ProductData.wsdl');

  $params = array(
  			'PublisherId' => '731031',
  			'CredentialToken' => $CredentialToken,
  			'Query' => 'ipod'
  			);
  $productos = $sProduct->SearchProducts($params);

  var_dump($params);

} catch(SoapFault $e){
  var_dump($e);
}
?>
 