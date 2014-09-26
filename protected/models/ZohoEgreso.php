<?php
class ZohoEgreso{
	 
	// Save user to potential clients list
	function save($move){
			
		$xml  = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= '<Invoices>';
		$xml .= '<row no="1">';
		$xml .= '<FL val="Subject">Egreso '.$move->motivo.' - '.date("d-m-Y").'</FL>';
        $xml .= '<FL val="Purchase Order"> Egreso </FL>';
		$xml .= '<FL val="Status">Finalizada</FL>'; 
		$xml .= '<FL val="Invoice Date">'.date("Y-m-d",strtotime($move->fecha)).'</FL>';
		$xml .= '<FL val="Contact Id">'.$this->findPersonalingUser().'</FL>';
		$xml .= '<FL val="Contact Name">Personaling Enterprise S.L. </FL>';
		$xml .= '<FL val="Email">info@personaling.com</FL>';
		$xml .= '<FL val="Description">'.$move->comentario.', '.$move->motivo.'</FL>';
		$xml .= '<FL val="Sub Total">'.(double)$move->total.'</FL>';
			
		$xml .= $this->Products($move->id,$this->findPersonalingUser()); 
		$this->actualizarCantidades($move->id);
		
		$xml .= '<FL val="Grand Total">'.(double)$move->total.'</FL>'; 
		$xml .= '</row>';
		$xml .= '</Invoices>';
		
		// var_dump($xml);
		
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
		
		$user = User::model()->findByAttributes(array('email'=>"info@personaling.com"));
		
		if(isset($user)){
			if(isset($user->zoho_id)){
				return $user->zoho_id;
			}else{ // is not on zoho
				$zoho = New Zoho;
				$zoho->email = "info@personaling.com";
				$zoho->first_name = "Personaling";
				$zoho->last_name = "Enterprise S.L.";
				$zoho->estado = "TRUE";
				$zoho->tipo = "Interno";
				
				$response = $zoho->save_potential();
				
				$xml = simplexml_load_string($response);
	            $id = (int)$xml->result[0]->recorddetail->FL[0];
	
	            $user->zoho_id = $id;
				$user->tipo_zoho = 0;
				$user->save();
				
				if($user->tipo_zoho == 0){ 
					$conv = $this->convertirLead($user->zoho_id, $user->email);
					$datos = simplexml_load_string($conv);
										
					$clientId = $datos->Contact;
					$user->zoho_id = $clientId;
					$user->tipo_zoho = 1;
										
					$user->save(); 
					return $clientId;
				}else{
					return $id;
				}
				
			}
		}else{ // create new user and send it to zoho
			$user = new User;
			$user->email = "info@personaling.com";
			$user->username = "info@personaling.com";
			$user->superuser = 0;
			$user->status = User::STATUS_ACTIVE;
			$user->interno = 1;
			$user->tipo_zoho = 0;
			
			if($user->save()){
				$zoho = New Zoho;
				$zoho->email = "info@personaling.com";
				$zoho->fisrt_name = "Personaling"; 
				$zoho->last_name = "Enterprise S.L.";
				$zoho->estado = "TRUE";
				$zoho->tipo = "Interno";
				
				$response = $zoho->save_potential();
				
				$xml = simplexml_load_string($response);
	            $id = (int)$xml->result[0]->recorddetail->FL[0];
	
	            $user->zoho_id = $id;
				$user->save();
				
				if($user->tipo_zoho == 0){ 
					$conv = $this->convertirLead($user->zoho_id, $user->email);
					$datos = simplexml_load_string($conv);
										
					$clientId = $datos->Contact;
					$user->zoho_id = $clientId;
					$user->tipo_zoho = 1;
										
					$user->save(); 
					return $clientId;
				}else{
					return $id; 
				}
			}
		}
		
	}

	function Products($move,$info_id)
	{
		$products = Movimientohaspreciotallacolor::model()->findAllByAttributes(array('movimiento_id'=>$move));
		//$productos = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$order));
		
		$addProduct = "";
		$xml2;
		$cost = 0;
		
		$xml2 = '<FL val="Product Details">';
		$i=1;
		$y=1; 
		$addProduct .= "<Products>";
		
		foreach ($products as $combination){
			$xml2 .= '<product no="'.intval($i).'">';
			
			$preciotallacolor = Preciotallacolor::model()->findByPk($combination->preciotallacolor_id);
			
			$product = $preciotallacolor->producto;
			$price = Precio::model()->findByAttributes(array('tbl_producto_id'=>$product->id));
			
			$cost += $price->costo; 
			
			$id = $preciotallacolor->zoho_id;
			$name = $product->nombre." - ".$preciotallacolor->sku;
			$unit = $price->precioVenta;
		//	$price_tax = $price->precioImpuesto;
			
			$xml2 .= '<FL val="Product Id">'.(int)$id.'</FL>';
			$xml2 .= '<FL val="Product Name">'.$name.'</FL>'; 
			$xml2 .= '<FL val="Unit Price">'.(double)$price->costo.'</FL>';
			$xml2 .= '<FL val="List Price">'.(double)$price->costo.'</FL>';
			$xml2 .= '<FL val="Total">'.(double)$price->costo.'</FL>';
			$xml2 .= '<FL val="Quantity">'.intval($combination->cantidad).'</FL>';
			
		//	$tax = (double)$unit * 0.21;
		//	$xml2 .= '<FL val="Tax">'.(double)$tax.'</FL>';
			$xml2 .= '<FL val="Net Total">'.(double)$price->costo.'</FL>';
						
			$i++;
			$xml2 .= '</product>';
			
									/* Añadiendo el producto al usuario */ 
						
									$addProduct .= "<row no='".intval($y)."'>";
									$addProduct .= "<FL val='PRODUCTID'>".(int)$preciotallacolor->zoho_id."</FL>";
						       		$addProduct .= "</row>"; 
									$y++;
			
		}
		$xml2 .= '</FL>';
		$xml2 .= '<FL val="Costo">'.(double)$cost.'</FL>';
		
			$addProduct .= "</Products>";
			
			$url2 ="https://crm.zoho.com/crm/private/xml/Contacts/updateRelatedRecords"; 
			$query2="authtoken=".Yii::app()->params['zohoToken']."&scope=crmapi&relatedModule=Products&id=".$info_id."&xmlData=".$addProduct; 
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
		$xml2 .= '<FL val="Total Productos">'.(double)$cost.'</FL>'; 
		
		return $xml2; 
	}

	function actualizarCantidades($id){
		
		$moves = Movimientohaspreciotallacolor::model()->findAllByAttributes(array('movimiento_id'=>$id));
//		$productos = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$id));
		
		$xml;
		$xml = '<Products>';
		$i=1;
		
		foreach($moves as $move){
				
			$preciotallacolor = Preciotallacolor::model()->findByPk($move->preciotallacolor_id);			
			$prod = Producto::model()->findByPk($preciotallacolor->producto_id);
			
			$xml .= '<row no="'.$i.'">';
			$xml .= '<FL val="Product Name">'.$prod->nombre.' - '.$preciotallacolor->sku.'</FL>';
			$xml .= '<FL val="Id">'.$preciotallacolor->zoho_id.'</FL>';
			$xml .= '<FL val="Qty in Stock">'.$preciotallacolor->cantidad.'</FL>';
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