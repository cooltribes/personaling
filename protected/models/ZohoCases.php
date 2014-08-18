<?php
class ZohoCases{
	public $Subject;
	public $Priority;
	public $Status;
	public $Origin;
	public $Email;
	public $Phone;
	public $Description;
	public $Comment;
	public $Solution;
	public $internal;
	public $reason;
	public $type;
	public $posible; 
	public $posible_id;
	public $related;
	public $related_id;
	
	// Save case
	function save_potential(){
		
		//$orden = Orden::model()->findByPk($orden); 
		
		$xml  = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<Cases>';
		$xml .= '<row no="1">';
		if(isset($this->Subject)) $xml .= '<FL val="Subject">'.$this->Subject.'</FL>';
		if(isset($this->Priority)) $xml .= '<FL val="Priority">'.$this->Priority.'</FL>';
		if(isset($this->Status)) $xml .= '<FL val="Status">'.$this->Status.'</FL>'; 
		if(isset($this->Origin)) $xml .= '<FL val="Case Origin">'.$this->Origin.'</FL>'; 
		if(isset($this->type)) $xml .= '<FL val="Type">'.$this->type.'</FL>'; 
        if(isset($this->Email)) $xml .= '<FL val="Email">'.$this->Email.'</FL>';
		if(isset($this->Phone)) $xml .= '<FL val="Phone">'.$this->Phone.'</FL>';
		if(isset($this->posible)){
			$xml .= '<FL val="Posible Cliente">'.$this->posible.'</FL>';
			$xml .= '<FL val="Posible Cliente Id">'.$this->posible_id.'</FL>';
		} 
		if(isset($this->related)){
			$xml .= '<FL val="Related To">'.$this->related.'</FL>';
			$xml .= '<FL val="Related To Id">'.$this->related_id.'</FL>';
		}
		if(isset($this->reason)) $xml .= '<FL val="Case Reason">'.$this->reason.'</FL>';
		if(isset($this->Description)) $xml .= '<FL val="Description">'.$this->Description.'</FL>';
		if(isset($this->Comment)) $xml .= '<FL val="Add Comment">'.$this->Comment.'</FL>';
		if(isset($this->Solution)) $xml .= '<FL val="Solution">'.$this->Solution.'</FL>';
		if(isset($this->internal)) $xml .= '<FL val="Internal Comments">'.$this->internal.'</FL>';
		$xml .= '</row>';
		$xml .= '</Cases>';
 
		$url ="https://crm.zoho.com/crm/private/xml/Cases/insertRecords";
		$query="authtoken=".Yii::app()->params['zohoToken']."&scope=crmapi&newFormat=1&duplicateCheck=2&xmlData=".$xml;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $query);// Set the request as a POST FIELD for curl.

		//Execute cUrl session
		$response = curl_exec($ch);
		curl_close($ch);
		return $response; 
		// var_dump( $response ); 
		 
	}
}