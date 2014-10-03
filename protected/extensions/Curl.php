<?php

/**
 * Curl wrapper for Yii
 * v - 1.2
 * @author hackerone
 */
class Curl extends CComponent {

    private $_ch;
    // config from config.php
    public $options;
    // default config
    private $_config = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_AUTOREFERER => true,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:5.0) Gecko/20110619 Firefox/5.0'
    );

    private function _exec($url) {

        $this->setOption(CURLOPT_URL, $url);
        $c = curl_exec($this->_ch);
        if (!curl_errno($this->_ch))
            return $c;
        else
            throw new CException(curl_error($this->_ch));
    }

    public function get($url, $params = array()) {
        $this->setOption(CURLOPT_HTTPGET, true);
        return $this->_exec($this->buildUrl($url, $params));
    }

    public function post($url, $data = array()) {
        $this->setOption(CURLOPT_POST, true);
       // $this->setOption(CURLOPT_CUSTOMREQUEST, "PUT");
        $this->setOption(CURLOPT_POSTFIELDS, $data);
        return $this->_exec($url);
    }

    public function put($url, $data, $params = array()) {

        // write to memory/temp
        $f = fopen('php://temp', 'rw+');
        fwrite($f, $data);
        rewind($f);

        $this->setOption(CURLOPT_PUT, true);
        $this->setOption(CURLOPT_INFILE, $f);
        $this->setOption(CURLOPT_INFILESIZE, strlen($data));
		
		
		//$f_response = fopen(Yii::app()->baseUrl.'/images/request.txt', 'w');
		$f_response = fopen('/var/www/html/site/images/request.txt', 'w');
		
		    
		    $this->setOption(CURLOPT_RETURNTRANSFER , 1);
		    $this->setOption(CURLOPT_FOLLOWLOCATION , 1);
		    $this->setOption(CURLOPT_VERBOSE        , 1);
		   // $this->setOption(CURLOPT_STDERR         , $f_response);
		//$this->setOption(CURLOPT_FILE         , $f_response);
		fclose($f_response);	
		//$url = $this->buildUrl($url, $params);	
        return $this->_exec($url);
    }
	/*
	public function putPago($data) {
		$url = "https://api.instapago.com/api/payment/";
		$data_keys = array(
		"KeyId"=> "069C794A-6917-4283-B26F-2AFC7F685A96",
		"PublicKeyId"=>"5274e829763cd383270512b87a6c947e",
		);
		$data = array_merge($data_keys, $data);
		$data_string = http_build_query($data);
        $this->setOption(CURLOPT_POST, true);
        $this->setOption(CURLOPT_POSTFIELDS, $data_string);
        return $this->_exec($url);		
	}
	 * */
	
	public function putPago($data) {
			

		$url = "https://api.instapago.com/payment/";
		//$url = "http://personaling.com/payment/";
		
		// datos reales
	/*	$data_keys = array( 
		"KeyId"=> "069C794A-6917-4283-B26F-2AFC7F685A96",
		"PublicKeyId"=>"5274e829763cd383270512b87a6c947e",
		);*/
		
		$data_keys = array(
		"KeyId"=> "EDC20F86-9C7E-4D2A-9603-6EF5612F5536",
		"PublicKeyId"=>"5274e829763cd383270512b87a6c947e", 
		);
		
		$data = array_merge($data_keys, $data);
		//var_dump($data); 
		
		$data_string = http_build_query($data);
		//echo $data_string;
		//$f_response = fopen('/var/www/html/site/images/request.txt', 'w');
		//$this->setOption(CURLOPT_CUSTOMREQUEST, 'PUT');
		$this->setOption(CURLOPT_SSL_VERIFYHOST, 0);
		$this->setOption(CURLOPT_SSL_VERIFYPEER, 0);
		$this->setOption(CURLOPT_USERPWD,"069C794A-6917-4283-B26F-2AFC7F685A96");
		$this->setOption(CURLOPT_POST, 1);
		$this->setOption(CURLOPT_CONNECTTIMEOUT, 100);
		$this->setOption(CURLOPT_TIMEOUT, 100);
		//$this->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		$this->setOption(CURLOPT_POSTFIELDS, $data_string);
		$this->setOption(CURLOPT_RETURNTRANSFER, 1);
		    
		    
		    $this->setOption(CURLOPT_FOLLOWLOCATION , 1);
		    $this->setOption(CURLOPT_VERBOSE        , 1);
		//$this->setOption(CURLOPT_STDERR         , $f_response);
		//$this->setOption(CURLOPT_FILE         , $f_response);
		
		//fclose($f_response);	
		//$url = $this->buildUrl($url, $params);
		//echo $this->_exec($url);
        return json_decode($this->_exec($url));
    }
	
	public function getstatus(){
		
		return curl_getinfo($this->_ch, CURLINFO_HTTP_CODE);
	}

    public function buildUrl($url, $data = array()) {
        $parsed = parse_url($url);
        isset($parsed['query']) ? parse_str($parsed['query'], $parsed['query']) : $parsed['query'] = array();
        $params = isset($parsed['query']) ? array_merge($parsed['query'], $data) : $data;
        $parsed['query'] = ($params) ? '?' . http_build_query($params) : '';
        if (!isset($parsed['path']))
            $parsed['path'] = '/';
        
        $port = '';
        if(isset($parsed['port'])){
            $port = ':' . $parsed['port'];
        }
        
        return $parsed['scheme'] . '://' . $parsed['host'] .$port. $parsed['path'] . $parsed['query'];
    }

    public function setOptions($options = array()) {
        curl_setopt_array($this->_ch, $options);
        return $this;
    }

    public function setOption($option, $value) {
        curl_setopt($this->_ch, $option, $value);
        return $this;
    }

    // sets header for current request
    public function setHeaders($header)
    {
        if($this->_isAssoc($header)){
            $out = array();
            foreach($header as $k => $v){
                $out[] = $k .': '.$v;
            }
            $header = $out;
        }
        $this->setOption(CURLOPT_HTTPHEADER, $header);
        return $this;
    }


    // initialize curl
    public function init() {
        try {
            $this->_ch = curl_init();
            $options = is_array($this->options) ? ($this->options + $this->_config) : $this->_config;
            $this->setOptions($options);

            $ch = $this->_ch;

            // close curl on exit
            /*Yii::app()->onEndRequest = function() use(&$ch) {
                        curl_close($ch);
                    };
			 * 
			 */
			 Yii::app()->onEndRequest=array($this,'closeCurl');
        } catch (Exception $e) {
            throw new CException('Curl not installed');
        }
    }
	public function closeCurl() {
     curl_close($this->_ch);
}

}