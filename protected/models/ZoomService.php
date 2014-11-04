<?php 

class ZoomService {
    var $URL;
    
    function ZoomService()
    {
        $this->URL = "http://sandbox.grupozoom.com/localhost/htdocs/internet/servicios/webservices/";
    }
    
    function setUrl($url) {
        $this->URL = $url;  
    }
    
    function call($method, $args)
    {
        $ch = curl_init();      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_URL, $this->URL."/".$method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
        $resposeText = curl_exec($ch);
        $resposeInfo = curl_getinfo($ch);   
        if($resposeInfo["http_code"] == 200)
        {
            
                return(json_decode($resposeText));
        }
        else
        {
                return null;
               // print_r(json_decode($resposeText));
        }
    }
        
    

}
?>