<?php
class ZohoEgreso{
	 
	// Save user to potential clients list
	function save($orden){
			
		$xml  = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<Invoices>';
		$xml .= '<row no="1">';
		$xml .= '<FL val="Subject">Egreso - '.date("d-m-Y").'</FL>';
        $xml .= '<FL val="Purchase Order"> Egreso </FL>';
		$xml .= '<FL val="Status">Finalizada</FL>'; 
		$xml .= '<FL val="Invoice Date">'.date("Y-m-d").'</FL>';
		$xml .= '<FL val="Contact Id">'.$this->findPersonalingUser().'</FL>';
		$xml .= '<FL val="Contact Name">Personaling Enterprise S.L</FL>';
		$xml .= '<FL val="Email">info@personaling.com</FL>';
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
			}
			
			$forma .= $detalle->getTipoPago().", "; 
			
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
		
		var_dump($xml);
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

	function findPersonalingUser(){
		// check if already exists on Zoho, if not send it
		
	}

	function Products($move)
	{
		$productos = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$order));
		$ordenhas = new OrdenHasProductotallacolor;
		$orden = Orden::model()->findByPk($order); 

		$addProduct = "";
		$xml2;
		$costo = 0;
		$dcto_productos = 0;
		$dcto_looks = 0;
		$dcto_total = 0;
		$looks_orden = "";
		
		$xml2 = '<FL val="Product Details">';
		$i=1; 
		$addProduct .= "<Products>";
		
		foreach ($productos as $tallacolor){
			$xml2 .= '<product no="'.intval($i).'">';
			
			$producto = $tallacolor->preciotallacolor->producto;
			$precio = Precio::model()->findByAttributes(array('tbl_producto_id'=>$producto->id));
			
			$costo += $precio->costo;
			$dcto_productos += $precio->ahorro;	
			
			$id = $tallacolor->preciotallacolor->zoho_id;
			$nombre = $producto->nombre." - ".$tallacolor->preciotallacolor->sku;
			$unit = $precio->precioVenta;
			$contax = $precio->precioImpuesto;
			$discount_price = $precio->precioDescuento;
			$discount = $precio->ahorro; 
			
			$xml2 .= '<FL val="Product Id">'.(int)$id.'</FL>';
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
			
									/* Añadiendo el producto al usuario */ 
						
									$addProduct .= "<row no='".intval($i)."'>";
									$addProduct .= "<FL val='PRODUCTID'>".(int)$tallacolor->preciotallacolor->zoho_id."</FL>";
						       		$addProduct .= "</row>"; 
		
			
		}
		$xml2 .= '</FL>';
		$xml2 .= '<FL val="Costo">'.(double)$costo.'</FL>'; 
		$xml2 .= '<FL val="Descuento Productos">'.(double)$dcto_productos.'</FL>';
		
		
		/*AÑANDIENDO AL CLIENTE 
		
			$addProduct .= "</Products>";
			
			$url2 ="https://crm.zoho.com/crm/private/xml/Contacts/updateRelatedRecords"; 
			$query2="authtoken=".Yii::app()->params['zohoToken']."&scope=crmapi&relatedModule=Products&id=".$orden->user->zoho_id."&xmlData=".$addProduct; 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url2);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $query2);// Set the request as a POST FIELD for curl.
	
			//Execute cUrl session 
			$response = curl_exec($ch);
			curl_close($ch);
			
		/* ===================== */ 	
		
		if($ordenhas->countLooks($order) > 0) // hay looks
		{ 
			$looks = $ordenhas->getLooks($order);
			
			foreach($looks as $lk)
			{
				$look = Look::model()->findByPk($lk['look_id']); 
				
				$looks_orden .= $look->title." (id: ".$look->id."), ";
								
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
		$dcto_total = $dcto_productos + $dcto_looks; 
		$totalProductos = $orden->total - $orden->envio; 
		
		$xml2 .= '<FL val="Looks">'.$looks_orden.'</FL>';
		$xml2 .= '<FL val="Descuento Looks">'.(double)$dcto_looks.'</FL>';
		$xml2 .= '<FL val="Descuento Total">'.(double)$dcto_total.'</FL>';
		$xml2 .= '<FL val="Total Productos">'.(double)$totalProductos.'</FL>'; 
		
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