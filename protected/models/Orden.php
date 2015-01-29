<?php
include("class.zoom.json.services.php");

/*
 * Definicion de los estados de la orden por transferencia
 * 1 - En espera de pago
 * 2 - En espera de confirmación
 * 3 - Pago Confirmado
 * 4 - Enviado
 * 5 - Cancelado
 * 6 - Pago Rechazado
 * 7 - Pago insuficiente
 * 8 - Recibido
 * 9 - Devuelto
 * 10 - Parcialmente devuelto 
 * 11 - Finalizada
 * 12 - Finalizada - Devuelta
 * 13 - Finalizada - Parcialmente devuelta
 * 
 * -------------- 
 * Tipo de Guia
 * --------------
 * 0 - Envio Estandar
 * 1 - Entre 0.5 kg y 5 kg
 * 2 - Mayor a 5 kg
 * 
 * ----------------------
 * ESTADOS DE LOGIS FASHION
 * 0 - enviado a lf
 * 1 - confirmado por lf
 * 2 - anulada checking
 * 3 - anulada picking
 * 4 - finalizada (paquete armado para enviar)
 * 5 - enviada
 * 
 * 
 * */

/**
 * This is the model class for table "{{orden}}".
 *
 * The followings are the available columns in table '{{orden}}':
 * @property integer $id
 * @property double $subtotal
 * @property double $descuento
 * @property double $envio
 * @property double $iva
 * @property double $descuentoRegalo
 * @property double $total
 * @property integer $estado
 * @property string $fecha
 * @property integer $bolsa_id
 * @property integer $user_id
 * @property integer $pago_id
 * @property integer $detalle_id
 * @property integer $direccionEnvio_id
 * @property string $tracking
 * The followings are the available model relations:
 * @property DireccionEnvio $direccionEnvio
 * @property Pago $pago
 * @property Pago $detalle
 * @property integer $estadoLF
 */
class Orden extends CActiveRecord
{
	const ESTADO_ESPERA = 1;
	const ESTADO_ESPERA_CONF = 2;
	const ESTADO_CONFIRMADO = 3;
        
	const ESTADO_ENVIADO = 4;
	const ESTADO_CANCELADO = 5;
	const ESTADO_RECHAZADO = 6;
	
        const ESTADO_INSUFICIENTE = 7;	
	const ESTADO_ENTREGADA = 8;
	const ESTADO_DEVUELTA = 9;
        
	const ESTADO_PARC_DEV = 10;        
        const ESTADO_FINALIZADA = 11;
	const ESTADO_FIN_DEVUELTA = 12;
        
	const ESTADO_FIN_PARC_DEV = 13;        

