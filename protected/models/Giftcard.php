<?php

/*
 * ESTADOS DE LA GIFTCARD
 * 1. Inactiva
 * 2. Activa
 * 3. Aplicada
 */


/**
 * This is the model class for table "{{giftcard}}".
 *
 * The followings are the available columns in table '{{giftcard}}':
 * @property integer $id
 * @property string $codigo
 * @property double $monto
 * @property integer $estado
 * @property string $inicio_vigencia
 * @property string $fin_vigencia
 * @property string $fecha_uso
 * @property integer $comprador
 * @property integer $beneficiario
 * @property integer $orden_id
 *
 * The followings are the available model relations:
 * @property User $UserComprador
 * @property User $UserBeneficiario
 * @property OrdenGC $Orden
 */
class Giftcard extends CActiveRecord
{
    
        /*CAMBIAR ESTA CONSTANTE CUANDO SE REQUIERA CAMBIAR LA LONGITUD DEL CODIGO DE UNA TARJETA*/
        const DIGITOS_CODIGO = 16;
        
        const MAX_MONTO_VE = 1000; //Para venezuela
        const MAX_MONTO_ES = 100; //Para españa
    
        //Montos para españa
        public static $montosES = array(1=>1, 5 => 5, 10 => 10, 15 => 15,
                                        20 => 20, 50 => 50, 100 => 100);
        //Montos para españa
        public static $montosVE = array(
                        100 => 100,
                        200 => 200,
                        300 => 300,
                        400 => 400,
                        500 => 500,
                        600 => 600,
                        700 => 700,
                        800 => 800,
                        900 => 900,
                        1000 => 1000,
                        );
        
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Giftcard the static model class
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
		return '{{giftcard}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('codigo, monto, estado, comprador', 'required'),
                        array('inicio_vigencia', 'required', 'message' => '¿Desde cuándo es válida la giftcard?'),
                        array('fin_vigencia', 'required', 'message' => '¿Hasta cuándo es válida la giftcard?'),
                        
                        array( 'inicio_vigencia','compare','compareValue' => date("Y-m-d"),'operator'=>'>=', 'allowEmpty'=>'false', 
                            'message' => 'La fecha de inicio de vigencia debe ser mayor o igual a la fecha de hoy.', 'on' => 'insert'),
			array( 'fin_vigencia','compare','compareAttribute' => 'inicio_vigencia', 'operator'=>'>=', 'allowEmpty'=>'false', 
                            'message' => 'La fecha de fin de vigencia debe ser mayor o igual a la fecha de inicio.', 'on' => 'insert'),
                    
