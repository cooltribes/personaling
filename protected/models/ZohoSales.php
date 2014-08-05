<?php
class ZohoSales{
	public $id;
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
	function save_potential($orden){
		
		//$orden = Orden::model()->findByPk($orden); 
		
		$xml  = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<Invoices>';
		$xml .= '<row no="1">';
		$xml .= '<FL val="Subject"> Orden '.$orden->id.'</FL>';
        $xml .= '<FL val="Purchase Order">'.intval($orden->id).'</FL>';
		$xml .= '<FL val="Status">Created</FL>';
		$xml .= '<FL val="Invoice Date">'.date("Y-m-d",strtotime($orden->fecha)).'</FL>';
		$xml .= '<FL val="Contact Id">1135568000000151007</FL>';
		$xml .= '<FL val="Contact Name">'.$orden->user->profile->first_name.' '.$orden->user->profile->last_name.'</FL>';
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
		$xml .= '<FL val="Sub Total">'.(double)$orden->subtotal.'</FL>';
		$xml .= '<FL val="Tax">'.(double)$orden->iva.'</FL>';
		if((double)$orden->descuento > 0) 
			$xml .= '<FL val="Discount">'.(double)$orden->descuento.'</FL>';
		
			$xml .= $this->Products($orden->id); 
		
		$xml .= '<FL val="Grand Total">'.(double)$orden->total.'</FL>'; 
		$xml .= '</row>';
		$xml .= '</Invoices>';
		
	//	echo htmlspecialchars($xml)."<p><p>";

		$url ="https://crm.zoho.com/crm/private/xml/Invoices/insertRecords";
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
			
			/*--------------*/
			$url ="https://crm.zoho.com/crm/private/xml/Products/getRecordById";
$query="authtoken=".Yii::app()->params['zohoToken']."&scope=crmapi&newFormat=1&id=".$tallacolor->preciotallacolor->zoho_id."&selectColumns=Products(Product Name,descuento,Precio Impuesto,Unit Price,Precio Descuento)";
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $query);// Set the request as a POST FIELD for curl.
	
			$response = curl_exec($ch);
			curl_close($ch);
		//	return $response; 
		//	echo htmlspecialchars($response)."<p><p>";
			
			$datos = simplexml_load_string($response);
		//	var_dump($datos);
			
			$id = $datos->result[0]->Products[0]->row->FL[0]; 
			$nombre = $datos->result[0]->Products[0]->row->FL[1];
			$unit = $datos->result[0]->Products[0]->row->FL[2];
			$contax = $datos->result[0]->Products[0]->row->FL[3];
			$discount_price = $datos->result[0]->Products[0]->row->FL[4];
			$discount = $datos->result[0]->Products[0]->row->FL[5];
			// Yii::app()->end();
			
			$xml2 .= '<FL val="Product Id">'.intval($id).'</FL>';
			$xml2 .= '<FL val="Product Name">'.$nombre.'</FL>';
			$xml2 .= '<FL val="Unit Price">'.(double)$unit.'</FL>';
			$xml2 .= '<FL val="List Price">'.(double)$unit.'</FL>';
			$xml2 .= '<FL val="Total">'.(double)$unit.'</FL>';
			if((double)$discount_price > 0){
				$xml2 .= '<FL val="Total After Discount">'.(double)$discount_price.'</FL>';
				$xml2 .= '<FL val="Discount">'.(double)$discount.'</FL>';
			}
			else {
				$xml2 .= '<FL val="Total After Discount">'.(double)$unit.'</FL>';
				$xml2 .= '<FL val="Discount"> 0 </FL>';
			}
			$xml2 .= '<FL val="Quantity">'.intval($tallacolor->cantidad).'</FL>';
			
			$impt = (double)$unit * 0.21;
			
			$xml2 .= '<FL val="Tax">'.(double)$impt.'</FL>';
			$xml2 .= '<FL val="Net Total">'.(double)$contax.'</FL>';
						
			$i++;
			$xml2 .= '</product>';
		}
		$xml2 .= '</FL>';
		return $xml2;
	}

	function convertirLead($lead_id,$lead_mail){
		
		$xml = '
			<Potentials>
			<row no="1">
			<option val="createPotential">false</option>
			<option val="assignTo">'.$lead_mail.'</option>
			<option val="notifyLeadOwner">false</option>
			<option val="notifyNewEntityOwner">false</option>
			</row>
			</Potentials>';	
			
		$url ="https://crm.zoho.com/crm/private/xml/Leads/convertLead";
		$query="authtoken=".Yii::app()->params['zohoToken']."&scope=crmapi&leadId=".$lead_id."&xmlData=".$xml;
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
	}

}