	public static $estados = array('1' => 'En espera de pago',
        '2' => 'En espera de confirmación', '3' => 'Pago confirmado',
        '4' => 'Enviado', '5' => 'Cancelada', '6' => 'Pago rechazado',
        '7' => 'Pago insuficiente', '8' => 'Entregada', '9' => 'Devuelta', 
        '10' => 'Parcialmente devuelta', '11' => "Finalizada",
        
         );
	 /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Orden the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{orden}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bolsa_id, user_id, direccionEnvio_id, tipo_guia, peso', 'required'),
			array('estado, bolsa_id, user_id,   direccionEnvio_id, tipo_guia', 'numerical', 'integerOnly'=>true),
			array('subtotal, descuento, envio, iva, descuentoRegalo, total, seguro', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subtotal, descuento, fecha, envio, iva, descuentoRegalo,
                            total, estado, bolsa_id, user_id,   direccionEnvio_id, tracking,
                            seguro, tipo_guia, peso, estadoLF, zoho_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'direccionEnvio' => array(self::BELONGS_TO, 'DireccionEnvio', 'direccionEnvio_id'),
			'direccionFacturacion' => array(self::BELONGS_TO, 'DireccionFacturacion', 'direccionFacturacion_id'),
			//'pago' => array(self::BELONGS_TO, 'Pago', 'pago_id'),
			'detalle' => array(self::BELONGS_TO, 'Pago', 'detalle_id'),
			'productos' => array(self::MANY_MANY, 'Preciotallacolor', 'tbl_orden_has_productotallacolor(tbl_orden_id, preciotallacolor_id)'),
			'looks' => array(self::MANY_MANY, 'Look', 'tbl_orden_has_productotallacolor(tbl_orden_id, look_id)','condition'=>'looks_looks.look_id > 0'),
			'estados' => array(self::HAS_MANY, 'Estado', 'orden_id', 'index'=>'id'),
			'mensajes' => array(self::HAS_MANY, 'Mensaje', 'orden_id', 'index'=>'id'),
			'detalles' => array(self::HAS_MANY, 'Detalle','orden_id'),
			'ohptc' => array(self::HAS_MANY, 'OrdenHasProductotallacolor','tbl_orden_id'),
			'totalpagado' => array(self::STAT, 'Detalle', 'orden_id',
            		'select' => 'SUM(monto)',
            		'condition' => 'estado = 1'
        		),
        	'nproductos' => array(self::STAT, 'OrdenHasProductotallacolor', 'tbl_orden_id',
            		'select' => 'COUNT(preciotallacolor_id)',
            		'condition' => 'cantidad > 0'
        		),
                        'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
                        'cupon'=>array(self::HAS_ONE, 'CuponHasOrden', 'orden_id'),
                        'outbound'=>array(self::HAS_ONE, 'Outbound', 'orden_id'),
     
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'subtotal' => 'Subtotal',
			'descuento' => 'Descuento',
			'envio' => 'Envio',
			'iva' => 'Iva',
			'descuentoRegalo' => 'Descuento Regalo',
			'total' => 'Total',
			'estado' => 'Estado',
			'fecha' => 'Fecha',
			'bolsa_id' => 'Bolsa',
			'user_id' => 'User',
			//'pago_id' => 'Pago',
			//'detalle_id' => 'Detalle',
			'direccionEnvio_id' => 'Direccion Envio',
			'tracking' => 'Número de guía',
			'seguro' => 'Seguro',
			'tipo_guia' => 'Tipo de guía',
			'peso' => 'Peso',
			'zoho_id' => 'ID Zoho',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('subtotal',$this->subtotal);
		$criteria->compare('descuento',$this->descuento);
		$criteria->compare('envio',$this->envio);
		$criteria->compare('iva',$this->iva);
		$criteria->compare('descuentoRegalo',$this->descuentoRegalo);
		$criteria->compare('total',$this->total);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('fecha',$this->fecha);
		$criteria->compare('bolsa_id',$this->bolsa_id);
		$criteria->compare('user_id',$this->user_id);
		//$criteria->compare('pago_id',$this->pago_id);
		//$criteria->compare('detalle_id',$this->detalle_id);
		$criteria->compare('direccionEnvio_id',$this->direccionEnvio_id);
		$criteria->compare('tracking',$this->tracking);
		$criteria->compare('seguro',$this->seguro);
		$criteria->compare('peso',$this->peso);
		$criteria->compare('zoho_id',$this->zoho_id);
		 
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}	

	public function busqueda()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('subtotal',$this->subtotal);
		$criteria->compare('descuento',$this->descuento);
		$criteria->compare('envio',$this->envio);
		$criteria->compare('iva',$this->iva);
		$criteria->compare('descuentoRegalo',$this->descuentoRegalo);
		$criteria->compare('total',$this->total);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('fecha',$this->fecha);
		$criteria->compare('bolsa_id',$this->bolsa_id);
		$criteria->compare('user_id',$this->user_id);
		//$criteria->compare('pago_id',$this->pago_id);
		//$criteria->compare('detalle_id',$this->detalle_id);
		$criteria->compare('direccionEnvio_id',$this->direccionEnvio_id);
		$criteria->compare('tracking',$this->tracking);
		$criteria->compare('seguro',$this->seguro);
		$criteria->compare('zoho_id',$this->zoho_id);
		
		$criteria->addCondition('estado != 6');
                $criteria->order = 'fecha DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function activas()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
 
