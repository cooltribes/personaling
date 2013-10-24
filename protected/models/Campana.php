<?php

/**
 * This is the model class for table "{{campana}}".
 *
 * The followings are the available columns in table '{{campana}}':
 * @property integer $id
 * @property string $nombre
 * @property string $recepcion_inicio
 * @property string $recepcion_fin
 * @property string $ventas_inicio
 * @property string $ventas_fin
 * @property string $fecha_creacion
 * @property integer $estado
 * 
 * 
 * Estados
 * 1: Programada
 * 2: Recepción
 * 3: Revisión
 * 4: Ventas
 * 5: Finalizada
 * 
 */
class Campana extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Campana the static model class
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
		return '{{campana}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, recepcion_inicio, recepcion_fin, ventas_inicio, ventas_fin, fecha_creacion', 'required'),
			array('estado', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>50),
			array( 'recepcion_inicio','compare','compareValue' => date("Y-m-d H:i:s", time()-(60*60*24)),'operator'=>'>', 'allowEmpty'=>'false', 'message' => '{attribute} debe ser mayor que la fecha actual.'),
			array( 'recepcion_fin','compare','compareAttribute' => 'recepcion_inicio','operator'=>'>', 'allowEmpty'=>'false', 'message' => '{attribute} debe ser mayor que {compareAttribute}.'),
			array( 'ventas_inicio','compare','compareAttribute' => 'recepcion_fin','operator'=>'>', 'allowEmpty'=>'false', 'message' => '{attribute} debe ser mayor que {compareAttribute}.'),
			array( 'ventas_fin','compare','compareAttribute' => 'ventas_inicio','operator'=>'>', 'allowEmpty'=>'false', 'message' => '{attribute} debe ser mayor que {compareAttribute}.'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre, recepcion_inicio, recepcion_fin, ventas_inicio, ventas_fin, fecha_creacion, estado', 'safe', 'on'=>'search'),
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
                    'personalshoppers' => array(self::HAS_MANY, 'CampanaHasPersonalShopper', 'campana_id'),
                    'looks' => array(self::HAS_MANY, 'Look', 'campana_id'),
                    'lookscreados' => array(self::STAT, 'Look', 'campana_id',
                    'select'=> 'COUNT(*)',
                ),
                    //'personalshoppers' => array(self::MANY_MANY, 'User', '{{CampanaHasPersonalShopper}}(campana_id, user_id)')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'recepcion_inicio' => 'Recepcion Inicio',
			'recepcion_fin' => 'Recepcion Fin',
			'ventas_inicio' => 'Ventas Inicio',
			'ventas_fin' => 'Ventas Fin',
			'fecha_creacion' => 'Fecha Creacion',
			'estado' => 'Estado',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('recepcion_inicio',$this->recepcion_inicio,true);
		$criteria->compare('recepcion_fin',$this->recepcion_fin,true);
		$criteria->compare('ventas_inicio',$this->ventas_inicio,true);
		$criteria->compare('ventas_fin',$this->ventas_fin,true);
		$criteria->compare('fecha_creacion',$this->fecha_creacion,true);
		//$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getProgress(){
			$f0 = strtotime($this->recepcion_inicio);
		   $f1 = strtotime($this->ventas_fin);
		   $now=strtotime(date("Y-m-d H:i:s"));
		   if($now<=$f0)
				return 0;
		   if($now>=$f1)
				return 100;
		   if ($f0 < $f1) { $tmp = $f1; $f1 = $f0; $f0 = $tmp; }
		   $total = ($f0 - $f1)/ 60 / 60 / 24;
		   $prog=($now-$f1)/ 60 / 60 / 24;
		   $prog=$prog*100/$total; 
		 
		   return round($prog);
			
	}
	public function daysLeft(){
			$f0 = strtotime($this->recepcion_inicio);
		   $f1 = strtotime($this->ventas_fin);
		   $now=strtotime(date("Y-m-d H:i:s"));
		   if($now<=$f0)
				return "Inicia en ".date_format(date_create($this->recepcion_inicio),"d/m/Y");
		   if($now>=$f1)
				return "Finalizó en ".date_format(date_create($this->ventas_fin),"d/m/Y");
		   if ($f0 < $f1) { $tmp = $f1; $f1 = $f0; $f0 = $tmp; }
		   $total = ($f0 - $f1)/ 60 / 60 / 24;
		   $prog=($now - $f1)/ 60 / 60 / 24;
		   return "Finaliza en ".round($total-$prog)." Días (".date_format(date_create($this->ventas_fin),"d/m/Y").")";
			
	}
        
        /**
         * Buscar por todos los filtros dados en el array $filters
         */
        public function buscarPorFiltros($filters) {
//            echo "<pre>";
//            print_r($filters);
//            echo "</pre>";
//            Yii::app()->end();

            $criteria = new CDbCriteria;
            
            $criteria->with = array();
            //$criteria->select = array();
            //$criteria->select[] = "t.*";
            
            $having = '';
            
            for ($i = 0; $i < count($filters['fields']); $i++) {
                
                $column = $filters['fields'][$i];
                $value = $filters['vals'][$i];
                $comparator = $filters['ops'][$i];
                
                if($i == 0){
                   $logicOp = 'AND'; 
                }else{                
                    $logicOp = $filters['rels'][$i-1];                
                }    
                                
               
                if($column == 'personalS')
                {                                    
                    
                    $comparator = ($comparator == '=') ? "": " NOT";
                    
                    $criteria->with['personalshoppers'] = array(
                        'select'=> false,
                        //'joinType'=>'INNER JOIN',
                       // 'condition'=> '',
                    );                    
                                       
                    
                    $criteria->addCondition('personalshoppers.campana_id '.$comparator.' IN(
                            SELECT DISTINCT(campana_id)
                            FROM tbl_campana_has_personal_shopper
                            WHERE user_id = '.$value.')', $logicOp);    
                    
                    if(!strpos($criteria->group, "t.id")){
                        $criteria->group = 't.id';
                    }
                    
                   continue;
                }
                if($column == 'looks_creados')
                {                        
                                 
                    $criteria->addCondition('
                    (select count(*) from tbl_look look
                        where look.campana_id = t.id
                        and
                        look.status IN (0, 1)
                        and
                        look.deleted = 0)
                    '
                    .$comparator.' '.$value.'', $logicOp);                 
                    
                   continue;
                }
                
                if($column == 'looks_aprobados')
                {                        
                                 
                    $criteria->addCondition('
                    (select count(*) from tbl_look look
                        where look.campana_id = t.id
                        and
                        look.status = 2
                        and
                        look.deleted = 0)
                    '
                    .$comparator.' '.$value.'', $logicOp);                 
                    
                   continue;
                }
                
                if($column == 'cantPS')
                {                        
                                 
                    $criteria->addCondition('
                    (select count(*) from tbl_campana_has_personal_shopper cps
                     where cps.campana_id = t.id)
                    '
                    .$comparator.' '.$value.'', $logicOp);                 
                    
                   continue;
                }
                
                if($column == 'cantMarcas')
                {                        
                                 
                    $criteria->addCondition('
                    (SELECT COUNT(DISTINCT(m.nombre))
                    FROM tbl_look l, tbl_look_has_producto lp, tbl_producto p, tbl_marca m
                    WHERE l.campana_id = t.id
                    AND l.id=lp.look_id 
                    AND lp.producto_id=p.id 
                    AND p.marca_id=m.id)
                    '
                    .$comparator.' '.$value.'', $logicOp);                 
                    
                   continue;
                }
                
                if($column == 'marca')
                {                                    
                    
                    $criteria->with['productos'] = array(
                        'select'=> false,
                        //'joinType'=>'INNER JOIN',
                        //'condition'=>'productos.nombres = 8',
                    );                 
                    
                    //having
                    if(!strpos($criteria->group, "t.id")){
                        $criteria->group = 't.id';
                    }
                    
                    //agregar condicion marca_id
                    $criteria->addCondition('productos.marca_id'
                    .$comparator.' '.$value.'', $logicOp);                    
                    
                   continue;
                }
                
                if($column == 'recepcion_inicio' || $column == 'recepcion_fin'
                    || $column == 'ventas_inicio' || $column == 'ventas_fin')
                {
                    $value = strtotime($value);
                    $value = date('Y-m-d H:i:s', $value);
                }
                
                $criteria->compare("t.".$column, $comparator." ".$value,
                        false, $logicOp);
                
            }
                                   
//            $criteria->select = 't.*';
            $criteria->having .= $having;
            //$criteria->with = array('categorias', 'preciotallacolor', 'precios');
            $criteria->together = true;
            //$criteria->compare('t.status', '1'); //siempre los no eliminados
            
//            echo "Criteria:";
//            
//            echo "<pre>";
//            print_r($criteria->toArray());
//            echo "</pre>"; 
            //exit();


            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
       }

}