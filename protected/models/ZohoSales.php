<?php
class ZohoProductos{
	public $subject;
	public $SONumber;
	public $status;
	public $DueDate;
	public $ContactName;
	public $Email;
	public $Peso;
	public $BillingAddressStreet;
	public $BillingAddressState;
	public $BillingAddressCity;
	public $BillingAddressCountry;
	public $TelefonoFacturacion;
	public $ShippingAddressStreet;
	public $ShippingAddressState;
	public $ShippingAddressCity;
	public $ShippingAddressCountry;
	public $TelefonoEnvio;
	public $tax;
	public $total;
	
	// Save user to potential clients list
	function save_potential(){
		
		$productos = $this->Products(8);
		
		$xml  = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<Products>';
		$xml .= '<row no="1">';
		if(isset($this->nombre)) $xml .= '<FL val="Product Name">'.$this->nombre.'</FL>';
		if(isset($this->marca)) $xml .= '<FL val="Marca">'.$this->marca.'</FL>';
		if(isset($this->referencia)) $xml .= '<FL val="Referencia">'.$this->referencia.'</FL>';
		if(isset($this->estado)) $xml .= '<FL val="Product Active">'.$this->estado.'</FL>';
		if(isset($this->peso)) $xml .= '<FL val="Peso">'.$this->peso.'</FL>';
		if(isset($this->fecha)) $xml .= '<FL val="Sales Start Date">'.$this->fecha.'</FL>';
		if(isset($this->categoria)) $xml .= '<FL val="Categoria">'.$this->categoria.'</FL>';
		if(isset($this->subcategoria1)) $xml .= '<FL val="Subcategoría1">'.$this->subcategoria1.'</FL>';
		if(isset($this->subcategoria2)) $xml .= '<FL val="Subcategoria2">'.$this->subcategoria2.'</FL>';
		if(isset($this->tipo)) $xml .= '<FL val="Tipo">'.$this->tipo.'</FL>';
		if(isset($this->tienda)) $xml .= '<FL val="Tienda">'.$this->tienda.'</FL>';
		if(isset($this->url)) $xml .= '<FL val="url">'.$this->url.'</FL>';
		if(isset($this->descripcion)) $xml .= '<FL val="Description">'.$this->descripcion.'</FL>';
		if(isset($this->costo)) $xml .= '<FL val="Costo">'.$this->costo.'</FL>'; 
		if(isset($this->precioVenta)) $xml .= '<FL val="Unit Price">'.$this->precioVenta.'</FL>';
		if(isset($this->precioDescuento)) $xml .= '<FL val="PrecioDescuento">'.$this->precioDescuento.'</FL>';
		if(isset($this->descuento)) $xml .= '<FL val="descuento">'.$this->descuento.'</FL>';
		if(isset($this->precioImpuesto)) $xml .= '<FL val="Precio Impuesto">'.$this->precioImpuesto.'</FL>';
		if(isset($this->ValorEnLook)) $xml .= '<FL val="Valor Venta en Look">'.$this->ValorEnLook.'</FL>';
		if(isset($this->porcentaje)) $xml .= '<FL val="PorcentajeDescuento">'.$this->porcentaje.'</FL>';
		if(isset($this->talla)) $xml .= '<FL val="Talla">'.$this->talla.'</FL>';
		if(isset($this->color)) $xml .= '<FL val="Color">'.$this->color.'</FL>';
		if(isset($this->SKU)) $xml .= '<FL val="SKU">'.$this->SKU.'</FL>';
		if(isset($this->cantidad)) $xml .= '<FL val="Qty in Stock">'.$this->cantidad.'</FL>';
		if(isset($this->titulo)) $xml .= '<FL val="Titulo">'.$this->titulo.'</FL>';
		if(isset($this->metaDescripcion)) $xml .= '<FL val="Meta Descripcion">'.$this->metaDescripcion.'</FL>';
		if(isset($this->tags)) $xml .= '<FL val="Tags">'.$this->tags.'</FL>';
		$xml .= '</row>';
		$xml .= '</Products>';
	//	var_dump($xml);

		$url ="https://crm.zoho.com/crm/private/xml/Products/insertRecords";
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

	function Products($order)
	{
		$xml ="";
		
		return $xml;
	}

}