		$criteria=new CDbCriteria;
		$criteria->select='t.*';
		$criteria->with=array('estados');
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->addCondition("t.estado <5 OR t.estado =7  OR (estados.estado = 8 AND estados.fecha >'".date('Y-m-d', strtotime('-1 month'))."' )");
		//$criteria->addCondition("estados.fecha >'".date('Y-m-d', strtotime('-1 month'))."'");
		$criteria->together = true;
		$criteria->group = 't.id';
		$criteria->order = 't.fecha DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function vendidas($pages = NULL)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
 
 	$sql="select p.id, o.cantidad as Cantidad, pr.nombre as Nombre, p.sku as SKU,  o.look_id as look, o.precio as Precio, pre.precioVenta as pVenta, ord.id as Orden,
		pre.precioImpuesto as pIVA, pre.costo as Costo, m.id, m.nombre as Marca,  t.valor as Talla, c.valor as Color, ord.fecha as Fecha, pr.codigo as Referencia
		from tbl_orden_has_productotallacolor o  
		JOIN tbl_precioTallaColor p ON p.id = o.preciotallacolor_id 
		JOIN tbl_orden ord ON ord.id = o.tbl_orden_id 
		JOIN tbl_producto pr ON pr.id = p.producto_id 
		JOIN tbl_precio pre ON pre.tbl_producto_id = p.producto_id 
		JOIN tbl_marca m ON m.id=pr.marca_id 
		JOIN tbl_talla t ON t.id=p.talla_id 
		JOIN tbl_color c ON c.id=p.color_id where o.tbl_orden_id IN(
		select id from tbl_orden where estado = 3 OR estado = 4 OR estado = 8 OR estado = 10 ) AND o.cantidad > 0 ";
		
		if(isset(Yii::app()->session['idMarca'])){
			if(Yii::app()->session['idMarca']!=0)
				$sql=$sql." AND m.id=".Yii::app()->session['idMarca'];

		}
		
		if(isset(Yii::app()->session['desde'])&&isset(Yii::app()->session['hasta'])){
			
				$sql=$sql." AND ord.fecha BETWEEN '".Yii::app()->session['desde']."' AND '".Yii::app()->session['hasta']."'";

		}
		
		
		$rawData=Yii::app()->db->createCommand($sql)->queryAll();
		
		if(!is_null($pages)){
				
			if(!$pages){
				$sql="select count(o.preciotallacolor_id) from tbl_orden_has_productotallacolor o WHERE o.tbl_orden_id IN(select id from tbl_orden where estado = 3 OR estado = 4 OR estado = 8 OR estado = 10 ) AND o.cantidad > 0";
				$pages=Yii::app()->db->createCommand($sql)->queryScalar();
			}
			else
				$pages=30;
		}

				
				// or using: $rawData=User::model()->findAll(); <--this better represents your question
	
