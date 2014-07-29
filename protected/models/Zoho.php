<?php
class Zoho{
	public $email;
	public $fisrt_name;
	public $last_name;
	public $birthday;
	public $sex;
	public $bio;
	public $dni;
	public $tlf_casa;
	public $tlf_celular;
	public $pinterest;
	public $twitter;
	public $facebook;
	public $url;
	public $admin;
	public $ps;
	public $altura;
	public $condicion_fisica;
	public $color_piel;
	public $color_cabello;
	public $color_ojos;
	public $tipo_cuerpo;
	public $diario;
	public $fiesta;
	public $vacaciones;
	public $deporte;
	public $oficina;
	public $calle;
	public $ciudad;
	public $estado;
	public $codigo_postal;
	public $pais;
	public $status;
	public $no_suscrito;
	

	// Save user to potential clients list
	function save_potential(){
		$xml  = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<Leads>';
		$xml .= '<row no="1">';
		if(isset($this->first_name)) $xml .= '<FL val="First Name">'.$this->first_name.'</FL>';
		if(isset($this->last_name)) $xml .= '<FL val="Last Name">'.$this->last_name.'</FL>';
		if(isset($this->email)) $xml .= '<FL val="Email">'.$this->email.'</FL>';
		$xml .= '<FL val="Lead Source">Tienda Personaling</FL>';
		if(isset($this->birthday)) $xml .= '<FL val="Fecha de Nacimiento">'.$this->birthday.'</FL>';
		if(isset($this->sex)) $xml .= '<FL val="Sexo">'.$this->sex.'</FL>';
		if(isset($this->bio)) $xml .= '<FL val="Description">'.$this->bio.'</FL>';
		if(isset($this->dni)) $xml .= '<FL val="Documento de Identidad">'.$this->dni.'</FL>';
		if(isset($this->tlf_casa)) $xml .= '<FL val="Phone">'.$this->tlf_casa.'</FL>';
		if(isset($this->tlf_celular)) $xml .= '<FL val="Mobile">'.$this->tlf_celular.'</FL>';
		if(isset($this->pinterest)) $xml .= '<FL val="Pinterest">'.$this->pinterest.'</FL>';
		if(isset($this->twitter)) $xml .= '<FL val="Twitter">'.$this->twitter.'</FL>';
		if(isset($this->facebook)) $xml .= '<FL val="Facebook">'.$this->facebook.'</FL>';
		if(isset($this->url)) $xml .= '<FL val="Alias para el Url">'.$this->url.'</FL>';
		if(isset($this->url)) $xml .= '<FL val="Website">'.$this->url.'</FL>';
		if(isset($this->admin)) $xml .= '<FL val="Perfil de Administrador">'.$this->admin.'</FL>';
		if(isset($this->ps)) $xml .= '<FL val="Perfil de Personal Shopper">'.$this->ps.'</FL>';
		if(isset($this->altura)) $xml .= '<FL val="Altura">'.$this->altura.'</FL>';
		if(isset($this->condicion_fisica)) $xml .= '<FL val="Condición Física">'.$this->condicion_fisica.'</FL>';
		if(isset($this->color_piel)) $xml .= '<FL val="Color de piel">'.$this->color_piel.'</FL>';
		if(isset($this->color_cabello)) $xml .= '<FL val="Color de cabello">'.$this->color_cabello.'</FL>';
		if(isset($this->color_ojos)) $xml .= '<FL val="Color de ojos">'.$this->color_ojos.'</FL>';
		if(isset($this->tipo_cuerpo)) $xml .= '<FL val="Tipo de Cuerpo">'.$this->tipo_cuerpo.'</FL>';
		if(isset($this->diario)) $xml .= '<FL val="Diario">'.$this->diario.'</FL>';
		if(isset($this->fiesta)) $xml .= '<FL val="Fiesta">'.$this->fiesta.'</FL>';
		if(isset($this->vacaciones)) $xml .= '<FL val="Vacaciones">'.$this->vacaciones.'</FL>';
		if(isset($this->deporte)) $xml .= '<FL val="Haciendo Deporte">'.$this->deporte.'</FL>';
		if(isset($this->oficina)) $xml .= '<FL val="Oficina">'.$this->oficina.'</FL>';
		if(isset($this->calle)) $xml .= '<FL val="Street">'.$this->calle.'</FL>';
		if(isset($this->ciudad)) $xml .= '<FL val="City">'.$this->ciudad.'</FL>';
		if(isset($this->estado)) $xml .= '<FL val="State">'.$this->estado.'</FL>';
		if(isset($this->codigo_postal)) $xml .= '<FL val="Zip Code">'.$this->codigo_postal.'</FL>';
		if(isset($this->pais)) $xml .= '<FL val="Country">'.$this->pais.'</FL>';
		if(isset($this->status)) $xml .= '<FL val="Lead Status">'.$this->status.'</FL>';
		if(isset($this->no_suscrito)) $xml .= '<FL val="Email Opt-out">'.$this->no_suscrito.'</FL>';

		$xml .= '</row>';
		$xml .= '</Leads>';

		$url ="https://crm.zoho.com/crm/private/xml/Leads/insertRecords";
		$query="authtoken=81ad9c824bfa232084f4b1a825797588&scope=crmapi&newFormat=1&duplicateCheck=2&xmlData=".$xml;
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
		//var_dump( $response );
	}
}