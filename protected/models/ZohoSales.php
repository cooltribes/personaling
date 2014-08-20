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
		$xml .= '<FL val="Status">'.$orden->getTextEstado().'</FL>'; 
		$xml .= '<FL val="Invoice Date">'.date("Y-m-d",strtotime($orden->fecha)).'</FL>';
		$xml .= '<FL val="Contact Id">'.$orden->user->zoho_id.'</FL>';
		$xml .= '<FL val="Contact Name">'.$orden->user->profile->first_name.' '.$orden->user->profile->last_name.'</FL>';
		$xml .= '<FL val="Email">'.$orden->user->email.'</FL>';
		$xml .= '<FL val="Peso">'.$orden->peso.'</FL>';
		$xml .= '<FL val="Envio">'.$orden->envio.'</FL>';
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
		
		$detalles = Detalle::model()->findAllByAttributes(array('orden_id'=>$orden->id));
		$envio_pago = 0;
		$ajuste=0;
		$forma="";
		$cupon=0;
		
		foreach($detalles as $detalle)
		{
			if($envio_pago == 0){		
				if($orden->envio > 0){
					$ajuste = $ajuste + $orden->envio;
					$envio_pago = 1;
				}
			}
			
			if($detalle->tipo_pago == 3){ 
				$ajuste -= $detalle->monto; 
				$xml .= '<FL val="Balance">'.(double)$detalle->monto.'</FL>';
				$forma .= " Balance, ";
			}
			
			if($detalle->tipo_pago == 4 || $detalle->tipo_pago == 5){
				$xml .= '<FL val="Paypal_Sabadell">'.(double)$detalle->monto.'</FL>';
				
				if($detalle->tipo_pago == 4)
					$forma .= " Sabadell, ";
				if($detalle->tipo_pago == 5)
					$forma .= " Paypal, ";
				if($detalle->tipo_pago == 7)
					$forma .= " Paypal prueba, ";
				
			}
			
			if(isset($orden->cupon)){
				if($cupon == 0){
					$ajuste -= $orden->cupon->descuento;
					$xml .= '<FL val="Cupon">'.(double)$orden->cupon->descuento.'</FL>';
					$forma .= " Cupón de descuento, ";
					$cupon++;
				}	
			} 
		} 
			
		$xml .= '<FL val="Adjustment">'.(double)$ajuste.'</FL>';	
		$xml .= '<FL val="Forma de Pago">'.$forma.'</FL>';
		// echo $ajuste;
		//Yii::app()->end();
			
		if((double)$orden->descuento > 0) 
			$xml .= '<FL val="Discount">'.(double)$orden->descuento.'</FL>';
		
			$xml .= $this->Products($orden->id); 
		
			$this->actualizarCantidades($orden->id);	
		
		$xml .= '<FL val="Grand Total">'.(double)$orden->total.'</FL>'; 
		$xml .= '</row>';
		$xml .= '</Invoices>';
		
		//echo htmlspecialchars($xml)."<p><p>";
		//Yii::app()->end();
		
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
		$ordenhas = new OrdenHasProductotallacolor;
		
		$xml2;
		$costo = 0;
		$dcto_productos = 0;
		$dcto_looks = 0;
		
		$xml2 = '<FL val="Product Details">';
		$i=1; 
		foreach ($productos as $tallacolor){
			$xml2 .= '<product no="'.intval($i).'">';
			
			$producto = $tallacolor->preciotallacolor->producto;
			$precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$producto->id));
			
			$costo += $precio->costo;
			$dcto_productos += $precio->ahorro;
			
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
		//	echo htmlspecialchars($response)."<p><p>";
			
			$datos = simplexml_load_string($response);
			
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
		$xml2 .= '<FL val="Costo">'.(double)$costo.'</FL>'; 
		$xml2 .= '<FL val="Descuento Productos">'.(double)$dcto_productos.'</FL>';
		
		if($ordenhas->countLooks($order) > 0) // hay looks
		{ 
			$looks = $ordenhas->getLooks($order);
			
			//var_dump($looks);
			//Yii::app()->end();
			
			foreach($looks as $lk)
			{
				$look = Look::model()->findByPk($lk['look_id']); 
				
				if(isset($look->tipoDescuento)) // No es null. hay descuento
				{
					if($look->tipoDescuento == 0) // porcentaje
					{
						$prc = $look->getPorcentajeDescuento();
						$total = $look->getPrecioProductosDescuento(false) * $look->valorDescuento / 100;
						$dcto_looks += $total;
					}
					
					if($look->tipoDescuento == 1){
						$dcto_looks += $look->valorDescuento; 
					}
						
				}
				
			}
		} 
		
		$xml2 .= '<FL val="Descuento Looks">'.(double)$dcto_looks.'</FL>';
		
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

	function actualizarCantidades($id){
		
		$productos = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$id));
		
		$xml;
		$xml = '<Products>';
		$i=1;
		
		foreach($productos as $tallacolor){ 
			
			$prod = Producto::model()->findByPk($tallacolor->preciotallacolor->producto_id);
			
			$xml .= '<row no="'.$i.'">';
			$xml .= '<FL val="Product Name">'.$prod->nombre.' - '.$tallacolor->preciotallacolor->sku.'</FL>';
			$xml .= '<FL val="Id">'.$tallacolor->preciotallacolor->zoho_id.'</FL>';
			$xml .= '<FL val="Qty in Stock">'.$tallacolor->preciotallacolor->cantidad.'</FL>';
			$xml .= '</row>';
			
			$i++;
			
		} // foreach
				
		$xml .= '</Products>';
		
		/*--------------*/
		$url ="https://crm.zoho.com/crm/private/xml/Products/updateRecords";
		$query="authtoken=".Yii::app()->params['zohoToken']."&scope=crmapi&version=4&xmlData=".$xml;
				
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $query);// Set the request as a POST FIELD for curl.
		
		$response = curl_exec($ch);
		curl_close($ch);
				
		// $datos = simplexml_load_string($response);
	}


}