				return new CArrayDataProvider($rawData, array(
				    'id'=>'data',
				    'pagination'=>array(
				        'pageSize'=>$pages,
				    ),
					 
				    'sort'=>array(
				        'attributes'=>array(
				             'Nombre', 'Marca', 'Talla', 'Color', 'Costo', 'Orden', 'Fecha'
				        ),
	    ),
				));
		
		

	}
	
	public function historial()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->select='t.*';
		$criteria->with=array('estados');
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->addCondition("(t.estado = 8 AND estados.fecha < '".date('Y-m-d', strtotime('-1 month'))."') OR t.estado = 5 ");
		$criteria->together = true;
		$criteria->group = 't.id';
		$criteria->order = 't.fecha DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
	public function getTotalByUser($id){
		
		$sql = "select sum(total) from tbl_orden where
                        estado IN (3, 4, 8)
                        and user_id = ".$id;
                //Revisar cuales estados de orden se deben incluir
		$total = Yii::app()->db->createCommand($sql)->queryScalar();
		return $total;
		
	}
	
		public function getPurchasedByUser($id){
		
		$sql = "select sum(total) from tbl_orden where user_id = ".$id." and (estado = 3 OR estado = 4 OR estado = 8)";
		$total = Yii::app()->db->createCommand($sql)->queryScalar();
		if(is_null($total))
			return 0;
		return $total;
		
	}
	
		 
	public function countOrdersByUser($id){
		
		$sql = "select count(id) from tbl_orden where user_id = ".$id." and (estado = 3 OR estado = 4 OR estado = 8)";
		$total = Yii::app()->db->createCommand($sql)->queryScalar();
		return $total;
		
	}

	public function filtrado($query)
	{
		
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('subtotal',$this->subtotal);
		$criteria->compare('descuento',$this->descuento);
		$criteria->compare('envio',$this->envio);
		$criteria->compare('iva',$this->iva);
		$criteria->compare('descuentoRegalo',$this->descuentoRegalo);
		$criteria->compare('total',$this->total);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('fecha',$this->fecha);
		$criteria->compare('bolsa_id',$this->bolsa_id);
		$criteria->compare('user_id',$this->user_id);
		//$criteria->compare('pago_id',$this->pago_id);
		//$criteria->compare('detalle_id',$this->detalle_id);
		$criteria->compare('direccionEnvio_id',$this->direccionEnvio_id);
		$criteria->compare('tracking',$this->tracking);	
		$criteria->compare('seguro',$this->seguro);
		$criteria->join ='JOIN tbl_users ON tbl_users.id = t.user_id AND (t.id LIKE "%'.$query.'%" OR tbl_users.username LIKE "%'.$query.'%" )';
		
	//	$criteria->addCondition('t.id LIKE :valor','OR');
	//	$criteria->addCondition('tbl_users.username LIKE :valor','OR');
		
	// 	$criteria->params = array(":valor" => $query);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
		
		
		
	}
        
        /**
         * 
         */
        public function buscarPorFiltros($filters) {

            $criteria = new CDbCriteria;
            $joinPagos = '';
            $joinUsers = '';
            $joinLooks = '';
            $havingLooks = '';

            for ($i = 0; $i < count($filters['fields']); $i++) {
                
                $column = $filters['fields'][$i];
                $value = $filters['vals'][$i];
                $comparator = $filters['ops'][$i];
                
                if($i == 0){
                   $logicOp = 'AND'; 
                }else{                
                    $logicOp = $filters['rels'][$i-1];                
                }                
                
                if($column == 'fecha'){
                    $value = strtotime($value);
                    $value = date('Y-m-d H:i:s', $value);
                }
                
                if($column == 'looks'){
                    
                   if (!strpos($joinLooks, 'tbl_orden_has_productotallacolor')) {
                        $joinLooks .= ' JOIN tbl_orden_has_productotallacolor as oprod ON oprod.tbl_orden_id = t.id AND oprod.look_id > 0';
                        $criteria->group = 't.id';
                        $havingLooks .= 'count(oprod.tbl_orden_id) '.$comparator.' '.$value.'';
                   }else{
                        $havingLooks .= ' '.$logicOp.' count(oprod.tbl_orden_id) '.$comparator.' '.$value.'';
                   }  
                                      
                   continue;
                }
                
                if($column == 'prendas'){
                   
                   if (!strpos($joinLooks, 'tbl_orden_has_productotallacolor')) {
                        $joinLooks .= ' JOIN tbl_orden_has_productotallacolor as oprod 
                            ON oprod.tbl_orden_id = t.id AND oprod.look_id = 0';
                        $criteria->group = 't.id';
                        $havingLooks .= 'count(oprod.tbl_orden_id) '.$comparator.' '.$value.'';
                   }else{
                        $havingLooks .= ' '.$logicOp.' count(oprod.tbl_orden_id) '.$comparator.' '.$value.'';
                   }   
                   
                    continue;
                }
                               
                if($column == 'pago_id'){                
                   
                    if (!strpos($joinPagos, 'tbl_detalle')) {
                        $joinPagos .= ' JOIN tbl_detalle on tbl_detalle.orden_id = t.id AND
                            ( tbl_detalle.tipo_pago '.$comparator.' '.$value.' )';
                    }else{
                        $joinPagos = str_replace(")", $logicOp.' tbl_detalle.tipo_pago '.$comparator.' '.$value.' )', $joinPagos) ; 
                    }           
                    
                    continue;
                }
                
                if($column == 'user_id'){
                    
                    $rest = ($comparator == '=') ? "= '".$value."'" : "LIKE '%".$value."%'";
                    
                    if (!strpos($joinUsers, 'tbl_users')) {
                        $joinUsers .= ' JOIN tbl_users on tbl_users.id = user_id AND ( tbl_users.username '.$rest.' )';
                    }else{
                        $joinUsers = str_replace(")", $logicOp.' tbl_users.username '.$rest.' )', $joinUsers) ; 
                    }  
                    
                    continue;
                }
                
                //Para las finalizadas
                if($column == 'estado'){
                    
                    if($value == 11){  
                        if($comparator == "="){
                            $criteria->addInCondition('t.'.$column, array(
                                11, 12, 13
                            ), $logicOp);                            
                        }else{
                            $criteria->addNotInCondition('t.'.$column, array(
                                11, 12, 13
                            ), $logicOp);                                                        
                        }

                        continue;
                    }
                    
                    if($value == 9){  
                        if($comparator == "="){
                            $criteria->addInCondition('t.'.$column, array(
                                9, 12
                            ), $logicOp);                            
                        }else{
                            $criteria->addNotInCondition('t.'.$column, array(
                                9, 12
                            ), $logicOp);                                                        
                        }
                         
                        continue;
                    }
                    
                    if($value == 10){  
                        if($comparator == "="){
                            $criteria->addInCondition('t.'.$column, array(
                                10, 13
                            ), $logicOp);                            
                        }else{
                            $criteria->addNotInCondition('t.'.$column, array(
                                10, 13
                            ), $logicOp);                                                        
                        }
                         
                        continue;
                    }
                   
                }
                
                $criteria->compare('t.'.$column, $comparator." ".$value,
                        false, $logicOp);
                
//                $filters['fields'][$i];
//                $filters['ops'][$i];
//                $filters['vals'][$i];
//                $filters['rels'][$i];
            }
                                   
            
            $criteria->select = 't.*';
            $criteria->join .= $joinPagos;
            $criteria->join .= $joinUsers;
            $criteria->join .= $joinLooks;
            $criteria->having .= $havingLooks;                          
            
//            echo "Criteria:";
//            
//            echo "<pre>";
//            print_r($criteria->toArray());
//            echo "</pre>"; 
//            exit();
//            echo "Condicion: ".$criteria->condition;
//            

            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
       }
	
	       public function getDevueltas()
	{
		$sql = "select count(id) from tbl_orden where estado = 9 or estado = 10";
		$num = Yii::app()->db->createCommand($sql)->queryScalar();
		return $num;
	}  
	public function getXConfirmar()
	{
		$sql = "select count(id) from tbl_orden where estado = 2";
		$num = Yii::app()->db->createCommand($sql)->queryScalar();
		return $num;
	}  
	public function getTipoPago(){
		if (isset($this->detalles))
		foreach ($this->detalles as $detalle){
			return $detalle->tipo_pago;
		}
		return 1;
		
	}
	public function cambiarEstado($estado){
		$this->estado = $estado;
		$this->save();
	}
	public function getMontoActivo(){
	if($this->estado == 3 || $this->estado == 8){
		return $this->total;
		
	}
	if($this->estado == 7)
	{
		/*$balance = Balance::model()->findByAttributes(array('user_id'=>$orden->user_id,'orden_id'=>$orden->id));
		if(isset($balance)){
			$a = $balance->total * -1;
			echo Yii::app()->numberFormatter->formatDecimal($a); 
		}*/
		//echo 'px'.$orden->getxPagar();
		//echo 'orden'.$orden->totalpagado; 
				return $this->getxPagar();
	}
	if($this->estado == 1 || $this->estado == 2 || $this->estado == 4 || $this->estado == 5 || $this->estado == 6){
				
		$balance = Balance::model()->findByAttributes(array('user_id'=>$this->user_id,'orden_id'=>$this->id, 'tipo'=>0));

		if(isset($balance))
		{
			if($balance->total < 0){
				$a = $balance->total * -1;
				return $a;
			}else {
				return $this->getxPagar();
			}
			
		}
		else
		{
			return $this->getxPagar();
		}
					
		
				
	}	
	}
	public function getxPagar($id=null){
		                
		if(is_null($id))
				$porpagar=$this->total-$this->totalpagado;
		else
			{
				$orden=$this->findByPk($id);
				$porpagar=$orden->total-$orden->totalpagado;
			}
		if($porpagar<0)
			$porpagar=0;
		
				
		return $porpagar;
		
	} 
	
	public function getTrackingInfo($id=null){
			
		if(is_null($id))
				$orden=$this;
		else
			{
				$orden=$this->findByPk($id);
		}
		$guia=$orden->tracking;
		if($orden->shipCarrier=='ZOOM'){
			$cliente = new ZoomService;
		 	return $cliente->call("getInfoTracking", array("tipo_busqueda"=>"1", "codigo"=>$guia,"codigo_cliente"=>Yii::app()->params['clientZoom']));
		//Devuelve array de tracking si lo consigue o null si no
		}
		else
			return;
	}
	
	public function getFlete($id=null){
			
		if(is_null($id))
				$orden=$this;
		else
			{
				$orden=$this->findByPk($id);
		}
		$cliente = new ZoomService;
	 	
	 		return $cliente->call("CalcularTarifa", array("tipo_tarifa"=>"2","modalidad_tarifa"=>"2","ciudad_remitente"=>"15","ciudad_destinatario"=>$orden->direccionEnvio->myciudad->cod_zoom,NULL,"cantidad_piezas"=>$orden->nproductos, "peso"=>$orden->peso,NULL,"valor_declarado"=>$orden->total));
		
	} 
	public function calcularTarifa($ciudad,$nproductos,$peso,$total){
			
		$cliente = new ZoomService;
       
        
        
        $array=array(  
             "tipo_tarifa"=>2,
             "modalidad_tarifa"=>2,
             "ciudad_remitente"=>19,
             "ciudad_destinatario"=>$ciudad,
             "oficina_retirar"=>0,
             "cantidad_piezas"=>$nproductos,
             "peso"=>$peso,
             "valor_mercancia"=>NULL,
             "valor_declarado"=>$total,
             "codpais"=>0,
             "tipo_envio"=>0
        );
	 	return $cliente->call("CalcularTarifa", $array);
        
	 
		//Devuelve array de tracking si lo consigue o null si no
	} 
	
	public function countxEstado($estado){
		return count($this->findAllByAttributes(array('estado'=>$estado)));
	}
	
	public function getTextEstado($estado = null) {
            if (is_null($estado)) {
                $estado = $this->estado;
            }

            if($estado == 12 || $estado == 13){
            
                $otrosEstados = array('12' => 'Devuelta<br>Finalizada',
                    '13' => "Parcialmente devuelta<br>Finalizada",);
                
                return isset($otrosEstados[$estado]) ? $otrosEstados[$estado] : "ERROR";
                
            }
            
            return isset(self::$estados[$estado]) ? self::$estados[$estado] : "ERROR";
            
            
        }
        
        /**
         * Revisar la orden y los looks involucrados para asignarle a los
         * respectivos PS su comisión ganada.
         */
        public function pagarComisiones($orden){            
           
            $sumaComisiones = array();
            foreach($orden->ohptc as $productoEnOrden)
            {                                                    
                //Incluir en la comision solo los productos que estan en un look
                if($productoEnOrden->look_id > 0){

                    $lookActual = Look::model()->findByPk($productoEnOrden->look_id);

                    //Comisión de la PS dueña del look
                    $comision = $lookActual->user->profile->comision;
                    $tipoComision = $lookActual->user->profile->tipo_comision;
//                    $comision = 7;
//                    $tipoComision = 1; //1=%, 2=fijo                       

                    //Si la comisión es por Porcentaje
                    if($tipoComision == 1){

                        $comision /= 100;
                        $montoVenta = $productoEnOrden->precio * $productoEnOrden->cantidad;
                        $comisionAgregada = $montoVenta * $comision;                                                         

                        //Si la comisión es un monto fijo
                    }else if($tipoComision == 2){

                        $comisionAgregada = $comision;

                    } 
                    $idUsuario = $lookActual->user->id;
                    //si ya hay comisiones por el look/usuario actual, sumar
                    if(key_exists($idUsuario, $sumaComisiones)){

                        $sumaComisiones[$idUsuario] += $comisionAgregada;

                    //si no hay, agregarlo al array    
                    }else{

                        $sumaComisiones[$idUsuario] = $comisionAgregada;                                

                    }

                }

            } //fin foreach para cada producto de la orden

            //Agregar la suma total de comisiones por usuario a su
            //respectivo balance
            foreach($sumaComisiones as $idUsuario => $comisionPs){                    

                $balance = new Balance();
                $balance->total = $comisionPs;
                $balance->orden_id = $orden->id;
                $balance->user_id = $idUsuario;
                $balance->tipo = 5; //balance para comisiones
                //$balance->save();

            } 

            
            
            
        } 
 
	public function getTiposPago($continuo = null){
		$text="";
		$i=0;
		if(count($this->detalles)){
            foreach ($this->detalles as $detallePago){
            	if($i>0){
            		if(is_null($continuo))
	            		$text.="<br/>";
					else 
	            		$text.=" / ";
            	}
            
	            if($detallePago->tipo_pago==1)
				 	$text.= "Dep. o Transfer"; // metodo de pago
	            else if($detallePago->tipo_pago==2)
	                    $text.="Tarjeta de Crédito";  
	            else if($detallePago->tipo_pago==3)
	                    $text.="Uso de Balance"; 	            
	            else if($detallePago->tipo_pago==4)
	                    $text.="TPV Banco Sabadell"; 
	            else if($detallePago->tipo_pago==5)
	                    $text.="PayPal"; 
	            else if($detallePago->tipo_pago== Detalle::CUPON_DESCUENTO)
	                    $text.="Cupón de Descuento"; 
                    else if ($detallePago->tipo_pago == Detalle::PRUEBAS)
                            $text.= "Pago para pruebas";
	            else
	                    $text.="ERROR EN EL PAGO";
				$i++;
            
        }
        }else{
            $text.="Dep. o Transfer"; 
        }
		return $text;
	}

	public function getPagoMonto($continuo = null){
		$text="";
		$i=0;
		if(count($this->detalles)){
            foreach ($this->detalles as $detallePago){
            	if($i>0){
            		if(is_null($continuo)) 
	            		$text.="<br/>";
					else 
	            		$text.=" / ";
            	}
            
	            if($detallePago->tipo_pago==1)
				 	$text.= "<b>Dep. o Transfer:</b> ".Yii::app()->numberFormatter->format("#,##0.00",$detallePago->monto); // metodo de pago
	            else if($detallePago->tipo_pago==2)
	                    $text.="<b>Tarjeta de Crédito:</b> ".Yii::app()->numberFormatter->format("#,##0.00",$detallePago->monto);
	            else if($detallePago->tipo_pago==3)
	                    $text.="<b>Uso de Balance:</b> ".Yii::app()->numberFormatter->format("#,##0.00",$detallePago->monto);	            
	            else if($detallePago->tipo_pago==4)
	                    $text.="<b>TPV Banco Sabadell:</b> ".Yii::app()->numberFormatter->format("#,##0.00",$detallePago->monto);
	            else if($detallePago->tipo_pago==5)
	                    $text.="<b>PayPal:</b> ".Yii::app()->numberFormatter->format("#,##0.00",$detallePago->monto);
	            else if($detallePago->tipo_pago== Detalle::CUPON_DESCUENTO)
	                    $text.="<b>Cupón de Descuento:</b> ".Yii::app()->numberFormatter->format("#,##0.00",$detallePago->monto);
                    else if ($detallePago->tipo_pago == Detalle::PRUEBAS)
                            $text.= "<b>Pago para pruebas:</b> ".Yii::app()->numberFormatter->format("#,##0.00",$detallePago->monto);
	            else
	                    $text.="ERROR EN EL PAGO";
				$i++;
            
        }
        }else{
            $text.="Dep. o Transfer"; 
        }
		return $text;
	}
	
	public function montoTipo($tipo){
		
           foreach ($this->detalles as $detallePago) {

                if ($detallePago->tipo_pago == $tipo)
                    return Yii::app()->numberFormatter->format("#,##0.00", $detallePago->monto); // metodo de pago
            }

            return Yii::app()->numberFormatter->format("#,##0.00",0);
	}
	

	
	public function getShipCarrier($id=null){
		if(is_null($id))
			$orden=$this;
		else {
			$orden=Orden::model()->findByPk($id);
		}
		if(Yii::app()->language=="es_es")
			return "SEUR";
		if(Yii::app()->language=="es_ve"){			
				return "ZOOM";			
		}
	}
	
	public function getStats($accion = "sum", $criterio = "total", $campo = "total" ){
		switch ($criterio) {
                
                case "pendientes":
                    $sql="select ".$accion."(".$campo.") from tbl_orden where estado IN (1,2,6,7)";
                    break;
				case "completas":
                    $sql="select ".$accion."(".$campo.") from tbl_orden where estado IN (11,8,4,3)";
                    break;
                default:
					$sql="select ".$accion."(".$campo.") from tbl_orden";
                    break;
            }
           return Yii::app()->db->createCommand($sql)->queryScalar();
	}
	

	public function setActualizadas(){
		if($this->totalActualizado==0||is_null($this->totalActualizado)){
			$this->totalActualizado=$this->total;
			if($this->save()){
				foreach($this->ohptc as $ohptc){
					if($ohptc->cantidadActualizada==0||is_null($ohptc->cantidadActualizada))
					{	$ohptc->cantidadActualizada=$ohptc->cantidad;
						$ohptc->save();
					}
				}
			}
		}
		
	} 
	
	public function getFechaEstado($estado){

			$sql="select fecha from tbl_estado where orden_id=".$this->id." and estado =".$estado;
			return Yii::app()->db->createCommand($sql)->queryScalar();
	}
	
	public function getLookProducts($look_id)
	{
		
		$sql = "
                select count(*) from tbl_orden_has_productotallacolor 
                where look_id = ".$look_id." and tbl_orden_id = ".$this->id;
                
		return Yii::app()->db->createCommand($sql)->queryScalar();
		
	}
        
        
        /*Retorna El estado*/
	public function getEstadoLF()
	{            
            $estado = "-";
            if($this->outbound){
                
                $estado = $this->outbound->getEstado(); 

                //Agregar el contador de productos
                if($this->tieneDiscrepancias()){
                    $estado .= "<br>(".$this->cantidadEnviadosLF()."/".
                            $this->cantidadProductos().")";
                }else if($this->fueCorregido()){
                    $estado .= "<br>(Corregido)";
                }                
            }
            
            return $estado;        		
	}
        /*boolean, si el outbound tiene discrepancias*/
	public function tieneDiscrepancias()
	{   
            return $this->outbound && $this->outbound->discrepancias == 1;
	}
        /*boolean, si el outbound tiene discrepancias*/
	public function fueCorregido()
	{   
            foreach($this->ohptc as $producto){
                if($producto->estadoLF == 3) //si tenia discrepancias marcarlo corregido
                {
                    return true;
                }                    
            }
            return false;
	}
        
        /*Retorna el numero de prendas totales*/
	public function cantidadProductos()
	{   
            $total = 0;
            foreach($this->ohptc as $producto){
                $total += $producto->cantidad;
            }
            
            return $total;
	}
        
        /*Retorna el numero de prendas totales*/
	public function cantidadEnviadosLF()
	{   
            $total = 0;
            foreach($this->ohptc as $producto){
                $total += $producto->cantidadLF;
            }
            
            return $total;
	}
        
        //Si tiene un cupon usado
	public function hasCupon($idCupon)
	{
            return $this->cupon && $this->cupon->cupon_id == $idCupon;
	}
	
	public function getProductsValue(){
		//tengo los ptc de la orden
		$orderhas = OrdenHasProductotallacolor::model()->findAllByAttributes(array('tbl_orden_id'=>$this->id));
		$value = 0;
		
		foreach($orderhas as $ptc){
			$product = $ptc->preciotallacolor->producto;
			$value += $product->getPrecioImpuesto(false)*$ptc->cantidad;
		}
		
		return $value;
	}
    
    public function updateEstado($estado, $userId, $ordenId, $observacion = null){
        $model= new Estado;
        $model->estado = $estado;
        $model->user_id = $userId;
        $model->fecha = date('Y-m-d');
        $model->orden_id=$ordenId;
        $model->observacion=$observacion;
        if($model->save()){
            $this->estado=$estado;
            return($this->save());
        }
        return false;
    }
	

}
