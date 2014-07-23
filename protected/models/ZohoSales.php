<?php
class ZohoSales{
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
	public $Adjustments;
	public $Discount;
	public $TotalAfterDiscount;
	
	// Save user to potential clients list
	function save_potential(){
		
		$orden = Orden::model()->findByPk(8);
		
		$xml  = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<Invoices>';
		$xml .= '<row no="1">';
		$xml .= '<FL val="Subject"> Orden '.$orden->id.'</FL>';
        $xml .= '<FL val="Purchase Order">'.intval($orden->id).'</FL>';
		$xml .= '<FL val="Status">Created</FL>';
		$xml .= '<FL val="Invoice Date">'.date("Y-m-d",strtotime($orden->fecha)).'</FL>';
		$xml .= '<FL val="Account Name">'.$orden->user->profile->first_name.' '.$orden->user->profile->last_name.'</FL>';
		$xml .= '<FL val="Email">'.$orden->user->email.'</FL>';
		$xml .= '<FL val="Peso">'.$orden->peso.'</FL>';
		$xml .= '<FL val="Billing Street">'.$orden->direccionFacturacion->dirUno.' '.$orden->direccionFacturacion->dirDos.'</FL>';
		$xml .= '<FL val="Billing State">'.$orden->direccionFacturacion->provincia->nombre.'</FL>';
		$xml .= '<FL val="Billing City">'.$orden->direccionFacturacion->ciudad->nombre.'</FL>';
		$xml .= '<FL val="Billing Country">'.$orden->direccionFacturacion->pais.'</FL>';
		$xml .= '<FL val="Telefono Facturacion">'.$orden->direccionFacturacion->telefono.'</FL>';
		$xml .= '<FL val="Shipping Street">'.$orden->direccionFacturacion->dirUno.' '.$orden->direccionFacturacion->dirDos.'</FL>';
		$xml .= '<FL val="Shipping State">'.$orden->direccionFacturacion->provincia->nombre.'</FL>';
		$xml .= '<FL val="Shipping City">'.$orden->direccionFacturacion->ciudad->nombre.'</FL>';
		$xml .= '<FL val="Shipping Country">'.$orden->direccionFacturacion->pais.'</FL>';
		$xml .= '<FL val="Telefono Envio">'.$orden->direccionFacturacion->telefono.'</FL>'; 
		$xml .= '<FL val="Tax">'.$orden->iva.'</FL>';
		$xml .= '<FL val="Discount">'.$orden->descuento.'</FL>';
		$xml .= '<FL val="Total">'.$orden->total.'</FL>';
			$xml .= $this->Products(8);
		$xml .= '</row>';
		$xml .= '</Invoices>';
		
		// echo htmlspecialchars($xml);
		
		/*
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
*/
		$url ="https://crm.zoho.com/crm/private/xml/Invoices/insertRecords";
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
		// var_dump( $response ); 
		 
	}

	function Products($order)
	{
		$productos = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$order));
		$xml2;
		$xml2 = '<FL val="Product Details">';
		$i=1; 
		foreach ($productos as $tallacolor){
			$xml2 .= '<product no="'.intval($i).'">';
			
			$producto = $tallacolor->preciotallacolor->producto;
			$precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$producto->id));
			
			$xml2 .= '<FL val="Product Name">'.$producto->nombre.'</FL>';
			$xml2 .= '<FL val="Unit Price">'.$precio->precioVenta.'</FL>';
			$xml2 .= '<FL val="List Price">'.$precio->precioVenta.'</FL>';
			$xml2 .= '<FL val="Quantity">'.intval($tallacolor->cantidad).'</FL>';
			$xml2 .= '<FL val="Discount">'.$precio->ahorro.'</FL>';
			$xml2 .= '<FL val="Net Total">'.$precio->precioImpuesto.'</FL>';
			$xml2 .= '<FL val="Total">'.$precio->precioImpuesto.'</FL>';
			
			$i++;
			$xml2 .= '</product>';
		}
		$xml2 .= '</FL>';
		return $xml2;
	}

}