                        array('codigo', 'unique', 'message'=>'Código de gift card ya registrado.'),
			array('estado, comprador, beneficiario', 'numerical', 'integerOnly'=>true),
			array('monto', 'numerical', 'max' => self::getMontoMaximo()),
			array('codigo', 'length', 'max'=>25),
			array('fecha_uso', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, codigo, monto, estado, inicio_vigencia, fin_vigencia, fecha_uso, comprador, beneficiario, orden_id', 'safe', 'on'=>'search'),
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
			'UserComprador' => array(self::BELONGS_TO, 'User', 'comprador'),
			'UserBeneficiario' => array(self::BELONGS_TO, 'User', 'beneficiario'),
			'Orden' => array(self::BELONGS_TO, 'OrdenGC', 'orden_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'codigo' => 'Codigo',
			'monto' => 'Monto',
			'estado' => 'Estado',
			'inicio_vigencia' => 'Válida desde',
			'fin_vigencia' => 'Válida hasta',
			'fecha_uso' => 'Fecha Uso',
			'comprador' => 'Comprador',
			'beneficiario' => 'Beneficiario',
			'orden_id' => 'Orden',
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
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('monto',$this->monto);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('inicio_vigencia',$this->inicio_vigencia,true);
		$criteria->compare('fin_vigencia',$this->fin_vigencia,true);
		$criteria->compare('fecha_uso',$this->fecha_uso,true);
		$criteria->compare('comprador',$this->comprador);
		$criteria->compare('beneficiario',$this->beneficiario);
		$criteria->compare('orden_id',$this->orden_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Busca las Giftcards del usuario
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function giftcardsUser()
	{
		
		$criteria=new CDbCriteria;

		
		$criteria->compare('comprador',  Yii::app()->user->id);
		//$criteria->compare('beneficiario',$this->beneficiario);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
         /**
         * This method is invoked before validation starts.
         * @return boolean whether validation should be executed. Defaults to true.
         */
        protected function beforeValidate() {

            if($this->inicio_vigencia){
                $this->inicio_vigencia = strtotime($this->inicio_vigencia);
                $this->inicio_vigencia = date('Y-m-d', $this->inicio_vigencia); 
            }
            
            
            if($this->fin_vigencia){
                $this->fin_vigencia = strtotime($this->fin_vigencia);
                $this->fin_vigencia = date('Y-m-d', $this->fin_vigencia); 
            }
            
            return parent::beforeValidate();
            
        }
        
        /*Retorna la fecha de inicio de vigencia como un timestamp*/
        public function getInicioVigencia() {
            return strtotime($this->inicio_vigencia);
        }
        /*Retorna la fecha de inicio de vigencia como un timestamp*/
        public function getFinVigencia() {
            return strtotime($this->fin_vigencia);
        }
        /*Retorna la fecha de inicio de vigencia como un timestamp*/
        public function getFechaUso() {
            return strtotime($this->fecha_uso);
        }
        
        /*Si la GC fue creada por un admin*/
        public function comesFromAdmin() {
            return $this->UserComprador->superuser;
        }
        
        /*Retorna el codigo con formato*/
        public function getCodigo() {
            
            return implode("-", str_split($this->codigo, 4));
        }
        
        /*Retorna los ultimos 4 digitos del codigo con formato*/
        public function getMascaraCodigo() {
            
            return 'XXXX-XXXX-XXXX-'.substr($this->codigo, 12,14);
        }
        
        static function generarCodigo(){
            $cantNum = 8;
            $cantLet = 8;
            
            $l = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            
            $LETRAS = str_split($l);
            $NUMEROS = range(0, 9);

            $codigo = array();
            //Seleccionar cantLet letras
            for ($i = 0; $i < $cantLet; $i++) {
                $codigo[] = $LETRAS[array_rand($LETRAS)];
            }
            for ($i = 0; $i < $cantNum; $i++) {
                $codigo[] = array_rand($NUMEROS);
            }
            
            shuffle($codigo);

            $codigo = implode("", $codigo);
            
            return $codigo;
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
            $criteria->select = array();
            $criteria->select[] = "t.*";
            
            for ($i = 0; $i < count($filters['fields']); $i++) {
                
                $column = $filters['fields'][$i];
                $value = $filters['vals'][$i];
                $comparator = $filters['ops'][$i];
                
                if($i == 0){
                   $logicOp = 'AND'; 
                }else{                
                    $logicOp = $filters['rels'][$i-1];                
                }                 
                
                
                
                if($column == 'comprador')
                {
                    
                    $value = ($comparator == '=') ? "=".$value."" : $value;
                    
                    $criteria->compare('UserComprador.email', $value,
                        true, $logicOp);
                    
                    //$criteria->with[] = 'UserComprador';
                    $criteria->with['UserComprador'] = array(
                        'alias' => 'UserComprador'  
                     );
//                    
//                    //$criteria->alias = 'User';
//                    $criteria->join = 'JOIN tbl_profiles p ON User.id = p.user_id AND
//                        (p.first_name LIKE "%' . $_GET['nombre'] . '%" OR p.last_name LIKE "%' . $_GET['nombre'] . '%" 
//                            OR User.email LIKE "%' . $_GET['nombre'] . '%")';                    
                    
                    
                    continue;
                }
                
                if($column == 'beneficiario')
                {
                    
                    $value = ($comparator == '=') ? "=".$value."" : $value;
                    
//                    $value = ($comparator == '=') ? "= '".$value."'" : "LIKE '%".$value."%'";
//
//                    $criteria->addCondition('UserBeneficiario.email '.$value.' OR profB.first_name '.$value, $logicOp);
                    
                    $criteria->compare('UserBeneficiario.email', $value,
                        true, $logicOp);
                    
                    $criteria->with['UserBeneficiario'] = array(
                        'alias' => 'UserBeneficiario'  
                        );
//                    $criteria->with['UserBeneficiario.profile'] = array(
//                        'alias' => 'profB'  
//                        );
                    
                    
                    continue;
                }
                
                if($column == 'inicio_vigencia' || $column == 'fin_vigencia')
                {
                    $value = strtotime($value);
                    $value = date('Y-m-d H:i:s', $value);
                }
                
                $criteria->compare("t.".$column, $comparator." ".$value,
                        false, $logicOp);
                
            }
                                   
             
            //$criteria->with = array('categorias', 'preciotallacolor', 'precios');
            $criteria->together = true;
            
            
//            echo "Criteria:";
//            
//            echo "<pre>";
//            print_r($criteria->toArray());
//            echo "</pre>"; 
//            exit();


            return new CActiveDataProvider($this, array(
                'criteria' => $criteria,
            ));
       }
       
       public static function getMontos() {
            
            //si es españa
            if (Yii::app()->language == "es_es") {
                return self::$montosES;            
            //si es venezuela
            }else if (Yii::app()->language == "es_ve") {
                return self::$montosVE;                        
            }

            return array();
        }
        
       public static function getMontoPredeterminado() {
           
           $montoES = 5;
           $montoVE = 100;           
           //si es españa
           if (Yii::app()->language == "es_es") {
               return $montoES;            
           //si es venezuela
           }else if (Yii::app()->language == "es_ve") {
               return $montoVE;                        
           }

           return array();
        }
        
       public static function getMontoMaximo() {
                   
           //si es españa
           if (Yii::app()->language == "es_es") {
               return self::MAX_MONTO_ES;            
           //si es venezuela
           }else if (Yii::app()->language == "es_ve") {
               return self::MAX_MONTO_VE;            
           }

           return 0;
        }

}