<?php
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
 * 
 * --------------
 * Tipo de Guia
 * --------------
 * 0 - Envio Estandar
 * 1 - Entre 0.5 kg y 5 kg
 * 2 - Mayor a 5 kg
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
 */
class Orden extends CActiveRecord
{
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
			array('bolsa_id, user_id, pago_id, detalle_id, direccionEnvio_id, tipo_guia, peso', 'required'),
			array('estado, bolsa_id, user_id, pago_id, detalle_id, direccionEnvio_id, tipo_guia', 'numerical', 'integerOnly'=>true),
			array('subtotal, descuento, envio, iva, descuentoRegalo, total, seguro', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subtotal, descuento, fecha, envio, iva, descuentoRegalo, total, estado, bolsa_id, user_id, pago_id, detalle_id, direccionEnvio_id, tracking, seguro, tipo_guia, peso', 'safe', 'on'=>'search'),
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
			'pago' => array(self::BELONGS_TO, 'Pago', 'pago_id'),
			'detalle' => array(self::BELONGS_TO, 'Pago', 'detalle_id'),
			'productos' => array(self::MANY_MANY, 'Preciotallacolor', 'tbl_orden_has_productotallacolor(tbl_orden_id, preciotallacolor_id)'),
			'looks' => array(self::MANY_MANY, 'Look', 'tbl_orden_has_productotallacolor(tbl_orden_id, look_id)','condition'=>'looks_looks.look_id > 0'),
			'estados' => array(self::HAS_MANY, 'Estado', 'orden_id', 'index'=>'id'),
			
                       
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
			'pago_id' => 'Pago',
			'detalle_id' => 'Detalle',
			'direccionEnvio_id' => 'Direccion Envio',
			'tracking' => 'Número de guía',
			'seguro' => 'Seguro',
			'tipo_guia' => 'Tipo de guía',
			'peso' => 'Peso'
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
		$criteria->compare('pago_id',$this->pago_id);
		$criteria->compare('detalle_id',$this->detalle_id);
		$criteria->compare('direccionEnvio_id',$this->direccionEnvio_id);
		$criteria->compare('tracking',$this->tracking);
		$criteria->compare('seguro',$this->seguro);
		$criteria->compare('peso',$this->peso);
		
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
		$criteria->compare('pago_id',$this->pago_id);
		$criteria->compare('detalle_id',$this->detalle_id);
		$criteria->compare('direccionEnvio_id',$this->direccionEnvio_id);
		$criteria->compare('tracking',$this->tracking);
		$criteria->compare('seguro',$this->seguro);
		
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
		$criteria->addCondition("t.estado < 5 OR t.estado =7 OR (t.estado = 8 AND estados.fecha >'".date('Y-m-d', strtotime('-1 month'))."' )");
		//$criteria->addCondition("estados.fecha >'".date('Y-m-d', strtotime('-1 month'))."'");
		$criteria->together = true;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
	public function getTotalByUser($id){
		
		$sql = "select sum(total) from tbl_orden where user_id = ".$id;
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
		$criteria->compare('pago_id',$this->pago_id);
		$criteria->compare('detalle_id',$this->detalle_id);
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
//            echo "<pre>";
//            print_r($filters);
//            echo "</pre>";
            //Yii::app()->end();

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
                        $joinLooks .= ' JOIN tbl_orden_has_productotallacolor as oprod ON oprod.tbl_orden_id = t.id AND oprod.look_id = 0';
                        $criteria->group = 't.id';
                        $havingLooks .= 'count(oprod.tbl_orden_id) '.$comparator.' '.$value.'';
                   }else{
                        $havingLooks .= ' '.$logicOp.' count(oprod.tbl_orden_id) '.$comparator.' '.$value.'';
                   }   
                   
                    continue;
                }
                
                if($column == 'pago_id'){                
                   
                    if (!strpos($joinPagos, 'tbl_pago')) {
                        $joinPagos .= ' JOIN tbl_pago on tbl_pago.id = pago_id AND ( tbl_pago.tipo '.$comparator.' '.$value.' )';
                    }else{
                        $joinPagos = str_replace(")", $logicOp.' tbl_pago.tipo '.$comparator.' '.$value.' )', $joinPagos) ; 
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
	
}
